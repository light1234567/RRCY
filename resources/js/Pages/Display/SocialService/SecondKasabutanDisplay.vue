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
  
      <button v-if="editMode" @click="openModal" class="flex items-center space-x-2 px-3 py-1 bg-green-500 hover:bg-green-600 text-white rounded-md text-xs">
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
  
    <!-- Main Content -->
    <div class="graph-background pt-0.5  -mr-9 -mb-16">
    <div >
      <div class="max-w-3xl p-8 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
        <div class=" p-8 rounded">
          <div class="relative flex justify-between items-center mb-2">
            <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
            <p class="text-[12px] text-right -mt-10" style="font-family: 'Times New Roman', Times, serif; font-style: italic;">DSWD-GF-010A | REV 00 | 22 SEP 2023
  </p>
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
                <input type="text" v-model="clientName" 
                  class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none mt-2 shadow-sm w-1/3 p-0 text-sm" 
                  readonly/>
                <label class="block text-base  text-gray-700 -mt-1">Client/Resident</label>
              </div>
              <div>
                <input type="text" v-model="form.parent_guardian" 
                  class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm w-1/3 p-0 mt-12 text-sm" 
                  :readonly="!editMode"
                  @input="form.parent_guardian = removeNumbers(form.parent_guardian)"
                  maxlength="50"/>
                <label class="block text-base  -mt-1">Pangalan/Pirma sa Ginikanan/Guardian</label>
              </div>
              <div>
                <input type="text" v-model="form.second_kasabutan_case_manager" 
                  class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm w-1/3p-0 mt-12 py-1 text-sm" 
                  :readonly="!editMode"
                  @input="form.second_kasabutan_case_manager = removeNumbers(form.second_kasabutan_case_manager)"
                  maxlength="50"/>
                <label class="block text-base -mt-1">Case Manager</label>
              </div>
            </div>
          </div>
          <div class=" mt-16">
            <input type="text" v-model="center_head" :class="{'twinkle-border': editMode}" class="underline w-full border border-transparent p-0 " readonly>        
            <p class="-mt-1">Center Head/SWO IV</p>
          </div>
        </div>
  
        <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
        <div class="flex justify-between items-center">
          <div class="flex flex-col">
            <p class="ml-24 -mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
            <p class="border-t text-[11.5px]  mt-4 whitespace-nowrap" style="border-top: 2px solid black;">
              DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City
            </p>
            <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
          </div>
          <div class="ml-4">
            <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
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
        center_head: '',
        form: {
          client_id: null,
          client_resident: '',
          parent_guardian: '',
          second_kasabutan_case_manager: '',
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
        this.fetchCenterHead();
      }
    },
    watch: {
      '$route.params.id': function(newId) {
        if (newId) {
          this.fetchClientData(newId);
          this.fetchCenterHead(newId);
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

          // Fetch kasabutan by client_id using the new route
          const kasabutanResponse = await axios.get(`/api/kasabutan/client/${clientId}`);
          const kasabutan = kasabutanResponse.data;
          this.form.client_resident = kasabutan.client_resident || '';
          this.form.parent_guardian = kasabutan.parent_guardian || '';
          this.form.second_kasabutan_case_manager = kasabutan.second_kasabutan_case_manager || '';
          this.form.id = kasabutan.id;
        } catch (error) {
          this.errorMessage = 'Error fetching client data.';
          console.error('Error fetching client data:', error);
        }
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
    removeNumbers(input) {
    return input.replace(/[0-9]/g, '');
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
    const pdf = new jsPDF('p', 'mm', 'legal'); // Change to legal size (216x356 mm)
  
    // Header section with the logo and text
    const imgData = '/images/headerlogo2.png'; 
    pdf.addImage(imgData, 'PNG', 15, 10, 50, 30); // DSWD logo
  
    pdf.setFontSize(9);
    pdf.setFont('TimesNewRoman', 'italic'); // Set font style to italic
    pdf.text('DSWD-GF-010A | REV 00 | 22 SEP 2023', 140, 20);
  
    // Title ("KASABUTAN")
    pdf.setFont('arialbd', 'bold');
    pdf.setFontSize(30);
    pdf.setTextColor(0, 0, 0); // Black text for title
    pdf.text('KASABUTAN', 105, 60, null, null, 'center'); // Centered title
  
    // Main Content: Adjust positioning and apply bold/underline styles
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(12);
    
    let contentYPos = 80; // Start below the title
    const initialX = 20;  // Adjust this value to shift the text further right as needed
    const maxWidth = 175;
  
    const clientName = this.clientName;
    const text1 = 'Ako si ' + clientName + ' nagapanumpa ug naga saad na unsa man ang mahitabo sa akoan bahin niini PAGAPATAOD UG BOLITAS SA AKONG KINATAWO/OTIN, walay tulubagon ang DSWD-RRCY tungod kini maoy akong kabubut-on.';
  
    // Function to justify text
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
            yPos += 7; // Move to the next line
        });
    }
  
    pdf.setFontSize(13);
    // Justify the first text
    justifyText(text1, maxWidth, initialX, contentYPos, pdf);
  
    // Underlined sections for Client/Resident, Guardian, and Case Manager
    contentYPos += 40;
    pdf.setFontSize(12);
  
    // Client/Resident underline and label
    contentYPos += 20;
    pdf.text(`${this.form.client_resident || ''}`, initialX, contentYPos - 2);
    pdf.line(20, contentYPos, 100, contentYPos); // Underline first (left aligned)
    contentYPos += 5; // Move Y position down for the text
    pdf.text('Client/Resident', 20, contentYPos); // Label below the underline
  
    // Guardian underline and label
    contentYPos += 30; 
    pdf.text(`${this.form.parent_guardian || ''}`, initialX, contentYPos - 2);
    pdf.line(20, contentYPos, 100, contentYPos); // Underline first (left aligned)
    contentYPos += 5; // Move Y position down for the text
    pdf.text('Pangalan/Pirma sa Ginikanan/Guardian', 20, contentYPos); // Label below the underline
  
    // Case Manager underline and label
    contentYPos += 30;
    pdf.text(`${this.form.second_kasabutan_case_manager || ''}`, initialX, contentYPos - 2);      
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
    
    // Footer Section - Adjusted Y positions for legal size
  pdf.setFontSize(9);
  pdf.setFont('TimesNewRoman', 'bold');
  pdf.text('PAGE 1 of 1', 105, 330, null, null, 'center'); // Adjusted Y position for legal size
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

  </style>
  