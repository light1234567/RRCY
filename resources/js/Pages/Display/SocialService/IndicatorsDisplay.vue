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
      <Pagination :totalPages="totalPages" :currentPage="currentPage" @update:currentPage="updatePage" />
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

  <div class="mt-10">
    <!-- Page 1 -->
    <div v-if="currentPage === 1" class="max-w-3xl mx-auto bg-white p-16 rounded-lg shadow-lg mb-10">
      <div class="relative flex justify-between items-center mb-2">
        <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
        <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
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
          <label class="block mr-16 text-base font-semibold text-gray-700 flex items-center h-full">Client Name:</label>
          <input type="text" class="mt-1 w-1/2 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" v-model="clientName" readonly />
        </div>
      </div>

      <div class="flex items-center mb-4">
        <div class="flex-grow flex items-center mr-4">
          <label class="block text-base font-semibold text-gray-700 mr-10 flex items-center h-full">Date Admission:</label>
          <input type="date" class="mt-1 w-1/2 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" v-model="form.dateAdmission" readonly />
        </div>
      </div>

      <div class="flex items-center mb-4">
        <div class="flex-grow flex items-center mr-4">
          <label class="block text-base font-semibold text-gray-700 mr-4 flex items-center h-full">Date Administered:</label>
          <input type="date" class="mt-1 w-1/2 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" v-model="form.date_administered" :readonly="!editMode" />
        </div>
      </div>
            <!-- The rest of your table goes here -->
            <table class="min-w-full  bg-white">
                <thead>
                    <tr >
                        <th class="py-2 px-4 border border-black">
                            AREAS
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Severely-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Moderately-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Normal Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Raw Score
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Score per Area
                        </th>
                    </tr>
                </thead>
                <tbody class="border border-black">
                    <!-- Physical rows here -->

                    <tr>
              <td class="py-2 px-4 border border-black" rowspan="2">Physical</td>
              <td class="py-2 px-4 border border-black">Has very poor hygiene and grooming</td>
              <td class="py-2 px-4 border border-black">Practices adequate self-care habits but still needs monitoring and supervision to maintain such</td>
              <td class="py-2 px-4 border border-black">Practices adequate self-care habits even without monitoring and supervision</td>
              <td class="py-2 px-4 border border-black">
                <input type="number" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.physical_raw_score1" :readonly="!editMode" @input="validateRawScore('physical_raw_score1')">
              </td>
              <td class="py-2 px-4 border border-black" rowspan="2">
                <input type="text" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.physical_score_per_area1" readonly>
              </td>
            </tr> 
            <td class="py-2 px-4 border border-black">Is completely dependent to others due to absence of appropriate skills to manage physical disability</td>
              <td class="py-2 px-4 border border-black">With very limited skills to manage physical disability which causes him or her to unnecessarily require assistance from others at times</td>
              <td class="py-2 px-4 border border-black">Has appropriate skills to function within capacity</td>
              <td class="py-2 px-4 border border-black">
                <input type="number" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.physical_raw_score2" :readonly="!editMode" @input="validateRawScore('physical_raw_score2')">
              </td>

              </tbody>
              </table>
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

                    <!-- Emotional rows here / Page 2-->
                 <div  v-if="currentPage === 2" class="max-w-3xl mx-auto bg-white p-16 rounded-lg shadow-lg mb-10">
                    <table>
                      <thead>
                    <tr>
                        <th class="py-2 px-4 border border-black">
                            AREAS
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Severely-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Moderately-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Normal Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Raw Score
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Score per Area
                        </th>
                    </tr>
                </thead>
                      <tbody>
                    <tr>
              <td class="py-2 px-4 border border-black" rowspan="6">Emotional</td>
              <td class="py-2 px-4 border border-black">Is often times sad / lonely which results to his or her lack of interest in anything despite encourage from others.</td>
              <td class="py-2 px-4 border border-black">Experiences sadness / loneliness which he or she allows to interfere in the performance of daily tasks and dealings with others.</td>
              <td class="py-2 px-4 border border-black">Copes well with sadness or loneliness as he or she does not let such emotion interfere both in daily tasks and social relationship.</td>
              <td class="py-2 px-4 border border-black">
                <input type="number" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.emotional_raw_score1" :readonly="!editMode" @input="validateRawScore('emotional_raw_score1')">
              </td>
              <td class="py-2 px-4 border border-black" rowspan="6">
                <input type="text" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.emotional_score_per_area1" readonly>
              </td>
            </tr> 
            <td class="py-2 px-4 border border-black">Feels hopeless most of the time which is manifested through the following:
              <li>suicidal events</li>
        <li>absence of any interest in the center's activities</li>
        <li>self-isolation</li>
        <li>lack of desire to improve self / does not believe that his or her situation will improve at all.</li>
