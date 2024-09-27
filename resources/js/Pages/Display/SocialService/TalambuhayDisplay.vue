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

<div class="graph-background pt-0.5  -mr-9 -mb-16">
 <div class="p-8">
   <!-- Page 1 -->
   <div v-if="currentPage === 1" class="max-w-3xl mx-auto bg-white p-16 rounded-lg shadow-lg mb-10">
     <div class="flex items-center justify-between mb-4">
       <img src="/images/headerlogo2.png" alt="DSWD Logo" class="h-32 w-64 relative z-10">
       <div class="text-right">
         <p class="text-xs">DSPTD-QF-01-A | REV 01 | 12 SEP 2023</p>
       </div>
     </div>
     <h1 class="text-2xl font-bold text-center mb-2">CONFIDENTIAL</h1>
     <h2 class="text-xl text-center underline mb-6">TALAMBUHAY</h2>

     <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
       {{ message }}
     </div>
     <div class="mb-6">
 
       <p class=" mb-2"><u>Tungkol sa aking <span class="font-bold">Pamilya</span></u> (Ilan kaming magkakapatid at tungkol sa kanilang buhay o kaya trabaho; papa/mama at tungkol sa kanilang ikinabubuhay, tungkol sa pamilya at iba pa)</p>
       <textarea class="w-full mt-1 p-2 border border-gray-300 rounded-md" rows="10" v-model="form.about_my_family" :readonly="!editMode"></textarea>
     </div>

     <div class="mb-6">
       <p class="mb-2"><u>Tungkol sa aking <span class="font-bold">Sarili</span></u> (Karanasan mula pagkabata, mga napagtagumpayan, mga bisyo/pagkakamali, eskwela, interes at mga gustong gawin, sports, ambisyon, pangarap at iba pa)</p>
       <textarea class="w-full mt-1 p-2 border border-gray-300 rounded-md" rows="10" v-model="form.about_my_self" :readonly="!editMode"></textarea>
     </div>

     <div class="border-gray-300 ml-6 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
        <div class="flex justify-between items-center">
          <div class="flex flex-col">
            <p class="ml-24 -mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
            <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
            <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
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
       <p class="text-xs">DSPTD-QF-01-A | REV 01 | 12 SEP 2023</p>
     </div>

     <div class="mb-6 mt-12">
       <p class="mb-2"><u>Tungkol sa aking <span class="font-bold">kaso</span></u> (Ano at papaano nangyari, detalye ng pangyayari, ano ang rason at bakit nasangkot "Na-apil" sa kaso, sino-sino ang sangkot at iba pa)</p>
       <textarea class="w-full mt-1 p-2 border border-gray-300 rounded-md" rows="15" v-model="form.about_my_case" :readonly="!editMode"></textarea>
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
           >
          
         </div>
         <label class=" mb-2 -mt-12">Petsa:</label>
     <div class="border-gray-300 ml-6 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
        <div class="flex justify-between items-center">
          <div class="flex flex-col">
            <p class="ml-24 -mb-4 font-bold">PAGE 2 of {{ totalPages }}</p>
            <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
            <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
          </div>
          <div class="ml-4">
            <img src="/images/footerimg.png" alt="" class="h-12 w-24 object-cover rounded-md">
          </div>
        </div>
      </div>
   </div>
