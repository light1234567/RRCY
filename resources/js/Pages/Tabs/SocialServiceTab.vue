<template>
  <div>
    <div class="border-b p-1 bg-gray-100">
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
      <div v-if="currentTab === 'INDICATORS OF SOCIAL FUNCTIONING'"><IndicatorsDisplay/></div>
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
  'INDICATORS OF SOCIAL FUNCTIONING',
]);

const currentTab = ref('Admission Slip'); // Default tab set to "Admission Slip"
</script>
