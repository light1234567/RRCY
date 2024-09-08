<template>
  <AppLayout title="CICL">
    <template #header>
      <div class="flex items-center">
        <div class="w-2 h-6 bg-gray-400 mr-3"></div>
        <i class="fa fa-users text-black text-2xl ml-6"></i>
        <h1 class="text-lg ml-4 font-bold text-red-800">CICL</h1>
      </div>
    </template>

    <div class="ml-6 max-w-6x1 mx-auto sm:px-6 lg:px-8 mt-2">
      <div class="p-2 rounded-lg flex justify-end items-center">
        <div class="mr-auto text-md font-semibold text-gray-400">
          Total number of CICL:
          <span class="text-gray-800">{{ totalCICL }}</span>
        </div>

        <!-- Filter Icon (Left of Search Bar) -->
        <div class="relative mr-4">
          <button @click="toggleDropdown" class="p-2 rounded-full text-black">
            <!-- SVG icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
              <circle cx="8" cy="6" r="2" fill="currentColor"></circle>
              <circle cx="16" cy="12" r="2" fill="currentColor"></circle>
              <circle cx="8" cy="18" r="2" fill="currentColor"></circle>
            </svg>
          </button>

          <!-- Dropdown Menu for Filters -->
          <div v-if="isDropdownOpen" class="absolute right-0 mt-2 w-96 bg-white shadow-lg rounded-md z-10">
            <!-- Filter content (similar to the original code) -->
          </div>
        </div>

        <!-- Search Bar -->
        <div class="mt-2 relative w-80">
          <input v-model="searchQuery" type="text" placeholder="Search" class="mb-2 p-2 pr-10 border border-gray-300 rounded-md w-full text-sm"/>
          <span class="absolute inset-y-0 right-0 flex items-center pr-3">
            <svg class="mb-2 h-5 w-5 text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.099zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg>
          </span>
        </div>
      </div>

      <!-- Clients Table -->
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-4">
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
              <tr v-for="(client, index) in paginatedClients" :key="index" class="cursor-pointer hover:bg-gray-100" @click="navigateToEditPage(client.id)">
                <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-gray-900">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 rounded-full text-gray-500 bg-gray-200 p-1" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-2.7 0-8 1.4-8 4v2h16v-2c0-2.6-5.3-4-8-4z"/>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-[13px] font-medium text-gray-900">{{ client.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-[13px] text-black">{{ client.age }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-[13px] text-black">{{ client.case_status }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-[13px]" :class="getChildStatusClass(client.child_status)">
                  {{ client.child_status }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-[13px] text-gray-500">{{ client.date_admitted }}</td>
              </tr>

              <!-- No Clients Found Row -->
              <tr v-if="paginatedClients.length === 0">
                <td colspan="6" class="px-6 py-4 text-center">
                  <div class="p-6 bg-red-100 text-red-700 border border-red-400 rounded-md">
                    <p class="text-lg font-semibold">No clients found</p>
                    <p class="text-sm text-gray-500">Try adjusting your search or filters.</p>
                    <div class="mt-4 flex justify-center space-x-2">
                      <button @click="previousPage" :disabled="currentPage === 1" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 disabled:opacity-50">
                        Previous
                      </button>
                      <button @click="nextPage" :disabled="currentPage === totalPages" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 disabled:opacity-50">
                        Next
                      </button>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Pagination Controls (Outside of Table) -->
      <div class="mt-4 flex justify-end">
        <button @click="previousPage" :disabled="currentPage === 1" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md mr-2">
          Previous
        </button>
        <span class="px-3 py-1">{{ currentPage }} / {{ totalPages }}</span>
        <button @click="nextPage" :disabled="currentPage === totalPages" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md ml-2">
          Next
        </button>
      </div>
    </div>
  </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import '@fortawesome/fontawesome-free/css/all.css';

const router = useRouter();
const clients = ref([]);
const searchQuery = ref('');
const selectedCaseStatus = ref(''); // Selected case status
const selectedChildStatus = ref(''); // Selected child status
const currentPage = ref(1); // Current page
const clientsPerPage = 10; // Limit to 10 clients per page
const isDropdownOpen = ref(false); // State to manage filter dropdown visibility

// Toggle dropdown visibility
const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value;
};

// Case status and child status options
const caseStatuses = ref([
  "On trial", 
  "Suspended sentence", 
  "Acquitted", 
  "Dismissed", 
  "Provisionally Dismissed", 
  "Rehabilitation", 
  "Diversion", 
  "Disposition Measure", 
  "Child-at-risk (CAR)"
]);

const childStatuses = ref([
  "Still at the Center (SATC)", 
  "Discharge", 
  "Leave without Permission (LWOP)"
]);

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

// Computed property to calculate total CICL
const totalCICL = computed(() => {
  return clients.value.length;
});

// Select case status
const selectCaseStatus = (status) => {
  selectedCaseStatus.value = selectedCaseStatus.value === status ? '' : status;
};

// Select child status
const selectChildStatus = (status) => {
  selectedChildStatus.value = selectedChildStatus.value === status ? '' : status;
};

// Method to get the appropriate class based on child_status
const getChildStatusClass = (childStatus) => {
  switch (childStatus) {
    case 'Still at the Center (SATC)':
      return 'text-green-600'; // Green text for SATC
    case 'Discharge':
      return 'text-orange-600'; // Orange text for Discharge
    case 'Leave without Permission (LWOP)':
      return 'text-red-800'; // Red text for LWOP
    default:
      return 'text-black'; // Default black text
  }
};

// Calculate total number of pages
const totalPages = computed(() => {
  return Math.ceil(filteredClients.value.length / clientsPerPage);
});
// Paginate clients based on current page
const paginatedClients = computed(() => {
  const start = (currentPage.value - 1) * clientsPerPage;
  const end = start + clientsPerPage;
  return filteredClients.value.slice(start, end);
});

// Pagination methods
const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value += 1;
  }
};

const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value -= 1;
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
