<template>
  <AppLayout title="Dashboard">
    <template #header>
      <div class="flex items-center justify-center">
        <svg
          class="ml-12"  
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

    <!-- Case Status Display -->
    <div class="flex justify-center items-center p-4">
      <div class="bg-gray-50 -mb-8 border-4 border-gray-50 p-4 rounded-lg shadow-md text-gray-900 w-full max-w-6xl">
        <h2 class="text-lg mb-8 font-semibold text-left">Case Status Overview</h2>

        <!-- First Row -->
        <div class="grid grid-cols-5 gap-4 mb-3">
          <div v-for="([status, count, icon, color], index) in caseStatusCountsArray.slice(0, 5)"
              :key="status" 
              class="flex flex-col justify-center items-center text-center hover:scale-110 transition-transform">
            <!-- Icon with dynamic color -->
            <i :class="`fa fa-${icon} ${color} text-2xl mb-2`"></i>
            <h2 class="text-base font-medium">{{ status }}</h2>
            <!-- Transition for number with appear attribute -->
            <transition name="number-transition" appear>
              <p class="text-lg font-bold" 
                 :class="{
                   'text-red-500': count === 0,
                   'text-green-500': count > 0
                 }">{{ count }}</p>
            </transition>
          </div>
        </div>

        <!-- Second Row -->
        <div class="mt-6 grid grid-cols-4 justify-center mx-auto">
          <div v-for="([status, count, icon, color]) in caseStatusCountsArray.slice(5)" 
              :key="status" 
              class="flex flex-col justify-center items-center text-center hover:scale-110 transition-transform">
            <!-- Icon with dynamic color -->
            <i :class="`fa fa-${icon} ${color} text-2xl mb-2`"></i>
            <h2 class="text-base font-medium">{{ status }}</h2>

            <!-- Transition for number with appear attribute -->
            <transition name="number-transition" appear>
              <p class="text-lg font-bold" 
                 :class="{
                   'text-red-500': count === 0,
                   'text-green-500': count > 0
                 }">{{ count }}</p>
            </transition>
          </div>
        </div>
      </div>
    </div>

    <!-- Responsive Grid for the charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 p-14">
      <!-- Child Status Pie Chart -->
      <div class="bg-white p-4 rounded-lg shadow-md">
        <div class="relative h-64">
          <Pie 
            :data="childStatusData" 
            :options="{
              ...chartOptions, 
              layout: {
                padding: {
                  bottom: 10  // Adds margin between the chart and the legend
                }
              },
              plugins: { 
                title: { 
                  text: 'Child Status Distribution', 
                  display: true, 
                  font: { size: 15 }  // Title font size
                },
                legend: { 
                  position: 'bottom',  // Legend is placed at the bottom
                  labels: { 
                    font: { size: 14 }, // Font size for legend labels
                    boxWidth: 20,  // Width of the legend box
                    padding: 20    // Increase the space between legend items
                  }
                }
              },
              responsive: true,  // Ensures responsiveness
            }"
            class="vertical-legend"
          />
        </div>
      </div>

      <!-- Date Admitted Line Chart -->
      <div class="bg-white p-4 rounded-lg shadow-md md:col-span-2 lg:col-span-1">
        <div class="relative h-64">
          <Line :data="dateAdmittedData" :options="{...chartOptions, plugins: { title: { text: 'Admissions by Month', display: true, font: { size: 15 } }}}" />
        </div>
      </div>

      <!-- Age Distribution Histogram with Avg. Age of Clients -->
      <div class="bg-white p-4 rounded-lg shadow-md relative h-80">
        <!-- Flip Container -->
        <div class="flip-container" :class="{ flipped: isFlipped }" @click="toggleFlip">
          <!-- Front Side (Histogram) -->
          <div class="flipper">
            <div class="front">
              <Bar
                :data="ageData"
                :options="{
                  ...chartOptions,
                  plugins: {
                    title: {
                      text: 'Age Distribution',
                      display: true,
                      font: { size: 15 }
                    },
                    tooltip: {
                      enabled: true
                    }
                  }
                }"
              />
            </div>

            <!-- Back Side (Avg Age) -->
            <div class="back mt-24 p-4 rounded-lg flex flex-col items-center w-full h-full">
              <div class="flex flex-col items-center justify-center h-full">
                <i class="fa fa-user-clock text-2xl mb-2"></i> <!-- FontAwesome icon for age -->
                <h2 class="text-lg font-semibold text-center">Average Age of Clients</h2>
                <transition name="number-transition" appear>
                  <p class="text-xl text-red-600 font-bold text-center">{{ averageAge }} </p>
                </transition>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Offense Committed Pareto Chart -->
    <div class="bg-white p-4 rounded-lg shadow">
      <div class="relative h-64">
        <Bar 
          :data="paretoData" 
          :options="{
            responsive: true,
            scales: {
              y: {
                beginAtZero: true,
                title: {
                  display: true,
                  text: 'Offenses Count'
                }
              },
              y1: {
                beginAtZero: true,
                position: 'right',
                grid: {
                  drawOnChartArea: false
                },
                title: {
                  display: true,
                  text: 'Cumulative Percentage'
                }
              }
            },
            plugins: {
              title: { 
                display: true, 
                text: 'Offense Committed', 
                font: { size: 15 } 
              },
              legend: {
                display: true,
                position: 'top'
              }
            }
          }"
        />
      </div>
    </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Pie, Line, Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, LineElement, PointElement, BarElement } from 'chart.js';
