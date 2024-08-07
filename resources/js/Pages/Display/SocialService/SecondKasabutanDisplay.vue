<template>
  <div class="p-10 bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md">
      <div class="text-center mb-8">
        <img src="path/to/dswd-logo.png" alt="DSWD Logo" class="mx-auto mb-4" />
        <h1 class="text-xl font-bold">KASABUTAN</h1>
      </div>
      <div class="flex justify-end mb-4">
        <button @click="toggleEdit" class="px-4 py-2 bg-blue-500 text-white rounded-md mt-4">
          {{ editMode ? 'Save' : 'Edit' }}
        </button>
      </div>

      <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
        {{ message }}
      </div>

      <div class="mb-8">
        <p>
          Ako si <span class="font-bold underline">{{ clientName }}</span> nagapanumpa ug naga saad na unsa man ang mahitabo sa akoan bahin niini PAGAPATAOD UG BOLITAS SA AKONG KINATAWO/OTIN, walay tulubagon ang DSWD-RRCY tungod kini maoy akong kabubut-on.
        </p>
      </div>

      <div class="mb-8">
        <div class="space-y-2">
          <div>
            <label>Client/Resident</label>
            <input type="text" v-model="form.client_resident" class="border w-full px-2 py-1" :readonly="!editMode"/>
          </div>
          <div>
            <label>Pangalan/Pirma sa Ginikanan/Guardian</label>
            <input type="text" v-model="form.parent_guardian" class="border w-full px-2 py-1" :readonly="!editMode"/>
          </div>
          <div>
            <label>Case Manager</label>
            <input type="text" v-model="form.case_manager" class="border w-full px-2 py-1" :readonly="!editMode"/>
          </div>
        </div>
      </div>

      <div class="text-center mt-8">
        <p>ANGELIC B. PAÑA, RSW, MSSW</p>
        <p>Center Head/SWO IV</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';

export default {
  setup() {
    const route = useRoute();
    const editMode = ref(false);
    const message = ref('');
    const messageType = ref('');
    const form = ref({
      client_id: null,
      client_resident: '',
      parent_guardian: '',
      case_manager: '',
      id: null // Add id to track existing record
    });
    const clientName = ref('');
    const errorMessage = ref('');

    const fetchClientData = async (clientId) => {
      try {
        const clientResponse = await axios.get(`/api/clients/${clientId}`);
        const client = clientResponse.data;
        clientName.value = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
        form.value.client_id = client.id; // Set the client ID in the form

        const kasabutanResponse = await axios.get(`/api/kasabutan/${clientId}`);
        const kasabutan = kasabutanResponse.data;
        form.value.client_resident = kasabutan.client_resident || '';
        form.value.parent_guardian = kasabutan.parent_guardian || '';
        form.value.case_manager = kasabutan.case_manager || '';
        form.value.id = kasabutan.id; // Capture the kasabutan id if it exists
      } catch (error) {
        errorMessage.value = 'Error fetching client data.';
        console.error('Error fetching client data:', error);
      }
    };

    const toggleEdit = () => {
      if (editMode.value) {
        saveData();
      }
      editMode.value = !editMode.value;
    };

    const saveData = async () => {
      if (!form.value.client_id) {
        message.value = 'Client ID is missing.';
        messageType.value = 'error';
        return;
      }

      try {
        const response = await axios[form.value.id ? 'put' : 'post'](`/api/kasabutan${form.value.id ? '/' + form.value.id : ''}`, form.value);
        message.value = 'Data saved successfully!';
        messageType.value = 'success';
        errorMessage.value = ''; // Clear any previous error messages

        if (!form.value.id) {
          form.value.id = response.data.id; // Update id if new record created
        }

        // Hide success message after 3 seconds
        setTimeout(() => {
          message.value = '';
        }, 3000);
      } catch (error) {
        message.value = 'Error saving data.';
        messageType.value = 'error';
        console.error('Error saving data:', error);
      }
    };

    onMounted(() => {
      const id = route.params.id;
      if (id) {
        fetchClientData(id);
      }
    });

    return {
      editMode,
      form,
      clientName,
      errorMessage,
      message,
      messageType,
      toggleEdit,
    };
  }
};
</script>

<style scoped>
button {
  transition: background-color 0.3s;
}
button:hover {
  background-color: #2563eb;
}
</style>
