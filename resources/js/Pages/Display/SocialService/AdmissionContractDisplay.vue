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
     <Pagination
       :totalPages="totalPages" 
       :currentPage="currentPage" 
       @update:currentPage="updatePage" 
     />  
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
    

 <div v-if="currentPage === 1" class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
    <div class="">
      <!-- Page 1 -->
   
        <div class="relative flex justify-between items-center mb-2">
          <img src="/images/headerlogo2.png" alt="Logo" class="h-24 w-48 relative z-10">
          <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
        </div>

        <div class="text-center mb-8">
        <h1 class="text-[35px] font-bold">ADMISSION CONTRACT</h1>
      </div>

        <div class="mb-8 text-justify">
          <p>
            In order to enable a CICL undergo rehabilitation through an intensive management of his behaviour and anti-social attitudes in a residential setting and prepare him for successful adjustment to his family and community after release. This contract is set for CICL, Parents/ Custodian, LGU to abide the following provisions:
          </p>
        </div>

        <div class="mb-8">
          <h2 class="text-lg font-semibold">For the CICL:</h2>
          <ol class="list-decimal ml-6 space-y-2 text-justify">
            <li>To be physically fit, improve grooming and hygiene. Develop positive values, work habits and acquiring responsibility in a group living task.</li>
            <li>To develop emotional control, stability and maturity. Enable to acquire and equipped coping skills, life skills, solution-focus to address daily encountered problems, gain self-efficacy and self-actualization.</li>
            <li>To learn and develop new adaptive behaviours.</li>
            <li>To learn and live by with the daily structured activities of the center. Follow center policies and procedures at all times, as such offenses committed have corresponding corrective measure.</li>
            <li>To develop and regain self-concept, confidence and able to settle down, mix with others without occurrence of social and interpersonal conflicts.</li>
            <li>To enhance spiritual growth and rediscover the value, meaning and mission of one's life existence.</li>
            <li>To empower oneself knowledge through education and opportunity in taking acceleration exam.</li>
            <li>To equip oneself with skills, active participation in the management on income generating projects.</li>
          </ol>
        </div>

        <div class="mb-8">
          <h2 class="text-lg font-semibold">For the Parents/ Custodian:</h2>
          <ol class="list-decimal ml-6 space-y-2 text-justify">
            <li>To follow the rehabilitation Program/ intervention measures while their son is at the center.</li>
            <li>To observe schedule of visits to their son.</li>
            <li>To create and submit to Case Manager effective re integration plans for their son prior to termination phase of case management.</li>
            <li>To do follow up, constant monitoring of their son's performance while at the center.</li>
            <li>To attend obligatory activities at the center and schedule court hearings of their son.</li>
          </ol>
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



    <div v-if="currentPage === 2" class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
      <!-- Page 2 -->
      
         
   
       
          <h2 class="text-lg font-semibold">For the LSWDO:</h2>
          <ol class="list-decimal ml-6 space-y-2 text-justify">
            <li>To submit Social Case Study Report (SCSR) upon referral of CICL for Rehabilitation.</li>
            <li>To attend Case Conference and other obligatory responsibilities being Partners as service providers.</li>
            <li>To prepare ahead the Parenting Capability Assessment Report (PCAR).</li>
            <li>To assist for immediate release of LGU Claims.</li>
            <li>To prepare ahead an After-Care Plan.</li>
            <li>To give feedback to the DSWD F O XI-RRCY on the performances of CICL in his after Care Service.</li>
          </ol>
       

        <div class="mb-8">
          <p>Signed 
            <input type="text" v-model="form.signed_day" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-20 inline-block" :readonly="!editMode" maxlength="2" /> 
            day of 
            <input type="text" v-model="form.signed_month" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-20 inline-block" :readonly="!editMode" />, 
            2024. RRCY Davao City.
          </p>
        </div>

        <div class="text-right  mt-12 mb-12 ">
          <p><strong><u>ANGELIC B. PAÑA, RSW, MSSW</u></strong></p>
          <p>Center Head/SWO IV</p>
        </div>

        
      <div class="mt-8">
        <div class="grid grid-cols-2 gap-8">
          <!-- Conforme Section -->
          <div>
            <h2 class="text-lg font-semibold">Conforme:</h2>
            <div class="space-y-8 mt-4">
              <div>
                <input type="text" v-model="clientName" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" readonly />
                <label class="block text-gray-700 mt-1">Signature above-completed Name of CICL</label>
              </div>
              <div>
                <input type="text" v-model="form.parent_custodian_name" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
                <label class="block text-gray-700 mt-1">Signature above-completed Name of Parent/ Custodian</label>
              </div>
              <div>
                <input type="text" v-model="form.lgu_worker_name" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
                <label class="block text-gray-700 mt-1">Signature above-completed Name of LGU Worker</label>
              </div>
            </div>
          </div>
       

          <!-- Witnesses Section -->
          <div>
            <h2 class="text-lg font-semibold">Witnesses:</h2>
            <div class="space-y-8 mt-4">
              <div>
                <input type="text" v-model="form.rrcy_officer" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
                <label class="block text-gray-700 mt-1">RRCY Administering Officer</label>
              </div>
              <div>
                <input type="text" v-model="form.houseparent_on_duty" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
                <label class="block text-gray-700 mt-1">Houseparent-On Duty</label>
              </div>
            </div>
          </div>
          
        
         
  </div>
