<template>
<!-- Tabs for Actions (Back button visible only in edit mode) -->
<div v-if="editMode" class="flex absolute p-4 space-x-4">
  <button @click="cancelEdit" class="flex space-x-2 px-3 py-3 bg-blue-900 text-white rounded-md text-xs">
    <!-- FontAwesome for Back -->
    <i class="fas fa-arrow-left w-4 h-4"></i>
    <span>Back</span>
  </button>
</div>

<!-- Main Action Buttons -->
<div class="flex -ml-12 justify-end bg-transparent border -mr-[52px] border-gray-300 p-4 space-x-4 -mt-[52px]">

  <!-- Pagination Component -->
  <Pagination 
    :totalPages="totalPages" 
    :currentPage="currentPage" 
    @update:currentPage="currentPage = $event" 
  />

  <!-- Edit Button (visible only when not in edit mode) -->
  <button v-if="!editMode" @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
    <!-- FontAwesome for Edit -->
    <i class="fas fa-edit w-4 h-4"></i>
    <span>Edit</span>
  </button>

  <!-- Save Button (visible only in edit mode) -->
  <button v-if="editMode" @click="openModal" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
        <!-- FontAwesome for Save -->
        <i class="fas fa-check w-4 h-4"></i>
        <span>Save</span>
      </button>
  <!-- Export PDF Button -->
  <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 text-white rounded-md text-xs">
    <!-- FontAwesome for PDF Download -->
    <i class="fas fa-file-pdf w-4 h-4"></i>
    <span>Export PDF</span>
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
<div class="graph-background pt-9 -ml-4 -mr-12 -mb-16">      <!-- Success/Error Message -->

 
    <div class="p-8 -mb-96 bg-white  max-w-screen-md mx-auto border border-gray-400 rounded-lg shadow-lg">
      <!-- Header Section -->
      <div class="border border-black"> 
      <div class="text-center border-none pb-2 mb-4">
        <div class="flex justify-between items-center">
    <!-- Stretch the image -->
    <img src="/images/headerlogo2.png" alt="DSWD Logo" class="h-32 w-64"> 
    <div class="text-center">
      <p class="item-center mr-6 text-sm font-semibold">REGIONAL REHABILITATION CENTER FOR YOUTH</p>
      <p class="text-sm text-center font-semibold">RRCY/FIELD OFFICE XI</p>
      <p class="text-[11px] font-semibold italic">DSWD-GF-010 | REV 01 | 17 AUG 2022</p>
    </div>
        </div>
        <div class="border-t border-black">
        <h1 class="text-xl font-bold mt-4">NURSING CARE SERVICE</h1>
      </div>
      </div>
      <div class="grid grid-cols-4 gap-2 mb-2">
  <!-- Row 1: Name and Birthdate -->
  <div class="flex custom-border-t w-auto col-span-2">
    <label class="border-none flex items-center ml-1 -mt-2 block font-bold text-xs">CLIENT'S NAME:</label>
    <input type="text" v-model="form.client_name" class="w-56 border-none -mt-2 bg-transparent p-1 text-xs" readonly>
  </div>
  <div class="flex custom-border-l custom-border-t2 ml-28 border-black col-span-2">
    <label class="border-none flex items-center block ml-1 font-bold -mt-2 text-xs">BIRTHDATE:</label>
    <input type="date" v-model="form.birthdate" class="w-full border-none -mt-2 bg-transparent p-1 text-xs" readonly>
  </div>

  <!-- Row 2: Age and Medical Status -->
  <div class="flex  border-black custom-border-t col-span-2">
    <label class="border-none flex items-center block font-bold text-xs -mt-2  ml-1 whitespace-nowrap">CURRENT MEDICAL STATUS:</label>
    <input type="text" v-model="form.current_medical_status" class="w-full border-none bg-transparent -mt-2 p-1 text-xs" :readonly="!editMode" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" maxlength="50">
  </div>
  <div class="flex custom-border-l  custom-border-t2 ml-28 border-black col-span-2">
    <label class="border-none flex items-center  block  -mt-2 ml-1 font-bold text-xs">AGE:</label>
    <input type="number" v-model="form.age" class="w-20  border-none p-1 -mt-2 bg-transparent text-xs" readonly>
  </div>

  <!-- Row 3: Religion and Date Admitted -->
  <div class="flex custom-border-t col-span-2">
    <label class="border-none flex items-center ml-1 block font-bold -mt-2  text-xs">RELIGION:</label>
    <input type="text" v-model="form.religion" class="w-full border-none -mt-2 bg-transparent  p-1 text-xs" readonly>
  </div>
  <div class="flex custom-border-l custom-border-t2 ml-28 border-black col-span-2">
  <label class="border-none flex items-center block font-bold text-xs  ml-1 -mt-2 whitespace-nowrap">DATE ADMITTED:</label>
  <input type="date" v-model="form.date_of_admission" class="w-full border-none  -mt-2 bg-transparent p-1 text-xs" readonly>
</div>


  <!-- Row 4: Address -->
  <div class="flex border-black border-b custom-border-t3 col-span-4">
    <label class="border-none flex items-center block ml-1 font-bold -mt-2  text-xs">ADDRESS:</label>
    <input type="text" v-model="form.address" class="w-full border-none bg-transparent -mt-2  p-1 text-xs" readonly>
  </div>
