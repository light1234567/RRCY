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
          <button @click="closeSaveResultModal" :class="saveResultTitle === 'Error' ? 'bg-red-600 hover:bg-red-500' : 'bg-blue-600 hover:bg-blue-500'" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">OK</button>
        </div>
      </div>
    </div>
    
    <form ref="DataPrivacyConsentForm" @submit.prevent="saveData">
    <div class="graph-background pt-0.5  -mr-9 -mb-16">
    <div v-if="currentPage === 1" class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
        <div class="flex items-center justify-between mb-4">
          <img src="/images/headerlogo2.png" alt="DSWD Logo" class="h-32 w-64 relative z-10">
          <div class="text-right">
            <p class="text-[12px] text-right -mt-10" style="font-family: 'Times New Roman', Times, serif; font-style: italic;">DSWD-GF-010A | REV 00 | 22 SEP 2023
  </p>
          </div>
        </div>
        <h1 class="text-2xl font-bold text-center mb-4">DATA PRIVACY CONSENT</h1>
        <div class="flex justify-end items-center mb-4">
          <label class="text-gray-700 mr-4">Date:</label>
       
          <input 
  type="date" 
  class="mt-1 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-1/5" 
  v-model="form.date" 
  :readonly="!editMode" 
  :max="new Date().toISOString().split('T')[0]"  
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


        </div>
        <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
          {{ message }}
        </div>
        <div class="mb-6">
          <p>To Whom It May Concern:</p>
          <p class="mt-4 text-justify">
            I, <span class="font-bold underline">{{ clientName }}</span>, give my consent for the information concerning my file to be furnished by the DSWD-Regional Rehabilitation Center for Youth (RRCY) and/or its authorized personnel to Philippine courts, concerned local government units, and legal professionals. I request that any relevant information that may be required for purposes enumerated hereunder be provided in accordance with the provisions of the Data Privacy Act of 2012:
          </p>
          <ol class="list-decimal ml-6 mt-4 text-justify">
            <li>To assist in responding to Criminal Cases (Court, Lawyer, Prosecutor)</li>
            <li>To report to the PNP any untoward incident by the resident</li>
            <li>To request reports from the concerned LGUs e.g. Parenting Capability Assessment Report (PCAR), Transfer Summary Report and LGU Claims</li>
            <li>To assist in responding to the health needs (medical, psychological), school requirements and training agencies (LTO, TESDA, etc)</li>
            <li>To assist in the provision of financial assistance intended for basic needs, travel expenses, and medical needs</li>
            <li>To submit monthly, quarterly, semestral and annual reports to the Field Office and Central Office</li>
          </ol>
          <p class="mt-4 text-justify">
            I understand and accept that this will include access to personal data and records submitted, which may be considered sensitive personal data as provided for under Republic Act No. 10173, otherwise known as the Data Privacy Act of 2012.
          </p>
          <p class="mt-4 text-justify">
            Further, any records and related information associated with my case shall be kept from any and all public disclosure and shall be retained only for as long as necessary for the fulfillment of the purposes above-stated.
          </p>
          <p class="mt-4 text-justify">
            I understand and agree that this consent will remain valid and in force until I revoke it in writing.
          </p>
        </div>
        <div class="flex justify-between items-center mt-8">
          <div>
          <input 
            type="text" 
            class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" 
            v-model="clientName" 
            readonly
          >
          <label class="block text-gray-700">Name and signature (Client):</label>
        </div>
  
         
        </div>
        <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
        <div class="flex justify-between items-center">
          <div class="flex flex-col">
            <p class="ml-24 -mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
            <p class="border-t text-[11.5px] -ml-7 mt-4 whitespace-nowrap" style="border-top: 2px solid black;">
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
  
      <!-- Page 2 -->
      <div v-if="currentPage === 2" class="max-w-3xl p-10 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
        <div class="text-right mb-4">
          <p class="text-xs">DSPTD-QF-01-A | REV 01 | 12 SEP 2023</p>
        </div>
        <div class="mt-24 mb-6">
          <input 
            type="text" 
            class="mt-1 w-1/3 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" 
            v-model="form.guardian_signature" 
            :readonly="!editMode"
            @input="form.guardian_signature = removeNumbers(form.guardian_signature)"
          >
          <label class="block  text-gray-700 mb-2">Name and signature (Parent/Guardian):</label>
        </div>
        <div class="mt-[700px] border-gray-300 ml-6 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
    <div class="flex justify-between items-center">
      
      <!-- Left Section: Page number -->
      <div class="flex flex-col flex-grow">
        <!-- Page number centered -->
        <p class="text-center -mb-1 font-bold">PAGE 2 of {{ totalPages }}</p>
  
      <!-- Continuous horizontal line, moved to the left with space on the right -->
      <div style="border-top: 2px solid black; width: 110%; margin-top: 4px; margin-left: -44px;"></div>
  
  
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
  import { jsPDF } from 'jspdf';
  import '../../../fonts/arial-normal.js'; 
  import '../../../fonts/times-normal.js'; 
  import '../../../fonts/arialbd-bold.js'; 
  
  
  export default {
   components: {
     Pagination,
   },
   data() {
     return {
       editMode: false,
       message: '',
       messageType: '',
       form: {
         client_id: null,
         date: '',
         guardian_signature: '',
         id: null,
       },
       clientName: '',
       errorMessage: '',
       isModalOpen: false,
       isSaveResultModalOpen: false,
       saveResultTitle: '',
       saveResultMessage: '',
       totalPages: 2,
       currentPage: 1,
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
         const clientResponse = await axios.get(`/api/clients/${clientId}`);
         const client = clientResponse.data;
         this.clientName = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
         this.form.client_id = client.id;
  
         const consentResponse = await axios.get(`/api/data-privacy-consent/client/${clientId}`);

         const consent = consentResponse.data;
         this.form.date = consent.date || '';
         this.form.guardian_signature = consent.guardian_signature || '';
         this.form.id = consent.id;
       } catch (error) {
         this.errorMessage = 'Error fetching client data.';
         console.error('Error fetching client data:', error);
       }
     },
     toggleEdit() {
       if (this.editMode) {
         this.openModal();
       } else {
         this.editMode = true;
       }
     },
     async saveData() {
  // Total number of pages
  const totalPages = this.totalPages;  // Ensure this is set correctly based on your pagination logic
  let allFieldsValid = true;

  // Loop through each page to check validity
  for (let i = 1; i <= totalPages; i++) {
    // Set the current page to the one we are validating
    this.currentPage = i;
    
    // Ensure the view updates before validation
    await this.$nextTick();

    // Get the form ref for the current page
    const form = this.$refs.DataPrivacyConsentForm;  // Make sure this ref matches your template

    // Check if the current page's form is valid
    if (!form.checkValidity()) {
      allFieldsValid = false;
      form.reportValidity(); // Show validation messages and focus on invalid fields
      break; // Stop checking further pages if the current page is invalid
    }
  }

  // If all fields across all pages are valid, open the confirmation modal
  if (allFieldsValid) {
    this.isModalOpen = true;  // Open the confirmation modal
  } else {
    console.warn('Form has invalid fields, please correct them.');
    return;  // Exit if form is invalid
  }
},


  openModal() {
    // Ensure the modal is shown
    this.isModalOpen = true;
  },

  async confirmSave() {
    // Proceed with saving the data only after confirmation from the modal
    if (!this.form.client_id) {
      this.message = 'Client ID is missing.';
      this.messageType = 'error';
      setTimeout(() => {
        this.message = '';
      }, 3000);
      return;
    }

    try {
      const response = await axios({
        method: this.form.id ? 'put' : 'post',
        url: `/api/data-privacy-consent${this.form.id ? '/' + this.form.id : ''}`,
        data: this.form,
      });

      this.saveResultTitle = 'Success';
      this.saveResultMessage = 'Data saved successfully!';

      if (!this.form.id) {
        this.form.id = response.data.id;
      }

      this.editMode = false;
    } catch (error) {
      this.saveResultTitle = 'Error';
      this.saveResultMessage = 'Error saving data.';
      console.error('Error saving data:', error);
    } finally {
      this.closeModal();
      this.isSaveResultModalOpen = true;
    }
  },

  closeModal() {
    this.isModalOpen = false;
  },

  closeSaveResultModal() {
    this.isSaveResultModalOpen = false;
    this.saveResultTitle = '';
    this.saveResultMessage = '';
  },

  cancelEdit() {
    this.editMode = false;
  },

  updatePage(page) {
    this.currentPage = page;
  },

  // Method to remove numbers from input
  removeNumbers(input) {
    return input.replace(/[0-9]/g, '');
  },
     exportToPdf() {
    const pdf = new jsPDF('p', 'mm', 'legal'); // Change to legal size (216x356 mm)
  
    // Convert your image to Base64 or ensure it's a valid URL
    const imgData = '/images/headerlogo2.png'; // Ensure this is correct or use Base64 image
    pdf.addImage(imgData, 'PNG', 15, 10, 50, 30); // DSWD logo
  
    // Header
    pdf.setFontSize(9);
    pdf.setFont('TimesNewRoman', 'italic'); // Set font style to italic
    pdf.text('DSWD-GF-010A | REV 00 | 22 SEP 2023', 135, 20);
  
    pdf.setFont('arialbd', 'bold');
    pdf.setFontSize(20);
    pdf.setTextColor(0, 0, 0); // Black text for title
    pdf.text('DATA PRIVACY CONSENT', 105, 48, null, null, 'center'); // Centered title
  
    // Main Content: Adjust positioning and apply bold/underline styles
    let contentYPos = 55; // Start below the title
  
    let initialX = 20;  // Adjust this value to shift the text further right as needed
    const maxWidth = 170;
   
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(12);
    contentYPos += 7; 
    pdf.text('Date : ', initialX+130, contentYPos);
    pdf.setFontSize(10);
    pdf.text(`${this.form.date || ''}`, initialX+145, contentYPos);
    pdf.line(164, contentYPos+2, 190, contentYPos+2); // Underline first (left aligned)
  
    contentYPos += 11;
    pdf.setFontSize(13);
    pdf.setFont('arial', 'normal');
    pdf.text('To Whom It May Concern:', initialX, contentYPos);
  
    pdf.setFontSize(13);
    pdf.setFont('arial', 'normal');
  
    const clientName = this.clientName;
    const text1 = 'I, ' + clientName + ', give my consent for the information concerning my file to be furnished by the DSWD-Regional Rehabilitation Center for Youth (RRCY) and/or its authorized personnel to Philippine courts, concerned local government units, and legal professionals. I request that any relevant information that may be required for purposes enumerated hereunder be provided in accordance with the provisions of the Data Privacy Act of 2012:';
  
    function justifyText(text, maxWidth, initialX, yPos, pdf) {
      const lines = pdf.splitTextToSize(text, maxWidth);
      lines.forEach((line, lineIndex) => {
        const words = line.split(' ');
        if (words.length > 1 && lineIndex < lines.length - 1) {
          const totalWordsWidth = words.reduce((total, word) => total + pdf.getTextWidth(word), 0);
          const totalSpaceWidth = maxWidth - totalWordsWidth;
          const spaceWidth = totalSpaceWidth / (words.length - 1);
  
          let x = initialX;
          words.forEach((word, index) => {
            pdf.text(word, x, yPos);
            x += pdf.getTextWidth(word) + spaceWidth;  // Add space between words
          });
        } else {
          // For the last line or single-word lines, print as is (no extra spaces)
          pdf.text(line, initialX, yPos);
        }
        yPos += 6; // Move to the next line
      });
    }
  
    contentYPos += 10;
    // Justify the first text
    justifyText(text1, maxWidth, initialX, contentYPos, pdf);
  
    contentYPos += 45; 
    pdf.text('1. To assist in responding to Criminal Cases (Court, Lawyer, Prosecutor)', initialX+3, contentYPos);
    contentYPos += 7; 
    pdf.text('2. To report to the PNP any untoward incident by the resident)', initialX+3, contentYPos);
    contentYPos += 7; 
    pdf.text('3. To request reports from the concerned LGUs e.g. Parenting Capability ', initialX+3, contentYPos);
    contentYPos += 7; 
    pdf.text('Assessment Report (PCAR), Transfer Summary Report and LGU Claims)', initialX+8, contentYPos);
    contentYPos += 7; 
    pdf.text('4. To assist in responding to the health needs (medical, psychological), school', initialX+3, contentYPos);
    contentYPos += 7; 
    pdf.text('Rrequirements and training agencies (LTO, TESDA, etc)', initialX+8, contentYPos);
    contentYPos += 7; 
    pdf.text('5. To assist in the provision of financial assistance intended for basic needs, travel', initialX+3, contentYPos);
    contentYPos += 7; 
    pdf.text('expenses, and medical needs', initialX+8, contentYPos);
    contentYPos += 7; 
    pdf.text('6. To submit monthly, quarterly, semestral and annual reports to the Field Office', initialX+3, contentYPos);
    contentYPos += 7; 
    pdf.text('and Central Office', initialX+8, contentYPos);
  
    pdf.setFontSize(13);
    pdf.setFont('arial', 'normal');
  
    contentYPos += 15;
    const text2 = 'I understand and accept that this will include access to personal data and records submitted, which may be considered sensitive personal data as provided for under Republic Act No. 10173, otherwise known as the Data Privacy Act of 2012.';
    justifyText(text2, maxWidth, initialX, contentYPos, pdf);
  
    contentYPos += 25;
    const text3 = 'Further, any records and related information associated with my case shall be kept from any and all public disclosure and shall be retained only for as long as necessary for the fulfillment of the purposes above-stated.';
    justifyText(text3, maxWidth, initialX, contentYPos, pdf);
  
    contentYPos += 25;
    const text4 = 'I understand and agree that this consent will remain valid and in force until I revoke it in writing.';
    justifyText(text4, maxWidth, initialX, contentYPos, pdf);
  
    pdf.setFontSize(12);
    pdf.setFont('arial', 'normal');
    contentYPos += 40;
    pdf.text(`${this.clientName || ''}`, initialX, contentYPos+-2);
    pdf.line(20, contentYPos, 100, contentYPos); // Underline first (left aligned)
    contentYPos += 5; // Move Y position down for the text
    pdf.text('Name and signature (Client):', 20, contentYPos); // Label below the underline
  
    // Footer Section for Page 1
     // Footer Section - Adjusted Y positions for legal size
  pdf.setFontSize(9);
  pdf.setFont('TimesNewRoman', 'bold');
  pdf.text('PAGE 1 of 2', 105, 330, null, null, 'center'); // Adjusted Y position for legal size
  pdf.setLineWidth(0.5); // Set line width to make it bolder (default is 0.200)
  pdf.line(17, 332, 200, 332); // Footer line adjusted for legal size
  pdf.setFont('times', 'normal');
  const footerText = pdf.splitTextToSize('DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Prk. 7 Bago-Oshiro, Tugbok Dist., Davao City', 160); // Adjust width limit (160mm)
  pdf.text(footerText, 96, 337, null, null, 'center');
  // Display email and telephone number in one line
  pdf.setTextColor(0, 0, 255);
  pdf.text('Email: rrcy.fo11@dswd.gov.ph', 73, 342);
  // Reset text color to black and add Tel. No. on the same line
  pdf.setTextColor(0, 0, 0);
  pdf.text('Tel. No.: 293-0306', 114, 342);
  
  const footerImgData = '/images/footerimg.png'; // Make sure the image is correctly loaded
  pdf.addImage(footerImgData, 'PNG', 175, 330, 25, 12); // Adjust the position and size
  
  
  
    // Add a new page for Page 2 content
    pdf.addPage();
  
    pdf.setFont('TimesNewRoman', 'italic');
    pdf.text('DSWD-GF-010A | REV 00 | 22 SEP 2023', 135, 20);
  
    contentYPos = 10; // Reset Y position for the new page
    pdf.setFontSize(12);
    pdf.setFont('arial', 'normal');
   
  
    contentYPos += 30; 
    pdf.text(`${this.form.guardian_signature || ''}`, initialX, contentYPos+-2);
    pdf.line(20, contentYPos, 100, contentYPos); // Underline first (left aligned)
    contentYPos += 5; // Move Y position down for the text
    pdf.text('Name and signature (Parent/Guardian):', 20, contentYPos); // Label below the underline
  
    // Footer Section for Page 2
    pdf.setFontSize(8.5);
    pdf.setFont('TimesNewRoman', 'bold');
  
    // Footer page number
    pdf.text('PAGE 2 of 2', 105, 330, null, null, 'center');
  
    // Footer line
    pdf.setLineWidth(0.5);
    pdf.line(17, 332, 200, 332);
  
    // Single-line footer text without splitting
    pdf.text('DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH', 105, 335, null, null, 'center');
  
    // Save the PDF
    pdf.save('DataPrivacyConsent_Legal.pdf');
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
  </style>