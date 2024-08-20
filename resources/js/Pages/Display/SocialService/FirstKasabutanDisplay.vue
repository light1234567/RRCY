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
    <!-- Pagination Component -->
    <Pagination 
      :totalPages="totalPages" 
      :currentPage="currentPage" 
      @update:currentPage="currentPage = $event" 
    />
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
      
  <div>
    <div class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
      <div class="relative flex justify-between items-center mb-2">
        <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
        <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
      </div>
      <div class="text-center mb-8">
        <h1 class="text-[35px] font-bold">KASABUTAN</h1>
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

      <div class="mb-8 text-justify">
        <p class="mb-4">
          <span class="ml-8 inline-block">Ako</span> si <span class="font-bold underline">{{ clientName }}</span> usa ka residente diri sa DSWD-RRCY. Ako maningkamot na dili mo buhat us salaod na mulabag sa polisiya sa center. Ug ako mouyong na dili ko buhatan ug pasahan sa Final Report didto sa court kung dili <strong>“COLOR RED”</strong> and akong Performance equivalent to <strong>“OUTSTANDING”</strong>
        </p>
        <p><span class="ml-8 inline-block">Ug</span> kung ako makasala, andam ko na maextend akong pagpuyo diri sa center/RRCY hangtud na ako moabot sa 21 anyos.</p>
      </div>

      <div class="mb-8">
        <div class="space-y-12">
          <div>
            <input type="text" v-model="form.client_resident" 
              class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none mt-2 shadow-sm w-1/3 px-2 text-xs" 
              :readonly="!editMode"/>
            <label class="block text-base font-semibold text-gray-700 -mt-1">Client/Resident</label>
          </div>
          <div>
            <input type="text" v-model="form.parent_guardian" 
              class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm w-1/3 px-2 mt-12 text-xs" 
              :readonly="!editMode"/>
            <label class="block text-base font-semibold text-gray-700 -mt-1">Pangalan/Pirma sa Ginikanan/Guardian</label>
          </div>
          <div>
            <input type="text" v-model="form.case_manager" 
              class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm w-1/3 px-2 mt-12 py-1 text-xs" 
              :readonly="!editMode"/>
            <label class="block text-base font-semibold text-gray-700 -mt-1">Case Manager</label>
          </div>
        </div>
      </div>


      <div class="text-left  mt-16">
        <p><u><strong>ANGELIC B. PAÑA, RSW, MSSW</strong></u></p>
        <p>Center Head/SWO IV</p>
      </div>

      <div class="border-gray-300 ml-6 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
         <div class="flex justify-between items-center">
           <div class="flex flex-col">
             <p class="ml-24 -mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
             <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
             <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
           </div>
           <div class="ml-4">
             <img src="/images/footerimg.png" alt="" class="h-12 w-24 object-cover rounded-md">
           </div>
         </div>
       </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import Pagination from '@/Components/Pagination.vue';

export default {
  components: {
    Pagination,
  },
  setup() {
    const route = useRoute();
    const editMode = ref(false);
    const message = ref('');
    const messageType = ref('');
    const form = ref({
      client_id: null,
      client_resident: '',
      parent_guardian: '',
      case_manager: '',
      id: null
    });
    const clientName = ref('');
    const errorMessage = ref('');
    const isModalOpen = ref(false);
    const isSaveResultModalOpen = ref(false);
    const saveResultTitle = ref('');
    const saveResultMessage = ref('');
    const totalPages = ref(1);
    const currentPage = ref(1);

    const fetchClientData = async (clientId) => {
      try {
        const clientResponse = await axios.get(`/api/clients/${clientId}`);
        const client = clientResponse.data;
        clientName.value = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
        form.value.client_id = client.id;

        const kasabutanResponse = await axios.get(`/api/kasabutan/${clientId}`);
        const kasabutan = kasabutanResponse.data;
        form.value.client_resident = kasabutan.client_resident || '';
        form.value.parent_guardian = kasabutan.parent_guardian || '';
        form.value.case_manager = kasabutan.case_manager || '';
        form.value.id = kasabutan.id;
      } catch (error) {
        errorMessage.value = 'Error fetching client data.';
        console.error('Error fetching client data:', error);
      }
    };

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

    const confirmSave = async () => {
      try {
        await saveData();
        saveResultTitle.value = 'Success';
        saveResultMessage.value = 'Data saved successfully!';
      } catch (error) {
        saveResultTitle.value = 'Error';
        saveResultMessage.value = 'Failed to save data.';
      } finally {
        closeModal();
        editMode.value = false;
        isSaveResultModalOpen.value = true;
      }
    };

    const cancelEdit = () => {
      editMode.value = false;
    };

    const saveData = async () => {
      if (!form.value.client_id) {
        throw new Error('Client ID is missing.');
      }

      try {
        const response = await axios[form.value.id ? 'put' : 'post'](`/api/kasabutan${form.value.id ? '/' + form.value.id : ''}`, form.value);
        if (!form.value.id) {
          form.value.id = response.data.id;
        }
      } catch (error) {
        throw new Error('Error saving data.');
      }
    };

    const closeSaveResultModal = () => {
      isSaveResultModalOpen.value = false;
      saveResultTitle.value = '';
      saveResultMessage.value = '';
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
      isModalOpen,
      openModal,
      closeModal,
      confirmSave,
      cancelEdit,
      isSaveResultModalOpen,
      saveResultTitle,
      saveResultMessage,
      closeSaveResultModal,
      totalPages,
      currentPage,
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
