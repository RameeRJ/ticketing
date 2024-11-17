<template>
  <div>
     
      <nav class="navbar">
        <div class="navbar-container">
         
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
  <div class="admin-container">

     

      <div class="overlay">
        <div class="options-container">
          <h1>Hello Admin!</h1>
          <p class="instructions">
            Please select an option below to manage users or handle tickets efficiently.
          </p>
          <div class="options">
            <button @click="goToPage('user')" class="option-btn">User Management</button>
            <button @click="goToPage('ticket')" class="option-btn">Ticket Management</button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
import { useRouter } from 'vue-router';
import Swal from 'sweetalert2';
import axios from 'axios';


const router = useRouter();


function goToPage(page) {
  if (page === 'user') {
    router.push('/admin/user'); 
  } else if (page === 'ticket') {
    router.push('/admin/ticket'); 
  }
}


async function logout() {
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
      router.push({ name: 'login' });
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
}
</script>
  
  <style scoped>

@import "/resources/css/navbar.css";
@import "/resources/css/index.css";
 
  
  
  </style>
  