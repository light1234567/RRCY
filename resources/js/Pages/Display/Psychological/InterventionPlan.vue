<template>
  <div v-if="editMode" class="flex absolute p-4 space-x-4">
    <button @click="cancelEdit" class="flex space-x-2 px-3 py-1 bg-customBlue text-white rounded-md text-xs">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      <span>Back</span>
    </button>
  </div>

  <div class="flex justify-end bg-transparent border border-gray-300 p-4 rounded-md space-x-4 mt-4">
    <Pagination :totalPages="totalPages" :currentPage="currentPage" @update:currentPage="updatePage" />
    <button @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.3 2.7a1 1 0 011.4 0l1.3 1.3a1 1 0 010 1.4l-9.4 9.4a1 1 0 01-.6.3l-2.8.6a1 1 0 01-1.2-1.2l.6-2.8a1 1 0 01.3-.6l9.4-9.4z" />
      </svg>
      <span>Edit</span>
    </button>

    <button v-if="editMode" @click="confirmSave" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg>
      <span>Save</span>
    </button>
  </div>

  <div class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
    <div class="relative flex justify-between items-center mb-2">
      <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
      <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
    </div>

    <div class="p-4">
      <h1 class="text-xl font-bold mb-1 text-center">INTERVENTION PLAN</h1>
      <h1 class="text-sm font-bold mb-4 text-center">PSYCHOLOGICAL SERVICE</h1>
      <div class="ml-16 flex justify-center items-center my-4">
        <p>As of:
          <input type="date" v-model="form.as_of_date" class="flex-grow border-b-0 border-black border-t-0 mr-4 border-l-0 border-r-0 rounded-none shadow-sm w-1/8 px-2 py-1" :readonly="!editMode" />
        </p>
      </div>

      <div v-if="message" :class="`p-2 mt-4 text-white rounded-md text-xs ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
        {{ message }}
      </div>

      <div class="mb-4 text-xs">
        <div class="grid grid-cols-2 gap-2">
          <div class="flex items-center">
            <label class="font-semibold w-1/5">Name:</label>
            <input type="text" v-model="clientName" :class="{'twinkle-border': editMode}" class="w-3/4 border border-transparent p-1" readonly>
          </div>
          <div class="flex items-center">
            <label class="font-semibold w-1/5">Age:</label>
            <input type="text" v-model="age" :class="{'twinkle-border': editMode}" class="w-3/4 border border-transparent p-1" readonly>
          </div>
          <div class="flex items-center">
            <label class="font-semibold w-1/5">Date Admitted:</label>
            <input type="date" v-model="dateAdmitted" :class="{'twinkle-border': editMode}" class="w-3/4 border border-transparent p-1" readonly>
          </div>
        </div>
      </div>

      <!-- Intervention Plan Table -->
      <table class="min-w-full bg-white border border-black text-xs">
        <thead>
          <tr>
            <th class="py-1 px-2 border-b border-r border-black">Objectives</th>
            <th class="py-1 px-2 border-b border-r border-black">Activities</th>
            <th class="py-1 px-2 border-b border-r border-black">Responsible Person</th>
            <th class="py-1 px-2 border-b border-r border-black">Time Frame</th>
            <th class="py-1 px-2 border-b border-r border-black">Expected Output</th>
            <th class="py-1 px-2 border-b border-black">Progress</th>
            <th v-if="editMode" class="py-1 px-2 border-b border-black">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in form.items" :key="index">
            <td class="py-1 px-2 border-b border-r border-black">
              <textarea v-model="item.objectives" :readonly="!editMode" class="w-full p-1 border border-transparent"></textarea>
            </td>
            <td class="py-1 px-2 border-b border-r border-black">
              <textarea v-model="item.activities" :readonly="!editMode" class="w-full p-1 border border-transparent"></textarea>
            </td>
            <td class="py-1 px-2 border-b border-r border-black">
              <input type="text" v-model="item.responsible_person" :readonly="!editMode" class="w-full p-1 border border-transparent" />
            </td>
            <td class="py-1 px-2 border-b border-r border-black">
              <input type="text" v-model="item.time_frame" :readonly="!editMode" class="w-full p-1 border border-transparent" />
            </td>
            <td class="py-1 px-2 border-b border-r border-black">
              <textarea v-model="item.expected_output" :readonly="!editMode" class="w-full p-1 border border-transparent"></textarea>
            </td>
            <td class="py-1 px-2 border-b border-black">
              <textarea v-model="item.progress" :readonly="!editMode" class="w-full p-1 border border-transparent"></textarea>
            </td>
            <td v-if="editMode" class="py-1 px-2 border-b border-black">
              <button @click="removeItem(index)" class="px-2 py-1 bg-red-500 text-white rounded-md text-xs">Remove</button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Add Row Button -->
      <div v-if="editMode" class="text-right mt-2">
        <button @click="addItem" class="px-3 py-1 bg-green-500 text-white rounded-md text-xs">
          Add New Row
        </button>
      </div>

      <!-- Progress Notes Section -->
      <div class="space-y-4 mt-6">
        <label for="progressNotes" class="block font-medium">Progress Notes:</label>
        <textarea v-model="form.progress_notes" :readonly="!editMode" class="block w-full p-2 border border-transparent"></textarea>
      </div>

      <!-- Signatures Section -->
      <div class="mt-4 grid grid-cols-3 gap-2 text-xs">
        <div>
          <label class="font-semibold">Prepared by:</label>
          <input type="text" v-model="form.prepared_by" :readonly="!editMode" class="w-full border border-transparent p-1" />
          <div class="text-xs mt-1">Psychologist I</div>
        </div>
        <div>
          <label class="font-semibold">Noted by:</label>
          <input type="text" v-model="center_head" :readonly="!editMode" class="w-full border border-transparent p-1" />          
          <div class="text-xs mt-1">SWO IV / Center Head</div>
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
</template>