import axios from 'axios';
import { ref, computed, onMounted } from 'vue';
import '@fortawesome/fontawesome-free/css/all.css';

// Register necessary chart components
ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, LineElement, PointElement, BarElement);

const clients = ref([]);
const isFlipped = ref(false); // Track flip state

// Function to toggle flip state
const toggleFlip = () => {
  isFlipped.value = !isFlipped.value;
};

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

// Calculate average age
const averageAge = computed(() => {
  const totalAge = clients.value.reduce((sum, client) => sum + client.age, 0);
  return (totalAge / clients.value.length).toFixed(1);
});

// Total number of clients
const totalClients = computed(() => clients.value.length);

// Calculate case status counts with icons and colors
const caseStatusCountsArray = computed(() => {
  const statuses = [
    { label: 'On trial', icon: 'gavel', color: 'text-blue-500' },
    { label: 'Suspended sentence', icon: 'pause-circle', color: 'text-yellow-500' },
    { label: 'Acquitted', icon: 'check-circle', color: 'text-green-500' },
    { label: 'Dismissed', icon: 'times-circle', color: 'text-red-500' },
    { label: 'Rehabilitation', icon: 'heart', color: 'text-pink-500' },
    { label: 'Provisionally Dismissed', icon: 'clock', color: 'text-gray-500' },
    { label: 'Diversion', icon: 'random', color: 'text-indigo-500' },
    { label: 'Disposition Measure', icon: 'balance-scale-right', color: 'text-purple-500' },
    { label: 'Child-at-risk (CAR)', icon: 'exclamation-circle', color: 'text-orange-500' },
  ];

  const counts = statuses.reduce((acc, status) => {
    acc[status.label] = clients.value.filter(client => client.case_status === status.label).length;
    return acc;
  }, {});

  // Convert the counts object into an array of [status, count, icon, color]
  return statuses.map(status => [status.label, counts[status.label] || 0, status.icon, status.color]);
});

// Case Status Data for Pie Chart
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

// Child Status Data for Pie Chart
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

// Date Admitted Data for Line Chart
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

// Age Data for Histogram
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
        backgroundColor: '#87CEEB', // Sky blue color for histogram bars
        borderColor: '#388E3C',     // Darker green for border
        borderWidth: 1,
        data: Object.values(ageCounts),
      },
    ],
  };
});


// Offense Committed Data for Pareto Chart with DSWD colors
const paretoData = computed(() => {
  const offenseCounts = clients.value.reduce((acc, client) => {
    acc[client.offense_committed] = (acc[client.offense_committed] || 0) + 1;
    return acc;
  }, {});

  const sortedOffenses = Object.entries(offenseCounts).sort((a, b) => b[1] - a[1]);

  // Calculate cumulative percentage
  const totalOffenses = sortedOffenses.reduce((sum, [, count]) => sum + count, 0);
  let cumulative = 0;
  const cumulativePercentages = sortedOffenses.map(([, count]) => {
    cumulative += count;
    return (cumulative / totalOffenses) * 100;
  });

  return {
    labels: sortedOffenses.map(([offense]) => offense),
    datasets: [
      {
        label: 'Offenses Count',
        data: sortedOffenses.map(([, count]) => count),
        backgroundColor: '#4CAF50',
        yAxisID: 'y',
        type: 'bar',
      },
      {
        label: 'Cumulative Percentage',
        data: cumulativePercentages,
        backgroundColor: '#0000FF', // Blue for line
        borderColor: '#0000FF',
        fill: false,
        yAxisID: 'y1',
        type: 'line',
      }
    ]
  };
});

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
/* Flip animation CSS */
.flip-container {
  perspective: 1000px;
}

.flipper {
  transition: 0.6s;
  transform-style: preserve-3d;
  position: relative;
}

.flipped .flipper {
  transform: rotateY(180deg);
}

.front, .back {
  backface-visibility: hidden;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}

.back {
  transform: rotateY(180deg);
}
</style>
