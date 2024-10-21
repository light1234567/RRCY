<template>
  <!-- Tabs for Actions -->
  <div v-if="editMode" class="flex absolute p-4 space-x-4">
      <button @click="cancelEdit" class="flex space-x-2 px-3 py-3 bg-blue-900 hover:bg-blue-950 text-white rounded-md text-xs">
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
      <button v-if="!editMode" @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-xs">
        <!-- FontAwesome for Edit -->
        <i class="fas fa-edit w-4 h-4"></i>
        <span>Edit</span>
      </button>
  
      <button v-if="editMode" @click="saveData" class="flex items-center space-x-2 px-3 py-1 bg-green-500 hover:bg-green-600 text-white rounded-md text-xs">
        <!-- FontAwesome for Save -->
        <i class="fas fa-check w-4 h-4"></i>
        <span>Save</span>
      </button>
  
      <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-xs">
      
        <i class="fas fa-file-pdf w-4 h-4"></i>
        <span>Export PDF</span>
      </button> 
  </div>
    
  <form ref="interventionPlanForm" @submit.prevent="saveData" novalidate>
  <div class="graph-background pt-0.5  -mr-9 -mb-16">
  
    <div class="max-w-7xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
      <div class="relative flex justify-between items-center mb-2">
        <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
        <p class="text-[12px] text-right -mt-10" style="font-family: 'Times New Roman', Times, serif; font-style: italic;">DSWD-GF-010 | REV 01 | 17 AUG 2022        </p>
      </div>
  
      <div class="p-4">
        <h1 class="text-xl font-bold mb-1 text-center">INTERVENTION PLAN</h1>
        <h1 class="text-sm font-bold mb-4 text-center">PSYCHOLOGICAL SERVICE</h1>
        <div class="ml-16 flex justify-center items-center my-4">
          <p>As of:
            <input 
              type="date" 
              v-model="form.as_of_date" 
              class="flex-grow border-b-0 border-black border-t-0 mr-4 border-l-0 border-r-0 rounded-none shadow-sm w-1/8 px-2 py-1" 
              :readonly="!editMode" 
              :max="currentDate" 
              @input="(e) => { e.target.setCustomValidity('') }" 
              @invalid="(e) => { e.target.setCustomValidity('Please select a valid date up to the present') }" 
              required 
            />
          </p>
        </div>
  
        <div v-if="message" :class="`p-2 mt-4 text-white rounded-md text-xs ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
          {{ message }}
        </div>
  
        <div class="mb-4 text-xs">
          <div class="grid grid-cols-2 gap-2">
            <div class="flex items-center">
              <label class="font-semibold w-1/5">Name:</label>
              <input type="text" v-model="clientName" :class="{'twinkle-border': editMode}" class="w-3/4 border border-transparent p-1" readonly>
            </div>
            <div class="flex items-center">
              <label class="font-semibold w-1/5">Age:</label>
              <input type="text" v-model="age" :class="{'twinkle-border': editMode}" class="w-3/4 border border-transparent p-1" readonly>
            </div>
            <div class="flex items-center">
              <label class="font-semibold w-1/5">Date Admitted:</label>
              <input type="date" v-model="dateAdmitted" :class="{'twinkle-border': editMode}" class="w-3/4 border border-transparent p-1" readonly>
            </div>
          </div>
        </div>
  
        <!-- Intervention Plan Table -->
        <table class="min-w-full bg-white border border-black text-xs">
  <thead>
    <tr>
      <th class="py-2 px-2 border-b border-r border-black bg-orange-100">Objectives</th>
      <th class="py-2 px-2 border-b border-r border-black bg-orange-100">Activities</th>
      <th class="py-2 px-2 border-b border-r border-black bg-orange-100">Responsible Person</th>
      <th class="py-2 px-2 border-b border-r border-black bg-orange-100">Time Frame</th>
      <th class="py-2 px-2 border-b border-r border-black bg-orange-100">Expected Output</th>
      <th class="py-2 px-2 border-b border-black bg-blue-200">Progress</th>
      <th v-if="editMode" class="py-2 px-2 border-b border-black">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(item, index) in form.items" :key="index">
      <td class="py-2 px-2 border-b border-r border-black bg-orange-100 align-top">
        <textarea 
          v-model="item.objectives" 
          :readonly="!editMode" 
          class="w-full h-full p-1 bg-transparent border border-transparent align-top" 
          @input="(e) => { e.target.setCustomValidity('') }" 
          @invalid="(e) => { e.target.setCustomValidity('Please provide objectives') }" 
          required
        ></textarea>
      </td>
      <td class="py-2 px-2 border-b border-r border-black bg-orange-100 align-top">
        <textarea 
          v-model="item.activities" 
          :readonly="!editMode" 
          class="w-full h-full p-1 bg-transparent border border-transparent align-top" 
          @input="(e) => { e.target.setCustomValidity('') }" 
          @invalid="(e) => { e.target.setCustomValidity('Please provide the activities') }" 
          required
        ></textarea>
      </td>
      <td class="py-2 px-2 border-b border-r border-black bg-orange-100 align-top">
        <textarea 
          v-model="item.responsible_person" 
          :readonly="!editMode" 
          class="w-full h-full p-1 bg-transparent border border-transparent align-top" 
          @input="(e) => { e.target.setCustomValidity('') }" 
          @invalid="(e) => { e.target.setCustomValidity('Please provide a responsible person name') }" 
          required maxlength="50"
        ></textarea>
      </td>
      <td class="py-2 px-2 border-b border-r border-black bg-orange-100 align-top">
        <textarea 
          v-model="item.time_frame" 
          :readonly="!editMode" 
          class="w-full h-full p-1 bg-transparent border border-transparent align-top" 
          @input="(e) => { e.target.setCustomValidity('') }" 
          @invalid="(e) => { e.target.setCustomValidity('Please provide a time frame') }" 
          required maxlength="20"
        ></textarea>
      </td>
      <td class="py-2 px-2 border-b border-r border-black bg-orange-100 align-top">
        <textarea 
          v-model="item.expected_output" 
          :readonly="!editMode" 
          class="w-full h-full p-1 bg-transparent border border-transparent align-top" 
          @input="(e) => { e.target.setCustomValidity('') }" 
          @invalid="(e) => { e.target.setCustomValidity('Please provide the expected output') }" 
          required
        ></textarea>
      </td>
      <td class="py-2 px-2 border-b border-black bg-blue-200 align-top">
        <textarea 
          v-model="item.progress" 
          :readonly="!editMode" 
          class="w-full h-full p-1 bg-transparent border border-transparent align-top" 
          @input="(e) => { e.target.setCustomValidity('') }" 
          @invalid="(e) => { e.target.setCustomValidity('Please provide progress details') }" 
          required
        ></textarea>
      </td>
      <td v-if="editMode" class="py-2 px-2 border-b border-black">
        <button @click="removeItem(index)" class="px-2 py-1 bg-red-500 text-white rounded-md text-xs">Remove</button>
      </td>
    </tr>
  </tbody>
