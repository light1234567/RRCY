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

  <!-- Export PDF Button (commented out for now, uncomment to use) -->
  <!--
  <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 text-white rounded-md text-xs">
    <i class="fas fa-file-pdf w-4 h-4"></i>
    <span>Export PDF</span>
  </button>
  -->
</div>


    <!-- Success/Error Message -->
    <div v-if="message" :class="`mt-4 p-4 rounded text-white ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">{{ message }}</div>
    <div class="graph-background pt-0.5  -mr-9 -mb-16">



  <div v-if="currentPage === 1" class="max-w-3xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
    <!-- Header -->
    <div class="relative flex justify-between items-center mb-4">
      <img src="/images/headerlogo2.png" alt="Logo" class=" h-32 w-64 relative z-10">
      <div class="text-right">
        <p class="item-center mr-6 text-sm font-semibold">PROTECTIVE SERVICES DIVISION</p>
        <p class="text-sm font-semibold">Regional Rehabilitation Center for Youth RFO XI</p>
        <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
      </div>
    </div>
    <div class="text-center mb-4 border-b-2 border-gray-300 pb-2">
      <h1 class="text-lg font-bold">INDIVIDUAL PERFORMANCE OBSERVATION REPORT</h1>
    </div>

    <div class="flex items-center justify-center mb-6">
      <p class="text-md font-semibold mr-4">For the Period:</p>
      <input type="text" v-model="form.period" class="underline-input bg-transparent border-b-2 border-gray-300 text-center text-xs" :readonly="!editMode"/>
    </div>
      
    <!-- General Information -->
    <div class="mb-6 grid grid-cols-2 gap-4">
      <div>
        <label class="block font-bold mb-1">Name of Resident:</label>
        <input type="text" v-model="form.name" class="w-full p-2 border border-gray-300 rounded text-sm" readonly />
      </div>
      <div>
        <label class="block font-bold mb-1">Date of Assessment:</label>
        <input type="date" v-model="form.assessment_date" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode" />
      </div>
      <div class="col-span-2">
        <label class="block font-bold mb-1">Trainings Attended for the Month:</label>
        <input type="text" v-model="form.trainings_attended" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode" />
      </div>
    </div>

<!-- Scale of Measurement Section -->
 
<h4 class="text-center mb-4 border-b-2 border-gray-300 pb-2 font-bold mb-2 ">SCALE OF MEASUREMENT</h4>
      <div class="grid grid-cols-2 gap-4 text-sm">
        <div class="flex justify-between ">
          <span>4 - PIRMI GINABUHAT</span>
          <em>(ALWAYS)</em>
        </div>
        <div class="flex justify-between">
          <span>2 - KUNG GANAHAN LANG GINABUHAT</span>
          <em>(SELDOM)</em>
        </div>
        <div class="flex justify-between">
          <span>3 - USAHAY RA GINABUHAT</span>
          <em>(SOMETIMES)</em>
        </div>
        <div class="flex justify-between">
          <span>1 - WALA JUD GIBUHAT</span>
          <em>(NEVER)</em>
        </div>
      </div>


    <!-- Sections for Indicators and Remarks -->
