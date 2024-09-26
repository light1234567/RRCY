<template>
  <!-- Tabs for Actions -->
  <div v-if="editMode" class="flex absolute p-4 space-x-4">
      <button @click="cancelEdit" class="flex space-x-2 px-3 py-3 bg-[conic-gradient(at_bottom_right,_var(--tw-gradient-stops))] from-blue-700 via-blue-800 to-gray-900 text-white rounded-md text-xs">
        <!-- FontAwesome for Back -->
        <i class="fas fa-arrow-left w-4 h-4"></i>
        <span>Back</span>
      </button>
  </div>

  <div class="flex -ml-2 justify-end bg-transparent border -mr-9 border-gray-300 p-4 space-x-4 -mt-9">
      <!-- Pagination Component -->
      <Pagination 
        :totalPages="totalPages" 
        :currentPage="currentPage" 
        @update:currentPage="currentPage = $event" 
      />
      <button @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
        <!-- FontAwesome for Edit -->
        <i class="fas fa-edit w-4 h-4"></i>
        <span>Edit</span>
      </button>

      <button v-if="editMode" @click="openModal" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
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


   <!--- Page 1 of 4 -->
   <div class="graph-background p-0.5 -mr-9 -mb-16">

   <div ref="pdfContent" v-if="currentPage === 1" class="max-w-3xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
       <div class="">
         <div class="text-center mb-8">
           <div class="relative flex justify-between items-center mb-2">
         <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
         <p class="text-[10px] italic -mt-10">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
       </div>
       <h1 class="text-2xl font-bold">GENERAL INTAKE SHEET</h1>
       <div class="flex justify-end">
         <p>Date: <input type="date" v-model="sheet.date" class="flex-grow border-b-2 border-black border-t-0 mr-4 border-l-0 border-r-0 rounded-none shadow-sm  w-1/8 px-2 py-1" :readonly="!editMode" /></p>
       </div>
     </div>
    


     <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
       {{ message }}
     </div>
     <div class="mb-8">
      <h2 class="text-lg font-semibold">I. Identifying Information:</h2>
      <div class="space-y-2">
        <div class="flex items-center mb-4">
        
          <label class="mt-1 block text-base font-semibold text-gray-700 mr-4 whitespace-nowrap">Name of client:</label>
          <input type="text" v-model="sheet.name" class="mt-1 p-0 flex-grow border-b-2 border-black border-t-0 mr-4 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" readonly />
      </div>
  
   <div class="grid grid-cols-2 gap-4">
     <div class="flex items-center mb-4">
       <div class="flex-grow flex items-center mr-4">
         <label class="-mt-2 block text-base font-semibold text-gray-700 mr-4">Age:</label>
         <input type="text" v-model="sheet.age" class="-mt-2 p-0 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" readonly />
       </div>
     </div>
     <div class="flex items-center mb-4">
       <div class="flex-grow flex items-center mr-4">
         <label class="-mt-2 block text-base font-semibold text-gray-700 mr-4">Sex:</label>
         <input type="text" v-model="sheet.sex" class="-mt-2 p-0 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" readonly />
       </div>
     </div>
   </div>
   <div class="flex items-center mb-4">
     <div class="flex-grow flex items-center mr-4">
       <label class="-mt-2 block text-base font-semibold text-gray-700 mr-4">Address:</label>
       <input type="text" v-model="sheet.address" class="-mt-2 p-0 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" readonly />
     </div>
   </div>
   <div class="grid grid-cols-2 gap-4">
     <div class="flex items-center mb-4">
       <div class="flex-grow flex items-center mr-4">
         <label class="mt-2 block text-base font-semibold text-gray-700 mr-4 whitespace-nowrap">Date of Birth:</label>
         <input type="date" v-model="sheet.date_of_birth" class=" p-0  w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" readonly />
       </div>
     </div>
     <div class="flex items-center mb-4">
       <div class="flex-grow flex items-center mr-4">
         <label class="mt-1 block text-base font-semibold text-gray-700 mr-4 whitespace-nowrap">Place of birth:</label>
         <input type="text" v-model="sheet.place_of_birth" class=" p-0 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" readonly />
       </div>
     </div>
   </div>
   <div class="flex items-center mb-4">
     <div class="flex-grow flex items-center mr-4">
       <label class="-mt-2 block text-base font-semibold text-gray-700 mr-4">Religion:</label>
       <input type="text" v-model="sheet.religion" class="-mt-3 p-0 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" readonly />
     </div>
   </div>
   <div class="flex items-center mb-4">
     <div class="flex-grow flex items-center mr-4">
       <label class="mt-2 block text-base font-semibold text-gray-700 mr-4">Occupation:</label>
       <input type="text" v-model="sheet.occupation" class="mt-1 p-0 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" :readonly="!editMode" />
     </div>
   </div>
   <div class="flex items-center mb-4">
 <label class="mt-1 block text-base font-semibold text-gray-700 mr-4 whitespace-nowrap">Highest Educ'l Att't:</label>
 <input type="text" v-model="sheet.highest_educ_att" class="mt-2 p-0 flex-grow border-b-2 mr-4 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" :readonly="!editMode" />
</div>
 
<div class="flex items-center mb-4">
     <div class="flex-grow flex items-center mr-4">
       <label class="mt-1 block text-base font-semibold text-gray-700 mr-4 whitespace-nowrap">Name of School:</label>
       <input type="text" v-model="sheet.school_name" class="mt-1 p-0 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" :readonly="!editMode" />
     </div>
   </div>
   <div class="flex items-center mb-4">
     <div class="flex-grow flex items-center mr-4">
       <label class="mt-1 block text-base font-semibold text-gray-700 mr-4 whitespace-nowrap ">Class Adviser:</label>
       <input type="text" v-model="sheet.class_adviser" class="mt-1 p-0 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-[14px]" :readonly="!editMode" />
     </div>
   </div>
 </div>
</div>


     <div class="mb-8">
       <h2 class="text-lg font-semibold">II. Problem Presented:</h2>
       <textarea v-model="sheet.problem_presented" class="border w-full px-2 py-1" rows="4" :readonly="!editMode"></textarea>
     </div>
  

     
     <div class="mb-8">
  <h2 class="text-lg font-semibold">III. Brief Physical Description of the Minor:</h2>

  <!-- Child's Description -->
  <div class="mb-4">
    <label class="block text-base text-black-700 mb-2">Child’s Description:</label>
    <textarea v-model="sheet.brief_physical_description" class="border w-full px-2 py-1" rows="4" :readonly="!editMode"></textarea>
  </div>
</div>


   </div>
   <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
       <div class="flex justify-between items-center">
         <div class="flex flex-col">
           <p class="ml-24 -mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
           <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
           <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
         </div> 
         <div class="ml-4">
           <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
         </div>
       </div>
     </div>
 </div>

     
     <div ref="pdfContent" v-if="currentPage === 2" class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
      <div class="relative flex justify-between items-center mb-2">
        <p class="text-[10px] text-right mb-4 w-full italic">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
      </div>
      <div class="mb-8">
  <h2 class="text-lg font-semibold">A. Major life Events:</h2>
  <div class="grid grid-cols-2 gap-4">
    <div>
      <label><input type="checkbox" v-model="sheet.major_life_event.death_of_parents" :disabled="!editMode" /> Death of Parents</label><br />
      <label><input type="checkbox" v-model="sheet.major_life_event.separation_from_family" :disabled="!editMode" /> Separation from the family</label><br />
      <label><input type="checkbox" v-model="sheet.major_life_event.natural_disaster" :disabled="!editMode" /> Victim of natural / manmade disaster</label><br />
      <label><input type="checkbox" v-model="sheet.major_life_event.apprehension" :disabled="!editMode" /> Victim of apprehension</label><br />
      <label><input type="checkbox" v-model="sheet.major_life_event.physical_abuse" :disabled="!editMode" /> Victim of physical abuse</label><br />
      <label><input type="checkbox" v-model="sheet.major_life_event.suicidal_tendencies" :disabled="!editMode" /> with suicidal tendencies</label><br />
      <label><input type="checkbox" v-model="sheet.major_life_event.mistaken_identity" :disabled="!editMode" /> mistaken identity</label><br />
    </div>
    <div>
      <label><input type="checkbox" v-model="sheet.major_life_event.abandonment" :disabled="!editMode" /> Abandonment</label><br />
      <label><input type="checkbox" v-model="sheet.major_life_event.serious_accident" :disabled="!editMode" /> Serious Accident</label><br />
      <label><input type="checkbox" v-model="sheet.major_life_event.demolition" :disabled="!editMode" /> Victim of demolition</label><br />
      <label><input type="checkbox" v-model="sheet.major_life_event.sexual_abuse" :disabled="!editMode" /> Victim of sexual abuse</label><br />
      <label><input type="checkbox" v-model="sheet.major_life_event.verbal_abuse" :disabled="!editMode" /> Victim of verbal abuse</label><br />
      <label><input type="checkbox" v-model="sheet.major_life_event.disability" :disabled="!editMode" /> acquired disability</label><br />
      
      <!-- Other specify field with small text input and underline -->
      <label class="flex items-center whitespace-nowrap">
        <input type="checkbox" v-model="sheet.life_transition.others" :disabled="!editMode" />
        <span class="ml-2">Others (pls. specify)</span>
      </label>
    </div>
  </div>
</div>


     <div class="mb-8">
       <h2 class="text-lg font-semibold">B. Enduring Life Strain:</h2>
       <div class="grid grid-cols-2 gap-4">
         <div>
           <label><input type="checkbox" v-model="sheet.enduring_life_strain.poverty" :disabled="!editMode" /> Poverty</label><br />
           <label><input type="checkbox" v-model="sheet.enduring_life_strain.physical_illness" :disabled="!editMode" /> Physical illness</label><br />
           <label><input type="checkbox" v-model="sheet.enduring_life_strain.lack_recreational_facilities" :disabled="!editMode" /> Lack of recreational facilities</label><br />
           <label><input type="checkbox" v-model="sheet.enduring_life_strain.exclusion_from_peers" :disabled="!editMode" /> Exclusion from peers</label><br />
           <label><input type="checkbox" v-model="sheet.enduring_life_strain.other" :disabled="!editMode" /> other (pls. specify)</label><br />
         </div>
         <div>
           <label><input type="checkbox" v-model="sheet.enduring_life_strain.constant_need_to_earn" :disabled="!editMode" /> constant need to earn for the family</label><br />
           <label><input type="checkbox" v-model="sheet.enduring_life_strain.lack_education_opportunity" :disabled="!editMode" /> lack of educational/ opportunity</label><br />
           <label><input type="checkbox" v-model="sheet.enduring_life_strain.exclusion_from_school" :disabled="!editMode" /> exclusion from school</label><br />
           <label><input type="checkbox" v-model="sheet.enduring_life_strain.disability" :disabled="!editMode" /> with disability</label><br />
         </div>
       </div>
     </div>


    <div class="mb-8">
  <h2 class="text-lg font-semibold">C. Life Transition:</h2>
  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="flex items-center whitespace-nowrap">
        <input type="checkbox" v-model="sheet.life_transition.moving_neighbour" :disabled="!editMode" />
        <span class="ml-2">Moving from one neighbour to another</span>
      </label>
      <label class="flex items-center whitespace-nowrap">
        <input type="checkbox" v-model="sheet.life_transition.changing_peer_group" :disabled="!editMode" />
        <span class="ml-2">Changing peer group</span>
      </label>
      <label class="flex items-center whitespace-nowrap">
        <input type="checkbox" v-model="sheet.life_transition.moving_due_to_demolition" :disabled="!editMode" />
        <span class="ml-2">Moving of another place of residence due to demolition</span>
      </label>
      <label class="flex items-center whitespace-nowrap">
        <input type="checkbox" v-model="sheet.life_transition.moving_due_to_disaster" :disabled="!editMode" />
        <span class="ml-2">Moving of another place of residence due to disaster</span>
      </label>
      <label class="flex items-center whitespace-nowrap">
        <input type="checkbox" v-model="sheet.life_transition.kinship_foster_placement" :disabled="!editMode" />
        <span class="ml-2">Moving from biological family to a kinship/ foster placement</span>
      </label>
      <label class="flex items-center whitespace-nowrap">
        <input type="checkbox" v-model="sheet.life_transition.beginning_romantic_relationship" :disabled="!editMode" />
        <span class="ml-2">Beginning romantic relationship</span>
      </label>
      <label class="flex items-center whitespace-nowrap">
        <input type="checkbox" v-model="sheet.life_transition.beginning_parents_romantic_relationship" :disabled="!editMode" />
        <span class="ml-2">Beginning romantic relationship of parents</span>
      </label>
    </div>
  </div>
