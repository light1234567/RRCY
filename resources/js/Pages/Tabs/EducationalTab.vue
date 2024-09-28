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
        <div v-if="loading" class="text-center py-4">Loading client data...</div>
        <div v-else>
            <div v-if="currentTab === 'Learner Academic Form'"><LearnerAcademicForm/></div>
            <div v-if="currentTab === 'Learner Assessment Form'"><LearnerAssessmentForm/></div>
        </div>
    </div>
</div>

</template>

<script setup>
import { ref, onMounted } from 'vue';
import LearnerAcademicForm from '../Display/Educational/LearnerAcademicForm.vue';
import LearnerAssessmentForm from '../Display/Educational/LearnerAssessmentForm.vue';

const tabs = ref([
  'Learner Academic Form',
  'Learner Assessment Form',
]);

const currentTab = ref('Learner Academic Form'); // Default tab value
const isDropdownOpen = ref(false);
const loading = ref(false); // Simulate loading state

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
  if (savedTab && tabs.value.includes(savedTab)) {
    currentTab.value = savedTab;
  }
});
</script>

