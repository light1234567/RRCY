<template>
  <div class="bg-gray-100 p-10">
    <!-- Page 1 -->
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mb-10">
      <div class="flex items-center justify-between mb-4">
        <img src="path_to_logo.png" alt="DSWD Logo" class="h-16">
        <div class="text-right">
          <p class="text-xs">DSPTD-QF-01-A | REV 01 | 12 SEP 2023</p>
        </div>
      </div>
      <h1 class="text-2xl font-bold text-center mb-2">CONFIDENTIAL</h1>
      <h2 class="text-xl font-semibold text-center mb-6">TALAMBUHAY</h2>

      <div class="flex justify-end mt-4">
        <button @click="toggleEdit" class="px-4 py-2 bg-blue-500 text-white rounded-md">
          {{ editMode ? 'Save' : 'Edit' }}
        </button>
      </div>

      <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
        {{ message }}
      </div>
      <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Tungkol sa aking Pamilya</h3>
        <p class="text-gray-600 mb-2">(Ilan kaming magkakapatid at tungkol sa kanilang buhay o kaya trabaho; papa/mama at tungkol sa kanilang ikinabubuhay, tungkol sa pamilya at iba pa)</p>
        <textarea class="w-full mt-1 p-2 border border-gray-300 rounded-md" rows="10" v-model="form.about_my_family" :readonly="!editMode"></textarea>
      </div>

      <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Tungkol sa aking Sarili</h3>
        <p class="text-gray-600 mb-2">(Karanasan mula pagkabata, mga napagtagumpayan, mga bisyo/pagkakamali, eskwela, interes at mga gustong gawin, sports, ambisyon, pangarap at iba pa)</p>
        <textarea class="w-full mt-1 p-2 border border-gray-300 rounded-md" rows="10" v-model="form.about_my_self" :readonly="!editMode"></textarea>
      </div>

      <div class="text-center text-xs">
        <p>PAGE 1 of 3</p>
        <p>DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY), P.Y. Reyes Drive, Bajada, Davao City</p>
        <p>Email: rcydavao@gmail.com | Tel. No: 299-0348</p>
      </div>
    </div>

    <!-- Page 2 -->
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mb-10">
      <div class="text-right mb-4">
        <p class="text-xs">DSPTD-QF-01-A | REV 01 | 12 SEP 2023</p>
      </div>

      <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Tungkol sa aking kaso</h3>
        <p class="text-gray-600 mb-2">(Ano at papaano nangyari, detalye ng pangyayari, ano ang rason at bakit nasangkot "Na-apil" sa kaso, sino-sino ang sangkot at iba pa)</p>
        <textarea class="w-full mt-1 p-2 border border-gray-300 rounded-md" rows="15" v-model="form.about_my_case" :readonly="!editMode"></textarea>
      </div>

      <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Received & Assessed:</h3>
        <div class="flex justify-between mt-2">
          <div class="w-1/2 pr-2">
            <label class="block text-gray-700">Case Manager:</label>
            <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.case_manager" :readonly="!editMode">
          </div>
          <div class="w-1/2 pl-2">
            <label class="block text-gray-700">Pangalan ng Client at Pirma:</label>
            <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="clientName" :readonly="true">
          </div>
        </div>
      </div>

      <div class="text-center text-xs">
        <p>PAGE 2 of 3</p>
        <p>DSWD FIELD OFFICE XI, PROTECTIVE SERVICES DIVISION, REGIONAL REHABILITATION CENTER FOR YOUTH</p>
      </div>
    </div>

    <!-- Page 3 -->
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
      <div class="text-right mb-4">
        <p class="text-xs">DSPTD-QF-01-A | REV 01 | 12 SEP 2023</p>
      </div>

      <div class="mb-6">
        <label class="block text-gray-700 mb-2">Petsa:</label>
        <input type="date" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.date" :readonly="!editMode">
      </div>

      <div class="text-center text-xs">
        <p>PAGE 3 of 3</p>
        <p>DSWD FIELD OFFICE XI, PROTECTIVE SERVICES DIVISION, REGIONAL REHABILITATION CENTER FOR YOUTH</p>
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
      about_my_family: '',
      about_my_self: '',
      about_my_case: '',
      case_manager: '',
      date: ''
    });
    const clientName = ref('');
    const errorMessage = ref('');

    const fetchClientData = async (clientId) => {
      try {
        const clientResponse = await axios.get(`/api/clients/${clientId}`);
        const client = clientResponse.data;
        clientName.value = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
        form.value.client_id = client.id;

        const talambuhayResponse = await axios.get(`/api/talambuhay/${clientId}`);
        const talambuhay = talambuhayResponse.data;
        form.value.about_my_family = talambuhay.about_my_family || '';
        form.value.about_my_self = talambuhay.about_my_self || '';
        form.value.about_my_case = talambuhay.about_my_case || '';
        form.value.case_manager = talambuhay.case_manager || '';
        form.value.date = talambuhay.date || '';
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
        const response = await axios[form.value.id ? 'put' : 'post'](`/api/talambuhay${form.value.id ? '/' + form.value.id : ''}`, form.value);
        message.value = 'Data saved successfully!';
        messageType.value = 'success';
        errorMessage.value = '';

        if (!form.value.id) {
          form.value.id = response.data.id;
        }

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
