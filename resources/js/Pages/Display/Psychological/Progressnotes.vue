<template>
<!-- Tabs for Actions -->
<div v-if="editMode" class="flex absolute p-4 space-x-4">
    <button @click="cancelEdit" class="flex space-x-2 px-3 py-3 bg-blue-900 hover:bg-blue-950 text-white rounded-md text-xs">
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
    <button v-if="!editMode" @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-xs">
        <!-- FontAwesome for Edit -->
        <i class="fas fa-edit w-4 h-4"></i>
        <span>Edit</span>
      </button>

    <button v-if="editMode" @click="submitForm" class="flex items-center space-x-2 px-3 py-1 bg-green-500 hover:bg-green-600 text-white rounded-md text-xs">
      <i class="fas fa-check w-4 h-4"></i>
      <span>Save</span>
    </button>

    <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-xs">
      <i class="fas fa-file-pdf w-4 h-4"></i>
      <span>Export PDF</span>
    </button>
  </div>

  <form ref="ProgressNotes" @submit.prevent="submitForm">
  <div class="graph-background pt-0.5  -mr-9 -mb-16">

  <div class="max-w-3xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
    <div class="relative flex justify-between items-center mb-2">
      <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
      <p class="text-[12px] text-right -mt-10" style="font-family: 'Times New Roman', Times, serif; font-style: italic;">DSWD-GF-010 | REV 02 | 22 SEP 2023</p>
    </div>
    
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
    <input 
  type="text" 
  id="interventionPeriod" 
  v-model="form.intervention_period" 
  class="block flex -ml-8 w-2/3 p-0 text-sm border-0 bg-transparent" 
  :readonly="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the intervention period.'); }" 
  required maxlength="20"
/>
  </div>
</div>
        </div>

        <!-- Problem Behavior Log Section -->
        <div class="space-y-4 mt-6">
  <h2 class="font-bold">PROBLEM BEHAVIOR LOG</h2>
  <div 
    id="problemBehaviorLog"
    class="block w-full p-2 border border-gray-300 rounded-md"
    style="white-space: pre-wrap; min-height: 50px;"
    :contenteditable="editMode"
    @input="(e) => { form.problem_behavior_log = e.target.innerText; e.target.setCustomValidity('') }"
    @invalid="(e) => { e.target.setCustomValidity('Please provide a log of problem behavior'); }"
    :data-required="true"
    @blur="(e) => { if (!form.problem_behavior_log) { e.target.setCustomValidity('Please provide a log of problem behavior'); e.target.reportValidity(); } }"
  >
    {{ form.problem_behavior_log }}
  </div>
</div>


        <!-- Interventions Conducted Section -->
        <div class="space-y-4 mt-6">
  <h2 class="font-bold">INTERVENTIONS CONDUCTED</h2>
  <div 
    class="block w-full p-2 border border-gray-300 rounded-md" 
    :contenteditable="editMode" 
    @input="(e) => { form.interventions_conducted = e.target.innerText; e.target.setCustomValidity(''); }"
    @blur="(e) => { if(!form.interventions_conducted) { e.target.setCustomValidity('Please provide details about the interventions conducted'); e.target.reportValidity(); } }"
    @invalid="(e) => { e.target.setCustomValidity('Please provide details about the interventions conducted') }" 
    style="white-space: pre-wrap; min-height: 50px;"
    :data-required="true"
  >
    {{ form.interventions_conducted }}
  </div>
</div>

        <!-- Progress Notes Section -->
        <div class="space-y-4 mt-6">
  <h2 class="font-bold">PROGRESS NOTES</h2>
  <div 
    class="block w-full p-2 border border-gray-300 rounded-md" 
    :contenteditable="editMode" 
    @input="(e) => { form.progress_notes = e.target.innerText; e.target.setCustomValidity(''); }"
    @blur="(e) => { if (!form.progress_notes) { e.target.setCustomValidity('Please provide progress notes for this field'); e.target.reportValidity(); } }"
    @invalid="(e) => { e.target.setCustomValidity('Please provide progress notes for this field') }" 
    style="white-space: pre-wrap; min-height: 50px;" 
    :data-required="true"
  >
    {{ form.progress_notes }}
  </div>