<div class="mb-6">
  <h4 class="font-bold mb-2">INDICATORS</h4>
  <table class="w-full border-collapse border mb-4">
    <thead>
      <tr class="bg-gray-200">
        <th class="text-center p-2 border">A</th>
        <th class="text-center p-2 border">PERSONALITY/BEHAVIOR</th>
        <th class="text-center p-2 border">Self-Rating</th>
        <th class="text-center p-2 border">MDO's Rating</th>
        <th class="text-center p-2 border">Total Rating</th>
      </tr>
    </thead>
    <tbody>
      <tr >
        <td class="p-2 border text-center">1</td>
        <td class="p-2 border">Maayo ug batasan ug displinado. (Well mannered and disciplined)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[0].indicators[0].self_rating" @change="validateRating(form.sections[0].indicators[0], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[0].indicators[0].mdo_rating" @change="validateRating(form.sections[0].indicators[0], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[0].indicators[0]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">2</td>
        <td class="p-2 border">Makahimo ug maayong aksyon ug desisyon sa mga dili maayong sitwasyon. (He acts appropriately in any given situation)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[0].indicators[1].self_rating" @change="validateRating(form.sections[0].indicators[1], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[0].indicators[1].mdo_rating" @change="validateRating(form.sections[0].indicators[1], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[0].indicators[1]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">3</td>
        <td class="p-2 border">Mohatag ug inspirasyon ug mopadasig sa kaubang residente nga magmalipayon. (He can inspire and motivate co-residents to be happy)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[0].indicators[2].self_rating" @change="validateRating(form.sections[0].indicators[2], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[0].indicators[2].mdo_rating" @change="validateRating(form.sections[0].indicators[2], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[0].indicators[2]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">4</td>
        <td class="p-2 border">Makabarug ug makatidong sa kaugalingon sa mga dili maayong sitwasyon. (Carry himself well in any given situation)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[0].indicators[3].self_rating" @change="validateRating(form.sections[0].indicators[3], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[0].indicators[3].mdo_rating" @change="validateRating(form.sections[0].indicators[3], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[0].indicators[3]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">5</td>
        <td class="p-2 border">Naay kaisog nga mopadayag sa kaugalingon. (Has confidence in expressing himself)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[0].indicators[4].self_rating" @change="validateRating(form.sections[0].indicators[4], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[0].indicators[4].mdo_rating" @change="validateRating(form.sections[0].indicators[4], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[0].indicators[4]) }}</td>
      </tr>
    </tbody>
  </table>

  <!-- Sub-total and Remarks -->
  <div class="flex justify-between items-center">
    <p class="font-bold">Sub-Total: {{ calculateSubTotal(form.sections[0].indicators) }}</p>
    <div class="w-full ml-4">
      <label class="block font-bold mb-1">Remarks:</label>
      <textarea v-model="form.sections[0].remarks" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode"></textarea>
    </div>
  </div>
</div>


    <div class="mb-6">
  <table class="w-full border-collapse border mb-4">
    <thead>
      <tr class="bg-gray-200">
        <th class="text-center p-2 border">B</th>
        <th class="text-center p-2 border">PERSONAL RELATIONSHIP</th>
        <th class="text-center p-2 border">Self-Rating</th>
        <th class="text-center p-2 border">MDO's Rating</th>
        <th class="text-center p-2 border">Total Rating</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="p-2 border text-center">1</td>
        <td class="p-2 border">Makighalobilo ug makigdait sa ubang residente, staff ug mga trainer. (Can relate appropriately with co-residents, staff, and trainers)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[1].indicators[0].self_rating" @change="validateRating(form.sections[1].indicators[0], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[1].indicators[0].mdo_rating" @change="validateRating(form.sections[1].indicators[0], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[1].indicators[0]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">2</td>
        <td class="p-2 border">Makadala ug makadasig sa ubang residente sa paghimo sa ilang mga buluhaton. (Can lead and motivate co-residents to do assigned tasks)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[1].indicators[1].self_rating" @change="validateRating(form.sections[1].indicators[1], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[1].indicators[1].mdo_rating" @change="validateRating(form.sections[1].indicators[1], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[1].indicators[1]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">3</td>
        <td class="p-2 border">Masaligan ug masandigan sa tanang higayon. (Dependable in any given situation)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[1].indicators[2].self_rating" @change="validateRating(form.sections[1].indicators[2], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[1].indicators[2].mdo_rating" @change="validateRating(form.sections[1].indicators[2], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[1].indicators[2]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">4</td>
        <td class="p-2 border">Andam nga makat-on pinaagi sa pagpaminaw, pagpangutana sa wala nasabtan ngadto sa mga trainor. (Has the willingness to learn by listening, asking questions/clarify concerns with trainer)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[1].indicators[3].self_rating" @change="validateRating(form.sections[1].indicators[3], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[1].indicators[3].mdo_rating" @change="validateRating(form.sections[1].indicators[3], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[1].indicators[3]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">5</td>
        <td class="p-2 border">Dili moapil sa mga dili maayo nga buhat ug panghitabo sa sulod sa training. (Non-involvement in any untoward incident that may occur during the training)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[1].indicators[4].self_rating" @change="validateRating(form.sections[1].indicators[4], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[1].indicators[4].mdo_rating" @change="validateRating(form.sections[1].indicators[4], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[1].indicators[4]) }}</td>
      </tr>
    </tbody>
  </table>

  <!-- Sub-total and Remarks -->
  <div class="flex justify-between items-center">
    <p class="font-bold">Sub-Total: {{ calculateSubTotal(form.sections[1].indicators) }}</p>
    <div class="w-full ml-4">
      <label class="block font-bold mb-1">Remarks:</label>
      <textarea v-model="form.sections[1].remarks" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode"></textarea>
    </div>
  </div>
</div>

<div class="mb-6">
  <table class="w-full border-collapse border mb-4">
    <thead>
      <tr class="bg-gray-200">
        <th class="text-center p-2 border">C</th>
        <th class="text-center p-2 border">KNOWLEDGE</th>
        <th class="text-center p-2 border">Self-Rating</th>
        <th class="text-center p-2 border">MDO's Rating</th>
        <th class="text-center p-2 border">Total Rating</th>
      </tr>
    </thead>
    <tbody>
  <tr>
    <td class="p-2 border text-center">1</td>
    <td class="p-2 border">Naay pamaagi nga madugangan ang talento. (Has the initiative to improve his given skills and talents)</td>
    <td class="p-2 border text-center">
      <input type="number" min="0" max="4" v-model="form.sections[2].indicators[0].self_rating" @change="validateRating(form.sections[2].indicators[0], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
    </td>
    <td class="p-2 border text-center">
      <input type="number" min="0" max="4" v-model="form.sections[2].indicators[0].mdo_rating" @change="validateRating(form.sections[2].indicators[0], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
    </td>
    <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[2].indicators[0]) }}</td>
  </tr>
  <tr>
    <td class="p-2 border text-center">2</td>
    <td class="p-2 border">Nagpakita ug katakus nga mahatag ang pinakamaayo sa gihatag nga trabaho. (Has shown his best in any given tasks)</td>
    <td class="p-2 border text-center">
      <input type="number" min="0" max="4" v-model="form.sections[2].indicators[1].self_rating" @change="validateRating(form.sections[2].indicators[1], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
    </td>
    <td class="p-2 border text-center">
      <input type="number" min="0" max="4" v-model="form.sections[2].indicators[1].mdo_rating" @change="validateRating(form.sections[2].indicators[1], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
    </td>
    <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[2].indicators[1]) }}</td>
  </tr>
  <tr>
    <td class="p-2 border text-center">3</td>
    <td class="p-2 border">Nagpambit sa talento para mahatag ang pinakamaayong resulta para sa aktibidad. (Share his talent for best results on a given activity)</td>
    <td class="p-2 border text-center">
      <input type="number" min="0" max="4" v-model="form.sections[2].indicators[2].self_rating" @change="validateRating(form.sections[2].indicators[2], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
    </td>
    <td class="p-2 border text-center">
      <input type="number" min="0" max="4" v-model="form.sections[2].indicators[2].mdo_rating" @change="validateRating(form.sections[2].indicators[2], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
    </td>
    <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[2].indicators[2]) }}</td>
  </tr>
  <tr>
    <td class="p-2 border text-center">4</td>
    <td class="p-2 border">Naay kapasidad nga modutlo sa mga kauban sa mga butang nga makapalambo ug mapagawas ang pinakamaayo. (Has the capacity to teach his co-residents on things that will improve and show their best in a given situation)</td>
    <td class="p-2 border text-center">
      <input type="number" min="0" max="4" v-model="form.sections[2].indicators[3].self_rating" @change="validateRating(form.sections[2].indicators[3], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
    </td>
    <td class="p-2 border text-center">
      <input type="number" min="0" max="4" v-model="form.sections[2].indicators[3].mdo_rating" @change="validateRating(form.sections[2].indicators[3], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
    </td>
    <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[2].indicators[3]) }}</td>
  </tr>
  <tr>
    <td class="p-2 border text-center">5</td>
    <td class="p-2 border">Padayon sa pagsulay sa mga maayong butang nga makapalambo sa mga nakat-unan. (Continue to try new things that will increase and improve his learnings)</td>
    <td class="p-2 border text-center">
      <input type="number" min="0" max="4" v-model="form.sections[2].indicators[4].self_rating" @change="validateRating(form.sections[2].indicators[4], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
    </td>
    <td class="p-2 border text-center">
      <input type="number" min="0" max="4" v-model="form.sections[2].indicators[4].mdo_rating" @change="validateRating(form.sections[2].indicators[4], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
    </td>
    <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[2].indicators[4]) }}</td>
  </tr>
