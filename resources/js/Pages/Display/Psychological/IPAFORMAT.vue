<template>
  <!-- Tabs for Actions -->
  <div v-if="editMode" class="flex absolute p-4 space-x-4">
      <button @click="cancelEdit" class="flex space-x-2 px-3 py-3 bg-[conic-gradient(at_bottom_right,_var(--tw-gradient-stops))] from-blue-700 via-blue-800 to-gray-900 text-white rounded-md text-xs">
        <!-- FontAwesome for Back -->
        <i class="fas fa-arrow-left w-4 h-4"></i>
        <span>Back</span>
      </button>
  </div>
  
  <div class="flex -ml-2 justify-end bg-transparent border -mr-9 border-gray-300 p-4 space-x-4 -mt-9">
      <!-- Pagination Component -->
      <Pagination 
        :totalPages="totalPages" 
        :currentPage="currentPage" 
        @update:currentPage="currentPage = $event" 
      />
      <button @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
        <!-- FontAwesome for Edit -->
        <i class="fas fa-edit w-4 h-4"></i>
        <span>Edit</span>
      </button>
  
      <button v-if="editMode" @click="submitForm" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
        <!-- FontAwesome for Save -->
        <i class="fas fa-check w-4 h-4"></i>
        <span>Save</span>
      </button>
  
      <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 text-white rounded-md text-xs">
        <!-- FontAwesome for PDF Download -->
        <i class="fas fa-file-pdf w-4 h-4"></i>
        <span>Export PDF</span>
      </button>
  
  </div>
    
  
  <!-- Page 1 -->
  <form ref="IPAForm" @submit.prevent="submitForm" class="space-y-8 w-full">
    <div class="-mt-8 mx-auto p-8 rounded-lg max-w-full" style="width: 8.5in; height: 13in;">
    
      <div v-if="currentPage === 1" class="max-w-3xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
        <div class="relative flex justify-between items-center mb-2">
          <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
          <p class="text-xs text-right italic">DSWD-GF-010 | REV 02 | 22 SEP 2023</p>
        </div>
     
  
        <!-- Identifying Data Section -->
        <div class="space-y-4 mt-6">
          <h2 class="text-center pt-4 border-none font-bold">INITIAL PSYCHOLOGICAL ASSESSMENT REPORT (IPA)        </h2>
          <h2 style="color: red;" class="text-center text-sm pt-0 border-none font-bold text  ">(Strictly Confidential / Not for Legal Use)</h2>
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
          <h2 class="font-bold">II. REASON FOR REFERRAL</h2>
          <textarea 
  id="reasonForReferral" 
  v-model="form.reason_for_referral" 
  class="block w-full p-2 border border-gray-300 rounded-md" 
  :readonly="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide a reason for referral') }" 
  required
></textarea>
        </div>
  
        <!-- Brief Background Section -->
        <div class="space-y-4 mt-6">
          <h2 class="font-bold">III. BRIEF BACKGROUND</h2>
          <div class="space-y-2">
            <label for="familyHistory" class="block font-bold">Family History</label>
            <textarea 
  id="familyHistory" 
  v-model="form.family_history" 
  class="block w-full p-2 border border-gray-300 rounded-md" 
  :readonly="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide family history information') }" 
  required
></textarea>
          </div>
        </div>
  
        <div class=" border-gray-300 pt-4 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;"> 
      <div class="flex justify-between items-start w-full">
          <div class="flex flex-col w-full"> <!-- Expanded width for the text section -->
              <p class="font-bold">PAGE 1 of 1</p>
              <p class="border-t-2 border-black"></p>
              <p class="pt-2">DSWD Field Office XI , Ramon Magsaysay Avenue corner Damaso Suazo Street, Davao City, Philippines 8000</p>
              <p > Website: <span class="text-blue-600 underline">http://www.dswd.gov.ph </span>Tel Nos.: (082) 227-1964 Email: <span class="text-blue-600 underline">fo11@dswd.gov.ph </span> </p>
          </div>
          <div class="w-1/6 flex justify-end"> <!-- Restricting the image section to the right side -->
              <img src="/images/footerimg.png" alt="Footer Image" class="h-12 w-32 object-cover"> <!-- Expanded width for image -->
          </div>
      </div>
  </div>
