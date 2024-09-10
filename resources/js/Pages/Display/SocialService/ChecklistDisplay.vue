<template>

  <!-- Tabs for Actions -->
  <div v-if="editMode" class="flex absolute p-6 -mt-2 space-x-4">
    <button @click="cancelEdit" class="flex space-x-2 px-3 py-1 bg-customBlue text-white rounded-md text-xs">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      <span class="">Back</span>
    </button>
  </div>

  <div class="flex justify-end bg-transparent border border-gray-300 p-4 rounded-md space-x-4 mt-4">
    <!-- Pagination Component -->
    <Pagination 
      :totalPages="totalPages" 
      :currentPage="currentPage" 
      @update:currentPage="currentPage = $event" 
    />
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
  <div v-if="currentPage === 1" class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
    <div class="relative flex justify-between items-center mb-2">
      <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
      <p class="text-[8px]">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
    </div>

    <h1 class="text-2xl font-bold mb-4 text-center text-black">Checklist of Requirements during Admission</h1>
    <div v-if="message" :class="`p-2 mt-2 text-white rounded-md text-xs ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
      {{ message }}
    </div>
    <table class="min-w-full bg-white border border-black mt-2 text-xs">
  <thead>
    <tr class="bg-green-400">
      <th class="py-1 px-2 border border-black">No.</th>
      <th class="py-1 px-2 border border-black">Documents</th>
      <th class="py-1 px-2 border border-black w-16">Yes</th>
      <th class="py-1 px-2 border border-black w-16">No</th>
      <th class="py-1 px-2 border border-black w-96">Remarks</th>
    </tr>
  </thead>
  <tbody>
    <template v-for="(item, index) in checklist" :key="index">
      <!-- Only number the main items -->
      <tr class="hover:bg-gray-100">
        <td class="py-1 px-2 border border-black">{{ item.isSubItem ? '' : index + 1 }}</td>
        <td class="py-1 px-2 border border-black">{{ item.document }}</td>
        <td class="py-1 px-2 border border-black">
          <input type="checkbox" v-model="item.yes" :disabled="!editMode" @change="handleCheckboxChange(item, 'yes')" />
        </td>
        <td class="py-1 px-2 border border-black">
          <input type="checkbox" v-model="item.no" :disabled="!editMode" @change="handleCheckboxChange(item, 'no')" />
        </td>
        <td class="py-1 px-2 border border-black">
          <textarea v-model="item.remarks" class="w-full border border-transparent p-1 text-xs" :readonly="!editMode"></textarea>
        </td>
      </tr>

      <!-- Render sub-items if they exist -->
      <tr v-if="item.subItems" v-for="(subItem, subIndex) in item.subItems" :key="subIndex" class="hover:bg-gray-100">
        <td class="py-1 px-2 border border-black"></td> <!-- Empty for sub-items -->
        <td class="py-1 px-2 border border-black">{{ subItem.document }}</td>
        <td class="py-1 px-2 border border-black">
          <input type="checkbox" v-model="subItem.yes" :disabled="!editMode" @change="handleCheckboxChange(subItem, 'yes')" />
        </td>
        <td class="py-1 px-2 border border-black">
          <input type="checkbox" v-model="subItem.no" :disabled="!editMode" @change="handleCheckboxChange(subItem, 'no')" />
        </td>
        <td class="py-1 px-2 border border-black">
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
          <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
          <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
        </div>
        <div class="ml-4">
          <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
        </div>
      </div>
    </div>
  </div>

  <!-- Page 2 of 2 -->
  <div v-if="currentPage === 2" class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
    <h2 class="text-lg font-semibold -mt-2 mb-2 text-center">RRCY Forms</h2>
    <table class="min-w-full bg-white border border-black text-xs">
      <thead>
        <tr class="bg-green-400">
          <th class="py-1 px-2 border border-black">No.</th>
          <th class="py-1 px-12 border border-black">Forms</th>
          <th class="py-1 px-2 border border-black w-16">Yes</th>
          <th class="py-1 px-2 border border-black w-16">No</th>
          <th class="py-1 px-2 border border-black w-96">Remarks</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in rrForms" :key="index" class="hover:bg-gray-100">
          <td class="px-2 border border-black">{{ index + 1 }}</td>
          <td class="px-2 border border-black">{{ item.form }}</td>
          <td class="px-2 border border-black">
            <input type="checkbox" v-model="item.yes" :disabled="!editMode" @change="handleCheckboxChange(item, 'yes')" />
          </td>
          <td class="px-2 border border-black">
            <input type="checkbox" v-model="item.no" :disabled="!editMode" @change="handleCheckboxChange(item, 'no')" />
          </td>
          <td class="px-2 border border-black">
            <textarea v-model="item.remarks" class="w-full border border-gray-300 p-1 text-xs" :readonly="!editMode"></textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="footer mt-4">
    <p class="text-sm mb-4">Reviewed by:</p>
    <p class="text-sm mb-4">
      <input v-model="admittingOfficer" class="w-full border border-black p-1 text-sm" :readonly="!editMode" />
      <br>Admitting Officer
    </p>
    <p class="text-sm mb-4">Received by:</p>
    <p class="text-sm">
      <input v-model="caseManager" class="w-full border border-black p-1 text-sm" :readonly="!editMode" />
      <br>Case Manager
    </p>

      <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
        <div class="flex justify-between items-center">
          <div class="flex flex-col">
            <p class="ml-24 -mb-4 font-bold">PAGE 2 of {{ totalPages }}</p>
            <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
            <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
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
import Pagination from '@/Components/Pagination.vue';
import { jsPDF } from 'jspdf';