</div>

   
  
   
     <div class="mb-8">
       <h2 class="text-lg font-semibold">D. Development Changes:</h2>
       <div class="space-y-2">
         <label><input type="checkbox" v-model="sheet.development_changes.early_childhood" :disabled="!editMode" /> Early childhood 1-6 yrs. Old</label><br />
         <label><input type="checkbox" v-model="sheet.development_changes.school_age" :disabled="!editMode" /> School age 7-12 yrs. Old</label><br />
         <label><input type="checkbox" v-model="sheet.development_changes.adolescence" :disabled="!editMode" /> Adolescence 13-18 yrs. old</label><br />
       </div>
     </div>
     <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
       <div class="flex justify-between items-center">
         <div class="flex flex-col">
           <p class="ml-24 -mb-4 font-bold">PAGE 2 of {{ totalPages }}</p>
           <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
           <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
         </div>
         <div class="ml-4">
           <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
         </div>
       </div>
     </div>
   </div>



   <div v-if="currentPage === 3" class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
    <div class="relative flex justify-between items-center mb-2">
        <p class="text-[10px] text-right mb-4 w-full italic">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
      </div>
    <div class="mb-8">
  <h2 class="text-lg font-semibold">E. Normalization:</h2>
  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="flex items-center whitespace-nowrap">
        <input type="checkbox" v-model="sheet.normalization.legality_law_enforcement" :disabled="!editMode" />
        <span class="ml-2">Legality/law enforcement (weak)</span>
      </label>
      <label class="flex items-center whitespace-nowrap">
        <input type="checkbox" v-model="sheet.normalization.commercial_sex" :disabled="!editMode" />
        <span class="ml-2">Availability of:</span>
      </label>
      <div class="ml-16">
        <label class="flex items-center whitespace-nowrap">
          <input type="checkbox" v-model="sheet.normalization.commercial_sex" :disabled="!editMode" />
          <span class="ml-2">Commercial sex</span>
        </label>
        <label class="flex items-center whitespace-nowrap">
          <input type="checkbox" v-model="sheet.normalization.substance_illegal_drugs" :disabled="!editMode" />
          <span class="ml-2">Substance/illegal drugs</span>
        </label>
        <label class="flex items-center whitespace-nowrap">
          <input type="checkbox" v-model="sheet.normalization.pornography_materials" :disabled="!editMode" />
          <span class="ml-2">Pornography materials to include video tapes</span>
        </label>
        <label class="flex items-center whitespace-nowrap">
          <input type="checkbox" v-model="sheet.normalization.red_houses" :disabled="!editMode" />
          <span class="ml-2">Red houses</span>
        </label>
      </div>
      <label class="flex items-center whitespace-nowrap">
        <input type="checkbox" v-model="sheet.normalization.price_least_expensive" :disabled="!editMode" />
        <span class="ml-2">Price - least expensive</span>
      </label>
      <div>
        <label class="flex items-center whitespace-nowrap">
          <input type="checkbox" v-model="sheet.normalization.advertisement_media" :disabled="!editMode" />
          <span class="ml-2">Advertisement/ sponsorship/ media presentation</span>
        </label>
        <div class="ml-16">
          <label class="flex items-center whitespace-nowrap">
            <input type="checkbox" v-model="sheet.normalization.advertisement_promoting_liquors" :disabled="!editMode" />
            <span class="ml-2">Advertisement promoting liquors/cigarettes/clubs/red houses</span>
          </label>
          <label class="flex items-center whitespace-nowrap">
            <input type="checkbox" v-model="sheet.normalization.television_shows" :disabled="!editMode" />
            <span class="ml-2">Television shows</span>
          </label>
          <label class="flex items-center whitespace-nowrap">
            <input type="checkbox" v-model="sheet.normalization.movies" :disabled="!editMode" />
            <span class="ml-2">Movies</span>
          </label>
          <label class="flex items-center whitespace-nowrap">
            <input type="checkbox" v-model="sheet.normalization.printed_materials" :disabled="!editMode" />
            <span class="ml-2">Printed materials</span>
          </label>
        </div>
      </div>
      <label class="flex items-center whitespace-nowrap">
        <input type="checkbox" v-model="sheet.normalization.community_acceptance" :disabled="!editMode" />
        <span class="ml-2">Community acceptance</span>
      </label>
      <div class="ml-16">
        <label class="flex items-center whitespace-nowrap">
          <input type="checkbox" v-model="sheet.normalization.source_of_income" :disabled="!editMode" />
          <span class="ml-2">Source of income</span>
        </label>
        <label class="flex items-center whitespace-nowrap">
          <input type="checkbox" v-model="sheet.normalization.involve_in_trade" :disabled="!editMode" />
          <span class="ml-2">Involve in actual trade/production</span>
        </label>
      </div>
      <label class="flex items-center whitespace-nowrap">
        <input type="checkbox" v-model="sheet.normalization.role_of_culture" :disabled="!editMode" />
        <span class="ml-2">Role of culture (culturally accepted)</span>
      </label>
      <div class="ml-4">
  <div class="grid grid-cols-2 gap-x-4">
    <div>
      <label class="flex items-center space-x-1 whitespace-nowrap">
        <input type="checkbox" v-model="sheet.normalization.smoking" :disabled="!editMode" />
        <span>Smoking</span>
      </label>
      <label class="flex items-center space-x-1 whitespace-nowrap">
        <input type="checkbox" v-model="sheet.normalization.abuse" :disabled="!editMode" />
        <span>Abuse</span>
      </label>
      <label class="flex items-center space-x-1 whitespace-nowrap">
        <input type="checkbox" v-model="sheet.normalization.illicit_relationship" :disabled="!editMode" />
        <span>Illicit relationship</span>
      </label>
      <label class="flex items-center space-x-1 whitespace-nowrap">
        <input type="checkbox" v-model="sheet.normalization.incest_relationship" :disabled="!editMode" />
        <span>Incest relationship</span>
      </label>
      <label class="flex items-center space-x-1 whitespace-nowrap">
        <input type="checkbox" v-model="sheet.normalization.rugby_sniffing" :disabled="!editMode" />
        <span>Rugby Sniffing</span>
      </label>
    </div>
    <div class="ml-20">
      <label class="flex items-center space-x-1 whitespace-nowrap">
        <input type="checkbox" v-model="sheet.normalization.Drinking" :disabled="!editMode" />
        <span>Drinking</span>
      </label>
      <label class="flex items-center space-x-1 whitespace-nowrap">
        <input type="checkbox" v-model="sheet.normalization.gambling" :disabled="!editMode" />
        <span>Gambling</span>
      </label>
      <label class="flex items-center space-x-1 whitespace-nowrap">
        <input type="checkbox" v-model="sheet.normalization.polygamous_relationship" :disabled="!editMode" />
        <span>Polygamous Relationship</span>
      </label>
      <label class="flex items-center space-x-1 whitespace-nowrap">
        <input type="checkbox" v-model="sheet.normalization.begging" :disabled="!editMode" />
        <span>Begging</span>
      </label>
    </div>
  </div>
      </div>
    </div>
  </div>
</div>

     <div class="mb-8">
       <h2 class="text-lg font-semibold">F. Feelings / Behaviour towards the incident:</h2>
       <div class="grid grid-cols-2 gap-4">
         <div>
           <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.stow_away" :disabled="!editMode" /> stow away</label><br />
           <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.irritable" :disabled="!editMode" /> irritable</label><br />
           <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.delinquent_behaviour" :disabled="!editMode" /> Delinquent behaviour</label><br />
           <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.stealing" :disabled="!editMode" /> stealing</label><br />
           <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.begging" :disabled="!editMode" /> begging</label><br />
           <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.others" :disabled="!editMode" /> others (pls. specify)</label><br />
         </div>
         <div>
          <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.indulge_in_illegal_substance" :disabled="!editMode" /> indulge in illegal substance</label><br />
           <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.unresponsive_passive" :disabled="!editMode" /> unresponsive/ passive</label><br />
           <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.withdrawal" :disabled="!editMode" /> withdrawal</label><br />
           <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.snatching" :disabled="!editMode" /> snatching</label><br />
           <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.staying_in_street" :disabled="!editMode" /> staying in the street</label><br />
         </div><div class="mb-8">
 
    <div>
      <label class="flex items-center whitespace-nowrap">
        <input type="checkbox" v-model="sheet.normalization.commercial_sex" :disabled="!editMode" />
        <span class="ml-2">Feelings</span>
      </label>
      <div class="grid grid-cols-2 gap-x-8">
      <div class="ml-8">
        <label class="flex items-center space-x-1 whitespace-nowrap">
          <input type="checkbox" v-model="sheet.normalization.feeling_of_freedom" :disabled="!editMode" />
          <span>Feeling of Freedom</span>
        </label>
        <label class="flex items-center space-x-1 whitespace-nowrap">
          <input type="checkbox" v-model="sheet.normalization.hatred" :disabled="!editMode" />
          <span>Hatred</span>
        </label>
        <label class="flex items-center space-x-1 whitespace-nowrap">
          <input type="checkbox" v-model="sheet.normalization.independence" :disabled="!editMode" />
          <span>Independence</span>
        </label>
        <label class="flex items-center space-x-1 whitespace-nowrap">
          <input type="checkbox" v-model="sheet.normalization.others" :disabled="!editMode" />
          <span>Others (pls specify)</span>
        </label>
      </div>
    <div class="ml-24">
        <label class="flex items-center space-x-1 whitespace-nowrap">
          <input type="checkbox" v-model="sheet.normalization.contented" :disabled="!editMode" />
          <span>Contented</span>
        </label>
        <label class="flex items-center space-x-1 whitespace-nowrap">
          <input type="checkbox" v-model="sheet.normalization.belongingness" :disabled="!editMode" />
          <span>Belongingness</span>
        </label>
        <label class="flex items-center space-x-1 whitespace-nowrap">
          <input type="checkbox" v-model="sheet.normalization.guilt" :disabled="!editMode" />
          <span>Guilt</span>
        </label>
        <label class="flex items-center space-x-1 whitespace-nowrap">
          <input type="checkbox" v-model="sheet.normalization.rebellion" :disabled="!editMode" />
          <span>Rebellion</span>
        </label>
    </div>
  </div>
