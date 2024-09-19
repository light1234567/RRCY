<template>
  <AppLayout title="Dashboard">
    <template #header>
      <div class="flex items-center justify-center">
        <div class="ml-5 w-2 h-6 bg-gray-400 mr-3"></div>
        <svg
          class="ml-6"
          width="24"
          height="24"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M3 12h3v8H3zm6-8h3v16H9zm6 4h3v12h-3zm6-6h3v18h-3z"
          />
        </svg>
        <h1 class="text-xl font-bold ml-4 text-red-800 text-center">Dashboard</h1>
      </div>
    </template>

    <!-- Main Content Wrapper -->
    <div class="-mb-12 -mt-4 flex flex-wrap lg:flex-nowrap p-8 gap-4">
      <!-- Doughnut Chart (Case Status Overview) -->
      <div class="ml-4 bg-gray-50 border-4 border-gray-50 rounded-lg shadow-md p-4 w-full lg:w-2/5 h-auto">
        <h2 class="text-sm font-semibold">Case Status Overview</h2>
        <div class="relative w-full h-64">
          <Doughnut 
            :data="caseStatusData"
            :options="{
              plugins: { 
                legend: { 
                  position: 'right', 
                  labels: {
                    font: { size: 10 },
                    boxWidth: 10
                  }
                }
              },
              responsive: true,
              maintainAspectRatio: false,
            }"
          />
        </div>
      </div>

      <!-- Total CICL and Average Age -->
      <div class="flex flex-col space-y-4 w-full lg:w-1/5">
        <!-- Total CICL -->
        <div class="bg-white p-4 rounded-lg shadow-md flex-grow">
          <h3 class="text-sm font-medium text-gray-500">Total CICL</h3>
          <div class="flex items-center">
            <span class="text-3xl font-bold">{{ totalCICL }}</span>
          </div>
          <!-- Progress Bar -->
          <div class="mt-4 h-2 rounded-full bg-gray-200">
            <div class="h-2 bg-blue-600 rounded-full w-3/4"></div>
          </div>
        </div>

        <!-- Average Age -->
        <div class="bg-white p-4 rounded-lg shadow-md flex-grow">
          <h3 class="text-sm font-medium text-gray-500">Average Age of Clients</h3>
          <div class="flex items-center">
            <i class="fa fa-user-clock text-2xl text-gray-600 mr-2"></i>
            <span class="text-3xl font-bold">{{ averageAge }}</span>
          </div>
          <!-- Progress Bar -->
          <div class="mt-4 h-2 rounded-full bg-gray-200">
            <div class="h-2 bg-green-600 rounded-full w-4/5"></div>
          </div>
        </div>
      </div>

      <!-- Line Chart for Admissions by Month -->
      <div class="bg-white p-4 rounded-lg shadow-md w-full lg:w-2/5">
        <h2 class="text-sm font-semibold">Admissions by Month</h2>
        <div class="relative h-64 w-full">
          <Line 
            :data="filteredDateAdmittedData"
            :options="{ plugins: { title: {display: true, font: { size: 15 } }}}"
          />
        </div>
      </div>
    </div>

    <!-- Main Body Content (Offense Committed, Age Distribution, Child Status) -->
    <div class="flex flex-wrap lg:flex-nowrap gap-4 p-8">
      <!-- Offense Committed Table -->
      <div class="ml-4 bg-white p-6 rounded-lg shadow-md w-full lg:w-1/3">
  <h2 class="text-sm mb-6 font-semibold text-gray-700">Offense Committed</h2>
  <div class="overflow-y-auto h-64">
    <table class="-ml-1 w-full table-auto border-collapse">
      <thead class=" bg-gray-50 text-gray-600 uppercase text-xs font-semibold shadow-sm sticky top-0">
        <tr>
          <th class="px-4 py-3 text-left">Offense</th>
          <th class="px-8 py-3 text-left">Count</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
        <tr v-for="([offense, count], index) in filteredOffenses" :key="index" class="hover:bg-gray-50 transition duration-300 ease-in-out">
          <td class="px-4 py-4">{{ offense }}</td>
          <td class="px-8 py-4">{{ count }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>


      <!-- Age Distribution Bar Chart -->
      <div class="bg-white p-4 rounded-lg shadow-md w-full lg:w-1/2">
        <h2 class="text-sm font-semibold">Age Distribution</h2>
        <div class="-mb-12 relative w-full h-96">
          <Bar 
            :data="filteredAgeData"
            :options="{
              plugins: {
                title: {  display: true, font: { size: 15 } },
                tooltip: { enabled: true }
              }
            }"
          />
        </div>
      </div>

      <!-- Child Status Distribution Pie Chart -->
      <div class="bg-white p-4 rounded-lg shadow-md w-full lg:w-1/3">
        <h2 class="text-sm font-semibold">Child Status Distribution</h2>
        <div class="flex justify-center relative h-64">
          <Pie 
            :data="filteredChildStatusData"
            :options="{
              plugins: {
                title: { display: true, font: { size: 2 } },
                legend: {
                  position: 'bottom',
                  labels: {  font: { size: 12 }, margin: 10, boxWidth: 20, padding: 5 }
                }
              },
              responsive: true
            }"
          />
        </div>
      </div>
    </div>

    <!-- Sidebar (Dashboard Filters) -->
    <div :class="{ 'translate-x-full': !isSidebarOpen }" class="fixed right-0 top-0 w-64 h-full bg-white shadow-lg transition-transform duration-300 ease-in-out z-50">
      <!-- Sidebar Header with Collapse Button -->
      <div class=" p-4 flex justify-between items-center bg-gray-200">
        <h2 class="text-lg font-semibold">Dashboard Filters</h2>
        <button @click="toggleSidebar" class="text-gray-500 hover:text-gray-700">
          <i class="fa fa-times"></i>
        </button>
      </div>

      <!-- Sidebar Filters (Year and Month) -->
      <div class="p-4">
        <div class="flex flex-col mb-4">
          <div class="flex items-center space-x-2">
            <i class="fa fa-calendar-alt text-gray-700"></i>
            <div class="relative w-full">
              <select v-model="selectedYear" id="year" class="appearance-none border rounded-md p-2 shadow-sm bg-white focus:ring-indigo-500 focus:border-indigo-500 w-full pr-8">
                <option value="">All Years</option>
                <option v-for="year in availableYears" :key="year" :value="year">{{ year }}</option>
              </select>
              <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-col">
          <div class="flex items-center space-x-2">
            <i class="fa fa-calendar text-gray-700"></i>
            <div class="relative w-full">
              <select v-model="selectedMonth" id="month" class="appearance-none border rounded-md p-2 shadow-sm bg-white focus:ring-indigo-500 focus:border-indigo-500 w-full pr-8">
                <option value="">All Months</option>
                <option v-for="(monthName, index) in monthNames" :key="index" :value="index + 1">{{ monthName }}</option>
              </select>
              <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Overlay when Sidebar is Open -->
    <div v-if="isSidebarOpen" @click="toggleSidebar" class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>

    <!-- Toggle Sidebar Button -->
    <button @click="toggleSidebar" class="-mt-3 fixed right-0 top-4 z-50 bg-gray-200 p-2 rounded-l-md text-gray-700 shadow-md hover:bg-gray-300">
      <i :class="isSidebarOpen ? 'fa fa-chevron-right' : 'fa fa-chevron-left'"></i>
    </button>
  </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Pie, Line, Bar, Doughnut } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, LineElement, PointElement, BarElement } from 'chart.js';
