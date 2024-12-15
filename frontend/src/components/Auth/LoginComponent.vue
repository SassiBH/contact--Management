<template>
  <div class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
      <!-- Logo Section -->
      <div class="flex justify-center mb-6">
        <img
          src="https://industryx0.pro/wp-content/uploads/2021/01/cropped-Logo-AI-V1.png"
          alt="Website Logo"
          class="h-16 w-auto object-contain"
        />
      </div>

      <!-- Login Form -->
      <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Login</h2>
      <form @submit.prevent="login">
        <!-- Error Message -->
        <div v-if="errorMessage" class="mb-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded">
          {{ errorMessage }}
        </div>

        <!-- Username Field -->
        <div class="mb-4">
          <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
          <input
            v-model="username"
            type="text"
            id="username"
            placeholder="Enter your username"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <!-- Password Field -->
        <div class="mb-6">
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input
            v-model="password"
            type="password"
            id="password"
            placeholder="Enter your password"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <!-- Login Button -->
        <button
          type="submit"
          class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition duration-200"
        >
          Login
        </button>

        <!-- Register Button -->
        <button
          type="button"
          class="w-full bg-green-500 text-white py-2 px-4 rounded-md mt-4 hover:bg-green-600 transition duration-200"
          @click="$router.push('/register')"
        >
          Register
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      username: "",
      password: "",
      errorMessage: "", // New property to store error message
    };
  },
  methods: {
    async login() {
      this.errorMessage = ""; // Clear any previous error message
      try {
        const response = await axios.post(`${process.env.VUE_APP_API_URL}/login`, {
          username: this.username,
          password: this.password,
        });
        localStorage.setItem("token", response.data.token);
        this.$router.push("/contacts");
      } catch (error) {
        this.errorMessage = "Invalid username or password. Please try again."; // Set the error message
      }
    },
  },
};
</script>

<style scoped>

</style>
