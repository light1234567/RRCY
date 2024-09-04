<template>
  <AppLayout title="CICL">
    <template #header>
      <h1 class="text-lg ml-12 font-bold text-red-800">CICL</h1>
    </template>
    <div class="ml-6 max-w-6x1 mx-auto sm:px-6 lg:px-8 mt-2">
      <div class="p-2 rounded-lg flex justify-between items-center">
        <div class="relative -mr-2 w-80 ml-auto"> 
          <span class="absolute -mt-2 inset-y-0 left-0 flex items-center pl-3">
            <svg
              class="h-5 w-5 text-gray-500"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 10.5 18a7.5 7.5 0 0 0 6.15-3.35z"
              ></path>
            </svg>
          </span>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search"
            class="mb-2 p-2 pl-10 border border-gray-300 rounded-md w-full text-sm" 
          />
        </div>
      </div>
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <!-- Clients List -->
        <div class="p-4">
          <table class="min-w-full divide-y divide-gray-400">
            <thead>
              <tr class="">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Age</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Case Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Child Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Admitted</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr
                v-for="(client, index) in filteredClients"
                :key="index"
                class="cursor-pointer hover:bg-gray-100"
                @click="navigateToEditPage(client.id)"
              >
                <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-gray-900">{{ client.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">{{ client.age }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">{{ client.case_status }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">{{ client.child_status }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">{{ client.date_admitted }}</td>
              </tr>
              <tr v-if="filteredClients.length === 0">
                <td colspan="5" class="px-6 py-4 text-center text-xs text-gray-500">No clients found</td>
              </tr>
            </tbody>
          </table>
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

// Fetch clients from the API
const fetchClients = async () => {
  try {
    const response = await axios.get('/api/clients-data');
    clients.value = response.data.map(client => {
      const { first_name, last_name, date_of_birth } = client;
      const admission = client.admissions[0]; // Assuming you want the first admission
      const age = new Date().getFullYear() - new Date(date_of_birth).getFullYear();

      return {
        id: client.id,
        name: `${first_name} ${last_name}`,
        age: age,
        case_status: admission?.case_status || 'N/A',
        child_status: client.child_status,
        date_admitted: admission?.date_admitted || 'N/A',
      };
    });
  } catch (error) {
    console.error('Error fetching clients:', error);
  }
};

onMounted(fetchClients);

// Computed property to filter clients
const filteredClients = computed(() => {
  if (!searchQuery.value) {
    return clients.value;
  }
  return clients.value.filter(client =>
    client.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

// Function to navigate to edit page
const navigateToEditPage = (id) => {
  const resolvedRoute = router.resolve({ name: 'maintab', params: { id: id } });
  window.location.href = resolvedRoute.href;
};
</script>

<style scoped>
/* Add any component-specific styles here */
</style>