<script>
import axios from 'axios';

export default {
  name: 'InterventionPlan',
  data() {
    return {
      form: {
        id: null,
        client_id: null,
        as_of_date: '',
        center_head: '',
        items: [
          {
            objectives: '',
            activities: '',
            responsible_person: '',
            time_frame: '',
            expected_output: '',
            progress: ''
          }
        ],
        progress_notes: '',
        prepared_by: '',
        noted_by: ''
      },
      clientName: '',
      age: '',
      dateAdmitted: '',
      editMode: false,
      message: '',
      messageType: '',
      isModalOpen: false,
      isSaveResultModalOpen: false,
      saveResultTitle: '',
      saveResultMessage: '',
      totalPages: 1,
      currentPage: 1
    };
  },
  mounted() {
    // Fetch data when the component is mounted
    const clientId = this.$route.params.id;
    console.log('Client ID on mounted:', clientId);
    this.fetchData(clientId);
  },
  watch: {
    '$route.params.id': function(newId) {
      console.log('Client ID changed to:', newId);
      this.fetchData(newId);
    }
  },
  methods: {
    fetchData(clientId) {
      if (!clientId) {
        console.error('Client ID is missing!');
        return;
      }

      console.log('Fetching client data for ID:', clientId);

      axios.get(`/api/clients/${clientId}`)
        .then(response => {
          console.log('Client data fetched:', response.data);
          this.fetchCenterHead(clientId);
          const client = response.data;

          this.clientName = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
          this.age = this.calculateAge(client.date_of_birth);
          this.dateAdmitted = client.admissions[0]?.date_admitted;

          this.form.client_id = client.id;
          console.log('Client ID set in form:', this.form.client_id);

          this.fetchPlanData(clientId);
        })
        .catch(error => {
          this.message = 'Error fetching data.';
          this.messageType = 'error';
          console.error('Error fetching client data:', error);
        });
    },
    fetchPlanData(clientId) {
      console.log('Fetching intervention plan data for client ID:', clientId);

      axios.get(`/api/psychological-intervention-plans/${clientId}`)
        .then(response => {
          console.log('Intervention plan data fetched:', response.data);
          if (response.data && response.data.plan) {
            this.form = {
              ...response.data.plan,
              items: response.data.plan.items || []
            };
          } else {
            this.resetForm(clientId);
          }
        })
        .catch(error => {
          console.error('Error fetching intervention plan:', error);
          this.resetForm(clientId);
        });
    },
    fetchCenterHead(clientId) {
    if (!clientId) {
      console.error("Client ID is missing.");
      return;
    }
    // Make an API request using the client ID
    axios.get(`/api/center-head/${clientId}`)
      .then(response => {
        this.center_head = response.data.center_head;
        console.log("Fetched center head:", this.center_head); // Log the center head
      })
      .catch(error => {
        console.error("Error fetching center head:", error);
      });
  },
  // Save center head
  saveCenterHead() {
    const clientId = this.$route.params.id;
    if (!this.center_head || !clientId) {
      return;
    }
    axios
      .put(`/api/update-center-head`, {
        center_head: this.center_head,
        client_id: clientId, // Use the correct client ID
      })
      .then(response => {
        this.editMode = false;
        this.fetchClientData(clientId); // Refetch the data to update the UI
      })
      .catch(error => {
        console.error("Error updating center head:", error);
      });
  },
    resetForm(clientId) {
      console.log('Resetting form for client ID:', clientId);
      this.form = {
        id: null,
        client_id: clientId,
        as_of_date: '',
        items: [
          {
            objectives: '',
            activities: '',
            responsible_person: '',
            time_frame: '',
            expected_output: '',
            progress: ''
          }
        ],
        progress_notes: '',
        prepared_by: '',
        noted_by: ''
      };
    },
    addItem() {
      this.form.items.push({
        objectives: '',
        activities: '',
        responsible_person: '',
        time_frame: '',
        expected_output: '',
        progress: ''
      });
      console.log('Item added to form:', this.form.items);
    },
    removeItem(index) {
      this.form.items.splice(index, 1);
      console.log('Item removed from form at index:', index, 'Remaining items:', this.form.items);
    },
    toggleEdit() {
      if (this.editMode) {
        this.openModal();
      } else {
        this.editMode = !this.editMode;
      }
      console.log('Edit mode toggled:', this.editMode);
    },
    openModal() {
      this.isModalOpen = true;
      console.log('Modal opened');
    },
    closeModal() {
      this.isModalOpen = false;
      console.log('Modal closed');
    },
    confirmSave() {
      this.saveData();
      this.saveCenterHead();
      this.closeModal();
    },
    cancelEdit() {
      this.editMode = false;
      console.log('Edit mode canceled');
    },
    saveData() {
      let url, method;

      if (!this.form.client_id) {
        this.form.client_id = this.$route.params.id;
      }

      if (this.form.id) {
        url = `/api/psychological-intervention-plans/${this.form.client_id}`;
        method = 'put';
      } else {
        url = `/api/psychological-intervention-plans`;
        method = 'post';
      }

      console.log('Saving data with method:', method, 'URL:', url);

      axios[method](url, this.form)
        .then(response => {
          if (!this.form.id) {
            this.form.id = response.data.id;
          }
          this.saveResultTitle = 'Success';
          this.saveResultMessage = 'Data saved successfully!';
          console.log('Data saved successfully:', response.data);
        })
        .catch(error => {
          if (error.response) {
            this.saveResultMessage = `Error saving data: ${error.response.data.message || 'An unexpected error occurred.'}`;
          } else if (error.request) {
            this.saveResultMessage = 'Error saving data: No response from server.';
          } else {
            this.saveResultMessage = `Error saving data: ${error.message}`;
          }
          this.saveResultTitle = 'Error';
          console.error('Error saving data:', error);
        })
        .finally(() => {
          this.isSaveResultModalOpen = true;
          this.editMode = false;
          console.log('Save result modal opened');
        });
    },
    updatePage(page) {
      this.currentPage = page;
      console.log('Page updated to:', page);
    },
    closeSaveResultModal() {
      this.isSaveResultModalOpen = false;
      this.saveResultTitle = '';
      this.saveResultMessage = '';
      console.log('Save result modal closed');
    },
    calculateAge(dob) {
      const birthDate = new Date(dob);
      const ageDiff = Date.now() - birthDate.getTime();
      const ageDate = new Date(ageDiff);
      return Math.abs(ageDate.getUTCFullYear() - 1970);
    }
  }
};
</script>



<style scoped>
button {
  transition: background-color 0.3s;
}
button:hover {
  background-color: #2563eb;
}
.twinkle-border {
  animation: twinkle 2s infinite;
}
@keyframes twinkle {
  0%, 100% { border-color: #a1b6cf; }
  50% { border-color: white; }
}
</style>
