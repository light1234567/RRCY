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

<div class="graph-background pt-0.5  -mr-9 -mb-16">

  <div class="max-w-3xl mx-auto mt-8 p-12 bg-white border border-gray-400 rounded-lg shadow-lg">
  <div class="text-center mb-8">
    <div class="flex justify-between items-center mb-4">
      <img src="/images/headerlogo2.png" alt="DSWD Logo"  class="h-32 w-64 -mt-16 relative z-10" />
      <div class="text-right">
        <p class="item-center mr-6 text-sm font-semibold">PROTECTIVE SERVICES DIVISION</p>
        <p class=" text-sm font-semibold">Regional Rehabilitation Center for Youth</p>
        <p class="mr-20 text-sm font-semibold">Youth/RFO XI</p>
        <div class="text-xs font-semibold pt-12">
  <p class="text-sm">
  DRN
  <input type="text" v-model="drn" class="underline-input text-sm p-1" :readonly="!editMode" />
</p>
</div>      </div>
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
            class="underline-input shadow-sm w-3/4" 
            :readonly="!editMode">
    </div>
    <div>
      <label for="dateOfDuty" class="block font-medium">Date of Duty:</label>
      <input type="date" v-model="form.date_of_duty" id="dateOfDuty" 
            class="underline-input shadow-sm w-3/4" 
            :readonly="!editMode">
    </div>
    <div>
      <label for="requestingPartyPosition" class="block font-medium">Position:</label>
      <input type="text" v-model="form.requesting_party_position" id="requestingPartyPosition" 
            class="underline-input shadow-sm w-3/4" 
            :readonly="!editMode">
    </div>
    <div>
  <label for="timeOfDuty" class="block font-medium">Time of Duty:</label>
  <input 
    type="time" 
    v-model="form.time_of_duty" 
    id="timeOfDuty" 
    class="underline-input shadow-sm w-3/4" 
    :readonly="!editMode"
  />
</div>
  </div>


  <!-- SOD Section -->
  <div class="mb-6">
  <p class="font-bold"></p>
  <div class="grid grid-cols-2 gap-4">
    <div>
      <label for="sodName" class="block font-medium">Name of SOD accepted the request:</label>
      <input type="text" v-model="form.sod_name" id="sodName" 
            class="underline-input shadow-sm w-3/4" 
            :readonly="!editMode">
    </div>
    <div>
      <label for="sodDateOfDuty" class="block font-medium">Date of Duty:</label>
      <input type="date" v-model="form.sod_date_of_duty" id="sodDateOfDuty" 
            class="underline-input shadow-sm w-3/4" 
            :readonly="!editMode">
    </div>
    <div>
      <label for="sodPosition" class="block font-medium">Position:</label>
      <input type="text" v-model="form.sod_position" id="sodPosition" 
            class="underline-input shadow-sm w-3/4" 
            :readonly="!editMode">
    </div>
    <div>
      <label for="sodShiftTime" class="block font-medium">Shift/Time of Duty:</label>
      <input type="text" v-model="form.sod_shift_time" id="sodShiftTime" 
            class="underline-input shadow-sm w-3/4" 
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
      <input type="text" v-model="form.requested_by" id="requestedBy" class="underline-input shadow-sm w-3/4" 
      :readonly="!editMode">
      <div class="mb-6 flex justify-start items-center">
        <label for="requestedPosition" class="block font-medium">Position:</label>
  <input type="text" v-model="form.requested_by_position" id="requestedPosition" 
        class="underline-input shadow-sm w-1/2" 
        :readonly="!editMode">
      </div>
    </div>
    <div>
      <label for="acceptedBy" class="block font-medium">Accepted by:</label>
      <input type="text" v-model="form.accepted_by" id="acceptedBy" class="underline-input shadow-sm w-3/4" :readonly="!editMode">
      <div class="mb-6 flex justify-start items-center">
      <label for="acceptedPosition" class="block font-medium">Position:</label>
      <input type="text" v-model="form.accepted_by_position" id="acceptedPosition" class="underline-input shadow-sm w-1/2" :readonly="!editMode">
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
        v-model="form.swapping_shp"
        class="mt-1 w-3/4 border-none font-semibold text-base"
        :readonly="!editMode"
      >
      <p class="text-sm ">HP III/SHP</p>
    </div>

    <!-- Approved by Section -->
    <div class="w-1/2">
      <label for="approvedBy" class="block text-sm font-medium">Approved by:</label>
      <input
        type="text"
        id="approvedBy"
        v-model="center_head"
        class="mt-1 w-3/4 border-none font-semibold"
        readonly
      >
      <p class="text-sm ml-2">SWO IV / Center Head</p>
    </div>
  </div>

    <!-- Footer Section -->
    <div class=" pt-4 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        <div class="flex flex-col">
          <p class="font-bold">PAGE 1 of 1</p>
          <p class="border-t border-black pt-2">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
          <p>Email: <span class="text-blue-600 underline">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
        </div>
        <div>
          <img src="/images/footerimg.png" alt="Footer Image" class="h-12 w-24 object-cover">
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
</div>
</template>

