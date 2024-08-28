<template>
  <div class="flex flex-col justify-center items-center min-h-screen">
    <div class="flex flex-col justify-center items-center w-full">
      <!-- Icon button with dropdown menu -->
      <div class="relative">
        <button 
          @click="toggleDropdown" 
          :class="[
            'fixed bottom-6 right-6 flex items-center justify-center w-14 h-14 text-md border border-gray-500 rounded-full bg-gray-800 shadow-xl focus:outline-none focus:ring-1 focus:ring-blue-500',
            { 'glow': isDropdownOpen } // Add glow effect when dropdown is open
          ]"
        >
          <!-- SVG for form icon -->
          <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
      <div v-if="currentTab === 'Admission Slip'"><AdmissionSlipDisplay/></div>
      <div v-if="currentTab === 'Checklist of Requirements'"><ChecklistDisplay/></div>
      <div v-if="currentTab === 'First Intervention Plan'"><FirstInterventionPlanDisplay/></div>
      <div v-if="currentTab === 'General Intake 1'"><FirstGeneralIntakeDisplay/></div>
      <div v-if="currentTab === 'General Intake 2'"><SecondGeneralIntakeDisplay/></div>
      <div v-if="currentTab === 'Kasabutan1'"><FirstKasabutanDisplay/></div>
      <div v-if="currentTab === 'Kasabutan2'"><SecondKasabutanDisplay/></div>
      <div v-if="currentTab === 'Data Privacy Consent'"><DataPrivacyConsentDisplay/></div>
      <div v-if="currentTab === 'Talambuhay'"><TalambuhayDisplay/></div>
      <div v-if="currentTab === 'Admission Contract'"><AdmissionContractDisplay/></div>
      <div v-if="currentTab === 'Indicators of Social Functioning'"><IndicatorsDisplay/></div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

// Import components
import AdmissionSlipDisplay from '../Display/SocialService/AdmissionSlipDisplay.vue';
import ChecklistDisplay from '../Display/SocialService/ChecklistDisplay.vue';
import FirstInterventionPlanDisplay from '../Display/SocialService/FirstInterventionPlanDisplay.vue';
import FirstGeneralIntakeDisplay from '../Display/SocialService/FirstGeneralIntakeDisplay.vue';
import SecondGeneralIntakeDisplay from '../Display/SocialService/SecondGeneralIntakeDisplay.vue';
import FirstKasabutanDisplay from '../Display/SocialService/FirstKasabutanDisplay.vue';
import SecondKasabutanDisplay from '../Display/SocialService/SecondKasabutanDisplay.vue';
import DataPrivacyConsentDisplay from '../Display/SocialService/DataPrivacyConsentDisplay.vue';
import TalambuhayDisplay from '../Display/SocialService/TalambuhayDisplay.vue';
import AdmissionContractDisplay from '../Display/SocialService/AdmissionContractDisplay.vue';
import IndicatorsDisplay from '../Display/SocialService/IndicatorsDisplay.vue';

const tabs = ref([
  'Admission Slip',
  'Checklist of Requirements',
  'First Intervention Plan',
  'General Intake 1',
  'General Intake 2',
  'Kasabutan1',
  'Kasabutan2',
  'Data Privacy Consent',
  'Talambuhay',
  'Admission Contract',
  'Indicators of Social Functioning',
]);

const defaultTab = 'Admission Slip';
const currentTab = ref(localStorage.getItem('currentTab') || defaultTab); // Set to defaultTab if nothing in localStorage
const isDropdownOpen = ref(false);

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value;
};

const selectTab = (tab) => {
  currentTab.value = tab;
  localStorage.setItem('currentTab', tab); // Save the selected tab to localStorage
  isDropdownOpen.value = false;
};

// Ensure the correct tab is loaded on page refresh
onMounted(() => {
  const savedTab = localStorage.getItem('currentTab');
  if (!savedTab || !tabs.value.includes(savedTab)) {
    // If there's no saved tab or the saved tab is invalid, set to default
    currentTab.value = defaultTab;
    localStorage.setItem('currentTab', defaultTab); // Save defaultTab to localStorage
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