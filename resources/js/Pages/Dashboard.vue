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


    <div class="mt-1 min-h-screen bg-slate-100"  style="background-image: url('/images/da.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center;">
    <!-- Main Content Wrapper -->
    <div class="-mb-10 flex flex-wrap lg:flex-nowrap p-8 -gap-1">
      <div class="-mt-6 flex flex-col space-y-4 w-1/2">
        <!-- Horizontal Layout for Total Clients and Average Age -->
        <div class="flex justify-between space-x-4 w-full lg:w-9/10">
          <!-- Total Clients -->
          <div class="ml-4 bg-white p-4 rounded-lg shadow-md flex justify-between items-center border-l-4 border-blue-600 w-full lg:w-1/2">
            <div>
              <h3 class="text-xs font-medium text-blue-600 uppercase">No. of CICL</h3>
              <span class="text-2xl font-bold text-gray-800">{{ totalClients }}</span>
            </div>
            <i class="fa fa-users text-4xl text-blue-600"></i>
          </div>

          <!-- Average Age -->
          <div class="bg-white -mr-2 p-4 rounded-lg shadow-md flex justify-between items-center border-l-4 border-blue-900 w-full lg:w-1/2">
            <div>
              <h3 class="text-xs font-medium text-blue-900 uppercase">Average Age of CICL</h3>
              <span class="text-2xl font-bold text-gray-800">{{ averageAge }}</span>
            </div>
            <i class="fa fa-user-clock text-4xl text-blue-900"></i>
          </div>
        </div>
        
     <!-- Line Chart for Admissions by Month (Full Width) -->
          <!-- Line Chart for Admissions by Month (Full Width) -->
        <div class="flex justify-center">
          <div class="bg-white ml-4 p-4 rounded-lg shadow-md w-full">
            <h2 class="-mt-4 -ml-4 mb-4 pb-2 -mr-4 border border-gray-300 pt-2 text-sm font-semibold text-gray-700 bg-slate-200 px-6 py-1 rounded-sm flex items-center justify-between">
              Admission by Month
             
            </h2>

            <div class="flex justify-center">
              <div class="-mt-12 relative h-80 w-full max-w-full">
                <Line 
                  :data="filteredDateAdmittedData"
                  :options="{ plugins: { title: {display: true, font: { size: 15 } }}}"
                />
              </div>
            </div>
          </div>
        </div>
      </div>

    <!-- Doughnut Chart (Case Status Overview) -->
    <div class="-mt-6 -mr-2 ml-4 bg-gray-50 border-4 border-gray-50 shadow-md p-4 w-full lg:w-1/2 h-auto">
    <h2 class="-mt-5 -ml-5 mb-12 pb-2 -mr-5 border border-gray-300 pt-2 text-sm font-semibold text-gray-700 bg-slate-200 px-6 py-1 rounded-sm">
      Case Status Overview
    </h2>
    
    <!-- Adjust the height and width of the container -->
    <div class="relative -mt-20 w-full h-[300px] lg:h-[390px]">  
      <Doughnut 
        :data="caseStatusData"
        :options="chartOptions"
      />

      <!-- Suspended Sentence Total -->
      <h3 class="-mt-4 font-semibold text-gray-700"> Total Suspended Sentence</h3>
      <p class="text-xl text-gray-900">
        {{ suspendedSentenceTotal }} Case{{ suspendedSentenceTotal > 1 ? 's' : '' }}
      </p>
    </div>
  </div>
    </div>

  

    <!-- Main Body Content (Offense Committed, Age Distribution, Child Status) -->
    <div class="flex flex-wrap lg:flex-nowrap gap-4 p-8">
      

  <!-- Child Status Distribution Pie Chart -->
<div class="ml-4 bg-white p-4 rounded-lg shadow-md w-full lg:w-1/3">
  <h2 class="-mt-4 -ml-4 -mr-4 border border-gray-300 pt-2 text-sm font-semibold text-gray-700 bg-slate-200 px-6 py-1 rounded-sm">
          Child Status Distribution
        </h2>   <div class="mt-2 flex justify-center relative h-[330px] mb-12 ">
    <Pie 
      :data="filteredChildStatusData"
      :options="{
        plugins: {
          title: { display: true, font: { size: 0 } },
          legend: {
            position: 'bottom',
            labels: { font: { size: 13 }, margin: 20, boxWidth: 15, padding: 10 }
          }
        },
        responsive: true,
        onClick: (e, activeEls) => {
          if (activeEls.length > 0) {
            const index = activeEls[0].index;
            const status = filteredChildStatusData.labels[index];
            openChildStatusModal(status); // Trigger modal
          }
        }
      }"
    />
  </div>
