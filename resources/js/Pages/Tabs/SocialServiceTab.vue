<template>
  <div class="flex flex-col justify-center items-center min-h-screen">
    <div class="flex flex-col justify-center items-center w-full">
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
import { ref } from 'vue';

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

const currentTab = ref('Admission Slip'); // Default tab set to "Admission Slip"
</script>

<style scoped>
/* Add any additional styles here */
.text-customBlue {
  color: #1c3d5a; /* Adjust this to your custom blue color */
}
</style>
