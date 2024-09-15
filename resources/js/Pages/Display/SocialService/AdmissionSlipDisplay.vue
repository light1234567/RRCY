<template>
  <div>
    <!-- Tabs for Actions -->
    <div v-if="editMode" class="flex absolute p-6 -mt-2 space-x-4">
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

      <button v-if="editMode" @click="openModal" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span>Save</span>
      </button>

      <!-- Export to PDF Button -->
      <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 text-white rounded-md text-xs">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Export to PDF</span>
      </button>
    </div>

    <!-- Modal for Save Confirmation -->
    <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50">
      <div class="fixed inset-0 bg-black opacity-50"></div>
      <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
        <div class="bg-white p-6">
          <div class="flex items-center">
            <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.93 5h13.86c1.1 0 1.96-.9 1.84-1.98l-1.18-12.14a2 2 0 00-1.98-1.88H4.27a2 2 0 00-1.98 1.88L1.11 16.02c-.12 1.08.74 1.98 1.84 1.98z" />
            </svg>
            <h3 class="text-lg leading-6 font-medium text-gray-900">Save changes?</h3>
          </div>
          <div class="mt-2">
            <p class="text-sm text-gray-500">Are you sure you want to save the changes?</p>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button @click="confirmSave" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
    Save
</button>

          <button @click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
            Cancel
          </button>
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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
  
     <!-- Form Content -->
  
    <div ref="pdfContent" class="p-6 border border-gray-400 shadow-xs rounded-lg max-w-3xl mx-auto my-8 ">
      <div class=" relative flex justify-between items-center mb-2">
        <img src="/images/headerlogo2.png" alt="Logo" class="ml-4 h-32 w-64 relative z-10">
        <p class="text-[10.7px] mb-10 font mr-6" style="font-family: 'Times New Roman', Times, serif; font-style: italic;">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>

      </div>

      <h1 class="text-[21.33px] font-bold mb-2 text-center text-black">ADMISSION SLIP</h1>

      <div v-if="clients.length > 0" v-for="client in clients" :key="client.id" class="mb-12 p-6 rounded-lg text-xs">
        <div class="flex items-center">
          <div class="flex-grow text-[15px] flex items-center mr-2">
  <label class="mb-3 text-black mr-2 flex items-center h-full">Name:</label>
  <!-- When not in edit mode, show the concatenated value -->
  <template v-if="!editMode">
    <input type="text" class="underline-input w-full" :value="client.first_name + ' ' + client.middle_name + ' ' + client.last_name" readonly>
  </template>

  <!-- When in edit mode, show the separate fields for first, middle, and last name -->
  <template v-else>
    <input type="text" class="underline-input w-1/3 mr-1" v-model="client.first_name" placeholder="First Name">
    <input type="text" class="underline-input w-1/3 mr-1" v-model="client.middle_name" placeholder="Middle Name">
    <input type="text" class="underline-input w-1/3" v-model="client.last_name" placeholder="Last Name">
  </template>
</div>

<div class="flex text-[15px] items-center w-1/4">
          <label class="mb-3 text-black mr-2">Sex:</label>
          <input type="text" class="underline-input bg-transparent mt-1 w-full" v-model="client.sex" :readonly="!editMode">
        </div>
        <div class="flex text-[15px] items-center w-1/4">
          <label class="mb-3 text-black mr-2">Religion:</label>
          <input type="text" class="underline-input bg-transparent mt-1 w-full" v-model="client.religion" :readonly="!editMode">
        </div>
        </div>

        <div class="flex items-center">
          <div class="flex-grow flex text-[15px] items-center mr-2">
  <label class="mb-3 block text-black mr-2">Address:</label>
  
  <template v-if="!editMode">
    <input type="text" class="underline-input w-full" :value="client.province + ', ' + client.city + ', ' + client.barangay + ', ' + client.street" readonly>
  </template>
  
  <template v-else>
    <input type="text" class="underline-input w-1/4 mr-1" v-model="client.province" placeholder="Province">
    <input type="text" class="underline-input w-1/4 mr-1" v-model="client.city" placeholder="City">
    <input type="text" class="underline-input w-1/4 mr-1" v-model="client.barangay" placeholder="Barangay">
    <input type="text" class="underline-input w-1/4" v-model="client.street" placeholder="Street">
  </template>
</div>

        </div>

        <div class="text-[15px] flex items-center">
  <label class="mb-3 block text-black mr-2 whitespace-nowrap">Date/Place of Birth:</label>
  
  <!-- Show the combined Date of Birth and Place of Birth when not in edit mode -->
  <template v-if="!editMode">
    <input type="text" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs" :value="client.date_of_birth + ' / ' + client.place_of_birth" readonly>
  </template>
  
  <!-- Show separate input fields for Date of Birth and Place of Birth in edit mode -->
  <template v-else>
    <input type="date" class="underline w-1/2 mr-1 text-xs" v-model="client.date_of_birth" placeholder="Date of Birth">
    <input type="text" class="underline-input w-1/2 text-xs" v-model="client.place_of_birth" placeholder="Place of Birth">
  </template>
