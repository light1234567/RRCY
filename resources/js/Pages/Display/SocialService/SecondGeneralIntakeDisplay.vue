<template>
  <div class="p-10 bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md">
      <div class="text-center mb-8">
        <h1 class="text-xl font-bold">GENERAL INTAKE SHEET</h1>
        <p>Date: <input type="date" v-model="sheet.date" class="border w-1/8 px-2 py-1" :readonly="!editMode" /></p>
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
        <h2 class="text-lg font-semibold">I. Identifying Information:</h2>
        <div class="space-y-2">
          <div>
            <label>Name of client</label>
            <input type="text" v-model="sheet.name" class="border w-full px-2 py-1" readonly />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label>Age</label>
              <input type="text" v-model="sheet.age" class="border w-full px-2 py-1" readonly />
            </div>
            <div>
              <label>Sex</label>
              <input type="text" v-model="sheet.sex" class="border w-full px-2 py-1" readonly />
            </div>
          </div>
          <div>
            <label>Address</label>
            <input type="text" v-model="sheet.address" class="border w-full px-2 py-1" readonly />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label>Date of Birth</label>
              <input type="date" v-model="sheet.date_of_birth" class="border w-full px-2 py-1" readonly />
            </div>
            <div>
              <label>Place of birth</label>
              <input type="text" v-model="sheet.place_of_birth" class="border w-full px-2 py-1" readonly />
            </div>
          </div>
          <div>
            <label>Religion</label>
            <input type="text" v-model="sheet.religion" class="border w-full px-2 py-1" readonly />
          </div>
          <div>
            <label>Occupation</label>
            <input type="text" v-model="sheet.occupation" class="border w-full px-2 py-1" :readonly="!editMode" />
          </div>
          <div>
            <label>Highest Educ'l Att't</label>
            <input type="text" v-model="sheet.highest_educ_att" class="border w-full px-2 py-1" :readonly="!editMode" />
          </div>
          <div>
            <label>Name of School</label>
            <input type="text" v-model="sheet.school_name" class="border w-full px-2 py-1" :readonly="!editMode" />
          </div>
          <div>
            <label>Class Adviser</label>
            <input type="text" v-model="sheet.class_adviser" class="border w-full px-2 py-1" :readonly="!editMode" />
          </div>
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">Vices/Start:</h2>
        <div class="space-y-2">
          <label><input type="checkbox" v-model="sheet.vices.gambling" :disabled="!editMode" /> Gambling</label><br />
          <label><input type="checkbox" v-model="sheet.vices.drugs" :disabled="!editMode" /> Drugs (_______)</label><br />
          <label><input type="checkbox" v-model="sheet.vices.cigarette" :disabled="!editMode" /> Cigarette</label><br />
          <label><input type="checkbox" v-model="sheet.vices.liquor" :disabled="!editMode" /> Liquor</label><br />
          <label><input type="checkbox" v-model="sheet.vices.computer_games" :disabled="!editMode" /> Computer Games (_______ hrs)</label><br />
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">Schools Activities Achievement:</h2>
        <div class="space-y-2">
          <textarea v-model="sheet.school_activities_achievement" class="border w-full px-2 py-1" rows="4" :readonly="!editMode"></textarea>
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">Family:</h2>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label>Mother's Occupation</label>
            <input type="text" v-model="sheet.occupation_of_mother" class="border w-full px-2 py-1" :readonly="!editMode" />
          </div>
          <div>
            <label>Father's Occupation</label>
            <input type="text" v-model="sheet.occupation_of_father" class="border w-full px-2 py-1" :readonly="!editMode" />
          </div>
        </div>
        <div class="space-y-2">
          <label>Siblings:</label>
          <input type="text" v-model="sheet.siblings[0]" class="border w-full px-2 py-1" :readonly="!editMode" />
          <input type="text" v-model="sheet.siblings[1]" class="border w-full px-2 py-1" :readonly="!editMode" />
          <input type="text" v-model="sheet.siblings[2]" class="border w-full px-2 py-1" :readonly="!editMode" />
        </div>
        <div class="space-y-2">
          <label>Responsible for Households Chores</label>
          <input type="text" v-model="sheet.responsible_for_households_chores" class="border w-full px-2 py-1" :readonly="!editMode" />
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">Community:</h2>
        <div class="space-y-2">
          <label>No. of Days Detention/Jail/CSWD/MSWDO</label>
          <input type="text" v-model="sheet.detention_days" class="border w-full px-2 py-1" :readonly="!editMode" />
          <label>Water Source</label><br />
          <label><input type="checkbox" v-model="sheet.community.water_source" :disabled="!editMode" /> Water Source</label><br />
          <label><input type="checkbox" v-model="sheet.community.light" :disabled="!editMode" /> Light</label><br />
          <label><input type="checkbox" v-model="sheet.community.barangay_facility" :disabled="!editMode" /> Barangay Facility</label><br />
          <label><input type="checkbox" v-model="sheet.community.health_center" :disabled="!editMode" /> Health Center</label><br />
          <label><input type="checkbox" v-model="sheet.community.internet" :disabled="!editMode" /> Internet</label><br />
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">House made of:</h2>
        <div class="space-y-2">
          <input type="text" v-model="sheet.house_made_of" class="border w-full px-2 py-1" :readonly="!editMode" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { ref, reactive, onMounted } from 'vue';
