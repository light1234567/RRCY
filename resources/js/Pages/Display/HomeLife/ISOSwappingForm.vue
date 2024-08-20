<template>
 
    <!-- Action Tabs -->
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

      <button v-if="editMode" @click="submitForm" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span>Save</span>
      </button>
    </div>

    <div class="max-w-3xl mx-auto mt-12 p-16 bg-white border border-gray-300 rounded-lg shadow-lg">
    <div class="text-center mb-8">
      <div class="flex justify-between items-center mb-4">
        <img src="/images/headerlogo2.png" alt="DSWD Logo"  class="h-32 w-64 -mt-16 relative z-10" />
        <div class="text-right">
          <p class="item-center mr-6 text-sm font-semibold">PROTECTIVE SERVICES DIVISION</p>
          <p class=" text-sm font-semibold">Regional Rehabilitation Center for Youth</p>
          <p class="mr-20 text-sm font-semibold">Youth/RFO XI</p>
          <p class="pt-12">DRN: ______________________</p>
        </div>
      </div>
      <h1 class="font-bold text-xl">REGIONAL REHABILITATION CENTER FOR YOUTH</h1>
      <p>Bago Oshiro Tugbok dist. Davao City</p>
    </div>

    <!-- Date of Filing Section -->
    <div class="mb-6 flex items-center justify-end">
      <label for="dateOfFiling" class="block font-medium">Date of Filing:</label>
      <input type="date" v-model="form.date_of_filing" id="dateOfFiling" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none ml-2 shadow-sm w-1/4 text-right" :readonly="!editMode">
    </div>

    <!-- Requesting Party Details -->
    <div class="grid grid-cols-2 gap-4 mb-6">
      <div>
        <label for="requestingPartyName" class="block font-medium">Name of Requesting Party:</label>
        <input type="text" v-model="form.requesting_party_name" id="requestingPartyName" 
              class="border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm w-3/4" 
              :readonly="!editMode">
      </div>
      <div>
        <label for="dateOfDuty" class="block font-medium">Date of Duty:</label>
        <input type="date" v-model="form.date_of_duty" id="dateOfDuty" 
              class="border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm w-3/4" 
              :readonly="!editMode">
      </div>
      <div>
        <label for="requestingPartyPosition" class="block font-medium">Position:</label>
        <input type="text" v-model="form.requesting_party_position" id="requestingPartyPosition" 
              class="border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm w-3/4" 
              :readonly="!editMode">
      </div>
      <div>
        <label for="timeOfDuty" class="block font-medium">Time of Duty:</label>
        <input type="time" v-model="form.time_of_duty" id="timeOfDuty" 
              class="border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm w-3/4" 
              :readonly="!editMode">
      </div>
    </div>


    <!-- SOD Section -->
    <div class="mb-6">
    <p class="font-bold"></p>
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label for="sodName" class="block font-medium">Name of SOD accepted the request:</label>
        <input type="text" v-model="form.sod_name" id="sodName" 
              class="border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm w-3/4" 
              :readonly="!editMode">
      </div>
      <div>
        <label for="sodDateOfDuty" class="block font-medium">Date of Duty:</label>
        <input type="date" v-model="form.sod_date_of_duty" id="sodDateOfDuty" 
              class="border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm w-3/4" 
              :readonly="!editMode">
      </div>
      <div>
        <label for="sodPosition" class="block font-medium">Position:</label>
        <input type="text" v-model="form.sod_position" id="sodPosition" 
              class="border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm w-3/4" 
              :readonly="!editMode">
      </div>
      <div>
        <label for="sodShiftTime" class="block font-medium">Shift/Time of Duty:</label>
        <input type="text" v-model="form.sod_shift_time" id="sodShiftTime" 
              class="border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm w-3/4" 
              :readonly="!editMode">
      </div>
    </div>
  </div>


    <!-- Purpose Section -->
    <div class="mb-6">
      <label for="purpose" class="block font-medium">Purpose:</label>
      <textarea v-model="form.purpose" id="purpose" rows="4" class="border border-gray-400 p-2 rounded-md w-full" :readonly="!editMode"></textarea>
    </div>

    <!-- Requested and Accepted By Section -->
    <div class="grid grid-cols-2 gap-4 mb-6">
      <div>
        <label for="requestedBy" class="block font-medium">Requested by:</label>
        <input type="text" v-model="form.requested_by" id="requestedBy" class="border-b-2 mb-4 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm w-3/4" 
        :readonly="!editMode">
        <div class="mb-6 flex justify-start items-center">
          <label for="requestedPosition" class="block font-medium">Position:</label>
    <input type="text" v-model="form.requesting_party_position" id="requestedPosition" 
          class="border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm w-1/2" 
          :readonly="!editMode">
        </div>
      </div>
      <div>
        <label for="acceptedBy" class="block font-medium">Accepted by:</label>
        <input type="text" v-model="form.accepted_by" id="acceptedBy" class="border-b-2 mb-4 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm w-3/4" :readonly="!editMode">
        <div class="mb-6 flex justify-start items-center">
        <label for="acceptedPosition" class="block font-medium">Position:</label>
        <input type="text" v-model="form.accepted_by_position" id="acceptedPosition" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm w-1/2" :readonly="!editMode">
      </div>
      </div>
    </div>

    <!-- Noted by and Approved by -->
    <div class="mb-6 flex justify-between items-start">
      <!-- Noted by Section -->
      <div class="w-1/2 mr-12">
        <label for="notedBy" class="block text-sm font-medium">Noted by:</label>
        <input
          type="text"
          id="notedBy"
          v-model="form.noted_by"
          class="mt-1 w-3/4 border-b-2 text-sm border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm"
          :readonly="!editMode"
        >
        <p class="text-sm">HP III/SHP</p>
      </div>

      <!-- Approved by Section -->
      <div class="w-1/2">
        <label for="approvedBy" class="block text-sm font-medium">Approved by:</label>
        <input
          type="text"
          id="approvedBy"
          v-model="form.approved_by"
          class="mt-1 w-3/4 border-b-2 border-black text-sm border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm"
          readonly
        >
        <p class="text-sm">SWO IV / Center Head</p>
      </div>
    </div>

   <!-- Footer Section -->
   <div class="border-gray-300 ml-6 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        <div class="flex flex-col">
          <p class="ml-24 -mb-4 font-bold">PAGE 1 of 1</p>
          <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
          <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
        </div>
        <div class="ml-4">
          <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
        </div>
      </div>
    </div>

    <!-- Modals for Save Confirmation and Result -->
    <!-- Modal for Save Confirmation -->
    <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50">
      <div class="fixed inset-0 bg-black opacity-50"></div>
      <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
        <div class="bg-white p-6">
          <div class="flex items-center">
            <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.93 5h13.86c1.1 0 1.96-.9 1.84-1.98l-1.18-12.14a2 2 0 00-1.98-1.88H4.27a2 2 0 00-1.98 1.88L1.11 16.02c-.12 1.08.74 1.98 1.84 1.98z"/>
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
  </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import Pagination from '@/Components/Pagination.vue';

