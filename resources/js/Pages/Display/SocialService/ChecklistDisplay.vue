<template>
     <!-- Tabs for Actions -->
     <div class="flex absolute p-4 space-x-4 ">
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


      <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50">
      <div class="fixed inset-0 bg-black opacity-50"></div>
      <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
        <div class="bg-white p-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Save changes?</h3>
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



  <div class="a4-container p-6 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
    <div class="relative flex justify-between items-center mb-2">
      <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
      <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
    </div>
    
    <h1 class="text-lg font-bold mb-4 text-center text-black">Checklist of Requirements during Admission</h1>
    <div v-if="message" :class="`p-2 mt-2 text-white rounded-md text-xs ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
      {{ message }}
    </div>
    <table class="min-w-full bg-white border border-black mt-2 text-xs">
      <thead>
        <tr class="bg-green-400">
          <th class="py-1 px-2 border border-black">No.</th>
          <th class="py-1 px-2 border border-black">Documents</th>
          <th class="py-1 px-2 border border-black w-16">Yes</th>
          <th class="py-1 px-2 border border-black w-16">No</th>
          <th class="py-1 px-2 border border-black w-96">Remarks</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in checklist" :key="index" class="hover:bg-gray-100">
          <td class="py-1 px-2 border border-black">{{ index + 1 }}</td>
          <td class="py-1 px-2 border border-black">{{ item.document }}</td>
          <td class="py-1 px-2 border border-black">
            <input type="checkbox" v-model="item.yes" :disabled="!editMode" @change="handleCheckboxChange(item, 'yes')" />
          </td>
          <td class="py-1 px-2 border border-black">
            <input type="checkbox" v-model="item.no" :disabled="!editMode" @change="handleCheckboxChange(item, 'no')" />
          </td>
          <td class="py-1 px-2 border border-black">
            <textarea v-model="item.remarks" class="w-full border border-transparent p-1 text-xs" :readonly="!editMode"></textarea>
          </td>
        </tr>
      </tbody>
    </table>

    <h2 class="text-lg font-semibold mt-4 mb-2 text-center">RRCY Forms</h2>
    <table class="min-w-full bg-white border border-black text-xs">
      <thead>
        <tr class="bg-green-400">
          <th class="py-1 px-2 border border-black">No.</th>
          <th class="py-1 px-2 border border-black">Forms</th>
          <th class="py-1 px-2 border border-black w-16">Yes</th>
          <th class="py-1 px-2 border border-black w-16">No</th>
          <th class="py-1 px-2 border border-black w-96">Remarks</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in rrForms" :key="index" class="hover:bg-gray-100">
          <td class="py-1 px-2 border border-black">{{ index + 1 }}</td>
          <td class="py-1 px-2 border border-black">{{ item.form }}</td>
          <td class="py-1 px-2 border border-black">
            <input type="checkbox" v-model="item.yes" :disabled="!editMode" @change="handleCheckboxChange(item, 'yes')" />
          </td>
          <td class="py-1 px-2 border border-black">
            <input type="checkbox" v-model="item.no" :disabled="!editMode" @change="handleCheckboxChange(item, 'no')" />
          </td>
          <td class="py-1 px-2 border border-black">
            <textarea v-model="item.remarks" class="w-full border border-gray-300 p-1 text-xs" :readonly="!editMode"></textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="footer mt-4">
        <p class="text-sm mb-4">Reviewed by:</p>
        <p class="text-sm mb-4">_________________________<br>Admitting Officer</p>
        <p class="text-sm mb-4">Received by:</p>
        <p class="text-sm">_________________________<br>Case Manager</p>

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
    const isModalOpen = ref(false);

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
    const cancelEdit = () => {
      editMode.value = false;
    };

    const confirmSave = () => {
      saveData();
      closeModal();
      editMode.value = false;
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
      cancelEdit,
      isModalOpen,
      openModal,
      closeModal,
      confirmSave,
    };
  },
};
</script>

<style scoped>
.a4-container {
  max-width: 210mm;
  padding: 10mm;
  background: white;
  border: 1px solid #ccc;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  page-break-after: always;
}

button {
  transition: background-color 0.3s;
  font-size: 0.75rem;
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
.border-black {
  border-color: #000 !important;
}
.text-xs {
  font-size: 0.75rem; /* Smaller font size */
}


</style>
