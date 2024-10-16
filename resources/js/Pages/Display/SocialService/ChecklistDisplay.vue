<template>
  <!-- Tabs for Actions -->
  <div v-if="editMode" class="flex absolute p-4 space-x-4">
      <button @click="cancelEdit" class="flex space-x-2 px-3 py-3 bg-blue-500 text-white rounded-md text-xs">
        <!-- FontAwesome for Back -->
        <i class=" fas fa-arrow-left w-4 h-4"></i>
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
  
    <!-- Page 1 of 2 -->
    <div class="graph-background p-0.5 -mr-9 -mb-16">
    <div v-if="currentPage === 1" class="max-w-3xl border-gray-400 p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border ">
      <div class="relative flex justify-between items-center mb-2">
        <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
        <p class="text-[12px] text-right -mt-10" style="font-family: 'Times New Roman', Times, serif; font-style: italic;">DSWD-GF-010A | REV 00 | 22 SEP 2023
        </p>
      </div>
  
      <h1 class="text-2xl font-bold mb-4 text-center text-black">Checklist of Requirements during Admission</h1>
      <div v-if="message" :class="`p-2 mt-2 text-white rounded-md text-xs ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
        {{ message }}
      </div>
      <table class="min-w-full bg-white border border-black mt-2 text-xs">
    <thead>
      <tr class="bg-[#c9ddb3] text-[16px]"> 
        <th class="py-2 px-2 border border-black">No.</th>
        <th class="py-2 px-2 border border-black">DOCUMENTS</th>
        <th class="py-2 px-2 border border-black w-16">YES</th>
        <th class="py-2 px-2 border border-black w-16">NO</th>
        <th class="py-2 px-2 border border-black w-96">REMARKS</th>
      </tr>
    </thead>
    <tbody>
      <template v-for="(item, index) in checklist" :key="index">
        <!-- Only number the main items -->
        <tr class="hover:bg-gray-100 text-[16px] ">
          <td class="py-1 px-4 border border-black">{{ item.isSubItem ? '' : index + 1 }}</td>
          <td class="py-1 px-4 text-black text-[16px] border w-2/5 border-black">{{ item.document }}</td>
          <td class="py-1 px-4  border border-black">
            <input type="checkbox" v-model="item.yes" :disabled="!editMode" @change="handleCheckboxChange(item, 'yes')" />
          </td>
          <td class="py-1 px-4 border border-black">
            <input type="checkbox" v-model="item.no" :disabled="!editMode" @change="handleCheckboxChange(item, 'no')" />
          </td>
          <td class="py-1 px-2 text-black text-[16px] border border-black">
            <textarea v-model="item.remarks" class="w-full border border-transparent p-1 text-xs" :readonly="!editMode"></textarea>
          </td>
        </tr>
  
        <!-- Render sub-items if they exist -->
        <tr v-if="item.subItems" v-for="(subItem, subIndex) in item.subItems" :key="subIndex" class="hover:bg-gray-100">
          <td class="py-1 px-2 border border-black"></td> <!-- Empty for sub-items -->
          <td class="py-1 px-4 text-black text-[16px] border w-1/3 border-black">{{ subItem.document }}</td>
          <td class="py-1 px-4 border border-black">
            <input type="checkbox" v-model="subItem.yes" :disabled="!editMode" @change="handleCheckboxChange(subItem, 'yes')" />
          </td>
          <td class="py-1 px-4 border border-black">
            <input type="checkbox" v-model="subItem.no" :disabled="!editMode" @change="handleCheckboxChange(subItem, 'no')" />
          </td>
          <td class="py-1 px-2 text-black text-[20px] border border-black">
            <textarea v-model="subItem.remarks" class="w-full border border-transparent p-1 text-xs" :readonly="!editMode"></textarea>
          </td>
        </tr>
      </template>
    </tbody>
  </table>
  
  
      <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
        <div class="flex justify-between items-center">
          <div class="flex flex-col">
            <p class="ml-24 -mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
            <p class="border-t -ml-7 mt-4 whitespace-nowrap" style="border-top: 2px solid black;">
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
  
    <!-- Page 2 of 2 -->
    <div v-if="currentPage === 2" class="max-w-3xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
      <div class="relative flex justify-between items-center mb-2">
    <p class="text-[12px] text-right w-full" style="font-family: 'Times New Roman', Times, serif; font-style: italic;">DSWD-GF-010A | REV 00 | 22 SEP 2023
  </p>
  </div>
      <h2 class="text-lg font-semibold mt-8 mb-2 text-center">RRCY Forms</h2>
      <table class="min-w-full bg-white border border-black text-xs">
        <thead>
          <tr class="bg-[#c9ddb3] text-[16px]"> 
            <th class="py-2 px-2 border border-black">No.</th>
        <th class="py-2 px-2 border border-black">DOCUMENTS</th>
        <th class="py-2 px-2 border border-black w-16">YES</th>
        <th class="py-2 px-2 border border-black w-16">NO</th>
        <th class="py-2 px-2 border border-black w-96">REMARKS</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in rrForms" :key="index" class="hover:bg-gray-100">
            <td class="py-1 px-4 text-[16px] border border-black">{{ index + 1 }}</td>
          <td class="py-1 px-4 text-black text-[16px] border w-2/5 border-black">{{ item.form}}</td>
          <td class="py-1 px-4  border border-black">
            <input type="checkbox" v-model="item.yes" :disabled="!editMode" @change="handleCheckboxChange(item, 'yes')" />
          </td>
          <td class="py-1 px-4 border border-black">
            <input type="checkbox" v-model="item.no" :disabled="!editMode" @change="handleCheckboxChange(item, 'no')" />
          </td>
          <td class="py-1 px-2 text-black text-[16px] border border-black">
            <textarea v-model="item.remarks" class="w-full border border-transparent p-1 text-xs" :readonly="!editMode"></textarea>
          </td>
          </tr>
        </tbody>
      </table>
      <div class="footer mt-4">
        <p class="text-[15px] mb-4">Reviewed by:</p>
        <p class="text-[15px] mb-4">
  <input 
    v-model="admittingOfficer" 
    class="w-1/2 font-semibold border-b border-black p-0 text-[15px]" 
    :readonly="!editMode" 
    style="border: none; border-bottom: 1px solid black;" 
    inputmode="text"
    oninput="this.value = this.value.replace(/[0-9]/g, '')"
    placeholder="Enter only letters"
  />
  <br>Admitting Officer
