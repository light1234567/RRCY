<template>
  <AppLayout title="CICL">
    <template #header></template>
    <div class="">
      <div class="max-w-6x1 mx-auto sm:px-6 lg:px-8 -mt-32">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <!-- Search input and Details button -->
          <div class="p-2 flex justify-between items-center">
            <span class="ml-4 text-red-600 text-lg font-bold">CICL LIST</span>
            <div class="relative w-80">
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search"
                class="mb-2 p border border-gray-300 rounded w-full"
              />
              <span class="absolute inset-y-0 right-0 flex items-center pr-3 pb-2">
                <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 10.5 18a7.5 7.5 0 0 0 6.15-3.35z"></path>
                </svg>
              </span>
            </div>
          </div>
          <!-- Clients List -->
          <div class="p-4">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profile</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>

                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admitted | Discharged</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr
                  v-for="(client, index) in filteredClients"
                  :key="client.id"
                  class="cursor-pointer hover:bg-gray-100"
                  @click="activateClient(client.id)"
                >
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 flex items-center">
                    <div :style="getProfilePictureStyle(getInitials(client.first_name, client.last_name))" class="mr-3 rounded-full">
                      {{ getInitials(client.first_name, client.last_name) }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ client.first_name }} {{ client.last_name }}</td>

                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex space-x-4">
                      <button class="mr-12 ml-5" :class="getBoxStyles(index).leftBoxClass + ' p-3 rounded'"></button>
                      <button :class="getBoxStyles(index).rightBoxClass + ' p-3 rounded'"></button>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button @click.stop="showDeleteModal(client.id)" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                  </td>
                </tr>
                <tr v-if="filteredClients.length === 0">
                  <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No clients found</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center z-50">
      <div class="absolute inset-0 bg-black opacity-50"></div>
      <div class="bg-white p-6 rounded-lg shadow-lg z-10">
        <h2 class="text-xl font-semibold mb-4">Delete Client</h2>
        <p>Are you sure you want to delete this client?</p>
        <div class="flex justify-end mt-4">
          <button @click="hideDeleteModal" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
          <button @click="confirmDelete" class="bg-red-600 text-white px-4 py-2 rounded">Delete</button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();

const clients = ref([]);
const searchQuery = ref('');
const showModal = ref(false);
const clientIdToDelete = ref(null);

// Fetch clients from the API
const fetchClients = async () => {
  try {
    const response = await axios.get('/api/clients');
    clients.value = response.data;
  } catch (error) {
    console.error('Error fetching clients:', error);
  }
};

onMounted(fetchClients);

// Computed property to filter clients based on search query
const filteredClients = computed(() => {
  if (!searchQuery.value) {
    return clients.value;
  }
  return clients.value.filter(client =>
    `${client.first_name} ${client.last_name}`.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

// Function to show delete confirmation modal
const showDeleteModal = (id) => {
  clientIdToDelete.value = id;
  showModal.value = true;
};

// Function to hide delete confirmation modal
const hideDeleteModal = () => {
  showModal.value = false;
  clientIdToDelete.value = null;
};

// Function to confirm delete
const confirmDelete = async () => {
  try {
    await axios.delete(`/api/clients/${clientIdToDelete.value}`);
    clients.value = clients.value.filter(client => client.id !== clientIdToDelete.value);
    alert('Client deleted successfully.');
    hideDeleteModal();
  } catch (error) {
    const errorMessage = error.response?.data?.message || 'An error occurred while deleting the client. Please try again.';
    console.error('Error deleting client:', error);
    alert(errorMessage);
    hideDeleteModal();
  }
};

// Function to get initials from name
const getInitials = (firstName, lastName) => {
  return (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();
};

// Function to generate profile picture style
const getProfilePictureStyle = (initials) => {
  return {
    backgroundColor: '#4A90E2',
    color: 'white',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
    borderRadius: '50%',
    width: '40px',
    height: '40px',
    fontSize: '18px',
    fontWeight: 'bold',
  };
};

// Function to get box styles
const getBoxStyles = (index) => {
  const leftBoxClass = index % 2 === 0 ? 'bg-blue-500' : 'bg-red-500';
  const rightBoxClass = index % 2 === 0 ? 'bg-red-500' : 'bg-blue-500';
  return { leftBoxClass, rightBoxClass };
};

// Function to navigate to edit page
const activateClient = async (id) => {
  try {
    await axios.patch(`/api/clients/${id}`, { Status: 'active' });
    const client = clients.value.find(client => client.id === id);
    if (client) {
      client.Status = 'active';
    }
    alert('Client status updated to active.');
    
    // Redirecting to the specified route with a refresh query parameter
    window.location.href = router.resolve({ name: 'edit', params: { id } }).href + `?refresh=${Date.now()}`;
  } catch (error) {
    console.error('Error updating client status:', error);
    const errorMessage = error.response?.data?.message || 'An error occurred while updating the client status. Please try again.';
    alert(errorMessage);
  }
};
</script>


<style>
.p {
  height: 35px;
  width: 80px;
  font-size: 18px;
  font-weight: bold;
}

.bg-box-left {
  background-color: rgb(239, 68, 68);
}

.bg-box-right {
  background-color: rgb(59, 130, 246);
}
</style>
