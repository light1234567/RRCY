<template>
    <div>
      <!-- Search Input -->
      <input v-model="searchQuery" placeholder="Search clients..." class="mb-2 p-2 border border-gray-300 rounded" />
  
      <!-- Clients Table -->
      <table class="min-w-full divide-y divide-gray-200">
        <thead>
          <tr>
            <th>Name</th>
            <th>ID</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="client in filteredClients" :key="client.id">
            <td @click="openModal(client)" class="cursor-pointer text-blue-500">{{ client.name }}</td>
            <td>{{ client.id }}</td>
            <td>{{ client.crimeStatus }}</td>
          </tr>
          <tr v-if="filteredClients.length === 0">
            <td colspan="3">No clients found</td>
          </tr>
        </tbody>
      </table>
  
      <!-- Modal for Client Details -->
      <Transition name="modal">
        <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
          <div class="bg-white p-4 rounded">
            <h2 class="text-lg font-bold">Client Details</h2>
            <p><strong>Name:</strong> {{ selectedClient.name }}</p>
            <p><strong>ID:</strong> {{ selectedClient.id }}</p>
            <p><strong>Status:</strong> {{ selectedClient.crimeStatus }}</p>
            <button @click="closeModal" class="mt-2 p-2 bg-blue-500 text-white rounded">Close</button>
          </div>
        </div>
      </Transition>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, onMounted } from 'vue';
  import axios from 'axios';
  
  const clients = ref([]);
  const searchQuery = ref('');
  const isModalOpen = ref(false);
  const selectedClient = ref(null);
  
  const fetchClients = async () => {
    try {
      const response = await axios.get('/api/clients');
      clients.value = response.data;
    } catch (error) {
      console.error('Error fetching clients:', error);
    }
  };
  
  onMounted(fetchClients);
  
  const filteredClients = computed(() => {
    if (!searchQuery.value) return clients.value;
    return clients.value.filter(client =>
      client.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  });
  
  const openModal = (client) => {
    selectedClient.value = client;
    isModalOpen.value = true;
  };
  
  const closeModal = () => {
    isModalOpen.value = false;
    selectedClient.value = null;
  };
  </script>
  
  <style scoped>
  /* Modal Transition */
  .modal-enter-active, .modal-leave-active {
    transition: opacity 0.5s;
  }
  .modal-enter, .modal-leave-to /* .modal-leave-active in <2.1.8 */ {
    opacity: 0;
  }
  </style>
  