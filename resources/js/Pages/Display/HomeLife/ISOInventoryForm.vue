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
  
      
  
  
      <button v-if="editMode" @click="submitForm" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
        <!-- FontAwesome for Save -->
        <i class="fas fa-check w-4 h-4"></i>
        <span>Save</span>
      </button>
      
      <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 text-white rounded-md text-xs">
        <i class="fas fa-file-pdf w-4 h-4"></i>
        <span>Export PDF</span>
      </button>
  
      <!-- Download PDF Button 
      <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 text-white rounded-md text-xs">
      
        <i class="fas fa-file-pdf w-4 h-4"></i>
        <span>Export PDF</span>
      </button> -->
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
    
  <form ref="InventoryForm" @submit.prevent="submitForm">
    <!-- Header Section -->
    <div class="graph-background pt-0.5  -mr-9 -mb-16">
  
    <div class="max-w-3xl mx-auto mt-8 p-12 bg-white border border-gray-400 rounded-lg shadow-lg">
    <div class="text-center mb-8">
      <div class="flex justify-between items-center mb-4">
        <img src="/images/headerlogo2.png" alt="DSWD Logo"  class="h-32 w-64 -mt-16 relative z-10" />
        <div class="text-right">
          <p class="item-center mr-6 text-sm font-semibold">PROTECTIVE SERVICES DIVISION</p>
          <p class=" text-sm font-semibold">Regional Rehabilitation Center for Youth</p>
          <p class="mr-20 text-sm font-semibold">Youth/RFO XI</p>
          <p class=" text-xs font-italic text-center flex justify-center">DSWD-GF-010 | REV 02 | 17 AUG 2022</p>
          <div class="text-xs font-semibold pt-12">
    <p class="text-sm">
    DRN
    <input type="text" v-model="form.drn" class="underline-input text-sm p-1" :readonly="!editMode" />
  </p>
  </div>      </div>
      </div>
      <h1 class="font-bold text-md">MONTHLY INVENTORY OF BELONGINGS</h1>
      <p class="text-sm">
    FOR THE MONTH OF
    <select 
  v-model="form.month" 
  class="underline-input text-sm p-1" 
  :disabled="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please select a month') }" 
  required
>
    <option value="" disabled>Select Month</option>
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


  </p>  </div>
  
    <!-- Inventory Table -->
    <div class="overflow-x-auto mb-6">
    <table class="w-full border-collapse border border-gray-300">
      <thead>
        <tr class="bg-gray-200">
          <th class="border border-gray-300 p-2 text-left">Item</th>
          <th class="border border-gray-300 p-2 text-left">Qty</th>
          <th class="border border-gray-300 p-2 text-left">Brand</th>
          <th class="border border-gray-300 p-2 text-left">Size</th>
          <th class="border border-gray-300 p-2 text-left">Color</th>
          <th class="border border-gray-300 p-2 text-left">Old</th>
          <th class="border border-gray-300 p-2 text-left">New</th>
          <th class="border border-gray-300 p-2 text-left">Remarks</th>
          <th v-if="editMode" class="border border-gray-300 p-2 text-left">Action</th> <!-- Conditionally Visible Action Column -->
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in form.items" :key="index">
          <td class="border border-gray-300 p-2">
            <input type="text" v-model="item.name" class="w-full p-1 border-b-2 border-transparent rounded-none" :readonly="!editMode" maxlength="20">
          </td>
          <td class="border border-gray-300 p-2">
            <input min="0" type="number" v-model.number="item.qty" class="w-full p-1 border-b-2 border-transparent rounded-none" :readonly="!editMode">
          </td>
          <td class="border border-gray-300 p-2">
            <input type="text" v-model="item.brand" class="w-full p-1 border-b-2 border-transparent rounded-none" :readonly="!editMode" maxlength="20">
          </td>
          <td class="border border-gray-300 p-2">
            <input type="text" v-model="item.size" class="w-full p-1 border-b-2 border-transparent rounded-none" :readonly="!editMode" maxlength="10">
          </td>
          <td class="border border-gray-300 p-2">
            <input type="text" v-model="item.color" class="w-full p-1 border-b-2 border-transparent rounded-none" :readonly="!editMode" maxlength="10">
          </td>
          <td class="border border-gray-300 p-2">
            <input type="text" v-model="item.old" class="w-full p-1 border-b-2 border-transparent rounded-none" :readonly="!editMode" maxlength="10">
          </td>
          <td class="border border-gray-300 p-2">
            <input type="text" v-model="item.new" class="w-full p-1 border-b-2 border-transparent rounded-none" :readonly="!editMode" maxlength="10" >
          </td>
          <td class="border border-gray-300 p-2">
            <input type="text" v-model="item.remarks" class="w-full p-1 border-b-2 border-transparent rounded-none" :readonly="!editMode" maxlength="150">
          </td>
          <td v-if="editMode" class="border border-gray-300 p-2">
            <!-- Remove Button -->
            <button @click="removeItem(index)" class="px-2 py-1 bg-red-500 text-white rounded-md text-xs">
              Remove
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Button to Add New Row -->
    <div v-if="editMode" class="mt-4 text-right">
  <button type="button" @click="addNewRow" class="px-4 py-2 bg-green-500 text-white rounded-md text-xs">
    Add New Row
  </button>