</div>
</div>
</div>
</div>

     

     <div class="mb-8">
       <h2 class="text-lg font-semibold">G. Attachments:</h2>
       <div class="grid grid-cols-2 gap-4">
         <div>
           <label><input type="checkbox" v-model="sheet.attachments.mother" :disabled="!editMode" /> Mother</label><br />
           <label><input type="checkbox" v-model="sheet.attachments.grandmother" :disabled="!editMode" /> Grandmother</label><br />
           <label><input type="checkbox" v-model="sheet.attachments.aunt" :disabled="!editMode" /> Aunt</label><br />
           <label><input type="checkbox" v-model="sheet.attachments.neighbour" :disabled="!editMode" /> Neighbour</label><br />
           <label><input type="checkbox" v-model="sheet.attachments.cousin" :disabled="!editMode" /> Cousin</label><br />
           <label><input type="checkbox" v-model="sheet.attachments.cousin" :disabled="!editMode" /> Teacher</label><br />
           <label><input type="checkbox" v-model="sheet.attachments.cousin" :disabled="!editMode" /> Othe</label><br />
         </div>
         <div>
           <label><input type="checkbox" v-model="sheet.attachments.father" :disabled="!editMode" /> father</label><br />
           <label><input type="checkbox" v-model="sheet.attachments.grandfather" :disabled="!editMode" /> grand father</label><br />
           <label><input type="checkbox" v-model="sheet.attachments.uncle" :disabled="!editMode" /> uncle</label><br />
           <label><input type="checkbox" v-model="sheet.attachments.peer" :disabled="!editMode" /> peer</label><br />
           <label><input type="checkbox" v-model="sheet.attachments.schoolmate" :disabled="!editMode" /> schoolmate</label><br />
           <label><input type="checkbox" v-model="sheet.attachments.classmate" :disabled="!editMode" /> classmate</label><br />
         </div>
       </div>
     </div>

     <div class="mb-8">
       <h2 class="text-lg font-semibold">H. Skills:</h2>
       <div class="grid grid-cols-2 gap-4">
         <div>
           <label><input type="checkbox" v-model="sheet.skills.problem_solving" :disabled="!editMode" /> Problem solving</label><br />
           <label><input type="checkbox" v-model="sheet.skills.interpersonal_relationship" :disabled="!editMode" /> Interpersonal relationship</label><br />
           <label><input type="checkbox" v-model="sheet.skills.communication_skills" :disabled="!editMode" /> Communication skills</label><br />
           <label><input type="checkbox" v-model="sheet.skills.vocational_skills" :disabled="!editMode" /> Vocational skills</label><br />
           <label><input type="checkbox" v-model="sheet.skills.critical_thinking" :disabled="!editMode" /> Critical thinking</label><br />
           <label><input type="checkbox" v-model="sheet.skills.others" :disabled="!editMode" /> Others</label><br />
         </div>
         <div>
           <label><input type="checkbox" v-model="sheet.skills.coping_skills" :disabled="!editMode" /> coping skills</label><br />
           <label><input type="checkbox" v-model="sheet.skills.survival_skills" :disabled="!editMode" /> survival skills</label><br />
           <label><input type="checkbox" v-model="sheet.skills.decision_making_skills" :disabled="!editMode" /> decision making skills</label><br />
           <label><input type="checkbox" v-model="sheet.skills.comprehension" :disabled="!editMode" /> comprehension</label><br />
           <label><input type="checkbox" v-model="sheet.skills.self_awareness" :disabled="!editMode" /> self-awareness</label><br />
         </div>
       </div>
     </div>
     <div  class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
       <div class="flex justify-between items-center">
         <div class="flex flex-col">
           <p class="ml-24 -mb-4 font-bold">PAGE 3 of {{ totalPages }}</p>
           <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
           <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
         </div>
         <div class="ml-4">
           <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
         </div>
       </div>
     </div>
   </div>

   
<div v-if="currentPage === 4" class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
  <div class="relative flex justify-between items-center mb-2">
        <p class="text-[10px] text-right mb-4 w-full italic">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
      </div>
  <div class="mb-8">
  <h2 class="text-lg font-semibold">Resources:</h2>
  <div class="space-y-8">

    <!-- Internal Resources Section -->
    <div class="flex space-x-8">
      <div class="w-1/2">
        <label class="flex items-center whitespace-nowrap">
          <input type="checkbox" v-model="sheet.resources.internal" :disabled="!editMode" />
          <span class="ml-2">Internal Resources</span>
        </label>
        <div class="ml-8">
          <div class="grid grid-cols-2 gap-x-4">
            <div>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.intelligence" :disabled="!editMode" />
                <span>Intelligence</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.spirituality" :disabled="!editMode" />
                <span>Spirituality</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.resourceful" :disabled="!editMode" />
                <span>Resourceful</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.obedient" :disabled="!editMode" />
                <span>Obedient</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.others" :disabled="!editMode" />
                <span>Others</span>
              </label>
            </div>
            <div class="ml-8">
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.education" :disabled="!editMode" />
                <span>Education</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.discipline" :disabled="!editMode" />
                <span>Discipline</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.respectful" :disabled="!editMode" />
                <span>Respectful</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.submissive" :disabled="!editMode" />
                <span>Submissive</span>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- External Resources Section -->
    <div class="flex space-x-8">
      <div class="w-1/2">
        <label class="flex items-center whitespace-nowrap">
          <input type="checkbox" v-model="sheet.resources.external" :disabled="!editMode" />
          <span class="ml-2">External Resources</span>
        </label>
        <div class="ml-8">
          <div class="grid grid-cols-2 gap-x-4">
            <div>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.family" :disabled="!editMode" />
                <span>Family</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.peers" :disabled="!editMode" />
                <span>Peers</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.health_services" :disabled="!editMode" />
                <span>Health Services</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.recreational_services" :disabled="!editMode" />
                <span>Recreational Services</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.ngos" :disabled="!editMode" />
                <span>NGOs Existing in the Community</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.civic_organization" :disabled="!editMode" />
                <span>Civic Organization</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.others_external" :disabled="!editMode" />
                <span>Others (pls. specify)</span>
              </label>
            </div>
            <div class="ml-44">
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.street_children" :disabled="!editMode" />
                <span>Other Street Children</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.street_educators" :disabled="!editMode" />
                <span>Street Educators</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.vocational_services" :disabled="!editMode" />
                <span>Vocational Services</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.lgu_staff" :disabled="!editMode" />
                <span>LGU Staff at All Levels</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.peoples_organization" :disabled="!editMode" />
                <span>People’s Organization</span>
              </label>
              <label class="flex items-center space-x-1 whitespace-nowrap">
                <input type="checkbox" v-model="sheet.resources.faith_based_organization" :disabled="!editMode" />
                <span>Faith Based Organization</span>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>




    <div class="mb-8">
      <h2 class="text-lg font-semibold">IV. Activities or source of income in the street:</h2>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label><input type="checkbox" v-model="sheet.source_of_income_in_street.vending" :disabled="!editMode" /> Vending</label><br />
          <label><input type="checkbox" v-model="sheet.source_of_income_in_street.car_wash_boy" :disabled="!editMode" /> Car wash boy</label><br />
          <label><input type="checkbox" v-model="sheet.source_of_income_in_street.rugby_user" :disabled="!editMode" /> Rugby user</label><br />
        </div>
        <div>
          <label><input type="checkbox" v-model="sheet.source_of_income_in_street.porter" :disabled="!editMode" /> Porter</label><br />
          <label><input type="checkbox" v-model="sheet.source_of_income_in_street.barker" :disabled="!editMode" /> Barker</label><br />
        </div>
      </div>
      <div class="space-y-2">
        <div class="flex items-center mb-4">
          <label class="block text-base font-semibold text-gray-700 mr-4">Earnings/ income:</label>
          <input type="text" v-model="sheet.earnings_income" class="flex-grow mt-1 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
        </div>
        <div class="flex items-center mb-4">
          <label class="block text-base font-semibold text-gray-700 mr-4">Hours of stay in the street:</label>
          <input type="text" v-model="sheet.hrs_stay_in_street" class="flex-grow mt-1 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
        </div>
        <div class="flex items-center mb-4">
          <label class="block text-base font-semibold text-gray-700 mr-4">Length of stay in the street:</label>
          <input type="text" v-model="sheet.length_stay_in_street" class="flex-grow mt-1 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
        </div>
        <div class="flex items-center mb-4">
          <label class="block text-base font-semibold text-gray-700 mr-4">Common Substance used:</label>
          <input type="text" v-model="sheet.common_substance_used" class="flex-grow mt-1 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
        </div>
      </div>
    </div>

  </div>
</div>

<div class="mb-8">
  <h2 class="text-lg font-semibold">V. INITIAL ASSESSMENT:</h2>
  <textarea v-model="sheet.initial_assessment" class="border w-full px-2 py-1" rows="4" :readonly="!editMode"></textarea>
</div>

<div class="mb-8">
      <h2 class="text-lg font-semibold">VI. RECOMMENDATIONS:</h2>
      <textarea v-model="sheet.recommendations" class="border w-full px-2 py-1" rows="4" :readonly="!editMode"></textarea>
    </div>

    <div class="flex justify-between mb-8">
      <div class="flex flex-col items-start">
        <label class="block text-base font-semibold text-gray-700 mb-1">Prepared by:</label>
        <input type="text" v-model="case_manager" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
        <p>SWO __/Case Manager</p>
      </div>
      <div class="flex flex-col items-end">
        <label class="block text-base font-semibold text-gray-700 mb-8">Reviewed by:</label>
        <div class="text-right">
          <input type="text" v-model="center_head" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
          <p>Center Head/SWO IV</p>
        </div>
      </div>
    </div>
 

<div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
  <div class="flex justify-between items-center">
    <div class="flex flex-col">
      <p class="ml-24 -mb-4 font-bold">PAGE 4 of {{ totalPages }}</p>
      <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
      <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
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
import Pagination from '@/Components/Pagination.vue';
import { jsPDF } from 'jspdf';
import '../../../fonts/arial-normal.js'; 
import '../../../fonts/times-normal.js'; 
import '../../../fonts/arialbd-bold.js'; 

