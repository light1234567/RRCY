<template>

  <div>
<!-- Tabs for Actions -->
<div v-if="editMode" class="flex absolute p-4 space-x-4">
    <button @click="cancelEdit" class="flex space-x-2 px-3 py-3 bg-blue-600 text-white rounded-md text-xs">
      <!-- FontAwesome for Back -->
      <i class=" fas fa-arrow-left w-4 h-4"></i>
      <span>Cancel</span>
    </button>
</div>

<div class="flex -ml-2 justify-end bg-transparent border -mr-9 border-gray-300 p-4 space-x-4 -mt-9">
    <!-- Pagination Component -->
    <Pagination 
      :totalPages="totalPages" 
      :currentPage="currentPage" 
      @update:currentPage="currentPage = $event" 
    />

  <button v-if="!editMode" @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
    <!-- FontAwesome for Edit -->
    <i class="fas fa-edit w-4 h-4"></i>
    <span>Edit</span>
  </button>

    <button v-if="editMode" @click="saveForm" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
      <!-- FontAwesome for Save -->
      <i class="fas fa-check w-4 h-4"></i>
      <span>Save</span>
    </button>

    <!-- Download PDF Button -->
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
    <form ref="AdmissionForm" @submit.prevent="saveForm">
     <!-- Form Content -->
  <div class="graph-background pt-0.5  -mr-9 -mb-16">
    <div>
    <div ref="pdfContent" class="max-w-3xl border-gray-400 p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border ">
      <div class=" relative flex justify-between items-center mb-2">
        <img src="/images/headerlogo2.png" alt="Logo" class=" h-32 w-64 relative z-10">
        <p class="text-[12px] text-right -mt-10" style="font-family: 'Times New Roman', Times, serif; font-style: italic;">DSWD-GF-010A | REV 00 | 22 SEP 2023
        </p>

      </div>

      <h1 class="text-[21.33px] font-bold mb-2 text-center text-black">ADMISSION SLIP</h1>

      <div v-if="clients.length > 0" v-for="client in clients" :key="client.id" class="mb-12 p-1.5 rounded-lg text-xs">
        <div class="flex items-center">
          <div class="flex-grow text-[15px] flex items-center mr-2">
  <label class="mb-3 text-black mr-2 flex items-center h-full">Name:</label>
  <!-- When not in edit mode, show the concatenated value -->
  <template v-if="!editMode">
    <input type="text" class="underline-input w-full" :value="client.first_name + ' ' + client.middle_name + ' ' + client.last_name" readonly>
  </template>

  <!-- When in edit mode, show the separate fields for first, middle, and last name -->
  <template v-else>
    <input 
  type="text" 
  class="underline-input w-1/3 mr-1" 
  v-model="client.first_name" 
  placeholder="First Name" 
  @input="(e) => { client.first_name = removeNumbers(e.target.value); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide a valid first name.'); }" 
  required 
/>
<input 
  type="text" 
  class="underline-input w-1/3 mr-1" 
  v-model="client.middle_name" 
  placeholder="Middle Name" 
  @input="(e) => { client.middle_name = removeNumbers(e.target.value); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide a valid middle name.'); }" 
  required
/>
<input 
  type="text" 
  class="underline-input w-1/3" 
  v-model="client.last_name" 
  placeholder="Last Name" 
  @input="(e) => { client.last_name = removeNumbers(e.target.value); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide a valid last name.'); }" 
  required 
/>
  </template>
</div>

<div class="flex text-[15px] items-center w-1/4">
          <label class="mb-3 text-black mr-2">Sex:</label>
          <input type="text" class="underline-input bg-transparent mt-1 w-full" v-model="client.sex" :readonly="!editMode" @input="client.sex = removeNumbers(client.sex)" required>
        </div>
        <div class="flex text-[15px] items-center w-1/4">
          <label class="mb-3 text-black mr-2">Religion:</label>
          <input type="text" class="underline-input bg-transparent mt-1 w-full" v-model="client.religion" :readonly="!editMode"  @input="client.religion = removeNumbers(client.religion)" required>
        </div>
        </div>

        <div class="flex items-center">
          <div class="flex-grow flex text-[15px] items-center mr-2">
  <label class="mb-3 block text-black mr-2">Address:</label>
  
  <template v-if="!editMode">
    <input type="text" class="underline-input w-full" :value="client.province + ', ' + client.city + ', ' + client.barangay + ', ' + client.street" readonly>
  </template>
  
  <template v-else>
    <input type="text" class="underline-input w-1/4 mr-1" v-model="client.province" placeholder="Province"  @input="client.province = removeNumbers(client.province)" required>
    <input type="text" class="underline-input w-1/4 mr-1" v-model="client.city" placeholder="City" @input="client.city = removeNumbers(client.city)" required>
    <input type="text" class="underline-input w-1/4 mr-1" v-model="client.barangay" placeholder="Barangay" required>
    <input type="text" class="underline-input w-1/4" v-model="client.street" placeholder="Street" required>
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
    <input 
  type="date" 
  class="underline w-1/2 mr-1 text-xs" 
  v-model="client.date_of_birth" 
  placeholder="Date of Birth" 
  required 
  :max="new Date().toISOString().split('T')[0]" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide a valid date of birth up to the present year'); }" 
