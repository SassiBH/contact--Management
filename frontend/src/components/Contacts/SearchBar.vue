<template>
    <div class="mb-6">
      <input
        type="text"
        v-model="query"
        @input="onSearch"
        placeholder="Search contacts..."
        class="w-full px-4 py-2 border border-gray-300 rounded"

      />
    </div>
  </template>
  
  <script>
export default {
  data() {
    return {
      query: '',
    };
  },
  methods: {
    onSearch() {
      this.$emit('search', this.query);
    },
  },
};
  </script>
  