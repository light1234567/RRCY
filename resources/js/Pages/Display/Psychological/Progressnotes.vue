<template>
  <div class="mx-auto p-8 bg-gray-100 rounded-lg max-w-full">
    <form @submit.prevent="submitForm" class="space-y-8 w-full">
      <!-- Header -->
      <div class="border border-gray-300 p-6 rounded-md bg-white">
        <!-- Progress Report Section -->
        <div class="flex justify-end mb-4">
          <button
            v-if="!editMode"
            @click="toggleEdit"
            type="button"
            class="px-4 py-2 bg-blue-500 text-white rounded-md mt-4"
          >
            Edit
          </button>
          <button
            v-else
            type="button"
            @click="submitForm"
            class="px-4 py-2 bg-green-500 text-white rounded-md mt-4"
          >
            Save
          </button>
        </div>

        <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
          {{ message }}
        </div>

        <!-- Progress Report Section -->
        <div class="space-y-4 mt-6">
          <h2 class="font-bold text-lg">PROGRESS REPORT</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label for="name" class="block font-medium">Name:</label>
              <input type="text" id="name" v-model="form.name" class="block w-full p-2 border border-gray-300 rounded-md" readonly>
            </div>
            <div class="space-y-2">
              <label for="age" class="block font-medium">Age:</label>
              <input type="text" id="age" v-model="form.age" class="block w-full p-2 border border-gray-300 rounded-md" readonly>
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label for="dateAdmitted" class="block font-medium">Date Admitted:</label>
              <input type="date" id="dateAdmitted" v-model="form.date_admitted" class="block w-full p-2 border border-gray-300 rounded-md" readonly>
            </div>
            <div class="space-y-2">
              <label for="interventionPeriod" class="block font-medium">Period of Intervention Plan:</label>
              <input type="text" id="interventionPeriod" v-model="form.intervention_period" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
            </div>
          </div>
        </div>

        <!-- Problem Behavior Log Section -->
        <div class="space-y-4 mt-6">
          <h2 class="font-bold">PROBLEM BEHAVIOR LOG</h2>
          <textarea id="problemBehaviorLog" v-model="form.problem_behavior_log" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
        </div>

        <!-- Interventions Conducted Section -->
        <div class="space-y-4 mt-6">
          <h2 class="font-bold">INTERVENTIONS CONDUCTED</h2>
          <textarea id="interventionsConducted" v-model="form.interventions_conducted" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
        </div>

        <!-- Progress Notes Section -->
        <div class="space-y-4 mt-6">
          <h2 class="font-bold">PROGRESS NOTES</h2>
          <textarea id="progressNotes" v-model="form.progress_notes" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
        </div>

        <!-- Signatures Section -->
        <div class="space-y-4 mt-6">
          <div class="space-y-2">
            <label for="preparedBy" class="block font-medium">Prepared by:</label>
            <input type="text" id="preparedBy" v-model="form.prepared_by" class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200" :readonly="!editMode">
          </div>
          <div class="space-y-2">
            <label for="notedBy" class="block font-medium">Noted by:</label>
            <input type="text" id="notedBy" v-model="form.noted_by" class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200" :readonly="!editMode">
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
  name: 'ProgressReportForm',
  setup() {
    const form = ref({
      client_id: null,
      admission_id: null,
      name: '',
      age: '',
      date_admitted: '',
      intervention_period: '',
      problem_behavior_log: '',
      interventions_conducted: '',
      progress_notes: '',
      prepared_by: 'BRYAN V. GALANG, MPsy, RPsy',
      noted_by: 'ANGELIC B. PAÑA, RSW, MSSW',
    });

    const editMode = ref(false);
    const message = ref('');
    const messageType = ref(''); // 'success' or 'error'
    const route = useRoute();

    const fetchData = () => {
      const clientId = route.params.id;
      if (clientId) {
        axios.get(`/api/cicl-progress-notes/${clientId}`).then(response => {
          if (response.data.note) {
            Object.assign(form.value, response.data.note);
            form.value.client_id = clientId;
            form.value.admission_id = response.data.admission.id;
            // Assign additional fields from client and admission, making them non-editable
            const client = response.data.client;
            const admission = response.data.admission;
            form.value.name = `${client.first_name} ${client.last_name}`;
            form.value.age = calculateAge(client.date_of_birth);
            form.value.date_admitted = admission.date_admitted;
          } else {
            const { client, admission } = response.data;
            form.value.client_id = client.id;
            form.value.admission_id = admission.id;
            form.value.name = `${client.first_name} ${client.last_name}`;
            form.value.age = calculateAge(client.date_of_birth);
            form.value.date_admitted = admission.date_admitted;
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
      if (!form.value.client_id || !form.value.admission_id) {
        message.value = 'Client ID and Admission ID are required.';
        messageType.value = 'error';
        clearMessage();
        return;
      }

      const url = `/api/cicl-progress-notes/${form.value.client_id}`;

      axios.put(url, form.value)
        .then(response => {
          editMode.value = false;
          message.value = 'Data saved successfully!';
          messageType.value = 'success';
          clearMessage();
          fetchData(); // Re-fetch data to update the form with the latest saved data
        })
        .catch(error => {
          if (error.response && error.response.status === 422) {
            const errors = error.response.data.errors;
            message.value = 'Validation error: ' + Object.values(errors).flat().join(', ');
          } else {
            message.value = 'Failed to save data';
          }
          messageType.value = 'error';
          clearMessage();
        });
    };

    const calculateAge = (birthDate) => {
      const today = new Date();
      const birthDateObj = new Date(birthDate);
      let age = today.getFullYear() - birthDateObj.getFullYear();
      const monthDiff = today.getMonth() - birthDateObj.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDateObj.getDate())) {
        age--;
      }
      return age;
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
      calculateAge,
      clearMessage,
    };
  },
};
</script>

<style scoped>
/* Add your custom styles here */
</style>
