<template>
    <div class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold mb-4">{{ title }}</h2>
        <p class="mb-6">{{ message }}</p>
        <div class="flex justify-end space-x-4">
          <button
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
            @click="$emit('cancel')"
          >
            Cancel
          </button>
          <button
            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
            @click="$emit('confirm')"
          >
            Confirm
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      title: {
        type: String,
        default: "Are you sure?",
      },
      message: {
        type: String,
        default: "Do you really want to delete this item? This action cannot be undone.",
      },
    },
  };
  </script>
  
  <style scoped>
  .fixed {
    position: fixed;
  }
  </style>
  