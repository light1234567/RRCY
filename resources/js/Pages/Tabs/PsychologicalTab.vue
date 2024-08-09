<template>
  <div>
    <div class="border-b p-4 bg-gray-100">
      <div class="relative">
        <button @click="toggleDropdown" class="w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-pointer focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
          <span class="block truncate">{{ currentTab }}</span>
          <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l5 5a1 1 0 01-1.414 1.414L10 5.414l-4.293 4.293A1 1 0 014.293 8.293l5-5A1 1 0 0110 3z" clip-rule="evenodd" />
              <path fill-rule="evenodd" d="M10 11a1 1 0 01.707.293l5 5a1 1 0 01-1.414 1.414L10 13.414l-4.293 4.293A1 1 0 014.293 15.293l5-5A1 1 0 0110 11z" clip-rule="evenodd" />
            </svg>
          </span>
        </button>
        <div v-if="isDropdownOpen" class="absolute mt-1 w-full rounded-md bg-white shadow-lg z-10">
          <ul tabindex="-1" role="listbox" class="max-h-56 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
            <li 
              v-for="(tab, index) in tabs" 
              :key="index" 
              @click="selectTab(tab)"
              :class="['cursor-pointer select-none relative py-2 pl-3 pr-9', currentTab === tab ? 'text-white bg-blue-600' : 'text-gray-900']"
              role="option"
            >
              <span :class="['block truncate', currentTab === tab ? 'font-semibold' : 'font-normal']">{{ tab }}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="p-4">
      <div v-if="currentTab === 'Intervention Plan'"><InterventionPlan/></div>
      <div v-if="currentTab === 'IPA Format'"><IPAFORMAT/></div>
      <div v-if="currentTab === 'Progress Notes'"><Progressnotes/></div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import InterventionPlan from '../Display/Psychological/InterventionPlan.vue';
import IPAFORMAT from '../Display/Psychological/IPAFORMAT.vue';
import Progressnotes from '../Display/Psychological/Progressnotes.vue';

const tabs = ref([
  'Intervention Plan',
  'IPA Format',
  'Progress Notes'
]);

const currentTab = ref('Intervention Plan'); // Default tab value
const isDropdownOpen = ref(false);

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value;
};

const selectTab = (tab) => {
  currentTab.value = tab;
  isDropdownOpen.value = false;
};

// Close the dropdown if clicked outside
document.addEventListener('click', (e) => {
  if (!e.target.closest('.relative')) {
    isDropdownOpen.value = false;
  }
});
</script>
