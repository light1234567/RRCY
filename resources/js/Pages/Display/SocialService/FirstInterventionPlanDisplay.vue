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
  
  <!-- Add Row Button -->


  <!-- Pagination Component -->
  <Pagination :totalPages="totalPages" :currentPage="currentPage" @update:currentPage="updatePage" />
  <button v-if="editMode" @click="addItem" class="flex items-center space-x-2 px-3 py-1 bg-customBlue text-white rounded-md text-xs">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" />
    </svg>
    <span>Add Row</span>
  </button>
  <!-- Edit Button -->
  <button @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
    <i class="fas fa-edit w-4 h-4"></i>
    <span>Edit</span>
  </button>

  <!-- Save Button (shown only in edit mode) -->
  <button v-if="editMode" @click="openModal" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
    <i class="fas fa-check w-4 h-4"></i>
    <span>Save</span>
  </button>

  <!-- Export to PDF Button -->
  <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 text-white rounded-md text-xs">
    <i class="fas fa-file-pdf w-4 h-4"></i>
    <span>Export PDF</span>
  </button>

</div>


  <div class="graph-background p-0.5 -mr-9 -mb-16">

  <div v-if="currentPage === 1">
    <div class="max-w-3xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
      <div class="relative flex justify-between items-center mb-2">
        <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
        <p class="text-[10px] -mt-10" style="font-family: 'Times New Roman', Times, serif; font-style: italic;">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
      </div>
      <div class="p-4">
        <h1 class="text-2xl font-bold mb-4 text-center">Helping/Intervention Plan</h1>

        <div v-if="message" :class="`p-2 mt-4 text-white rounded-md text-xs ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
          {{ message }}
        </div>
        <div class="mb-4 text-xs">
          <div class="grid grid-cols-2 gap-2">
            <div class="flex items-center">
              <label class="font-semibold w-1/5">Name:</label>
              <input type="text" v-model="plan.name" :class="{'twinkle-border': editMode}" class="w-3/4 border border-transparent p-1" readonly>
            </div>
            <div class="flex items-center">
              <label class="font-semibold w-1/5">Age:</label>
              <input type="text" v-model="plan.age" :class="{'twinkle-border': editMode}" class="w-3/4 border border-transparent p-1" readonly>
            </div>
            <div class="flex items-center">
              <label class="font-semibold w-1/5">Period:</label>
              <input type="text" v-model="plan.period" :class="{'twinkle-border': editMode}" class="w-3/4 border border-transparent p-1" :readonly="!editMode">
            </div>
            <div class="flex items-center relative">
              <label class="font-semibold w-1/5">Date Prepared:</label>
              <input type="date" v-model="plan.date_prepared" :class="{'twinkle-border': editMode}" class="w-3/4 border border-transparent p-1" :readonly="!editMode">
              <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" @click="openCalendar">
                
              </span>
            </div>
          </div>
        </div>
        <table class="min-w-full bg-white border border-black text-xs">
  <thead>
    <tr>
      <th class="py-1 px-2 border-b border-r border-black">Objectives</th>
      <th class="py-1 px-2 border-b border-r border-black">Activities</th>
      <th class="py-1 px-2 border-b border-r border-black">Time Frame</th>
      <th class="py-1 px-2 border-b border-r border-black">Responsible Person</th>
      <th class="py-1 px-2 border-b border-r border-black">Expected Outcome</th>
      <th class="py-1 px-2 border-b border-black">Remarks</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(item, index) in plan.items" :key="item.id || index" class="hover:bg-gray-100">
      <td class="py-1 px-2 border-b border-r border-black">
        <textarea v-model="item.objectives" 
          :class="{'twinkle-border': editMode}" 
          class="w-full p-1 resize-none overflow-hidden bg-transparent border-none" 
          :readonly="!editMode" 
          @input="adjustHeight($event)">
        </textarea>
      </td>
      <td class="py-1 px-2 border-b border-r border-black">
        <textarea v-model="item.activities" 
          :class="{'twinkle-border': editMode}" 
          class="w-full p-1 resize-none overflow-hidden bg-transparent border-none" 
          :readonly="!editMode" 
          @input="adjustHeight($event)">
        </textarea>
      </td>
      <td class="py-1 px-2 border-b border-r border-black">
        <textarea v-model="item.time_frame" 
          :class="{'twinkle-border': editMode}" 
          class="w-full p-1 resize-none overflow-hidden bg-transparent border-none" 
          :readonly="!editMode" 
          @input="adjustHeight($event)">
        </textarea>
      </td>
      <td class="py-1 px-2 border-b border-r border-black">
        <textarea v-model="item.responsible_person" 
          :class="{'twinkle-border': editMode}" 
          class="w-full p-1 resize-none overflow-hidden bg-transparent border-none" 
          :readonly="!editMode" 
          @input="adjustHeight($event)">
        </textarea>
      </td>
      <td class="py-1 px-2 border-b border-r border-black">
        <textarea v-model="item.expected_outcome" 
          :class="{'twinkle-border': editMode}" 
          class="w-full p-1 resize-none overflow-hidden bg-transparent border-none" 
          :readonly="!editMode" 
          @input="adjustHeight($event)">
        </textarea>
      </td>
      <td class="py-1 px-2 border-b border-black">
        <textarea v-model="item.remarks" 
          :class="{'twinkle-border': editMode}" 
          class="w-full p-1 resize-none overflow-hidden bg-transparent border-none" 
          :readonly="!editMode" 
          @input="adjustHeight($event)">
        </textarea>
      </td>
    </tr>
  </tbody>
