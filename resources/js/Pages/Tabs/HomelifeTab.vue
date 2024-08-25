<template>
  <div class="flex flex-col justify-center items-center min-h-screen">
    <div class="flex flex-col justify-center items-center w-full">
      <!-- Icon button with dropdown menu -->
      <div class="relative">
        <button 
          @click="toggleDropdown" 
          :class="[
            'fixed bottom-6 right-6 flex items-center justify-center w-12 h-12 text-md border border-gray-500 rounded-full bg-white shadow-xl focus:outline-none focus:ring-1 focus:ring-blue-500',
            { 'glow': isDropdownOpen } // Add glow effect when dropdown is open
          ]"
        >
          <!-- SVG for form icon -->
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 9h10M7 13h10M7 17h10M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
          </svg>
        </button>

        <!-- Dropdown menu -->
        <div v-if="isDropdownOpen" class="fixed bottom-24 right-6 mt-2 py-2 w-56 bg-white border rounded-lg shadow-lg">
          <ul>
            <li v-for="(tab, index) in tabs" :key="index">
              <a
                href="#"
                @click.prevent="selectTab(tab)"
                :class="{
                  'bg-blue-100 text-blue-700': currentTab === tab, // Highlighted tab
                  'text-gray-700': currentTab !== tab // Non-highlighted tabs
                }"
                class="block px-4 py-2 text-md hover:bg-gray-100 rounded"
              >
                {{ tab }}
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Display content based on selected tab -->
    <div class="p-4 w-full">
      <div v-if="currentTab === 'ISO Anecdotal Form'"><ISOAnecdotalForm/></div>
      <div v-if="currentTab === 'ISO Incident Form'"><ISOIncidentForm/></div>
      <div v-if="currentTab === 'ISO Inventory Form'"><ISOInventoryForm/></div>
      <div v-if="currentTab === 'ISO Session Form'"><ISOSessionForm/></div>
      <div v-if="currentTab === 'ISO Swapping Form'"><ISOSwappingForm/></div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';

// Import components
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

const defaultTab = 'ISO Anecdotal Form'; // Define the default tab

// Retrieve the saved tab from localStorage or set it to the default tab
const currentTab = ref(localStorage.getItem('usetab') || defaultTab);
const isDropdownOpen = ref(false);

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value;
};

const selectTab = (tab) => {
  currentTab.value = tab;
  isDropdownOpen.value = false;
  // Save the selected tab in localStorage
  localStorage.setItem('usetab', tab);
};

// Watch for changes to currentTab and update localStorage


// Ensure a default tab is set on component mount
onMounted(() => {
  if (!localStorage.getItem('usetab')) {
    currentTab.value = defaultTab;
    localStorage.setItem('usetab', defaultTab);
  }
});
</script>


<style scoped>
/* More pronounced shimmering effect */
@keyframes intenseShimmer {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.05); /* Slightly enlarge button */
  }
  100% {
    transform: scale(1); /* Return to original size */
  }
}

.glow {
  animation: intenseShimmer 1s infinite ease-in-out;
}

/* Optional: Add any additional styles here */
.text-customBlue {
  color: #1c3d5a; /* Adjust this to your custom blue color */
}
</style>
