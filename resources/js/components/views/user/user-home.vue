<template>
  <Navbar />
  <div class="user-management-container">
    <div class="header-container">
      <h2 class="section-description">Need help? <br> Submit a ticket and our support team will get back to you as soon as possible. <br> </h2>
    
      <button class="submit-ticket-btn" @click="showAddTicketModel = true"><i class="fas fa-ticket-alt"></i> Submit Ticket</button>
    </div>

    <table class="user-table">
      <thead>
        <tr>
          <th>Issue</th>
          <th>Priority</th>
          <th>Image</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="tickets.length === 0">
                <td colspan="6" class="text-center">No tickets available</td>
              </tr>
              <tr v-for="ticket in tickets" :key="ticket.id">
                <td>{{ ticket.issue }}</td>
                <td :class="getPriorityClass(ticket.priority)">{{ ticket.priority }}</td>
                <td>{{ ticket.image ? ticket.image : 'No image' }}</td>
                <td :class="getStatusClass(ticket.status)">{{ ticket.status }}</td>


                
                <td>
                      
                  <button class="edit-btn">Edit</button>
                  <button class="delete-btn" @click="destroyTickets(user.id)">Delete</button>
                  <button class="preview-btn" v-if="ticket.image"  @click="previewImage(ticket.image)">Preview</button>
                   
                </td>
              </tr>
      </tbody>
    </table>
    <div v-if="showImageModal" class="modal-backdrop">
  <div class="modal-content">
    <h3 class="center">Image Preview</h3>
    <img :src="imageToPreview" alt="Image Preview" class="preview-image" />
    <button class="btn btn-add-close" @click="closeImageModal">Close</button>
  </div>
</div>

    <!-- Modal for Adding User -->
    <div v-if="showAddTicketModel" class="modal-backdrop">
      <div class="modal-content">
        <h3 class="center">Submit your Ticket</h3>
        <form @submit.prevent="storeTicket">
          <div class="form-group">
            <label for="issue">issue</label>
            <input type="text" id="issue" v-model="form.issue" required />
          </div>
          <div class="form-group">
            <label for="priority">priority</label>
            <select id="priority" v-model="form.priority" required>
    <option value="" disabled selected>Select priority</option>
    <option value="low">Low</option>
    <option value="medium">Medium</option>
    <option value="high">High</option>
  </select>
          </div>
          <div class="form-group">
  <label for="image">Image (Optional)</label>
  <input type="file" id="image" @change="handleImageUpload" />
</div>
         
          <div class="button-group">
            <button type="submit" class="btn btn-add">Submit</button>
            <button type="reset" class="btn btn-add-secondary" @click="resetForm">Reset</button>
            <button type="button" class="btn btn-add-close" @click="showAddTicketModel = false">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import Navbar from "../../Layouts/Navbar.vue";
import { useRouter } from "vue-router";
import { ref,onMounted } from "vue";
import axios from "axios"; 
import Swal from "sweetalert2";

const router = useRouter();
const showAddTicketModel = ref(false);
const tickets = ref([]);
const showImageModal = ref(false); // to control modal visibility
const imageToPreview = ref(''); // to hold the image URL for preview

// Method to show image preview
const previewImage = (image) => {
  imageToPreview.value = `/storage/tickets/${image}`;
  showImageModal.value = true; // Show the modal
};

// Method to close the image preview modal
const closeImageModal = () => {
  showImageModal.value = false; // Hide the modal
  imageToPreview.value = ''; // Reset the image URL
};

// Form object for new user
const form = ref({
  issue: "",
  priority: "",
  status: "",
  image: null, // Initially null
});
const handleImageUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    form.value.image = file;
  } else {
    form.value.image = null; // Clear image if no file is selected
  }
};

const fetchTicket = async () => {
      try {
        const response = await axios.post('/tickets');
        tickets.value = response.data.tickets;
      } catch (error) {
        console.error('Error fetching users:', error);
        error.value = 'Failed to load users. Please try again.';
      }
    };