<script>
import jsPDF from 'jspdf';
import axios from 'axios';
import Pagination from '@/Components/Pagination.vue';

export default {
name: 'SwappingForm',
components: {
  Pagination,
},
data() {
  return {
    center_head: '',
    drn: '',
    form: {
      client_id: null,
      drn: '',
      date_of_filing: '',
      requesting_party_name: '',
      requesting_party_position: '',
      requested_by_position:'',
      accepted_by_position:'',
      date_of_duty: '',
      time_of_duty: '',
      sod_name: '',
      sod_date_of_duty: '',
      sod_position: '',
      sod_shift_time: '',
      purpose: '',
      requested_by: '',
      accepted_by: '',
      swapping_shp: '',
      approved_by: 'ANGELIC B. PAÑA',
    },
    originalForm: null,
    editMode: false,
    message: '',
    messageType: '', // 'success' or 'error'
    isModalOpen: false,
    isSaveResultModalOpen: false,
    saveResultTitle: '',
    saveResultMessage: '',
    currentPage: 1,
    totalPages: 1,
  };
},
mounted() {
  const clientId = this.$route.params.id;
    this.fetchData(clientId);
    this.fetchDrn(clientId);
    this.fetchCenterHead();
},
watch: {
  '$route.params.id': function(newId) {
      this.fetchData(newId);
      this.fetchDrn(newId);
  }
},
methods: {
  fetchData() {
    const clientId = this.$route.params.id;
    console.log('Fetching data for client ID:', clientId);
    if (clientId) {
      axios.get(`/api/swapping-forms/${clientId}`).then(response => {
        if (response.data.form) {
          this.form = response.data.form;
          this.form.client_id = clientId;
          this.originalForm = JSON.parse(JSON.stringify(this.form));
        } else {
          this.form.client_id = clientId;
        }
      }).catch(error => {
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
  
  fetchDrn(clientId) {
  if (!clientId) {
    console.error("Client ID is missing.");
    return;
  }
  // Fetch DRN based on clientId
  axios.get(`/api/drn/${clientId}`)
    .then(response => {
      this.drn = response.data.drn || ''; // Set DRN to the response, or an empty string if not present
      console.log("Fetched DRN:", this.drn);
    })
    .catch(error => {
      console.error("Error fetching DRN:", error);
    });
},


saveDrn() {
  const clientId = this.form.client_id; // Ensure client_id is available in the form
  if (!clientId) {
    console.error("Client ID is missing.");
    return;
  }

  // Save or update DRN
  axios.post('/api/drn', {
    client_id: clientId, // Pass the client_id
    drn: this.drn // Pass the DRN value
  })
  .then(response => {
    console.log("DRN saved successfully:", response.data);
    this.fetchDrn(clientId); // Fetch updated DRN after save
  })
  .catch(error => {
    console.error("Error saving DRN:", error.response.data); // Log detailed error message
  });
},
formatTime(value) {
  if (!value) return ''; // Handle empty time case

  // Handle the time string and format it to H:i (24-hour format)
  const date = new Date(`1970-01-01T${value}`);
  let hours = date.getHours().toString().padStart(2, '0');
  let minutes = date.getMinutes().toString().padStart(2, '0');
  
  return `${hours}:${minutes}`;
}
,
  toggleEdit() {
    if (this.editMode) {
      this.openModal();
    } else {
      this.originalForm = JSON.parse(JSON.stringify(this.form));
      this.editMode = true;
    }
  },

  openModal() {
    this.isModalOpen = true;
  },

  closeModal() {
    this.isModalOpen = false;
  },

  confirmSave() {
    this.submitForm();
    this.saveDrn();
    this.closeModal();
  },

  cancelEdit() {
    if (this.originalForm) {
      this.form = JSON.parse(JSON.stringify(this.originalForm));
    }
    this.editMode = false;
  },

  submitForm() {
    if (this.form.time_of_duty) {
    this.form.time_of_duty = this.formatTime(this.form.time_of_duty);
  }
  
    if (!this.form.client_id) {
      this.message = 'Client ID is required.';
      this.messageType = 'error';
      return;
    }

    const url = `/api/swapping-forms/${this.form.client_id}`;

    axios.put(url, this.form)
      .then(response => {
        this.editMode = false;
        this.message = 'Data updated successfully!';
        this.messageType = 'success';
        this.saveResultTitle = 'Success';
        this.saveResultMessage = 'Data saved successfully.';
        this.isSaveResultModalOpen = true;
        this.clearMessage();
        this.fetchData();
      })
      .catch(error => {
        this.message = 'Failed to update data';
        this.messageType = 'error';
        this.saveResultTitle = 'Error';
        this.saveResultMessage = error.response?.data?.message || 'Error saving data.';
        this.isSaveResultModalOpen = true;
        this.clearMessage();
      });
  },

  clearMessage() {
    setTimeout(() => {
      this.message = '';
      this.messageType = '';
    }, 3000);
  },

  closeSaveResultModal() {
    this.isSaveResultModalOpen = false;
    this.saveResultTitle = '';
    this.saveResultMessage = '';
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
    pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 135, 20);
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
      pdf.setFontSize(11);
    }
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


  contentYPos += -25;
  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(9);
  pdf.text(`DRN :  ________________________ ${this.form.name || ''}`, initialX+110, contentYPos);

  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(14);
  pdf.text('REGIONAL REHABILITATION CENTER FOR YOUTH', 105, 48, { align: 'center' });
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  pdf.text('Bago Oshiro Tugbok dist. Davao City', 105, 53, { align: 'center' });
  contentYPos += 15;

  // Content starts below title
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(13);

  contentYPos += rowHeight;
contentYPos += 6;

pdf.text(`Date of Filing:`, initialX + 100, contentYPos);


const date_of_filingValue = `${this.form.date_of_filing || ''}`;
const date_of_filingWidth = pdf.getTextWidth(date_of_filingValue);
pdf.text(date_of_filingValue, initialX + 130, contentYPos);  
pdf.line(initialX + 130, contentYPos + 1, initialX + 130 + date_of_filingWidth, contentYPos + 1); 

contentYPos += 4;
contentYPos += rowHeight;
pdf.text(`Name of Requesting Party:`, initialX, contentYPos);
const requesting_party_nameValue = `${this.form.requesting_party_name || ''}`;
const requesting_party_nameWidth = pdf.getTextWidth(requesting_party_nameValue);
pdf.text(requesting_party_nameValue, initialX, contentYPos+8);  
pdf.line(initialX, contentYPos + 10, initialX +  + requesting_party_nameWidth, contentYPos + 10); 

pdf.text(`Date of Duty:`, initialX + 100, contentYPos);
const date_of_dutyValue = `${this.form.date_of_duty || ''}`;
const date_of_dutyWidth = pdf.getTextWidth(date_of_dutyValue);
pdf.text(date_of_dutyValue, initialX + 100, contentYPos+8); 
pdf.line(initialX + 100, contentYPos + 10, initialX + 100 + date_of_dutyWidth, contentYPos + 10); 


contentYPos += 15;
contentYPos += rowHeight;
pdf.text(`Position:`, initialX, contentYPos);
const requesting_party_positionValue = `${this.form.requesting_party_position || ''}`;
const requesting_party_positionWidth = pdf.getTextWidth(requesting_party_positionValue);
pdf.text(requesting_party_positionValue, initialX, contentYPos+8);  
pdf.line(initialX, contentYPos + 10, initialX +  + requesting_party_positionWidth, contentYPos + 10); 

pdf.text(`Time of Duty:`, initialX + 100, contentYPos);
const time_of_dutyValue = `${this.form.time_of_duty || ''}`;
const time_of_dutyWidth = pdf.getTextWidth(time_of_dutyValue);
pdf.text(time_of_dutyValue, initialX + 100, contentYPos+8); 
pdf.line(initialX + 100, contentYPos + 10, initialX + 100 + time_of_dutyWidth, contentYPos + 10); 

contentYPos += 15;
contentYPos += rowHeight;
pdf.text(`Name of SOD accepted the request:`, initialX, contentYPos);
const sod_nameValue = `${this.form.sod_name || ''}`;
const sod_nameWidth = pdf.getTextWidth(sod_nameValue);
pdf.text(sod_nameValue, initialX, contentYPos+8);  
pdf.line(initialX, contentYPos + 10, initialX +  + sod_nameWidth, contentYPos + 10); 

pdf.text(`Date of Duty:`, initialX + 100, contentYPos);
const sod_date_of_dutyValue = `${this.form.sod_date_of_duty || ''}`;
const sod_date_of_dutyWidth = pdf.getTextWidth(sod_date_of_dutyValue);
pdf.text(sod_date_of_dutyValue, initialX + 100, contentYPos+8); 
pdf.line(initialX + 100, contentYPos + 10, initialX + 100 + sod_date_of_dutyWidth, contentYPos + 10); 



contentYPos += 15;
contentYPos += rowHeight;
pdf.text(`Position:`, initialX, contentYPos);
const sod_positionValue = `${this.form.sod_position || ''}`;
const sod_positionWidth = pdf.getTextWidth(sod_positionValue);
pdf.text(sod_positionValue, initialX, contentYPos+8);  
pdf.line(initialX, contentYPos + 10, initialX +  + sod_positionWidth, contentYPos + 10); 

pdf.text(`Shift/Time of Duty:`, initialX + 100, contentYPos);
const sod_shift_timeValue = `${this.form.sod_shift_time || ''}`;
const sod_shift_timeWidth = pdf.getTextWidth(sod_shift_timeValue);
pdf.text(sod_shift_timeValue, initialX + 100, contentYPos+8); 
pdf.line(initialX + 100, contentYPos + 10, initialX + 100 + sod_shift_timeWidth, contentYPos + 10); 

contentYPos += rowHeight;
  addNewPageIfNeeded();
  contentYPos +=8;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  contentYPos +=7;
  pdf.text('Purpose:', initialX, contentYPos);

  contentYPos +=7;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  const purposeLog = `${this.form.purpose || ''}`;
  const purposeLogLines = pdf.splitTextToSize(purposeLog, maxWidth);

  purposeLogLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos);
    contentYPos += lineHeight;
  });



  contentYPos += 7;
contentYPos += rowHeight;
addNewPageIfNeeded();
pdf.setLineWidth(0);
pdf.setFont('arial', 'normal');
pdf.setFontSize(12);
pdf.text(`Requested by:`, initialX, contentYPos);
const requested_byValue = `${this.form.requested_by || ''}`;
const requested_byWidth = pdf.getTextWidth(requested_byValue);
pdf.text(requested_byValue, initialX, contentYPos+8);  
pdf.line(initialX, contentYPos + 10, initialX +  + requested_byWidth, contentYPos + 10); 

pdf.text(`Accepted by:`, initialX + 100, contentYPos);
const accepted_byValue = `${this.form.accepted_by || ''}`;
const accepted_byWidth = pdf.getTextWidth(accepted_byValue);
pdf.text(accepted_byValue, initialX + 100, contentYPos+8); 
pdf.line(initialX + 100, contentYPos + 10, initialX + 100 + accepted_byWidth, contentYPos + 10); 

contentYPos += 15;
pdf.text(`Position:`, initialX, contentYPos);
const requesting_party_position2Value = `${this.form.requesting_party_position || ''}`;
const requesting_party_position2Width = pdf.getTextWidth(requesting_party_position2Value);
pdf.text(requesting_party_position2Value, initialX + 18, contentYPos);  
pdf.line(initialX + 18, contentYPos + 1, initialX + 18 + requesting_party_position2Width, contentYPos + 1); 

pdf.text(`Position:`, initialX + 100, contentYPos);
const dateValue = `${this.form.date_conducted || ''}`;
const dateWidth = pdf.getTextWidth(dateValue);
pdf.text(dateValue, initialX + 135, contentYPos); 
pdf.line(initialX + 135, contentYPos + 1, initialX + 135 + dateWidth, contentYPos + 1); 



contentYPos += 10;

  contentYPos += rowHeight; 
  addNewPageIfNeeded();
  pdf.setFontSize(11);
  pdf.text('Noted by:', initialX, contentYPos);
  pdf.text('Approved by:', initialX+100, contentYPos);
  
  contentYPos += rowHeight; 

  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(11);
  pdf.text('VAN M. DE LEON', initialX, contentYPos);
  contentYPos += 4; 
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(10);
  pdf.line(20, contentYPos+-3, 55, contentYPos+-3);
  pdf.text('HP III/SHP', initialX, contentYPos+2);

  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(11);
  pdf.text('ANGELIC B. PAÑA', initialX+100, contentYPos+-4);
  contentYPos += 5; 
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(10);
  pdf.line(120, contentYPos+-8, 157, contentYPos+-8);
  pdf.text('SWO IV / Center Head', initialX+100, contentYPos+-4);

  // Add the footer for the last page
  addFooter();

  const totalPages = pdf.internal.getNumberOfPages();
  for (let i = 1; i <= totalPages; i++) {
    pdf.setPage(i);
    pdf.setFontSize(9);
    pdf.setFont('TimesNewRoman', 'bold');
    pdf.text(`PAGE ${i} of ${totalPages}`, 105, 280, { align: 'center' }); // Update the footer with the correct total pages
  }

  // Save the PDF with dynamic file name
  pdf.save(`Swapping_${this.form.name || ''}.pdf`);
},
}
};
</script>


<style scoped>
.underline-input {
border: none;
border-bottom:  1px solid black;
padding: 0;
margin: 0;
vertical-align: bottom; /* Ensures the text aligns with the bottom of the input */
}
.graph-background {
    background-image: linear-gradient(to right, #cccccc 1px, transparent 1px), 
                      linear-gradient(to bottom, #cccccc 1px, transparent 1px);
    background-size: 15px 15px; /* Adjust size as per your need */
  } 
</style>
