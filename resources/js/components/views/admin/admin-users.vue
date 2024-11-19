<template>
  <Navbar />
  <div class="user-management-container">
    <div class="header-container">
      <button class="back-btn" @click="goBack"><i class="fas fa-arrow-left"></i> Back</button>
      <button class="add-user-btn" @click="showAddUserModal = true"><i class="fas fa-user-plus"></i> Add User</button>
    </div>

    <table class="user-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="users.length === 0">
                <td colspan="6" class="text-center">No users available</td>
              </tr>
              <tr v-for="user in users" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                
                <td>
                      
                  <button class="edit-btn" @click="openEditUserModal(user)">Edit</button>
                  <button class="delete-btn" @click="destroyUsers(user.id)">Delete</button>
                </td>
              </tr>
      </tbody>
    </table>

    <!-- Modal for Adding User -->
    <div v-if="showAddUserModal" class="modal-backdrop">
      <div class="modal-content">
        <h3 class="center">Add New User</h3>
        <form @submit.prevent="storeUser">
          <div class="form-group">
            <label for="name">Name</label>
            
            <input type="text" id="name" v-model="form.name" required placeholder="Enter user's name"/>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" v-model="form.email" required placeholder="Enter user's email"/>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" v-model="form.password" required placeholder="Enter user's password"/>
          </div>
          <div class="form-group">
            <label for="confirmpassword">Confirm Password</label>
            <input type="password" id="confirmpassword" v-model="form.password_confirmation" required placeholder="Confirm user's password"/>
          </div>
          <div class="button-group">
            <button type="submit" class="btn btn-add">Submit</button>
            <button type="reset" class="btn btn-add-secondary" @click="resetForm">Reset</button>
            <button type="button" class="btn btn-add-close" @click="showAddUserModal = false">Close</button>
          </div>
        </form>
      </div>
    </div>

    <div v-if="showEditUserModal" class="modal-backdrop">
  <div class="modal-content">
    <h3 class="center">Edit User</h3>
    <form @submit.prevent="updateUser">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" v-model="editForm.name" required placeholder="Enter User name"/>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" v-model="editForm.email" required placeholder="Enter User email"/>
      </div>
      <div class="form-group">
        <label for="password">Password</label>

        <input type="password" id="password" v-model="editForm.password" placeholder="Leave blank to keep current password"/>
      </div>
      <div class="form-group">
        <label for="confirmpassword">Confirm Password</label>
        <input type="password" id="confirmpassword" v-model="editForm.password_confirmation" placeholder="Confirm new password (if updating)"/>
      </div>
      <div class="button-group">
        <button type="submit" class="btn btn-add">Save Changes</button>
        <button type="button" class="btn btn-add-close" @click="showEditUserModal = false">Close</button>
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
const showAddUserModal = ref(false);
const showEditUserModal = ref(false);
const users = ref([]);

// Form object for new user
const form = ref({
  name: "",
  email: "",
  phone: "",
  password: "",
  password_confirmation: "",
});
const editForm = ref({
  id: null,
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});
const openEditUserModal = (user) => {
  editForm.value = { ...user, password: "", password_confirmation: "" };
  showEditUserModal.value = true;
};

const fetchUsers = async () => {
      try {
        const response = await axios.post('/users');
        users.value = response.data;
      } catch (error) {
        console.error('Error fetching users:', error);
        error.value = 'Failed to load users. Please try again.';
      }
    };

// Method to handle form submission
async function storeUser() {
  try {
    const response = await axios.post("/users/store", form.value); // Replace with your API endpoint
    Swal.fire({
          icon: 'success',
          title: 'User registered successfully',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2000,
        });
        showAddUserModal.value = false;
        resetForm();
        fetchUsers();
  } catch (error) {
    console.error(error.response?.data || error.message); // Log the error
    Swal.fire({
          icon: 'error',
          title: 'Registration failed',
          text: error.response?.data?.message || 'An error occurred. Please try again.',
        });
  }
}
const updateUser = async () => {
  try {
    await axios.put(`/users/update/${editForm.value.id}`, editForm.value);
    Swal.fire({
      icon: "success",
      title: "User updated successfully",
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 2000,
    });
    showEditUserModal.value = false;
    fetchUsers();
  } catch (error) {
    console.error(error.response?.data || error.message);
    Swal.fire({
      icon: "error",
      title: "Update failed",
      text: error.response?.data?.message || "An error occurred. Please try again.",
    });
  }
};

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
        fetchUsers();
        
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

function resetForm() {
  form.value = {
    name: "",
    email: "",
    phone: "",
    password: "",
    password_confirmation: "",
  };
}


function goBack() {
  router.back();
}

onMounted(fetchUsers);

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
 }
 
 .user-table th, .user-table td {
   border: 1px solid #ddd;
   padding: 12px;
   text-align: center;
 }
 
 .user-table th {
   background-color: #f2f2f2;
 
 }
 
 .edit-btn, .delete-btn {
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
 
 .delete-btn {
   background-color: #f44336;
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
 </style>
 