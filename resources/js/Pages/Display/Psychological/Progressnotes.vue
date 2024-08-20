<template>
  <!-- Tabs for Actions -->
  <div v-if="editMode" class="flex absolute p-4 space-x-4">
    <button @click="cancelEdit" class="flex space-x-2 px-3 py-1 bg-customBlue text-white rounded-md text-xs">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      <span>Back</span>
    </button>
  </div>

  <div class="flex justify-end bg-transparent border border-gray-300 p-4 rounded-md space-x-4 mt-4">
    <Pagination
      :totalPages="totalPages"
      :currentPage="currentPage"
      @update:currentPage="updatePage"
    />
    <button @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.3 2.7a1 1 0 011.4 0l1.3 1.3a1 1 0 010 1.4l-9.4 9.4a1 1 0 01-.6.3l-2.8.6a1 1 0 01-1.2-1.2l.6-2.8a1 1 0 01.3-.6l9.4-9.4z" />
      </svg>
      <span>Edit</span>
    </button>

    <button v-if="editMode" @click="saveData" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg>
      <span>Save</span>
    </button>
  </div>

  <div class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
    <div class="relative flex justify-between items-center mb-2">
      <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
      <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
    </div>
    <form @submit.prevent="submitForm" class="space-y-8 w-full">
      <!-- Header -->
      <div class="p-6 rounded-md bg-white">
        <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
          {{ message }}
        </div>

        <!-- Progress Report Section -->
        <div class="space-y-4 mt-6">
          <div class="text-center">
            <h2 class="font-bold text-md">PROGRESS REPORT</h2>
            <h2 class="font-semibold mt-2 mb-8 text-md">PSYCHOLOGICAL SERVICE</h2>
          </div>
          <div class="space-y-2">
            <div class="flex text-sm -mb-4">
              <label for="name" class="block w-1/6">Name:</label>
              <input type="text" id="name" v-model="form.name" class="text-sm block w-2/3 -ml-10 p-0  border-0 bg-transparent" readonly>
            </div>
          </div>

          <div class="space-y-2">
            <div class="flex text-sm -mb-4">
              <label for="age" class="block w-1/6">Age:</label>
              <input type="text" id="age" v-model="form.age" class="block w-2/3 -ml-10 p-0  text-sm border-0 bg-transparent" readonly>
            </div>
          </div>

          <div class="space-y-2">
            <div class="flex text-sm -mb-4">
              <label for="dateAdmitted" class="block w-1/5">Date Admitted:</label>
              <input type="text" id="dateAdmitted" v-model="form.date_admitted" class="block -ml-4 w-2/3 p-0 text-sm border-0 bg-transparent" readonly>
            </div>
          </div>

          <div class="space-y-2">
            <div class="flex text-sm">
              <label for="interventionPeriod" class="block w-1/2">Period of Intervention Plan:</label>
              <input type="text" id="interventionPeriod" v-model="form.intervention_period" class="block w-2/3 p-1 text-sm border-0 bg-transparent" :readonly="!editMode">
            </div>
          </div>
        </div>

        <!-- Problem Behavior Log Section -->
        <div class="space-y-4 mt-6">
          <h2 class="font-bold">PROBLEM BEHAVIOR LOG</h2>
          <textarea id="problemBehaviorLog" v-model="form.problem_behavior_log" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
        </div>

        <!-- Interventions Conducted Section -->
        <div class="space-y-4 mt-6">
          <h2 class="font-bold">INTERVENTIONS CONDUCTED</h2>
          <textarea id="interventionsConducted" v-model="form.interventions_conducted" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
        </div>

        <!-- Progress Notes Section -->
        <div class="space-y-4 mt-6">
          <h2 class="font-bold">PROGRESS NOTES</h2>
          <textarea id="progressNotes" v-model="form.progress_notes" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
        </div>

        <div class="space-y-4 mt-6">
          <div class="space-y-2">
            <label for="preparedBy" class="block mb-12 mt-12 font-sm">Prepared by:</label>
            <div class="flex flex-col">
              <strong><input type="text" id="preparedBy" v-model="form.prepared_by" class="block w-full p-0 border border-transparent rounded-md" :readonly="!editMode"></strong>
              <span>Psychologist I</span>
            </div>
          </div>
          <div class="space-y-2 mt-4">
            <label for="notedBy" class="block mb-12 mt-12 font-sm">Noted by:</label>
            <div class="flex flex-col">
              <strong><input type="text" id="notedBy" v-model="form.noted_by" class="block w-full p-0 border border-transparent rounded-md" :readonly="!editMode"></strong>
              <span>SWO IV / Center Head</span>
            </div>
          </div>
        </div>
      </div>

      <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
        <div class="flex justify-between items-center">
          <div class="flex flex-col">
            <p class="ml-24 -mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
            <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
            <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
          </div>
          <div class="ml-4">
            <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
          </div>
        </div>
      </div>
    </form>
  </div>

  <!-- Modal for Save Confirmation -->
  <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50">
    <div class="fixed inset-0 bg-black opacity-50"></div>
    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
      <div class="bg-white p-6">
        <div class="flex items-center">
          <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.93 5h13.86c1.1 0 1.96-.9 1.84-1.98l-1.18-12.14a2 2 0 00-1.98-1.88H4.27a2 2 0 00-1.98 1.88L1.11 16.02c-.12 1.08.74 1.98 1.84 1.98z" />
          </svg>
          <h3 class="text-lg leading-6 font-medium text-gray-900">Save changes?</h3>
        </div>
        <div class="mt-2">
          <p class="text-sm text-gray-500">Are you sure you want to save the changes?</p>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button @click="confirmSave" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Save</button>
        <button @click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
      </div>
    </div>
  </div>

  <!-- Modal for Save Result -->
  <div v-if="isSaveResultModalOpen" class="fixed inset-0 flex items-center justify-center z-50">
    <div class="fixed inset-0 bg-black opacity-50"></div>
    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
      <div class="bg-white p-6 text-center">
        <div v-if="saveResultTitle === 'Error'" class="flex justify-center items-center mb-4">
          <div class="flex items-center justify-center w-12 h-12 bg-red-100 rounded-full">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </div>
        </div>
        <div v-if="saveResultTitle === 'Success'" class="flex justify-center items-center mb-4">
          <div class="flex items-center justify-center w-12 h-12 bg-blue-500 rounded-full">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
        </div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ saveResultTitle }}</h3>
        <div class="mt-2">
          <p class="text-sm text-gray-500">{{ saveResultMessage }}</p>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button @click="closeSaveResultModal" :class="saveResultTitle === 'Error' ? 'bg-red-600 hover:bg-red-500' : 'bg-blue-600 hover:bg-blue-500'" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
          OK
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import Pagination from '@/Components/Pagination.vue';

