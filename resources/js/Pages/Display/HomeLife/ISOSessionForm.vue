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
</div>        </div>
      </div>
      <h1 class="font-bold text-xl">DEPARTMENT OF SOCIAL WELFARE AND DEVELOPMENT</h1>
      <p>REGIONAL REHABILITATION CENTER FOR YOUTH</p>
      <p>Bago Oshiro Tugbok dist. Davao City</p>
    </div>

    <!-- Session Information Section -->
    <div class="mb-6 flex items-center">
    <!-- Session Field -->
    <div class="w-1/2 flex items-center">
      <label for="session" class="block font-medium w-auto">Session:</label>
      <input type="text" id="session" v-model="form.session" class="underline-input shadow-sm w-1/2" :readonly="!editMode">
    </div>

    <!-- Date Conducted Field -->
    <div class="w-1/2 flex items-center justify-end space-x-2">
      <label for="dateConducted" class="block font-medium text-right">Date Conducted:</label>
      <input type="date" id="dateConducted" v-model="form.date_conducted" class="underline-input shadow-sm w-1/2" :readonly="!editMode">
      </div>
    </div>
   
    <div class="mb-6 flex flex-col items-center">
      <input type="text" id="title" v-model="form.title" class="underline-input shadow-sm w-1/2 text-center" :readonly="!editMode">
      <label for="title" class="block font-medium mt-2 text-center">Title of Session:</label>
    </div>

    <!-- Session Sections -->
    <div class="space-y-4 mb-6">
      <div class="space-y-2">
        <label for="objective" class="block font-medium">I. Objective</label>
        <textarea id="objective" v-model="form.objective" class="border border-gray-400 p-2 rounded-md w-full" :readonly="!editMode"></textarea>
      </div>
      <div class="space-y-2">
        <label for="methodology" class="block font-medium">II. Methodology</label>
        <textarea id="methodology" v-model="form.methodology" class="border border-gray-400 p-2 rounded-md w-full" :readonly="!editMode"></textarea>
      </div>
      <div class="space-y-2">
        <label for="highlight" class="block font-medium">III. Highlight of the Session and Activity</label>
        <textarea id="highlight" v-model="form.highlight" class="border border-gray-400 p-2 rounded-md w-full" :readonly="!editMode"></textarea>
      </div>
      <div class="space-y-2">
        <label for="outcome" class="block font-medium">IV. Outcome</label>
        <textarea id="outcome" v-model="form.outcome" class="border border-gray-400 p-2 rounded-md w-full" :readonly="!editMode"></textarea>
      </div>
    </div>

    <!-- Signatures Section -->
    <div>
      <label for="preparedBy" class="block text-sm font-medium">Prepared By :</label>
    <input
      type="text"
      id="preparedBy"
      v-model="form.prepared_by"
      class="mt-1 w-60 underline-input text-sm shadow-sm"
      :readonly="!editMode"
    >
      </div>
      <br />
       <!-- Noted by and Approved by -->
       <div class="mb-6 flex justify-between items-start">
      <!-- Noted by Section -->
      <div class="w-1/2 mr-12">
        <label for="notedBy" class="block text-sm font-medium">Noted by:</label>
        <input
          type="text"
          id="notedBy"
          v-model="shp"
          class="font-semibold mt-1 w-3/4 underline-input text-sm shadow-sm"
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
          v-model="center_head"
          class="font-semibold mt-1 w-3/4 underline-input text-sm shadow-sm"
          readonly
        >
        <p class="text-sm">SWO IV / Center Head</p>
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
  name: 'SessionForm',
  components: {
    Pagination,
  },
  data() {
    return {
      center_head: '',
      shp: '',
      drn: '',
      form: {
        client_id: null,
        drn: '',
        session: '',
        title: '',
        date_conducted: '',
        objective: '',
        methodology: '',
        highlight: '',
        outcome: '',
        prepared_by: '',
        noted_by: 'VAN M. DE LEON',
        approved_by: 'ANGELIC B. PAÑA',
      },
      originalForm: null,  // To store the original form data
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
    this.fetchSHP(clientId);  
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
        axios.get(`/api/cicl-sessions/${clientId}`).then(response => {
          if (response.data.session) {
            this.form = response.data.session;
            this.form.client_id = clientId;
            this.originalForm = JSON.parse(JSON.stringify(this.form)); // Capture the original state
          } else {
            const { client } = response.data;
            this.form.client_id = client.id;
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
  
  fetchSHP(clientId) {
    if (!clientId) {
      console.error("Client ID is missing.");
      return;
    }
    axios.get(`/api/shp/${clientId}`)
      .then(response => {
        this.shp = response.data.shp || '';
        console.log("Fetched SHP:", this.shp);
      })
      .catch(error => {
        console.error("Error fetching SHP:", error);
      });
  },
  saveSHP() {
    const clientId = this.$route.params.id;
    console.log("Saving SHP:", this.shp, "for client:", clientId);
    if (!clientId) {
      console.error("Client ID is missing.");
      return;
    }
    axios.put(`/api/update-shp/${clientId}`, { 
      client_id: clientId,
      name: this.shp
    })
    .then(response => {
      console.log("SHP saved successfully:", response.data);
      this.editMode = false;
      this.fetchSHP(clientId);
    })
    .catch(error => {
      console.error("Error updating SHP:", error);
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
    toggleEdit() {
      if (this.editMode) {
        this.openModal();
      } else {
        this.originalForm = JSON.parse(JSON.stringify(this.form)); // Capture the current form state
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
      this.saveCenterHead();
      this.saveSHP();
      this.saveDrn();
      this.closeModal();
    },

    cancelEdit() {
      if (this.originalForm) {
        this.form = JSON.parse(JSON.stringify(this.originalForm)); // Revert to the original form state
      }
      this.editMode = false; // Exit edit mode
    },

    submitForm() {
      if (!this.form.client_id) {
        this.message = 'Client ID is required.';
        this.messageType = 'error';
        return;
      }

      const url = `/api/cicl-sessions/${this.form.client_id}`;

      axios.put(url, this.form)
        .then(response => {
          this.editMode = false;
          this.message = 'Data updated successfully!';
          this.messageType = 'success';
          this.saveResultTitle = 'Success';
          this.saveResultMessage = 'Data saved successfully.';
          this.isSaveResultModalOpen = true;
          this.clearMessage();
          this.fetchData(); // Re-fetch data to update the form with the latest saved data
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

    updatePage(page) {
      this.currentPage = page;
      // Logic to handle pagination-related actions can be added here
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
  pdf.text('DEPARTMENT OF SOCIAL WELFARE AND DEVELOPMENT', 105, 48, { align: 'center' });
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  pdf.text('REGIONAL REHABILITATION CENTER FOR YOUTH', 105, 53, { align: 'center' });
  pdf.text('Bago Oshiro Tugbok dist. Davao City', 105, 58, { align: 'center' });
  contentYPos += 15;

  // Content starts below title
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(13);

  contentYPos += rowHeight;

contentYPos += 6;
pdf.text(`Session:`, initialX, contentYPos);


const sessionValue = `${this.form.session || ''}`;
const sessionWidth = pdf.getTextWidth(sessionValue);


pdf.text(sessionValue, initialX + 18, contentYPos);  
pdf.line(initialX + 18, contentYPos + 1, initialX + 18 + sessionWidth, contentYPos + 1); 

pdf.text(`Date Conducted:`, initialX + 100, contentYPos);


const dateValue = `${this.form.date_conducted || ''}`;
const dateWidth = pdf.getTextWidth(dateValue);

pdf.text(dateValue, initialX + 135, contentYPos); 
pdf.line(initialX + 135, contentYPos + 1, initialX + 135 + dateWidth, contentYPos + 1); 

  contentYPos += 15;

// Get the width of the title text
const titleText = `${this.form.title || ''}`;
const titleWidth = pdf.getTextWidth(titleText);

// Center the title and automatically create an underline
pdf.text(titleText, 105, contentYPos - 2, { align: 'center' });

// Calculate the starting and ending points for the underline
const startX = 105 - (titleWidth / 2);  // Centered starting point
const endX = 105 + (titleWidth / 2);    // Centered ending point
// Draw the underline just below the title text
pdf.line(startX, contentYPos, endX, contentYPos);
contentYPos += 5;
pdf.text('Title of Session', 105, contentYPos, { align: 'center' }); // Label for Case Manager

contentYPos += rowHeight;
  addNewPageIfNeeded();
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  contentYPos +=7;
  pdf.text('I. Objective', initialX, contentYPos);

  contentYPos +=7;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  const objectivelLog = `${this.form.objective || ''}`;
  const objectivelLogLines = pdf.splitTextToSize(objectivelLog, maxWidth);

  objectivelLogLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos);
    contentYPos += lineHeight;
  });

  contentYPos += rowHeight;
  addNewPageIfNeeded();
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  contentYPos +=7;
  pdf.text('II. Methodology', initialX, contentYPos);

  contentYPos +=7;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  const methodologylLog = `${this.form.methodology || ''}`;
  const methodologylLogLines = pdf.splitTextToSize(methodologylLog, maxWidth);

  methodologylLogLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos);
    contentYPos += lineHeight;
  });

  contentYPos += rowHeight;
  addNewPageIfNeeded();
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  contentYPos +=7;
  pdf.text('III. Highlight of the Session and Activity', initialX, contentYPos);

  contentYPos +=7;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  const highlightlLog = `${this.form.highlight || ''}`;
  const highlightlLogLines = pdf.splitTextToSize(highlightlLog, maxWidth);

  highlightlLogLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos);
    contentYPos += lineHeight;
  });


  contentYPos += rowHeight;
  addNewPageIfNeeded();
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  contentYPos +=7;
  pdf.text('IV. Outcome', initialX, contentYPos);

  contentYPos +=7;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  const outcomelLog = `${this.form.outcome || ''}`;
  const outcomelLogLines = pdf.splitTextToSize(outcomelLog, maxWidth);

  outcomelLogLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos);
    contentYPos += lineHeight;
  });


  contentYPos += rowHeight; 
  addNewPageIfNeeded();
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  pdf.text('Prepared by:', initialX, contentYPos);
  
  contentYPos += rowHeight; 

  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  
const prepared_byValue = `${this.form.prepared_by || ''}`;
const prepared_byWidth = pdf.getTextWidth(prepared_byValue);
pdf.text(prepared_byValue, initialX, contentYPos);  
pdf.line(initialX, contentYPos + 1, initialX + prepared_byWidth, contentYPos + 1); 


  contentYPos += rowHeight; 
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
  pdf.save(`Session_${this.form.name || ''}.pdf`);
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