</td>
              <td class="py-2 px-4 border border-black">Feels hopeless at times and allows such emotion to negatively affect performance of tasks and social relationship. However, he or she shows no suicidal tendency</td>
              <td class="py-2 px-4 border border-black">Is generally optimistic despite difficult situations which enable him or her to perform tasks or roles</td>
              <td class="py-2 px-4 border border-black">
                <input type="number" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.emotional_raw_score2" :readonly="!editMode" @input="validateRawScore('emotional_raw_score2')">
              </td>
              <tr>
              
              <td class="py-2 px-4 border border-black">Oftentimes experiences extreme / severe fear because of traumatic event/s in life which results to social and functional impairment like withdrawal, fighting back, and unnecessary cautiousness</td>
              <td class="py-2 px-4 border border-black">Sometimes experiences fear as a result of traumatic event. With constant encouragement; however, he or she tries not to allow such to affect dealings with others and performance of tasks</td>
              <td class="py-2 px-4 border border-black">Copes well with traumatic events as evident by his or her social and functional adjustment even with very minimal requirement for support from others</td>
              <td class="py-2 px-4 border border-black">
                <input type="number" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.emotional_raw_score3" :readonly="!editMode" @input="validateRawScore('emotional_raw_score3')">
              </td>
            </tr> 
            
                </tbody>
                
            </table>
            <div class="border-gray-300 ml-6 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
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
        
      </div>


        <!--page 3-->
        <div v-if="currentPage === 3" class="max-w-3xl mx-auto bg-white p-16 rounded-lg shadow-lg mb-10">
              <table>
                <thead>
                    <tr>
                        <th class="py-2 px-4 border border-black">
                            AREAS
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Severely-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Moderately-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Normal Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Raw Score
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Score per Area
                        </th>
                    </tr>
                </thead>
              <tbody>
              <tr>
                <td class="py-2 px-4 border border-black" rowspan="6">Emotional</td>
              <td class="py-2 px-4 border border-black">Harbors ill feelings which renders him or her unable to build good relationship with others and to focus on tasks at hand as indicated by any or all of the following:
                <li>dwells most of the time on planning revenge</li>
                <li>not open to reconciliation or forgiveness</li>
                <li>aggressive</li>
                <li>relationship with others is superficial</li>
                <li>displaces anger to others</li>
              </td>
              <td class="py-2 px-4 border border-black">Is trying to overcome ill feelings (e.g. hatred, resentment and anger) as may be evident by any or all of the following expressions: 
                <li>that revenge may only worsen the situation</li>
                <li>that reconciliation may be possible in the future</li>
                <li>that he or she may consider forgiving the individual(s) who has/have done wrong to him or her</li>
              </td>
              <td class="py-2 px-4 border border-black">Has decided to let go of ill-feelings as may be evident in any or all of the following:
                <li>has forgiven others</li>
                <li>is ready to ask forgiveness for those whom he may have done wrong</li>
                <li>believes that there are people who are genuinely interested in his or her welfare</li>
              </td>
              <td class="py-2 px-4 border border-black">
                <input type="number" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.emotional_raw_score4" :readonly="!editMode" @input="validateRawScore('emotional_raw_score4')">
              </td>
              <td class="py-2 px-4 border border-black" rowspan="6">
                
              </td>
            </tr> 

            <tr>
              
              <td class="py-2 px-4 border border-black">Is severely guilty for grave offense committed which make him or her feel unworthy and incapable of doing good</td>
              <td class="py-2 px-4 border border-black">Feels guilty for grave offense committed which make him or her at times doubt capacity to be a good person</td>
              <td class="py-2 px-4 border border-black">Because of feelings of guilt for an offense committed, he or she strives to change negative attitudes that cause damage to others</td>
              <td class="py-2 px-4 border border-black">
                <input type="number" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.emotional_raw_score5" :readonly="!editMode" @input="validateRawScore('emotional_raw_score5')">
              </td>
              
            </tr> 

            <tr>
              
              <td class="py-2 px-4 border border-black">Is severely guilty because of the incarceration of her abuser which, she is made to believe, resulted to the difficulties being faced by the family. Such emotion cripples her daily interaction with others</td>
              <td class="py-2 px-4 border border-black">Sometimes think that she is to blame because of family disintegration due to the case she filed against her perpetrator</td>
              <td class="py-2 px-4 border border-black">Believes that revealing the truth about the abuse she experienced and taking legal action are appropriate. Feels good about self for taking the right action against her perpetrator.</td>
              <td class="py-2 px-4 border border-black">
                <input type="number" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.emotional_raw_score6" :readonly="!editMode" @input="validateRawScore('emotional_raw_score6')">
              </td>
            </tr> 
            
          </tbody>
          </table>
          <div class="border-gray-300 ml-6 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
         <div class="flex justify-between items-center">
           <div class="flex flex-col">
             <p class="ml-24 -mb-4 font-bold">PAGE 3 of {{ totalPages }}</p>
             <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
             <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
           </div>
           <div class="ml-4">
             <img src="/images/footerimg.png" alt="" class="h-12 w-24 object-cover rounded-md">
           </div>
         </div>
       </div>
            
        </div>
        
  
        <!-- Page 4 -->
        <div v-if="currentPage === 4" class="max-w-3xl mx-auto bg-white p-16 rounded-lg shadow-lg mb-10">
            <table >
                <thead>
                    <tr>
                        <th class="py-2 px-4 border border-black">
                            AREAS
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Severely-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Moderately-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Normal Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Raw Score
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Score per Area
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Social / Behavioral rows here -->
                    <tr>
              <td class="py-2 px-4 border border-black" rowspan="8">Social / Behavioral</td>
              <td class="py-2 px-4 border border-black">Has no self-control as maybe evident in any or all of the following:
                <li>frequent involvement in fights (physical and verbal)</li>
                <li>inappropriate sexual behavior (e.g. frequent masturbation even in the presence of others)</li>
                <li>saying offensive words without caution</li>
                <li>vices</li>
              </td>
              <td class="py-2 px-4 border border-black">Exercises self-control when he or she believes that it will bring him or her some reward or will make him or her appear good to others</td>
              <td class="py-2 px-4 border border-black">Exercises self-control in all cases as evident in the following:
                <li>cautious in giving comments so that he or she may not hurt or offend others</li>
                <li>avoids involvement in fights</li>
                <li>avoids stealing</li>
                <li>avoids display of inappropriate sexual behavior</li>
              </td>
              <td class="py-2 px-4 border border-black">
                <input type="number" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.social_raw_score1" :readonly="!editMode" @input="validateRawScore('social_raw_score1')">
              </td>
              <td class="py-2 px-4 border border-black" rowspan="6">
                <input type="text" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.social_score_per_area1" readonly>
              </td>
            </tr> 
            <td class="py-2 px-4 border border-black">Lacks sense of responsibility as evident in refusing to perform tasks / roles and constantly complaining even if tasks given are:
              <li>appropriate to age, intellectual ability, physical strength</li>
              <li>not against his or her principles and religious belief</li>
              </td>
              <td class="py-2 px-4 border border-black">Carries out responsibilities but requires supervision and close monitoring</td>
              <td class="py-2 px-4 border border-black">Performs responsibilities to the best of his or her ability even without prodding. He or she may at times express complaints but does so only when task given is not within his or her own capacity and not against religious beliefs and principles</td>
              <td class="py-2 px-4 border border-black">
                <input type="number" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.social_raw_score2" :readonly="!editMode" @input="validateRawScore('social_raw_score2')">
              </td>    
          </tbody>
        </table>
  
        <div class="border-gray-300 ml-6 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
         <div class="flex justify-between items-center">
           <div class="flex flex-col">
             <p class="ml-24 -mb-4 font-bold">PAGE 4 of {{ totalPages }}</p>
             <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
             <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
           </div>
           <div class="ml-4">
             <img src="/images/footerimg.png" alt="" class="h-12 w-24 object-cover rounded-md">
           </div>
         </div>
       </div>
      </div>


      <!--Page 5 -->
