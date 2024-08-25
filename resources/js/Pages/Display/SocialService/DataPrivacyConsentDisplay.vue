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
      <Pagination :totalPages="totalPages" :currentPage="currentPage" @update:currentPage="updatePage" />
      <button @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.3 2.7a1 1 0 011.4 0l1.3 1.3a1 1 0 010 1.4l-9.4 9.4a1 1 0 01-.6.3l-2.8.6a1 1 0 01-1.2-1.2l.6-2.8a1 1 0 01.3-.6l9.4-9.4z" />
        </svg>
        <span>Edit</span>
      </button>

      <button v-if="editMode" @click="openModal" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span>Save</span>
      </button>
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
          <button @click="closeSaveResultModal" :class="saveResultTitle === 'Error' ? 'bg-red-600 hover:bg-red-500' : 'bg-blue-600 hover:bg-blue-500'" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">OK</button>
        </div>
      </div>
    </div>
  
    <div v-if="currentPage === 1" class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
        <div class="flex items-center justify-between mb-4">
          <img src="/images/headerlogo2.png" alt="DSWD Logo" class="h-32 w-64 relative z-10">
          <div class="text-right">
            <p class="text-xs">DSPTD-QF-01-A | REV 01 | 12 SEP 2023</p>
          </div>
        </div>
        <h1 class="text-2xl font-bold text-center mb-4">DATA PRIVACY CONSENT</h1>
        <div class="flex justify-end items-center mb-4">
          <label class="text-gray-700 mr-4">Date:</label>
          <input 
            type="date" 
            class="mt-1 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-1/5"
            v-model="form.date" 
            :readonly="!editMode"
          >
        </div>
        <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
          {{ message }}
        </div>
        <div class="mb-6">
          <p>To Whom It May Concern:</p>
          <p class="mt-4 text-justify">
            I, <span class="font-bold underline">{{ clientName }}</span>, give my consent for the information concerning my file to be furnished by the DSWD-Regional Rehabilitation Center for Youth (RRCY) and/or its authorized personnel to Philippine courts, concerned local government units, and legal professionals. I request that any relevant information that may be required for purposes enumerated hereunder be provided in accordance with the provisions of the Data Privacy Act of 2012:
          </p>
          <ol class="list-decimal ml-6 mt-4 text-justify">
            <li>To assist in responding to Criminal Cases (Court, Lawyer, Prosecutor)</li>
            <li>To report to the PNP any untoward incident by the resident</li>
            <li>To request reports from the concerned LGUs e.g. Parenting Capability Assessment Report (PCAR), Transfer Summary Report and LGU Claims</li>
            <li>To assist in responding to the health needs (medical, psychological), school requirements and training agencies (LTO, TESDA, etc)</li>
            <li>To assist in the provision of financial assistance intended for basic needs, travel expenses, and medical needs</li>
            <li>To submit monthly, quarterly, semestral and annual reports to the Field Office and Central Office</li>
          </ol>
          <p class="mt-4 text-justify">
            I understand and accept that this will include access to personal data and records submitted, which may be considered sensitive personal data as provided for under Republic Act No. 10173, otherwise known as the Data Privacy Act of 2012.
          </p>
          <p class="mt-4 text-justify">
            Further, any records and related information associated with my case shall be kept from any and all public disclosure and shall be retained only for as long as necessary for the fulfillment of the purposes above-stated.
          </p>
          <p class="mt-4 text-justify">
            I understand and agree that this consent will remain valid and in force until I revoke it in writing.
          </p>
        </div>
        <div class="flex justify-between items-center mt-8">
          <div>
          <input 
            type="text" 
            class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" 
            v-model="form.client_signature" 
            :readonly="!editMode"
          >
          <label class="block text-gray-700">Name and signature (Client):</label>
        </div>

         
        </div>
        <div class="border-gray-300 ml-6 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
         <div class="flex justify-between items-center">
           <div class="flex flex-col">
             <p class="ml-24 -mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
             <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
             <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
           </div>
           <div class="ml-4">
             <img src="/images/footerimg.png" alt="" class="h-12 w-24 object-cover rounded-md">
           </div>
         </div>
       </div>
      </div>

      <!-- Page 2 -->
      <div v-if="currentPage === 2" class="max-w-3xl p-10 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
        <div class="text-right mb-4">
          <p class="text-xs">DSPTD-QF-01-A | REV 01 | 12 SEP 2023</p>
        </div>
        <div class="mt-24 mb-6">
          <input 
            type="text" 
            class="mt-1 w-1/3 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" 
            v-model="form.guardian_signature" 
            :readonly="!editMode"
          >
          <label class="block  text-gray-700 mb-2">Name and signature (Parent/Guardian):</label>
        </div>
        <div class="border-gray-300 ml-6 mt-[700px] text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
         <div class="flex justify-between items-center">
           <div class="flex flex-col">
             <p class="ml-24 -mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
             <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
             <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
           </div>
           <div class="ml-4">
             <img src="/images/footerimg.png" alt="" class="h-12 w-24 object-cover rounded-md">
           </div>
         </div>
       </div>
    </div>
   
 
  </template>
 <script>
 import axios from 'axios';
 import Pagination from '@/Components/Pagination.vue'; 
 
 export default {
   components: {
     Pagination,
   },
   data() {
     return {
       editMode: false,
       message: '',
       messageType: '',
       form: {
         client_id: null,
         client_signature: '',
         date: '',
         guardian_signature: '',
         id: null,
       },
       clientName: '',
       errorMessage: '',
       isModalOpen: false,
       isSaveResultModalOpen: false,
       saveResultTitle: '',
       saveResultMessage: '',
       totalPages: 2,
       currentPage: 1,
     };
   },
   mounted() {
     const id = this.$route.params.id;
     console.log('Client ID fetched:', id); // Console log showing client ID
     if (id) {
       this.fetchClientData(id);
     }
   },
   watch: {
     '$route.params.id': function(newId) {
       console.log('Client ID changed:', newId); // Console log showing updated client ID
       if (newId) {
         this.fetchClientData(newId);
       }
     }
   },
   methods: {
     async fetchClientData(clientId) {
       try {
         const clientResponse = await axios.get(`/api/clients/${clientId}`);
         const client = clientResponse.data;
         this.clientName = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
         this.form.client_id = client.id;
 
         const consentResponse = await axios.get(`/api/data-privacy-consent/${clientId}`);
         const consent = consentResponse.data;
         this.form.client_signature = consent.client_signature || '';
         this.form.date = consent.date || '';
         this.form.guardian_signature = consent.guardian_signature || '';
         this.form.id = consent.id;
       } catch (error) {
         this.errorMessage = 'Error fetching client data.';
         console.error('Error fetching client data:', error);
       }
     },
     toggleEdit() {
       if (this.editMode) {
         this.openModal();
       } else {
         this.editMode = true;
       }
     },
     async saveData() {
       if (!this.form.client_id) {
         this.message = 'Client ID is missing.';
         this.messageType = 'error';
         setTimeout(() => {
           this.message = '';
         }, 3000);
         return;
       }
 
       try {
         const response = await axios({
           method: this.form.id ? 'put' : 'post',
           url: `/api/data-privacy-consent${this.form.id ? '/' + this.form.id : ''}`,
           data: this.form,
         });
         this.saveResultTitle = 'Success';
         this.saveResultMessage = 'Data saved successfully!';
         if (!this.form.id) {
           this.form.id = response.data.id;
         }
         this.editMode = false;
       } catch (error) {
         this.saveResultTitle = 'Error';
         this.saveResultMessage = 'Error saving data.';
         console.error('Error saving data:', error);
       } finally {
         this.closeModal();
         this.isSaveResultModalOpen = true;
       }
     },
     openModal() {
       this.isModalOpen = true;
     },
     closeModal() {
       this.isModalOpen = false;
     },
     confirmSave() {
       this.saveData();
     },
     closeSaveResultModal() {
       this.isSaveResultModalOpen = false;
       this.saveResultTitle = '';
       this.saveResultMessage = '';
     },
     cancelEdit() {
       this.editMode = false;
     },
     updatePage(page) {
       this.currentPage = page;
     }
   }
 };
 </script>