export default {
  name: 'GeneralIntakeSheet',
  components: {
    Pagination
  },
  data() {
    return {
      editMode: false,
      message: '',
      messageType: '',
      center_head: '',
      case_manager:'',
      totalPages: 4,
      clientId: null,
      currentPage: 1,
      isModalOpen: false,
      isSaveResultModalOpen: false,
      saveResultTitle: '',
      saveResultMessage: '',
      sheet: {
        id: null,
        name: '',
        age: '',
        sex: '',
        address: '',
        date_of_birth: '',
        place_of_birth: '',
        religion: '',
        occupation: '',
        highest_educ_att: '',
        school_name: '',
        class_adviser: '',
        date: '',  // New date field
        problem_presented: '',
        brief_physical_description: '',
        major_life_event: {
          death_of_parents: false,
          separation_from_family: false,
          natural_disaster: false,
          apprehension: false,
          physical_abuse: false,
          suicidal_tendencies: false,
          mistaken_identity: false,
          abandonment: false,
          serious_accident: false,
          demolition: false,
          sexual_abuse: false,
          verbal_abuse: false,
          disability: false,
          others: false,
        },
        enduring_life_strain: {
          poverty: false,
          physical_illness: false,
          lack_recreational_facilities: false,
          exclusion_from_peers: false,
          other: false,
          constant_need_to_earn: false,
          lack_education_opportunity: false,
          exclusion_from_school: false,
          disability: false,
        },
        life_transition: {
          moving_neighbour: false,
          changing_peer_group: false,
          moving_due_to_demolition: false,
          moving_due_to_disaster: false,
          kinship_foster_placement: false,
          beginning_romantic_relationship: false,
          beginning_parents_romantic_relationship: false,
          others: false,
        },
        development_changes: {
          early_childhood: false,
          school_age: false,
          adolescence: false,
        },
        normalization: {
          legality_law_enforcement: false,
          commercial_sex: false,
          substance_illegal_drugs: false,
          pornography_materials: false,
          red_houses: false,
          price_least_expensive: false,
          advertisement_media: false,
          advertisement_promoting_liquors: false,
          television_shows: false,
          movies: false,
          printed_materials: false,
          community_acceptance: false,
          source_of_income: false,
          involve_in_trade: false,
          role_of_culture: false,
          smoking: false,
          abuse: false,
          illicit_relationship: false,
          incest_relationship: false,
          begging: false,
          rugby_sniffing: false,
        },
        behaviour_towards_incident: {
          stow_away: false,
          irritable: false,
          delinquent_behaviour: false,
          stealing: false,
          begging: false,
          others: false,
          withdrawal: false,
          unresponsive_passive: false,
          indulge_in_illegal_substance: false,
          snatching: false,
          staying_in_street: false,
        },
        attachments: {
          mother: false,
          grandmother: false,
          aunt: false,
          neighbour: false,
          cousin: false,
          father: false,
          grandfather: false,
          uncle: false,
          peer: false,
          schoolmate: false,
          classmate: false,
        },
        skills: {
          problem_solving: false,
          interpersonal_relationship: false,
          communication_skills: false,
          vocational_skills: false,
          critical_thinking: false,
          others: false,
          coping_skills: false,
          survival_skills: false,
          decision_making_skills: false,
          comprehension: false,
          self_awareness: false,
        },
        resources: {
          internal: false,
          intelligence: false,
          spirituality: false,
          resourceful: false,
          obedient: false,
          others: false,
          external: false,
          family: false,
          peers: false,
          health_services: false,
          recreational_services: false,
          ngos: false,
          civic_organization: false,
          others: false,
        },
        source_of_income_in_street: {
          vending: false,
          car_wash_boy: false,
          rugby_user: false,
          porter: false,
          barker: false,
        },
        earnings_income: '',
        hrs_stay_in_street: '',
        length_stay_in_street: '',
        common_substance_used: '',
        initial_assessment: '',
        recommendations: '',
        vices: '',
        school_activities_achievement: '',
        occupation_of_mother: '',
        occupation_of_father: '',
        siblings: '',
        responsible_for_households_chores: '',
        water_source: '',
        house_made_of: '',
        prepared_by: '',  // New field
      }
    };
  },
  mounted() {
    this.clientId = this.$route.params.id;
    console.log('Client ID fetched:', this.clientId); // Console log showing client ID
    this.fetchClientData(this.clientId);
    this.fetchCenterHead();
    this.fetchCaseManager(this.clientId);
  },
  watch: {
    '$route.params.id'(newId) {
      this.clientId = newId;
      this.fetchClientData(this.clientId);
      this.fetchCenterHead();
      this.fetchCaseManager(this.clientId);
    }
  },
  methods: {
    async fetchClientData(id) {
      try {
        const response = await axios.get(`/api/clients/${id}`);
        const client = response.data;

        this.sheet.name = `${client.first_name} ${client.last_name}`;
        this.sheet.age = this.calculateAge(client.date_of_birth);
        this.sheet.sex = client.sex;
        this.sheet.address = `${client.province}, ${client.city}, ${client.barangay}, ${client.street}`;
        this.sheet.date_of_birth = client.date_of_birth;
        this.sheet.place_of_birth = client.place_of_birth;
        this.sheet.religion = client.religion;

        const sheetResponse = await axios.get(`/api/general-intake-sheets/${id}`);
        const clientSheet = sheetResponse.data;

        Object.assign(this.sheet, clientSheet);
      } catch (error) {
        console.error('Error fetching client data:', error);
      }
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
fetchCaseManager(clientId) {
      // Fetch the case manager based on the client ID
      if (!clientId) {
        console.error("Client ID is missing.");
        return;
      }
      axios.get(`/api/case-manager/${clientId}`)
        .then(response => {
          this.case_manager = response.data.case_manager || '';
          console.log("Fetched case manager:", this.case_manager); // Log the case manager
        })
        .catch(error => {
          console.error("Error fetching case manager:", error);
        });
    },

    saveCaseManager() {
  console.log("Saving case manager:", this.case_manager, "for client:", this.clientId); // Log the data before the request
  
  if (!this.clientId) {
    console.error("Client ID is missing.");
    return;
  }

  axios.put(`/api/update-case-manager/${this.clientId}`, { 
    client_id: this.clientId,  // Include the client_id here
    name: this.case_manager 
  })
  .then(response => {
    console.log("Case manager saved successfully:", response.data); // Log the response
    this.editMode = false;
    this.fetchCaseManager(this.clientId);  // Refetch to update the UI
  })
  .catch(error => {
    console.error("Error updating case manager:", error);
  });
}
,

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
    toggleEdit() {
      if (this.editMode) {
        this.openModal();
      } else {
        this.editMode = !this.editMode;
      }
    },
    openModal() {
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
    },
    confirmSave() {
      this.saveData();
      this.saveCenterHead();
      this.saveCaseManager(); 
      this.closeModal();
      this.editMode = false;
    },
    cancelEdit() {
      this.editMode = false;
    },
    saveData() {
      if (!this.clientId) {
        this.message = 'No client selected.';
        this.messageType = 'error';
        this.clearNotification();
        return;
      }

      const payload = {
        client_id: this.clientId,
        ...this.sheet
      };

      const method = this.sheet.id ? 'put' : 'post';
      const url = `/api/general-intake-sheets${this.sheet.id ? '/' + this.sheet.id : ''}`;

      axios[method](url, payload)
        .then(response => {
          this.saveResultTitle = 'Success';
          this.saveResultMessage = 'Data saved successfully.';
          if (!this.sheet.id) this.sheet.id = response.data.id;
          this.editMode = false;
        })
        .catch(error => {
          this.saveResultTitle = 'Error';
          this.saveResultMessage = error.response.data.message || 'Error saving data.';
          console.error('Error saving data:', error);
        })
        .finally(() => {
          this.isModalOpen = false;
          this.isSaveResultModalOpen = true;
        });
    },
    closeSaveResultModal() {
      this.isSaveResultModalOpen = false;
      this.saveResultTitle = '';
      this.saveResultMessage = '';
    },
    clearNotification() {
      setTimeout(() => {
        this.message = '';
        this.messageType = '';
      }, 3000);
    },

    exportToPdf() {
  const pdf = new jsPDF('p', 'mm', [216, 356]); // Legal size: 216mm x 356mm

  // Set default font properties
  pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
  pdf.setFont('Arial', 'normal');   
  pdf.setFontSize(11);
  pdf.setLineHeightFactor(1.5);

  // Page 1 content
  let offset = 90; // Initialize offset at the start of page 1

  const imgData = '/images/headerlogo2.png'; // Ensure this is accessible or use base64
  pdf.addImage(imgData, 'PNG', 15, 10, 75, 35); // Increase width to 75 and height to 35

  // Add the header below the image
  pdf.setFontSize(8);
  pdf.setFont('TimesNewRoman', 'italic');
  pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 153, 24);

  // Add the title
  pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
  pdf.setFont('arialbd', 'bold');  
  pdf.setFontSize(18);
  pdf.text('GENERAL INTAKE SHEET', 108, 60, null, null, 'center');
  pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
  pdf.setFont('Arial', 'normal');  


  // Date
  pdf.setFontSize(12);
  pdf.text(`Date: ${String(this.sheet.date)}`, 160, 70);
  pdf.line(170, 71, 200, 71);

// Function to add footer to the first page with debug text
function addFirstPageFooter(pdf, totalPages) {
    // Set font and add debug text for the footer
    pdf.setFont("helvetica", "normal");
    pdf.setFontSize(10);

    // Footer text
    const footerText = "DEBUG: Footer Page 1 of " + totalPages;
    
    // Add the footer text with correct alignment
    pdf.text(footerText, 20, pdf.internal.pageSize.getHeight() - 10);  // Adjusted y-position for visibility

    // Add a debug rectangle to visualize the footer area
    pdf.rect(15, pdf.internal.pageSize.getHeight() - 30, 180, 20); // Debug rectangle for visual confirmation

    // Add a simple placeholder image or comment out the image to debug
    pdf.text("DEBUG: Footer Image Area", 20, pdf.internal.pageSize.getHeight() - 20); // Placeholder for image
}

// Function to add footer for pages 2 and beyond with debug text
function addOtherPagesFooter(pdf, pageNumber, totalPages) {
    // Set font for normal footer text
    pdf.setFont("helvetica", "normal");
    pdf.setFontSize(10);
    
    // Footer text for other pages
    const footerText = "DEBUG: Footer Page " + pageNumber + " of " + totalPages;

    // Add the footer text
    pdf.text(footerText, 20, pdf.internal.pageSize.getHeight() - 10);  // Adjusted y-position for visibility

    // Add a debug rectangle to visualize the footer area
    pdf.rect(15, pdf.internal.pageSize.getHeight() - 30, 180, 20); // Debug rectangle for visual confirmation
}

// Function to apply footers to all pages with debug text
function addAllFooters(pdf, totalPages) {
    // Loop through all pages to apply footers
    for (let i = 1; i <= totalPages; i++) {
        pdf.setPage(i);
        if (i === 1) {
            addFirstPageFooter(pdf, totalPages);  // Custom footer for the first page
        } else {
            addOtherPagesFooter(pdf, i, totalPages);  // Footer for subsequent pages
        }
    }
}

// Function to check for page overflow and add a new page if necessary
function checkAndAddPage(pdf, currentOffset, pageHeight, footerHeight) {
    // If the current offset exceeds the allowable page height (minus footer), add a new page
    if (currentOffset > pageHeight - footerHeight) {
        pdf.addPage();
        return 0;  // Reset offset after adding a new page
    }
    return currentOffset;  // Return the current offset if no new page is needed
}

  // Identifying Information
  pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
  pdf.setFont('arialbd', 'bold');  
  pdf.setFontSize(12);
  pdf.text('I. Identifying Information:', 20, 90);
  pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
  pdf.setFont('Arial', 'normal');  

  pdf.setFontSize(12);
  pdf.text(`Name of client:`, 20, 100);
  pdf.text(String(this.sheet.name), 50, 100);
  pdf.line(50, 101, 130, 101);

  pdf.text(`Age:`, 135, 100);
  pdf.text(String(this.sheet.age), 145, 100);
  pdf.line(145, 101, 170, 101);

  pdf.text(`Sex:`, 175, 100);
  pdf.text(String(this.sheet.sex), 185, 100);
  pdf.line(185, 101, 200, 101);
  
  function justifyLine(pdf, text, x, y, maxWidth) {
  const textWidth = pdf.getTextWidth(text); // Get the width of the text
  const spaceCount = (text.match(/\s+/g) || []).length; // Count the number of spaces in the text
  const spaceWidth = (maxWidth - textWidth) / spaceCount; // Calculate extra space to add between words

  // If no spaces, or if the text is already fitting within the width, skip justification
  if (spaceCount === 0 || spaceWidth <= 0) {
    pdf.text(text, x, y);
    return;
  }

  // Split the text into words
  const words = text.split(/\s+/);

  let currentX = x;

  // Loop through each word, print it, and add extra space between words
  words.forEach((word, index) => {
    pdf.text(word, currentX, y); // Print the word at the current X position
    currentX += pdf.getTextWidth(word) + spaceWidth; // Move the X position to the right for the next word
  });
}

// Handle Address Wrapping with conditional justification
pdf.text('Address:', 20, offset + 20); // Static label placement at 20x offset

const addressText = String(this.sheet.address); // Dynamically fetch the address from the data
const wrappedAddress = pdf.splitTextToSize(addressText, 150); // Wrap the address text to fit within 150 units of width

// Adjust the offset to account for the wrapped address lines
wrappedAddress.forEach((line, i) => {
  const lineX = i === 0 ? 38 : 20; // Align first line with some margin (42), subsequent lines start at 20
  const lineY = offset + 20 + i * 8; // Adjust Y position based on the current line

  if (i < wrappedAddress.length - 1) {
    // Justify all lines except the last one
    justifyLine(pdf, line, lineX, lineY, 170);
  } else {
    // Last line should not be justified
    pdf.text(line, lineX, lineY);
  }

  // Draw underline for each line
  pdf.line(lineX, lineY + 1, 200, lineY + 1);
});

// Calculate the total height used by the wrapped address and update the offset
const addressHeight = wrappedAddress.length * 9; // Adjust height based on the number of lines (9 units per line)
offset += addressHeight + 10; // Update offset for the following content

// Date of Birth
pdf.text(`Date of Birth:`, 20, offset + 10  );
pdf.text(String(this.sheet.date_of_birth), 46, offset + 10);
pdf.line(46, offset + 11, 100, offset + 11);
offset += 10; // Move offset down

// Place of Birth
pdf.text(`Place of birth:`, 105, offset);
pdf.text(String(this.sheet.place_of_birth), 133, offset);
pdf.line(133, offset + 1, 200, offset + 1);
offset += 10; // Move offset down

// Religion
pdf.text(`Religion:`, 20, offset);
pdf.text(String(this.sheet.religion), 40, offset);
pdf.line(40, offset + 1, 200, offset + 1);
offset += 10; // Move offset down

// Occupation
pdf.text(`Occupation:`, 20, offset);
pdf.text(String(this.sheet.occupation), 45, offset);
pdf.line(45, offset + 1, 200, offset + 1);
offset += 10; // Move offset down

// Highest Educational Attainment
pdf.text(`Highest Educ'l Att't:`, 20, offset);
pdf.text(String(this.sheet.highest_educ_att), 59, offset);
pdf.line(59, offset + 1, 200, offset + 1);
offset += 10; // Move offset down

// Name of School
pdf.text(`Name of School:`, 20, offset);
pdf.text(String(this.sheet.school_name), 53, offset);
pdf.line(53, offset + 1, 200, offset + 1);
offset += 10; // Move offset down

// Class Adviser
pdf.text(`Class Adviser:`, 20, offset);
pdf.text(String(this.sheet.class_adviser), 50, offset);
pdf.line(50, offset + 1, 200, offset + 1);
offset += 10; // Move offset down

function addTextWithWrappingAndLines(pdf, text, x, y, maxWidth, pageHeight, footerHeight, lineHeight) {
  const lines = pdf.splitTextToSize(text, maxWidth); // Split long text into multiple lines
  lines.forEach((line) => {
    // If the current y position + lineHeight exceeds the page height minus the footer height, add a new page
    if (y + lineHeight > pageHeight - footerHeight) {
      pdf.addPage(); // Add new page
      pdf.setFontSize(8); 
      pdf.setFont('TimesNewRoman', 'italic'); 
      pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 149, 20); 
      pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
      pdf.setFont('Arial', 'normal'); 
      pdf.setFontSize(11);
      y = 20; // Reset y position for the new page
    }

    pdf.text(line, x, y); // Add the text line at (x, y)
    pdf.line(x, y + 1, 200, y + 1); // Draw a line under each text line
    y += lineHeight; // Move to the next line position
  });
  return y; // Return the updated y position after all lines are added
}

const pageHeight = 356; // Height of a legal-sized page in mm
const footerHeight = 25; // Footer height in mm
const lineHeight = 7; // Height between lines

// Section II: Problem Presented
pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
pdf.setFont('arialbd', 'bold');
pdf.setFontSize(12);
pdf.text('II. Problem Presented:', 20, offset);
pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
pdf.setFont('Arial', 'normal');
offset += 10;
// Define rowHeight and column positions globally or at the beginning of your function
const rowHeight = 6; 
const rowHeight1 =2; // Row height for spacing between items
const leftColumnX = 20; // X coordinate for the left column
const rightColumnX = 120; // X coordinate for the right column

// Dynamically add Problem Presented text with wrapping and check for page breaks
offset = addTextWithWrappingAndLines(pdf, String(this.sheet.problem_presented), 20, offset, 180, pageHeight, footerHeight, rowHeight);

// Section III: Brief Physical Description
pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
pdf.setFont('arialbd', 'bold');
pdf.setFontSize(12);
pdf.text('III. Brief Physical Description of the Minor:', 20, offset + 5);
pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
pdf.setFont('Arial', 'normal');
offset += 10;

// Dynamically add Brief Physical Description with wrapping and page breaks
offset = addTextWithWrappingAndLines(pdf, String(this.sheet.brief_physical_description), 20, offset + 5, 170, pageHeight, footerHeight, rowHeight);

// Dynamically add space after the previous section
offset += 15; // Add a bit of extra space between sections

// Function to dynamically add text with wrapping and checkboxes, and handle page breaks
function addTextWithCheckboxAndWrapping(pdf, text, x, y, isChecked, maxWidth, pageHeight, footerHeight, rowHeight1) {
  const boxSize = 5;

  // If the current y position + rowHeight exceeds the page height minus the footer height, add a new page
  if (y + rowHeight1 > pageHeight - footerHeight) {
    pdf.addPage(); // Add a new page
    pdf.setFontSize(8); 
    pdf.setFont('TimesNewRoman', 'italic'); 
    pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 149, 20); 
    pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
    pdf.setFont('Arial', 'normal'); 
    pdf.setFontSize(11);
    y = 20; // Reset y position for the new page
  }

  // Calculate text lines with wrapping
  const lines = pdf.splitTextToSize(text, maxWidth);
  lines.forEach((line) => {
    // Draw checkbox and checkmark
    drawCheckboxWithCheckmark(pdf, x, y, isChecked);
    
    // Draw the text label next to the checkbox
    pdf.text(line, x + 10, y);
    
    // Update the y position
    y += rowHeight1;
    
    // Check for page break again inside the loop
    if (y + rowHeight1 > pageHeight - footerHeight) {
      pdf.addPage();
      pdf.setFontSize(8); 
    pdf.setFont('TimesNewRoman', 'italic'); 
    pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 149, 20); 

    pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
    pdf.setFont('Arial', 'normal'); 
    pdf.setFontSize(11);
      y = 20; // Reset y position for new page
    }
  });

  return y; // Return the updated y position
}

