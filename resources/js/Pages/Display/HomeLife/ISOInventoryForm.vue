<template>
  <div class="mx-auto p-8 bg-gray-100 rounded-lg max-w-full">
    <form @submit.prevent="submitForm" class="space-y-8 w-full">
      <div class="border border-gray-300 p-6 rounded-md bg-white">
        <h1 class="font-bold text-lg mb-4">Monthly Inventory of Belongings</h1>

        <div class="flex justify-end mb-4 mt-6">
          <button v-if="!editMode" @click="toggleEdit" type="button" class="px-4 py-2 bg-blue-500 text-white rounded-md">
            Edit
          </button>
          <button v-else @click="submitForm" type="button" class="px-4 py-2 bg-green-500 text-white rounded-md">
            Save
          </button>
        </div>

        <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
          {{ message }}
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div class="space-y-2">
            <label for="month" class="block font-medium">For the Month of:</label>
            <select id="month" v-model="form.month" class="block w-full p-2 border border-gray-300 rounded-md" :disabled="!editMode" required>
              <option value="" disabled>Select a month</option>
              <option v-for="(month, index) in months" :key="index" :value="month">{{ month }}</option>
            </select>
            <p v-if="!form.month && editMode" class="text-red-500 text-sm">Please select a month.</p>
          </div>

          <div class="space-y-2">
            <label for="drn" class="block font-medium">DRN:</label>
            <input type="text" id="drn" v-model="form.drn" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
          </div>
        </div>

        <div class="space-y-4">
          <table class="w-full border-collapse">
            <thead>
              <tr class="bg-gray-200">
                <th class="border p-2 text-left">Item</th>
                <th class="border p-2 text-left">Description</th>
                <th class="border p-2 text-left">Qty</th>
                <th class="border p-2 text-left">Brand</th>
                <th class="border p-2 text-left">Size</th>
                <th class="border p-2 text-left">Color</th>
                <th class="border p-2 text-left">Old</th>
                <th class="border p-2 text-left">New</th>
                <th class="border p-2 text-left">Remarks</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in form.items" :key="index">
                <td class="border p-2">{{ item.name }}</td>
                <td class="border p-2">
                  <input type="text" v-model="item.description" class="w-full p-1 border border-gray-300 rounded-md" :readonly="!editMode">
                </td>
                <td class="border p-2">
                  <input type="number" v-model.number="item.qty" class="w-full p-1 border border-gray-300 rounded-md" :readonly="!editMode">
                </td>
                <td class="border p-2">
                  <input type="text" v-model="item.brand" class="w-full p-1 border border-gray-300 rounded-md" :readonly="!editMode">
                </td>
                <td class="border p-2">
                  <input type="text" v-model="item.size" class="w-full p-1 border border-gray-300 rounded-md" :readonly="!editMode">
                </td>
                <td class="border p-2">
                  <input type="text" v-model="item.color" class="w-full p-1 border border-gray-300 rounded-md" :readonly="!editMode">
                </td>
                <td class="border p-2">
                  <input type="text" v-model="item.old" class="w-full p-1 border border-gray-300 rounded-md" :readonly="!editMode">
                </td>
                <td class="border p-2">
                  <input type="text" v-model="item.new" class="w-full p-1 border border-gray-300 rounded-md" :readonly="!editMode">
                </td>
                <td class="border p-2">
                  <input type="text" v-model="item.remarks" class="w-full p-1 border border-gray-300 rounded-md" :readonly="!editMode">
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="space-y-4 mt-6">
          <div class="flex justify-between">
            <div class="space-y-2">
              <label for="residentName" class="block font-medium">Name & Signature of Resident:</label>
              <input type="text" id="residentName" v-model="form.resident_name" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
            </div>
            <div class="space-y-2">
              <label for="houseparentName" class="block font-medium">Name & Signature of Houseparent:</label>
              <input type="text" id="houseparentName" v-model="form.houseparent_name" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
            </div>
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
  name: 'MonthlyInventoryForm',
  setup() {
    const form = ref({
      id: null,
      client_id: null,
      original_month: '', // Track the original month
      month: '',
      drn: '',
      resident_name: '',
      houseparent_name: '',
      items: [
        { name: 'T shirt', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'T shirt Uranay', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Polo Shirt', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Polo Uniform', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Polo', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Short Pants', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Long Pants', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Long Pants Uniform', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Long Sleeve', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Sando Jersey', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'School Shoes', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Basketball Shoes', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Walking Shoes', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Bed Sheet', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Slipper', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Blanket', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Pillows', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Pillow Case', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Towel', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Face Towel', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Socks', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Brief/ Boxer', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Jogging Pants', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Jacket/sweatshirt', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'CAP', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
        { name: 'Pack Bag', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
      ]
    });

    const editMode = ref(false);
    const message = ref('');
    const messageType = ref(''); // 'success' or 'error'
    const route = useRoute();
    
    const months = ref([
      'January', 'February', 'March', 'April', 'May', 'June',
      'July', 'August', 'September', 'October', 'November', 'December'
    ]);

    const fetchData = () => {
      const clientId = route.params.id;
      if (clientId) {
        axios.get(`/api/monthly-inventories/${clientId}`).then(response => {
          if (response.data.inventory) {
            Object.assign(form.value, response.data.inventory);
            form.value.client_id = clientId;
            form.value.original_month = response.data.inventory.month; // Store the original month
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
      months,
      toggleEdit,
      submitForm,
    };
  },
};
</script>
