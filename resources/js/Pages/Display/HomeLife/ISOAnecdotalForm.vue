<template>
  <div class="max-w-3xl mx-auto p-16 bg-white border border-gray-300 rounded-lg shadow-lg">
    <!-- Header Section -->
    <div class="text-center mb-8">
      <div class="flex justify-between items-center mb-4">
        <img src="/images/headerlogo2.png" alt="DSWD Logo" class="h-24 w-48 -mt-16 relative z-10" />
        <div class="text-right">
          <p class="item-center mr-6 text-sm font-semibold">PROTECTIVE SERVICES DIVISION</p>
          <p class=" text-sm font-semibold">Regional Rehabilitation Center for Youth</p>
          <p class="mr-20 text-sm font-semibold">Youth/RFO XI</p>
          <p class="pt-12">DRN: ______________________</p>
        </div>
      </div>
      <h1 class="font-bold text-md">ANECDOTAL REPORT</h1>
      <p class="text-sm">FOR THE MONTH OF ____________________</p>
    </div>

    <!-- General Information -->
    <div class="grid grid-cols-2 gap-6 mb-6">
      <div class="flex items-center">
        <label for="pangalan" class="block font-medium w-1/3">Pangalan:</label>
        <input
          type="text"
          id="pangalan"
          v-model="form.name"
          readonly
          class="border-transparent -ml-4 p-2 rounded-md w-2/3"
        >
      </div>
      <div class="flex items-center">
        <label for="date" class="block ml-16 font-medium w-1/3">Petsa:</label>
        <input
          type="date"
          id="date"
          v-model="form.date"
          class="border-transparent -ml-8 p-2 rounded-md w-2/3"
          :readonly="!editMode"
        >
      </div>
    </div>

    <!-- Report Sections -->
    <div class="space-y-4 mb-6">
      <div>
        <label for="physical" class="block font-medium">
          <span class="font-bold text-sm">I. PHYSICAL :</span> 
          <span class="font-normal text-sm"> Management of personal hygiene and improvement of self-care habits.</span>
        </label>
        <textarea
          id="physical"
          v-model="form.physical"
          class="border border-gray-400 p-2 rounded-md w-full"
          rows="3"
          :readonly="!editMode"
        ></textarea>
      </div>

      <div>
        <label for="emotional" class="block font-medium">
          <span class="font-bold text-sm">II. EMOTIONAL :</span> 
          <span class="font-normal text-sm justify-text"> The degree to which the resident displayed his coping capacity towards ill/guilty feelings and feelings of helplessness.</span>
        </label>
       
        <textarea
          id="emotional"
          v-model="form.emotional"
          class="border border-gray-400 p-2 rounded-md w-full"
          rows="3"
          :readonly="!editMode"
        ></textarea>
      </div>

      <div>
        <label for="behavioral" class="block font-medium">
          <span class="font-bold text-sm">III. SOCIAL/BEHAVIORAL :</span> 
          <span class="font-normal text-sm justify-text"> The level to which the resident demonstrated honesty, self-control, and a sense of responsibility.</span>
        </label>
        <textarea
          id="behavioral"
          v-model="form.behavioral"
          class="border border-gray-400 p-2 rounded-md w-full"
          rows="3"
          :readonly="!editMode"
        ></textarea>
      </div>

      <div>
        <label for="spiritual" class="block font-medium">
          <span class="font-bold text-sm">IV. SPIRITUAL :</span> 
          <span class="font-normal text-sm justify-text"> Attitude displayed towards the acceptance of the present situation.</span>
        </label>
        <textarea
          id="spiritual"
          v-model="form.spiritual"
          class="border border-gray-400 p-2 rounded-md w-full"
          rows="3"
          :readonly="!editMode"
        ></textarea>
      </div>

      <div>
        <label for="recommendation" class="block font-medium">V. RECOMMENDATION:</label>
        <textarea
          id="recommendation"
          v-model="form.recommendation"
          class="border border-gray-400 p-2 rounded-md w-full"
          rows="3"
          :readonly="!editMode"
        ></textarea>
      </div>
    </div>

    <!-- Signatures Section -->
    <div class="grid grid-cols-2 gap-6 mb-6">
      <div>
        <label for="notedBy" class="block font-medium">Noted by:</label>
        <input
          type="text"
          id="notedBy"
          v-model="form.noted_by"
          class="border border-gray-400 p-2 rounded-md w-full"
          :readonly="!editMode"
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

    <!-- Additional Signatures -->
    <div class="grid grid-cols-2 gap-6 mb-6">
      <div>
        <label for="preparedBy" class="block font-medium">Prepared by:</label>
        <input
          type="text"
          id="preparedBy"
          v-model="form.prepared_by"
          class="border border-gray-400 p-2 rounded-md w-full"
          :readonly="!editMode"
        >
      </div>
      <div>
        <label for="color" class="block font-medium">Color:</label>
        <input
          type="text"
          id="color"
          v-model="form.color"
          class="border border-gray-400 p-2 rounded-md w-full"
          :readonly="!editMode"
        >
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
  name: 'AnecdotalReportForm',
  setup() {
    const form = ref({
      client_id: null,
      name: '',
      date: '',
      drn: '',
      color: '',
      physical: '',
      emotional: '',
      behavioral: '',
      spiritual: '',
      recommendation: '',
      noted_by: 'VAN M. DE LEON',
      approved_by: 'ANGELIC B. PAÑA',
      prepared_by: '',
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

    const submitForm = () => {
      const url = `/api/anecdotal-reports/${form.value.client_id}`;

      axios.put(url, form.value)
        .then(response => {
          editMode.value = false;
          message.value = 'Data updated successfully!';
          messageType.value = 'success';
          clearMessage();
          fetchData(); // Re-fetch data to update the form with the latest saved data
        })
        .catch(error => {
          message.value = 'Failed to update data';
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
