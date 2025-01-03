<template>
  <div class="container mx-auto p-6">
    <header class="header flex justify-between items-center">
      <div class="logo-container">
        <img
          src="https://industryx0.pro/wp-content/uploads/2021/01/cropped-Logo-AI-V1.png"
          alt="Website Logo"
          class="logo"
        />
      </div>
      <div class="m-2 flex flex-row border border-red-600 rounded divide-x divide-red-600 bg-red-100 text-base text-red-700 leading-5">
      <button
        class="px-6 py-2 cursor-pointer text-red-800 focus:scale-110 focus:outline-none hover:bg-red-200 hover:text-red-800 transition duration-200 ease-in-out flex justify-center items-center"
        @click="logout"
      >
        <span>Logout</span>
      </button>
      </div>
    </header>

    <h1 class="text-4xl font-bold text-gray-900 mb-6">Contacts</h1>

    <!-- Search Bar -->
    <div class="mb-6">
      <SearchBar @search="searchContacts" />
    </div>

    <!-- Add Contact Button -->
    <button
      class="bg-blue-600 text-white px-6 py-2 rounded-lg mb-4 hover:bg-blue-700 hover:text-white transition-all duration-200"
      @click="openCreateModal"
    >
      Add Contact
    </button>

    <!-- Delete Confirmation Modal -->
    <ConfirmModal
      v-if="showDeleteModal"
      :title="'Confirm Deletion'"
      :message="'Are you sure you want to delete this contact?'"
      @confirm="confirmDelete"
      @cancel="cancelDelete"
    />

    <!-- Create Contact Modal -->
    <CreateModal
      :visible="showCreateModal"
      :contact="newContact"
      @close="closeCreateModal"
      @create-contact="createContact"
    />

    <!-- Edit Contact Modal -->
    <EditModal
      :visible="showEditModal"
      :editContact="editContact"
      @close="closeEditModal"
      @edit-contact="updateContact"
    />

    <!-- Snackbar -->
    <div
      v-if="showSnackbar"
      :class="`fixed top-4 left-1/2 transform -translate-x-1/2 px-4 py-2 text-white rounded-md shadow-md ${snackbarClass}`"
    >
      {{ snackbarMessage }}
    </div>

    <!-- Contact List -->
    <div v-if="contacts.length === 0" class="text-gray-500 text-lg text-center my-10">No contacts found.</div>
    <ul>
      <li
        v-for="contact in contacts"
        :key="contact.id"
        class="bg-white shadow-lg rounded-lg p-6 mb-6 flex justify-between items-start hover:shadow-xl transition-all duration-200"
      >
        <div>
          <h2 class="text-2xl font-semibold text-gray-800">{{ contact.first_name }} {{ contact.last_name }}</h2>
          <p class="text-gray-600"><strong>Email: </strong>{{ contact.email }}</p>
          <p class="text-gray-600"><strong>Phone: </strong>{{ contact.phone }}</p>
          <p class="text-gray-600"><strong>Age: </strong>{{ contact.age }}</p>
          <p class="text-gray-600"><strong>Country: </strong>{{ contact.country }}</p>
        </div>
        <div class="flex flex-col justify-start items-end">
          <button
            class="bg-green-500 text-white px-4 py-2 rounded-lg mb-2 hover:bg-green-600 hover:text-white transition-all duration-200"
            @click="openEditModal(contact)"
          >
            Edit
          </button>
          <button
            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-200"
            @click="promptDelete(contact.id)"
          >
            Delete
          </button>
        </div>
      </li>
    </ul>

    <footer class="bg-gray-800 text-white text-center p-4 fixed bottom-0 left-0 w-full">
      <p>&copy; 2024 industryx0</p>
    </footer>
  </div>
</template>

<script>
import SearchBar from './SearchBar.vue';
import ConfirmModal from './ConfirmModal.vue';
import CreateModal from './CreateModal.vue';
import EditModal from './EditModal.vue';
import axios from 'axios';

