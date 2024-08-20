<template>
  <div>
    <div v-if="loading" class="text-center py-4">Loading client data...</div>
    <div v-else>
      <!-- Dropdown for selecting a form -->
      <div class="flex flex-col justify-center items-center w-full mb-4">
        <h1 class="mt-2 text-customBlue mb-1 text-lg italic">Select a Form:</h1>
        <div class="relative w-1/4">
          <select 
            v-model="currentTab" 
            class="block w-full py-2 text-md border rounded-lg shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
          >
            <option 
              v-for="(tab, index) in tabs" 
              :key="index" 
              :value="tab"
            >
              {{ tab }}
            </option>
          </select>
        </div>
      </div>

      <!-- Display content based on selected tab -->
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
import { ref } from 'vue';
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
const loading = ref(false);
</script>

<style scoped>
.text-customBlue {
  color: #1c3d5a; /* Adjust this to your custom blue color */
}
</style>
