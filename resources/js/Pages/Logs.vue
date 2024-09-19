<template>
    <AppLayout>
      <div class="ml-12">
        <h1 class="text-lg font-bold mb-4">System Logs</h1>
        <table class="table-auto border-collapse border border-gray-300 w-full text-sm">
          <thead>
            <tr>
              <th class="border px-2 py-1 w-1/6">Date/Time</th>
              <th class="border px-2 py-1 w-1/12">Action</th>
              <th class="border px-2 py-1 w-1/12">Model</th>
              <th class="border px-2 py-1 w-2/6">Details</th>
              <th class="border px-2 py-1 w-1/6">Client Name</th>
              <th class="border px-2 py-1 w-1/6">Performed By</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="logs.length === 0">
              <td colspan="6" class="text-center border px-2 py-1">No logs found</td>
            </tr>
            <tr v-for="log in logs" :key="log.id">
              <td class="border px-2 py-1">{{ new Date(log.updated_at).toLocaleString() }}</td>
              <td class="border px-2 py-1">{{ formatAction(log.action) }}</td>
              <td class="border px-2 py-1">{{ log.model }}</td>
              <td class="border px-2 py-1">
                <div :style="{ width: `${log.width}px`, height: `${log.height}px` }" 
                     class="resizable-details" @mousedown="startResizing($event, log)">
                  <ul>
                    <li v-for="(value, key) in parseChanges(log.changes)" :key="key" class="inline-details">
                      <strong>{{ key }}:</strong> {{ value }}
                    </li>
                  </ul>
                  <div class="corner-resizer"></div>
                </div>
              </td>
              <td class="border px-2 py-1">{{ log.client_full_name }}</td>
              <td class="border px-2 py-1">{{ log.updated_by }} <span class="text-gray-500">({{ log.user_role }})</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </AppLayout>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import AppLayout from '@/Layouts/AppLayout.vue';
  import axios from 'axios';
  
  const logs = ref([]);
  const isResizing = ref(false);
  const startX = ref(0), startY = ref(0), initialWidth = ref(0), initialHeight = ref(0);
  const resizingLog = ref(null);
  
  const parseChanges = (changes) => {
    try {
      return JSON.parse(changes);
    } catch (error) {
      return {}; 
    }
  };
  
  const formatAction = (action) => (action === 'created' ? 'Create' : action === 'updated' ? 'Update' : action);
  
  const startResizing = (event, log) => {
    isResizing.value = true;
    resizingLog.value = log;
    startX.value = event.clientX;
    startY.value = event.clientY;
    initialWidth.value = log.width || 300;
    initialHeight.value = log.height || 32;
    document.addEventListener('mousemove', resizeBox);
    document.addEventListener('mouseup', stopResizing);
  };
  
  const resizeBox = (event) => {
    if (!isResizing.value) return;
    resizingLog.value.width = initialWidth.value + (event.clientX - startX.value);
    resizingLog.value.height = initialHeight.value + (event.clientY - startY.value);
  };
  
  const stopResizing = () => {
    isResizing.value = false;
    document.removeEventListener('mousemove', resizeBox);
    document.removeEventListener('mouseup', stopResizing);
  };
  
  const fetchLogs = async () => {
    try {
      const response = await axios.get('/api/logs');
      logs.value = response.data.data.map(log => ({ ...log, width: 300, height: 32 }));
    } catch (error) {
      console.error('Error fetching logs:', error);
    }
  };
  
  onMounted(() => {
    fetchLogs();
  });
  </script>
  
  <style scoped>
  .resizable-details {
    position: relative;
    min-width: 150px;
    min-height: 1.5em;
    overflow: hidden;
    border: 1px solid #ccc;
    white-space: normal;
    padding: 5px;
  }
  
  .corner-resizer {
    position: absolute;
    right: 0;
    bottom: 0;
    width: 12px;
    height: 12px;
    cursor: nwse-resize;
    background: linear-gradient(135deg, transparent 50%, black 50%);
  }
  
  .inline-details {
    display: inline-block;
    margin-right: 0.5rem;
  }
  
  .text-gray-500 {
    color: #6b7280;
  }
  </style>
  