</div>
  
  
   <!-- Page 2 -->
    
   <div v-if="currentPage === 2" class="max-w-3xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
    <div class="relative flex justify-end items-center mb-2">
              <p class="text-xs text-right">DSWD-GF-010 | REV 02 | 22 SEP 2023</p>
            </div>
   
            <div class="space-y-2">
              <label for="sexualDevelopment" class="block font-bold">Sexual Development</label>
              <textarea 
  id="sexualDevelopment" 
  v-model="form.sexual_development" 
  class="block w-full p-2 border border-gray-300 rounded-md" 
  :readonly="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide details on sexual development') }" 
  required
></textarea>
            </div>
            <div class="space-y-2 mt-20">
              <label for="medicalHistory" class="block font-bold">Medical and Psychological History</label>
              <textarea 
  id="medicalHistory" 
  v-model="form.medical_history" 
  class="block w-full p-2 border border-gray-300 rounded-md" 
  :readonly="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide medical history') }" 
  required
></textarea>
            </div>
            <div class="space-y-2 mt-20">
              <label for="schoolHistory" class="block font-bold">School History</label>
              <textarea 
  id="schoolHistory" 
  v-model="form.school_history" 
  class="block w-full p-2 border border-gray-300 rounded-md" 
  :readonly="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the school history') }" 
  required
></textarea>
            </div>
            <div class="space-y-2 mt-20">
              <label for="socialHistory" class="block font-bold">Social History (including Spiritual Development and Work Experience)</label>
              <textarea 
  id="socialHistory" 
  v-model="form.social_history" 
  class="block w-full p-2 border border-gray-300 rounded-md" 
  :readonly="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide social history information') }" 
  required
></textarea>
            </div>
            <div class="space-y-2 mt-20">
              <label for="personalCharacteristics" class="block font-bold">Personal Characteristics</label>
              <textarea 
  id="personalCharacteristics" 
  v-model="form.personal_characteristics" 
  class="block w-full p-2 border border-gray-300 rounded-md" 
  :readonly="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide personal characteristics') }" 
  required
></textarea>
            </div>
        
          <div class="space-y-4 mt-20">
            <h2 class="font-bold">IV. ASSESSMENT TOOLS</h2>
            <div class="space-y-2">
              <label for="assessmentInterview" class="block font-medium"></label>
              <textarea 
  id="assessmentInterview" 
  v-model="form.assessment_interview" 
  class="block w-full p-2 border border-gray-300 rounded-md" 
  :readonly="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide an assessment interview') }" 
  required
></textarea>
            </div>
          </div>
  
  
          
          <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
    <div class="flex justify-between items-center">
      
      <!-- Left Section: Page number -->
      <div class="flex flex-col flex-grow">
        <!-- Page number centered -->
        <p class="text-center -mb-1 font-bold">PAGE 2 of {{ totalPages }}</p>
  
      <!-- Continuous horizontal line, moved to the left with space on the right -->
      <div style="border-top: 2px solid black; width: 103%; margin-top: 4px; margin-left: -24px;"></div>
  
  
        <!-- Text under the line -->
        <p class="text-[11px] " style="text-align: center; font-weight: bold; margin-top: -1px;">DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH</p>
      </div>
  
    </div>
          </div>
       </div>
  
  
  
  
   <!-- Page 3 -->
   <div v-if="currentPage === 3" class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto border border-gray-200">
    <div class="relative flex justify-end items-center mb-2">
              <p class="text-xs text-right">DSWD-GF-010 | REV 02 | 22 SEP 2023</p>
            </div>
  
            <div class="space-y-4 mt-6">
            
            <h2 class="font-bold">V. TEST RESULT AND DISCUSSION</h2>
            <div class="space-y-2">
              <textarea 
  id="testResult" 
  v-model="form.test_result" 
  class="block w-full p-2 border border-gray-300 rounded-md" 
  :readonly="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the test result') }" 
  required