/>

    <input type="text" class="underline-input w-1/2 text-xs" v-model="client.place_of_birth" placeholder="Place of Birth" required>
  </template>
</div>


        <div class="grid grid-cols-2 gap-4">
          <div class="flex items-center text-[15px] ">
              <label class="mb-3    text-black mr-2 whitespace-nowrap">Committing Court:</label>
              <input type="text" class="underline-input bg-transparent text-xs w-full" v-model="client.admissions[0].committing_court" :readonly="!editMode" required>
          </div>
          <div class="text-[15px] flex items-center">
            <label class="mb-3 block    text-black ml-2  mr-2 whitespace-nowrap">Crim. Case #:</label>
            <input type="text" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs" v-model="client.admissions[0].crim_case_number" :readonly="!editMode" required
>            </div>
        </div>

        <div class="flex items-center">
       
        <!-- Date Admitted Section -->
        <div class="text-[15px] flex items-center w-1/2">
  <label class="mb-3 text-black mr-2 whitespace-nowrap ">Date admitted to Center:</label>
  
  <!-- Show the date admitted in a readonly input when not in edit mode -->
  <template v-if="!editMode">
    <input type="text" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs" :value="client.admissions[0]?.date_admitted" readonly>
  </template>
  
  <!-- Show a date picker input field when in edit mode -->
  <template v-else>
    <input type="date" class="underline w-full text-xs" v-model="client.admissions[0].date_admitted" placeholder="Date Admitted" required>
  </template>
</div>

 <!-- Offense Committed Section -->
 <div class="text-[15px] flex items-center w-1/2">
          <label class="mb-3    text-black mr-2 whitespace-nowrap ml-4">Offense Committed:</label>
          <input type="text" v-model="client.admissions[0].offense_committed" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs":readonly="!editMode"required
/>
        </div>

      </div>

        <div class="flex items-center">
            <div class="flex items-center text-[15px] w-1/2">
            <label class="mb-3 block text-black whitespace-nowrap mr-2">No. of Days in Jail:</label>
            <input type="number" v-model.number="client.admissions[0].days_in_jail" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs" :readonly="!editMode" min="0" required
/>
          </div>
          <div class="flex items-center text-[15px] w-1/2">
            <label class="mb-3 block    text-black ml-4 whitespace-nowrap mr-2">No. of Days in Detention Center:</label>
            <input type="number" class="underline-input w-1/4 bg-transparent mt-1  mb-6 flex-grow text-xs" v-model="client.admissions[0].days_in_detention_center" :readonly="!editMode" min="0" required>
          </div>
        </div>
        <div class="mb-2">
          <label class="mt-2 text-[15px] mb-4 block font-bold text-black">DISTINGUISHING MARKS:</label>
          <div class="flex flex-wrap items-center gap-x-8">
            <!-- Tattoo/Scars -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3 block text-black mr-2">a.Tattoo/Scars:</label>
              <input type="text" v-model="client.admissions[0].distinguishing_marks[0].tattoo_scars" class="underline-input bg-transparent flex-grow text-xs w-[100px]" :readonly="!editMode" required
/>
            </div>

            <!-- Height -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3 block    text-black mr-2">b.Height:</label>
              <input type="number" v-model="client.admissions[0].distinguishing_marks[0].height" class="underline-input bg-transparent flex-grow text-xs w-[100px]" :readonly="!editMode" required
/>
            </div>

            <!-- Weight -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3 block    text-black mr-2">c. Weight:</label>
              <div v-if="client.admissions[0]?.distinguishing_marks?.[0]">
<input type="number" class="underline-input1 bg-transparent flex-grow text-xs w-[100px]" v-model="client.admissions[0].distinguishing_marks[0].weight" :readonly="!editMode" required
/>
</div>
            </div>

            <!-- Colour of Eye -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3    text-black mr-2">d. Colour of Eye:</label>
              <div v-if="client.admissions[0]?.distinguishing_marks?.[0]">
<input type="text" class="underline-input1 bg-transparent flex-grow text-xs w-[100px]" v-model="client.admissions[0].distinguishing_marks[0].colour_of_eye" :readonly="!editMode" required
/>
</div>
            </div>

            <!-- Skin -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3    text-black mr-2">e. Skin:</label>
              <div v-if="client.admissions[0]?.distinguishing_marks?.[0]">
