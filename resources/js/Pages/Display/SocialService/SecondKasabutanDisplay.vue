<template>
  <!-- Tabs for Actions -->
  <div class="flex -ml-2 justify-end bg-transparent border -mr-9 border-gray-300 p-4  space-x-4 -mt-9">
      <button @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.3 2.7a1 1 0 011.4 0l1.3 1.3a1 1 0 010 1.4l-9.4 9.4a1 1 0 01-.6.3l-2.8.6a1 1 0 01-1.2-1.2l.6-2.8a1 1 0 01.3-.6l9.4-9.4z" />
        </svg>
        <span>Edit</span>
      </button>
         <!-- Pagination Component -->
    <Pagination 
      :totalPages="totalPages" 
      :currentPage="currentPage" 
      @update:currentPage="currentPage = $event" 
    />
      <button @click="openModal" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
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

  <!-- Main Content -->
  <div class="graph-background pt-0.5  -mr-9 -mb-16">
  <div >
    <div class="max-w-3xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
      <div class=" p-8 rounded">
        <div class="relative flex justify-between items-center mb-2">
          <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
          <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
        </div>

        <div class="text-center mb-8">
          <h1 class="text-[35px] font-bold">KASABUTAN</h1>
        </div>

        <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
          {{ message }}
        </div>

        <div class="mb-8">
          <p class="text-justify">
            <span class="ml-8 inline-block">Ako</span> si <span class="font-bold underline">{{ clientName }}</span> nagapanumpa ug naga saad na unsa man ang mahitabo sa akoan bahin niini <strong>PAGAPATAOD UG BOLITAS SA AKONG KINATAWO/OTIN</strong>, walay tulubagon ang DSWD-RRCY tungod kini maoy akong kabubut-on.
          </p>
        </div>

        <div class="mb-8">
          <div class="space-y-12">
            <div>
              <input type="text" v-model="form.client_resident" 
                class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none mt-2 shadow-sm w-1/3 px-2 text-xs" 
                :readonly="!editMode"/>
              <label class="block text-base font-semibold text-gray-700 -mt-1">Client/Resident</label>
            </div>
            <div>
              <input type="text" v-model="form.parent_guardian" 
                class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm w-1/3 px-2 mt-12 text-xs" 
                :readonly="!editMode"/>
              <label class="block text-base font-semibold text-gray-700 -mt-1">Pangalan/Pirma sa Ginikanan/Guardian</label>
            </div>
            <div>
              <input type="text" v-model="form.case_manager" 
                class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm w-1/3 px-2 mt-12 py-1 text-xs" 
                :readonly="!editMode"/>
              <label class="block text-base font-semibold text-gray-700 -mt-1">Case Manager</label>
            </div>
          </div>
        </div>
        <div class=" mt-16">
          <p><u><strong>ANGELIC B. PAÑA, RSW, MSSW</strong></u></p>
          <p class="-mt-1">Center Head/SWO IV</p>
        </div>
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
  </div>
  </div>
</template>

