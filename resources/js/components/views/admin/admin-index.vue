<template>
    <div class="admin-container">
      <!-- Navbar -->
     
  
      <!-- Main Content -->
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
  
  // Use Vue Router for navigation
  const router = useRouter();
  
  function goToPage(page) {
    if (page === 'user') {
      router.push('/admin/user'); // Navigate to the user management page
    } else if (page === 'ticket') {
      router.push('/admin/ticket'); // Navigate to the ticket management page
    }
  }
  </script>
  
  <style scoped>
  /* Container for the entire page */
  .admin-container {
    display: flex;
    flex-direction: column;
    height: 100vh;
    background: url('/public/images/wallpaper.png') no-repeat center center;
    background-size: cover;
    color: #fff; /* Text color for better visibility on the background */
    position: relative;
    margin:-8px;
  }
  
  /* Overlay to add a semi-transparent effect */
  .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent dark overlay */
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  /* Options container */
  .options-container {
    text-align: center;
    background-color: rgba(255, 255, 255, 0.8); /* Light background with transparency */
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    color: #333; /* Dark text color for contrast */
  }
  
  h1 {
    margin-bottom: 10px;
    font-size: 28px;
  }
  
  .instructions {
    margin-bottom: 20px;
    font-size: 16px;
    color: #555;
  }
  
  .options {
    display: flex;
    gap: 20px;
    justify-content: center;
  }
  
  .option-btn {
    padding: 12px 24px;
    font-size: 16px;
    color: #fff;
    background-color: #2196f3;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  
  .option-btn:hover {
    background-color: #1976d2;
  }
  </style>
  