</div>
  </div>
  
  
    <!-- Name and Signature of Houseparent -->
    <div class="mb-6 flex justify-between items-center">
      <div class="w-1/2  mr-12">
        <label for="preparedBy" class="mb-6 block text-sm font-medium">Prepared by:</label>
        <div class="flex items-center">
          <input
            type="text"
            id="preparedBy"
            v-model="form.houseparent_name"
            class="mt-1 w-3/4 underline-input shadow-sm"
            :readonly="!editMode"
            maxlength="50"
          >
        </div>
        <p class="text-sm mt-2">Name and Signature of Houseparent</p>
      </div>
  
      <!-- Name and Signature of Residents -->
      <div class="w-100% justify-last">
        <label for="signatureResidents" class="block font-medium invisible">Prepared by:</label>
        <div class="flex items-center">
          <input
            type="text"
            id="signatureResidents"
            v-model="form.resident_name"
            class="mt-1 w-3/4 underline-input shadow-sm"
            :readonly="!editMode"
            maxlength="50"
          >
        </div>
        <p class="text-sm mt-2">Name & Signature of Residents</p>
      </div>
    </div>
  
    <div class="mb-6 flex justify-center items-center">
      <!-- Noted by Section -->
      <div class=" ">
        <label for="notedBy" class="block text-sm font-medium">Noted by:</label>
        <input type="text" v-model="form.inventory_shp" 
      class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm w-100% px-2 mt-12 py-1 text-xs text-center" 
      :readonly="!editMode"
      maxlength="50"/>      
      <p class="text-sm flex-wrap justify-center text-center w-100%">HP III/SHP</p>
      </div>
    </div>
  
  <!-- Footer Section -->
  <div class=" pt-4 text-center text-xs " style="font-family: 'Times New Roman', Times, serif;">
        <div class="flex justify-center w-full items-center">
          <div class="flex flex-col">
            <p class="mr-6 font-bold text-center ">PAGE 1 of 1</p>
            <p class="border-t border-black pt-2 text-[10px]">DSWD Field Office XI, Ramon Magsaysay Corner D. Suazo Street, Davao City, Philippines 8000</p>
            <p>Website:<span class="text-blue-600 underline"> http://www.rrcy.fo11@dswd.gov.ph Tel Nos.: (082) 293-03-06</span></p>
          </div>
          <div>
            <img src="/images/footerimg.png" alt="Footer Image" class="h-12 w-24 object-cover">
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
  import 'jspdf-autotable'; // Optional for table generation
  
  export default {
  name: 'MonthlyInventoryForm',
  components: {
    Pagination,
  },
  data() {
    return {
      form: {
        id: null,
        client_id: null,
        drn: '',
        month: '',
        resident_name: '',
        houseparent_name: '',
        inventory_shp: '',
        items: [],
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
      this.fetchData(clientId);
  },
  watch: {
    '$route.params.id': function(newId) {
        this.fetchData(newId);
    }
  },
  methods: {
    addNewRow() {
      this.form.items.push({
        name: '',
        description: '',
        qty: '',
        brand: '',
        size: '',
        color: '',
        old: '',
        new: '',
        remarks: ''
      });
    },
  
    fetchData() {
      const clientId = this.$route.params.id;
      console.log('Fetching data for client ID:', clientId); // Debugging
      if (clientId) {
        axios.get(`/api/monthly-inventories/${clientId}`)
          .then(response => {
            console.log('Fetch data response:', response.data); // Debugging
            if (response.data.inventory) {
              this.form = response.data.inventory;
              this.form.client_id = clientId;
              this.originalForm = JSON.parse(JSON.stringify(this.form)); // Capture the original state
            } else {
              const { client } = response.data;
              this.form.client_id = client.id;
            }
          })
          .catch(error => {
            console.error('Error fetching data:', error); // Debugging
            console.error('Error response data:', error.response?.data); // More detailed logging
          });
      }
    },
  
  removeItem(index) {
        this.form.items.splice(index, 1);
        console.log('Item removed from form at index:', index, 'Remaining items:', this.form.items);
      },
    toggleEdit() {
      if (this.editMode) {
        this.openModal();
      } else {
        this.originalForm = JSON.parse(JSON.stringify(this.form)); // Capture the current form state
        this.editMode = true;
      }
    },
  
    openModal() {
      this.isModalOpen = true;
    },
  
    closeModal() {
      this.isModalOpen = false;
    },
  
    confirmSave() {
      this.submitForm();
      this.closeModal();
    },
  
    cancelEdit() {
      if (this.originalForm) {
        this.form = JSON.parse(JSON.stringify(this.originalForm)); // Revert to the original form state
      }
      this.editMode = false; // Exit edit mode
    },
  
    submitForm() {
  // Ensure client_id exists before proceeding
  if (!this.form.client_id) {
    this.message = 'Client ID is required.';
    this.messageType = 'error';
    return;
  }

  const form = this.$refs.InventoryForm; // Reference to the form for validation
  let isFormValid = true;

  // Validate the form and check for any invalid fields
  if (!form.checkValidity()) {
    isFormValid = false;
    form.reportValidity(); // Show validation messages and focus on the first invalid field
  }

  // If all fields are valid, open the confirmation modal
  if (isFormValid) {
    this.isModalOpen = true;  // Open the modal to confirm saving
  } else {
    console.warn('Form contains invalid fields. Please correct them.');
  }
},

confirmSave() {
  const isUpdate = this.form.id !== null;
  const url = `/api/monthly-inventories`; // Same URL for both update and create actions

  // Use PUT for updating and POST for creating new records
  const method = isUpdate ? 'put' : 'post';
  
  console.log(`Submitting form with method ${method} to URL:`, url); // Debugging
  console.log('Form data being submitted:', this.form); // Debugging

  axios({ method, url, data: this.form })
    .then(response => {
      console.log('Form submission successful:', response.data); // Debugging
      this.editMode = false;
      this.message = isUpdate ? 'Data updated successfully!' : 'Data created successfully!';
      this.messageType = 'success';
      this.saveResultTitle = 'Success';
      this.saveResultMessage = isUpdate ? 'Data updated successfully.' : 'Data created successfully.';
      this.isSaveResultModalOpen = true;
      this.clearMessage();
      this.fetchData(); // Re-fetch data to update the form with the latest saved data
    })
    .catch(error => {
      console.error('Form submission failed:', error); // Debugging
      console.error('Error response data:', error.response?.data); // More detailed logging
      console.error('Error response status:', error.response?.status); // Status code
      console.error('Error response headers:', error.response?.headers); // Response headers
      this.message = 'Failed to save data';
      this.messageType = 'error';
      this.saveResultTitle = 'Error';
      this.saveResultMessage = error.response?.data?.message || 'Error saving data.';
      this.isSaveResultModalOpen = true;
      this.clearMessage();
    })
    .finally(() => {
      this.isModalOpen = false; // Close the confirmation modal
    });
},

  
    clearMessage() {
      setTimeout(() => {
        this.message = '';
        this.messageType = '';
      }, 3000);
    },
  
    closeSaveResultModal() {
      this.isSaveResultModalOpen = false;
      this.saveResultTitle = '';
      this.saveResultMessage = '';
    },
  
    exportToPdf() {
      const pdf = new jsPDF('p', 'mm', [216, 356]); // Create a new PDF document
      const pageHeight = pdf.internal.pageSize.getHeight(); 
      const marginBottom = 30; // Space for footer
      const footerHeight = 20; // Space for footer
      let currentY = 40; // Start Y position for content
      let currentPage = 1; // Track current page
  
      const addHeader = () => {
          pdf.setFontSize(10);
          pdf.setFont('Arial', 'bold');
          pdf.text('PROTECTIVE SERVICES DIVISION', 160, 20, { align: 'center' });
          pdf.text('REGIONAL REHABILITATION CENTER FOR YOUTH', 160, 25, { align: 'center' });
          pdf.text('Youth/RFO XI', 160, 30, { align: 'center' });
          pdf.setFontSize(9);
          pdf.setFont('Times', 'italic');
          pdf.text('DSWD-GF-010 | REV 02 | 17 AUG 2022', 135, 35);
          pdf.line(10,37,200,37);
      };
  
      const addFooter = () => {
          pdf.setFontSize(9);
          pdf.setFont('Times', 'normal');
          pdf.text('DSWD Field Office XI, Ramon Magsaysay Corner D. Suazo Street, Davao City, Philippines 8000', 105, pageHeight - marginBottom + 10, { align: 'center' });
          pdf.text('Website: http://www.rrcy.fo11@dswd.gov.ph Tel Nos.: (082) 293-03-06', 105, pageHeight - marginBottom + 15, { align: 'center' });
      };
  
      const addPage = () => {
          
          if (currentY+100 >= (pageHeight - marginBottom - footerHeight)) {
        addFooter(); // Add footer before new page
        pdf.addPage(); // Create new page
        currentY = 40; // Reset Y position for new page
        currentPage++;
      }
      };
  
      // Add header to the first page
      addHeader();
  
      // DSWD logo
      const imgData = '/images/headerlogo2.png';
      pdf.addImage(imgData, 'PNG', 10, 5, 70, 40); // Adjust the width and height
  
      // Set the title
      pdf.setFontSize(16);
      pdf.setFont('Arial', 'bold');
      pdf.text("Monthly Inventory of Belongings", 105, 55, "center");
  
      // Add month and DRN
      pdf.setFontSize(12);
      pdf.text(`For the Month of: ${this.form.month||''}`, 105, 60, "center");
      pdf.line(120, 61, 145, 61);
      pdf.text(`DRN: ${this.form.drn||''}`, 135, 45);
      pdf.line(145, 46, 200, 46);
  
      // Table Headers
      const headers = [
          ["Item", "Qty", "Brand", "Size", "Color", "Old", "New", "Remarks"]
      ];
  
      // Table Rows (map over form items)
      const rows = this.form.items.map(item => [
          item.name, item.qty, item.brand, item.size, item.color, item.old, item.new, item.remarks
      ]);
  
      // Add the table
      pdf.autoTable({
          head: headers,
          body: rows,
          startY: 70, // Adjust as necessary to fit with other content
          margin: { top: 20, bottom: 30 }, // Add margin for the table
          theme: 'grid',
          styles: { fontSize: 10, fillColor: [255, 255, 255], textColor: 0 }, // Set background color to white and text color to black
          headStyles: { fillColor: [192, 192, 192], textColor: 0 }, // Set header background to light gray and text color to black
          didDrawPage: function (data) {
              if (data.pageCount > currentPage) {
                
                  addFooter(); // Ensure footer on each page
              }
          },
      });
      
      
  
      // Add signatures and notes after the table
      currentY = pdf.autoTable.previous.finalY + 20;
      addPage ();
  
  
      pdf.setFontSize(11);
      pdf.setFont('Arial', 'normal');

  
      pdf.text(`${this.form.resident_name||''}`, 45, currentY, "center");
      pdf.line(20, currentY + 1, 75, currentY + 1);
      pdf.text('Name & Signature of Resident', 20, currentY + 5);
  
      pdf.text(`${this.form.houseparent_name|| ''}`, 160, currentY, "center");
      pdf.line(128, currentY + 1, 190, currentY + 1);
      pdf.text('Name & Signature of Houseparent', 160, currentY + 5, "center");
  
      pdf.text('Noted by:', 105, currentY + 20, "center");
      pdf.text(`${this.form.inventory_shp||''}`, 105, currentY + 30, "center");
  
      
      addFooter();
      // Page number handling
    const totalPages = pdf.internal.getNumberOfPages();
    for (let i = 1; i <= totalPages; i++) {
      pdf.setPage(i);
      pdf.setFontSize(9);
      pdf.setFont('Times', 'bold');
      pdf.text(`PAGE ${i} of ${totalPages}`, 105, pageHeight - marginBottom + 5, { align: 'center' });
      addFooter();
      marginBottom;
    }
  
  
      // Save the PDF
      pdf.save(`Monthly_Inventory_${this.form.month}.pdf`);
  }
  
  
  
  
  
    
  }
  };
  </script>
  
  
  
  <style scoped>
  .underline-input {
  border: none;
  border-bottom:  1px solid black;
  padding: 0;
  margin: 0;
  vertical-align: bottom; /* Ensures the text aligns with the bottom of the input */
  }
  .graph-background {
      background-image: linear-gradient(to right, #cccccc 1px, transparent 1px), 
                        linear-gradient(to bottom, #cccccc 1px, transparent 1px);
      background-size: 15px 15px; /* Adjust size as per your need */
    } 
  </style>
  