// Section A: Major Life Events
pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
pdf.setFont('arialbd', 'bold');
pdf.text('A. Major Life Events:', 20, offset -10); // Use the dynamic offset value
pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
pdf.setFont('Arial', 'normal');
offset += rowHeight1 -4; // Add some space after the title

// Define your major life events array with the appropriate values
const majorLifeEvents = [
  { label: 'Death of Parents', value: this.sheet.major_life_event.death_of_parents },
  { label: 'Separation from the family', value: this.sheet.major_life_event.separation_from_family },
  { label: 'Victim of natural / manmade disaster', value: this.sheet.major_life_event.natural_disaster },
  { label: 'Victim of apprehension', value: this.sheet.major_life_event.apprehension },
  { label: 'Victim of physical abuse', value: this.sheet.major_life_event.physical_abuse },
  { label: 'With suicidal tendencies', value: this.sheet.major_life_event.suicidal_tendencies },
  { label: 'Mistaken identity', value: this.sheet.major_life_event.mistaken_identity },
  { label: 'Abandonment', value: this.sheet.major_life_event.abandonment },
  { label: 'Serious Accident', value: this.sheet.major_life_event.serious_accident },
  { label: 'Victim of demolition', value: this.sheet.major_life_event.demolition },
  { label: 'Victim of sexual abuse', value: this.sheet.major_life_event.sexual_abuse },
  { label: 'Victim of verbal abuse', value: this.sheet.major_life_event.verbal_abuse },
  { label: 'Acquired disability', value: this.sheet.major_life_event.disability },
  { label: 'Others (pls. Specify)', value: this.sheet.major_life_event.others }
];

// Split the events into two columns (left and right)
const halfLength = Math.ceil(majorLifeEvents.length / 2);
const leftColumnEvents = majorLifeEvents.slice(0, halfLength);
const rightColumnEvents = majorLifeEvents.slice(halfLength);

// Track the current Y position
let currentY = offset + 2;

// Loop through both columns and draw items on the left and right at the same Y position
for (let i = 0; i < halfLength; i++) {
  // Render the left column
  if (leftColumnEvents[i]) {
    currentY = addTextWithCheckboxAndWrapping(pdf, leftColumnEvents[i].label, leftColumnX, currentY, leftColumnEvents[i].value, 90, pageHeight, footerHeight, rowHeight1);
  }

  // Render the right column
  if (rightColumnEvents[i]) {
    currentY = addTextWithCheckboxAndWrapping(pdf, rightColumnEvents[i].label, rightColumnX, currentY, rightColumnEvents[i].value, 90, pageHeight, footerHeight, rowHeight1);
  }

  // Increment Y for the next row in both columns
  currentY += rowHeight1;
}
offset += 50;
// Section B: Enduring Life Strain
pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
pdf.setFont('arialbd', 'bold');
pdf.setFontSize(12);
pdf.text('B. Enduring Life Strain:', 20, offset ); // Use the current dynamic offset value

offset += 10; // Add some space after the title

pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
pdf.setFont('Arial', 'normal');
pdf.setFontSize(12); // Regular text font size

// Function to draw a checkbox and checkmark with blue background and blue border when checked
function drawCheckboxWithCheckmark(pdf, x, y, isChecked) {
  const boxSize = 5; // Size of the checkbox

  if (isChecked) {
    // If checked, set the background color and border color to light blue
    pdf.setFillColor(0, 102, 255); // Blue background color
    pdf.setDrawColor(0, 102, 255); // Blue border color (same as background)
    pdf.rect(x, y - boxSize + 1, boxSize, boxSize, 'FD'); // Filled and outlined rectangle
  } else {
    // If not checked, keep normal black border with no background
    pdf.setDrawColor(0, 0, 0); // Black border
    pdf.rect(x, y - boxSize + 1, boxSize, boxSize); // Regular rectangle with border
  }

  if (isChecked) {
    // Draw checkmark if checked
    pdf.setLineWidth(0.3);
    pdf.setDrawColor(255, 255, 255); // White checkmark color
    pdf.line(x + 1, y - 2, x + 2, y); // First part of checkmark
    pdf.line(x + 2, y, x + 4, y - 3); // Second part of checkmark
  }
}

// Use existing data structure for enduring life strain
const enduringLifeStrains = [
  { label: 'Poverty', value: this.sheet.enduring_life_strain.poverty },
  { label: 'Physical illness', value: this.sheet.enduring_life_strain.physical_illness },
  { label: 'Lack of recreational facilities', value: this.sheet.enduring_life_strain.lack_recreational_facilities },
  { label: 'Exclusion from peers', value: this.sheet.enduring_life_strain.exclusion_from_peers },
  { label: 'Other (pls. specify)', value: this.sheet.enduring_life_strain.other },
  { label: 'Constant need to earn for the family', value: this.sheet.enduring_life_strain.constant_need_to_earn },
  { label: 'Lack of educational opportunity', value: this.sheet.enduring_life_strain.lack_education_opportunity },
  { label: 'Exclusion from school', value: this.sheet.enduring_life_strain.exclusion_from_school },
  { label: 'With disability', value: this.sheet.enduring_life_strain.with_disability }
];