</table>

      
        <div class="mt-4 grid grid-cols-3 gap-2 text-xs">
          <div>
            <label class="font-semibold">Prepared by:</label>
            <input type="text" v-model="plan.prepared_by" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode">
            <div class="text-xs mt-1">Social Welfare Officer I</div>
          </div>
          <div>
            <label class="font-semibold">Conformed by:</label>
            <input type="text" v-model="plan.conformed_by" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode">
            <div class="text-xs mt-1">Resident</div>
          </div>
          <div>
            <label class="font-semibold">Noted by:</label>
            <input type="text" v-model="center_head" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode">
            <div class="text-xs mt-1">Center Head/ SWO IV</div>
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
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';

export default {
  components: {
    Pagination
  },
  data() {
    return {
      editMode: false,
      message: '',
      messageType: '',
      clientId: null,
      isModalOpen: false,
      totalPages: 1,
      currentPage: 1,
      isSaveResultModalOpen: false,
      saveResultTitle: '',
      saveResultMessage: '',
      center_head: '',
      emptyRows: 5, 
      plan: {
        id: null,
        name: '',
        age: '',
        period: '',
        date_prepared: '',
        prepared_by: '',
        conformed_by: '',
        items: [
          { objectives: '', activities: '', time_frame: '', responsible_person: '', expected_outcome: '', remarks: '' },
        ],
      },
    };
  },
  methods: {
    fetchClientData() {
  axios.get(`/api/clients/${this.clientId}`)
    .then(response => {
      const client = response.data;
      this.plan.name = `${client.first_name} ${client.last_name}`;
      this.plan.age = this.calculateAge(client.date_of_birth);

      return axios.get(`/api/intervention-plans/${this.clientId}`);
    })
    .then(response => {
      const clientPlan = response.data;

      this.plan.id = clientPlan.id;
      this.plan.period = clientPlan.period;
      this.plan.date_prepared = clientPlan.date_prepared;
      this.plan.prepared_by = clientPlan.prepared_by || '';
      this.plan.conformed_by = clientPlan.conformed_by || '';

      // Assign the JSON items directly to the plan.items array
      this.plan.items = clientPlan.items ? clientPlan.items : [];

      // Update the total pages for pagination
      this.updateTotalPages();
    })
    .catch(error => {
      console.error('Error fetching client data:', error);
    });

  console.log('Fetched client ID:', this.clientId);
}
,
    fetchCenterHead(clientId) {
  if (!clientId) {
    console.error("Client ID is missing.");
    return;
  }
  // Make an API request using the client ID
  axios.get(`/api/center-head/${clientId}`)  // Updated endpoint to match the route
    .then(response => {
      this.center_head = response.data.center_head;
      console.log("Fetched center head:", this.center_head); // Log the center head
    })
    .catch(error => {
      console.error("Error fetching center head:", error);
    });
},
saveCenterHead() {
  if (!this.center_head || !this.clientId) {
    return;
  }
  axios
    .put(`/api/update-center-head`, {
      center_head: this.center_head,
      client_id: this.clientId, // Pass the client ID instead of admission ID
    })
    .then(response => {
      this.editMode = false;
      this.fetchClientData(); // Refetch the data to update the UI
    })
    .catch(error => {
      console.error("Error updating center head:", error);
    });
},
    calculateAge(birthDate) {
      const today = new Date();
      const birthDateObj = new Date(birthDate);
      let age = today.getFullYear() - birthDateObj.getFullYear();
      const monthDiff = today.getMonth() - birthDateObj.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDateObj.getDate())) {
        age--;
      }
      return age;
    },
    updateTotalPages() {
      const itemsPerPage = 10; // Assuming each page can show up to 10 items
      this.totalPages = Math.ceil(this.plan.items.length / itemsPerPage);
    },
    updatePage(page) {
      this.currentPage = page;
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
    confirmSave() {
      this.saveData();
      this.saveCenterHead();
      this.closeModal();
      this.editMode = false;
    },
    cancelEdit() {
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
    period: this.plan.period,
    date_prepared: this.plan.date_prepared,
    prepared_by: this.plan.prepared_by,
    conformed_by: this.plan.conformed_by,
    center_head: this.center_head,
    items: this.plan.items, // Send items as an array
  };

  const method = this.plan.id ? 'put' : 'post';
  const url = `/api/intervention-plans${this.plan.id ? '/' + this.plan.id : ''}`;

  axios[method](url, payload)
    .then(response => {
      this.saveResultTitle = 'Success';
      this.saveResultMessage = 'Data saved successfully.';
      if (!this.plan.id) {
        this.plan.id = response.data.id;
      }
      this.editMode = false;
    })
    .catch(error => {
      this.messageType = 'error';
      this.saveResultTitle = 'Error';
      this.saveResultMessage = error.response.data.message || 'An error occurred while saving data.';
      console.error('Error saving data:', error);
    })
    .finally(() => {
      this.isModalOpen = false;
      this.isSaveResultModalOpen = true;
    });
}

