<template>
  <!-- Tabs for Actions -->
  <div v-if="editMode" class="flex absolute p-4 space-x-4">
      <button @click="cancelEdit" class="flex space-x-2 px-3 py-3 bg-blue-900 hover:bg-blue-950 text-white rounded-md text-xs">
        <!-- FontAwesome for Back -->
        <i class="fas fa-arrow-left w-4 h-4"></i>
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
      <button v-if="!editMode" @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-xs">
        <!-- FontAwesome for Edit -->
        <i class="fas fa-edit w-4 h-4"></i>
        <span>Edit</span>
      </button>
  
      <button v-if="editMode" @click="saveData" class="flex items-center space-x-2 px-3 py-1 bg-green-500 hover:bg-green-600 text-white rounded-md text-xs">
        <!-- FontAwesome for Save -->
        <i class="fas fa-check w-4 h-4"></i>
        <span>Save</span>
      </button>
  
      <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-xs">
      
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
            <button @click="closeSaveResultModal" :class="saveResultTitle === 'Error' ? 'bg-red-600 hover:bg-red-500' : 'bg-blue-600 hover:bg-blue-500'" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">OK</button>
          </div>
        </div>
      </div>
  
      <form ref="indicatorsForm" @submit.prevent="saveData">
      <div class="graph-background pt-0.5  -mr-9 -mb-16">
    <div class="mt-8">
      <!-- Page 1 -->
      <div v-if="currentPage === 1" class="max-w-4xl mx-auto border border-gray-400 bg-white p-12 rounded-lg shadow-lg mb-10">
        <div class="relative flex justify-between items-center mb-2">
          <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
          <p class="text-[12px] text-right mb-8" style="font-family: 'Times New Roman', Times, serif; font-style: italic;">DSWD-GF-010A | REV 00 | 22 SEP 2023
</p>
        </div>
  
        <h1 class="text-2xl font-bold text-center mb-4">INDICATORS OF SOCIAL FUNCTIONING</h1>
  
      
  
        <div v-if="errorMessage" class="p-4 mt-4 text-white rounded-md bg-red-500">
          {{ errorMessage }}
        </div>
  
        <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
          {{ message }}
        </div>
        
        <div class="flex items-center mb-4">
           <div class="flex-grow flex items-center mr-4">
            <label class="block mr-16 text-base font-semibold text-gray-700 flex items-center h-full">CLIENT:</label>
            <input type="text" class="ml-24 p-0 mt-1 w-1/2 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-md" v-model="clientName" readonly />
          </div>
        </div>
  
        <div class="flex items-center mb-4">
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-10 flex items-center h-full">DATE ADMISSION:</label>
            <input type="date" class="ml-10 p-0 mt-1 w-1/2 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-md" v-model="form.dateAdmission" readonly />
          </div>
        </div>
  
        <div class="flex items-center mb-4">
          <div class="flex-grow flex items-center mr-4">
            <label class="block text-base font-semibold text-gray-700 mr-4 flex items-center h-full">DATE ADMINISTERED:</label>
            <input 
  type="date" 
  class="ml-8 p-0 mt-1 w-1/2 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-md" 
  v-model="form.date_administered" 
  :readonly="!editMode" 
  required 
  :max="new Date().toLocaleString('en-CA', { 
      timeZone: 'Asia/Manila', 
      year: 'numeric', 
      month: '2-digit', 
      day: '2-digit' 
    }).split(',')[0]"  
  @input="(e) => { 
    const inputDate = new Date(e.target.value); 
    const inputYear = inputDate.getFullYear(); 
    const currentYear = new Date().getFullYear();
    if (inputYear < 1950 || inputYear > currentYear) { 
      e.target.setCustomValidity(`Please provide a valid year between 1950 and ${currentYear}`); 
    } else { 
      e.target.setCustomValidity(''); 
    } 
  }" 
  oninvalid="this.setCustomValidity('Please provide a valid date between 1950 and the present year')"
/>


          </div>
        </div>
              <!-- The rest of your table goes here -->
              <table class="min-w-full  bg-white">
                <thead>
  <tr>
    <!-- AREAS column with rowspan to merge -->
    <th class="py-2 px-1 border border-black" style="width: 50px;" rowspan="2">
      AREAS
    </th>
    <th class="py-2 px-4 border-t border-black border-l border-b border-r-0">
      Severely-Impaired Functioning
    </th>
    <th class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0" style="width: 10px;"></th>
    <th class="py-2 px-4 border-t border-black border-l border-b border-r-0">
      Moderately-Impaired Functioning
    </th>
    <th class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0" style="width: 30px;"></th>
    <th class="py-2 px-4 border-t border-black border-l border-b border-r-0">
      Normal Functioning
    </th>
    <th class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0" style="width: 30px;"></th>

    <!-- Raw Score column with rowspan to merge -->
    <th class="py-2 px-4 border border-black" rowspan="2">
      Raw Score
    </th>
    
    <!-- Score per Area column with rowspan to merge -->
    <th class="py-2 px-4 border border-black" rowspan="2">
      Score per Area
    </th>
  </tr>
  <tr>
    <!-- Instruction row under Functioning columns -->
    <td class="py-1 italic px-4 border-t border-black border-l border-b border-r-0">
      If check please input "1" in Column C.
    </td>
    <td class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0"></td>
    <td class="py-2 italic px-4 border-t border-black border-l border-b border-r-0">
      If check please input "2" in Column E.
    </td>
    <td class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0"></td>
    <td class="py-2 italic px-4 border-t border-black border-l border-b border-r-0">
      If check please input "3" in Column G.
    </td>
    <td class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0"></td>
  </tr>
