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
      <div v-if="currentTab === 'IOR Form'"><IORForm/></div>
      <div v-if="currentTab === 'TNA Questionnaire'"><TNAQuestionnaire/></div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import IORForm from '../Display/PSD/IORForm.vue';
import TNAQuestionnaire from '../Display/PSD/TNAQuestionnaire.vue';

const tabs = ref([
  'IOR Form',
  'TNA Questionnaire'
]);

const currentTab = ref('IOR Form'); // Default tab value
</script>
