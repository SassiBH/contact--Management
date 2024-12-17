<template>
  <div>
    <!-- Circular Loading Spinner -->
    <div
      v-if="isLoading"
      class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50"
    >
      <div class="spinner"></div>
    </div>

    <!-- Registration Form -->
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

        <!-- Register Form -->
        <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">
          Register
        </h2>
        <form @submit.prevent="register">
          <!-- Error Message -->
          <div
            v-if="errorMessage"
            class="mb-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded"
          >
            {{ errorMessage }}
          </div>

          <!-- Username Field -->
          <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700"
              >Username</label
            >
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
            <label for="password" class="block text-sm font-medium text-gray-700"
              >Password</label
            >
            <input
              v-model="password"
              type="password"
              id="password"
              placeholder="Enter your password"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            />
          </div>

          <!-- Register Button -->
          <button
            type="submit"
            class="w-full bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 transition duration-200"
          >
            Register
          </button>

          <!-- Login Redirect Button -->
          <button
            type="button"
            class="w-full bg-blue-500 text-white py-2 px-4 rounded-md mt-4 hover:bg-blue-600 transition duration-200"
            @click="$router.push('/login')"
          >
            Back to Login
          </button>
        </form>

        <!-- Snackbar -->
        <div
          v-if="showSnackbar"
          class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-md shadow-md"
        >
          Registration successful! Redirecting to login...
        </div>
      </div>
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
      errorMessage: "",
      showSnackbar: false, // Snackbar visibility
      isLoading: false, // Loading state
    };
  },
  async created() {
    const token = localStorage.getItem("token");
    if (token) {
      this.$router.push("/contacts");
    }
  },
  methods: {
    async register() {
      this.errorMessage = "";
      this.isLoading = true; // Show loading spinner
      try {
        await axios.post(`${process.env.VUE_APP_API_URL}/register`, {
          username: this.username,
          password: this.password,
        });

        // Show snackbar
        this.showSnackbar = true;

        // Hide snackbar after 2 seconds and redirect to login
        setTimeout(() => {
          this.showSnackbar = false;
          this.$router.push("/login");
        }, 2000);
      } catch (error) {
        this.errorMessage =
          error.response?.status === 401
            ? "Username already used."
            : "Username and password are required.";
      } finally {
        this.isLoading = false; // Hide loading spinner
      }
    },
  },
};
</script>

<style scoped>
/* Circular spinner */
.spinner {
  width: 32px;
  height: 32px;
  border: 4px solid rgba(255, 255, 255, 0.3);
  border-top-color: #3498db;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

/* Spinner animation */
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
</style>
