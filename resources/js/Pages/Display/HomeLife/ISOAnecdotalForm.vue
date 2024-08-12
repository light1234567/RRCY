<template>
  <div class="mx-auto p-8 bg-gray-100 rounded-lg max-w-full">
    <form @submit.prevent="submitForm" class="space-y-8 w-full">
      <!-- Header -->
      <div class="border border-gray-300 p-6 rounded-md bg-white">
        <h1 class="font-bold text-lg mb-4">Anecdotal Report Form</h1>

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
            <label for="name" class="block font-medium">Pangalan:</label>
            <input type="text" id="name" v-model="form.name" readonly class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="space-y-2">
            <label for="date" class="block font-medium">Date:</label>
            <input 
              type="date" 
              id="date" 
              v-model="form.date" 
              class="block w-full p-2 border border-gray-300 rounded-md" 
              :readonly="!editMode" 
              ref="dateField"
            >
          </div>
          <div class="space-y-2">
            <label for="drn" class="block font-medium">DRN:</label>
            <input type="text" id="drn" v-model="form.drn" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
          </div>
          <div class="space-y-2">
            <label for="color" class="block font-medium">Color:</label>
            <input type="text" id="color" v-model="form.color" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
          </div>
        </div>

        <!-- Report Sections -->
        <div class="space-y-4 mt-6">
          <div class="space-y-2">
            <label for="physical" class="block font-medium">I. Physical:</label>
            <textarea id="physical" v-model="form.physical" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="emotional" class="block font-medium">II. Emotional:</label>
            <textarea id="emotional" v-model="form.emotional" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="behavioral" class="block font-medium">III. Social/Behavioral:</label>
            <textarea id="behavioral" v-model="form.behavioral" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="spiritual" class="block font-medium">IV. Spiritual:</label>
            <textarea id="spiritual" v-model="form.spiritual" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="recommendation" class="block font-medium">V. Recommendation:</label>
            <textarea id="recommendation" v-model="form.recommendation" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
        </div>
 <!-- Signatures -->
 <div class="space-y-4 mt-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label for="notedBy" class="block font-medium">Noted by:</label>
              <input type="text" id="notedBy" v-model="form.noted_by" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
            </div>
            <div class="space-y-2">
              <label for="approvedBy" class="block font-medium">Approved by:</label>
              <input type="text" id="approvedBy" v-model="form.approved_by" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
            </div>
          </div>
          <div class="space-y-2">
            <label for="preparedBy" class="block font-medium">Prepared by:</label>
            <input type="text" id="preparedBy" v-model="form.prepared_by" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
          </div>
        </div>
        
        <!-- Signature Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
          
          <!-- House Parents Signature -->
          <div class="space-y-2">
            <div v-if="form.house_parents_signature" class="mb-2">
              <!-- <img :src="form.house_parents_signature" alt="House Parents Signature" class="w-32 h-32 object-cover mx-auto"> -->
            </div>
            <!-- <input type="file" @change="onFileChange('house_parents_signature', $event)" :disabled="!editMode"> -->
            <input type="text" id="houseParents" v-model="form.house_parents" class="block w-full p-2 border border-gray-300 rounded-md mt-2" :readonly="!editMode">
            <p class="text-center">House Parents</p>
          </div>

          <!-- Residents Signature -->
          <div class="space-y-2">
            <div v-if="form.residents_signature" class="mb-2">
              <!-- <img :src="form.residents_signature" alt="Residents Signature" class="w-32 h-32 object-cover mx-auto"> -->
            </div>
            <!-- <input type="file" @change="onFileChange('residents_signature', $event)" :disabled="!editMode"> -->
            <input type="text" id="residents" v-model="form.residents" class="block w-full p-2 border border-gray-300 rounded-md mt-2" :readonly="!editMode">
            <p class="text-center">Residents</p>
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
  name: 'AnecdotalReportForm',
  setup() {
    const form = ref({
      client_id: null,
      date: '',
      drn: '',
      color: '',
      physical: '',
      emotional: '',
      behavioral: '',
      spiritual: '',
      recommendation: '',
      noted_by: '',
      approved_by: '',
      prepared_by: '',
      house_parents: '',
      house_parents_signature: null, // Signature image for House Parents
      residents: '',
      residents_signature: null, // Signature image for Residents
    });

    const editMode = ref(false);
    const message = ref('');
    const messageType = ref(''); // 'success' or 'error'
    const route = useRoute();

    const fetchData = () => {
      const clientId = route.params.id;
      if (clientId) {
        axios.get(`/api/anecdotal-reports/${clientId}`).then(response => {
          if (response.data.report) {
            Object.assign(form.value, response.data.report);
            form.value.client_id = clientId;
            // Assign additional fields from client
            const client = response.data.client;
            form.value.name = `${client.first_name} ${client.last_name}`;
          } else {
            const { client } = response.data;
            form.value.client_id = client.id;
            form.value.name = `${client.first_name} ${client.last_name}`;
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

    const onFileChange = (field, event) => {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          form.value[field] = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    };

    const submitForm = () => {
      // Check if date is filled, if not, focus on date field
      if (!form.value.date) {
        document.getElementById('date').scrollIntoView({ behavior: 'smooth' });
        document.getElementById('date').focus();
        return;
      }

      const url = `/api/anecdotal-reports/${form.value.client_id}`;

      axios.put(url, form.value)
        .then(response => {
          editMode.value = false;
          message.value = 'Data saved successfully!';
          messageType.value = 'success';
          clearMessage();
          fetchData(); // Re-fetch data to update the form with the latest saved data
        })
        .catch(error => {
          message.value = 'Failed to save data';
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
      onFileChange,
      submitForm,
      clearMessage,
    };
  },
};
</script>

<style scoped>
/* Add your custom styles here */
</style>