<div v-if="currentPage === 5" class="max-w-3xl mx-auto bg-white p-16 rounded-lg shadow-lg mb-10" >
      <table>
        <thead>
                    <tr>
                        <th class="py-2 px-4 border border-black">
                            AREAS
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Severely-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Moderately-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Normal Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Raw Score
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Score per Area
                        </th>
                    </tr>
                </thead>
        <tbody>
          <tr>
            <td class="py-2 px-4 border border-black" rowspan="8">Social / Behavioral</td>
              <td class="py-2 px-4 border border-black">Has no self-confidence which cause him or her to do most or all of the following:
                <li>always refuses to participate in sports, socio-cultural, and skills training even if constantly encouraged</li>
                <li>constantly makes negative self-talk (e.g. I cannot do it, I am good for nothing, etc.)</li>
                <li>always dwells on what she or he cannot do rather than on what she or he can perform</li>
                <li>isolates self, most of the time</li>
              </td>
              <td class="py-2 px-4 border border-black">Tries to participate in center's activities although with some degree of hesitation because of doubt that she or he will be able to perform as expected. Needs constant encouragement.</td>
              <td class="py-2 px-4 border border-black">Aware of limitations but still maintain healthy self-confidence as shown in his or her ability to do the following:
                <li>assert</li>
                <li>avoid saying self-demeaning words</li>
                <li>active participation in center's activities</li>
              </td>
              <td class="py-2 px-4 border border-black">
                <input type="number" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.social_raw_score3" :readonly="!editMode" @input="validateRawScore('social_raw_score3')">
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

              <td class="py-2 px-4 border border-black">Is selective in showing respect</td>
              <td class="py-2 px-4 border border-black">Respects others at all times</td>
              
              <td class="py-2 px-4 border border-black">
                <input type="number" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.social_raw_score4" :readonly="!editMode" @input="validateRawScore('social_raw_score4')">
              </td>
              
            </tr> 

            <tr>
              
              <td class="py-2 px-4 border border-black">Can't decide for himself or herself either because of absence of appropriate decision-making skills</td>
              <td class="py-2 px-4 border border-black">Makes decisions but always needs the confirmation of others</td>
              <td class="py-2 px-4 border border-black">Decides for himself or herself but refers to others for assistance when appropriate</td>
              <td class="py-2 px-4 border border-black">
                <input type="number" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.social_raw_score5" :readonly="!editMode" @input="validateRawScore('social_raw_score5')">
              </td>
            </tr> 
        </tbody>
      </table>
      <div class="border-gray-300 ml-6 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
         <div class="flex justify-between items-center">
           <div class="flex flex-col">
             <p class="ml-24 -mb-4 font-bold">PAGE 5 of {{ totalPages }}</p>
             <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
             <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
           </div>
           <div class="ml-4">
             <img src="/images/footerimg.png" alt="" class="h-12 w-24 object-cover rounded-md">
           </div>
         </div>
       </div>
    </div>
    
        <!-- Page 6 -->
        <div v-if="currentPage === 6" class="max-w-3xl mx-auto bg-white p-16 rounded-lg shadow-lg mb-10">
            <table>
                <thead>
                    <tr>
                        <th class="py-2 px-4 border border-black">
                            AREAS
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Severely-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Moderately-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Normal Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Raw Score
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Score per Area
                        </th>
                    </tr>
                </thead>
                <tr>
                  <td class="py-2 px-4 border border-black" rowspan="6">Social/Behavioral</td>
              <td class="py-2 px-4 border border-black">Domineering and manipulative as can be gleaned from any or all of the following:
                <li>attempts to lead others to violate center's rules and regulations</li>
                <li>imposes harsh decisions, distorted values, false beliefs, inappropriate practices, etc.</li>
                <li>intimates or threatens others to get things done</li>
              </td>
              <td class="py-2 px-4 border border-black">Sometimes tends to dominate and manipulate others, but tries to control such tendency especially when attention is called</td>
              <td class="py-2 px-4 border border-black">Refrains from domineering or manipulating others as evident in the following:
                <li>adheres to group decision</li>
                <li>refrains from imposing beliefs, values or practices to others</li>
                <li>refrains from threatening others to achieve or get what he or she wants</li>
              </td>

              <td class="py-2 px-4 border border-black">
                <input type="number" class="w-full mt-1 p-2 border border-black  rounded-md" v-model="form.social_raw_score6" :readonly="!editMode" @input="validateRawScore('social_raw_score6')">
              </td>
              <td class="py-2 px-4 border border-black" rowspan="8">
                
              </td>
            </tr> 

            <tr>
              
              <td class="py-2 px-4 border border-black">Is always involved in stealing and shows no remorse</td>
              <td class="py-2 px-4 border border-black">Has the tendency to steal but shows remorse by returning stolen items and expressing the need to be restrained from committing such act</td>
              <td class="py-2 px-4 border border-black">Does not steal</td>
              <td class="py-2 px-4 border border-black">
                <input type="number" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.social_raw_score7" :readonly="!editMode" @input="validateRawScore('social_raw_score7')">
              </td>
             
            </tr> 

            <tr>
              
              <td class="py-2 px-4 border border-black">Always tells lies to damage or hurt others and to make self-appear superior over other people</td>
              <td class="py-2 px-4 border border-black">Has the tendency to lie in some occasions but avoids that may harm or damage others</td>
              <td class="py-2 px-4 border border-black">Strives to be honest at all times</td>
              <td class="py-2 px-4 border border-black">
                <input type="number" class="w-full mt-1 p-2 border border-black  rounded-md" v-model="form.social_raw_score8" :readonly="!editMode" @input="validateRawScore('social_raw_score8')">
              </td>
             
            </tr> 
                <tbody>
                  
                  <tr>
                    
              <td class="py-2 px-4 border border-black" rowspan="6">Spiritual</td>
              <td class="py-2 px-4 border border-black">Has low self-confidence which causes him or her to find meaning only in negative thoughts; always makes self-deprecating comments and statements which devalue his/her own worth</td>
              <td class="py-2 px-4 border border-black">Sometimes tends to be overly critical of self but manages to overcome feelings of inadequacy and finds meaning in life through other positive activities</td>
              <td class="py-2 px-4 border border-black">Recognizes and accepts his/her limitations but strives to improve self and find meaning in life through positive self-affirmation and involvement in community/ religious activities</td>
              <td class="py-2 px-4 border border-black">
                <input type="number" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.spiritual_raw_score1" :readonly="!editMode" @input="validateRawScore('spiritual_raw_score1')">
              </td>
              <td class="py-2 px-4 border border-black">
                <input type="text" class="w-full mt-1 p-2 border border-black rounded-md" v-model="form.spiritual_score_per_area1" readonly>
              </td>
              
            </tr>

                    <!-- Add additional rows as necessary -->
                </tbody>
            </table>

            <div class="border-gray-300 ml-6 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
         <div class="flex justify-between items-center">
           <div class="flex flex-col">
             <p class="ml-24 -mb-4 font-bold">PAGE 6 of {{ totalPages }}</p>
             <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
             <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
           </div>
           <div class="ml-4">
             <img src="/images/footerimg.png" alt="" class="h-12 w-24 object-cover rounded-md">
           </div>
         </div>
       </div>
        </div>

        <!-- Page 7 -->
        <div v-if="currentPage === 7" class="max-w-3xl mx-auto bg-white p-16 rounded-lg shadow-lg">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border border-black">
                            AREAS
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Severely-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Moderately-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Normal Functioning
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Raw Score
                        </th>
                        <th class="py-2 px-4 border border-black">
                            Score per Area
                        </th>
                    </tr>
                </thead>
                <tbody>
                  <tr>
    <td class="py-2 px-4 border border-black">
        Educational / Literacy
    </td>
    <td class="py-2 px-4 border border-black">
        Not able to read, write and count
    </td>
    <td class="py-2 px-4 border border-black">
        Undertakes non-formal education or willingly
        receives tutorial services to learn basic skills
    </td>
    <td class="py-2 px-4 border border-black">
        Able to read, write and count with skills
        appropriate to age and educational attainment
    </td>
    <td class="py-2 px-4 border border-black">
        <input
            type="number"
            min="0"
            max="100"
            class="w-full mt-1 p-2 border border-black rounded-md"
            v-model="form.educational_raw_score"
            :readonly="!editMode"
            @input="validateRawScore('educational_raw_score')"
        />
    </td>
    <td class="py-2 px-4 border border-black">
        <input
            type="text"
            class="w-full mt-1 p-2 border border-black  rounded-md"
            v-model="form.educational_score_per_area"
            readonly
        />
    </td>
