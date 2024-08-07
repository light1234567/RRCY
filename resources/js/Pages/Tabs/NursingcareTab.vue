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
        <div v-if="currentTab === 'Nursing Care Service Form'"><NursingCareService/></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref} from 'vue';
import NursingCareService from '../Display/NursingCare/NursingCareService.vue';

const tabs = ref([
  'Nursing Care Service Form'
]);

const currentTab = ref('Nursing Care Service Form'); // Default tab value

</script>
