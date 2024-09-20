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

<!-- Page 1 -->
<div class="mx-auto p-8 rounded-lg max-w-full">
  <form @submit.prevent="submitForm" class="space-y-8 w-full">
    <div v-if="currentPage === 1" class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
      <div class="relative flex justify-between items-center mb-2">
        <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
        <p class="text-xs text-right">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
      </div>
      <div class="border-t-2 p-4 border-black text-center mt-4">
        <h1 class="text-lg font-bold uppercase">Republic of the Philippines</h1>
        <h2 class="text-sm font-semibold">
          Department of Social Welfare and Development
        </h2>
        <h3 class="text-sm">
          Regional Rehabilitation Center for Youth (RRCY)
        </h3>
        <p class="text-sm">
          Prk. 7 Bago Oshiro, Tugbok District, Davao City
        </p>
      </div>

      <!-- Identifying Data Section -->
      <div class="space-y-4 mt-6">
        <h2 class="text-center pt-4 border-t-2 border-black font-bold">INITIAL PSYCHOLOGICAL ASSESSMENT REPORT</h2>

        <!-- Success/Error Message -->
      

        <div class="space-y-2">
          <h2 class="font-bold">I. IDENTIFYING DATA</h2>

          <div class="ml-3 space-y-2">
            <!-- Name -->
            <div class="flex">
              <span class="mr-32 font-semibold">Name</span>
              <span class="w-1/12">:</span>
              <input
                type="text"
                v-model="form.name"
                class="p-1 border-b border-transparent focus:outline-none"
                readonly
              />
            </div>

            <!-- Nickname -->
            <div class="flex">
              <span class="mr-[98px] font-semibold">Nickname</span>
              <span class="w-1/12">:</span>
              <input
                type="text"
                v-model="form.nickname"
                class="p-1 border-b border-transparent focus:outline-none"
                :readonly="!editMode"
              />
            </div>

            <!-- Birth Date -->
            <div class="flex">
              <span class="mr-[97px] font-semibold">Birth Date</span>
              <span class="w-1/12">:</span>
              <input
                type="date"
                v-model="form.birth_date"
                class="p-1 border-b border-transparent focus:outline-none"
                readonly
              />
            </div>

            <!-- Age -->
            <div class="flex">
              <span class="mr-[142px] font-semibold">Age</span>
              <span class="w-1/12">:</span>
              <input
                type="number"
                v-model="form.age"
                class="p-1 border-b border-transparent focus:outline-none"
                readonly
              />
            </div>

            <!-- Gender -->
            <div class="flex">
              <span class="mr-[122px] font-semibold">Gender</span>
              <span class="w-1/12">:</span>
              <input
                type="text"
                v-model="form.gender"
                class="w-3/4 p-1 border-b border-transparent focus:outline-none"
                readonly
              />
            </div>

            <!-- Address -->
            <div class="flex">
              <span class="mr-[117px] font-semibold">Address</span>
              <span class="w-1/12">:</span>
              <input
                type="text"
                v-model="form.address"
                class="w-3/4 p-1 border-b border-transparent focus:outline-none"
                readonly
              />
            </div>

            <!-- Religion -->
            <div class="flex">
              <span class="mr-[117px] font-semibold">Religion</span>
              <span class="w-1/12">:</span>
              <input
                type="text"
                v-model="form.religion"
                class="w-3/4 p-1 border-b border-transparent focus:outline-none"
                readonly
              />
            </div>

            <!-- Educational Attainment -->
            <div class="flex">
              <span class="mr-[1px] font-semibold">Educational Attainment</span>
              <span class="w-1/12">:</span>
              <input
                type="text"
                v-model="form.educational_attainment"
                class="p-1 border-b border-transparent focus:outline-none"
                :readonly="!editMode"
              />
            </div>

            <!-- Offense Committed -->
            <div class="flex">
              <span class="mr-[29px] font-semibold">Offense Committed</span>
              <span class="w-1/12">:</span>
              <input
                type="text"
                v-model="form.offense_committed"
                class="p-1 border-b border-transparent focus:outline-none"
                readonly
              />
            </div>

            <!-- Date of Admission -->
            <div class="flex">
              <span class="mr-[38px] font-semibold">Date of Admission</span>
              <span class="w-1/12">:</span>
              <input
                type="date"
                v-model="form.admission_date"
                class="p-1 border-b border-transparent focus:outline-none"
                readonly
              />
            </div>

            <!-- Date of Report -->
            <div class="flex">
              <span class="mr-[65px] font-semibold">Date of Report</span>
              <span class="w-1/12">:</span>
              <input
                type="date"
                v-model="form.report_date"
                class="p-1 border-b border-transparent focus:outline-none"
                :readonly="!editMode"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- Reason for Referral Section -->
      <div class="space-y-4 mt-6">
        <h2 class="font-bold">REASON FOR REFERRAL</h2>
        <textarea id="reasonForReferral" v-model="form.reason_for_referral" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
      </div>

      <!-- Brief Background Section -->
      <div class="space-y-4 mt-6">
        <h2 class="font-bold">BRIEF BACKGROUND</h2>
        <div class="space-y-2">
          <label for="familyHistory" class="block font-medium">Family History</label>
          <textarea id="familyHistory" v-model="form.family_history" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
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
    </div>
  </form>