<input type="text" class="underline-input1 bg-transparent flex-grow text-xs w-[100px]" v-model="client.admissions[0].distinguishing_marks[0].skin_colour" :readonly="!editMode" required
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
      
      <!-- First Row: 3 items -->
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

      <!-- Second Row: 3 items -->
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

      <!-- Others Checkbox -->
      <label class="block font-semibold text-gray-700 flex items-center">
        <input 
          type="checkbox" 
          class="mr-2" 
          :checked="isDocumentSubmitted(client, 'Others')" 
          @change="toggleDocument(client, 'Others')" 
          :disabled="!editMode"
        > Others
      </label>

      <!-- Conditional Header for Other Documents Submitted -->
      <div class="col-span-3" v-if="getOthersDocument(client) || (othersDocumentName && editMode)">
        <label class="-ml-4 text-[15px] font-semibold text-black">Other Documents Submitted:</label>
      </div>

      <!-- Third Row: Only input field for "Others" -->
      <div class="col-span-3">
        <!-- Show input for "Others" if it's checked -->
        <input 
          v-if="isDocumentSubmitted(client, 'Others') && editMode" 
          type="text" 
          v-model="othersDocumentName" 
          placeholder="Specify Others" 
          class="ml-2 underline-input bg-transparent flex-grow text-xs w-full"
          @input="handleOtherDocument(client, othersDocumentName)" 
        >
  
        <!-- Display the "Others" document name if it exists and not in edit mode -->
        <span v-if="getOthersDocument(client) && !editMode" class="underline ml-2">
          1. {{ getOthersDocument(client) }}
        </span>
      </div>

    </div>
  </div>
</div>






<div class="text-[15px] mb-4">
  <label class="block font-semibold mb-2 text-black">General impression upon admission:</label>
  <textarea 
  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-[15px] leading-relaxed" 
  style="line-height: 1.5;" 
  v-model="client.admissions[0].general_impression" 
  :readonly="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide a general impression for this field'); }" 
  required>
</textarea>

</div>

<div class="text-[15px] mb-4">
  <label class="block font-semibold mb-2 text-black">Action Taken:</label>
  <textarea 
  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-[15px] leading-relaxed" 
  style="line-height: 1.5;" 
  v-model="client.admissions[0].action_taken" 
  :readonly="!editMode" 
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide action taken for this field'); }" 
  required>
</textarea>

</div>

<div class="grid grid-cols-2 gap-4 mb-4">

          
  <!-- Referring Party Section -->
  <div class="flex flex-col justify-end text-[15px] mb-4">
<!-- Display the current signature image if it exists or show a preview of the new uploaded image -->
<div v-if="client.admissions[0]?.referring_party_signature || editMode" class="mb-4">
  <label class="block mb-2 text-sm text-[15px] text-gray-700">
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
  :readonly="!editMode" required
>

<label class="block text-[15px] text-black -mt-3">Name & Signature of Referring Party</label>
</div>



  <!-- Admitting Officer Section -->
  <div class="flex flex-col justify-end text-[15px] mb-4">
  <input 
    type="text" 
    class="underline-input mt-1 w-full " 
    v-model="client.admissions[0].admitting_officer" 
    :readonly="!editMode"
    @input="client.admissions[0].admitting_officer = removeNumbers(client.admissions[0].admitting_officer)" required

  >
  <label class="block text-[15px] text-black -mt-3">Admitting Officer</label>
</div>
</div>

<div class="grid grid-cols-2 gap-4 text-[15px] mb-4">
  <div>
    <input 
      type="text" 
      class="underline-input mt-1 w-full text-[15px]" 
      v-model="client.admissions[0].designation_id_contact" 
      :readonly="!editMode"
    >
    <label class="block  text-[15px] text-black -mt-3">Designation / ID No. / Contact #</label>
  </div>
  <div>
    <input 
      type="text" 
      class="underline-input mt-1 w-full text-[15px]" 
      v-model="client.admissions[0].designation" 
      :readonly="!editMode" required
    >
    <label class="block text-black text-[15px] -mt-3 mb-4">Designation</label>
  </div>
</div>

<div class="grid grid-cols-2 gap-4 text-[15px] mb-4">
  <div>
    <input 
      type="text" 
      class="underline-input mt-1 w-full text-[15px]" 
      v-model="client.admissions[0].office_address" 
      :readonly="!editMode" required
    >
    <label class="block text-black text-[15px] -mt-3">Complete Address/Office Address</label>
  </div>
  
  <div>
  <!-- When not in edit mode, show the combined Date/Time as a single read-only field -->
  <template v-if="!editMode">
    <input 
      type="text" 
      class="underline-input mt-1 w-full text-[15px]" 
      :value="formatDateTime(client.admissions[0]?.date_time)" 
      readonly required
    >
  </template>

  <!-- When in edit mode, show a single input for both date and time -->
  <template v-else>
  <input 
    type="datetime-local"  
    class="underline mt-1 w-full text-[15px]" 
    v-model="client.admissions[0].date_time"  
    placeholder="Select Date and Time"
    :max="currentDateTime"
    required
  >
</template>


  <label class="block text-black text-[15px] -mt-3">Date/Time</label>
</div>


</div>

<!-- Noted By Section -->
<div class="border-gray-300 pt-4 text-[15px] text-center  ">
  <p class="font-semibold mb-4 text-[15px]">Noted By:</p>
  <input 
    v-if="client.admissions[0]" 
    type="text" 
    class="underline-input mt-1 text-center text-[15px] font-bold"
    v-model="center_head" 
    readonly
    style="width: 240px;" 
  />
  <p class="text-[15px] -mt-3">Center Head/SWO IV</p>
