<template>
  <AppLayout>
    <template #header>
      <div class="flex items-center">
        <div class="ml-5 w-2 h-6 bg-gray-400 mr-3"></div>
        <i class="fa fa-users  text-black text-2xl ml-6"></i> 
        <h1 class="text-lg ml-4 font-bold text-red-800">CICL Information</h1>
      </div>
    </template>

    <div v-if="loading" class="text-center py-4">Loading client data...</div>
    <div v-else>
      <div v-if="showTabs" class="flex mt-2 ml-10 border-b">
        <div class="tabs">
          <button
            v-for="(tab, index) in availableTabs"
            :key="index"
            @click="setTab(tab)"
            :class="['py-2 px-8 focus:outline-none', currentTab === tab ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-500']"
          >
            {{ tab }}
          </button>
        </div>
      </div>
      <div class="p-4 tab-content">
        <div v-if="currentTab === 'Social Service'"><SocialServiceTab/></div>
        <div v-if="currentTab === 'Psychological Reports'"><PsychologicalTab/></div>
        <div v-if="currentTab === 'Homelife Services'"><HomelifeTab/></div>
        <div v-if="currentTab === 'Nursing Care'"><NursingcareTab/></div>
        <div v-if="currentTab === 'PSD Reports'"><PSDTab/></div>
        <div v-if="currentTab === 'Educational Services'"><EducationalTab/></div>
        <div v-if="currentTab === 'Court Order'"><CourtOrderTab/></div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

// Adjusted import paths
import SocialServiceTab from './Tabs/SocialServiceTab.vue';
import PsychologicalTab from './Tabs/PsychologicalTab.vue';
import CourtOrderTab from './Tabs/CourtOrderTab.vue';
import HomelifeTab from './Tabs/HomelifeTab.vue';
import NursingcareTab from './Tabs/NursingcareTab.vue';
import EducationalTab from './Tabs/EducationalTab.vue';
import PSDTab from './Tabs/PSDTab.vue';

const tabs = ref([
  'Social Service',
  'Psychological Reports',
  'Homelife Services',
  'Nursing Care',
  'PSD Reports',
  'Educational Services',
  'Court Order'
]);

const currentTab = ref(''); // Set to an empty string initially
const user = ref({ role: '' }); // Role will be set dynamically

const availableTabs = computed(() => {
  if (user.value.role === 'social services' || user.value.role === 'admin') {
    return tabs.value;
  }
  switch (user.value.role) {
    case 'psychological':
      return ['Psychological Reports'];
    case 'court order':
      return ['Court Order'];
    case 'homelife services':
      return ['Homelife Services'];
    case 'nursing care':
      return ['Nursing Care'];
    case 'educational services':
      return ['Educational Services'];
    case 'psd':
      return ['PSD Reports'];
    default:
      return [];
  }
});

const roleToTab = {
  'social services': 'Social Service',
  'admin': 'Social Service',
  'psychological': 'Psychological Reports',
  'court order': 'Court Order',
  'homelife services': 'Homelife Services',
  'nursing care': 'Nursing Care',
  'educational services': 'Educational Services',
  'psd': 'PSD Reports'
};

const showTabs = computed(() => user.value.role === 'social services' || user.value.role === 'admin');

const setTab = (tab) => {
  currentTab.value = tab;
  localStorage.setItem('currentTab', tab); // Save tab to localStorage
};

onMounted(() => {
  const { props } = usePage();
  user.value.role = props.auth.user.role; // Set user role from Inertia props
  
  // Retrieve tab from localStorage
  const storedTab = localStorage.getItem('currentTab');
  
  // Set the default tab based on the user role or localStorage value
  const defaultTab = storedTab && availableTabs.value.includes(storedTab)
    ? storedTab
    : roleToTab[user.value.role] || 'Psychological Reports';
  
  currentTab.value = defaultTab;
});
</script>

<style scoped>
.flex {
  display: flex;
}
.border-b {
  border-bottom: 1px solid #ddd;
}
.py-2 {
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
}
.px-8 {
  padding-left: 2rem;
  padding-right: 2rem;
  text-align: center;
}
.focus\:outline-none {
  outline: none;
}
.border-blue-500 {
  border-color: #3b82f6;
}
.text-blue-500 {
  color: #3b82f6;
}
.text-gray-500 {
  color: #6b7280;
}
.p-4 {
  padding: 1rem;
}
.tab-content {
  padding: 20px;
  border: 1px solid #ddd;
  border-top: none;
}
</style>