import axios from 'axios';
import '@fortawesome/fontawesome-free/css/all.css';

// Sidebar open state
const isSidebarOpen = ref(false); // Added state for sidebar visibility

// Method to toggle sidebar
const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

// Register necessary chart components
ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, LineElement, PointElement, BarElement);

// Initialize reference for clients
const clients = ref([]);
const selectedYear = ref('');  // Selected year
const selectedMonth = ref(''); // Selected month

// Fetch clients data from the API
const fetchClients = async () => {
  try {
    console.log(clients.value);
    const response = await axios.get('/api/clients-data'); // Replace with your actual API endpoint
    clients.value = response.data.map(client => {
      const { first_name, last_name, date_of_birth, child_status } = client;
      const admission = client.admissions[0]; // Assuming the first admission record is required
      const age = new Date().getFullYear() - new Date(date_of_birth).getFullYear();

      return {
        id: client.id,
        name: `${first_name} ${last_name}`,
        case_status: admission?.case_status || 'N/A',
        child_status: child_status || 'N/A',
        offense_committed: admission?.offense_committed || 'N/A',
        age: age,
        date_admitted: admission?.date_admitted || 'N/A',
      };
    });
  } catch (error) {
    console.error('Error fetching clients:', error);
  }
};

onMounted(fetchClients);

