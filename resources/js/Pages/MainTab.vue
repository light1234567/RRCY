<template>
  <AppLayout>
    <template #header>
      <div class="flex items-center">
        <div class="ml-5 w-2 h-6 bg-gray-400 mr-3"></div>
        <i class="fa fa-users text-black text-2xl ml-6"></i> 
        <h1 class="text-lg ml-4 font-bold text-red-800">CICL Information</h1>
      </div>
    </template>

    <!-- Main Client Information -->
    <div v-if="client" class="flex  items-center justify-between p-6 bg-white border border-gray-200 rounded-lg shadow-lg">
      <!-- Left: Client Image and Details -->
      <div class="ml-8 flex items-center space-x-6">
        <img
          :src="client.profile_image ? `/storage/${client.profile_image}` : defaultImage"
          alt="Client Profile Image"
          class="w-24 h-24 rounded-full object-cover border-4 border-blue-500"
        />
        <div>
          <h1 class="text-2xl font-bold text-gray-900">{{ client.first_name }} {{ client.last_name }}</h1>
          <div class="mt-2 text-gray-700 space-y-1">
            <p class="text-sm"><span class="font-semibold">Age:</span> {{ calculateAge(client.date_of_birth) }} years old</p>
            <p class="text-sm"><span class="font-semibold">Address:</span> {{ formattedAddress }}</p>
          </div>
        </div>
      </div>
      <div class="flex justify-end mr-3">
  <p :class="[getChildStatusClass(client.child_status), 'uppercase text-[20px] font-cops']">
    {{ client.child_status }}
  </p>
</div>

    </div>

    <div v-if="loading" class="text-center py-4">Loading client data...</div>
    <div v-else>
      <div v-if="showTabs" class="ml-12 flex mt-2 border-b">
        <div class="flex space-x-4 overflow-auto tabs">
          <button
            v-for="(tab, index) in availableTabs"
            :key="index"
            @click="setTab(tab)"
            :class="['py-2 px-4 focus:outline-none whitespace-nowrap', currentTab === tab ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-500']"
          >
            {{ tab }}
          </button>
        </div>
      </div>
      </div>
      <div class=" p-2 tab-content">
        <div v-if="currentTab === 'Social Service'"><SocialServiceTab /></div>
        <div v-if="currentTab === 'Psychological Reports'"><PsychologicalTab /></div>
        <div v-if="currentTab === 'Homelife Services'"><HomelifeTab /></div>
        <div v-if="currentTab === 'Nursing Care'"><NursingcareTab /></div>
        <div v-if="currentTab === 'PSD Reports'"><PSDTab /></div>
        <div v-if="currentTab === 'Educational Services'"><EducationalTab /></div>
        <div v-if="currentTab === 'Court Order'"><CourtOrderTab /></div>
      </div>
  </AppLayout>
</template>

<script>
import { ref, computed, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';

import SocialServiceTab from './Tabs/SocialServiceTab.vue';
import PsychologicalTab from './Tabs/PsychologicalTab.vue';
import CourtOrderTab from './Tabs/CourtOrderTab.vue';
import HomelifeTab from './Tabs/HomelifeTab.vue';
import NursingcareTab from './Tabs/NursingcareTab.vue';
import EducationalTab from './Tabs/EducationalTab.vue';
import PSDTab from './Tabs/PSDTab.vue';

export default {
  components: {
    AppLayout,
    SocialServiceTab,
    PsychologicalTab,
    CourtOrderTab,
    HomelifeTab,
    NursingcareTab,
    EducationalTab,
    PSDTab,
  },
  setup() {
    const tabs = ref([
      'Social Service',
      'Psychological Reports',
      'Homelife Services',
      'Nursing Care',
      'PSD Reports',
      'Educational Services',
      'Court Order'
    ]);

    const currentTab = ref('');
    const client = ref(null);
    const defaultImage = 'https://via.placeholder.com/150';
    const loading = ref(true);
    const user = ref({ role: '' });

    const route = useRoute();
    const clientId = ref(route.params.id);

    const fetchClient = async (clientId) => {
      try {
        const { data } = await axios.get(`/api/clients/${clientId}`);
        client.value = data;
        loading.value = false;
      } catch (error) {
        console.error('Error fetching client data:', error);
        loading.value = false;
      }
    };

    const calculateAge = (dob) => {
      const birthDate = new Date(dob);
      const today = new Date();
      let age = today.getFullYear() - birthDate.getFullYear();
      const monthDiff = today.getMonth() - birthDate.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      return age;
    };

    const formattedAddress = computed(() => {
      if (!client.value) return '';
      const { street, barangay, city, province } = client.value;
      return `${street || ''} ${barangay || ''} ${city || ''} ${province || ''}`.trim();
    });

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
      localStorage.setItem('currentTab', tab);
    };

    onMounted(() => {
      const { props } = usePage();
      user.value.role = props.auth.user.role;

      fetchClient(clientId.value);

      const storedTab = localStorage.getItem('currentTab');
      const defaultTab = storedTab && availableTabs.value.includes(storedTab)
        ? storedTab
        : roleToTab[user.value.role] || 'Psychological Reports';

      currentTab.value = defaultTab;
    });

    // Watch for changes in the route params to fetch new client data dynamically
    watch(() => route.params.id, (newId) => {
      clientId.value = newId;
      fetchClient(clientId.value);
    });

    const getChildStatusClass = (childStatus) => {
    switch (childStatus) {
      case 'Still at the Center (SATC)':
        return 'text-green-600';
      case 'Discharge':
        return 'text-red-600 mr-24 text-[28px]'; // Add right margin for Discharge
      case 'Leave without Permission (LWOP)':
        return 'text-orange-500';
      default:
        return 'text-black';
    }
  };

    return {
      tabs,
      currentTab,
      client,
      defaultImage,
      loading,
      user,
      formattedAddress,
      availableTabs,
      showTabs,
      setTab,
      calculateAge,
      fetchClient,
      getChildStatusClass,
    };
  },
};
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
.whitespace-nowrap {
  white-space: nowrap;
}
.tabs {
  display: flex;
  flex-wrap: nowrap;
}
.space-x-4 {
  column-gap: 1rem;
}
.tab-content {
  padding: 20px;
  border: 1px solid #ddd;
  border-top: none;
}
</style>
