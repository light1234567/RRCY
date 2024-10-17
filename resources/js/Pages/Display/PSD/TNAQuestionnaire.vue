<template>
  <!-- Tabs for Actions (Back button visible only in edit mode) -->
<div v-if="editMode" class="flex absolute p-4 space-x-4">
  <button @click="cancelEdit" class="flex space-x-2 px-3 py-3 bg-blue-900 text-white rounded-md text-xs">
    <!-- FontAwesome for Back -->
    <i class="fas fa-arrow-left w-4 h-4"></i>
    <span>Cancel</span>
  </button>
</div>

<!-- Main Action Buttons -->
<div class="flex -ml-2 justify-end bg-transparent border -mr-9 border-gray-300 p-4 space-x-4 -mt-9">

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
  <button v-if="editMode" @click="saveData" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
        <!-- FontAwesome for Save -->
        <i class="fas fa-check w-4 h-4"></i>
        <span>Save</span>
      </button>

  <!-- Export PDF Button (commented out for now, uncomment to use) -->
  
  
  <button @click="generatePdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 text-white rounded-md text-xs">
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

    <form ref="TNAForm" @submit.prevent="saveData">

<div class="graph-background pt-0.5  -mr-9 -mb-16">

  <div v-if="currentPage === 1" class="max-w-3xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
<!-- Header -->
<div class="relative flex justify-between items-center mb-4">
  <img src="/images/headerlogo2.png" alt="Logo" class=" h-32 w-64 relative z-10">    
  <div class="text-right">
      <p class="flex justify-center item-center mr-6 text-sm font-semibold">PROTECTIVE SERVICES DIVISION</p>
      <p class="flex justify-center text-sm font-semibold">Regional Rehabilitation Center for Youth RFO XI</p>
      <p class="flex justify-center text-xs">DSWD-GF-010 | REV 02 | 22 SEP 2023</p>
    </div>
  </div>

  <div class="p-4">
<!-- Training Needs Assessment Heading Section -->
<div class="w-full text-center p-2">
  <h2 class="text-lg font-bold">TRAINING NEEDS ASSESSMENT</h2>

  <!-- FOR THE and Date of Admission Section -->
  <div class="flex items-center justify-center mb-2">
    <p class="text-xs text-md font-semibold mr-2">FOR THE </p>
    <input 
      type="text" 
      v-model="form.period" 
      class="text-xs block w-32 border-b-1 border-black border-t-0 border-l-0 border-r-0 text-center focus:outline-none" 
      :readonly="!editMode" 
      @input="(e) => { e.target.setCustomValidity('') }" 
      @invalid="(e) => { e.target.setCustomValidity('Please provide a period') }" 
      required maxlength="10"
    />
  </div>
  
  <div class="flex items-center justify-center mb-6">
    <p class="text-xs font-semibold mr-2">Date of Admission:</p>
    <input 
      type="date" 
      v-model="form.date_of_admission" 
      class="border-b-1 border-black border-t-0 border-l-0 border-r-0 text-xs block w-32 text-center focus:outline-none" 
      :readonly="!editMode" 
      @input="(e) => { e.target.setCustomValidity('') }" 
      @invalid="(e) => { e.target.setCustomValidity('Please provide a date of admission') }" 
      required 
/>

  </div>

  <!-- Petsa sa Pagtubag Section -->
  <div class="flex items-center justify-end mb-6">
    <p class="text-xs font-semibold mr-2">Petsa sa Pagtubag:</p>
    <input 
      type="date" 
      v-model="form.date" 
      class="border-b-1 border-black border-t-0 border-l-0 border-r-0 text-xs block w-32 text-center focus:outline-none" 
      :readonly="!editMode" 
      @input="(e) => { e.target.setCustomValidity('') }" 
      @invalid="(e) => { e.target.setCustomValidity('Please provide the date') }" 
      required 
/>  </div>
</div>

<!-- Form Fields for Name, Birthdate, and Age -->
 
<div class="flex ">
  <p class=" font-semibold mt-2">Pangalan:</p>
  <input type="text" v-model="form.name" readonly class="border-b-1 border-black border-t-0 border-l-0 border-r-0 border-b-1 w-1/2 border-b-1 border-black focus:outline-none">
  
</div>

<div class="flex flex-wrap w-full mt-2 ">
  <div class="mt-7">
    <p class="font-semibold">Adlaw nga Natawhan:</p>
  </div>
  <div class="mt-3 w-full md:w-2/6 p-2 ">
    <input type="date" v-model="form.birthdate" readonly class=" border-t-0 border-l-0 border-r-0 w-full border-b-1 border-black focus:outline-none" @change="form.age = calculateAge(form.birthdate)">
  </div>
  
  <div class=" flex w-1/4 ">
    <div class=" mt-7">
      <p class="font-semibold">Edad:</p>
    </div>
    
    <div class="mt-5">
    <input type="number" v-model="form.age" readonly class="text-center w-3/4 border-t-0 border-l-0 border-r-0 border-b-1 border-black focus:outline-none" >
    </div>
  </div>
  
  <div class="flex mr-7 mt-7 ">
    <p class="font-semibold">Lugar nga Natawhan:</p>
  </div>
  <div class="mt-3">
    <input type="text" v-model="form.place_of_birth" readonly class="border-t-0 border-l-0 border-r-0 w-full border-b-1 border-black focus:outline-none" >
  </div>
</div>

<!-- Education Section -->
<div class="p-1 mt-2 border bg-blue-300 font-bold">
  <p>Natapos nga Grado:</p>
</div>
<div v-if="educationError" class="text-red-500 text-xs font-bold mt-1">
  {{ educationErrorMessage }}
</div>

<div class="flex flex-col p-2">
  <div class="flex items-center">
    <input type="radio" value="Wala Naka eskwela" v-model="form.selectedEducationLevel" :disabled="!editMode" class="mr-2">
    <span>Wala Naka eskwela</span>
  </div>

  <!-- Two columns for Educational Levels -->
  <div class="flex justify-start space-x-8 mt-4">
    <!-- Column 1 -->
    <div class="flex flex-col">
      <label class="flex items-center space-x-2">
  <input type="radio" value="Elementary Level" v-model="form.selectedEducationLevel" :disabled="!editMode">
  <span>Elementary Level (Grade</span>
  
  <select 
    v-model="form.elementaryGrade" 
    :disabled="!editMode || form.selectedEducationLevel !== 'Elementary Level'" 
    class="text-xs w-16 border-b p-1 text-center"
    style=" background: transparent;"
  >
    <option value="" disabled></option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
  </select>
  
  <span>)</span>
</label>



      <label class="flex items-center space-x-2 mt-2">
        <input type="radio" value="Elementary Graduate" v-model="form.selectedEducationLevel" :disabled="!editMode">
        <span>Elementary Graduate</span>
      </label>

      <label class="flex items-center space-x-2 mt-2">
  <input type="radio" value="Junior High School Level" v-model="form.selectedEducationLevel" :disabled="!editMode">
  <span>Junior High School Level (Year</span>
  
  <select 
    v-model="form.juniorHighYear" 
    :disabled="!editMode || form.selectedEducationLevel !== 'Junior High School Level'" 
    class="text-xs w-16 border-b p-1 text-center"
     style=" background: transparent;"
  >
    <option value="" disabled></option>
    <option value="1st">1st</option>
    <option value="2nd">2nd</option>
    <option value="3rd">3rd</option>
    <option value="4th">4th</option>
  </select>
  
  <span>)</span>
