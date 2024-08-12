<template>
  <div class="mx-auto p-8 bg-gray-100 rounded-lg max-w-full">
    <form @submit.prevent="submitForm" class="space-y-8 w-full">
      <!-- Header -->
      <div class="border border-gray-300 p-6 rounded-md bg-white">
        <h1 class="font-bold text-lg mb-4">Session Form</h1>

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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-2">
            <label for="drn" class="block font-medium">DRN:</label>
            <input type="text" id="drn" v-model="form.drn" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
          </div>
          <div class="space-y-2">
            <label for="session" class="block font-medium">Session:</label>
            <input type="text" id="session" v-model="form.session" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
          </div>
          <div class="space-y-2">
            <label for="title" class="block font-medium">Title of Session:</label>
            <input type="text" id="title" v-model="form.title" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
          </div>
          <div class="space-y-2">
            <label for="dateConducted" class="block font-medium">Date Conducted:</label>
            <input type="date" id="dateConducted" v-model="form.date_conducted" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
          </div>
        </div>

        <!-- Session Sections -->
        <div class="space-y-4 mt-6">
          <div class="space-y-2">
            <label for="objective" class="block font-medium">Section I: Objective</label>
            <textarea id="objective" v-model="form.objective" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="methodology" class="block font-medium">Section II: Methodology</label>
            <textarea id="methodology" v-model="form.methodology" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="highlight" class="block font-medium">Section III: Highlight of the Session and Activity</label>
            <textarea id="highlight" v-model="form.highlight" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="outcome" class="block font-medium">Section IV: Outcome</label>
            <textarea id="outcome" v-model="form.outcome" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
        </div>

        <!-- Signatures -->
        <div class="space-y-4 mt-6">
          <div class="space-y-2">
            <label for="notedBy" class="block font-medium">Noted by:</label>
            <input type="text" id="notedBy" v-model="form.noted_by" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
          </div>
          <div class="space-y-2">
            <label for="approvedBy" class="block font-medium">Approved by:</label>
            <input type="text" id="approvedBy" v-model="form.approved_by" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
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
      noted_by: '',
      approved_by: '',
    });

    const editMode = ref(false);
    const message = ref('');
    const messageType = ref(''); // 'success' or 'error'
    const route = useRoute();

    const fetchData = () => {
  const clientId = route.params.id;
  console.log('Fetching data for client ID:', clientId); // Log client ID

  if (clientId) {
    axios.get(`/api/cicl-sessions/${clientId}`)
      .then(response => {
        console.log('Server response:', response); // Log server response

        if (response.data.session) {
          Object.assign(form.value, response.data.session);
          form.value.client_id = clientId;
          console.log('Form data after assignment:', form.value); // Log form data after assignment
        } else {
          console.log('No session data found, initializing with client data');
          const { client } = response.data;
          form.value.client_id = client.id;
        }
      })
      .catch(error => {
        console.error('Error fetching data:', error); // Log any errors
        message.value = 'Failed to load data'; // Display error message
      });
  } else {
    console.warn('Client ID is missing in route params'); // Warn if client ID is missing
  }
};


    onMounted(fetchData);

    const toggleEdit = () => {
      editMode.value = true;
    };

    const submitForm = () => {
  console.log('Submitting form data:', form.value); // Log form data being submitted

  if (!form.value.client_id) {
    message.value = 'Client ID is required.';
    messageType.value = 'error';
    console.error('Client ID is missing, cannot submit form'); // Log missing client ID
    return;
  }

  const url = `/api/cicl-sessions/${form.value.client_id}`;

  axios.put(url, form.value) // Use PUT instead of POST
    .then(response => {
      console.log('Form submission successful:', response); // Log successful response
      editMode.value = false;
      message.value = 'Data updated successfully!';
      messageType.value = 'success';
      clearMessage();
      fetchData(); // Re-fetch data to update the form with the latest saved data
    })
    .catch(error => {
      console.error('Error during form submission:', error); // Log any errors
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
