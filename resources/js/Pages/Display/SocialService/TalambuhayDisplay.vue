<template>
  <!-- Tabs for Actions -->
  <div v-if="editMode" class="flex absolute p-4 space-x-4">
      <button @click="cancelEdit" class="flex space-x-2 px-3 py-3 bg-blue-900 text-white rounded-md text-xs">
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
             <h3 class="text-lg leading-6 font-medium ">Save changes?</h3>
           </div>
           <div class="mt-2">
             <p class="text-sm">Are you sure you want to save the changes?</p>
           </div>
         </div>
         <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
           <button @click="confirmSave" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Save</button>
           <button @click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
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
           <h3 class="text-lg leading-6 font-medium ">{{ saveResultTitle }}</h3>
           <div class="mt-2">
             <p class="text-sm ">{{ saveResultMessage }}</p>
           </div>
         </div>
         <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
           <button @click="closeSaveResultModal" :class="saveResultTitle === 'Error' ? 'bg-red-600 hover:bg-red-500' : 'bg-blue-600 hover:bg-blue-500'" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
             OK
           </button>
         </div>
       </div>
     </div>
     <form ref="TalambuhayForm" @submit.prevent="saveData">
  <div class="graph-background pt-0.5  -mr-9 -mb-16">
   <div class="p-8">
     <!-- Page 1 -->
     <div v-if="currentPage === 1" class="max-w-3xl border border-gray-400 mx-auto bg-white p-16 rounded-lg shadow-lg mb-10">
       <div class="flex items-center justify-between mb-4">
         <img src="/images/headerlogo2.png" alt="DSWD Logo" class="h-32 w-64 relative z-10">
         <div class="text-right">
           <p class="text-xs">DSWD-GF-010A | REV 00 | 22 SEP 2023        </p>
         </div>
       </div>
       <h1 class="text-2xl font-bold text-center mb-2">CONFIDENTIAL</h1>
       <h2 class="text-xl text-center underline mb-6">TALAMBUHAY</h2>
  
       <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
         {{ message }}
       </div>
       <div class="mb-6">
   
         <p class=" mb-2"><u>Tungkol sa aking <span class="font-bold">Pamilya</span></u> (Ilan kaming magkakapatid at tungkol sa kanilang buhay o kaya trabaho; papa/mama at tungkol sa kanilang ikinabubuhay, tungkol sa pamilya at iba pa)</p>
         <textarea 
  class="w-full mt-1 p-2 border border-gray-300 rounded-md" 
  rows="10" 
  v-model="form.about_my_family" 
  :readonly="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide details about your family') }" 
  required
></textarea>

       </div>
  
       <div class="mb-6">
         <p class="mb-2"><u>Tungkol sa aking <span class="font-bold">Sarili</span></u> (Karanasan mula pagkabata, mga napagtagumpayan, mga bisyo/pagkakamali, eskwela, interes at mga gustong gawin, sports, ambisyon, pangarap at iba pa)</p>
         <textarea 
  class="w-full mt-1 p-2 border border-gray-300 rounded-md" 
  rows="10" 
  v-model="form.about_my_self" 
  :readonly="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide details about yourself') }" 
  required
></textarea>

       </div>
  
       <div class="border-gray-300 ml-6 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
          <div class="flex justify-between items-center">
            <div class="flex flex-col">
              <p class="ml-24 -mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
              <p class="border-t mt-4 text-[10px]" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
              <p class="ml-4">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
            </div>
            <div class="ml-4">
              <img src="/images/footerimg.png" alt="" class="h-12 w-24 object-cover rounded-md">
            </div>
          </div>
        </div>
     </div>
  
     <!-- Page 2 -->
     <div v-if="currentPage === 2" class="max-w-3xl mx-auto bg-white p-16 rounded-lg shadow-lg mb-10">
       <div class="text-right mb-4">
         <p class="text-xs">DSWD-GF-010A | REV 00 | 22 SEP 2023  </p>
       </div>
  
       <div class="mb-6 mt-12">
         <p class="mb-2"><u>Tungkol sa aking <span class="font-bold">kaso</span></u> (Ano at papaano nangyari, detalye ng pangyayari, ano ang rason at bakit nasangkot "Na-apil" sa kaso, sino-sino ang sangkot at iba pa)</p>
         <textarea 
  class="w-full mt-1 p-2 border border-gray-300 rounded-md" 
  rows="15" 
  v-model="form.about_my_case" 
  :readonly="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide details about your case') }" 
  required
