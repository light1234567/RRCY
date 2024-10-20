<template>
  <!-- Tabs for Actions -->
  <div v-if="editMode" class="flex absolute p-4 space-x-4">
      <button @click="cancelEdit" class="flex space-x-2 px-3 py-3 bg-blue-900  text-white rounded-md text-xs">
        <!-- FontAwesome for Back -->
        <i class="fas fa-arrow-left w-4 h-4"></i>
        <span>Cancel</span>
      </button>
  </div>
  
  <div class="flex -ml-2 justify-end bg-transparent border -mr-9 border-gray-300 p-4 space-x-4 -mt-9">
      <!-- Pagination Component -->
      <Pagination 
        :totalPages="totalPages" 
        :currentPage="currentPage" 
        @update:currentPage="currentPage = $event" 
      />
      <button v-if="!editMode" @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
        <!-- FontAwesome for Edit -->
        <i class="fas fa-edit w-4 h-4"></i>
        <span>Edit</span>
      </button>
  
      <button v-if="editMode" @click="saveData" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
        <!-- FontAwesome for Save -->
        <i class="fas fa-check w-4 h-4"></i>
        <span>Save</span>
      </button>
  
      <!-- Download PDF Button -->
      <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 text-white rounded-md text-xs">
        <!-- FontAwesome for PDF Download -->
        <i class="fas fa-file-pdf w-4 h-4"></i>
        <span>Export PDF</span>
      </button>
  </div>
  
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
  
    <form ref="secondIntake" @submit.prevent="saveData">
    <!-- Page 1 of 2 -->
    <div class="graph-background p-0.5 -mr-9 -mb-16">
  
    <div v-if="currentPage === 1" class="max-w-3xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
      <div class="relative flex justify-between items-center mb-2"> 
           <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
           <p class="text-[10px] italic -mt-10">DSWD-GF-010A | REV 00 | 12 SEP 2023</p>
         </div>
  
      <div class="bg-white  ">
       
        <h1 class="text-2xl font-bold text-center">GENERAL INTAKE SHEET</h1>
      
        <div class="flex justify-end">
          <p>Date: 
  <input 
    type="date" 
    v-model="sheet.date_second" 
    class="flex-grow border-b-1 border-black border-t-0 mr-4 border-l-0 border-r-0 rounded-none shadow-sm w-1/8 px-2 py-1" 
    :readonly="!editMode" 
    :max="currentDateTime.date" 
    required 
    @input="(e) => { 
      const inputDate = new Date(e.target.value); 
      const inputYear = inputDate.getFullYear(); 
      const currentYear = new Date().getFullYear();
      if (inputYear < 1950 || inputYear > currentYear) { 
        e.target.setCustomValidity(`Please provide a valid year between 1950 and ${currentYear}`); 
      } else { 
        e.target.setCustomValidity(''); 
      } 
    }" 
    @invalid="(e) => { e.target.setCustomValidity('Please provide a valid date between 1950 and the present year') }"
/>
</p>
         </div>
  
        <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
          {{ message }}
        </div>
  
        <div class="mb-8">
        <h2 class="text-lg font-semibold">I. Identifying Information:</h2>
        <div class="space-y-2">
          <div class="flex items-center mb-4">
          
            <label class="mt-1 block text-base font-semibold text-gray-700 mr-4 whitespace-nowrap">Name of client:</label>
            <input type="text" v-model="sheet.name" class="mt-1 p-0 flex-grow border-b-1 border-black border-t-0 mr-4 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" readonly />
        </div>
    
     <div class="grid grid-cols-2 gap-4">
       <div class="flex items-center mb-4">
         <div class="flex-grow flex items-center mr-4">
           <label class="-mt-2 block text-base font-semibold text-gray-700 mr-4">Age:</label>
           <input type="text" v-model="sheet.age" class="-mt-2 p-0 w-full border-b-1 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" readonly />
         </div>
       </div>
       <div class="flex items-center mb-4">
         <div class="flex-grow flex items-center mr-4">
           <label class="-mt-2 block text-base font-semibold text-gray-700 mr-4">Sex:</label>
           <input type="text" v-model="sheet.sex" class="-mt-2 p-0 w-full border-b-1 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" readonly />
         </div>
       </div>
     </div>
     <div class="flex items-center mb-4">
       <div class="flex-grow flex items-center mr-4">
         <label class="-mt-2 block text-base font-semibold text-gray-700 mr-4">Address:</label>
         <input type="text" v-model="sheet.address" class="-mt-2 p-0 w-full border-b-1 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" readonly />
       </div>
     </div>
     <div class="grid grid-cols-2 gap-4">
       <div class="flex items-center mb-4">
         <div class="flex-grow flex items-center mr-4">
           <label class="mt-2 block text-base font-semibold text-gray-700 mr-4 whitespace-nowrap">Date of Birth:</label>
           <input type="date" v-model="sheet.date_of_birth" class=" p-0  w-full border-b-1 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" readonly />
         </div>
       </div>
       <div class="flex items-center mb-4">
         <div class="flex-grow flex items-center mr-4">
           <label class="mt-1 block text-base font-semibold text-gray-700 mr-4 whitespace-nowrap">Place of birth:</label>
           <input type="text" v-model="sheet.place_of_birth" class=" p-0 w-full border-b-1 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" readonly />
         </div>
       </div>
     </div>
     <div class="flex items-center mb-4">
       <div class="flex-grow flex items-center mr-4">
         <label class="-mt-2 block text-base font-semibold text-gray-700 mr-4">Religion:</label>
         <input type="text" v-model="sheet.religion" class="-mt-3 p-0 w-full border-b-1 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" readonly />
       </div>
     </div>
     <div class="flex items-center mb-4">
       <div class="flex-grow flex items-center mr-4">
         <label class="mt-2 block text-base font-semibold text-gray-700 mr-4">Occupation:</label>
         <input 
  type="text" 
  v-model="sheet.occupation" 
  class="mt-1 p-0 w-full border-b-1 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" 
  :readonly="!editMode" 
