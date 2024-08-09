<template>
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


        <button v-if="editMode" @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          <span>Save</span>
        </button>
      </div>

        <!-- Modal for Save Confirmation -->
     <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50">
      <div class="fixed inset-0 bg-black opacity-50"></div>
      <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
        <div class="bg-white p-6">
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

    <!-- Modal for Save Result -->
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



    <div class="p-8 bg-white shadow-xl rounded-lg max-w-4xl mx-auto my-8">
        <div class=" p-8 ">
      
        <div class="relative flex justify-between items-center mb-2">
      <img src="/images/headerlogo2.png" alt="Logo" class="h-24 w-48 relative z-10">
      <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
    </div>

    <div class="bg-white p-8 rounded shadow-md">
      <div class="text-center mb-8">
        <h1 class="text-xl font-bold">GENERAL INTAKE SHEET</h1>
        <p>Date: <input type="date" v-model="sheet.date" class="border w-1/8 px-2 py-1" :readonly="!editMode" /></p>
      </div>

    

      <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
        {{ message }}
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">I. Identifying Information:</h2>
        <div class="space-y-2">
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Name of client:</label>
            <input type="text" v-model="sheet.name" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="flex-grow flex items-center mr-4">
              <label class="block text-base font-semibold text-gray-700 mr-4">Age:</label>
              <input type="text" v-model="sheet.age" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
            </div>
            <div class="flex-grow flex items-center mr-4">
              <label class="block text-base font-semibold text-gray-700 mr-4">Sex:</label>
              <input type="text" v-model="sheet.sex" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
            </div>
          </div>
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Address:</label>
            <input type="text" v-model="sheet.address" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="flex-grow flex items-center mr-4">
              <label class="block text-base font-semibold text-gray-700 mr-4">Date of Birth:</label>
              <input type="date" v-model="sheet.date_of_birth" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
            </div>
            <div class="flex-grow flex items-center mr-4">
              <label class="block text-base font-semibold text-gray-700 mr-4">Place of birth:</label>
              <input type="text" v-model="sheet.place_of_birth" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
            </div>
          </div>
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Religion:</label>
            <input type="text" v-model="sheet.religion" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
          </div>
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Occupation:</label>
            <input type="text" v-model="sheet.occupation" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
          </div>
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Highest Educ'l Att't:</label>
            <input type="text" v-model="sheet.highest_educ_att" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
          </div>
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Name of School:</label>
            <input type="text" v-model="sheet.school_name" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
          </div>
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Class Adviser:</label>
            <input type="text" v-model="sheet.class_adviser" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
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
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Mother's Occupation:</label>
            <input type="text" v-model="sheet.occupation_of_mother" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
          </div>
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Father's Occupation:</label>
            <input type="text" v-model="sheet.occupation_of_father" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
          </div>
        </div>
        <div class="space-y-2">
          <label>Siblings:</label>
          <input type="text" v-model="sheet.siblings[0]" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
          <input type="text" v-model="sheet.siblings[1]" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
          <input type="text" v-model="sheet.siblings[2]" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
        </div>
        <div class="space-y-2">
          <label>Responsible for Households Chores:</label>
          <input type="text" v-model="sheet.responsible_for_households_chores" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">Community:</h2>
        <div class="space-y-2">
          <label>No. of Days Detention/Jail/CSWD/MSWDO:</label>
          <input type="text" v-model="sheet.detention_days" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
          <label>Water Source:</label><br />
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
          <input type="text" v-model="sheet.house_made_of" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
        </div>
      </div>
    </div>
    <div class="border-gray-300 ml-6 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        <div class="flex flex-col">
          <p class="ml-24 -mb-4 font-bold">PAGE 1 of 1</p>
          <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
          <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
        </div>
        <div class="ml-4">
          <img src="images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
        </div>
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
    const isModalOpen = ref(false);
    const isSaveResultModalOpen = ref(false);
    const saveResultTitle = ref('');
    const saveResultMessage = ref('');

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
        openModal();
      } else {
        editMode.value = !editMode.value;
      }
    };

    const openModal = () => {
      isModalOpen.value = true;
    };

    const closeModal = () => {
      isModalOpen.value = false;
    };

    const confirmSave = () => {
      saveData();
      closeModal();
      editMode.value = false;
    };

    const cancelEdit = () => {
      editMode.value = false;
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
          saveResultTitle.value = 'Success';
          saveResultMessage.value = 'Data saved successfully.';
          if (!sheet.id) sheet.id = response.data.id;
          editMode.value = false;
        })
        .catch(error => {
          saveResultTitle.value = 'Error';
          saveResultMessage.value = error.response.data.message || 'Error saving data.';
          console.error('Error saving data:', error);
        })
        .finally(() => {
          isModalOpen.value = false;
          isSaveResultModalOpen.value = true;
        });
    };

    const closeSaveResultModal = () => {
      isSaveResultModalOpen.value = false;
      saveResultTitle.value = '';
      saveResultMessage.value = '';
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
      isModalOpen,
      openModal,
      closeModal,
      confirmSave,
      cancelEdit,
      isSaveResultModalOpen,
      saveResultTitle,
      saveResultMessage,
      closeSaveResultModal,
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
@keyframes twinkle {
  0%, 100% { border-color: #a1b6cf; }
  50% { border-color: white; }
}
.twinkle-border {
  animation: twinkle 2s infinite;
}
</style>
