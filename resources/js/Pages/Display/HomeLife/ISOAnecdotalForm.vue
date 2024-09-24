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

   <div class="flex justify-end bg-transparent border border-gray-300 p-4 rounded-md space-x-4 mt-2">
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
   </div>

 <div class="max-w-3xl mx-auto mt-12 p-16 bg-white border border-gray-300 rounded-lg shadow-lg">
   <!-- Header Section -->
   <div class="text-center mb-8">
     <div class="flex justify-between items-center mb-4">
       <img src="/images/headerlogo2.png" alt="DSWD Logo" class="h-32 w-64 -mt-16 relative z-10" />
       <div class="text-right">
         <p class="item-center mr-6 text-sm font-semibold">PROTECTIVE SERVICES DIVISION</p>
         <p class=" text-sm font-semibold">Regional Rehabilitation Center for Youth</p>
         <p class="mr-20 text-sm font-semibold">Youth/RFO XI</p>
         <div class="text-xs font-semibold pt-12">
  <p class="text-sm">
  DRN
  <input type="text" v-model="drn" class="underline-input text-sm p-1" :readonly="!editMode" />
</p>
</div>
       </div>
     </div>
     <h1 class="font-bold text-md">ANECDOTAL REPORT</h1>
     <p class="text-sm">
  FOR THE MONTH OF
  <input type="text" v-model="form.month" class="underline-input text-sm p-1" :readonly="!editMode" />
</p>
   </div>

   <!-- General Information -->
   <div class="grid grid-cols-2 gap-6 mb-6">
     <div class="flex items-center text-sm">
 <label for="pangalan" class="block font-medium w-auto mr-2">Pangalan:</label>
 <input
   type="text"
   id="pangalan"
   v-model="form.name"
   readonly
   class="border-transparent text-sm underline-input p-2 w-full"
 >
</div>
     <div class="flex items-center">
       <label for="date" class="block font-medium w-auto mr-2 text-sm ">Petsa:</label>
       <input
         type="date"
         id="date"
         v-model="form.date"
         class=" border-transparent text-sm underline-input p-2 w-28"
         :readonly="!editMode"
       >
     </div>
   </div>

   <!-- Report Sections -->
   <div class="space-y-4 mb-6">
     <div>
       <label for="physical" class="block font-medium">
         <span class="font-bold text-sm">I. PHYSICAL :</span> 
         <span class="font-normal text-sm"> Management of personal hygiene and improvement of self-care habits.</span>
       </label>
       <textarea
         id="physical"
         v-model="form.physical"
         class="border border-gray-400 p-2 rounded-md w-full"
         rows="3"
         :readonly="!editMode"
       ></textarea>
     </div>

     <div>
       <label for="emotional" class="block font-medium">
         <span class="font-bold text-sm">II. EMOTIONAL :</span> 
         <span class="font-normal text-sm justify-text"> The degree to which the resident displayed his coping capacity towards ill/guilty feelings and feelings of helplessness.</span>
       </label>
      
       <textarea
         id="emotional"
         v-model="form.emotional"
         class="border border-gray-400 p-2 rounded-md w-full"
         rows="3"
         :readonly="!editMode"
       ></textarea>
     </div>

     <div>
       <label for="behavioral" class="block font-medium">
         <span class="font-bold text-sm">III. SOCIAL/BEHAVIORAL :</span> 
         <span class="font-normal text-sm justify-text"> The level to which the resident demonstrated honesty, self-control, and a sense of responsibility.</span>
       </label>
       <textarea
         id="behavioral"
         v-model="form.behavioral"
         class="border border-gray-400 p-2 rounded-md w-full"
         rows="3"
         :readonly="!editMode"
       ></textarea>
     </div>

     <div>
       <label for="spiritual" class="block font-medium">
         <span class="font-bold text-sm">IV. SPIRITUAL :</span> 
         <span class="font-normal text-sm justify-text"> Attitude displayed towards the acceptance of the present situation.</span>
       </label>
       <textarea
         id="spiritual"
         v-model="form.spiritual"
         class="border border-gray-400 p-2 rounded-md w-full"
         rows="3"
         :readonly="!editMode"
       ></textarea>
     </div>

     <div>
       <label for="recommendation" class="block text-sm font-semibold">V. RECOMMENDATION:</label>
       <textarea
         id="recommendation"
         v-model="form.recommendation"
         class="border border-gray-400 p-2 rounded-md w-full"
         rows="3"
         :readonly="!editMode"
       ></textarea>
     </div>
   </div>

   <!-- Color and Prepared by -->
   <div class="mb-6 ">
     <!-- Color Field -->
     <div class="flex items-center mb-4">
       <label for="color" class="block text-sm font-medium mr-4">Color:</label>
       <input
         type="text"
         id="color"
         v-model="form.color"
         class=" w-1/4 underline-input text-sm p-0 shadow-sm"
         :readonly="!editMode"
       >
     </div>
     </div>
     <!-- Prepared by Field -->
    <!-- Name and Signature of Houseparent -->
    <div class="mb-6 flex justify-between items-center">
     <div class="w-1/2 mr-12">
       <label for="preparedBy" class="block text-sm font-medium">Prepared by:</label>
       <div class="flex items-center">
         <input
           type="text"
           id="preparedBy"
           v-model="form.prepared_by"
           class="mt-1 w-3/4 underline-input text-sm shadow-sm"
           :readonly="!editMode"
         >
       </div>
       <p class="text-sm mt-2">Name and Signature of Houseparent</p>
     </div>

     <!-- Name and Signature of Residents -->
     <div class="w-1/2">
       <label for="signatureResidents" class="block font-medium invisible">Prepared by:</label>
       <div class="font-semibold flex items-center">
         <input
           type="text"
           id="signatureResidents"
           v-model="form.name"
           class="mt-1 w-3/4 underline-input text-sm shadow-sm"
           :readonly="!editMode"
         >
       </div>
       <p class="text-sm mt-2">Name & Signature of Residents</p>
     </div>
   </div>

     <!-- Noted by and Approved by -->
   <div class="mb-6 flex justify-between items-start">
     <!-- Noted by Section -->
     <div class="w-1/2 mr-12">
       <label for="notedBy" class="block text-sm font-medium">Noted by:</label>
       <input
         type="text"
         id="notedBy"
         v-model="shp"
         class="mt-1 w-3/4 underline-input text-sm shadow-sm"
         :readonly="!editMode"
       >
       <p class="text-sm">HP III/SHP</p>
     </div>

     <!-- Approved by Section -->
     <div class="w-1/2">
       <label for="approvedBy" class="block text-sm font-medium">Approved by:</label>
       <input
         type="text"
         id="notedBy"
         v-model="center_head"
         class="mt-1 w-3/4 underline-input text-sm shadow-sm"
         :readonly="!editMode"
       >
       <p class="text-sm">SWO IV / Center Head</p>
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
</template>