export default {
  components: {
    Pagination
  },
  data() {
    return {
      editMode: false,
      admittingOfficer: '',
      caseManager: '',
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
    this.caseManager = clientData.case_manager || '';

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
    case_manager: this.caseManager,
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
      const pdf = new jsPDF('p', 'mm', 'a4'); // Standard A4 size document
      pdf.setFont('helvetica', 'normal');
      pdf.setFontSize(11);

      // Add header
      const imgData = '/images/headerlogo2.png'; 
      pdf.addImage(imgData, 'PNG', 15, 10, 50, 30); 
      pdf.setFontSize(10);
      pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 135, 30);

      // Page 1 content
      pdf.setFont('helvetica', 'bold');
      pdf.setFontSize(18);
      pdf.text('Checklist of Requirements during Admission', 105, 60, null, null, 'center');

      pdf.setFont('helvetica', 'normal');
      pdf.setFontSize(11);

      // Table headers
      pdf.text('No.', 20, 80);
      pdf.text('Documents', 40, 80);
      pdf.text('Yes', 140, 80);
      pdf.text('No', 160, 80);
      pdf.text('Remarks', 180, 80);

      // Table content for checklist
      this.checklist.forEach((item, index) => {
        const offset = 90 + (index * 10);
        pdf.text(`${index + 1}`, 20, offset);
        pdf.text(`${item.document}`, 40, offset);
        if (item.yes) {
          pdf.text('✔', 140, offset);
        }
        if (item.no) {
          pdf.text('✔', 160, offset);
        }
        pdf.text(`${item.remarks}`, 180, offset);
      });

      pdf.addPage(); // Add a new page for Page 2

      // Page 2 content
      pdf.setFont('helvetica', 'bold');
      pdf.setFontSize(18);
      pdf.text('RRCY Forms', 105, 20, null, null, 'center');

      pdf.setFont('helvetica', 'normal');
      pdf.setFontSize(11);

      // Table headers
      pdf.text('No.', 20, 40);
      pdf.text('Forms', 40, 40);
      pdf.text('Yes', 140, 40);
      pdf.text('No', 160, 40);
      pdf.text('Remarks', 180, 40);

      // Table content for RRCY forms
      this.rrForms.forEach((item, index) => {
        const offset = 50 + (index * 10);
        pdf.text(`${index + 1}`, 20, offset);
        pdf.text(`${item.form}`, 40, offset);
        if (item.yes) {
          pdf.text('✔', 140, offset);
        }
        if (item.no) {
          pdf.text('✔', 160, offset);
        }
        pdf.text(`${item.remarks}`, 180, offset);
      });

      // Add Admitting Officer and Case Manager
      pdf.text('Reviewed by: ' + this.admittingOfficer, 20, 250);
      pdf.text('Admitting Officer', 20, 255);
      pdf.text('Received by: ' + this.caseManager, 150, 250);
      pdf.text('Case Manager', 150, 255);

      // Footer
      pdf.setFontSize(10);
      pdf.text('DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY)', 105, 290, null, null, 'center');
      pdf.text('Email: rrxy.fo11@dswd.gov.ph    Tel. No.: 293-0306', 105, 295, null, null, 'center');

      const footerImgData = '/images/footerimg.png';
      pdf.addImage(footerImgData, 'PNG', 160, 285, 30, 15);

      pdf.save(`checklist-rrcy-forms-${this.clientId}.pdf`);
    }
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