</tbody>

  </table>

  <!-- Sub-total and Remarks -->
  <div class="flex justify-between items-center">
    <p class="font-bold">Sub-Total: {{ calculateSubTotal(form.sections[2].indicators) }}</p>
    <div class="w-full ml-4">
      <label class="block font-bold mb-1">Remarks:</label>
      <textarea v-model="form.sections[2].remarks" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode"></textarea>
    </div>
  </div>
</div>


<div class="mb-6">
  <table class="w-full border-collapse border mb-4">
    <thead>
      <tr class="bg-gray-200">
        <th class="text-center p-2 border">D</th>
        <th class="text-center p-2 border">SKILLS</th>
        <th class="text-center p-2 border">Self-Rating</th>
        <th class="text-center p-2 border">MDO's Rating</th>
        <th class="text-center p-2 border">Total Rating</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="p-2 border text-center">1</td>
        <td class="p-2 border">Naay kapasidad nga mohimo sa mga butang nga magpakita sa mga talento. (Has inherent capacity to be creative)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[3].indicators[0].self_rating" @change="validateRating(form.sections[3].indicators[0], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[3].indicators[0].mdo_rating" @change="validateRating(form.sections[3].indicators[0], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[3].indicators[0]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">2</td>
        <td class="p-2 border">Pagamit sa mga skills nga nakat-unan sa pagbuhat sa mga aktibidad nga makatabang. (Utilizes his skills appropriately on beneficial activity)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[3].indicators[1].self_rating" @change="validateRating(form.sections[3].indicators[1], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[3].indicators[1].mdo_rating" @change="validateRating(form.sections[3].indicators[1], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[3].indicators[1]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">3</td>
        <td class="p-2 border">Naningkamot nga mapakita ang pinakamaayo nga nakat-unan pinaagi sa pag-apil sa mga kalihukan. (Tries his best to be progressive on acquired skills in the different activities)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[3].indicators[2].self_rating" @change="validateRating(form.sections[3].indicators[2], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[3].indicators[2].mdo_rating" @change="validateRating(form.sections[3].indicators[2], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[3].indicators[2]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">4</td>
        <td class="p-2 border">Moapil sa mga kalihukan sa pagtabang sa mga trainor para magamit ang tanang oras sa mga residente. (Participates in activities that will assist the trainer in maximizing resident time at the center)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[3].indicators[3].self_rating" @change="validateRating(form.sections[3].indicators[3], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[3].indicators[3].mdo_rating" @change="validateRating(form.sections[3].indicators[3], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[3].indicators[3]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">5</td>
        <td class="p-2 border">Dali lang makakat-on sa mga programa sa pagpalambo nga gitudlo. (Learns easily on productive endeavors taught to him)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[3].indicators[4].self_rating" @change="validateRating(form.sections[3].indicators[4], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[3].indicators[4].mdo_rating" @change="validateRating(form.sections[3].indicators[4], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[3].indicators[4]) }}</td>
      </tr>
    </tbody>
  </table>

  <!-- Sub-total and Remarks -->
  <div class="flex justify-between items-center">
    <p class="font-bold">Sub-Total: {{ calculateSubTotal(form.sections[3].indicators) }}</p>
    <div class="w-full ml-4">
      <label class="block font-bold mb-1">Remarks:</label>
      <textarea v-model="form.sections[3].remarks" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode"></textarea>
    </div>
  </div>
</div>

    <div class="border-gray-300 ml-6 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
        <div class="flex justify-between items-center">
          <div class="flex flex-col">
            <p class="ml-24 -mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
            <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
            <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrcy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
          </div>
          <div class="ml-4">
            <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
          </div>
        </div>
      </div>
  </div>



  <div v-if="currentPage === 2" class="max-w-3xl p-8 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">

    <!-- General Information -->
    <div class="mb-6 grid grid-cols-2 gap-4">
      <div>
        <label class="block font-bold mb-1">Name of Resident:</label>
        <input type="text" v-model="form.name" class="w-full p-2 border border-gray-300 rounded text-sm" readonly />
      </div>
      <div>
        <label class="block font-bold mb-1">Date of Assessment:</label>
        <input type="date" v-model="form.assessment_date" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode" />
      </div>
    </div>

    <!-- Sections for Indicators and Remarks -->
    <div class="mb-6">
  <table class="w-full border-collapse border mb-4">
    <thead>
      <tr class="bg-gray-200">
        <th class="text-center p-2 border">E</th>
        <th class="text-center p-2 border">ATTITUDE</th>
        <th class="text-center p-2 border">Self-Rating</th>
        <th class="text-center p-2 border">MDO's Rating</th>
        <th class="text-center p-2 border">Total Rating</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="p-2 border text-center">1</td>
        <td class="p-2 border">Wala mosupak sa mga polisiya sa training sa tanang higayon. (He abides with policies of the training at all times)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[4].indicators[0].self_rating" @change="validateRating(form.sections[4].indicators[0], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[4].indicators[0].mdo_rating" @change="validateRating(form.sections[4].indicators[0], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[4].indicators[0]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">2</td>
        <td class="p-2 border">Mosunod ug motuman sa mga tudlo sa gihatag nga trabaho. (He follows instructions on given tasks)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[4].indicators[1].self_rating" @change="validateRating(form.sections[4].indicators[1], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[4].indicators[1].mdo_rating" @change="validateRating(form.sections[4].indicators[1], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[4].indicators[1]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">3</td>
        <td class="p-2 border">Parehas nga pagtagad sa mga kaubang residente. (He treats his co-residents fairly)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[4].indicators[2].self_rating" @change="validateRating(form.sections[4].indicators[2], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[4].indicators[2].mdo_rating" @change="validateRating(form.sections[4].indicators[2], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[4].indicators[2]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">4</td>
        <td class="p-2 border">Maayong timplo sa tanang higayon. (He is a peacemaker at all times)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[4].indicators[3].self_rating" @change="validateRating(form.sections[4].indicators[3], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[4].indicators[3].mdo_rating" @change="validateRating(form.sections[4].indicators[3], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[4].indicators[3]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">5</td>
        <td class="p-2 border">Makabalanse sa tanang mga pagsulay ug kalisud. (He can cope up with challenges and difficulties)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[4].indicators[4].self_rating" @change="validateRating(form.sections[4].indicators[4], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[4].indicators[4].mdo_rating" @change="validateRating(form.sections[4].indicators[4], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[4].indicators[4]) }}</td>
      </tr>
    </tbody>
  </table>

  <!-- Sub-total and Remarks -->
  <div class="flex justify-between items-center">
    <p class="font-bold">Sub-Total: {{ calculateSubTotal(form.sections[4].indicators) }}</p>
    <div class="w-full ml-4">
      <label class="block font-bold mb-1">Remarks:</label>
      <textarea v-model="form.sections[4].remarks" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode"></textarea>
    </div>
  </div>
</div>


<div class="mb-6">
  <table class="w-full border-collapse border mb-4">
    <thead>
      <tr class="bg-gray-200">
        <th class="text-center p-2 border">F</th>
        <th class="text-center p-2 border">RESPONSES TO SITUATIONS</th>
        <th class="text-center p-2 border">Self-Rating</th>
        <th class="text-center p-2 border">MDO's Rating</th>
        <th class="text-center p-2 border">Total Rating</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="p-2 border text-center">1</td>
        <td class="p-2 border">Dili moreklamo sa mga wala giplano nga kabag-uhan. (Never complains on unexpected changes/result of a group tasks)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[5].indicators[0].self_rating" @change="validateRating(form.sections[5].indicators[0], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[5].indicators[0].mdo_rating" @change="validateRating(form.sections[5].indicators[0], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[5].indicators[0]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">2</td>
        <td class="p-2 border">Inanay/plastar sa iyang plano ug mga desisyon. (Gentle in his actions/decisions)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[5].indicators[1].self_rating" @change="validateRating(form.sections[5].indicators[1], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[5].indicators[1].mdo_rating" @change="validateRating(form.sections[5].indicators[1], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[5].indicators[1]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">3</td>
        <td class="p-2 border">Madaladala sa mga bug-at/challenging nga buhat. (Can handle challenging tasks)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[5].indicators[2].self_rating" @change="validateRating(form.sections[5].indicators[2], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[5].indicators[2].mdo_rating" @change="validateRating(form.sections[5].indicators[2], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[5].indicators[2]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">4</td>
        <td class="p-2 border">Makaplano ug maayo sa mga moabot nga sitwasyon. (Can think appropriately in any given situation)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[5].indicators[3].self_rating" @change="validateRating(form.sections[5].indicators[3], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[5].indicators[3].mdo_rating" @change="validateRating(form.sections[5].indicators[3], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[5].indicators[3]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">5</td>
        <td class="p-2 border">Dili makiglalis sa mga kaubang residente ug trainor para dili makahimo ug kagubot. (Never argues with co-residents and trainor to create conflict)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[5].indicators[4].self_rating" @change="validateRating(form.sections[5].indicators[4], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[5].indicators[4].mdo_rating" @change="validateRating(form.sections[5].indicators[4], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[5].indicators[4]) }}</td>
      </tr>
    </tbody>
  </table>

  <!-- Sub-total and Remarks -->
  <div class="flex justify-between items-center">
    <p class="font-bold">Sub-Total: {{ calculateSubTotal(form.sections[5].indicators) }}</p>
    <div class="w-full ml-4">
      <label class="block font-bold mb-1">Remarks:</label>
      <textarea v-model="form.sections[5].remarks" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode"></textarea>
    </div>
  </div>
</div>

<div class="mb-6">
  <table class="w-full border-collapse border mb-4">
    <thead>
      <tr class="bg-gray-200">
        <th class="text-center p-2 border">G</th>
        <th class="text-center p-2 border">LIFE'S ASPIRATIONS</th>
        <th class="text-center p-2 border">Self-Rating</th>
        <th class="text-center p-2 border">MDO's Rating</th>
        <th class="text-center p-2 border">Total Rating</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="p-2 border text-center">1</td>
        <td class="p-2 border">Andam makaton sa mga kabag-ohan. (Willingness to learn new things)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[6].indicators[0].self_rating" @change="validateRating(form.sections[6].indicators[0], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[6].indicators[0].mdo_rating" @change="validateRating(form.sections[6].indicators[0], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[6].indicators[0]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">2</td>
        <td class="p-2 border">Naghatag ug importansya sa pag-eskwela. (Values the importance of education)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[6].indicators[1].self_rating" @change="validateRating(form.sections[6].indicators[1], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[6].indicators[1].mdo_rating" @change="validateRating(form.sections[6].indicators[1], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[6].indicators[1]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">3</td>
        <td class="p-2 border">Nagatoo nga ang pagbantog ug disiplina sa kaugalingon makapabago-o sa kinabuhi. (Believes having discipline can change his life)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[6].indicators[2].self_rating" @change="validateRating(form.sections[6].indicators[2], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[6].indicators[2].mdo_rating" @change="validateRating(form.sections[6].indicators[2], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[6].indicators[2]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">4</td>
        <td class="p-2 border">Nagatoo sa gahum sa pag-atiman sa Ginoo. (Believes in the power of the caring God)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[6].indicators[3].self_rating" @change="validateRating(form.sections[6].indicators[3], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[6].indicators[3].mdo_rating" @change="validateRating(form.sections[6].indicators[3], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[6].indicators[3]) }}</td>
      </tr>
      <tr>
        <td class="p-2 border text-center">5</td>
        <td class="p-2 border">Nagatoo nga ang maayong pamatasan makatabang nga mapalambo ang kaugalingon nga kakayahan. (Believes that good character qualities will help him develop his potentials)</td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[6].indicators[4].self_rating" @change="validateRating(form.sections[6].indicators[4], 'self_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <input type="number" min="0" max="4" v-model="form.sections[6].indicators[4].mdo_rating" @change="validateRating(form.sections[6].indicators[4], 'mdo_rating')" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">{{ calculateTotalRating(form.sections[6].indicators[4]) }}</td>
      </tr>
    </tbody>
  </table>

  <!-- Sub-total and Remarks -->
  <div class="flex justify-between items-center">
    <p class="font-bold">Sub-Total: {{ calculateSubTotal(form.sections[6].indicators) }}</p>
    <div class="w-full ml-4">
      <label class="block font-bold mb-1">Remarks:</label>
      <textarea v-model="form.sections[6].remarks" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode"></textarea>
    </div>
  </div>
</div>

<!-- OVER-ALL RATING -->
<tr class="bg-gray-300 font-bold">
  <td colspan="2" class="p-2 border text-center">Overall Rating</td>
  <td class="p-2 border text-center">{{ calculateOverallRating().overall }}</td>
</tr>

    <div class="w-full h-full p-4">
      <h4>ADJECTIVAL RATING</h4>
    <table class="w-full h-full border-collapse border border-black table-fixed">
        <tr>
            <td class="border border-black p-4 align-top">4 - Points - Excellent/Full cooperation and proper physical condition</td>
            <td class="border border-black p-4 align-top">2 - 2.99 Points - Needs Improvement/Complies with the request to cooperate</td>
        </tr>
        <tr>
            <td class="border border-black p-4 align-top">3 - 3.99 Points - Very Satisfactory/Appropriate behavior and condition during the training</td>
            <td class="border border-black p-4 align-top">1 - 1.99 Points - Needs Close Monitoring/Problem is Prominent</td>
        </tr>
    </table>
</div>
      <br />



    <!-- General Remarks/Recommendations -->
    <div class="mb-6">
      <label class="block font-bold mb-1">General Remarks/Recommendation:</label>
      <textarea v-model="form.general_remarks" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode"></textarea>
    </div>

    <!-- Trainings Previously Attended -->
    <div class="mb-6">
      <h4 class="font-bold mb-2">Trainings Previously Attended</h4>
      <table class="w-full border-collapse border mb-4">
        <thead>
          <tr class="bg-gray-200">
            <th class="text-center p-2 border">No.</th>
            <th class="text-center p-2 border">Title of the Training</th>
            <th class="text-center p-2 border">Date of Attendance</th>
            <th class="text-center p-2 border">Status</th>
            <th class="text-center p-2 border">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(training, index) in form.trainings" :key="index">
            <td class="p-2 border text-center">{{ index + 1 }}</td>
            <td class="p-2 border">
              <input type="text" v-model="training.title" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode" />
            </td>
            <td class="p-2 border">
              <input type="date" v-model="training.date_of_attendance" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode" />
            </td>
            <td class="p-2 border">
              <input type="text" v-model="training.status" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode" />
            </td>
            <td class="p-2 border text-center">
              <button @click="removeTraining(index)" type="button" class="px-2 py-1 bg-red-500 text-white rounded" :disabled="!editMode">Remove</button>
            </td>
          </tr>
        </tbody>
      </table>
      <button @click="addTraining" type="button" class="px-4 py-2 bg-blue-500 text-white rounded" :disabled="!editMode">Add Training</button>
    </div>

    
  <!-- Signatures Section -->
  <div class="mb-6 flex gap-4">
    <!-- Prepared by Signature -->
    <div class="w-1/2">
      <label for="preparedBy" class="block text-sm font-medium">Prepared by:</label>
      <div class="flex items-center">
        <input
          type="text"
          id="preparedBy"
          v-model="form.prepared_by_one"
          class="mt-1 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm "
        >
      </div>
      <p class="text-sm mt-2">MDO I</p>

      
      <div class="flex items-center">
        <input
          type="text"
          id="preparedBy"
          v-model="form.prepared_by_two"
          class="mt-1 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm "
        >
      </div>
      <p class="text-sm mt-2">MDO II</p>
      
      
    </div>
  
    <!-- Noted by Signature -->
    <div class="w-1/2">
      <label for="notedBy" class="block text-sm font-medium">Noted by:</label>
      <div class="flex items-center">
        <input
          type="text"
          id="notedBy"
          v-model="center_head"
          readonly
          class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm "
        >
      </div>
      <p class="text-sm mt-2">Center Head</p>
    </div>
  </div>

    <div class="border-gray-300 ml-6 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
        <div class="flex justify-between items-center">
          <div class="flex flex-col">
            <p class="ml-24 -mb-4 font-bold">PAGE 2 of {{ totalPages }}</p>
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
import Pagination from '@/Components/Pagination.vue';

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
</style>