export default {
  name: 'ProgressReportForm',
  components: {
    Pagination,
  },
  setup() {
    const form = ref({
      client_id: null,
      admission_id: null,
      name: '',
      age: '',
      date_admitted: '',
      intervention_period: '',
      problem_behavior_log: '',
      interventions_conducted: '',
      progress_notes: '',
      prepared_by: 'BRYAN V. GALANG, MPsy, RPsy',
      noted_by: 'ANGELIC B. PAÑA, RSW, MSSW',
    });

    const editMode = ref(false);
    const message = ref('');
    const messageType = ref(''); // 'success' or 'error'
    const route = useRoute();
    const totalPages = ref(1);
    const currentPage = ref(1);
    const isModalOpen = ref(false);
    const isSaveResultModalOpen = ref(false);
    const saveResultTitle = ref('');
    const saveResultMessage = ref('');

    const fetchData = () => {
      const clientId = route.params.id;
      if (clientId) {
        axios.get(`/api/cicl-progress-notes/${clientId}`).then(response => {
          if (response.data.note) {
            Object.assign(form.value, response.data.note);
            form.value.client_id = clientId;
            form.value.admission_id = response.data.admission.id;
            // Assign additional fields from client and admission, making them non-editable
            const client = response.data.client;
            const admission = response.data.admission;
            form.value.name = `${client.first_name} ${client.last_name}`;
            form.value.age = calculateAge(client.date_of_birth);
            form.value.date_admitted = admission.date_admitted;
          } else {
            const { client, admission } = response.data;
            form.value.client_id = client.id;
            form.value.admission_id = admission.id;
            form.value.name = `${client.first_name} ${client.last_name}`;
            form.value.age = calculateAge(client.date_of_birth);
            form.value.date_admitted = admission.date_admitted;
          }
        }).catch(error => {
          console.error('Error fetching data:', error);
        });
      }
    };

    onMounted(fetchData);

    const toggleEdit = () => {
      editMode.value = !editMode.value;
    };

    const cancelEdit = () => {
      editMode.value = false;
      fetchData(); // Reset the form with the latest data
    };

    const saveData = () => {
      isModalOpen.value = true;
    };

    const confirmSave = () => {
      isModalOpen.value = false;
      submitForm();
    };

    const closeModal = () => {
      isModalOpen.value = false;
    };

    const closeSaveResultModal = () => {
      isSaveResultModalOpen.value = false;
      saveResultTitle.value = '';
      saveResultMessage.value = '';
    };

    const submitForm = () => {
      if (!form.value.client_id || !form.value.admission_id) {
        message.value = 'Client ID and Admission ID are required.';
        messageType.value = 'error';
        clearMessage();
        return;
      }

      const url = `/api/cicl-progress-notes/${form.value.client_id}`;

      axios.put(url, form.value)
        .then(response => {
          editMode.value = false;
          saveResultTitle.value = 'Success';
          saveResultMessage.value = 'Data saved successfully!';
          isSaveResultModalOpen.value = true;
          fetchData(); // Re-fetch data to update the form with the latest saved data
        })
        .catch(error => {
          if (error.response && error.response.status === 422) {
            const errors = error.response.data.errors;
            message.value = 'Validation error: ' + Object.values(errors).flat().join(', ');
          } else {
            message.value = 'Failed to save data';
          }
          saveResultTitle.value = 'Error';
          saveResultMessage.value = message.value;
          isSaveResultModalOpen.value = true;
        });
    };

    const calculateAge = (birthDate) => {
      const today = new Date();
      const birthDateObj = new Date(birthDate);
      let age = today.getFullYear() - birthDateObj.getFullYear();
      const monthDiff = today.getMonth() - birthDateObj.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDateObj.getDate())) {
        age--;
      }
      return age;
    };

    const clearMessage = () => {
      setTimeout(() => {
        message.value = '';
        messageType.value = '';
      }, 3000);
    };

    const updatePage = (page) => {
      currentPage.value = page;
    };

    return {
      form,
      editMode,
      message,
      messageType,
      toggleEdit,
      cancelEdit,
      saveData,
      confirmSave,
      closeModal,
      closeSaveResultModal,
      currentPage,
      totalPages,
      isModalOpen,
      isSaveResultModalOpen,
      saveResultTitle,
      saveResultMessage,
      submitForm,
      calculateAge,
      clearMessage,
      updatePage,
    };
  },
};
</script>

<style scoped>
button {
  transition: background-color 0.3s;
}
button:hover {
  background-color: #2563eb;
}
.twinkle-border {
  animation: twinkle 2s infinite;
}
@keyframes twinkle {
  0%, 100% { border-color: #a1b6cf; }
  50% { border-color: white; }
}
</style>
