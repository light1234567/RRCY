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

  <div class="max-w-3xl mx-auto mt-8 p-16 bg-white border border-gray-400 rounded-lg shadow-lg">
   <!-- Header Section -->
   <div class="text-center mb-8">
     <div class="flex justify-between items-center mb-4">
       <img src="/images/headerlogo2.png" alt="DSWD Logo" class="h-32 w-64 -mt-16 relative z-10" />
       <div class="text-right">
         <p class="item-center  text-sm font-semibold">PROTECTIVE SERVICES DIVISION</p>
         <p class=" text-sm font-semibold">Regional Rehabilitation Center for</p>
         <p class="mr-20 text-sm font-semibold">Youth/RFO XI</p>
         <p class="text-center text-xs">DSWD-GF-010A | REV 02 | 17 AUG 2022</p>
         <div class="text-xs font-semibold pt-12">
  <p class="text-sm font-semibold">
  DRN :
  <input type="text" v-model="drn" class="underline-input text-sm p-1" :readonly="!editMode" />
</p>
</div> 
     
</div>
      </div>
      <h1 class="font-bold text-md">INCIDENT REPORT</h1>
    </div>

    <!-- Incident Details -->
    <div class="mb-6">
      <label for="incident" class="block font-semibold">What was the incident: (Unsa nga Offense? Unsa rason ngano Nahitabo?)</label>
      <textarea
        id="incident"
        v-model="form.incident"
        class="border border-gray-400 p-2 w-full"
        rows="3"
        :readonly="!editMode"
      ></textarea>
    </div>

    <!-- When It Happened -->
    <div class="text-center font-semibold mb-4">
      WHEN IT HAPPENED
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
      <div>
        <label for="dateOfIncident" class="block text-sm"><span class="w-auto mr-2 font-semibold">Date of Incident:</span>
        <input
          type="date"
          id="dateOfIncident"
          v-model="form.date_of_incident"
          required
          class="underline-input p-2 text-sm w-28"
          :readonly="!editMode"
        >
      </label>
      </div>
      <br />
      <div>
        <label for="timeOfIncident" class="block text-sm"><span class="w-auto mr-2 font-semibold">Time:</span>
        <input
          type="time"
          id="timeOfIncident"
          v-model="form.time_of_incident"
          required
          class="underline-input text-sm p-2 w-28"
          :readonly="!editMode"
        >
      </label>
      </div>
    </div>

    <!-- Who Are Involved -->
    <div class="mb-6">
      <label for="involved" class="block font-semibold">Who are involved? (State name of residents)</label>
      <textarea
        id="involved"
        v-model="form.involved"
        class="border border-gray-400 p-2 w-full"
        rows="3"
        :readonly="!editMode"
      ></textarea>
    </div>

    <!-- Where It Happened -->
    <div class="mb-6">
      <label for="location" class="block font-semibold">Where it happened? (Exact place of the incident)</label>
      <textarea
        id="location"
        v-model="form.location"
        class="border border-gray-400 p-2 w-full"
        rows="3"
        :readonly="!editMode"
      ></textarea>
    </div>

    <!-- Action Taken -->
    <div class="mb-6">
      <label for="actionTaken" class="block font-semibold">Action Taken</label>
      <textarea
        id="actionTaken"
        v-model="form.action_taken"
        class="border border-gray-400 p-2 w-full"
        rows="3"
        :readonly="!editMode"
      ></textarea>
    </div>

    <!-- Agreements Reached/Advice Given -->
    <div class="mb-6">
      <label for="agreements" class="block font-semibold">Agreements Reached/Advice Given to Residents Involved</label>
      <textarea
        id="agreements"
        v-model="form.agreements"
        class="border border-gray-400 p-2 w-full"
        rows="3"
        :readonly="!editMode"
      ></textarea>
    </div>

    <!-- Corrective Measure -->
    <div class="mb-6">
      <label for="correctiveMeasure" class="block font-semibold">Corrective Measure</label>
      <textarea
        id="correctiveMeasure"
        v-model="form.corrective_measure"
        class="border border-gray-400 p-2 w-full"
        rows="3"
        :readonly="!editMode"
      ></textarea>
    </div>

   <!-- Signatures Section -->
    <div class="grid grid-cols-1 gap-4 mb-6">
      <!-- Prepared by Field -->
      <div>
        <label for="preparedBy" class="block font-medium text-sm">Prepared by:</label>
        <input
          type="text"
          id="preparedBy"
          v-model="form.prepared_by"
          class="mt-1 w-64 text-sm underline-input shadow-sm"
          :readonly="!editMode">
      </div>

      <!-- Reviewed and Approved by Fields -->
      <div class="grid grid-cols-2 gap-4">
        <div class="">
          <label for="reviewedBy" class="block font-medium text-sm">Reviewed by:</label>
          <input
            type="text"
            id="reviewedBy"
            v-model="form.incident_report_shp"
            class="font-semibold  mt-1 w-3/4 border-b-2 text-sm underline-input p-0 rounded-none shadow-sm"
            :readonly="!editMode"
          >
          <p class="font-semibold text-sm">HP III/SHP</p>
        </div>
        <div>
          <label for="approvedBy" class="block font-medium text-sm">Approved by:</label>
          <input
            type="text"
            id="approvedBy"
            v-model="center_head"
            class="font-semibold  mt-1 w-3/4 text-sm underline-input p-0 shadow-sm"
            readonly
          >
          <p class="font-semibold text-sm">SWO IV / Center Head</p>
        </div>
      </div>
    </div>

    <div class=" border-gray-300 pt-4 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;"> 
      <div class="flex justify-between items-start w-full">
          <div class="flex flex-col w-full"> <!-- Expanded width for the text section -->
              <p class="font-bold">PAGE 1 of 1</p>
              <p class="border-t-2 border-black"></p>
              <p class="pt-2">DSWD FOXI, Regional Rehabilitation Center for Youth, Bago Oshiro, Davao City, Philippines 8000</p>
              <p > Email: <span class="text-blue-600 underline">rrcy.fo11.dswd.gov.ph</span> Tel No.(082) 293-0306</p>
          </div>
          <div class="w-1/6 flex justify-end"> <!-- Restricting the image section to the right side -->
              <img src="/images/footerimg.png" alt="Footer Image" class="h-12 w-32 object-cover"> <!-- Expanded width for image -->
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
import axios from 'axios';
import Pagination from '@/Components/Pagination.vue';
import jsPDF from 'jspdf';

