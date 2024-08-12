<template>
  <div class="mx-auto p-8 bg-gray-100 rounded-lg max-w-full">
    <form @submit.prevent="submitForm" class="space-y-8 w-full">
      <!-- Header -->
      <div class="border border-gray-300 p-6 rounded-md bg-white">
        <h1 class="font-bold text-lg mb-4">Request Form</h1>

        <!-- Edit/Save Button -->
        <div class="flex justify-end mb-4">
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

        <!-- DRN Section -->
        <div class="space-y-2">
          <label for="drn" class="block font-medium">DRN:</label>
          <input type="text" v-model="form.drn" id="drn" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
        </div>

        <!-- Date of Filing Section -->
        <div class="space-y-2">
          <label for="dateOfFiling" class="block font-medium">Date of Filing:</label>
          <input type="date" v-model="form.date_of_filing" id="dateOfFiling" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
        </div>

        <!-- Requesting Party Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div class="space-y-2">
            <label for="requestingPartyName" class="block font-medium">Name of Requesting Party:</label>
            <input type="text" v-model="form.requesting_party_name" id="requestingPartyName" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
          </div>
          <div class="space-y-2">
            <label for="requestingPartyPosition" class="block font-medium">Position:</label>
            <input type="text" v-model="form.requesting_party_position" id="requestingPartyPosition" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
          </div>
        </div>

        <!-- Date and Time of Duty -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div class="space-y-2">
            <label for="dateOfDuty" class="block font-medium">Date of Duty:</label>
            <input type="date" v-model="form.date_of_duty" id="dateOfDuty" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
          </div>
          <div class="space-y-2">
            <label for="timeOfDuty" class="block font-medium">Time of Duty:</label>
            <input type="time" v-model="form.time_of_duty" id="timeOfDuty" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
          </div>
        </div>

        <!-- SOD Section -->
        <div class="space-y-4">
          <h2 class="font-bold text-lg mb-4">SOD Section</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="space-y-2">
              <label for="sodName" class="block font-medium">Name of SOD accepting the request:</label>
              <input type="text" v-model="form.sod_name" id="sodName" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
            </div>
            <div class="space-y-2">
              <label for="sodDateOfDuty" class="block font-medium">Date of Duty:</label>
              <input type="date" v-model="form.sod_date_of_duty" id="sodDateOfDuty" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="space-y-2">
              <label for="sodPosition" class="block font-medium">Position:</label>
              <input type="text" v-model="form.sod_position" id="sodPosition" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
            </div>
            <div class="space-y-2">
              <label for="sodShiftTime" class="block font-medium">Shift/Time of Duty:</label>
              <input type="text" v-model="form.sod_shift_time" id="sodShiftTime" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
            </div>
          </div>
        </div>

        <!-- Purpose Section -->
        <div class="space-y-2">
          <label for="purpose" class="block font-medium">Purpose:</label>
          <textarea v-model="form.purpose" id="purpose" rows="4" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
        </div>

        <!-- Requested and Accepted By Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div class="space-y-2">
            <label for="requestedBy" class="block font-medium">Requested by:</label>
            <input type="text" v-model="form.requested_by" id="requestedBy" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
          </div>
          <div class="space-y-2">
            <label for="acceptedBy" class="block font-medium">Accepted by:</label>
            <input type="text" v-model="form.accepted_by" id="acceptedBy" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
          </div>
        </div>

        <!-- Noted By and Approved By -->
        <div class="space-y-2">
          <label for="notedBy" class="block font-medium">Noted by:</label>
          <input type="text" id="notedBy" v-model="form.noted_by" readonly class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200">
        </div>
        <div class="space-y-2">
          <label for="approvedBy" class="block font-medium">Approved by:</label>
          <input type="text" id="approvedBy" v-model="form.approved_by" readonly class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200">
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
  name: 'SwappingForm',
  setup() {
    const form = ref({
      client_id: null,
      drn: '',
      date_of_filing: '',
      requesting_party_name: '',
      requesting_party_position: '',
      date_of_duty: '',
      time_of_duty: '',
      sod_name: '',
      sod_date_of_duty: '',
      sod_position: '',
      sod_shift_time: '',
      purpose: '',
      requested_by: '',
      accepted_by: '',
      noted_by: 'VAN M. DE LEON',
      approved_by: 'ANGELIC B. PAÑA',
    });

    const editMode = ref(false);
    const message = ref('');
    const messageType = ref('');
    const route = useRoute();

    const fetchData = () => {
      const clientId = route.params.id;
      console.log('Fetching data for client ID:', clientId); // Detailed log
      if (clientId) {
        axios.get(`/api/swapping-forms/${clientId}`).then(response => {
          console.log('Server response:', response.data); // Detailed log
          if (response.data.form) {
            Object.assign(form.value, response.data.form);
            form.value.client_id = clientId;
          } else {
            form.value.client_id = clientId;
          }
        }).catch(error => {
          console.error('Error fetching data:', error); // Detailed error log
        });
      }
    };

    onMounted(fetchData);

    const toggleEdit = () => {
      console.log('Toggling edit mode'); // Detailed log
      editMode.value = true;
    };

    const submitForm = () => {
    const clientId = form.value.client_id;

    // Convert time_of_duty to H:i format if it contains a time in 12-hour format
    if (form.value.time_of_duty) {
        const time = new Date(`1970-01-01T${form.value.time_of_duty}`);
        const hours = String(time.getHours()).padStart(2, '0');
        const minutes = String(time.getMinutes()).padStart(2, '0');
        form.value.time_of_duty = `${hours}:${minutes}`;
    }

    console.log('Submitting form with data:', form.value); // Detailed console log

    const url = `/api/swapping-forms/${clientId}`;

    axios.put(url, form.value)
        .then(response => {
            console.log('Form submission successful:', response); // Detailed console log on success
            editMode.value = false;
            message.value = 'Data updated successfully!';
            messageType.value = 'success';
            clearMessage();
            fetchData();
        })
        .catch(error => {
            console.error('Error during form submission:', error); // Detailed console log on error
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
