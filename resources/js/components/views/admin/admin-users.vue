<!-- UserManagement.vue -->
<template>
    <Navbar />
   <div class="user-management-container">
     
     <div class="header-container">
       <button class="back-btn" @click="goBack"> <i class="fas fa-arrow-left"></i> Back</button>
       
       <button class="add-user-btn"> <i class="fas fa-user-plus"></i> Add User</button>
     </div>
     <table class="user-table">
       <thead>
         <tr>
           <th>ID</th>
           <th>Name</th>
           <th>Email</th>
           <th>Role</th>
           <th>Actions</th>
         </tr>
       </thead>
       <tbody>
         <!-- Example data -->
         <tr>
           <td>1</td>
           <td>John Doe</td>
           <td>john.doe@example.com</td>
           <td>Admin</td>
           <td>
             <button class="edit-btn">Edit</button>
             <button class="delete-btn">Delete</button>
           </td>
         </tr>
         <tr>
           <td>2</td>
           <td>Jane Smith</td>
           <td>jane.smith@example.com</td>
           <td>User</td>
           <td>
             <button class="edit-btn">Edit</button>
             <button class="delete-btn">Delete</button>
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
   text-align: left;
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
 