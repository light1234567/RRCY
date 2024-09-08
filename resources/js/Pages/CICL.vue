<template>
  <AppLayout title="CICL">
    <template #header>
      <div class="flex items-center">
        <div class="w-2 h-6 bg-gray-400 mr-3"></div>
        <h1 class="text-lg ml-12 font-bold text-red-800">CICL</h1>
      </div>
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

        <!-- Case Status Filter -->
        <div class="relative -mr-2 w-80 ml-auto">
          <select v-model="selectedCaseStatus" class="mb-2 p-2 border border-gray-300 rounded-md w-full text-sm">
            <option value="">Select Case Status</option>
            <option value="On trial">On trial</option>
            <option value="Suspended sentence">Suspended sentence</option>
            <option value="Acquitted">Acquitted</option>
            <option value="Dismissed">Dismissed</option>
            <option value="Provisionally Dismissed">Provisionally Dismissed</option>
            <option value="Rehabilitation">Rehabilitation</option>
            <option value="Diversion">Diversion</option>
            <option value="Disposition Measure">Disposition Measure</option>
            <option value="Child-at-risk (CAR)">Child-at-risk (CAR)</option>
          </select>
        </div>

        <!-- Child Status Filter -->
        <div class="relative -mr-2 w-80 ml-auto">
          <select v-model="selectedChildStatus" class="mb-2 p-2 border border-gray-300 rounded-md w-full text-sm">
            <option value="">Select Child Status</option>
            <option value="Still at the Center (SATC)">Still at the Center (SATC)</option>
            <option value="Discharge">Discharge</option>
            <option value="Leave without Permission (LWOP)">Leave without Permission (LWOP)</option>
          </select>
        </div>
      </div>

      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <!-- Clients List -->
        <div class="p-4">
          <table class="min-w-full divide-y divide-gray-400">
            <thead>
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profile</th>
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
                <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-gray-900">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 rounded-full text-gray-500 bg-gray-200 p-1" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-2.7 0-8 1.4-8 4v2h16v-2c0-2.6-5.3-4-8-4z"/>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-[13px] font-medium text-gray-900">
                  {{ client.name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-[13px] text-black">{{ client.age }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-[13px] text-black">{{ client.case_status }}</td>
                <td
                  class="px-6 py-4 whitespace-nowrap text-[13px]"
                  :class="getChildStatusClass(client.child_status)"
                >
                  {{ client.child_status }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-[13px] text-gray-500">{{ client.date_admitted }}</td>
              </tr>

              <!-- No Clients Found Row -->
              <tr v-if="filteredClients.length === 0">
                <td colspan="6" class="px-6 py-4 text-center text-[13px] text-gray-500">No clients found</td>
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
const selectedCaseStatus = ref(''); // Case status filter
const selectedChildStatus = ref(''); // Child status filter

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

// Method to get the appropriate class based on child_status
const getChildStatusClass = (childStatus) => {
  switch (childStatus) {
    case 'Still at the Center (SATC)':
      return ' text-green-600'; // Green text for SATC
    case 'Discharge':
      return 'text-orange-600'; // Orange text for Discharge
    case 'Leave without Permission (LWOP)':
      return 'text-red-800'; // Red text for LWOP
    default:
      return ' text-black'; // Default black text
  }
};

// Computed property to filter clients
const filteredClients = computed(() => {
  let filtered = clients.value;

  // Filter by search query
  if (searchQuery.value) {
    filtered = filtered.filter(client =>
      client.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  }

  // Filter by case status
  if (selectedCaseStatus.value) {
    filtered = filtered.filter(client => client.case_status === selectedCaseStatus.value);
  }

  // Filter by child status
  if (selectedChildStatus.value) {
    filtered = filtered.filter(client => client.child_status === selectedChildStatus.value);
  }

  return filtered;
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