></textarea>
            </div>
          </div>
  
  
          <div class="space-y-4 mt-20">
            <h2 class="font-bold">VI. CLINICAL IMPRESSION</h2>
            <textarea 
  id="clinicalImpression" 
  v-model="form.clinical_impression" 
  class="block w-full p-2 border border-gray-300 rounded-md" 
  :readonly="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide a clinical impression') }" 
  required
></textarea>
          </div>
  
          <!-- Plan of Action Section -->
          <div class="space-y-4 mt-20">
            <h2 class="font-bold">VII. PLAN OF ACTION</h2>
            <textarea 
  id="planOfAction" 
  v-model="form.plan_of_action" 
  class="block w-full p-2 border border-gray-300 rounded-md" 
  :readonly="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide a plan of action') }" 
  required
></textarea>
          </div>
  
          <div class="space-y-4 mt-20">
            <div class="space-y-2">
              <label for="preparedBy" class="block mb-12 mt-12 font-sm">Prepared by:</label>
              <div class="flex flex-col">
                <strong> 
    <input
      type="text"
      value="BRYAN V. GALANG"
      class="w-full text-base w-48 -mr-12 mt-1 pl-0 border-none shadow-none"
      :readonly="!editMode"
    >
  </strong>
  
                <span>Psychologist I</span>
              </div>
            </div>
            <div class="space-y-2 mt-4">
              <label for="notedBy" class="block mb-12 mt-12 font-sm">Noted by:</label>
              <div class="flex flex-col">
                <strong><input type="text" v-model="center_head" class="block w-full p-0 border border-transparent rounded-md" :readonly></strong>
                <span>SWO IV / Center Head</span>
              </div>
            </div>
  
            <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
    <div class="flex justify-between items-center">
      
      <!-- Left Section: Page number -->
      <div class="flex flex-col flex-grow">
        <!-- Page number centered -->
        <p class="text-center -mb-1 font-bold">PAGE 3 of {{ totalPages }}</p>
  
      <!-- Continuous horizontal line, moved to the left with space on the right -->
      <div style="border-top: 2px solid black; width: 103%; margin-top: 4px; margin-left: -24px;"></div>
  
  
        <!-- Text under the line -->
        <p class="text-[10.5px] " style="text-align: center; font-weight: bold; margin-top: -1px;">DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH</p>
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
   </div>
  </form>
  </template>
  
  <script>
  import axios from 'axios';
  import Pagination from '@/Components/Pagination.vue';
  import { jsPDF } from 'jspdf';
  
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
      this.fetchCenterHead();
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
    
      fetchCenterHead() {
      axios.get('/api/center-head')  // Replace with the correct API route
        .then(response => {
          this.center_head = response.data.name;  // Bind the fetched name to v-model
        })
        .catch(error => {
          console.error('Error fetching center head:', error);
        });
    },
    
      toggleEdit() {
        this.editMode = !this.editMode;
      },
      cancelEdit() {
        this.editMode = false;
        this.fetchData(); // Reset the form with the latest data
      },
      openModal() {
        this.isModalOpen = true;
        console.log('Modal opened');
      },
      closeModal() {
        this.isModalOpen = false;
        console.log('Modal closed');
      },
      closeSaveResultModal() {
        this.isSaveResultModalOpen = false;
        this.saveResultTitle = '';
        this.saveResultMessage = '';
      },
      submitForm() {
  const totalPages = this.totalPages;
  let allFieldsValid = true;
  
  const checkValidityPerPage = (page) => {
    // Set the current page
    this.currentPage = page;
    
    // Use $nextTick to ensure the page has been rendered before validating
    this.$nextTick(() => {
      const form = this.$refs.IPAForm; // Ensure that the form is correctly referenced
      
      // Check if the form is valid
      if (!form.checkValidity()) {
        allFieldsValid = false;
        form.reportValidity(); // Display validation errors
      }
      
      // If fields are valid, move to the next page
      if (allFieldsValid && page < totalPages) {
        checkValidityPerPage(page + 1);
      } else if (!allFieldsValid) {
        console.warn('Form has invalid fields, please correct them.');
      } else if (allFieldsValid && page === totalPages) {
        // If we reached the last page and all fields are valid, open the confirmation modal
        this.isModalOpen = true;
      }
    });
  };

  // Start checking the validity from page 1
  checkValidityPerPage(1);
}
,