// Method to handle form submission
async function storeTicket() {
  const formData = new FormData();
  formData.append('issue', form.value.issue);
  formData.append('priority', form.value.priority);
  

  // Only append image if selected
  if (form.value.image) {
    formData.append('image', form.value.image);
  }

  try {
    const response = await axios.post("/tickets/store", formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
    });

    Swal.fire({
      icon: 'success',
      title: 'Ticket submitted successfully',
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2000,
    });

    showAddTicketModel.value = false;
    resetForm();
    fetchTicket();
  } catch (error) {
    console.error(error.response?.data || error.message); // Log the error
    Swal.fire({
      icon: 'error',
      title: 'Submission failed',
      text: error.response?.data?.message || 'An error occurred. Please try again.',
    });
  }
}
const destroyUsers = async (usersId) => {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel'
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        // Make the DELETE request
        await axios.delete(`/users/delete/${usersId}`);
        
        // Fetch the updated user list
        fetchTicket();
        
        // Show success notification
        Swal.fire({
          icon: 'success',
          title: 'User removed successfully',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2000,
        });
      } catch (error) {
        console.error('Error removing user:', error);
        Swal.fire('Error!', 'Failed to remove the user.', 'error');
      }
    }
  });
};
const getStatusClass = (status) => {
  switch(status) {
    case 'pending':
      return 'status-pending'; // Custom class for pending status
    case 'completed':
      return 'status-completed'; // Custom class for completed status
    case 'in-progress':
      return 'status-in-progress'; // Custom class for in-progress status
    default:
      return ''; // Default class if none match
  }
};
const getPriorityClass = (status) => {
  switch(status) {
    case 'low':
      return 'priority-low'; // Custom class for pending priority
    case 'medium':
      return 'priority-medium'; // Custom class for completed priority
    case 'high':
      return 'priority-high'; // Custom class for in-progress priority
    default:
      return ''; // Default class if none match
  }
};

function resetForm() {
  form.value = {
    issue: "",
    priority: "",
    image: "",
  
  };
}




onMounted(fetchTicket);

</script>
 
 <style scoped>
 @import "/resources/css/model.css";
 .user-management-container {
   padding: 20px;
   margin-top:30px;
 }
 
 .header-container {
   display: flex;
   justify-content: space-between;
   align-items: center;
   margin-bottom: 15px;
 }
 
 h1 {
   margin: 0;
 }
 
 .add-user-btn {
   background-color: #4caf50;
   color: white;
   border: none;
   border-radius: 4px;
   padding: 10px 20px;
   cursor: pointer;
 }
 
 .user-table {
   width: 100%;
   border-collapse: collapse;
   margin-top: 40px;
 }
 
 .user-table th, .user-table td {
   border: 1px solid #ddd;
   padding: 12px;
   text-align: center;
 }
 
 .user-table th {
   background-color: #f2f2f2;
 
 }
 
 .edit-btn, .delete-btn, .preview-btn {
   padding: 6px 12px;
   border: none;
   border-radius: 4px;
   cursor: pointer;
   color: white;
 }
 
 .edit-btn {
   background-color: #2196f3;
   margin-right: 5px;
 }
 .edit-btn:hover {
   background-color: #1970b7;
   margin-right: 5px;
 }
 
 .delete-btn {
   background-color: #f44336;
   margin-right: 5px;
 }
 .delete-btn:hover{
   background-color: #d23b31;
   margin-right: 5px;
 }
 .preview-btn{
  background-color: #45a049;
 }
 .back-btn {
   background-color: #5138c4;
   color: white;
   border: none;
   border-radius: 4px;
   padding: 8px 16px;
   cursor: pointer;
   font-weight: bold;
   margin-right: 15px;
   transition: background-color 0.3s ease;
 }
 
 .back-btn:hover {
   background-color: #4727da;
 }

 .section-heading {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
}

.section-description {
  font-size: 20px;
  margin-bottom: 11px;
}

.submit-ticket-btn {
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  padding: 10px 20px;
  cursor: pointer;
}

.preview-btn:hover {
  background-color: #358d39f1;
}


.preview-image {
  max-width: 100%;
  max-height: 400px;
  margin: 20px 0;
}
.status-pending {
  color: rgb(192, 192, 16); /* Yellow color for pending status */
}

.status-completed {
  color: rgb(2, 130, 2); /* Green color for completed status */
}

.status-in-progress {
  color: rgb(197, 128, 0); /* Orange color for in-progress status */
}
.priority-low {
  color: rgb(192, 192, 16); /* Yellow color for pending priority */
}

.priority-medium {
  color: rgb(2, 130, 2); /* Green color for completed priority */
}

.priority-high {
  color: rgb(197, 128, 0); /* Orange color for in-progress status */
}

 </style>
 