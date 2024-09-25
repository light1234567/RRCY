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

    <!-- Download PDF Button 
    <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 text-white rounded-md text-xs">
    
      <i class="fas fa-file-pdf w-4 h-4"></i>
      <span>Export PDF</span>
    </button> -->
</div>
  
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
        <div class="text-xs font-semibold pt-12">
  <p class="text-sm">
  DRN
  <input type="text" v-model="drn" class="underline-input text-sm p-1" :readonly="!editMode" />
</p>
</div>      </div>
    </div>
    <h1 class="font-bold text-md">MONTHLY INVENTORY OF BELONGINGS</h1>
    <p class="text-sm">
  FOR THE MONTH OF
  <input type="text" v-model="form.month" class="underline-input text-sm p-1" :readonly="!editMode" />
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
          <input type="text" v-model="item.name" class="w-full p-1 border-b-2 border-transparent rounded-none" :readonly="!editMode">
        </td>
        <td class="border border-gray-300 p-2">
          <input type="number" v-model.number="item.qty" class="w-full p-1 border-b-2 border-transparent rounded-none" :readonly="!editMode">
        </td>
        <td class="border border-gray-300 p-2">
          <input type="text" v-model="item.brand" class="w-full p-1 border-b-2 border-transparent rounded-none" :readonly="!editMode">
        </td>
        <td class="border border-gray-300 p-2">
          <input type="text" v-model="item.size" class="w-full p-1 border-b-2 border-transparent rounded-none" :readonly="!editMode">
        </td>
        <td class="border border-gray-300 p-2">
          <input type="text" v-model="item.color" class="w-full p-1 border-b-2 border-transparent rounded-none" :readonly="!editMode">
        </td>
        <td class="border border-gray-300 p-2">
          <input type="text" v-model="item.old" class="w-full p-1 border-b-2 border-transparent rounded-none" :readonly="!editMode">
        </td>
        <td class="border border-gray-300 p-2">
          <input type="text" v-model="item.new" class="w-full p-1 border-b-2 border-transparent rounded-none" :readonly="!editMode">
        </td>
        <td class="border border-gray-300 p-2">
          <input type="text" v-model="item.remarks" class="w-full p-1 border-b-2 border-transparent rounded-none" :readonly="!editMode">
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
    <button @click="addNewRow" class="px-4 py-2 bg-green-500 text-white rounded-md text-xs">
      Add New Row
    </button>
  </div>
</div>


  <!-- Name and Signature of Houseparent -->
  <div class="mb-6 flex justify-between items-center">
    <div class="w-1/2 mr-12">
      <label for="preparedBy" class="block text-sm font-medium">Prepared by:</label>
      <div class="flex items-center">
        <input
          type="text"
          id="preparedBy"
          v-model="form.houseparent_name"
          class="mt-1 w-3/4 underline-input shadow-sm"
          :readonly="!editMode"
        >
      </div>
      <p class="text-sm mt-2">Name and Signature of Houseparent</p>
    </div>

    <!-- Name and Signature of Residents -->
    <div class="w-1/2">
      <label for="signatureResidents" class="block font-medium invisible">Prepared by:</label>
      <div class="flex items-center">
        <input
          type="text"
          id="signatureResidents"
          v-model="form.resident_name"
          class="mt-1 w-3/4 underline-input shadow-sm"
          :readonly="!editMode"
        >
      </div>
      <p class="text-sm mt-2">Name & Signature of Residents</p>
    </div>
  </div>

  <div class="mb-6 flex justify-between items-start">
    <!-- Noted by Section -->
    <div class="w-1/2 mr-12">
      <label for="notedBy" class="block text-sm font-medium">Noted by:</label>
      <input type="text" v-model="shp" 
    class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm w-1/3 px-2 mt-12 py-1 text-xs" 
    :readonly="!editMode"/>      
    <p class="text-sm">HP III/SHP</p>
    </div>
  </div>