</div>

 <!-- Page 2 -->
 <div v-if="currentPage === 2" class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
  <div class="relative flex justify-end items-center mb-2">
            <p class="text-xs text-right">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
          </div>
 
          <div class="space-y-2">
            <label for="sexualDevelopment" class="block font-medium">Sexual Development</label>
            <textarea id="sexualDevelopment" v-model="form.sexual_development" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="medicalHistory" class="block font-medium">Medical and Psychological History</label>
            <textarea id="medicalHistory" v-model="form.medical_history" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="schoolHistory" class="block font-medium">School History</label>
            <textarea id="schoolHistory" v-model="form.school_history" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="socialHistory" class="block font-medium">Social History (including Spiritual Development and Work Experience)</label>
            <textarea id="socialHistory" v-model="form.social_history" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="personalCharacteristics" class="block font-medium">Personal Characteristics</label>
            <textarea id="personalCharacteristics" v-model="form.personal_characteristics" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
      
        <!-- Assessment Tools Section -->
        <div class="space-y-4 mt-6">
          <h2 class="font-bold">ASSESSMENT TOOLS</h2>
          <div class="space-y-2">
            <label for="reviewSystems" class="block font-medium">Review the major systems of psychiatric functioning (appearance, cognitive function, insight, etc.).</label>
            <textarea id="reviewSystems" v-model="form.review_systems" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="mentalStatus" class="block font-medium">Mental Status Examination</label>
            <textarea id="mentalStatus" v-model="form.mental_status" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="assessmentInterview" class="block font-medium">Gathering information about the client, assessing his strengths, level of adjustment, the nature and history of the problem, and relevant personal and family history.</label>
            <textarea id="assessmentInterview" v-model="form.assessment_interview" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
        </div>

        <!-- Test Result and Discussion Section -->
        <div class="space-y-4 mt-6">
          
          <h2 class="font-bold">TEST RESULT AND DISCUSSION</h2>
          <div class="space-y-2">
            <label for="testResult" class="block font-medium">Test Result and Discussion</label>
            <textarea id="testResult" v-model="form.test_result" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
        </div>
        <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
       <div class="flex justify-between items-center">
         <div class="flex flex-col">
           <p class="ml-24 -mb-4 font-bold">PAGE 2 of {{ totalPages }}</p>
           <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
           <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
         </div>
         <div class="ml-4">
           <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
         </div>
       </div>
     </div>
</div>



 <!-- Page 3 -->
 <div v-if="currentPage === 3" class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto border border-gray-200">
  <div class="relative flex justify-end items-center mb-2">
            <p class="text-xs text-right">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
          </div>
        <div class="space-y-4 mt-6">
          <h2 class="font-bold">CLINICAL IMPRESSION</h2>
          <textarea id="clinicalImpression" v-model="form.clinical_impression" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
        </div>

        <!-- Plan of Action Section -->
        <div class="space-y-4 mt-6">
          <h2 class="font-bold">PLAN OF ACTION</h2>
          <textarea id="planOfAction" v-model="form.plan_of_action" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
        </div>

        <!-- Signatures Section -->
        <div class="space-y-4 mt-6">
          <div class="space-y-2">
            <label for="preparedBy" class="block font-medium">Prepared by:</label>
            <input type="text" id="preparedBy" v-model="form.prepared_by" class="block w-full p-2 border border-gray-300 rounded-md " :readonly="!editMode">
          </div>
          <div class="space-y-2">
            <label for="notedBy" class="block font-medium">Noted by:</label>
            <input type="text" v-model="center_head" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
            <div class="text-xs mt-1">SWO IV / Center Head</div>
          </div>
          <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
       <div class="flex justify-between items-center">
         <div class="flex flex-col">
           <p class="ml-24 -mb-4 font-bold">PAGE 3 of {{ totalPages }}</p>
           <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
           <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
         </div>
         <div class="ml-4">
           <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
         </div>
       </div>
     </div>
 </div>
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
import Pagination from '@/Components/Pagination.vue';

