<template>
  <div class="max-w-4xl mx-auto p-8 bg-white border border-gray-300 rounded-lg shadow-lg">
    <!-- Header Section -->
    <div class="text-center mb-8">
      <div class="flex justify-between items-center mb-4">
        <img src="/images/headerlogo2.png" alt="DSWD Logo" class="h-16" />
        <div class="text-right">
          <p class="font-semibold">PROTECTIVE SERVICES DIVISION</p>
          <p>Regional Rehabilitation Center for Youth</p>
          <p>Youth/RFO XI</p>
          <p>DRN: ______________________</p>
        </div>
      </div>
      <h1 class="font-bold text-xl">INCIDENT REPORT</h1>
    </div>

    <!-- Incident Details -->
    <div class="mb-6">
      <label for="incident" class="block font-medium">What was the incident: (Unsa nga Offense? Unsa rason ngano Nahitabo?)</label>
      <textarea
        id="incident"
        v-model="form.incident"
        class="border border-gray-400 p-2 rounded-md w-full"
        rows="4"
        :readonly="!editMode"
      ></textarea>
    </div>

    <!-- When It Happened -->
    <div class="text-center font-medium mb-4">
      WHEN IT HAPPENED
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
      <div>
        <label for="dateOfIncident" class="block font-medium">Date of Incident:</label>
        <input
          type="date"
          id="dateOfIncident"
          v-model="form.date_of_incident"
          required
          class="border border-gray-400 p-2 rounded-md w-full"
          :readonly="!editMode"
        >
      </div>
      <div>
        <label for="timeOfIncident" class="block font-medium">Time:</label>
        <input
          type="time"
          id="timeOfIncident"
          v-model="form.time_of_incident"
          required
          class="border border-gray-400 p-2 rounded-md w-full"
          :readonly="!editMode"
        >
      </div>
    </div>

    <!-- Who Are Involved -->
    <div class="mb-6">
      <label for="involved" class="block font-medium">Who are involved? (State name of residents)</label>
      <textarea
        id="involved"
        v-model="form.involved"
        class="border border-gray-400 p-2 rounded-md w-full"
        rows="4"
        :readonly="!editMode"
      ></textarea>
    </div>

    <!-- Where It Happened -->
    <div class="mb-6">
      <label for="location" class="block font-medium">Where it happened? (Exact place of the incident)</label>
      <textarea
        id="location"
        v-model="form.location"
        class="border border-gray-400 p-2 rounded-md w-full"
        rows="4"
        :readonly="!editMode"
      ></textarea>
    </div>

    <!-- Action Taken -->
    <div class="mb-6">
      <label for="actionTaken" class="block font-medium">Action Taken</label>
      <textarea
        id="actionTaken"
        v-model="form.action_taken"
        class="border border-gray-400 p-2 rounded-md w-full"
        rows="4"
        :readonly="!editMode"
      ></textarea>
    </div>

    <!-- Agreements Reached/Advice Given -->
    <div class="mb-6">
      <label for="agreements" class="block font-medium">Agreements Reached/Advice Given to Residents Involved</label>
      <textarea
        id="agreements"
        v-model="form.agreements"
        class="border border-gray-400 p-2 rounded-md w-full"
        rows="4"
        :readonly="!editMode"
      ></textarea>
    </div>

    <!-- Corrective Measure -->
    <div class="mb-6">
      <label for="correctiveMeasure" class="block font-medium">Corrective Measure</label>
      <textarea
        id="correctiveMeasure"
        v-model="form.corrective_measure"
        class="border border-gray-400 p-2 rounded-md w-full"
        rows="4"
        :readonly="!editMode"
      ></textarea>
    </div>

    <!-- Signatures Section -->
    <div class="grid grid-cols-2 gap-4 mb-6">
      <div>
        <label for="preparedBy" class="block font-medium">Prepared by:</label>
        <input
          type="text"
          id="preparedBy"
          v-model="form.prepared_by"
          class="border border-gray-400 p-2 rounded-md w-full"
          :readonly="!editMode"
        >
        <div class="mt-2">
          <input
            type="text"
            v-model="form.prepared_by_position"
            class="border border-gray-400 p-2 rounded-md w-full"
            :readonly="!editMode"
          >
        </div>
      </div>
      <div>
        <label for="reviewedBy" class="block font-medium">Reviewed by:</label>
        <input
          type="text"
          id="reviewedBy"
          v-model="form.reviewed_by"
          class="border border-gray-400 p-2 rounded-md w-full"
          readonly
        >
        <p class="text-sm mt-1">VAN M. DE LEON</p>
        <p class="text-sm">HP III/SHP</p>
      </div>
      <div>
        <label for="approvedBy" class="block font-medium">Approved by:</label>
        <input
          type="text"
          id="approvedBy"
          v-model="form.approved_by"
          class="border border-gray-400 p-2 rounded-md w-full"
          readonly
        >
        <p class="text-sm mt-1">ANGELIC B. PAÑA</p>
        <p class="text-sm">SWO IV / Center Head</p>
      </div>
    </div>

    <!-- Footer Section -->
    <div class="text-center mt-8">
      <p>PAGE 1 of 1</p>
      <p class="text-xs">
        DSWD Field Office XI, Ramon Magsaysay Corner D. Suazo Street, Davao City, Philippines 8000<br>
        Website: <a href="https://www.dswd.gov.ph" class="text-blue-500 underline">https://www.dswd.gov.ph</a> | Tel No.: (082) 254-0230-08
      </p>
    </div>

    <!-- Edit/Save Button -->
    <div class="flex justify-end mt-8">
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
      prepared_by_position: '',
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

      if (form.value.time_of_incident) {
        form.value.time_of_incident = form.value.time_of_incident.slice(0, 5);
      }

      const url = `/api/incident-reports/${form.value.client_id}`;

      axios.put(url, form.value)
        .then(response => {
          editMode.value = false;
          message.value = 'Data updated successfully!';
          messageType.value = 'success';
          clearMessage();
          fetchData();
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