</div>

 </div>
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
       const clientResponse = await axios.get(`/api/clients/${clientId}`);
       const client = clientResponse.data;
       this.clientName = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
       this.form.client_id = client.id;

       const talambuhayResponse = await axios.get(`/api/talambuhay/${clientId}`);
       const talambuhay = talambuhayResponse.data;
       this.form.about_my_family = talambuhay.about_my_family || '';
       this.form.about_my_self = talambuhay.about_my_self || '';
       this.form.about_my_case = talambuhay.about_my_case || '';
       this.form.talambuhay_case_manager = talambuhay.talambuhay_case_manager || '';
       this.form.date = talambuhay.date || '';
     } catch (error) {
       this.errorMessage = 'Error fetching client data.';
       console.error('Error fetching client data:', error);
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
   async saveData() {
     if (!this.form.client_id) {
       this.message = 'Client ID is missing.';
       this.messageType = 'error';
       return;
     }

     try {
       const response = await axios[this.form.id ? 'put' : 'post'](`/api/talambuhay${this.form.id ? '/' + this.form.id : ''}`, this.form);
       this.saveResultTitle = 'Success';
       this.saveResultMessage = 'Data saved successfully!';
       this.errorMessage = '';

       if (!this.form.id) {
         this.form.id = response.data.id;
       }

       setTimeout(() => {
         this.message = '';
       }, 3000);
     } catch (error) {
       this.saveResultTitle = 'Error';
       this.saveResultMessage = 'Error saving data.';
       console.error('Error saving data:', error);
     } finally {
       this.isSaveResultModalOpen = true;
     }
   },
   closeSaveResultModal() {
     this.isSaveResultModalOpen = false;
     this.saveResultTitle = '';
     this.saveResultMessage = '';
   },
   updatePage(page) {
     this.currentPage = page;
   },
   exportToPdf() {
 const pdf = new jsPDF('p', 'mm', 'a4'); // Standard A4 size document
 const pageHeight = 297; // Total page height in mm
 const marginBottom = 30; // Bottom margin in mm
 const lineHeight = 7; // Space between lines
 const maxContentHeight = pageHeight - marginBottom; // Max height for content before adding a new page
 const maxWidth = 170; // Maximum width for text
 let contentYPos = 70; // Start Y position for content
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
     // Footer for Page 1
     pdf.setFontSize(9);
     pdf.setFont('TimesNewRoman', 'bold');
     pdf.setLineWidth(0.5);
     pdf.line(17, 282, 173, 282); // Footer line

     pdf.setFont('times', 'normal');
     const footerText = pdf.splitTextToSize('DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Prk. 7 Bago-Oshiro, Tugbok Dist., Davao City', 160);
     pdf.text(footerText, 95, 287, { align: 'center' });
     pdf.text('Email: rrcy.fo11@dswd.gov.ph    Tel. No.: 293-0306', 105, 292, { align: 'center' });

     const footerImgData = '/images/footerimg.png';
     pdf.addImage(footerImgData, 'PNG', 175, 275, 25, 12); // Footer image
   } else {
     // Footer for Page 2 and beyond
     pdf.setFontSize(8.5);
     pdf.setFont('TimesNewRoman', 'bold');

     pdf.setLineWidth(0.5);
     pdf.line(17, 282, 193, 282); // Footer line extending further

     pdf.setFont('times', 'bold');
     pdf.text('DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH', 105, 285, { align: 'center' });
   }
 };

 addHeader();

 const imgData = '/images/headerlogo2.png';
 pdf.addImage(imgData, 'PNG', 15, 10, 50, 30);

 // Add the title section
 pdf.setFont('arialbd', 'bold');
 pdf.setFontSize(20);
 pdf.text('CONFIDENTIAL', 105, 50, null, null, 'center');
 pdf.setFontSize(15);
 pdf.setFont('arial', 'normal');
 pdf.text('TALAMBUHAY', 105, 60, null, null, 'center');
 pdf.line(87, contentYPos + -9, 123, contentYPos + -9); // Underline

 // Reset contentYPos to start below the title
 contentYPos = 70;

 // Main content section for "Pamilya"
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
 contentYPos += 10;
 const text1 = `${this.form.about_my_family || ''}`;
 const wrappedText1 = pdf.splitTextToSize(text1, maxWidth);
 wrappedText1.forEach(line => {
   addNewPageIfNeeded(); // Add a new page if necessary
   pdf.text(line, initialX, contentYPos);
   const textWidth = pdf.getTextWidth(line);
   pdf.line(initialX, contentYPos + 1, initialX + textWidth, contentYPos + 1); // Underline
   contentYPos += lineHeight;
 });

 // Main content section for "Sarili"
 contentYPos += 70;
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

 // Dynamic text with underline for "Sarili"
 contentYPos += 10;
 const text2 = `${this.form.about_my_self || ''}`;
 const wrappedText2 = pdf.splitTextToSize(text2, maxWidth);
 wrappedText2.forEach(line => {
   addNewPageIfNeeded(); // Add a new page if necessary
   pdf.text(line, initialX, contentYPos);
   const textWidth = pdf.getTextWidth(line);
   pdf.line(initialX, contentYPos + 1, initialX + textWidth, contentYPos + 1); // Underline
   contentYPos += lineHeight;
 });

 // Footer for Page 1
 addFooter();

 // Add a new page for the next section
 pdf.addPage();
 addHeader(); // Add the header for the new page
 currentPage++; // Increment the page count
 contentYPos = 50; // Reset Y position

 // Main content section for "Kaso"
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
 contentYPos += 10;
 const text3 = `${this.form.about_my_case || ''}`;
 const wrappedText3 = pdf.splitTextToSize(text3, maxWidth);
 wrappedText3.forEach(line => {
   addNewPageIfNeeded(); // Add a new page if necessary
   pdf.text(line, initialX, contentYPos);
   const textWidth = pdf.getTextWidth(line);
   pdf.line(initialX, contentYPos + 1, initialX + textWidth, contentYPos + 1); // Underline
   contentYPos += lineHeight;
 });



 // Signature and Date Section
 contentYPos += 40;
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

 // Total pages
 const totalPages = pdf.internal.getNumberOfPages();
 for (let i = 1; i <= totalPages; i++) {
   pdf.setPage(i);
   pdf.setFontSize(9);
   pdf.setFont('TimesNewRoman', 'bold');
   pdf.text(`PAGE ${i} of ${totalPages}`, 105, 280, { align: 'center' }); // Add page number for each page
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