/>
       </div>
     </div>
     <div class="flex items-center mb-4">
   <label class="mt-1 block text-base font-semibold text-gray-700 mr-4 whitespace-nowrap">Highest Educ'l Att't:</label>
   <input 
  type="text" 
  v-model="sheet.highest_educ_att" 
  class="mt-2 p-0 flex-grow border-b-1 mr-4 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" 
  :readonly="!editMode" 
/>
  </div>
   
  <div class="flex items-center mb-4">
       <div class="flex-grow flex items-center mr-4">
         <label class="mt-1 block text-base font-semibold text-gray-700 mr-4 whitespace-nowrap">Name of School:</label>
         <input 
  type="text" 
  v-model="sheet.school_name" 
  class="mt-1 p-0 w-full border-b-1 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" 
  :readonly="!editMode" 
/>
       </div>
     </div>
     <div class="flex items-center mb-4">
       <div class="flex-grow flex items-center mr-4">
         <label class="mt-1 block text-base font-semibold text-gray-700 mr-4 whitespace-nowrap ">Class Adviser:</label>
         <input
  type="text"
  v-model="sheet.class_adviser"
  class="mt-1 p-0 w-full border-b-1 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]"
  :readonly="!editMode"
/>

       </div>
     </div>
   </div>
  </div>
  
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">Vices/Start:</h2>
          <div class="space-y-2">
            <label><input type="checkbox" v-model="sheet.vices.gambling" :disabled="!editMode" /> Gambling</label><br />
            <div class="flex items-center space-x-1 whitespace-nowrap">
    <input type="checkbox" v-model="sheet.vices.othersEnabled1" :disabled="!editMode" @change="focusInput('resources2')" />
    <label class="ml-2">
      Drugs (<span v-if="sheet.vices.othersEnabled1" ref="resources2" contenteditable="true" @input="updateVicesOthers1" class="editable">{{ sheet.vices.others1 }}</span><span v-else>________</span>)
    </label>
  </div>          <label><input type="checkbox" v-model="sheet.vices.cigarette" :disabled="!editMode" /> Cigarette</label><br />
            <label><input type="checkbox" v-model="sheet.vices.liquor" :disabled="!editMode" /> Liquor</label><br />
            <div class="flex items-center space-x-1 whitespace-nowrap">
    <input type="checkbox" v-model="sheet.vices.othersEnabled2" :disabled="!editMode" @change="focusInput('resources2')" />
    <label class="ml-2">
      Computer Games (<span v-if="sheet.vices.othersEnabled2" ref="resources2" contenteditable="true" @input="updateVicesOthers2" class="editable">{{ sheet.vices.others2 }}</span><span v-else>________</span>)
    </label>
  </div>         
  </div>
        </div>
      </div>
  
      <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        <div class="flex flex-col">
          <p class="ml-24 -mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
          <p class="border-t -ml-7 mt-4 whitespace-nowrap" style="border-top: 2px solid black;">
            DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City
          </p>
          <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrcy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
        </div>
        <div class="ml-4">
          <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
        </div>
      </div>
    </div>
    </div>
  
    <!-- Page 2 of 2 -->
    <div v-if="currentPage === 2" class="max-w-3xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
      <div class="relative flex justify-between items-center mb-2">
          <p class="text-[10px] text-right mt-6 mb-4 w-full italic">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
        </div>
        <div class="mb-8">
  <h2 class="text-lg font-semibold">Schools Activities Achievement:</h2>
  <div class="space-y-2">
    <div 
      class="p-1 mt-1 block w-full border border-gray-300 rounded-md shadow-sm text-[15px] leading-relaxed" 
      style="line-height: 1.5; white-space: pre-wrap; min-height: 50px;" 
      contenteditable="true" 
      :contenteditable="editMode"
      @input="(e) => { sheet.school_activities_achievement = e.target.innerText; }"
    >
      {{ sheet.school_activities_achievement }}
    </div>
  </div>