</div>


        <div class="grid grid-cols-2 gap-4">
          <div class="flex items-center text-[15px] ">
              <label class="mb-3    text-black mr-2 whitespace-nowrap">Committing Court:</label>
              <input type="text" class="underline-input bg-transparent text-xs w-full" v-model="client.admissions[0].committing_court" :readonly="!editMode">
          </div>
          <div class="text-[15px] flex items-center">
            <label class="mb-3 block    text-black ml-2  mr-2 whitespace-nowrap">Crim. Case #:</label>
            <input type="text" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs" v-model="client.admissions[0].crim_case_number" :readonly="!editMode"
>            </div>
        </div>

        <div class="flex items-center">
        <!-- Offense Committed Section -->
        <div class="text-[15px] flex items-center w-1/2">
          <label class="mb-3    text-black mr-2 whitespace-nowrap">Offense Committed:</label>
          <input type="text" v-model="client.admissions[0].offense_committed" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs":readonly="!editMode"
/>
        </div>

        <!-- Date Admitted Section -->
        <div class="text-[15px] flex items-center w-1/2">
  <label class="mb-3 text-black mr-2 whitespace-nowrap ml-4">Date admitted to Center:</label>
  
  <!-- Show the date admitted in a readonly input when not in edit mode -->
  <template v-if="!editMode">
    <input type="text" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs" :value="client.admissions[0]?.date_admitted" readonly>
  </template>
  
  <!-- Show a date picker input field when in edit mode -->
  <template v-else>
    <input type="date" class="underline w-full text-xs" v-model="client.admissions[0].date_admitted" placeholder="Date Admitted">
  </template>
</div>

      </div>

        <div class="flex items-center">
          <div class="flex items-center text-[15px] w-1/2">
            <label class="mb-3 block    text-black whitespace-nowrap mr-2">No. of Days in Jail:</label>
            <input type="text" v-model="client.admissions[0].days_in_jail" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs" :readonly="!editMode"
/>
          </div>
          <div class="flex items-center text-[15px] w-1/2">
            <label class="mb-3 block    text-black ml-4 whitespace-nowrap mr-2">No. of Days in Detention Center:</label>
            <input type="text" class="underline-input w-1/4 bg-transparent mt-1  mb-6 flex-grow text-xs" v-model="client.admissions[0].days_in_detention_center" :readonly="!editMode">
          </div>
        </div>
        <div class="mb-2">
          <label class="mt-2 text-[15px] mb-4 block font-bold text-black">DISTINGUISHING MARKS:</label>
          <div class="flex flex-wrap items-center gap-x-8">
            <!-- Tattoo/Scars -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3 block text-black mr-2">a.Tattoo/Scars:</label>
              <input type="text" v-model="client.admissions[0].distinguishing_marks[0].tattoo_scars" class="underline-input bg-transparent flex-grow text-xs w-[100px]" :readonly="!editMode"
/>
            </div>

            <!-- Height -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3 block    text-black mr-2">b.Height:</label>
              <input type="text" v-model="client.admissions[0].distinguishing_marks[0].height" class="underline-input bg-transparent flex-grow text-xs w-[100px]" :readonly="!editMode"
/>
            </div>

            <!-- Weight -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3 block    text-black mr-2">c. Weight:</label>
              <div v-if="client.admissions[0]?.distinguishing_marks?.[0]">
<input type="text" class="underline-input1 bg-transparent flex-grow text-xs w-[100px]" v-model="client.admissions[0].distinguishing_marks[0].weight" :readonly="!editMode"
/>
</div>
            </div>

            <!-- Colour of Eye -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3    text-black mr-2">d. Colour of Eye:</label>
              <div v-if="client.admissions[0]?.distinguishing_marks?.[0]">
<input type="text" class="underline-input1 bg-transparent flex-grow text-xs w-[100px]" v-model="client.admissions[0].distinguishing_marks[0].colour_of_eye" :readonly="!editMode"
/>
</div>
            </div>

            <!-- Skin -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3    text-black mr-2">e. Skin:</label>
              <div v-if="client.admissions[0]?.distinguishing_marks?.[0]">
<input type="text" class="underline-input1 bg-transparent flex-grow text-xs w-[100px]" v-model="client.admissions[0].distinguishing_marks[0].skin_colour" :readonly="!editMode"
/>
</div>
            </div>
          </div>
        </div>


 <!-- Checklist for Documents Submitted -->
