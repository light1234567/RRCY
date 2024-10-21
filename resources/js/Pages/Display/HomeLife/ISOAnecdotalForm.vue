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
  
      <button v-if="editMode" @click="submitForm" class="flex items-center space-x-2 px-3 py-1 bg-green-500 hover:bg-green-600 text-white rounded-md text-xs">
        <!-- FontAwesome for Save -->
        <i class="fas fa-check w-4 h-4"></i>
        <span>Save</span>
      </button>
  
      <!-- Download PDF Button -->
      <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-xs">
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
  
  <form ref="AnecdotalForm" @submit.prevent="submitForm">
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
           <p class="text-center text-xs">DSWD-GF-010 | REV 02 | 17 AUG 2022</p>
           <div class="text-xs font-semibold pt-12">
    <p class="text-sm font-semibold">
    DRN :
    <input type="text" v-model="form.drn" class="underline-input text-sm p-1" :readonly="!editMode" maxlength="20"/>
  </p>
  </div>
         </div>
       </div>
       <p class="text-sm font-semibold">
    FOR THE MONTH OF
    <select 
        v-model="form.month" 
        class="underline-input text-sm -p-1" 
        style="background: transparent;" 
        :disabled="!editMode" 
        @input="(e) => { e.target.setCustomValidity('') }" 
        @invalid="(e) => { e.target.setCustomValidity('Please select a month') }" 
        required
      >
        <option value="" disabled selected>Select a month</option>
        <option value="January">January</option>
        <option value="February">February</option>
        <option value="March">March</option>
        <option value="April">April</option>
        <option value="May">May</option>
        <option value="June">June</option>
        <option value="July">July</option>
        <option value="August">August</option>
        <option value="September">September</option>
        <option value="October">October</option>
        <option value="November">November</option>
        <option value="December">December</option>
      </select>


  </p>
     </div>
  
     <!-- General Information -->
     <div class="grid grid-cols-2 gap-6 mb-6">
       <div class="flex items-center text-sm">
   <label for="pangalan" class="block font-medium w-auto mr-2">Pangalan:</label>
   <input
     type="text"
     id="pangalan"
     v-model="form.name"
     readonly
     class="border-transparent text-sm underline-input p-2 w-full"
   >
  </div>
       <div class="flex items-center">
         <label for="date" class="block font-medium w-auto mr-2 text-sm ">Petsa:</label>
         <input
            type="date"
            id="date"
            v-model="form.date"
            class="border-transparent text-sm underline-input p-2 w-28"
            :readonly="!editMode"
            :max="new Date().toLocaleString('en-CA', { 
      timeZone: 'Asia/Manila', 
      year: 'numeric', 
      month: '2-digit', 
      day: '2-digit' 
    }).split(',')[0]"  
            @input="(e) => { e.target.setCustomValidity('') }"
            @invalid="(e) => { e.target.setCustomValidity('Please provide a valid date') }"
            required
          >

       </div>
     </div>
  
     <!-- Report Sections -->
     <div class="space-y-4 mb-6">
       <div>
         <label for="physical" class="block font-medium">
           <span class="font-bold text-sm">I. PHYSICAL :</span> 
           <span class="font-normal text-sm"> Management of personal hygiene and improvement of self-care habits.</span>
         </label>
         <textarea
          id="physical"
          v-model="form.physical"
          class="border border-gray-400 p-2 rounded-md w-full"
          rows="3"
          :readonly="!editMode"
          @input="(e) => { e.target.setCustomValidity('') }"
          @invalid="(e) => { e.target.setCustomValidity('Please provide a physical description') }"
          required
        ></textarea>

       </div>
  
       <div>
         <label for="emotional" class="block font-medium">
           <span class="font-bold text-sm">II. EMOTIONAL :</span> 
           <span class="font-normal text-sm justify-text"> The degree to which the resident displayed his coping capacity towards ill/guilty feelings and feelings of helplessness.</span>
         </label>
        
         <textarea
            id="emotional"
            v-model="form.emotional"
            class="border border-gray-400 p-2 rounded-md w-full"
            rows="3"
            :readonly="!editMode"
            @input="(e) => { e.target.setCustomValidity('') }"
            @invalid="(e) => { e.target.setCustomValidity('Please provide an emotional response') }"
            required
          ></textarea>

       </div>
  
       <div>
         <label for="behavioral" class="block font-medium">
           <span class="font-bold text-sm">III. SOCIAL/BEHAVIORAL :</span> 
           <span class="font-normal text-sm justify-text"> The level to which the resident demonstrated honesty, self-control, and a sense of responsibility.</span>
         </label>
         <textarea
            id="behavioral"
            v-model="form.behavioral"
            class="border border-gray-400 p-2 rounded-md w-full"
            rows="3"
            :readonly="!editMode"
            @input="(e) => { e.target.setCustomValidity('') }"
            @invalid="(e) => { e.target.setCustomValidity('Please provide behavioral information') }"
            required
          ></textarea>

       </div>
  
       <div>
         <label for="spiritual" class="block font-medium">
           <span class="font-bold text-sm">IV. SPIRITUAL :</span> 
           <span class="font-normal text-sm justify-text"> Attitude displayed towards the acceptance of the present situation.</span>
         </label>
         <textarea
            id="spiritual"
            v-model="form.spiritual"
            class="border border-gray-400 p-2 rounded-md w-full"
            rows="3"
            :readonly="!editMode"
            @input="(e) => { e.target.setCustomValidity('') }"
            @invalid="(e) => { e.target.setCustomValidity('Please provide a spiritual input') }"
            required
          ></textarea>

       </div>
  
       <div>
         <label for="recommendation" class="block text-sm font-semibold">V. RECOMMENDATION:</label>
         <textarea
          id="recommendation"
          v-model="form.recommendation"
          class="border border-gray-400 p-2 rounded-md w-full"
          rows="3"
          :readonly="!editMode"
          @input="(e) => { e.target.setCustomValidity('') }"
          @invalid="(e) => { e.target.setCustomValidity('Please provide a recommendation') }"
          required
        ></textarea>

       </div>
     </div>
  
     <!-- Color and Prepared by -->
     <div class="mb-6 ">
       <!-- Color Field -->
       <div class="flex items-center mb-4">
         <label for="color" class="block text-sm font-medium mr-4">Color:</label>
         <input
           type="text"
           id="color"
           v-model="form.color"
           class=" w-1/4 underline-input text-sm p-0 shadow-sm"
           :readonly="!editMode"
           maxlength="10"
         >
       </div>
       </div>
       <!-- Prepared by Field -->
      <!-- Name and Signature of Houseparent -->
      <div class="mb-6 flex justify-between items-center">
       <div class="w-1/2 mr-12">
         <label for="preparedBy" class="block text-sm font-medium">Prepared by:</label>
         <div class="flex items-center">
           <input
             type="text"
             id="preparedBy"
             v-model="form.prepared_by"
             class="mt-1 w-3/4 underline-input text-sm shadow-sm"
             :readonly="!editMode"
             maxlength="50"
           >
         </div>
         <p class="text-sm mt-2">Name and Signature of Houseparent</p>
       </div>
  
       <!-- Name and Signature of Residents -->
       <div class="w-1/2">
         <label for="signatureResidents" class="block font-medium invisible">Prepared by:</label>
         <div class="font-semibold flex items-center">
           <input
             type="text"
             id="signatureResidents"
             v-model="form.name"
             class="mt-1 w-3/4 underline-input text-sm shadow-sm"
             :readonly="!editMode"
           >
         </div>
         <p class="text-sm mt-2">Name & Signature of Residents</p>
       </div>
     </div>
  
       <!-- Noted by and Approved by -->
     <div class="mb-6 flex justify-between items-start">
       <!-- Noted by Section -->
       <div class="w-1/2 mr-12">
         <label for="notedBy" class="block text-sm font-medium">Noted by:</label>
         <input
           type="text"
           id="notedBy"
           v-model="form.anecdotal_shp"
           class="mt-1 w-3/4 underline-input text-sm shadow-sm"
           :readonly="!editMode"
           maxlength="50"
         >
         <p class="text-sm">HP III/SHP</p>
       </div>
  
       <!-- Approved by Section -->
       <div class="w-1/2">
         <label for="approvedBy" class="block text-sm font-medium">Approved by:</label>
         <input
           type="text"
           id="notedBy"
           v-model="center_head"
           class="mt-1 w-3/4 underline-input text-sm shadow-sm"
           :readonly="!editMode"
         >
         <p class="text-sm">SWO IV / Center Head</p>
       </div>
     </div>
     <div class=" border-gray-300 pt-4 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;"> 
        <div class="flex justify-between items-start w-full">
            <div class="flex flex-col w-full"> <!-- Expanded width for the text section -->
                <p class="font-bold">PAGE 1 of 1</p>
                <p class="border-t-2 border-black"></p>
                <p class="pt-2">DSWD FOXI, Ramon Magsaysay Corner D. Suazo Street, Davao City, Philippines 8000</p>
                <p > Website: <span class="text-blue-600 underline">http://www.rrcy.fo11@dswd.gov.ph</span> Tel No.(082) 293-03-06</p>
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
  
  export default {
   name: 'AnecdotalReportForm',
   components: {
     Pagination,
   },
   data() {
     return {
      center_head: '',
       form: {
         client_id: null,
         drn: '',
         name: '',
         anecdotal_shp:'',
         date: '',
         month: '',
         color: '',
         physical: '',
         emotional: '',
         behavioral: '',
         spiritual: '',
         recommendation: '',
         approved_by: 'ANGELIC B. PAÑA',
         prepared_by: '',
         signature_residents: '',
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
     this.fetchCenterHead();
     this.fetchData(clientId);
   },
   watch: {
      '$route.params.id': function(newId) {
       this.fetchData(newId);
     }
   },
   methods: {
    fetchData(clientId) {
    if (!clientId) return;
    console.log('Fetching data for client ID:', clientId);
  
    axios.get(`/api/anecdotal-reports/${clientId}`).then(response => {
      console.log('API Response:', response.data); // Add this to check the response
  
      if (response.data.report) {
        // Populate form if report exists
        Object.assign(this.form, response.data.report);
        this.form.client_id = clientId;
        this.form.month = response.data.report.month;
        this.form.drn = response.data.report.drn;
        this.form.anecdotal_shp = response.data.report.anecdotal_shp;
        this.form.name = `${response.data.client.first_name} ${response.data.client.last_name}`; // Ensure correct field mapping
        this.originalForm = JSON.parse(JSON.stringify(this.form)); // Store original form
      } else {
        // If no report, fetch client info
        const { client } = response.data;
        this.form.client_id = client.id;
        this.form.name = `${client.first_name} ${client.last_name}`;
        this.originalForm = JSON.parse(JSON.stringify(this.form)); // Store original form
      }
    }).catch(error => {
      console.error('Error fetching data:', error);
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
    
    toggleEdit() {
      this.editMode = !this.editMode;
    },
  
     openModal() {
       this.isModalOpen = true;
     },
  
     closeModal() {
       this.isModalOpen = false;
     },
  
     cancelEdit() {
       if (this.originalForm) {
         // Revert to the original data
         this.form = JSON.parse(JSON.stringify(this.originalForm));
       }
       this.editMode = false; // Exit edit mode
     },
  
     submitForm() {
  const form = this.$refs.AnecdotalForm; // Make sure the form ref is properly set in the template
  let isFormValid = true;

  // Validate the form, if there are invalid fields, report them
  if (!form.checkValidity()) {
    isFormValid = false;
    form.reportValidity();  // This will scroll to the first invalid field and show a validation message
  }

  // If the form is valid, open the confirmation modal
  if (isFormValid) {
    this.isModalOpen = true;  // Open the confirmation modal for saving
  } else {
    console.warn('Form has invalid fields, please correct them.');
  }
},

confirmSave() {
  const url = `/api/anecdotal-reports/${this.form.client_id}`;

  axios.put(url, this.form)
    .then(response => {
      this.message = 'Data updated successfully!';
      this.messageType = 'success';
      this.saveResultTitle = 'Success';
      this.saveResultMessage = 'Data updated successfully.';
      this.isSaveResultModalOpen = true; // Show the modal after saving
      this.fetchData(this.form.client_id); // Refresh the data after successful save
    })
    .catch(error => {
      this.message = 'Failed to update data';
      this.messageType = 'error';
      this.saveResultTitle = 'Error';
      this.saveResultMessage = error.response?.data?.message || 'Error updating data.';
      this.isSaveResultModalOpen = true; // Show the modal even on error
      console.error('Error saving data:', error);
    })
    .finally(() => {
      this.isModalOpen = false;  // Close the confirmation modal after the save operation
    });
},


  
  
     clearMessage() {
       setTimeout(() => {
         this.message = '';
         this.messageType = '';
       }, 3000);
     },
  
     closeSaveResultModal() {
        this.isSaveResultModalOpen = false; // Close the result modal
        this.editMode = false; // Ensure the form is no longer in edit mode if applicable
      },
  
     updatePage(newPage) {
       this.currentPage = newPage;
       // Add logic to fetch data or change content based on the page
     },
     exportToPdf() {
      const pdf = new jsPDF('p', 'mm', [216, 356]); // Legal size: 216mm x 356mm
    const pageHeight = pdf.internal.pageSize.getHeight(); // Total page height in mm
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
      pdf.text('DSWD-GF-010 | REV 02 | 17 AUG 2022', 135, 20);
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
        pdf.setFontSize(12); // Set font size back to what it was
        pdf.setDrawColor(0, 0, 0);
      }
    };
  
    const addFooter = () => {
        if (currentPage === 1) {
          pdf.setFontSize(8);
          pdf.setFont('TimesNewRoman', 'bold');
          pdf.setLineWidth(0.5);
          pdf.line(21, 335, 190, 335); // Footer line
    
          pdf.setFont('times', 'normal');
          const footerText = pdf.splitTextToSize('DSWD Field Office XI, Ramon Magsaysay Corner D. Suazo Street, Davao City, Philippines 8000', 160);
          pdf.text(footerText, 105, 340, { align: 'center' });
          pdf.text('Website:', 71, 343, { align: 'center' });
          pdf.text('Tel Nos.: (082) 293-03-06', 133, 343, { align: 'center' });



          pdf.setFontSize(8);
        pdf.setTextColor(0, 0, 255);
        pdf.text('http://www.rrcy.fo11@dswd.gov.ph', 97, 343, { align: 'center' });
        pdf.setLineWidth(0);
        pdf.setDrawColor(0, 0, 255);
        pdf.line(76, 344, 118, 344);

        pdf.setTextColor(0, 0, 0);
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
      pdf.text('PROTECTIVE SERVICES DIVISION', 160, 19, { align: 'center' });
      pdf.text('Regional Rehabilitation Center for', 160, 23, { align: 'center' });
      pdf.text('Youth FOR XI', 160, 27, { align: 'center' });
    
      pdf.setFontSize(8);
      pdf.setFont('arial', 'normal'); 
      pdf.text('DSWD-GF-010 | REV 02 | 17 AUG 2022', 160, 32, { align: 'center' });
    
  
    contentYPos += -20;
    pdf.setFont('arialbd', 'bold');
    pdf.setFontSize(11);
    pdf.text(`DRN :`, initialX+110, contentYPos+-5);
    pdf.text(`${this.form.drn || ''}`, initialX+122, contentYPos+-5);
    pdf.line(142, contentYPos+-4, 190, contentYPos+-4); 
  
  contentYPos += 10;
  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(11);
  pdf.text(`FOR THE MONTH OF ${this.form.month}`, initialX + 60, contentYPos);
  pdf.line(119, contentYPos+1, 150, contentYPos+1); 


  // Content starts below title
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(11);

  contentYPos += 15;
  pdf.text(`Pangalan:`, initialX, contentYPos);
const nameValue = `${this.form.name || ''}`;
const nameWidth = pdf.getTextWidth(nameValue);
pdf.text(nameValue, initialX + 18, contentYPos); 
pdf.line(initialX + 18, contentYPos + 1, initialX + 18 + nameWidth, contentYPos + 1); 


pdf.text(`Petsa:`, initialX + 100, contentYPos);
const dateValue = `${this.form.date || ''}`;
const dateWidth = pdf.getTextWidth(dateValue);
pdf.text(dateValue, initialX + 112, contentYPos);
pdf.line(initialX + 112, contentYPos + 1, initialX + 112 + dateWidth, contentYPos + 1);






  contentYPos += rowHeight;
  addNewPageIfNeeded();
  pdf.setFont('arialbd', 'bold');
  pdf.text('I. PHYSICAL :', initialX, contentYPos+5);
  pdf.setFont('arial', 'normal');
  pdf.text('Management of personal hygiene and improvement of self-care habits.', initialX+27, contentYPos+5);

  contentYPos += rowHeight;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(11);
  const physicalLog = `${this.form.physical || ''}`;
  const physicalLogLines = pdf.splitTextToSize(physicalLog, maxWidth);

  physicalLogLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos+4);
    contentYPos += lineHeight;
  });

  contentYPos += rowHeight;
  addNewPageIfNeeded();
  pdf.setFont('arialbd', 'bold');
  pdf.text('II. EMOTIONAL :', initialX, contentYPos+5);
  pdf.setFont('arial', 'normal');
  pdf.text('The degree to which the resident displayed his coping capacity towards ill/guilty', initialX+31, contentYPos+5);
  pdf.text('feelings and feelings of helplessness.', initialX, contentYPos+10);

  contentYPos += rowHeight;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(11);
  const emotionallLog = `${this.form.emotional || ''}`;
  const emotionallLogLines = pdf.splitTextToSize(emotionallLog, maxWidth);

  emotionallLogLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos+8);
    contentYPos += lineHeight;
  });

  contentYPos += rowHeight;
  addNewPageIfNeeded();
  pdf.setFont('arialbd', 'bold');
  pdf.text('III. SOCIAL/BEHAVIORAL :', initialX, contentYPos+5);
  pdf.setFont('arial', 'normal');
  pdf.text('The level to which the resident demonstrated honesty, self-control,', initialX+50, contentYPos+5);
  pdf.text('and a sense of responsibility.', initialX, contentYPos+10);

  contentYPos += rowHeight;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(11);
  const behaviorallLog = `${this.form.behavioral || ''}`;
  const behaviorallLogLines = pdf.splitTextToSize(behaviorallLog, maxWidth);

  behaviorallLogLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos+8);
    contentYPos += lineHeight;
  });

  contentYPos += rowHeight;
  addNewPageIfNeeded();
  pdf.setFont('arialbd', 'bold');
  pdf.text('IV. SPIRITUAL :', initialX, contentYPos+5);
  pdf.setFont('arial', 'normal');
  pdf.text('Attitude displayed towards the acceptance of the present situation.', initialX+30, contentYPos+5);

  contentYPos += rowHeight;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(11);
  const spirituallLog = `${this.form.spiritual || ''}`;
  const spirituallLogLines = pdf.splitTextToSize(spirituallLog, maxWidth);

  spirituallLogLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos+4);
    contentYPos += lineHeight;
  });

  contentYPos += rowHeight;
  addNewPageIfNeeded();
  pdf.setFont('arialbd', 'bold');
  pdf.text('V. RECOMMENDATION:', initialX, contentYPos+5);

  contentYPos += rowHeight;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(11);
  const recommendationlLog = `${this.form.recommendation || ''}`;
  const recommendationlLogLines = pdf.splitTextToSize(recommendationlLog, maxWidth);

  recommendationlLogLines.forEach(line => {
    addNewPageIfNeeded(); // Check for overflow before adding a line
    pdf.text(line, initialX, contentYPos+4);
    contentYPos += lineHeight;
  });


  contentYPos +=rowHeight;
  addNewPageIfNeeded();

  pdf.text(`Color:`, initialX, contentYPos);

