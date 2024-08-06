<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Helping/Intervention Plan</h1>
    <button @click="toggleEdit" class="px-4 py-2 bg-blue-500 text-white rounded-md">{{ editMode ? 'Save' : 'Edit' }}</button>
    <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
      {{ message }}
    </div>
    <div class="mb-4">
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="font-semibold">Name:</label>
          <input type="text" v-model="plan.name" class="w-full border border-gray-300 p-2" readonly>
        </div>
        <div>
          <label class="font-semibold">Age:</label>
          <input type="text" v-model="plan.age" class="w-full border border-gray-300 p-2" readonly>
        </div>
        <div>
          <label class="font-semibold">Period:</label>
          <input type="text" v-model="plan.period" class="w-full border border-gray-300 p-2" :readonly="!editMode">
        </div>
        <div>
          <label class="font-semibold">Date Prepared:</label>
          <div class="relative">
            <input type="date" v-model="plan.date_prepared" class="w-full border border-gray-300 p-2" :readonly="!editMode">
            <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" @click="openCalendar">
              <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H16M8 11H16M8 15H16M4 4H20V20H4V4Z"></path>
              </svg>
            </span>
          </div>
        </div>
      </div>
    </div>
    <table class="min-w-full bg-white border border-gray-300">
      <thead>
        <tr>
          <th class="py-2 px-4 border-b">Objectives</th>
          <th class="py-2 px-4 border-b">Activities</th>
          <th class="py-2 px-4 border-b">Time Frame</th>
          <th class="py-2 px-4 border-b">Responsible Person</th>
          <th class="py-2 px-4 border-b">Expected Outcome</th>
          <th class="py-2 px-4 border-b">Remarks</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in plan.items" :key="index" class="hover:bg-gray-100">
          <td class="py-2 px-4 border-b"><input type="text" v-model="item.objectives" class="w-full border border-gray-300 p-1" :readonly="!editMode"></td>
          <td class="py-2 px-4 border-b"><input type="text" v-model="item.activities" class="w-full border border-gray-300 p-1" :readonly="!editMode"></td>
          <td class="py-2 px-4 border-b"><input type="text" v-model="item.time_frame" class="w-full border border-gray-300 p-1" :readonly="!editMode"></td>
          <td class="py-2 px-4 border-b"><input type="text" v-model="item.responsible_person" class="w-full border border-gray-300 p-1" :readonly="!editMode"></td>
          <td class="py-2 px-4 border-b"><input type="text" v-model="item.expected_outcome" class="w-full border border-gray-300 p-1" :readonly="!editMode"></td>
          <td class="py-2 px-4 border-b"><input type="text" v-model="item.remarks" class="w-full border border-gray-300 p-1" :readonly="!editMode"></td>
        </tr>
      </tbody>
    </table>
    <button @click="addItem" class="mt-4 px-4 py-2 bg-green-500 text-white rounded-md" v-if="editMode">Add Item</button>
    <div class="mt-6 grid grid-cols-3 gap-4">
      <div>
        <label class="font-semibold">Prepared by:</label>
        <input type="text" v-model="plan.prepared_by" class="w-full border border-gray-300 p-2" :readonly="!editMode">
        <div class="text-sm mt-1">Social Welfare Officer I</div>
      </div>
      <div>
        <label class="font-semibold">Conformed by:</label>
        <input type="text" v-model="plan.conformed_by" class="w-full border border-gray-300 p-2" :readonly="!editMode">
        <div class="text-sm mt-1">Resident</div>
      </div>
      <div>
        <label class="font-semibold">Noted by:</label>
        <input type="text" v-model="plan.noted_by" class="w-full border border-gray-300 p-2" :readonly="!editMode">
        <div class="text-sm mt-1">Center Head/ SWO IV</div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted, reactive } from 'vue';
import { useRoute } from 'vue-router';

export default {
  setup() {
    const route = useRoute();
    const editMode = ref(false);
    const message = ref('');
    const messageType = ref('');
    const clientId = ref(null);
    const plan = reactive({
      id: null,
      name: '',
      age: '',
      period: '',
      date_prepared: '',
      prepared_by: '',
      conformed_by: '',
      noted_by: '',
      items: [
        { objectives: '', activities: '', time_frame: '', responsible_person: '', expected_outcome: '', remarks: '' },
      ],
    });

    const fetchClientData = async (id) => {
      try {
        const response = await axios.get(`/api/clients/${id}`);
        const client = response.data;

        plan.name = `${client.first_name} ${client.last_name}`;
        plan.age = calculateAge(client.date_of_birth);

        const planResponse = await axios.get(`/api/intervention-plans/${id}`);
        const clientPlan = planResponse.data;

        plan.id = clientPlan.id;
        plan.period = clientPlan.period;
        plan.date_prepared = clientPlan.date_prepared;
        plan.prepared_by = clientPlan.prepared_by || '';
        plan.conformed_by = clientPlan.conformed_by || '';
        plan.noted_by = clientPlan.noted_by || '';
        plan.items = clientPlan.items.map(item => ({
          objectives: item.objectives,
          activities: item.activities,
          time_frame: item.time_frame,
          responsible_person: item.responsible_person,
          expected_outcome: item.expected_outcome,
          remarks: item.remarks,
        }));
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
        // Save data
        saveData();
      }
      editMode.value = !editMode.value;
    };

    const saveData = () => {
      if (!clientId.value) {
        message.value = 'No client selected.';
        messageType.value = 'error';
        return;
      }

      const payload = {
        client_id: clientId.value,
        period: plan.period,
        date_prepared: plan.date_prepared,
        prepared_by: plan.prepared_by,
        conformed_by: plan.conformed_by,
        noted_by: plan.noted_by,
        items: plan.items.map(item => ({
          objectives: item.objectives,
          activities: item.activities,
          time_frame: item.time_frame,
          responsible_person: item.responsible_person,
          expected_outcome: item.expected_outcome,
          remarks: item.remarks,
        })),
      };

      const method = plan.id ? 'put' : 'post';
      const url = `/api/intervention-plans${plan.id ? '/' + plan.id : ''}`;

      axios[method](url, payload)
        .then(response => {
          message.value = 'Data saved successfully.';
          messageType.value = 'success';
          if (!plan.id) plan.id = response.data.id;
        })
        .catch(error => {
          message.value = error.response.data.message || 'Error saving data.';
          messageType.value = 'error';
          console.error('Error saving data:', error);
        });
    };

    const addItem = () => {
      plan.items.push({
        objectives: '',
        activities: '',
        time_frame: '',
        responsible_person: '',
        expected_outcome: '',
        remarks: '',
      });
    };

    const openCalendar = () => {
      document.querySelector('input[type="date"]').showPicker();
    };

    return {
      editMode,
      message,
      messageType,
      plan,
      toggleEdit,
      addItem,
      openCalendar,
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