// Dynamic function to add checkboxes with text and handle page breaks
function addStrainsWithCheckbox(pdf, strains, startX, startY, pageHeight, footerHeight, rowHeight) {
  let currentY = startY;
  let leftColumnX = 20;
  let rightColumnX = 120;
  
  strains.forEach((strain, index) => {
    const x = index % 2 === 0 ? leftColumnX : rightColumnX; // Alternate between left and right columns
    
    if (currentY + rowHeight > pageHeight - footerHeight) {
      // Check if we need to add a new page
      pdf.addPage();
      currentY = 20; // Reset Y position after a page break
    }

    drawCheckboxWithCheckmark(pdf, x, currentY, strain.value); // Draw the checkbox
    pdf.text(strain.label, x + 10, currentY); // Text next to the checkbox
    
    if (index % 2 === 1) {
      currentY += rowHeight; // Only increment Y after drawing for both columns
    }
  });

  return currentY; // Return the updated Y position
}

// Start the checkboxes in two columns dynamically
offset = addStrainsWithCheckbox(pdf, enduringLifeStrains, 20, offset, pageHeight, footerHeight, rowHeight);
// Start with an initial offset based on where your last section ended
offset += 12; // Adjust this to add some space after the previous section

// Section C: Life Transition
pdf.setFontSize(12);
pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
pdf.setFont('arialbd', 'bold');
pdf.text('C. Life Transition:', 20, offset);

offset += 10; // Add some space after the section title

pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
pdf.setFont('Arial', 'normal');

// Function to draw checkbox, checkmark, background, and outline color
function drawCheckboxWithBackground(pdf, x, y, isChecked) {
  const boxSize = 5; // Size of the checkbox

  if (isChecked) {
    // If checked, set the background color to blue and the border color to blue
    pdf.setFillColor(0, 102, 255); // Blue background
    pdf.setDrawColor(0, 102, 255); // Blue border
    pdf.rect(x, y - boxSize + 1, boxSize, boxSize, 'FD'); // Filled rectangle with blue background and border
  } else {
    // If not checked, keep normal black border with no background
    pdf.setDrawColor(0, 0, 0); // Black border
    pdf.rect(x, y - boxSize + 1, boxSize, boxSize); // Regular rectangle with border
  }

  if (isChecked) {
    // Draw checkmark if checked
    pdf.setLineWidth(0.3);
    pdf.setDrawColor(255, 255, 255); // White checkmark color
    pdf.line(x + 1, y - 2, x + 2, y); // First part of checkmark
    pdf.line(x + 2, y, x + 4, y - 3); // Second part of checkmark
  }
}

// Define life transitions
const lifeTransitions = [
  { label: 'Moving from one neighbour to another', value: this.sheet.life_transition.moving_neighbour },
  { label: 'Changing peer group', value: this.sheet.life_transition.changing_peer_group },
  { label: 'Moving to another place of residence due to demolition', value: this.sheet.life_transition.moving_due_to_demolition },
  { label: 'Moving to another place of residence due to disaster', value: this.sheet.life_transition.moving_due_to_disaster },
  { label: 'Moving from biological family to a kinship/foster placement', value: this.sheet.life_transition.kinship_foster_placement },
  { label: 'Beginning romantic relationship', value: this.sheet.life_transition.beginning_romantic_relationship },
  { label: 'Beginning romantic relationship of parents', value: this.sheet.life_transition.beginning_parents_romantic_relationship },
  { label: 'Others (pls. specify)', value: this.sheet.life_transition.others }
];

// Dynamic function to add life transitions with checkboxes and handle page breaks
function addLifeTransitions(pdf, transitions, startY, pageHeight, footerHeight, rowHeight) {
  let currentY = startY;

  transitions.forEach((transition) => {
    // Check if we need to add a new page
    if (currentY + rowHeight > pageHeight - footerHeight) {
      pdf.addPage();
      currentY = 20; // Reset Y position after a page break
    }

    drawCheckboxWithBackground(pdf, 20, currentY, transition.value); // Draw checkbox
    pdf.text(transition.label, 30, currentY); // Add text next to checkbox

    currentY += rowHeight; // Move Y down for the next item
  });

  return currentY; // Return the updated Y position
}

// Start adding life transitions with the current dynamic offset
offset = addLifeTransitions(pdf, lifeTransitions, offset, pageHeight, footerHeight, rowHeight);

// Update the current offset dynamically after the previous section
offset += 7; // Adjust this to add some space after the previous section

// Section D: Development Changes
pdf.setFontSize(12);
pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
pdf.setFont('arialbd', 'bold');
pdf.text('D. Development Changes:', 20, offset); // Use dynamic offset

offset += 10; // Add some space after the section title

pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
pdf.setFont('Arial', 'normal');

// Function to draw checkbox, checkmark, background, and outline color
function drawCheckboxWithBackground(pdf, x, y, isChecked) {
  const boxSize = 5; // Size of the checkbox

  if (isChecked) {
    // If checked, set the background color to blue and the border color to blue
    pdf.setFillColor(0, 102, 255); // Blue background
    pdf.setDrawColor(0, 102, 255); // Blue border
    pdf.rect(x, y - boxSize + 1, boxSize, boxSize, 'FD'); // Filled rectangle with blue background and border
  } else {
    // If not checked, keep normal black border with no background
    pdf.setDrawColor(0, 0, 0); // Black border
    pdf.rect(x, y - boxSize + 1, boxSize, boxSize); // Regular rectangle with border
  }

  if (isChecked) {
    // Draw checkmark if checked
    pdf.setLineWidth(0.3);
    pdf.setDrawColor(255, 255, 255); // White checkmark color
    pdf.line(x + 1, y - 2, x + 2, y); // First part of checkmark
    pdf.line(x + 2, y, x + 4, y - 3); // Second part of checkmark
  }
}

// Dynamic function to add development changes with checkboxes and handle page breaks
function addDevelopmentChanges(pdf, changes, startY, pageHeight, footerHeight, rowHeight) {
  let currentY = startY;

  changes.forEach((change) => {
    // Check if we need to add a new page
    if (currentY + rowHeight > pageHeight - footerHeight) {
      pdf.addPage();
      currentY = 20; // Reset Y position after a page break
    }

    drawCheckboxWithBackground(pdf, 20, currentY, change.value); // Draw checkbox
    pdf.text(change.label, 30, currentY); // Add text next to checkbox

    currentY += rowHeight; // Move Y down for the next item
  });

  return currentY; // Return the updated Y position
}

// Define development changes
const developmentChanges = [
  { label: 'Early childhood 1-6 yrs. Old', value: this.sheet.development_changes.early_childhood },
  { label: 'School age 7-12 yrs. Old', value: this.sheet.development_changes.school_age },
  { label: 'Adolescence 13-18 yrs. old', value: this.sheet.development_changes.adolescence }
];

// Add development changes dynamically with page break handling
offset = addDevelopmentChanges(pdf, developmentChanges, offset, pageHeight, footerHeight, rowHeight);

// Update the current offset dynamically after the previous section
offset += 7; // Adjust this to add some space after the previous section

// Section E: Normalization
pdf.setFontSize(12);
pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
pdf.setFont('arialbd', 'bold');
pdf.text('E. Normalization:', 20, offset);

offset += 10; // Add some space after the section title

pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
pdf.setFont('Arial', 'normal');

// Function to dynamically add normalization items in a single column with page break handling
function addNormalizationItemsSingleColumn(pdf, items, startY, pageHeight, footerHeight, rowHeight) {
  let currentY = startY; // Start Y coordinate
  const columnX = 25; // X coordinate for the single column

  // Loop through all items to render in one column
  items.forEach((item) => {
    // Check for page break before rendering
    if (currentY + rowHeight > pageHeight - footerHeight) {
      pdf.addPage();
      currentY = 20; // Reset Y position for the new page
    }

    // Apply indentation if necessary
    const indent = (item.indent) ? 10 : 0;

    // Render the checkbox and label
    drawCheckboxWithBackground(pdf, columnX + indent - 5, currentY, item.value);
    pdf.text(item.label, columnX + indent + 5, currentY);

    // Increment Y position for the next item
    currentY += rowHeight;
  });

  return currentY; // Return the updated Y position
}

// Define normalization items dynamically (including indents for requested items)
const normalizationItems = [
  { label: 'Legality/law enforcement (weak)', value: this.sheet.normalization.legality_law_enforcement },
  { label: 'Availability of:', value: this.sheet.normalization.commercial_sex },
  { label: 'Commercial sex', value: this.sheet.normalization.commercial_sex, indent: true },
  { label: 'Substance/illegal drugs', value: this.sheet.normalization.substance_illegal_drugs, indent: true },
  { label: 'Pornography materials to include video tapes', value: this.sheet.normalization.pornography_materials, indent: true },
  { label: 'Red houses', value: this.sheet.normalization.red_houses, indent: true },
  { label: 'Price (least expensive)', value: this.sheet.normalization.price_least_expensive },
  { label: 'Advertisement/sponsorship/media presentation', value: this.sheet.normalization.advertisement_media },
  { label: 'Advertisement promoting liquors/cigarettes/', value: this.sheet.normalization.advertisement_promoting_liquors, split: true, indent: true },
  { label: 'Television shows', value: this.sheet.normalization.television_shows, indent: true },
  { label: 'Movies', value: this.sheet.normalization.movies, indent: true },
  { label: 'Printed materials', value: this.sheet.normalization.printed_materials, indent: true },
  { label: 'Community acceptance', value: this.sheet.normalization.community_acceptance },
  { label: 'Source of income', value: this.sheet.normalization.source_of_income, indent: true },
  { label: 'Involved in actual trade/production', value: this.sheet.normalization.involve_in_trade, indent: true },
  { label: 'Role of culture (culturally accepted)', value: this.sheet.normalization.role_of_culture },
  { label: 'Smoking', value: this.sheet.normalization.smoking, indent: true },
  { label: 'Drinking', value: this.sheet.normalization.drinking, indent: true },
  { label: 'Abuse', value: this.sheet.normalization.abuse, indent: true },
  { label: 'Gambling', value: this.sheet.normalization.gambling, indent: true },
  { label: 'Illicit relationship', value: this.sheet.normalization.illicit_relationship, indent: true },
  { label: 'Incest relationship', value: this.sheet.normalization.incest_relationship, indent: true },
  { label: 'Rugby sniffing', value: this.sheet.normalization.rugby_sniffing, indent: true},
  { label: 'Polygamous Relationship', value: this.sheet.normalization.polygamous_relationship, indent: true },
  { label: 'Begging', value: this.sheet.normalization.begging, indent: true }
];

// Add normalization items dynamically in a single column with aligned Y coordinates
offset = addNormalizationItemsSingleColumn(pdf, normalizationItems, offset, pageHeight, footerHeight, rowHeight);


// Function to update the offset after each section
function updateOffset(value) {
  offset += value; // Increase offset by specified value
}

// Section F: Feelings / Behavior towards the incident
pdf.setFontSize(12);
pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
pdf.setFont('arialbd', 'bold');
pdf.text('F. Feelings / Behaviour towards the incident:', 20, offset + 5);
updateOffset(15); // Add space after the section title
pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
pdf.setFont('Arial', 'normal');

// Function to dynamically add feelings and behavior items with aligned Y coordinates
function addFeelingsItemsAligned(pdf, items, startY, pageHeight, footerHeight, rowHeight) {
  let currentY = startY;
  const leftColumnX = 25;
  const middleColumnX = 90;
  const rightColumnX = 155;

  for (let i = 0; i < Math.ceil(items.length / 3); i++) {
    const leftItem = items[i];
    const middleItem = items[i + Math.ceil(items.length / 3)];
    const rightItem = items[i + 2 * Math.ceil(items.length / 3)];

    if (currentY + rowHeight > pageHeight - footerHeight) {
      pdf.addPage();
      currentY = 20; // Reset Y position for the new page
    }

    // Render the left column item
    if (leftItem) {
      drawCheckboxWithBackground(pdf, leftColumnX - 5, currentY, leftItem.value);
      pdf.text(leftItem.label, leftColumnX + 5, currentY);
    }

    // Render the middle column item
    if (middleItem) {
      drawCheckboxWithBackground(pdf, middleColumnX - 5, currentY, middleItem.value);
      pdf.text(middleItem.label, middleColumnX + 5, currentY);
    }

    // Render the right column item
    if (rightItem) {
      drawCheckboxWithBackground(pdf, rightColumnX - 5, currentY, rightItem.value);
      pdf.text(rightItem.label, rightColumnX + 5, currentY);
    }

    currentY += rowHeight;
  }

  return currentY; // Return the updated Y position
}

