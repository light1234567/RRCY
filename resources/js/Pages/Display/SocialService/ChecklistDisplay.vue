<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Checklist of Requirements during Admission</h1>
    <button @click="toggleEdit" class="px-4 py-2 bg-blue-500 text-white rounded-md">{{ editMode ? 'Save' : 'Edit' }}</button>
    <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
      {{ message }}
    </div>
    <table class="min-w-full bg-white border border-gray-300 mt-4">
      <thead>
        <tr>
          <th class="py-2 px-4 border-b">No.</th>
          <th class="py-2 px-4 border-b">Documents</th>
          <th class="py-2 px-4 border-b w-16">Yes</th>
          <th class="py-2 px-4 border-b w-16">No</th>
          <th class="py-2 px-4 border-b w-96">Remarks</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in checklist" :key="index" class="hover:bg-gray-100">
          <td class="py-2 px-4 border-b">{{ index + 1 }}</td>
          <td class="py-2 px-4 border-b">{{ item.document }}</td>
          <td class="py-2 px-4 border-b">
            <input type="checkbox" v-model="item.yes" :disabled="!editMode" @change="handleCheckboxChange(item, 'yes')" />
          </td>
          <td class="py-2 px-4 border-b">
            <input type="checkbox" v-model="item.no" :disabled="!editMode" @change="handleCheckboxChange(item, 'no')" />
          </td>
          <td class="py-2 px-4 border-b">
            <textarea v-model="item.remarks" class="w-full border border-gray-300 p-1" :readonly="!editMode"></textarea>
          </td>
        </tr>
      </tbody>
    </table>

    <h2 class="text-xl font-semibold mt-6 mb-4">RRCY Forms</h2>
    <table class="min-w-full bg-white border border-gray-300">
      <thead>
        <tr>
          <th class="py-2 px-4 border-b">No.</th>
          <th class="py-2 px-4 border-b">Forms</th>
          <th class="py-2 px-4 border-b w-16">Yes</th>
          <th class="py-2 px-4 border-b w-16">No</th>
          <th class="py-2 px-4 border-b w-96">Remarks</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in rrForms" :key="index" class="hover:bg-gray-100">
          <td class="py-2 px-4 border-b">{{ index + 1 }}</td>
          <td class="py-2 px-4 border-b">{{ item.form }}</td>
          <td class="py-2 px-4 border-b">
            <input type="checkbox" v-model="item.yes" :disabled="!editMode" @change="handleCheckboxChange(item, 'yes')" />
          </td>
          <td class="py-2 px-4 border-b">
            <input type="checkbox" v-model="item.no" :disabled="!editMode" @change="handleCheckboxChange(item, 'no')" />
          </td>
          <td class="py-2 px-4 border-b">
            <textarea v-model="item.remarks" class="w-full border border-gray-300 p-1" :readonly="!editMode"></textarea>
          </td>
        </tr>
      </tbody>
    </table>
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
    const checklist = reactive([]);
    const rrForms = reactive([]);

    const initializeForm = () => {
      checklist.length = 0;
      rrForms.length = 0;

      checklist.push(
        { document: 'Commitment/Court Order', yes: false, no: false, remarks: '' },
        { document: 'Referral Letter', yes: false, no: false, remarks: '' },
        { document: 'Social Case Study Report', yes: false, no: false, remarks: '' },
        { document: 'Medical Certificate', yes: false, no: false, remarks: '' },
        { document: 'Negative RT-PCR COVID-19 Test Result', yes: false, no: false, remarks: '' },
        { document: 'Laboratory Examination Result', yes: false, no: false, remarks: '' },
        { document: 'Psychological Assessment and Evaluation', yes: false, no: false, remarks: '' },
        { document: 'Birth Certificate/Baptismal Cert', yes: false, no: false, remarks: '' },
        { document: 'School Documents (Form 137) if applicable', yes: false, no: false, remarks: '' },
        { document: 'List of Belongings', yes: false, no: false, remarks: '' },
      );

      rrForms.push(
        { form: 'Admission Slip', yes: false, no: false, remarks: '' },
        { form: 'General Intake Form', yes: false, no: false, remarks: '' },
        { form: 'Admission Contract', yes: false, no: false, remarks: '' },
        { form: 'Parent\'s Consent', yes: false, no: false, remarks: '' },
        { form: 'Inventory of Client\'s belongings', yes: false, no: false, remarks: '' },
        { form: 'Kasabutan "Good Performance"', yes: false, no: false, remarks: '' },
        { form: 'Kasabutan (Bulitas)', yes: false, no: false, remarks: '' },
        { form: 'Data Privacy Consent Form', yes: false, no: false, remarks: '' },
        { form: 'Talambuhay', yes: false, no: false, remarks: '' },
        { form: 'SFI', yes: false, no: false, remarks: '' },
        { form: 'Daily Journal', yes: false, no: false, remarks: '' },
      );
    };

    const fetchClientData = async (id) => {
      try {
        const response = await axios.get(`/api/checklist/${id}`);
        const clientData = response.data;

        initializeForm();

        clientData.checklist.forEach((item) => {
          const checklistItem = checklist.find(ch => ch.document === item.document);
          if (checklistItem) {
            checklistItem.yes = item.yes === 1;
            checklistItem.no = item.no === 1;
            checklistItem.remarks = item.remarks;
          } else {
            checklist.push({ document: item.document, yes: item.yes === 1, no: item.no === 1, remarks: item.remarks });
          }
        });

        clientData.rrForms.forEach((item) => {
          const rrFormItem = rrForms.find(rr => rr.form === item.form);
          if (rrFormItem) {
            rrFormItem.yes = item.yes === 1;
            rrFormItem.no = item.no === 1;
            rrFormItem.remarks = item.remarks;
          } else {
            rrForms.push({ form: item.form, yes: item.yes === 1, no: item.no === 1, remarks: item.remarks });
          }
        });
      } catch (error) {
        console.error('Error fetching client data:', error);
      }
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

      const checklistWithClientId = checklist.map(item => ({
        ...item,
        client_id: clientId.value,
      }));

      const rrFormsWithClientId = rrForms.map(item => ({
        ...item,
        client_id: clientId.value,
      }));

      const payload = {
        checklist: checklistWithClientId,
        rrForms: rrFormsWithClientId,
      };

      axios.post('/api/save-checklist', payload)
        .then(response => {
          message.value = 'Data saved successfully.';
          messageType.value = 'success';
        })
        .catch(error => {
          message.value = error.response.data.message || 'Error saving data.';
          messageType.value = 'error';
          console.error('Error saving data:', error);
        });
    };

    const handleCheckboxChange = (item, field) => {
      if (field === 'yes' && item.yes) {
        item.no = false;
      } else if (field === 'no' && item.no) {
        item.yes = false;
      }
    };

    return {
      editMode,
      message,
      messageType,
      checklist,
      rrForms,
      toggleEdit,
      handleCheckboxChange,
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
.bg-blue-500:checked {
  background-color: #2563eb;
}
.w-16 {
  width: 4rem; /* 64px */
}
.w-96 {
  width: 24rem; /* 384px */
}
textarea {
  min-height: 2.5rem; /* Minimum height for textarea */
  resize: vertical; /* Allows vertical resizing */
}
</style>