export default {
  name: 'IncidentReportForm',
  components: {
    Pagination,
  },
  data() {
    return {
      center_head: '',
      form: {
        client_id: null,
        drn: '',
        incident: '',
        date_of_incident: '',
        time_of_incident: '',
        involved: '',
        location: '',
        action_taken: '',
        agreements: '',
        corrective_measure: '',
        prepared_by: '',
        prepared_by_position: '',
        incident_report_shp: '',
        approved_by: 'ANGELIC B. PAÑA',
      },
      originalForm: null, // To store the original form data
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
      this.fetchSHP(newId);
      this.fetchDrn(newId);
    }
  },
  methods: {
    fetchData() {
    const clientId = this.$route.params.id;
    console.log('Fetching data for client ID:', clientId);
    if (clientId) {
      axios.get(`/api/incident-reports/${clientId}`).then(response => {
        if (response.data.report) {
          // Populate form with existing report data
          this.form = {
            ...this.form,
            ...response.data.report,
            time_of_incident: response.data.report.time_of_incident
              ? response.data.report.time_of_incident.slice(0, 5)
              : '',
          };
          this.form.client_id = clientId;
          this.originalForm = JSON.parse(JSON.stringify(this.form)); // Store original data
        } else {
          // No report exists yet, set client_id for a new report
          const { client } = response.data;
          this.form.client_id = client.id;
          this.originalForm = JSON.parse(JSON.stringify(this.form)); // Store original data
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
    axios.get(`/api/drn/${clientId}`)
      .then(response => {
        this.drn = response.data.drn || '';
        console.log("Fetched DRN:", this.drn);
      })
      .catch(error => {
        console.error("Error fetching DRN:", error);
      });
  },

  saveDrn() {
    const clientId = this.form.client_id; // Assuming client_id is in the form
    console.log("Saving DRN:", this.drn, "for client:", clientId);

    if (!clientId) {
        console.error("Client ID is missing.");
        return;
    }

    axios.post('/api/drn', {  // Ensure the correct URL with /api prefix
        client_id: clientId,
        drn: this.drn
    })
    .then(response => {
        console.log("DRN saved successfully:", response.data);
        this.fetchDrn(clientId); // Fetch updated DRN
    })
    .catch(error => {
        console.error("Error saving DRN:", error.response.data); // Log detailed error message
    });
},
    toggleEdit() {
      if (this.editMode) {
        this.openSaveModal();
      } else {
        this.editMode = true;
        this.originalForm = JSON.parse(JSON.stringify(this.form)); // Store the original form data before editing
      }
    },

    openSaveModal() {
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
        // Revert to the original data
        this.form = JSON.parse(JSON.stringify(this.originalForm));
      }
      this.editMode = false; // Exit edit mode
    },

    submitForm() {
    if (!this.form.client_id) {
      this.message = 'Client ID is required.';
      this.messageType = 'error';
      this.clearMessage();
      return;
    }

    if (this.form.time_of_incident) {
      this.form.time_of_incident = this.form.time_of_incident.slice(0, 5);
    }

    const url = `/api/incident-reports/${this.form.client_id}`;

    // Check if we are updating or creating a new record
    axios.get(`/api/incident-reports/${this.form.client_id}`)
      .then(response => {
        if (response.data.report) {
          // Update existing report
          axios.put(url, this.form)
            .then(response => {
              this.message = 'Data updated successfully!';
              this.messageType = 'success';
              this.fetchData(); // Refresh data
            })
            .catch(error => {
              this.handleError(error);
            });
        } else {
          // Create new report
          axios.post(`/api/incident-reports`, this.form)
            .then(response => {
              this.message = 'Data created successfully!';
              this.messageType = 'success';
              this.fetchData(); // Refresh data
            })
            .catch(error => {
              this.handleError(error);
            });
        }
      })
      .catch(error => {
        console.error('Error fetching report for validation:', error);
      });
  },
  handleError(error) {
    if (error.response && error.response.status === 422) {
      this.message = 'Validation error: ' + JSON.stringify(error.response.data.errors);
    } else {
      this.message = 'Failed to save data';
    }
    this.messageType = 'error';
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

    updatePage(newPage) {
      this.currentPage = newPage;
      // Add logic to fetch data or change content based on the page
    },
    exportToPdf() {
  const pdf = new jsPDF('p', 'mm', [216, 356]); // Legal size: 216mm x 356mm
  const pageHeight = 356; // Total page height in mm
  const marginBottom = 30; // Bottom margin in mm
  const rowHeight = 8; // Height of each row
  const lineHeight = 7; // Space between lines
  const footerHeight = 0; // Adjust to fit the height of your footer
  const maxContentHeight = pageHeight - marginBottom - footerHeight; // Reduce height to account for footer
  const maxWidth = 170; // Maximum width for text
  let contentYPos = 75; // Start Y position for content
  let initialX = 20; // X position for content
  let currentPage = 1; // Start at page 1

  
  const addHeader = () => {
    // Header text
    pdf.setFontSize(9);
    pdf.setFont('TimesNewRoman', 'italic');
    pdf.text('DSWD-GF-010A | REV 02 | 17 AUG 2022', 135, 20);
  };
  
  // Helper function to add a new page if content exceeds the page height
  const addNewPageIfNeeded = () => {
    if (contentYPos >= maxContentHeight) {
      addFooter(); // Add the footer for the current page
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
        pdf.text('Website: http://www.rrcy.fo11@dswd.gov.ph Tel Nos.: (082) 293-03-06', 105, 345, { align: 'center' });
  
        const footerImgData = '/images/footerimg.png';
        pdf.addImage(footerImgData, 'PNG', 175, 330, 25, 12); // Footer image
  
      } else {
        // Footer for Page 2 and beyond
        pdf.setFontSize(8.5);
        pdf.setFont('TimesNewRoman', 'bold');
  
        pdf.setLineWidth(0.5);
        pdf.line(17, 335, 193, 335); // Footer line extending further
  
        pdf.setFont('times', 'bold');
        pdf.text('DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH', 105, 340, { align: 'center' });
      }
    };


  // DSWD logo
  const imgData = '/images/headerlogo2.png';
  pdf.addImage(imgData, 'PNG', 15, 5, 70, 35);

      // Add title and header text
      pdf.setFontSize(10);
    pdf.setFont('arialbd', 'bold'); 
    pdf.text('PROTECTIVE SERVICES DIVISION', 150, 19, { align: 'center' });
    pdf.text('Regional Rehabilitation Center for', 150, 24, { align: 'center' });
    pdf.text('Youth FOR XI', 150, 28, { align: 'center' });
  
    pdf.setFontSize(8);
    pdf.setFont('arial', 'italic'); 
    pdf.text('DSWD-GF-010A | REV 02 | 17 AUG 2022', 150, 32, { align: 'center' });
  

  contentYPos += -20;
  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(11);
  pdf.text(`DRN :`, initialX+110, contentYPos+-5);
  pdf.text(`${this.drn || ''}`, initialX+122, contentYPos+-5);
  pdf.line(142, contentYPos+-4, 190, contentYPos+-4); 


  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(14);
  pdf.text('INCIDENT REPORT', 105, 60, { align: 'center' });
  contentYPos += 15;

  // Content starts below title
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(11);

  contentYPos += rowHeight;
  addNewPageIfNeeded();
  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(12);
  pdf.text('What was the incident: (Unsa nga Offense? Unsa rason ngano Nahitabo?)', initialX, contentYPos);

  contentYPos +=7;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  const incidentLog = `${this.form.incident || ''}`;
  const incidentLogLines = pdf.splitTextToSize(incidentLog, maxWidth);

  incidentLogLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos);
    contentYPos += lineHeight;
  });

  contentYPos += rowHeight;
  addNewPageIfNeeded();
  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(12);
  pdf.text('WHEN IT HAPPENED', initialX+65, contentYPos);
  contentYPos += rowHeight;
  pdf.setFontSize(11);
  pdf.setFont('arialbd', 'bold');
  pdf.text(`Date of Incident:`, initialX, contentYPos);
const date_of_incidentValue = `${this.form.date_of_incident || ''}`;
const date_of_incidentWidth = pdf.getTextWidth(date_of_incidentValue);
pdf.setFont('arial', 'normal');
pdf.text(date_of_incidentValue, initialX + 34, contentYPos);  
pdf.line(initialX + 34, contentYPos + 1, initialX + 34 + date_of_incidentWidth, contentYPos + 1); 

// Function to convert 24-hour time to 12-hour time with AM/PM
const convertTo12Hour = (time) => {
  let [hours, minutes] = time.split(':');
  hours = parseInt(hours);

  const ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12 || 12; // Convert 24-hour to 12-hour format
  return `${hours}:${minutes} ${ampm}`;
};

// Adjust Y position for time display
contentYPos += 8;
pdf.setFontSize(11);
pdf.setFont('arialbd', 'bold');
pdf.text(`Time:`, initialX, contentYPos);

// Get the time_of_incident value (if it's available) and convert it to 12-hour format
let time_of_incidentValue = `${this.form.time_of_incident || ''}`;
if (time_of_incidentValue) {
  time_of_incidentValue = convertTo12Hour(time_of_incidentValue); // Convert to 12-hour format with AM/PM
}

// Get the width of the time_of_incident value
const time_of_incidentWidth = pdf.getTextWidth(time_of_incidentValue);

pdf.setFont('arial', 'normal');
pdf.text(time_of_incidentValue, initialX + 13, contentYPos);  

// Add an underline for the time value
pdf.line(initialX + 13, contentYPos + 1, initialX + 13 + time_of_incidentWidth, contentYPos + 1);


  contentYPos += rowHeight;
  addNewPageIfNeeded();
  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(12);
  contentYPos +=7;
  pdf.text('Who are involved? (State name of residents)', initialX, contentYPos);

  contentYPos +=7;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  const involvedlLog = `${this.form.involved || ''}`;
  const involvedlLogLines = pdf.splitTextToSize(involvedlLog, maxWidth);

  involvedlLogLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos);
    contentYPos += lineHeight;
  });

  contentYPos += rowHeight;
  contentYPos +=5;
  addNewPageIfNeeded();
  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(12);
  pdf.text('Where it happened? (Exact place of the incident)', initialX, contentYPos);

  contentYPos +=7;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  const locationlLog = `${this.form.location || ''}`;
  const locationlLogLines = pdf.splitTextToSize(locationlLog, maxWidth);

  locationlLogLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos);
    contentYPos += lineHeight;
  });

  contentYPos += rowHeight;
  contentYPos +=5;
  addNewPageIfNeeded();
  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(12);
  pdf.text('Action Taken', initialX, contentYPos);

  contentYPos +=7;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  const action_takenlLog = `${this.form.action_taken || ''}`;
  const action_takenlLogLines = pdf.splitTextToSize(action_takenlLog, maxWidth);

  action_takenlLogLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos);
    contentYPos += lineHeight;
  });

  contentYPos += rowHeight;
  contentYPos +=5;
  addNewPageIfNeeded();
  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(12);
  pdf.text('Agreements Reached/Advice Given to Residents Involved', initialX, contentYPos);

  contentYPos +=7;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  const agreementslLog = `${this.form.agreements || ''}`;
  const agreementslLogLines = pdf.splitTextToSize(agreementslLog, maxWidth);

  agreementslLogLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos);
    contentYPos += lineHeight;
  });

  contentYPos += rowHeight;
  contentYPos +=5;
  addNewPageIfNeeded();
  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(12);
  pdf.text('Corrective Measure', initialX, contentYPos);

  contentYPos +=7;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  const corrective_measurelLog = `${this.form.corrective_measure || ''}`;
  const corrective_measurelLogLines = pdf.splitTextToSize(corrective_measurelLog, maxWidth);

  corrective_measurelLogLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos);
    contentYPos += lineHeight;
  });




  contentYPos += rowHeight; 
  contentYPos +=15;
  addNewPageIfNeeded();
  pdf.text('Prepared by:', initialX, contentYPos);
  
  contentYPos += rowHeight; 

  pdf.setFont('arial', 'normal');
  pdf.setFontSize(11);
  const prepared_byValue = `${this.form.prepared_by || ''}`;
  const prepared_byWidth = pdf.getTextWidth(prepared_byValue);

pdf.text(prepared_byValue, initialX, contentYPos);  
pdf.line(initialX, contentYPos + 1, initialX + prepared_byWidth, contentYPos + 1); 




  // Noted by Section
  contentYPos += rowHeight; 
  contentYPos += 4;
  pdf.setFontSize(11);
  pdf.text('Reviewed by:', initialX, contentYPos);
  pdf.text('Approved by:', initialX+100, contentYPos);
  
  contentYPos += rowHeight; 

  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(11);
  pdf.text('VAN M. DE LEON', initialX, contentYPos);
  contentYPos += 4; 
  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(10);
  pdf.line(20, contentYPos+-3, 55, contentYPos+-3);
  pdf.text('HP III/SHP', initialX, contentYPos+2);

  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(11);
  pdf.text('ANGELIC B. PAÑA', initialX+100, contentYPos+-4);
  contentYPos += 5; 
  pdf.setFont('arialbd', 'bold');
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
      pdf.text(`PAGE ${i} of ${totalPages}`, 105, 333, { align: 'center' }); // Update the footer with the correct total pages
    }


  // Save the PDF with dynamic file name
  pdf.save(`Incident_Report_${this.form.name || ''}.pdf`);
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