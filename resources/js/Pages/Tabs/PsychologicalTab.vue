<template>
  <div>
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
</script>
