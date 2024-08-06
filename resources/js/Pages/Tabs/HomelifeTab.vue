<template>
  <div>
    <div v-if="loading" class="text-center py-4">Loading client data...</div>
    <div v-else>
      <div class="border-b p-4">
        <label for="tabs" class="block text-gray-700">Select a tab:</label>
        <select
          id="tabs"
          v-model="currentTab"
          class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
        >
          <option 
            v-for="(tab, index) in availableTabs" 
            :key="index" 
            :value="tab"
          >
            {{ tab }}
          </option>
        </select>
      </div>
      <div class="p-4">
        <div v-if="currentTab === 'ISO Anecdotal Form'"><ISOAnecdotalForm/></div>
        <div v-if="currentTab === 'ISO Incident Form'"><ISOIncidentForm/></div>
        <div v-if="currentTab === 'ISO Inventory Form'"><ISOInventoryForm/></div>
        <div v-if="currentTab === 'ISO Session Form'"><ISOSessionForm/></div>
        <div v-if="currentTab === 'ISO Swapping Form'"><ISOSwappingForm/></div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useRoute } from 'vue-router';
import axios from 'axios';
import ISOAnecdotalForm from '../Display/HomeLife/ISOAnecdotalForm.vue';
import ISOIncidentForm from '../Display/HomeLife/ISOIncidentForm.vue';
import ISOInventoryForm from '../Display/HomeLife/ISOInventoryForm.vue';
import ISOSessionForm from '../Display/HomeLife/ISOSessionForm.vue';
import ISOSwappingForm from '../Display/HomeLife/ISOSwappingForm.vue';

const tabs = ref([
  'ISO Anecdotal Form',
  'ISO Incident Form',
  'ISO Inventory Form',
  'ISO Session Form',
  'ISO Swapping Form',
]);

const currentTab = ref('ISO Anecdotal Form'); // Default tab value
const route = useRoute();
const client = ref(null);
const loading = ref(true);
const user = ref({ role: '' }); // Role will be set dynamically

const availableTabs = computed(() => {
  if (user.value.role === 'social services') {
    return tabs.value;
  }
  // Define available tabs based on user role if needed
  return []; // Return an empty array or modify as necessary
});

onMounted(async () => {
  const { props } = usePage();
  user.value.role = props.auth.user.role || ''; // Set user role from Inertia props

  // Fetch client data based on the ID from the route
  try {
    const response = await axios.get(`/api/clients/${route.params.id}`);
    client.value = response.data;
    loading.value = false;
  } catch (error) {
    console.error('Error fetching client data:', error);
    loading.value = false;
  }
});
</script>
<style scoped>
.border-b {
  border-bottom: 1px solid #ddd;
}
.p-4 {
  padding: 1rem;
}
.block {
  display: block;
}
.w-full {
  width: 100%;
}
.mt-1 {
  margin-top: 0.25rem;
}
.border-gray-300 {
  border-color: #d1d5db;
}
.rounded-md {
  border-radius: 0.375rem;
}
.shadow-sm {
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}
.focus\:border-blue-500 {
  border-color: #3b82f6;
}
.focus\:ring {
  outline: none;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
}
.focus\:ring-blue-500 {
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
}
.focus\:ring-opacity-50 {
  --tw-ring-opacity: 0.5;
}
.text-center {
  text-align: center;
}
.py-4 {
  padding-top: 1rem;
  padding-bottom: 1rem;
}
.text-gray-700 {
  color: #4a5568;
}
</style>