</div>

  
      <!-- BMI Monitoring Table -->
      <div class="text-center  pb-2 mb-4">
        <h2 class="text-lg mt-6 font-bold">MONTHLY BMI MONITORING 2024</h2>
      </div>
  
      <table class="w-full border-black mb-4">
        <thead>
          <tr class="bg-white border-black text-base">
            <th class="border-t border-r border-b border-black p-2">VITAL SIGNS / BMI</th>
            <th class="border-t border-black border-b p-2">
              <select v-model="form.selectedMonth" class="border p-2" :disabled="!editMode">
                <option value="">Select a month</option>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
              </select>
            </th>
          </tr>
        </thead>
        <tbody class="border-black">
          <tr>
            <td class="border-black border-r border-b text-sm p-2" style="width: 320px; ">TEMPERATURE</td>
            <td class="border-black border-b text-sm p-2"><input type="number" v-model="form.temperature" class="w-full ml-40 bg-transparent border-none p-1" style="width: 200px; " :readonly="!editMode"></td>
          </tr>
          <tr>
            <td class="border-black border-r border-b text-sm p-2" style="width: 320px; ">PULSE RATE</td>
            <td class="border-black border-b text-sm p-2"><input type="number" v-model="form.pulse_rate" class="w-full ml-40 bg-transparent border-none p-1" style="width: 200px; "  :readonly="!editMode"></td>
          </tr>
          <tr>
            <td class="border-black border-r border-b text-sm p-2" style="width: 320px; ">RESPIRATORY RATE</td>
            <td class="border-black border-b text-sm p-2"><input type="number" v-model="form.respiratory_rate" class="w-full ml-40 bg-transparent border-none p-1" style="width: 200px; "  :readonly="!editMode"></td>
          </tr>
          <tr>
            <td class="border-black border-r border-b text-sm p-2" style="width: 320px; ">BLOOD PRESSURE</td>
            <td class="border-black border-b text-sm p-2">
  <input 
    type="text" 
    v-model="form.blood_pressure" 
    class="w-full ml-40 bg-transparent  border-none p-1"  style="width: 200px; " 
    :readonly="!editMode" 
    oninput="this.value = this.value.replace(/[^0-9\/]/g, '')" 
    maxlength="20"
  >
</td>

          </tr>
          <tr>
            <td class="border-black border-r border-b text-sm p-2" style="width: 320px; ">HEIGHT (cm)</td>
            <td class="border-black border-b text-sm p-2"><input type="number" v-model="form.height_cm" @input="computeBMI" class="w-full  ml-40 bg-transparent border-none p-1" style="width: 200px; "  :readonly="!editMode"></td>
          </tr>
          <tr>
            <td class="border-black border-r border-b text-sm p-2" style="width: 320px; ">WEIGHT (kg)</td>
            <td class="border-black border-b text-sm p-2"><input type="number" v-model="form.weight_kg" @input="computeBMI" class="w-full ml-40 bg-transparent border-none p-1" style="width: 200px; "  :readonly="!editMode"></td>
          </tr>
          <tr>
            <td class="border-black border-r border-b text-sm p-2" style="width: 320px; ">BODY MASS INDEX (BMI)</td>
            <td class="border-black border-b text-sm p-2"><input type="number" v-model="form.bmi" class="w-full ml-40 bg-transparent border-none p-1" style="width: 200px; "  :readonly="!editMode"></td>
          </tr>
          <tr>
            <td class="border-black border-r border-b text-sm p-2" style="width: 320px; ">BMI REMARKS</td>
            <td class="border-black border-b text-sm p-2"><input type="text" v-model="form.bmi_remarks" class="w-full bg-transparent border-none p-1" :readonly="!editMode" maxlength="100"></td>
          </tr>
        </tbody>
      </table>
  
      <!-- General Appearance -->
      <div class="text-center pb-2 mb-4">
        <h2 class="text-lg font-bold">GENERAL APPEARANCE</h2>
      </div>
  
      <div class="flex mb-4">
  
  
   <!-- Table with health status information -->
  <div class="grid grid-cols-2 gap-4 w-full border-t border-b border-black">
    <!-- Column 1: Eyes, Ears, Mouth & Teeth -->
    <div class="border-black border-r w-58 p-2">
      <!-- Eyes Section -->
      <div class="flex items-center mb-2">
        <label class="font-bold text-xs mr-2">EYES:</label>
        <input 
  type="text" 
  v-model="form.eyes_status" 
  class="w-full border-none p-1 text-xs" 
  :readonly="!editMode" 
  oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" 
  maxlength="50"
/>

      </div>
  
      <!-- Ears Section -->
      <div class="flex items-center mb-2">
        <label class="font-bold text-xs mr-2">EARS:</label>
        <input 
  type="text" 
  v-model="form.ears_status" 
  class="w-full border-none p-1 text-xs" 
  :readonly="!editMode" 
  oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" 
  maxlength="50"
/>

      </div>
  
      <!-- Mouth & Teeth Section -->
      <div class="flex items-center w-full mb-2">
        <label class="flex w-44 font-bold text-xs mr-2">MOUTH & TEETH:     </label>
        <input 
  type="text" 
  v-model="form.mouth_teeth_status" 
  class="-ml-4 w-full border-none p-1 text-xs" 
  :readonly="!editMode" 
  oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" 
  maxlength="50"
/>

      </div>
    </div>
  
    <!-- Column 2: Nails, Skin, Hair -->
    <div class="border-none p-2">
      <!-- Nails Section -->
      <div class="flex items-center mb-2">
        <label class="font-bold text-xs -ml-4 mr-2">NAILS:</label>
        <input 
  type="text" 
  v-model="form.nails_status" 
  class="w-full border-none p-1 text-xs" 
  :readonly="!editMode" 
  oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" 
  maxlength="50"