</div>
<!-- Offense Committed Table -->
<div class="bg-white p-6 rounded-lg shadow-md w-full lg:w-2/5">
  <h2 class="-mt-6 -ml-6 mb-4 -mr-6 border border-gray-300 pt-2 text-sm font-semibold text-gray-700 bg-slate-200 px-6 py-1 rounded-sm">
    Offense Committed
  </h2>
  <div class="overflow-hidden rounded-lg shadow">
    <!-- Set fixed height and enable scrolling -->
    <div class="max-h-96 overflow-y-auto hide-scrollbar"> <!-- Adjusted height to max-h-80 -->
      <table class="min-w-full leading-normal table-auto relative"> <!-- Add 'relative' for positioning -->
        <thead class="bg-white shadow-md text-black uppercase text-xs font-semibold sticky top-0 z-10"> <!-- Add sticky and z-index -->
          <tr>
            <th class="px-5 py-3 border-b-2 bg-transparent border-gray-200 text-left w-3/5">Offense</th> <!-- Adjusted width for offense -->
            <th class="px-5 py-3 border-b-2 bg-transparent  border-gray-200 text-center w-2/5">Count</th> <!-- Adjusted width for count -->
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr v-for="([offense, count], index) in filteredOffenses" :key="index"
              class="hover:bg-teal-50 transition duration-150 ease-in-out" 
              @click="openOffenseModal(offense)">
            <td class="px-5 py-4 text-sm font-medium text-gray-900">{{ offense }}</td>
            <td class="px-5 py-4 text-sm text-center font-semibold text-gray-700">{{ count }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>



<!-- Modal for showing clients who committed the selected offense -->
<div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center z-50">
  <div class="relative bg-white p-6 rounded-lg shadow-lg w-[32rem]">
    <!-- Modal Header -->
    <div class="flex justify-between items-center">
      <h2 class="text-lg font-semibold">{{ selectedOffense }}</h2>
      <button @click="closeOffenseModal" class="text-gray-500 hover:text-red-600">
        <i class="fas fa-times text-xl"></i>
      </button>
    </div>

    <!-- Total Clients Count -->
    <p class="text-sm text-gray-500 mt-2">
      <span class="font-medium text-gray-800">Total Clients:</span> {{ clientsByOffense.length }}
    </p>

    <!-- Scrollable Table -->
    <div class="overflow-y-auto max-h-80 mt-4">
      <table class="table-auto w-full text-left">
        <thead>
          <tr class="border-b text-gray-700">
            <th class="text-sm font-semibold py-2">Client Name</th>
            <th class="text-sm font-semibold py-2">Date Admitted</th>
          </tr>
        </thead>
        <tbody>
          <tr 
            v-for="client in clientsByOffense" 
            :key="client.id" 
            class="hover:bg-gray-50 border-b text-gray-800"
          >
            <td class="py-2 text-sm">{{ client.name }}</td>
            <td class="py-2 text-sm">{{ client.date_admitted }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end mt-4">
      <button 
        @click="downloadClientsByOffense" 
        class="px-4 py-2 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 text-white rounded hover:opacity-90 transition-opacity"
      >
        Download
      </button>
    </div>
  </div>
</div>


<!-- Modal for showing clients who belong to the selected child status -->
<div v-if="isChildStatusModalOpen" class="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center z-50">
  <div class="relative bg-white p-6 rounded-lg shadow-lg w-[32rem]">
    <!-- Modal Header -->
    <div class="flex justify-between items-center">
      <h2 class="text-lg font-semibold">{{ selectedChildStatus }}</h2>
      <button @click="closeChildStatusModal" class="text-gray-500 hover:text-red-600">
        <i class="fas fa-times text-xl"></i>
      </button>
    </div>

    <!-- Total Clients Count -->
    <p class="text-sm text-gray-500 mt-2">
      <span class="font-medium text-gray-800">Total Clients:</span> {{ clientsByChildStatus.length }}
    </p>

    <!-- Scrollable Table -->
    <div class="overflow-y-auto max-h-80 mt-4">
      <table class="table-auto w-full text-left">
        <thead>
          <tr class="border-b text-gray-700">
            <th class="text-sm font-semibold py-2">Client Name</th>
            <th class="text-sm font-semibold py-2">Date Admitted</th>
          </tr>
        </thead>
        <tbody>
          <tr 
            v-for="client in clientsByChildStatus" 
            :key="client.id" 
            class="hover:bg-gray-50 border-b text-gray-800"
          >
            <td class="py-2 text-sm">{{ client.name }}</td>
            <td class="py-2 text-sm">{{ client.date_admitted }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end mt-4">
      <button 
        @click="downloadClientsByChildStatus" 
        class="px-4 py-2 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 text-white rounded hover:opacity-90 transition-opacity"
      >
        Download
      </button>
    </div>
  </div>
</div>



<!-- Modal for showing clients who belong to the selected case status -->
<div v-if="isCaseStatusModalOpen" class="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center z-50">
  <div class="relative bg-white p-6 rounded-lg shadow-lg w-[32rem]">
    <!-- Modal Header -->
    <div class="flex justify-between items-center">
      <h2 class="text-lg font-semibold">{{ selectedCaseStatus }}</h2>
      <button @click="closeCaseStatusModal" class="text-gray-500 hover:text-red-600">
        <i class="fas fa-times text-xl"></i>
      </button>
    </div>

    <!-- Total Clients Count -->
    <p class="text-sm text-gray-500 mt-2">
      <span class="font-medium text-gray-800">Total Clients:</span> {{ clientsByCaseStatus.length }}
    </p>

    <!-- Table -->
    <div class="overflow-y-auto max-h-80 mt-4">
      <table class="table-auto w-full text-left">
        <thead>
          <tr class="border-b text-gray-700">
            <th class="text-sm font-semibold py-2">Client Name</th>
            <th class="text-sm font-semibold py-2">Date Admitted</th>
          </tr>
        </thead>
        <tbody>
          <tr 
            v-for="client in clientsByCaseStatus" 
            :key="client.id" 
            class="hover:bg-gray-50 border-b text-gray-800"
          >
            <td class="py-2 text-sm">{{ client.name }}</td>
            <td class="py-2 text-sm">{{ client.date_admitted }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end mt-4">
      <button 
        @click="downloadClientsByCaseStatus" 
        class="px-4 py-2 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 text-white rounded hover:opacity-90 transition-opacity"
      >
        Download
      </button>
    </div>
  </div>
</div>

<!-- Modal for showing clients within the selected age range -->
<div v-if="isAgeDistributionModalOpen" class="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center z-50">
  <div class="relative bg-white p-6 rounded-lg shadow-lg w-[32rem]">
    <!-- Modal Header -->
    <div class="flex justify-between items-center">
      <h2 class="text-lg font-semibold">Age: {{ selectedAge }}</h2>
      <button @click="closeAgeDistributionModal" class="text-gray-500 hover:text-red-600">
        <i class="fas fa-times text-xl"></i>
      </button>
    </div>

    <!-- Total Clients Count -->
    <p class="text-sm text-gray-500 mt-2">
      <span class="font-medium text-gray-800">Total Clients:</span> {{ clientsByAge.length }}
    </p>

    <!-- Scrollable Table -->
    <div class="overflow-y-auto max-h-80 mt-4">
      <table class="table-auto w-full text-left">
        <thead>
          <tr class="border-b text-gray-700">
            <th class="text-sm font-semibold py-2">Client Name</th>
            <th class="text-sm font-semibold py-2">Date Admitted</th>
          </tr>
        </thead>
        <tbody>
          <tr 
            v-for="client in clientsByAge" 
            :key="client.id" 
            class="hover:bg-gray-50 border-b text-gray-800"
          >
            <td class="py-2 text-sm">{{ client.name }}</td>
            <td class="py-2 text-sm">{{ client.date_admitted }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end mt-4">
      <button 
        @click="downloadClientsByAge" 
        class="px-4 py-2 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 text-white rounded hover:opacity-90 transition-opacity"
      >
        Download
      </button>
    </div>
  </div>
</div>





<!-- Age Distribution Bar Chart -->
<div class="-mr-4 bg-white p-4 rounded-lg shadow-md w-full lg:w-1/3">
  <h2 class="-mt-4 -ml-4 -mb-4 -mr-4 border border-gray-300 pt-2 text-sm font-semibold text-gray-700 bg-slate-200 px-6 py-1 rounded-sm">
          Age Distribution
        </h2> 
  <div class="-mb-12 relative w-full" style="height: 425px;">
    <Bar 
      :data="filteredAgeData"
      :options="{
        maintainAspectRatio: false, // Allow chart to expand
        plugins: {
          title: { display: true, font: { size: 15 } },
          tooltip: { enabled: true }
        },
        onClick: (e, activeEls) => {
          if (activeEls.length > 0) {
            const index = activeEls[0].index;
            const age = filteredAgeData.labels[index]; // Get the clicked age group
            openAgeDistributionModal(age); // Trigger modal
          }
        }
      }"
      height="350"
    />
  </div>
</div>
     

    </div>

 <!-- Sidebar (Dashboard Filters) -->
<div :class="{ 'translate-x-full': !isSidebarOpen }" class="fixed right-0 top-0 w-64 h-full bg-white shadow-lg transition-transform duration-300 ease-in-out z-50">
  <!-- Sidebar Header with Collapse Button -->
  <div class="p-4 flex justify-between items-center bg-slate-100">
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
          <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"></div>
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
          <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"></div>
        </div>
      </div>
    </div>
     <!-- Button to Download All Data -->
  <div class="flex justify-end w-full p-6 ">
    <button @click="downloadAllData" class="px-4 py-2 bg-[conic-gradient(at_bottom_right,_var(--tw-gradient-stops))] from-blue-700 via-blue-800 to-gray-900 text-white rounded-lg shadow-md">
      Download All Data (CSV)
    </button>
  </div>
  </div>
</div>



    <!-- Overlay when Sidebar is Open -->
    <div v-if="isSidebarOpen" @click="toggleSidebar" class="fixed inset-0 bg-black bg-opacity-70 z-40"></div>

    <!-- Toggle Sidebar Button -->
    <button v-if="!isSidebarOpen" @click="toggleSidebar" class="mt-9 fixed right-0 top-4 z-50 bg-blue-900 p-2 rounded-l-md text-gray-200 shadow-md hover:bg-blue-950 flex items-center">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5 mr-2">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        <circle cx="8" cy="6" r="2" fill="currentColor"></circle>
        <circle cx="16" cy="12" r="2" fill="currentColor"></circle>
        <circle cx="8" cy="18" r="2" fill="currentColor"></circle>
    </svg>
    Filter
    
</button>

</div>

  </AppLayout>
</template>

<script setup>

import { ref, computed, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Pie, Line, Bar, Doughnut } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, LineElement, PointElement, BarElement } from 'chart.js';
import axios from 'axios';
import '@fortawesome/fontawesome-free/css/all.css';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import * as XLSX from 'xlsx';

ChartJS.register(ChartDataLabels);

// Sidebar and modal open state
const isSidebarOpen = ref(false);
const isModalOpen = ref(false); // Modal visibility state
const selectedOffense = ref(''); // The offense that was clicked
const clientsByOffense = ref([]); // Clients who committed the selected offense
const isChildStatusModalOpen = ref(false); // Child Status modal visibility state
const selectedChildStatus = ref(''); // The selected child status
const clientsByChildStatus = ref([]); // Clients who belong to the selected child status
const isCaseStatusModalOpen = ref(false); // Case Status modal visibility state
const selectedCaseStatus = ref(''); // The selected case status
const clientsByCaseStatus = ref([]); // Clients who belong to the selected case status
const isAgeDistributionModalOpen = ref(false); // Age Distribution modal visibility state
const selectedAge = ref(''); // The selected age
const clientsByAge = ref([]); // Clients who belong to the selected age group



const downloadAllData = () => {
  if (!clients.value.length) return;

  // Prepare the data and ensure 'Date Admitted' is in string format (text)
  const data = clients.value.map(client => ({
    Name: client.name,
    Age: String(client.age),  // Convert Age to string so it is treated as text
    'Case Status': client.case_status,
    'Child Status': client.child_status,
    'Date Admitted': client.date_admitted,  // Ensure 'Date Admitted' is in string format for consistency
    'Offense Committed': client.offense_committed
  }));

  // Add the header row
  const header = ['Name', 'Age', 'Case Status', 'Child Status', 'Date Admitted', 'Offense Committed'];

  // Create a worksheet from the data
  const ws = XLSX.utils.json_to_sheet(data, {
    header: header,
    dateNF: 'yyyy-mm-dd',  // Format dates as 'yyyy-mm-dd'
  });

  // Calculate column widths based on both header and data content
  const columnWidths = header.map((column, index) => {
    let maxLength = column.length;  // Start by considering the length of the header

    // Also consider the data in the column
    data.forEach(client => {
      const cellValue = String(client[Object.keys(client)[index]]); // Convert value to string
      maxLength = Math.max(maxLength, cellValue.length); // Update the max length if the current value is longer
    });

    return maxLength; // Return the max length for this column
  });

  // Apply column widths (adjust 'wch' for character width)
  ws['!cols'] = columnWidths.map(width => ({ wch: width }));

  // Set column alignment: Align all columns to the left
  Object.keys(ws).forEach((key) => {
    if (key[0] !== '!') { // Skip special properties like '!cols'
      if (!ws[key].s) ws[key].s = {}; // Create style object if not already present

      // Set alignment for all columns to left
      ws[key].s.alignment = { vertical: 'center', horizontal: 'left' };
    }
  });

  // Create a new workbook and append the sheet
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, 'Clients');

  // Write the workbook to a file and trigger the download
  XLSX.writeFile(wb, 'dashboard_all_clients_data.xlsx');
};





const downloadClientsByChildStatus = () => {
  if (!clientsByChildStatus.value.length) return;

  // Ensure the 'Date Admitted' field is treated as a string for consistency in Excel
  const data = clientsByChildStatus.value.map(client => ({
    Name: client.name,
    'Date Admitted': client.date_admitted ? new Date(client.date_admitted).toISOString().split('T')[0] : '',  // Ensure date format
    'Child Status': client.child_status
  }));

  // Add the header row
  const header = ['Name', 'Date Admitted', 'Child Status'];

  // Create a worksheet from the data
  const ws = XLSX.utils.json_to_sheet(data, {
    header: header,
    dateNF: 'yyyy-mm-dd',  // Ensure 'Date Admitted' is formatted as 'yyyy-mm-dd'
  });

  // Calculate column widths based on both header and data content
  const columnWidths = header.map((column, index) => {
    let maxLength = column.length;  // Start by considering the length of the header

    // Also consider the data in the column
    data.forEach(client => {
      const cellValue = String(client[header[index]]); // Get the value based on header
      maxLength = Math.max(maxLength, cellValue.length); // Update the max length if the current value is longer
    });

    return maxLength; // Return the max length for this column
  });

  // Apply column widths (adjust 'wch' for character width)
  ws['!cols'] = columnWidths.map(width => ({ wch: width }));

  // Set column alignment: Align all columns to the left
  Object.keys(ws).forEach((key) => {
    if (key[0] !== '!') { // Skip special properties like '!cols'
      if (!ws[key].s) ws[key].s = {}; // Create style object if not already present

      // Set alignment for all columns to left
      ws[key].s.alignment = { vertical: 'center', horizontal: 'left' };
    }
  });

  // Ensure that `selectedChildStatus.value` is defined before using it
  const fileName = selectedChildStatus.value ? `clients_child_status_${selectedChildStatus.value}.xlsx` : 'clients_child_status.xlsx';
  
  // Truncate sheet name to 31 characters to avoid error
  const sheetName = `Clients_${selectedChildStatus.value || 'All'}`.slice(0, 31);

  // Create a new workbook and append the sheet
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, sheetName);

  // Write the workbook to a file and trigger the download
  XLSX.writeFile(wb, fileName);
};


// Method to download the clients by age data as a CSV file


const downloadClientsByOffense = () => {
  if (!clientsByOffense.value.length) return;

  // Prepare the data, ensuring 'Date Admitted' is treated as a string for consistent formatting
  const data = clientsByOffense.value.map(client => ({
    Name: client.name,
    'Date Admitted': client.date_admitted ? new Date(client.date_admitted).toISOString().split('T')[0] : '',  // Ensure date format
    Offense: client.offense_committed,  // Offense information
  }));

  // Add the header row
  const header = ['Name', 'Date Admitted', 'Offense'];

  // Create a worksheet from the data
  const ws = XLSX.utils.json_to_sheet(data, {
    header: header,
    dateNF: 'yyyy-mm-dd',  // Ensure 'Date Admitted' is formatted as 'yyyy-mm-dd'
  });

  // Calculate column widths based on both header and data content
  const columnWidths = header.map((column, index) => {
    let maxLength = column.length;  // Start by considering the length of the header

    // Also consider the data in the column
    data.forEach(client => {
      const cellValue = String(client[header[index]]); // Get the value based on header
      maxLength = Math.max(maxLength, cellValue.length); // Update the max length if the current value is longer
    });

    return maxLength; // Return the max length for this column
  });

  // Apply column widths (adjust 'wch' for character width)
  ws['!cols'] = columnWidths.map(width => ({ wch: width }));

  // Set column alignment: Align all columns to the left
  Object.keys(ws).forEach((key) => {
    if (key[0] !== '!') { // Skip special properties like '!cols'
      if (!ws[key].s) ws[key].s = {}; // Create style object if not already present

      // Set alignment for all columns to left
      ws[key].s.alignment = { vertical: 'center', horizontal: 'left' };
    }
  });

  // Ensure that `selectedOffense.value` is defined before using it
  const fileName = selectedOffense.value ? `clients_offense_${selectedOffense.value}.xlsx` : 'clients_offense.xlsx';

  // Truncate sheet name to 31 characters to avoid error
  const sheetName = `Clients_Offense_${selectedOffense.value || 'All'}`.slice(0, 31);

  // Create a new workbook and append the sheet
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, sheetName);

  // Write the workbook to a file and trigger the download
  XLSX.writeFile(wb, fileName);
};



