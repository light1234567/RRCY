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
      <h1 class="font-bold text-xl">DEPARTMENT OF SOCIAL WELFARE AND DEVELOPMENT</h1>
      <p>REGIONAL REHABILITATION CENTER FOR YOUTH</p>
      <p>Bago Oshiro Tugbok dist. Davao City</p>
    </div>

    <!-- Session Information Section -->
    <div class="mb-6">
      <label for="session" class="block font-medium">Session:</label>
      <input type="text" id="session" v-model="form.session" class="border border-gray-400 p-2 rounded-md w-full" :readonly="!editMode">
    </div>
    <div class="mb-6">
      <label for="dateConducted" class="block font-medium">Date Conducted:</label>
      <input type="date" id="dateConducted" v-model="form.date_conducted" class="border border-gray-400 p-2 rounded-md w-full" :readonly="!editMode">
    </div>
    <div class="mb-6">
      <label for="title" class="block font-medium">Title of Session:</label>
      <input type="text" id="title" v-model="form.title" class="border border-gray-400 p-2 rounded-md w-full" :readonly="!editMode">
    </div>

    <!-- Session Sections -->
    <div class="space-y-4 mb-6">
      <div class="space-y-2">
        <label for="objective" class="block font-medium">I. Objective</label>
        <textarea id="objective" v-model="form.objective" class="border border-gray-400 p-2 rounded-md w-full" :readonly="!editMode"></textarea>
      </div>
      <div class="space-y-2">
        <label for="methodology" class="block font-medium">II. Methodology</label>
        <textarea id="methodology" v-model="form.methodology" class="border border-gray-400 p-2 rounded-md w-full" :readonly="!editMode"></textarea>
      </div>
      <div class="space-y-2">
        <label for="highlight" class="block font-medium">III. Highlight of the Session and Activity</label>
        <textarea id="highlight" v-model="form.highlight" class="border border-gray-400 p-2 rounded-md w-full" :readonly="!editMode"></textarea>
      </div>
      <div class="space-y-2">
        <label for="outcome" class="block font-medium">IV. Outcome</label>
        <textarea id="outcome" v-model="form.outcome" class="border border-gray-400 p-2 rounded-md w-full" :readonly="!editMode"></textarea>
      </div>
    </div>

    <!-- Signatures Section -->
    <div class="grid grid-cols-2 gap-4 mb-6">
      <div>
        <label for="preparedBy" class="block font-medium">Prepared by:</label>
        <input type="text" id="preparedBy" v-model="form.prepared_by" class="border border-gray-400 p-2 rounded-md w-full" :readonly="!editMode">
      </div>
    </div>
    <div class="grid grid-cols-2 gap-4 mb-6">
      <div>
        <label for="notedBy" class="block font-medium">Noted by:</label>
        <input type="text" id="notedBy" v-model="form.noted_by" class="border border-gray-400 p-2 rounded-md w-full" readonly>
        <p class="text-sm mt-1">VAN M. DE LEON</p>
        <p class="text-sm">HP III/SHP</p>
      </div>
      <div>
        <label for="approvedBy" class="block font-medium">Approved by:</label>
        <input type="text" id="approvedBy" v-model="form.approved_by" class="border border-gray-400 p-2 rounded-md w-full" readonly>
        <p class="text-sm mt-1">ANGELIC B. PAÑA</p>
        <p class="text-sm">SWO IV/Center Head</p>
      </div>
    </div>

    <!-- Footer Section -->
    <div class="text-center">
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
  name: 'SessionForm',
  setup() {
    const form = ref({
      client_id: null,
      drn: '',
      session: '',
      title: '',
      date_conducted: '',
      objective: '',
      methodology: '',
      highlight: '',
      outcome: '',
      prepared_by: '',
      noted_by: 'VAN M. DE LEON',
      approved_by: 'ANGELIC B. PAÑA',
    });

    const editMode = ref(false);
    const message = ref('');
    const messageType = ref(''); // 'success' or 'error'
    const route = useRoute();

    const fetchData = () => {
      const clientId = route.params.id;
      if (clientId) {
        axios.get(`/api/cicl-sessions/${clientId}`)
          .then(response => {
            if (response.data.session) {
              Object.assign(form.value, response.data.session);
              form.value.client_id = clientId;
            } else {
              const { client } = response.data;
              form.value.client_id = client.id;
            }
          })
          .catch(error => {
            message.value = 'Failed to load data';
            messageType.value = 'error';
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

      const url = `/api/cicl-sessions/${form.value.client_id}`;

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
            const errors = error.response.data.errors;
            message.value = 'Validation error: ' + Object.values(errors).flat().join(', ');
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
/* Add custom styles here */
</style>