/>

      </div>
  
      <!-- Skin Section -->
      <div class="flex items-center mb-2">
        <label class="font-bold text-xs -ml-4 mr-2">SKIN:</label>
        <input 
  type="text" 
  v-model="form.skin_status" 
  class="w-full border-none p-1 text-xs" 
  :readonly="!editMode" 
  oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" 
  maxlength="50"
/>

      </div>
  
      <!-- Hair Section -->
      <div class="flex items-center mb-2">
        <label class="font-bold text-xs -ml-4 mr-2">HAIR:</label>
        <input 
  type="text" 
  v-model="form.hair_status" 
  class="w-full border-none p-1 text-xs" 
  :readonly="!editMode" 
  oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" 
  maxlength="50"
/>

      </div>
    </div>
  </div>
  
  </div>
  
  
  
      <div class="border-none">
      <div class="grid grid-cols-3 gap-4 mb-4">
    <!-- Left Column: Services Given and Remarks -->
    <div class="col-span-2">
      <!-- Services Given Section -->
      <div class="mb-4 bg-transparent w-96 ">
        <label class=" font-bold ml-2 text-sm">SERVICES GIVEN:</label>
        <textarea v-model="form.services_given" rows="5" class="w-full ml-2 p-1 border-none text-sm mb-2" :readonly="!editMode"></textarea>
      </div>

  
      <div class="mb-4 bg-transparent w-96 ">
        <label class=" font-bold ml-2 text-sm">REMARKS:</label>
        <textarea v-model="form.remarks" rows="5" class="w-full p-1 ml-2 border-none text-sm mb-2" :readonly="!editMode"></textarea>
      </div>



   




    </div>
  
    <div class="-ml-14 mt-14 col-span-1 flex-absolute justify-center items-center">
  <!-- Upload and Camera Buttons (Visible only in edit mode) -->
<!-- Upload and Camera Buttons (Visible only in edit mode) -->
<div v-if="editMode" class="flex flex-col space-y-4">
  <!-- File Input for Uploading Profile Image -->
  <input 
    type="file" 
    ref="fileInput" 
    accept="image/*" 
    @change="onFileChange" 
    class="hidden" 
  />
  <button @click="triggerFileInput" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 w-full">
    Upload Image
  </button>

  <!-- Button to Open Camera -->
  <button @click="openCamera" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 w-full">
    Open Camera
  </button>

  <!-- Modal Structure -->
  <div v-if="showCamera" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-4 w-11/12 sm:w-96">
      <video ref="video" autoplay class="w-full h-64 object-cover rounded-md"></video>
      <button @click="capturePhoto" class="mt-4 w-full px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
        Capture
      </button>
      <button @click="closeCamera" class="mt-2 w-full px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
        Close
      </button>
    </div>
  </div>
</div>


  <!-- Preview Profile Image -->
  <div class="w-60 h-60 border flex justify-center items-center cursor-pointer" @click="triggerFileInput">
    <img 
      v-if="form.profile_image || previewImage" 
      :src="previewImage || `/profile_images/${form.profile_image}`" 
      alt="Profile Image" 
      class="h-full w-full object-cover" 
    />
    
    <img 
    v-else 
    src="/images/default-profile.jpg" 
    alt="Default Profile Image" 
    class="h-full w-full object-cover"
  />
  </div>
</div>  



  </div>
  
  </div>
  
  
  <!-- Signatures Section -->
  <div class="flex gap-4 mb-6 border-black border-t p-4">
    <!-- Prepared by Signature -->
    <div class="w-1/2 pr-4">
    <label class="block text-sm font-bold">PREPARED BY:</label>
    
    <!-- Always show the first prepared by field -->
    <div class="font-semibold flex items-center">
      <input
        type="text"
        v-model="form.f_prepared_by"
        class="w-full text-sm -ml-3 mt-1 border-none shadow-none"
        :readonly="!editMode"
        maxlength="50"
      >
    </div>

    <!-- Conditionally render s_prepared_by if the user clicks 'Add More' or if there is existing data -->
    <div v-if="showSPreparedBy || form.s_prepared_by">
      <div class="font-semibold text-sm flex items-center">
        <input
          type="text"
          v-model="form.s_prepared_by"
          class="w-full text-sm -ml-3 mt-1 border-none shadow-none"
          :readonly="!editMode"
          maxlength="50"
        >
      </div>
    </div>

    <!-- Conditionally render t_prepared_by if the user clicks 'Add More' or if there is existing data -->
    <div v-if="showTPreparedBy || form.t_prepared_by">
      <div class="font-semibold text-sm flex items-center">
        <input
          type="text"
          v-model="form.t_prepared_by"
          class="w-full text-sm -ml-3 mt-1 border-none shadow-none"
          :readonly="!editMode"
          maxlength="50"
        >
      </div>
    </div>

    <!-- Button to show additional prepared_by fields -->
    <button v-if="editMode && (!form.s_prepared_by || !form.t_prepared_by)" @click="addPreparedByField" class="mt-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs flex items-center">
      <i class="fas fa-plus mr-1"></i> Add Nurse Resident
    </button>

    <p class="text-sm mt-2">RESIDENT NURSES RRCY</p>
  </div>
  
    <!-- Noted by Signature -->
    <div class="w-1/2 pl-4">
      <label class="block text-sm font-bold">NOTED BY:</label>
      <div class="flex items-center mt-14">
        <input
          type="text"
          v-model="center_head"
          class="text-sm font-semibold w-44 mt-1 underline-input shadow-none"
          :readonly="!editMode"
        >
      </div>
      <p class="text-sm mt-2">SWO IV/Center Head</p>
    </div>
  </div>
  
  
    </div>
    <div class=" border-gray-300 pt-4 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;"> 
      <div class="flex justify-between items-start w-full">
          <div class="flex flex-col w-full"> <!-- Expanded width for the text section -->
              <p class="font-bold">PAGE 1 of 1</p>
              <p class="border-t-2 border-black"></p>
              <p class="pt-2">DSWD Field Office XI , Ramon Magsaysay Avenue corner Damaso Suazo Street, Davao City, Philippines 8000</p>
              <p > Website: <span class="text-blue-600 underline">http://www.dswd.gov.ph </span>Tel Nos.: (082) 227-1964 Email: <span class="text-blue-600 underline">fo11@dswd.gov.ph </span> </p>
          </div>
          <div class="w-1/6 flex justify-end"> <!-- Restricting the image section to the right side -->
              <img src="/images/footerimg.png" alt="Footer Image" class="h-12 w-32 object-cover"> <!-- Expanded width for image -->
          </div>
      </div>
        </div>
        </div>
  </div>
  </template>
  <script>
  import axios from 'axios';
  import { jsPDF } from 'jspdf';