const downloadClientsByCaseStatus = () => {
  if (!clientsByCaseStatus.value.length) return;

  // Prepare the data, ensuring 'Date Admitted' is treated as a string for consistent formatting
  const data = clientsByCaseStatus.value.map(client => ({
    Name: client.name,
    'Date Admitted': client.date_admitted ? new Date(client.date_admitted).toISOString().split('T')[0] : '',  // Ensure date format
    'Case Status': client.case_status,  // Case Status information
  }));

  // Add the header row
  const header = ['Name', 'Date Admitted', 'Case Status'];

  // Create a worksheet from the data
  const ws = XLSX.utils.json_to_sheet(data, {
    header: header,
    dateNF: 'yyyy-mm-dd',  // Ensure 'Date Admitted' is formatted as 'yyyy-mm-dd'
  });

  // Calculate column widths based on both header and data content
  const columnWidths = header.map((column, index) => {
    let maxLength = column.length;  // Start by considering the length of the header

    // Also consider the data in the column
    data.forEach(client => {
      const cellValue = String(client[header[index]]); // Get the value based on header
      maxLength = Math.max(maxLength, cellValue.length); // Update the max length if the current value is longer
    });

    return maxLength; // Return the max length for this column
  });

  // Apply column widths (adjust 'wch' for character width)
  ws['!cols'] = columnWidths.map(width => ({ wch: width }));

  // Set column alignment: Align all columns to the left
  Object.keys(ws).forEach((key) => {
    if (key[0] !== '!') { // Skip special properties like '!cols'
      if (!ws[key].s) ws[key].s = {}; // Create style object if not already present

      // Set alignment for all columns to left
      ws[key].s.alignment = { vertical: 'center', horizontal: 'left' };
    }
  });

  // Ensure that `selectedCaseStatus.value` is defined before using it
  const fileName = selectedCaseStatus.value ? `clients_case_status_${selectedCaseStatus.value}.xlsx` : 'clients_case_status.xlsx';

  // Truncate sheet name to 31 characters to avoid error
  const sheetName = `Clients_Case_${selectedCaseStatus.value || 'All'}`.slice(0, 31);

  // Create a new workbook and append the sheet
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, sheetName);

  // Write the workbook to a file and trigger the download
  XLSX.writeFile(wb, fileName);
};




