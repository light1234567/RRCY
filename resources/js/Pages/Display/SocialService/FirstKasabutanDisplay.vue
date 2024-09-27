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
  <div>
    <div ref="contentToPrint" class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
      <div class="relative flex justify-between items-center mb-2">
        <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
        <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
      </div>
      <div class="text-center mb-8">
        <h1 class="text-[35px] font-bold">KASABUTAN</h1>
      </div>

      <!-- Save Confirmation Modal -->
      <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="fixed inset-0 bg-black opacity-50"></div>
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
          <div class="bg-white p-16">
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

      <!-- Save Result Modal -->
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
      
      
      <div class="mb-8 text-justify">
        <p class="mb-4">
          <span class="ml-8 inline-block">Ako</span> si <span class="font-bold underline">{{ clientName }}</span> usa ka residente diri sa DSWD-RRCY. Ako maningkamot na dili mo buhat us salaod na mulabag sa polisiya sa center. Ug ako mouyong na dili ko buhatan ug pasahan sa Final Report didto sa court kung dili <strong>“COLOR RED”</strong> and akong Performance equivalent to <strong>“OUTSTANDING”</strong>
        </p>
        <p><span class="ml-8 inline-block">Ug</span> kung ako makasala, andam ko na maextend akong pagpuyo diri sa center/RRCY hangtud na ako moabot sa 21 anyos.</p>
      </div>

      <div class="mb-8">
        <div class="space-y-12">
          <div>
            <input type="text" v-model="form.client_resident" 
              class="underline-input w-1/3 px-2 text-xs" 
              :readonly="!editMode"/>
            <label class="block text-base -mt-1">Client/Resident</label>
          </div>
          <div>
            <input type="text" v-model="form.parent_guardian" 
              class="underline-input w-1/3 px-2 mt-12 text-xs" 
              :readonly="!editMode"/>
            <label class="block text-base -mt-1">Pangalan/Pirma sa Ginikanan/Guardian</label>
          </div>
          <div>
            <input type="text" v-model="form.first_kasabutan_case_manager" 
              class="underline-input w-1/3 px-2 mt-12 py-1 text-xs" 
              :readonly="!editMode"/>
            <label class="block text-base -mt-1">Case Manager</label>
          </div>
        </div>
      </div>

      <div class="text-left mt-16">
        <input type="text" v-model="center_head" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" readonly>        <p>Center Head/SWO IV</p>
      </div>

      <div class="border-gray-300 ml-6 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
        <div class="flex justify-between items-center">
          <div class="flex flex-col">
            <p class="ml-24 -mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
            <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
            <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrcy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
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
  name: 'KasabutanSheet',
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
        first_kasabutan_case_manager: '',
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
    console.log('Client ID fetched:', clientId); // Console log showing client ID
    if (clientId) {
      this.fetchClientData(clientId);
      this.fetchCenterHead();
    }
  },
  watch: {
    '$route.params.id': function(newId) {
      console.log('Client ID changed:', newId); // Console log showing updated client ID
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

        const kasabutanResponse = await axios.get(`/api/kasabutan/${clientId}`);
        const kasabutan = kasabutanResponse.data;
        this.form.client_resident = kasabutan.client_resident || '';
        this.form.parent_guardian = kasabutan.parent_guardian || '';
        this.form.first_kasabutan_case_manager = kasabutan.first_kasabutan_case_manager || '';
        this.form.id = kasabutan.id;
      } catch (error) {
        this.errorMessage = 'Error fetching client data.';
        console.error('Error fetching client data:', error);
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
      if (this.editMode) {
        this.openModal();
      } else {
        this.editMode = !this.editMode;
      }
    },
    openModal() {
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
    },
    async confirmSave() {
      try {
        await this.saveData();
        this.saveResultTitle = 'Success';
        this.saveResultMessage = 'Data saved successfully!';
      } catch (error) {
        this.saveResultTitle = 'Error';
        this.saveResultMessage = 'Failed to save data.';
      } finally {
        this.closeModal();
        this.editMode = false;
        this.isSaveResultModalOpen = true;
      }
    },
    cancelEdit() {
      this.editMode = false;
    },
    async saveData() {
      if (!this.form.client_id) {
        throw new Error('Client ID is missing.');
      }

      try {
        const response = await axios[this.form.id ? 'put' : 'post'](`/api/kasabutan${this.form.id ? '/' + this.form.id : ''}`, this.form);
        if (!this.form.id) {
          this.form.id = response.data.id;
        }
      } catch (error) {
        throw new Error('Error saving data.');
      }
    },
    closeSaveResultModal() {
      this.isSaveResultModalOpen = false;
      this.saveResultTitle = '';
      this.saveResultMessage = '';
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

  const initialX = 20;  // Initial X position for the text
const maxWidth = 170;


const clientName = this.clientName;
const text1 = 'Ako si ' + clientName + ' usa ka residente diri sa DSWD-RRCY. Ako maningkamot na dili mo buhat us salaod na mulabag sa polisiya sa center. Ug ako mouyong na dili ko buhatan ug pasahan sa Final Report didto sa court kung dili “COLOR RED” and akong Performance equivalent to “OUTSTANDING”.';
const text2 = 'Ug kung ako makasala, andam ko na maextend akong pagpuyo diri sa center/RRCY hangtud na ako moabot sa 21 anyos.';

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


// Justify the first text
justifyText(text1, maxWidth, initialX, contentYPos, pdf);

// Justify the second text
contentYPos += 35;  // Add some spacing between the two paragraphs
justifyText(text2, maxWidth, initialX, contentYPos, pdf);

  // Underlined sections for Client/Resident, Guardian, and Case Manager
contentYPos += 40;


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
pdf.text(`${this.sheet.first_kasabutan_case_manager || ''}`, initialX, contentYPos+-2);
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

printContent() {
  const originalContent = document.body.innerHTML;

  // Base64 encoded image for header logo (replace with actual Base64 data)
  const headerLogoBase64 = 'data:image/png;base64,...'; // Replace with your Base64 encoded image string
  const footerImgBase64 = 'data:image/png;base64,...'; // Replace with your Base64 encoded image string

  document.body.innerHTML = `
    <div style="font-family: 'Times New Roman', Times, serif; font-size: 12px;">
      <div class="content">
        <div class="header" style="text-align: center;">
          <img src="${headerLogoBase64}" style="width: 200px; margin-bottom: 20px;" alt="Logo">
          <p style="font-size: 10px;">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
        </div>

        <h1 style="text-align: center; font-size: 28px; margin-bottom: 40px; font-weight: bold;">KASABUTAN</h1>

        <div style="text-align: justify; margin-bottom: 16px;">
          <p><span style="margin-left: 32px;">Ako</span> si <span style="font-weight: bold; text-decoration: underline;">${this.clientName}</span> usa ka residente diri sa DSWD-RRCY. Ako maningkamot na dili mo buhat us salaod na mulabag sa polisiya sa center. Ug ako mouyong na dili ko buhatan ug pasahan sa Final Report didto sa court kung dili <strong>“COLOR RED”</strong> and akong Performance equivalent to <strong>“OUTSTANDING”</strong>.</p>
          <p style="margin-left: 32px;">Ug kung ako makasala, andam ko na maextend akong pagpuyo diri sa center/RRCY hangtud na ako moabot sa 21 anyos.</p>
        </div>

        <div style="margin-bottom: 32px;">
          <p>Client/Resident: <span style="border-bottom: 2px solid black;">${this.form.client_resident}</span></p>
          <p>Pangalan/Pirma sa Ginikanan/Guardian: <span style="border-bottom: 2px solid black;">${this.form.parent_guardian}</span></p>
          <p>Case Manager: <span style="border-bottom: 2px solid black;">${this.sheet.first_kasabutan_case_manager}</span></p>
        </div>

        <div style="text-align: left; margin-top: 64px;">
          <p><u><strong>ANGELIC B. PAÑA, RSW, MSSW</strong></u></p>
          <p>Center Head/SWO IV</p>
        </div>
      </div>

      <div style="text-align: center; font-size: 10px; position: fixed; bottom: 20px; left: 0; right: 0;">
        <p>DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY)</p>
        <p>Email: rrcy.fo11@dswd.gov.ph | Tel. No.: 293-0306</p>
      </div>

      <div style="position: absolute; bottom: 0; right: 20px; font-size: 10px;">
        PAGE 1 of 1
      </div>
    </div>
  `;

  window.print(); // Trigger the print dialog

  document.body.innerHTML = originalContent; // Restore the original content of the page
  window.location.reload(); // Reload the page to restore any event listeners and state
},
  },
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
.bg-green-500:hover {
  background-color: #38a169;
}
.underline-input {
  border: none;
  border-bottom:  1px solid black;
  padding: 0;
  margin: 0;
  vertical-align: bottom; /* Ensures the text aligns with the bottom of the input */
}
</style>