// Month names for the dropdown
const monthNames = [
  'January', 'February', 'March', 'April', 'May', 'June', 
  'July', 'August', 'September', 'October', 'November', 'December'
];

// Get all unique years from the data for the year filter
const availableYears = computed(() => {
  const years = clients.value.map(client => new Date(client.date_admitted).getFullYear());
  return [...new Set(years)]; // Return unique years
});

// Calculate the average age of filtered clients
const averageAge = computed(() => {
  const filteredClients = clients.value.filter(client => {
    const admittedDate = new Date(client.date_admitted);
    const clientMonth = admittedDate.getMonth() + 1;
    const clientYear = admittedDate.getFullYear();

    return (!selectedYear.value || selectedYear.value == clientYear) &&
           (!selectedMonth.value || selectedMonth.value == clientMonth);
  });
  
  if (!filteredClients.length) return 0;
  
  const totalAge = filteredClients.reduce((sum, client) => sum + client.age, 0);
  return Math.floor(totalAge / filteredClients.length);
});

// Filtered Offenses
const filteredOffenses = computed(() => {
  return Object.entries(
    clients.value.reduce((acc, client) => {
      const admittedDate = new Date(client.date_admitted);
      const clientMonth = admittedDate.getMonth() + 1; // Month is 0-indexed
      const clientYear = admittedDate.getFullYear();

      const matchesFilter =
        (!selectedYear.value || selectedYear.value == clientYear) &&
        (!selectedMonth.value || selectedMonth.value == clientMonth);

      if (matchesFilter) {
        acc[client.offense_committed] = (acc[client.offense_committed] || 0) + 1;
      }
      return acc;
    }, {})
  ).sort((a, b) => b[1] - a[1]); // Sort by count descending
});

// Filtered Case Status Counts for the Pie Chart and Case Status Table
const filteredCaseStatusCountsArray = computed(() => {
  const statuses = [
    { label: 'On trial', icon: 'gavel', color: '#36A2EB' }, // Blue
    { label: 'Suspended sentence', icon: 'pause-circle', color: '#FFCE56' }, // Yellow
    { label: 'Acquitted', icon: 'check-circle', color: '#4BC0C0' }, // Green
    { label: 'Dismissed', icon: 'times-circle', color: '#FF6384' }, // Red
    { label: 'Rehabilitation', icon: 'heart', color: '#9966FF' }, // Purple
    { label: 'Provisionally Dismissed', icon: 'clock', color: '#FF9F40' }, // Orange
    { label: 'Diversion', icon: 'random', color: '#33FF57' }, // Light Green
    { label: 'Disposition Measure', icon: 'balance-scale-right', color: '#FF5733' }, // Dark Red
    { label: 'Child-at-risk (CAR)', icon: 'exclamation-circle', color: '#3357FF' }  // Dark Blue
  ];

  const counts = statuses.reduce((acc, status) => {
    acc[status.label] = clients.value.filter(client => {
      const admittedDate = new Date(client.date_admitted);
      const clientMonth = admittedDate.getMonth() + 1; // Month is 0-indexed
      const clientYear = admittedDate.getFullYear();
      const matchesFilter =
        (!selectedYear.value || selectedYear.value == clientYear) &&
        (!selectedMonth.value || selectedMonth.value == clientMonth);
      return matchesFilter && client.case_status === status.label;
    }).length;
    return acc;
  }, {});

  return statuses.map(status => ({
    label: status.label,
    count: counts[status.label] || 0,
    color: status.color,
  }));
});