</tr>
<tr>
    <td class="py-2 px-4 border border-black">
        Economic Productivity
    </td>
    <td class="py-2 px-4 border border-black">
        No employable skills and has no interest in learning
        any skills that would help him/her support his/her
        needs
    </td>
    <td class="py-2 px-4 border border-black">
        Needs to brush up skills to make them usable for
        employment
    </td>
    <td class="py-2 px-4 border border-black">
        Has employable skills
    </td>
    <td class="py-2 px-4 border border-black">
        <input
            type="number"
            min="0"
            max="100"
            class="w-full mt-1 p-2 border border-black  rounded-md"
            v-model="form.economic_raw_score"
            :readonly="!editMode"
            @input="validateRawScore('economic_raw_score')"
        />
    </td>
    <td class="py-2 px-4 border border-black">
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
                  <input type="text" class="w-full border-0 p-2 focus:ring-0 text-xs" v-model="form.interpretation" :readonly="!editMode">
                </td>
              </tr>
            </table>

        
  
            <div class="flex justify-between mt-10">
              <div class="flex flex-col items-start w-1/2 pr-4">
                <label class="block text-gray-700">Prepared by:</label>
                <input 
                  type="text" 
                  class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" 
                  v-model="form.prepared_by" 
                  :readonly="!editMode"
                >
                <span class="text-xs text-gray-700 mt-1">Case Manager</span>
              </div>

              <div class="flex flex-col items-start w-1/2 pl-4">
                <label class="block text-gray-700">Discussed with:</label>
                <input 
                  type="text" 
                  class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" 
                  v-model="form.discussed_with" 
                  :readonly="!editMode"
                >
                <span class="text-xs text-gray-700 mt-1">Client</span>
              </div>
            </div>
  
        <div class="border-gray-300 ml-6 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
         <div class="flex justify-between items-center">
           <div class="flex flex-col">
             <p class="ml-24 -mb-4 font-bold">PAGE 7 of {{ totalPages }}</p>
             <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
             <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
           </div>
           <div class="ml-4">
             <img src="/images/footerimg.png" alt="" class="h-12 w-24 object-cover rounded-md">
           </div>
         </div>
       </div>
      </div>


