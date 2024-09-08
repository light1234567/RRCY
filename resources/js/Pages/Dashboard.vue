<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Pie, Line } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, LineElement, PointElement, LineController } from 'chart.js';
import axios from 'axios';
import { ref, computed, onMounted } from 'vue';

// Register necessary chart components
ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, LineElement, PointElement, LineController);

const clients = ref([]); // Dynamic clients data fetched from the API

// Fetch clients data from the API
const fetchClients = async () => {
  try {
    const response = await axios.get('/api/clients-data'); // Replace with your actual API endpoint
    clients.value = response.data.map(client => {
      const { first_name, last_name, date_of_birth, child_status } = client;
      const admission = client.admissions[0]; // Assuming the first admission record is required
      const age = new Date().getFullYear() - new Date(date_of_birth).getFullYear();
      
      // Use admission to fetch offense_committed, case_status, and other details
      const offenseCommitted = admission?.offense_committed || 'N/A'; 
      
      return {
        id: client.id,
        name: `${first_name} ${last_name}`,
        case_status: admission?.case_status || 'N/A',
        child_status: child_status || 'N/A',
        offense_committed: offenseCommitted,
        age: age,
        date_admitted: admission?.date_admitted || 'N/A',
      };
    });
  } catch (error) {
    console.error('Error fetching clients:', error);
  }
};

onMounted(fetchClients);

// Computed properties for Case Status, Child Status, Date Admitted, Age Distribution, and Offense Committed

// Case Status Data for Pie Chart with DSWD colors
const caseStatusData = computed(() => {
  const caseStatusCounts = clients.value.reduce((acc, client) => {
    acc[client.case_status] = (acc[client.case_status] || 0) + 1;
    return acc;
  }, {});

  return {
    labels: Object.keys(caseStatusCounts),
    datasets: [
      {
        label: 'Case Status',
        backgroundColor: ['#FF0000', '#0000FF', '#FFFF00', '#FFFFFF'], // DSWD red, blue, yellow, white
        data: Object.values(caseStatusCounts),
      },
    ],
  };
});

// Child Status Data for Pie Chart with DSWD colors
const childStatusData = computed(() => {
  const childStatusCounts = clients.value.reduce((acc, client) => {
    acc[client.child_status] = (acc[client.child_status] || 0) + 1;
    return acc;
  }, {});

  return {
    labels: Object.keys(childStatusCounts),
    datasets: [
      {
        label: 'Child Status',
        backgroundColor: ['#FF0000', '#0000FF', '#FFFF00'], // DSWD red, blue, yellow
        data: Object.values(childStatusCounts),
      },
    ],
  };
});

// Date Admitted Data for Line Chart with DSWD colors
const dateAdmittedData = computed(() => {
  const dateAdmittedCounts = clients.value.reduce((acc, client) => {
    const month = new Date(client.date_admitted).toLocaleString('default', { month: 'long' });
    acc[month] = (acc[month] || 0) + 1;
    return acc;
  }, {});

  // Ensure months are in chronological order
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

// Age Data for Pie Chart with DSWD colors
const ageData = computed(() => {
  const ageCounts = clients.value.reduce((acc, client) => {
    acc[client.age] = (acc[client.age] || 0) + 1; // Using actual ages as keys
    return acc;
  }, {});

  return {
    labels: Object.keys(ageCounts), // Labels will be the actual ages
    datasets: [
      {
        label: 'Age Distribution',
        backgroundColor: ['#FF0000', '#0000FF', '#FFFF00', '#FFFFFF', '#FF6384'], // DSWD red, blue, yellow, white, and an extra color
        data: Object.values(ageCounts),
      },
    ],
  };
});

// Offense Committed Data for Pie Chart with DSWD colors
const offenseData = computed(() => {
  const offenseCounts = clients.value.reduce((acc, client) => {
    acc[client.offense_committed] = (acc[client.offense_committed] || 0) + 1;
    return acc;
  }, {});

  return {
    labels: Object.keys(offenseCounts),
    datasets: [
      {
        label: 'Offense Committed',
        backgroundColor: ['#FF0000', '#0000FF', '#FFFF00', '#FFFFFF'], // DSWD red, blue, yellow, white
        data: Object.values(offenseCounts),
      },
    ],
  };
});

// Calculate average age
const averageAge = computed(() => {
  const totalAge = clients.value.reduce((sum, client) => sum + client.age, 0);
  return (totalAge / clients.value.length).toFixed(1);
});

// Total number of clients
const totalClients = computed(() => clients.value.length);

// Chart Options
const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  scales: {
    y: {
      ticks: {
        beginAtZero: true,
        stepSize: 1, // Ensure integer steps
      }
    }
  },
  plugins: {
    legend: { position: 'bottom' },
    title: { display: true, text: '' },
  },
};
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h1 class="text-xl font-bold ml-12 text-red-800 text-center">Dashboard</h1>
    </template>

    <!-- Average Age and Total Clients Display (centered) -->
    <div class="flex justify-center items-center p-6">
      <div class="bg-white p-6 rounded-lg shadow flex justify-center items-center space-x-12">
        <div>
          <h2 class="text-lg font-semibold text-center">Average Age of Clients</h2>
          <p class="text-xl font-bold text-center">{{ averageAge }} years</p>
        </div>
        <div>
          <h2 class="text-lg font-semibold text-center">Total Clients</h2>
          <p class="text-xl font-bold text-center">{{ totalClients }}</p>
        </div>
      </div>
    </div>

    <!-- Responsive Grid for the charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">

      <!-- Case Status Pie Chart -->
      <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4">Case Status Overview</h2>
        <div class="relative h-64">
          <Pie :data="caseStatusData" :options="{...chartOptions, plugins: { title: { text: 'Case Status Distribution', display: true }}}" />
        </div>
      </div>

      <!-- Child Status Pie Chart -->
      <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4">Child Status Overview</h2>
        <div class="relative h-64">
          <Pie :data="childStatusData" :options="{...chartOptions, plugins: { title: { text: 'Child Status Distribution', display: true }}}" />
        </div>
      </div>

      <!-- Date Admitted Line Chart (Revised) -->
      <div class="bg-white p-4 rounded-lg shadow md:col-span-2 lg:col-span-1">
        <h2 class="text-lg font-semibold mb-4">Date Admitted Overview</h2>
        <div class="relative h-64">
          <Line :data="dateAdmittedData" :options="{...chartOptions, plugins: { title: { text: 'Admissions by Month', display: true }}}" />
        </div>
      </div>

      <!-- Age Distribution Pie Chart -->
      <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4">Age Distribution</h2>
        <div class="relative h-64">
          <Pie :data="ageData" :options="{...chartOptions, plugins: { title: { text: 'Age Distribution', display: true }}}" />
        </div>
      </div>

      <!-- Offense Committed Pie Chart -->
      <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4">Offense Committed Overview</h2>
        <div class="relative h-64">
          <Pie :data="offenseData" :options="{...chartOptions, plugins: { title: { text: 'Offense Committed Distribution', display: true }}}" />
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
/* Add any necessary styles here */
</style>