></textarea>
       </div>
  
       <div class="mb-6">
         <h3 class="text-lg font-semibold mb-2">Received & Assessed:</h3>
         <div class="flex justify-between mt-2">
           <div class="w-1/2 pr-2">
             <input 
               type="text" 
               class="mt-1 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full"
               v-model="form.talambuhay_case_manager" 
               :readonly="!editMode"
               @input="form.talambuhay_case_manager = removeNumbers(form.talambuhay_case_manager)"
             >
             <label class="">Case Manager:</label>
           </div>
           <div class="w-1/2 pl-2">
             <input 
               type="text" 
               class="mt-1 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full"
               v-model="clientName" 
               readonly
             >
             <label class="">Pangalan ng Client at Pirma:</label>
           </div>
         </div>
       </div>
       <div class="mt-12">
             <input 
  type="date" 
  class="mt-1 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-1/4" 
  v-model="form.date" 
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
           <label class=" mb-2 -mt-12">Petsa:</label>
           <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        
        <!-- Left Section: Page number -->
        <div class="flex flex-col flex-grow">
          <!-- Page number centered -->
          <p class="text-center -mb-1 font-bold">PAGE 2 of {{ totalPages }}</p>
    
        <!-- Continuous horizontal line, moved to the left with space on the right -->
        <div style="border-top: 2px solid black; width: 103%; margin-top: 4px; margin-left: -24px;"></div>
    
    
          <!-- Text under the line -->
          <p class="-ml-6 text-[11px] " style="text-align: center; font-weight: bold; margin-top: -1px;">DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH</p>
        </div>
    
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
  import { jsPDF } from 'jspdf';
  import '../../../fonts/arial-normal.js'; 
  import '../../../fonts/times-normal.js'; 
  import '../../../fonts/arialbd-bold.js'; 
  
  
  export default {
   components: {
     Pagination
   },
   data() {
     return {
       editMode: false,
       message: '',
       messageType: '',
       form: {
         client_id: null,
         about_my_family: '',
         about_my_self: '',
         about_my_case: '',
         talambuhay_case_manager: '',
         date: ''
       },
       clientName: '',
       errorMessage: '',
       currentPage: 1,
       totalPages: 2,
       isModalOpen: false,
       isSaveResultModalOpen: false,
       saveResultTitle: '',
       saveResultMessage: ''
     };
   },
   mounted() {
     const id = this.$route.params.id;
     console.log('Client ID fetched:', id); // Console log showing client ID
     if (id) {
       this.fetchClientData(id);
     }
   },
   watch: {
     '$route.params.id': function(newId) {
       console.log('Client ID changed:', newId); // Console log showing updated client ID
       if (newId) {
         this.fetchClientData(newId);
       }
     }
   },
   methods: {
    async fetchClientData(clientId) {
      try {
        console.log(`Fetching client data for client ID: ${clientId}`);
        
        // Fetch client data
        const clientResponse = await axios.get(`/api/clients/${clientId}`);
        console.log('Client response:', clientResponse);
        const client = clientResponse.data;
        this.clientName = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
        this.form.client_id = client.id;
  
        // Fetch Talambuhay data by client ID
        console.log(`Fetching Talambuhay data for client ID: ${clientId}`);
        const talambuhayResponse = await axios.get(`/api/talambuhay/client/${clientId}`); // Updated the URL
        console.log('Talambuhay response:', talambuhayResponse);
        const talambuhay = talambuhayResponse.data;
  
        // Populate the form fields
        this.form.about_my_family = talambuhay.about_my_family || '';
        this.form.about_my_self = talambuhay.about_my_self || '';
        this.form.about_my_case = talambuhay.about_my_case || '';
        this.form.talambuhay_case_manager = talambuhay.talambuhay_case_manager || '';
        this.form.date = talambuhay.date || '';
  
      } catch (error) {
        if (error.response) {
          console.error('Error response data:', error.response.data);
          console.error('Error response status:', error.response.status);
          console.error('Error response headers:', error.response.headers);
        } else if (error.request) {
          console.error('Error request:', error.request);
        } else {
          console.error('Error message:', error.message);
        }
        console.error('Error config:', error.config);
        this.errorMessage = 'Error fetching client data.';
      }
    },
     toggleEdit() {
       if (this.editMode) {
         this.openModal();
       } else {
         this.editMode = !this.editMode;
       }
     },
     cancelEdit() {
        this.editMode = false;
        console.log('Edit mode canceled');
      },
     openModal() {
       this.isModalOpen = true;
     },
     closeModal() {
       this.isModalOpen = false;
     },
     async confirmSave() {
       await this.saveData();
       this.closeModal();
       this.editMode = false;
     },
     removeNumbers(input) {
    return input.replace(/[0-9]/g, '');
  },
  async saveData() {
  if (!this.form.client_id) {
    this.message = 'Client ID is missing.';
    this.messageType = 'error';
    return;
  }

  const totalPages = this.totalPages;  // Ensure this is set correctly based on your pagination logic
  let allFieldsValid = true;

  // Loop through each page and check for required field validation
  for (let i = 1; i <= totalPages; i++) {
    // Set the current page to the page being validated
    this.currentPage = i;
    
    // Wait for the page to be fully rendered
    await this.$nextTick();
    
    // Get the form reference for validation
    const form = this.$refs.TalambuhayForm;  // Ensure this matches the form's ref in your template

    // Validate the current page's form
    if (!form.checkValidity()) {
      allFieldsValid = false;
      form.reportValidity();  // Show validation messages and focus on the first invalid field
      
      // Stop validation if we find an invalid field
      break;
    }
  }

  // If all fields are valid across all pages, show the confirmation modal
  if (allFieldsValid) {
    this.isModalOpen = true;  // Open confirmation modal
  } else {
    console.warn('Form has invalid fields, please correct them.');
  }
},

async confirmSave() {
  try {
    // Check if the Talambuhay record exists and update it
    const response = await axios.get(`/api/talambuhay/client/${this.form.client_id}`);
    
    if (response.status === 200) {
      // Update the existing Talambuhay record
      await axios.put(`/api/talambuhay/client/${this.form.client_id}`, this.form);
      this.saveResultTitle = 'Success';
      this.saveResultMessage = 'Data updated successfully!';
    }
  } catch (error) {
    // If record does not exist, create a new one
    if (error.response && error.response.status === 404) {
      try {
        await axios.post('/api/talambuhay', this.form);
        this.saveResultTitle = 'Success';
        this.saveResultMessage = 'Data created successfully!';
      } catch (postError) {
        console.error('Error creating record:', postError);
        this.saveResultTitle = 'Error';
        this.saveResultMessage = 'Error creating record.';
      }
    } else {
      console.error('Error fetching data:', error);
      this.saveResultTitle = 'Error';
      this.saveResultMessage = 'Error saving data.';
    }
  } finally {
    this.isModalOpen = false;  // Close confirmation modal
    this.isSaveResultModalOpen = true;  // Show save result modal
  }
}
,
     closeSaveResultModal() {
       this.isSaveResultModalOpen = false;
       this.saveResultTitle = '';
       this.saveResultMessage = '';
     },
     updatePage(page) {
       this.currentPage = page;
     },
     exportToPdf() {
    const pdf = new jsPDF('p', 'mm', [216, 356]); // Legal size: 216mm x 356mm
    const pageHeight = 356; // Total page height in mm
    const marginBottom = 30; // Bottom margin in mm
    const rowHeight = 8; // Height of each row
    const lineHeight = 7; // Space between lines
    const footerHeight = 7; // Adjust to fit the height of your footer
    const maxContentHeight = pageHeight - marginBottom - footerHeight; // Reduce height to account for footer
    const maxWidth = 170; // Maximum width for text
    let contentYPos = 55; // Start Y position for content
    let initialX = 20; // X position for content
    let currentPage = 1; // Start at page 1
  
  
   const addHeader = () => {
     // Header text
     pdf.setFontSize(9);
     pdf.setFont('TimesNewRoman', 'italic');
     pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 135, 20);
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
          const footerText = pdf.splitTextToSize('DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Prk. 7 Bago-Oshiro, Tgubok Dist., Davao City', 160);
          pdf.text(footerText, 95, 340, { align: 'center' });
          pdf.text('Email: rrcy.fo11@dswd.gov.ph Tel. No.:293-0306 ', 105, 345, { align: 'center' });
    
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
      addHeader();
  
   const imgData = '/images/headerlogo2.png';
   pdf.addImage(imgData, 'PNG', 15, 10, 50, 30);
  
   contentYPos +=10;
   pdf.setFont('arialbd', 'bold');
   pdf.setFontSize(20);
   pdf.text('CONFIDENTIAL', 105, 50, null, null, 'center');
   pdf.setFontSize(15);
   pdf.setFont('arial', 'normal');
   pdf.text('TALAMBUHAY', 105, 60, null, null, 'center');
   pdf.line(87, contentYPos+-4, 123, contentYPos+-4); // Underline
  
   // Reset contentYPos to start below the title
    contentYPos += 5;
    addNewPageIfNeeded();
   pdf.setFont('arial', 'normal');
   pdf.setFontSize(12);
   pdf.text('Tungkol sa aking', initialX, contentYPos);
   pdf.setFont('arialbd', 'bold');
   pdf.text('Pamilya.', initialX + 33, contentYPos);
   pdf.setFont('Arial', 'normal');
   pdf.text('(Ilan kaming magkakapatid at tungkol sa kanilang buhay o', initialX + 51, contentYPos);
   pdf.line(20, contentYPos + 1, 70, contentYPos + 1); // Underline
   contentYPos += 7;
   pdf.text('kaya trabaho; papa/mama at tungkol sa kanilang ikinabubuhay, tungkol sa pamilya at iba', initialX, contentYPos);
   contentYPos += 7;
   pdf.text('pa)', initialX, contentYPos);
  
   // Dynamic text with underline
   contentYPos += rowHeight;
   const text1 = `${this.form.about_my_family || ''}`;
   const wrappedText1 = pdf.splitTextToSize(text1, maxWidth);
   wrappedText1.forEach(line => {
     addNewPageIfNeeded(); // Add a new page if necessary
     pdf.text(line, initialX, contentYPos);
     const textWidth = pdf.getTextWidth(line);
     pdf.line(initialX, contentYPos + 1, initialX + textWidth, contentYPos + 1); // Underline
     contentYPos += lineHeight;
   });
  
   contentYPos += rowHeight;
    contentYPos += 10;
    addNewPageIfNeeded();
   pdf.setFont('arial', 'normal');
   pdf.text('Tungkol sa aking', initialX, contentYPos);
   pdf.setFont('arialbd', 'bold');
   pdf.text('Sarili.', initialX + 33, contentYPos);
   pdf.setFont('Arial', 'normal');
   pdf.text('(Karanasan mula pagkabata, mga napagtagumpayan, mga', initialX + 47, contentYPos);
   pdf.line(20, contentYPos + 1, 65, contentYPos + 1); // Underline
   contentYPos += 7;
   pdf.text('bisyo/pagkakamali, eskwela, interes at mga gustong gawin, sports, ambisyon, pangarap', initialX, contentYPos);
   contentYPos += 7;
   pdf.text('at iba pa)', initialX, contentYPos);
  
  
   contentYPos += rowHeight;
   const text2 = `${this.form.about_my_self || ''}`;
   const wrappedText2 = pdf.splitTextToSize(text2, maxWidth);
   wrappedText2.forEach(line => {
     addNewPageIfNeeded(); // Add a new page if necessary
     pdf.text(line, initialX, contentYPos);
     const textWidth = pdf.getTextWidth(line);
     pdf.line(initialX, contentYPos + 1, initialX + textWidth, contentYPos + 1); // Underline
     contentYPos += lineHeight;
   });
  
  
   contentYPos += rowHeight;
    contentYPos += 10;
    addNewPageIfNeeded();
   pdf.setLineWidth(0);
   pdf.setFont('arial', 'normal');
   pdf.setFontSize(12);
   pdf.text('Tungkol sa aking', initialX, contentYPos);
   pdf.setFont('arialbd', 'bold');
   pdf.text('Kaso.', initialX + 33, contentYPos);
   pdf.setFont('Arial', 'normal');
   pdf.text('(Ano at papaano nangyari, detalye ng pangyayari, ano ang rason', initialX + 46, contentYPos);
   pdf.line(20, contentYPos + 1, 64, contentYPos + 1); // Underline
   contentYPos += 7;
   pdf.text('at bakit nasangkot "Na-apil" sa kaso, sino-sino ang sangkot at iba pa)', initialX, contentYPos);
  
   // Dynamic text with underline for "Kaso"
   contentYPos += rowHeight;
   const text3 = `${this.form.about_my_case || ''}`;
   const wrappedText3 = pdf.splitTextToSize(text3, maxWidth);
   wrappedText3.forEach(line => {
     addNewPageIfNeeded(); // Add a new page if necessary
     pdf.text(line, initialX, contentYPos);
     const textWidth = pdf.getTextWidth(line);
     pdf.line(initialX, contentYPos + 1, initialX + textWidth, contentYPos + 1); // Underline
     contentYPos += lineHeight;
   });
  
  
  
   contentYPos += rowHeight;
    contentYPos += 15;
    addNewPageIfNeeded();
   pdf.setFontSize(13);
   pdf.setFont('arialbd', 'bold');
   pdf.text('Received & Assessed:', initialX, contentYPos);
   contentYPos += 20;
   pdf.setFont('arial', 'normal');
   pdf.setFontSize(11);
   pdf.text(`${this.talambuhay_case_manager || ''}`, initialX, contentYPos - 2);
   pdf.line(20, contentYPos, 100, contentYPos); // Underline for Case Manager
   contentYPos += 5;
   pdf.text('Case Manager', 20, contentYPos); // Label for Case Manager
  
   // Signature on the right
   contentYPos -= 5;
   initialX = 110;
   pdf.text(`${this.clientName || ''}`, initialX, contentYPos - 2);
   pdf.line(initialX, contentYPos, initialX + 80, contentYPos); // Underline for Client Signature
   contentYPos += 5;
   pdf.text('Pangalan ng Client at Pirma', initialX, contentYPos); // Label for Client Signature
  
   // Date Section
   contentYPos += 20;
   initialX = 20;
   pdf.text(`${this.form.date || ''}`, initialX, contentYPos - 2);
   pdf.line(20, contentYPos, 100, contentYPos); // Underline for Date
   contentYPos += 5;
   pdf.text('Petsa', 20, contentYPos); // Label for Date
  
   // Footer for Page 2
   addFooter();
  
   const totalPages = pdf.internal.getNumberOfPages();
      for (let i = 1; i <= totalPages; i++) {
        pdf.setPage(i);
        pdf.setFontSize(9);
        pdf.setFont('TimesNewRoman', 'bold');
        pdf.text(`PAGE ${i} of ${totalPages}`, 105, 333, { align: 'center' }); // Update the footer with the correct total pages
      }
   // Save the PDF
   pdf.save(`Talambuhay_${this.clientName || 'NoName'}.pdf`);
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
  </style>
  