// Define feelings and behavior items
const feelingsItems = [
  { label: 'stow away', value: this.sheet.behaviour_towards_incident.stow_away },
  { label: 'irritable', value: this.sheet.behaviour_towards_incident.irritable },
  { label: 'Delinquent behaviour', value: this.sheet.behaviour_towards_incident.delinquent_behaviour },
  { label: 'stealing', value: this.sheet.behaviour_towards_incident.stealing },
  { label: 'begging', value: this.sheet.behaviour_towards_incident.begging },
  { label: 'staying in the street', value: this.sheet.behaviour_towards_incident.staying_in_street },
  { label: 'indulge in illegal substance', value: this.sheet.behaviour_towards_incident.indulge_in_illegal_substance },
  { label: 'unresponsive/ passive', value: this.sheet.behaviour_towards_incident.unresponsive_passive },
  { label: 'withdrawal', value: this.sheet.behaviour_towards_incident.withdrawal },
  { label: 'snatching', value: this.sheet.behaviour_towards_incident.snatching },
  { label: 'others (pls. specify)', value: this.sheet.behaviour_towards_incident.others }
];

// Dynamically add feelings items to the PDF
offset = addFeelingsItemsAligned(pdf, feelingsItems, offset, pageHeight, footerHeight, rowHeight);

// Function to update the offset after each section
function updateOffset(value) {
  offset += value; // Increase offset by specified value
}
offset += -10; // Increment offset for each attachment item

pdf.setFontSize(12);
pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
pdf.setFont('arialbd', 'bold');
updateOffset(10); // Add space after the section title
pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
pdf.setFont('Arial', 'normal');

// Feelings items
const feelingsItems1 = [
  // Left column
  { label: 'Feeling', value: this.sheet.normalization.feeling_of_freedom, x: 25 },
  { label: 'Feeling of Freedom', value: this.sheet.normalization.feeling_of_freedom, x: 30 },
  { label: 'Hatred', value: this.sheet.normalization.hatred, x: 30 },
  { label: 'Independence', value: this.sheet.normalization.independence, x: 30 },
  { label: 'Others (pls specify)', value: this.sheet.normalization.others, x: 30 },

  // Right column
  { label: 'Contented', value: this.sheet.normalization.contented, x: 90 },
  { label: 'Belongingness', value: this.sheet.normalization.belongingness, x: 90 },
  { label: 'Guilt', value: this.sheet.normalization.guilt, x: 90 },
  { label: 'Rebellion', value: this.sheet.normalization.rebellion, x: 90 }
];

// Function to dynamically add Feelings section with page break handling
function addFeelingsSection(pdf, items, startY, pageHeight, footerHeight, rowHeight) {
  let currentY = startY;

  // Loop through half of the items for the left column and another half for the right column
  for (let i = 0; i < Math.ceil(items.length / 2); i++) {
    const leftItem = items[i];
    const rightItem = items[i + Math.ceil(items.length / 2)];

    // Check for page break before rendering
    if (currentY + rowHeight > pageHeight - footerHeight) {
      pdf.addPage();
      currentY = 20; // Reset Y position after a page break
    }

    // Render left column item
    if (leftItem) {
      drawCheckboxWithBackground(pdf, leftItem.x - 5, currentY, leftItem.value); // Checkbox
      pdf.text(leftItem.label, leftItem.x + 5, currentY); // Label
    }

    // Render right column item
    if (rightItem) {
      drawCheckboxWithBackground(pdf, rightItem.x - 5, currentY, rightItem.value); // Checkbox
      pdf.text(rightItem.label, rightItem.x + 5, currentY); // Label
    }

    // Increment Y position for the next row in both columns
    currentY += rowHeight;
  }

  return currentY; // Return the updated Y position
}

// Function to check and add a new page if necessary
function checkAndAddPage(pdf, offset, pageHeight, footerHeight) {
  if (offset > pageHeight - footerHeight) {
    pdf.addPage(); // Add a new page
    return 20; // Reset Y offset for the new page
  }
  return offset; // Return the current offset if no new page is needed
}

// Define row height for attachments
const rowHeight4 = 3; // Set the desired row height

// Dynamically add feelings section to the PDF
offset = addFeelingsSection(pdf, feelingsItems1, offset, pageHeight, footerHeight, rowHeight);

// Section G: Attachments
pdf.setFontSize(12);
pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
pdf.setFont('arialbd', 'bold');
pdf.text('G. Attachments:', 20, offset + 5);
updateOffset(10); // Add space after the section title

// Set the initial Y position for the attachments section using the updated offset
const baseY = offset + 5; // Start from the current offset
pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
pdf.setFont('Arial', 'normal');

// Define attachments items with their respective X positions for three columns
const attachmentsItems = [
  { label: 'Mother', value: this.sheet?.attachments?.mother || false },
  { label: 'Grandmother', value: this.sheet?.attachments?.grandmother || false },
  { label: 'Aunt', value: this.sheet?.attachments?.aunt || false },
  { label: 'Neighbour', value: this.sheet?.attachments?.neighbour || false },
  { label: 'Cousin', value: this.sheet?.attachments?.cousin || false },
  { label: 'Father', value: this.sheet?.attachments?.father || false },
  { label: 'Grandfather', value: this.sheet?.attachments?.grandfather || false },
  { label: 'Uncle', value: this.sheet?.attachments?.uncle || false },
  { label: 'Peer', value: this.sheet?.attachments?.peer || false },
  { label: 'Schoolmate', value: this.sheet?.attachments?.schoolmate || false },
  { label: 'Classmate', value: this.sheet?.attachments?.classmate || false }
];

// Define column X positions
const columnX = [25, 90, 155]; // X positions for three columns

// Loop through the items and add them to the PDF
attachmentsItems.forEach((item, index) => {
  const columnIndex = index % 3; // Determine column index
  const rowIndex = Math.floor(index / 3); // Determine row index

  // Calculate the X and Y coordinates
  const x = columnX[columnIndex];
  let y = baseY + (rowIndex * rowHeight4); // Y position based on rowHeight4

  // Check and add a new page if necessary
  offset = checkAndAddPage(pdf, y, pageHeight, footerHeight);
  y = offset + (rowIndex * rowHeight4); // Recalculate Y position after potential page addition

  drawCheckboxWithBackground(pdf, x - 5, y, item.value);
  pdf.text(item.label, x + 5, y);
});

// Update offset after the last item
offset += (Math.ceil(attachmentsItems.length / 3) * rowHeight4) + 10; // Add space after the section

// Section H: Skills
pdf.setFontSize(12);
pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
pdf.setFont('arialbd', 'bold');
pdf.text('H. Skills:', 20, offset);
updateOffset(10); // Add space after the section title
pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
pdf.setFont('Arial', 'normal');

// Define the skills array
const skillsItems = [
  { label: 'Problem solving', value: this.sheet.skills.problem_solving },
  { label: 'Interpersonal relationship', value: this.sheet.skills.interpersonal_relationship },
  { label: 'Communication skills', value: this.sheet.skills.communication_skills },
  { label: 'Vocational skills', value: this.sheet.skills.vocational_skills },
  { label: 'Critical thinking', value: this.sheet.skills.critical_thinking },
  { label: 'Self-awareness', value: this.sheet.skills.self_awareness },
  { label: 'Coping skills', value: this.sheet.skills.coping_skills },
  { label: 'Survival skills', value: this.sheet.skills.survival_skills },
  { label: 'Decision making skills', value: this.sheet.skills.decision_making_skills },
  { label: 'Comprehension', value: this.sheet.skills.comprehension },
  { label: 'Others', value: this.sheet.skills.others }
];

// Function to add skill items with checkboxes and styles
function addSkillsItems(pdf, items, startY, pageHeight, footerHeight, rowHeight) {
  let currentY = startY;

  items.forEach((item, index) => {
    // Determine column index and row index
    const columnIndex = index % 3; // Three columns
    const rowIndex = Math.floor(index / 3); // Row index based on item position

    // Calculate the X and Y coordinates
    const x = columnX[columnIndex];
    let y = startY + (rowIndex * rowHeight); // Y position based on row index

    // Check if the next item fits on the current page
    if (y + rowHeight > pageHeight - footerHeight) {
      pdf.addPage();
      currentY = 20; // Reset Y position for the new page
      y = currentY + (rowIndex * rowHeight); // Recalculate Y position
    }

    // Draw checkbox with background and outline
    drawCheckboxWithBackground(pdf, x - 5, y, item.value);

    // Draw the label next to the checkbox
    pdf.text(item.label, x + 5, y);
  });

  return currentY + (Math.ceil(items.length / 3) * rowHeight); // Return the updated Y position
}

// Function to draw checkbox with optional checkmark
function drawCheckbox(pdf, x, y, checked) {
  pdf.rect(x, y - 5, 6, 6); // Draw the checkbox outline
  if (checked) {
    pdf.text('X', x + 1, y); // Draw checkmark
  }
}

// Add skill items dynamically
offset = addSkillsItems(pdf, skillsItems, offset, pageHeight, footerHeight, rowHeight);

// Continue with the next section if needed after adding skills
offset += 10; // Adjust spacing as needed for the next section
const rowHeight2 = 6; // Row height for consistent spacing

// Set the font size and style for the Resources section
pdf.setFontSize(12);
pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
pdf.setFont('arialbd', 'bold');
pdf.text('Resources:', 20, offset);

// Set font and size for content
pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
pdf.setFont('Arial', 'normal');
offset += -1; // Add some spacing after the "Resources" title

// Define the base X positions for the two columns
const column1X = 20;  // X position for the first column
const column2X = 100; // X position for the second column


// Group Internal and External resources separately
const internalResourcesItems = [
  { label: 'Internal resources', value: this.sheet.resources.internal, column: 1 },
  { label: 'Intelligence', value: this.sheet.resources.intelligence, indent: true, column: 1 },
  { label: 'Spirituality', value: this.sheet.resources.spirituality, indent: true, column: 1 },
  { label: 'Resourceful', value: this.sheet.resources.resourceful, indent: true, column: 1 },
  { label: 'Obedient', value: this.sheet.resources.obedient, column: 1 },
  { label: 'Others', value: this.sheet.resources.others, indent: true, column: 1 },
  { label: 'Education', value: this.sheet.resources.education, indent: true, column: 2 },
  { label: 'Discipline', value: this.sheet.resources.discipline, indent: true, column: 2 },
  { label: 'Respectful', value: this.sheet.resources.respectful, indent: true, column: 2 },
  { label: 'Submissive', value: this.sheet.resources.submissive, indent: true, column: 2 },
  ];

