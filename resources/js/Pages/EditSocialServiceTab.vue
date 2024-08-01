<template>
  <div>
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
        <div v-if="currentTab === 'Checklist of Requirements'">Checklist of Requirements</div>
        <div v-if="currentTab === 'First Intervention Plan'">First Intervention Plan</div>
        <div v-if="currentTab === 'Admission Slip'"><AdmissionSlipDisplay/></div>
        <div v-if="currentTab === 'General Intake 1'">General Intake 1</div>
        <div v-if="currentTab === 'General Intake 2'">General Intake 2</div>
        <div v-if="currentTab === 'Kasabutan'">Kasabutan</div>
        <div v-if="currentTab === 'Data Privacy Consent'">Data Privacy Consent</div>
        <div v-if="currentTab === 'Talambuhay'">Talambuhay</div>
        <div v-if="currentTab === 'INDICATORS OF SOCIAL FUNCTIONING'">INDICATORS OF SOCIAL FUNCTIONING</div>
        <div v-if="currentTab === 'Admission Contract'">Admission Contract</div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useRoute } from 'vue-router';
import axios from 'axios';
import AdmissionSlipDisplay from './AdmissionSlipDisplay.vue';

const tabs = ref([
  'Checklist of Requirements',
  'First Intervention Plan',
  'Admission Slip',
  'General Intake 1',
  'General Intake 2',
  'Kasabutan',
  'Data Privacy Consent',
  'Talambuhay',
  'INDICATORS OF SOCIAL FUNCTIONING',
  'Admission Contract',
]);

const currentTab = ref('Checklist of Requirements'); // Default tab value
const route = useRoute();
const client = ref(null);
const loading = ref(true);
const user = ref({ role: '' }); // Role will be set dynamically

const availableTabs = computed(() => {
  if (user.value.role === 'social services') {
    return tabs.value;
  }
  // Define available tabs based on user role if needed
  return []; // Return an empty array or modify as necessary
});

onMounted(async () => {
  const { props } = usePage();
  user.value.role = props.auth.user.role || ''; // Set user role from Inertia props

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