// Generate data for the Doughnut Chart
const caseStatusData = computed(() => {
  const labels = filteredCaseStatusCountsArray.value.map(status => status.label);
  const data = filteredCaseStatusCountsArray.value.map(status => status.count);
  const backgroundColor = filteredCaseStatusCountsArray.value.map(status => status.color);

  return {
    labels: labels,
    datasets: [
      {
        label: 'Case Status',
        backgroundColor: backgroundColor,
        data: data,
      }
    ]
  };
});

// Filtered Child Status Data for the Pie Chart
const filteredChildStatusData = computed(() => {
  const childStatusCounts = clients.value.reduce((acc, client) => {
    const admittedDate = new Date(client.date_admitted);
    const clientMonth = admittedDate.getMonth() + 1;
    const clientYear = admittedDate.getFullYear();

    const matchesFilter =
      (!selectedYear.value || selectedYear.value == clientYear) &&
      (!selectedMonth.value || selectedMonth.value == clientMonth);

    if (matchesFilter) {
      acc[client.child_status] = (acc[client.child_status] || 0) + 1;
    }
    return acc;
  }, {});

  return {
    labels: Object.keys(childStatusCounts),
    datasets: [
      {
        label: 'Child Status',
        backgroundColor: ['#FF0000', '#0000FF', '#FFFF00'],
        data: Object.values(childStatusCounts),
      },
    ],
  };
});

// Filtered Date Admitted Data for the Line Chart
const filteredDateAdmittedData = computed(() => {
  const dateAdmittedCounts = clients.value.reduce((acc, client) => {
    const admittedDate = new Date(client.date_admitted);
    const clientMonth = admittedDate.getMonth() + 1;
    const clientYear = admittedDate.getFullYear();

    const matchesFilter =
      (!selectedYear.value || selectedYear.value == clientYear) &&
      (!selectedMonth.value || selectedMonth.value == clientMonth);

    if (matchesFilter) {
      const month = new Date(client.date_admitted).toLocaleString('default', { month: 'long' });
      acc[month] = (acc[month] || 0) + 1;
    }
    return acc;
  }, {});

  const monthOrder = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  const sortedCounts = monthOrder.map(month => dateAdmittedCounts[month] || 0); // Set 0 for months with no data

  return {
    labels: monthOrder,
    datasets: [
      {
        label: 'Date Admitted',
        backgroundColor: 'rgba(255, 0, 0, 0.2)', // DSWD red with transparency
        borderColor: '#FF0000', // DSWD red
        fill: true,
        data: sortedCounts,
      },
    ],
  };
});

// Filtered Age Data for the Histogram
const filteredAgeData = computed(() => {
  const ageCounts = clients.value.reduce((acc, client) => {
    const admittedDate = new Date(client.date_admitted);
    const clientMonth = admittedDate.getMonth() + 1;
    const clientYear = admittedDate.getFullYear();

    const matchesFilter =
      (!selectedYear.value || selectedYear.value == clientYear) &&
      (!selectedMonth.value || selectedMonth.value == clientMonth);

    if (matchesFilter) {
      acc[client.age] = (acc[client.age] || 0) + 1;
    }
    return acc;
  }, {});

  return {
    labels: Object.keys(ageCounts), // Labels will be the actual ages
    datasets: [
      {
        label: 'Age Distribution',
        backgroundColor: '#87CEEB', // Sky blue color for histogram bars
        borderColor: '#388E3C',     // Darker green for border
        borderWidth: 1,
        data: Object.values(ageCounts),
      },
    ],
  };
});
// Calculate the total CICL clients (Adjust based on your data)
const totalCICL = computed(() => {
return clients.value.filter(client => client.client_type === 'CICL').length;});
</script>

<style scoped>
.number-transition-enter-active, .number-transition-leave-active {
  transition: transform 0.5s ease, opacity 0.5s ease;
}
.number-transition-enter-from, .number-transition-leave-to {
  transform: scale(0.8);
  opacity: 0;
}
.number-transition-enter-to, .number-transition-leave-from {
  transform: scale(1);
  opacity: 1;
}
/* Sidebar styles */
.translate-x-full {
  transform: translateX(100%);
}
</style>
