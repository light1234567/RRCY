<template>
  <div>
    <!-- Tabs for Actions -->
    <div v-if="editMode" class="flex absolute p-6 -mt-2 space-x-4">
      <button @click="cancelEdit" class="flex space-x-2 px-3 py-1 bg-customBlue text-white rounded-md text-xs">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Back</span>
      </button>
    </div>

    <div class="flex justify-end bg-transparent border border-gray-300 p-4 rounded-md space-x-4 mt-4">
      <!-- Pagination Component -->
      <Pagination :totalPages="totalPages" :currentPage="currentPage" @update:currentPage="currentPage = $event" />
      <button @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.3 2.7a1 1 0 011.4 0l1.3 1.3a1 1 0 010 1.4l-9.4 9.4a1 1 0 01-.6.3l-2.8.6a1 1 0 01-1.2-1.2l.6-2.8a1 1 0 01.3-.6l9.4-9.4z" />
        </svg>
        <span>Edit</span>
      </button>

      <button v-if="editMode" @click="openModal" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span>Save</span>
      </button>

      <!-- Export to PDF Button -->
      <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 text-white rounded-md text-xs">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Export to PDF</span>
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
          <button @click="confirmSave" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
            Save
          </button>
          <button @click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
            Cancel
          </button>
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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
  
     <!-- Form Content -->
  
    <div ref="pdfContent" class="p-6 border border-gray-400 shadow-xs rounded-lg max-w-3xl mx-auto my-8 ">
      <div class=" relative flex justify-between items-center mb-2">
        <img src="/images/headerlogo2.png" alt="Logo" class="ml-4 h-32 w-64 relative z-10">
        <p class="text-[10.7px] mb-10 font mr-6" style="font-family: 'Times New Roman', Times, serif; font-style: italic;">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>

      </div>

      <h1 class="text-[21.33px] font-bold mb-2 text-center text-black">ADMISSION SLIP</h1>

      <div v-if="clients.length > 0" v-for="client in clients" :key="client.id" class="mb-12 p-6 rounded-lg text-xs">
        <div class="flex items-center">
          <div class="flex-grow text-[15px] flex items-center mr-2">
            <label class="mb-3  text-black   mr-2 flex items-center h-full">Name:</label>
            <input type="text" class="underline-input  w-full" :value="client.first_name + ' ' + client.middle_name + ' ' + client.last_name" :readonly="!editMode">
          </div>
          <div class="flex text-[15px]  items-center w-1/4">
            <label class="mb-3   text-black mr-2 flex items-center h-full p-0">Sex:</label>
            <input type="text" class="underline-input bg-transparent mt-1 w-full" :value="client.sex" :readonly="!editMode">
          </div>
          <div class="flex text-[15px] items-center w-1/4">
            <label class="mb-3 block ml-2    text-black mr-2">Religion:</label>
            <input type="text" class="underline-input bg-transparent mt-1 w-full mb-6 " :value="client.religion" :readonly="!editMode">
          </div>  
        </div>

        <div class="flex items-center">
          <div class="flex-grow flex text-[15px] items-center mr-2">
            <label class="mb-3 block     text-black mr-2">Address:</label>
            <input type="text" class="underline-input bg-transparent w-full mb-24" :value="client.province + ', ' + client.city + ', ' + client.barangay + ', ' + client.street" :readonly="!editMode">
          </div>
        </div>

        <div class="text-[15px] flex items-center">
          <label class="mb-3 block    text-black mr-2 whitespace-nowrap">Date/Place of Birth:</label>
          <input type="text" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs" :value="client.date_of_birth + ' / ' + client.place_of_birth" :readonly="!editMode">
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div class="flex items-center text-[15px] ">
              <label class="mb-3    text-black mr-2 whitespace-nowrap">Committing Court:</label>
              <input type="text" class="underline-input bg-transparent text-xs w-full" :value="client.admissions[0]?.committing_court" :readonly="!editMode">
          </div>
          <div class="text-[15px] flex items-center">
            <label class="mb-3 block    text-black ml-2  mr-2 whitespace-nowrap">Crim. Case #:</label>
            <input type="text" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs" :value="client.admissions[0]?.crim_case_number" :readonly="!editMode">
          </div>
        </div>

        <div class="flex items-center">
        <!-- Offense Committed Section -->
        <div class="text-[15px] flex items-center w-1/2">
          <label class="mb-3    text-black mr-2 whitespace-nowrap">Offense Committed:</label>
          <input type="text" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs" :value="client.admissions[0]?.offense_committed" :readonly="!editMode">
        </div>

        <!-- Date Admitted Section -->
        <div class="text-[15px] flex items-center w-1/2">
          <label class="mb-3    text-black mr-2 whitespace-nowrap ml-4">Date admitted to Center:</label>
          <input type="text" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs" :value="client.admissions[0]?.date_admitted" :readonly="!editMode">
        </div>
      </div>

        <div class="flex items-center">
          <div class="flex items-center text-[15px] w-1/2">
            <label class="mb-3 block    text-black whitespace-nowrap mr-2">No. of Days in Jail:</label>
            <input type="text" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs" :value="client.admissions[0]?.days_in_jail" :readonly="!editMode">
          </div>
          <div class="flex items-center text-[15px] w-1/2">
            <label class="mb-3 block    text-black ml-4 whitespace-nowrap mr-2">No. of Days in Detention Center:</label>
            <input type="text" class="underline-input w-1/4 bg-transparent mt-1  mb-6 flex-grow text-xs" :value="client.admissions[0]?.days_in_detention_center" :readonly="!editMode">
          </div>
        </div>
        <div class="mb-2">
          <label class="mt-2 text-[15px] mb-4 block font-bold text-black">DISTINGUISHING MARKS:</label>
          <div class="flex flex-wrap items-center gap-x-8">
            <!-- Tattoo/Scars -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3 block    text-black mr-2">a. Tattoo/Scars:</label>
              <input type="text" class="underline-input1 bg-transparent flex-grow text-xs w-[100px]" :value="client.admissions[0]?.distinguishing_marks[0]?.tattoo_scars" :readonly="!editMode">
            </div>

            <!-- Height -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3 block    text-black mr-2">b. Height:</label>
              <input type="text" class="underline-input1 bg-transparent flex-grow text-xs w-[100px]" :value="client.admissions[0]?.distinguishing_marks[0]?.height" :readonly="!editMode">
            </div>

            <!-- Weight -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3 block    text-black mr-2">c. Weight:</label>
              <input type="text" class="underline-input1 bg-transparent flex-grow text-xs w-[100px]" :value="client.admissions[0]?.distinguishing_marks[0]?.weight" :readonly="!editMode">
            </div>

            <!-- Colour of Eye -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3    text-black mr-2">d. Colour of Eye:</label>
              <input type="text" class="underline-input1 bg-transparent flex-grow text-xs w-[100px]" :value="client.admissions[0]?.distinguishing_marks[0]?.colour_of_eye" :readonly="!editMode">
            </div>

            <!-- Skin -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3    text-black mr-2">e. Skin:</label>
              <input type="text" class="underline-input1 bg-transparent flex-grow text-xs w-[100px]" :value="client.admissions[0]?.distinguishing_marks[0]?.skin_colour" :readonly="!editMode">
            </div>
          </div>
        </div>


        <div class="mb-4">
  <label class="text-[15px] block mb-2 font-semibold text-black">Put on Documents Submitted:</label>
  <div class="pl-4">
    <!-- Checklist with 3 columns -->
    <div class="text-[15px] grid grid-cols-3 gap-x-10 gap-y-2">
      <label class="block font-semibold text-gray-700">
        <input type="checkbox" class="mr-2" :checked="isDocumentSubmitted(client, 'SCSR')" disabled> SCSR
      </label>
      <label class="block font-semibold text-gray-700">
        <input type="checkbox" class="mr-2" :checked="isDocumentSubmitted(client, 'Court Order')" disabled> Court Order
      </label>
      <label class="block font-semibold text-gray-700">
        <input type="checkbox" class="mr-2" :checked="isDocumentSubmitted(client, 'Medical Certificates')" disabled> Medical Certificates
      </label>
      <label class="block font-semibold text-gray-700">
        <input type="checkbox" class="mr-2" :checked="isDocumentSubmitted(client, 'Consent from Parents')" disabled> Consent from Parents
      </label>
      <label class="block font-semibold text-gray-700">
        <input type="checkbox" class="mr-2" :checked="isDocumentSubmitted(client, 'School Records')" disabled> School Records
      </label>
      <label class="block font-semibold text-gray-700 flex items-center">
        <input type="checkbox" class="mr-2" :checked="isDocumentSubmitted(client, 'Others')" disabled> Others
        <span v-if="getOtherDocumentName(client)" class="ml-2">
          ({{ getOtherDocumentName(client) }})
        </span>
      </label>
    </div>
  </div>
