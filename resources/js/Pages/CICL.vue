<template>
  <AppLayout title="CICL">
    <template #header>
      <h1 class="text-lg font-bold text-red-800">CICL</h1>
    </template>
    <div class="">
      <div class="ml-6 max-w-6x1 mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="p-2 flex justify-between items-center">
          <div class="relative w-80">
            <span class="absolute -mt-2 inset-y-0 left-0 flex items-center pl-3">
              <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 10.5 18a7.5 7.5 0 0 0 6.15-3.35z"></path>
              </svg>
            </span>
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search"
              class="mb-2 p-2 pl-10 border border-gray-300 rounded w-full text-sm"
            />
          </div>
          <button @click="navigateToNewClientPage" class="bg-blue-900 text-white px-4 py-2 rounded text-sm flex items-center">
            <svg class="h-5 w-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add
          </button>
        </div>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <!-- Search input and Add button -->
         
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
                  v-for="(client, index) in paginatedClients"
                  :key="client.id"
                  class="cursor-pointer hover:bg-gray-100"
                  @click="navigateToEditPage(client.id)"
                >
                  <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-gray-900 flex items-center">
                    <div :style="getProfilePictureStyle(getInitials(client.first_name, client.last_name))" class="mr-3 rounded-full">
                      {{ getInitials(client.first_name, client.last_name) }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-gray-900">{{ client.first_name }} {{ client.last_name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-xs font-medium">
                    <div class="flex space-x-4">
                      <button class="mr-12 ml-5" :class="getBoxStyles(index).leftBoxClass + ' p-2 rounded'"></button>
                      <button :class="getBoxStyles(index).rightBoxClass + ' p-2 rounded'"></button>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-xs font-medium">
                    <button @click.stop="showDeleteModal(client.id)" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                  </td>
                </tr>
                <tr v-if="paginatedClients.length === 0">
                  <td colspan="4" class="px-6 py-4 text-center text-xs text-gray-500">No clients found</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- Pagination -->
          <div class="flex justify-end p-4">
            <button
              :disabled="currentPage === 1"
              @click="previousPage"
              class="mr-2 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-xs"
            >
              Previous
            </button>
            <span class="px-4 py-2 text-xs">{{ currentPage }} / {{ totalPages }}</span>
            <button
              :disabled="currentPage === totalPages"
              @click="nextPage"
              class="ml-2 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-xs"
            >
              Next
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center z-50">
      <div class="absolute inset-0 bg-black opacity-50"></div>
      <div class="bg-white p-6 rounded-lg shadow-lg z-10">
        <h2 class="text-lg font-semibold mb-4">Delete Client</h2>
        <p class="text-sm">Are you sure you want to delete this client?</p>
        <div class="flex justify-end mt-4">
          <button @click="hideDeleteModal" class="bg-gray-500 text-white px-4 py-2 rounded mr-2 text-sm">Cancel</button>
          <button @click="confirmDelete" class="bg-red-600 text-white px-4 py-2 rounded text-sm">Delete</button>
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
const currentPage = ref(1);
const itemsPerPage = 9;

const navigateToNewClientPage = () => {
  const resolvedRoute = router.resolve({ name: 'NewClient' });
  window.location.href = resolvedRoute.href;
};

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

// Computed property to filter and paginate clients
const filteredClients = computed(() => {
  if (!searchQuery.value) {
    return clients.value;
  }
  return clients.value.filter(client =>
    `${client.first_name} ${client.last_name}`.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

const paginatedClients = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return filteredClients.value.slice(start, end);
});

const totalPages = computed(() => {
  return Math.ceil(filteredClients.value.length / itemsPerPage);
});

// Pagination controls
const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

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
const navigateToEditPage = (id) => {
  const resolvedRoute = router.resolve({ name: 'maintab', params: { id: id } });
  window.location.href = resolvedRoute.href;
};


</script>