<!-- Footer Section -->
<div class=" pt-4 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        <div class="flex flex-col">
          <p class="font-bold">PAGE 1 of 1</p>
          <p class="border-t border-black pt-2">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
          <p>Email: <span class="text-blue-600 underline">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
        </div>
        <div>
          <img src="/images/footerimg.png" alt="Footer Image" class="h-12 w-24 object-cover">
        </div>
      </div>
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
</div>
</div>
</template>

<script>
import axios from 'axios';
import Pagination from '@/Components/Pagination.vue';

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
      month: '',
      resident_name: '',
      houseparent_name: '',
      items: [
        { name: '', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        // add other items as necessary
      ]
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
    shp: '',
    drn: '',
  };
},
mounted() {
  const clientId = this.$route.params.id;
    this.fetchData(clientId);
    this.fetchSHP(clientId);
    this.fetchDrn(clientId);
},
watch: {
  '$route.params.id': function(newId) {
      this.fetchData(newId);
      this.fetchSHP(newId);
      this.fetchDrn(newId);
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
            this.form.month = response.data.report.month;
            this.form.resident_name = response.data.report.resident_name;
            this.form.houseparent_name = response.data.report.houseparent_name;
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
  fetchSHP(clientId) {
    if (!clientId) {
      console.error("Client ID is missing.");
      return;
    }
    axios.get(`/api/shp/${clientId}`)
      .then(response => {
        this.shp = response.data.shp || '';
        console.log("Fetched SHP:", this.shp);
      })
      .catch(error => {
        console.error("Error fetching SHP:", error);
      });
  },
  saveSHP() {
    const clientId = this.$route.params.id;
    console.log("Saving SHP:", this.shp, "for client:", clientId);
    if (!clientId) {
      console.error("Client ID is missing.");
      return;
    }
    axios.put(`/api/update-shp/${clientId}`, { 
      client_id: clientId,
      name: this.shp
    })
    .then(response => {
      console.log("SHP saved successfully:", response.data);
      this.editMode = false;
      this.fetchSHP(clientId);
    })
    .catch(error => {
      console.error("Error updating SHP:", error);
    });
  }
,
fetchDrn(clientId) {
  if (!clientId) {
    console.error("Client ID is missing.");
    return;
  }
  // Fetch DRN based on clientId
  axios.get(`/api/drn/${clientId}`)
    .then(response => {
      this.drn = response.data.drn || ''; // Set DRN to the response, or an empty string if not present
      console.log("Fetched DRN:", this.drn);
    })
    .catch(error => {
      console.error("Error fetching DRN:", error);
    });
},


saveDrn() {
  const clientId = this.form.client_id; // Ensure client_id is available in the form
  if (!clientId) {
    console.error("Client ID is missing.");
    return;
  }

  // Save or update DRN
  axios.post('/api/drn', {
    client_id: clientId, // Pass the client_id
    drn: this.drn // Pass the DRN value
  })
  .then(response => {
    console.log("DRN saved successfully:", response.data);
    this.fetchDrn(clientId); // Fetch updated DRN after save
  })
  .catch(error => {
    console.error("Error saving DRN:", error.response.data); // Log detailed error message
  });
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
    this.saveSHP();
    this.saveDrn();
    this.closeModal();
  },

  cancelEdit() {
    if (this.originalForm) {
      this.form = JSON.parse(JSON.stringify(this.originalForm)); // Revert to the original form state
    }
    this.editMode = false; // Exit edit mode
  },

  submitForm() {
if (!this.form.client_id) {
  this.message = 'Client ID is required.';
  this.messageType = 'error';
  return;
}

const isUpdate = this.form.id !== null;
const url = isUpdate
  ? `/api/monthly-inventories` // Update URL
  : `/api/monthly-inventories`; // Create URL (same as update URL but different HTTP method)

const method = isUpdate ? 'put' : 'post'; // Decide HTTP method

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
  });
}
,

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
