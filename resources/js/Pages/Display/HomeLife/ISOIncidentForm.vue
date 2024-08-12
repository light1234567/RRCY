<template>
  <div class="mx-auto p-8 bg-gray-100 rounded-lg max-w-full">
    <form @submit.prevent="submitForm" class="space-y-8 w-full">
      <!-- Header -->
      <div class="border border-gray-300 p-6 rounded-md bg-white">
        <h1 class="font-bold text-lg mb-4">Incident Report Form</h1>

        <!-- Edit/Save Button -->
        <div class="flex justify-end mb-4 mt-6">
          <button
            v-if="!editMode"
            @click="toggleEdit"
            type="button"
            class="px-4 py-2 bg-blue-500 text-white rounded-md"
          >
            Edit
          </button>
          <button
            v-else
            @click="submitForm"
            type="button"
            class="px-4 py-2 bg-green-500 text-white rounded-md"
          >
            Save
          </button>
        </div>

        <!-- Message -->
        <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
          {{ message }}
        </div>

        <!-- General Information -->
        <div class="space-y-2">
          <label for="drn" class="block font-medium">DRN:</label>
          <input 
            type="text" 
            id="drn" 
            v-model="form.drn" 
            required 
            class="block w-full p-2 border border-gray-300 rounded-md" 
            :readonly="!editMode"
          >
        </div>

        <!-- Incident Details -->
        <div class="space-y-4 mt-6">
          <div class="space-y-2">
            <label for="incident" class="block font-medium">What was the incident:</label>
            <textarea 
              id="incident" 
              v-model="form.incident" 
              class="block w-full p-2 border border-gray-300 rounded-md" 
              rows="4" 
              :readonly="!editMode"
            ></textarea>
          </div>
          
          <div class="text-center font-medium mt-4">
            WHEN IT HAPPENED
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            <div class="space-y-2">
              <label for="dateOfIncident" class="block font-medium">Date of Incident:</label>
              <input 
                type="date" 
                id="dateOfIncident" 
                v-model="form.date_of_incident" 
                required 
                class="block w-full p-2 border border-gray-300 rounded-md" 
                :readonly="!editMode"
              >
            </div>
            <div class="space-y-2">
              <label for="timeOfIncident" class="block font-medium">Time:</label>
              <input 
                type="time" 
                id="timeOfIncident" 
                v-model="form.time_of_incident" 
                required 
                class="block w-full p-2 border border-gray-300 rounded-md" 
                :readonly="!editMode"
              >
            </div>
          </div>

          <div class="space-y-2 mt-4">
            <label for="involved" class="block font-medium">Who are involved:</label>
            <textarea 
              id="involved" 
              v-model="form.involved" 
              class="block w-full p-2 border border-gray-300 rounded-md" 
              :readonly="!editMode"
            ></textarea>
          </div>

          <div class="space-y-2 mt-4">
            <label for="location" class="block font-medium">Where it happened:</label>
            <textarea 
              id="location" 
              v-model="form.location" 
              class="block w-full p-2 border border-gray-300 rounded-md" 
              rows="4" 
              :readonly="!editMode"
            ></textarea>
          </div>

          <div class="space-y-2 mt-4">
            <label for="actionTaken" class="block font-medium">Action Taken:</label>
            <textarea 
              id="actionTaken" 
              v-model="form.action_taken" 
              class="block w-full p-2 border border-gray-300 rounded-md" 
              rows="4" 
              :readonly="!editMode"
            ></textarea>
          </div>

          <div class="space-y-2 mt-4">
            <label for="agreements" class="block font-medium">Agreements Reached/Advice Given to Residents Involved:</label>
            <textarea 
              id="agreements" 
              v-model="form.agreements" 
              class="block w-full p-2 border border-gray-300 rounded-md" 
              rows="4" 
              :readonly="!editMode"
            ></textarea>
          </div>

          <div class="space-y-2 mt-4">
            <label for="correctiveMeasure" class="block font-medium">Corrective Measure:</label>
            <textarea 
              id="correctiveMeasure" 
              v-model="form.corrective_measure" 
              class="block w-full p-2 border border-gray-300 rounded-md" 
              rows="4" 
              :readonly="!editMode"
            ></textarea>
          </div>
        </div>

        <!-- Signatures -->
        <div class="space-y-4 mt-6">
          <div class="space-y-2">
            <label for="preparedBy" class="block font-medium">Prepared by:</label>
            <input 
              type="text" 
              id="preparedBy" 
              v-model="form.prepared_by" 
              class="block w-full p-2 border border-gray-300 rounded-md" 
              :readonly="!editMode"
            >
          </div>
          <div class="space-y-2">
            <label for="reviewedBy" class="block font-medium">Reviewed by:</label>
            <input 
              type="text" 
              id="reviewedBy" 
              v-model="form.reviewed_by" 
              value="" 
              :readonly="!editMode" 
              class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200"
            >
            <p class="text-sm">HPIII/SHP</p>
          </div>
          <div class="space-y-2">
            <label for="approvedBy" class="block font-medium">Approved by:</label>
            <input 
              type="text" 
              id="approvedBy" 
              v-model="form.approved_by" 
              value="" 
              :readonly="!editMode" 
              class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200"
            >
            <p class="text-sm">SWO IV / Center Head</p>
          </div>
        </div>
      </div>

    </form>
  </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';