<div class="mb-4">
  <label class="text-[15px] block mb-2 font-semibold text-black">Put on Documents Submitted:</label>
  <div class="pl-4">
    <!-- Checklist with 3 columns -->
    <div class="text-[15px] grid grid-cols-3 gap-x-10 gap-y-2">
      
      <!-- SCSR Checkbox -->
      <label class="block font-semibold text-gray-700">
        <input 
          type="checkbox" 
          class="mr-2" 
          :checked="isDocumentSubmitted(client, 'SCSR')" 
          @change="toggleDocument(client, 'SCSR')" 
          :disabled="!editMode"
        > SCSR
      </label>

      <!-- Court Order Checkbox -->
      <label class="block font-semibold text-gray-700">
        <input 
          type="checkbox" 
          class="mr-2" 
          :checked="isDocumentSubmitted(client, 'Court Order')" 
          @change="toggleDocument(client, 'Court Order')" 
          :disabled="!editMode"
        > Court Order
      </label>

      <!-- Medical Certificates Checkbox -->
      <label class="block font-semibold text-gray-700">
        <input 
          type="checkbox" 
          class="mr-2" 
          :checked="isDocumentSubmitted(client, 'Medical Certificates')" 
          @change="toggleDocument(client, 'Medical Certificates')" 
          :disabled="!editMode"
        > Medical Certificates
      </label>

      <!-- Consent from Parents Checkbox -->
      <label class="block font-semibold text-gray-700">
        <input 
          type="checkbox" 
          class="mr-2" 
          :checked="isDocumentSubmitted(client, 'Consent from Parents')" 
          @change="toggleDocument(client, 'Consent from Parents')" 
          :disabled="!editMode"
        > Consent from Parents
      </label>

      <!-- School Records Checkbox -->
      <label class="block font-semibold text-gray-700">
        <input 
          type="checkbox" 
          class="mr-2" 
          :checked="isDocumentSubmitted(client, 'School Records')" 
          @change="toggleDocument(client, 'School Records')" 
          :disabled="!editMode"
        > School Records
      </label>

     <!-- Others Checkbox with input -->
<label class="block font-semibold text-gray-700 flex items-center">
  <input 
    type="checkbox" 
    class="mr-2" 
    :checked="isDocumentSubmitted(client, 'Others')" 
    @change="toggleDocument(client, 'Others')" 
    :disabled="!editMode"
  > Others
  
  <!-- Show input for "Others" if it's checked -->
  <input 
    v-if="isDocumentSubmitted(client, 'Others') && editMode" 
    type="text" 
    v-model="othersDocumentName" 
    placeholder="Specify Others" 
    class="ml-2 underline-input bg-transparent flex-grow text-xs"
    @input="handleOtherDocument(client, othersDocumentName)" 
  >
  
  <!-- Display the "Others" document name if it exists and not in edit mode -->
  <span v-if="getOthersDocument(client) && !editMode" class="ml-2">
    ({{ getOthersDocument(client) }})
  </span>
</label>



    </div>
  </div>
</div>






<div class="text-[15px] mb-4">
  <label class="block font-semibold mb-2 text-black">General impression upon admission:</label>
  <textarea 
    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-[15px] leading-relaxed" 
    style="line-height: 1.5;" 
    v-model="client.admissions[0].general_impression" 
    :readonly="!editMode">
  </textarea>
</div>

<div class="text-[15px] mb-4">
  <label class="block font-semibold mb-2 text-black">Action Taken:</label>
  <textarea 
    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-[15px] leading-relaxed" 
    style="line-height: 1.5;" 
    v-model="client.admissions[0].action_taken" 
    :readonly="!editMode">
  </textarea>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">

          
  <!-- Referring Party Section -->
  <div class="flex flex-col justify-end mb-4">
<!-- Display the current signature image if it exists or show a preview of the new uploaded image -->
<div v-if="client.admissions[0]?.referring_party_signature || editMode" class="mb-4">
  <label class="block mb-2 text-sm font-medium text-gray-700">
    Upload or Update Referring Party Signature:
  </label>

  <!-- Show image preview if available -->
  <div v-if="signaturePreview || client.admissions[0]?.referring_party_signature">
    <img
      :src="signaturePreview || getSignatureUrl(client.admissions[0]?.referring_party_signature)"
      alt="Referring Party Signature"
      class="h-24 w-auto mb-2"
    />
  </div>
</div>

<!-- Text input for the referring party name -->
<input 
  type="text" 
  class="underline-input mt-1 w-full text-[15px]" 
  v-model="client.admissions[0].referring_party_name" 
  :readonly="!editMode"
>

<label class="block font-semibold text-gray-700 mt-2">Name & Signature of Referring Party</label>
</div>



  <!-- Admitting Officer Section -->
  <div class="flex flex-col justify-end mb-4">
  <input 
    type="text" 
    class="underline-input mt-1 w-full text-[15px]" 
    v-model="client.admissions[0].admitting_officer" 
    :readonly="!editMode"
  >
  <label class="block font-semibold text-gray-700 mt-2">Admitting Officer</label>
</div>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
  <div>
    <input 
      type="text" 
      class="underline-input mt-1 w-full text-[15px]" 
      v-model="client.admissions[0].designation_id_contact" 
      :readonly="!editMode"
    >
    <label class="block font-semibold text-gray-700 mt-2">Designation / ID No. / Contact #</label>
  </div>
  <div>
    <input 
      type="text" 
      class="underline-input mt-1 w-full text-[15px]" 
      v-model="client.admissions[0].designation" 
      :readonly="!editMode"
    >
    <label class="block font-semibold text-gray-700 mt-2">Designation</label>
  </div>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
  <div>
    <input 
      type="text" 
      class="underline-input mt-1 w-full text-[15px]" 
      v-model="client.admissions[0].office_address" 
      :readonly="!editMode"
    >
    <label class="block font-semibold text-gray-700 mt-2">Complete Address/Office Address</label>
  </div>
  
  <div>
  <!-- When not in edit mode, show the combined Date/Time as a single read-only field -->
  <template v-if="!editMode">
    <input 
      type="text" 
      class="underline-input mt-1 w-full text-[15px]" 
      :value="formatDateTime(client.admissions[0]?.date_time)" 
      readonly
    >
  </template>

  <!-- When in edit mode, show a single input for both date and time -->
  <template v-else>
    <input 
      type="datetime-local"  
      class="underline mt-1 w-full text-[15px]" 
      v-model="client.admissions[0].date_time"  
      placeholder="Select Date and Time"
    >
  </template>

  <label class="block font-semibold text-gray-700 mt-2">Date/Time</label>