export default {
  name: 'InitialPsychologicalAssessmentForm',
  components: {
    Pagination,
  },
  data() {
    return {
      center_head: '',
      form: {
        id: null,
        client_id: null,
        nickname: '',
        name: '',
        birth_date: '',
        age: '',
        gender: '',
        address: '',
        religion: '',
        educational_attainment: '',
        offense_committed: '',
        admission_date: '',
        report_date: '',
        reason_for_referral: '',
        family_history: '',
        sexual_development: '',
        medical_history: '',
        school_history: '',
        social_history: '',
        personal_characteristics: '',
        review_systems: '',
        mental_status: '',
        assessment_interview: '',
        test_result: '',
        clinical_impression: '',
        plan_of_action: '',
        prepared_by: '',
      },
      editMode: false,
      message: '',
      messageType: '', // 'success' or 'error'
      totalPages: 3,
      currentPage: 1,
      isModalOpen: false,
      isSaveResultModalOpen: false,
      saveResultTitle: '',
      saveResultMessage: '',
    };
  },
  mounted() {
    this.fetchData();
  },
  watch: {
    '$route.params.id': 'fetchData',
  },
  methods: {
    fetchData() {
      const clientId = this.$route.params.id;
      console.log('Client ID:', clientId); // Log the client ID to the console
      this.fetchCenterHead(clientId);
      if (clientId) {
        axios.get(`/api/initial-psychological-assessments/${clientId}`)
          .then(response => {
            if (response.data.assessment) {
              Object.assign(this.form, response.data.assessment);
              this.form.client_id = clientId;
              this.form.admission_id = response.data.admission.id;
              
              // Assign additional fields from client and admission, making them non-editable
              const client = response.data.client;
              const admission = response.data.admission;
              this.form.name = `${client.first_name} ${client.last_name}`;
              this.form.birth_date = client.date_of_birth;
              this.form.age = this.calculateAge(client.date_of_birth);
              this.form.gender = client.sex;
              this.form.address = `${client.street}, ${client.barangay}, ${client.city}, ${client.province}`;
              this.form.religion = client.religion;
              this.form.offense_committed = admission.offense_committed;
              this.form.admission_date = admission.date_admitted;
            } else {
              const { client, admission, highest_educ_att } = response.data;
              this.form.client_id = client.id;
              this.form.admission_id = admission.id;
              this.form.name = `${client.first_name} ${client.last_name}`;
              this.form.birth_date = client.date_of_birth;
              this.form.age = this.calculateAge(client.date_of_birth);
              this.form.gender = client.sex;
              this.form.address = `${client.street}, ${client.barangay}, ${client.city}, ${client.province}`;
              this.form.religion = client.religion;
              this.form.offense_committed = admission.offense_committed;
              this.form.educational_attainment = highest_educ_att;
              this.form.admission_date = admission.date_admitted;
              this.form.report_date = new Date().toISOString().split('T')[0];
            }
          })
          .catch(error => {
            console.error('Error fetching data:', error);
          });
      }
    },
    fetchCenterHead(clientId) {
    if (!clientId) {
      console.error("Client ID is missing.");
      return;
    }
    // Make an API request using the client ID
    axios.get(`/api/center-head/${clientId}`)
      .then(response => {
        this.center_head = response.data.center_head;
        console.log("Fetched center head:", this.center_head); // Log the center head
      })
      .catch(error => {
        console.error("Error fetching center head:", error);
      });
  },
  // Save center head
  saveCenterHead() {
    const clientId = this.$route.params.id;
    if (!this.center_head || !clientId) {
      return;
    }
    axios
      .put(`/api/update-center-head`, {
        center_head: this.center_head,
        client_id: clientId, // Use the correct client ID
      })
      .then(response => {
        this.editMode = false;
        this.fetchClientData(clientId); // Refetch the data to update the UI
      })
      .catch(error => {
        console.error("Error updating center head:", error);
      });
  },

    toggleEdit() {
      this.editMode = !this.editMode;
    },
    cancelEdit() {
      this.editMode = false;
      this.fetchData(); // Reset the form with the latest data
    },
    saveData() {
      this.isModalOpen = true;
    },
    confirmSave() {
      this.isModalOpen = false;
      this.submitForm();
      this.saveCenterHead();
    },
    closeModal() {
      this.isModalOpen = false;
    },
    closeSaveResultModal() {
      this.isSaveResultModalOpen = false;
      this.saveResultTitle = '';
      this.saveResultMessage = '';
    },
    submitForm() {
      if (!this.form.client_id || !this.form.admission_id) {
        this.message = 'Client ID and Admission ID are required.';
        this.messageType = 'error';
        return;
      }

      const url = this.form.id 
        ? `/api/initial-psychological-assessments/${this.form.id}` 
        : `/api/initial-psychological-assessments`;

      const method = this.form.id ? 'put' : 'post';

      axios[method](url, this.form)
        .then(response => {
          this.editMode = false;
          this.saveResultTitle = 'Success';
          this.saveResultMessage = 'Data saved successfully!';
          this.isSaveResultModalOpen = true;
          this.fetchData(); // Re-fetch data to update the form with the latest saved data
        })
        .catch(error => {
          if (error.response && error.response.status === 422) {
            const errors = error.response.data.errors;
            this.message = 'Validation error: ' + Object.values(errors).flat().join(', ');
          } else {
            this.message = 'Failed to save data';
          }
          this.saveResultTitle = 'Error';
          this.saveResultMessage = this.message;
          this.isSaveResultModalOpen = true;
        });
    },
    calculateAge(birthDate) {
      const today = new Date();
      const birthDateObj = new Date(birthDate);
      let age = today.getFullYear() - birthDateObj.getFullYear();
      const monthDiff = today.getMonth() - birthDateObj.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDateObj.getDate())) {
        age--;
      }
      return age;
    },
    updatePage(page) {
      this.currentPage = page;
    },
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
