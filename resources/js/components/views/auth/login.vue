<template>
    <div class="login-container">
      <h2>Login</h2>
      <form @submit.prevent="handleLogin">
        <div class="form-group">
          <label for="email">email</label>
          <input
            type="text"
            id="email"
            v-model="email"
            placeholder="Enter your email"
            required
          />
        </div>
  
        <div class="form-group">
          <label for="password">Password</label>
          <input
            type="password"
            id="password"
            v-model="password"
            placeholder="Enter your password"
            required
          />
        </div>
  
        <button type="submit">Login</button>
      </form>
    </div>
  </template>
  
  <script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: 'Login',
  data() {
    return {
      email: '',
      password: '',
      remember: false,
      errors: {},
    };
  },
  methods: {
  async handleLogin() { 
    this.errors = {}; 

    try {
      const response = await axios.post('/login', {
        email: this.email,
        password: this.password,
        remember: this.remember,
      });

      const user = response.data.user;

    
      localStorage.setItem('userType', user.user_type);
      localStorage.setItem('user', JSON.stringify(user));

     
      Swal.fire({
        icon: 'success',
        title: 'Login Successful!',
        showConfirmButton: false,
        timer: 1000,
        toast: true,
        position: 'top-end',
      });

      // Redirect based on user type
      if (user.user_type === 'admin') {
        this.$router.push('/admin/home');
      } else {
        this.$router.push('/user/home');
      }
    } catch (error) {
      if (error.response && error.response.data.errors) {
        // Handle validation errors
        this.errors = error.response.data.errors;
      } else {
        alert('Login failed. Please try again.');
      }
    }
  },
}

};
</script>
  <style scoped>
  .login-container {
    max-width: 400px;
    margin: 100px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
  }
  
  h2 {
    margin-bottom: 20px;
  }
  
  .form-group {
    margin-bottom: 15px;
    text-align: left;
  }
  
  label {
    display: block;
    margin-bottom: 5px;
  }
  
  input {
    width: 100%;
    padding: 8px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
  }
  
  button {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #0056b3;
  }
  </style>
  