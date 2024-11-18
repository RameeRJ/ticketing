<template>
  <div class="login-container">
    <h2>Login</h2>
    <h3>Enter your login details</h3>
    <form @submit.prevent="handleLogin">
      <div class="form-group">
        <label for="email">Email</label>
        <input
          type="text"
          id="email"
          v-model="email"
          placeholder="Enter your email"
           :class="{ 'is-invalid': errors.email }"
        />
        <span class="text-danger" v-if="errors.email">{{ errors.email[0] }}</span>
      </div>

      <div class="form-group">
  <label for="password">Password</label>
  <div class="password-wrapper">
    <input
      :type="pwd_type"
      id="password"
      v-model="password"
      placeholder="Enter your password"
       :class="{ 'is-invalid': errors.password }"
    />
    <svg @click="set_pwd_type" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                      viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" id="toggle-password" class="feather feather-eye"
                      :class="{'eye-visible': pwd_type === 'text'}">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                      <circle cx="12" cy="12" r="3"></circle>
                    </svg>
  </div>
  <span class="text-danger" v-if="errors.password">{{ errors.password[0] }}</span>
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
      pwd_type: 'password',
      email: '',
      password: '',
      remember: false,
      errors: {},
    };
  },
  methods: {
    set_pwd_type() {
      if (this.pwd_type == 'password') { this.pwd_type = 'text'; } else { this.pwd_type = 'password'; }
    },
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

        if (user.user_type === 'admin') {
  this.$router.push('/admin/home'); // Redirect to admin's home
} else if (user.user_type === 'user') {
  this.$router.push('/user/home');  // Redirect to user's home
} else {
      this.$router.push('/login');
    }
      } catch (error) {
        if (error.response && error.response.data.errors) {
          this.errors = error.response.data.errors;
        } else {
          alert('Login failed. Please try again.');
        }
      }
    },
  },
};
</script>

<style scoped>
@import "/resources/css/auth.css";
</style>