</p>

        <p class="text-[15px] mb-4">Received by:</p>
        <p class="text-[15px]">
          <input v-model="checklist_case_manager" class="w-1/2 font-semibold border-b border-black p-0 text-[15px]" :readonly="!editMode" style="border: none; border-bottom: 1px solid black;"/>
          <br>Case Manager
        </p>
  
  
      <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
    <div class="flex justify-between items-center">
      
      <!-- Left Section: Page number -->
      <div class="flex flex-col flex-grow">
        <!-- Page number centered -->
        <p class="text-center -mb-1 font-bold">PAGE 2 of {{ totalPages }}</p>
  
      <!-- Continuous horizontal line, moved to the left with space on the right -->
      <div style="border-top: 2px solid black; width: 103%; margin-top: 4px; margin-left: -24px;"></div>
  
  
        <!-- Text under the line -->
        <p style="text-align: center; font-weight: bold; margin-top: -1px;">DSWD | FIELD OFFICE XI | ADMINISTRATIVE DIVISION</p>
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
        admittingOfficer: '',
        checklist_case_manager: '',
        message: '',
        messageType: '',
        currentPage: 1,
        totalPages: 2,
        clientId: null,
        checklist: [],
        rrForms: [],
        isModalOpen: false,
        isSaveResultModalOpen: false,
        saveResultTitle: '',
        saveResultMessage: '',
      };
    },
    methods: {
      initializeForm() {
        this.checklist = [
    { document: 'Commitment/Court Order', yes: false, no: false, remarks: '' },
    { document: 'Referral Letter', yes: false, no: false, remarks: '' },
    { document: 'Social Case Study Report', yes: false, no: false, remarks: '' },
    { 
      document: 'Medical Certificate', 
      yes: false, 
      no: false, 
      remarks: '', 
      subItems: [
      { document: 'Negative RT-PCR COVID-19 Test Result', yes: false, no: false, remarks: '', isSubItem: true },
      { document: 'Laboratory Examination Result', yes: false, no: false, remarks: '', isSubItem: true },
        { document: 'a. Chest Xray', yes: false, no: false, remarks: '', isSubItem: true },
        { document: 'b. Fecalysis', yes: false, no: false, remarks: '', isSubItem: true },
        { document: 'c. Urinalysis', yes: false, no: false, remarks: '', isSubItem: true },
        { document: 'd. Complete Blood Count (CBC)', yes: false, no: false, remarks: '', isSubItem: true }
      ]
    },
    { document: 'Psychological Assessment and Evaluation', yes: false, no: false, remarks: '' },
    { document: 'Birth Certificate/Baptismal Cert', yes: false, no: false, remarks: '' },
    { document: 'School Documents (Form 137) if applicable', yes: false, no: false, remarks: '' },
    { document: 'List of Belongings', yes: false, no: false, remarks: '' }
  ];
  
  
  
        this.rrForms = [
          { form: 'Admission Slip', yes: false, no: false, remarks: '' },
          { form: 'General Intake Form', yes: false, no: false, remarks: '' },
          { form: 'Admission Contract', yes: false, no: false, remarks: '' },
          { form: 'Parent\'s Consent', yes: false, no: false, remarks: '' },
          { form: 'Inventory of Client\'s belongings', yes: false, no: false, remarks: '' },
          { form: 'Kasabutan "Good Performance"', yes: false, no: false, remarks: '' },
          { form: 'Kasabutan (Bulitas)', yes: false, no: false, remarks: '' },
          { form: 'Data Privacy Consent Form', yes: false, no: false, remarks: '' },
          { form: 'Talambuhay', yes: false, no: false, remarks: '' },
          { form: 'SFI', yes: false, no: false, remarks: '' },
          { form: 'Daily Journal', yes: false, no: false, remarks: '' },
        ];
      },
      async fetchData() {
    try {
      const response = await axios.get(`/api/checklist/${this.clientId}`);
      const clientData = response.data;
  
      // Initialize default checklist structure
      this.initializeForm();
  
      // Loop through the documents and map them into the checklist with sub-items
      if (Array.isArray(clientData.documents)) {
        clientData.documents.forEach(item => {
          const checklistItem = this.checklist.find(ch => ch.document === item.document);
          if (checklistItem) {
            checklistItem.yes = item.yes === 1 || item.yes === true;  // Ensure boolean
            checklistItem.no = item.no === 1 || item.no === true;     // Ensure boolean
            checklistItem.remarks = item.remarks;
  
            // Handle sub-items
            if (item.subItems) {
              checklistItem.subItems = item.subItems.map(subItem => ({
                document: subItem.document,
                yes: subItem.yes === 1 || subItem.yes === true, // Ensure boolean
                no: subItem.no === 1 || subItem.no === true,    // Ensure boolean
                remarks: subItem.remarks
              }));
            }
          }
        });
      }
  
      // Similarly, fetch and map rrForms
      if (Array.isArray(clientData.rrcy_forms)) {
        clientData.rrcy_forms.forEach(item => {
          const rrFormItem = this.rrForms.find(rr => rr.form === item.form);
          if (rrFormItem) {
            rrFormItem.yes = item.yes === 1 || item.yes === true;
            rrFormItem.no = item.no === 1 || item.no === true;
            rrFormItem.remarks = item.remarks;
          }
        });
      }
  
      this.admittingOfficer = clientData.admitting_officer || '';
      this.checklist_case_manager = clientData.checklist_case_manager || '';
  
    } catch (error) {
      console.error('Error fetching client data:', error);
    }
  }
  ,
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
      cancelEdit() {
        this.editMode = false;
      },
      confirmSave() {
        this.saveData();
        this.closeModal();
        this.editMode = false;
      },
      closeSaveResultModal() {
        this.isSaveResultModalOpen = false;
      },
      saveData() {
    if (!this.clientId) {
      this.message = 'No client selected.';
      this.messageType = 'error';
      return;
    }
  
    const payload = {
      client_id: this.clientId,
      admitting_officer: this.admittingOfficer,
      checklist_case_manager: this.checklist_case_manager,
      documents: this.checklist.map(item => ({
        document: item.document,
        yes: item.yes ? 1 : 0,   // Convert to number for backend
        no: item.no ? 1 : 0,     // Convert to number for backend
        remarks: item.remarks,
        subItems: item.subItems ? item.subItems.map(subItem => ({
          document: subItem.document,
          yes: subItem.yes ? 1 : 0,
          no: subItem.no ? 1 : 0,
          remarks: subItem.remarks
        })) : []  // Add sub-items if present
      })),
      rrcy_forms: this.rrForms.map(item => ({
        form: item.form,
        yes: item.yes ? 1 : 0,   // Convert to number for backend
        no: item.no ? 1 : 0,     // Convert to number for backend
        remarks: item.remarks
      })),
    };
  
    axios.post('/api/checklist', payload)
      .then(response => {
        this.showSaveResultModal('Success', 'Checklist saved successfully.');
        console.log('Checklist saved:', response.data);
      })
      .catch(error => {
        this.showSaveResultModal('Error', 'Error saving checklist. Please try again.');
        console.error('Error saving checklist:', error);
      });
  }
  
  
  ,
      showSaveResultModal(title, message) {
        this.saveResultTitle = title;
        this.saveResultMessage = message;
        this.isSaveResultModalOpen = true;
      },
      handleCheckboxChange(item, field) {
        if (field === 'yes' && item.yes) {
          item.no = false;
        } else if (field === 'no' && item.no) {
          item.yes = false;
        }
      },
      exportToPdf() {
    const pdf = new jsPDF('p', 'mm', [216, 356]); // Legal size: 216mm x 356mm
  
    // Add header and title
    pdf.setFont('TimesNewRoman', 'italic');
    pdf.setFontSize(11);
    pdf.setLineHeightFactor(1.5);
    const imgData = '/images/headerlogo2.png'; 
    pdf.addImage(imgData, 'PNG', 15, 10, 75, 35);
    pdf.setFontSize(8); 
    pdf.text('DSWD-GF-010A | REV 00 | 22 SEP 2023', 152, 24);
    pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
    pdf.setFont('arialbd', 'bold');
    pdf.setFontSize(18);
    pdf.text('Checklist Requirements During Admission', (pdf.internal.pageSize.width / 2) - 60, 54);
  
    pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
    pdf.setFont('Arial', 'normal'); 
    pdf.setFontSize(11); 
  
    // Function to draw a checkmark
    function drawCheckmark(pdf, x, y, boxSize) {
      pdf.setLineWidth(0.2); 
      pdf.setDrawColor(0, 0, 0); 
      pdf.line(x, y + (boxSize / 2) - 1, x + (boxSize / 3) - 3, y + boxSize - 2);
      pdf.line(x + (boxSize / 3) - 3, y + boxSize - 2, x + boxSize - 3, y + 1);
    }
  
    function drawCheckedBox(pdf, x, y, boxSize) {
      drawCheckmark(pdf, x, y, boxSize); 
    }
  
  // Footer function for the first page
  function addFirstPageFooter(pdf, totalPages) {
    const offset = 330; // Adjust according to the layout
  
    // Set bold font for the page number
    pdf.setFont('TimesNewRoman', 'bold');
    pdf.setFontSize(9);
    pdf.text(`PAGE 1 of ${totalPages}`, 108, offset + 9, null, null, 'center');
  
    // Add horizontal line
    pdf.setLineWidth(0.5);
    pdf.line(18, offset + 10, 174, offset + 10); // Horizontal line
  
    // Set normal font for the footer text
    pdf.setFont('TimesNewRoman', 'normal');
    pdf.setFontSize(9);
  
    // Add address information (in black)
    pdf.setTextColor(0, 0, 0);
    pdf.text(
      'DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Prk. 7 Bago-Oshiro, Tugbok Dist., Davao City',
      96, offset + 13, null, null, 'center'
    );
  
    // Add Email label (in black)
    pdf.text('Email:', 76, offset + 16, null, null, 'left');
  
    // Set blue color and underline for the email
    pdf.setTextColor(0, 0, 255); // Blue color
    pdf.textWithLink('rrcy.fo11@dswd.gov.ph', 85, offset + 16, { url: 'mailto:rrcy.fo11@dswd.gov.ph' });
  
    // Reset text color back to black and add the phone number
    pdf.setTextColor(0, 0, 0);
    pdf.text('Tel. No.: 293-0306', 117, offset + 16, null, null, 'left');
  
    // Add the footer image
    const footerImgData = '/images/footerimg.png'; // Ensure image path is correct and image is accessible
    pdf.addImage(footerImgData, 'PNG', 175, offset + 5, 25, 15); // Adjust the position and size as needed
  }
  
  
  // Footer function for pages 2 and beyond
  function addOtherPagesFooter(pdf, pageNumber, totalPages) {
    const offset = 330; // Adjust according to the layout
    pdf.setFont('TimesNewRoman', 'bold');
    pdf.setFontSize(9);
    pdf.text(`PAGE ${pageNumber} of ${totalPages}`, 108, offset + 9, null, null, 'center');
    pdf.setLineWidth(0.5);
    pdf.line(18, offset + 10, 198, offset + 10); // Horizontal line
  
    // Simple footer for other pages
    pdf.setFont('TimesNewRoman');
    pdf.setFontSize(9);
    pdf.text('DSWD | FIELD OFFICE XI | ADMINISTRATIVE DIVISION', 108, offset + 13, null, null, 'center');
  }
  
  // Function to apply footers based on page number
  function addAllFooters(pdf) {
    const totalPages = pdf.internal.getNumberOfPages(); // Get the total number of pages
    for (let i = 1; i <= totalPages; i++) {
      pdf.setPage(i);
      if (i === 1) {
        // First page footer
        addFirstPageFooter(pdf, totalPages);
      } else {
        // Other pages footer
        addOtherPagesFooter(pdf, i, totalPages);
      }
    }
  }
  
    // Table setup
    pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
    pdf.setFont('Arial', 'normal'); 
    const tableStartX = 18;
    let tableStartY = 68; 
    const colWidths = [12, 85, 12, 12, 65]; 
    const rowHeight = 10; 
    const checkBoxSize = 8; 
    const rightMarginX = 198; 
    const tableWidth = rightMarginX - tableStartX;
    const colWidthAdjustment = tableWidth - colWidths.reduce((acc, width) => acc + width, 0);
    colWidths[4] += colWidthAdjustment; 
  
    pdf.setLineWidth(0.2); 
    pdf.setDrawColor(50, 50, 50); 
  
    // Table Header
    pdf.setFillColor(0, 128, 0); 
    pdf.rect(tableStartX, tableStartY, tableWidth, rowHeight, 'F'); 
    pdf.setTextColor(255, 255, 255); 
    pdf.setFontSize(12);
  
    // Table Header content
    pdf.setFillColor(184, 231, 192);
    pdf.rect(tableStartX, tableStartY, colWidths[0], rowHeight, 'FD'); 
    pdf.rect(tableStartX + colWidths[0], tableStartY, colWidths[1], rowHeight, 'FD'); 
    pdf.rect(tableStartX + colWidths[0] + colWidths[1], tableStartY, colWidths[2], rowHeight, 'FD'); 
    pdf.rect(tableStartX + colWidths[0] + colWidths[1] + colWidths[2], tableStartY, colWidths[3], rowHeight, 'FD'); 
    pdf.rect(tableStartX + colWidths[0] + colWidths[1] + colWidths[2] + colWidths[3], tableStartY, colWidths[4], rowHeight, 'FD'); 
  
    // Header Text
    pdf.setTextColor(0, 0, 0); 
    pdf.setFontSize(12);
    pdf.text('No.', tableStartX + 3, tableStartY + 7);
    pdf.text('DOCUMENTS', tableStartX + colWidths[0] + 5, tableStartY + 7);
    pdf.text('YES', tableStartX + colWidths[0] + colWidths[1] + 2, tableStartY + 7); 
    pdf.text('NO', tableStartX + colWidths[0] + colWidths[1] + colWidths[2] + 2, tableStartY + 7); 
    pdf.text('REMARKS', tableStartX + colWidths[0] + colWidths[1] + colWidths[2] + colWidths[3] + 5, tableStartY + 7);
  
    pdf.setTextColor(0, 0, 0); 
    let y = tableStartY + rowHeight;
    let numberIndex = 1;
  
    // Max content height per page
    const maxPageContentHeight = 310;
  
    // Page break handler
    function handlePageBreak() {
    if (y + rowHeight > maxPageContentHeight) {
      pdf.addPage();
      pdf.setFontSize(8); 
      pdf.setFont('TimesNewRoman', 'italic'); 
      pdf.text('DSWD-GF-010A | REV 00 | 22 SEP 2023', 149, 20); 
      y = 30; // Reset y position after adding a new page
      pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
      pdf.setFont('Arial', 'normal'); 
      pdf.setFontSize(11);
    }
  }
  
    // Render remarks
    function renderRemarksAcrossPages(pdf, remarks, xPos, rowY, colWidths, tableStartX) {
    const splitRemarks = pdf.splitTextToSize(remarks, colWidths[4] - 4);
    let remainingRemarks = splitRemarks.slice(); 
    let currentPageContentHeight = maxPageContentHeight - y;
  
    const lineHeight = 7; // Approximate line height in mm
  
    while (remainingRemarks.length > 0) {
      if (currentPageContentHeight < rowHeight) {
        handlePageBreak(); 
        currentPageContentHeight = maxPageContentHeight - y; 
      }
  
      const linesToFit = Math.floor(currentPageContentHeight / lineHeight); // Number of lines that can fit in the remaining space
      const remarksToRender = remainingRemarks.splice(0, linesToFit);
  
      let remarksY = y + 7;
      remarksToRender.forEach(line => {
        pdf.text(line, xPos, remarksY);
        remarksY += lineHeight;
      });
  
      const calculatedHeight = remarksToRender.length * lineHeight;
  
      // Render the table row
      pdf.rect(tableStartX, y, colWidths[0], calculatedHeight + 10); 
      pdf.rect(tableStartX + colWidths[0], y, colWidths[1], calculatedHeight + 10); 
      pdf.rect(tableStartX + colWidths[0] + colWidths[1], y, colWidths[2], calculatedHeight + 10); 
      pdf.rect(tableStartX + colWidths[0] + colWidths[1] + colWidths[2], y, colWidths[3], calculatedHeight + 10); 
      pdf.rect(tableStartX + colWidths[0] + colWidths[1] + colWidths[2] + colWidths[3], y, colWidths[4], calculatedHeight + 10); 
  
      y += calculatedHeight;
      currentPageContentHeight -= calculatedHeight;
    }
  }
  
  
    // Main Row Loop
    this.checklist.forEach((item, index) => {
      handlePageBreak(); 
  
      const splitDocument = pdf.splitTextToSize(item.document, colWidths[1] - 4); 
      const documentLines = splitDocument.length;
      const calculatedHeight = Math.max(rowHeight, documentLines * 7); 
  
  
      pdf.text(String(numberIndex), tableStartX + 3, y + 7); 
      numberIndex++;
  
    
      let textY = y + 7; 
      splitDocument.forEach(line => {
        pdf.text(line, tableStartX + colWidths[0] + 2, textY); 
        textY += 5; 
      });
  
  
      if (item.yes) {
        drawCheckedBox(pdf, tableStartX + colWidths[0] + colWidths[1] + 4, y + 3, checkBoxSize); 
      }
  
    
      if (item.no) {
        drawCheckedBox(pdf, tableStartX + colWidths[0] + colWidths[1] + colWidths[2] + 4, y + 3, checkBoxSize); 
      }
  
      renderRemarksAcrossPages(pdf, item.remarks || '', tableStartX + colWidths[0] + colWidths[1] + colWidths[2] + colWidths[3] + 2, y, colWidths, tableStartX);
  
      y += calculatedHeight;
  
      // Handle sub-items like "a. Chest Xray" or "b. Fecalysis"
      if (item.subItems && item.subItems.length > 0) {
        item.subItems.forEach((subItem) => {
          handlePageBreak();
          const subSplitDocument = pdf.splitTextToSize(subItem.document, colWidths[1] - 4);
          const subDocumentLines = subSplitDocument.length;
          const subCalculatedHeight = Math.max(rowHeight, subDocumentLines * 7);
  
          pdf.text('', tableStartX + 3, y + 7); // Sub-items get a "-" marker instead of a number
  
        
          let subTextY = y + 7;
          subSplitDocument.forEach(line => {
            pdf.text(line, tableStartX + colWidths[0] + 2, subTextY);
            subTextY += 5;
          });
  
        
          if (subItem.yes) {
            drawCheckedBox(pdf, tableStartX + colWidths[0] + colWidths[1] + 4, y + 3, checkBoxSize); 
          }
  
        
          if (subItem.no) {
            drawCheckedBox(pdf, tableStartX + colWidths[0] + colWidths[1] + colWidths[2] + 4, y + 3, checkBoxSize); 
          }
  
          renderRemarksAcrossPages(pdf, subItem.remarks || '', tableStartX + colWidths[0] + colWidths[1] + colWidths[2] + colWidths[3] + 2, y, colWidths, tableStartX);
  
          y += subCalculatedHeight;
        });
      }
    });
  
    let rrFormsIndex = 1;
    pdf.setFont('Arial', 'normal'); 
    pdf.rect(tableStartX, y, tableWidth, rowHeight); 
    pdf.setFont('arialbd', 'bold'); 
    const text = 'RRCY FORMS';
    pdf.text(text, tableStartX - 15 + colWidths[0] + colWidths[1], y + 7); 
    pdf.setFont('Arial', 'normal'); 
    y += rowHeight;
  
    this.rrForms.forEach((form, index) => {
      handlePageBreak(); 
  
      pdf.text(String(rrFormsIndex), tableStartX + 3, y + 7); 
      rrFormsIndex++;
  
      pdf.text(form.form, tableStartX + colWidths[0] + 5, y + 7); 
  
      if (form.yes) {
        drawCheckedBox(pdf, tableStartX + colWidths[0] + colWidths[1] + 4, y + 3, checkBoxSize); 
      }
  
      if (form.no) {
        drawCheckedBox(pdf, tableStartX + colWidths[0] + colWidths[1] + colWidths[2] + 4, y + 3, checkBoxSize); 
      }
  
  
      // Render remarks for the form
      renderRemarksAcrossPages(pdf, form.remarks || '', tableStartX + colWidths[0] + colWidths[1] + colWidths[2] + colWidths[3] + 2, y, colWidths, tableStartX);
  
      y += rowHeight; 
    });
  
  // Ensure there's space for the signature section, otherwise add a page
  const signatureHeight = 1; // Approximate height required for each signature section (Admitting Officer or Case Manager)
  
  // First, check if there's space for the "Admitting Officer" section
  if (y + signatureHeight > maxPageContentHeight) {
    // Add a new page if there's not enough space
    pdf.addPage();
    // Reset the y position after adding a new page
    pdf.setFontSize(8); 
    pdf.setFont('TimesNewRoman', 'italic'); 
    pdf.text('DSWD-GF-010A | REV 00 | 22 SEP 2023', 149, 20); 
    y = 30;
    pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
    pdf.setFont('Arial', 'normal'); 
    pdf.setFontSize(11);
  }
  
  // "Admitting Officer" Section
  y += 10;
  pdf.setFontSize(12);
  pdf.text('Reviewed by:', 18, y);
  y += 10; // Adjust y position for input box
  
  // Draw underline and text for the 'Reviewed by' section (Admitting Officer)
  const admittingOfficerText = this.admittingOfficer || ''; // Use officer's name if available, otherwise blank
  const admittingOfficerWidth = pdf.getTextWidth(admittingOfficerText); // Get the width of the name text
  
  // If admittingOfficer name exists, draw it in bold and underline
  if (admittingOfficerText) {
    pdf.setFont('arialbd', 'bold'); // Set font to bold for officer name
    pdf.text(admittingOfficerText, 18, y); // Display officer's name
    pdf.line(18, y + 1, 18 + admittingOfficerWidth, y + 1); // Draw underline according to text width
  }
  
  // Label "Admitting Officer" below the underline, separated from the name
  pdf.setFont('Arial', 'normal'); // Revert font to normal for label
  pdf.text('Admitting Officer', 18, y + 6); // Display "Admitting Officer" label below the line
  y += 25; // Add space after the signature
  
  // Check if there's space for the "Case Manager" section
  if (y + signatureHeight > maxPageContentHeight) {
    // Add a new page if there's not enough space
    pdf.addPage();
    // Reset the y position after adding a new page
    pdf.setFontSize(8); 
    pdf.setFont('TimesNewRoman', 'italic'); 
    pdf.text('DSWD-GF-010A | REV 00 | 22 SEP 2023', 149, 20); 
    y = 30;
    pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
    pdf.setFont('Arial', 'normal'); 
    pdf.setFontSize(11);
  }
  
  // "Case Manager" Section
  y += -5;
  pdf.text('Received by:', 18, y);
  y += 10; // Adjust y position for input box
  
  // Draw underline and text for the 'Received by' section (Case Manager)
  const caseManagerText = this.checklist_case_manager || ''; // Use manager's name if available, otherwise blank
  const caseManagerWidth = pdf.getTextWidth(caseManagerText); // Get the width of the name text
  
  // If caseManager name exists, draw it in bold and underline
  if (caseManagerText) {
    pdf.setFont('arialbd', 'bold'); // Set font to bold for manager name
    pdf.text(caseManagerText, 18, y); // Display manager's name
    pdf.line(18, y + 1, 18 + caseManagerWidth, y + 1); // Draw underline according to text width
  }
  
  // Label "Case Manager" below the underline, separated from the name
  pdf.setFont('Arial', 'normal'); // Revert font to normal for label
  pdf.text('Case Manager', 18, y + 6); // Display "Case Manager" label below the line
  y += 25; // Add space after the signature
  
    addAllFooters(pdf);
    pdf.save(`checklist-rrcy-forms-${this.clientId}.pdf`);
  },
  
  
  
    },
    mounted() {
      this.clientId = this.$route.params.id;
      this.fetchData();
  }
  ,
    watch: {
      '$route.params.id': function(newId) {
        this.clientId = newId;
        this.fetchData();
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
  .a4-container {
    max-width: 210mm;
    padding: 10mm;
    background: white;
    border: 1px solid #ccc;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    page-break-after: always;
  }
  
  button {
    transition: background-color 0.3s;
    font-size: 0.75rem;
  }
  button:hover {
    background-color: #2563eb;
  }
  .bg-blue-500:checked {
    background-color: #2563eb;
  }
  .w-16 {
    width: 4rem; /* 64px */
  }
  .w-96 {
    width: 24rem; /* 384px */
  }
  textarea {
    min-height: 2.5rem; /* Minimum height for textarea */
    resize: vertical; /* Allows vertical resizing */
  }
  .border-black {
    border-color: #000 !important;
  }
  .text-xs {
    font-size: 0.75rem; /* Smaller font size */
  }
  </style>
  