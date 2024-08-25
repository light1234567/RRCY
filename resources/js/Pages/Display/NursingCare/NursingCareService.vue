<template>
  <div class="p-4">
    <!-- Tabs for Actions -->
    <div v-if="editMode" class="flex absolute p-4 space-x-4">
      <button @click="cancelEdit" class="flex space-x-2 px-3 py-1 bg-customBlue text-white rounded-md text-xs">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Back</span>
      </button>
    </div>

    <div class="flex justify-end bg-transparent border border-gray-300 p-4 rounded-md space-x-4 mt-4">
      <button @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.3 2.7a1 1 0 011.4 0l1.3 1.3a1 1 0 010 1.4l-9.4 9.4a1 1 0 01-.6.3l-2.8.6a1 1 0 01-1.2-1.2l.6-2.8a1 1 0 01.3-.6l9.4-9.4z" />
        </svg>
        <span>Edit</span>
      </button>

      <button v-if="editMode" @click="openModal" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span>Save</span>
      </button>
    </div>

    <!-- Save Confirmation Modal -->
    <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50">
      <div class="fixed inset-0 bg-black opacity-50"></div>
      <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
        <div class="bg-white p-16">
          <div class="flex items-center">
            <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.93 5h13.86c1.1 0 1.96-.9 1.84-1.98l-1.18-12.14a2 2 0 00-1.98-1.88H4.27a2 2 0 00-1.98 1.88L1.11 16.02c-.12 1.08.74 1.98 1.84 1.98z"/>
            </svg>
            <h3 class="text-lg leading-6 font-medium text-gray-900">Save changes?</h3>
          </div>
          <div class="mt-2">
            <p class="text-sm text-gray-500">Are you sure you want to save the changes?</p>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button @click="confirmSave" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Save</button>
          <button @click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
        </div>
      </div>
    </div>

    <!-- Save Result Modal -->
    <div v-if="isSaveResultModalOpen" class="fixed inset-0 flex items-center justify-center z-50">
      <div class="fixed inset-0 bg-black opacity-50"></div>
      <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
        <div class="bg-white p-6 text-center">
          <div v-if="saveResultTitle === 'Error'" class="flex justify-center items-center mb-4">
            <div class="flex items-center justify-center w-12 h-12 bg-red-100 rounded-full">
              <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </div>
          </div>
          <div v-if="saveResultTitle === 'Success'" class="flex justify-center items-center mb-4">
            <div class="flex items-center justify-center w-12 h-12 bg-blue-500 rounded-full">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
          </div>
          <h3 class="text-lg leading-6 font-medium text-gray-900">{{ saveResultTitle }}</h3>
          <div class="mt-2">
            <p class="text-sm text-gray-500">{{ saveResultMessage }}</p>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button @click="closeSaveResultModal" :class="saveResultTitle === 'Error' ? 'bg-red-600 hover:bg-red-500' : 'bg-blue-600 hover:bg-blue-500'" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
            OK
          </button>
        </div>
      </div>
    </div>

    <!-- Nursing Care Service Form -->
    <div class="text-center border-b pb-2 mb-4">
      <div class="flex justify-between items-center">
        <img src="path-to-your-logo.png" alt="DSWD Logo" class="h-12">
        <div>
          <h1 class="text-lg font-bold">REGIONAL REHABILITATION CENTER FOR YOUTH</h1>
          <h2 class="text-md">RRCY/FIELD OFFICE XI</h2>
          <h3 class="text-sm">DSWD-GF-010 | REV 01 | 17 AUG 2022</h3>
        </div>
        <img src="path-to-your-logo.png" alt="DSWD Logo" class="h-12">
      </div>
      <h1 class="text-xl font-bold mt-2">NURSING CARE SERVICE</h1>
    </div>

    <!-- Form Fields -->
    <div class="grid grid-cols-3 gap-4 mb-4">
      <div class="col-span-1">
        <label class="block font-bold">CLIENT'S NAME:</label>
        <input type="text" v-model="form.client_name" class="w-full border p-1" readonly>
      </div>
      <div class="col-span-1">
        <label class="block font-bold">BIRTHDATE:</label>
        <input type="date" v-model="form.birthdate" class="w-full border p-1" readonly>
      </div>
      <div class="col-span-1">
        <label class="block font-bold">AGE:</label>
        <input type="number" v-model="form.age" class="w-full border p-1" readonly>
      </div>
      <div class="col-span-1">
        <label class="block font-bold">CURRENT MEDICAL STATUS:</label>
        <input type="text" v-model="form.current_medical_status" class="w-full border p-1" :readonly="!editMode">
      </div>
      <div class="col-span-1">
        <label class="block font-bold">RELIGION:</label>
        <input type="text" v-model="form.religion" class="w-full border p-1" readonly>
      </div>
      <div class="col-span-1">
        <label class="block font-bold">ADDRESS:</label>
        <input type="text" v-model="form.address" class="w-full border p-1" readonly>
      </div>
      <div class="col-span-2">
        <label class="block font-bold">DATE OF ADMISSION:</label>
        <input type="date" v-model="form.date_of_admission" class="w-full border p-1" readonly>
      </div>
    </div>

    <!-- Vital Signs & BMI Table -->
    <div class="text-center border-b pb-2 mb-4">
      <h2 class="text-lg font-bold">MONTHLY BMI MONITORING 2024</h2>
    </div>

    <table class="w-full border-collapse border mb-4">
      <thead>
        <tr class="bg-gray-100">
          <th class="border p-2">VITAL SIGNS / BMI</th>
          <th class="border p-2">APRIL</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border p-2">TEMPERATURE</td>
          <td class="border p-2"><input type="number" v-model="form.temperature" class="w-full border p-1" :readonly="!editMode"></td>
        </tr>
        <tr>
          <td class="border p-2">PULSE RATE</td>
          <td class="border p-2"><input type="number" v-model="form.pulse_rate" class="w-full border p-1" :readonly="!editMode"></td>
        </tr>
        <tr>
          <td class="border p-2">RESPIRATORY RATE</td>
          <td class="border p-2"><input type="number" v-model="form.respiratory_rate" class="w-full border p-1" :readonly="!editMode"></td>
        </tr>
        <tr>
          <td class="border p-2">BLOOD PRESSURE</td>
          <td class="border p-2"><input type="text" v-model="form.blood_pressure" class="w-full border p-1" :readonly="!editMode"></td>
        </tr>
        <tr>
          <td class="border p-2">HEIGHT (cm)</td>
          <td class="border p-2"><input type="number" v-model="form.height_cm" @input="computeBMI" class="w-full border p-1" :readonly="!editMode"></td>
        </tr>
        <tr>
          <td class="border p-2">WEIGHT (kg)</td>
          <td class="border p-2"><input type="number" v-model="form.weight_kg" @input="computeBMI" class="w-full border p-1" :readonly="!editMode"></td>
        </tr>
        <tr>
          <td class="border p-2">BODY MASS INDEX (BMI)</td>
          <td class="border p-2"><input type="number" v-model="form.bmi" class="w-full border p-1" readonly></td>
        </tr>
        <tr>
          <td class="border p-2">BMI REMARKS</td>
          <td class="border p-2"><input type="text" v-model="form.bmi_remarks" class="w-full border p-1" :readonly="!editMode"></td>
        </tr>
      </tbody>
    </table>

    <!-- General Appearance -->