</table>


  
        <!-- Add Row Button -->
        <div v-if="editMode" class="text-right mt-2">
          <button @click="addItem" class="px-3 py-1 bg-green-500 text-white rounded-md text-xs">
            Add New Row
          </button>
        </div>
  
        <!-- Progress Notes Section -->
        <div class="space-y-4 mt-6">
        <label for="progressNotes" class="block font-medium">Progress Notes:</label>

        <div 
          class="block w-full p-2 border border-gray-300 rounded-md" 
          style="min-height: 100px; white-space: pre-wrap; line-height: 1.5;" 
          contenteditable="true" 
          :contenteditable="editMode" 
          @input="(e) => { form.progress_notes = e.target.innerText; e.target.setCustomValidity('') }" 
          @invalid="(e) => { e.target.setCustomValidity('Please provide progress notes') }" 
          @blur="(e) => { if (!form.progress_notes) { e.target.setCustomValidity('Please provide progress notes'); e.target.reportValidity(); } }"
          required
        >
          {{ form.progress_notes }}
        </div>
      </div>

  
        <!-- Signatures Section -->
        <div class="mt-4 grid grid-cols-3 gap-2 text-xs">
          <div>
            <label class="font-semibold">Approved by:</label>
            <input type="text" v-model="form.approved_by" :readonly="!editMode" class="w-full border border-transparent p-0 underline" maxlength="50"/>
            <div class="text-xs mt-1">Psychometrician</div>
          </div>
          <div>
            <label class="font-semibold">Prepared by:</label>
            <input type="text" v-model="form.prepared_by" :readonly="!editMode" class="w-full border border-transparent p-0 underline" maxlength="50"/>
            <div class="text-xs mt-1">Psychologist I</div>
          </div>
          <div>
            <label class="font-semibold">Noted by:</label>
            <input type="text" v-model="center_head" class="w-full border border-transparent p-0 underline" />          
            <div class="text-xs mt-1">SWO IV / Center Head</div>
          </div>
        </div>
        <div class="border-gray-300 mt-24 text-center text-xs w-full" style="font-family: 'Times New Roman', Times, serif;">
  <div class="flex justify-between items-center w-full">
    <div class="flex flex-col w-full">
      <!-- PAGE Number -->
      <p class="text-center font-bold">PAGE 1 of {{ totalPages }}</p>

      <!-- Border Line and Address -->
      <p class="border-t mt-2 mb-1" style="border-top: 3px solid black;"></p>
      <p class="text-center">DSWD Field Office XI, Ramon Magsaysay Avenue corner DamasoSuazo Street, Davao City
      </p>

      <!-- Email, Phone, and Website -->
      <p class="text-center">
        Email: 
        <a href="mailto:fo11@dswd.gov.ph" class="text-blue-600 underline">fo11@dswd.gov.ph</a> 
        Tel. No.: (082) 227-1964 Website: 
        <a href="http://www.dswd.gov.ph" class="text-blue-600 underline">www.dswd.gov.ph</a>
      </p>
    </div>

    <!-- Footer Image (aligned to the right) -->
    <div class="ml-4">
      <img src="/images/footerimg.png" alt="Footer Logo" class="h-12 w-24 object-cover">
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
  import jsPDF from 'jspdf';
  import '../../../fonts/arial-normal.js'; 
  import '../../../fonts/times-normal.js'; 
  import '../../../fonts/arialbd-bold.js'; 
  import "jspdf-autotable";
  
  export default {
    name: 'InterventionPlan',
    components: {
      Pagination,
    },
    data() {
      return {
        form: {
          id: null,
          client_id: null,
          as_of_date: '',
          center_head: '',
          items: [
            {
              objectives: '',
              activities: '',
              responsible_person: '',
              time_frame: '',
              expected_output: '',
              progress: ''
            }
          ],
          progress_notes: '',
          prepared_by: '',
          approved_by:'',
          noted_by: ''
        },
        clientName: '',
        age: '',
        dateAdmitted: '',
        editMode: false,
        message: '',
        messageType: '',
        isModalOpen: false,
        isSaveResultModalOpen: false,
        saveResultTitle: '',
        saveResultMessage: '',
        totalPages: 1,
        currentPage: 1
      };
    },
    mounted() {
      // Fetch data when the component is mounted
      const clientId = this.$route.params.id;
      console.log('Client ID on mounted:', clientId);
      this.fetchData(clientId);
      this.fetchCenterHead();
    },
    watch: {
      '$route.params.id': function(newId) {
        console.log('Client ID changed to:', newId);
        this.fetchData(newId);
      }
    },
    methods: {
      fetchData(clientId) {
        if (!clientId) return;
        console.log('Fetching client data for client ID:', clientId);
  
        axios.get(`/api/clients/${clientId}`)
          .then(response => {
            console.log('Client data fetched:', response.data);
            const client = response.data;
            this.clientName = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
            this.age = this.calculateAge(client.date_of_birth);
            this.dateAdmitted = client.admissions[0]?.date_admitted;
  
            this.form.client_id = client.id;
            console.log('Client ID set in form:', this.form.client_id);
  
            this.fetchPlanData(clientId);
          })
          .catch(error => {
            console.error('Error fetching client data:', error);
            this.message = 'Error fetching data.';
            this.messageType = 'error';
          });
      },
      fetchPlanData(clientId) {
    console.log('Fetching intervention plan data for client ID:', clientId);
  
    axios.get(`/api/psychological-intervention-plans/${clientId}`)
      .then(response => {
        console.log('Intervention plan data fetched:', response.data);
        
        // Check if the response contains data
        if (response.data && response.data.items) {
          // Set the fetched plan data to form
          this.form = { ...response.data, items: response.data.items || [] };
          console.log('Plan data set in form:', this.form);
        } else {
          console.log('No plan data found, resetting form.');
        }
      })
      .catch(error => {
        console.error('Error fetching intervention plan data:', error);
      });
  }
  ,
      fetchCenterHead() {
      axios.get('/api/center-head')  // Replace with the correct API route
        .then(response => {
          this.center_head = response.data.name;  // Bind the fetched name to v-model
        })
        .catch(error => {
          console.error('Error fetching center head:', error);
        });
    },
      addItem() {
        this.form.items.push({
          objectives: '',
          activities: '',
          responsible_person: '',
          time_frame: '',
          expected_output: '',
          progress: ''
        });
        console.log('Item added to form:', this.form.items);
      },
      removeItem(index) {
        this.form.items.splice(index, 1);
        console.log('Item removed from form at index:', index, 'Remaining items:', this.form.items);
      },
      toggleEdit() {
        if (this.editMode) {
          this.openModal();
        } else {
          this.editMode = !this.editMode;
        }
        console.log('Edit mode toggled:', this.editMode);
      },
      openModal() {
        this.isModalOpen = true;
        console.log('Modal opened');
      },
      closeModal() {
        this.isModalOpen = false;
        console.log('Modal closed');
      },
      cancelEdit() {
        this.editMode = false;
        console.log('Edit mode canceled');
      },
      saveData() {
    const form = this.$refs.interventionPlanForm;

    // Reset all custom validity messages first to avoid stale errors
    [...form.elements].forEach((element) => {
      if (element.tagName === 'TEXTAREA' || element.tagName === 'INPUT') {
        element.setCustomValidity('');
      }
    });

    // Now check validity
    if (form.checkValidity()) {
      // If valid, proceed to open the confirmation modal
      this.isModalOpen = true;
    } else {
      // Show validation messages only when the form is submitted and fields are invalid
      form.reportValidity();
    }
  },

  confirmSave() {
    let url, method;

    if (!this.form.client_id) {
      this.form.client_id = this.$route.params.id;
    }

    if (this.form.id) {
      url = `/api/psychological-intervention-plans/${this.form.client_id}`;
      method = 'put';
    } else {
      url = `/api/psychological-intervention-plans`;
      method = 'post';
    }

    console.log('Saving data with method:', method, 'URL:', url);

    axios[method](url, this.form)
      .then(response => {
        if (!this.form.id) {
          this.form.id = response.data.id;
        }
        this.saveResultTitle = 'Success';
        this.saveResultMessage = 'Data saved successfully!';
        console.log('Data saved successfully:', response.data);
      })
      .catch(error => {
        if (error.response) {
          this.saveResultMessage = `Error saving data: ${error.response.data.message || 'An unexpected error occurred.'}`;
        } else if (error.request) {
          this.saveResultMessage = 'Error saving data: No response from server.';
        } else {
          this.saveResultMessage = `Error saving data: ${error.message}`;
        }
        this.saveResultTitle = 'Error';
        console.error('Error saving data:', error);
      })
      .finally(() => {
        this.isSaveResultModalOpen = true; // Show save result modal
        this.isModalOpen = false; // Close confirmation modal
        this.editMode = false; // Reset edit mode
        console.log('Save result modal opened');
      });
  },
      updatePage(page) {
        this.currentPage = page;
        console.log('Page updated to:', page);
      },
      closeSaveResultModal() {
        this.isSaveResultModalOpen = false;
        this.saveResultTitle = '';
        this.saveResultMessage = '';
        console.log('Save result modal closed');
      },
      calculateAge(dob) {
        const birthDate = new Date(dob);
        const ageDiff = Date.now() - birthDate.getTime();
        const ageDate = new Date(ageDiff);
        return Math.abs(ageDate.getUTCFullYear() - 1970);
      },
      exportToPdf() {
      const pdf = new jsPDF("landscape", "mm", [216, 356]); // Initialize jsPDF
      const pageWidth = pdf.internal.pageSize.getWidth();
      const pageHeight = pdf.internal.pageSize.getHeight();
      const footerMargin = 20; // Margin from the bottom for the footer
      let totalPages = 0; // To keep track of the total number of pages
  
      // Adjustable gap between table and signature section (in mm)
      const signatureGap = 30;
  
      // Define items per page
      const itemsPerPage = this.itemsPerPage || 10; // Fallback to 10 if itemsPerPage is not set
  
      // Calculate total pages based on itemsPerPage
      const totalPagesGenerated = Math.ceil(this.form.items.length / itemsPerPage) || 1;
      this.totalPages = totalPagesGenerated;
  
      const addHeaderFirstPage = () => {
          const imgData = '/images/headerlogo2.png'; // Path to your header image
          pdf.addImage(imgData, 'PNG', 13, 10, 75, 35); // Add header image
  
          pdf.setFont('Times', 'italic'); // Use built-in 'Times' font in italic
          pdf.setFontSize(9);
          pdf.text('DSWD-GF-010 | REV 01 | 17 AUG 2022', pageWidth - 68, 24); // Adjusted X position
  
          pdf.addFont('arialbd-bold.ttf', 'Arial', 'bold');
          pdf.setFont('Arial', 'bold');  
          pdf.setFontSize(14);
          pdf.text('INTERVENTION PLAN', pageWidth / 2, 47, { align: 'center' });
          pdf.text('PSYCHOLOGICAL SERVICE', pageWidth / 2, 54, { align: 'center' });
           // Add 'As of' date below the Date Admitted
  
           pdf.setFont('Arial', 'normal');
           pdf.setFontSize(12);
           pdf.text(`As of: ${this.form.as_of_date}`, pageWidth / 2, 60, { align: 'center'}); // Add 'As of' date
      };
  
      const addHeaderOtherPages = () => {
      pdf.setFont('Times', 'italic'); // Use built-in 'Times' font in italic
      pdf.setFontSize(9);
      pdf.text('DSWD-GF-010 | REV 01 | 17 AUG 2022', 287, 20);
    };
  
      /**
   * Function to add footer for the first page
   * @param {number} pageNumber - Current page number
   * @param {number} totalPages - Total number of pages
   */
  const addFooterFirstPage = (pageNumber, totalPages) => {
      pdf.setPage(pageNumber); // Set the current page
      const footerY = pageHeight - footerMargin + 5;
      pdf.setFont('Times', 'normal'); // Use built-in 'Times' font
      pdf.setFontSize(10);
  
      // Set consistent line width and color
      pdf.setDrawColor(0, 0, 0); // Black color
      pdf.setLineWidth(0.6); // Consistent line width
      pdf.line(15, footerY - 5, pageWidth - 35, footerY - 5); // Draw footer line
  
      // Add footer image
      const imgData = '/images/footerimg.png'; // Path to your footer image
      pdf.addImage(imgData, 'PNG', pageWidth - 35, footerY - 10, 22, 12); // Add footer image
  
      // Footer text
      pdf.text('DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION/REGIONAL REHABILITATION CENTER FOR YOUTH', pageWidth / 2, footerY - 1, { align: 'center' });
  
      // Contact information
      pdf.text('Email:', 117, footerY + 4);
      pdf.text('Website:', 192, footerY + 4);
  
      // Add clickable links
      pdf.setTextColor(0, 0, 255); // Blue color for links
      pdf.textWithLink('fo11@dswd.gov.ph', 127, footerY + 4, { url: 'mailto:fo11@dswd.gov.ph' });
      pdf.textWithLink('http://www.dswd.gov.ph', 205, footerY + 4, { url: 'http://www.dswd.gov.ph' });
  
      pdf.setTextColor(0, 0, 0); // Reset text color to black
      pdf.text('Tel. No.:(082) 227-1964', pageWidth / 2 - 22, footerY + 4);
  
      // Add page numbering
      pdf.setFont('Times', 'bold'); // Use built-in 'Times' bold font
      pdf.text(`PAGE ${pageNumber} of ${totalPages}`, pageWidth / 2, footerY - 7, { align: 'center' });
  };
  
  /**
   * Function to add footer for subsequent pages
   * @param {number} pageNumber - Current page number
   * @param {number} totalPages - Total number of pages
   */
  const addFooterOtherPages = (pageNumber, totalPages) => {
      pdf.setPage(pageNumber); // Set the current page
      const footerY = pageHeight - footerMargin + 5;
      pdf.setFont('Times', 'normal'); // Use built-in 'Times' font
      pdf.setFontSize(10);
  
      // Set consistent line width and color
      pdf.setDrawColor(0, 0, 0); // Black color
      pdf.setLineWidth(0.6); // Consistent line width
      pdf.line(15, footerY - 5, pageWidth - 15, footerY - 5); // Draw footer line
  
      // Footer text
      pdf.text('DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH', pageWidth / 2, footerY - 1, { align: 'center' });
  
      // Add page numbering
      pdf.setFont('Times', 'bold'); // Use built-in 'Times' bold font
      pdf.text(`PAGE ${pageNumber} of ${totalPages}`, pageWidth / 2, footerY - 7, { align: 'center' });
  };
    
  
      const addTable = (startY, tableRows) => {
          pdf.autoTable({
              startY: startY,
              head: [[
              { content: "OBJECTIVES", styles: { fillColor: [255, 220, 185], textColor: [0, 0, 0] } },
              { content: "ACTIVITIES", styles: { fillColor: [255, 220, 185], textColor: [0, 0, 0] } },
              { content: "RESPONSIBLE PERSON", styles: { fillColor: [255, 220, 185], textColor: [0, 0, 0] } },
              { content: "TIME FRAME", styles: { fillColor: [255, 220, 185], textColor: [0, 0, 0] } },
              { content: "EXPECTED OUTPUT", styles: { fillColor: [255, 220, 185], textColor: [0, 0, 0] } },
              { content: "PROGRESS", styles: { fillColor: [142, 187, 255], textColor: [0, 0, 0] } } // Updated color for the progress column
          ]],
          body: tableRows.map(row => row.map((cell, index) => {
              let fillColor = [255, 240, 225]; // Default peach color for body cells
              // Apply light blue for the "PROGRESS" column (last column)
              if (index === 5) {
                  fillColor = [142, 187, 255]; // Updated light blue for the progress column
              }
              return {
                  content: cell,
                  styles: { fillColor: fillColor, textColor: [0, 0, 0] } // Text color black
              };
          })),
              theme: "plain",
              headStyles: {
                  halign: 'center',
                  fontStyle: 'bold',
                  textTransform: 'uppercase'
              },
              styles: {
                  fontSize: 10,
                  overflow: 'linebreak',
                  cellPadding: 2,
                  lineWidth: 0.2,
                  lineColor: [0, 0, 0], // Changed to pure black
                  textColor: [50, 50, 50]
              },
              margin: { bottom: footerMargin + 10 }, // Ensure space above footer
              columnStyles: {
                  0: { halign: 'center', valign: 'middle' },
                  1: { halign: 'center', valign: 'middle' },
                  2: { halign: 'center', valign: 'middle' },
                  3: { halign: 'center', valign: 'middle' },
                  4: { halign: 'center', valign: 'middle' },
                  5: { halign: 'center', valign: 'middle' },
              },
              didDrawPage: (data) => {
          const currentPage = pdf.internal.getCurrentPageInfo().pageNumber;
  
          if (currentPage === 1) {
            addHeaderFirstPage();
          } else {
            addHeaderOtherPages();
            data.settings.startY = 25; // Adjust startY for subsequent pages
          }
          // Footer will be added after all content is generated
        }
          });
      };
  
      /**
       * Function to add client details before the table
       * @param {number} startY - Y-coordinate to start the client details
       */
    
      const addSignatureSection = (startY) => {
      const signatureHeight = 30; // Height required for the signature section
      const requiredSpace = 10 + signatureHeight + 5; // LineY + signatureHeight + padding
  
      // Calculate available space on the current page
      const availableSpace = pageHeight - startY - footerMargin;
  
      // Check if there's enough space for the signature section
      if (requiredSpace > availableSpace) {
          pdf.addPage(); // Add a new page if there's not enough space
          addHeaderOtherPages(); // Add header to the new page
          startY = 30; // Reset startY for the new page
      }
  
      const finalLineY = startY + 10;
      const finalLabelY = finalLineY + 5;
  
      pdf.setFont('Arial', 'normal');
      pdf.setFontSize(12); // Set font size once
  
      // Function to get the width of a string in points
      function getTextWidth(pdf, text) {
          return pdf.getTextWidth(text); // Using jsPDF's built-in getTextWidth
      }
  
      // Helper function to add a signature block
      const addSignatureBlock = (label, name, xPosition, title) => {
          const labelWidth = getTextWidth(pdf, label);
          const nameWidth = getTextWidth(pdf, name);
  
          pdf.text(label, xPosition, finalLineY - 15); // Label above the name
          pdf.text(name, xPosition, finalLineY ); // Name above the line
          pdf.line(xPosition, finalLineY + 1, xPosition + nameWidth, finalLineY + 1); // Signature line below the name
          pdf.text(title, xPosition, finalLabelY); // Title below the signature line
      };
  
    // Define the y-position for all sections

const sectionY = finalLineY - 10; // Same Y position for labels

// 'Approved by' section - Left aligned
const approvedByLabel = 'Approved by:';
const approvedByName = this.form.approved_by || ''; // Fallback if not defined

pdf.setFont('Arial', 'normal');
pdf.text(approvedByLabel, 15, sectionY);
pdf.setFont('Arial', 'bold');
pdf.text(approvedByName, 15, finalLineY);
pdf.line(15, finalLineY + 1, 15 + pdf.getTextWidth(approvedByName), finalLineY + 1);
pdf.setFont('Arial', 'normal');
pdf.text('Psychometrician', 15, finalLabelY);

// 'Prepared by' section - Center aligned
const preparedByLabel = 'Prepared by:';
const preparedByName = this.form.prepared_by || ''; // Fallback if not defined

const centerX = (pageWidth / 2 - 20) - (pdf.getTextWidth(preparedByName) / 2);

pdf.setFont('Arial', 'normal');
pdf.text(preparedByLabel, centerX, sectionY);
pdf.setFont('Arial', 'bold');
pdf.text(preparedByName, centerX, finalLineY);
pdf.line(centerX, finalLineY + 1, centerX + pdf.getTextWidth(preparedByName), finalLineY + 1);
pdf.setFont('Arial', 'normal');
pdf.text('Psychologist I', centerX, finalLabelY);

// 'Noted by' section - Right aligned
const notedByLabel = 'Noted by:';
const notedByName = this.center_head || ''; // Fallback if not defined
const notedByX = pageWidth - 95;

pdf.setFont('Arial', 'normal');
pdf.text(notedByLabel, notedByX, sectionY);
pdf.setFont('Arial', 'bold');
pdf.text(notedByName, notedByX, finalLineY);
pdf.line(notedByX, finalLineY + 1, notedByX + pdf.getTextWidth(notedByName), finalLineY + 1);
pdf.setFont('Arial', 'normal');
pdf.text('SWO IV / Center Head', notedByX, finalLabelY);

  };
  
  /**
   * Function to generate the PDF content
   */
  const generatePdfContent = () => {
  
      // Add header for the first page
      addHeaderFirstPage();
      pdf.setFont('Arial', 'normal');
      pdf.setFontSize(11);
  
      // Add metadata
      const metadataY = 71;
      pdf.text(`Name: ${this.clientName || ''}`, 15, metadataY);
      pdf.text(`Age: ${this.age || ''}`, pageWidth / 2, metadataY);
      pdf.text(`Date Admitted: ${this.dateAdmitted || ''}`, 15, metadataY + 6);
  
      // Prepare table rows
      const tableRows = this.form.items.map((item) => [
          item.objectives || '',
          item.activities || '',
          item.time_frame || '',
          item.responsible_person || '',
          item.expected_output || '',
          item.progress || '',
      ]);
  
      const tableStartY = metadataY + 10;
      addTable(tableStartY, tableRows);
  
      // After adding the table, get the last Y position
      const lastY = pdf.lastAutoTable ? pdf.lastAutoTable.finalY : tableStartY;
  
// Function to add the header on each page
function addHeader() {
    pdf.setFont('Times', 'italic'); // Use built-in 'Times' font in italic
    pdf.setFontSize(9);
    pdf.text('DSWD-GF-010 | REV 01 | 17 AUG 2022', 287, 20); // Aligns header at the top-right
}

// Add Progress Notes Section
const progressNotesY = lastY + 10; // Adjust Y position below the table
pdf.setFont('Arial', 'bold'); // Set back the font for the Progress Notes label
pdf.setFontSize(12);
pdf.text('Progress Notes:', 15, progressNotesY); // Label for Progress Notes

pdf.setFontSize(10);
pdf.setFont('Arial', 'normal'); // Set back to Arial and normal font for progress notes

// Use splitTextToSize to handle long text dynamically
const progressNotesText = this.form.progress_notes || '';
const maxWidth = pageWidth - 30; // Maximum width for text wrapping
const splitNotes = pdf.splitTextToSize(progressNotesText, maxWidth); // Split text into multiple lines

// Set the Y position for the first line of the progress notes
let currentY = progressNotesY + 6; // Start below the label
const pageHeight = pdf.internal.pageSize.height; // Get page height
const bottomMargin = 20; // Set a bottom margin

// Loop through each line and add it to the PDF
splitNotes.forEach((line) => {
    // Check if adding this line would exceed the page height
    if (currentY + 6 > pageHeight - bottomMargin) { // Check if we are reaching the bottom of the page
        pdf.addPage(); // Add a new page
        addHeader(); // Add the header on the new page
        pdf.setFont('Arial', 'normal'); // Reset the font back to Arial normal after the header
        pdf.setFontSize(10); // Reset font size to normal for the subsequent text
        currentY = 30; // Reset Y position for the new page (consider top margin)
    }
    pdf.text(line, 15, currentY);
    currentY += 6; // Adjust Y position for the next line
});

  
  // Adjust the Y position for the signature section
  const signatureStartY = currentY + 10; // Add a gap before the signature section
  addSignatureSection(signatureStartY);
  
  
    
      // After all content is added, set totalPages
      totalPages = pdf.getNumberOfPages();
  
      // Now, add footers to all pages
      for (let i = 1; i <= totalPages; i++) {
          if (i === 1) {
              addFooterFirstPage(i, totalPages);
          } else {
              addFooterOtherPages(i, totalPages);
          }
      }
  
      // Save the PDF with the plan name
      pdf.save(`intervention-plan-${this.form.clientName || 'Unnamed'}.pdf`);
  };
  
  
      generatePdfContent();
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
  