<template>
  <!-- Tabs for Actions -->
  <div class="flex -ml-2 justify-end bg-transparent border -mr-9 border-gray-300 p-4  space-x-4 -mt-9">
      <button @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.3 2.7a1 1 0 011.4 0l1.3 1.3a1 1 0 010 1.4l-9.4 9.4a1 1 0 01-.6.3l-2.8.6a1 1 0 01-1.2-1.2l.6-2.8a1 1 0 01.3-.6l9.4-9.4z" />
        </svg>
        <span>Edit</span>
      </button>
         <!-- Pagination Component -->
    <Pagination 
      :totalPages="totalPages" 
      :currentPage="currentPage" 
      @update:currentPage="currentPage = $event" 
    />
      <button @click="openModal" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
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
        
      <label class="block text-base font-semibold text-gray-700 mr-4 whitespace-nowrap">Name of client:</label>
      <input type="text" v-model="sheet.name" class="flex-grow border-b-2 border-black border-t-0 mr-4 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
      </div>
  
   <div class="grid grid-cols-2 gap-4">
     <div class="flex items-center mb-4">
       <div class="flex-grow flex items-center mr-4">
         <label class="block text-base font-semibold text-gray-700 mr-4">Age:</label>
         <input type="text" v-model="sheet.age" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
       </div>
     </div>
     <div class="flex items-center mb-4">
       <div class="flex-grow flex items-center mr-4">
         <label class="block text-base font-semibold text-gray-700 mr-4">Sex:</label>
         <input type="text" v-model="sheet.sex" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
       </div>
     </div>
   </div>
   <div class="flex items-center mb-4">
     <div class="flex-grow flex items-center mr-4">
       <label class="block text-base font-semibold text-gray-700 mr-4">Address:</label>
       <input type="text" v-model="sheet.address" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
     </div>
   </div>
   <div class="grid grid-cols-2 gap-4">
     <div class="flex items-center mb-4">
       <div class="flex-grow flex items-center mr-4">
         <label class="block text-base font-semibold text-gray-700 mr-4">Date of Birth:</label>
         <input type="date" v-model="sheet.date_of_birth" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
       </div>
     </div>
     <div class="flex items-center mb-4">
       <div class="flex-grow flex items-center mr-4">
         <label class="block text-base font-semibold text-gray-700 mr-4">Place of birth:</label>
         <input type="text" v-model="sheet.place_of_birth" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
       </div>
     </div>
   </div>
   <div class="flex items-center mb-4">
     <div class="flex-grow flex items-center mr-4">
       <label class="block text-base font-semibold text-gray-700 mr-4">Religion:</label>
       <input type="text" v-model="sheet.religion" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
     </div>
   </div>
   <div class="flex items-center mb-4">
     <div class="flex-grow flex items-center mr-4">
       <label class="block text-base font-semibold text-gray-700 mr-4">Occupation:</label>
       <input type="text" v-model="sheet.occupation" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
     </div>
   </div>
   <div class="flex items-center mb-4">
 <label class="block text-base font-semibold text-gray-700 mr-4 whitespace-nowrap">Highest Educ'l Att't:</label>
 <input type="text" v-model="sheet.highest_educ_att" class="flex-grow border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