// Get the session value and its width
const colorValue = `${this.form.color || ''}`;
const colorWidth = pdf.getTextWidth(colorValue);

// Display the session value and underline only the value
pdf.text(colorValue, initialX + 12, contentYPos);  // Adjust the X position to align the value after the label
pdf.setLineWidth(0);
pdf.line(initialX + 12, contentYPos + 1, initialX + 12 + colorWidth, contentYPos + 1); // Underline for session value

contentYPos +=10;
  // Prepared by Section
  contentYPos += rowHeight; 
  addNewPageIfNeeded();
  pdf.text('Prepared by:', initialX, contentYPos);
  
  contentYPos += rowHeight; 
  addNewPageIfNeeded();
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(11);
  const prepared_byValue = `${this.form.prepared_by || ''}`;
  const prepared_byWidth = pdf.getTextWidth(prepared_byValue);
  pdf.setLineWidth(0);
  pdf.text(prepared_byValue, initialX, contentYPos);  
  pdf.line(initialX, contentYPos + 1, initialX + prepared_byWidth, contentYPos + 1); 


  pdf.setFont('arial', 'normal');
  pdf.setFontSize(11);
  pdf.text('Name and Signature of Houseparent', initialX, contentYPos+5);

  pdf.setFont('arial', 'normal');
  pdf.setFontSize(11);
  const signature_residentsValue = `${this.form.name || ''}`;
  const signature_residentsWidth = pdf.getTextWidth(signature_residentsValue);
  pdf.setLineWidth(0);
  pdf.text(signature_residentsValue, initialX+100, contentYPos);  
  pdf.line(initialX+100, contentYPos + 1, initialX+100 + signature_residentsWidth, contentYPos + 1); 




  contentYPos += 5; 
  addNewPageIfNeeded();
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(11);
  pdf.text('Name & Signature of Residents', initialX+100, contentYPos);

  // Noted by Section
  contentYPos += rowHeight; 
  contentYPos += 4;
  addNewPageIfNeeded();
  pdf.setFontSize(11);
  pdf.text('Noted by:', initialX, contentYPos);
  pdf.text('Approved by:', initialX+100, contentYPos);
  
  contentYPos += rowHeight; 
  addNewPageIfNeeded();
