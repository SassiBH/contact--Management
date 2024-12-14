<template>
    <div
      v-if="visible"
      class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50"
    >
      <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold mb-4">Add New Contact</h2>
        <form @submit.prevent="submitForm">
          <!-- First Name -->
          <div class="mb-4">
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
            <input
              v-model="localContact.first_name"
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
              v-model="localContact.last_name"
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
              v-model="localContact.email"
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
              v-model="localContact.phone"
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
              v-model="localContact.age"
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
              v-model="localContact.country"
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
              Save Contact
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      visible: {
        type: Boolean,
        required: true,
      },
      newContact: {
        type: Object,
        required: true,
      },
    },
    data() {
      return {
        localContact: { ...this.newContact },
        errors: {},
      };
    },
    methods: {
      validateForm() {
        this.errors = {};
  
        // Validate First Name
        if (!this.localContact.first_name) {
          this.errors.first_name = "First name is required.";
        }
  
        // Validate Last Name
        if (!this.localContact.last_name) {
          this.errors.last_name = "Last name is required.";
        }
  
        // Validate Email
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!this.localContact.email || !emailPattern.test(this.localContact.email)) {
          this.errors.email = "Please enter a valid email address.";
        }
  
        // Validate Phone
        const phonePattern = /^\d{10,15}$/;
        if (!this.localContact.phone || !phonePattern.test(this.localContact.phone)) {
          this.errors.phone = "Phone number must be 10-15 digits.";
        }
  
        // Validate Age
        if (!this.localContact.age || this.localContact.age <= 0 || this.localContact.age > 120) {
          this.errors.age = "Age must be between 1 and 120.";
        }
  
        // Validate Country
        if (!this.localContact.country) {
          this.errors.country = "Country is required.";
        }
  
        return Object.keys(this.errors).length === 0;
      },
  
      submitForm() {
        if (this.validateForm()) {
          this.$emit("create-contact", this.localContact);
          this.close();
        }
      },
  
      close() {
        this.localContact = {
          first_name: "",
          last_name: "",
          email: "",
          phone: "",
          age: "",
          country: "",
        };
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
  