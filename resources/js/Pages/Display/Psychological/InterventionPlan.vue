<template>
  <!-- Tabs for Actions -->
  <div class="flex absolute p-4 space-x-4">
    <button @click="cancelEdit" class="flex space-x-2 px-3 py-1 bg-customBlue text-white rounded-md text-xs">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      <span>Back</span>
    </button>
  </div>

  <div class="flex justify-end bg-transparent border border-gray-300 p-4 rounded-md space-x-4 mt-4">
    <div class="w-full text-black ml-40 text-center text-md" v-if="!editMode">
      VIEW MODE
    </div>

    <div v-if="editMode" class="w-full text-black ml-40 text-center text-md">
      EDIT MODE
    </div>

    <button @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.3 2.7a1 1 0 011.4 0l1.3 1.3a1 1 0 010 1.4l-9.4 9.4a1 1 0 01-.6.3l-2.8.6a1 1 0 01-1.2-1.2l.6-2.8a1 1 0 01.3-.6l9.4-9.4z" />
      </svg>
      <span>Edit</span>
    </button>

    <button @click="addItem" class="flex items-center space-x-2 px-3 py-1 bg-customBlue text-white rounded-md text-xs" v-if="editMode">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" />
      </svg>
      <span>Add Row</span>
    </button>

    <button @click="downloadAction" class="flex items-center space-x-2 px-3 py-1 bg-customBlue text-white rounded-md text-xs">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7m7 7V3" />
      </svg>
      <span>Download</span>
    </button>

    <button v-if="editMode" @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg>
      <span>Save</span>
    </button>
  </div>

  <div class="max-w-4xl p-6 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
    <div class="relative flex justify-between items-center mb-2">
      <img src="/images/headerlogo2.png" alt="Logo" class="h-24 w-48 relative z-10">
      <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
    </div>

    <div class="p-4">
      <h1 class="text-xl font-bold mb-4 text-center">Psychological Intervention Plan</h1>
      <div class="flex justify-center items-center my-4">
  <p>Date: 
    <input type="date" v-model="form.as_of_date" 
    class="flex-grow border-b-0 border-black border-t-0 mr-4 border-l-0 border-r-0 rounded-none shadow-sm w-1/8 px-2 py-1" 
    :readonly="!editMode" />
  </p>