const downloadClientsByAge = () => {
  if (!clientsByAge.value.length) return;

  // Prepare the data, ensuring 'Date Admitted' is treated as a string for consistent formatting
  const data = clientsByAge.value.map(client => ({
    Name: client.name,
    'Age': client.age,
    'Date Admitted': client.date_admitted ? new Date(client.date_admitted).toISOString().split('T')[0] : '',  // Ensure date format
  }));

  // Add the header row
  const header = ['Name', 'Age', 'Date Admitted'];

  // Create a worksheet from the data
  const ws = XLSX.utils.json_to_sheet(data, {
    header: header,
    dateNF: 'yyyy-mm-dd',  // Ensure 'Date Admitted' is formatted as 'yyyy-mm-dd'
  });

  // Calculate column widths based on both header and data content
  const columnWidths = header.map((column, index) => {
    let maxLength = column.length;  // Start by considering the length of the header

    // Also consider the data in the column
    data.forEach(client => {
      const cellValue = String(client[header[index]]); // Get the value based on header
      maxLength = Math.max(maxLength, cellValue.length); // Update the max length if the current value is longer
    });

    return maxLength; // Return the max length for this column
  });

  // Apply column widths (adjust 'wch' for character width)
  ws['!cols'] = columnWidths.map(width => ({ wch: width }));

  // Set column alignment: Align all columns to the left
  Object.keys(ws).forEach((key) => {
    if (key[0] !== '!') { // Skip special properties like '!cols'
      if (!ws[key].s) ws[key].s = {}; // Create style object if not already present

      // Set alignment for all columns to left
      ws[key].s.alignment = { vertical: 'center', horizontal: 'left' };
    }
  });

  // Ensure that `selectedAge.value` is defined before using it
  const fileName = selectedAge.value ? `clients_age_${selectedAge.value}.xlsx` : 'clients_age.xlsx';

  // Truncate sheet name to 31 characters to avoid error
  const sheetName = `Clients_Age_${selectedAge.value || 'All'}`.slice(0, 31);

  // Create a new workbook and append the sheet
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, sheetName);

  // Write the workbook to a file and trigger the download
  XLSX.writeFile(wb, fileName);
};



