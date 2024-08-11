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
 
   <button @click="addItem" class="flex items-center space-x-2 px-3 py-1 bg-customBlue text-white rounded-md text-xs" v-if="editMode">
     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" />
     </svg>
     <span>Add Row</span>
   </button>
 
   <button v-if="editMode" @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
     </svg>
     <span>Save</span>
   </button>
 </div>
 <div v-if="currentPage === 1">
   <div class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
     <div class="relative flex justify-between items-center mb-2">
       <img src="/images/headerlogo2.png" alt="Logo" class="h-24 w-48 relative z-10">
       <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
     </div>
     <div class="p-4">
       <h1 class="text-2xl font-bold mb-4 text-center">Helping/Intervention Plan</h1>
 
       <div v-if="message" :class="`p-2 mt-4 text-white rounded-md text-xs ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
         {{ message }}
       </div>
       <div class="mb-4 text-xs">
         <div class="grid grid-cols-2 gap-2">
           <div class="flex items-center">
             <label class="font-semibold w-1/5">Name:</label>
             <input type="text" v-model="plan.name" :class="{'twinkle-border': editMode}" class="w-3/4 border border-transparent p-1" readonly>
           </div>
           <div class="flex items-center">
             <label class="font-semibold w-1/5">Age:</label>
             <input type="text" v-model="plan.age" :class="{'twinkle-border': editMode}" class="w-3/4 border border-transparent p-1" readonly>
           </div>
           <div class="flex items-center">
             <label class="font-semibold w-1/5">Period:</label>
             <input type="text" v-model="plan.period" :class="{'twinkle-border': editMode}" class="w-3/4 border border-transparent p-1" :readonly="!editMode">
           </div>
           <div class="flex items-center relative">
             <label class="font-semibold w-1/5">Date Prepared:</label>
             <input type="date" v-model="plan.date_prepared" :class="{'twinkle-border': editMode}" class="w-3/4 border border-transparent p-1" :readonly="!editMode">
             <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" @click="openCalendar">
               <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H16M8 11H16M8 15H16M4 4H20V20H4V4Z"></path>
               </svg>
             </span>
           </div>
         </div>
       </div>
       <table class="min-w-full bg-white border border-black text-xs">
         <thead>
           <tr>
             <th class="py-1 px-2 border-b border-r border-black">Objectives</th>
             <th class="py-1 px-2 border-b border-r border-black">Activities</th>
             <th class="py-1 px-2 border-b border-r border-black">Time Frame</th>
             <th class="py-1 px-2 border-b border-r border-black">Responsible Person</th>
             <th class="py-1 px-2 border-b border-r border-black">Expected Outcome</th>
             <th class="py-1 px-2 border-b border-black">Remarks</th>
           </tr>
         </thead>
         <tbody>
           <tr v-for="(item, index) in plan.items" :key="index" class="hover:bg-gray-100">
             <td class="py-1 px-2 border-b border-r border-black"><input type="text" v-model="item.objectives" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode"></td>
             <td class="py-1 px-2 border-b border-r border-black"><input type="text" v-model="item.activities" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode"></td>
             <td class="py-1 px-2 border-b border-r border-black"><input type="text" v-model="item.time_frame" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode"></td>
             <td class="py-1 px-2 border-b border-r border-black"><input type="text" v-model="item.responsible_person" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode"></td>
             <td class="py-1 px-2 border-b border-r border-black"><input type="text" v-model="item.expected_outcome" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode"></td>
             <td class="py-1 px-2 border-b border-black"><input type="text" v-model="item.remarks" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode"></td>
           </tr>
           <!-- Add empty rows for additional entries -->
           <tr v-for="i in emptyRows" :key="'empty' + i" class="hover:bg-gray-100">
             <td class="py-1 px-2 border-b border-r border-black"><input type="text" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode"></td>
             <td class="py-1 px-2 border-b border-r border-black"><input type="text" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode"></td>
             <td class="py-1 px-2 border-b border-r border-black"><input type="text" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode"></td>
             <td class="py-1 px-2 border-b border-r border-black"><input type="text" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode"></td>
             <td class="py-1 px-2 border-b border-r border-black"><input type="text" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode"></td>
             <td class="py-1 px-2 border-b border-black"><input type="text" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode"></td>
           </tr>
         </tbody>
       </table>
     
       <div class="mt-4 grid grid-cols-3 gap-2 text-xs">
         <div>
           <label class="font-semibold">Prepared by:</label>
           <input type="text" v-model="plan.prepared_by" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode">
           <div class="text-xs mt-1">Social Welfare Officer I</div>
         </div>
         <div>
           <label class="font-semibold">Conformed by:</label>
           <input type="text" v-model="plan.conformed_by" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode">
           <div class="text-xs mt-1">Resident</div>
         </div>
         <div>
           <label class="font-semibold">Noted by:</label>
           <input type="text" v-model="plan.noted_by" :class="{'twinkle-border': editMode}" class="w-full border border-transparent p-1" :readonly="!editMode">
           <div class="text-xs mt-1">Center Head/ SWO IV</div>
         </div>
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
 import { ref, onMounted, reactive } from 'vue';
 import { useRoute } from 'vue-router';
 import Pagination from '@/Components/Pagination.vue';
 
 export default {
   components: {
     Pagination
   },
   setup() {
     const route = useRoute();
     const editMode = ref(false);
     const message = ref('');
     const messageType = ref('');
     const clientId = ref(null);
     const isModalOpen = ref(false);
     const totalPages = ref(1);
     const currentPage = ref(1);
     const isSaveResultModalOpen = ref(false);
     const saveResultTitle = ref('');
     const saveResultMessage = ref('');
     const emptyRows = ref(5); // Number of empty rows to display
 
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
         updateTotalPages();
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
 
     const updateTotalPages = () => {
       // Assuming each page can show up to 10 items
       const itemsPerPage = 10;
       totalPages.value = Math.ceil(plan.items.length / itemsPerPage);
     };
 
     const updatePage = (page) => {
       currentPage.value = page;
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
 
     const closeSaveResultModal = () => {
       isSaveResultModalOpen.value = false;
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
           saveResultTitle.value = 'Success';
           saveResultMessage.value = 'Data saved successfully.';
           if (!plan.id) plan.id = response.data.id;
           editMode.value = false;
         })
         .catch(error => {
           messageType.value = 'error';
           saveResultTitle.value = 'Error';
           saveResultMessage.value = error.response.data.message || 'An error occurred while saving data.';
           console.error('Error saving data:', error);
         })
         .finally(() => {
           isModalOpen.value = false;
           isSaveResultModalOpen.value = true;
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
       updateTotalPages(); // Update the total pages after adding a new item
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
       cancelEdit,
       addItem,
       openCalendar,
       isModalOpen,
       openModal,
       closeModal,
       confirmSave,
       isSaveResultModalOpen,
       saveResultTitle,
       saveResultMessage,
       closeSaveResultModal,
       Pagination,
       totalPages,
       currentPage,
       emptyRows,
       updatePage,
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
   color: white;
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
 