</div>

  
      <div class="mb-8">
        <h2 class="text-lg font-semibold">Family:</h2>
        <div class="grid grid-cols-2 gap-4">
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Mother's Occupation:</label>
            <input type="text" v-model="sheet.occupation_of_mother" class="mt-1 w-full border-b-1 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
          </div>
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Father's Occupation:</label>
            <input type="text" v-model="sheet.occupation_of_father" class="mt-1 w-full border-b-1 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
          </div>
        </div>
        <div class="space-y-2">
          <label>Siblings:</label>
          <input type="text" v-model="sheet.siblings[0]" class="border-b-1 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" @input="sheet.siblings[0] = removeNumbers(sheet.siblings[0])"/>
          <input type="text" v-model="sheet.siblings[1]" class="border-b-1 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" @input="sheet.siblings[1] = removeNumbers(sheet.siblings[1])"/>
          <input type="text" v-model="sheet.siblings[2]" class="border-b-1 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" @input="sheet.siblings[2] = removeNumbers(sheet.siblings[2])"/>
        </div>
        <div class="space-y-2">
          <label>Responsible for Households Chores:</label>
          <input type="text" v-model="sheet.responsible_for_households_chores" class="border-b-1 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
        </div>
      </div>
  
      <div class="mb-8">
        <h2 class="text-lg font-semibold">Community:</h2>
        <div class="space-y-2">
          <label>No. of Days Detention/Jail/CSWD/MSWDO:</label>
          <input type="text" v-model="sheet.detention_days" class="border-b-1 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
          <label>Water Source:</label><br />
          <label><input type="checkbox" v-model="sheet.community.water_source" :disabled="!editMode" /> Water Source</label><br />
          <label><input type="checkbox" v-model="sheet.community.light" :disabled="!editMode" /> Light</label><br />
          <label><input type="checkbox" v-model="sheet.community.barangay_facility" :disabled="!editMode" /> Barangay Facility</label><br />
          <label><input type="checkbox" v-model="sheet.community.health_center" :disabled="!editMode" /> Health Center</label><br />
          <label><input type="checkbox" v-model="sheet.community.internet" :disabled="!editMode" /> Internet</label><br />
        </div>
      </div>
  
      <div class="mb-8">
        <h2 class="text-lg font-semibold">House made of:</h2>
        <div class="space-y-2">
          <input type="text" v-model="sheet.house_made_of" class="border-b-1 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
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
      <p class="-ml-8 whitespace-nowrap"style="text-align: center; font-weight: bold; margin-top: -1px;">DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION |REGIONAL REHABILITATION CENTER FOR YOUTH
      </p>
    </div>

  </div>