// Method to toggle sidebar
const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

const openAgeDistributionModal = (age) => {
  selectedAge.value = age;
  clientsByAge.value = clients.value.filter(client => {
    const admittedDate = new Date(client.date_admitted);
    const clientMonth = admittedDate.getMonth() + 1; // Month is 0-indexed
    const clientYear = admittedDate.getFullYear();

    // Check if client matches age, year, and month filters
    const matchesFilter =
      (!selectedYear.value || selectedYear.value == clientYear) &&
      (!selectedMonth.value || selectedMonth.value == clientMonth) &&
      client.age == age;

    return matchesFilter;
  });

  isAgeDistributionModalOpen.value = true;
};

// Method to close the age distribution modal
const closeAgeDistributionModal = () => {
  isAgeDistributionModalOpen.value = false;
};

const openCaseStatusModal = (status) => {
  selectedCaseStatus.value = status;
  clientsByCaseStatus.value = clients.value.filter(client => {
    const admittedDate = new Date(client.date_admitted);
    const clientMonth = admittedDate.getMonth() + 1; // Month is 0-indexed
    const clientYear = admittedDate.getFullYear();

    // Check if client matches case status, year, and month filters
    const matchesFilter =
      (!selectedYear.value || selectedYear.value == clientYear) &&
      (!selectedMonth.value || selectedMonth.value == clientMonth) &&
      client.case_status === status;

    return matchesFilter;
  });

  isCaseStatusModalOpen.value = true;
};