const externalResourcesItems = [
  { label: 'External Resources', value: this.sheet.resources.external, column: 1 },
  { label: 'Family', value: this.sheet.resources.family, indent: true, column: 1 },
  { label: 'Peers', value: this.sheet.resources.peers, indent: true, column: 1 },
  { label: 'Health services', value: this.sheet.resources.health_services, indent: true, column: 1 },
  { label: 'Recreational services', value: this.sheet.resources.recreational_services, indent: true, column: 1 },
  { label: 'NGOs existing in the community', value: this.sheet.resources.ngos, column: 1 },
  { label: 'Civic Organization', value: this.sheet.resources.civic_organization, column: 1 },
  { label: 'Others (pls. specify)', value: this.sheet.resources.others, column: 1 },

  // Additional items from your HTML
  { label: 'Other Street Children', value: this.sheet.resources.street_children, column: 2 },
  { label: 'Street Educators', value: this.sheet.resources.street_educators, column: 2 },
  { label: 'Vocational Services', value: this.sheet.resources.vocational_services, column: 2 },
  { label: 'LGU Staff at All Levels', value: this.sheet.resources.lgu_staff, column: 2 },
  { label: 'People’s Organization', value: this.sheet.resources.peoples_organization, column: 2 },
  { label: 'Faith Based Organization', value: this.sheet.resources.faith_based_organization, column: 2 }
];


// Set base Y position for resources
let resourceOffset = offset + 10;

// Function to render a resource section
function renderResourcesSection(pdf, items, column1X, column2X, rowHeight, resourceOffset, pageHeight, footerHeight) {
  const leftColumnItems = items.filter(item => item.column === 1);
  const rightColumnItems = items.filter(item => item.column === 2);
  
  const maxRows = Math.max(leftColumnItems.length, rightColumnItems.length);
  
  for (let i = 0; i < maxRows; i++) {
    const y = resourceOffset + (i * rowHeight);

    // Check if the next item fits on the current page
    if (y + rowHeight > pageHeight - footerHeight) {
      pdf.addPage();
      resourceOffset = 20; // Reset Y position for the new page
    }

    if (leftColumnItems[i]) {
      drawCheckboxWithCheckmark(pdf, column1X, resourceOffset + (i * rowHeight), leftColumnItems[i].value);
      pdf.text(leftColumnItems[i].label, column1X + 10, resourceOffset + (i * rowHeight));
    }

    if (rightColumnItems[i]) {
      drawCheckboxWithCheckmark(pdf, column2X, resourceOffset + (i * rowHeight), rightColumnItems[i].value);
      pdf.text(rightColumnItems[i].label, column2X + 10, resourceOffset + (i * rowHeight));
    }
  }
  
  return resourceOffset + (maxRows * rowHeight);
}

// Render Internal Resources section
pdf.setFont('arialbd', 'bold');
pdf.setFont('Arial', 'normal');

resourceOffset = renderResourcesSection(pdf, internalResourcesItems, column1X, column2X, rowHeight2, resourceOffset, pageHeight, footerHeight);

// Add space between sections
resourceOffset += 10; 

resourceOffset = renderResourcesSection(pdf, externalResourcesItems, column1X, column2X, rowHeight2, resourceOffset, pageHeight, footerHeight);

offset += 20;
// Section for Activities or Source of Income
pdf.setFontSize(12);
pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
pdf.setFont('arialbd', 'bold');
pdf.text('IV. Activities or source of income in the street:', 20, resourceOffset + 10);

// Set constants for row height
const rowHeight3 = 6; // Set your desired row height here

// Set font and size for content
pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
pdf.setFont('Arial', 'normal');

// Source of Income Section with aligned columns
const incomeItems = [
  { label: 'Vending', value: this.sheet.source_of_income_in_street.vending, column: 1 },
  { label: 'Car wash boy', value: this.sheet.source_of_income_in_street.car_wash_boy, column: 1 },
  { label: 'Rugby user', value: this.sheet.source_of_income_in_street.rugby_user, column: 1 },
  { label: 'Porter', value: this.sheet.source_of_income_in_street.porter, column: 2 },
  { label: 'Barker', value: this.sheet.source_of_income_in_street.barker, column: 2 }
];

// Set base Y position for income items
let incomeOffset = resourceOffset + 20;

// Function to check and add a new page if necessary
function checkAndAddPage(pdf, currentOffset, pageHeight, footerHeight) {
    if (currentOffset > pageHeight - footerHeight) {
        pdf.addPage(); // Add a new page
        return 20; // Reset offset to a new starting point on the new page
    }
    return currentOffset; // Return the current offset if no new page is added
}

// Separate items by column
const column1Items = incomeItems.filter(item => item.column === 1);
const column2Items = incomeItems.filter(item => item.column === 2);

// Add income items for column 1
column1Items.forEach((item, index) => {
  const x = column1X; // Fixed X position for column 1
  incomeOffset = checkAndAddPage(pdf, incomeOffset, pageHeight, footerHeight); // Check for page overflow
  const y = incomeOffset + (index * rowHeight3); // Increment Y position using row height
  drawCheckboxWithCheckmark(pdf, x, y, item.value);
  pdf.text(item.label, x + 10, y);
});

// Add income items for column 2
column2Items.forEach((item, index) => {
  const x = column2X; // Fixed X position for column 2
  incomeOffset = checkAndAddPage(pdf, incomeOffset, pageHeight, footerHeight); // Check for page overflow
  const y = incomeOffset + (index * rowHeight3); // Increment Y position using row height
  drawCheckboxWithCheckmark(pdf, x, y, item.value);
  pdf.text(item.label, x + 10, y);
});

// Earnings/ Income Section
incomeOffset += 20; // Adjust offset for earnings section
incomeOffset = checkAndAddPage(pdf, incomeOffset, pageHeight, footerHeight); // Check for page overflow
pdf.text('Earnings/ income:', 20, incomeOffset);
pdf.text(this.sheet.earnings_income || '', 55, incomeOffset);
pdf.setLineWidth(0.2);
pdf.line(55, incomeOffset + 1, 200, incomeOffset + 1);

// Hours of Stay in the Street
incomeOffset += 10; // Adjust offset for hours section
incomeOffset = checkAndAddPage(pdf, incomeOffset, pageHeight, footerHeight); // Check for page overflow
pdf.text('Hours of stay in the street:', 20, incomeOffset);
pdf.text(this.sheet.hrs_stay_in_street || '', 70, incomeOffset);
pdf.line(70, incomeOffset + 1, 200, incomeOffset + 1);

// Length of Stay in the Street
incomeOffset += 10; // Adjust offset for length section
incomeOffset = checkAndAddPage(pdf, incomeOffset, pageHeight, footerHeight); // Check for page overflow
pdf.text('Length of stay in the street:', 20, incomeOffset);
pdf.text(this.sheet.length_stay_in_street || '', 70, incomeOffset);
pdf.line(70, incomeOffset + 1, 200, incomeOffset + 1);

// Common Substance Used
incomeOffset += 10; // Adjust offset for substance section
incomeOffset = checkAndAddPage(pdf, incomeOffset, pageHeight, footerHeight); // Check for page overflow
pdf.text('Common Substance used:', 20, incomeOffset);
pdf.text(this.sheet.common_substance_used || '', 70, incomeOffset);
pdf.line(70, incomeOffset + 1, 200, incomeOffset + 1);

// Function to check and add a new page if necessary
function checkAndAddPage(pdf, currentOffset, pageHeight, footerHeight) {
    const maxHeight = pageHeight - footerHeight; // Define a maximum height before needing a new page
    if (currentOffset > maxHeight) {
        pdf.addPage(); // Add a new page
        return 20; // Reset offset to a new starting point on the new page
    }
    return currentOffset; // Return the current offset if no new page is added
}
function addTextWithWrappingAndLines(pdf, text, x, y, maxWidth, pageHeight, footerHeight, rowHeight) {
    const lines = pdf.splitTextToSize(text, maxWidth);
    lines.forEach((line) => {
        // Check if adding this line would exceed the page height
        if (y + rowHeight > pageHeight - footerHeight) {
            pdf.addPage(); // Add a new page
            y = 20; // Reset y position
        }
        pdf.text(line, x, y);
        pdf.line(x, y + 1, x + maxWidth, y + 1); // Draw line under the text
        y += rowHeight; // Move down for the next line
    });
    return y; // Return the new y position
}
// Initial Assessment
pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
pdf.setFont('arialbd', 'bold');    
const initialAssessmentY = incomeOffset + 10;
pdf.text('INITIAL ASSESSMENT:', 20, initialAssessmentY);

pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
pdf.setFont('Arial', 'normal');
let currentYS = initialAssessmentY + 10; // Start just below the title

// Add assessment lines using the utility function
const initialAssessmentLines = (this.sheet.initial_assessment || '').split('\n');
initialAssessmentLines.forEach(line => {
    currentYS = addTextWithWrappingAndLines(pdf, line, 20, currentYS, 180, pageHeight, footerHeight, 10);
});



// Space before recommendations
currentYS += 5; // Add space before recommendations



// Recommendations
pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
pdf.setFont('arialbd', 'bold');  
pdf.text('RECOMMENDATIONS:', 20, currentYS);
pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
pdf.setFont('Arial', 'normal');

currentYS += 10; // Initialize Y position for recommendations
const recommendationsLines = (this.sheet.recommendations || '').split('\n');

// Add recommendations lines using the utility function
recommendationsLines.forEach(line => {
    currentYS = addTextWithWrappingAndLines(pdf, line, 20, currentYS, 180, pageHeight, footerHeight, 10);
});

// Prepare for the next section with dynamic page check
currentYS += 10; // Add additional space before the next section


// Check and add a new page if necessary before "Prepared by"
currentYS = checkAndAddPage(pdf, currentYS, pageHeight, footerHeight);
pdf.text('Prepared by:', 20, currentYS);

pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
pdf.setFont('arialbd', 'bold');  
const preparedByText = this.sheet.prepared_by || '';

// Check and add a new page if necessary before the prepared by text
currentYS = checkAndAddPage(pdf, currentYS, pageHeight, footerHeight);
pdf.text(preparedByText, 20, currentYS + 10);

// Calculate the width of the text
const textWidth = pdf.getTextWidth(preparedByText);

// Draw a line below the text, with the width matching the text's width
pdf.line(20, currentYS + 11, 20 + textWidth, currentYS + 11);

// Store the y-coordinate for Reviewed By to align later
const reviewedByY = currentYS + 15; // Adjust as needed for spacing

// Add SWO text
currentYS += 15; // Move down for SWO text
currentYS = checkAndAddPage(pdf, currentYS, pageHeight, footerHeight);
pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
pdf.setFont('Arial', 'normal');
pdf.text('SWO __/Case Manager', 20, currentYS);

// Reviewed by section
currentYS = checkAndAddPage(pdf, reviewedByY, pageHeight, footerHeight); // Use the stored y-coordinate
pdf.text('Reviewed by:', 130, reviewedByY - 15); // Align y-coordinate

pdf.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
pdf.setFont('arialbd', 'bold'); 
const reviewerText = 'ANGELIC B. PAÑA, RSW, MSSW';

// Check and add a new page if necessary before the reviewer text
currentYS = checkAndAddPage(pdf, reviewedByY, pageHeight, footerHeight);
pdf.text(reviewerText, 130, reviewedByY ); // Align y-coordinate

// Draw a line below the reviewer's name
pdf.line(130, reviewedByY + 1, 200, reviewedByY + 1); 

// Add position title
currentYS += 15; // Move down for position title
currentYS = checkAndAddPage(pdf, currentYS, pageHeight, footerHeight);
pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
pdf.setFont('Arial', 'normal');
pdf.text('Center Head/SWO IV', 130, currentYS - 10);

// Final offset update after the section
incomeOffset = currentYS + 30; // Update incomeOffset for the next section


      // Save the PDF
      pdf.save('General Intake Sheet.pdf');
    },
  }
};
</script>


<style scoped>
.graph-background {
    background-image: linear-gradient(to right, #cccccc 1px, transparent 1px), 
                      linear-gradient(to bottom, #cccccc 1px, transparent 1px);
    background-size: 15px 15px; /* Adjust size as per your need */
  }
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
