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
          <h1 class="text-2xl font-bold text-center mb-4">DATA PRIVACY CONSENT</h1>
          <div class="flex justify-end mb-4">
              <button @click="toggleEdit" class="px-4 py-2 bg-blue-500 text-white rounded-md mt-4">
                  {{ editMode ? 'Save' : 'Edit' }}
              </button>
          </div>
          <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
              {{ message }}
          </div>
          <div class="mb-6">
              <p>To Whom It May Concern:</p>
              <p class="mt-4">
                  I, <span class="font-bold underline">{{ clientName }}</span>, give my consent for the information concerning my file to be furnished by the DSWD-Regional Rehabilitation Center for Youth (RRCY) and/or its authorized personnel to Philippine courts, concerned local government units, and legal professionals. I request that any relevant information that may be required for purposes enumerated hereunder be provided in accordance with the provisions of the Data Privacy Act of 2012:
              </p>
              <ol class="list-decimal ml-6 mt-4">
                  <li>To assist in responding to Criminal Cases (Court, Lawyer, Prosecutor)</li>
                  <li>To report to the PNP any untoward incident by the resident</li>
                  <li>To request reports from the concerned LGUs e.g. Parenting Capability Assessment Report (PCAR), Transfer Summary Report and LGU Claims</li>
                  <li>To assist in responding to the health needs (medical, psychological), school requirements and training agencies (LTO, TESDA, etc)</li>
                  <li>To assist in the provision of financial assistance intended for basic needs, travel expenses, and medical needs</li>
                  <li>To submit monthly, quarterly, semestral and annual reports to the Field Office and Central Office</li>
              </ol>
              <p class="mt-4">
                  I understand and accept that this will include access to personal data and records submitted, which may be considered sensitive personal data as provided for under Republic Act No. 10173, otherwise known as the Data Privacy Act of 2012.
              </p>
              <p class="mt-4">
                  Further, any records and related information associated with my case shall be kept from any and all public disclosure and shall be retained only for as long as necessary for the fulfillment of the purposes above-stated.
              </p>
              <p class="mt-4">
                  I understand and agree that this consent will remain valid and in force until I revoke it in writing.
              </p>
          </div>
          <div class="flex justify-between items-center mt-8">
              <div>
                  <label class="block text-gray-700">Name and signature (Client):</label>
                  <input type="text" class="w-full mt-2 p-2 border border-gray-300 rounded-md" v-model="form.client_signature" :readonly="!editMode">
              </div>
              <div>
                  <label class="block text-gray-700">Date:</label>
                  <input type="date" class="w-full mt-2 p-2 border border-gray-300 rounded-md" v-model="form.date" :readonly="!editMode">
              </div>
          </div>
          <div class="text-center text-xs mt-10">
              <p>PAGE 1 of 2</p>
              <p>DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY), P.Y. Reyes Drive, Bajada, Davao City</p>
              <p>Email: rcydavao@gmail.com | Tel. No: 299-0348 | Website: www.dswd.gov.ph</p>
          </div>
      </div>
      <!-- Page 2 -->
      <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
          <div class="text-right mb-4">
              <p class="text-xs">DSPTD-QF-01-A | REV 01 | 12 SEP 2023</p>
          </div>
          <div class="mb-6">
              <label class="block text-gray-700 mb-2">Name and signature (Parent/Guardian):</label>
              <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.guardian_signature" :readonly="!editMode">
          </div>
          <div class="text-center text-xs mt-10">
              <p>PAGE 2 of 2</p>
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
          client_signature: '',
          date: '',
          guardian_signature: '',
          id: null // Add id to track existing record
      });
      const clientName = ref('');
      const errorMessage = ref('');

      const fetchClientData = async (clientId) => {
          try {
              const clientResponse = await axios.get(`/api/clients/${clientId}`);
              const client = clientResponse.data;
              clientName.value = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
              form.value.client_id = client.id;

              const consentResponse = await axios.get(`/api/data-privacy-consent/${clientId}`);
              const consent = consentResponse.data;
              form.value.client_signature = consent.client_signature || '';
              form.value.date = consent.date || '';
              form.value.guardian_signature = consent.guardian_signature || '';
              form.value.id = consent.id; // Capture the consent id if it exists
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
              setTimeout(() => {
                  message.value = '';
              }, 3000);
              return;
          }

          try {
              const response = await axios({
                  method: form.value.id ? 'put' : 'post',
                  url: `/api/data-privacy-consent${form.value.id ? '/' + form.value.id : ''}`,
                  data: form.value
              });
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
              setTimeout(() => {
                  message.value = '';
              }, 3000);
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