</div>


</div>

<!-- Noted By Section -->
<div class="border-gray-300 pt-4 text-center text-xs">
  <p class="font-semibold mb-4 text-[12px]">Noted By:</p>
  <input 
    v-if="client.admissions[0]" 
    type="text" 
    class="underline-input mt-1 text-center text-[12px] font-bold"
    v-model="client.admissions[0].noted_by" 
    :readonly="!editMode"
    style="width: 200px;" 
  />
  <p class="text-xs">Center Head/SWO IV</p>
</div>


      </div>
      <div v-else>
        <p>Loading data...</p>
      </div>

      <div class="border-gray-300 ml-6 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
        <div class="flex justify-between items-center">
          <div class="flex flex-col">
            <p class="ml-24 -mb-2 font-bold">PAGE 1 of 1</p>
            <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
            <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrcy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
          </div>
          <div class="ml-4">
            <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
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

export default {  
  name: 'ClientList',
  data() {
    return {
      clients: [],
      admission_id: null, // Admission ID used for update logic
      editMode: false,
      isModalOpen: false,
      isSaveResultModalOpen: false,
      saveResultTitle: '',
      saveResultMessage: '',
      id: null, // Current client or admission ID
      signaturePreview: null,
      othersDocumentName: '',
      form: {
        client: {
          first_name: '',
          middle_name: '',
          last_name: '',
          suffix: '',
          sex: '',
          date_of_birth: '',
          place_of_birth: '',
          province: '',
          city: '',
          barangay: '',
          street: '',
          religion: '',
      },
      admission: {
          case_status: '',
          committing_court: '',
          crim_case_number: '',
          offense_committed: '',
          date_admitted: '',
          days_in_jail: 0,
          days_in_detention_center: 0,
          action_taken: '',
          general_impression: '',
          referring_party_name: '',
          admitting_officer: '',
          designation_id_contact: '',
          designation: '',
          office_address: '',
          date_time: '',
          noted_by: '',
          referring_party_signature: null,
        },
        distinguishing_marks: {
          tattoo_scars: '',
          height: null,
          weight: null,
          colour_of_eye: '',
          skin_colour: '',
        },
        documents_submitted: {
          documents: [],
          others: '',
        },
    },

  };
},

  mounted() {
    this.id = this.$route.params.id;
    this.fetchClientsData();
  },
  watch: {
    '$route.params.id': function(newId) {
      this.id = newId;
      this.fetchClientsData();
    },
  },
  methods: {

    knownDocuments() {
    return ["SCSR", "Court Order", "Medical Certificates", "Consent from Parents", "School Records"];
  },

    // Toggle between edit and view modes
    toggleEdit() {
      this.editMode = !this.editMode;
    },

    cancelEdit() {
      this.editMode = false;
    },

    openModal() {
      this.isModalOpen = true;
    },

    closeModal() {
      this.isModalOpen = false;
    },

    confirmSave() {
    if (this.clients[0]?.admissions[0]?.id) {
        this.saveForm(this.clients[0].admissions[0].id);
    } else {
        this.saveForm();
    }
    this.closeModal();
    this.editMode = false;
},


getSignatureUrl(signaturePath) {
      // Append /storage/ to signature path if it's a relative path
      if (signaturePath && !signaturePath.startsWith('http')) {
        return `/storage/${signaturePath}`;
      }
      return signaturePath;
    },


    // Update form data (for existing admissions)
    async saveForm(admissionId = null) {
  try {
    const client = this.clients[0]; // Assuming you're using the first client in the list
    const admission = client.admissions[0]; // Assuming you're using the first admission in the list

    // Convert documents_submitted.documents from string to array if it's a stringified JSON
    let documentsSubmitted = admission.documents?.[0]?.document_name;
    if (typeof documentsSubmitted === 'string') {
      try {
        documentsSubmitted = JSON.parse(documentsSubmitted);
      } catch (e) {
        console.error("Failed to parse documents_submitted:", e);
        documentsSubmitted = []; // Set to an empty array if parsing fails
      }
    }

    const data = {
      client: {
        id: client.id || '', // Include the client ID to update the existing client
        first_name: client.first_name || '',
        middle_name: client.middle_name || '',
        last_name: client.last_name || '',
        sex: client.sex || '',
        religion: client.religion || '',
        date_of_birth: client.date_of_birth || '',
        place_of_birth: client.place_of_birth || '',
        province: client.province || '',
        city: client.city || '',
        barangay: client.barangay || '',
        street: client.street || '',
        child_status: client.child_status || ''
      },
      admission: {
        id: admission.id || '', // Include the admission ID to update the existing admission
        case_status: admission.case_status || '',
        committing_court: admission.committing_court || '',
        crim_case_number: admission.crim_case_number || '',
        offense_committed: admission.offense_committed || '',
        date_admitted: admission.date_admitted || '',
        days_in_jail: admission.days_in_jail || '',
        days_in_detention_center: admission.days_in_detention_center || '',
        action_taken: admission.action_taken || '',
        general_impression: admission.general_impression || '',
        referring_party_name: admission.referring_party_name || '',
        admitting_officer: admission.admitting_officer || '',
        designation_id_contact: admission.designation_id_contact || '',
        designation: admission.designation || '',
        office_address: admission.office_address || '',
        date_time: admission.date_time || '',
        noted_by: admission.noted_by || ''
      },
      distinguishing_marks: {
        tattoo_scars: admission.distinguishing_marks?.[0]?.tattoo_scars || '',
        height: admission.distinguishing_marks?.[0]?.height || '',
        weight: admission.distinguishing_marks?.[0]?.weight || '',
        colour_of_eye: admission.distinguishing_marks?.[0]?.colour_of_eye || '',
        skin_colour: admission.distinguishing_marks?.[0]?.skin_colour || ''
      },
      documents_submitted: {
        documents: documentsSubmitted, // Ensure this is an array, not a string
        others: admission.documents?.[0]?.others || ''
      },
      client_id: client.id || '', // Pass client_id for identification
      admission_id: admission.id || '' // Pass admission_id for identification
    };

    // Log the data being sent for debugging
    console.log("Data to be sent:", data);

    // Decide if it's a PUT (update) or POST (new entry)
    const method = admissionId ? 'put' : 'post';
    const url = admissionId ? `/api/admission/${admissionId}` : '/api/admission';

    // Send the request
    const response = await axios({
      method,
      url,
      data
    });

    console.log("Response received:", response); // Log the response from the server

    if (response.status === 200) {
      this.showSaveResultModal('Success', 'Form saved successfully.');
    } else {
      throw new Error('Unexpected response');
    }
  } catch (error) {
    // Log the error details for debugging
    console.error("Error saving form:", error.response?.data || error.message);
    console.error("Full error details:", error); // Log the full error object
    this.showSaveResultModal('Error', 'An error occurred while saving.');
  }
}
,
    closeSaveResultModal() {
      this.isSaveResultModalOpen = false;
    },

    formatDateTime(dateTime) {
      if (!dateTime) return '';
      const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric', 
        hour: '2-digit', 
        minute: '2-digit', 
        hour12: true 
      };
      return new Date(dateTime).toLocaleString('en-US', options);  // Use toLocaleString for combined DateTime format
    },

// Check if a document has been submitted
isDocumentSubmitted(client, documentName) {
    if (!client.admissions || !client.admissions[0] || !client.admissions[0].documents || !client.admissions[0].documents[0]) {
      return false;
    }

    const document = client.admissions[0].documents[0];
    let documentNames = [];

    try {
      if (document.document_name) {
        documentNames = JSON.parse(document.document_name);
      }
    } catch (e) {
      console.error("Error parsing document_name:", e);
    }

    // If checking for "Others", return true if any document is not in the known list
    if (documentName === 'Others') {
      return documentNames.some(doc => !this.knownDocuments().includes(doc));
    } else {
      return documentNames.includes(documentName);
    }
  },

  getOthersDocument(client) {
    if (!client.admissions || !client.admissions[0] || !client.admissions[0].documents || !client.admissions[0].documents[0]) {
      return '';
    }

    const document = client.admissions[0].documents[0];
    let documentNames = [];

    try {
      if (document.document_name) {
        documentNames = JSON.parse(document.document_name);
      }
    } catch (e) {
      console.error("Error parsing document_name:", e);
    }

    // Return the name of the "Others" document (the document not in the known list)
    const othersDocument = documentNames.find(doc => !this.knownDocuments().includes(doc));
    return othersDocument || '';
  },

// Toggle document in the documents_submitted array
toggleDocument(client, documentName) {
    if (!client.admissions || !client.admissions[0].documents) {
      client.admissions[0].documents = [{ document_name: JSON.stringify([]), submitted: false }];
    }

    let document = client.admissions[0].documents[0];
    let documentNames = [];

    try {
      documentNames = JSON.parse(document.document_name || '[]');
    } catch (e) {
      console.error("Error parsing document_name:", e);
    }

    // If toggling "Others", handle unknown documents
    if (documentName === 'Others') {
      if (!this.isDocumentSubmitted(client, 'Others')) {
        documentNames.push(this.othersDocumentName);
      } else {
        documentNames = documentNames.filter(doc => this.knownDocuments().includes(doc));
      }
    } else {
      const documentIndex = documentNames.indexOf(documentName);
      if (documentIndex === -1) {
        documentNames.push(documentName);
      } else {
        documentNames.splice(documentIndex, 1);
      }
    }

    // Save the updated array as a JSON string
    client.admissions[0].documents[0].document_name = JSON.stringify(documentNames);
  },

    showSaveResultModal(title, message) {
      this.saveResultTitle = title;
      this.saveResultMessage = message;
      this.isSaveResultModalOpen = true;
    },

    handleOtherDocument(client, otherDocumentName) {
    if (!client.admissions || !client.admissions[0] || !client.admissions[0].documents) {
      return;
    }

    const document = client.admissions[0].documents[0];

    let documentNames = [];
    try {
      documentNames = JSON.parse(document.document_name);
    } catch (e) {
      console.error("Error parsing document_name:", e);
    }

    // Remove existing "Others" value to prevent duplication
    documentNames = documentNames.filter(doc => this.knownDocuments().includes(doc));

    // Add the new "Others" value if it's not already in the array
    if (otherDocumentName && !documentNames.includes(otherDocumentName)) {
      documentNames.push(otherDocumentName);
    }

    // Update the document_name and others field
    client.admissions[0].documents[0].document_name = JSON.stringify(documentNames);
    client.admissions[0].documents[0].others = otherDocumentName; 
  }
,

    async fetchClientsData() {
  try {
    console.log(`Fetching data for client with ID: ${this.id}`);

    // Fetch the data from the server
    const response = await axios.get(`/api/clients-data/${this.id}`);
    
    // Log the entire response for inspection
    console.log('Full API response:', response.data);

    // Filter and get the specific client by ID
    this.clients = response.data.filter(client => client.id === parseInt(this.id));

    // Check if any client data was found
    if (this.clients.length === 0) {
      console.warn(`No client found with ID: ${this.id}`);
    } else {
      console.log(`Client found:`, this.clients[0]);
    }

    // Iterate over clients and admissions to ensure proper structure
    this.clients.forEach(client => {
      console.log(`Processing client with ID: ${client.id}`);
      client.admissions.forEach(admission => {
        console.log(`Processing admission with ID: ${admission.id}`);

        // Ensure documents exists and is correctly structured
        if (!admission.documents) {
          console.warn(`No documents found for admission ID: ${admission.id}`);
          admission.documents = []; // Initialize the documents array if it doesn't exist
        } else {
          console.log(`Documents submitted for admission ID ${admission.id}:`, admission.documents);

          // Ensure documents is an array
          if (!Array.isArray(admission.documents)) {
            console.warn(`Documents is not an array for admission ID: ${admission.id}`);
            admission.documents = []; // Convert to array if not already
          }
        }

        // Ensure others field is present
        if (!admission.others) {
          admission.others = ''; // Initialize others as an empty string if it doesn't exist
        }
      });
    });

    console.log('Processed client data:', this.clients);

  } catch (error) {
    console.error('Error fetching client data:', error);
  }
}

,

async exportToPdf() {
  const pdf = new jsPDF('p', 'mm', [216, 356]); // Legal size: 216mm x 356mm

  // Add and set Times New Roman font
  pdf.addFont('times-normal.ttf', 'TimesNewRoman', 'italic'); // Load the Times New Roman italic font
  pdf.setFont('TimesNewRoman', 'italic'); // Set Times New Roman as the italic font

  // Set default font properties
  pdf.setFontSize(11);
  pdf.setLineHeightFactor(1.5);

  const imgData = '/images/headerlogo2.png'; // Ensure this is accessible or use base64
  pdf.addImage(imgData, 'PNG', 15, 10, 75, 35); // Adjust the size as needed

  // Add the header below the image
  pdf.setFontSize(8); 
  pdf.setFont('italic'); // Set font to italic
  pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 152, 24);

  // Load and set Arial font
  pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
  pdf.setFont('Arial', 'normal'); // Set Arial as the default font  
  pdf.setFontSize(18);

  pdf.setTextColor(0, 0, 0); // RGB values for black

  // Mimic bold by drawing the text multiple times with slight offsets
  pdf.text('ADMISSION SLIP', 108, 60, null, null, 'center'); // First pass
  pdf.text('ADMISSION SLIP', 108.2, 60, null, null, 'center'); // Slight offset
  pdf.text('ADMISSION SLIP', 107.8, 60, null, null, 'center'); // Slight offset

  pdf.setFont('Arial', 'normal'); // Set Arial as the default font
  pdf.setFontSize(11); // Reset font size for content

  // Function to draw a custom checkmark inside the checkbox
  function drawCheckmark(pdf, x, y) {
    pdf.setLineWidth(0.1);
    pdf.line(x, y + 1, x + 1, y + 2.5); // First line of the checkmark
    pdf.line(x + 1, y + 2.5, x + 3, y - 0.5); // Second line of the checkmark
  }

  // Function to fill the checkbox and draw the checkmark
  function fillCheckboxWithCheck(pdf, x, y) {
    pdf.setFillColor(169, 169, 169); // Set a light gray color
    pdf.rect(x, y, 4, 4, 'F'); // Draw and fill the rectangle
    drawCheckmark(pdf, x, y + 2); // Draw the checkmark on top
  }

  // Loop through clients and add their data
  this.clients.forEach((client, index) => {
    let offset = index * 160 + 80; // Adjust offset for each client's data

    // Add client details with margins and underline
    pdf.text('Name:', 20, offset);
    pdf.text(String(client.first_name) + ' ' + String(client.middle_name) + ' ' + String(client.last_name), 35, offset);
    pdf.line(35, offset + 1, 95, offset + 1); // Draw underline for name

    pdf.text('Sex:', 100, offset);
    pdf.text(String(client.sex), 110, offset);
    pdf.line(110, offset + 1, 140, offset + 1); // Draw underline for sex

    pdf.text('Religion:', 145, offset);
    pdf.text(String(client.religion), 162, offset);
    pdf.line(162, offset + 1, 200, offset + 1); // Draw underline for religion

    // Handle address with text wrapping
    pdf.text('Address:', 20, offset + 10);
    const addressText = String(client.province) + ', ' + String(client.city) + ', ' + String(client.barangay) + ', ' + String(client.street);
    const wrappedAddress = pdf.splitTextToSize(addressText, 150); // 150mm width for wrapping

    wrappedAddress.forEach((line, i) => {
        const lineX = i === 0 ? 40 : 20; // First line starts at 40, subsequent lines at 20
        const lineY = offset + 10 + i * 8; // 5mm height per line
        pdf.text(line, lineX, lineY); // Print the wrapped line
        pdf.line(lineX, lineY + 1, 200, lineY + 1); // Draw the underline for each line
    });

    const addressHeight = wrappedAddress.length * 5; // Adjust height based on number of lines (5mm per line)
    offset += addressHeight + 6; // Adjust offset to account for wrapped text


    pdf.text('Date/Place of Birth:', 20, offset + 10);
    pdf.text(String(client.date_of_birth) + ' / ' + String(client.place_of_birth), 58, offset + 10);
    pdf.line(58, offset + 11, 200, offset + 11); // Draw underline for birth details

    pdf.text('Committing Court:', 20, offset + 20);
    pdf.text(String(client.admissions[0]?.committing_court), 56, offset + 20);
    pdf.line(56, offset + 21, 110, offset + 21); // Draw underline for committing court

    pdf.text('Crim. Case #:', 115, offset + 20);
    pdf.text(String(client.admissions[0]?.crim_case_number), 143, offset + 20);
    pdf.line(143, offset + 21, 200, offset + 21); // Draw underline for criminal case number

    pdf.text('Offense Committed:', 20, offset + 30);
    pdf.text(String(client.admissions[0]?.offense_committed), 58, offset + 30);
    pdf.line(58, offset + 31, 110, offset + 31); // Draw underline for offense

    pdf.text('Date admitted to Center:', 115, offset + 30);
    pdf.text(String(client.admissions[0]?.date_admitted), 160, offset + 30);
    pdf.line(160, offset + 31, 200, offset + 31); // Draw underline for date admitted

    pdf.text('No. of Days in Jail:', 20, offset + 40);
    pdf.text(String(client.admissions[0]?.days_in_jail), 57, offset + 40);
    pdf.line(57, offset + 41, 110, offset + 41); // Draw underline for days in jail

    pdf.text('No. of Days in Detention Center:', 115, offset + 40);
    pdf.text(String(client.admissions[0]?.days_in_detention_center), 175, offset + 40);
    pdf.line(175, offset + 41, 200, offset + 41); // Draw underline for days in detention center

    pdf.setFont('helvetica', 'bold');
    pdf.text('Distinguishing Marks:', 20, offset + 50);
    pdf.setFont('helvetica', 'normal');

    pdf.text('a. Tattoo/Scars:', 20, offset + 60);
    pdf.text(String(client.admissions[0]?.distinguishing_marks[0]?.tattoo_scars), 51, offset + 60);
    pdf.line(51, offset + 61, 110, offset + 61); // Draw underline for tattoo/scars

    pdf.text('b. Height:', 115, offset + 60);
    pdf.text(String(client.admissions[0]?.distinguishing_marks[0]?.height), 138, offset + 60);
    pdf.line(138, offset + 61, 200, offset + 61); // Draw underline for height

    pdf.text('c. Weight:', 20, offset + 70);
    pdf.text(String(client.admissions[0]?.distinguishing_marks[0]?.weight), 40, offset + 70);
    pdf.line(40, offset + 71, 110, offset + 71); // Draw underline for weight

    pdf.text('d. Colour of Eye:', 115, offset + 70);
    pdf.text(String(client.admissions[0]?.distinguishing_marks[0]?.colour_of_eye), 150, offset + 70);
    pdf.line(150, offset + 71, 200, offset + 71); // Draw underline for eye color

    pdf.text('e. Skin:', 20, offset + 80);
    pdf.text(String(client.admissions[0]?.distinguishing_marks[0]?.skin_colour), 36, offset + 80);
    pdf.line(36, offset + 81, 110, offset + 81); // Draw underline for skin color

    // Add the "Put on Documents Submitted" section with checkboxes
    pdf.setFont('helvetica', 'bold');
    pdf.text('Put on Documents Submitted:', 20, offset + 90);
    pdf.setFont('helvetica', 'normal');

    const documents = [
      { label: 'SCSR', checked: client.admissions[0]?.documents[0]?.submitted },
      { label: 'Court Order', checked: client.admissions[0]?.documents[1]?.submitted },
      { label: 'Medical Certificates', checked: client.admissions[0]?.documents[2]?.submitted },
      { label: 'Consent from Parents', checked: client.admissions[0]?.documents[3]?.submitted },
      { label: 'School Records', checked: client.admissions[0]?.documents[4]?.submitted },
      { label: 'Others', checked: client.admissions[0]?.documents[5]?.submitted },
    ];

    documents.forEach((doc, i) => {
      const x = i < 3 ? 20 + i * 70 : 20 + (i - 3) * 70;
      const y = i < 3 ? offset + 96 : offset + 106;
      pdf.rect(x, y, 4, 4);
      pdf.text(doc.label, x + 8, y + 4);
      if (doc.checked) fillCheckboxWithCheck(pdf, x, y);
    });

    pdf.setFont('helvetica', 'bold');
    pdf.text('General impression upon admission:', 20, offset + 120);
    pdf.setFont('helvetica', 'normal');
    pdf.text(String(client.admissions[0]?.general_impression || ''), 20, offset + 130, { maxWidth: 170 });
    pdf.line(20, offset + 131, 200, offset + 131); // Draw underline for general impression

    pdf.setFont('helvetica', 'bold');
    pdf.text('Action Taken:', 20, offset + 140);
    pdf.setFont('helvetica', 'normal');
    pdf.text(String(client.admissions[0]?.action_taken || ''), 20, offset + 150, { maxWidth: 170 });
    pdf.line(20, offset + 151, 200, offset + 151); // Draw underline for action taken

    if (index < this.clients.length - 1) {
      pdf.addPage(); // Add a new page for the next client if more clients exist
    }
  });

  let offset = 253; // Assuming we are continuing from a previous offset

  // Name & Signature of Referring Party / Admitting Officer
  pdf.line(20, offset, 85, offset);
  pdf.text('Name & Signature of Referring Party', 20, offset + 4);
  pdf.line(130, offset, 200, offset);
  pdf.text('Admitting Officer', 130, offset + 4);

  offset += 10;

  // Designation / ID No. / Contact # / Designation
  pdf.line(20, offset, 85, offset);
  pdf.text('Designation / ID No. / Contact #', 20, offset + 4);
  pdf.line(130, offset, 200, offset);
  pdf.text('Designation', 130, offset + 4);

  offset += 10;

  // Complete Address/Office Address / Date/Time
  pdf.line(20, offset, 85, offset);
  pdf.text('Complete Address/Office Address', 20, offset + 4);
  pdf.line(130, offset, 200, offset);
  pdf.text('Date/Time', 130, offset + 4);

  offset += 20;

  // Noted By section
  pdf.setFontSize(11);
  pdf.text('Noted By:', 108, offset - 5, null, null, 'center');
  pdf.setFont('helvetica', 'bold');
  pdf.text('ANGELIC B. PAÑA, RSW, MSSW', 108, offset + 6, null, null, 'center');
  pdf.line(78, offset + 7, 140, offset + 7);
  pdf.text('Center Head/SWO IV', 108, offset + 12, null, null, 'center');

  offset += 30;

  // Footer
  pdf.setFont('TimesNewRoman', 'bold');
  pdf.setFontSize(9);
  pdf.text(`PAGE 1 of 1`, 108, offset + 8, null, null, 'center');
  pdf.setLineWidth(0.5);
  pdf.line(18, offset + 10, 174, offset + 10); // Horizontal line

  // Footer content for the first page
  pdf.setFont('TimesNewRoman', 'normal');
  pdf.setFontSize(9);
  pdf.text('DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Prk. 7 Bago-Oshiro, Tugbok Dist., Davao City', 96, offset + 15, null, null, 'center');
  pdf.text('Email: rrcy.fo11@dswd.gov.ph    Tel. No.: 293-0306', 108, offset + 20, null, null, 'center');

  // Add the footer image
  const footerImgData = '/images/footerimg.png'; // Make sure the image is correctly loaded
  pdf.addImage(footerImgData, 'PNG', 175, offset + 5, 25, 15); // Adjust the position and size as needed

  // Save the PDF
  pdf.save(`admission-slip-${this.id}.pdf`);
}


  },
};



</script>

<style scoped>
/* Adjust spacing and underline input */
.underline-input {
  border: none;
  border-bottom:  1px solid black;
  padding: 0;
  width: 100%;
  margin-bottom: 14px;
  line-height: 0;
  box-sizing: border-box;
  vertical-align: bottom; /* Ensures the text aligns with the bottom of the input */
  font-size: inherit; /* Ensure consistent font size */
}
.underline-input1 {
  border: none;
  border-bottom:  1px solid black;
  padding: 0;
  margin-bottom: 14px;
  line-height: 0;
  box-sizing: border-box;
  vertical-align: bottom; /* Ensures the text aligns with the bottom of the input */
  font-size: inherit; /* Ensure consistent font size */
}



/* Ensure the form fits within Legal size dimensions for printing */
@media print {
  .max-w-7xl {
    max-width: 216mm;
  }
  .p-8 {
    padding: 100mm;
  }
  .mr-4, .mb-12, .mb-8, .mb-6, .mb-4, .mb-2 {
    margin-bottom: 20mm;
  }
  .border-t {
    border-top: 1px solid #d2d2d2;
  }
}
</style>"