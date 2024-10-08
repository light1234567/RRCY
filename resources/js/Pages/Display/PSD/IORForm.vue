<template>
  <!-- Tabs for Actions (Back button visible only in edit mode) -->
  <div v-if="editMode" class="flex absolute p-4 space-x-4">
    <button @click="cancelEdit" class="flex space-x-2 px-3 py-3 bg-[conic-gradient(at_bottom_right,_var(--tw-gradient-stops))] from-blue-700 via-blue-800 to-gray-900 text-white rounded-md text-xs">
      <!-- FontAwesome for Back -->
      <i class="fas fa-arrow-left w-4 h-4"></i>
      <span>Back</span>
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
    <button v-else @click="submitForm" type="button" class="px-4 py-2 bg-green-500 text-white rounded">Save</button>
  
    <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 text-white rounded-md text-xs">
        <!-- FontAwesome for PDF Download -->
        <i class="fas fa-file-pdf w-4 h-4"></i>
        <span>Export PDF</span>
      </button>
  
  </div>
  
  
      <!-- Success/Error Message -->
      <div v-if="message" :class="`mt-4 p-4 rounded text-white ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">{{ message }}</div>
      <div class="graph-background pt-0.5  -mr-9 -mb-16">
  
  
  
    <div v-if="currentPage === 1" class="max-w-3xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
      <!-- Header -->
      <div class="relative flex justify-between items-center mb-4">
        <img src="/images/headerlogo2.png" alt="Logo" class=" h-32 w-64 relative z-10">
        <div class="-ml-8 text-center">
          <p class="item-center mr-6 text-sm font-semibold">PROTECTIVE SERVICES DIVISION</p>
          <p class="text-sm font-semibold">Regional Rehabilitation Center for Youth RFO XI</p>
          <p class="text-sm font-bold">DSWD-GF-010 | REV 02 | 22 SEP 2023</p>
        </div>
      </div>
      <div class="border border-black-100">
      <div class="text-center mb-4 border-b-2 border-gray-300 pb-2">
        <h1 class="text-base font-bold">INDIVIDUAL PERFORMANCE OBSERVATION REPORT</h1>
      </div>
  
      <div class="flex -mt-4 bg-sky-400 items-center justify-center mb-6 bg-gray-300">
        <p class="text-md text-sm font-bold mr-4">For the Period:</p>
        <input type="text" v-model="form.period" class="underline-input2 bg-transparent border-b-2 border-gray-300 text-center text-xs" />
      </div>
  
      <!-- Success/Error Message -->
      <div v-if="message" :class="`mt-4 p-4 rounded text-white ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
        {{ message }}
      </div>
        
      <!-- General Information -->
      <div class="mb-6 -mt-4 grid grid-cols-2 gap-4">
        <div class="flex items-center justify-start mb-6">
      <label class="block text-xs font-bold mb-1">Name of Resident:</label>
      <input type="text" v-model="form.name" class="underline-input2 ml-4 text-xs w-1/2 p-2 border border-gray-300 " :readonly="!editMode" />
  </div>
  
        <div class="flex items-center justify-start ml-12 mb-6">
      <label class="block text-xs font-bold mr-2">Date of Assessment:</label>
      <input
          type="date"
          v-model="form.assessment_date"
          class="underline-input2 text-xs p-2 border border-gray-300 w-1/2"
          :readonly="!editMode" />
  </div>
  
      </div>
      <div class="flex -mt-8 items-start mb-6">
      <label class="block text-xs font-bold mb-1">Trainings Attended for the Month:</label>
      <input type="text" v-model="form.trainings_attended" class="underline-input2 text-xs w-full border border-gray-300" :readonly="!editMode" />
  </div>
  
  <!-- Scale of Measurement Section -->
   
   
  <h4 class="text-center mb-4 border-b-2 text-sm bg-sky-400 pb-2 font-bold mb-2 ">SCALE OF MEASUREMENT</h4>
        <div class="grid grid-cols-2 gap-4 text-xs">
          <div class="ml-4 font-bold flex justify-between ">
            <span>4 - PIRMI GINABUHAT <em>(ALWAYS)</em></span>
          </div>
          <div class="ml-8 font-bold flex justify-between">
            <span>2 - KUNG GANAHAN LANG GINABUHAT <em>(SELDOM)</em></span>
          </div>
          <div class="ml-4 font-bold flex justify-between">
            <span>3 - USAHAY RA GINABUHAT <em>(SOMETIMES)</em></span>
          </div>
          <div class="ml-8 font-bold flex justify-between">
            <span>1 - WALA JUD GIBUHAT <em>(NEVER)</em></span>
          </div>
        </div>
        
      <!-- Sections for Indicators and Remarks -->
  <div class="mb-6">
    <table class="w-full border-collapse border mb-4 text-xs">
      <thead>
          <tr class="bg-white">
              <th class="text-center p-1 border">INDICATORS</th>
              <th class="text-center bg-green-400 p-1 border">Self-Rating</th>
              <th class="text-center bg-green-400 p-1 border">MDO's Rating</th>
              <th class="text-center bg-green-400 p-1 border">TOTAL RATING</th>
              <th class="text-center p-1 border">REMARKS</th>
          </tr>
      </thead>
      <tbody>
        <tr class="bg-gray-100">
  <th class="text-left p-1 border bg-sky-400" colspan="5">A. PERSONALITY/BEHAVIOR</th>
</tr>
<tr>
  <td class="p-1 border">1 |<span class="font-bold"> Maayo ug batasan ug displinado. </span> (Well mannered and disciplined)</td>
  <td class="p-1 border text-center">
    <input type="number" min="0" max="4" v-model="form.sections[0].indicators[0].self_rating" @change="validateRating(form.sections[0].indicators[0], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
  </td>
  <td class="p-1 border text-center">
    <input type="number" min="0" max="4" v-model="form.sections[0].indicators[0].mdo_rating" @change="validateRating(form.sections[0].indicators[0], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
  </td>
  <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[0].indicators[0]) }}</td>
  <td class="p-1 border text-center" rowspan="5" style="width: 180px; ">
    <textarea v-model="form.sections[0].remarks" rows="5" class="w-full p-2 border border-gray-300 rounded text-sm" style=" height: 300px; ":readonly="!editMode"></textarea>
</td>