import '../../../fonts/arial-normal.js'; 
import '../../../fonts/times-normal.js'; 
import '../../../fonts/arialbd-bold.js'; 
import Pagination from '@/Components/Pagination.vue';


  export default {
    components: {
      Pagination,
    },
    data() {
      return {
        totalPages: 1,
        currentPage: 1,
        center_head: '',
        showCamera: false,
        isModalOpen: false,
        
        isSaveResultModalOpen: false,
        saveResultTitle: '',
        saveResultMessage: '',
    videoStream: null,
    previewImage: null,
    form: {
      profile_image: null, // Holds the captured or uploaded image
          client_name: '',
          birthdate: '',
          age: '',
          current_medical_status: '',
          religion: '',
          address: '',
          date_of_admission: '',
          selectedMonth: '',
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
          f_prepared_by: '',
          s_prepared_by: '',
          t_prepared_by: '',
          noted_by: '',
          client_id: null, // Ensure client_id is explicitly defined
          id: null, // This will hold the id of NursingCareService if exists
        },
        editMode: false,
        showSPreparedBy: false,
        showTPreparedBy: false,
        message: '',
        messageType: '',
      };
    },
    mounted() {
      const clientId = this.$route.params.id;
      console.log('client ID:', clientId); // Log client ID on component mount
      this.fetchData(clientId);
      this.fetchCenterHead(clientId);
    },
    watch: {
      '$route.params.id': function (newClientId) {
        console.log('Watched client ID change:', newClientId); // Log client ID on route change
        this.fetchData(newClientId);
        this.fetchCenterHead(newClientId);
      }
    },
    methods: {


      fetchData(clientId) {
        if (!clientId) {
          console.error('Client ID is missing.');
          return;
        }
  
        axios.get(`/api/nursing-care-services/${clientId}`)
          .then(response => {
            const { data } = response;
            if (!data || !data.client) {
              console.warn('No client data found in the response.');
              return;
            }
  
            const { client, assessment } = data;
            this.form.client_id = client.id;  // Ensure client_id is set
            this.form.client_name = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
            this.form.birthdate = client.date_of_birth;
            this.form.age = this.calculateAge(client.date_of_birth);
            this.form.religion = client.religion;
            this.form.address = `${client.street}, ${client.barangay}, ${client.city}, ${client.province}`;
  
            if (client.admissions && client.admissions.length > 0) {
              this.form.date_of_admission = client.admissions[0].date_admitted;
            } else {
              this.form.date_of_admission = '';
            }
  
            if (assessment) {
              Object.assign(this.form, assessment);
              this.form.id = assessment.id;
            }
          })
          .catch(error => {
            console.error('Error fetching data:', error.response ? error.response.data : error.message);
            this.message = 'Error fetching data: ' + (error.response?.data || error.message);
            this.messageType = 'error';
            this.clearMessageAfterDelay();
          });
      },
      fetchCenterHead() {
      axios.get('/api/center-head')  // Replace with the correct API route
        .then(response => {
          this.center_head = response.data.name;  // Bind the fetched name to v-model
        })
        .catch(error => {
          console.error('Error fetching center head:', error);
        });
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
      openModal() {
        this.isModalOpen = true;
      },
      closeModal() {
        this.isModalOpen = false;
      },
      toggleEdit() {
        this.editMode = !this.editMode;
      },
      cancelEdit() {
     if (this.originalForm) {
       this.form = JSON.parse(JSON.stringify(this.originalForm));
     }
     this.editMode = false;
   },
   closeSaveResultModal() {
        this.isSaveResultModalOpen = false;
        this.saveResultTitle = '';
        this.saveResultMessage = '';
      },
   async confirmSave() {
        try {
          await this.saveData();
          this.saveResultTitle = 'Success';
          this.saveResultMessage = 'Data saved successfully!';
        } catch (error) {
          this.saveResultTitle = 'Error';
          this.saveResultMessage = 'Failed to save data.';
        } finally {
          this.closeModal();
          this.editMode = false;
          this.isSaveResultModalOpen = true;
        }
      },
      addPreparedByField() {
    if (!this.form.s_prepared_by && !this.showSPreparedBy) {
      // Show s_prepared_by if it is not already shown or filled
      this.showSPreparedBy = true;
    } else if (!this.form.t_prepared_by && !this.showTPreparedBy) {
      // Show t_prepared_by if it is not already shown or filled
      this.showTPreparedBy = true;
    }
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
  // Trigger file input for uploading image
  triggerFileInput() {
    // Ensure we correctly reference the hidden file input element
    this.$refs.fileInput.click();
  },

  // Handle file upload
  onFileChange(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        this.previewImage = e.target.result; // Set the preview image
      };
      reader.readAsDataURL(file);
      this.form.profile_image = file; // Store the file in form data
    }
  },

  // Open the camera to capture an image
  openCamera() {
    this.showCamera = true;
    navigator.mediaDevices
      .getUserMedia({ video: true })
      .then((stream) => {
        this.videoStream = stream;
        this.$refs.video.srcObject = stream;
      })
      .catch((err) => {
        console.error("Error accessing the camera: ", err);
        this.message = 'Error accessing the camera.';
        this.messageType = 'error';
      });
  },

  // Capture the photo from the camera
  capturePhoto() {
  const video = this.$refs.video;
  const canvas = document.createElement('canvas');
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  const context = canvas.getContext('2d');
  context.drawImage(video, 0, 0, canvas.width, canvas.height);

  // Generate timestamp
  const timestamp = new Date().toISOString().replace(/[-:.]/g, ''); // Removes special characters for filename compatibility
  
  // Set the captured image as preview
  this.previewImage = canvas.toDataURL('image/png');

  // Convert data URL to file object for saving and add timestamp to the filename
  canvas.toBlob((blob) => {
    this.form.profile_image = new File([blob], `captured_image_${timestamp}.png`, { type: 'image/png' });
  });

  // Stop the video stream and close the camera view
  this.closeCamera();
},


  // Close the camera and modal
  closeCamera() {
    if (this.videoStream) {
      this.videoStream.getTracks().forEach(track => track.stop());
    }
    this.showCamera = false;
  },

  saveData() {
    const formData = new FormData();

    // Loop through the form and append fields to FormData if they are not null
    Object.keys(this.form).forEach(key => {
      if (this.form[key] !== null && this.form[key] !== undefined && key !== 'client_id' && key !== 'profile_image') {
        formData.append(key, this.form[key]);
      }
    });

    // If a new profile image is selected or captured, append it to form data
    if (this.form.profile_image instanceof File) {
      formData.append('profile_image', this.form.profile_image);
    }

    // Ensure client_id is present before proceeding
    if (!this.form.client_id) {
      console.error('Missing client_id');
      this.message = 'Client ID is missing. Cannot submit the form.';
      this.messageType = 'error';
      this.clearMessageAfterDelay();
      return;
    }

    // Append the client ID to formData
    formData.append('client_id', this.form.client_id);

    // Send a request to either update or create the record
    const url = this.form.id
      ? `/api/nursing-care-services/${this.form.id}?_method=PUT`
      : '/api/nursing-care-services';
    
    axios({
      method: 'post', // Use POST for both creation and updates
      url: url,
      data: formData,
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    .then(response => {
      console.log('Data saved successfully', response.data);
      this.message = 'Data saved successfully!';
      this.messageType = 'success';
      this.clearMessageAfterDelay();
      this.editMode = false; // Exit edit mode after saving
    })
    .catch(error => {
      console.error('Error saving data:', error.response ? error.response.data : error.message);
      this.message = 'Error saving data: ' + (error.response?.data?.message || error.message);
      this.messageType = 'error';
      this.clearMessageAfterDelay();
    });
  },

  clearMessageAfterDelay() {
    setTimeout(() => {
      this.message = '';
    }, 3000); // Clear the message after 3 seconds
  },


  exportToPdf() { 
  const pdf = new jsPDF('p', 'mm', [216, 356]); // Legal size: 216mm x 356mm
  const pageHeight = 356; // Total page height in mm
  const marginBottom = 30; // Bottom margin in mm
  const rowHeight = 8; // Height of each row
  const lineHeight = 7; // Space between lines
  const footerHeight = 0; // Adjust to fit the height of your footer
  const maxContentHeight = pageHeight - marginBottom - footerHeight; // Reduce height to account for footer
  const maxWidth = 170; // Maximum width for text
  let contentYPos = 0; // Start Y position for content
  let initialX = 20; // X position for content
  let currentPage = 1; // Start at page 1

  
  const addHeader = () => {
    // Header text
    pdf.setFontSize(9);
    pdf.setFont('TimesNewRoman', 'italic');
    pdf.setTextColor(0, 0, 0);
    pdf.text('DSWD-GF-010 | REV 01 | 17 AUG 2022', 135, 20);
  };
  
  // Helper function to add a new page if content exceeds the page height
  const addNewPageIfNeeded = () => {
    if (contentYPos >= maxContentHeight) {
      pdf.setTextColor(0, 0, 0);
      addFooter(); // Add the footer for the current page
      pdf.setLineWidth(0.5);
      pdf.setDrawColor(0, 0, 0);
      pdf.addPage(); // Add new page
      addHeader(); // Add the header on the new page
      pdf.rect(10, 10, 190, 315); 
      currentPage++; // Increment page number
      contentYPos = 40; // Reset Y position for the new page
      pdf.setFont('arial', 'normal'); // Reset font to 'arial' and style to 'normal'
      pdf.setFontSize(11); // Set font size back to what it was
    }
  };

  const addFooter = () => {
      if (currentPage === 1) {
        pdf.setFontSize(9);
        pdf.setFont('TimesNewRoman', 'bold');
        pdf.setLineWidth(0.5);
        pdf.line(17, 335, 173, 335); // Footer line
  
        pdf.setFont('times', 'normal');
        const footerText = pdf.splitTextToSize('DSWD Field Office XI, Ramon Magsaysay Corner D. Suazo Street, Davao City, Philippines 8000', 160);
        pdf.text(footerText, 95, 340, { align: 'center' });
        pdf.text('Website: ', 45, 345, { align: 'center' });
        pdf.text('Tel Nos.: (082) 227-1964 Email:', 105, 345, { align: 'center' });

        pdf.setFontSize(9);
        pdf.setTextColor(0, 0, 255);
        pdf.text('http://www.dswd.gov.ph', 67, 345, { align: 'center' });
        pdf.text('fo11@dswd.gov.ph ', 140, 345, { align: 'center' });
        pdf.setLineWidth(0);
        pdf.setDrawColor(0, 0, 255);
        pdf.line(51, 346, 83, 346);
        pdf.line(127, 346, 153, 346);
        pdf.setTextColor(0, 0, 0);


        //pdf.text('Website: http://www.dswd.gov.ph Tel Nos.: (082) 227-1964 Email: fo11@dswd.gov.ph ', 105, 345, { align: 'center' });
  
        const footerImgData = '/images/footerimg.png';
        pdf.addImage(footerImgData, 'PNG', 175, 330, 25, 12); // Footer image
  
      } else {
        // Footer for Page 2 and beyond
        pdf.setTextColor(0, 0, 0);
        pdf.setFontSize(8.5);
        pdf.setFont('TimesNewRoman', 'bold');
        pdf.setDrawColor(0, 0, 0);
        pdf.setLineWidth(0.5);
        pdf.line(17, 335, 193, 335); // Footer line extending further
  
        pdf.setFont('times', 'bold');
        pdf.text('DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH', 105, 340, { align: 'center' });
      }
    };


    pdf.setLineWidth(0.5);
  pdf.rect(10, 10, 190, 315); 


  //horizyontal 
  pdf.line(10, 40, 200, 40); 
  pdf.line(10, 52, 200, 52); 
  pdf.line(10, 58, 200, 58); 
  pdf.line(10, 64, 200, 64); 
  pdf.line(10, 69, 200, 69); 
  pdf.line(10, 74, 200, 74); 
  pdf.line(10, 85, 200, 85); 
  pdf.line(10, 90, 200, 90); 
  pdf.line(10, 95, 200, 95); 
  pdf.line(10, 100, 200, 100); 
  pdf.line(10, 105, 200, 105);
  pdf.line(10, 110, 200, 110);
  pdf.line(10, 115, 200, 115);
  pdf.line(10, 120, 200, 120);
  pdf.line(10, 125, 200, 125);
  pdf.line(10, 130, 200, 130);
  pdf.line(10, 140, 200, 140);
  pdf.line(10, 156, 200, 156);

  //vertical ni siya
  pdf.line(108, 52 , 108, 69); 
  pdf.line(90, 85 , 90, 130); 
  pdf.line(110, 140, 110, 156); 


  pdf.setLineWidth(0);



  // Add header logo
  const logoImg = "/images/headerlogo2.png"; 
  pdf.addImage(logoImg, "PNG", 15, 10, 80, 30); 
  contentYPos += 40; 

  // Add title and header text
  pdf.setFontSize(10);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text('REGIONAL REHABILITATION CENTER FOR YOUTH', 150, 22, { align: 'center' });
  contentYPos += 10;

  pdf.text('RRCY/FIELD OFFICE XI', 150, 27, { align: 'center' });
  contentYPos += 10;

  pdf.setFontSize(8);
  pdf.setFont('times', 'italic','bold');
  pdf.text('DSWD-GF-010 | REV 01 | 17 AUG 2022', 150, 32, { align: 'center' });
  contentYPos += 10;


  pdf.setFontSize(18);
  pdf.setTextColor(50, 50, 255);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text('NURSING CARE SERVICE', 105, 48, { align: 'center' });


  pdf.setTextColor(0, 0, 0);
  contentYPos += -14;
  pdf.setFontSize(10);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text(`CLIENT'S NAME: ${this.form.client_name || ''}`, initialX+-9, contentYPos);
  pdf.text(`BIRTHDATE: ${this.form.birthdate || ''}`, initialX+90, contentYPos);

  contentYPos += 6;
  pdf.text(`CURRENT MEDICAL STATUS: ${this.form.current_medical_status || ''}`, initialX+-9, contentYPos);
  pdf.text(`AGE: ${this.form.age || ''}`, initialX+90, contentYPos);


  contentYPos += 6;
  pdf.text(`RELIGION: ${this.form.religion || ''}`, initialX+-9, contentYPos);
  pdf.setFontSize(10);
  pdf.text(`DATE OF ADMISSION: ${this.form.date_of_admission || ''}`, initialX+90, contentYPos);

  contentYPos += 5;
  pdf.text(`ADDRESS:`, initialX+-9, contentYPos);
  pdf.setFontSize(9);
  pdf.text(`${this.form.address || ''}`, initialX+10, contentYPos);

contentYPos +=6;
  pdf.setFontSize(16);
  pdf.setTextColor(50, 50, 255);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text('MONTHLY BMI MONITORING 2024', 105, 82, { align: 'center' });


contentYPos += 10;
pdf.setFontSize(10);
pdf.setTextColor(0, 0, 0);
pdf.setFont('arialbd', 'bold'); 
pdf.text(`VITAL SIGNS / BMI`, initialX+15, contentYPos);
const selectedMonth = this.form.selectedMonth || ''; // Get the temperature value
pdf.text(`${selectedMonth}`, initialX+123, contentYPos); 


contentYPos += 5;
pdf.setFont('arial', 'normal'); 
pdf.text(`TEMPERATURE`, initialX+-9, contentYPos);
const temperature = this.form.temperature || ''; // Get the temperature value
pdf.text(`${temperature}`, 136, contentYPos); 
const tempTextWidth = pdf.getTextWidth(`${temperature}`);
pdf.text('degree celsius', 136 + tempTextWidth + 2, contentYPos);

contentYPos += 5;
pdf.setFont('arial', 'normal'); 
pdf.text(`PULSE RATE`, initialX+-9, contentYPos);
const pulsrate = this.form.pulse_rate || ''; // Get the temperature value
pdf.text(`${pulsrate}`, 145, contentYPos); 
const pulsrateTextWidth = pdf.getTextWidth(`${pulsrate}`);
pdf.text('bpm', 145 + pulsrateTextWidth + 2, contentYPos);

contentYPos += 5;
pdf.setFont('arial', 'normal'); 
pdf.text(`RESPIRATORY RATE`, initialX+-9, contentYPos);
const respiratory_rate = this.form.respiratory_rate || ''; // Get the temperature value
pdf.text(`${respiratory_rate}`, 145, contentYPos); 
const respiratory_rateTextWidth = pdf.getTextWidth(`${respiratory_rate}`);
pdf.text('bpm', 145 + respiratory_rateTextWidth + 2, contentYPos);

contentYPos += 5;
pdf.setFont('arial', 'normal'); 
pdf.text(`BLOOD PRESSURE`, initialX+-9, contentYPos);
const blood_pressure = this.form.blood_pressure || ''; // Get the temperature value
pdf.text(`${blood_pressure}`, 147, contentYPos); 
const blood_pressureTextWidth = pdf.getTextWidth(`${blood_pressure}`);
pdf.text('mmHg', 147 + blood_pressureTextWidth + 2, contentYPos);

contentYPos += 5;
pdf.setFont('arial', 'normal'); 
pdf.text(`HEIGHT (cm)`, initialX+-9, contentYPos);
pdf.text(`${this.form.height_cm || ''}`, 150, contentYPos, { align: 'center' });

contentYPos += 5;
pdf.setFont('arial', 'normal'); 
pdf.text(`WEIGHT (kg)`, initialX+-9, contentYPos);
pdf.text(`${this.form.weight_kg || ''}`, 150, contentYPos, { align: 'center' });


contentYPos += 5;
pdf.setFont('arial', 'normal'); 
pdf.text(`BODY MASS INDEX (BMI)`, initialX+-9, contentYPos);
pdf.text(`${this.form.bmi || ''}`, 150, contentYPos, { align: 'center' });

contentYPos += 5;
pdf.setFont('arial', 'normal'); 
pdf.text(`BMI REMARKS`, initialX+-9, contentYPos);
pdf.setFont('arialbd', 'bold'); 
pdf.text(`${this.form.bmi_remarks || ''}`, 150, contentYPos, { align: 'center' });


pdf.setFontSize(14);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text('GENERAL APPEARANCE', 105, 137, { align: 'center' });

  contentYPos += 15;
  pdf.setFontSize(10);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text(`EYES:`, initialX+-9, contentYPos);
  pdf.setFontSize(9);
  pdf.setFont('arial', 'normal'); 
  pdf.text(`${this.form.eyes_status || ''}`, initialX+3, contentYPos);
  pdf.setFont('arialbd', 'bold'); 
  pdf.setFontSize(10);
  pdf.text(`NAILS:`, initialX+91, contentYPos);
  pdf.setFontSize(9);
  pdf.setFont('arial', 'normal'); 
  pdf.text(`${this.form.nails_status || ''}`, initialX+104, contentYPos);

  contentYPos += 5;
  pdf.setFontSize(10);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text(`EARS:`, initialX+-9, contentYPos);
  pdf.setFontSize(9);
  pdf.setFont('arial', 'normal'); 
  pdf.text(`${this.form.ears_status || ''}`, initialX+3, contentYPos);
  pdf.setFont('arialbd', 'bold'); 
  pdf.setFontSize(10);
  pdf.text(`SKIN:`, initialX+91, contentYPos);
  pdf.setFontSize(9);
  pdf.setFont('arial', 'normal'); 
  pdf.text(`${this.form.skin_status || ''}`, initialX+102, contentYPos);

  contentYPos += 5;
  pdf.setFontSize(10);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text(`MOUTH & TEETH:`, initialX+-9, contentYPos);
  pdf.setFontSize(9);
  pdf.setFont('arial', 'normal'); 
  pdf.text(`${this.form.mouth_teeth_status || ''}`, initialX+22, contentYPos);
  pdf.setFont('arialbd', 'bold'); 
  pdf.setFontSize(10);
  pdf.text(`HAIR:`, initialX+91, contentYPos);
  pdf.setFontSize(9);
  pdf.setFont('arial', 'normal'); 
  pdf.text(`${this.form.hair_status || ''}`, initialX+103, contentYPos);



  contentYPos +=3;
  const profileImage = this.form.profile_image 
  ? `/profile_images/${this.form.profile_image}` 
  : this.previewImage || '/images/default-profile.jpg'; // Fallback to default image if none

  const img = new Image();
  img.src = profileImage; // Set the image source
  img.onload = () => {
      // Add the profile image to the PDF
      pdf.addImage(img, 'PNG', initialX+ 90, contentYPos, 89, 81); // Adjust size as necessary








      contentYPos +=3;
      pdf.setFontSize(10);


  pdf.setFont('arialbd', 'bold');
  pdf.text(`SERVICES GIVEN:`, initialX + -9, contentYPos);

pdf.setLineWidth(0);
contentYPos += rowHeight;
contentYPos += 2;
pdf.setFont('arial', 'normal');
pdf.setFontSize(10);

// Split the text into lines
const services_giveLog = `${this.form.services_given || ''}`;
const services_giveLogLines = pdf.splitTextToSize(services_giveLog, maxWidth + -75);

services_giveLogLines.forEach(line => {
  addNewPageIfNeeded(); // Check for overflow before adding a line
  
  // Just print the lines as they are, since the numbering is handled in the textarea itself
  pdf.text(line, initialX + -9, contentYPos - 5);
  
  contentYPos += lineHeight + -2;
});



  contentYPos +=25;

  pdf.setFont('arialbd', 'bold');
  pdf.text(`REMARKS:`, initialX + -9, contentYPos);

contentYPos += rowHeight;
contentYPos += 2;
pdf.setFont('arial', 'normal');
pdf.setFontSize(10);

// Split the text into lines
const remarksLog = `${this.form.remarks || ''}`;
const remarksLogLines = pdf.splitTextToSize(remarksLog, maxWidth + -75);

remarksLogLines.forEach(line => {
  addNewPageIfNeeded(); // Check for overflow before adding a line

  // Just print the lines as they are, since the numbering is handled in the textarea itself
  pdf.text(line, initialX + -9, contentYPos - 5);

  contentYPos += lineHeight + -2;
});






  
 contentYPos +=60;
 addNewPageIfNeeded();
 pdf.setLineWidth(0.5);
 pdf.line(10, contentYPos+-10, 200,contentYPos+-10); 
  pdf.setFontSize(10);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text(`PREPARED BY:`, initialX+-9, contentYPos);

  pdf.setFontSize(10);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text(`NOTED BY:`, initialX+81, contentYPos);






contentYPos += 10;


  // Exporting f_prepared_by field
  if (this.form.f_prepared_by) {
    pdf.setFontSize(11);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`${this.form.f_prepared_by}`, initialX +12, contentYPos);
    contentYPos += 5;  // Adjust space after each field
  }

  // Conditionally render s_prepared_by if it exists
  if (this.form.s_prepared_by) {
    pdf.setFontSize(11);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`${this.form.s_prepared_by}`, initialX +12, contentYPos);
    contentYPos += 5;
  }

  // Conditionally render t_prepared_by if it exists
  if (this.form.t_prepared_by) {
    pdf.setFontSize(11);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`${this.form.t_prepared_by}`, initialX +12, contentYPos);
    contentYPos += 5;
  }

  // Adding the Resident Nurses RRCY part
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(10);
  pdf.text('RESIDENT NURSES RRCY', initialX + 12, contentYPos);


  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(11);
  pdf.text(this.center_head, initialX+105, contentYPos-5);
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(10);
  pdf.text('SWO IV / Center Head', initialX+105, contentYPos-1);


  addFooter();

const totalPages = pdf.internal.getNumberOfPages();
  for (let i = 1; i <= totalPages; i++) {
    pdf.setPage(i);
    pdf.setFontSize(9);
    pdf.setTextColor(0, 0, 0);
    pdf.setFont('TimesNewRoman', 'bold');
    pdf.text(`PAGE ${i} of ${totalPages}`, 105, 333, { align: 'center' }); // Update the footer with the correct total pages
  }

// Save the PDF with a dynamic filename
pdf.save(`Nursing_Care_${this.form.client_name || ''}.pdf`);

};
img.onerror = (err) => {
   console.error('Image loading error:', err);
   // Continue generating the PDF even if the image fails to load
   pdf.save(`Nursing_Care_${this.form.client_name || ''}.pdf`);
  };

  img.src = profileImage; // Set the image source
},


}
  };
  </script>
  
  
  <style scoped>
  .underline-input {
    border: none;
    border-bottom:  1px solid black;
    padding: 0;
    margin: 0;
    vertical-align: bottom; /* Ensures the text aligns with the bottom of the input */
    width: 80%;
  }
  
  .custom-border-l {
  position: relative;
}