</div>



<div class="text-[15px] mb-4">
  <label class="block font-semibold mb-2 text-black">General impression upon admission:</label>
  <textarea 
    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-[15px] leading-relaxed" 
    style="line-height: 1.5;" 
    :value="client.admissions[0]?.general_impression" 
    :readonly="!editMode">
  </textarea>
</div>

<div class="text-[15px] mb-4">
  <label class="block font-semibold mb-2 text-black">Action Taken:</label>
  <textarea 
    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-[15px] leading-relaxed" 
    style="line-height: 1.5;" 
    :value="client.admissions[0]?.action_taken" 
    :readonly="!editMode">
  </textarea>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">

          
  <!-- Referring Party Section -->
  <div class="flex flex-col justify-end mb-4">
  <div v-if="client.admissions[0]?.referring_party_signature">
    <img
      :src="'/storage/' + client.admissions[0]?.referring_party_signature"
      alt="Referring Party Signature"
      class="h-24 w-auto mb-2"
    />
  </div>
  <input 
    type="text" 
    class="underline-input mt-1 w-full text-[15px]" 
    :value="client.admissions[0]?.referring_party_name" 
    :readonly="!editMode"
  >
  <label class="block font-semibold text-gray-700 mt-2">Name & Signature of Referring Party</label>
