<template>
  <div>
    <div v-if="loading" class="text-center py-4">Loading client data...</div>
    <div v-else>
      <div class="border-b p-4 bg-gray-100">
        <ul class="flex border-b overflow-x-auto whitespace-nowrap">
          <li 
            v-for="(tab, index) in tabs" 
            :key="index" 
            @click="currentTab = tab"
            class="cursor-pointer"
          >
            <a :class="[
              'inline-block py-1 px-2 text-xs font-semibold rounded-t-lg transition-colors duration-300',
              currentTab === tab ? 'bg-white text-blue-700 border-t border-l border-r -mb-px' : 'text-gray-500 hover:text-blue-700'
            ]">
              {{ tab }}
            </a>
          </li>
        </ul>
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
const loading = ref(false); // Set default to false as loading is not used
</script>