</label>

    </div>

    <!-- Column 2 -->
    <div class="flex flex-col">
      <label class="flex items-center space-x-2">
  <input type="radio" value="Senior High School Level" v-model="form.selectedEducationLevel" :disabled="!editMode">
  <span>Senior High School Level (Year</span>
  <select 
    v-model="form.seniorHighYear" 
    :disabled="!editMode || form.selectedEducationLevel !== 'Senior High School Level'" 
    class="text-xs w-16 border-b p-1 text-center" 
    style=" background: transparent;"
  >
    <option value="" disabled></option>
    <option value="11">11</option>
    <option value="12">12</option>
  </select>
  <span>)</span>
</label>


      <label class="flex items-center space-x-2 mt-2">
        <input type="radio" value="Senior High School Graduate" v-model="form.selectedEducationLevel" :disabled="!editMode">
        <span>Senior High School Graduate</span>
      </label>
      <label class="flex items-center space-x-2 mt-2">
  <input type="radio" value="College Level" v-model="form.selectedEducationLevel" :disabled="!editMode">
  <span>College Level (Year</span>
  
  <select 
    v-model="form.collegeYear" 
    :disabled="!editMode || form.selectedEducationLevel !== 'College Level'" 
    class="text-xs w-24 border-b p-1 text-center"
        style=" background: transparent;"
  >
    <option value="" disabled></option>
    <option value="1st">1st</option>
    <option value="2nd">2nd</option>
    <option value="3rd">3rd</option>
    <option value="4th">4th</option>
  </select>
  
  <span>)</span>
</label>


      
    </div>
    
  </div>
  
</div>


<div class="flex mr-7 mt-7 ">
    <p class="mt-5 font-semibold">Pangalan sa imong Social Worker:</p>
    <div class="">
  <input 
    type="text" 
    v-model="form.social_worker" 
    :readonly="!editMode" 
    class="mt-3 border-t-0 border-l-0 border-r-0 w-full border-b-1 border-black focus:outline-none" 
    oninput="this.value = this.value.replace(/[^a-zA-Z\s.,]/g, '')" 
    maxlength="50"
  >
</div>

  </div>
 

  <div class="flex mr-7 mt-7 ">
    <p class="mt-5 font-semibold">Pangalan sa imong Houseparent:</p>
    <div class="">
  <input 
    type="text" 
    v-model="form.houseparent" 
    :readonly="!editMode" 
    class="mt-3 border-t-0 border-l-0 border-r-0 w-full border-b-1 border-black focus:outline-none" 
    oninput="this.value = this.value.replace(/[^a-zA-Z\s.,]/g, '')" 
    maxlength="50"
  >
</div>

  </div>
  
<!-- Additional Information Section -->
<div class="p-1 mt-2 w-full border bg-blue-300 font-bold">
  <p>Pangalan sa Ginikanan:</p>
</div>

<div class="flex flex-wrap p-2">
  <div class=" mt-4 flex flex-wrap p-2 ">Amahan:</div>
  <div class="w-3/4 mt-2 p-2">
  <input 
    type="text" 
    v-model="form.father" 
    :readonly="!editMode" 
    class="w-full border-t-0 border-l-0 border-r-0 border-b-1 border-black focus:outline-none" 
    oninput="this.value = this.value.replace(/[^a-zA-Z\s.,]/g, '')" 
    maxlength="50"
  >
</div>

</div>

<div class="flex flex-wrap p-2">
  <div class="mt-4 flex flex-wrap p-2">Inahan:</div>
  <div class="w-3/4 mt-2 p-2">
  <input 
    type="text" 
    v-model="form.mother" 
    :readonly="!editMode" 
    class="border-t-0 border-l-0 border-r-0 w-full border-b-1 border-black focus:outline-none" 
    oninput="this.value = this.value.replace(/[^a-zA-Z\s.,]/g, '')" 
    maxlength="50"
  >
</div>

</div>

<div class="flex flex-wrap p-2">
  <div class="mt-4 flex flex-wrap p-2">Pinuy-Anan:</div>
  <div class="w-3/4 mt-2 p-2">
    <input type="text" v-model="form.address" :readonly="!editMode" class="border-t-0 border-l-0 border-r-0 w-full border-b-1 border-black focus:outline-none" maxlength="150" >
  </div>
</div>

<div class="flex flex-wrap p-2">
  <div class="mt-4 flex flex-wrap p-2">Kadugayon sa Pagpuyo sa Center:</div>
  <div class="w-1/2 mt-2 p-2">
  <input 
    type="text" 
    v-model="form.center_duration" 
    :readonly="!editMode" 
    class="border-t-0 border-l-0 border-r-0 w-full border-b-1 border-black focus:outline-none" 
    oninput="this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, '')" 
    maxlength="20"
  >
</div>



</div>



    <!-- Page 2: Trainings -->
<table class="w-full border-collapse border mt-4">
  <thead>
    <tr>
      <th colspan="5" class="text-sm text-left p-2 border bg-blue-300">Skills Training nga human na nga naapilan diri sa sulod CENTER ug sa gawas sa center</th>
    </tr>
    <tr class="">
      <th class="border p-2 text-center text-sm">Title sa Training nga Naapilan</th>
      <th class="border p-2 text-center text-sm">Kadugayon sa Training</th>
      <th colspan="5" class="border p-2 text-center text-sm">Lugar sa Gi-Trainingan</th>
      
      <th class="border p-2 text-center text-sm"></th>
    </tr>
    <tr class="">
      <th class="border p-2 text-center text-sm"></th>
      <th class="border p-2 text-center text-sm"></th>
      <th  class="border p-2 text-center text-sm">Sa Gawas</th>
      <th class="border p-2 text-center text-sm">Sa Center</th>
      
    </tr>
  </thead>
  <tbody>
    <tr v-for="(training, index) in form.trainings" :key="index">
      <td class="p-2 border">
  <input 
    type="text" 
    v-model="training.title" 
    class="w-full border" 
    :readonly="!editMode" 
    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" 
  >
</td>

<td class="p-2 border">
  <input 
    type="text" 
    v-model="training.duration" 
    class="w-full border" 
    :readonly="!editMode" 
    oninput="this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, '')" 
  >
</td>

      <td class="p-2 border">
        <input type="text" v-model="training.location_outside" class="w-full border" :readonly="!editMode">
      </td>
      <td class="p-2 border">
        <input type="text" v-model="training.location_inside" class="w-full border" :readonly="!editMode">
      </td>
      <td class="p-2 border text-center">
        <!-- Remove Button -->
        <button type="button" @click="removeTraining(index)" class="px-2 py-1 bg-red-500 text-white rounded" v-if="editMode">
          Remove
        </button>
      </td>
    </tr>
    <!-- Option to add a new training -->
    <tr v-if="editMode">
      <td colspan="5" class="p-2 text-center">
        <button type="button" @click="addNewTraining" class="px-4 py-2 bg-blue-500 text-white rounded">Add Training</button>
      </td>
    </tr>
  </tbody>
