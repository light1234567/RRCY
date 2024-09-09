<template>
  <AppLayout title="CICL">
    <template #header>
      <div class="flex items-center mb-4">
        <div class="w-2 h-6 bg-gray-500 mr-3"></div>
        <i class="fa fa-users text-gray-800 text-2xl ml-6"></i>
        <h1 class="text-xl ml-4 font-bold text-indigo-800">CICL Management</h1>
      </div>
    </template>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
      <div class="p-4 rounded-lg flex flex-col md:flex-row justify-between items-center bg-gray-100 shadow-sm space-y-4 md:space-y-0">
        <div class="text-md font-semibold text-gray-500">
          Total number of CICL: <span class="text-gray-900">{{ totalCICL }}</span>
        </div>

        <div class="flex items-center space-x-4">
          <!-- Filter Icon -->
          <div class="relative">
            <button @click="toggleDropdown" class="p-2 rounded-full text-gray-700 bg-gray-200 hover:bg-gray-300 transition-all duration-150">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                <circle cx="8" cy="6" r="2" fill="currentColor"></circle>
                <circle cx="16" cy="12" r="2" fill="currentColor"></circle>
                <circle cx="8" cy="18" r="2" fill="currentColor"></circle>
              </svg>
            </button>

            <!-- Dropdown Menu for Filters -->
            <div v-if="isDropdownOpen" class="absolute right-0 mt-2 w-96 bg-white shadow-lg rounded-md z-10">
              <div class="p-4">
                <!-- Filter for Case Status -->
                <div>
                  <h3 class="font-semibold text-gray-800 mb-2">Case Status</h3>
                  <div class="flex flex-wrap">
                    <button
                      v-for="status in caseStatuses"
                      :key="status"
                      @click="selectCaseStatus(status)"
                      :class="{'bg-blue-600 text-white': selectedCaseStatus === status, 'bg-gray-200 text-gray-700 hover:bg-gray-300': selectedCaseStatus !== status}"
                      class="px-4 py-2 mr-2 mb-2 rounded-full text-xs transition-all duration-150">
                      {{ status }}
                    </button>
                  </div>
                </div>

                <!-- Filter for Child Status -->
                <div class="mt-4">
                  <h3 class="font-semibold text-gray-800 mb-2">Child Status</h3>
                  <div class="flex flex-wrap">
                    <button
                      v-for="status in childStatuses"
                      :key="status"
                      @click="selectChildStatus(status)"
                      :class="{'bg-green-600 text-white': selectedChildStatus === status, 'bg-gray-200 text-gray-700 hover:bg-gray-300': selectedChildStatus !== status}"
                      class="px-4 py-2 mr-2 mb-2 rounded-full text-xs transition-all duration-150">
                      {{ status }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Search Bar -->
          <div class="relative w-full max-w-xs">
            <input v-model="searchQuery" type="text" placeholder="Search" class="p-2 pr-10 border border-gray-300 rounded-md w-full text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none"/>
            <span class="absolute inset-y-0 right-0 flex items-center pr-3">
              <svg class="h-5 w-5 text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.099zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
              </svg>
            </span>
          </div>
        </div>
      </div>

      <!-- Clients Table -->
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-6">
        <div class="p-4">
          <table class="min-w-full divide-y divide-gray-200 table-auto">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Age</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Case Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Child Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Date Admitted</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
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

      <!-- Pagination Controls -->
      <div class="mt-4 flex justify-center">
        <button @click="previousPage" :disabled="currentPage === 1" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md mr-2 hover:bg-gray-300">
          Previous
        </button>
        <span class="px-3 py-1">{{ currentPage }} / {{ totalPages }}</span>
        <button @click="nextPage" :disabled="currentPage === totalPages" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md ml-2 hover:bg-gray-300">
          Next
        </button>
      </div>
    </div>

    <!-- Modal for Old Case Warning -->
    <transition name="fade">
      <div v-if="showModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ modalMessage }}</h3>
          <div class="flex justify-end space-x-4">
            <button @click="confirmProceed" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Yes</button>
            <button @click="cancelProceed" class="px-4 py-2 bg-gray-500 text-white rounded-lg">No</button>
          </div>
        </div>
      </div>
    </transition>
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
const showModal = ref(false);
const modalMessage = ref('');
const isNavigating = ref(false);
let clientToProceed = null;

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value;
};

const caseStatuses = ["On trial", "Suspended sentence", "Acquitted", "Dismissed", "Provisionally Dismissed", "Rehabilitation", "Diversion", "Disposition Measure", "Child-at-risk (CAR)"];

const childStatuses = ["Still at the Center (SATC)", "Discharge", "Leave without Permission (LWOP)"];

const fetchClients = async () => {
  try {
    const response = await axios.get('/api/clients-data');
    clients.value = response.data.map(client => {
      const { first_name, last_name, date_of_birth } = client;
      const admission = client.admissions[0];
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
      return 'text-orange-600';
    case 'Leave without Permission (LWOP)':
      return 'text-red-800';
    default:
      return 'text-black';
  }
};

const totalPages = computed(() => Math.ceil(filteredClients.value.length / clientsPerPage));

const sortedClients = computed(() => {
  let grouped = groupByName(filteredClients.value);

  let flattened = [];
  for (let name in grouped) {
    let cases = grouped[name];
    cases.forEach((client, index) => {
      client.case_label = index === 0 ? "New Case" : "Old Case";
      flattened.push(client);
    });
  }

  const sorted = flattened.sort((a, b) => {
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

const groupByName = (clients) => {
  return clients.reduce((acc, client) => {
    if (!acc[client.name]) acc[client.name] = [];
    acc[client.name].push(client);
    acc[client.name].sort((a, b) => new Date(b.date_admitted) - new Date(a.date_admitted));
    return acc;
  }, {});
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value += 1;
};

const previousPage = () => {
  if (currentPage.value > 1) currentPage.value -= 1;
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

const navigateToEditPage = (id) => {
  const resolvedRoute = router.resolve({ name: 'maintab', params: { id: id } });
  window.location.href = resolvedRoute.href;
};

const handleRowClick = (client) => {
  if (isNavigating.value) return;
  isNavigating.value = true;

  if (client.case_label === 'Old Case') {
    modalMessage.value = `This is the old case of ${client.name}. Do you want to proceed?`;
    clientToProceed = client;
    showModal.value = true;
  } else {
    navigateToEditPage(client.id);
  }
};

const confirmProceed = () => {
  showModal.value = false;
  navigateToEditPage(clientToProceed.id);
};

const cancelProceed = () => {
  showModal.value = false;
  isNavigating.value = false;
};
</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>