</div>


  <!-- Admitting Officer Section -->
  <div class="flex flex-col justify-end mb-4">
  <input 
    type="text" 
    class="underline-input mt-1 w-full text-[15px]" 
    :value="client.admissions[0]?.admitting_officer" 
    :readonly="!editMode"
  >
  <label class="block font-semibold text-gray-700 mt-2">Admitting Officer</label>
</div>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
  <div>
    <input 
      type="text" 
      class="underline-input mt-1 w-full text-[15px]" 
      :value="client.admissions[0]?.designation_id_contact" 
      :readonly="!editMode"
    >
    <label class="block font-semibold text-gray-700 mt-2">Designation / ID No. / Contact #</label>
  </div>
  <div>
    <input 
      type="text" 
      class="underline-input mt-1 w-full text-[15px]" 
      :value="client.admissions[0]?.designation" 
      :readonly="!editMode"
    >
    <label class="block font-semibold text-gray-700 mt-2">Designation</label>
  </div>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
  <div>
    <input 
      type="text" 
      class="underline-input mt-1 w-full text-[15px]" 
      :value="client.admissions[0]?.office_address" 
      :readonly="!editMode"
    >
    <label class="block font-semibold text-gray-700 mt-2">Complete Address/Office Address</label>
  </div>
  <div>
    <input 
      type="text" 
      class="underline-input mt-1 w-full text-[15px]" 
      :value="formatDateTime(client.admissions[0]?.date_time)" 
      :readonly="!editMode"
    >
    <label class="block font-semibold text-gray-700 mt-2">Date/Time</label>
  </div>
</div>

<!-- Noted By Section -->
<div class="border-gray-300 pt-4 text-center text-xs">
  <p class="font-semibold mb-4 text-[12px]">Noted By:</p>
  <input 
    v-if="client.admissions[0]" 
    type="text" 
    class="underline-input mt-1 text-center text-[12px] font-bold"
    v-model="client.admissions[0].noted_by" 
    :readonly="!editMode"
    style="width: 200px;" 
  />
  <p class="text-xs">Center Head/SWO IV</p>
</div>


      </div>
      <div v-else>
        <p>Loading data...</p>
      </div>

      <div class="border-gray-300 ml-6 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
        <div class="flex justify-between items-center">
          <div class="flex flex-col">
            <p class="ml-24 -mb-2 font-bold">PAGE 1 of 1</p>
            <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
            <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrcy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
          </div>
          <div class="ml-4">
            <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { jsPDF } from 'jspdf';
import '../../../fonts/arial-normal.js'; 
import '../../../fonts/times-normal.js'; 

