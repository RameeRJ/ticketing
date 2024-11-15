<!-- TicketManagement.vue -->
<template>
    <Navbar />
   <div class="ticket-management-container">
       <div class="header-container">
       <button class="back-btn" @click="goBack"> <i class="fas fa-arrow-left"></i> Back</button>
       </div>
     <table class="ticket-table">
       <thead>
         <tr>
           <th>ID</th>
           <th>User</th>
           <th>Subject</th>
           <th>Status</th>
           <th>Actions</th>
         </tr>
       </thead>
       <tbody>
         <!-- Example data -->
         <tr>
           <td>101</td>
           <td>Jane Smith</td>
           <td>Account Issue</td>
           <td class="status pending">Pending</td>
           <td>
             <button class="resolve-btn">Resolve</button>
           </td>
         </tr>
         <tr>
           <td>102</td>
           <td>Michael Brown</td>
           <td>Password Reset</td>
           <td class="status resolved">Resolved</td>
           <td>
             <button class="resolve-btn" disabled>Resolved</button>
           </td>
         </tr>
       </tbody>
     </table>
   </div>
 </template>
 
 <script setup>
 import Navbar from "../../Layouts/Navbar.vue";
 import { useRouter } from 'vue-router';

const router = useRouter();
function goBack() {
 router.back();
}
 </script>
 
 <style scoped>
 .ticket-management-container {
   padding: 20px;
   margin-top:30px;
 }
 
 h1 {
   margin-bottom: 20px;
 }
 
 .ticket-table {
   width: 100%;
   border-collapse: collapse;
 }
 
 .ticket-table th, .ticket-table td {
   border: 1px solid #ddd;
   padding: 12px;
   text-align: left;
 }
 
 .ticket-table th {
   background-color: #f2f2f2;
 }
 
 .status {
   padding: 4px 8px;
   border-radius: 4px;
   text-transform: uppercase;
   font-weight: bold;
 }
 
 .status.pending {
   background-color: #ff9800;
   color: white;
 }
 
 .status.resolved {
   background-color: #4caf50;
   color: white;
 }
 
 .resolve-btn {
   background-color: #4caf50;
   color: white;
   border: none;
   border-radius: 4px;
   padding: 6px 12px;
   cursor: pointer;
 }
 
 .resolve-btn:disabled {
   background-color: #9e9e9e;
   cursor: not-allowed;
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
.header-container {
 display: flex;
 justify-content: space-between;
 align-items: center;
 margin-bottom: 15px;
}
 </style>
 