,
    addItem() {
        // Add a new item with no `id` (new items should not have an `id` before saving to the database)
        const newItem = {
            objectives: '',
            activities: '',
            time_frame: '',
            responsible_person: '',
            expected_outcome: '',
            remarks: ''
        };

        // Replace the array to avoid using .push()
        this.plan.items = [...this.plan.items, newItem]; xxxxxxx
    },
    openCalendar() {
      document.querySelector('input[type="date"]').showPicker();
    },
    exportToPdf() {
      const element = document.querySelector('.max-w-3xl'); // Select the element you want to export
      html2canvas(element).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('p', 'pt', 'a4');
        const imgWidth = 595.28;
        const pageHeight = 841.89;
        const imgHeight = canvas.height * imgWidth / canvas.width;
        let heightLeft = imgHeight;

        let position = 0;
        pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        while (heightLeft >= 0) {
          position = heightLeft - imgHeight;
          pdf.addPage();
          pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
          heightLeft -= pageHeight;
        }
        pdf.save(`${this.plan.name}_Intervention_Plan.pdf`);
      });
    },
    printPage() {
      window.print();
    },
  },
  mounted() {
    this.clientId = this.$route.params.id;
    this.fetchClientData();
    this.fetchCenterHead(this.clientId);
  },
  watch: {
    '$route.params.id': function(newId) {
      this.clientId = newId;
      this.fetchClientData();
      this.fetchCenterHead(this.clientId);
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
button {
  transition: background-color 0.3s;
}
button:hover {
  background-color: #2563eb;
  color: white;
}
.bg-green-500:hover {
  background-color: #38a169;
}
@keyframes twinkle {
  0%, 100% { border-color: #a1b6cf; }
  50% { border-color: white; }
}
.twinkle-border {
  animation: twinkle 2s infinite;
}
textarea {
  min-height: 40px;  /* Set a minimum height for readability */
  max-height: 300px;  /* Optional: limit how tall the textarea can grow */
  line-height: 1.5;
}

textarea:focus {
  outline: none;  /* Remove the outline when focused */
}

</style>