</div>
    </div>
    </div>
  </form>
  </template>
  
  <script>
  import axios from 'axios';
  import Pagination from '@/Components/Pagination.vue';
  import jsPDF from 'jspdf';
  import '../../../fonts/arial-normal.js'; 
  import '../../../fonts/times-normal.js'; 
  import '../../../fonts/arialbd-bold.js'; 
  
  export default {
    name: 'GeneralIntakeSheet',
    components: {
      Pagination
    },
    data() {
      return {
        editMode: false,
        message: '',
        messageType: '',
        clientId: null,
        totalPages: 2,
        currentPage: 1,
        isModalOpen: false,
        isSaveResultModalOpen: false,
        saveResultTitle: '',
        saveResultMessage: '',
        sheet: {
          id: null,
          name: '',
          age: '',
          sex: '',
          address: '',
          date_of_birth: '',
          place_of_birth: '',
          religion: '',
          occupation: '',
          highest_educ_att: '',
          school_name: '',
          class_adviser: '',
          date_second: '',
          vices: {
            gambling: false,
            drugs: false,
            others1: '',
            othersEnabled1: false,
            cigarette: false,
            liquor: false,
            computer_games: false,
            others2: '',
            othersEnabled2: false,
          },
          school_activities_achievement: '',
          occupation_of_mother: '',
          occupation_of_father: '',
          siblings: ['', '', ''],
          responsible_for_households_chores: '',
          detention_days: '',
          community: {
            water_source: false,
            light: false,
            barangay_facility: false,
            health_center: false,
            internet: false,
          },
          house_made_of: '',
        }
      };
    },

  
    computed: {
  currentDateTime() {
    // Get the current date and time in the Asia/Manila timezone
    const options = { timeZone: 'Asia/Manila', year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' };
    const formatter = new Intl.DateTimeFormat('en-CA', options); // 'en-CA' is used for the format YYYY-MM-DD
    const parts = formatter.formatToParts(new Date());

    const year = parts.find(part => part.type === 'year').value;
    const month = parts.find(part => part.type === 'month').value;
    const day = parts.find(part => part.type === 'day').value;
    const hour = parts.find(part => part.type === 'hour').value;
    const minute = parts.find(part => part.type === 'minute').value;
    const second = parts.find(part => part.type === 'second').value;

    // Return the current date and time in the 'Asia/Manila' timezone
    return {
      date: `${year}-${month}-${day}`,
      time: `${hour}:${minute}:${second}`
    };
  }
},

    mounted() {
      this.clientId = this.$route.params.id;
      console.log('Client ID fetched:', this.clientId); // Console log showing client ID
      this.fetchClientData(this.clientId);
    },
    watch: {
      '$route.params.id'(newId) {
        this.clientId = newId;
        console.log('Client ID changed:', this.clientId); // Console log showing updated client ID
        this.fetchClientData(this.clientId);
      }
    },
    methods: {
      async fetchClientData(id) {
    try {
      // Fetch client data based on client_id
      const clientResponse = await axios.get(`/api/clients/${id}`);
      const client = clientResponse.data;
  
      // Populate client-related fields
      this.sheet.name = `${client.first_name} ${client.last_name}`;
      this.sheet.age = this.calculateAge(client.date_of_birth);
      this.sheet.sex = client.sex;
      this.sheet.address = `${client.street}, ${client.barangay}, ${client.city}, ${client.province}`;
      this.sheet.date_of_birth = client.date_of_birth;
      this.sheet.place_of_birth = client.place_of_birth;
      this.sheet.religion = client.religion;
  
      console.log('Client data mapped to sheet:', this.sheet);
  
      // Fetch general intake sheet data based on client_id
      try {
        const generalIntakeResponse = await axios.get(`/api/general-intake-sheets?client_id=${id}`);
        const generalIntake = generalIntakeResponse.data[0]; // Assuming first sheet is the correct one
  
        if (generalIntake) {
          // Populate general intake sheet fields
          this.sheet.occupation = generalIntake.occupation;
          this.sheet.highest_educ_att = generalIntake.highest_educ_att;
          this.sheet.school_name = generalIntake.school_name;
          this.sheet.class_adviser = generalIntake.class_adviser;
  
          // Store general intake ID for further use
          this.sheet.general_intake_id = generalIntake.id;
  
          console.log('General Intake data mapped to sheet:', this.sheet);
        } else {
          console.warn('No general intake sheet found for this client.');
        }
      } catch (error) {
        if (error.response && error.response.status === 404) {
          console.warn('General Intake Sheet not found. Proceeding without it.');
        } else {
          console.error('Error fetching general intake sheet:', error);
        }
      }
  
      // Fetch second intake sheet data using the general_intake_id
      if (this.sheet.general_intake_id) {
        try {
          const secondIntakeResponse = await axios.get(`/api/second-intake-sheets?general_intake_id=${this.sheet.general_intake_id}`);
          if (secondIntakeResponse.data.length > 0) {
            const secondIntake = secondIntakeResponse.data[0]; // Assuming first record is the correct one
  
            // Map second intake sheet data to the sheet object
            Object.assign(this.sheet, secondIntake);
            this.sheet.id = secondIntake.id; // Set second intake sheet ID
  
            console.log('Second Intake data mapped to sheet:', this.sheet);
          } else {
            console.log('No second intake sheet found for this general intake.');
          }
        } catch (error) {
          console.error('Error fetching second intake sheet:', error);
        }
      }
  
    } catch (error) {
      console.error('Error fetching client data:', error);
    }
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
      toggleEdit() {
        if (this.editMode) {
          this.openModal();
        } else {
          this.editMode = !this.editMode;
        }
      },
      openModal() {
        this.isModalOpen = true;
      },
      closeModal() {
        this.isModalOpen = false;
      },
      cancelEdit() {
        this.editMode = false;
      },
      removeNumbers(input) {
    return input.replace(/[0-9]/g, '');
  },
  async saveData() {
  if (!this.clientId) {
    this.message = 'No client selected.';
    this.messageType = 'error';
    this.clearNotification();
    return;
  }

  const totalPages = this.totalPages;  // Ensure this is set correctly based on your pagination logic
  let allFieldsValid = true;

  // Loop through each page to check its validity
  for (let i = 1; i <= totalPages; i++) {
    // Set the current page to the one being validated
    this.currentPage = i;

    // Wait for the page to be fully rendered before validation
    await this.$nextTick();

    // Get the form for the current page
    const form = this.$refs.secondIntake;  // Ensure this ref matches the form in your template

    // Validate the form on the current page
    if (!form.checkValidity()) {
      allFieldsValid = false;
      form.reportValidity();  // Show validation messages and focus on the first invalid field

      // Break out of the loop and stop checking further pages
      break;
    }
  }

  // If all fields across all pages are valid, open the confirmation modal
  if (allFieldsValid) {
    this.isModalOpen = true;
  } else {
    console.warn('Form has invalid fields, please correct them.');
  }
}
,


confirmSave() {
  // Prepare data for general intake sheet
  const generalIntakePayload = {
    client_id: this.clientId,
    occupation: this.sheet.occupation,
    highest_educ_att: this.sheet.highest_educ_att,
    school_name: this.sheet.school_name,
    class_adviser: this.sheet.class_adviser,
    // Add other general intake fields here if needed
  };

  // Prepare data for second intake sheet
  const secondIntakePayload = {
    client_id: this.clientId,
    general_intake_id: this.sheet.general_intake_id || null,
    date_second: this.sheet.date_second,
    vices: this.sheet.vices,
    school_activities_achievement: this.sheet.school_activities_achievement,
    occupation_of_mother: this.sheet.occupation_of_mother,
    occupation_of_father: this.sheet.occupation_of_father,
    siblings: this.sheet.siblings,
    responsible_for_households_chores: this.sheet.responsible_for_households_chores,
    detention_days: this.sheet.detention_days,
    community: this.sheet.community,
    house_made_of: this.sheet.house_made_of,
  };

  // Save or update general intake sheet first
  let generalIntakeMethod, generalIntakeUrl;
  if (this.sheet.general_intake_id) {
    generalIntakeMethod = 'put';
    generalIntakeUrl = `/api/general-intake-sheets/${this.sheet.general_intake_id}`;
  } else {
    generalIntakeMethod = 'post';
    generalIntakeUrl = `/api/general-intake-sheets`;
  }

  axios[generalIntakeMethod](generalIntakeUrl, generalIntakePayload)
    .then(response => {
      this.sheet.general_intake_id = response.data.id;  // Store the new or updated general intake ID

      // Now save or update the second intake sheet
      let secondIntakeMethod, secondIntakeUrl;
      if (this.sheet.id) {
        secondIntakeMethod = 'put';
        secondIntakeUrl = `/api/second-intake-sheets/${this.sheet.id}`;
      } else {
        secondIntakeMethod = 'post';
        secondIntakeUrl = `/api/second-intake-sheets`;
      }

      return axios[secondIntakeMethod](secondIntakeUrl, secondIntakePayload);
    })
    .then(response => {
      this.saveResultTitle = 'Success';
      this.saveResultMessage = 'Data saved successfully.';
      if (!this.sheet.id) this.sheet.id = response.data.id;  // Set the new second intake sheet ID
      this.editMode = false;
    })
    .catch(error => {
      this.saveResultTitle = 'Error';
      this.saveResultMessage = error.response.data.message || 'Error saving data.';
      console.error('Error saving data:', error);
    })
    .finally(() => {
      this.isModalOpen = false;
      this.isSaveResultModalOpen = true;
    });
}
,
      updateVicesOthers1(event) {
        this.sheet.vices.others1 = event.target.innerText;
      },
      updateVicesOthers2(event) {
        this.sheet.vices.others2 = event.target.innerText;
      },
      focusInput(refName) {
        this.$nextTick(() => {
          if (this.$refs[refName]) {
            this.$refs[refName].focus();
          }
        });
      },
      closeSaveResultModal() {
        this.isSaveResultModalOpen = false;
        this.saveResultTitle = '';
        this.saveResultMessage = '';
      },
      clearNotification() {
        setTimeout(() => {
          this.message = '';
          this.messageType = '';
        }, 3000);
      },
      exportToPdf() {
    const pdf = new jsPDF('p', 'mm', 'a4'); // Standard A4 size document
    const pageHeight = 297;
    const marginBottom = 30;
    const rowHeight = 8;
    const lineHeight = 7;
    const footerHeight = 5; // Adjust to fit the height of your footer
    const maxContentHeight = pageHeight - marginBottom - footerHeight; // Reduce height to account for footer
    const maxWidth = 170;
    let contentYPos = 65; 
    let initialX = 20;
    let currentPage = 1;
    
    const addHeader = () => {
      pdf.setFontSize(9);
      pdf.setFont('TimesNewRoman', 'italic');
      pdf.text('DSWD-GF-010A | REV 00 | 12 SEP 2023', 135, 20);
    };
    
    // Helper function to add a new page if content exceeds the page height
    const addNewPageIfNeeded = () => {
      if (contentYPos >= maxContentHeight) {
        addFooter();
        pdf.addPage();
        addHeader();
        currentPage++;
        contentYPos = 40;
        pdf.setFont('arial', 'normal');
        pdf.setFontSize(12);
      }
    };
  
    const drawCheckbox = (isChecked, x, y) => {
  
    pdf.setFillColor(0, 122, 255); 
    pdf.setDrawColor(0, 0, 0);
  
    pdf.setLineWidth(0.2); 
    pdf.rect(x, y, 5, 5, isChecked ? 'FD' : 'S'); 
  
    if (isChecked) {
     
      pdf.setDrawColor(255, 255, 255);
      pdf.setLineWidth(0.7); 
  
  
      pdf.line(x + 1, y + 2.5, x + 2, y + 4);
      pdf.line(x + 2, y + 4, x + 4, y + 1.5); 
    }
  
    
    pdf.setLineWidth(0.2); 
    pdf.setDrawColor(0, 0, 0);
    pdf.setFillColor(255, 255, 255);
  };
  
  
  
  
  
  
    const addFooter = () => {
      if (currentPage === 1) {
        pdf.setFontSize(9);
        pdf.setFont('TimesNewRoman', 'bold');
        pdf.setLineWidth(0.5);
        pdf.line(17, 282, 173, 282);
        pdf.setFont('times', 'normal');
        const footerText = pdf.splitTextToSize('DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Prk. 7 Bago-Oshiro, Tugbok Dist., Davao City', 160);
        pdf.text(footerText, 95, 287, { align: 'center' });
        pdf.text('Email: rrcy.fo11@dswd.gov.ph    Tel. No.: 293-0306', 105, 292, { align: 'center' });
        const footerImgData = '/images/footerimg.png';
        pdf.addImage(footerImgData, 'PNG', 175, 275, 25, 12);
      } else {
        pdf.setFontSize(8.5);
        pdf.setFont('TimesNewRoman', 'bold');
        pdf.setLineWidth(0.5);
        pdf.line(17, 282, 193, 282);
        pdf.text('DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH', 105, 285, { align: 'center' });
      }
    };
  
    addHeader();
  
    // DSWD logo
    const imgData = '/images/headerlogo2.png';
    pdf.addImage(imgData, 'PNG', 15, 10, 50, 30);
  
    pdf.setFont('arialbd', 'bold');
    pdf.setFontSize(20);
    pdf.text('GENERAL INTAKE SHEET', 105, 48, { align: 'center' });
    pdf.setFont('arial', 'normal');
  
  
  contentYPos += rowHeight;
  contentYPos += +-18;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(13);
  pdf.text(`Date:`, initialX + 105, contentYPos);
  const dateValue = `${this.sheet.date_second || ''}`;
  const dateWidth = pdf.getTextWidth(dateValue);
  pdf.text(dateValue, initialX + 119, contentYPos);  
  pdf.line(initialX + 119, contentYPos + 1, initialX + 119 + dateWidth, contentYPos + 1); 
  
  contentYPos += rowHeight;
    pdf.setFontSize(13);
    pdf.setFont('arialbd', 'bold');
    pdf.text('I. Identifying Information:', initialX, contentYPos);
  
    contentYPos += rowHeight;
  pdf.setFontSize(13);
  pdf.setFont('arial', 'normal');
  pdf.text(`Name of client:`, initialX, contentYPos);
  
  pdf.setFontSize(11);
  pdf.setFont('arial', 'normal');
  pdf.text(`${this.sheet.name || ''}`, initialX+32, contentYPos);;
  pdf.line(52, contentYPos+1, 190, contentYPos+1); 
  
  contentYPos += rowHeight;
  pdf.setFontSize(13);
  pdf.setFont('arial', 'normal');
  pdf.text(`Age:`, initialX, contentYPos);
  pdf.setFontSize(11);
  pdf.setFont('arial', 'normal');
  pdf.text(`${this.sheet.age || ''}`, initialX+12, contentYPos);;
  pdf.line(31, contentYPos+1, 115, contentYPos+1); 
  
  pdf.setFontSize(13);
  pdf.setFont('arial', 'normal');
  pdf.text(`Sex:`, initialX + 100, contentYPos);
  pdf.setFontSize(11);
  pdf.setFont('arial', 'normal');
  pdf.text(`${this.sheet.sex || ''}`, initialX+110, contentYPos);;
  pdf.line(130, contentYPos+1, 190, contentYPos+1); 
  
// Initial values
contentYPos += rowHeight; // Adjust starting position using rowHeight

// Set the font for the "Address:" label
pdf.setFontSize(13);  
pdf.setFont('arial', 'normal');
pdf.text(`Address:`, initialX, contentYPos); // Label for Address

// Address content from the sheet
const addressText = this.sheet.address || '';

// Set the font for the address content
pdf.setFontSize(10);
pdf.setFont('arial', 'normal');

// Wrap the address text if it exceeds the limit
const wrappedAddress = pdf.splitTextToSize(addressText, 150); // 150 units width for wrapping

// Adjust row height to minimal space for each line of the wrapped address
wrappedAddress.forEach((line, i) => {
    const lineX = i === 0 ? initialX + 20 : initialX; // Indent first line slightly, subsequent lines start at 20
    const lineY = contentYPos + (i * rowHeight); // Adjust line position using rowHeight for each line
    
    // Render the current line
    pdf.text(line, lineX, lineY);

    // Draw underline for each line of the address
    pdf.line(lineX, lineY + 1, 190, lineY + 1); // Underline from lineX to 190
});

// Only adjust `contentYPos` if there is more than one line (second row or more)
if (wrappedAddress.length > 1) {
    const totalAddressHeight = wrappedAddress.length * rowHeight - 7; // Calculate the height for multiple rows
    contentYPos += totalAddressHeight; // Adjust contentYPos based on the number of lines
}

  
  contentYPos += rowHeight;
  pdf.setFontSize(13);
  pdf.setFont('arial', 'normal');
  pdf.text(`Date of Birth:`, initialX, contentYPos);
  pdf.setFontSize(11);
  pdf.setFont('arial', 'normal');
  pdf.text(`${this.sheet.date_of_birth || ''}`, initialX+28, contentYPos);;
  pdf.line(48, contentYPos+1, 90, contentYPos+1);
  
  pdf.setFontSize(13);
  pdf.setFont('arial', 'normal');
  pdf.text(`Place of birth:`, initialX + 72, contentYPos);
  pdf.setFontSize(11);
  pdf.setFont('arial', 'normal');
  pdf.text(`${this.sheet.place_of_birth || ''}`, initialX+ 102, contentYPos);;
  pdf.line(122, contentYPos+1, 190, contentYPos+1);
  
  
  contentYPos += rowHeight;
  pdf.setFontSize(13);  
  pdf.setFont('arial', 'normal');
  pdf.text(`Religion:`, initialX, contentYPos);
  
  pdf.setFontSize(11);
  pdf.setFont('arial', 'normal');
  pdf.text(`${this.sheet.religion || ''}`, initialX+19, contentYPos);;
  pdf.line(38, contentYPos+1, 190, contentYPos+1);
  
  contentYPos += rowHeight;
  pdf.setFontSize(13);  
  pdf.setFont('arial', 'normal');
  pdf.text(`Occupation:`, initialX, contentYPos);
  
  pdf.setFontSize(11);
  pdf.setFont('arial', 'normal');
  pdf.text(`${this.sheet.occupation || ''}`, initialX+25, contentYPos);;
  pdf.line(45, contentYPos+1, 190, contentYPos+1);
  
  contentYPos += rowHeight;
  pdf.setFontSize(13);  
  pdf.setFont('arial', 'normal');
  pdf.text(`Highest Educ'l Att't:`, initialX, contentYPos);
  
  pdf.setFontSize(11);
  pdf.setFont('arial', 'normal');
  pdf.text(`${this.sheet.highest_educ_att || ''}`, initialX+42, contentYPos);;
  pdf.line(61, contentYPos+1, 190, contentYPos+1);
  
  
  
  contentYPos += rowHeight;
  pdf.setFontSize(13);  
  pdf.setFont('arial', 'normal');
  pdf.text(`Name of School:`, initialX, contentYPos);
  
  pdf.setFontSize(11);
  pdf.setFont('arial', 'normal');
  pdf.text(`${this.sheet.school_name || ''}`, initialX+35, contentYPos);;
  pdf.line(54, contentYPos+1, 190, contentYPos+1);
  
  
  contentYPos += rowHeight;
  pdf.setFontSize(13);  
  pdf.setFont('arialbd', 'bold');
  pdf.text(`Class Adviser:`, initialX, contentYPos);
  
  pdf.setFontSize(11);
  pdf.setFont('arial', 'normal');
  pdf.text(`${this.sheet.class_adviser || ''}`, initialX+34, contentYPos);;
  pdf.line(52, contentYPos+1, 190, contentYPos+1);
  
  
  
  contentYPos += rowHeight;
  contentYPos += 8;
    pdf.setFontSize(13);
    pdf.setFont('arialbd', 'bold');
    pdf.text('Vices/Start:', initialX, contentYPos);
  
  
  
    contentYPos += rowHeight;
    pdf.setFontSize(12);
    pdf.setFont('arial', 'normal');
    pdf.text('Gambling', initialX+8, contentYPos);
    drawCheckbox(this.sheet.vices.gambling, initialX, contentYPos - 4); // Adjust Y position to align checkbox
    contentYPos += rowHeight;
  
    pdf.setFont('arial', 'normal');
  
  // Draw the label "Drugs"
  pdf.text('Drugs', initialX + 8, contentYPos);
  drawCheckbox(this.sheet.vices.othersEnabled1, initialX, contentYPos - 4); // Adjust Y position to align checkbox
  
  // Add the dynamic text after "Drugs", if the field others1 is enabled and contains text
  if (this.sheet.vices.othersEnabled1) {
      const othersText = this.sheet.vices.others1 || '________'; // Use the others1 text or fallback to a blank line
      pdf.text(`(${othersText})`, initialX + 20, contentYPos); // Adjust X position for alignment after "Drugs"
  }
  
    contentYPos += rowHeight;
  
    pdf.setFont('arial', 'normal');
    pdf.text('Cigarette', initialX+8, contentYPos);
    drawCheckbox(this.sheet.vices.cigarette, initialX, contentYPos - 4);
    contentYPos += rowHeight;
  
    pdf.setFont('arial', 'normal');
    pdf.text('Liquor', initialX+8, contentYPos);
    drawCheckbox(this.sheet.vices.liquor, initialX, contentYPos - 4);
    contentYPos += rowHeight;
  
    pdf.setFont('arial', 'normal');
    pdf.text('Computer Games', initialX+8, contentYPos);
    drawCheckbox(this.sheet.vices.othersEnabled2, initialX, contentYPos - 4);
  
    if (this.sheet.vices.othersEnabled2) {
      const others2Text = this.sheet.vices.others2 || '________'; // Use the others1 text or fallback to a blank line
      pdf.text(`(${others2Text})`, initialX + 43, contentYPos); // Adjust X position for alignment after "Drugs"
  }
  
  
    contentYPos += rowHeight;
    addNewPageIfNeeded();
    pdf.setFont('arialbd', 'bold');
    pdf.setFontSize(13);
    contentYPos +=7;
    pdf.text('Schools Activities Achievement:', initialX, contentYPos);
  
    contentYPos +=7;
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(12);
    const school_activities_achievementlLog = `${this.sheet.school_activities_achievement || ''}`;
    const school_activities_achievementlLogLines = pdf.splitTextToSize(school_activities_achievementlLog, maxWidth);
  
    school_activities_achievementlLogLines.forEach(line => {
      addNewPageIfNeeded(); // Check for overflow before adding a line
      pdf.text(line, initialX, contentYPos);
      contentYPos += lineHeight;
    });
  
  
    contentYPos += rowHeight;
    addNewPageIfNeeded();
    pdf.setFontSize(13);
    pdf.setFont('arialbd', 'bold');
    pdf.text('Family:', initialX, contentYPos);
  
  
    pdf.setLineWidth(0);
    contentYPos += rowHeight;
    addNewPageIfNeeded();
  pdf.setFontSize(12);
  pdf.setFont('arialbd', 'bold');
  pdf.text(`Mother's Occupation:`, initialX, contentYPos);
  pdf.setFontSize(11);
  pdf.setFont('arial', 'normal');
  pdf.text(`${this.sheet.occupation_of_mother || ''}`, initialX+45, contentYPos);;
  pdf.line(64, contentYPos+1, 112, contentYPos+1);
  
  
  pdf.setFontSize(12);
  pdf.setFont('arialbd', 'bold');
  pdf.text(`Father's Occupation:`, initialX + 95, contentYPos);
  pdf.setFontSize(11);
  pdf.setFont('arial', 'normal');
  pdf.text(`${this.sheet.occupation_of_mother || ''}`, initialX+139, contentYPos);;
  pdf.line(158, contentYPos+1, 190, contentYPos+1);
  
  
  
  contentYPos += rowHeight;
  addNewPageIfNeeded();
  pdf.setFontSize(12);
  pdf.setFont('arial', 'normal');
  pdf.text(`Siblings:`, initialX, contentYPos);
  
  contentYPos += 7;
  addNewPageIfNeeded();
  pdf.setLineWidth(0);
  pdf.setFontSize(11);
  pdf.setFont('arial', 'normal');
  pdf.text(`${this.sheet.siblings[0] || ''}`, initialX, contentYPos);;
  pdf.line(20, contentYPos+1, 190, contentYPos+1);
  
  
  contentYPos += 7;
  pdf.setLineWidth(0);
  addNewPageIfNeeded();
  pdf.text(`${this.sheet.siblings[1] || ''}`, initialX, contentYPos);;
  pdf.line(20, contentYPos+1, 190, contentYPos+1);
  
  contentYPos += 7;
  pdf.setLineWidth(0);
  addNewPageIfNeeded();
  pdf.text(`${this.sheet.siblings[2] || ''}`, initialX, contentYPos);;
  pdf.line(20, contentYPos+1, 190, contentYPos+1);
  
  
  contentYPos += rowHeight;
  contentYPos +=5;
  addNewPageIfNeeded();
  pdf.setLineWidth(0);
  pdf.setFontSize(12);
  pdf.setFont('arial', 'normal');
  pdf.text(`Responsible for Households Chores:`, initialX, contentYPos);
  
  contentYPos += 7;
  pdf.setFontSize(11);
  pdf.setFont('arial', 'normal');
  pdf.text(`${this.sheet.responsible_for_households_chores || ''}`, initialX, contentYPos);;
  pdf.line(20, contentYPos+1, 190, contentYPos+1);
  
  
  
  contentYPos += rowHeight;
    addNewPageIfNeeded();
  contentYPos += 5;
    pdf.setFontSize(13);
    pdf.setFont('arialbd', 'bold');
    pdf.text('Community:', initialX, contentYPos);
  
    contentYPos += rowHeight;
  addNewPageIfNeeded();
  pdf.setFontSize(12);
  pdf.setFont('arial', 'normal');
  pdf.text(`No. of Days Detention/Jail/CSWD/MSWDO:`, initialX, contentYPos);
  
  contentYPos += 7;
  pdf.setFontSize(11);
  pdf.setLineWidth(0);
  pdf.setFont('arial', 'normal');
  pdf.text(`${this.sheet.detention_days || ''}`, initialX, contentYPos);;
  pdf.line(20, contentYPos+1, 190, contentYPos+1);
  
  
  contentYPos += rowHeight;
    addNewPageIfNeeded();
  contentYPos += 5;
    pdf.setFontSize(12);
    pdf.setFont('arial', 'normal');
    pdf.text('Water Source:', initialX, contentYPos);
  contentYPos += rowHeight;
  addNewPageIfNeeded();
    pdf.setFontSize(12);
    pdf.text('Water Source', initialX+8, contentYPos);
    drawCheckbox(this.sheet.community.water_source, initialX, contentYPos - 4); // Adjust Y position to align checkbox
    contentYPos += rowHeight;
  
  
    pdf.text('Light', initialX+8, contentYPos);
    drawCheckbox(this.sheet.community.light, initialX, contentYPos - 4); // Adjust Y position to align checkbox
    contentYPos += rowHeight;
  
  
    pdf.text('Barangay Facility', initialX+8, contentYPos);
    drawCheckbox(this.sheet.community.barangay_facility, initialX, contentYPos - 4);
    contentYPos += rowHeight;
  
  
    pdf.text('Health Center', initialX+8, contentYPos);
    drawCheckbox(this.sheet.community.health_center, initialX, contentYPos - 4);
    contentYPos += rowHeight;
  
  
    pdf.text('Internet', initialX+8, contentYPos);
    drawCheckbox(this.sheet.community.internet, initialX, contentYPos - 4);
  
  
    contentYPos += rowHeight;
  addNewPageIfNeeded();
  pdf.setFontSize(12);
  pdf.setFont('arialbd', 'bold');
  pdf.text(`House made of:`, initialX, contentYPos);
  
  contentYPos += 7;
  pdf.setFontSize(11);
  pdf.setFont('arial', 'normal');
  pdf.text(`${this.sheet.house_made_of || ''}`, initialX, contentYPos);;
  pdf.line(20, contentYPos+1, 190, contentYPos+1);
  
  
  
  addFooter();
  
    // Pagination at the bottom
    const totalPages = pdf.internal.getNumberOfPages();
    for (let i = 1; i <= totalPages; i++) {
      pdf.setPage(i);
      pdf.setFontSize(9);
      pdf.setFont('TimesNewRoman', 'bold');
      pdf.text(`PAGE ${i} of ${totalPages}`, 105, 280, { align: 'center' }); // Update the footer with the correct total pages
    }
    // Save the PDF with a dynamic file name
    pdf.save(`IntakeSheet_${this.sheet.name || 'Client'}.pdf`);
  },
  
    }
  };
  </script>
  
  <style scoped>
  .graph-background {
      background-image: linear-gradient(to right, #cccccc 1px, transparent 1px), 
                        linear-gradient(to bottom, #cccccc 1px, transparent 1px);
      background-size: 15px 15px; /* Adjust size as per your need */
    }
  button {
    transition: background-color 0.3s;
  }
  button:hover {
    background-color: #2563eb;
  }
  .bg-green-500:hover {
    background-color: #38a169;
  }
  @keyframes twinkle {
    0%, 100% { border-color: #a1b6cf; }
    50% { border-color: white; }
  }
  .twinkle-border {
    animation: twinkle 2s infinite;
  }
  </style>
  