</template>



<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import {  watch } from 'vue';
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
      prepared_by: '',
      discussed_with: ''
    });

    const clientName = ref('');
    const errorMessage = ref('');
    const isModalOpen = ref(false);
    const isSaveResultModalOpen = ref(false);
    const saveResultTitle = ref('');
    const saveResultMessage = ref('');
    const totalPages = ref(7);
    const currentPage = ref(1);

    const fetchData = async (client_id) => {
  try {
    const clientResponse = await axios.get(`/api/clients/${client_id}`);
    const clientData = clientResponse.data;

    const admissionResponse = await axios.get(`/api/admissions/client/${clientData.id}`);
    const admissionData = admissionResponse.data;

    const indicatorResponse = await axios.get(`/api/indicators-of-social-functioning/check/${clientData.id}/${admissionData.id}`);
    const indicatorData = indicatorResponse.data;

    if (!indicatorData) {
      // No indicator found for this client and admission, handle accordingly
      message.value = 'No indicator data found for this client.';
      messageType.value = 'error';
      return;
    }

    clientName.value = `${clientData.first_name} ${clientData.middle_name ? clientData.middle_name + ' ' : ''}${clientData.last_name}`;
    form.value.client_id = clientData.id;
    form.value.admission_id = admissionData.id;
    form.value.dateAdmission = admissionData.date_admitted;
    form.value.date_administered = indicatorData.date_administered || admissionData.date_administered;

    form.value.physical_raw_score1 = indicatorData.physical_raw_score1 || '';
    form.value.physical_score_per_area1 = indicatorData.physical_score_per_area1 || '';
    form.value.physical_raw_score2 = indicatorData.physical_raw_score2 || '';

    form.value.emotional_raw_score1 = indicatorData.emotional_raw_score1 || '';
    form.value.emotional_score_per_area1 = indicatorData.emotional_score_per_area1 || '';
    form.value.emotional_raw_score2 = indicatorData.emotional_raw_score2 || '';
    form.value.emotional_raw_score3 = indicatorData.emotional_raw_score3 || '';
    form.value.emotional_raw_score4 = indicatorData.emotional_raw_score4 || '';
    form.value.emotional_raw_score5 = indicatorData.emotional_raw_score5 || '';
    form.value.emotional_raw_score6 = indicatorData.emotional_raw_score6 || '';

    form.value.social_raw_score1 = indicatorData.social_raw_score1 || '';
    form.value.social_score_per_area1 = indicatorData.social_score_per_area1 || '';
    form.value.social_raw_score2 = indicatorData.social_raw_score2 || '';
    form.value.social_raw_score3 = indicatorData.social_raw_score3 || '';
    form.value.social_raw_score4 = indicatorData.social_raw_score4 || '';
    form.value.social_raw_score5 = indicatorData.social_raw_score5 || '';
    form.value.social_raw_score6 = indicatorData.social_raw_score6 || '';
    form.value.social_raw_score7 = indicatorData.social_raw_score7 || '';
    form.value.social_raw_score8 = indicatorData.social_raw_score8 || '';

    form.value.spiritual_raw_score1 = indicatorData.spiritual_raw_score1 || '';
    form.value.spiritual_score_per_area1 = indicatorData.spiritual_score_per_area1 || '';

    form.value.educational_raw_score = indicatorData.educational_raw_score || '';
    form.value.educational_score_per_area = indicatorData.educational_score_per_area || '';

    form.value.economic_raw_score = indicatorData.economic_raw_score || '';
    form.value.economic_score_per_area = indicatorData.economic_score_per_area || '';

    form.value.general_score = indicatorData.general_score || '';
    form.value.interpretation = indicatorData.interpretation || '';

    form.value.prepared_by = indicatorData.prepared_by || '';
    form.value.discussed_with = indicatorData.discussed_with || '';

    errorMessage.value = '';

  } catch (error) {
    handleAxiosError(error);
  }
};



    const toggleEdit = () => {
      if (editMode.value) {
        saveData();
      }
      editMode.value = !editMode.value;
    };

    const validateRawScore = (field) => {
    if (form.value[field] < 0) {
        form.value[field] = 0;
    } else if (form.value[field] > 100) {
        form.value[field] = 100;
    }
    // Convert to integer explicitly
    form.value[field] = parseInt(form.value[field], 10) || 0;
    calculateScores();
};

