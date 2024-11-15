<template>
    <div>
      <!-- Alternate Navigation -->
      <nav class="navbar">
        <div class="navbar-container">
          <!-- Brand Logo and Name -->
          <div class="brand-logo-container">
            <img src="/public/images/logo.png" alt="DocBooker Logo" class="brand-logo" />
           
          </div>
          <div class="profile-logout-container">
            <button @click="logout" class="logout-btn">Logout</button>
          </div>
        </div>
      </nav>
      <div class="dashboard-content">
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import Swal from 'sweetalert2';
  
  export default {
    name: 'Navbar',
    data() {
      return {
        user: null,
        
      };
    }, 
    methods: {
      async logout() {
        try {
          const result = await Swal.fire({
            title: 'Are you sure?',
            text: 'You will be logged out!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, log me out!',
            cancelButtonText: 'Cancel',
            padding: '1em',
          });
  
          if (result.isConfirmed) {
            await axios.post('/logout');
            localStorage.clear(); 
            this.$router.push({ name: 'login' });
            Swal.fire({
              icon: 'success',
              title: 'Logged out successfully',
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 2000,
              padding: '1em',
            });
          }
        } catch (error) {
          Swal.fire({
            icon: 'error',
            title: 'Logout Failed',
            text: 'There was an error logging you out. Please try again.',
            padding: '1em',
          });
        }
      },
      
    },
    
  };
  </script>
  
  <style scoped>
  @import "/resources/css/navbar.css";
  
  
  </style>