<template>
    <div
      v-if="visible"
      class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50"
    >
      <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold mb-4">Edit Contact</h2>
        <form @submit.prevent="submitEditForm">
          <!-- First Name -->
          <div class="mb-4">
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
            <input
              v-model="localEditContact.first_name"
              type="text"
              id="first_name"
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"
              :class="{'border-red-500': errors.first_name}"
              required
            />
            <p v-if="errors.first_name" class="text-red-500 text-sm mt-1">{{ errors.first_name }}</p>
          </div>
          <!-- Last Name -->
          <div class="mb-4">
            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input
              v-model="localEditContact.last_name"
              type="text"
              id="last_name"
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"
              :class="{'border-red-500': errors.last_name}"
              required
            />
            <p v-if="errors.last_name" class="text-red-500 text-sm mt-1">{{ errors.last_name }}</p>
          </div>
          <!-- Email -->
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
              v-model="localEditContact.email"
              type="email"
              id="email"
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"
              :class="{'border-red-500': errors.email}"
              required
            />
            <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</p>
          </div>
          <!-- Phone -->
          <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
            <input
              v-model="localEditContact.phone"
              type="text"
              id="phone"
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"
              :class="{'border-red-500': errors.phone}"
              required
            />
            <p v-if="errors.phone" class="text-red-500 text-sm mt-1">{{ errors.phone }}</p>
          </div>
          <!-- Age -->
          <div class="mb-4">
            <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
            <input
              v-model="localEditContact.age"
              type="number"
              id="age"
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"
              :class="{'border-red-500': errors.age}"
              required
            />
            <p v-if="errors.age" class="text-red-500 text-sm mt-1">{{ errors.age }}</p>
          </div>
          <!-- Country -->
          <div class="mb-4">
            <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
            <input
              v-model="localEditContact.country"
              type="text"
              id="country"
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"
              :class="{'border-red-500': errors.country}"
              required
            />
            <p v-if="errors.country" class="text-red-500 text-sm mt-1">{{ errors.country }}</p>
          </div>
          <!-- Actions -->
          <div class="flex justify-between">
            <button
              type="button"
              class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
              @click="close"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            >
              Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      visible: Boolean,
      editContact: Object, // Contact data passed from the parent
    },
    data() {
      return {
        localEditContact: {}, // Local copy to edit contact details
        errors: {},
      };
    },
    watch: {
      // Watch for changes in `editContact` and update local copy
      editContact: {
        immediate: true,
        handler(newValue) {
          this.localEditContact = { ...newValue }; // Avoid mutating props directly
        },
      },
    },
    methods: {
      validateForm() {
        this.errors = {};
  
        // Validate First Name
        if (!this.localEditContact.first_name) {
          this.errors.first_name = "First name is required.";
        }
  
        // Validate Last Name
        if (!this.localEditContact.last_name) {
          this.errors.last_name = "Last name is required.";
        }
  
        // Validate Email
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!this.localEditContact.email || !emailPattern.test(this.localEditContact.email)) {
          this.errors.email = "Please enter a valid email address.";
        }
  
        // Validate Phone
        const phonePattern = /^\d{10,15}$/;
        if (!this.localEditContact.phone || !phonePattern.test(this.localEditContact.phone)) {
          this.errors.phone = "Phone number must be 10-15 digits.";
        }
  
        // Validate Age
        if (!this.localEditContact.age || this.localEditContact.age <= 0 || this.localEditContact.age > 120) {
          this.errors.age = "Age must be between 1 and 120.";
        }
  
        // Validate Country
        if (!this.localEditContact.country) {
          this.errors.country = "Country is required.";
        }
  
        return Object.keys(this.errors).length === 0;
      },
  
      submitEditForm() {
        if (this.validateForm()) {
          this.$emit("edit-contact", { ...this.localEditContact });
          this.close();
        }
      },
  
      close() {
        this.localEditContact = { ...this.editContact };
        this.errors = {};
        this.$emit("close");
      },
    },
  };
  </script>
  
  <style scoped>
  .border-red-500 {
    border-color: #f56565;
  }
  </style>
  