import { useRoute } from 'vue-router';

export default {
  name: 'GeneralIntakeSheetPart2',
  setup() {
    const route = useRoute();
    const editMode = ref(false);
    const message = ref('');
    const messageType = ref('');
    const clientId = ref(null);
    const sheet = reactive({
      id: null,
      name: '',
      age: '',
      sex: '',
      address: '',
      date_of_birth: '',
      place_of_birth: '',
      religion: '',
      occupation: '',
      highest_educ_att: '',
      school_name: '',
      class_adviser: '',
      date: '',
      vices: {
        gambling: false,
        drugs: false,
        cigarette: false,
        liquor: false,
        computer_games: false,
      },
      school_activities_achievement: '',
      occupation_of_mother: '',
      occupation_of_father: '',
      siblings: ['', '', ''],
      responsible_for_households_chores: '',
      detention_days: '',
      community: {
        water_source: false,
        light: false,
        barangay_facility: false,
        health_center: false,
        internet: false,
      },
      house_made_of: '',
    });

    const fetchClientData = async (id) => {
      try {
        const response = await axios.get(`/api/clients/${id}`);
        const client = response.data;

        sheet.name = `${client.first_name} ${client.last_name}`;
        sheet.age = calculateAge(client.date_of_birth);
        sheet.sex = client.sex;
        sheet.address = `${client.province}, ${client.city}, ${client.barangay}, ${client.street}`;
        sheet.date_of_birth = client.date_of_birth;
        sheet.place_of_birth = client.place_of_birth;
        sheet.religion = client.religion;

        const firstIntakeResponse = await axios.get(`/api/general-intake-sheets/${id}?intake=first`);
        const firstIntake = firstIntakeResponse.data;

        sheet.occupation = firstIntake.occupation;
        sheet.highest_educ_att = firstIntake.highest_educ_att;
        sheet.school_name = firstIntake.school_name;
        sheet.class_adviser = firstIntake.class_adviser;

        const secondIntakeResponse = await axios.get(`/api/second-intake-sheets/${id}`);
        const secondIntake = secondIntakeResponse.data;

        Object.assign(sheet, secondIntake);
      } catch (error) {
        console.error('Error fetching client data:', error);
      }
    };

    const calculateAge = (birthDate) => {
      const today = new Date();
      const birthDateObj = new Date(birthDate);
      let age = today.getFullYear() - birthDateObj.getFullYear();
      const monthDiff = today.getMonth() - birthDateObj.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDateObj.getDate())) {
        age--;
      }
      return age;
    };

    onMounted(() => {
      clientId.value = route.params.id;
      fetchClientData(clientId.value);
    });

    const toggleEdit = () => {
      if (editMode.value) {
        saveData();
      }
      editMode.value = !editMode.value;
    };

    const saveData = () => {
      if (!clientId.value) {
        message.value = 'No client selected.';
        messageType.value = 'error';
        clearNotification();
        return;
      }

      const payload = {
        client_id: clientId.value,
        ...sheet,
      };

      const method = sheet.id ? 'put' : 'post';
      const url = `/api/second-intake-sheets${sheet.id ? '/' + sheet.id : ''}`;

      axios[method](url, payload)
        .then(response => {
          message.value = 'Data saved successfully.';
          messageType.value = 'success';
          clearNotification();
          if (!sheet.id) sheet.id = response.data.id;
        })
        .catch(error => {
          message.value = error.response.data.message || 'Error saving data.';
          messageType.value = 'error';
          console.error('Error saving data:', error);
          clearNotification();
        });
    };

    const clearNotification = () => {
      setTimeout(() => {
        message.value = '';
        messageType.value = '';
      }, 3000);
    };

    return {
      editMode,
      message,
      messageType,
      sheet,
      toggleEdit,
      saveData,
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
.bg-green-500:hover {
  background-color: #38a169;
}
</style>