.custom-border-l::after {
  content: '';
  position: absolute;
  left: 0;
  top: -7px;
  bottom: -1px; /* Adjust this value to make the border extend lower */
  width: 1px; /* The thickness of the border */
  background-color: black; /* Same as the border color */
}
.custom-border-t {
  position: relative;
}

.custom-border-t::before {
  content: '';
  position: absolute;
  left: 0;
  right: -120px;
  top: -2px;
  height: 1px; /* Thickness of the top border */
  background-color: black; /* Same as the border color */
  transform: translateY(-5px); /* Adjust this value to move the top border higher */
}

.custom-border-t2 {
  position: relative;
}

.custom-border-t2::before {
  content: '';
  position: absolute;
  left: 0;
  right: 0;
  top: -2px;
  height: 1px; /* Thickness of the top border */
  background-color: black; /* Same as the border color */
  transform: translateY(-5px); /* Adjust this value to move the top border higher */
}
.custom-border-t3 {
  position: relative;
}

.custom-border-t3::before {
  content: '';
  position: absolute;
  left: 0;
  right: 0;
  top: -2px;
  height: 1px; /* Thickness of the top border */
  background-color: black; /* Same as the border color */
  transform: translateY(-5px); /* Adjust this value to move the top border higher */
}
.graph-background {
      background-image: linear-gradient(to right, #cccccc 1px, transparent 1px), 
                        linear-gradient(to bottom, #cccccc 1px, transparent 1px);
      background-size: 15px 15px; /* Adjust size as per your need */
    } 
  </style>
  