</div>
 
   <div class="flex items-center mb-4">
     <div class="flex-grow flex items-center mr-4">
       <label class="block text-base font-semibold text-gray-700 mr-4">Name of School:</label>
       <input type="text" v-model="sheet.school_name" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
     </div>
   </div>
   <div class="flex items-center mb-4">
     <div class="flex-grow flex items-center mr-4">
       <label class="block text-base font-semibold text-gray-700 mr-4">Class Adviser:</label>
       <input type="text" v-model="sheet.class_adviser" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
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
        <input type="text" v-model="sheet.prepared_by" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
        <p>SWO __/Case Manager</p>
      </div>
      <div class="flex flex-col items-end">
        <label class="block text-base font-semibold text-gray-700 mb-8">Reviewed by:</label>
        <div class="text-right">
          <input type="text" v-model="center_head" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
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
      totalPages: 4,
      clientId: null,
      currentPage: 1,
      isModalOpen: false,
      isSaveResultModalOpen: false,
      saveResultTitle: '',
      saveResultMessage: '',
      center_head: '',
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
        reviewed_by: '',  // New field
      }
    };
  },
  mounted() {
    this.clientId = this.$route.params.id;
    console.log('Client ID fetched:', this.clientId); // Console log showing client ID
    this.fetchClientData(this.clientId);
    this.fetchCenterHead(this.clientId);
  },
  watch: {
    '$route.params.id'(newId) {
      this.clientId = newId;
      this.fetchClientData(this.clientId);
      this.fetchCenterHead(this.clientId);
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
    fetchCenterHead(clientId) {
  if (!clientId) {
    console.error("Client ID is missing.");
    return;
  }
  // Make an API request using the client ID
  axios.get(`/api/center-head/${clientId}`)  // Updated endpoint to match the route
    .then(response => {
      this.center_head = response.data.center_head;
      console.log("Fetched center head:", this.center_head); // Log the center head
    })
    .catch(error => {
      console.error("Error fetching center head:", error);
    });
},
saveCenterHead() {
  if (!this.center_head || !this.clientId) {
    return;
  }
  axios
    .put(`/api/update-center-head`, {
      center_head: this.center_head,
      client_id: this.clientId, // Pass the client ID instead of admission ID
    })
    .then(response => {
      this.editMode = false;
      this.fetchClientData(); // Refetch the data to update the UI
    })
    .catch(error => {
      console.error("Error updating center head:", error);
    });
},

    exportToPdf() {
  const pdf = new jsPDF('p', 'mm', [216, 356]); // Legal size: 216mm x 356mm

  // Set default font properties
  pdf.setFont('helvetica', 'normal');
  pdf.setFontSize(11);
  pdf.setLineHeightFactor(1.5);

  // Page 1 content
  let offset = 327; // Initialize offset at the start of page 1

  const imgData = '/images/headerlogo2.png'; // Ensure this is accessible or use base64
  pdf.addImage(imgData, 'PNG', 15, 10, 75, 35); // Increase width to 75 and height to 35

  // Add the header below the image
  pdf.setFontSize(10);
  pdf.setFont('helvetica', 'italic');
  pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 135, 20);

  // Add the title
  pdf.setFont('helvetica', 'bold');
  pdf.setFontSize(18);
  pdf.text('GENERAL INTAKE SHEET', 108, 60, null, null, 'center');
  pdf.setFont('helvetica', 'normal');
  pdf.setFontSize(11);

  // Date
  pdf.setFontSize(11);
  pdf.text(`Date: ${String(this.sheet.date)}`, 160, 70);
  pdf.line(170, 71, 200, 71);

  // Identifying Information
  pdf.setFont('helvetica', 'bold');
  pdf.setFontSize(11);
  pdf.text('I. Identifying Information:', 20, 90);
  pdf.setFont('helvetica', 'normal'); // Reset font to normal for subsequent text

  pdf.setFontSize(11);
  pdf.text(`Name of client:`, 20, 100);
  pdf.text(String(this.sheet.name), 52, 100);
  pdf.line(52, 101, 130, 101);

  pdf.text(`Age:`, 135, 100);
  pdf.text(String(this.sheet.age), 148, 100);
  pdf.line(148, 101, 170, 101);

  pdf.text(`Sex:`, 175, 101);
  pdf.text(String(this.sheet.sex), 187, 100);
  pdf.line(187, 101, 200, 101);

  pdf.text(`Address:`, 20, 110);
  pdf.text(String(this.sheet.address), 42, 110);
  pdf.line(42, 111, 200, 111);

  pdf.text(`Date of Birth:`, 20, 120);
  pdf.text(String(this.sheet.date_of_birth), 48, 120);
  pdf.line(48, 121, 124, 121);

  pdf.text(`Place of birth:`, 130, 120);
  pdf.text(String(this.sheet.place_of_birth), 160, 120);
  pdf.line(160, 121, 200, 121);

  pdf.text(`Religion:`, 20, 130);
  pdf.text(String(this.sheet.religion), 40, 130);
  pdf.line(40, 131, 200, 131);

  pdf.text(`Occupation:`, 20, 140);
  pdf.text(String(this.sheet.occupation), 44, 140);
  pdf.line(44, 141, 200, 141);

  pdf.text(`Highest Educ'l Att't:`, 20, 150);
  pdf.text(String(this.sheet.highest_educ_att), 60, 150);
  pdf.line(60, 151, 200, 151);

  pdf.text(`Name of School:`, 20, 160);
  pdf.text(String(this.sheet.school_name), 56, 160);
  pdf.line(56, 161, 200, 161);

  pdf.text(`Class Adviser:`, 20, 170);
  pdf.text(String(this.sheet.class_adviser), 54, 170);
  pdf.line(54, 171, 200, 171);

  // Problem Presented
  pdf.setFont('helvetica', 'bold'); // Set font to bold
  pdf.setFontSize(11);
  pdf.text('II. Problem Presented:', 20, 190);
  pdf.setFont('helvetica', 'normal'); // Reset font to normal for subsequent text

  pdf.setFontSize(11);
  pdf.text(String(this.sheet.problem_presented), 20, 200, { maxWidth: 180 });
  pdf.line(20, 201, 200, 201);
  pdf.line(20, 207, 200, 207);
  pdf.line(20, 213, 200, 213);
  pdf.line(20, 219, 200, 219);
  pdf.line(20, 225, 200, 225);
  pdf.line(20, 231, 200, 231);

  // Brief Physical Description
  pdf.setFont('helvetica', 'bold'); // Set font to bold
  pdf.setFontSize(11);
  pdf.text('III. Brief Physical Description of the Minor:', 20, 240);
  pdf.setFont('helvetica', 'normal'); // Reset font to normal for subsequent text
  pdf.setFontSize(11);
  pdf.text(String(this.sheet.brief_physical_description), 20, 250, { maxWidth: 170 });
  pdf.line(20, 251, 200, 251);
  pdf.line(20, 257, 200, 257);
  pdf.line(20, 263, 200, 263);
  pdf.line(20, 269, 200, 269);
  pdf.line(20, 275, 200, 275);
  pdf.line(20, 281, 200, 281);
  pdf.line(20, 287, 200, 287);
  // Footer
  pdf.setFont('Times');
  pdf.setFontSize(10);
  pdf.setFont('helvetica', 'bold');
  pdf.text(`PAGE 1 of ${String(this.totalPages)}`, 108, 330, null, null, 'center');
  pdf.setFont('helvetica', 'normal');
  pdf.setLineWidth(0.5);
  pdf.line(20, offset + 5, 210 - 30, offset + 5);
  pdf.setFontSize(8);
  pdf.text('DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City', 100, offset + 10, null, null, 'center');
  pdf.text('Email: rrcy.fo11@dswd.gov.ph    Tel. No.: 293-0306', 108, offset + 15, null, null, 'center');

  // Add the footer image
  const footerImgData = '/images/footerimg.png';
  pdf.addImage(footerImgData, 'PNG', 182, offset, 20, 10);

  // Move to the second page
  pdf.addPage();
  offset = 327; // Reset offset for the second page

  pdf.setFontSize(10);
  pdf.setFont('helvetica', 'italic');
  pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 135, 20);

  // Page 2 content
  pdf.setFont('helvetica', 'normal');
  pdf.setFontSize(11);
      
  // Section A: Major Life Events
  pdf.setFont('helvetica', 'bold');
  pdf.text('A. Major Life Events:', 20, 30);

  pdf.setFont('helvetica', 'normal');
  const majorLifeEvents = [
  { label: 'Death of Parents', value: this.sheet.major_life_event.death_of_parents, x: 20, y: 40 },
  { label: 'Separation from the family', value: this.sheet.major_life_event.separation_from_family, x: 20, y: 50 },
  { label: 'Victim of natural / manmade disaster', value: this.sheet.major_life_event.natural_disaster, x: 20, y: 60 },
  { label: 'Victim of apprehension', value: this.sheet.major_life_event.apprehension, x: 20, y: 70 },
  { label: 'Victim of physical abuse', value: this.sheet.major_life_event.physical_abuse, x: 20, y: 80 },
  { label: 'With suicidal tendencies', value: this.sheet.major_life_event.suicidal_tendencies, x: 20, y: 90 },
  { label: 'Mistaken identity', value: this.sheet.major_life_event.mistaken_identity, x: 20, y: 100 },
  { label: 'Abandonment', value: this.sheet.major_life_event.abandonment, x: 120, y: 40 },
  { label: 'Serious Accident', value: this.sheet.major_life_event.serious_accident, x: 120, y: 50 },
  { label: 'Victim of demolition', value: this.sheet.major_life_event.demolition, x: 120, y: 60 },
  { label: 'Victim of sexual abuse', value: this.sheet.major_life_event.sexual_abuse, x: 120, y: 70 },
  { label: 'Victim of verbal abuse', value: this.sheet.major_life_event.verbal_abuse, x: 120, y: 80 },
  { label: 'Acquired disability', value: this.sheet.major_life_event.disability, x: 120, y: 90 },
  { label: 'Others (pls. Specify)', value: this.sheet.major_life_event.others, x: 120, y: 100 }
  ];

  majorLifeEvents.forEach((event) => {
    pdf.text(`[${event.value ? 'X' : ' '}] ${event.label}`, event.x, event.y);
  }); 
  // Section B: Enduring Life Strain
  pdf.setFont('helvetica', 'bold');
  pdf.text('B. Enduring Life Strain:', 20, 115);

  pdf.setFont('helvetica', 'normal');
  const enduringLifeStrains = [
    { label: 'Poverty', value: this.sheet.enduring_life_strain.poverty, x: 20, y: 125 },
    { label: 'Physical illness', value: this.sheet.enduring_life_strain.physical_illness, x: 20, y: 135 },
    { label: 'Lack of recreational facilities', value: this.sheet.enduring_life_strain.lack_recreational_facilities, x: 20, y: 145 },
    { label: 'Exclusion from peers', value: this.sheet.enduring_life_strain.exclusion_from_peers, x: 20, y: 155 },
    { label: 'Other (pls. specify)', value: this.sheet.enduring_life_strain.other, x: 20, y: 165 },
    { label: 'Constant need to earn for the family', value: this.sheet.enduring_life_strain.constant_need_to_earn, x: 120, y: 125 },
    { label: 'Lack of educational opportunity', value: this.sheet.enduring_life_strain.lack_education_opportunity, x: 120, y: 135 },
    { label: 'Exclusion from school', value: this.sheet.enduring_life_strain.exclusion_from_school, x: 120, y: 145 },
    { label: 'With disability', value: this.sheet.enduring_life_strain.with_disability, x: 120, y: 155 }
  ];

  enduringLifeStrains.forEach((strain) => {
      pdf.text(`[${strain.value ? 'X' : ' '}] ${strain.label}`, strain.x, strain.y);
  });

  const sectionStartY = 180; // Adjust this to set the starting position for the section title

  pdf.setFontSize(11);
  pdf.setFont('helvetica', 'bold');
  pdf.text('C. Life Transition:', 20, sectionStartY);

  // Define life transitions with dynamic x and y coordinates
  const lifeTransitions = [
      { label: 'Moving from one neighbour to another', value: this.sheet.life_transition.moving_neighbour, x: 20, y: sectionStartY + 10 },
      { label: 'Changing peer group', value: this.sheet.life_transition.changing_peer_group, x: 20, y: sectionStartY + 20 },
      { label: 'Moving to another place of residence due to demolition', value: this.sheet.life_transition.moving_due_to_demolition, x: 20, y: sectionStartY + 30 },
      { label: 'Moving to another place of residence due to disaster', value: this.sheet.life_transition.moving_due_to_disaster, x: 20, y: sectionStartY + 40 },
      { label: 'Moving from biological family to a kinship/foster placement', value: this.sheet.life_transition.kinship_foster_placement, x: 20, y: sectionStartY + 50 },
      { label: 'Beginning romantic relationship', value: this.sheet.life_transition.beginning_romantic_relationship, x: 20, y: sectionStartY + 60 },
      { label: 'Beginning romantic relationship of parents', value: this.sheet.life_transition.beginning_parents_romantic_relationship, x: 20, y: sectionStartY + 70 },
      { label: 'Others (pls. specify)', value: this.sheet.life_transition.others, x: 20, y: sectionStartY + 80 }
  ];

  // Add items with checkboxes
  pdf.setFont('helvetica', 'normal');
  lifeTransitions.forEach((transition) => {
      pdf.text(`[${transition.value ? 'X' : ' '}] ${transition.label}`, transition.x, transition.y);
  });

  const developmentChangesStartY = 275; // Adjust this to set the starting position for the Development Changes section

  pdf.setFontSize(11);
  pdf.setFont('helvetica', 'bold');
  pdf.text('D. Development Changes:', 20, developmentChangesStartY);

  // Define development changes with dynamic x and y coordinates
  const developmentChanges = [
      { label: 'Early childhood 1-6 yrs. Old', value: this.sheet.development_changes.early_childhood, x: 20, y: developmentChangesStartY + 10 },
      { label: 'School age 7-12 yrs. Old', value: this.sheet.development_changes.school_age, x: 20, y: developmentChangesStartY + 20 },
      { label: 'Adolescence 13-18 yrs. old', value: this.sheet.development_changes.adolescence, x: 20, y: developmentChangesStartY + 30 }
  ];

  // Add items with checkboxes
  pdf.setFont('helvetica', 'normal');
  developmentChanges.forEach((change) => {
      pdf.text(`[${change.value ? 'X' : ' '}] ${change.label}`, change.x, change.y);
  });

  // Footer for Page 2
  pdf.setFont('Times');
  pdf.setFontSize(10);
  pdf.setFont('helvetica', 'bold');
  pdf.text(`PAGE 2 of ${String(this.totalPages)}`, 108, 330, null, null, 'center');
  pdf.setFont('helvetica', 'normal');
  pdf.setLineWidth(0.5);
  pdf.line(20, offset + 5, 210 - 30, offset + 5);
  pdf.setFontSize(8);
  pdf.text('DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City', 100, offset + 10, null, null, 'center');
  pdf.text('Email: rrcy.fo11@dswd.gov.ph    Tel. No.: 293-0306', 108, offset + 15, null, null, 'center');
  pdf.addImage(footerImgData, 'PNG', 182, offset, 20, 10);

  // Move to the second page
  pdf.addPage();
  offset = 327; // Reset offset for the second page

  pdf.setFontSize(10);
  pdf.setFont('helvetica', 'italic');
  pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 135, 20);

  const normalizationStartY = 30; // Adjust this to set the starting position for the Normalization section
  const feelingsStartY = 165; // Adjust this to set the starting position for the Feelings / Behaviour towards the incident section
  const attachmentsStartY = 218; // Adjust this to set the starting position for the Attachments section
  const skillsStartY = 270; // Adjust this to set the starting position for the Skills section

  // Set font and size for section title
  pdf.setFontSize(11);
  pdf.setFont('helvetica', 'bold');
  pdf.text('E. Normalization:', 20, 30);

  // Set font and size for content
  pdf.setFont('helvetica', 'normal');

  // Define checkbox positions and labels with x and y coordinates
  const normalizationItems = [
    { label: 'legality/law enforcement (weak)', value: this.sheet.normalization.legality_law_enforcement, x: 20, y: 40 },
    { label: 'Availability of:', value: '', x: 20, y: 50 },
    { label: 'Commercial sex', value: this.sheet.normalization.commercial_sex, x: 30, y: 60 },
    { label: 'substance/illegal drugs', value: this.sheet.normalization.substance_illegal_drugs, x: 30, y: 70 },
    { label: 'Pornography materials to include video tapes', value: this.sheet.normalization.pornography_materials, x: 30, y: 80 },
    { label: 'Red houses', value: this.sheet.normalization.red_houses, x: 30, y: 90 },
    { label: 'Price- least expensive', value: this.sheet.normalization.price_least_expensive, x: 20, y: 100 },
    { label: 'Advertisement/ sponsorship/ media presentation', value: this.sheet.normalization.advertisement_media, x: 20, y: 110 },
    { label: 'Advertisement promoting liquors/cigarettes/clubs/', value: this.sheet.normalization.advertisement_promoting_liquors, x: 30, y: 120, split: true },
    { label: 'Television shows', value: this.sheet.normalization.television_shows, x: 30, y: 140 },
    { label: 'Movies', value: this.sheet.normalization.movies, x: 30, y: 150 },
    { label: 'printed materials', value: this.sheet.normalization.printed_materials, x: 130, y: 40 },
    { label: 'Community acceptance', value: this.sheet.normalization.community_acceptance, x: 120, y: 50 },
    { label: 'Source of income', value: this.sheet.normalization.source_of_income, x: 130, y: 60 },
    { label: 'involve in actual trade/ production', value: this.sheet.normalization.involve_in_trade, x: 130, y: 70 },
    { label: 'Role of culture (culturally accepted)', value: this.sheet.normalization.role_of_culture, x: 120, y: 80 },
    { label: 'Smoking', value: this.sheet.normalization.smoking, x: 130, y: 90 },
    { label: 'Abuse', value: this.sheet.normalization.abuse, x: 130, y: 100 },
    { label: 'Illicit relationship', value: this.sheet.normalization.illicit_relationship, x: 130, y: 110 },
    { label: 'Incest relationship', value: this.sheet.normalization.incest_relationship, x: 130, y: 120 },
    { label: 'Begging', value: this.sheet.normalization.begging, x: 130, y: 130 },
    { label: 'Rugby sniffing', value: this.sheet.normalization.rugby_sniffing, x: 130, y: 140 }
  ];
  // Add items with checkboxes
  pdf.setFont('helvetica', 'normal');
  normalizationItems.forEach((item) => {
      if (item.split) {
          // Split the label into two lines
          const lines = [
              'Advertisement promoting liquors/cigarettes/clubs/',
              'red houses'
          ];
          lines.forEach((line, index) => {
              if (index === 0) {
                  // Add checkbox only for the first line
                  pdf.text(`[${item.value ? 'X' : ' '}] ${line}`, item.x, item.y + (index * 10));
              } else {
                  // Add label without checkbox for the second line
                  pdf.text(`${line}`, item.x + 10, item.y + (index * 10)); // Adjust x for alignment
              }
          });
      } else {
          // For items that do not need splitting
          pdf.text(`[${item.value ? 'X' : ' '}] ${item.label}`, item.x, item.y);
      }
  });

  // Add checkbox items to PDF
  pdf.setFont('helvetica', 'normal');
  normalizationItems.forEach((item) => {
      pdf.text(`[${item.value ? 'X' : ' '}] ${item.label}`, item.x, item.y);
  });


  pdf.setFontSize(11);
  pdf.setFont('helvetica', 'bold');
  pdf.text('F. Feelings / Behaviour towards the incident:', 20, feelingsStartY);

  // Define feelings and behavior items with dynamic x and y coordinates
  pdf.setFont('helvetica', 'normal');
  const feelingsItems = [
      { label: 'stow away', value: this.sheet.behaviour_towards_incident.stow_away, x: 20, y: feelingsStartY + 10 },
      { label: 'irritable', value: this.sheet.behaviour_towards_incident.irritable, x: 20, y: feelingsStartY + 20 },
      { label: 'Delinquent behaviour', value: this.sheet.behaviour_towards_incident.delinquent_behaviour, x: 20, y: feelingsStartY + 30 },
      { label: 'stealing', value: this.sheet.behaviour_towards_incident.stealing, x: 20, y: feelingsStartY + 40 },
      { label: 'begging', value: this.sheet.behaviour_towards_incident.begging, x: 90, y: feelingsStartY + 10 },
      { label: 'staying in the street', value: this.sheet.behaviour_towards_incident.staying_in_street, x: 90, y: feelingsStartY + 20 },
      { label: 'indulge in illegal substance', value: this.sheet.behaviour_towards_incident.indulge_in_illegal_substance, x: 90, y: feelingsStartY + 30 },
      { label: 'unresponsive/ passive', value: this.sheet.behaviour_towards_incident.unresponsive_passive, x: 90, y: feelingsStartY + 40 },
      { label: 'withdrawal', value: this.sheet.behaviour_towards_incident.withdrawal, x: 150, y: feelingsStartY + 10 },
      { label: 'snatching', value: this.sheet.behaviour_towards_incident.snatching, x: 150, y: feelingsStartY + 20 },
      { label: 'others (pls. specify)', value: this.sheet.behaviour_towards_incident.others, x: 150, y: feelingsStartY + 30 },
    ];

    // Add feelings and behavior items with checkboxes
    feelingsItems.forEach((item) => {
        pdf.text(`[${item.value ? 'X' : ' '}] ${item.label}`, item.x, item.y);
    });

    pdf.setFontSize(11);
    pdf.setFont('helvetica', 'bold');
    pdf.text('G. Attachments:', 20, attachmentsStartY);

    // Define attachments items with dynamic x and y coordinates
    pdf.setFont('helvetica', 'normal');
    const attachmentsItems = [
        { label: 'Mother', value: this.sheet.attachments.mother, x: 20, y: attachmentsStartY + 10 },
        { label: 'Grandmother', value: this.sheet.attachments.grandmother, x: 20, y: attachmentsStartY + 20 },
        { label: 'Aunt', value: this.sheet.attachments.aunt, x: 20, y: attachmentsStartY + 30 },
        { label: 'Neighbour', value: this.sheet.attachments.neighbour, x: 20, y: attachmentsStartY + 40 },
        { label: 'Cousin', value: this.sheet.attachments.cousin, x: 90, y: attachmentsStartY + 10 },
        { label: 'father', value: this.sheet.attachments.father, x: 90, y: attachmentsStartY + 20 },
        { label: 'grand father', value: this.sheet.attachments.grandfather, x: 90, y: attachmentsStartY + 30 },
        { label: 'uncle', value: this.sheet.attachments.uncle, x: 90, y: attachmentsStartY + 40 },
        { label: 'peer', value: this.sheet.attachments.peer, x: 150, y: attachmentsStartY + 10 },
        { label: 'schoolmate', value: this.sheet.attachments.schoolmate, x: 150, y: attachmentsStartY + 20 },
        { label: 'classmate', value: this.sheet.attachments.classmate, x: 150, y: attachmentsStartY + 30 }
    ];

    // Add attachments items with checkboxes
    attachmentsItems.forEach((item) => {
        pdf.text(`[${item.value ? 'X' : ' '}] ${item.label}`, item.x, item.y);
    });

    pdf.setFontSize(11);
    pdf.setFont('helvetica', 'bold');
    pdf.text('H. Skills:', 20, skillsStartY);

    pdf.setFont('helvetica', 'normal');
    const skillsItems = [
      { label: 'Problem solving', value: this.sheet.skills.problem_solving, x: 20, y: skillsStartY + 10 },
      { label: 'Interpersonal relationship', value: this.sheet.skills.interpersonal_relationship, x: 20, y: skillsStartY + 20 },
      { label: 'Communication skills', value: this.sheet.skills.communication_skills, x: 20, y: skillsStartY + 30 },
      { label: 'Vocational skills', value: this.sheet.skills.vocational_skills, x: 20, y: skillsStartY + 40 },
      { label: 'Critical thinking', value: this.sheet.skills.critical_thinking, x: 90, y: skillsStartY + 10 },
      { label: 'Self-awareness', value: this.sheet.skills.self_awareness, x: 90, y: skillsStartY + 20 },
      { label: 'Coping skills', value: this.sheet.skills.coping_skills, x: 90, y: skillsStartY + 30 },
      { label: 'Survival skills', value: this.sheet.skills.survival_skills, x: 90, y: skillsStartY + 40 },
      { label: 'Decision making skills', value: this.sheet.skills.decision_making_skills, x: 150, y: skillsStartY + 10 },
      { label: 'Comprehension', value: this.sheet.skills.comprehension, x: 150, y: skillsStartY + 20 },
      { label: 'Others', value: this.sheet.skills.others, x: 150, y: skillsStartY + 30 },
    ];

    pdf.setFont('helvetica', 'normal');
    skillsItems.forEach(item => {
      pdf.text(`[${item.value ? 'X' : ' '}] ${item.label}`, item.x, item.y);
    });

      // Footer
    pdf.setFont('Times');
    pdf.setFontSize(10);
    pdf.setFont('helvetica', 'bold');
    pdf.text(`PAGE 3 of ${String(this.totalPages)}`, 108, 330, null, null, 'center');
    pdf.setFont('helvetica', 'normal');
    pdf.setLineWidth(0.5);
    pdf.line(20, offset + 5, 210 - 30, offset + 5);
    pdf.setFontSize(8);
    pdf.text('DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City', 100, offset + 10, null, null, 'center');
    pdf.text('Email: rrcy.fo11@dswd.gov.ph    Tel. No.: 293-0306', 108, offset + 15, null, null, 'center');

    // Add the footer image
    const footerImageData = '/images/footerimg.png';
    pdf.addImage(footerImageData, 'PNG', 182, offset, 20, 10);

    pdf.addPage();
    pdf.setFontSize(10);
    pdf.setFont('helvetica', 'italic');
    pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 135, 20);

    pdf.setFontSize(11);
    pdf.setFont('helvetica', 'bold');
    pdf.text('Resources:', 20, 30);

    // Set font and size for content
    pdf.setFont('helvetica', 'normal');

    // Resources Section
    const resourcesItems = [
      { label: 'Internal resources', value: this.sheet.resources.internal, x: 20, y: 40 },
      { label: 'Intelligence', value: this.sheet.resources.intelligence, x: 30, y: 50, indent: true },
      { label: 'Spirituality', value: this.sheet.resources.spirituality, x: 30, y: 60, indent: true },
      { label: 'Resourceful', value: this.sheet.resources.resourceful, x: 30, y: 70, indent: true },
      { label: 'Obedient', value: this.sheet.resources.obedient, x: 120, y: 50 },
      { label: 'Others', value: this.sheet.resources.others, x: 120, y: 60, indent: true },
      { label: 'External Resources', value: this.sheet.resources.external, x: 20, y: 80 },
      { label: 'Family', value: this.sheet.resources.family, x: 30, y: 90, indent: true },
      { label: 'Peers', value: this.sheet.resources.peers, x: 30, y: 100, indent: true },
      { label: 'Health services', value: this.sheet.resources.health_services, x: 30, y: 110, indent: true },
      { label: 'Recreational services', value: this.sheet.resources.recreational_services, x: 30, y: 120, indent: true },
      { label: 'NGOs existing in the community', value: this.sheet.resources.ngos, x: 120, y: 90, indent: true },
      { label: 'Civic Organization', value: this.sheet.resources.civic_organization, x: 120, y: 100, indent: true },
      { label: 'Others (pls. specify)', value: this.sheet.resources.others, x: 120, y: 110, indent: true }
    ];

    resourcesItems.forEach(item => {
      pdf.text(`[${item.value ? 'X' : ' '}] ${item.label}`, item.x, item.y);
    });

    pdf.setFontSize(11);
    pdf.setFont('helvetica', 'bold');
    pdf.text('IV. Activities or source of income in the street:', 20, 130);

     // Set font and size for content
     pdf.setFont('helvetica', 'normal');

    // Source of Income Section
    const incomeItems = [
      { label: 'Vending', value: this.sheet.source_of_income_in_street.vending, x: 30, y: 140 },
      { label: 'Car wash boy', value: this.sheet.source_of_income_in_street.car_wash_boy, x: 30, y: 150 },
      { label: 'Rugby user', value: this.sheet.source_of_income_in_street.rugby_user, x: 30, y: 160 },
      { label: 'Porter', value: this.sheet.source_of_income_in_street.porter, x: 120, y: 140 },
      { label: 'Barker', value: this.sheet.source_of_income_in_street.barker, x: 120, y: 150 }
    ];

    incomeItems.forEach(item => {
      pdf.text(`[${item.value ? 'X' : ' '}] ${item.label}`, item.x, item.y);
    });

  // Text fields
  pdf.text('Earnings/ income:', 20, 170);
  pdf.text(this.sheet.earnings_income || '', 55, 170);

  // Set the line width to a thinner value
  pdf.setLineWidth(0.3); // Adjust the value to make it thinner (0.5 is fairly thin)

  // Draw a thin line under "Earnings/ income"
  pdf.line(55, 171, 200, 171);

  pdf.text('Hours of stay in the street:', 20, 180);
  pdf.text(this.sheet.hrs_stay_in_street || '', 70, 180);

  // Draw line under "Hours of stay in the street"
  pdf.line(70, 181, 200, 181);

  pdf.text('Length of stay in the street:', 20, 190);
  pdf.text(this.sheet.length_stay_in_street || '', 70, 190);

  // Draw line under "Length of stay in the street"
  pdf.line(70, 191, 200, 191);

  pdf.text('Common Substance used:', 20, 200);
  pdf.text(this.sheet.common_substance_used || '', 70, 200);

  // Draw line under "Common Substance used"
  pdf.line(70, 201, 200, 201);


    // Initial Assessment
    pdf.setFont("helvetica", "bold"); // Use "bold" for the bold style
    pdf.text('INITIAL ASSESSMENT:', 20, 210);
    pdf.setFont("helvetica", "normal");
    pdf.text(this.sheet.initial_assessment || '', 20, 220, {  indent: true, maxWidth: 180 });
    pdf.line(20, 221, 200, 221);
    pdf.line(20, 227, 200, 227);
    pdf.line(20, 233, 200, 233);
    pdf.line(20, 239, 200, 239);
    // Recommendations
    pdf.setFont("helvetica", "bold");
    pdf.text('RECOMMENDATIONS:', 20, 250);
    pdf.setFont("helvetica", "normal");
    pdf.text(this.sheet.recommendations || '', 20, 260, {   maxWidth: 180 });
    pdf.line(20, 261, 200, 261);
    pdf.line(20, 267, 200, 267);
    pdf.line(20, 273, 200, 273);

    // Prepared by and Reviewed by
    pdf.text('Prepared by:', 20, 290);
    pdf.setFont("helvetica", "bold"); // Use "bold" for the bold style
    // Define the text
    const preparedByText = this.sheet.prepared_by || '';

    // Add the text
    pdf.text(preparedByText, 20, 300);

    // Calculate the width of the text
    const textWidth = pdf.getTextWidth(preparedByText);

    // Draw a line below the text, with the width matching the text's width
    pdf.line(20, 301, 20 + textWidth, 301);
    pdf.setFont("helvetica", "normal");
    pdf.text('SWO __/Case Manager', 20, 305);

    pdf.text('Reviewed by:', 140, 290);
    pdf.setFont("helvetica", "bold"); // Use "bold" for the bold style
    pdf.text('ANGELIC B. PAÑA, RSW, MSSW', 140, 300);
    pdf.line(140, 301, 200, 301); 
    pdf.setFont("helvetica", "normal");
    pdf.text('Center Head/SWO IV', 140, 305);
    pdf.setFont('helvetica', 'bold');

    // Footer
    pdf.setFont('Times');
    pdf.setFontSize(10);
    pdf.setFont('helvetica', 'bold');
    pdf.text(`PAGE 4 of ${String(this.totalPages)}`, 108, 330, null, null, 'center');
    pdf.setFont('helvetica', 'normal');
    pdf.setLineWidth(0.5);
    pdf.line(20, offset + 5, 210 - 30, offset + 5);
    pdf.setFontSize(8);
    pdf.text('DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City', 100, offset + 10, null, null, 'center');
    pdf.text('Email: rrcy.fo11@dswd.gov.ph    Tel. No.: 293-0306', 108, offset + 15, null, null, 'center');

    // Add the footer image
    const footerImgeData = '/images/footerimg.png';
    pdf.addImage(footerImgeData, 'PNG', 182, offset, 20, 10);

      // Save the PDF
      pdf.save('General Intake Sheet.pdf');
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
        center_head: this.center_head,
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
    }
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