</div>


      </div>
      <div v-else>
        <p>Loading data...</p>
      </div>

      <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        <div class="flex flex-col">
          <p class="ml-24 -mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
          <p class="border-t -ml-7 mt-4 whitespace-nowrap" style="border-top: 2px solid black;">
            DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City
          </p>
          <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
        </div>
        <div class="ml-4">
          <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
        </div>
      </div>
    </div>
    </div>
  </div>
</div>
</form>
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
    Pagination
  },
  name: 'ClientList',
  data() {
    return {
      currentDateTime: new Date().toLocaleString('sv-SE', { 
      timeZone: 'Asia/Manila', 
      hour12: false 
    }).replace(' ', 'T').slice(0, 16),
      clients: [],
      isSticky: false,
      admission_id: null, // Admission ID used for update logic
      center_head: '',
      editMode: false,
      isModalOpen: false,
      isSaveResultModalOpen: false,
      saveResultTitle: '',
      saveResultMessage: '',
      id: null, // Current client or admission ID
      signaturePreview: null,
      othersDocumentName: '',
      currentPage: 1,
      totalPages: 1,
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
    this.fetchCenterHead();
    window.addEventListener('scroll', this.handleScroll);
  },
  beforeDestroy() {
    // Clean up listener
    window.removeEventListener('scroll', this.handleScroll);
  },
  watch: {
    '$route.params.id': function(newId) {
      this.id = newId;
      this.fetchClientsData();
    },
  },
  methods: {

    fetchCenterHead() {
    axios.get('/api/center-head')  // Replace with the correct API route
      .then(response => {
        this.center_head = response.data.name;  // Bind the fetched name to v-model
      })
      .catch(error => {
        console.error('Error fetching center head:', error);
      });
  },
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
    handleScroll() {
      const offset = window.pageYOffset;
      const triggerHeight = 400; // Adjust this height to the point you want the tab to stick

      // Check if scroll offset is greater than the trigger height
      if (offset > triggerHeight) {
        this.isSticky = true;
      } else {
        this.isSticky = false;
      }
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

// Method to remove numbers from input
removeNumbers(input) {
  return input.replace(/[0-9]/g, '');
},
    // Update form data (for existing admissions)
    async saveForm() {
      // Access the form using the ref
      const form = this.$refs.AdmissionForm;

      // Validate the form first
      if (form.checkValidity()) {
        // If valid, open the modal
        this.isModalOpen = true;
      } else {
        // If not valid, show the validation messages
        form.reportValidity();
      }
    },
    openModal() {
      // Ensure the modal is shown
      this.isModalOpen = true;
    },

    closeModal() {
      // Close the modal
      this.isModalOpen = false;
    },
    async confirmSave() {
  try {
    const client = this.clients[0]; // Assuming you're using the first client in the list
    const admission = client.admissions[0]; // Assuming you're using the first admission in the list
    const admissionId = admission.id || null;
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
          this.saveResultTitle = 'Success';
          this.saveResultMessage = 'Form saved successfully.';
        } else {
          throw new Error('Unexpected response');
        }
      } catch (error) {
        console.error("Error saving form:", error);
        this.saveResultTitle = 'Error';
        this.saveResultMessage = 'An error occurred while saving.';
      } finally {
        this.isModalOpen = false;
        this.isSaveResultModalOpen = true;
      }
    },

    closeSaveResultModal() {
      this.isSaveResultModalOpen = false;
      this.editMode = false;
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

 // Helper function to format date and time
 function formatDateTime(dateTime) {
    if (!dateTime) return ' ';
    
    const date = new Date(dateTime);
    const options = {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
      hour12: true
    };
    
    return date.toLocaleString('en-US', options);
  }

// Add and set Times New Roman font
pdf.addFont('times-normal.ttf', 'TimesNewRoman', 'italic'); 
pdf.setFont('TimesNewRoman', 'italic'); 

// Set default font properties
pdf.setFontSize(11);
pdf.setLineHeightFactor(1.5);

const imgData = '/images/headerlogo2.png'; 
pdf.addImage(imgData, 'PNG', 15, 10, 75, 35); 

// Add the header below the image
pdf.setFontSize(8); 
pdf.setFont('italic'); 
pdf.text('DSWD-GF-010A | REV 00 | 22 SEP 2023', 152, 24);

// Load and set Arial font
pdf.addFont('arialbd-bold.ttf', 'Arial', 'bold');
pdf.setFont('Arial', 'bold');
pdf.setFontSize(18);

pdf.setTextColor(0, 0, 0); 

// Title with slight bold effect
pdf.text('ADMISSION SLIP', 108, 60, null, null, 'center');

pdf.setFont('Arial', 'normal'); 
pdf.setFontSize(11); 

// Function to draw a custom checkmark inside the checkbox
function drawCheckmark(pdf, x, y) {
  // Save the current draw color to restore later
  const currentDrawColor = pdf.getDrawColor();

  // Set the checkmark color to white
  pdf.setDrawColor(255, 255, 255); // White color for checkmark
  pdf.setLineWidth(0.2); // Set line width for checkmark

  // Draw the checkmark
  pdf.line(x + 0.5, y , x + 1.5, y + 1.5); // First part of the checkmark (lower left to center)
  pdf.line(x + 1.5, y + 1.5, x + 3.5, y - 1.5); // Second part of the checkmark (center to upper right)

  // Restore the original draw color for proceeding elements
  pdf.setDrawColor(currentDrawColor);
}

// Function to add footer for the first page
function addFirstPageFooter(pdf, pageNumber, totalPages) {
  const footerYPosition = 326; // Adjust position as needed

  // Set font to a built-in font like Times or Helvetica
  pdf.setFont('Times', 'bold');
  pdf.setFontSize(9);
  
  // Centered page number text
  pdf.text(`PAGE ${pageNumber} of ${totalPages}`, 108, footerYPosition + 2, null, null, 'center');
  
  // Add horizontal line for separation
  pdf.setLineWidth(0.5);
  pdf.line(18, footerYPosition + 5, 174, footerYPosition + 5); // Horizontal line across the page

  // Footer content for the first page
  pdf.setFont('Times', 'normal');
  pdf.setFontSize(9);

 // Footer content for the first page
 pdf.setFont('TimesNewRoman', 'normal');
  pdf.setFontSize(9);
  pdf.text('DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Prk. 7 Bago-Oshiro, Tugbok Dist., Davao City', 96,footerYPosition + 10, null, null, 'center');
  pdf.text('Email: rrcy.fo11@dswd.gov.ph    Tel. No.: 293-0306', 108, footerYPosition + 15, null, null, 'center');

  // Add the footer image
  const footerImgData = '/images/footerimg.png'; // Make sure the image is correctly loaded
  pdf.addImage(footerImgData, 'PNG', 175, footerYPosition, 25, 15); // Adjust the position and size as needed
}


// Function to add footer for other pages
function addOtherPagesFooter(pdf, pageNumber, totalPages) {
  const footerYPosition = 326; // Adjust position as needed

  // Simple footer for other pages
  pdf.setFont('TimesNewRoman', 'bold');
  pdf.setFontSize(9);
  pdf.text(`PAGE ${pageNumber} of ${totalPages}`, 108, footerYPosition + 2, null, null, 'center');
  pdf.setLineWidth(0.5);
  pdf.line(18, footerYPosition + 5, 198, footerYPosition + 5);

  // Simple footer text for other pages
  pdf.setFont('TimesNewRoman', 'normal');
  pdf.setFontSize(9);
  pdf.text('DSWD | FIELD OFFICE XI | ADMINISTRATIVE DIVISION', 108, footerYPosition + 10, null, null, 'center');
}
// Function to apply footers dynamically based on page number
// Function to apply footers dynamically based on page number
function addFooters(pdf) {
  const totalPages = pdf.internal.getNumberOfPages(); // Get the total number of pages after all content is added

  for (let i = 1; i <= totalPages; i++) {
    pdf.setPage(i); // Set the correct page for adding footer

    if (i === 1) {
      addFirstPageFooter(pdf, i, totalPages); // First page footer
    } else {
      addOtherPagesFooter(pdf, i, totalPages); // Footer for other pages
    }
  }
}

function checkAndAddPageIfNeeded(pdf, currentOffset) {
  const safeAreaHeight = 320; // Content area height excluding footer
  if (currentOffset >= safeAreaHeight) {
    addFooters(pdf); // Add footer to the current page before moving to the next
    pdf.addPage();
    
    // Re-add the page-specific headers after a new page is added
    pdf.setFontSize(8); 
    pdf.addFont('times-normal.ttf', 'TimesNewRoman', 'italic'); 
    pdf.setFont('TimesNewRoman', 'italic'); 
    pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 149, 20); 
    
    pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
    pdf.setFont('Arial', 'normal'); 
    pdf.setFontSize(11);
    
    return 35; // Reset the Y position for the new page
  }
  return currentOffset;
}

// Function to fill the checkbox with blue and draw the checkmark
function fillCheckboxWithCheck(pdf, x, y) {
  // Set the fill color to blue
  pdf.setFillColor(0, 102, 255); // Blue background color
  
  // Draw the filled rectangle (checkbox)
  pdf.rect(x, y, 4, 4, 'F'); // 'F' mode for fill only
  
  // Draw the white checkmark inside the checkbox
  drawCheckmark(pdf, x, y + 2); // Adjust y position for the checkmark
}

  // Loop through clients and add their data
  this.clients.forEach((client, index) => {
    let offset = index * 160 + 80;

    // Client Details
    pdf.text('Name:', 20, offset);
    pdf.text(`${client.first_name} ${client.middle_name} ${client.last_name}`, 35, offset);
    pdf.line(35, offset + 1, 95, offset + 1);

    pdf.text('Sex:', 100, offset);
    pdf.text(String(client.sex), 110, offset);
    pdf.line(110, offset + 1, 140, offset + 1);

    pdf.text('Religion:', 145, offset);
    pdf.text(String(client.religion), 162, offset);
    pdf.line(162, offset + 1, 200, offset + 1);

    // Function to justify the text
    function justifyLine(pdf, text, x, y, maxWidth) {
      const words = text.split(' ');
      if (words.length === 1) {
        pdf.text(text, x, y); // No justification needed for single-word lines
        return;
      }

      // Calculate total width of the text without extra spacing
      const totalTextWidth = pdf.getStringUnitWidth(text) * pdf.internal.getFontSize() / pdf.internal.scaleFactor;

      // Calculate the space remaining to justify the text
      const spaceWidth = (maxWidth - totalTextWidth) / (words.length - 1);

      let currentX = x;

      // Draw each word with extra spacing between
      words.forEach((word, index) => {
        pdf.text(word, currentX, y);
        if (index < words.length - 1) {
          currentX += pdf.getStringUnitWidth(word) * pdf.internal.getFontSize() / pdf.internal.scaleFactor + spaceWidth;
        }
      });
    }

    // Handle Address Wrapping with conditional justification
    pdf.text('Address:', 20, offset + 10);
    const addressText = `${client.province}, ${client.city}, ${client.barangay}, ${client.street}`;
    const wrappedAddress = pdf.splitTextToSize(addressText, 150);

    wrappedAddress.forEach((line, i) => {
      const lineX = i === 0 ? 40 : 20; // First line starts at 40, subsequent lines at 20
      const lineY = offset + 10 + i * 8; // Line height is 8mm

      if (i < wrappedAddress.length - 1) {
        // Justify all lines except the last one
        justifyLine(pdf, line, lineX, lineY, 150);
      } else {
        // Last line should not be justified
        pdf.text(line, lineX, lineY);
      }

      // Draw the underline for each line
      pdf.line(lineX, lineY + 1, 200, lineY + 1);
    });

    const addressHeight = wrappedAddress.length * 9; // Adjust height based on number of lines (8mm per line)
    offset += addressHeight + 1; // Adjust offset for the following content

    // Date of Birth and Place
    pdf.text('Date/Place of Birth:', 20, offset + 10);
    pdf.text(`${client.date_of_birth} / ${client.place_of_birth}`, 58, offset + 10);
    pdf.line(58, offset + 11, 200, offset + 11);

    // Committing Court and Case Info
    offset += 20;
    pdf.text('Committing Court:', 20, offset);
    pdf.text(`${client.admissions[0]?.committing_court}`, 56, offset);
    pdf.line(56, offset + 1, 110, offset + 1);

    pdf.text('Crim. Case #:', 115, offset);
    pdf.text(`${client.admissions[0]?.crim_case_number}`, 143, offset);
    pdf.line(143, offset + 1, 200, offset + 1);

// Date Admitted Section (switched to the left)
offset += 10;
pdf.text('Date admitted to Center:', 20, offset);
pdf.text(`${client.admissions[0]?.date_admitted}`, 64, offset);
pdf.line(64, offset + 1, 110, offset + 1);

// Dynamic Offense Committed Section (switched to the right)
pdf.text('Offense Committed:', 115, offset);
const offenseCommitted = `${client.admissions[0]?.offense_committed || ''}`;

// Define the available widths for each row
const firstLineMaxWidth = 48; // Available width for the first line (from x = 152 to x = 200)
const fullLineMaxWidth = 180; // Available width for the subsequent lines (from x = 20 to x = 200)

// Split the text for the "Offense Committed" field, limiting the first line to 48mm width
const firstLineOffense = pdf.splitTextToSize(offenseCommitted, firstLineMaxWidth);

// Check if the text fits on one line or requires wrapping
if (firstLineOffense.length === 1) {
    // If only one line is required, draw it on the same row
    pdf.text(firstLineOffense[0], 152, offset);
    pdf.line(152, offset + 1, 200, offset + 1); // Underline for the first line
    // Keep the offset as is (single line case), no extra spacing added
} else {
    // If the text wraps to a second line, draw the first part at x = 152 and wrap the rest on the next line
    const remainingOffenseText = offenseCommitted.substring(firstLineOffense[0].length).trim();
    pdf.text(firstLineOffense[0], 152, offset);
    pdf.line(152, offset + 1, 200, offset + 1); // Underline for the first line

    // Wrap the rest of the text on the next line
    const wrappedRemainingOffense = pdf.splitTextToSize(remainingOffenseText, fullLineMaxWidth);

    wrappedRemainingOffense.forEach((line, index) => {
        const lineY = offset + (index + 1) * 7; // Adjust line height dynamically for subsequent lines
        pdf.text(line, 20, lineY); // Start each line at x = 20
        pdf.line(20, lineY + 1, 200, lineY + 1); // Underline from x = 20 to x = 200 to match full width
    });

    // Adjust the offset based on the number of wrapped lines
    offset += (wrappedRemainingOffense.length * 7);
}


    // Days in Jail and Detention Center
    offset += 10;
    pdf.text('No. of Days in Jail:', 20, offset);
    pdf.text(String(client.admissions[0]?.days_in_jail), 57, offset);
    pdf.line(57, offset + 1, 110, offset + 1);

    pdf.text('No. of Days in Detention Center:', 115, offset);
    pdf.text(String(client.admissions[0]?.days_in_detention_center), 175, offset);
    pdf.line(175, offset + 1, 200, offset + 1);

    // Distinguishing Marks
    offset += 10;
    pdf.setFont('helvetica', 'bold');
    pdf.text('Distinguishing Marks:', 20, offset);
    pdf.setFont('helvetica', 'normal');

    pdf.text('a. Tattoo/Scars:', 20, offset + 10);
    pdf.text(`${client.admissions[0]?.distinguishing_marks[0]?.tattoo_scars}`, 51, offset + 10);
    pdf.line(51, offset + 11, 110, offset + 11);

    pdf.text('b. Height:', 115, offset + 10);
    pdf.text(`${client.admissions[0]?.distinguishing_marks[0]?.height}`, 138, offset + 10);
    pdf.line(138, offset + 11, 200, offset + 11);

    pdf.text('c. Weight:', 20, offset + 20);
    pdf.text(`${client.admissions[0]?.distinguishing_marks[0]?.weight}`, 40, offset + 20);
    pdf.line(40, offset + 21, 110, offset + 21);

    pdf.text('d. Colour of Eye:', 115, offset + 20);
    pdf.text(`${client.admissions[0]?.distinguishing_marks[0]?.colour_of_eye}`, 150, offset + 20);
    pdf.line(150, offset + 21, 200, offset + 21);

    pdf.text('e. Skin:', 20, offset + 30);
    pdf.text(`${client.admissions[0]?.distinguishing_marks[0]?.skin_colour}`, 36, offset + 30);
    pdf.line(36, offset + 31, 110, offset + 31);

    // Documents Submitted
    offset += 40;
    pdf.setFont('helvetica', 'bold');
    pdf.text('Put on Documents Submitted:', 20, offset);
    pdf.setFont('helvetica', 'normal');

 // Retrieve and parse documents submitted
 let documentsSubmitted = client.admissions[0]?.documents[0]?.document_name;
    let documentNames = [];

    if (typeof documentsSubmitted === 'string') {
      try {
        documentNames = JSON.parse(documentsSubmitted);
      } catch (e) {
        console.error("Error parsing document_name:", e);
        documentNames = [];
      }
    }

   // Existing code for rendering documents checkboxes
pdf.rect(20, offset + 4, 4, 4);
pdf.text(`SCSR`, 28, offset + 7.5);
if (documentNames.includes('SCSR')) {
  fillCheckboxWithCheck(pdf, 20, offset + 4);
}

pdf.rect(90, offset + 4, 4, 4);
pdf.text(`Court Order`, 98, offset + 7.5);
if (documentNames.includes('Court Order')) {
  fillCheckboxWithCheck(pdf, 90, offset + 4);
}

pdf.rect(157, offset + 4, 4, 4);
pdf.text(`Medical Certificates`, 165, offset + 7.5);
if (documentNames.includes('Medical Certificates')) {
  fillCheckboxWithCheck(pdf, 157, offset + 4);
}

pdf.rect(20, offset + 12, 4, 4);
pdf.text(`Consent from Parents`, 28, offset + 15.5);
if (documentNames.includes('Consent from Parents')) {
  fillCheckboxWithCheck(pdf, 20, offset + 12);
}

pdf.rect(90, offset + 12, 4, 4);
pdf.text(`School Records`, 98, offset + 15.5);
if (documentNames.includes('School Records')) {
  fillCheckboxWithCheck(pdf, 90, offset + 12);
}

// Checkbox for "Others"
pdf.rect(157, offset + 12, 4, 4);
pdf.text(`Others`, 165, offset + 15.5);

// Check if "Others" is selected and adjust layout accordingly
const othersDocument = documentNames.find(doc => !this.knownDocuments().includes(doc));

if (othersDocument) {
  // Fill the checkbox for "Others"
  fillCheckboxWithCheck(pdf, 157, offset + 12);
  
  // Move to the next line to display "Other Documents Submitted" section
  offset += 16; // Add space below checkboxes
  pdf.setFont('helvetica', 'bold');
  pdf.text('Other Documents Submitted:', 20, offset + 8); // Header for other documents
  
// Display the actual name of the other document(s)
offset += 8;
pdf.setFont('helvetica', 'normal');

// Split text into multiple lines if it's too long
const wrappedText = pdf.splitTextToSize(`1. ${othersDocument}`, 180); // Adjust the width (170) as needed

// Render each line of the wrapped text
wrappedText.forEach((line, i) => {
    pdf.text(line, 20, offset + 8 + (i * 6)); // Each line moves down by 6 units
    
    // Add underline for each line
    const textWidth = pdf.getStringUnitWidth(line) * pdf.internal.getFontSize() / pdf.internal.scaleFactor;
    pdf.line(20, offset + 9 + (i * 6), 20 + textWidth, offset + 9 + (i * 6)); // Underline for each line
});

// Adjust the offset to move down after rendering all lines
offset += wrappedText.length * 4;
} else {
  // No document submitted, apply the default offset
  offset += 8;
}

    // General Impression Section with Justified Text
    pdf.setFont('helvetica', 'bold');
    pdf.text('General Impression upon admission:', 20, offset + 18); // Render the title first
    pdf.setFont('helvetica', 'normal');

    // Split the text for General Impression and justify the lines except the last one
    const impressionText = pdf.splitTextToSize(client.admissions[0]?.general_impression || '', 170);
    impressionText.forEach((line, i) => {
      const lineY = offset + 28 + i * 6; // Adjust Y position dynamically based on index
      
      if (i < impressionText.length - 1) {
        // Justify all lines except the last one
        justifyLine(pdf, line, 20, lineY, 196);
      } else {
        // Last line is not justified
        pdf.text(line, 20, lineY);
      }

      // Draw underline for each line
      pdf.line(20, lineY + 1, 200, lineY + 1);
    });

    // Dynamically adjust offset based on General Impression content height
    const impressionHeight = impressionText.length * 8; // Each line takes up 8 units of space
    offset += impressionHeight + 11; // Add some extra space after the General Impression

    // Action Taken Section with Justified Text (Placed after General Impression)
    pdf.setFont('helvetica', 'bold');
    pdf.text('Action Taken:', 20, offset + 18); // Render Action Taken title after General Impression
    pdf.setFont('helvetica', 'normal');

    // Split the text for Action Taken and justify the lines except the last one
    const actionText = pdf.splitTextToSize(client.admissions[0]?.action_taken || '', 170);
    actionText.forEach((line, i) => {
      const lineY = offset + 27 + i * 6; // Adjust Y position dynamically based on index
      
      if (i < actionText.length - 1) {
        // Justify all lines except the last one
        justifyLine(pdf, line, 20, lineY, 194);
      } else {
        // Last line is not justified
        pdf.text(line, 20, lineY);
      }

      // Draw underline below the text
      pdf.line(20, lineY + 1, 200, lineY + 1);
    });

 // Dynamically adjust the offset based on the height of the Action Taken content
 const actionHeight = actionText.length * 8; // Each line takes 8 units of space
    offset += actionHeight + 35; // Add some extra space after Action Taken

    // Signature and Other Fields with Dynamic Page Break
    offset = checkAndAddPageIfNeeded(pdf, offset); // Check if signature touches the footer

    // Name & Signature of Referring Party and Admitting Officer
    pdf.text(client.admissions[0]?.referring_party_name || ' ', 20, offset);
    pdf.line(20, offset + 1, 85, offset + 1);
    pdf.text(client.admissions[0]?.admitting_officer || ' ', 130, offset);
    pdf.line(130, offset + 1, 200, offset + 1);

    pdf.text('Name & Signature of Referring Party', 20.5, offset + 5);
    pdf.text('Admitting Officer', 150, offset + 5);

    offset += 20;

    offset = checkAndAddPageIfNeeded(pdf, offset); // Check if new fields touch the footer

    // Designation / ID No. / Contact # and Designation
    pdf.text(client.admissions[0]?.designation_id_contact || ' ', 20, offset);
    pdf.line(20, offset + 1, 85, offset + 1);
    pdf.text(client.admissions[0]?.designation || ' ', 130, offset);
    pdf.line(130, offset + 1, 200, offset + 1);

    pdf.text('Designation / ID No. / Contact #', 24, offset + 5);
    pdf.text('Designation', 154, offset + 5);

    offset += 20;

    offset = checkAndAddPageIfNeeded(pdf, offset); // Check if new fields touch the footer

    // Complete Address/Office Address and Date/Time
    pdf.text(client.admissions[0]?.office_address || ' ', 20, offset);
    pdf.line(20, offset + 1, 85, offset + 1);
    pdf.text(formatDateTime(client.admissions[0]?.date_time) || ' ', 130, offset);
    pdf.line(130, offset + 1, 200, offset + 1);

    pdf.text('Complete Address/Office Address', 22, offset + 5);
    pdf.text('Date/Time', 154, offset + 5);

    offset += 20;
    // Continue adjusting offset dynamically as needed for other sections

    // Check if there's enough space for "Noted By" section
    if (offset >= 370) {
      // Add footer before creating a new page
      addFooter(pdf, offset);
      pdf.addPage();
     // Switch back to Arial normal for further content
      pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
      pdf.setFont('Arial', 'normal'); 
      pdf.setFontSize(11);
      offset = 30; // Reset offset for the new page
    }

    offset = checkAndAddPageIfNeeded(pdf, offset + 20);

    // Noted By Section
    pdf.setFontSize(11);
    pdf.text('Noted By:', 108, offset - 8, null, null, 'center');

    // Dynamic Noted By value from Vue.js input field
    pdf.setFont('helvetica', 'bold');
    pdf.text(client.admissions[0]?.center_head || 'ANGELIC B. PAÑA, RSW, MSSW', 108, offset + 6, null, null, 'center');

    // Draw underline
    pdf.line(78, offset + 7, 140, offset + 7);
    pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
    pdf.setFont('Arial', 'normal'); 
    // Static position
    pdf.text('Center Head/SWO IV', 108, offset + 12, null, null, 'center');

    // Add the footer at the bottom of the page
   
  });
  addFooters(pdf, 326); // 326 is approximately where the footer should be on a legal-sized page
  // Save the PDF
  pdf.save(`admission-slip-${this.id}.pdf`);
},
  }};

</script>

<style scoped>

.graph-background {
    background-image: linear-gradient(to right, #cccccc 1px, transparent 1px), 
                      linear-gradient(to bottom, #cccccc 1px, transparent 1px);
    background-size: 15px 15px; /* Adjust size as per your need */
  }
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