export default {  
  name: 'ClientList',
  data() {
    return {
      clients: [],
      editMode: false,
      isModalOpen: false,
      isSaveResultModalOpen: false,
      saveResultTitle: '',
      saveResultMessage: '',
      id: null,
      totalPages: 1,
      currentPage: 1,
    };
  },
  mounted() {
    this.id = this.$route.params.id;
    this.fetchClientsData();
  },
  watch: {
    '$route.params.id': function(newId) {
      this.id = newId;
      this.fetchClientsData();
    },
  },
  methods: {
    // Toggle between edit and view modes
    toggleEdit() {
      this.editMode = !this.editMode;
    },

    cancelEdit() {
      this.editMode = false;
    },

    openModal() {
      this.isModalOpen = true;
    },

    closeModal() {
      this.isModalOpen = false;
    },

    confirmSave() {
      this.saveForm();
      this.closeModal();
      this.editMode = false;
    },

    closeSaveResultModal() {
      this.isSaveResultModalOpen = false;
    },

    formatDateTime(dateTime) {
      if (!dateTime) return '';
      const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
      return new Date(dateTime).toLocaleDateString('en-US', options);
    },

// Check if a document has been submitted
isDocumentSubmitted(client, documentName) {
      const documents = client.admissions[0]?.documents[0]?.document_name.split(', ');
      if (!documents) return false;

      // Check if the document exists in the list
      return documents.includes(documentName);
    },

    // Get the specific "Others" document name
    getOtherDocumentName(client) {
      const documents = client.admissions[0]?.documents[0]?.document_name.split(', ');
      if (!documents) return null;

      // Find the "Others" document and return the name if available
      const othersIndex = documents.indexOf('Others');
      if (othersIndex === -1 && documents.length > othersIndex + 1) {
        return documents[documents.length - 1]; // Return the last item if it's "Others"
      }

      return null; // No "Others" document found
    },

    // Save form data
    async saveForm() {
   try {
      const response = await axios.post('/api/save-admission', { clients: this.clients });
      this.showSaveResultModal('Success', 'Form saved successfully.');
      this.editMode = false;
   } catch (error) {
      if (error.response && error.response.status === 422) {
         // Log detailed validation errors from the server
         console.error('Validation error:', error.response.data.errors);
      }
      this.showSaveResultModal('Error', 'Error saving the form.');
      console.error('Error saving form:', error);
   }
}

,

    showSaveResultModal(title, message) {
      this.saveResultTitle = title;
      this.saveResultMessage = message;
      this.isSaveResultModalOpen = true;
    },

    async fetchClientsData() {
      try {
        const response = await axios.get(`/api/clients-data/${this.id}`);
        this.clients = response.data.filter(
          (client) => client.id === parseInt(this.id)
        );
        console.log(this.clients); // Check if data is being fetched correctly
      } catch (error) {
        console.error('Error fetching client data:', error);
      }
    },

  async exportToPdf() {
  const pdf = new jsPDF('p', 'mm', [216, 356]); // Legal size: 216mm x 356mm

  // Add and set Times New Roman font
  pdf.addFont('times-normal.ttf', 'TimesNewRoman', 'italic'); // Loads the Times New Roman italic font
  pdf.setFont('TimesNewRoman', 'italic'); // Sets Times New Roman as the italic font

  // Set default font properties
  pdf.setFontSize(11);
  pdf.setLineHeightFactor(1.5);

  const imgData = '/images/headerlogo2.png'; // Ensure this is accessible or use base64
  pdf.addImage(imgData, 'PNG', 15, 10, 75, 35); // Adjust the size as needed

  // Add the header below the image
  pdf.setFontSize(8); 
  pdf.setFont('italic'); // Set font to italic
  pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 152, 24);

  // Load and set Arial font
  pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
  pdf.setFont('Arial', 'normal'); // Set Arial as the default font  
  pdf.setFontSize(18);

  
  pdf.setTextColor(0, 0, 0); // RGB values for black

  // Mimic bold by drawing the text multiple times with slight offsets
  pdf.text('ADMISSION SLIP', 108, 60, null, null, 'center'); // First pass
  pdf.text('ADMISSION SLIP', 108.2, 60, null, null, 'center'); // Slight offset
  pdf.text('ADMISSION SLIP', 107.8, 60, null, null, 'center'); // Slight offset



  pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
  pdf.setFont('Arial', 'normal'); // Set Arial as the default font
  pdf.setFontSize(11); // Reset font size to 12 for content

  // Loop through clients and add their data
  this.clients.forEach((client, index) => {
    const offset = index * 160 + 80; // Adjust offset for each client's data

    // Add client details with margins and underline
    pdf.text(`Name:`, 20, offset);
    pdf.text(`${client.first_name} ${client.middle_name} ${client.last_name}`, 35, offset);
    pdf.line(35, offset + 1, 95, offset + 1); // Draw underline from start to end of data

    pdf.text(`Sex:`, 100, offset);
    pdf.text(`${client.sex}`, 110, offset);
    pdf.line(110, offset + 1, 140, offset + 1); // Draw underline for sex

    pdf.text(`Religion:`, 145, offset  );
    pdf.text(`${client.religion}`, 162, offset );
    pdf.line(162, offset + 1, 200, offset + 1); // Draw underline for religion

    pdf.text(`Address:`, 20, offset + 10);
    pdf.text(`${client.province}, ${client.city}, ${client.barangay}, ${client.street}`, 40, offset + 10);
    pdf.line(40, offset + 11, 200, offset + 11); // Draw underline for address

    pdf.text(`Date/Place of Birth:`, 20, offset + 20);
    pdf.text(`${client.date_of_birth} / ${client.place_of_birth}`, 58, offset + 20);
    pdf.line(58, offset + 21, 200, offset + 21); // Draw underline for birth details

   
    pdf.text(`Committing Court:`, 20, offset + 30);
    pdf.text(`${client.admissions[0]?.committing_court}`, 56, offset + 30);
    pdf.line(56, offset + 31, 110, offset + 31); // Draw underline for committing court

    pdf.text(`Crim. Case #:`, 115, offset + 30);
    pdf.text(`${client.admissions[0]?.crim_case_number}`, 143, offset + 30);
    pdf.line(143, offset + 31, 200, offset + 31); // Draw underline for criminal case number

    pdf.text(`Offense Committed:`, 20, offset + 40);
    pdf.text(`${client.admissions[0]?.offense_committed}`, 58, offset + 40);
    pdf.line(58, offset + 41, 110, offset + 41); // Draw underline for offense

    pdf.text(`Date admitted to Center:`, 115, offset + 40);
    pdf.text(`${client.admissions[0]?.date_admitted}`, 160, offset + 40);
    pdf.line(160, offset + 41, 200, offset + 41); // Draw underline for date admitted

    pdf.text(`No. of Days in Jail:`, 20, offset + 50);
    pdf.text(`${client.admissions[0]?.days_in_jail}`, 57, offset + 50);
    pdf.line(57, offset + 51, 110, offset + 51); // Draw underline for days in jail

    pdf.text(`No. of Days in Detention Center:`, 115, offset + 50);
    pdf.text(`${client.admissions[0]?.days_in_detention_center}`, 175, offset + 50);
    pdf.line(175, offset + 51, 200, offset + 51); // Draw underline for days in detention center

    pdf.setFont('helvetica', 'bold'); // Set font to Arial and make it bold
    pdf.text(`Distinguishing Marks:`, 20, offset + 60);
    pdf.setFont('helvetica', 'normal'); // Reset font to normal for the following text


    pdf.text(`a. Tattoo/Scars:`, 20, offset + 70);
    pdf.text(`${client.admissions[0]?.distinguishing_marks[0]?.tattoo_scars}`, 51, offset + 70);
    pdf.line(51, offset + 71, 110, offset + 71); // Draw underline for tattoo/scars

    pdf.text(`b. Height:`, 115, offset + 70);
    pdf.text(`${client.admissions[0]?.distinguishing_marks[0]?.height}`, 138, offset + 70);
    pdf.line(138, offset + 71, 200, offset + 71); // Draw underline for height

    pdf.text(`c. Weight:`, 20, offset + 80);
    pdf.text(`${client.admissions[0]?.distinguishing_marks[0]?.weight}`, 40, offset + 80);
    pdf.line(40, offset + 81, 110, offset + 81); // Draw underline for weight

    pdf.text(`d. Colour of Eye:`, 115, offset + 80);
    pdf.text(`${client.admissions[0]?.distinguishing_marks[0]?.colour_of_eye}`, 150, offset + 80);
    pdf.line(150, offset + 81, 200, offset + 81); // Draw underline for eye color

    pdf.text(`e. Skin:`, 20, offset + 90);
    pdf.text(`${client.admissions[0]?.distinguishing_marks[0]?.skin_colour}`, 36, offset + 90);
    pdf.line(36, offset + 91, 110, offset + 91); // Draw underline for skin color

    // Add the "Put on Documents Submitted" section with checkboxes
    pdf.setFont('helvetica', 'bold'); // Set font to Arial and make it bold
    pdf.text(`Put on Documents Submitted:`, 20, offset + 100);
    pdf.setFont('helvetica', 'normal'); // Reset font to normal for the following text

    // Function to draw a custom checkmark inside the checkbox
      function drawCheckmark(pdf, x, y) {
          pdf.setLineWidth(0.1);
          pdf.line(x, y + 1, x + 1, y + 2.5); // Adjust the first line of the checkmark
          pdf.line(x + 1, y + 2.5, x + 3, y - 0.5); // Adjust the second line of the checkmark
      }

      // Function to fill the checkbox and draw the checkmark
      function fillCheckboxWithCheck(pdf, x, y) {
          pdf.setFillColor(169, 169, 169); // Set a light gray color
          pdf.rect(x, y, 4, 4, 'F'); // Draw and fill the rectangle
          drawCheckmark(pdf, x, y + 2); // Draw the checkmark on top
      }

      // Example usage in your PDF generation code:

      // SCSR
      pdf.rect(20, offset + 106, 4, 4); // Draw a square for the checkbox
      pdf.text(`SCSR`, 28, offset + 110); // Position the label text next to the checkbox
      if (client.admissions[0]?.documents[0]?.submitted) {
          fillCheckboxWithCheck(pdf, 20, offset + 106); // Fill the checkbox and draw the checkmark
      }

      // Court Order
      pdf.rect(90, offset + 106, 4, 4); // Draw a square for the checkbox
      pdf.text(`Court Order`, 98, offset + 110); // Position the label text next to the checkbox
      if (client.admissions[0]?.documents[1]?.submitted) {
          fillCheckboxWithCheck(pdf, 90, offset + 106); // Fill the checkbox and draw the checkmark
      }

      // Medical Certificates
      pdf.rect(157, offset + 106, 4, 4); // Draw a square for the checkbox
      pdf.text(`Medical Certificates`, 165, offset + 110); // Position the label text next to the checkbox
      if (client.admissions[0]?.documents[2]?.submitted) {
          fillCheckboxWithCheck(pdf, 157, offset + 106); // Fill the checkbox and draw the checkmark
      }

      // Consent from Parents
      pdf.rect(20, offset + 116, 4, 4); // Draw a square for the checkbox
      pdf.text(`Consent from Parents`, 28, offset + 120); // Position the label text next to the checkbox
      if (client.admissions[0]?.documents[3]?.submitted) {
          fillCheckboxWithCheck(pdf, 20, offset + 116); // Fill the checkbox and draw the checkmark
      }

      // School Records
      pdf.rect(90, offset + 116, 4, 4); // Draw a square for the checkbox
      pdf.text(`School Records`, 98, offset + 120); // Position the label text next to the checkbox
      if (client.admissions[0]?.documents[4]?.submitted) {
          fillCheckboxWithCheck(pdf, 90, offset + 116); // Fill the checkbox and draw the checkmark
      }

      // Others
      pdf.rect(157, offset + 116, 4, 4); // Draw a square for the checkbox
      pdf.text(`Others`, 165, offset + 120); // Position the label text next to the checkbox
      if (client.admissions[0]?.documents[5]?.submitted) {
          fillCheckboxWithCheck(pdf, 180, offset + 116); // Fill the checkbox and draw the checkmark
      }

    pdf.setFont('helvetica', 'bold'); // Set font to Arial and make it bold
    pdf.text(`General impression upon admission:`, 20, offset + 130);
    pdf.setFont('helvetica', 'normal'); // Reset font to normal for the following text

    pdf.text(client.admissions[0]?.general_impression || '', 20, offset + 140, { maxWidth: 170 });
    pdf.line(20, offset + 141, 200, offset + 141); // Draw underline for general impression

    pdf.setFont('helvetica', 'bold'); // Set font to Arial and make it bold
    pdf.text(`Action Taken:`, 20, offset + 150);
    pdf.setFont('helvetica', 'normal'); // Reset font to normal for the following text

    pdf.text(client.admissions[0]?.action_taken || '', 20, offset + 160, { maxWidth: 170 });
    pdf.line(20, offset + 161, 200, offset + 161); // Draw underline for action taken

    if (index < this.clients.length - 1) {
      pdf.addPage(); // Add a new page for the next client if more clients exist
    }
  });
    // Add the new section content
    let offset = 253; // Assuming we are continuing from a previous offset

    // Grid: Name & Signature of Referring Party / Admitting Officer
   
        // Name & Signature of Referring Party / Admitting Officer
    pdf.line(20, offset, 85, offset); // Underline for Referring Party
    pdf.text('Name & Signature of Referring Party', 20, offset + 4); // Text below the line
    pdf.line(130, offset, 200, offset); // Underline for Admitting Officer
    pdf.text('Admitting Officer', 130, offset + 4); // Text below the line

    offset += 10; // Move down

    // Grid: Designation / ID No. / Contact # / Designation
    pdf.line(20, offset, 85, offset); // Underline for Designation / ID No. / Contact #
    pdf.text('Designation / ID No. / Contact #', 20, offset + 4); // Text below the line
    pdf.line(130, offset, 200, offset); // Underline for Designation
    pdf.text('Designation', 130, offset + 4); // Text below the line

    offset += 10; // Move down

    // Grid: Complete Address/Office Address / Date/Time
    pdf.line(20, offset, 85, offset); // Underline for Complete Address/Office Address
    pdf.text('Complete Address/Office Address', 20, offset + 4); // Text below the line
    pdf.line(130, offset, 200, offset); // Underline for Date/Time
    pdf.text('Date/Time', 130, offset + 4); // Text below the line

    offset += 20; // Move down for "Noted By" section

    // Noted By section
    pdf.setFontSize(11);
    pdf.text('Noted By:', 108, offset - 5, null, null, 'center');

    pdf.setFontSize(11);
    pdf.setFont('helvetica', 'bold');
    // Centered text with the underline above
    pdf.text('ANGELIC B. PAÑA, RSW, MSSW', 108, offset + 6, null, null, 'center'); // Text below the line
    pdf.setFont('helvetica', 'normal');
      // Draw the underline above the text
      

    pdf.line(78, offset + 7, 140, offset + 7); // Adjust the line length and position for centering

    // Centered text with the underline above
    pdf.text('Center Head/SWO IV', 108, offset + 12, null, null, 'center'); // Text below the line

    offset += 30; // Move down for footer

    // Add and set Times New Roman font
    pdf.setFont('TimesNewRoman', 'bold'); // Use the normal font but increase size for bold effect
pdf.setFontSize(12); // Increase the font size to simulate bold
pdf.text('PAGE 1 of 1', 108, offset + 3, null, null, 'center');
    pdf.setLineWidth(0.5);
    pdf.addFont('times-normal.ttf', 'TimesNewRoman', 'italic'); // Loads the Times New Roman italic font
    pdf.setFont('TimesNewRoman', 'italic'); // Sets Times New Roman as the italic font
    pdf.line(20, offset + 5, 210 - 30, offset + 5); // Draw a line
    pdf.setFontSize(9);
    pdf.text('DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City', 100, offset + 10, null, null, 'center');
    pdf.text('Email: rrcy.fo11@dswd.gov.ph    Tel. No.: 293-0306', 108, offset + 15, null, null, 'center');

     // Add the footer image
     const footerImgData = '/images/footerimg.png'; // Path to your footer image
    pdf.addImage(footerImgData, 'PNG', 182, offset, 20, 10); // Adjust the position and size as needed

    // Save the PDF
    pdf.save(`admission-slip-${this.id}.pdf`);
    }

  },
};
</script>

<style scoped>
/* Adjust spacing and underline input */
.underline-input {
  border: none;
  border-bottom:  1px solid black;
  padding: 0;
  width: 100%;
  margin-bottom: 14px;
  line-height: 0;
  box-sizing: border-box;
  vertical-align: bottom; /* Ensures the text aligns with the bottom of the input */
  font-size: inherit; /* Ensure consistent font size */
}
.underline-input1 {
  border: none;
  border-bottom:  1px solid black;
  padding: 0;
  margin-bottom: 14px;
  line-height: 0;
  box-sizing: border-box;
  vertical-align: bottom; /* Ensures the text aligns with the bottom of the input */
  font-size: inherit; /* Ensure consistent font size */
}



/* Ensure the form fits within Legal size dimensions for printing */
@media print {
  .max-w-7xl {
    max-width: 216mm;
  }
  .p-8 {
    padding: 100mm;
  }
  .mr-4, .mb-12, .mb-8, .mb-6, .mb-4, .mb-2 {
    margin-bottom: 20mm;
  }
  .border-t {
    border-top: 1px solid #d2d2d2;
  }
}
</style>