export default {
  name: 'IncidentReportForm',
  setup() {
    const form = ref({
      client_id: null,
      drn: '',
      incident: '',
      date_of_incident: '',
      time_of_incident: '',
      involved: '',
      location: '',
      action_taken: '',
      agreements: '',
      corrective_measure: '',
      prepared_by: '',
      reviewed_by: 'VAN M. DE LEON',
      approved_by: 'ANGELIC B. PAÑA',
    });

    const editMode = ref(false);
    const message = ref('');
    const messageType = ref(''); // 'success' or 'error'
    const route = useRoute();

    const fetchData = () => {
      const clientId = route.params.id;
      if (clientId) {
        axios.get(`/api/incident-reports/${clientId}`).then(response => {
          if (response.data.report) {
            // Format time_of_incident to H:i format if needed
            if (response.data.report.time_of_incident) {
              form.value.time_of_incident = response.data.report.time_of_incident.slice(0, 5);
            }
            Object.assign(form.value, response.data.report);
            form.value.client_id = clientId;
          } else {
            const { client } = response.data;
            form.value.client_id = client.id;
          }
        }).catch(error => {
          console.error('Error fetching data:', error);
        });
      }
    };

    onMounted(fetchData);

    const toggleEdit = () => {
      editMode.value = true;
    };

    const submitForm = () => {
  if (!form.value.client_id) {
    message.value = 'Client ID is required.';
    messageType.value = 'error';
    return;
  }

  // Ensure the time is correctly formatted before submission
  if (form.value.time_of_incident) {
    form.value.time_of_incident = form.value.time_of_incident.slice(0, 5); // Format to H:i
  }

  const url = `/api/incident-reports/${form.value.client_id}`;

  axios.put(url, form.value)
    .then(response => {
      editMode.value = false;
      message.value = 'Data updated successfully!';
      messageType.value = 'success';
      clearMessage();
      fetchData(); // Re-fetch data to update the form with the latest saved data
    })
    .catch(error => {
      if (error.response && error.response.status === 422) {
        message.value = 'Validation error: ' + JSON.stringify(error.response.data.errors);
      } else {
        message.value = 'Failed to update data';
      }
      messageType.value = 'error';
      clearMessage();
    });
};

const clearMessage = () => {
      setTimeout(() => {
        message.value = '';
        messageType.value = '';
      }, 3000);
    };

    return {
      form,
      editMode,
      message,
      messageType,
      toggleEdit,
      submitForm,
    };
  },
};
</script>

<style scoped>
/* Add your custom styles here */
</style>