<div class="text-center border-b pb-2 mb-4">
  <h2 class="text-lg font-bold">GENERAL APPEARANCE</h2>
</div>

<table class="w-full border-collapse border mb-4">
  <tbody>
    <tr>
      <td class="border p-2">EYES:</td>
      <td class="border p-2"><input type="text" v-model="form.eyes_status" class="w-full border p-1" :readonly="!editMode"></td>
      <td class="border p-2">SKIN:</td>
      <td class="border p-2"><input type="text" v-model="form.skin_status" class="w-full border p-1" :readonly="!editMode"></td>
    </tr>
    <tr>
      <td class="border p-2">NAILS:</td>
      <td class="border p-2"><input type="text" v-model="form.nails_status" class="w-full border p-1" :readonly="!editMode"></td>
      <td class="border p-2">MOUTH & TEETH:</td>
      <td class="border p-2"><input type="text" v-model="form.mouth_teeth_status" class="w-full border p-1" :readonly="!editMode"></td>
    </tr>
    <tr>
      <td class="border p-2">EARS:</td>
      <td class="border p-2"><input type="text" v-model="form.ears_status" class="w-full border p-1" :readonly="!editMode"></td>
      <td class="border p-2">HAIR:</td>
      <td class="border p-2"><input type="text" v-model="form.hair_status" class="w-full border p-1" :readonly="!editMode"></td>
    </tr>
  </tbody>
</table>


    <!-- Services Given -->
    <div class="border-b pb-2 mb-4">
      <h2 class="text-lg font-bold">SERVICES GIVEN:</h2>
      <textarea v-model="form.services_given" class="w-full border p-2" rows="3" :readonly="!editMode"></textarea>
    </div>

    <!-- Remarks -->
    <div class="border-b pb-2 mb-4">
      <h2 class="text-lg font-bold">REMARKS:</h2>
      <textarea v-model="form.remarks" class="w-full border p-2" rows="3" :readonly="!editMode"></textarea>
    </div>

    <!-- Prepared and Noted By -->
    <div class="flex justify-between items-center">
      <div>
        <h2 class="text-lg font-bold">PREPARED BY:</h2>
        <input type="text" v-model="form.prepared_by" class="w-full border p-1" :readonly="!editMode">
      </div>
      <div>
        <h2 class="text-lg font-bold">NOTED BY:</h2>
        <input type="text" v-model="form.noted_by" class="w-full border p-1" :readonly="!editMode">
      </div>
    </div>
  </div>
</template>


<script>
import axios from 'axios';

