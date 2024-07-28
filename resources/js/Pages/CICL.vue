<template>
  <AppLayout title="CICL">
    <template #header></template>
    <div class="">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 -mt-40">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <!-- Search input and CICL LIST -->
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
                <svg class="h-5 w-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unique ID</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Crime Status</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admitted | Discharged</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr
                  v-for="(client, index) in filteredClients"
                  :key="client.id"
                  @click="handleRowClick(client)"
                  class="cursor-pointer hover:bg-gray-100"
                >
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 flex items-center">
                    <!-- Profile Picture -->
                    <div :style="getProfilePictureStyle(getInitials(client.name))" class="mr-3 rounded-full">
                      {{ getInitials(client.name) }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ client.name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ client.id }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ client.crimeStatus }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex space-x-4">
                      <!-- Left Box -->
                      <button class="mr-12 ml-5"
                        @click.stop="handleLeftClick($event, client)"
                        :class="getBoxStyles(index).leftBoxClass + ' p-3 rounded'"
                      >
                      </button>

                      <!-- Right Box -->
                      <button 
                        @click.stop="handleRightClick($event, client)"
                        :class="getBoxStyles(index).rightBoxClass + ' p-3 rounded'"
                      >
                      </button>
                    </div>
                  </td>
                </tr>
                <tr v-if="filteredClients.length === 0">
                  <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No clients found</td>
                </tr>
              </tbody>
            </table>
          </div>
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

const clients = ref([]);
const searchQuery = ref('');
const router = useRouter();

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
    client.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

// Function to handle row click
const handleRowClick = (client) => {
  // Navigate to the ClientDetails page with the client ID as a route parameter
  router.push({ name: 'ClientDetails', params: { id: client.id } });
};

// Function to handle left box click
const handleLeftClick = (event, client) => {
  event.stopPropagation(); // Prevents the row click event from being triggered
  console.log(`Left box clicked for client: ${client.name}`);
};

// Function to handle right box click
const handleRightClick = (event, client) => {
  event.stopPropagation(); // Prevents the row click event from being triggered
  console.log(`Right box clicked for client: ${client.name}`);
};

// Function to determine box styles based on index
const getBoxStyles = (index) => {
  if (index % 3 === 2) {
    // Every 3rd item (2, 5, 8, ...)
    return {
      leftBoxClass: 'border border-black bg-transparent',
      rightBoxClass: 'bg-blue-500 border-none'
    };
  } else {
    // All other items
    return {
      leftBoxClass: 'bg-blue-500 border-none',
      rightBoxClass: 'border border-black bg-transparent'
    };
  }
};

// Function to get initials from name
const getInitials = (name) => {
  const names = name.split(' ');
  return names.map(name => name.charAt(0)).join('').toUpperCase();
};

// Function to generate profile picture style
const getProfilePictureStyle = (initials) => {
  return {
    backgroundColor: '#4A90E2', // Customizable color
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
</script>

<style scoped>
/* Your styles here */
</style>
