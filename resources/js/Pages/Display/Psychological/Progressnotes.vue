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

  <div class="max-w-3xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
    <div class="relative flex justify-between items-center mb-2">
      <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
      <p class="text-xs italic">DSWD-GF-010 | REV 02 | 22 SEP 2023</p>
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
    <label for="interventionPeriod" class="block w-52">Period of Intervention Plan:</label>
    <input type="text" id="interventionPeriod" v-model="form.intervention_period" class="block flex -ml-8 w-2/3 p-0 text-sm border-0 bg-transparent" :readonly="!editMode">
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
              <span>Psychologist</span>
            </div>
          </div>
          <div class="space-y-2 mt-4">
            <label for="notedBy" class="block mb-12 mt-12 font-sm">Noted by:</label>
            <div class="flex flex-col">
              <strong><input type="text" v-model="center_head" class="block w-full p-0 border border-transparent rounded-md" :readonly></strong>
              <span>SWO IV / Center Head</span>
            </div>
          </div>
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
  </div>
</template>

<script>
import axios from 'axios';
import Pagination from '@/Components/Pagination.vue';
import { jsPDF } from 'jspdf'; // Import jsPDF for PDF generation

export default {
  name: 'ProgressReportForm',
  components: {
    Pagination,
  },
  data() {
    return {
      center_head: '',
      form: {
        client_id: null,
        admission_id: null,
        name: '',
        age: '',
        date_admitted: '',
        intervention_period: '',
        problem_behavior_log: '',
        interventions_conducted: '',
        progress_notes: '',
        prepared_by: '',
        noted_by: '',
      },
      editMode: false,
      message: '',
      messageType: '', // 'success' or 'error'
      totalPages: 1,
      currentPage: 1,
      isModalOpen: false,
      isSaveResultModalOpen: false,
      saveResultTitle: '',
      saveResultMessage: '',
      id: null,
    };
  },
  mounted() {
    this.id = this.$route.params.id;
    this.fetchData();
    this.fetchCenterHead();
  },
  watch: {
    '$route.params.id': function(newId) {
      this.id = newId;
      this.fetchData();
    }
  },
  methods: {
    fetchData() {
      const clientId = this.id;
      console.log('Fetching data for client ID:', clientId);
      this.fetchCenterHead(clientId);
      if (clientId) {
        axios.get(`/api/cicl-progress-notes/${clientId}`)
          .then(response => {
            if (response.data.note) {
              Object.assign(this.form, response.data.note);
              this.form.client_id = clientId;
              this.form.admission_id = response.data.admission.id;
              // Assign additional fields from client and admission, making them non-editable
              const client = response.data.client;
              const admission = response.data.admission;
              this.form.name = `${client.first_name} ${client.last_name}`;
              this.form.age = this.calculateAge(client.date_of_birth);
              this.form.date_admitted = admission.date_admitted;
            } else {
              const { client, admission } = response.data;
              this.form.client_id = client.id;
              this.form.admission_id = admission.id;
              this.form.name = `${client.first_name} ${client.last_name}`;
              this.form.age = this.calculateAge(client.date_of_birth);
              this.form.date_admitted = admission.date_admitted;
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

    saveData() {
      this.isModalOpen = true;
    },
    confirmSave() {
      this.isModalOpen = false;
      this.submitForm();
      this.closeModal();
    },
    openModal() {
      this.isModalOpen = true;
      console.log('Modal opened');
    },
    closeModal() {
      this.isModalOpen = false;
    },

    closeSaveResultModal() {
      this.isSaveResultModalOpen = false;
      this.saveResultTitle = '';
      this.saveResultMessage = '';
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
    pdf.text('DSWD-GF-010 | REV 02 | 22 SEP 2023', 135, 20);
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



  addHeader();
  pdf.setTextColor(0, 0, 0);
  // DSWD logo
  const imgData = '/images/headerlogo2.png';
  pdf.addImage(imgData, 'PNG', 15, 10, 50, 30);

  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(12);
  pdf.text('PROGRESS REPORT', 105, 48, { align: 'center' });
  pdf.text('PSYCHOLOGICAL SERVICE', 105, 55, { align: 'center' });

  // Content starts below title
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(11);

  contentYPos += 6;
  pdf.text(`Name: ${this.form.name || ''}`, initialX, contentYPos);
  contentYPos += 6;
  pdf.text(`Age: ${this.form.age || ''}`, initialX, contentYPos);
  pdf.text('years old', initialX + 16, contentYPos);
  
  contentYPos += 6;
  addNewPageIfNeeded();
  pdf.text(`Date Admitted: ${this.form.date_admitted || ''}`, initialX, contentYPos);

  contentYPos += 6;
  addNewPageIfNeeded();
  pdf.text(`Period of Intervention Plan: ${this.form.intervention_period || ''}`, initialX, contentYPos);

  // Section: Problem Behavior Log
  contentYPos += rowHeight;
  contentYPos += 10;
  addNewPageIfNeeded();
  pdf.setFont('arialbd', 'bold');
  pdf.text('PROBLEM BEHAVIOR LOG:', initialX, contentYPos);

  contentYPos += rowHeight;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(11);
  const problemBehaviorLog = `${this.form.problem_behavior_log || ''}`;
  const problemLogLines = pdf.splitTextToSize(problemBehaviorLog, maxWidth);

  problemLogLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos);
    contentYPos += lineHeight;
  });

  // Section: Interventions Conducted
  contentYPos += rowHeight;
  contentYPos += 15;
  addNewPageIfNeeded();
  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(11);
  pdf.text('INTERVENTIONS CONDUCTED:', initialX, contentYPos);

  contentYPos += rowHeight;
  pdf.setFont('arial', 'normal');
  const interventionsConducted = `${this.form.interventions_conducted || ''}`;
  const interventionLines = pdf.splitTextToSize(interventionsConducted, maxWidth);

  interventionLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(`• ${line}`, initialX + 5, contentYPos);
    contentYPos += lineHeight;
  });


  // Section: Progress Notes
  contentYPos += rowHeight;
  contentYPos += 15;
  addNewPageIfNeeded();
  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(11);
  pdf.text('PROGRESS NOTES', initialX, contentYPos);

  pdf.setFontSize(11);
  contentYPos += rowHeight;
  pdf.setFont('arial', 'normal');
  const progressNotes = `${this.form.progress_notes || ''}`;
  const progressNoteLines = pdf.splitTextToSize(progressNotes, maxWidth);

  progressNoteLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos);
    contentYPos += lineHeight;
  });


  contentYPos +=50;
  // Prepared by Section
  contentYPos += rowHeight; 
  addNewPageIfNeeded();
  
  pdf.setFontSize(11);
  pdf.text('Prepared by:', initialX, contentYPos);
  
  contentYPos += rowHeight; 
  addNewPageIfNeeded();
  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(11);

  contentYPos += 5; 
  pdf.text(`${this.form.prepared_by || ''}`, initialX, contentYPos);
  contentYPos += 4; 
  addNewPageIfNeeded();
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(10);
  pdf.text('Psychologist', initialX, contentYPos);

  // Noted by Section
  contentYPos += rowHeight; 
  addNewPageIfNeeded();
  
  pdf.setFontSize(11);
  pdf.text('Noted by:', initialX, contentYPos);
  
  contentYPos += rowHeight; 
  contentYPos += 5; 
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
      pdf.setTextColor(0, 0, 0);
      pdf.setFont('TimesNewRoman', 'bold');
      pdf.text(`PAGE ${i} of ${totalPages}`, 105, 333, { align: 'center' }); // Update the footer with the correct total pages
    }

  // Save the PDF with dynamic file name
  pdf.save(`Progress_Report_${this.form.name || 'NoName'}.pdf`);
},


    submitForm() {
      if (!this.form.client_id || !this.form.admission_id) {
        this.message = 'Client ID and Admission ID are required.';
        this.messageType = 'error';
        this.clearMessage();
        return;
      }

      const url = `/api/cicl-progress-notes/${this.form.client_id}`;

      axios.put(url, this.form)
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

    clearMessage() {
      setTimeout(() => {
        this.message = '';
        this.messageType = '';
      }, 3000);
    },

    updatePage(page) {
      this.currentPage = page;
    }
  }
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