export default {
  components: { SearchBar, ConfirmModal, CreateModal, EditModal },
  data() {
    return {
      contacts: [],
      showCreateModal: false,
      showEditModal: false,
      showDeleteModal: false,
      showSnackbar: false,
      snackbarMessage: '',
      snackbarClass: '',
      contactToDelete: null,
      newContact: {
        user_id: '',
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
        age: '',
        country: '',
      },
      editContact: {},
    };
  },
  async created() {
    const token = localStorage.getItem('token');
    if (!token) {
      this.$router.push('/login');
    }
    await this.fetchContacts();
  },
  methods: {
    async fetchContacts() {
      const token = localStorage.getItem('token');
      try {
        const response = await axios.get(`${process.env.VUE_APP_API_URL}/contacts`, {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.contacts = response.data;
      } catch (error) {
        console.error(error);
      }
    },
  async searchContacts(query) {
    const token = localStorage.getItem('token');
    try {
    if (query.trim() === '') {
      // If the search query is empty, fetch all contacts
      await this.fetchContacts();
    } else {
      // Perform the search API request
      const response = await axios.get(`${process.env.VUE_APP_API_URL}/contacts/search`, {
        params: { query },
        headers: { Authorization: `Bearer ${token}` },
      });
      this.contacts = response.data;
    }
  } catch (error) {
    console.error(error);
  }
},
    openCreateModal() {
      this.showCreateModal = true;
    },
    closeCreateModal() {
      this.showCreateModal = false;
    },
    async createContact(newContact) {
      const token = localStorage.getItem('token');
      try {
        await axios.post(`${process.env.VUE_APP_API_URL}/contacts`, newContact, {
          headers: { Authorization: `Bearer ${token}` },
        });
        await this.fetchContacts();
        this.showSnackbarMessage('Contact created successfully!', 'bg-green-500');
        this.closeCreateModal();
      } catch (error) {
        console.error(error);
      }
    },
    openEditModal(contact) {
      this.editContact = { ...contact };
      this.showEditModal = true;
    },
    closeEditModal() {
      this.showEditModal = false;
    },
    async updateContact(updatedContact) {
      const token = localStorage.getItem('token');
      try {
        await axios.put(`${process.env.VUE_APP_API_URL}/contacts/${updatedContact.id}`, updatedContact, {
          headers: { Authorization: `Bearer ${token}` },
        });
        await this.fetchContacts();
        this.showSnackbarMessage('Contact updated successfully!', 'bg-blue-500');
        this.closeEditModal();
      } catch (error) {
        console.error(error);
      }
    },
    promptDelete(contactId) {
      this.contactToDelete = contactId;
      this.showDeleteModal = true;
    },
    async confirmDelete() {
      const token = localStorage.getItem('token');
      try {
        await axios.delete(`${process.env.VUE_APP_API_URL}/contacts/${this.contactToDelete}`, {
          headers: { Authorization: `Bearer ${token}` },
        });
        await this.fetchContacts();
        this.showSnackbarMessage('Contact deleted successfully!', 'bg-red-500');
      } catch (error) {
        console.error(error);
      } finally {
        this.showDeleteModal = false;
      }
    },
    cancelDelete() {
      this.showDeleteModal = false;
    },
    showSnackbarMessage(message, cssClass) {
      this.snackbarMessage = message;
      this.snackbarClass = cssClass;
      this.showSnackbar = true;
      setTimeout(() => {
        this.showSnackbar = false;
      }, 2000);
    },
    logout() {
      localStorage.removeItem('token');
      this.$router.push('/login');
    },
  },
};
</script>

<style scoped>
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  background-color: #f8f9fa;
}

.logo-container {
  display: flex;
  align-items: center;
}

.logo {
  width: 150px; /* Adjust size as needed */
  height: auto;
  margin-right: 10px; /* Space between logo and site name */
}
.snackbar {
  transition: opacity 0.5s;
}
</style>
