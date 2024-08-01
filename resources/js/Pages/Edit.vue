<template>
  <AppLayout>
    <template #header>
      <!-- Add your header content here if needed -->
    </template>

    <div v-if="loading" class="text-center py-4">Loading client data...</div>
    <div v-else>
      <div class="flex border-b">
        <button 
          v-for="(tab, index) in availableTabs" 
          :key="index" 
          @click="currentTab = tab" 
          :class="['py-2 px-4 focus:outline-none', currentTab === tab ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-500']"
        >
          {{ tab }}
        </button>
      </div>
      <div class="p-4">
        <div v-if="currentTab === 'Social Service'"><EditSocialServiceTab/></div>
        <div v-if="currentTab === 'Psychological Reports'"><EditPsychologicalTab/></div>
        <div v-if="currentTab === 'Court Order'"><EditCourtOrderTab/></div>
        <div v-if="currentTab === 'Homelife Services'"><EditHomelifeTab/></div>
        <div v-if="currentTab === 'Nursing Care'"><EditNursingcareTab/></div>
        <div v-if="currentTab === 'Educational Services'"><EditEducationalTab/></div>
        <div v-if="currentTab === 'PSD Reports'"><EditPSDTab/></div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import EditSocialServiceTab from './EditSocialServiceTab.vue';
import EditPsychologicalTab from './EditPsychologicalTab.vue';
import EditCourtOrderTab from './EditCourtOrderTab.vue';
import EditHomelifeTab from './EditHomelifeTab.vue';
import EditNursingcareTab from './EditNursingcareTab.vue';
import EditEducationalTab from './EditEducationalTab.vue';
import EditPSDTab from './EditPSDTab.vue';

const tabs = ref([
  'Social Service',
  'Psychological Reports',
  'Court Order',
  'Homelife Services',
  'Nursing Care',
  'Educational Services',
  'PSD Reports'
]);

const currentTab = ref(''); // Set to an empty string initially

const route = useRoute();
const client = ref(null);
const loading = ref(true);
const user = ref({ role: '' }); // Role will be set dynamically

const availableTabs = computed(() => {
  if (user.value.role === 'social services') {
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
  'psychological': 'Psychological Reports',
  'court order': 'Court Order',
  'homelife services': 'Homelife Services',
  'nursing care': 'Nursing Care',
  'educational services': 'Educational Services',
  'psd': 'PSD Reports'
};

onMounted(async () => {
  const { props } = usePage();
  user.value.role = props.auth.user.role || ''; // Set user role from Inertia props

  // Set currentTab based on user role
  currentTab.value = roleToTab[user.value.role] || tabs.value[0];

  // Fetch client data based on the ID from the route
  try {
    const response = await axios.get(`/api/clients/${route.params.id}`);
    client.value = response.data;
    loading.value = false;
  } catch (error) {
    console.error('Error fetching client data:', error);
    loading.value = false;
  }
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
.px-4 {
  padding-left: 1rem;
  padding-right: 1rem;
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
</style>