// Method to close the case status modal
const closeCaseStatusModal = () => {
  isCaseStatusModalOpen.value = false;
};
// Method to open the offense modal and get clients who committed that offense
const openOffenseModal = (offense) => {
  selectedOffense.value = offense;
  clientsByOffense.value = clients.value.filter(client => {
    const admittedDate = new Date(client.date_admitted);
    const clientMonth = admittedDate.getMonth() + 1; // Month is 0-indexed
    const clientYear = admittedDate.getFullYear();

    // Check if client matches offense, year, and month filters
    const matchesFilter =
      (!selectedYear.value || selectedYear.value == clientYear) &&
      (!selectedMonth.value || selectedMonth.value == clientMonth) &&
      client.offense_committed === offense;

    return matchesFilter;
  });

  isModalOpen.value = true;
};
// Method to close the offense modal
const closeOffenseModal = () => {
  isModalOpen.value = false;
};

const openChildStatusModal = (status) => {
  selectedChildStatus.value = status;
  clientsByChildStatus.value = clients.value.filter(client => {
    const admittedDate = new Date(client.date_admitted);
    const clientMonth = admittedDate.getMonth() + 1; // Month is 0-indexed
    const clientYear = admittedDate.getFullYear();

    // Check if client matches child status, year, and month filters
    const matchesFilter =
      (!selectedYear.value || selectedYear.value == clientYear) &&
      (!selectedMonth.value || selectedMonth.value == clientMonth) &&
      client.child_status === status;

    return matchesFilter;
  });

  isChildStatusModalOpen.value = true;
};