</tr>

          <tr>
              <td class="p-1 border">2 |<span class="font-bold"> Makahimo ug maayong aksyon ug desisyon sa mga dili maayong sitwasyon. </span>(He acts appropriately in any given situation)</td>
              <td class="p-1 border text-center"><input type="number" min="0" max="4" v-model="form.sections[0].indicators[1].self_rating" @change="validateRating(form.sections[0].indicators[1], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> <input type="number" min="0" max="4" v-model="form.sections[0].indicators[1].mdo_rating" @change="validateRating(form.sections[0].indicators[1], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[0].indicators[1]) }}</td>
          </tr>
          <tr>
              <td class="p-1 border">3 | <span class="font-bold">Mohatag ug inspirasyon ug mopadasig sa kaubang residente nga magmalipayon. </span>(He can inspire and motivate co-residents to be happy)</td>
              <td class="p-1 border text-center"><input type="number" min="0" max="4" v-model="form.sections[0].indicators[2].self_rating" @change="validateRating(form.sections[0].indicators[2], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> <input type="number" min="0" max="4" v-model="form.sections[0].indicators[2].mdo_rating" @change="validateRating(form.sections[0].indicators[2], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[0].indicators[2]) }}</td>
          </tr>
          <tr>
              <td class="p-1 border">4 | <span class="font-bold">Makabarug ug makatidong sa kaugalingon sa mga dili maayong sitwasyon.</span> (Carry himself well in any given situation)</td>
              <td class="p-1 border text-center"> <input type="number" min="0" max="4" v-model="form.sections[0].indicators[3].self_rating" @change="validateRating(form.sections[0].indicators[3], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"><input type="number" min="0" max="4" v-model="form.sections[0].indicators[3].mdo_rating" @change="validateRating(form.sections[0].indicators[3], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[0].indicators[3]) }}</td>
          </tr>
          <tr>
              <td class="p-1 border">5 | <span class="font-bold">Naay kaisog nga mopadayag sa kaugalingon. </span>(Has confidence in expressing himself)</td>
              <td class="p-1 border text-center"><input type="number" min="0" max="4" v-model="form.sections[0].indicators[4].self_rating" @change="validateRating(form.sections[0].indicators[4], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> <input type="number" min="0" max="4" v-model="form.sections[0].indicators[4].mdo_rating" @change="validateRating(form.sections[0].indicators[4], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[0].indicators[4]) }}</td>
          </tr>
          <tr class="bg-sky-400">
              <th class="text-left p-1 border" colspan="1">B. PERSONAL RELATIONSHIP</th>
              <th class="text-left p-1 border" colspan="5">Sub-Total {{ calculateSubTotal(form.sections[0].indicators) }}</th>
          </tr>
          <tr>
              <td class="p-1 border">1 | <span class="font-bold">Makighalobilo ug makigdait sa ubang residente, staff ug mga trainer.</span> (Can relate appropriately with co-residents, staff, and trainers)</td>
              <td class="p-1 border text-center">  
                 <input type="number" min="0" max="4" v-model="form.sections[1].indicators[0].self_rating" @change="validateRating(form.sections[1].indicators[0], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> 
                 <input type="number" min="0" max="4" v-model="form.sections[1].indicators[0].mdo_rating" @change="validateRating(form.sections[1].indicators[0], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[1].indicators[0]) }}</td>
              <td class="p-1 border text-center" rowspan="5" style="width:180px;">
                <textarea v-model="form.sections[1].remarks" class="w-full p-2 border border-gray-300 rounded text-sm"  style=" height: 300px; " :readonly="!editMode"></textarea>
  
              </td>
          </tr>
          <tr>
              <td class="p-1 border">2 | <span class="font-bold">Makadala ug makadasig sa ubang residente sa paghimo sa ilang mga buluhaton. </span>(Can lead and motivate co-residents to do assigned tasks)</td>
              <td class="p-1 border text-center"> 
                  <input type="number" min="0" max="4" v-model="form.sections[1].indicators[1].self_rating" @change="validateRating(form.sections[1].indicators[1], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center">  
                <input type="number" min="0" max="4" v-model="form.sections[1].indicators[1].mdo_rating" @change="validateRating(form.sections[1].indicators[1], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[1].indicators[1]) }}</td>
          </tr>
          <tr>
              <td class="p-1 border">3 | <span class="font-bold">Masaligan ug masandigan sa tanang higayon. </span>(Dependable in any given situation)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[1].indicators[2].self_rating" @change="validateRating(form.sections[1].indicators[2], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[1].indicators[2].mdo_rating" @change="validateRating(form.sections[1].indicators[2], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[1].indicators[2]) }}</td>
          </tr>
          <tr>
              <td class="p-1 border">4 | <span class="font-bold">Andam nga makat-on pinaagi sa pagpaminaw, pagpangutana sa wala nasabtan ngadto sa mga trainor. </span>(Has the willingness to learn by listening, asking questions/clarify concerns with trainer)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[1].indicators[3].self_rating" @change="validateRating(form.sections[1].indicators[3], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[1].indicators[3].mdo_rating" @change="validateRating(form.sections[1].indicators[3], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[1].indicators[3]) }}</td>
          </tr>
          <tr>
              <td class="p-1 border">5 | <span class="font-bold">Dili moapil sa mga dili maayo nga buhat ug panghitabo sa sulod sa training. </span>(Non-involvement in any untoward incident that may occur during the training)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[1].indicators[4].self_rating" @change="validateRating(form.sections[1].indicators[4], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[1].indicators[4].mdo_rating" @change="validateRating(form.sections[1].indicators[4], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[1].indicators[4]) }}</td>
          </tr>
          <tr class="bg-sky-400">
              <th class="text-left p-1 border" colspan="1">C. KNOWLEDGE:</th>
              <th class="text-left p-1 border" colspan="5">Sub-Total {{ calculateSubTotal(form.sections[1].indicators) }}</th>
          </tr>
          <tr>
              <td class="p-1 border">1 | <span class="font-bold">Naay pamaagi nga madugangan ang talento. </span>(Has the initiative to improve his given skills and talents)</td>
              <td class="p-1 border text-center">  
                <input type="number" min="0" max="4" v-model="form.sections[2].indicators[0].self_rating" @change="validateRating(form.sections[2].indicators[0], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[2].indicators[0].mdo_rating" @change="validateRating(form.sections[2].indicators[0], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[2].indicators[0]) }}</td>
              <td class="p-1 border text-center" rowspan="5" style="width: 180px;">
                <textarea v-model="form.sections[2].remarks" class="w-full p-2 border border-gray-300 rounded text-sm" style="height: 300px;"   :readonly="!editMode"></textarea>
  
              </td>
          </tr>
          <tr>
              <td class="p-1 border">2 | <span class="font-bold">Nagpakita ug katakus nga mahatag ang pinakamaayo sa gihatag nga trabaho. </span>(Has shown his best in any given tasks)</td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[2].indicators[1].self_rating" @change="validateRating(form.sections[2].indicators[1], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center">  
                <input type="number" min="0" max="4" v-model="form.sections[2].indicators[1].mdo_rating" @change="validateRating(form.sections[2].indicators[1], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[2].indicators[1]) }}</td>
          </tr>
          <tr>
              <td class="p-1 border">3 | <span class="font-bold">Nagpambit sa talento para mahatag ang pinakamaayong resulta para sa aktibidad. </span>(Share his talent for best results on a given activity)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[2].indicators[2].self_rating" @change="validateRating(form.sections[2].indicators[2], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[2].indicators[2].mdo_rating" @change="validateRating(form.sections[2].indicators[2], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[2].indicators[2]) }}</td>
          </tr>
          <tr>
              <td class="p-1 border">4 | <span class="font-bold">Naay kapasidad nga modutlo sa mga kauban sa mga butang nga makapalambo ug mapagawas ang pinakamaayo.</span> (Has the capacity to teach his co-residents on things that will improve and show their best in a given situation)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[2].indicators[3].self_rating" @change="validateRating(form.sections[2].indicators[3], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[2].indicators[3].mdo_rating" @change="validateRating(form.sections[2].indicators[3], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[2].indicators[3]) }}</td>
          </tr>
          <tr>
              <td class="p-1 border">5 | <span class="font-bold">Padayon sa pagsulay sa mga maayong butang nga makapalambo sa mga nakat-unan. </span>(Continue to try new things that will increase and improve his learnings)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[2].indicators[4].self_rating" @change="validateRating(form.sections[2].indicators[4], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[2].indicators[4].mdo_rating" @change="validateRating(form.sections[2].indicators[4], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[2].indicators[4]) }}</td>
                </tr>
                <tr class="bg-sky-400">
              <th class="text-left p-1 border" colspan="1">D. SKILLS:</th>
              <th class="text-left p-1 border" colspan="5">Sub-Total {{ calculateSubTotal(form.sections[2].indicators) }}</th>
          </tr>
          <tr>
              <td class="p-1 border">1 |<span class="font-bold"> Naay kapasidad nga mohimo sa mga butang nga magpakita sa mga talento.</span> (Has inherent capacity to be creative)</td>
              <td class="p-1 border text-center">  
                <input type="number" min="0" max="4" v-model="form.sections[3].indicators[0].self_rating" @change="validateRating(form.sections[3].indicators[0], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[3].indicators[0].mdo_rating" @change="validateRating(form.sections[3].indicators[0], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center">{{ calculateTotalRating(form.sections[3].indicators[0]) }}</td>
              <td class="p-1 border text-center" rowspan="5" style="width: 180px;">
                <textarea v-model="form.sections[3].remarks" class="w-full p-2 border border-gray-300 rounded text-sm" style="height: 300px;"   :readonly="!editMode"></textarea>
  
              </td>
          </tr>
          <tr>
              <td class="p-1 border">2 | <span class="font-bold">Pagamit sa mga skills nga nakat-unan sa pagbuhat sa mga aktibidad nga makatabang.</span> (Utilizes his skills appropriately on beneficial activity)</td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[3].indicators[1].self_rating" @change="validateRating(form.sections[3].indicators[1], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center">  
                <input type="number" min="0" max="4" v-model="form.sections[3].indicators[1].mdo_rating" @change="validateRating(form.sections[3].indicators[1], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
           </td>
           <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[3].indicators[1]) }}</td>
          </tr>
          <tr>
              <td class="p-1 border">3 | <span class="font-bold">Naningkamot nga mapakita ang pinakamaayo nga nakat-unan pinaagi sa pag-apil sa mga kalihukan. </span>(Tries his best to be progressive on acquired skills in the different activities)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[3].indicators[2].self_rating" @change="validateRating(form.sections[3].indicators[2], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[3].indicators[2].mdo_rating" @change="validateRating(form.sections[3].indicators[2], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[3].indicators[2]) }}</td>
          </tr>
          <tr>
              <td class="p-1 border">4 | <span class="font-bold">Moapil sa mga kalihukan sa pagtabang sa mga trainor para magamit ang tanang oras sa mga residente. </span>(Participates in activities that will assist the trainer in maximizing resident time at the center)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[3].indicators[3].self_rating" @change="validateRating(form.sections[3].indicators[3], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
             </td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[3].indicators[3].mdo_rating" @change="validateRating(form.sections[3].indicators[3], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
            </td>
            <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[3].indicators[3]) }}</td>
          </tr>
          <tr>
              <td class="p-1 border">5 | <span class="font-bold">Dali lang makakat-on sa mga programa sa pagpalambo nga gitudlo. </span>(Learns easily on productive endeavors taught to him)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[3].indicators[4].self_rating" @change="validateRating(form.sections[3].indicators[4], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[3].indicators[4].mdo_rating" @change="validateRating(form.sections[3].indicators[4], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
            </td>
            <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[3].indicators[4]) }}</td>
                </tr>
                <tr class="bg-sky-400">
              <th class="text-left p-1 border" colspan="1"></th>
              <th class="text-left p-1 border" colspan="5">Sub-Total {{ calculateSubTotal(form.sections[3].indicators) }}</th>
          </tr>
      </tbody>
    </table>
  </div>
  </div>
  
  <div class="border-t border-gray-300 pt-4 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;"> 
      <div class="flex justify-between items-start w-full">
          <div class="flex flex-col w-full"> <!-- Expanded width for the text section -->
              <p class="font-bold">PAGE 1 of 2</p>
              <p class="pt-2">DSWD FOXI, Regional Rehabilitation Center for Youth, Bago Oshiro, Davao City, Philippines 8000</p>
              <p class="text-blue-600 underline"> Email: rrcy.fo11.dswd.gov.ph; Tel No.(082) 293-0306</p>
              <p class="border-t border-black pt-2"></p>
          </div>
          <div class="w-1/6 flex justify-end"> <!-- Restricting the image section to the right side -->
              <img src="/images/footerimg.png" alt="Footer Image" class="h-12 w-32 object-cover"> <!-- Expanded width for image -->
          </div>
      </div>
  </div>
  
  
  </div>
  
  
    <div v-if="currentPage === 2" class="max-w-3xl p-8 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
  
      <div class="text-right mt-4">
        <p class="text-xs font-bold italic">DSWD-GF-010 | REV 02 | 17 AUG 2022</p>
    </div>
      <!-- General Information -->
      <div class=" mb-6 grid grid-cols-2 mt-4 gap-4">
        <div class="flex items-center justify-start mb-6">
          <label class="block text-sm font-bold mb-1">Name of Resident:</label>
          <input type="text" v-model="form.name" class="underline-input2 ml-4 text-sm w-1/2 p-2 border border-gray-300 " readonly />
        </div>
        <div class="flex items-center justify-start ml-12 mb-6">
          <label class="block text-sm font-bold mr-2">Date of Assessment:</label>
          <input type="date" v-model="form.assessment_date" class="underline-input2 text-sm p-2 border border-gray-300 w-1/2" :readonly="!editMode" />
        </div>
      </div>
  
      <!-- Sections for Indicators and Remarks -->
      <div class="mb-6">
        
    <table class="w-full -mt-8 border-collapse border mb-4 text-xs">
      
      <tbody>
          <tr class="bg-sky-400">
              <th class="text-left p-1 border" colspan="5">E. ATTITUDE</th>
          </tr>
          <tr>
              <td class="p-1 border">1 |<span class="font-bold"> Wala mosupak sa mga polisiya sa training sa tanang higayon. </span>(He abides with policies of the training at all times)</td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[4].indicators[0].self_rating" @change="validateRating(form.sections[4].indicators[0], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[4].indicators[0].mdo_rating" @change="validateRating(form.sections[4].indicators[0], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[4].indicators[0]) }}</td>
              <td class="p-1 border text-center" rowspan="5" style="width: 180px;">
                      <textarea v-model="form.sections[4].remarks" class="w-full p-2 border border-gray-300 rounded text-sm" style="height: 300px;"  :readonly="!editMode"></textarea>
  
              </td>
          </tr>
          <tr>
              <td class="p-1 border">2 |<span class="font-bold"> Mosunod ug motuman sa mga tudlo sa gihatag nga trabaho. </span>(He follows instructions on given tasks)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[4].indicators[1].self_rating" @change="validateRating(form.sections[4].indicators[1], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[4].indicators[1].mdo_rating" @change="validateRating(form.sections[4].indicators[1], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[4].indicators[1]) }}</td>
          </tr>
          <tr>
              <td class="p-1 border">3 | <span class="font-bold">Parehas nga pagtagad sa mga kaubang residente. </span>(He treats his co-residents fairly)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[4].indicators[2].self_rating" @change="validateRating(form.sections[4].indicators[2], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[4].indicators[2].mdo_rating" @change="validateRating(form.sections[4].indicators[2], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[4].indicators[2]) }}</td>
                </tr>
          <tr>
              <td class="p-1 border">4 | <span class="font-bold">Maayong timplo sa tanang higayon. </span> (He is a peacemaker at all times)</td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[4].indicators[3].self_rating" @change="validateRating(form.sections[4].indicators[3], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[4].indicators[3].mdo_rating" @change="validateRating(form.sections[4].indicators[3], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[4].indicators[3]) }}</td>
          </tr>
          <tr>
              <td class="p-1 border">5 | <span class="font-bold">Makabalanse sa tanang mga pagsulay ug kalisud. </span>(He can cope up with challenges and difficulties)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[4].indicators[4].self_rating" @change="validateRating(form.sections[4].indicators[4], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[4].indicators[4].mdo_rating" @change="validateRating(form.sections[4].indicators[4], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[4].indicators[4]) }}</td>
          </tr>
          <tr class="bg-sky-400">
              <th class="text-left p-1 border" colspan="1">F. RESPONSES TO SITUATIONS</th>
              <th class="text-left p-1 border" colspan="5">Sub-Total {{ calculateSubTotal(form.sections[4].indicators) }}</th>
          </tr>
          <tr>
              <td class="p-1 border">1 | <span class="font-bold">Dili moreklamo sa mga wala giplano nga kabag-uhan. </span>(Never complains on unexpected changes/result of a group tasks)</td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[5].indicators[0].self_rating" @change="validateRating(form.sections[5].indicators[0], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[5].indicators[0].mdo_rating" @change="validateRating(form.sections[5].indicators[0], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[5].indicators[0]) }}</td>
              <td class="p-1 border text-center" rowspan="5" style="width: 180px;">
                      <textarea v-model="form.sections[5].remarks" class="w-full p-2 border border-gray-300 rounded text-sm"  style="height: 300px;" :readonly="!editMode"></textarea>
  
              </td>
          </tr>
          <tr>
              <td class="p-1 border">2 | <span class="font-bold">Inanay/plastar sa iyang plano ug mga desisyon. </span>(Gentle in his actions/decisions)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[5].indicators[1].self_rating" @change="validateRating(form.sections[5].indicators[1], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[5].indicators[1].mdo_rating" @change="validateRating(form.sections[5].indicators[1], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[5].indicators[1]) }}</td>
            </tr>
          <tr>
              <td class="p-1 border">3 | <span class="font-bold">Madaladala sa mga bug-at/challenging nga buhat.</span> (Can handle challenging tasks)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[5].indicators[2].self_rating" @change="validateRating(form.sections[5].indicators[2], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[5].indicators[2].mdo_rating" @change="validateRating(form.sections[5].indicators[2], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
            </td>
            <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[5].indicators[2]) }}</td>
                </tr>
          <tr>
              <td class="p-1 border">4 | <span class="font-bold">Makaplano ug maayo sa mga moabot nga sitwasyon.</span> (Can think appropriately in any given situation)</td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[5].indicators[3].self_rating" @change="validateRating(form.sections[5].indicators[3], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[5].indicators[3].mdo_rating" @change="validateRating(form.sections[5].indicators[3], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
             </td>
             <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[5].indicators[3]) }}</td>
          </tr>
          <tr>
              <td class="p-1 border">5 | <span class="font-bold">Dili makiglalis sa mga kaubang residente ug trainor para dili makahimo ug kagubot. </span>(Never argues with co-residents and trainor to create conflict)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[5].indicators[4].self_rating" @change="validateRating(form.sections[5].indicators[4], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[5].indicators[4].mdo_rating" @change="validateRating(form.sections[5].indicators[4], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[5].indicators[4]) }}</td>
          </tr>
          <tr class="bg-sky-400">
              <th class="text-left p-1 border" colspan="1">G. LIFE'S ASPIRATIONS</th>
              <th class="text-left p-1 border" colspan="5">Sub-Total {{ calculateSubTotal(form.sections[5].indicators) }}</th>
          </tr>
          <tr>
              <td class="p-1 border">1 | <span class="font-bold">Andam makaton sa mga kabag-ohan.</span> (Willingness to learn new things)</td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[6].indicators[0].self_rating" @change="validateRating(form.sections[6].indicators[0], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[6].indicators[0].mdo_rating" @change="validateRating(form.sections[6].indicators[0], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[6].indicators[0]) }}</td>
              <td class="p-1 border text-center" rowspan="5" style="width: 180px;">
                      <textarea v-model="form.sections[6].remarks" class="w-full p-2 border border-gray-300 rounded text-sm" style="height: 300px;" :readonly="!editMode"></textarea>
  
              </td>
          </tr>
          <tr>
              <td class="p-1 border">2 | <span class="font-bold">Naghatag ug importansya sa pag-eskwela.</span> (Values the importance of education)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[6].indicators[1].self_rating" @change="validateRating(form.sections[6].indicators[1], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[6].indicators[1].mdo_rating" @change="validateRating(form.sections[6].indicators[1], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[6].indicators[1]) }}</td>
            </tr>
          <tr>
              <td class="p-1 border">3 | <span class="font-bold">Nagatoo nga ang pagbantog ug disiplina sa kaugalingon makapabago-o sa kinabuhi. </span>(Believes having discipline can change his life)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[6].indicators[2].self_rating" @change="validateRating(form.sections[6].indicators[2], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[6].indicators[2].mdo_rating" @change="validateRating(form.sections[6].indicators[2], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[6].indicators[2]) }}</td>
                </tr>
          <tr>
              <td class="p-1 border">4 | <span class="font-bold">Nagatoo sa gahum sa pag-atiman sa Ginoo. </span>(Believes in the power of the caring God)</td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[6].indicators[3].self_rating" @change="validateRating(form.sections[6].indicators[3], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
             </td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[6].indicators[3].mdo_rating" @change="validateRating(form.sections[6].indicators[3], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[6].indicators[3]) }}</td>
          </tr>
          <tr>
              <td class="p-1 border">5 |<span class="font-bold"> Nagatoo nga ang maayong pamatasan makatabang nga mapalambo ang kaugalingon nga kakayahan. </span>(Believes that good character qualities will help him develop his potentials)</td>
              <td class="p-1 border text-center">
                <input type="number" min="0" max="4" v-model="form.sections[6].indicators[4].self_rating" @change="validateRating(form.sections[6].indicators[4], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-1 border text-center"> 
                <input type="number" min="0" max="4" v-model="form.sections[6].indicators[4].mdo_rating" @change="validateRating(form.sections[6].indicators[4], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[6].indicators[4]) }}</td>
          </tr>
          <tr class="bg-sky-400">
            <th class="text-left p-1 border" colspan="1"></th>
              <th class="text-left p-1 border" colspan="5">Sub-Total {{ calculateSubTotal(form.sections[6].indicators) }}</th>
          </tr>
          <tr class="bg-purple-300">
            <th class="text-left p-1 border" colspan="1">OVER-ALL RATING</th>
              <th class="text-left p-1 border" colspan="5">{{ calculateOverallRating().overall }}</th>
          </tr>
          <tr class="bg-white border-black">
            <th class="text-left p-1 border-black border" colspan="1">ADJECTIVAL RATING</th>
            <th class="text-left p-1 border-black border" colspan="2"></th>
            <th class="text-left p-1 border-black border" colspan="3"></th>
          </tr>
          <tr class="bg-white border-black">
            <th class="text-left p-1 border-black border" colspan="5"></th>
          </tr>
          <tr class=" text-sm">
              <td class="border border-black p-2 align-top  font-bold text-xs " colspan="1">4 - Points - Excellent/Full cooperation and proper physical condition</td>
              <td class="border border-black p-2 align-top font-bold text-xs" colspan="5">2 - 2.99 Points - Needs Improvement/Complies with the request to cooperate</td>
          </tr>
          <tr class=" text-sm">
              <td class="border border-black p-2 align-top font-bold text-xs " colspan="1">3 - 3.99 Points - Very Satisfactory/Appropriate behavior and condition during the training</td>
              <td class="border border-black p-2 align-top font-bold text-xs" colspan="5">1 - 1.99 Points - Needs Close Monitoring/Problem is Prominent</td>
          </tr>
  
  
  
          <tr class="bg-rose-300 border-black">
            <th class="text-left p-1 text-sm border-black border" colspan="5">General Remarks/Recommendation:</th>
          </tr>
          <tr class="bg-white border-black">
            <th class="text-left p-1 border-black border" colspan="5">   <textarea v-model="form.general_remarks" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode"></textarea></th>
          </tr>
  
  
        </tbody>
    </table>
  </div>
  
  
          <table class="w-full -mt-6 border-collapse border mb-4 text-xs">
      <thead>
          <!-- Header row with pink background -->
          <tr class="bg-rose-300 border-black">
              <th class="text-left font-bold text-sm p-2 border-black border" colspan="5">TRAININGS PREVIOUSLY ATTENDED:</th>
          </tr>
  
          <tr class="bg-white border-black">
              <th class="text-center p-2 border w-12">No.</th> <!-- Adjusted width to fit 2-3 digits -->
              <th class="text-center p-2 border">TITLE OF THE TRAINING</th>
              <th class="text-center p-2 border">DATE OF ATTENDANCE</th>
              <th class="text-center p-2 border">STATUS</th>
              <th class="text-center p-2 border">
                  <button @click="removeTraining(index)" type="button" class="px-2 py-1 bg-red-500 text-white rounded" :disabled="!editMode">Remove</button>
              </th>
          </tr>
      </thead>
  
      <tbody>
          <!-- Dynamic rows for each training -->
          <tr v-for="(training, index) in form.trainings" :key="index" class="border">
              <td class="p-2 border text-center w-12">{{ index + 1 }}</td> <!-- Adjusted width to match header -->
              <td class="p-2 border">
                  <input type="text" v-model="training.title" class="w-full p-1 border-none border-gray-300 rounded text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border">
                  <input type="date" v-model="training.date_of_attendance" class="w-full p-1 border-none border-gray-300 rounded text-sm" :readonly="!editMode" />
              </td>
              <td class="p-2 border">
                  <input type="text" v-model="training.status" class="w-full p-1 border-none border-gray-300 rounded text-sm" :readonly="!editMode" />
              </td>
          </tr>
        <tr>
      <button @click="addTraining" type="button" class="px-4 py-2 bg-blue-500 text-white rounded" :disabled="!editMode">Add Training</button>
    </tr>
      </tbody>
  </table>
  
  
  
  
  
  
  
  
  
      
  <!-- Signatures Section -->
  <div class="mb-6 flex justify-between text-xs">
    <!-- Prepared by Signatures -->
    <div class="w-1/2">
      <label class="block mb-1 text-xs">Prepared by:</label>
      <div class="flex">
    <div class="text-center mr-6">
      <input
        type="text"
        v-model="form.prepared_by_one"
        class="mt-1 text-center font-bold underline-input p-0 text-xs w-full"
      >
      <p class="text-xs mt-1">MDO I</p>
    </div>
    <div class="text-center ml-6">
      <input
        type="text"
        v-model="form.prepared_by_two"
        class="mt-1 text-center font-bold underline-input p-0 text-xs w-full"
      >
      <p class="text-xs mt-1">MDO II</p>
    </div>
  </div>
  
    </div>
  
    
    <!-- Noted by Signature -->
    <div class="w-1/2 text-center">
    <label class="block mb-1 text-xs">Noted by:</label>
    <input
      type="text"
      v-model="center_head"
      readonly
      class="mt-1 underline-input font-bold p-0 text-xs w-full text-center"
    >
    <p class="text-xs mt-1">Center Head</p>
  </div>
  
  </div>
  
  
  <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        
        <!-- Left Section: Page number -->
        <div class="flex flex-col flex-grow">
          <!-- Page number centered -->
          <p class="text-center -mb-1 font-bold">PAGE 2 of {{ totalPages }}</p>
    
        <!-- Continuous horizontal line, moved to the left with space on the right -->
        <div style="border-top: 2px solid black; width: 103%; margin-top: 4px; margin-left: -24px;"></div>
    
    
          <!-- Text under the line -->
          <p style="text-align: LEFT; font-weight: bold; margin-top: -1px;">DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH
          </p>
        </div>
    
      </div>
            </div>
        
        </div>
    </div>
  </template>
  
  
  <script>
  import axios from 'axios';
  import Pagination from '@/Components/Pagination.vue';
  import jsPDF from 'jspdf';
  
  export default {
    name: 'IORForm',
    components: {
      Pagination,
    },
    data() {
    return {
      form: {
        client_id: null,
        name: '',
        period: '',
        assessment_date: '',
        trainings_attended: '',
        sections: [
          {
            title: 'Section A',
            sub_total: 0,
            remarks: '',
            indicators: [
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' }
            ]
          },
          {
            title: 'Section B',
            sub_total: 0,
            remarks: '',
            indicators: [
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' }
            ]
          },
          {
            title: 'Section C',
            sub_total: 0,
            remarks: '',
            indicators: [
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' }
            ]
          },
          {
            title: 'Section D',
            sub_total: 0,
            remarks: '',
            indicators: [
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' }
            ]
          },
          {
            title: 'Section E',
            sub_total: 0,
            remarks: '',
            indicators: [
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' }
            ]
          },
          {
            title: 'Section F',
            sub_total: 0,
            remarks: '',
            indicators: [
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' }
            ]
          },
          {
            title: 'Section G',
            sub_total: 0,
            remarks: '',
            indicators: [
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' },
              { self_rating: '', mdo_rating: '' }
            ]        
          },
        ],
        general_remarks: '',
        trainings: [{ title: '', date_of_attendance: '', status: '' }],
        prepared_by_one: '',
        prepared_by_two: '',
      },
      center_head: '',
      editMode: false,
      originalForm: null,
      message: '',
      totalPages: 2,
      currentPage: 1,
      messageType: '',
    };
  }
  ,
    mounted() {
      this.fetchReportData();
      this.fetchCenterHead();
    },
    watch: {
      '$route.params.id': 'fetchReportData',
  }
  ,
    methods: {
      addTraining() {
      this.form.trainings.push({ title: '', date_of_attendance: '', status: '' });
    },
    removeTraining(index) {
      this.form.trainings.splice(index, 1);
    },
    fetchReportData() {
      const clientId = this.$route.params.id;
  
      // Ensure clientId is defined
      if (!clientId) {
          console.warn("Client ID is undefined. Fetching client data.");
          this.fetchClientData(); // Fetch the client data directly
          return;
      }
  
      // Fetch performance observation report data
      axios.get(`/api/performance-observation-reports/${clientId}/show`)
          .then(response => {
              console.log('API Response:', response.data);  // Log API response
  
              if (response.data) {
                  const report = response.data.report;
                  const client = response.data.client;
  
                  // Ensure the client exists in the response and set it
                  if (client && client.id) {
                      this.form.client_id = client.id;
                      this.form.name = `${client.first_name} ${client.last_name}`;
                  } else {
                      console.warn('Client data is missing from the report response. Fetching client data separately.');
                      this.fetchClientData(clientId);
                  }
  
                  // Process report data if it exists
                  if (report) {
                      if (report.sections && Array.isArray(report.sections)) {
                          this.form.sections = report.sections.map(section => ({
                              title: section.title,
                              sub_total: section.sub_total,
                              remarks: section.remarks,
                              indicators: section.indicators.map(indicator => ({
                                  self_rating: indicator.self_rating,
                                  mdo_rating: indicator.mdo_rating,
                              }))
                          }));
                      }
  
                      // Handle the trainings array from the report
                      if (response.data.trainings && Array.isArray(response.data.trainings)) {
                          this.form.trainings = response.data.trainings.map(training => ({
                              title: training.title,
                              date_of_attendance: training.date_of_attendance,
                              status: training.status,
                          }));
                      }
  
                      this.form.assessment_date = report.assessment_date;
                      this.form.period = report.period;
                      this.form.trainings_attended = report.trainings_attended;
                      this.form.general_remarks = report.general_remarks;
                      this.form.prepared_by_one = report.prepared_by_one;
                      this.form.prepared_by_two = report.prepared_by_two;
                  }
  
                  // Fetch center head based on the client data
                  this.fetchCenterHead(this.form.client_id);
  
                  console.log('Form data after API fetch:', this.form);  // Log the form data after fetch
                  this.messageType = 'success';
              } else {
                  console.warn('No report data found. Fetching client data separately.');
                  this.fetchClientData(clientId);
              }
          })
          .catch(error => {
              console.error('Error fetching report data:', error);
              this.fetchClientData(clientId);
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
    
    fetchClientData(clientId) {
      // Check if clientId is valid
      if (!clientId) {
          console.error("Client ID is undefined or invalid.");
          return;
      }
  
      // Make the API request to fetch client data
      axios.get(`/api/clients/${clientId}`)
          .then(response => {
              const client = response.data;
  
              // Ensure client data exists
              if (client && client.id) {
                  this.form.client_id = client.id; // Set the client_id
                  this.form.name = `${client.first_name} ${client.last_name}`; // Set client name
                  this.fetchCenterHead(clientId); // Fetch related data if needed
  
                  console.log("Client data successfully fetched:", this.form.name);
              } else {
                  console.error("No client data found.");
              }
          })
          .catch(error => {
              // Detailed error logging
              if (error.response) {
                  console.error(`Error fetching client data: ${error.response.status} - ${error.response.data.message}`);
              } else if (error.request) {
                  console.error("No response received from the server.");
              } else {
                  console.error("Request error:", error.message);
              }
          });
  },
      submitForm() {
      console.log("Submitting form with data:", this.form);
  
      // Check for missing client_id (only check if in edit mode)
      if (!this.form.client_id && this.editMode) {
        this.message = 'Failed to save data: Missing client ID';
        this.messageType = 'error';
        return;
      }
  
      // Prepare the payload with the required fields
      const payload = {
        client_id: this.form.client_id,
        period: this.form.period,
        assessment_date: this.form.assessment_date,
        trainings_attended: this.form.trainings_attended,
        general_remarks: this.form.general_remarks,
        prepared_by_one: this.form.prepared_by_one || '',
        prepared_by_two: this.form.prepared_by_two || '',
  
        // JSON fields for sections and ratings
        sections: this.form.sections,
        trainings: this.form.trainings
      };
  
      // Determine whether to create or update based on whether the form is in edit mode
      const apiMethod = this.editMode ? 'put' : 'post';
      const apiUrl = this.editMode 
        ? `/api/performance-observation-reports/${this.form.client_id}`  // Update if in edit mode
        : `/api/performance-observation-reports`;  // Create if not in edit mode
  
      // Perform the API call to submit the form data
      axios[apiMethod](apiUrl, payload)
        .then(response => {
          // Handle successful response
          this.message = 'Form submitted successfully!';
          this.messageType = 'success';
          this.editMode = false; // Exit edit mode after saving
          console.log('Success:', response.data);
        })
        .catch(error => {
          // Handle validation or other errors (e.g., 422 HTTP response)
          this.message = this.constructDetailedErrorMessage(error);
          this.messageType = 'error';
          console.error('Error:', error);
        });
    },
      clearMessageAfterDelay() {
      setTimeout(() => {
        this.message = '';
      }, 3000); // Clear the message after 3 seconds
    },
      constructDetailedErrorMessage(error) {
          let message = 'Failed to save or update data: ';
      
          if (error.response) {
              message += `HTTP ${error.response.status} (${error.response.statusText}) - `;
      
              if (error.response.data && error.response.data.message) {
                  message += `${error.response.data.message}. `;
              }
      
              if (error.response.data && error.response.data.errors) {
                  const errorDetails = Object.entries(error.response.data.errors)
                      .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
                      .join('; ');
                  message += `Details: ${errorDetails}`;
              }
          } else if (error.request) {
              message += 'No response received from the server. ';
          } else {
              message += `Request setup error: ${error.message}. `;
          }
      
          return message;
      },
      toggleEdit() {
          this.editMode = !this.editMode;
      },
      calculateTotalRating(indicator) {
    if (!indicator) return 0;
    
    // Parse the ratings and add them, then divide by 2
    const selfRating = parseFloat(indicator.self_rating) || 0;
    const mdoRating = parseFloat(indicator.mdo_rating) || 0;
  
    return (selfRating + mdoRating) / 2;
  }
  ,
  validateRating(indicator, ratingType) {
    // If a user manually inputs a value greater than 4, automatically set it to 4
    if (indicator[ratingType] > 4) {
      indicator[ratingType] = 4;
    } else if (indicator[ratingType] < 0) {
      // If input is less than 0, set it to 0
      indicator[ratingType] = 0;
    }
  },
      cancelEdit() {
        this.editMode = false;
        console.log('Edit mode canceled');
      },
      calculateSubTotal(indicators) {
    if (!Array.isArray(indicators) || indicators.length === 0) return 0;
    
    // Sum all the total ratings
    const totalRatings = indicators.reduce((total, indicator) => {
      return total + this.calculateTotalRating(indicator);
    }, 0);
    
    // Automatically determine the number of indicators and divide
    const numOfIndicators = indicators.length;
    
    // Return the average of the total ratings
    return (totalRatings / numOfIndicators).toFixed(2); // Ensures the result is rounded to two decimal places
  }
  ,
  calculateOverallRating() {
    let totalSubtotals = 0;
    let sectionCount = this.form.sections.length;
  
    // Iterate through all sections and sum their subtotals
    this.form.sections.forEach(section => {
      const subTotal = this.calculateSubTotal(section.indicators);
      totalSubtotals += isNaN(subTotal) ? 0 : parseFloat(subTotal);  // Ensure subtotals are valid numbers
    });
  
    // If no valid sections or total is zero, return 0
    if (sectionCount === 0 || totalSubtotals === 0) {
      return { overall: '0.00' };
    }
  
    // Calculate the overall average rating
    const overallAverage = totalSubtotals / sectionCount;
  
    return {
      overall: isNaN(overallAverage) ? '0.00' : overallAverage.toFixed(2)
    };
  },
      addTraining() {
        this.form.trainings.push({
          title: '',
          date_of_attendance: '',
          status: ''
        });
      },
      removeTraining(index) {
        this.form.trainings.splice(index, 1);
      },  exportToPdf() {
    const pdf = new jsPDF('p', 'mm', [216, 356]); // Legal size: 216mm x 356mm
    const pageHeight = 356; // Total page height in mm
    const marginBottom = 30; // Bottom margin in mm
    const rowHeight = 8; // Height of each row
    const lineHeight = 6; // Space between lines
    const footerHeight = 5; // Adjust to fit the height of your footer
    const maxContentHeight = pageHeight - marginBottom - footerHeight; // Reduce height to account for footer
    const maxWidth = 190; // Maximum width for text
    let initialX = 11; // X position for content
    let currentPage = 1; // Start at page 1
    const maxRemarksHeight = 60;
    const maxLines = Math.floor(maxRemarksHeight / lineHeight);
  
    const colWidths = [10, 90, 50, 40];
  
    
    const addHeader = () => {
      // Header text
      pdf.setFontSize(9);
      pdf.setFont('TimesNewRoman', 'italic');
      pdf.text('DSWD-GF-010 | REV 02 | 17 AUG 2022', 135, 20);
    };
    
    // Helper function to add a new page if content exceeds the page height
    const addNewPageIfNeeded = () => {
      if (contentYPos >= maxContentHeight) {
        addFooter(); // Add the footer for the current page
        pdf.addPage(); // Add new page
        addHeader(); // Add the header on the new page
        currentPage++; // Increment page number
        contentYPos = 40; // Reset Y position for the new page
        pdf.setFont('arial', 'normal'); // Reset font to 'arial' and style to 'normal'
        pdf.setFontSize(11); // Set font size back to what it was
        pdf.setLineWidth(0.3);
        pdf.rect(10, 30, 190, 298); 
      }
    };
  
    const addFooter = () => {
      if (currentPage === 2) {
        
      } else {
        // Footer for Page 2 and beyond
        pdf.setFontSize(8.5);
        pdf.setFont('TimesNewRoman', 'bold');
  
        pdf.setLineWidth(0.5);
        pdf.line(17, 335, 193, 335); // Footer line extending further
  
        pdf.setFont('times', 'bold');
        pdf.text('DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH', 105, 340, { align: 'center' });
      }
    };
  
    // DSWD logo
    const imgData = '/images/headerlogo2.png';
    pdf.addImage(imgData, 'PNG', 10, 1, 70, 30);
  
  
    // Add title and header text
    pdf.setFontSize(10);
    pdf.setFont('arialbd', 'bold'); 
    pdf.text('PROTECTIVE SERVICES DIVISION', 150, 12, { align: 'center' });
  
    pdf.text('REGIONAL REHABILITATION CENTER FOR YOUTH FOR XI', 150, 17, { align: 'center' });
  
    pdf.setFontSize(10);
    pdf.text('DSWD-GF-010 | REV 02 | 12 SEP 2023', 150, 22, { align: 'center' });
  
    let contentYPos = 17;
  
    pdf.setFontSize(14);
    pdf.setFont('arialbd', 'bold'); 
    pdf.text('INDIVIDUAL PERFORMANCE OBSERVATION REPORT', 105, 36, { align: 'center' });
  
  
    pdf.setFillColor(173, 216, 230); // Light blue color (adjust if necessary)
    pdf.rect(10, 38, 190, 6, 'F');
    
    contentYPos +=25;
    pdf.setFontSize(11);
    pdf.text(`For the Period: ${this.form.period || ''}`, initialX+60, contentYPos);
    pdf.line(98, contentYPos+1, 140,contentYPos+1);
  
    contentYPos +=10;
    pdf.setFontSize(11);
    pdf.text(`NAME OF RESIDENT: ${this.form.name || ''}`, initialX, contentYPos);
    pdf.line(52, contentYPos+1, 125,contentYPos+1);
    pdf.text(`DATE OF ASSESSMENT: ${this.form.assessment_date || ''}`, initialX+120, contentYPos);
    pdf.line(177, contentYPos+1, 200,contentYPos+1);
  
    contentYPos +=8;
    pdf.setFontSize(10);
    pdf.text(`TRAININGS ATTENDED FOR THE MONTH: ${this.form.trainings_attended || ''}`, initialX, contentYPos);
    pdf.line(83, contentYPos+1, 190,contentYPos+1);
  
    pdf.setFillColor(173, 216, 230); // Light blue color (adjust if necessary)
    pdf.rect(10, 65, 190, 6, 'F');
  
    
    contentYPos +=10;
    pdf.setFontSize(12);
    pdf.text(`SCALE OF MEASUREMENT`, initialX+65, contentYPos);
  
    contentYPos +=5;
    pdf.setFontSize(9);
    pdf.text(`4 - PIRMI GINABUHAT (ALWAYS)`, initialX+10, contentYPos);
    pdf.text(`2 - KUNG GANAHAN LANG GINABUHAT (SELDOM)`, initialX+105, contentYPos);
    contentYPos +=5;
    pdf.text(`3 - USAHAY RA GINABUHAT (SOMETIMES)`, initialX+10, contentYPos);
    pdf.text(`1 - WALA JUD GIBUHAT (NEVER)`, initialX+105, contentYPos);
  
  
  
    pdf.setFillColor(189, 225, 165); // Light green color (adjust if necessary)
  
    pdf.rect(124, 83, 35, 11, 'F');
    
    contentYPos +=13;
    pdf.setFontSize(11);
    pdf.text(`INDICATORS`, initialX+45, contentYPos);
  
    pdf.setFontSize(8);
    pdf.text(`Self-Ra`, initialX+114, contentYPos+-5);
    pdf.text(`ting`, initialX+116, contentYPos+-2);
    pdf.text(`MDO's`, initialX+127, contentYPos+-5);
    pdf.text(`Rating`, initialX+127, contentYPos+-2);
    pdf.text(`TOTAL `, initialX+138, contentYPos+-7);
    pdf.text(`RATIN`, initialX+138, contentYPos+-3);
    pdf.text(`G`, initialX+141, contentYPos);
  
  
    
    pdf.setFontSize(11);
    pdf.text(`REMARKS`, initialX+158, contentYPos);
  
  
    pdf.setLineWidth(0.3);
    pdf.setFillColor(173, 216, 230); // Light blue color (adjust if necessary)
    pdf.rect(10, 94, 190, 6, 'F');
    pdf.line(initialX+-1, contentYPos+1, 200,contentYPos+1);
    contentYPos +=6;
    pdf.setFontSize(11);
    pdf.text(`A. PERSONALITY/BEHAVIOR`, initialX, contentYPos);
  
    contentYPos +=6;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`1`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Maayo ug batasan ug disiplinado.`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Well mannered and disciplined)`, initialX+58, contentYPos+-1);
  
  pdf.text(`${this.form.sections[0].indicators[0].self_rating || ''}`, initialX+58 + 60, contentYPos-1);
  pdf.text(`${this.form.sections[0].indicators[0].mdo_rating || ''}`, initialX+70 + 60, contentYPos-1);
  pdf.text(`${this.calculateTotalRating(this.form.sections[0].indicators[0]) || ''}`, initialX+140, contentYPos-1);
  
  const remarks = this.form.sections[0].remarks || '';
  const remarksLines = pdf.splitTextToSize(remarks, 40); // Wrap the text to fit within 40 units of width
  const limitedRemarksLines = remarksLines.slice(0, maxLines);
  pdf.text(limitedRemarksLines, initialX + 149, contentYPos - 1);
  
  
  
  
    contentYPos +=5;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`2`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Makahimo ug maayong aksyon ug desisyon sa mga dili maayong`, initialX+4, contentYPos+-1);
    pdf.text(`sitwasyon.`, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`(He acts appropriately in any given situation)`, initialX+23, contentYPos+3);
  
    pdf.text(`${this.form.sections[0].indicators[1].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[0].indicators[1].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[0].indicators[1]) || ''}`, initialX+140, contentYPos);
  
  
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`3`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Mohatag ug inspirasyon ug mopadasig sa kaubang residente nga`, initialX+4, contentYPos+-1);
    pdf.text(`malipayon.`, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`(He can inspire and motivate co-residents to be happy).`, initialX+24, contentYPos+3);
  
    pdf.text(`${this.form.sections[0].indicators[2].self_rating || ''}`, initialX+58 + 60, contentYPos+1);
  pdf.text(`${this.form.sections[0].indicators[2].mdo_rating || ''}`, initialX+70 + 60, contentYPos+1);
  pdf.text(`${this.calculateTotalRating(this.form.sections[0].indicators[2]) || ''}`, initialX+140, contentYPos+1);
  
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`4`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Makabarug ug makatindog sa kaugalingon sa mga dili maayong`, initialX+4, contentYPos+-1);
    pdf.text(`sitwason.`, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Carry himself well in any given situation).`, initialX+24, contentYPos+3);
  
    pdf.text(`${this.form.sections[0].indicators[3].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[0].indicators[3].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[0].indicators[3]) || ''}`, initialX+140, contentYPos);
  
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`5`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Naay kaisog nga mopadayag sa kaugalingon`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Has confidence in`, initialX+74, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(` expressing himself).`, initialX+3, contentYPos+3);
  
    pdf.text(`${this.form.sections[0].indicators[4].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[0].indicators[4].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[0].indicators[4]) || ''}`, initialX+140, contentYPos);
  
  
  
  
    pdf.line(124, 83, 124, 145); 
    pdf.line(136, 83, 136, 145); 
    pdf.line(148, 83, 148, 145); 
    pdf.line(159, 83, 159, 145); 
  
    pdf.line(10, 83, 200, 83); 
    pdf.line(10, 106, 159, 106); 
    pdf.line(10, 115, 159, 115); 
    pdf.line(10, 124, 159, 124); 
    pdf.line(10, 133, 159, 133); 
  
  
  
    pdf.setLineWidth(0.3);
    pdf.setFillColor(173, 216, 230); // Light blue color (adjust if necessary)
    pdf.rect(10, 141, 190, 6, 'F');
    pdf.line(initialX+-1, contentYPos+4, 200,contentYPos+4);
    contentYPos +=8;
    pdf.setFontSize(11);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`B. PERSONAL RELATIONSHIP`, initialX, contentYPos+1);
    pdf.text(`SUB-TOTAL  ${this.calculateSubTotal(this.form.sections[0].indicators) || ''}`, initialX+114, contentYPos+1);
  
  
    contentYPos +=7;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`1`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Makighalobilo ug makigdait sa ubang residente, staff ug mga trainer.`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Can relate appropriately with co-residents, staff and trainers).`, initialX+4, contentYPos+3);
  
    pdf.text(`${this.form.sections[1].indicators[0].self_rating || ''}`, initialX+58 + 60, contentYPos-1);
  pdf.text(`${this.form.sections[1].indicators[0].mdo_rating || ''}`, initialX+70 + 60, contentYPos-1);
  pdf.text(`${this.calculateTotalRating(this.form.sections[1].indicators[0]) || ''}`, initialX+140, contentYPos-1);
  
  const remarks1 = this.form.sections[1].remarks || '';
  const remarks1Lines = pdf.splitTextToSize(remarks1, 40); // Wrap the text to fit within 40 units of width
  const limitedRemarks1Lines = remarks1Lines.slice(0, maxLines+5);
  pdf.text(limitedRemarks1Lines, initialX + 149, contentYPos - 1);
  
  
  
    
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`2`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Makadala ug makadasig sa ubang residente sa paghimo sa ilang mga`, initialX+4, contentYPos+-1);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`buluhaton`, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Can lead and motivate co-residents to do assigned tasks).`, initialX+22, contentYPos+3);
  
  
    pdf.text(`${this.form.sections[1].indicators[1].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[1].indicators[1].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[1].indicators[1]) || ''}`, initialX+140, contentYPos);
  
  
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`3`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Masaligan ug masandigan sa tanang higayon.`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Dependable in any`, initialX+74, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`given situation).`, initialX+4, contentYPos+3);
  
  
    pdf.text(`${this.form.sections[1].indicators[2].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[1].indicators[2].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[1].indicators[2]) || ''}`, initialX+140, contentYPos);
  
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`4`, initialX, contentYPos+3);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Andam nga makat-on pinaagi sa pagpaminaw, pagpangutana sa wala`, initialX+4, contentYPos+-1);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`nasabtan ngadto sa mga trainor.`, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Has the willingness to learn by`, initialX+55, contentYPos+3);
    pdf.text(`listening, asking questions/clarify concerns with trainer).`, initialX+4, contentYPos+7);
  
  
  
  
    pdf.text(`${this.form.sections[1].indicators[3].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[1].indicators[3].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[1].indicators[3]) || ''}`, initialX+140, contentYPos);
  
  
    contentYPos +=13;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`5`, initialX, contentYPos+3);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Dili moapil sa mga dili maayo nga buhat ug panghitabo sa`, initialX+4, contentYPos+-1);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`training.`, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Non-involvement in any untoward incident that may occur during`, initialX+18, contentYPos+3);
    pdf.text(`the training).`, initialX+4, contentYPos+7);
  
  
    pdf.text(`${this.form.sections[1].indicators[4].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[1].indicators[4].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[1].indicators[4]) || ''}`, initialX+140, contentYPos);
  
  
    pdf.line(124, 141, 124, 202); 
    pdf.line(136, 147, 136, 202); 
    pdf.line(148, 141, 148, 202); 
    pdf.line(159, 141, 159, 202); 
  
    pdf.line(10, 156, 159, 156); 
    pdf.line(10, 165, 159, 165); 
    pdf.line(10, 175, 159, 175); 
    pdf.line(10, 188, 159, 188); 
  
  
  
  
  
  
    pdf.setLineWidth(0.3);
    pdf.setFillColor(173, 216, 230); // Light blue color (adjust if necessary)
    pdf.rect(10, 200, 190, 6, 'F');
    pdf.line(initialX+-1, contentYPos+8, 200,contentYPos+8);
    contentYPos +=11;
    pdf.setFontSize(11);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`C. KNOWLEDGE`, initialX, contentYPos+1);
    pdf.text(`SUB-TOTAL  ${this.calculateSubTotal(this.form.sections[1].indicators) || ''}`, initialX+114, contentYPos+1);
  
    contentYPos +=7;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`1`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Naay pamaagi nga madugangan ang talento.`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Has the initiative to`, initialX+73, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`improve his given skills and talents)`, initialX+4, contentYPos+3);
  
  
  
    
    pdf.text(`${this.form.sections[2].indicators[0].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[2].indicators[0].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[2].indicators[0]) || ''}`, initialX+140, contentYPos);
  
  const remarks2 = this.form.sections[2].remarks || '';
  const remarks2Lines = pdf.splitTextToSize(remarks2, 40); // Wrap the text to fit within 40 units of width
  const limitedRemarks2Lines = remarks2Lines.slice(0, maxLines+5);
  pdf.text(limitedRemarks2Lines, initialX + 149, contentYPos - 1);
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`2`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Nagpakita ug katakus nga mahatag ang pinakamaayo sa gihatag nga`, initialX+4, contentYPos+-1);
    pdf.setFont('arialbd', 'bold');
    pdf.text(` trabaho.`, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Has shown his best in any given tasks).`, initialX+19, contentYPos+3);
  
  
    pdf.text(`${this.form.sections[2].indicators[1].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[2].indicators[1].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[2].indicators[1]) || ''}`, initialX+140, contentYPos);
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`3`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Nagpaambit sa talento para mahatag ang pinakamaayong resulta`, initialX+4, contentYPos+-1);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`para sa aktibidad.`, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Share his talent for best results on a given activity).`, initialX+30, contentYPos+3);
  
  
    pdf.text(`${this.form.sections[2].indicators[2].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[2].indicators[2].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[2].indicators[2]) || ''}`, initialX+140, contentYPos);
  
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`4`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Naay kapasidad nga motudlo sa mga kauban sa mga butang nga`, initialX+4, contentYPos+-1);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`makapalambo ug mapagawas ang pinakamaayo.`, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Has the capacity to`, initialX+79, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`teach his co-residents on things that will improve and show their best in a`, initialX+4, contentYPos+7);
    pdf.setFont('arial', 'normal');
    pdf.text(`given situation).`, initialX+4, contentYPos+11);
  
  
  
    pdf.text(`${this.form.sections[2].indicators[3].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[2].indicators[3].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[2].indicators[3]) || ''}`, initialX+140, contentYPos);
  
  
    contentYPos +=17;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`5`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Padayon sa pagsulay sa mga maayong butang nga makapalambo sa `, initialX+4, contentYPos+-1);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`mga nakat-unan.`, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Continue to try new things that will increase and`, initialX+33, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`and improve his learnings).`, initialX+4, contentYPos+7);
  
    pdf.text(`${this.form.sections[2].indicators[4].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[2].indicators[4].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[2].indicators[4]) || ''}`, initialX+140, contentYPos);
  
  
    pdf.line(124, 200, 124, 267); 
    pdf.line(136, 206, 136, 267); 
    pdf.line(148, 200, 148, 267); 
    pdf.line(159, 200, 159, 267); 
  
    pdf.line(10, 215, 159, 215); 
    pdf.line(10, 224, 159, 224); 
    pdf.line(10, 233, 159, 233); 
    pdf.line(10, 250, 159, 250); 
  
  
  
    pdf.setLineWidth(0.3);
    pdf.setFillColor(173, 216, 230); // Light blue color (adjust if necessary)
    pdf.rect(10, 262, 190, 6, 'F');
    pdf.line(initialX+-1, contentYPos+8, 200,contentYPos+8);
    contentYPos +=11;
    pdf.setFontSize(11);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`D. SKILLS:`, initialX, contentYPos+1);
    pdf.text(`SUB-TOTAL  ${this.calculateSubTotal(this.form.sections[2].indicators) || ''}`, initialX+114, contentYPos+1);
  
  
    contentYPos +=8;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`1`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Naay kapasidad nga mohimo sa mga butang nga magpakita sa mga`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`talento.`, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Has inherent capacity to be creative).`, initialX+20, contentYPos+3);
  
  
  
    pdf.text(`${this.form.sections[3].indicators[0].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[3].indicators[0].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[3].indicators[0]) || ''}`, initialX+140, contentYPos);
  
  const remarks3 = this.form.sections[3].remarks || '';
  const remarks3Lines = pdf.splitTextToSize(remarks3, 40); // Wrap the text to fit within 40 units of width
  const limitedRemarks3Lines = remarks3Lines.slice(0, maxLines+4);
  pdf.text(limitedRemarks3Lines, initialX + 149, contentYPos - 1);
  
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`2`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Paggamit sa mga skills nga nakat-unan sa pagbuhat sa mga aktibidad`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`nga makatabang.`, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Utilizes his skills appropriately on beneficial activity).`, initialX+30, contentYPos+3);
  
  
    pdf.text(`${this.form.sections[3].indicators[1].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[3].indicators[1].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[3].indicators[1]) || ''}`, initialX+140, contentYPos);
  
  
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`3`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Naningkamot nga mapakita ang pinakamaayo nga nakat-unan pinaagi`, initialX+4, contentYPos+-1);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`sa pag-apil sa mga kalihukan.`, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Tries his best to be progressive on`, initialX+55, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`acquired skills in the different activities).`, initialX+4, contentYPos+7);
  
    pdf.text(`${this.form.sections[3].indicators[2].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[3].indicators[2].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[3].indicators[2]) || ''}`, initialX+140, contentYPos);
  
  
  
    contentYPos +=13;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`4`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Moapil sa mga kalihukan sa pagtabang sa mga trainor para magamit`, initialX+4, contentYPos+-1);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`ang tanang oras sa mga residente.`, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Participates in activities that will `, initialX+55, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`assist the trainer in maximizing resident time at the center).`, initialX+4, contentYPos+7);
  
    
    pdf.text(`${this.form.sections[3].indicators[3].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[3].indicators[3].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[3].indicators[3]) || ''}`, initialX+140, contentYPos);
  
  
    contentYPos +=13;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`5`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Dali lang makat-on sa mga programa sa pagpalambo nga gitudlo.`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Learns easily on productive endeavor taught to him).     `, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
  
  
    pdf.text(`${this.form.sections[3].indicators[4].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[3].indicators[4].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[3].indicators[4]) || ''}`, initialX+140, contentYPos);
  
  
  
  
    pdf.setLineWidth(0.3);
    pdf.rect(10, 30, 190, 298); 
  
  
    pdf.setLineWidth(0.3);
    pdf.setFillColor(173, 216, 230); // Light blue color (adjust if necessary)
    pdf.rect(10, 322, 190, 6, 'F');
  
    pdf.line(124, 262, 124, 328); 
    pdf.line(136, 268, 136, 322); 
    pdf.line(148, 262, 148, 328); 
    pdf.line(159, 262, 159, 328); 
  
    pdf.line(10, 277, 159, 277); 
    pdf.line(10, 287, 159, 287); 
    pdf.line(10, 300, 159, 300); 
    pdf.line(10, 313, 159, 313); 
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`SUB-TOTAL  ${this.calculateSubTotal(this.form.sections[3].indicators) || ''}`, initialX+114, contentYPos+1);
  
  
        // Footer for Page 1
        pdf.setFontSize(9);
        pdf.setFont('TimesNewRoman', 'bold');
        pdf.setLineWidth(0.5);
        pdf.line(17, 335, 173, 335); // Footer line
  
        pdf.setFont('times', 'normal');
        const footerText = pdf.splitTextToSize('DSWD FOXI, Regional Rehabilitation Center for Youth, Bago Oshiro, Davao City, Philippines 8000', 160);
        pdf.text(footerText, 95, 340, { align: 'center' });
        pdf.text('Email:rrcy.fo11.dswd.gov.ph; Tel No.(082) 293-0306', 105, 345, { align: 'center' });
  
        const footerImgData = '/images/footerimg.png';
        pdf.addImage(footerImgData, 'PNG', 175, 330, 25, 12); // Footer image
  
    pdf.addPage();
  
    pdf.setLineWidth(0.3);
    pdf.rect(10, 30, 190, 298); 
  
    pdf.setFont('TimesNewRoman', 'italic'); // Set font style to italic
    pdf.text('DSWD-GF-010 | REV 02 | 17 AUG 2022', 135, 20);
  
  
    contentYPos =35;
    pdf.setFontSize(11);
    pdf.setFont('arialbd', 'bold'); // Set font style to italic
    pdf.text(`NAME OF RESIDENT: ${this.form.name || ''}`, initialX+1, contentYPos);
    pdf.line(52, contentYPos+1, 125,contentYPos+1);
    pdf.text(`DATE OF ASSESSMENT: ${this.form.assessment_date || ''}`, initialX+120, contentYPos);
    pdf.line(177, contentYPos+1, 200,contentYPos+1);
  
    pdf.setLineWidth(0.3);
    pdf.setFillColor(173, 216, 230); // Light blue color (adjust if necessary)
    pdf.rect(10, 39, 190, 6, 'F');
    pdf.line(initialX+-1, contentYPos+4, 200,contentYPos+4);
    contentYPos +=7;
    pdf.setFontSize(11);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`E. ATTITUDE:`, initialX, contentYPos+1);
  
  
    contentYPos +=8;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`1`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Wala mosupak sa mga polisiya sa training sa tanang higayon.`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(He`, initialX+98, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`abides with policies of the training at all times).`, initialX+4, contentYPos+3);
  
    pdf.text(`${this.form.sections[4].indicators[0].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[4].indicators[0].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[4].indicators[0]) || ''}`, initialX+140, contentYPos);
  
  
  const remarks4 = this.form.sections[4].remarks || '';
  const remarks4Lines = pdf.splitTextToSize(remarks4, 40); // Wrap the text to fit within 40 units of width
  const limitedRemarks4Lines = remarks4Lines.slice(0, maxLines+2);
  pdf.text(limitedRemarks4Lines, initialX + 149, contentYPos - 1);
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`2`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Mosunod ug motuman sa mga tudlo sa gihatag nga trabaho.`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(He `, initialX+96, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`follows instructions on given tasks).`, initialX+4, contentYPos+3);
  
  
    
    pdf.text(`${this.form.sections[4].indicators[1].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[4].indicators[1].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[4].indicators[1]) || ''}`, initialX+140, contentYPos);
  
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`3`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Parehas nga pagtagad sa mga kaubang residente.   `, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Treats his co-residents fairly).`, initialX+4, contentYPos+3);
  
  
    
    pdf.text(`${this.form.sections[4].indicators[2].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[4].indicators[2].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[4].indicators[2]) || ''}`, initialX+140, contentYPos);
  
  
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`4`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Maayong ihimplo sa tanang higayon.`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(He is a peacemaker at all times).`, initialX+4, contentYPos+3);
  
  
    pdf.text(`${this.form.sections[4].indicators[3].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[4].indicators[3].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[4].indicators[3]) || ''}`, initialX+140, contentYPos);
  
  
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`5`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Makabalanse sa tanang mga pagsulay ug kalisud.`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Can cope up with challenges and difficulties).`, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
  
  
  
    
    pdf.text(`${this.form.sections[4].indicators[4].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[4].indicators[4].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[4].indicators[4]) || ''}`, initialX+140, contentYPos);
  
  
    pdf.line(124, 45, 124, 95); 
    pdf.line(136, 45, 136, 95); 
    pdf.line(148, 45, 148, 95); 
    pdf.line(159, 45, 159, 95); 
  
    pdf.line(10, 54, 159, 54); 
    pdf.line(10, 63, 159, 63); 
    pdf.line(10, 72, 159, 72); 
  pdf.line(10, 82, 159, 82); 
    
  
    pdf.setLineWidth(0.3);
    pdf.setFillColor(173, 216, 230); // Light blue color (adjust if necessary)
    pdf.rect(10, 90, 190, 6, 'F');
    pdf.line(initialX+-1, contentYPos+4, 200,contentYPos+4);
    contentYPos +=7;
    pdf.setFontSize(11);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`F. RESPONSES TO SITUATIONS:`, initialX, contentYPos+1);
    pdf.text(`SUB-TOTAL  ${this.calculateSubTotal(this.form.sections[4].indicators) || ''}`, initialX+114, contentYPos+1);
  
    contentYPos +=8;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`1`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Dili moreklamo sa mga wala giplano nga kabag-uhan.`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Never complains on unexpected changes/result of a group tasks.)`, initialX+4, contentYPos+3);
  
  
    pdf.text(`${this.form.sections[5].indicators[0].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[5].indicators[0].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[5].indicators[0]) || ''}`, initialX+140, contentYPos);
  
  const remarks5 = this.form.sections[5].remarks || '';
  const remarks5Lines = pdf.splitTextToSize(remarks5, 40); // Wrap the text to fit within 40 units of width
  const limitedRemarks5Lines = remarks5Lines.slice(0, maxLines+3);
  pdf.text(limitedRemarks5Lines, initialX + 149, contentYPos - 1);
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`2`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Inanay/plastar sa iyang plano ug mga desisyon.`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Gentle in his actions/decisions.)`, initialX+4, contentYPos+3);
  
  
    pdf.text(`${this.form.sections[5].indicators[1].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[5].indicators[1].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[5].indicators[1]) || ''}`, initialX+140, contentYPos);
  
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`3`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Makadala sa mga bug-at/challenging nga buhat.`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Can handle challenging tasks.)`, initialX+4, contentYPos+3);
  
  
    pdf.text(`${this.form.sections[5].indicators[2].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[5].indicators[2].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[5].indicators[2]) || ''}`, initialX+140, contentYPos);
  
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`4`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Makaplano ug maayo sa mga moabot nga sitwasyon.`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Can think appropriately in any given situation.)`, initialX+4, contentYPos+3);
  
    
    pdf.text(`${this.form.sections[5].indicators[3].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[5].indicators[3].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[5].indicators[3]) || ''}`, initialX+140, contentYPos);
  
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`5`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Dili makiglalis sa mga kaubang residente ug trainor para dili`, initialX+4, contentYPos+-1);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`makahimo ug kagubot.`, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Never argues with co-residents and trainor to`, initialX+39, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`create conflict.)`, initialX+4, contentYPos+7);
  
  
    
    pdf.text(`${this.form.sections[5].indicators[4].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[5].indicators[4].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[5].indicators[4]) || ''}`, initialX+140, contentYPos);
  
  
    pdf.line(124, 90, 124, 150);
    pdf.line(136, 96, 136, 150);
    pdf.line(148, 90, 148, 150);
    pdf.line(159, 90, 159, 150); 
  
  pdf.line(10, 105, 159, 105); 
  pdf.line(10, 115, 159, 115); 
  pdf.line(10, 124, 159, 124); 
  pdf.line(10, 133, 159, 133); 
  
  
    pdf.setLineWidth(0.3);
    pdf.setFillColor(173, 216, 230); // Light blue color (adjust if necessary)
    pdf.rect(10, 146, 190, 6, 'F');
    pdf.line(initialX+-1, contentYPos+9, 200,contentYPos+9);
    contentYPos +=12;
    pdf.setFontSize(11);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`G. LIFE'S ASPIRATIONS:`, initialX, contentYPos+1);
    pdf.text(`SUB-TOTAL  ${this.calculateSubTotal(this.form.sections[5].indicators) || ''}`, initialX+114, contentYPos+1);
  
    contentYPos +=8;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`1`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Andam makat-on sa mga kabag-ohan.`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Willingness to learn new things.)`, initialX+62, contentYPos+-1);
  
  
  
  
    pdf.text(`${this.form.sections[6].indicators[0].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[6].indicators[0].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[6].indicators[0]) || ''}`, initialX+140, contentYPos);
  
  
  const remarks6 = this.form.sections[6].remarks || '';
  const remarks6Lines = pdf.splitTextToSize(remarks6, 40); // Wrap the text to fit within 40 units of width
  const limitedRemarks6Lines = remarks6Lines.slice(0, maxLines+1);
  pdf.text(limitedRemarks6Lines, initialX + 149, contentYPos - 1);
  
  
    contentYPos +=6;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`2`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Naghatag ug importansya sa pag-skwela.`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Values the importance of `, initialX+67, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`education.)`, initialX+4, contentYPos+3);
  
  
    pdf.text(`${this.form.sections[6].indicators[1].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[6].indicators[1].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[6].indicators[1]) || ''}`, initialX+140, contentYPos);
  
    contentYPos +=8;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`3`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Nagatoo nga ang pagbaton ug disiplina sa kaugalingon makapabag-o`, initialX+4, contentYPos+-1);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`sa kinabuhi. `, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Believes having discipline can change his life.)`, initialX+23, contentYPos+3);
  
  
  
    pdf.text(`${this.form.sections[6].indicators[2].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[6].indicators[2].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[6].indicators[2]) || ''}`, initialX+140, contentYPos);
  
    contentYPos +=9;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`4`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Nagatoo sa gahum sa pag-atiman sa ginoo.`, initialX+4, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Believes in the power of`, initialX+71, contentYPos+-1);
    pdf.setFont('arial', 'normal');
    pdf.text(`the caring God.)`, initialX+4, contentYPos+3);
  
  
  
    pdf.text(`${this.form.sections[6].indicators[3].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[6].indicators[3].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[6].indicators[3]) || ''}`, initialX+140, contentYPos);
  
  
    contentYPos +=8;
    pdf.setFontSize(11);
    pdf.setFont('arial', 'normal');
    pdf.text(`5`, initialX, contentYPos);
    pdf.setFontSize(9);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`Nagatoo nga ang maayong pamatasan makatabang nga mapalambo`, initialX+4, contentYPos+-1);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`ang kaugalingon nga kakayahan.`, initialX+4, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`(Believes that good character qualities`, initialX+55, contentYPos+3);
    pdf.setFont('arial', 'normal');
    pdf.text(`will help him develop his potentials.)`, initialX+4, contentYPos+7);
  
  
    pdf.text(`${this.form.sections[6].indicators[4].self_rating || ''}`, initialX+58 + 60, contentYPos);
  pdf.text(`${this.form.sections[6].indicators[4].mdo_rating || ''}`, initialX+70 + 60, contentYPos);
  pdf.text(`${this.calculateTotalRating(this.form.sections[6].indicators[4]) || ''}`, initialX+140, contentYPos);
  
  
  
    pdf.line(124, 146, 124, 200); 
    pdf.line(136, 152, 136, 200); 
    pdf.line(148, 146, 148, 200); 
    pdf.line(159, 146, 159, 200); 
  
  pdf.line(10, 158, 159, 158); 
  pdf.line(10, 167, 159, 167); 
  pdf.line(10, 175, 159, 175); 
  pdf.line(10, 184, 159, 184); 
  
  
    pdf.setLineWidth(0.3);
    pdf.setFillColor(173, 216, 230); // Light blue color (adjust if necessary)
    pdf.rect(10, 197, 190, 6, 'F');
    pdf.line(initialX+-1, contentYPos+9, 200,contentYPos+9);
  
    pdf.setLineWidth(0.3);
    pdf.setFillColor(191, 150, 227);
    pdf.rect(10, 203, 190, 6, 'F');
    pdf.line(initialX+-1, contentYPos+15, 200,contentYPos+15);
  
    contentYPos +=12;
    pdf.setFontSize(11);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`SUB-TOTAL  ${this.calculateSubTotal(this.form.sections[6].indicators) || ''}`, initialX+114, contentYPos+1);
  
    contentYPos +=6;
    pdf.setFontSize(11);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`OVER-ALL RATING`, initialX+5, contentYPos+1);
    pdf.text(`  ${this.calculateOverallRating().overall || ''}`, initialX+112, contentYPos+1);
  
    contentYPos +=6;
    pdf.setFontSize(11);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`ADJECTIVAL RATING:`, initialX+5, contentYPos+1);
  
  
  
    contentYPos +=7;
    pdf.setFontSize(9);
    pdf.text(`4 - Points - Excellent/Full cooperation and proper physical`, initialX+5, contentYPos);
    pdf.text(`condition`, initialX+5, contentYPos+3);
    pdf.text(`2 - 2.99 Points  - Needs Improvement/`, initialX+105, contentYPos);
    pdf.text(`Complies with the request to cooperate`, initialX+105, contentYPos+3);
    contentYPos +=8;
    pdf.text(`3 - 3.99 Points  - Very Satisfactory/Appropriate behavior and`, initialX+5, contentYPos);
    pdf.text(`condition during the training`, initialX+5, contentYPos+3);
    pdf.text(`1 - 1.99 Points -  Needs Close`, initialX+105, contentYPos);
    pdf.text(`Monitoring/Problem is Prominent`, initialX+105, contentYPos+3);
  
  
    pdf.line(10, 214, 200, 214); 
    pdf.line(10, 216, 200, 216); 
    pdf.line(10, 223, 200, 223); 
   
    pdf.line(110, 214, 110, 235); 
  
  
    contentYPos +=5;
    pdf.setFillColor(233, 150, 150);
    pdf.rect(10, contentYPos, 190, 6, 'F');
    pdf.setFontSize(11);
    pdf.setFont('arialbd', 'bold');
    pdf.text(`GENERAL REMARKS/RECOMMENDATION:`, initialX+1, contentYPos+5);
  
    contentYPos += rowHeight;
    contentYPos +=6;
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(11);
    const general_remarksLog = `${this.form.general_remarks || ''}`;
    const general_remarksLogLines = pdf.splitTextToSize(general_remarksLog, maxWidth);
  
    general_remarksLogLines.forEach(line => {
      addNewPageIfNeeded(); // Check for overflow before adding a line
      pdf.text(line, initialX, contentYPos-3);
      contentYPos += lineHeight;
    });
  
  
  
  
    // Adding the header row with pink background
    pdf.setFontSize(11);
    pdf.setFillColor(233, 150, 150);
    pdf.rect(10, contentYPos, maxWidth, 6, 'F'); // Background for header
    pdf.setFont('arialbd', 'bold');
    pdf.text(`TRAININGS PREVIOUSLY ATTENDED`, initialX +1, contentYPos + 5);
    contentYPos += rowHeight;
  
    pdf.setFontSize(10);
  pdf.setFont('arialbd', 'bold');
  pdf.rect(initialX+-1, contentYPos+-2, colWidths[0], rowHeight); // No. column
  pdf.text(`No.`, initialX + 1, contentYPos + 4); // Move text left within the cell by reducing X position
  
  pdf.rect(initialX+-1 + colWidths[0], contentYPos+-2, colWidths[1], rowHeight); // Title of the Training
  pdf.text(`TITLE OF THE TRAINING`, initialX + colWidths[0] + 1, contentYPos + 4); // Move text left
  
  pdf.rect(initialX+-1 + colWidths[0] + colWidths[1], contentYPos+-2, colWidths[2], rowHeight); // Date of Attendance
  pdf.text(`DATE OF ATTENDANCE`, initialX + colWidths[0] + colWidths[1] + 1, contentYPos + 4); // Move text left
  
  pdf.rect(initialX+-1 + colWidths[0] + colWidths[1] + colWidths[2], contentYPos+-2, colWidths[3], rowHeight); // Status
  pdf.text(`STATUS`, initialX + colWidths[0] + colWidths[1] + colWidths[2] + 1, contentYPos + 4); // Move text left
  contentYPos += rowHeight;
  
  // Dynamic rows for each training
  this.form.trainings.forEach((training, index) => {
    addNewPageIfNeeded();
  
    // Draw each cell for No.
    pdf.rect(initialX+-1, contentYPos+-2, colWidths[0], rowHeight);
    pdf.text(`${index + 1}`, initialX + 1, contentYPos + 4); // Move text left
  
    // Draw each cell for Title of the Training
    pdf.rect(initialX+-1 + colWidths[0], contentYPos+-2, colWidths[1], rowHeight);
    pdf.text(`${training.title || ''}`, initialX + colWidths[0] + 1, contentYPos + 4); // Move text left
  
    // Draw each cell for Date of Attendance
    pdf.rect(initialX+-1 + colWidths[0] + colWidths[1], contentYPos+-2, colWidths[2], rowHeight);
    pdf.text(`${training.date_of_attendance || ''}`, initialX + colWidths[0] + colWidths[1] + 1, contentYPos + 4); // Move text left
  
    // Draw each cell for Status
    pdf.rect(initialX+-1 + colWidths[0] + colWidths[1] + colWidths[2], contentYPos+-2, colWidths[3], rowHeight);
    pdf.text(`${training.status || ''}`, initialX + colWidths[0] + colWidths[1] + colWidths[2] + 1, contentYPos + 4); // Move text left
  
    contentYPos += rowHeight;
  });
  
  
  contentYPos += 10;
    contentYPos += rowHeight; 
    addNewPageIfNeeded();
    
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(10);
    pdf.text('Prepared by:', initialX, contentYPos);
    pdf.text('Noted by:', initialX+120, contentYPos);
    
    contentYPos += rowHeight; 
  contentYPos += 5;
    pdf.setFont('arialbd', 'bold');
    pdf.setFontSize(11);
    pdf.text(`${this.form.prepared_by_one || ''}`, initialX+10, contentYPos);
  
  
    pdf.setFont('arialbd', 'bold');
    pdf.setFontSize(11);
    pdf.text(`${this.form.prepared_by_two || ''}`, initialX+70, contentYPos);
  
    contentYPos += 4; 
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(10);
    pdf.text('MDO I', initialX+10, contentYPos+2);
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(10);
    pdf.text('MDO II', initialX+70, contentYPos+2);
  
  
  
  
  
  
    pdf.setFont('arialbd', 'bold');
    pdf.setFontSize(11);
    pdf.text('ANGELIC B. PAÑA', initialX+140, contentYPos+-4);
    contentYPos += 5; 
    pdf.setFont('arial', 'normal');
    pdf.setFontSize(10);
    pdf.text('Center Head', initialX+140, contentYPos+-4);
  
  
  // Footer for Page 2 and beyond
  pdf.setFontSize(8.5);
        pdf.setFont('TimesNewRoman', 'bold');
  
        pdf.setLineWidth(0.5);
        pdf.line(17, 335, 193, 335); // Footer line extending further
  
        pdf.setFont('times', 'bold');
        pdf.text('DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH', 105, 340, { align: 'center' });
  
  
  
  
  
        const totalPages = pdf.internal.getNumberOfPages();
    for (let i = 1; i <= totalPages; i++) {
      pdf.setPage(i);
      pdf.setFontSize(9);
      pdf.setFont('TimesNewRoman', 'bold');
      pdf.text(`PAGE ${i} of ${totalPages}`, 105, 333, { align: 'center' }); // Update the footer with the correct total pages
    }
    // Save the PDF with dynamic file name
    pdf.save(`IOR_REPORT_${this.form.name || ''}.pdf`);
  },
    },
  };
  </script>
  
  <style scoped>
  .graph-background {
      background-image: linear-gradient(to right, #cccccc 1px, transparent 1px), 
                        linear-gradient(to bottom, #cccccc 1px, transparent 1px);
      background-size: 15px 15px; /* Adjust size as per your need */
    } 
    .underline-input {
    border: none;
    border-bottom:  1px solid black;
    padding: 0;
    width: 90%;
    margin-bottom: 14px;
    line-height: 0;
    box-sizing: border-box;
    vertical-align: bottom; /* Ensures the text aligns with the bottom of the input */
    font-size: inherit; /* Ensure consistent font size */
  }
  
  .underline-input2 {
    border: none;
    border-bottom:  1px solid black;
    padding: 1;
    margin: 0;
    line-height: -0.5;
  }
  </style>
   