export default {
  data() {
    return {
      form: {
        client_name: '',
        birthdate: '',
        age: '',
        current_medical_status: '',
        religion: '',
        address: '',
        date_of_admission: '',
        temperature: '',
        pulse_rate: '',
        respiratory_rate: '',
        blood_pressure: '',
        height_cm: '',
        weight_kg: '',
        bmi: '',
        bmi_remarks: '',
        eyes_status: '',
        nails_status: '',
        ears_status: '',
        skin_status: '',
        mouth_teeth_status: '',
        hair_status: '',
        services_given: '',
        remarks: '',
        prepared_by: '',
        noted_by: '',
      },
      editMode: false,
      isModalOpen: false,
      isSaveResultModalOpen: false,
      saveResultTitle: '',
      saveResultMessage: '',
    };
  },
  mounted() {
    const clientId = this.$route.params.id;
    console.log('Client ID on mounted:', clientId);
    this.fetchData(clientId);
  },
  watch: {
    '$route.params.id'(newClientId) {
      console.log('Client ID changed:', newClientId);
      this.fetchData(newClientId);
    }
  },
  methods: {
    async fetchData(clientId) {
    try {
        console.log('Fetching data for client ID:', clientId);
        if (clientId) {
            const response = await axios.get(`/api/initial-psychological-assessments/${clientId}`);
            console.log('Fetched data:', response.data);

            if (response.data.assessment) {
                Object.assign(this.form, response.data.assessment);
                this.form.client_id = clientId; // Set the client_id here

                const client = response.data.client;
                const admission = response.data.admission;

                this.form.client_name = `${client.first_name} ${client.last_name}`;
                this.form.birthdate = client.date_of_birth;
                this.form.age = this.calculateAge(client.date_of_birth);
                this.form.religion = client.religion;
                this.form.address = `${client.street}, ${client.barangay}, ${client.city}, ${client.province}`;
                this.form.date_of_admission = admission.date_admitted;

                const serviceResponse = await axios.get(`/api/nursing-care-services/${clientId}`);
                console.log('Nursing care service data:', serviceResponse.data);
                if (serviceResponse.data) {
                    Object.assign(this.form, serviceResponse.data);
                }
            } else {
                const { client, admission } = response.data;
                this.form.client_id = clientId; // Set the client_id here
                this.form.client_name = `${client.first_name} ${client.middle_name || ''} ${client.last_name}`.trim();
                this.form.birthdate = client.date_of_birth;
                this.form.age = this.calculateAge(client.date_of_birth);
                this.form.religion = client.religion;
                this.form.address = `${client.street || ''} ${client.barangay}, ${client.city}, ${client.province}`.trim();
                this.form.date_of_admission = admission.date_admitted;

                const serviceResponse = await axios.get(`/api/nursing-care-services/${clientId}`);
                console.log('Nursing care service data:', serviceResponse.data);
                if (serviceResponse.data) {
                    Object.assign(this.form, serviceResponse.data);
                }
            }
        }
    } catch (error) {
        console.error('Error fetching data:', error);
    }
},
    calculateAge(birthDate) {
      const today = new Date();
      const birthDateObj = new Date(birthDate);
      let age = today.getFullYear() - birthDateObj.getFullYear();
      const monthDiff = today.getMonth() - birthDateObj.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDateObj.getDate())) {
        age--;
      }
      return age;
    },
    computeBMI() {
      const heightInMeters = this.form.height_cm / 100;
      const weight = this.form.weight_kg;

      if (heightInMeters > 0 && weight > 0) {
        const bmi = weight / (heightInMeters * heightInMeters);
        this.form.bmi = bmi.toFixed(2);
      } else {
        this.form.bmi = '';
      }
    },
    toggleEdit() {
      if (this.editMode) {
        this.openModal();
      } else {
        this.editMode = !this.editMode;
      }
    },
    openModal() {
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
    },
    async confirmSave() {
      try {
        await this.saveData();
        this.saveResultTitle = 'Success';
        this.saveResultMessage = 'Data saved successfully!';
      } catch (error) {
        console.error('Save error:', error.response ? error.response.data : error.message);
        this.saveResultTitle = 'Error';
        this.saveResultMessage = 'Failed to save data.';
      } finally {
        this.closeModal();
        this.editMode = false;
        this.isSaveResultModalOpen = true;
      }
    },
    cancelEdit() {
      this.editMode = false;
    },
    async saveData() {
      const url = this.form.id
        ? `/api/nursing-care-services/${this.form.id}`
        : '/api/nursing-care-services';
      const method = this.form.id ? 'put' : 'post';

      try {
        console.log('Saving data:', this.form);
        const response = await axios[method](url, this.form);
        console.log('Save response:', response.data);
        if (!this.form.id) {
          this.form.id = response.data.id;
        }
      } catch (error) {
        console.error('Error saving data:', error.response ? error.response.data : error.message);
        throw new Error('Error saving data.');
      }
    },
    closeSaveResultModal() {
      this.isSaveResultModalOpen = false;
      this.saveResultTitle = '';
      this.saveResultMessage = '';
    },
  },
};

</script>
