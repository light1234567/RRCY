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

    <button v-if="editMode" @click="openModal" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
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

  <!-- Page 1 of 2 -->
  <div class="graph-background p-0.5 -mr-9 -mb-16">

  <div v-if="currentPage === 1" class="max-w-3xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
    <div class="relative flex justify-between items-center mb-2"> 
         <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
         <p class="text-[10px] italic -mt-10">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
       </div>

    <div class="bg-white  ">
     
      <h1 class="text-2xl font-bold text-center">GENERAL INTAKE SHEET</h1>
    
      <div class="flex justify-end">
         <p>Date: <input type="date" v-model="sheet.date" class="flex-grow border-b-2 border-black border-t-0 mr-4 border-l-0 border-r-0 rounded-none shadow-sm  w-1/8 px-2 py-1" :readonly="!editMode" /></p>
       </div>

      <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
        {{ message }}
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">I. Identifying Information:</h2>
        <div class="space-y-2">
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Name of client:</label>
            <input type="text" v-model="sheet.name" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="flex-grow flex items-center mr-4">
              <label class="block text-base font-semibold text-gray-700 mr-4">Age:</label>
              <input type="text" v-model="sheet.age" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
            </div>
            <div class="flex-grow flex items-center mr-4">
              <label class="block text-base font-semibold text-gray-700 mr-4">Sex:</label>
              <input type="text" v-model="sheet.sex" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
            </div>
          </div>
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Address:</label>
            <input type="text" v-model="sheet.address" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="flex-grow flex items-center mr-4">
              <label class="block text-base font-semibold text-gray-700 mr-4">Date of Birth:</label>
              <input type="date" v-model="sheet.date_of_birth" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
            </div>
            <div class="flex-grow flex items-center mr-4">
              <label class="block text-base font-semibold text-gray-700 mr-4">Place of birth:</label>
              <input type="text" v-model="sheet.place_of_birth" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
            </div>
          </div>
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Religion:</label>
            <input type="text" v-model="sheet.religion" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
          </div>
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Occupation:</label>
            <input type="text" v-model="sheet.occupation" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
          </div>
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Highest Educ'l Att't:</label>
            <input type="text" v-model="sheet.highest_educ_att" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
          </div>
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Name of School:</label>
            <input type="text" v-model="sheet.school_name" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
          </div>
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Class Adviser:</label>
            <input type="text" v-model="sheet.class_adviser" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
          </div>
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">Vices/Start:</h2>
        <div class="space-y-2">
          <label><input type="checkbox" v-model="sheet.vices.gambling" :disabled="!editMode" /> Gambling</label><br />
          <label><input type="checkbox" v-model="sheet.vices.drugs" :disabled="!editMode" /> Drugs (_______)</label><br />
          <label><input type="checkbox" v-model="sheet.vices.cigarette" :disabled="!editMode" /> Cigarette</label><br />
          <label><input type="checkbox" v-model="sheet.vices.liquor" :disabled="!editMode" /> Liquor</label><br />
          <label><input type="checkbox" v-model="sheet.vices.computer_games" :disabled="!editMode" /> Computer Games (_______ hrs)</label><br />
        </div>
      </div>
    </div>

    <div class="border-gray-300 ml-6 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        <div class="flex flex-col">
          <p class="ml-24 -mb-4 font-bold">PAGE 1 of 2</p>
          <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
          <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
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
        <textarea v-model="sheet.school_activities_achievement" class="border w-full px-2 py-1" rows="4" :readonly="!editMode"></textarea>
      </div>
    </div>

    <div class="mb-8">
      <h2 class="text-lg font-semibold">Family:</h2>
      <div class="grid grid-cols-2 gap-4">
        <div class="flex-grow flex items-center mr-4">
          <label class="block text-base font-semibold text-gray-700 mr-4">Mother's Occupation:</label>
          <input type="text" v-model="sheet.occupation_of_mother" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
        </div>
        <div class="flex-grow flex items-center mr-4">
          <label class="block text-base font-semibold text-gray-700 mr-4">Father's Occupation:</label>
          <input type="text" v-model="sheet.occupation_of_father" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
        </div>
      </div>
      <div class="space-y-2">
        <label>Siblings:</label>
        <input type="text" v-model="sheet.siblings[0]" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
        <input type="text" v-model="sheet.siblings[1]" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
        <input type="text" v-model="sheet.siblings[2]" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
      </div>
      <div class="space-y-2">
        <label>Responsible for Households Chores:</label>
        <input type="text" v-model="sheet.responsible_for_households_chores" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
      </div>
    </div>

    <div class="mb-8">
      <h2 class="text-lg font-semibold">Community:</h2>
      <div class="space-y-2">
        <label>No. of Days Detention/Jail/CSWD/MSWDO:</label>
        <input type="text" v-model="sheet.detention_days" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
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
        <input type="text" v-model="sheet.house_made_of" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
      </div>
    </div>

    <div class="border-gray-300 ml-6 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        <div class="flex flex-col">
          <p class="ml-24 -mb-4 font-bold">PAGE 2 of 2</p>
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
</template>

<script>
import axios from 'axios';
import Pagination from '@/Components/Pagination.vue';

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
        date: '',
        vices: {
          gambling: false,
          drugs: false,
          cigarette: false,
          liquor: false,
          computer_games: false,
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

      // Populate general intake sheet fields
      this.sheet.occupation = generalIntake.occupation;
      this.sheet.highest_educ_att = generalIntake.highest_educ_att;
      this.sheet.school_name = generalIntake.school_name;
      this.sheet.class_adviser = generalIntake.class_adviser;

      // Store general intake ID for further use
      this.sheet.general_intake_id = generalIntake.id;

      console.log('General Intake data mapped to sheet:', this.sheet);
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
    confirmSave() {
      this.saveData();
      this.closeModal();
      this.editMode = false;
    },
    cancelEdit() {
      this.editMode = false;
    },
    saveData() {
  if (!this.clientId) {
    this.message = 'No client selected.';
    this.messageType = 'error';
    this.clearNotification();
    return;
  }

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
    vices: this.sheet.vices,
    date: this.sheet.date,
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
    }
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