</div> 
<div class="border-gray-300 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        <div class="flex flex-col">
          <p class="ml-24 -mb-4 font-bold">PAGE 2 of {{ totalPages }}</p>
          <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
          <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
        </div>
        <div class="ml-4">
          <img src="/images/footerimg.png" alt="" class="h-12 w-24 object-cover rounded-md">
        </div>
      </div>
    </div>
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
      signed_day: '',
      signed_month: '',
      parent_custodian_name: '',
      lgu_worker_name: '',
      rrcy_officer: '',
      houseparent_on_duty: '',
      id: null, // Add id to track existing record
    });
    const clientName = ref('');
    const errorMessage = ref('');
    const currentPage = ref(1);
    const totalPages = ref(2);
    const isModalOpen = ref(false);
    const isSaveResultModalOpen = ref(false);
    const saveResultTitle = ref('');
    const saveResultMessage = ref('');

    const fetchClientData = async (clientId) => {
      try {
        const clientResponse = await axios.get(`/api/clients/${clientId}`);
        const client = clientResponse.data;
        clientName.value = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
        form.value.client_id = client.id;

        const admissionContractResponse = await axios.get(`/api/admission-contracts/${clientId}`);
        const admissionContract = admissionContractResponse.data;
        form.value.signed_day = admissionContract.signed_day || '';
        form.value.signed_month = admissionContract.signed_month || '';
        form.value.parent_custodian_name = admissionContract.parent_custodian_name || '';
        form.value.lgu_worker_name = admissionContract.lgu_worker_name || '';
        form.value.rrcy_officer = admissionContract.rrcy_officer || '';
        form.value.houseparent_on_duty = admissionContract.houseparent_on_duty || '';
        form.value.id = admissionContract.id;
      } catch (error) {
        errorMessage.value = 'Error fetching client data: ' + (error.response?.data?.message || error.message);
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

    const confirmSave = () => {
      saveData();
      closeModal();
      editMode.value = false;
    };

    const closeSaveResultModal = () => {
      isSaveResultModalOpen.value = false;
    };

    const saveData = async () => {
      if (!form.value.client_id) {
        message.value = 'Client ID is missing.';
        messageType.value = 'error';
        return;
      }

      try {
        const response = await axios[form.value.id ? 'put' : 'post'](`/api/admission-contracts${form.value.id ? '/' + form.value.id : ''}`, form.value);
        saveResultTitle.value = 'Success';
        saveResultMessage.value = 'Data saved successfully!';
        errorMessage.value = '';

        if (!form.value.id) {
          form.value.id = response.data.id;
        }

        setTimeout(() => {
          message.value = '';
        }, 3000);
      } catch (error) {
        saveResultTitle.value = 'Error';
        saveResultMessage.value = 'Error saving data: ' + (error.response?.data?.message || error.message);
        console.error('Error saving data:', error);
      } finally {
        isSaveResultModalOpen.value = true;
      }
    };

    const updatePage = (page) => {
      currentPage.value = page;
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
      currentPage,
      totalPages,
      isModalOpen,
      isSaveResultModalOpen,
      saveResultTitle,
      saveResultMessage,
      toggleEdit,
      openModal,
      closeModal,
      confirmSave,
      closeSaveResultModal,
      updatePage,
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
</style>