// Method to close the child status modal
const closeChildStatusModal = () => {
  isChildStatusModalOpen.value = false;
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
      
      // Accurate age calculation
      const dob = new Date(date_of_birth);
      const today = new Date();
      let age = today.getFullYear() - dob.getFullYear();
      const monthDiff = today.getMonth() - dob.getMonth();
      
      // Check if the birthday hasn't happened yet this year
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
        age--;
      }

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
    { label: 'Acquitted/Dismissed', icon: 'check-circle', color: '#4BC0C0' }, // Green
    { label: 'Rehabilitated', icon: 'heart', color: '#9966FF' }, // Purple
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
        backgroundColor: ['#0097A7', '#E53935', '#FBC02D'],
        data: Object.values(childStatusCounts),
      },
    ],
  };
});



// Calculating the total suspended sentence
const suspendedSentenceTotal = computed(() => {
  const diversionIndex = caseStatusData.value.labels.indexOf('Diversion');
  const dispositionMeasureIndex = caseStatusData.value.labels.indexOf('Disposition Measure');

  const diversion = caseStatusData.value.datasets[0].data[diversionIndex] || 0;
  const dispositionMeasure = caseStatusData.value.datasets[0].data[dispositionMeasureIndex] || 0;

  return diversion + dispositionMeasure;
});