export default {
  name: 'SwappingForm',
  components: {
    Pagination,
  },
  setup() {
    const form = ref({
      client_id: null,
      drn: '',
      date_of_filing: '',
      requesting_party_name: '',
      requesting_party_position: '',
      date_of_duty: '',
      time_of_duty: '',
      sod_name: '',
      sod_date_of_duty: '',
      sod_position: '',
      sod_shift_time: '',
      purpose: '',
      requested_by: '',
      accepted_by: '',
      noted_by: 'VAN M. DE LEON',
      approved_by: 'ANGELIC B. PAÑA',
    });

    const originalForm = ref(null);
    const editMode = ref(false);
    const message = ref('');
    const messageType = ref('');
    const isModalOpen = ref(false);
    const isSaveResultModalOpen = ref(false);
    const saveResultTitle = ref('');
    const saveResultMessage = ref('');
    const route = useRoute();

    const currentPage = ref(1);
    const totalPages = ref(1);

    const fetchData = () => {
      const clientId = route.params.id;
      if (clientId) {
        axios.get(`/api/swapping-forms/${clientId}`).then(response => {
          if (response.data.form) {
            form.value = response.data.form;
            form.value.client_id = clientId;
            originalForm.value = JSON.parse(JSON.stringify(form.value));
          } else {
            form.value.client_id = clientId;
          }
        }).catch(error => {
          console.error('Error fetching data:', error);
        });
      }
    };

    onMounted(fetchData);

    const toggleEdit = () => {
      if (editMode.value) {
        openModal();
      } else {
        originalForm.value = JSON.parse(JSON.stringify(form.value));
        editMode.value = true;
      }
    };

    const openModal = () => {
      isModalOpen.value = true;
    };

    const closeModal = () => {
      isModalOpen.value = false;
    };

    const confirmSave = () => {
      submitForm();
      closeModal();
    };

    const cancelEdit = () => {
      if (originalForm.value) {
        form.value = JSON.parse(JSON.stringify(originalForm.value));
      }
      editMode.value = false;
    };

    const submitForm = () => {
      if (!form.value.client_id) {
        message.value = 'Client ID is required.';
        messageType.value = 'error';
        return;
      }

      const url = `/api/swapping-forms/${form.value.client_id}`;

      axios.put(url, form.value)
        .then(response => {
          editMode.value = false;
          message.value = 'Data updated successfully!';
          messageType.value = 'success';
          saveResultTitle.value = 'Success';
          saveResultMessage.value = 'Data saved successfully.';
          isSaveResultModalOpen.value = true;
          clearMessage();
          fetchData();
        })
        .catch(error => {
          message.value = 'Failed to update data';
          messageType.value = 'error';
          saveResultTitle.value = 'Error';
          saveResultMessage.value = error.response?.data?.message || 'Error saving data.';
          isSaveResultModalOpen.value = true;
          clearMessage();
        });
    };

    const clearMessage = () => {
      setTimeout(() => {
        message.value = '';
        messageType.value = '';
      }, 3000);
    };

    const closeSaveResultModal = () => {
      isSaveResultModalOpen.value = false;
      saveResultTitle.value = '';
      saveResultMessage.value = '';
    };

    return {
      form,
      editMode,
      message,
      messageType,
      toggleEdit,
      submitForm,
      isModalOpen,
      openModal,
      closeModal,
      confirmSave,
      currentPage,
      totalPages,
      isSaveResultModalOpen,
      saveResultTitle,
      saveResultMessage,
      closeSaveResultModal,
      cancelEdit,
    };
  },
};
</script>

<style scoped>
/* Add custom styles here */
</style>