pdf.setFontSize(11);
pdf.setFont('Arialbd', 'bold');

const anecdotal_shpValue = `${this.form.anecdotal_shp || ''}`;
const anecdotal_shpWidth = pdf.getTextWidth(anecdotal_shpValue);
const pageWidth = pdf.internal.pageSize.getWidth();
const centerX = (pageWidth - anecdotal_shpWidth) / 2;
pdf.text(anecdotal_shpValue, initialX, contentYPos + 8);
pdf.line(initialX, contentYPos + 9, initialX + anecdotal_shpWidth, contentYPos + 9); 
pdf.setFont('Arial', 'normal');
pdf.text(`HP III/SHP`, initialX, contentYPos + 14);

  pdf.setFontSize(11);
  pdf.setFont('Arialbd', 'bold');
 const center_headValue = `${this.center_head || ''}`;
 const center_headWidth = pdf.getTextWidth(center_headValue);
 pdf.text(center_headValue, initialX + 100, contentYPos+8); 
 pdf.line(initialX + 100, contentYPos + 9, initialX + 100 + center_headWidth, contentYPos + 9); 
 pdf.setFont('Arial', 'normal');
 pdf.text(`SWO IV / Center Head`, initialX + 100, contentYPos+14);
 
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
  pdf.save(`Anecdotal_Report_${this.form.name || ''}.pdf`);
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
    }
  .graph-background {
      background-image: linear-gradient(to right, #cccccc 1px, transparent 1px), 
                        linear-gradient(to bottom, #cccccc 1px, transparent 1px);
      background-size: 15px 15px; /* Adjust size as per your need */
    } 
  </style>