// Chart options with afterDatasetsDraw to draw lines
const chartOptions = ref({
  layout: {
    padding: {
      top: 50,
      bottom: 50,
      left: 20,
      right: 20,
    },
  },
  plugins: {
    legend: {
      position: 'right',
      labels: {
        font: { size: 13 },
        boxWidth: 20,
        padding: 15,
      },
    },
    datalabels: {
      color: '#000',
      font: {
        weight: 'bold',
        size: 12,
      },
      formatter: (value, context) => {
        const total = context.chart._metasets[0].total;
        const percentage = ((value / total) * 100).toFixed(1);
        return percentage > 0 ? `${percentage}%` : '';
      },
    },
  },
  responsive: true,
  maintainAspectRatio: false,
  afterDatasetsDraw: function(chart) {
    const ctx = chart.ctx;
    const chartArea = chart.chartArea;
    const meta = chart.getDatasetMeta(0);

    const diversionIndex = chart.data.labels.indexOf('Diversion');
    const dispositionMeasureIndex = chart.data.labels.indexOf('Disposition Measure');

    if (diversionIndex >= 0 && dispositionMeasureIndex >= 0) {
      const diversionPoint = meta.data[diversionIndex].tooltipPosition();
      const dispositionPoint = meta.data[dispositionMeasureIndex].tooltipPosition();

      const centerX = (chartArea.left + chartArea.right) / 2;
      const centerY = chartArea.bottom + 20; // Adjust this for line positioning

      // Draw line from Diversion
      ctx.beginPath();
      ctx.moveTo(diversionPoint.x, diversionPoint.y);
      ctx.lineTo(centerX, centerY);
      ctx.strokeStyle = '#33FF57'; // Green for Diversion
      ctx.lineWidth = 3; // Increase the width of the line
      ctx.stroke();
      ctx.closePath();

      // Draw line from Disposition Measure
      ctx.beginPath();
      ctx.moveTo(dispositionPoint.x, dispositionPoint.y);
      ctx.lineTo(centerX, centerY);
      ctx.strokeStyle = '#FF5733'; // Red for Disposition Measure
      ctx.lineWidth = 3; // Increase the width of the line
      ctx.stroke();
      ctx.closePath();
    }
  },
  onClick: (e, activeEls) => {
    if (activeEls.length > 0) {
      const index = activeEls[0].index;
      const status = caseStatusData.value.labels[index];
      openCaseStatusModal(status); // Placeholder for your modal logic
    }
  },
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
        backgroundColor: '#3949AB',
        borderColor: '#3949AB',     // Darker green for border
        borderWidth: 1,
        data: Object.values(ageCounts),
      },
    ],
  };
});
// Calculate the total number of clients affected by year and month filters
const totalClients = computed(() => {
  return clients.value.filter(client => {
    const admittedDate = new Date(client.date_admitted);
    const clientMonth = admittedDate.getMonth() + 1; // Month is 0-indexed
    const clientYear = admittedDate.getFullYear();

    // Return true if client matches the selected year and month filters
    return (!selectedYear.value || selectedYear.value == clientYear) &&
           (!selectedMonth.value || selectedMonth.value == clientMonth);
  }).length;
});


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

/* Hide scrollbar for WebKit browsers (Chrome, Safari) */
.hide-scrollbar::-webkit-scrollbar {
  display: none; /* Hide scrollbar */
}

/* Hide scrollbar for IE and Edge */
.hide-scrollbar {
  -ms-overflow-style: none; /* IE and Edge */
}

/* Hide scrollbar for Firefox */
.hide-scrollbar {
  scrollbar-width: none; /* Firefox */
}
</style>