</div>


      <div v-if="message" :class="`p-2 mt-4 text-white rounded-md text-xs ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
        {{ message }}
      </div>

      <!-- Client Details -->
      <div class="mb-4 text-xs">
        <div class="grid grid-cols-2 gap-2">
          <div class="flex items-center">
            <label class="font-semibold w-1/5">Name:</label>
            <input type="text" v-model="clientName" :class="{'twinkle-border': editMode}" class="w-3/4 border border-transparent p-1" readonly>
          </div>
          <div class="flex items-center">
            <label class="font-semibold w-1/5">Age:</label>
            <input type="text" v-model="age" :class="{'twinkle-border': editMode}" class="w-3/4 border border-transparent p-1" readonly>
          </div>
          <div class="flex items-center">
            <label class="font-semibold w-1/5">Date Admitted:</label>
            <input type="date" v-model="dateAdmitted" :class="{'twinkle-border': editMode}" class="w-3/4 border border-transparent p-1" readonly>
          </div>
        </div>
      </div>

      <!-- Intervention Plan Table -->
      <table class="min-w-full bg-white border border-black text-xs">
        <thead>
          <tr>
            <th class="py-1 px-2 border-b border-r border-black">Objectives</th>
            <th class="py-1 px-2 border-b border-r border-black">Activities</th>
            <th class="py-1 px-2 border-b border-r border-black">Responsible Person</th>
            <th class="py-1 px-2 border-b border-r border-black">Time Frame</th>
            <th class="py-1 px-2 border-b border-r border-black">Expected Output</th>
            <th class="py-1 px-2 border-b border-black">Progress</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="py-1 px-2 border-b border-r border-black">
              <textarea v-model="form.objectives" :readonly="!editMode" class="w-full p-1 border border-transparent"></textarea>
            </td>
            <td class="py-1 px-2 border-b border-r border-black">
              <textarea v-model="form.activities" :readonly="!editMode" class="w-full p-1 border border-transparent"></textarea>
            </td>
            <td class="py-1 px-2 border-b border-r border-black">
              <input type="text" v-model="form.responsible_person" :readonly="!editMode" class="w-full p-1 border border-transparent" />
            </td>
            <td class="py-1 px-2 border-b border-r border-black">
              <input type="text" v-model="form.time_frame" :readonly="!editMode" class="w-full p-1 border border-transparent" />
            </td>
            <td class="py-1 px-2 border-b border-r border-black">
              <textarea v-model="form.expected_output" :readonly="!editMode" class="w-full p-1 border border-transparent"></textarea>
            </td>
            <td class="py-1 px-2 border-b border-black">
              <textarea v-model="form.progress" :readonly="!editMode" class="w-full p-1 border border-transparent"></textarea>
            </td>
          </tr>
          <!-- Add empty rows for additional entries -->
          <tr v-for="i in 5" :key="'empty' + i" class="hover:bg-gray-100">
            <td class="py-1 px-2 border-b border-r border-black"><textarea :readonly="!editMode" class="w-full p-1 border border-transparent"></textarea></td>
            <td class="py-1 px-2 border-b border-r border-black"><textarea :readonly="!editMode" class="w-full p-1 border border-transparent"></textarea></td>
            <td class="py-1 px-2 border-b border-r border-black"><input type="text" :readonly="!editMode" class="w-full p-1 border border-transparent" /></td>
            <td class="py-1 px-2 border-b border-r border-black"><input type="text" :readonly="!editMode" class="w-full p-1 border border-transparent" /></td>
            <td class="py-1 px-2 border-b border-r border-black"><textarea :readonly="!editMode" class="w-full p-1 border border-transparent"></textarea></td>
            <td class="py-1 px-2 border-b border-black"><textarea :readonly="!editMode" class="w-full p-1 border border-transparent"></textarea></td>
          </tr>
        </tbody>
      </table>

      <!-- Progress Notes Section -->
      <div class="space-y-4 mt-6">
        <label for="progressNotes" class="block font-medium">Progress Notes:</label>
        <textarea v-model="form.progress_notes" :readonly="!editMode" class="block w-full p-2 border border-transparent"></textarea>
      </div>

      <!-- Signatures Section -->
      <div class="mt-4 grid grid-cols-3 gap-2 text-xs">
        <div>
          <label class="font-semibold">Prepared by:</label>
          <input type="text" v-model="form.prepared_by" :readonly="!editMode" class="w-full border border-transparent p-1" />
          <div class="text-xs mt-1">Psychologist I</div>
        </div>
        <div>
          <label class="font-semibold">Noted by:</label>
          <input type="text" v-model="form.noted_by" :readonly="!editMode" class="w-full border border-transparent p-1" />
          <div class="text-xs mt-1">SWO IV / Center Head</div>
        </div>
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
      id: null,
      as_of_date: '',
      objectives: '',
      activities: '',
      responsible_person: '',
      time_frame: '',
      expected_output: '',
      progress: '',
      progress_notes: '',
      prepared_by: '',
      noted_by: '',
    });
    const clientName = ref('');
    const age = ref('');
    const dateAdmitted = ref('');

    const fetchPlanData = async (clientId) => {
      try {
        const response = await axios.get(`/api/psychological-intervention-plans/${clientId}`);
        return response.data;
      } catch (error) {
        console.error('Error fetching intervention plan:', error);
        return null;
      }
    };

    const fetchData = async (clientId) => {
    try {
        console.log(`Fetching client data for client_id: ${clientId}`);

        const clientResponse = await axios.get(`/api/clients/${clientId}`);
        const client = clientResponse.data;

        clientName.value = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
        age.value = calculateAge(client.date_of_birth);
        dateAdmitted.value = client.admissions[0].date_admitted;

        form.value.client_id = client.id; // Ensure client_id is assigned here

        const planData = await fetchPlanData(clientId);
        if (planData) {
            form.value.id = planData.plan.id;
            form.value.as_of_date = planData.plan.as_of_date || '';
            form.value.objectives = planData.plan.objectives || '';
            form.value.activities = planData.plan.activities || '';
            form.value.responsible_person = planData.plan.responsible_person || '';
            form.value.time_frame = planData.plan.time_frame || '';
            form.value.expected_output = planData.plan.expected_output || '';
            form.value.progress = planData.plan.progress || '';
            form.value.progress_notes = planData.plan.progress_notes || '';
            form.value.prepared_by = planData.plan.prepared_by || '';
            form.value.noted_by = planData.plan.noted_by || '';
        } else {
            console.log('No existing plan found for this client, initializing new plan data.');
            form.value = {
                id: null,
                client_id: client.id, // Ensure client_id is included in new plan data
                as_of_date: '',
                objectives: '',
                activities: '',
                responsible_person: '',
                time_frame: '',
                expected_output: '',
                progress: '',
                progress_notes: '',
                prepared_by: '',
                noted_by: '',
            };
        }
    } catch (error) {
        console.error('Error fetching client data:', error);
        message.value = 'Error fetching data.';
        messageType.value = 'error';
    }
};

    const calculateAge = (dob) => {
      const birthDate = new Date(dob);
      const ageDiff = Date.now() - birthDate.getTime();
      const ageDate = new Date(ageDiff);
      return Math.abs(ageDate.getUTCFullYear() - 1970);
    };

    const toggleEdit = async () => {
    if (editMode.value) {
        try {
            let url, method;

            if (!form.value.client_id) {
                // Ensure client_id is set before attempting to save
                form.value.client_id = route.params.id;
            }

            if (form.value.id) {
                // Update existing plan
                url = `/api/psychological-intervention-plans/${form.value.client_id}`;
                method = 'put';
            } else {
                // Create new plan
                url = `/api/psychological-intervention-plans`;
                method = 'post';
            }

            const response = await axios[method](url, form.value);

            if (!form.value.id) {
                form.value.id = response.data.id;
            }

            message.value = 'Data saved successfully!';
            messageType.value = 'success';

            setTimeout(() => {
                message.value = '';
            }, 3000);
        } catch (error) {
            console.error('Error saving data:', error);
            if (error.response) {
                message.value = `Error saving data: ${error.response.data.message || 'An unexpected error occurred.'}`;
            } else if (error.request) {
                message.value = 'Error saving data: No response from server.';
            } else {
                message.value = `Error saving data: ${error.message}`;
            }
            messageType.value = 'error';
        }
    }
    editMode.value = !editMode.value;
};


    onMounted(() => {
      fetchData(route.params.id);
    });

    return {
      form,
      clientName,
      age,
      dateAdmitted,
      editMode,
      message,
      messageType,
      toggleEdit,
    };
  },
};
</script>


<style scoped>
button {
  transition: background-color 0.3s;
}
button:hover {
  background-color: #2563eb;
}
.twinkle-border {
  animation: twinkle 2s infinite;
}
@keyframes twinkle {
  0%, 100% { border-color: #a1b6cf; }
  50% { border-color: white; }
}
</style>