confirmSave() {
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
      this.isModalOpen = false;
      this.isSaveResultModalOpen = true; // Open the result modal
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
      this.isSaveResultModalOpen = true; // Open the result modal on error
    });
}
,
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
      exportToPdf() {
        const pdf = new jsPDF('p', 'mm', [216, 356]);
    const pageHeight = 356; // Total page height in mm
    const marginBottom = 30; // Bottom margin in mm
    const rowHeight = 10; // Height of each row
    const lineHeight = 7; // Space between lines
    const footerHeight = 5; // Adjust to fit the height of your footer
    const maxContentHeight = pageHeight - marginBottom - footerHeight; // Reduce height to account for footer
    const maxWidth = 170; // Maximum width for text
    let contentYPos = 0; // Start Y position for content
    let initialX = 20; // X position for content
    let currentPage = 1; // Start at page 1
  
    
    const addHeader = () => {
      // Header text
      pdf.setFontSize(9);
      pdf.setFont('TimesNewRoman', 'italic');
      pdf.text('DSWD-GF-010 | REV.00 | 12 SEP 2023', 135, 20);
    };
    
    // Helper function to add a new page if content exceeds the page height
    const addNewPageIfNeeded = () => {
      if (contentYPos >= maxContentHeight) {
        addFooter(); // Add the footer for the current page
        pdf.setTextColor(0, 0, 0);
        pdf.addPage(); // Add new page
        addHeader(); // Add the header on the new page
        currentPage++; // Increment page number
        contentYPos = 40; // Reset Y position for the new page
        pdf.setFont('arial', 'normal'); // Reset font to 'arial' and style to 'normal'
        pdf.setFontSize(11); // Set font size back to what it was
      }
    };
  
    
  const addFooter = () => {
      if (currentPage === 1) {
        pdf.setFontSize(9);
        pdf.setFont('TimesNewRoman', 'bold');
        pdf.setLineWidth(0.5);
        pdf.line(17, 335, 173, 335); // Footer line
  
        pdf.setFont('times', 'normal');
        const footerText = pdf.splitTextToSize('DSWD Field Office XI, Ramon Magsaysay Corner D. Suazo Street, Davao City, Philippines 8000', 160);
        pdf.text(footerText, 95, 340, { align: 'center' });
        pdf.text('Website: ', 45, 345, { align: 'center' });
        pdf.text('Tel Nos.: (082) 227-1964 Email:', 105, 345, { align: 'center' });

        pdf.setFontSize(9);
        pdf.setTextColor(0, 0, 255);
        pdf.text('http://www.dswd.gov.ph', 67, 345, { align: 'center' });
        pdf.text('fo11@dswd.gov.ph ', 140, 345, { align: 'center' });
        pdf.setLineWidth(0);
        pdf.setDrawColor(0, 0, 255);
        pdf.line(51, 346, 83, 346);
        pdf.line(127, 346, 153, 346);
        


        //pdf.text('Website: http://www.dswd.gov.ph Tel Nos.: (082) 227-1964 Email: fo11@dswd.gov.ph ', 105, 345, { align: 'center' });
  
        const footerImgData = '/images/footerimg.png';
        pdf.addImage(footerImgData, 'PNG', 175, 330, 25, 12); // Footer image
  
      } else {
        // Footer for Page 2 and beyond
        pdf.setTextColor(0, 0, 0);
        pdf.setFontSize(8.5);
        pdf.setFont('TimesNewRoman', 'bold');
        pdf.setDrawColor(0, 0, 0);
        pdf.setLineWidth(0.5);
        pdf.line(17, 335, 193, 335); // Footer line extending further
  
        pdf.setFont('times', 'bold');
        pdf.text('DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH', 105, 340, { align: 'center' });
      }
    };

    addHeader();
    pdf.setTextColor(0, 0, 0);
    // DSWD logo
    const imgData = '/images/headerlogo2.png';
    pdf.addImage(imgData, 'PNG', 15, 10, 50, 30);
  
    pdf.setFont('arialbd', 'bold');
    pdf.setFontSize(13);
    pdf.text('INITIAL PSYCHOLOGICAL ASSESSMENT REPORT (IPA)', 105, 45, { align: 'center' });
  
    pdf.setFontSize(9);
    pdf.setTextColor(255, 0, 0);
    pdf.setFont('arial', 'normal');
    pdf.text('(Strictly Confidential / Not for Legal Use)', 105, 50, { align: 'center' });
  
    pdf.setTextColor(0, 0, 0);
    contentYPos += 55;
    contentYPos += rowHeight;
    addNewPageIfNeeded();
    pdf.setFontSize(11);
    pdf.setFont('arialbd', 'bold');
    pdf.text('I. IDENTIFYING DATA', initialX, contentYPos);
    initialX +=3;
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(11);
    contentYPos += 0;
    contentYPos +=rowHeight;
    pdf.text(`Name`, initialX, contentYPos);
    pdf.text(`: ${this.form.name || ''}`, initialX+45, contentYPos);
    contentYPos += 5;
    pdf.text(`Nickname`, initialX, contentYPos);
    pdf.text(`: ${this.form.nickname || ''}`, initialX+45, contentYPos);
    contentYPos += 5;
    pdf.text(`Birth Date`, initialX, contentYPos);
    pdf.text(`: ${this.form.birth_date || ''}`, initialX+45, contentYPos);
    contentYPos += 5;
    pdf.text(`Age`, initialX, contentYPos);
    pdf.text(`: ${this.form.age || ''}`, initialX+45, contentYPos);
    contentYPos += 5;
    pdf.text(`Gender`, initialX, contentYPos);
    pdf.text(`: ${this.form.gender || ''}`, initialX+45, contentYPos);
    contentYPos += 5;
    pdf.text(`Address`, initialX, contentYPos);
    pdf.text(`: ${this.form.address || ''}`, initialX+45, contentYPos);
    contentYPos += 5;
    pdf.text(`Religion`, initialX, contentYPos);
    pdf.text(`: ${this.form.religion || ''}`, initialX+45, contentYPos);
    contentYPos += 5;
    pdf.text(`Educational Attainment`, initialX, contentYPos);
    pdf.text(`: ${this.form.educational_attainment || ''}`, initialX+45, contentYPos);
  
    contentYPos += 9;
    addNewPageIfNeeded();
    pdf.text(`Offense Committed`, initialX, contentYPos);
    pdf.text(`: ${this.form.offense_committed || ''}`, initialX+45, contentYPos);
    contentYPos += 5;
    addNewPageIfNeeded();
    pdf.text(`Date of Admission`, initialX, contentYPos);
    pdf.text(`: ${this.form.admission_date || ''}`, initialX+45, contentYPos);
    contentYPos += 5;
    addNewPageIfNeeded();
    pdf.text(`Date of Report`, initialX, contentYPos);
    pdf.text(`: ${this.form.report_date || ''}`, initialX+45, contentYPos);
  
  
  
  
    contentYPos += rowHeight;
    addNewPageIfNeeded();
    pdf.setFont('arialbd', 'bold');
    pdf.text('II. REASON FOR REFERRAL', initialX, contentYPos);
  
    contentYPos += rowHeight;
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(11);
    const reason_for_referralLog = `${this.form.reason_for_referral || ''}`;
    const reason_for_referralLogLines = pdf.splitTextToSize(reason_for_referralLog, maxWidth);
  
    reason_for_referralLogLines.forEach(line => {
      addNewPageIfNeeded(); // Check for overflow before adding a line
      pdf.text(line, initialX, contentYPos-3);
      contentYPos += lineHeight;
    });
  
    contentYPos += rowHeight;
    addNewPageIfNeeded();
    pdf.setFont('arialbd', 'bold');
    pdf.text('III. BRIEF BACKGROUND', initialX, contentYPos);
    contentYPos +=5;
    pdf.text('Family History', initialX, contentYPos);
  
    contentYPos += rowHeight;
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(11);
    const family_historyLog = `${this.form.family_history || ''}`;
    const family_historyLogLines = pdf.splitTextToSize(family_historyLog, maxWidth);
  
    family_historyLogLines.forEach(line => {
      addNewPageIfNeeded(); // Check for overflow before adding a line
      pdf.text(line, initialX, contentYPos-3);
      contentYPos += lineHeight;
    });
  
  
    contentYPos += rowHeight;
    addNewPageIfNeeded();
    pdf.setFont('arialbd', 'bold');
    pdf.text('Sexual Development', initialX, contentYPos);
  
    contentYPos += rowHeight;
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(11);
    const sexual_developmentLog = `${this.form.sexual_development || ''}`;
    const sexual_developmentLogLines = pdf.splitTextToSize(sexual_developmentLog, maxWidth);
  
    sexual_developmentLogLines.forEach(line => {
      addNewPageIfNeeded(); // Check for overflow before adding a line
      pdf.text(line, initialX, contentYPos-3);
      contentYPos += lineHeight;
    });
  
    contentYPos += rowHeight;
    addNewPageIfNeeded();
    pdf.setFont('arialbd', 'bold');
    pdf.text('Medical and Psychological History', initialX, contentYPos);
  
    contentYPos += rowHeight;
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(11);
    const medical_historyLog = `${this.form.medical_history || ''}`;
    const medical_historyLogLines = pdf.splitTextToSize(medical_historyLog, maxWidth);
  
    medical_historyLogLines.forEach(line => {
      addNewPageIfNeeded(); // Check for overflow before adding a line
      pdf.text(line, initialX, contentYPos-3);
      contentYPos += lineHeight;
    });
  
  
    contentYPos += rowHeight;
    addNewPageIfNeeded();
    pdf.setFont('arialbd', 'bold');
    pdf.text('School History', initialX, contentYPos);
  
    contentYPos += rowHeight;
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(11);
    const school_historyLog = `${this.form.school_history || ''}`;
    const school_historyLogLines = pdf.splitTextToSize(school_historyLog, maxWidth);
  
    school_historyLogLines.forEach(line => {
      addNewPageIfNeeded(); // Check for overflow before adding a line
      pdf.text(line, initialX, contentYPos-3);
      contentYPos += lineHeight;
    });
  
    
    contentYPos += rowHeight;
    addNewPageIfNeeded();
    pdf.setFont('arialbd', 'bold');
    pdf.text('Social History (including Spiritual Development and Work Experience)', initialX, contentYPos);
  
    contentYPos += rowHeight;
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(11);
    const social_historyLog = `${this.form.social_history || ''}`;
    const social_historyLogLines = pdf.splitTextToSize(social_historyLog, maxWidth);
  
    social_historyLogLines.forEach(line => {
      addNewPageIfNeeded(); // Check for overflow before adding a line
      pdf.text(line, initialX, contentYPos-3);
      contentYPos += lineHeight;
    });
  
  
  contentYPos += rowHeight;
    addNewPageIfNeeded();
    pdf.setFont('arialbd', 'bold');
    pdf.text('Personal Characteristics', initialX, contentYPos);
  
    contentYPos += rowHeight;
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(11);
    const personal_characteristicsLog = `${this.form.personal_characteristics || ''}`;
    const personal_characteristicsLogLines = pdf.splitTextToSize(personal_characteristicsLog, maxWidth);
  
    personal_characteristicsLogLines.forEach(line => {
      addNewPageIfNeeded(); // Check for overflow before adding a line
      pdf.text(line, initialX, contentYPos-3);
      contentYPos += lineHeight;
    });
  
    contentYPos += rowHeight;
    addNewPageIfNeeded();
    pdf.setFont('arialbd', 'bold');
    pdf.text('IV. ASSESSMENT TOOLS', initialX, contentYPos);
  
    contentYPos += rowHeight;
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(11);
    const assessment_interviewLog = `${this.form.assessment_interview || ''}`;
    const assessment_interviewLogLines = pdf.splitTextToSize(assessment_interviewLog, maxWidth);
  
    assessment_interviewLogLines.forEach(line => {
      addNewPageIfNeeded(); // Check for overflow before adding a line
      pdf.text(line, initialX, contentYPos-3);
      contentYPos += lineHeight;
    });
  
    contentYPos += rowHeight;
    addNewPageIfNeeded();
    pdf.setFont('arialbd', 'bold');
    pdf.text('V. TEST RESULT AND DISCUSSION', initialX, contentYPos);
  
    contentYPos += rowHeight;
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(11);
    const test_resultLog = `${this.form.test_result || ''}`;
    const test_resultLogLines = pdf.splitTextToSize(test_resultLog, maxWidth);
  
    test_resultLogLines.forEach(line => {
      addNewPageIfNeeded(); // Check for overflow before adding a line
      pdf.text(line, initialX, contentYPos-3);
      contentYPos += lineHeight;
    });
  
    contentYPos += rowHeight;
    addNewPageIfNeeded();
    pdf.setFont('arialbd', 'bold');
    pdf.text('VI. CLINICAL IMPRESSION', initialX, contentYPos);
  
    contentYPos += rowHeight;
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(11);
    const clinical_impressionLog = `${this.form.clinical_impression || ''}`;
    const clinical_impressionLines = pdf.splitTextToSize(clinical_impressionLog, maxWidth);
  
    clinical_impressionLines.forEach(line => {
      addNewPageIfNeeded(); // Check for overflow before adding a line
      pdf.text(line, initialX, contentYPos-3);
      contentYPos += lineHeight;
    });
  
  
  
    contentYPos += rowHeight;
    addNewPageIfNeeded();
    pdf.setFont('arialbd', 'bold');
    pdf.text('VII. PLAN OF ACTION', initialX, contentYPos);
  
    contentYPos += rowHeight;
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(11);
    const plan_of_actionLog = `${this.form.plan_of_action || ''}`;
    const plan_of_actionLogLines = pdf.splitTextToSize(plan_of_actionLog, maxWidth);
  
    plan_of_actionLogLines.forEach(line => {
      addNewPageIfNeeded(); // Check for overflow before adding a line
      pdf.text(line, initialX, contentYPos-3);
      contentYPos += lineHeight;
    });
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
    contentYPos +=10;
    initialX +=0;
    // Prepared by Section
    contentYPos += rowHeight; 
    addNewPageIfNeeded();
    pdf.text('Prepared by:', initialX, contentYPos);
    
    contentYPos += rowHeight; 
    addNewPageIfNeeded();
    pdf.setFont('arialbd', 'bold');
    pdf.setFontSize(11);
    pdf.text('BRYAN V. GALANG, MPsy, RPsy', initialX, contentYPos);
    contentYPos += 4; 
    addNewPageIfNeeded();
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(10);
    pdf.text('Psychologist I', initialX, contentYPos);
  
    // Noted by Section
    contentYPos += rowHeight; 
    addNewPageIfNeeded();
    pdf.text('Noted by:', initialX, contentYPos);
    
    contentYPos += rowHeight; 
    addNewPageIfNeeded();
    pdf.setFont('arialbd', 'bold');
    pdf.setFontSize(11);
    pdf.text('ANGELIC B. PAÑA, RSW, MSSW', initialX, contentYPos);
    contentYPos += 4; 
    addNewPageIfNeeded();
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(10);
    pdf.text('SWO IV / Center Head', initialX, contentYPos);
  
    // Add the footer for the last page
    addFooter();
  
   
  const totalPages = pdf.internal.getNumberOfPages();
    for (let i = 1; i <= totalPages; i++) {
      pdf.setPage(i);
      pdf.setFontSize(9);
      pdf.setFont('TimesNewRoman', 'bold');
      pdf.text(`PAGE ${i} of ${totalPages}`, 105, 333, { align: 'center' }); // Update the footer with the correct total pages
    }
  
    // Save the PDF with dynamic file name
    pdf.save(`IPA_FORMAT_${this.form.name || 'NoName'}.pdf`);
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
  .graph-background {
      background-image: linear-gradient(to right, #cccccc 1px, transparent 1px), 
                        linear-gradient(to bottom, #cccccc 1px, transparent 1px);
      background-size: 15px 15px; /* Adjust size as per your need */
    } 
  </style>
  