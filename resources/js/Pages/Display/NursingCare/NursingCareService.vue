<template>
  <div class="p-8 bg-white max-w-screen-md mx-auto border border-gray-300 rounded-lg shadow-lg">
    <!-- Edit and Save Buttons -->
    <div class="flex justify-end space-x-4 mb-4">
      <button @click="toggleEdit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
        <span v-if="!editMode">Edit</span>
        <span v-else>Cancel</span>
      </button>
      <button v-if="editMode" @click="saveData" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
        Save
      </button>
    </div>

    <!-- Header Section -->
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

    <!-- Client Information Section -->
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

    <!-- BMI Monitoring Table -->
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

    <div class="flex mb-4">
      <div class="w-2/3">
        <table class="w-full border-collapse border">
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
      </div>
      <div class="w-1/3 flex justify-center items-center">
        <div class="w-32 h-32 border border-gray-300 rounded-full overflow-hidden">
          <!-- Profile picture should go here -->
          <img src="path-to-profile-pic.png" alt="Profile Picture" class="w-full h-full object-cover">
        </div>
      </div>
    </div>

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
      <div class="w-1/2">
        <h2 class="text-lg font-bold">PREPARED BY:</h2>
        <input type="text" v-model="form.prepared_by" class="w-full border p-1" :readonly="!editMode">
      </div>
      <div class="w-1/2">
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
    };
  },
  mounted() {
    const clientId = this.$route.params.id;
    this.fetchData(clientId);
  },
  watch: {
    '$route.params.id'(newClientId) {
      this.fetchData(newClientId);
    }
  },
  methods: {
    async fetchData(clientId) {
      try {
        const response = await axios.get(`/api/initial-psychological-assessments/${clientId}`);
        if (response.data.assessment) {
          Object.assign(this.form, response.data.assessment);
          this.form.client_id = clientId;
          const client = response.data.client;
          const admission = response.data.admission;
          this.form.client_name = `${client.first_name} ${client.last_name}`;
          this.form.birthdate = client.date_of_birth;
          this.form.age = this.calculateAge(client.date_of_birth);
          this.form.religion = client.religion;
          this.form.address = `${client.street}, ${client.barangay}, ${client.city}, ${client.province}`;
          this.form.date_of_admission = admission.date_admitted;
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
      this.editMode = !this.editMode;
    },
    async saveData() {
      // Add your save logic here
      this.toggleEdit();
    },
  },
};
</script>
