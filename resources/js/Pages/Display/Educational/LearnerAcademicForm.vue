<template>

<div class="flex justify-end space-x-4 mb-4">
  <button @click="toggleEdit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
    <span v-if="!editMode">Edit</span>
    <span v-else>Cancel</span>
  </button>
  <button v-if="editMode" @click="submitForm" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
  Save
</button>

</div>

<!-- Success/Error Message -->
<div v-if="message" :class="messageType === 'success' ? 'bg-green-500' : 'bg-red-500'" class="mt-4 p-4 text-white rounded">
  {{ message }}
</div>

  <div class="max-w-3xl p-8 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
    <!-- Header Section with Logo and Document Details -->
    <div class="relative flex justify-between items-center mb-4">
      <img src="/images/headerlogo2.png" alt="Logo" class="h-24 w-48">
      <div class="text-right">
        <p class="item-center mr-6 text-sm font-semibold">PROTECTIVE SERVICES DIVISION</p>
        <p class="text-sm font-semibold">Regional Rehabilitation Center for Youth</p>
        <p class="mr-20 text-sm font-semibold">Youth/RFO XI</p>
        <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
      </div>
    </div>

    <form @submit.prevent="submitForm">


      <div class="text-center mb-6">
        <h1 class="font-bold text-xl">LEARNER’S ACADEMIC BEHAVIORAL FORM</h1>
        <div class="flex justify-center gap-4 mt-4">
          <div>
            <label for="month" class="block font-medium">For the Month of:</label>
            <input v-model="form.month" type="text" id="month" class="block w-32 p-1 border border-gray-300 mx-auto text-sm" />
          </div>
          <div>
            <label for="schoolYear" class="block font-medium">School Year:</label>
            <input v-model="form.school_year" type="text" id="schoolYear" class="block w-32 p-1 border border-gray-300 mx-auto text-sm" />
          </div>
        </div>
      </div>

      <div class="flex flex-wrap gap-4 mb-6">
        <div class="w-1/2 sm:w-1/3">
          <label for="learnerName" class="block font-medium text-sm">Learner’s Name:</label>
          <input v-model="form.learner_name" type="text" id="learnerName" class="block w-full p-1 border border-gray-300 text-sm" readonly />
        </div>
        <div class="w-1/2 sm:w-1/3">
          <label for="grade" class="block font-medium text-sm">Grade:</label>
          <input v-model="form.grade" type="text" id="grade" class="block w-full p-1 border border-gray-300 text-sm" />
        </div>
        <div class="w-1/2 sm:w-1/3">
          <label for="lrn" class="block font-medium text-sm">LRN:</label>
          <input v-model="form.lrn" type="text" id="lrn" class="block w-full p-1 border border-gray-300 text-sm" />
        </div>
        <div class="w-1/2 sm:w-1/3">
          <label for="status" class="block font-medium text-sm">Status:</label>
          <input v-model="form.status" type="text" id="status" class="block w-full p-1 border border-gray-300 text-sm" />
        </div>
      </div>

      <div class="mb-6">
        <table class="w-full border-collapse">
          <thead>
            <tr>
              <th class="border p-2 text-left">Learner Skill</th>
              <th class="border p-2">Outstanding</th>
              <th class="border p-2">Very Satisfactory</th>
              <th class="border p-2">Satisfactory</th>
              <th class="border p-2">Fairly Satisfactory</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, index) in form.skills" :key="index">
              <td class="border p-2">{{ row.skill }}</td>
              <td class="border p-2"><input v-model="row.outstanding" type="text" class="w-full p-1 border border-gray-300" /></td>
              <td class="border p-2"><input v-model="row.verySatisfactory" type="text" class="w-full p-1 border border-gray-300" /></td>
              <td class="border p-2"><input v-model="row.satisfactory" type="text" class="w-full p-1 border border-gray-300" /></td>
              <td class="border p-2"><input v-model="row.fairlySatisfactory" type="text" class="w-full p-1 border border-gray-300" /></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="mb-6">
        <label for="observationFeedback" class="block font-medium">Observation/Feedback:</label>
        <textarea v-model="form.observation_feedback" id="observationFeedback" rows="6" class="block w-full p-2 border border-gray-300"></textarea>
      </div>

      <div class="mb-6 flex gap-4">
        <div class="w-1/2">
          <label for="learnerSignature" class="block text-sm font-medium">Learner</label>
          <div class="flex items-center">
            <input
              v-model="form.learner_name"
              type="text"
              id="learner"
              class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm"
            >
          </div>
          <p class="text-sm mt-2">Learner</p>
        </div>

        <div class="w-1/2">
          <label for="categoryAdviserSignature" class="block text-sm font-medium">Category Adviser</label>
          <div class="flex items-center">
            <input
              v-model="form.category_adviser_signature"
              type="text"
              id="categoryAdviserSignature"
              class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm"
            >
          </div>
          <p class="text-sm mt-2">Category Adviser</p>
        </div>
      </div>

      <div class="mb-6 flex gap-4">
        <div class="w-1/2">
          <label for="educationalSectionHeadSignature" class="block text-sm font-medium">Educational Section Head</label>
          <div class="flex items-center">
            <input
              v-model="form.educational_section_head_signature"
              type="text"
              id="educationalSectionHeadSignature"
              class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm bg-gray-200"
              :readonly="!editMode"
            >
          </div>
          <p class="text-sm mt-2">Educational Section Head</p>
        </div>

        <div class="w-1/2">
          <label for="centerHeadSignature" class="block text-sm font-medium">Center Head</label>
          <div class="flex items-center">
            <input
              v-model="center_head"
              type="text"
              class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm bg-gray-200"
              :readonly="!editMode"
            >
          </div>
          <p class="text-sm mt-2">Center Head</p>
        </div>
      </div>

      
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'LearnerBehaviorForm',
  data() {
    return {
      form: {
        client_id: null,
        month: '',
        school_year: '',
        learner_name: '',
        grade: '',
        lrn: '',
        status: '',
        skills: [
          { skill: 'HOMEWORK COMPLETION', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
          { skill: 'STUDY SKILLS', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
          { skill: 'ORGANIZATIONAL SKILLS', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
          { skill: 'COOPERATIVE LEARNING SKILLS', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
          { skill: 'INDEPENDENT SEAT WORK', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
          { skill: 'MOTIVATION', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
          { skill: 'COMPLIANCE', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
        ],
        observation_feedback: '',
        learner_signature: '',
        category_adviser_signature: '',
        educational_section_head_signature: '',
        center_head_signature: '',
      },
      originalForm: null,
      editMode: false,
      center_head: '',
      message: '', 
      messageType: '', 
    };
  },
  mounted() {
    this.form.client_id = this.$route.params.id;
    if (!this.form.client_id) {
      console.error('client_id is missing in mounted. Cannot fetch the form data.');
    } else {
      this.fetchData();
    }
  },
  watch: {
    '$route.params.id': function (newId) {
      this.form.client_id = newId;
      this.fetchData();
    }
  },
  methods: {
    fetchData() {
      this.fetchCenterHead(this.form.client_id);
      if (!this.form.client_id) {
        console.error('client_id is missing. Cannot fetch the form data.');
        return;
      }

      axios.get(`/api/learner-academic-behavioral-forms/${this.form.client_id}`)
        .then(response => {
          if (response.data.form) {
            Object.assign(this.form, response.data.form);
            this.originalForm = JSON.parse(JSON.stringify(this.form));
            console.log('Form data loaded:', this.form);
          } else if (response.data.client) {
            this.form.learner_name = `${response.data.client.first_name} ${response.data.client.last_name}`;
            console.log('Client name loaded:', this.form.learner_name);
          }
        })
        .catch(error => {
          this.message = 'Error fetching data: ' + (error.response?.data || error.message);
          this.messageType = 'error';
          console.error('Error fetching data:', error.response?.data || error);
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

  submitForm() {
      this.saveCenterHead();
      if (!this.form.client_id) {
        this.message = 'Client ID is missing. Cannot submit the form.';
        this.messageType = 'error';
        console.error('client_id is missing. Cannot submit the form.');
        return;
      }

      const url = `/api/learner-academic-behavioral-forms`;
      
      axios.post(url, this.form)
        .then(response => {
          this.editMode = false;
          this.message = 'Form submitted successfully!';
          this.messageType = 'success'; // Set success message
          this.clearMessageAfterDelay();
          this.fetchData(); // Reload the form data
          console.log('Form submitted successfully:', response.data);

        })
        .catch(error => {
          this.message = 'Error saving data: ' + (error.response?.data || error.message);
          this.messageType = 'error'; // Set error message
          this.clearMessageAfterDelay();
          console.error('Error saving data:', error.response?.data || error);
        });
    },
    clearMessageAfterDelay() {
    setTimeout(() => {
      this.message = '';
    }, 3000); // Clear the message after 3 seconds
  },
    toggleEdit() {
      this.message = ''; // Clear any existing messages when toggling edit mode
      this.messageType = ''; // Clear message type as well
      this.editMode = !this.editMode;
    }
  }
};
</script>

<style scoped>
table {
  border-collapse: collapse;
}

th, td {
  padding: 8px;
  text-align: left;
}

input[type="text"], textarea {
  border-width: 1px;
}
</style>
      