const calculateScores = () => {
      // Calculate physical score per area
      form.value.physical_score_per_area1 = 
        form.value.physical_raw_score1 && form.value.physical_raw_score2 
        ? (parseFloat(form.value.physical_raw_score1) + parseFloat(form.value.physical_raw_score2)) / 2 
        : '';

      // Calculate emotional score per area
      form.value.emotional_score_per_area1 = [
        form.value.emotional_raw_score1,
        form.value.emotional_raw_score2,
        form.value.emotional_raw_score3,
        form.value.emotional_raw_score4,
        form.value.emotional_raw_score5,
        form.value.emotional_raw_score6,
      ].reduce((sum, score) => sum + (parseFloat(score) || 0), 0) / 6 || '';

      // Calculate social score per area
      form.value.social_score_per_area1 = [
        form.value.social_raw_score1,
        form.value.social_raw_score2,
        form.value.social_raw_score3,
        form.value.social_raw_score4,
        form.value.social_raw_score5,
        form.value.social_raw_score6,
        form.value.social_raw_score7,
        form.value.social_raw_score8,
      ].reduce((sum, score) => sum + (parseFloat(score) || 0), 0) / 8 || '';

      // Calculate spiritual score per area
      form.value.spiritual_score_per_area1 = form.value.spiritual_raw_score1 
        ? parseFloat(form.value.spiritual_raw_score1) 
        : '';

      // Calculate educational score per area
      form.value.educational_score_per_area = form.value.educational_raw_score 
        ? parseFloat(form.value.educational_raw_score) 
        : '';

      // Calculate economic score per area
      form.value.economic_score_per_area = form.value.economic_raw_score 
        ? parseFloat(form.value.economic_raw_score) 
        : '';

      // Calculate the general score
      const scores = [
        form.value.physical_score_per_area1,
        form.value.emotional_score_per_area1,
        form.value.social_score_per_area1,
        form.value.spiritual_score_per_area1,
        form.value.educational_score_per_area,
        form.value.economic_score_per_area,
      ].filter(score => score !== '');
      
      form.value.general_score = scores.length > 0 
        ? (scores.reduce((sum, score) => sum + parseFloat(score), 0) / scores.length).toFixed(2) 
        : '';
    };

    // Watch for changes in any of the raw scores to trigger recalculation
    watch(
      () => [
        form.value.physical_raw_score1,
        form.value.physical_raw_score2,
        form.value.emotional_raw_score1,
        form.value.emotional_raw_score2,
        form.value.emotional_raw_score3,
        form.value.emotional_raw_score4,
        form.value.emotional_raw_score5,
        form.value.emotional_raw_score6,
        form.value.social_raw_score1,
        form.value.social_raw_score2,
        form.value.social_raw_score3,
        form.value.social_raw_score4,
        form.value.social_raw_score5,
        form.value.social_raw_score6,
        form.value.social_raw_score7,
        form.value.social_raw_score8,
        form.value.spiritual_raw_score1,
        form.value.educational_raw_score,
        form.value.economic_raw_score,
      ],
      calculateScores
    );