</table>

    
    <div>
      <table class="w-full border-collapse border">
</table>
</div>
    
    <br />
  <div class="flex justify-center border-gray-300 ml-6 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        <div class="flex flex-col">
          <p class="ml-24 -mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
          <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD FOXI, Regional Rehabilitation Center for Youth, Bago-Oshiro, Davao City, Philippines 8000</p>
          <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrcy.fo11@dswd.gov.ph</span> Tel. No.: (082) 293-0306</p>
        </div>
        <div class="ml-4">
          <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
        </div>
      </div>
    </div>
    
    
</div>

</div>


<div  v-if="currentPage === 2" class="max-w-3xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
    <div class="flex justify-end text-right">
      
      <p class="flex justify-center text-xs">DSWD-GF-010 | REV 02 | 22 SEPT 2023</p>
    </div>
  
  <!-- Automotive Sector -->
  <tr class="">
    <th class="border p-2 text-center"></th>
    <th class="border p-2 text-center"></th>
    <th class="border p-2 text-center bg-yellow-300">1</th>
    <th class="border p-2 text-center bg-yellow-300">2</th>
    <th class="border p-2 text-center bg-yellow-300">3</th>
    <th class="border p-2 text-center bg-yellow-300">4</th>
    <th class="border p-2 text-center bg-yellow-300">5</th>
    <th class="border p-2 text-center bg-yellow-300">Ikasugyot/Remarks</th>
  </tr>
  <tr class="bg-blue-200 font-bold">
    <td colspan="8" class="border p-2">A. AUTOMOTIVE SECTOR:</td>
  </tr>
  <tr v-for="(item, index) in automotiveSector" :key="'automotive-' + index">
    <td class="border p-2 text-center">{{ index + 1 }}</td>
    <td class="border p-2">{{ item.name }}</td>
    <td class="border p-2 text-center"><input type="radio" :name="'automotive-' + index" value="1" v-model="item.rank" @change="logRank(item)" :disabled="!editMode" ></td>
    <td class="border p-2 text-center"><input type="radio" :name="'automotive-' + index" value="2" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'automotive-' + index" value="3" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'automotive-' + index" value="4" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'automotive-' + index" value="5" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2"><input type="text" v-model="item.remarks" class="w-full border p-1" :readonly="!editMode"></td>
  </tr>

  <!-- Agricultural Sector -->
  <tr class="bg-blue-200 font-bold">
    <td colspan="8" class="border p-2">B. AGRICULTURAL SECTOR:</td>
  </tr>
  <tr v-for="(item, index) in agriculturalSector" :key="'agricultural-' + index">
    <td class="border p-2 text-center">{{ index + 1 }}</td>
    <td class="border p-2">{{ item.name }}</td>
    <td class="border p-2 text-center"><input type="radio" :name="'agricultural-' + index" value="1" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'agricultural-' + index" value="2" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'agricultural-' + index" value="3" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'agricultural-' + index" value="4" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'agricultural-' + index" value="5" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2"><input type="text" v-model="item.remarks" class="w-full border p-1" :readonly="!editMode"></td>
  </tr>

  <!-- Health Sector -->
  <tr class="bg-blue-200 font-bold">
    <td colspan="8" class="border p-2">C. HEALTH, SOCIAL & OTHER COMMUNITY DEVT. SERVICES:</td>
  </tr>
  <tr v-for="(item, index) in healthSector" :key="'health-' + index">
    <td class="border p-2 text-center">{{ index + 1 }}</td>
    <td class="border p-2">{{ item.name }}</td>
    <td class="border p-2 text-center"><input type="radio" :name="'health-' + index" value="1" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'health-' + index" value="2" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'health-' + index" value="3" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'health-' + index" value="4" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'health-' + index" value="5" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2"><input type="text" v-model="item.remarks" class="w-full border p-1" :readonly="!editMode"></td>
  </tr>

  <!-- ICT Sector -->
  <tr class="bg-blue-200 font-bold">
    <td colspan="8" class="border p-2">D. INFORMATION & COMMUNICATION TECHNOLOGY:</td>
  </tr>
  <tr v-for="(item, index) in ictSector" :key="'ict-' + index">
    <td class="border p-2 text-center">{{ index + 1 }}</td>
    <td class="border p-2">{{ item.name }}</td>
    <td class="border p-2 text-center"><input type="radio" :name="'ict-' + index" value="1" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'ict-' + index" value="2" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'ict-' + index" value="3" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'ict-' + index" value="4" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'ict-' + index" value="5" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2"><input type="text" v-model="item.remarks" class="w-full border p-1" :readonly="!editMode"></td>
  </tr>

  <!-- Metals Sector -->
  <tr class="bg-blue-200 font-bold">
    <td colspan="8" class="border p-2">E. METALS & ENGINEERING SECTOR:</td>
  </tr>
  <tr v-for="(item, index) in metalsSector" :key="'metals-' + index">
    <td class="border p-2 text-center">{{ index + 1 }}</td>
    <td class="border p-2">{{ item.name }}</td>
    <td class="border p-2 text-center"><input type="radio" :name="'metals-' + index" value="1" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'metals-' + index" value="2" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'metals-' + index" value="3" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'metals-' + index" value="4" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'metals-' + index" value="5" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2"><input type="text" v-model="item.remarks" class="w-full border p-1" :readonly="!editMode"></td>
  </tr>

  <!-- Tourism Sector -->
  <tr class="bg-blue-200 font-bold">
    <td colspan="8" class="border p-2">F. TOURISM SECTOR:</td>
  </tr>
  <tr v-for="(item, index) in tourismSector" :key="'tourism-' + index">
    <td class="border p-2 text-center">{{ index + 1 }}</td>
    <td class="border p-2">{{ item.name }}</td>
    <td class="border p-2 text-center"><input type="radio" :name="'tourism-' + index" value="1" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'tourism-' + index" value="2" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'tourism-' + index" value="3" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'tourism-' + index" value="4" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'tourism-' + index" value="5" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2"><input type="text" v-model="item.remarks" class="w-full border p-1" :readonly="!editMode"></td>
  </tr>

  <!-- Construction Sector -->
  <tr class="bg-blue-200 font-bold">
    <td colspan="8" class="border p-2">G. CONSTRUCTION SECTOR:</td>
  </tr>
  <tr v-for="(item, index) in constructionSector" :key="'construction-' + index">
    <td class="border p-2 text-center">{{ index + 1 }}</td>
    <td class="border p-2">{{ item.name }}</td>
    <td class="border p-2 text-center"><input type="radio" :name="'construction-' + index" value="1" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'construction-' + index" value="2" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'construction-' + index" value="3" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'construction-' + index" value="4" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'construction-' + index" value="5" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2"><input type="text" v-model="item.remarks" class="w-full border p-1" :readonly="!editMode"></td>
  </tr>

  <!-- Basic Trainings -->
  <tr class="bg-blue-200 font-bold">
    <td colspan="8" class="border p-2">H. BASIC TRAININGS:</td>
  </tr>
  <tr v-for="(item, index) in basicTrainings" :key="'basic-' + index">
    <td class="border p-2 text-center">{{ index + 1 }}</td>
    <td class="border p-2">{{ item.name }}</td>
    <td class="border p-2 text-center"><input type="radio" :name="'basic-' + index" value="1" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'basic-' + index" value="2" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'basic-' + index" value="3" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'basic-' + index" value="4" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'basic-' + index" value="5" v-model="item.rank" :disabled="!editMode"></td>
    <td class="border p-2"><input type="text" v-model="item.remarks" class="w-full border p-1" :readonly="!editMode"></td>
  </tr>
  <br />

  <div class="w-1/2 ml-auto">
