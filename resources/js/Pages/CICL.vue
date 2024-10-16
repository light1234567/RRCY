<template>
  <AppLayout title="CICL">
    <template #header>
      <div class="flex items-center">
        <div class="ml-5 w-2 h-6 bg-gray-400 mr-3"></div>
        <i class="fa fa-users text-black text-2xl ml-6"></i>
        <h1 class="text-lg ml-4 font-bold text-red-800">CICL LIST</h1>
      </div>
    </template>

    <div class="bg-slate-50 min-h-screen ml-5 max-w-8xl mx-auto px-4 -mr-4 sm:px-6 lg:px-8 mt-4">



<div class="-mt-3 pt-4 flex justify-between items-center space-x-4 w-full">
  <!-- Search Bar (left-aligned) -->
  <div class="relative w-full max-w-xs">
    <span class="absolute inset-y-0 right-0 flex items-center pr-3">
      <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.099zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
      </svg>
    </span>
    <input v-model="searchQuery" type="text" placeholder="Search" class="p-2 pr-10 border border-gray-300 rounded-md w-full text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none transition duration-150"/>
   
  </div>

  <!-- Filters (right-aligned) -->
  <div class="mr-4 flex items-center space-x-4">
    <!-- Label for Sort by -->
    <label class="text-gray-600 text-sm font-medium">Sort by:</label>

    <!-- Case Status Filter -->
    <div class="relative">
      <select v-model="selectedCaseStatus" class="text-sm block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-indigo-500">
        <option value="">Case Status</option>
        <option v-for="status in caseStatuses" :key="status" :value="status">{{ status }}</option>
      </select>
      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"></div>
    </div>

    <!-- Child Status Filter -->
    <div class="relative">
      <select v-model="selectedChildStatus" class="text-sm  block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-indigo-500">
        <option value="">Child Status</option>
        <option v-for="status in childStatuses" :key="status" :value="status">{{ status }}</option>
      </select>
      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"></div>
    </div>
  </div>
</div>



      <!-- Clients Table -->
      <div class="-ml-4 -mr-4 overflow-hidden  sm:rounded-lg ">
        <div class="p-4">
          <table class="min-w-full divide-y  table-auto">
            <thead class="border border-gray-200 text-white bg-white">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">Age</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">Case Status</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">Child Status</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">Date Admitted</th>
              </tr>
            </thead>
            <tbody class=" divide-y divide-gray-200">
              <tr v-for="(client, index) in sortedClients" :key="index"
                  class="cursor-pointer hover:bg-gray-100 transition-all duration-150"
                  @click="handleRowClick(client)">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ client.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ client.age }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">{{ client.case_status }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm" :class="getChildStatusClass(client.child_status)">
                  {{ client.child_status }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatDate(client.date_admitted) }}</td>
              </tr>

              <!-- No Clients Found Row -->
              <tr v-if="sortedClients.length === 0">
                <td colspan="5" class="px-6 py-4 text-center">
                  <div class="p-6 bg-red-100 text-red-700 border border-red-400 rounded-md">
                    <p class="text-lg font-semibold">No clients found</p>
                    <p class="text-sm text-gray-500">Try adjusting your search or filters.</p>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

     <!-- Pagination Controls -->
     <div class=" mt-4 mb-8 flex justify-between items-center space-x-2">
  <!-- Total number of CICL (left-aligned) -->
  <div class="ml-4 text-sm font-semibold text-gray-700">
    TOTAL NUMBER OF CICL = <span class="text-gray-700">{{ totalCICL }} </span>
  </div>

  <!-- Pagination (right-aligned) -->
  <div class="flex items-center space-x-2">
    <!-- First Page Button (Disabled if on the first page) -->
    <button @click="firstPage" :disabled="currentPage === 1" 
            class="text-xs px-3 py-1 bg-gray-100 text-black rounded-md hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">
      « 
    </button>

    <!-- Previous Page Button (Disabled if on the first page) -->
    <button @click="previousPage" :disabled="currentPage === 1" 
            class="text-xs px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">
      ‹
    </button>

    <!-- Page Numbers -->
    <button v-for="page in totalPages" :key="page"
            @click.stop="goToPage(page)" 
            :class="{
              'text-xs px-3 py-1 border-2 border-blue-500 text-blue-500 rounded-md': currentPage === page,
              'text-xs px-3 py-1 bg-white border-2 border-gray-200 text-black rounded-md hover:bg-gray-100': currentPage !== page
            }">
      {{ page }}
    </button>

    <!-- Next Page Button (Disabled if on the last page) -->
    <button @click="nextPage" :disabled="currentPage === totalPages" 
            class="text-xs px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">
      ›
    </button>

    <!-- Last Page Button (Disabled if on the last page) -->
    <button @click="lastPage" :disabled="currentPage === totalPages" 
            class="text-xs px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">
      »
    </button>
  </div>
