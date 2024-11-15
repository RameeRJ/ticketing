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
          this.$router.push('/admin/home');
        } else {
          this.$router.push('/user/home');
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
/* Add keyframe animation for fade-in effect */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Stylish Container with animation */
.login-container {
  max-width: 400px;
  margin: 100px auto;
  padding: 30px;
  border-radius: 12px;
  background: #ffffff;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  text-align: center;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  animation: fadeIn 0.8s ease-out; /* Apply fade-in animation */
  height: 476px;
}

/* Heading Style */
h2 {
  margin-bottom: 25px;
  font-size: 28px;
  color: #333;
  font-weight: 600;
}
h3 {
  margin-bottom: 45px;
  font-size: 18px;
  color: #666;
  font-weight: 400;
  margin-top:-14px;
}

/* Form Groups */
.form-group {
  margin-bottom: 20px;
  text-align: left;
}

/* Label Style */
label {
  display: block;
  margin-bottom: 8px;
  font-size: 14px;
  color: #555;
}

/* Input Field Style */
input {
  width: 100%;
  padding: 12px;
  font-size: 14px;
  border: 1px solid #ddd;
  border-radius: 6px;
  outline: none;
  transition: border-color 0.3s, box-shadow 0.3s; /* Smooth transition */
}

input:focus {
  border-color: #007bff;
  box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
}

/* Error Message Style */
.text-danger {
  color: #e74c3c;
  font-size: 12px;
  margin-top: 5px;
  display: block;
}

/* Button Style */
button {
  width: 100%;
  padding: 12px;
  font-size: 16px;
  color: #fff;
  background-color: #007bff;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s, transform 0.2s; /* Smooth transition */
}

button:hover {
  background-color: #0056b3;
  transform: translateY(-3px); /* Lift the button on hover */
}

button:active {
  transform: translateY(0); /* Return to original position on click */
}

/* Form Background Enhancements */
body {
  background: linear-gradient(135deg, #72edf2 10%, #5151e5 100%);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.is-invalid {
  border-color: red !important;
}
/* Password Wrapper */
.password-wrapper {
  position: relative;
  display: flex;
  align-items: center; /* Align items in the center vertically */
}

.password-wrapper input {
  width: 100%;
  padding-right: 40px; /* Space for the eye icon */
}

.password-wrapper svg {
  position: absolute;
  right: 10px;
  cursor: pointer;
  color: #aaa;
  transition: color 0.3s; /* Add smooth transition for color */
}

.password-wrapper svg:hover {
  color: #333;
}
.password-wrapper svg.eye-visible {
  color: #007bff;  /* Change this color to your desired color when visible */
}

</style>