<div class="flex justify-center flex items-center mt-7">
  <input
    v-model="form.name"
    type="text"
    id="centerHeadSignature"
    class=" mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none"
    readonly
  >
</div>
<p class="flex justify-center items-center text-sm mt-2">Pangalan ug Pirma sa Residente</p>
</div>

<br />

  <div class="border-gray-300 ml-6 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        <div class="flex flex-col">
          <p class="ml-24 -mb-4 font-bold">PAGE 2 of {{ totalPages }}</p>
          <p class="border-t mt-4 text-[10px]" style="border-top: 2px solid black;">DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH</p>

        </div>
        <div class="ml-4">
          <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
        </div>
      </div>
    </div>

</div>
</div>
</form>
</template>

<script>
import axios from 'axios';
import Pagination from '@/Components/Pagination.vue';
import jsPDF from 'jspdf';
import 'jspdf-autotable'; // Optional for table generation

export default {
  components: {
    Pagination,
  },
name: "TrainingNeedsAssessment",
data() {
  return {
    totalPages: 2,
    currentPage: 1,
    isModalOpen: false,
    isSaveResultModalOpen: false,
    saveResultTitle: '',
    saveResultMessage: '',
    educationError: false,
    educationErrorMessage: '',
    form: {
      client_id: null,
      name: '',
      birthdate: '',
      place_of_birth: '',
      age: null,
      trainings: [],
      education: [],
      
      selectedEducationLevel: '',
      elementaryGrade: '',
      juniorHighYear: '',
      seniorHighYear: '',
      collegeYear: '',
      social_worker: '',
      houseparent: '',
      father: '',
      mother: '',
      address: '',
      center_duration: '',
      period: '',
      date_of_admission: '',
      date:'',
      lugar_nga_natawhan: '',
    },
    automotiveSector: [
      { name: 'Theoretical Driving Course', rank: null, remarks: '' },
      { name: 'Automotive Servicing', rank: null, remarks: '' },
      { name: 'Practical Driving Course', rank: null, remarks: '' },
      { name: 'Motorcycle Small Engine Servicing', rank: null, remarks: '' },
      { name: 'Refrigeration & Airconditioning Servicing', rank: null, remarks: '' },
    ],
    agriculturalSector: [
      { name: 'Agricultural Crops Production', rank: null, remarks: '' },
      { name: 'Animal Production (Poultry-Chicken)', rank: null, remarks: '' },
      { name: 'Animal Production (Ruminants)', rank: null, remarks: '' },
      { name: 'Animal Production (Swine)', rank: null, remarks: '' },
      { name: 'Agricultural Organic Production (AOP)', rank: null, remarks: '' },
      { name: 'Horticulture (Landscapping)', rank: null, remarks: '' },

    ],
    healthSector: [
      { name: 'Beauty Care', rank: null, remarks: '' },
      { name: 'Bookkeeping', rank: null, remarks: '' },
      { name: 'Caregiving', rank: null, remarks: '' },
      { name: 'Consumer Electronics Servicing', rank: null, remarks: '' },
      { name: 'Domestic Worksc', rank: null, remarks: '' },
      { name: 'Hairdressing', rank: null, remarks: '' },
      { name: 'Health Care Services', rank: null, remarks: '' },
      { name: 'Massage Therapy(Hilot Wellness)', rank: null, remarks: '' },
      { name: 'Dress Making', rank: null, remarks: '' },
    ],
    ictSector: [
      { name: 'Computer System Servicing', rank: null, remarks: '' },
      { name: 'Domestic Appliance Repair', rank: null, remarks: '' },
      { name: 'Information Technology Support', rank: null, remarks: '' },
    ],
    metalsSector: [
      { name: 'Shielded Metal Arc Welding', rank: null, remarks: '' },
    ],
    tourismSector: [
      { name: 'Food Processing', rank: null, remarks: '' },
      { name: 'Bartending', rank: null, remarks: '' },
      { name: 'Bread and Pastry Production', rank: null, remarks: '' },
      { name: 'Cookery', rank: null, remarks: '' },
      { name: 'Food and Beverage Services', rank: null, remarks: '' },
      { name: 'Housekeeping', rank: null, remarks: '' },
      { name: 'Security Services', rank: null, remarks: '' },
    ],
    constructionSector: [
      { name: 'Carpentry', rank: null, remarks: '' },
      { name: 'Plumbing', rank: null, remarks: '' },
      { name: 'Mason', rank: null, remarks: '' },
      { name: 'Painter', rank: null, remarks: '' },
      { name: 'Electrician', rank: null, remarks: '' },
      { name: 'Tile Setting', rank: null, remarks: '' },
    ],
    basicTrainings: [
      { name: 'Arts & Crafts', rank: null, remarks: '' },
      { name: 'Handicrafts', rank: null, remarks: '' },
      { name: 'Musical Band Tutorial/Training', rank: null, remarks: '' },
      { name: 'T-shirt Printing', rank: null, remarks: '' },
      { name: 'Gardening & Ornamental Plant Production', rank: null, remarks: '' },
      { name: 'Rag Making', rank: null, remarks: '' },
      { name: 'Basic Sewing', rank: null, remarks: '' },
      { name: 'Bayong Making', rank: null, remarks: '' },
      { name: 'Other Suggestions:', rank: null, remarks: '' },
      { name: 'a.', rank: null, remarks: '' },
      { name: 'b.', rank: null, remarks: '' },
      { name: 'c.', rank: null, remarks: '' },
    ],
    // Training sectors arrays here
    // ...
    originalForm: null, // to store the original form data
    editMode: false,
    message: '',
    messageType: '', // 'success' or 'error'
  };
},
mounted() {
  this.id = this.$route.params.id;
  this.fetchData();
  console.log('Automotive Sector Data on mount:', this.automotiveSector);
},
watch: {
  '$route.params.id': function(newId) {
    this.id = newId;
    this.fetchData();
  }
},
methods: {
  toggleEdit() {
    if (this.editMode) {
      this.openModal();
    } else {
      this.editMode = true;
      this.originalForm = JSON.parse(JSON.stringify(this.form)); // store the original form data before editing
    }
  },
  toggleEducation(level) {
    const index = this.form.education.findIndex(edu => edu.education_level === level);
    if (index > -1) {
      this.form.education.splice(index, 1);
    } else {
      this.addEducationLevel(level);
    }
  },
  hasEducation(level) {
    return this.form.education.some(edu => edu.education_level === level);
  },
  addEducationLevel(level) {
    this.form.education.push({
      education_level: level,
      year_or_grade: this.getYearOrGradeForLevel(level)
    });
  },
  updateYearOrGrade(level, value) {
    const index = this.form.education.findIndex(edu => edu.education_level === level);
    if (index > -1) {
      this.$set(this.form.education, index, {
        ...this.form.education[index],
        year_or_grade: value
      });
    } else {
      this.addEducationLevel(level);
      this.updateYearOrGrade(level, value); // Recursive call to update after adding the level
    }
  },
  cancelEdit() {
    if (this.originalForm) {
      // revert to the original data
      this.form = JSON.parse(JSON.stringify(this.originalForm));
    }
    this.editMode = false; // exit edit mode
  },
  calculateAge(dob) {
  const birthDate = new Date(dob);
  const ageDiff = Date.now() - birthDate.getTime();
  const ageDate = new Date(ageDiff);
  return Math.abs(ageDate.getUTCFullYear() - 1970);
}

,
fetchData() {
    const clientId = this.$route.params.id;

    if (clientId) {
        this.form.client_id = clientId;
        axios.get(`/api/training-needs-assessment/${clientId}`)
            .then(response => {
                // Log the entire response to understand the data structure
                console.log('Raw Report Data:', response.data.report);

                const report = response.data.report || {};  // Safeguard for null report
                const educationDetails = report.education_details || [];  // Default to empty array if null
                const trainingDetails = report.training_details || [];  // Default to empty array if null
                const trainingSectorDetails = report.training_sector_details || [];  // Default to empty array if null

                // Log each of these to verify
                console.log('Education Details:', educationDetails);
                console.log('Training Details:', trainingDetails);
                console.log('Training Sector Details:', trainingSectorDetails);

                // Populate the form with the report data (if available)
                Object.assign(this.form, report);
                this.fetchClientData(clientId);

                // Populate the education fields
                if (Array.isArray(educationDetails) && educationDetails.length > 0) {
                    const education = educationDetails[0];
                    this.form.selectedEducationLevel = education.education_level;

                    switch (education.education_level) {
                        case 'Elementary Level':
                            this.form.elementaryGrade = education.year_or_grade;
                            break;
                        case 'Junior High School Level':
                            this.form.juniorHighYear = education.year_or_grade;
                            break;
                        case 'Senior High School Level':
                            this.form.seniorHighYear = education.year_or_grade;
                            break;
                        case 'College Level':
                            this.form.collegeYear = education.year_or_grade;
                            break;
                    }
                } else {
                    console.warn('No education details found.');
                }

                // Populate the trainings fields
                if (Array.isArray(trainingDetails) && trainingDetails.length > 0) {
                    this.form.trainings = trainingDetails.map(detail => ({
                        title: detail.title,
                        duration: detail.duration,
                        location_outside: detail.location_outside,
                        location_inside: detail.location_inside,
                    }));
                } else {
                    this.form.trainings = [];
                    console.warn('No training details found.');
                }

                // Populate the training sectors
                if (Array.isArray(trainingSectorDetails) && trainingSectorDetails.length > 0) {
                    trainingSectorDetails.forEach(detail => {
                        let sectorArray = [];

                        switch (detail.sector) {
                            case 'Automotive':
                                sectorArray = this.automotiveSector;
                                break;
                            case 'Agricultural':
                                sectorArray = this.agriculturalSector;
                                break;
                            case 'Health':
                                sectorArray = this.healthSector;
                                break;
                            case 'ICT':
                                sectorArray = this.ictSector;
                                break;
                            case 'Metals':
                                sectorArray = this.metalsSector;
                                break;
                            case 'Tourism':
                                sectorArray = this.tourismSector;
                                break;
                            case 'Construction':
                                sectorArray = this.constructionSector;
                                break;
                            case 'Basic':
                                sectorArray = this.basicTrainings;
                                break;
                        }

                        if (sectorArray) {
                            const item = sectorArray.find(s => s.name === detail.name);
                            if (item) {
                                item.rank = detail.rank;
                                item.remarks = detail.remarks;
                            }
                        }
                    });
                } else {
                    console.warn('No training sector details found.');
                }

                // Fetch the client's additional details (name, date of birth)
                this.fetchClientData(clientId);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                this.fetchClientData(clientId); // Fetch client data even if the report is not found
            });
    } else {
        console.warn('No client ID found in route parameters.');
    }
}

,
fetchClientData(clientId) {
  axios.get(`/api/clients/${clientId}`)
      .then(response => {
          if (response.data) {
              const client = response.data;
              
              // Set the client's name
              this.form.name = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
              
              // Set the client's birthdate and calculate the age
              if (client.date_of_birth) {
                  this.form.birthdate = client.date_of_birth;
                  this.form.place_of_birth = client.place_of_birth;
                  this.form.age = this.calculateAge(client.date_of_birth);
              }
              
              // Set other client details if needed
              this.dateAdmitted = client.admissions[0]?.date_admitted;
              this.form.client_id = client.id;

          } else {
              console.warn('Client data not found.');
          }
      })
      .catch(error => {
          this.message = 'Error fetching client data.';
          this.messageType = 'error';
          console.error('Error fetching client data:', error);
      });
}
,
saveData() {
  const form = this.$refs.TNAForm; // Ensure the form has the correct ref in the template
  let isFormValid = true;

  // Validate education level
  if (!this.form.selectedEducationLevel) {
      this.educationError = true;
      this.educationErrorMessage = 'Please select an education level.';
      isFormValid = false;
    } else {
      this.educationError = false;
      this.educationErrorMessage = '';
    }

  // Validate the form fields and check for any invalid fields
  if (!form.checkValidity()) {
    isFormValid = false;
    form.reportValidity(); // This will display validation messages and scroll to the first invalid field
  }

  // If all fields are valid, open the confirmation modal
  if (isFormValid) {
    this.isModalOpen = true;  // Open the modal to confirm saving
  } else {
    console.warn('Form contains invalid fields. Please correct them.');
  }
},

confirmSave() {
  // Prepare data for saving
  const clientId = this.form.client_id;
  const url = `/api/training-needs-assessment/${clientId}`;

  // Validate that education level is provided before saving
  if (!this.form.selectedEducationLevel) {
    this.message = 'Education level is required.';
    this.messageType = 'error';
    return;
  }

  // Prepare the education details array
  this.form.education_details = [{
    education_level: this.form.selectedEducationLevel,
    year_or_grade: this.getYearOrGradeForLevel(this.form.selectedEducationLevel)
  }];

  // Prepare the training_sector_details array based on the sectors
  this.form.training_sector_details = [
    ...this.automotiveSector.map(s => ({ sector: 'Automotive', ...s })),
    ...this.agriculturalSector.map(s => ({ sector: 'Agricultural', ...s })),
    ...this.healthSector.map(s => ({ sector: 'Health', ...s })),
    ...this.ictSector.map(s => ({ sector: 'ICT', ...s })),
    ...this.metalsSector.map(s => ({ sector: 'Metals', ...s })),
    ...this.tourismSector.map(s => ({ sector: 'Tourism', ...s })),
    ...this.constructionSector.map(s => ({ sector: 'Construction', ...s })),
    ...this.basicTrainings.map(s => ({ sector: 'Basic', ...s })),
  ];

  // Prepare the training details array
  this.form.training_details = this.form.trainings.map(t => ({
    title: t.title,
    duration: t.duration,
    location_outside: t.location_outside,
    location_inside: t.location_inside
  }));

  // Save data using Axios PUT
  axios.put(url, this.form)
    .then(response => {
      this.message = 'Data saved successfully!';
      this.messageType = 'success';
      this.saveResultTitle = 'Success';
      this.saveResultMessage = 'Data saved successfully.';
      this.isSaveResultModalOpen = true;
      this.editMode = false; // Exit edit mode after saving
    })
    .catch(error => {
      this.message = 'Failed to save data.';
      this.messageType = 'error';
      this.saveResultTitle = 'Error';
      this.saveResultMessage = error.response?.data?.message || 'Error saving data.';
      this.isSaveResultModalOpen = true;
      console.error('Error saving data:', error);
    })
    .finally(() => {
      this.isModalOpen = false;  // Close the confirmation modal
    });
},
getYearOrGradeForLevel(level) {
    // Logic to get the year or grade based on selected education level
    switch (level) {
      case 'Elementary Level':
        return this.form.elementaryGrade;
      case 'Junior High School Level':
        return this.form.juniorHighYear;
      case 'Senior High School Level':
        return this.form.seniorHighYear;
      case 'College Level':
        return this.form.collegeYear;
      default:
        return '';
    }
  },
openModal() {
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
    },
    cancelEdit() {
      this.editMode = false;
    },
    closeSaveResultModal() {
       this.isSaveResultModalOpen = false;
       this.saveResultTitle = '';
       this.saveResultMessage = '';
     },
getYearOrGradeForLevel(level) {
  switch (level) {
    case 'Elementary Level':
      return this.form.elementaryGrade;
    case 'Junior High School Level':
      return this.form.juniorHighYear;
    case 'Senior High School Level':
      return this.form.seniorHighYear;
    case 'College Level':
      return this.form.collegeYear;
    default:
      return ''; // Return an empty string or null if no match
  }
},
  addNewTraining() {
    this.form.trainings.push({ title: '', duration: '', location_outside: '', location_inside: '' });
  },
removeTraining(index) {
    this.form.trainings.splice(index, 1);
  },
  generatePdf() {
        console.log('Current selected education level:', this.form.selectedEducationLevel);
        // Call your PDF generation logic here
        this.exportToPdf(); // Assuming this method generates the PDF
    },

    logRank(item) {
      console.log(`Selected Rank for ${item.name} is ${item.rank}`);
    },

  exportToPdf() {
    const pdf = new jsPDF('p', 'mm', [216, 356]);  // Custom size: 216 mm x 356 mm (Long paper size)
const pageHeight = pdf.internal.pageSize.getHeight();  // Long paper height in mm
    const marginBottom = 30; // Space for footer
    const footerHeight = 20; // Space for footer
    let currentY = 140; // Start Y position for content
    let currenty = 140;
    let currentPage = 1; // Track current page
  
      const addHeader = () => {
          pdf.setFontSize(10);
          pdf.setFont('Times', 'bold');
          pdf.text('PROTECTIVE SERVICES DIVISION', 160, 20, { align: 'center' });
          pdf.text('REGIONAL REHABILITATION CENTER FOR YOUTH', 160, 25, { align: 'center' });
          pdf.text('Youth/RFO XI', 160, 30, { align: 'center' });
          pdf.setFontSize(8);
          pdf.setFont('Times', 'italic');
          pdf.text('DSWD-GF-010 | REV 02 | 22 SEP 2023', 135, 35);
          pdf.line(10,37,200,37);
      };
      const addHeader2 = () => {
          pdf.setFontSize(8);
          pdf.setFont('Times', 'italic');
          pdf.text('DSWD-GF-010 | REV 02 | 22 SEPT 2023', 148, 25);
          
      };
  
      const addFooter = () => {
          pdf.setFontSize(8); 
          pdf.addImage(imgData2, 'PNG', 165, 325, 30, 20);
          pdf.setFont('Times', 'normal');
          pdf.text('DSWD FOXI, Regional Rehabilitation Center for Youth, Bago Oshiro, Davao City, Philippines 8000', 105, pageHeight - marginBottom + 10, { align: 'center' });
          pdf.text('Email:rrcy.fo11.dswd.gov.ph; Tel No.(082) 293-0306', 105, pageHeight - marginBottom + 15, { align: 'center' });
      };

      const addFooter2 = () => {
          pdf.setFontSize(8); 
          
          pdf.setFont('Times', 'normal');
          pdf.text('DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH', 105, pageHeight - marginBottom + 10, { align: 'center' });
      }


      const addPage = () => {
          
          if (currentY >= (pageHeight - marginBottom - footerHeight)) {
       
        pdf.addPage(); // Create new page
        currentY = 40; // Reset Y position for new page
        currentPage++;
      }
      };

      // Add header to the first page
      addHeader();
      
      
  

    // Add logo image (replace with the actual base64 or URL)
    const imgData = '/images/headerlogo2.png';  // Example, replace with actual path or base64 image
    pdf.addImage(imgData, 'PNG', 10, 5, 70, 40); // Add image (left, top, width, height)

    const imgData2 = '/images/footerimg.png';  // Example, replace with actual path or base64 image
   
    

    addFooter();
   

    // Form title
    pdf.setFontSize(16);
    pdf.setFont('Arial', 'bold')
    pdf.text('TRAINING NEEDS ASSESSMENT', 105, 45, null, null, 'center');

    // Add fields like "FOR THE" and "Date of Admission"
    pdf.setFontSize(12);
    pdf.text(`FOR THE: ${this.form.period||''}` , 105, 50, "center");
    
    pdf.text(`Date of Admission: ${this.form.period||''}`, 105, 55, "center");
    

    pdf.setFontSize(11);
    pdf.text(`Petsa sa Pagtubag: ${this.form.period||''}`, 160, 65, "center"); // Example name
    
    // Add personal information fields
    pdf.text(`Pangalan: ${this.form.name|| ''}`, 20, 75);
    
    

    pdf.text(`Adlaw nga Natawhan: ${this.form.birthdate||''}`, 20, 85);
    pdf.text(`Lugar nga Natawhan: ${this.form.place_of_birth||''}`, 20, 90);
    
    

    pdf.text(`Edad: ${this.form.age||''}`, 130, 85);
    

    // Education Section
    

    pdf.setFontSize(10);
    pdf.setFont('Arial', 'bold'); // Ensure Arial is registered properly
    pdf.text('Natapos nga Grado:', 20, 95);
    pdf.setFont('Arial', 'normal');

    // Using ASCII representation for checkmarks
    pdf.text(`[ ${this.form.selectedEducationLevel === 'Wala Naka eskwela' ? '/' : ' '} ] Wala Naka eskwela`, 30, 105);
    pdf.text(`[ ${this.form.selectedEducationLevel === 'Elementary Level' ? '/' : ' '} ] Elementary Level (Grade `, 30, 115);
    pdf.text(`${this.form.elementaryGrade||''} )`, 80, 115); // Display the grade if applicable
   

    pdf.text(`[ ${this.form.selectedEducationLevel === 'Elementary Graduate' ? '/' : ' '} ] Elementary Graduate`, 30, 125);
    pdf.text(`[ ${this.form.selectedEducationLevel === 'Junior High School Level' ? '/' : ' '} ] Junior High School Level (Year `, 100, 105);
    pdf.text(`${this.form.juniorHighYear||''} )`, 165, 105); // Display the year if applicable
   

    pdf.text(`[ ${this.form.selectedEducationLevel === 'Senior High School Level' ? '/' : ' '} ] Senior High School Level (Year `, 100, 115);
    pdf.text(`${this.form.seniorHighYear||''} )`, 165, 115); // Display the year if applicable
    

    pdf.text(`[ ${this.form.selectedEducationLevel === 'Senior High School Graduate' ? '/' : ' '} ] Senior High School Graduate`, 100, 125);
    pdf.text(`[ ${this.form.selectedEducationLevel === 'College Level' ? '/' : ' '} ] College Level (Year `, 100, 130);
    pdf.text(`${this.form.collegeYear||''} )`, 150, 130); // Display the year if applicable
    



    // Add fields for social worker, houseparent, and parents' names
    
    pdf.setFont('Arial', 'normal');
    pdf.text(`Pangalan sa imong Social Worker: ${this.form.social_worker||''}`, 20, currentY);
  

    pdf.text(`Pangalan sa imong Houseparent: ${this.form.houseparent||''}`, 20, currentY+5);
    
    pdf.setFont('Arial', 'bold');
    pdf.text(`Pangalan sa Ginikanan:`, 20, currentY+15);
    
    pdf.setFont('Arial', 'normal');
    pdf.text(`Amahan: ${this.form.father||''}`, 20, currentY+20);
    

    pdf.text(`Inahan: ${this.form.mother||''}`, 20,  currentY+ 25);
    

    // Address and other details
    pdf.text(`Pinuy-Anan: ${this.form.address||''}`, 20, currentY + 35);
    

    pdf.text(`Kadugayon sa Pagpuyo sa Center: ${this.form.center_duration||''}`, 20, currentY + 40);
    

    // Training Section
    

  
    // First row content that spans across all columns
const firstRow = [
    { content: 'Skills Training nga human na nga naapilan diri sa sulod CENTER ug sa gawas sa center', colSpan: 4, styles: { halign: 'left', fillColor: [192, 228, 255] } }
];

// Second row with three columns
const secondRow = [
    { content: 'Title sa Training nga Naapilan', colSpan: 1, styles: { halign: 'center' } },
    { content: 'Kadugayon sa Training', colSpan: 1, styles: { halign: 'center' } },
    { content: 'Lugar sa Gi-Trainingan', colSpan: 2, styles: { halign: 'center' } }
];

// Third row with four columns, splitting the third column into two sub-columns
const thirdRow = [
    { content: '', colSpan: 2 },  // Empty cells for the first two columns
    { content: 'Sa Gawas', colSpan: 1, styles: { halign: 'center' } },
    { content: 'Sa Center', colSpan: 1, styles: { halign: 'center' } }
];

// Prepare the table data (assuming this.form.trainings holds the data)
const tableData = this.form.trainings.map(training => [
    training.title,
    training.duration,
    training.location_outside,
    training.location_inside
]);
let firstTableOnPage = true;  // Assume the first table starts on the page
let secondTableOnPage = false; // Flag to track if the second table is on the current page
let firstTableEnded = false;  // Track if the first table has fully ended
let footer1Printed = false;  // Flag to track if Footer 1 has been printed
// Generate the table using autoTable
pdf.autoTable({
    head: [firstRow, secondRow, thirdRow],  // First row with merged columns, followed by the second and third row
    body: tableData,  // Training data for each row
    startY: currentY + 55,  // Adjust the Y position to start the table
    styles: { fontSize: 10, fillColor: [255, 255, 255], textColor: 0 },  // Set background color to white and text color to black
    headStyles: { fillColor: [255, 255, 255], textColor: 0, lineColor: [0, 0, 0], lineWidth: 0.3 },  // Optional: header style
    margin: { top: 30,left: 20, right: 20, bottom: 40 },  // Adjust margins if necessary
    theme: 'grid',  // Optional: adds a grid to the table
    showHead: 'firstPage',  // Show the full header on the first page only
    pageBreak: 'auto',  // Automatically handle page breaks
    

});

    currentY = pdf.autoTable.previous.finalY+5;
    addPage(); 
    


    // Title
   
    


const columns = [
    { title: " ", dataKey: "number" },
    { title: " ", dataKey: "training" },
    { title: "1", dataKey: "rank1" },
    { title: "2", dataKey: "rank2" },
    { title: "3", dataKey: "rank3" },
    { title: "4", dataKey: "rank4" },
    { title: "5", dataKey: "rank5" },
    { title: "Ikasugyot/Remarks", dataKey: "remarks" }
];

// Data for the table
const data = [];


// Add sector header row dynamically before adding actual data for each sector

// Automotive Sector

data.push([{ content: 'A. AUTOMOTIVE SECTOR', colSpan: 8, styles: { halign: 'left', fillColor: [192, 228, 255]} }]);  // Add sector header
this.automotiveSector.forEach((item, index) => {
    data.push({
        number: index + 1,
        training: item.name,
        rank1: item.rank === "1" ? '/' : '',
        rank2: item.rank === "2" ? '/' : '',
        rank3: item.rank === "3" ? '/' : '',
        rank4: item.rank === "4" ? '/' : '',
        rank5: item.rank === "5" ? '/' : '',
        remarks: item.remarks
    });
});

// Agricultural Sector
data.push([{ content: 'B. AGRICULTURAL SECTOR', colSpan: 8, styles: { halign: 'left', fillColor: [192, 228, 255] } }]);  // Add sector header
this.agriculturalSector.forEach((item, index) => {
    data.push({
        number: index + 1,
        training: item.name,
        rank1: item.rank === "1" ? '/' : '',
        rank2: item.rank === "2" ? '/' : '',
        rank3: item.rank === "3" ? '/' : '',
        rank4: item.rank === "4" ? '/' : '',
        rank5: item.rank === "5" ? '/' : '',
        remarks: item.remarks
    });
});

// Health Sector
data.push([{ content: 'C. HEALTH SECTOR', colSpan: 8, styles: { halign: 'left', fillColor: [192, 228, 255] } }]);  // Add sector header
this.healthSector.forEach((item, index) => {
    data.push({
        number: index + 1,
        training: item.name,
        rank1: item.rank === "1" ? '/' : '',
        rank2: item.rank === "2" ? '/' : '',
        rank3: item.rank === "3" ? '/' : '',
        rank4: item.rank === "4" ? '/' : '',
        rank5: item.rank === "5" ? '/' : '',
        remarks: item.remarks
    });
});

// ICT Sector
data.push([{ content: 'D. ICT SECTOR', colSpan: 8, styles: { halign: 'left', fillColor: [192, 228, 255] } }]);  // Add sector header
this.ictSector.forEach((item, index) => {
    data.push({
        number: index + 1,
        training: item.name,
        rank1: item.rank === "1" ? '/' : '',
        rank2: item.rank === "2" ? '/' : '',
        rank3: item.rank === "3" ? '/' : '',
        rank4: item.rank === "4" ? '/' : '',
        rank5: item.rank === "5" ? '/' : '',
        remarks: item.remarks
    });
});

// Metals Sector
data.push([{ content: 'E. METALS SECTOR', colSpan: 8, styles: { halign: 'left', fillColor: [192, 228, 255] } }]);  // Add sector header
this.metalsSector.forEach((item, index) => {
    data.push({
        number: index + 1,
        training: item.name,
        rank1: item.rank === "1" ? '/' : '',
        rank2: item.rank === "2" ? '/' : '',
        rank3: item.rank === "3" ? '/' : '',
        rank4: item.rank === "4" ? '/' : '',
        rank5: item.rank === "5" ? '/' : '',
        remarks: item.remarks
    });
});

// Tourism Sector
data.push([{ content: 'F. TOURISM SECTOR', colSpan: 8, styles: { halign: 'left', fillColor: [192, 228, 255] } }]);  // Add sector header
this.tourismSector.forEach((item, index) => {
    data.push({
        number: index + 1,
        training: item.name,
        rank1: item.rank === "1" ? '/' : '',
        rank2: item.rank === "2" ? '/' : '',
        rank3: item.rank === "3" ? '/' : '',
        rank4: item.rank === "4" ? '/' : '',
        rank5: item.rank === "5" ? '/' : '',
        remarks: item.remarks
    });
});

// Construction Sector
data.push([{ content: 'G. CONSTRUCTION SECTOR', colSpan: 8, styles: { halign: 'left', fillColor: [192, 228, 255] } }]);  // Add sector header
this.constructionSector.forEach((item, index) => {
    data.push({
        number: index + 1,
        training: item.name,
        rank1: item.rank === "1" ? '/' : '',
        rank2: item.rank === "2" ? '/' : '',
        rank3: item.rank === "3" ? '/' : '',
        rank4: item.rank === "4" ? '/' : '',
        rank5: item.rank === "5" ? '/' : '',
        remarks: item.remarks
    });
});

// Basic Trainings
data.push([{ content: 'H. BASIC TRAININGS', colSpan: 8, styles: { halign: 'left', fillColor: [192, 228, 255] } }]);  // Add sector header
this.basicTrainings.forEach((item, index) => {
    data.push({
        number: index + 1,
        training: item.name,
        rank1: item.rank === "1" ? '/' : '',
        rank2: item.rank === "2" ? '/' : '',
        rank3: item.rank === "3" ? '/' : '',
        rank4: item.rank === "4" ? '/' : '',
        rank5: item.rank === "5" ? '/' : '',
        remarks: item.remarks
    });
});

// Create the auto table

const topRow = [
    { content: 'Skills Training Nga Gustong Apilan Diri Sulod sa CENTER', colSpan: 2, styles: { halign: 'center', fillColor: [255, 255, 0] }  },  // First cell spans two columns
    { content: 'Pamili ug lima (5) ka skills o kahanas nga gusto nimo matun-an o prioridad nga maapilan diri sa sulod sa center kung diin ang 1 pinakagusto nga unang maapilan ug ang 5 ang pinakaulahi nga gustong maapilan o matun-an.', colSpan: 6, styles: { halign: 'left', fillColor: [255, 255, 0] } }  // Second cell spans six columns
];

currentY+=30;
// Create the auto table with custom top row added before headers
// Initialize a variable to track the row number
let currentRowNumber = 1; // Initialize the row number to start from 1

// Create the table with a single header on the first page and continuous numbering
pdf.autoTable({
    head: [
        [  // Add the top row as a part of the head
            { content: 'Skills Training Nga Gustong Apilan Diri Sulod sa CENTER', colSpan: 2, styles: { halign: 'center', fillColor: [255, 255, 255], fontSize: 10 } }, 
            { content: 'Pamili ug lima (5) ka skills o kahanas nga gusto nimo matun-an o prioridad nga maapilan diri sa sulod sa center kung diin ang 1 pinakagusto nga unang maapilan ug ang 5 ang pinakaulahi nga gustong maapilan o matun-an.', colSpan: 6, styles: { halign: 'left', fillColor: [255, 255, 255], fontSize: 10 } }
        ],
        columns.map(col => col.title)  // Column headers for the table
    ],
    body: data.map(item => {
        // Only increment the row number for non-sector rows (i.e., data rows)
        if (!Array.isArray(item)) {
            const rowNumber = currentRowNumber++;
            return [rowNumber, item.training, item.rank1, item.rank2, item.rank3, item.rank4, item.rank5, item.remarks];
        }
        return item; // Return sector header rows without incrementing the row number
    }),
    startY: currentY,  // Set the starting Y position
    styles: { fontSize: 10, fillColor: [255, 255, 255], textColor: 0 },  // Table styles
    headStyles: { fillColor: [255, 255, 0], textColor: 0, lineColor: [0, 0, 0], lineWidth: 0.3 },  // Header styles
    margin: { top: 30, left: 20, right: 20, bottom: 70 },  // Margins
    theme: 'grid',  // Optional grid theme
    showHead: 'firstPage',  // Show the full header on the first page only
    pageBreak: 'auto',  // Automatically handle page breaks
    didDrawPage: function (data) {
        // This is for Table 2's presence on the page
        secondTableOnPage = true;  // Mark that Table 2 is present on the page
        
        // If Table 2 is present, add Footer 2 (and skip Footer 1)
        if (secondTableOnPage) {
            addHeader2();  // Add the header for the second table
            addFooter2();  // Add the second footer
        }
    },
    didDrawCell: function (data) {
        // Check if Table 2 has finished on the current page
        if (data.section === 'body' && data.row.index === data.table.body.length - 1) {
            secondTableOnPage = false;  // Mark that Table 2 has finished on the page
        }
    }
});


    addPage();

    

    pdf.text(`${this.form.name||''}`, 160, 300, "center");
    pdf.line(130, 301, 190, 301);
    pdf.text("Pangalan ug Pirma sa Residente", 160, 306, "center");

  
    const totalPages = pdf.internal.getNumberOfPages();
    for (let i = 1; i <= totalPages; i++) {
      pdf.setPage(i);
      pdf.setFontSize(9);
      pdf.setFont('Times', 'bold');
      pdf.text(`PAGE ${i} of ${totalPages}`, 105, pageHeight - marginBottom + 5, { align: 'center' });
      marginBottom;
    }

    // Save the PDF
    pdf.save('Training_Needs_Assessment.pdf');
  }
}
};
</script>

<style scoped>
.table-header {
background-color: #d1d5db; /* Tailwind gray-300 */
}
.table-subheader {
background-color: #f3f4f6; /* Tailwind gray-100 */
}
.table-title {
font-weight: bold;
}
.graph-background {
    background-image: linear-gradient(to right, #cccccc 1px, transparent 1px), 
                      linear-gradient(to bottom, #cccccc 1px, transparent 1px);
    background-size: 15px 15px; /* Adjust size as per your need */
  } 
</style>