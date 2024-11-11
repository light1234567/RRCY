<template>
  <AppLayout>
    <template #header>
      <div class="flex items-center">
        <div class="ml-5 w-2 h-6 bg-gray-400 mr-3"></div>
        <i class="fa fa-address-card ml-6 text-xl mr-2"></i>
        <h1 class="ml-4 text-lg font-bold text-red-800">System Logs</h1>
      </div>
    </template>
    <div class=" bg-[#f1f5f9] h-full ">
    <!-- Add red background to this container -->
    <div class="pr-80 pl-20 md:pl-32 lg:pl-80 py-8">
      <table class="w-full bg-white border border-gray-300 text-sm shadow-md p-6 mb-4 mt-4 rounded-sm">
        <!-- Table Header with background color -->
        <thead class="bg-[#e2e8f0]">
          <tr>
            <th class="border px-2 py-1 w-1/6">Performed By</th>
            <th class="border px-2 py-1 w-1/12">Action</th>
            <th class="border px-2 py-1 w-1/12">Table</th>
            <th class="border px-2 py-1 w-1/6">Client Name</th>
            <th class="border px-2 py-1 w-1/6">Date/Time</th>
            <th class="border px-2 py-1 w-1/6">Details</th> <!-- Set the width here -->
          </tr>
        </thead>
        <tbody>
          <tr v-if="currentLogs.length === 0">
            <td colspan="6" class="text-center border px-2 py-1">No logs found</td>
          </tr>
          <tr v-for="log in currentLogs" :key="log.id">
            <td class="border text-sm px-2 py-1">{{ log.updated_by }}<br /> <span class="text-gray-500">{{ log.user_role }}</span></td>
            <td class="border px-2 py-1">{{ formatAction(log.action) }}</td>
            <td class="border px-2 py-1">{{ log.model }}</td>
            <td class="border px-2 py-1">{{ log.client_full_name }}</td>
            <td class="border px-2 py-1">{{ new Date(log.updated_at).toLocaleString() }}</td>
            <td class="border px-2 py-1 relative">
              <span class="text-blue-500 cursor-pointer group" @click="openDetailModal(log)">
                <i class="fas fa-info-circle"></i>
                <span class="hover-text ml-2 text-sm font-medium text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                  Show Details
                </span>
              </span>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Pagination Controls -->
      <div class="mt-4 mb-8 flex justify-between items-center space-x-2">
        <div class="ml-4 text-sm font-semibold text-gray-700">
          TOTAL LOGS = <span class="text-gray-700">{{ totalLogsCount }}</span>
        </div>

        <div class="flex items-center space-x-2">
          <button @click="firstPage" :disabled="currentPage === 1" 
                  class="text-xs px-3 py-1 bg-gray-100 text-black rounded-md hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">
            «
          </button>

          <button @click="previousPage" :disabled="currentPage === 1" 
                  class="text-xs px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">
            ‹
          </button>

          <button v-for="page in totalPages" :key="page"
                  @click.stop="goToPage(page)" 
                  :class="{
                    'text-xs px-3 py-1 border-2 border-blue-500 text-blue-500 rounded-md': currentPage === page,
                    'text-xs px-3 py-1 bg-white border-2 border-gray-200 text-black rounded-md hover:bg-gray-100': currentPage !== page
                  }">
            {{ page }}
          </button>

          <button @click="nextPage" :disabled="currentPage === totalPages" 
                  class="text-xs px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">
            ›
          </button>

          <button @click="lastPage" :disabled="currentPage === totalPages" 
                  class="text-xs px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">
            »
          </button>
        </div>
      </div>
    </div>
  </div>
    <!-- Modal for log details -->
    <LogsModal 
      v-if="isModalOpen" 
      :show="isModalOpen" 
      :log="selectedLog" 
      @close="isModalOpen = false"
    />
  </AppLayout>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';
import LogsModal from '@/Components/LogsModal.vue';

const logs = ref([]);
const isModalOpen = ref(false);
const selectedLog = ref(null);
const currentPage = ref(1);
const itemsPerPage = 15;

const formatAction = (action) => (action === 'created' ? 'Create' : action === 'updated' ? 'Update' : action);

const openDetailModal = (log) => {
  selectedLog.value = log;
  isModalOpen.value = true;
};

const fetchLogs = async () => {
  try {
    const response = await axios.get('/api/logs');
    logs.value = response.data.data
      .map(log => ({ ...log, width: 300, height: 32 }))
      .sort((a, b) => new Date(b.updated_at) - new Date(a.updated_at)); // Sort logs by date descending
  } catch (error) {
    console.error('Error fetching logs:', error);
  }
};

onMounted(() => {
  fetchLogs();
});

const totalPages = computed(() => {
  return Math.ceil(logs.value.length / itemsPerPage);
});

const totalLogsCount = computed(() => {
  return logs.value.length;
});

const currentLogs = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return logs.value.slice(start, end);
});

const goToPage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
};

const firstPage = () => {
  currentPage.value = 1;
};

const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const lastPage = () => {
  currentPage.value = totalPages.value;
};
</script>

<style scoped>
.text-gray-500 {
  color: #727272;
}
.text-blue-500 {
  color: rgb(45, 70, 255);
}
.group:hover .hover-text {
  opacity: 1;
}

.hover-text {
  opacity: 0;
  transition: opacity 0.3s ease;
  display: inline-block;
  white-space: nowrap;
}

</style>
