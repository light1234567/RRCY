<template>
  <AppLayout>
    <template #header>
      <div class="flex items-center">
        <div class="ml-5 w-2 h-6 bg-gray-400 mr-3"></div>
        <i class="fa fa-users text-black text-2xl ml-6"></i> 
        <h1 class="text-lg ml-4 font-bold text-red-800">CICL Information</h1>
      </div>

      <!-- Save and Cancel buttons -->
      <div class="absolute top-14 right-6 flex space-x-3">
        <!-- Display the buttons if either Case Status or Child Status is in edit mode -->
        <button v-if="editCaseStatusMode || editChildStatusMode" @click="saveChanges">
          <i class="fas fa-save"></i> Save
        </button>

        <button v-if="editCaseStatusMode || editChildStatusMode" @click="cancelChanges">
          <i class="fas fa-times"></i> Cancel
        </button>
      </div>
    </template>

    <!-- Main Client Information -->
    <div v-if="client" class="flex  items-center justify-between p-6 bg-white border border-gray-200 rounded-lg shadow-lg">
      <!-- Left: Client Image and Details -->
      <div class="ml-8 flex items-center space-x-6">
        <img
  :src="client.profile_image ? `/profile_images/${client.profile_image}` : defaultImage"
  alt="Client Profile Image"
  class="w-24 h-24 rounded-full object-cover border-4 border-blue-500"
/>
        <div>
          <h1 class="text-2xl font-bold text-gray-900">{{ client.first_name }} {{ client.last_name }}</h1>
          <div class="mt-2 text-gray-700 space-y-1">
            <p class="text-sm"><span class="font-semibold">Age:</span> {{ calculateAge(client.date_of_birth) }} years old</p>
            <p class="text-sm"><span class="font-semibold">Address:</span> {{ formattedAddress }}</p>
            <p class="text-sm">
  <span class="font-semibold">Case Status: </span>
  <span v-if="!editCaseStatusMode">{{ client?.admission?.case_status || 'N/A' }}</span>
  <select v-if="editCaseStatusMode" v-model="editedClient.case_status">
    <option v-for="status in caseStatusOptions" :key="status" :value="status">
      {{ status }}
    </option>
  </select>
  <!-- Edit icon at the end of Case Status -->
  <i v-if="!editCaseStatusMode" class="fas fa-edit ml-2 cursor-pointer" @click="toggleEditCaseStatus"></i>
</p>

<p class="text-sm">
  <span class="font-semibold">Child Status: </span>
  <span v-if="!editChildStatusMode">{{ client.child_status }}</span>
  <select v-if="editChildStatusMode" v-model="editedClient.child_status">
    <option v-for="status in childStatusOptions" :key="status" :value="status">
      {{ status }}
    </option>
  </select>
  <!-- Edit icon at the end of Child Status -->
  <i v-if="!editChildStatusMode" class="border-0 fas fa-edit ml-2 cursor-pointer" @click="toggleEditChildStatus"></i>
</p>


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

      <NotificationModal
  :isVisible="showModal"
  :modalType="modalType"
  :message="modalMessage"
  @close="showModal = false"
/>
  </AppLayout>
</template>

<script>
import NotificationModal from '@/Components/NotificationModal.vue';
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
  props: {
    client: {
      type: Object,
      default: null // Ensure the default is null to prevent errors when it's not passed
    },
    caseStatusOptions: {
      type: Array,
      required: true
    },
    childStatusOptions: {
      type: Array,
      required: true
    }
  },
  data() {
  return {
    editCaseStatusMode: false,
    editChildStatusMode: false,
    editedClient: {
      case_status: this.client?.admission.case_status || '',
      child_status: this.client?.child_status || ''
    },
    caseStatusOptions: [
      'On trial',
      'Acquitted/Dismissed',
      'Provisionally Dismissed',
      'Rehabilitation',
      'Diversion',
      'Disposition Measure',
      'Child-at-risk (CAR)'
    ],
    childStatusOptions: [
      'Still at the Center (SATC)',
      'Discharge',
      'Leave without Permission (LWOP)'
    ],
    showModal: false,
    modalType: 'success',
    modalMessage: '',
  };
},

methods: {
  async saveChanges() {
    try {
      if (this.client) {
        // Create an object with only the edited fields
        const updateData = {};

        // Include case_status only if it has been edited
        if (this.editCaseStatusMode) {
          updateData.case_status = this.editedClient.case_status;
        } else {
          updateData.case_status = this.client.admission.case_status;
        }

        // Include child_status only if it has been edited
        if (this.editChildStatusMode) {
          updateData.child_status = this.editedClient.child_status;
        } else {
          updateData.child_status = this.client.child_status;
        }

        // Send the update request with only the necessary fields
        await axios.post(`/api/admission/updateClientStatus/${this.client.id}`, updateData);

        // Show success modal
        this.modalType = 'success';
        this.modalMessage = 'Changes saved successfully!';
        this.showModal = true;

        // Close both edit modes
        this.editCaseStatusMode = false;
        this.editChildStatusMode = false;

        // Refresh the page after a short delay to apply the changes
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      }
    } catch (error) {
      console.error('Failed to save changes:', error.response?.data || error.message);

      // Show error modal
      this.modalType = 'error';
      this.modalMessage = 'Failed to save changes. Please check your data and try again.';
      this.showModal = true;
    }
  },
  cancelChanges() {
    // Reset the editedClient values to original client values
    this.editedClient = {
      case_status: this.client?.admission.case_status || '',
      child_status: this.client?.child_status || ''
    };
    this.editCaseStatusMode = false;
    this.editChildStatusMode = false;
  },
  toggleEditCaseStatus() {
    this.editCaseStatusMode = !this.editCaseStatusMode;
  },
  toggleEditChildStatus() {
    this.editChildStatusMode = !this.editChildStatusMode;
  }
},

  components: {
    AppLayout,
    SocialServiceTab,
    PsychologicalTab,
    CourtOrderTab,
    HomelifeTab,
    NursingcareTab,
    EducationalTab,
    PSDTab,
    NotificationModal
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
    // First API call to get the client data
    const clientResponse = await axios.get(`/api/clients/${clientId}`);
    client.value = clientResponse.data;

    // Fetch the admission data
    const admissionResponse = await axios.get(`/api/admissions/client/${clientId}`);
    client.value.admission = admissionResponse.data;

    // Proceed to fetch the profile image
    try {
      const nursingResponse = await axios.get(`/api/nursing-care-services/client/${clientId}`);

      // If profile_image exists, set it, otherwise set it to null
      client.value.profile_image = nursingResponse.data && nursingResponse.data.profile_image 
        ? nursingResponse.data.profile_image 
        : null;

    } catch (error) {
      console.warn("Error fetching profile image, using default image.");
      client.value.profile_image = null; // Ensure default image is used
    }

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
  fetchClient(clientId.value).then(() => {
    if (client.value && client.value.admission) {
      this.editedClient = {
        case_status: client.value.admission.case_status || '',
        child_status: client.value.child_status || ''
      };
    }
  });
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