</thead>

                  <tbody class="text-[11px] border border-black">
                      <!-- Physical rows here -->
  
                      <tr>
                        <td class="py-2 text-[16px] font-bold px-4 border border-black" rowspan="2">Physical</td>
                <td class="py-2 px-4 border border-black">Has very poor hygiene and grooming</td>
                <td class="py-2 px-4 border border-black">
                  <input type="checkbox" v-model="form.indicators_level.physical_one" :disabled="!editMode" @change="selectOnlyOne('physical_first', 'physical_one', 1)">
                </td>
                <td class="py-2 px-4 border border-black">Practices adequate self-care habits but still needs monitoring and supervision to maintain such</td>
                <td class="py-2 px-4 border border-black">
                  <input type="checkbox" v-model="form.indicators_level.physical_two" :disabled="!editMode" @change="selectOnlyOne('physical_first', 'physical_two', 2)">
                </td>
                <td class="py-2 px-4 border border-black">Practices adequate self-care habits even without monitoring and supervision</td>
                <td class="py-2 px-4 border border-black">
                  <input type="checkbox" v-model="form.indicators_level.physical_three" :disabled="!editMode" @change="selectOnlyOne('physical_first', 'physical_three', 3)">
                </td>
                <td class="py-2 px-4 border border-black">
                  <input 
  type="text" 
  class="w-full mt-1 p-2 border border-black rounded-md" 
  v-model="form.physical_raw_score1" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('physical_raw_score1', 'physical_first'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the physical raw score for this field'); }"
  required 
/>
                </td>
                <td class="py-2 px-3 border border-black" rowspan="2">
                  <input type="text" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.physical_score_per_area1" readonly>
                </td>
              </tr>
              <td class="py-2 px-4 border border-black">Is completely dependent to others due to absence of appropriate skills to manage physical disability</td>
              <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.physical_four" :disabled="!editMode" @change="selectOnlyOne('physical_second','physical_four', 1)"></td>
                <td class="py-2 px-4 border border-black">With very limited skills to manage physical disability which causes him or her to unnecessarily require assistance from others at times</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.physical_five" :disabled="!editMode" @change="selectOnlyOne('physical_second','physical_five', 2)"></td>
                <td class="py-2 px-4 border border-black">Has appropriate skills to function within capacity</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.physical_six" :disabled="!editMode" @change="selectOnlyOne('physical_second','physical_six', 3)"></td>
                <td class="py-2 px-4 border border-black">
                  <input 
  type="text" 
  class="w-full mt-1 p-2 border border-black rounded-md" 
  v-model="form.physical_raw_score2" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('physical_raw_score2', 'physical_second'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the physical raw score for this field'); }"
  required 
/>
                </td>
                <tr>
                <td class="py-2 px-4 text-[16px] font-bold border border-black" rowspan="6">Emotional</td>
                <td class="py-2 px-4 border border-black">Is often times sad / lonely which results to his or her lack of interest in anything despite encourage from others.</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_one" :disabled="!editMode" @change="selectOnlyOne('emotional_first','emotional_one', 1)"></td>
                <td class="py-2 px-4 border border-black">Experiences sadness / loneliness which he or she allows to interfere in the performance of daily tasks and dealings with others.</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_two" :disabled="!editMode" @change="selectOnlyOne('emotional_first','emotional_two', 2)"></td>
                <td class="py-2 px-4 border border-black">Copes well with sadness or loneliness as he or she does not let such emotion interfere both in daily tasks and social relationship.</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_three" :disabled="!editMode" @change="selectOnlyOne('emotional_first','emotional_three', 3)"></td>
                <td class="py-2 px-4 border border-black">
                  <input 
  type="text" 
  class="w-full mt-1 p-2 border border-black rounded-md" 
  v-model="form.emotional_raw_score1" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('emotional_raw_score1', 'emotional_first'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the emotional raw score for this field'); }"
  required 
/>
                </td>
                <td class="py-2 px-3 border border-black" rowspan="6">
                  <input type="text" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.emotional_score_per_area1" readonly>
                </td>
              </tr> 
              <td class="py-2 px-4 border border-black">Feels hopeless most of the time which is manifested through the following:
                <li>suicidal events</li>
          <li>absence of any interest in the center's activities</li>
          <li>self-isolation</li>
          <li>lack of desire to improve self / does not believe that his or her situation will improve at all.</li>
  </td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_four" :disabled="!editMode" @change="selectOnlyOne('emotional_second','emotional_four', 1)"></td>
                <td class="py-2 px-4 border border-black">Feels hopeless at times and allows such emotion to negatively affect performance of tasks and social relationship. However, he or she shows no suicidal tendency</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_five" :disabled="!editMode" @change="selectOnlyOne('emotional_second','emotional_five', 2)"></td>
                <td class="py-2 px-4 border border-black">Is generally optimistic despite difficult situations which enable him or her to perform tasks or roles</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_six" :disabled="!editMode" @change="selectOnlyOne('emotional_second','emotional_six', 3)"></td>
                <td class="py-2 px-4 border border-black">
                  <input 
  type="text" 
  class="w-full mt-1 p-2 border border-black rounded-md" 
  v-model="form.emotional_raw_score2" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('emotional_raw_score2', 'emotional_second'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the emotional raw score for this field'); }"
  required 
/>
                </td>
                <tr>
                
                <td class="py-2 px-4 border border-black">Oftentimes experiences extreme / severe fear because of traumatic event/s in life which results to social and functional impairment like withdrawal, fighting back, and unnecessary cautiousness</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_seven" :disabled="!editMode" @change="selectOnlyOne('emotional_third','emotional_seven', 1)"></td>                
                <td class="py-2 px-4 border border-black">Sometimes experiences fear as a result of traumatic event. With constant encouragement; however, he or she tries not to allow such to affect dealings with others and performance of tasks</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_eight" :disabled="!editMode" @change="selectOnlyOne('emotional_third','emotional_eight', 2)"></td>
                <td class="py-2 px-4 border border-black">Copes well with traumatic events as evident by his or her social and functional adjustment even with very minimal requirement for support from others</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_nine" :disabled="!editMode" @change="selectOnlyOne('emotional_third','emotional_nine', 3)"></td>
                <td class="py-2 px-4 border border-black">
                  <input 
  type="text" 
  class="w-full mt-1 p-2 border border-black rounded-md" 
  v-model="form.emotional_raw_score3" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('emotional_raw_score3', 'emotional_third'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the emotional raw score for this field'); }"
  required 
/>
                </td>
              </tr> 
              
                </tbody>
                </table>
                <div class="border-gray-300 mt-24 text-center text-xs w-full" style="font-family: 'Times New Roman', Times, serif;">
  <div class="flex justify-between items-center w-full">
    <div class="flex flex-col w-full">
      <p class="-mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
      <p class="border-t mt-4 w-full" style="border-top: 2px solid black;">
        DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City
      </p>
      <p>Email: <span style="color: blue; text-decoration: underline;">rrcy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
    </div>
    <div class="ml-4">
      <img src="/images/footerimg.png" alt="" class="h-12 w-24 object-cover rounded-md">
    </div>
  </div>
</div>

        </div> 
  
                      <!-- Emotional rows here / Page 2-->
                      <div v-if="currentPage === 2" class="max-w-4xl mx-auto border border-gray-400 bg-white p-12 rounded-lg shadow-lg mb-10">
                        <p class="text-[12px] text-right mb-8" style="font-family: 'Times New Roman', Times, serif; font-style: italic;">DSWD-GF-010A | REV 00 | 22 SEP 2023
</p>

                        <table>
                        <thead>
                          <tr>
  <th class="py-2 px-1 border border-black" style="width: 50px;">
    AREAS
  </th>
  <th class="ml-20 py-2 px-4 border-t border-black border-l border-b border-r-0">
    Severely-Impaired Functioning
  </th>
  <th class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0" style="width: 10px;">
    <!-- Blank space with only top border -->
  </th>
  <th class="py-2 px-4 border-t border-black border-l border-b border-r-0">
    Moderately-Impaired Functioning
  </th>
  <th class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0" style="width: 30px;">
    <!-- Blank space with only top border -->
  </th>
  <th class="py-2 px-4 border-t border-black border-l border-b border-r-0">
    Normal Functioning
  </th>
  <th class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0" style="width: 30px;">
    <!-- Blank space with only top border -->
  </th>
  <th class="py-2 px-4 border border-black">
    Raw Score
  </th>
  <th class="py-2 px-4 border border-black">
    Score per Area
  </th>
</tr>

<!-- New Row for Instructions -->
<tr>
  <td class="py-2 px-1 border border-black"></td> <!-- Blank area under AREAS -->
  <td class="py-2 px-4 border border-black">
    If check please input "1" in Column C.
  </td>
  <td class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0"></td> <!-- Blank space -->
  <td class="py-2 px-4 border border-black">
    If check please input "2" in Column E.
  </td>
  <td class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0"></td> <!-- Blank space -->
  <td class="py-2 px-4 border border-black">
    If check please input "3" in Column G.
  </td>
  <td class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0"></td> <!-- Blank space -->
  <td class="py-2 px-4 border border-black"></td> <!-- Blank area under Raw Score -->
  <td class="py-2 px-4 border border-black"></td> <!-- Blank area under Score per Area -->
</tr>

                  </thead>
                  <tbody class="text-[11px]">
                    <tr>
                  <td class="py-2 px-4 text-[16px] font-bold border border-black" rowspan="6"></td>
                <td class="py-2 px-4 border border-black">Harbors ill feelings which renders him or her unable to build good relationship with others and to focus on tasks at hand as indicated by any or all of the following:
                  <li>dwells most of the time on planning revenge</li>
                  <li>not open to reconciliation or forgiveness</li>
                  <li>aggressive</li>
                  <li>relationship with others is superficial</li>
                  <li>displaces anger to others</li>
                </td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_ten" :disabled="!editMode" @change="selectOnlyOne('emotional_fourth','emotional_ten', 1)"></td>
                <td class="py-2 px-4 border border-black">Is trying to overcome ill feelings (e.g. hatred, resentment and anger) as may be evident by any or all of the following expressions: 
                  <li>that revenge may only worsen the situation</li>
                  <li>that reconciliation may be possible in the future</li>
                  <li>that he or she may consider forgiving the individual(s) who has/have done wrong to him or her</li>
                </td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_eleven" :disabled="!editMode" @change="selectOnlyOne('emotional_fourth','emotional_eleven', 2)"></td>
                <td class="py-2 px-4 border border-black">Has decided to let go of ill-feelings as may be evident in any or all of the following:
                  <li>has forgiven others</li>
                  <li>is ready to ask forgiveness for those whom he may have done wrong</li>
                  <li>believes that there are people who are genuinely interested in his or her welfare</li>
                </td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_twelve" :disabled="!editMode" @change="selectOnlyOne('emotional_fourth','emotional_twelve', 3)"></td>
                <td class="py-2 px-4 border border-black">
                  <input 
  type="text" 
  class="w-full mt-1 p-2 border border-black rounded-md" 
  v-model="form.emotional_raw_score4" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('emotional_raw_score4', 'emotional_fourth'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the emotional raw score for this field'); }"
  required 
/>
                </td>
                <td class="py-2 px-4 border border-black" rowspan="6">
                  
                </td>
              </tr> 
  
              <tr>
                
                <td class="py-2 px-4 border border-black">Is severely guilty for grave offense committed which make him or her feel unworthy and incapable of doing good</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_thirteen" :disabled="!editMode" @change="selectOnlyOne('emotional_fifth','emotional_thirteen', 1)"></td>
                <td class="py-2 px-4 border border-black">Feels guilty for grave offense committed which make him or her at times doubt capacity to be a good person</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_fourteen" :disabled="!editMode" @change="selectOnlyOne('emotional_fifth','emotional_fourteen', 2)"></td>
                <td class="py-2 px-4 border border-black">Because of feelings of guilt for an offense committed, he or she strives to change negative attitudes that cause damage to others</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_fifteen" :disabled="!editMode" @change="selectOnlyOne('emotional_fifth','emotional_fifteen', 3)"></td>
                <td class="py-2 px-4 border border-black">
                  <input 
  type="text" 
  class="w-full mt-1 p-2 border border-black rounded-md" 
  v-model="form.emotional_raw_score5" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('emotional_raw_score5', 'emotional_fifth'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the emotional raw score for this field'); }"
  required 
/>
                </td>
              </tr> 
  
              <tr>
                
                <td class="py-2 px-4 border border-black">Is severely guilty because of the incarceration of her abuser which, she is made to believe, resulted to the difficulties being faced by the family. Such emotion cripples her daily interaction with others</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_sixteen" :disabled="!editMode" @change="selectOnlyOne('emotional_sixth','emotional_sixteen', 1)"></td>
                <td class="py-2 px-4 border border-black">Sometimes think that she is to blame because of family disintegration due to the case she filed against her perpetrator</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_seventeen" :disabled="!editMode" @change="selectOnlyOne('emotional_sixth','emotional_seventeen', 2)"></td>
                <td class="py-2 px-4 border border-black">Believes that revealing the truth about the abuse she experienced and taking legal action are appropriate. Feels good about self for taking the right action against her perpetrator.</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.emotional_eighteen" :disabled="!editMode" @change="selectOnlyOne('emotional_sixth','emotional_eighteen', 3)"></td>

                <td class="py-2 px-4 border border-black">

                  <input 
  type="text" 
  class="w-full mt-1 p-2 border border-black rounded-md" 
  v-model="form.emotional_raw_score6" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('emotional_raw_score6', 'emotional_sixth'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the emotional raw score for this field'); }"
  required 
/>
                </td>
              </tr> 
                  </tbody>
                   <!-- Social / Behavioral rows here -->
                   <tr class="text-[11px]">
                <td class="py-2 text-[16px] font-bold px-4 border border-black" rowspan="8">Social / Behavioral</td>
                <td class="py-2 px-4 border border-black">Has no self-control as maybe evident in any or all of the following:
                  <li>frequent involvement in fights (physical and verbal)</li>
                  <li>inappropriate sexual behavior (e.g. frequent masturbation even in the presence of others)</li>
                  <li>saying offensive words without caution</li>
                  <li>vices</li>
                </td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_one" :disabled="!editMode" @change="selectOnlyOne('social_first','social_one', 1)"></td>
                <td class="py-2 px-4 border border-black">Exercises self-control when he or she believes that it will bring him or her some reward or will make him or her appear good to others</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_two" :disabled="!editMode" @change="selectOnlyOne('social_first','social_two', 2)"></td>
                <td class="py-2 px-4 border border-black">Exercises self-control in all cases as evident in the following:
                  <li>cautious in giving comments so that he or she may not hurt or offend others</li>
                  <li>avoids involvement in fights</li>
                  <li>avoids stealing</li>
                  <li>avoids display of inappropriate sexual behavior</li>
                </td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_three" :disabled="!editMode" @change="selectOnlyOne('social_first','social_three', 3)"></td>
                <td class="py-2 px-4 border border-black">
                  <input 
  type="text" 
  class="w-full mt-1 p-2 border border-black rounded-md" 
  v-model="form.social_raw_score1" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('social_raw_score1', 'social_first'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the social raw score for this field'); }"
  required 
/>
                </td>
                <td class="py-2 px-3 border border-black" rowspan="6">
                  <input type="text" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.social_score_per_area1" readonly>
                </td>
              </tr> 
              <tr class="text-[11px]">
              <td class="text-[11px] py-2 px-4 border border-black">Lacks sense of responsibility as evident in refusing to perform tasks / roles and constantly complaining even if tasks given are:
                <li>appropriate to age, intellectual ability, physical strength</li>
                <li>not against his or her principles and religious belief</li>
                </td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_four" :disabled="!editMode" @change="selectOnlyOne('social_second','social_four', 1)"></td>
                <td class="text-[11px]  py-2 px-4 border border-black">Carries out responsibilities but requires supervision and close monitoring</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_five" :disabled="!editMode" @change="selectOnlyOne('social_second','social_five', 2)"></td>
                <td class="text-[11px]  py-2 px-4 border border-black">Performs responsibilities to the best of his or her ability even without prodding. He or she may at times express complaints but does so only when task given is not within his or her own capacity and not against religious beliefs and principles</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_six" :disabled="!editMode" @change="selectOnlyOne('social_second','social_six', 3)"></td>
                <td class="py-2 px-4 border border-black">
                  <input 
  type="text" 
  class="w-full p-2 border border-black rounded-md" 
  v-model="form.social_raw_score2" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('social_raw_score2', 'social_second'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the social raw score for this field'); }"
  required 
/>
                </td> 
              </tr>   
              </table>
              <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
  <div class="flex justify-between items-center">
    
    <!-- Left Section: Page number -->
    <div class="flex flex-col flex-grow">
      <!-- Page number centered -->
      <p class="text-center -mb-1 font-bold">PAGE 2 of {{ totalPages }}</p>

    <!-- Continuous horizontal line, moved to the left with space on the right -->
    <div style="border-top: 2px solid black; width: 103%; margin-top: 4px; margin-left: -24px;"></div>


      <!-- Text under the line -->
      <p style="text-align: center; font-weight: bold; margin-top: -1px;"> DSWD | PROTECTIVE SERVICES DIVISION / FIELD OFFICE XI | REGIONAL REHABILITATION CENTER FOR YOUTH
      </p>
    </div>

  </div>
</div>
              
          </div>
          
        </div>
  
  
          <!--page 3-->
          <div v-if="currentPage === 3" class="max-w-4xl mx-auto border border-gray-400 bg-white p-12 rounded-lg shadow-lg mb-10">
            <p class="text-[12px] text-right mb-8" style="font-family: 'Times New Roman', Times, serif; font-style: italic;">DSWD-GF-010A | REV 00 | 22 SEP 2023
</p>

            <table>
                  <thead>
                    <tr>
                      <th class="py-2 px-1 border border-black" style="width: 50px;">
                        AREAS
                      </th>
                      <th class="ml-20 py-2 px-4 border-t border-black border-l border-b border-r-0">
                        Severely-Impaired Functioning
                      </th>
                      <th class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0" style="width: 10px;">
                        <!-- Blank space with only top border -->
                      </th>
                      <th class="py-2 px-4 border-t border-black border-l border-b border-r-0">
                        Moderately-Impaired Functioning
                      </th>
                      <th class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0" style="width: 30px;">
                        <!-- Blank space with only top border -->
                      </th>
                      <th class="py-2 px-4 border-t border-black border-l border-b border-r-0">
                        Normal Functioning
                      </th>
                      <th class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0" style="width: 30px;">
                        <!-- Blank space with only top border -->
                      </th>
                      <th class="py-2 px-4 border border-black">
                        Raw Score
                      </th>
                      <th class="py-2 px-4 border border-black">
                        Score per Area
                      </th>
                    </tr>
                  </thead>
          
                  <tbody class="text-[11px]">
            <tr>
              <td class="py-2 px-4 border border-black" rowspan="8"></td>
                <td class="py-2 px-4 border border-black">Has no self-confidence which cause him or her to do most or all of the following:
                  <li>always refuses to participate in sports, socio-cultural, and skills training even if constantly encouraged</li>
                  <li>constantly makes negative self-talk (e.g. I cannot do it, I am good for nothing, etc.)</li>
                  <li>always dwells on what she or he cannot do rather than on what she or he can perform</li>
                  <li>isolates self, most of the time</li>  
                </td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_seven" :disabled="!editMode" @change="selectOnlyOne('social_third','social_seven', 1)"></td>
                <td class="py-2 px-4 border border-black">Tries to participate in center's activities although with some degree of hesitation because of doubt that she or he will be able to perform as expected. Needs constant encouragement.</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_eight" :disabled="!editMode" @change="selectOnlyOne('social_third','social_eight', 2)"></td>
                <td class="py-2 px-4 border border-black">Aware of limitations but still maintain healthy self-confidence as shown in his or her ability to do the following:
                  <li>assert</li>
                  <li>avoid saying self-demeaning words</li>
                  <li>active participation in center's activities</li>
                </td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_nine" :disabled="!editMode" @change="selectOnlyOne('social_third','social_nine', 3)"></td>
                <td class="py-2 px-4 border border-black">
                  <input 
  type="text" 
  class="w-full mt-1 p-2 border border-black rounded-md" 
  v-model="form.social_raw_score3" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('social_raw_score3', 'social_third'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the social raw score for this field'); }"
  required 
/>
                </td>
                <td class="py-2 px-4 border border-black" rowspan="6">
                </td>
              </tr> 
              
              <tr>
                
                <td class="py-2 px-4 border border-black">Disrespectful as evident in the following:
                  <li>defies center's rules and regulations</li>
                  <li>does not want to perform tasks</li>
                  <li>always answers back</li>
                </td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_ten" :disabled="!editMode" @change="selectOnlyOne('social_fourth','social_ten', 1)"></td>
                <td class="py-2 px-4 border border-black">Is selective in showing respect</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_eleven" :disabled="!editMode" @change="selectOnlyOne('social_fourth','social_eleven', 2)"></td>
                <td class="py-2 px-4 border border-black">Respects others at all times</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_twelve" :disabled="!editMode" @change="selectOnlyOne('social_fourth','social_twelve', 3)"></td>
                <td class="py-2 px-4 border border-black">
                  <input 
  type="text" 
  class="w-full mt-1 p-2 border border-black rounded-md" 
  v-model="form.social_raw_score4" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('social_raw_score4', 'social_fourth'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the social raw score for this field'); }"
  required 
/>
                </td>
                
              </tr> 
  
              <tr>
                
                <td class="py-2 px-4 border border-black">Can't decide for himself or herself either because of absence of appropriate decision-making skills</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_thirteen" :disabled="!editMode" @change="selectOnlyOne('social_fifth','social_thirteen', 1)"></td>
                <td class="py-2 px-4 border border-black">Makes decisions but always needs the confirmation of others</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_fouteen" :disabled="!editMode" @change="selectOnlyOne('social_fifth','social_fouteen', 2)"></td>
                <td class="py-2 px-4 border border-black">Decides for himself or herself but refers to others for assistance when appropriate</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_fifteen" :disabled="!editMode" @change="selectOnlyOne('social_fifth','social_fifteen', 3)"></td>
                <td class="py-2 px-4 border border-black">
                  <input 
  type="text" 
  class="w-full mt-1 p-2 border border-black rounded-md" 
  v-model="form.social_raw_score5" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('social_raw_score5', 'social_fifth'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the social raw score for this field'); }"
  required 
/>
                </td>
              </tr> 
              <tr>
                <td class="py-2 px-4 border border-black">Domineering and manipulative as can be gleaned from any or all of the following:
                  <li>attempts to lead others to violate center's rules and regulations</li>
                  <li>imposes harsh decisions, distorted values, false beliefs, inappropriate practices, etc.</li>
                  <li>intimates or threatens others to get things done</li>
                </td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_sixteen" :disabled="!editMode" @change="selectOnlyOne('social_sixth','social_sixteen', 1)"></td>
                <td class="py-2 px-4 border border-black">Sometimes tends to dominate and manipulate others, but tries to control such tendency especially when attention is called</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_seventeen" :disabled="!editMode" @change="selectOnlyOne('social_sixth','social_seventeen', 2)"></td>
                <td class="py-2 px-4 border border-black">Refrains from domineering or manipulating others as evident in the following:
                  <li>adheres to group decision</li>
                  <li>refrains from imposing beliefs, values or practices to others</li>
                  <li>refrains from threatening others to achieve or get what he or she wants</li>
                </td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_eighteen" :disabled="!editMode" @change="selectOnlyOne('social_sixth','social_eighteen', 3)"></td>
                <td class="py-2 px-4 border border-black">
                  <input 
  type="text" 
  class="w-full mt-1 p-2 border border-black rounded-md" 
  v-model="form.social_raw_score6" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('social_raw_score6', 'social_sixth'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the social raw score for this field'); }"
  required 
/>
                </td>
             
              </tr> 
  
              <tr>
                
                <td class="py-2 px-4 border border-black">Is always involved in stealing and shows no remorse</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_nineteen" :disabled="!editMode" @change="selectOnlyOne('social_seventh','social_nineteen', 1)"></td>
                <td class="py-2 px-4 border border-black">Has the tendency to steal but shows remorse by returning stolen items and expressing the need to be restrained from committing such act</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_twenty" :disabled="!editMode" @change="selectOnlyOne('social_seventh','social_twenty', 2)"></td>
                <td class="py-2 px-4 border border-black">Does not steal</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_twenty_one" :disabled="!editMode" @change="selectOnlyOne('social_seventh','social_twenty_one', 3)"></td>
                <td class="py-2 px-4 border border-black">
                  <input 
  type="text" 
  class="w-full mt-1 p-2 border border-black rounded-md" 
  v-model="form.social_raw_score7" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('social_raw_score7', 'social_seventh'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the social raw score for this field'); }"
  required 
/>
                </td>
               
              </tr> 
  
              <tr>
                
                <td class="py-2 px-4 border border-black">Always tells lies to damage or hurt others and to make self-appear superior over other people</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_twenty_two" :disabled="!editMode" @change="selectOnlyOne('social_eighth','social_twenty_two', 1)"></td>
                <td class="py-2 px-4 border border-black">Has the tendency to lie in some occasions but avoids that may harm or damage others</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_twenty_three" :disabled="!editMode" @change="selectOnlyOne('social_eighth','social_twenty_three', 2)"></td>
                <td class="py-2 px-4 border border-black">Strives to be honest at all times</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.social_twenty_four" :disabled="!editMode" @change="selectOnlyOne('social_eighth','social_twenty_four', 3)"></td>
                <td class="py-2 px-4 border border-black">
                  <input 
  type="text" 
  class="w-full mt-1 p-2 border border-black rounded-md" 
  v-model="form.social_raw_score8" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('social_raw_score8', 'social_eighth'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the social raw score for this field'); }"
  required 
/>
                </td>
               
              </tr> 
           
                    
                 
                      <!-- Add additional rows as necessary -->
          
          </tbody>
              
         
            </table>
            <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
  <div class="flex justify-between items-center">
    
    <!-- Left Section: Page number -->
    <div class="flex flex-col flex-grow">
      <!-- Page number centered -->
      <p class="text-center -mb-1 font-bold">PAGE 3 of {{ totalPages }}</p>

    <!-- Continuous horizontal line, moved to the left with space on the right -->
    <div style="border-top: 2px solid black; width: 103%; margin-top: 4px; margin-left: -24px;"></div>


      <!-- Text under the line -->
      <p style="text-align: center; font-weight: bold; margin-top: -1px;"> DSWD | PROTECTIVE SERVICES DIVISION / FIELD OFFICE XI | REGIONAL REHABILITATION CENTER FOR YOUTH
      </p>
    </div>

  </div>
</div>
              
          </div>
          
 
  
          <!-- Page 4 -->
          <div v-if="currentPage === 4" class="max-w-4xl mx-auto border border-gray-400 bg-white p-12 rounded-lg shadow-lg mb-10">
            <p class="text-[12px] text-right mb-8" style="font-family: 'Times New Roman', Times, serif; font-style: italic;">DSWD-GF-010A | REV 00 | 22 SEP 2023
</p>

            <table class="min-w-full bg-white">
                  <thead>
                    <tr>
                      <th class="py-2 px-1 border border-black" style="width: 50px;">
                        AREAS
                      </th>
                      <th class="ml-20 py-2 px-4 border-t border-black border-l border-b border-r-0">
                        Severely-Impaired Functioning
                      </th>
                      <th class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0" style="width: 10px;">
                        <!-- Blank space with only top border -->
                      </th>
                      <th class="py-2 px-4 border-t border-black border-l border-b border-r-0">
                        Moderately-Impaired Functioning
                      </th>
                      <th class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0" style="width: 30px;">
                        <!-- Blank space with only top border -->
                      </th>
                      <th class="py-2 px-4 border-t border-black border-l border-b border-r-0">
                        Normal Functioning
                      </th>
                      <th class="py-2 px-1 border-t border-black border-l-0 border-r-0 border-b-0" style="width: 30px;">
                        <!-- Blank space with only top border -->
                      </th>
                      <th class="py-2 px-4 border border-black">
                        Raw Score
                      </th>
                      <th class="py-2 px-4 border border-black">
                        Score per Area
                      </th>
                    </tr>
                  </thead>
                  <tbody class="text-[11px]">
                    <tr>
                      
                      <td class="py-2 px-4 text-[16px] font-bold border border-black" >Spiritual</td>
                <td class="py-2 px-4 border border-black">Blames God for his or her crises or failures in life which results to lingering hopelessness and other negative emotions</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.spiritual_one" :disabled="!editMode" @change="selectOnlyOne('spiritual','spiritual_one', 1)"></td>
                <td class="py-2 px-4 border border-black">Does not blame God for his or her crises and failures in life but doubts whether God cares for him or her at all</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.spiritual_two" :disabled="!editMode"  @change="selectOnlyOne('spiritual','spiritual_two', 2)"></td>
                <td class="py-2 px-4 border border-black">Recognizes that God cares for him or her and is ready to provide needed strength to cope with the crisis and failures in life</td>
                <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.spiritual_three" :disabled="!editMode"  @change="selectOnlyOne('spiritual','spiritual_three', 3)"></td>
                <td class="py-2 px-4 border border-black">
                  <input 
  type="text" 
  class="w-full mt-1 p-2 border border-black rounded-md" 
  v-model="form.spiritual_raw_score1" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('spiritual_raw_score1', 'spiritual'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the spiritual raw score for this field'); }"
  required 
/>
                </td>
                <td class="py-2 px-3 border border-black">
                  <input type="text" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.spiritual_score_per_area1" readonly>
                </td>
                
              </tr>
  
                    <tr>
                      
      <td class="py-2 px-4 text-[16px] font-bold border border-black">
          Educational / Literacy
      </td>
      <td class="py-2 px-4 border border-black">
          Not able to read, write and count
      </td>
      <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.educational_one" :disabled="!editMode"  @change="selectOnlyOne('educational','educational_one', 1)"></td>
      <td class="py-2 px-4 border border-black">
          Undertakes non-formal education or willingly
          receives tutorial services to learn basic skills
      </td>
      <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.educational_two" :disabled="!editMode" @change="selectOnlyOne('educational','educational_two', 2)"></td>
      <td class="py-2 px-4 border border-black">
          Able to read, write and count with skills
          appropriate to age and educational attainment
      </td>
      <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.educational_three" :disabled="!editMode" @change="selectOnlyOne('educational','educational_three', 3)"></td>
      <td class="py-2 px-4 border border-black">
        <input 
  type="text" 
  class="w-full mt-1 p-2 border border-black rounded-md" 
  v-model="form.educational_raw_score" 
  :readonly="!editMode" 
  @input="(e) => { handleRawScoreInput('educational_raw_score', 'educational'); e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the educational raw score for this field'); }"
  required 
/>

      </td>
      <td class="py-2 px-3 border border-black">
          <input
              type="text"
              class="w-full mt-1 p-2 border border-black  rounded-md"
              v-model="form.educational_score_per_area"
              readonly
          />
      </td>
  </tr>
  
  <tr>
      <td class="py-2 text-[16px] font-bold px-4 border border-black">
          Economic Productivity
      </td>
      <td class="py-2 px-4 border border-black">
          No employable skills and has no interest in learning
          any skills that would help him/her support his/her
          needs
      </td>
      <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.economic_one" :disabled="!editMode" @change="selectOnlyOne('economic','economic_one', 1)"></td>
      <td class="py-2 px-4 border border-black">
          Needs to brush up skills to make them usable for
          employment
      </td>
      <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.economic_two" :disabled="!editMode" @change="selectOnlyOne('economic','economic_two', 2)"></td>
      <td class="py-2 px-4 border border-black">
          Has employable skills
      </td>
      <td class="py-2 px-4 border border-black"><input type="checkbox" v-model="form.indicators_level.economic_three" :disabled="!editMode" @change="selectOnlyOne('economic','economic_three', 3)"></td>
      <td class="py-2 px-4 border border-black">
        <input
  type="text"
  class="w-full mt-1 p-2 border border-black rounded-md"
  v-model="form.economic_raw_score"
  :readonly="!editMode"
  @input="(e) => { handleRawScoreInput('economic_raw_score', 'economic'); e.target.setCustomValidity('') }"
  @invalid="(e) => { e.target.setCustomValidity('Please provide the economic raw score for this field'); }"
  required
/>

      </td>
      <td class="py-2 px-3 border border-black">
          <input
              type="text"
              class="w-full mt-1 p-2 border border-black rounded-md"
              v-model="form.economic_score_per_area"
              readonly
          />
      </td>
  </tr>
  
                  </tbody>
              </table>
              <table class="min-w-full border-collapse border border-black mt-6">
                <tr>
                  <td class="border border-black p-2 w-3/4 font-semibold text-gray-700">GENERAL SCORE</td>
                  <td class="border border-black p-2">
                    <input type="text" class="w-full border-0 p-2 focus:ring-0 text-xs" v-model="form.general_score" readonly>
                  </td>
                </tr>
                <tr>
                  <td class="border border-black p-2 font-semibold text-gray-700">INTERPRETATION</td>
                  <td class="border border-black p-2">
                    <input 
                      type="text" 
                      class="w-full border-0 p-2 focus:ring-0 text-xs" 
                      v-model="form.interpretation" 
                      :readonly="!editMode" 
                      required 
                      oninvalid="this.setCustomValidity('Please provide an interpretation')" 
                      oninput="this.setCustomValidity('')"
                    />

                  </td>
                </tr>
              </table>
              <!-- Add the interpretation guide below the table -->
              <div class="mt-4 text-sm text-gray-700">
                <p>1.50 = Severely Impaired</p>
                <p>1.51 to 2.50 = Moderately-impaired</p>
                <p>2.51 to 3.0 = Normal</p>
              </div>
          
    
              <div class="flex justify-between mt-10">
                <div class="flex flex-col items-start w-1/2 pr-4">
                  <label class="block text-gray-700">Prepared by:</label>
                  <input 
                    type="text" 
                    class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-sm p-0" 
                    v-model="form.prepared_by" 
                    :readonly="!editMode"
                    @input="form.prepared_by = removeNumbers(form.prepared_by)"
                    maxlength="50"
                  >
                  <span class="text-xs text-gray-700 mt-1">Case Manager</span>
                </div>
  
                <div class="flex flex-col items-start w-1/2 pl-4">
                  <label class="block text-gray-700">Discussed with:</label>
                  <input 
                    type="text" 
                    class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-sm p-0" 
                    v-model="clientName" 
                    readonly
                  >
                  <span class="text-xs text-gray-700 mt-1">Client</span>
                </div>
              </div>
    
              <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
  <div class="flex justify-between items-center">
    
    <!-- Left Section: Page number -->
    <div class="flex flex-col flex-grow">
      <!-- Page number centered -->
      <p class="text-center -mb-1 font-bold">PAGE 4 of {{ totalPages }}</p>

    <!-- Continuous horizontal line, moved to the left with space on the right -->
    <div style="border-top: 2px solid black; width: 103%; margin-top: 4px; margin-left: -24px;"></div>


      <!-- Text under the line -->
      <p style="text-align: center; font-weight: bold; margin-top: -1px;"> DSWD | PROTECTIVE SERVICES DIVISION / FIELD OFFICE XI | REGIONAL REHABILITATION CENTER FOR YOUTH
      </p>
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
  import '../../../fonts/arial-normal.js'; 
  import '../../../fonts/times-normal.js'; 
  import '../../../fonts/arialbd-bold.js'; 
  import jsPDF from "jspdf";
  import "jspdf-autotable";
  
  export default {
    components: {
      Pagination
    },
    data() {
      return {
      
        editMode: false,
        message: '',
        messageType: '',
        case_manager: '',
        groups: {
        physical_first: ['physical_one', 'physical_two', 'physical_three'],
        physical_second: ['physical_four', 'physical_five', 'physical_six'],
        emotional_first: ['emotional_one', 'emotional_two', 'emotional_three'],
        emotional_second: ['emotional_four', 'emotional_five', 'emotional_six'],
        emotional_third: ['emotional_seven', 'emotional_eight', 'emotional_nine'],
        emotional_fourth: ['emotional_ten', 'emotional_eleven', 'emotional_twelve'],
        emotional_fifth: ['emotional_thirteen', 'emotional_fourteen', 'emotional_fifteen'],
        emotional_sixth: ['emotional_sixteen', 'emotional_seventeen', 'emotional_eighteen'],
        social_first: ['social_one', 'social_two', 'social_three'],
        social_second: ['social_four', 'social_five', 'social_six'],
        social_third: ['social_seven', 'social_eight', 'social_nine'],
        social_fourth: ['social_ten', 'social_eleven', 'social_twelve'],
        social_fifth: ['social_thirteen', 'social_fouteen', 'social_fifteen'],
        social_sixth: ['social_sixteen', 'social_seventeen', 'social_eighteen'],
        social_seventh: ['social_nineteen', 'social_twenty', 'social_twenty_one'],
        social_eighth: ['social_twenty_two', 'social_twenty_three', 'social_twenty_four'],
        spiritual: ['spiritual_one', 'spiritual_two', 'spiritual_three'],
        educational: ['educational_one', 'educational_two', 'educational_three'],
        economic: ['economic_one', 'economic_two', 'economic_three'],
      },
        form: {
          client_id: null,
          admission_id: null,
          date_administered: '',
          physical_raw_score1: '',
          physical_score_per_area1: '',
          physical_raw_score2: '',
          emotional_raw_score1: '',
          emotional_score_per_area1: '',
          emotional_raw_score2: '',
          emotional_raw_score3: '',
          emotional_raw_score4: '',
          emotional_raw_score5: '',
          emotional_raw_score6: '',
          social_raw_score1: '',
          social_score_per_area1: '',
          social_raw_score2: '',
          social_raw_score3: '',
          social_raw_score4: '',
          social_raw_score5: '',
          social_raw_score6: '',
          social_raw_score7: '',
          social_raw_score8: '',
          spiritual_raw_score1: '',
          spiritual_score_per_area1: '',
          educational_raw_score: '',
          educational_score_per_area: '',
          economic_raw_score: '',
          economic_score_per_area: '',
          general_score: '',
          interpretation: '',
          indicators_level: {
            physical_one: false,
            physical_two: false,
            physical_three: false,
            physical_four: false,
            physical_five: false,
            physical_six: false,
            emotional_one: false,
            emotional_two: false,
            emotional_three: false,
            emotional_four: false,
            emotional_five: false,
            emotional_six: false,
            emotional_seven: false,
            emotional_eight: false,
            emotional_nine: false,
            emotional_ten: false,
            emotional_eleven: false,
            emotional_twelve: false,
            emotional_thirteen: false,
            emotional_fourteen: false,
            emotional_fifteen: false,
            emotional_sixteen: false,
            emotional_seventeen: false,
            emotional_eighteen: false,
            social_one: false,
            social_two: false,
            social_three: false,
            social_four: false,
            social_five: false,
            social_six: false,
            social_seven: false,
            social_eight: false,
            social_nine: false,
            social_ten: false,
            social_eleven: false,
            social_twelve: false,
            social_thirteen: false,
            social_fouteen: false,
            social_fifteen: false,
            social_sixteen: false,
            social_seventeen: false,
            social_eighteen: false,
            social_nineteen: false,
            social_twenty: false,
            social_twenty_one: false,
            social_twenty_two: false,
            social_twenty_three: false,
            social_twenty_four: false,
            spiritual_one: false,
            spiritual_two: false,
            spiritual_three: false,
            educational_one: false,
            educational_two: false,
            educational_three: false,
            economic_one: false,
            economic_two: false,
            economic_three: false,
        },
          prepared_by: '',
          discussed_with: ''
        },
        clientName: '',
        errorMessage: '',
        isModalOpen: false,
        isSaveResultModalOpen: false,
        saveResultTitle: '',
        saveResultMessage: '',
        totalPages: 4,
        currentPage: 1
      };
    },
    mounted() {
      const id = this.$route.params.id; // Assuming id is the indicators_id
      if (id) {
        this.fetchData(id);
        this.fetchCaseManager(id);
      }
    },
    watch: {
      '$route.params.id': function(newId) {
        if (newId) {
          this.fetchData(newId);
          this.fetchCaseManager(newId);
        }
      },
    },
    methods: {
    async fetchData(client_id) {
      console.log(`Fetching data for client_id: ${client_id}`); // Added console log for debugging
  
      try {
        const clientResponse = await axios.get(`/api/clients/${client_id}`);
        const clientData = clientResponse.data;
  
        const admissionResponse = await axios.get(`/api/admissions/client/${clientData.id}`);
        const admissionData = admissionResponse.data;
  
        const indicatorResponse = await axios.get(`/api/indicators-of-social-functioning/check/${clientData.id}/${admissionData.id}`);
        const indicatorData = indicatorResponse.data;
  
        if (!indicatorData) {
          this.message = 'No indicator data found for this client.';
          this.messageType = 'error';
          return;
        }
  
        this.clientName = `${clientData.first_name} ${clientData.middle_name ? clientData.middle_name + ' ' : ''}${clientData.last_name}`;
        this.form.client_id = clientData.id;
        this.form.admission_id = admissionData.id;
        this.form.date_administered = indicatorData.date_administered || '';
        this.form.dateAdmission = admissionData.date_admitted || '';
  
        // Assign values from indicatorData to form
        Object.keys(this.form).forEach(key => {
          if (indicatorData[key] !== undefined) {
            this.form[key] = indicatorData[key];
          }
        });
  
        this.errorMessage = '';
      } catch (error) {
        this.handleAxiosError(error);
      }
    },
    selectOnlyOne(group, checkboxField, scoreValue) {
    // Reset all checkboxes in the group
    this.groups[group].forEach(field => {
        this.form.indicators_level[field] = false;
    });

    // Set the selected checkbox
    this.form.indicators_level[checkboxField] = true;

    // Automatically update the raw score based on the selected checkbox
    switch (group) {
        case 'physical_first':
            this.form.physical_raw_score1 = scoreValue;
            break;
        case 'physical_second':
            this.form.physical_raw_score2 = scoreValue;
            break;
        case 'emotional_first':
            this.form.emotional_raw_score1 = scoreValue;
            break;
        case 'emotional_second':
            this.form.emotional_raw_score2 = scoreValue;
            break;
        case 'emotional_third':
            this.form.emotional_raw_score3 = scoreValue;
            break;
        case 'emotional_fourth':
            this.form.emotional_raw_score4 = scoreValue;
            break;
        case 'emotional_fifth':
            this.form.emotional_raw_score5 = scoreValue;
            break;
        case 'emotional_sixth':
            this.form.emotional_raw_score6 = scoreValue;
            break;
        case 'social_first':
            this.form.social_raw_score1 = scoreValue;
            break;
        case 'social_second':
            this.form.social_raw_score2 = scoreValue;
            break;
        case 'social_third':
            this.form.social_raw_score3 = scoreValue;
            break;
        case 'social_fourth':
            this.form.social_raw_score4 = scoreValue;
            break;
        case 'social_fifth':
            this.form.social_raw_score5 = scoreValue;
            break;
        case 'social_sixth':
            this.form.social_raw_score6 = scoreValue;
            break;
        case 'social_seventh':
            this.form.social_raw_score7 = scoreValue;
            break;
        case 'social_eighth':
            this.form.social_raw_score8 = scoreValue;
            break;
        case 'spiritual':
            this.form.spiritual_raw_score1 = scoreValue;
            break;
        case 'educational':
            this.form.educational_raw_score = scoreValue;
            break;
        case 'economic':
            this.form.economic_raw_score = scoreValue;
            break;
        default:
            break;
    }

    // Recalculate the scores after updating the raw score
    this.calculateScores();
},

    handleRawScoreInput(rawScoreField, group) {
        // Validate the raw score input
        if (this.form[rawScoreField] < 0) {
            this.form[rawScoreField] = 0;
        } else if (this.form[rawScoreField] > 3) {
            this.form[rawScoreField] = 3;
        }
        this.form[rawScoreField] = parseInt(this.form[rawScoreField], 10) || 0;

        const score = this.form[rawScoreField];

        // Reset checkboxes in the group
        this.groups[group].forEach(field => {
            this.form.indicators_level[field] = false;
        });

        // Update checkbox states based on the validated raw score input
        if (score === 1) {
            this.form.indicators_level[this.groups[group][0]] = true;
        } else if (score === 2) {
            this.form.indicators_level[this.groups[group][1]] = true;
        } else if (score === 3) {
            this.form.indicators_level[this.groups[group][2]] = true;
        }

        // Recalculate the score after input change
        this.calculateScores();
    },
    removeNumbers(input) {
  return input.replace(/[0-9]/g, '');
},
    calculateScores() {
    // Calculate physical score per area and round to 2 decimal places
    this.form.physical_score_per_area1 =
        this.form.physical_raw_score1 && this.form.physical_raw_score2
            ? ((parseFloat(this.form.physical_raw_score1) + parseFloat(this.form.physical_raw_score2)) / 2).toFixed(2)
            : '';

    // Calculate emotional score per area and round to 2 decimal places
    this.form.emotional_score_per_area1 =
        [
            this.form.emotional_raw_score1,
            this.form.emotional_raw_score2,
            this.form.emotional_raw_score3,
            this.form.emotional_raw_score4,
            this.form.emotional_raw_score5,
            this.form.emotional_raw_score6
        ].reduce((sum, score) => sum + (parseFloat(score) || 0), 0) / 6 || '';

    if (this.form.emotional_score_per_area1 !== '') {
        this.form.emotional_score_per_area1 = parseFloat(this.form.emotional_score_per_area1).toFixed(2);
    }

    // Calculate social score per area and round to 2 decimal places
    this.form.social_score_per_area1 =
        [
            this.form.social_raw_score1,
            this.form.social_raw_score2,
            this.form.social_raw_score3,
            this.form.social_raw_score4,
            this.form.social_raw_score5,
            this.form.social_raw_score6,
            this.form.social_raw_score7,
            this.form.social_raw_score8
        ].reduce((sum, score) => sum + (parseFloat(score) || 0), 0) / 8 || '';

    if (this.form.social_score_per_area1 !== '') {
        this.form.social_score_per_area1 = parseFloat(this.form.social_score_per_area1).toFixed(2);
    }

    // Calculate spiritual score per area and round to 2 decimal places
    this.form.spiritual_score_per_area1 = this.form.spiritual_raw_score1
        ? parseFloat(this.form.spiritual_raw_score1).toFixed(2)
        : '';

    // Calculate educational score per area and round to 2 decimal places
    this.form.educational_score_per_area = this.form.educational_raw_score
        ? parseFloat(this.form.educational_raw_score).toFixed(2)
        : '';

    // Calculate economic score per area and round to 2 decimal places
    this.form.economic_score_per_area = this.form.economic_raw_score
        ? parseFloat(this.form.economic_raw_score).toFixed(2)
        : '';

    // Calculate general score based on all available area scores, rounded to 2 decimal places
    const scores = [
        this.form.physical_score_per_area1,
        this.form.emotional_score_per_area1,
        this.form.social_score_per_area1,
        this.form.spiritual_score_per_area1,
        this.form.educational_score_per_area,
        this.form.economic_score_per_area
    ].filter(score => score !== '');

    this.form.general_score = scores.length > 0
        ? (scores.reduce((sum, score) => sum + parseFloat(score), 0) / scores.length).toFixed(2)
        : '';
}
,

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
      const clientId = this.$route.params.id;  // Get the clientId from the route
      console.log("Saving case manager:", this.case_manager, "for client:", clientId); // Log the data before the request
      if (!clientId) {
        console.error("Client ID is missing.");
        return;
      }
      axios.put(`/api/update-case-manager/${clientId}`, { 
        client_id: clientId,  // Include the client_id here
        name: this.case_manager 
      })
      .then(response => {
        console.log("Case manager saved successfully:", response.data); // Log the response
        this.editMode = false;
        this.fetchCaseManager(clientId);  // Refetch to update the UI
      })
      .catch(error => {
        console.error("Error updating case manager:", error);
      });
    }
  ,
  
      toggleEdit() {
        if (this.editMode) {
          this.saveData();
        }
        this.editMode = !this.editMode;
      },
  
      async saveData() {
  // Total number of pages (assuming you have a way to determine the total pages)
  const totalPages = this.totalPages;  // Ensure this is set correctly based on your pagination logic
  let allFieldsValid = true;

  // Loop through each page to check validity
  for (let i = 1; i <= totalPages; i++) {
    // Set the current page to the one we are validating
    this.currentPage = i;
    
    // Ensure the view updates before validation
    await this.$nextTick();

    // Get the form ref for the current page
    const form = this.$refs.indicatorsForm;  // Make sure the ref is correctly set in your template

    // Check if the current page's form is valid
    if (!form.checkValidity()) {
      allFieldsValid = false;
      form.reportValidity(); // Show validation messages and focus on invalid fields
      break; // Stop checking further pages if the current page is invalid
    }
  }

  // If all fields across all pages are valid, open the confirmation modal
  if (allFieldsValid) {
    this.isModalOpen = true;  // Open the confirmation modal
  } else {
    console.warn('Form has invalid fields, please correct them.');
    return;  // Exit if form is invalid
  }
},

// Method to confirm and save data after the user clicks "Save" in the confirmation modal
async confirmSave() {
  // Proceed with saving data after user confirmation
  try {
    const response = await axios({
      method: 'put',  // Use PUT to update the existing record
      url: `/api/indicators-of-social-functioning/${this.form.client_id}/${this.form.admission_id}`,
      data: this.form
    });

    // Display success message
    this.saveResultTitle = 'Success';
    this.saveResultMessage = 'Data saved successfully!';

    // After saving, refetch the data to update the UI
    this.fetchData(this.form.client_id);

    this.editMode = false; // Disable edit mode
  } catch (error) {
    // Display error message
    this.saveResultTitle = 'Error';
    this.saveResultMessage = 'Error saving data.';
    console.error('Error saving data:', error);
  } finally {
    // Close the confirmation modal and show the result modal
    this.isModalOpen = false;
    this.isSaveResultModalOpen = true;
  }
},
  
      openModal() {
        this.isModalOpen = true;
      },
  
      closeModal() {
        this.isModalOpen = false;
      },
  
      closeSaveResultModal() {
        this.isSaveResultModalOpen = false;
        this.saveResultTitle = '';
        this.saveResultMessage = '';
        this.closeModal();
      },
  
      cancelEdit() {
        this.editMode = false;
      },
  
      updatePage(page) {
        this.currentPage = page;
      },
      exportToPdf() {
    const doc = new jsPDF('p', 'mm', 'legal');  // 'legal' is the page size for long format.
    const pageWidth = doc.internal.pageSize.getWidth();
    const pageHeight = doc.internal.pageSize.getHeight();
    const footerMargin = 20;
  
    const clientName = this.clientName || "";
    const dateAdmission = this.form.dateAdmission || "";
    const dateAdministered = this.form.date_administered || "";
  
    // Add Header Function for First Page
    const addHeaderFirstPage = () => {
      const imgData = '/images/headerlogo2.png';  // Path to your header image
      doc.addImage(imgData, 'PNG', 13, 10, 75, 35);
      doc.setFont('Times', 'italic');
      doc.setFontSize(9);
      doc.text('DSWD-GF-010A | REV 00 | 22 SEP 2023', 142, 24);
  
      doc.addFont('arialbd-bold.ttf', 'Arial', 'bold');
      doc.setFont('Arial', 'bold');    
      doc.setFontSize(14);
      doc.text('INDICATORS OF SOCIAL FUNCTIONING', pageWidth / 2, 49, { align: 'center' });
    };
  
    // Add Header for Other Pages
    const addHeaderOtherPages = () => {
      doc.setFont('Times', 'italic');
      doc.setFontSize(9);
      doc.text('DSWD-GF-010A | REV 00 | 22 SEP 2023', 142, 15);
    };
  
    // Add Footer for First Page
    const addFooterFirstPage = (pageNumber, totalPages) => {
      const footerY = pageHeight - footerMargin + 5;
      doc.setFont('Arial', 'normal');
      doc.setFontSize(10);
  
      doc.setDrawColor(0, 0, 0);
      doc.setLineWidth(0.6);
      doc.line(15, footerY - 5, pageWidth - 35, footerY - 5);
  
      const imgData = '/images/footerimg.png';  // Path to your footer image
      doc.addImage(imgData, 'PNG', pageWidth - 35, footerY - 10, 22, 12);
  
      doc.text('DSWD Field Office XI , RRCY Purok 7, Bago Oshiro, Tugbok District, Davao City, Philippines 8000', pageWidth / 2 - 10, footerY - 1, { align: 'center' });
     
      doc.text('Website:', pageWidth / 2 - 75, footerY + 4);
      doc.text('Email:', 125, footerY + 4);
  
  
      doc.setTextColor(0, 0, 255);
      doc.textWithLink('http://www.dswd.gov.ph', pageWidth /2 - 60, footerY + 4, { url: 'http://www.dswd.gov.ph' });
      doc.textWithLink('fo11@dswd.gov.ph', 135, footerY + 4, { url: 'mailto:fo11@dswd.gov.ph' });
     
  
      doc.setTextColor(0, 0, 0);
      doc.text('Tel. No.:(082) 227-1964', pageWidth / 2 - 22, footerY + 4);
  
      doc.setFont('Arial', 'bold');
      doc.text(`PAGE ${pageNumber} of ${totalPages}`, pageWidth / 2, footerY - 7, { align: 'center' });
    };
  
    // Add Footer for Other Pages
    const addFooterOtherPages = (pageNumber, totalPages) => {
      const footerY = pageHeight - footerMargin + 5;
      doc.setFont('Times', 'normal');
      doc.setFontSize(10);
  
      doc.setDrawColor(0, 0, 0);
      doc.setLineWidth(0.6);
      doc.line(15, footerY - 5, pageWidth - 15, footerY - 5);
  
      doc.text('DSWD | PROTECTIVE SERVICES DIVISION / FIELD OFFICE XI | REGIONAL REHABILITATION CENTER FOR YOUTH', pageWidth / 2, footerY - 1, { align: 'center' });
  
      doc.setFont('Times', 'bold');
      doc.text(`PAGE ${pageNumber} of ${totalPages}`, pageWidth / 2, footerY - 7, { align: 'center' });
    };
  
   // Add Client Info to the First Page with automatic underlines
  const addClientInfo = () => {
    doc.setFont('Arial', 'normal');
    doc.setFontSize(12);
  
    const clientNameLabel = "NAME                                  : ";
    const dateAdmissionLabel = "DATE ADMISSION              : ";
    const dateAdministeredLabel = "DATE ADMINISTERED       : ";
  
    // Set a uniform X position for the data to align
    const labelX = 15;  // Starting X for the labels
    const dataX = 70;   // X position where the data (fetched values) should start
  
    // Define positions for the text and underline
    let startY = 60;
  
    // Client Name
    doc.text(clientNameLabel, labelX, startY);  // Label position
    doc.text(clientName, dataX, startY);        // Data aligned with a uniform start position
    const clientNameWidth = doc.getTextWidth(clientName);  // Calculate data width
    doc.line(dataX, startY + 1, dataX + clientNameWidth, startY + 1);  // Underline below the data
  
    // Date Admission
    startY += 5;
    doc.text(dateAdmissionLabel, labelX, startY);  // Label position
    doc.text(dateAdmission, dataX, startY);        // Data aligned with a uniform start position
    const dateAdmissionWidth = doc.getTextWidth(dateAdmission);  // Calculate data width
    doc.line(dataX, startY + 1, dataX + dateAdmissionWidth, startY + 1);  // Underline below the data
  
    // Date Administered
    startY += 5;
    doc.text(dateAdministeredLabel, labelX, startY);  // Label position
    doc.text(dateAdministered, dataX, startY);        // Data aligned with a uniform start position
    const dateAdministeredWidth = doc.getTextWidth(dateAdministered);  // Calculate data width
    doc.line(dataX, startY + 1, dataX + dateAdministeredWidth, startY + 1);  // Underline below the data
  };
  
  
    // Prepare the Table Data
    const tableData = [
      // Physical table data
      [
      { 
  content: "Physical", 
  rowSpan: 2, 
  styles: { 
    valign: 'middle', 
    halign: 'center', 
    fontStyle: 'bold', // Make the content bold
    fontWeight: 'bold'  // Ensure boldness is applied
  } 
},

    "Has very poor hygiene and grooming", "", 
    "Practices adequate self-care habits but still needs monitoring and supervision to maintain such", "", 
    "Practices adequate self-care habits even without monitoring and supervision", "", 
    this.form.physical_raw_score1 || "", 
    { 
      content: this.form.physical_score_per_area1 || "", 
      rowSpan: 2, 
      styles: { 
        valign: 'middle', 
        halign: 'center', 
        lineWidth: 0.2, 
        lineColor: [0, 0, 0] 
      } 
    }
  ],
  [
    "Is completely dependent to others due to absence of appropriate skills to manage physical disability", "", 
    "With very limited skills to manage physical disability which causes him or her to unnecessarily require assistance from others at times", "", 
    "Has appropriate skills to function within capacity", "", 
    this.form.physical_raw_score2 || "", 
    ""  // Empty cell placeholder for the second row because it's merged above
  ],
  
      [
    // First Row - Merging Emotional Section Vertically (rowSpan of 3)
    { content: "Emotional", rowSpan: 3, styles: { valign: 'middle', halign: 'center' } },
    "Is oftentimes sad / lonely which results to his or her lack of interest in anything despite encouragement from others.", "", 
    "Experiences sadness / loneliness which he or she allows to interfere in the performance of daily tasks and dealings with others.", "",
    "Copes well with sadness or loneliness as he or she does not let such emotion interfere both in daily tasks and social relationship", "",
    this.form.emotional_raw_score1 || "",  // Raw score for first row
    { content: this.form.emotional_score_per_area1 || "", rowSpan: 3, styles: { valign: 'middle', halign: 'center', lineWidth: 0.2, lineColor: [0, 0, 0] } }  // Merge Score per Area across 3 rows
  ],
  [
    // Second Row
    "Feels hopeless most of the time which is manifested through the following:\n* Suicidal events\n* Absence of any interest in the center's activities\n* Self-isolation\n* Lack of desire to improve self / does not believe that his or her situation will improve at all", "",
    "Feels hopeless at times and allows such emotion to negatively affect performance of tasks and social relationship. However, he or she shows no suicidal tendency", "",
    "Is generally optimistic despite difficult situations which enable him or her to perform tasks or roles", "",
    this.form.emotional_raw_score2 || "",  // Raw score for second row
    ""  // Empty placeholder for the Score per Area column since it's merged above
  ],
  [
    // Third Row
    "Oftentimes experiences extreme / severe fear because of traumatic event/s in life which results to social and functional impairment like withdrawal, fighting back, and unnecessary cautiousness", "",
    "Sometimes experiences fear as a result of traumatic event. With constant encouragement; however, he or she tries not to allow such to affect dealings with others and performance of tasks", "",
    "Copes well with traumatic events as evident by his or her social and functional adjustment even with very minimal requirement for support from others", "",
    this.form.emotional_raw_score3 || "",  // Raw score for third row
    ""  // Empty placeholder for the Score per Area column since it's merged above
  ],
  
    [{ content: "", rowSpan: 3, styles: { valign: 'middle', halign: 'center' } },
   
      "Harbors ill feelings which renders him or her unable to build good relationships with others and to focus on tasks at hand as indicated by any or all of the following:\n* Dwells most of the time on planning revenge\n* Not open to reconciliation or forgiveness\n* Aggressive\n* Relationship with others is superficial\n* Displaces anger to others","",
      "Is trying to overcome ill feelings (e.g. hatred, resentment, and anger) as may be evident by any or all of the following expressions:\n* That revenge may only worsen the situation\n* That reconciliation may be possible in the future\n* That he or she may consider forgiving the individual/s who has/have done wrong to him or her","",
     "Has decided to let go of ill-feelings as may be evident in any or all of the following:\n* Has forgiven others\n* Is ready to ask forgiveness for those whom he may have done wrong\n* Believes that there are people who are genuinely interested in his or her welfare","",
      this.form.emotional_raw_score4 || "",
      { content: "" || "", rowSpan: 3, styles: { valign: 'middle', halign: 'center', lineWidth: 0.2, lineColor: [0, 0, 0] } }  // Merge Score per Area across 3 rows
  
    
    ],
    [
      "Is severely guilty for grave offense committed which make him or her feel unworthy and incapable of doing good","",
      "Feels guilty for grave offense committed which make him or her at times doubt capacity to be a good person","",
      "Because of feelings of guilt for an offense committed, he or she strives to change negative attitudes that cause damage to others","",
      this.form.emotional_raw_score5 || "",
      ""
    ],
    [ 
      "Is severely guilty because of the incarceration of her abuser which, she is made to believe, resulted to the difficulties being faced by the family. Such emotion cripples her daily interaction with others","",
      "Sometimes think that she is to blame because of family disintegration due to the case she filed against her perpetrator","",
      "Believes that revealing the truth about the abuse she experienced and taking legal action are appropriate. Feels good about self for taking the right action against her perpetrator.","",
      this.form.emotional_raw_score6 || "",
      ""
    ],
  
     // Social / Behavioral table data (Merged "Social / Behavioral" text with rowSpan)
  [
    { content: "Social / Behavioral", rowSpan: 2, styles: { valign: 'middle', halign: 'center' } }, 
    "Has no self-control as may be evident in any or all of the following:\n* Frequent involvement in fights (physical and verbal)\n* Inappropriate sexual behavior (e.g. frequent masturbation even in the presence of others)\n* Saying offensive words without caution\n* Vices","", 
    "Exercises self-control when he or she believes that it will bring him or her some reward or will make him or her appear good to others", "",
    "Exercises self-control in all cases as evident in the following:\n* Cautious in giving comments so that he or she may not hurt or offend others\n* Avoids involvement in fights\n* Avoids stealing\n* Avoids display of inappropriate sexual behavior", "",
    this.form.social_raw_score1, 
      { content: this.form.emotional_score_per_area1 || "", rowSpan: 2, styles: { valign: 'middle', halign: 'center', lineWidth: 0.2, lineColor: [0, 0, 0] } }  // Merge Score per Area across 3 rows
  
  ],
  [
    "Lacks sense of responsibility as evident in refusing to perform tasks / roles and constantly complaining even if tasks given are:\n* Appropriate to age, intellectual ability, physical strength\n* Not against his or her principles and religious belief", "",
    "Carries out responsibilities but requires supervision and close monitoring", "",
    "Performs responsibilities to the best of his or her ability even without prodding. He or she may at times express complaints but does so only when task given is not within his or her own capacity and not against religious beliefs and principles", "",
    this.form.social_raw_score2, 
    ""
  ],
  [
  { content: "", rowSpan: 6, styles: { valign: 'middle', halign: 'center' } }, 
  
    "Has no self-confidence which cause him or her to do most or all of the following:\n* Always refuses to participate in sports, socio-cultural, and skills training even if constantly encouraged\n* Constantly makes negative self-talk (e.g. I cannot do it, I am good for nothing, etc.)\n* Always dwells on what she or he cannot do rather than on what she or he can perform\n* Isolates self, most of the time", "",
    "Tries to participate in center's activities although with some degree of hesitation because of doubt that she or he will be able to perform as expected. Needs constant encouragement.", "",
    "Aware of limitations but still maintain healthy self-confidence as shown in his or her ability to do the following:\n* Assert\n* Avoid saying self-demeaning words\n* Active participation in center's activities", "",
    this.form.social_raw_score3, 
    { content: "" || "", rowSpan: 6, styles: { valign: 'middle', halign: 'center', lineWidth: 0.2, lineColor: [0, 0, 0] } }  // Merge Score per Area across 3 rows
  
  ],
  [
  
    "Disrespectful as evident in the following:\n* Defies center's rules and regulations\n* Does not want to perform tasks\n* Always answers back", "",
    "Is selective in showing respect", "",
    "Respects others at all times", "",
    this.form.social_raw_score4, 
    ""
  ],
  [
  
    "Can't decide for himself or herself either because of absence of appropriate decision-making skills", "",
    "Makes decisions but always needs the confirmation of others", "",
    "Decides for himself or herself but refers to others for assistance when appropriate", "",
    this.form.social_raw_score5, 
    ""
  ],
  [
    "Domineering and manipulative as can be gleaned from any or all of the following:\n* Attempts to lead others to violate center's rules and regulations\n* Imposes harsh decisions, distorted values, false beliefs, inappropriate practices, etc.\n* Intimates or threatens others to get things done", "",
    "Sometimes tends to dominate and manipulate others, but tries to control such tendency especially when attention is called", "",
   "Refrains from domineering or manipulating others as evident in the following:\n* Adheres to group decision\n* Refrains from imposing beliefs, values or practices to others\n* Refrains from threatening others to achieve or get what he or she wants", "",
    this.form.social_raw_score6, 
    ""
  ],
  [
    "Is always involved in stealing and shows no remorse", "",
    "Has the tendency to steal but shows remorse by returning stolen items and expressing the need to be restrained from committing such act", "",
    "Does not steal", "",
    this.form.social_raw_score7, 
    ""
  ],
  [
    "Always tells lies to damage or hurt others and to make self-appear superior over other people", "",
    "Has the tendency to lie in some occasions but avoids that may harm or damage others", "",
    "Strives to be honest at all times","", 
    this.form.social_raw_score8, 
    ""
  ],
  
  
      // Spiritual table data
      [
      "Spiritual", "Blames God for his or her crises or failures in life which results to lingering hopelessness and other negative emotions","", "Does not blame God for his or her crises and failures in life but doubts whether God cares for him or her at all", "","Recognizes that God cares for him or her and is ready to provide needed strength to cope with the crisis and failures in life","", this.form.spiritual_raw_score1, this.form.spiritual_score_per_area1],
  
      // Educational / Literacy table data
      ["Educational / Literacy", "Not able to read, write and count","", "Undertakes non-formal education or willingly receives tutorial services to learn basic", "","Able to read, write and count with comprehension appropriate to age and educational attainment","", this.form.educational_raw_score, this.form.educational_score_per_area],
  
      // Economic Productivity table data
      ["Economic Productivity", "No employable skills and has no interest to acquire any which could support his or her needs","", "Needs to brush up skills to make them usable for employment", "","Has employable skills", "",this.form.economic_raw_score, this.form.economic_score_per_area],
  
      [{ content: "GENERAL SCORE", styles: { fontStyle: 'bold', halign: 'left' } }, { content: this.form.general_score || "", colSpan: 7 }],
      [{ content: "INTERPRETATION", styles: { fontStyle: 'bold', halign: 'left' } }, { content: this.form.interpretation || "", colSpan: 7 }],
    ];
  
    // Render only the first page with headers, footers, and client info
    addHeaderFirstPage();
    addClientInfo();
    let isFirstPage = true;  // Initialize flag to track the first page
  
  doc.autoTable({
    head: [
      [
        { content: 'AREAS', rowSpan: 2, styles: { valign: 'middle', halign: 'center' } },  // Add top border back
        { content: 'Severely Impaired Functioning', styles: { valign: 'middle', halign: 'center', lineWidth: { top: 0.2, right: 0 }, lineColor: [0, 0, 0] } },  // Add top border back, remove right border
        { content: '', styles: { cellPadding: 0, lineWidth: { top: 0.2, left: 0, right: 0.2 }, lineColor: [0, 0, 0] } },  // Invisible column with top border
        { content: 'Moderately Impaired Functioning', styles: { valign: 'middle', halign: 'center', lineWidth: { top: 0.2, right: 0 }, lineColor: [0, 0, 0] } },  // Add top border back, remove right border
        { content: '', styles: { cellPadding: 0, lineWidth: { top: 0.2, left: 0, right: 0.2 }, lineColor: [0, 0, 0] } },  // Invisible column with top border
        { content: 'Normal Functioning', styles: { valign: 'middle', halign: 'center', lineWidth: { top: 0.2, right: 0 }, lineColor: [0, 0, 0] } },  // Add top border back, remove right border
        { content: '', styles: { cellPadding: 0, lineWidth: { top: 0.2, left: 0, right: 0.2 }, lineColor: [0, 0, 0] } },  // Invisible column with top border
        { content: 'Raw Score', rowSpan: 2, styles: { valign: 'middle', halign: 'center'} },  // Add top border back
        { content: 'Score per Area', rowSpan: 2, styles: { valign: 'middle', halign: 'center'} },  // Add top border back
      ],
      [
        { content: 'If check please input "1" in Column C.', styles: { valign: 'middle', halign: 'center', fontStyle: 'italic', lineWidth: { top: 0.2, right: 0 }, lineColor: [0, 0, 0] } },  // Add top border, remove right border
        { content: '', styles: { cellPadding: 0, lineWidth: { top: 0.2, left: 0, right: 0.2 }, lineColor: [0, 0, 0] } },  // Invisible column with top border
        { content: 'If check please input "2" in Column E.', styles: { valign: 'middle', halign: 'center', fontStyle: 'italic', lineWidth: { top: 0.2, right: 0 }, lineColor: [0, 0, 0] } },  // Add top border, remove right border
        { content: '', styles: { cellPadding: 0, lineWidth: { top: 0.2, left: 0, right: 0.2 }, lineColor: [0, 0, 0] } },  // Invisible column with top border
        { content: 'If check please input "3" in Column G.', styles: { valign: 'middle', halign: 'center', fontStyle: 'italic', lineWidth: { top: 0.2, right: 0 }, lineColor: [0, 0, 0] } },  // Add top border, remove right border
        { content: '', styles: { cellPadding: 0, lineWidth: { top: 0.2, left: 0, right: 0.2 }, lineColor: [0, 0, 0] } },  // Invisible column with top border
      ]
    
    ],
    body: tableData,  // Your dynamic data for the table
    startY: 75,  // Start position after headers and client info
  
    // Body styles
    styles: {
      font: 'arial',  // Use Arial font
      fontSize: 9.1,  // Set font size for body
      textColor: [0, 0, 0],  // Set text color to black
      lineWidth: 0.2,  // Set border width
      lineColor: [0, 0, 0],  // Set border color (black)
    },
  
    // Header-specific styles (for bold text)
    headStyles: {
      lineWidth: 0.2,  // Set border width
      fontSize: 12,  // Set font size for header
      font: 'arial',  // Use Arial for header
      textColor: [0, 0, 0],  // Pure black for header text
      fontStyle: 'bold',
      fillColor: null,  // Remove background color
      
    },
  
  
  
    columnStyles: {
      0: { cellWidth: 20 },  // 'Area' column width
      1: { cellWidth: 32 },  // 'Severely Impaired Functioning' column width
      2: { cellWidth: 8, },  // '''
      3: { cellWidth: 32 },  // 'Moderately Impaired Functioning' column width
      4: { cellWidth: 8 },  // ''
      5: { cellWidth: 32 },  // 'Normal Functioning' column width
      6: { cellWidth: 8 },  // ''
      7: { cellWidth: 20 },  // 'Raw Score' column width
      8: { cellWidth: 22 },  // 'Score per Area' column width
    },
  
    margin: { bottom: footerMargin },  // Leave space for footer
  
    willDrawCell: function (data) {
      // Check if it's a header cell and we're not on the first page
      if (data.row.section === 'head' && !isFirstPage) {
        // Skip rendering this cell entirely (removes header from subsequent pages)
        return false;  // Prevent drawing the cell and content
      }
    },
  
    
   // Hook to adjust margin for subsequent pages
   didDrawPage: function (data) {
      if (!isFirstPage) {
        // Adjust the start position of the table on subsequent pages
        data.cursor.y = 20;  // Move the table higher on the next pages
      }
      isFirstPage = false;  // Flag to indicate that we have passed the first page
    },
  
    // Initial margin for the first page
    margin: { top: -10, bottom: 35},
  
  });
  
  
      // Add the interpretation legend below the table
      doc.setFontSize(10);
    doc.setFont('Arial', 'normal');
    doc.text('1.50 = Severely Impaired', 15, doc.autoTable.previous.finalY + 115); // Position under table
    doc.text('1.51 to 2.50 = Moderately-impaired', 15, doc.autoTable.previous.finalY + 120);
    doc.text('2.51 to 3.0 = Normal', 15, doc.autoTable.previous.finalY + 125);
  
  
    // Add Prepared by and Discussed with section
    const addPreparedAndDiscussedSection = () => {
      const startY = doc.autoTable.previous ? doc.autoTable.previous.finalY + 140 : 100;  // Position 20mm below the last table or start from Y=100 if no table
  
      const maxWidth = 80;  // Maximum width for the text before wrapping
      const underlineOffset = 2;  // Offset from text to underline
  
      // Case Manager (Prepared by)
      const caseManager = this.case_manager || "";
      let caseManagerText = doc.splitTextToSize(caseManager, maxWidth);  // Split text to fit within maxWidth
      doc.text('Prepared by:', 15, startY);  // Label
      doc.text(caseManagerText, 15, startY + 12);  // Case manager's name (text may be wrapped)
      
      let caseManagerWidth = Math.min(doc.getTextWidth(caseManagerText[0]), maxWidth);  // Use the first line's width for the underline
      doc.line(15, startY + 11 + underlineOffset, 15 + caseManagerWidth, startY + 11 + underlineOffset);  // Underline based on text width
      
      // Label for Case Manager
      doc.setFontSize(10);
      doc.text('Case Manager', 15, startY + 20);
  
      // Client (Discussed with)
      const clientName = this.clientName || "Not Provided";
      let clientNameText = doc.splitTextToSize(clientName, maxWidth);  // Split text to fit within maxWidth
      doc.setFontSize(12);
      doc.text('Discussed with:', pageWidth / 2 + 15, startY);  // Label
      doc.text(clientNameText, pageWidth / 2 + 15, startY + 12);  // Client's name (text may be wrapped)
  
      let clientNameWidth = Math.min(doc.getTextWidth(clientNameText[0]), maxWidth);  // Use the first line's width for the underline
      doc.line(pageWidth / 2 + 15, startY + 11 + underlineOffset, pageWidth / 2 + 15 + clientNameWidth, startY + 11 + underlineOffset);  // Underline based on text width
      
      // Label for Client
      doc.setFontSize(10);
      doc.text('Client', pageWidth / 2 + 15, startY + 20);
    };
  
    // Call this function to add the "Prepared by" and "Discussed with" section after your table or content
    addPreparedAndDiscussedSection();
  
    let totalPages = doc.internal.getNumberOfPages();
  
  
    for (let i = 1; i <= totalPages; i++) {
      doc.setPage(i);
      if (i > 1) {
        addHeaderOtherPages();
      }
      if (i === 1) {
        addFooterFirstPage(i, totalPages);
      } else {
        addFooterOtherPages(i, totalPages);
      }
    }
  
    // Save the generated PDF
    doc.save('social_functioning_report.pdf');
  },
  
  
      handleAxiosError(error) {
        if (error.response) {
          console.error('Server Error:', error.response.data);
          this.message = `Error saving data: ${error.response.status} ${error.response.statusText}. ${error.response.data.message || ''}`;
        } else if (error.request) {
          console.error('No Response:', error.request);
          this.message = 'Error saving data: No response received from the server. Please check your network connection or try again later.';
        } else {
          console.error('Unexpected Error:', error.message);
          this.message = `Error saving data: ${error.message}`;
        }
  
        this.messageType = 'error';
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
  </style>