<script>
import axios from 'axios';
import Pagination from '@/Components/Pagination.vue';
import { jsPDF } from 'jspdf'; // Import jsPDF

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
        client_resident: '',
        parent_guardian: '',
        case_manager: '',
        id: null
      },
      clientName: '',
      errorMessage: '',
      isModalOpen: false,
      isSaveResultModalOpen: false,
      saveResultTitle: '',
      saveResultMessage: '',
      totalPages: 1,
      currentPage: 1
    };
  },
  mounted() {
    const clientId = this.$route.params.id;
    if (clientId) {
      this.fetchClientData(clientId);
    }
  },
  watch: {
    '$route.params.id': function(newId) {
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

        const kasabutanResponse = await axios.get(`/api/kasabutan/${clientId}`);
        const kasabutan = kasabutanResponse.data;
        this.form.client_resident = kasabutan.client_resident || '';
        this.form.parent_guardian = kasabutan.parent_guardian || '';
        this.form.case_manager = kasabutan.case_manager || '';
        this.form.id = kasabutan.id;
      } catch (error) {
        this.errorMessage = 'Error fetching client data.';
      }
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
    async confirmSave() {
      try {
        const response = await axios[this.form.id ? 'put' : 'post'](`/api/kasabutan${this.form.id ? '/' + this.form.id : ''}`, this.form);
        this.saveResultTitle = 'Success';
        this.saveResultMessage = 'Data saved successfully.';
        this.isSaveResultModalOpen = true;

        if (!this.form.id) {
          this.form.id = response.data.id;
        }

        this.errorMessage = '';
        this.editMode = false;
      } catch (error) {
        this.saveResultTitle = 'Error';
        this.saveResultMessage = error.response?.data?.message || 'Error saving data.';
        this.isSaveResultModalOpen = true;
      } finally {
        this.closeModal();
      }
    },
    closeSaveResultModal() {
      this.isSaveResultModalOpen = false;
      this.saveResultTitle = '';
      this.saveResultMessage = '';
    },
    cancelEdit() {
      this.editMode = false;
    },
    exportToPdf() {
  const pdf = new jsPDF('p', 'mm', 'a4'); // Standard A4 size document

  // Header section with the logo and text
  const imgData = '/images/headerlogo2.png'; 
  pdf.addImage(imgData, 'PNG', 15, 10, 50, 30); // DSWD logo
  pdf.setFontSize(9);
pdf.setFont('TimesNewRoman', 'italic'); // Set font style to italic
pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 135, 20);

  // Title ("KASABUTAN")
  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(30);
  pdf.setTextColor(0, 0, 0); // Black text for title
  pdf.text('KASABUTAN', 105, 60, null, null, 'center'); // Centered title

  // Main Content: Adjust positioning and apply bold/underline styles
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  
  let contentYPos = 80; // Start below the title

// Adjust starting position
// Increase the starting X-position to move the text to the right
// Use let or const for variable declaration in JavaScript
let initialX = 20;  // Adjust this value to shift the text further right as needed

// First line
pdf.setFont('Arial', 'normal');
pdf.setFontSize(13);
pdf.text('Ako si ', initialX, contentYPos); // Normal text for 'Ako si'

// Bold and underline the client's name
pdf.setFont('arialbd', 'bold');
pdf.setFontSize(12);
pdf.line(33, contentYPos + 1, 97, contentYPos+1); // Adjust the Y position downward by 10 units

pdf.textWithLink(this.clientName, initialX + pdf.getTextWidth('Ako si '), contentYPos, { underline: true }); // Bold and underlined client's name

// Continue with normal text
pdf.setFont('arial', 'normal');
pdf.text('nagapanumpa ug naga saad na unsa man', initialX + pdf.getTextWidth('Ako si ' + this.clientName) + 7, contentYPos);

// Second line of the paragraph
contentYPos += 7; // Move to the next line
pdf.text('ang mahitabo sa akoan bahin niini', initialX, contentYPos);
pdf.setFont('arialbd', 'bold');
pdf.text('PAGAPATAOD UG BOLITAS SA AKONG', 88, contentYPos);

// Third line, adding bold text for "COLOR RED"
contentYPos += 8; // Move to the next line
pdf.setFont('arialbd', 'bold');
pdf.text('KINATAWO/OTIN,', 20, contentYPos); // Normal text before bold
pdf.setFont('arial', 'normal');
pdf.text('walay tulubagon ang DSWD-RRCY tungod kini maoy akong kabubut-',58, contentYPos); // Normal text before bold

// Third line, adding bold text for "COLOR RED"
contentYPos += 8; // Move to the next line
pdf.setFont('arial', 'normal');
pdf.text('on', 20, contentYPos); // Normal text before bold


  // Underlined sections for Client/Resident, Guardian, and Case Manager
contentYPos += 1;

// Client/Resident underline and label
contentYPos += 20;
pdf.text(`${this.form.client_resident || ''}`, initialX, contentYPos+-2);
pdf.line(20, contentYPos, 100, contentYPos); // Underline first (left aligned)
contentYPos += 5; // Move Y position down for the text
pdf.text('Client/Resident', 20, contentYPos); // Label below the underline

// Guardian underline and label
contentYPos += 30; 
pdf.text(`${this.form.parent_guardian || ''}`, initialX, contentYPos+-2);
pdf.line(20, contentYPos, 100, contentYPos); // Underline first (left aligned)
contentYPos += 5; // Move Y position down for the text
pdf.text('Pangalan/Pirma sa Ginikanan/Guardian', 20, contentYPos); // Label below the underline

// Case Manager underline and label
contentYPos += 30;
pdf.text(`${this.form.case_manager || ''}`, initialX, contentYPos+-2);      
pdf.line(20, contentYPos, 100, contentYPos); // Underline first (left aligned)
contentYPos += 5; // Move Y position down for the text
pdf.text('Case Manager', 20, contentYPos); // Label below the underline

// Signature Section
contentYPos += 25;
  pdf.setFont('arialbd', 'bold');
  pdf.text('ANGELIC B. PAÑA, RSW, MSSW', 20, contentYPos);
  pdf.setFont('arial', 'normal');
  pdf.text('Center Head/SWO IV', 20, contentYPos + 6);
  contentYPos += 1;
  pdf.line(20, contentYPos, 87, contentYPos); // Underline first (left aligned)
  
// Footer Section - Adjusted Y positions to move higher
pdf.setFontSize(9);
pdf.setFont('TimesNewRoman', 'bold');
pdf.text('PAGE 1 of 1', 105, 280, null, null, 'center'); // Moved higher (was 290)
pdf.setLineWidth(0.5); // Set line width to make it bolder (default is 0.200)
pdf.line(17, 282, 173, 282); // Footer line moved higher (was 292)
pdf.setFont('times', 'normal');
const footerText = pdf.splitTextToSize('DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Prk. 7 Bago-Oshiro, Tugbok Dist., Davao City', 160); // Adjust width limit (160mm)
pdf.text(footerText, 95, 287, null, null, 'center');
pdf.text('Email: rrcy.fo11@dswd.gov.ph    Tel. No.: 293-0306', 105, 292, null, null, 'center');

const footerImgData = '/images/footerimg.png'; // Make sure the image is correctly loaded
pdf.addImage(footerImgData, 'PNG', 175, 275, 25, 12); // Adjust the position and size

  // Save the PDF
  pdf.save(`kasabutan-${this.form.client_id}.pdf`);
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