<script>
import axios from 'axios';
import Pagination from '@/Components/Pagination.vue';

export default {
 name: 'AnecdotalReportForm',
 components: {
   Pagination,
 },
 data() {
   return {
    center_head: '',
    drn: '',
    shp: '',
     form: {
       client_id: null,
       name: '',
       date: '',
       month: '',
       color: '',
       physical: '',
       emotional: '',
       behavioral: '',
       spiritual: '',
       recommendation: '',
       noted_by: 'VAN M. DE LEON',
       approved_by: 'ANGELIC B. PAÑA',
       prepared_by: '',
       signature_residents: '',
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
   this.fetchCenterHead(clientId);
   this.fetchSHP(clientId);
   this.fetchDrn(clientId);
   this.fetchData(clientId);
 },
 watch: {
    '$route.params.id': function(newId) {
      this.fetchCenterHead(newId);
     this.fetchSHP(newId);
     this.fetchDrn(newId);
     this.fetchData(newId);
   }
 },
 methods: {
  fetchData(clientId) {
  if (!clientId) return;
  console.log('Fetching data for client ID:', clientId);

  axios.get(`/api/anecdotal-reports/${clientId}`).then(response => {
    console.log('API Response:', response.data); // Add this to check the response

    if (response.data.report) {
      // Populate form if report exists
      Object.assign(this.form, response.data.report);
      this.form.client_id = clientId;
      this.form.month = response.data.report.month;
      this.form.name = `${response.data.client.first_name} ${response.data.client.last_name}`; // Ensure correct field mapping
      this.originalForm = JSON.parse(JSON.stringify(this.form)); // Store original form
    } else {
      // If no report, fetch client info
      const { client } = response.data;
      this.form.client_id = client.id;
      this.form.name = `${client.first_name} ${client.last_name}`;
      this.originalForm = JSON.parse(JSON.stringify(this.form)); // Store original form
    }
  }).catch(error => {
    console.error('Error fetching data:', error);
  });
}
,
   fetchCenterHead(clientId) {
     if (!clientId) {
       console.error("Client ID is missing.");
       return;
     }
     axios.get(`/api/center-head/${clientId}`).then(response => {
       this.center_head = response.data.center_head;
       console.log("Fetched center head:", this.center_head); 
     }).catch(error => {
       console.error("Error fetching center head:", error);
     });
   },

   saveCenterHead() {
     const clientId = this.$route.params.id; 
     if (!this.center_head || !clientId) {
       return;
     }
     axios.put(`/api/update-center-head`, {
       center_head: this.center_head,
       client_id: clientId,
     }).then(() => {
       this.fetchData(clientId); 
     }).catch(error => {
       console.error("Error updating center head:", error);
     });
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
  },
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
       this.editMode = true;
       this.originalForm = JSON.parse(JSON.stringify(this.form)); // Store the original form data before editing
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
     this.saveCenterHead();
     this.saveSHP();
     this.saveDrn();
     this.closeModal();
   },

   cancelEdit() {
     if (this.originalForm) {
       // Revert to the original data
       this.form = JSON.parse(JSON.stringify(this.originalForm));
     }
     this.editMode = false; // Exit edit mode
   },

   submitForm() {
     const url = `/api/anecdotal-reports/${this.form.client_id}`;

  // Avoid fetching and losing current data. Use form directly.
  axios.put(url, this.form)
    .then(response => {
      this.message = 'Data updated successfully!';
      this.messageType = 'success';
      this.fetchData(); // Refresh data, but ensure you're not wiping out other fields.
    })
    .catch(error => {
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

   updatePage(newPage) {
     this.currentPage = newPage;
     // Add logic to fetch data or change content based on the page
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
</style>