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
      <h1 class="font-bold text-xl">MONTHLY INVENTORY OF BELONGINGS</h1>
      <p>For the Month of <span class="underline">__________________</span></p>
    </div>

    <!-- Inventory Table -->
    <div class="overflow-x-auto mb-6">
      <table class="w-full border-collapse border border-gray-300">
        <thead>
          <tr class="bg-gray-200">
            <th class="border border-gray-300 p-2 text-left">Item</th>
            <th class="border border-gray-300 p-2 text-left">Qty</th>
            <th class="border border-gray-300 p-2 text-left">Brand</th>
            <th class="border border-gray-300 p-2 text-left">Size</th>
            <th class="border border-gray-300 p-2 text-left">Color</th>
            <th class="border border-gray-300 p-2 text-left">Old</th>
            <th class="border border-gray-300 p-2 text-left">New</th>
            <th class="border border-gray-300 p-2 text-left">Remarks</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in form.items" :key="index">
            <td class="border border-gray-300 p-2">{{ item.name }}</td>
            <td class="border border-gray-300 p-2">
              <input type="number" v-model.number="item.qty" class="w-full p-1 border border-gray-300 rounded-md" :readonly="!editMode">
            </td>
            <td class="border border-gray-300 p-2">
              <input type="text" v-model="item.brand" class="w-full p-1 border border-gray-300 rounded-md" :readonly="!editMode">
            </td>
            <td class="border border-gray-300 p-2">
              <input type="text" v-model="item.size" class="w-full p-1 border border-gray-300 rounded-md" :readonly="!editMode">
            </td>
            <td class="border border-gray-300 p-2">
              <input type="text" v-model="item.color" class="w-full p-1 border border-gray-300 rounded-md" :readonly="!editMode">
            </td>
            <td class="border border-gray-300 p-2">
              <input type="text" v-model="item.old" class="w-full p-1 border border-gray-300 rounded-md" :readonly="!editMode">
            </td>
            <td class="border border-gray-300 p-2">
              <input type="text" v-model="item.new" class="w-full p-1 border border-gray-300 rounded-md" :readonly="!editMode">
            </td>
            <td class="border border-gray-300 p-2">
              <input type="text" v-model="item.remarks" class="w-full p-1 border border-gray-300 rounded-md" :readonly="!editMode">
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Signatures Section -->
    <div class="grid grid-cols-2 gap-6 mb-6">
      <div class="space-y-2">
        <label for="residentName" class="block font-medium">Name & Signature of Resident:</label>
        <input type="text" id="residentName" v-model="form.resident_name" class="border border-gray-400 p-2 rounded-md w-full" :readonly="!editMode">
      </div>
      <div class="space-y-2">
        <label for="houseparentName" class="block font-medium">Name & Signature of Houseparent:</label>
        <input type="text" id="houseparentName" v-model="form.houseparent_name" class="border border-gray-400 p-2 rounded-md w-full" :readonly="!editMode">
      </div>
    </div>

    <!-- Footer Section -->
    <div class="text-center mt-8">
      <p class="font-semibold">Noted by:</p>
      <p>VAN M. DE LEON - HP III/SHP</p>
      <p class="font-semibold">Approved by:</p>
      <p>ANGELIC B. PAÑA - SWO IV / Center Head</p>
      <p class="mt-4">PAGE 1 of 1</p>
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
  name: 'MonthlyInventoryForm',
  setup() {
    const form = ref({
      id: null,
      client_id: null,
      month: '',
      drn: '',
      resident_name: '',
      houseparent_name: '',
      items: [
        { name: 'T shirt', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        // add other items as necessary
      ]
    });

    const editMode = ref(false);
    const message = ref('');
    const messageType = ref(''); // 'success' or 'error'
    const route = useRoute();

    const fetchData = () => {
      const clientId = route.params.id;
      if (clientId) {
        axios.get(`/api/monthly-inventories/${clientId}`).then(response => {
          if (response.data.inventory) {
            Object.assign(form.value, response.data.inventory);
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

      const url = `/api/monthly-inventories/${form.value.client_id}`;

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