</div>


    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const clients = ref([]);
const searchQuery = ref('');
const selectedCaseStatus = ref('');
const selectedChildStatus = ref('');
const currentPage = ref(1);
const clientsPerPage = 10;
const isDropdownOpen = ref(false);
const isNavigating = ref(false);

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value;
};

const caseStatuses = ["On trial",  "Acquitted/Dismissed", "Provisionally Dismissed", "Rehabilitated", "Diversion", "Disposition Measure", "Child-at-risk (CAR)"];

const childStatuses = ["Still at the Center (SATC)", "Discharge", "Leave without Permission (LWOP)"];

// Function to fetch clients and select only the latest admission for each client
const fetchClients = async () => {
  try {
    const response = await axios.get('/api/clients-data');
    
    const groupedClients = response.data.reduce((acc, client) => {
      const { first_name, last_name, date_of_birth, admissions } = client;
      
      // Accurate age calculation
      const birthDate = new Date(date_of_birth);
      const today = new Date();
      let age = today.getFullYear() - birthDate.getFullYear();
      const monthDiff = today.getMonth() - birthDate.getMonth();
      
      // Adjust the age if the birth date hasn't occurred yet this year
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }

      const latestAdmission = admissions.sort((a, b) => new Date(b.date_admitted) - new Date(a.date_admitted))[0];

      const clientInfo = {
        id: client.id,
        name: `${first_name} ${last_name}`,
        date_of_birth: birthDate.toISOString().split('T')[0],  // Save date of birth for comparison
        age: age,
        case_status: latestAdmission?.case_status || 'N/A',
        child_status: client.child_status,
        date_admitted: latestAdmission?.date_admitted || 'N/A',
      };

      // Now the check includes both name and date_of_birth
      const existingClient = acc.find(c => c.name === clientInfo.name && c.date_of_birth === clientInfo.date_of_birth);

      if (!existingClient || new Date(clientInfo.date_admitted) > new Date(existingClient.date_admitted)) {
        // Remove old entry if it exists
        acc = acc.filter(c => !(c.name === clientInfo.name && c.date_of_birth === clientInfo.date_of_birth));
        acc.push(clientInfo);
      }

      return acc;
    }, []);

    clients.value = groupedClients;
  } catch (error) {
    console.error('Error fetching clients:', error);
  }
};

onMounted(fetchClients);

const totalCICL = computed(() => clients.value.length);

const selectCaseStatus = (status) => {
  selectedCaseStatus.value = selectedCaseStatus.value === status ? '' : status;
};

const selectChildStatus = (status) => {
  selectedChildStatus.value = selectedChildStatus.value === status ? '' : status;
};

const getChildStatusClass = (childStatus) => {
  switch (childStatus) {
    case 'Still at the Center (SATC)':
      return 'text-green-600';
    case 'Discharge':
      return 'text-red-800 ';
    case 'Leave without Permission (LWOP)':
      return 'text-orange-600';
    default:
      return 'text-black';
  }
};

const totalPages = computed(() => Math.ceil(filteredClients.value.length / clientsPerPage));

const sortedClients = computed(() => {
  let filtered = filteredClients.value;

  const sorted = filtered.sort((a, b) => {
    const statusOrder = {
      'Still at the Center (SATC)': 0,
      'Leave without Permission (LWOP)': 1,
      'Discharge': 2,
    };

    return statusOrder[a.child_status] - statusOrder[b.child_status];
  });

  const start = (currentPage.value - 1) * clientsPerPage;
  return sorted.slice(start, start + clientsPerPage);
});

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value += 1;
};

const previousPage = () => {
  if (currentPage.value > 1) currentPage.value -= 1;
};

const firstPage = () => {
  currentPage.value = 1;
};

const lastPage = () => {
  currentPage.value = totalPages.value;
};

const goToPage = (page) => {
  currentPage.value = page;
};

const filteredClients = computed(() => {
  let filtered = clients.value;

  if (searchQuery.value) {
    filtered = filtered.filter(client =>
      client.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  }

  if (selectedCaseStatus.value) {
    filtered = filtered.filter(client => client.case_status === selectedCaseStatus.value);
  }

  if (selectedChildStatus.value) {
    filtered = filtered.filter(client => client.child_status === selectedChildStatus.value);
  }

  return filtered;
});

const formatDate = (date) => {
  if (!date || date === 'N/A') return 'N/A';
  return new Date(date).toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' });
};

// Function to navigate to case route instead of maintab
const navigateToCases = (id) => {
  const resolvedRoute = router.resolve({ name: 'case', params: { id: id } });
  window.location.href = resolvedRoute.href;
};

const handleRowClick = (client) => {
  if (isNavigating.value) return;
  isNavigating.value = true;
  navigateToCases(client.id);
};
</script>