</div>

        <div class="space-y-4 mt-6">
          <div class="space-y-2">
            <label for="preparedBy" class="block mb-12 mt-12 font-sm">Prepared by:</label>
            <div class="flex flex-col">
              <strong><input type="text" id="preparedBy" v-model="form.prepared_by" class="underline block w-full p-0 border border-transparent rounded-md" :readonly="!editMode" 
                @input="form.prepared_by = removeNumbers(form.prepared_by)"
                maxlength="50"></strong>
              <span>Psychologist</span>
            </div>
          </div>
          <div class="space-y-2 mt-4">
            <label for="notedBy" class="block mb-12 mt-12 font-sm">Noted by:</label>
            <div class="flex flex-col">
              <strong><input type="text" v-model="center_head" class="underline block w-full p-0 border border-transparent rounded-md" :readonly></strong>
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
</form>
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
        approved_by: '',
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
  removeNumbers(input) {
    return input.replace(/[0-9]/g, '');
  },
    toggleEdit() {
      this.editMode = !this.editMode;
    },

    cancelEdit() {
      this.editMode = false;
      this.fetchData(); // Reset the form with the latest data
    },
    
  closeSaveResultModal() {
        this.isSaveResultModalOpen = false;
        this.saveResultTitle = '';
        this.saveResultMessage = '';
      },

    submitForm() {
    const form = this.$refs.ProgressNotes;

    if (!this.form.client_id || !this.form.admission_id) {
      this.message = 'Client ID and Admission ID are required.';
      this.messageType = 'error';
      this.clearMessage();
      return;
    }

    if (form.checkValidity()) {
      this.isModalOpen = true; // Open the save confirmation modal
    } else {
      form.reportValidity(); // Show form validation errors
    }
  },

  // Method to confirm save and process the form data
  async confirmSave() {
    try {
      const url = `/api/cicl-progress-notes/${this.form.client_id}`;

      // Send a PUT request to update the progress notes
      const response = await axios.put(url, this.form);

      if (response.status === 200) {
        this.saveResultTitle = 'Success';
        this.saveResultMessage = 'Data saved successfully.';
      } else {
        throw new Error('Unexpected response');
      }
    } catch (error) {
      console.error('Error saving form:', error);
      this.saveResultTitle = 'Error';
      this.saveResultMessage = 'An error occurred while saving.';
    } finally {
      this.isSaveResultModalOpen = true; // Show save result modal
        this.isModalOpen = false; // Close confirmation modal
        this.editMode = false; // Reset edit mode
        console.log('Save result modal opened');
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

    closeModal() {
        this.isModalOpen = false;
        console.log('Modal closed');
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
  ,
  openModal() {
      this.isModalOpen = true;
      console.log('Modal opened');
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
  let contentYPos = 67; // Start Y position for content
  let initialX = 20; // X position for content
  let currentPage = 1; // Start at page 1
  
  const addHeader = () => {
      // Header text
      pdf.setFontSize(9);
      pdf.setFont('TimesNewRoman', 'italic');
      pdf.text('DSWD-GF-010 | REV 02 | 22 SEP 2023', 135, 18);
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
        pdf.line(21, 335, 176, 335); // Footer line
  
        pdf.setFont('times', 'normal');
        const footerText = pdf.splitTextToSize('DSWD Field Office XI , Ramon Magsaysay Avenue corner Damaso Suazo Street, Davao City, Philippines 8000', 160);
        pdf.text(footerText, 105  , 338, { align: 'center' });
        pdf.text('Website: ', 53, 342, { align: 'center' });
        pdf.text('Tel Nos.: (082) 227-1964 Email:', 116, 342, { align: 'center' });

        pdf.setFontSize(10);
        pdf.setTextColor(0, 0, 255);
        pdf.text('http://www.dswd.gov.ph', 77, 342, { align: 'center' });
        pdf.text('fo11@dswd.gov.ph ', 152, 342, { align: 'center' });
        pdf.setLineWidth(0);
        pdf.setDrawColor(0, 0, 255);
        pdf.line(59, 343, 95, 343);
        pdf.line(138, 343, 166, 343);
        
        
        const footerImgData = '/images/footerimg.png';
        pdf.addImage(footerImgData, 'PNG', 178, 330, 25, 12); // Footer image
      } else {
        // Footer for Page 2 and beyond
        pdf.setTextColor(0, 0, 0);
        pdf.setFontSize(8.3);
        pdf.setFont('TimesNewRoman', 'bold');
        pdf.setDrawColor(0, 0, 0);
        pdf.setLineWidth(0.5);
        pdf.line(21, 335, 188, 335); // Footer line
  
        pdf.setFont('times', 'bold');
        pdf.text('DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION/REGIONAL REHABILITATION CENTER FOR YOUTH', 105, 338, { align: 'center' });
      }
    };

    addHeader();
    pdf.setTextColor(0, 0, 0);
    // DSWD logo
    const imgData = '/images/headerlogo2.png';
    pdf.addImage(imgData, 'PNG', 16, 1, 65, 32);

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
  pdf.text('years old', initialX + 15, contentYPos);
  
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

  // Prepared by Section
  contentYPos += 10;
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
  pdf.setFontSize(11);
  pdf.text('Psychologist I', initialX, contentYPos);

  // Noted by Section
  contentYPos += 10; 
  contentYPos += rowHeight; 
  addNewPageIfNeeded();
  pdf.setFontSize(11);
  pdf.text('Noted by:', initialX, contentYPos);
  
  contentYPos += rowHeight; 
  contentYPos += 5; 
  addNewPageIfNeeded();
  pdf.setFont('arialbd', 'bold');
    pdf.setFontSize(11);
    pdf.text(this.center_head, initialX, contentYPos);
    contentYPos += 4; 
    addNewPageIfNeeded();
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(11);
    pdf.text('SWO IV / Center Head', initialX, contentYPos);
  
  // Add the footer for the last page
  addFooter();

  // Page numbers for all pages
  const totalPages = pdf.internal.getNumberOfPages();
  for (let i = 1; i <= totalPages; i++) {
    pdf.setPage(i);
    pdf.setFontSize(9);
    pdf.setTextColor(0, 0, 0);
    pdf.setFont('TimesNewRoman', 'bold');
    pdf.text(`PAGE ${i} of ${totalPages}`, 105, 334, { align: 'center' }); // Footer at bottom center with correct page numbers
  }

  // Save the PDF with dynamic file name
  pdf.save(`Progress_Report_${this.form.name || 'NoName'}.pdf`);
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
</style>