const saveData = async () => {
    if (!form.value.client_id || !form.value.admission_id) {
        message.value = 'Client or Admission ID is missing.';
        messageType.value = 'error';
        return;
    }

   
    try {
        const response = await axios({
          method: form.value.id ? 'put' : 'post',
          url: `/api/data-privacy-consent${form.value.id ? '/' + form.value.id : ''}`,
          data: form.value,
        });
        saveResultTitle.value = 'Success';
        saveResultMessage.value = 'Data saved successfully!';
        if (!form.value.id) {
          form.value.id = response.data.id;
        }
        editMode.value = false;
      } catch (error) {
        saveResultTitle.value = 'Error';
        saveResultMessage.value = 'Error saving data.';
        console.error('Error saving data:', error);
      } finally {
        closeModal();
        isSaveResultModalOpen.value = true;
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
    };

    const closeSaveResultModal = () => {
      isSaveResultModalOpen.value = false;
      saveResultTitle.value = '';
      saveResultMessage.value = '';
    };

    const cancelEdit = () => {
      editMode.value = false;
    };

    const updatePage = (page) => {
      currentPage.value = page;
    };




    const handleAxiosError = (error) => {
      if (error.response) {
        console.error('Server Error:', error.response.data);
        message.value = `Error saving data: ${error.response.status} ${error.response.statusText}. ${error.response.data.message || ''}`;
      } else if (error.request) {
        console.error('No Response:', error.request);
        message.value = 'Error saving data: No response received from the server. Please check your network connection or try again later.';
      } else {
        console.error('Unexpected Error:', error.message);
        message.value = `Error saving data: ${error.message}`;
      }

      messageType.value = 'error';
    };

    onMounted(() => {
  const id = route.params.id; // Assuming id is the indicators_id
  if (id) {
    fetchData(id);
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
      isSaveResultModalOpen,
      saveResultTitle,
      saveResultMessage,
      closeSaveResultModal,
      cancelEdit,
      totalPages,
      currentPage,
      updatePage,
      validateRawScore,
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
</style>