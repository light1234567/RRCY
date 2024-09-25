<template>
  
  <div class="max-w-3xl p-8 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
  <!-- Success/Error Message -->
  <div v-if="message" :class="`mt-4 p-4 rounded text-white ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">{{ message }}</div>
<!-- Header -->
<div class="relative flex justify-between items-center mb-4">
    <img src="/images/headerlogo2.png" alt="Logo" class="h-24 w-48">
    <div class="text-right">
      <p class="item-center mr-6 text-sm font-semibold">PROTECTIVE SERVICES DIVISION</p>
      <p class="text-sm font-semibold">Regional Rehabilitation Center for Youth RFO XI</p>
      <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
    </div>
  </div>

  <div class="p-4">
<table class="w-full">
  <thead>
    <tr>
      <th colspan="6" class="text-center p-2">
        <h2 class="text-lg font-bold">TRAINING NEEDS ASSESSMENT</h2>
        <div class="flex items-center justify-center mb-6">
          <p class="text-md font-semibold mr-4">FOR THE </p>
          <input type="text" v-model="form.period" class="underline-input bg-transparent border-b-2 border-gray-300 text-center text-xs" />
        </div>
        <div class="flex items-center justify-center mb-6">
          <p class="text-md font-semibold mr-4">Date of Admission:</p>
          <input type="text" v-model="form.period" class="underline-input bg-transparent border-b-2 border-gray-300 text-center text-xs" />
        </div>
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="p-2 border">Pangalan:</td>
      <td colspan="4" class="p-2 border">
        <input type="text" v-model="form.name" :readonly="!editMode" class="w-full border">
      </td>
    </tr>
    <tr>
      <td class="p-2 border">Adlaw nga Natawhan:</td>
      <td colspan="2" class="p-2 border">
        <input type="date" v-model="form.birthdate" :readonly="!editMode" class="w-full border" @change="form.age = calculateAge(form.birthdate)">
      </td>
      <td class="p-2 border">Edad:</td>
      <td colspan="2" class="p-2 border">
        <input type="number" v-model="form.age" class="w-full border" readonly>
      </td>
    </tr>
    
    <!-- Replace table row with grid layout -->
    <tr>        
      <td colspan="6" class="p-2 border bg-gray-200 font-bold">Natapos nga Grado:</td>
    </tr>
    <tr>
<td colspan="6" class="p-2">
  <div class="flex flex-col space-y-4">
    <!-- Wala Naka eskwela -->
    <div class="flex items-center">
      <input type="radio" value="Wala Naka eskwela" v-model="form.selectedEducationLevel" :disabled="!editMode" class="mr-2">
      <span>Wala Naka eskwela</span>
    </div>

    <div class="flex space-x-8">
      <!-- First Column -->
      <div>
        <label class="flex items-center space-x-2">
          <input type="radio" value="Elementary Level" v-model="form.selectedEducationLevel" :disabled="!editMode">
          <span>Elementary Level (Grade</span>
          <input type="text" v-model="form.elementaryGrade" :disabled="!editMode || form.selectedEducationLevel !== 'Elementary Level'" class="w-16 border-b p-1 text-center">
          <span>)</span>
        </label>

        <label class="flex items-center space-x-2 mt-2">
          <input type="radio" value="Elementary Graduate" v-model="form.selectedEducationLevel" :disabled="!editMode">
          <span>Elementary Graduate</span>
        </label>

        <label class="flex items-center space-x-2 mt-2">
          <input type="radio" value="Junior High School Level" v-model="form.selectedEducationLevel" :disabled="!editMode">
          <span>Junior High School Level (Year</span>
          <input type="text" v-model="form.juniorHighYear" :disabled="!editMode || form.selectedEducationLevel !== 'Junior High School Level'" class="w-16 border-b p-1 text-center">
          <span>)</span>
        </label>
      </div>

      <!-- Second Column -->
      <div>
        <label class="flex items-center space-x-2">
          <input type="radio" value="Senior High School Level" v-model="form.selectedEducationLevel" :disabled="!editMode">
          <span>Senior High School Level (Year</span>
          <input type="text" v-model="form.seniorHighYear" :disabled="!editMode || form.selectedEducationLevel !== 'Senior High School Level'" class="w-16 border-b p-1 text-center">
          <span>)</span>
        </label>

        <label class="flex items-center space-x-2 mt-2">
          <input type="radio" value="Senior High School Graduate" v-model="form.selectedEducationLevel" :disabled="!editMode">
          <span>Senior High School Graduate</span>
        </label>

        <label class="flex items-center space-x-2 mt-2">
          <input type="radio" value="College Level" v-model="form.selectedEducationLevel" :disabled="!editMode">
          <span>College Level (Year</span>
          <input type="text" v-model="form.collegeYear" :disabled="!editMode || form.selectedEducationLevel !== 'College Level'" class="w-24 border-b p-1 text-center">
          <span>)</span>
        </label>
      </div>
    </div>
  </div>
</td>
</tr>



    <!-- Additional education fields here -->
    <tr>
      <td colspan="2" class="p-2 border">Pangalan sa imong Social Worker:</td>
      <td colspan="4" class="p-2 border"><input type="text" v-model="form.social_worker" :readonly="!editMode" class="w-full border"></td>
    </tr>
    <tr>
      <td colspan="2" class="p-2 border">Pangalan sa imong Houseparent:</td>
      <td colspan="4" class="p-2 border"><input type="text" v-model="form.houseparent" :readonly="!editMode" class="w-full border"></td>
    </tr>
    <tr>
      <td colspan="6" class="p-2 border bg-gray-200 font-bold">Pangalan sa Ginikanan:</td>
    </tr>
    <tr>
      <td class="p-2 border">Amahan:</td>
      <td colspan="5" class="p-2 border"><input type="text" v-model="form.father" :readonly="!editMode" class="w-full border"></td>
    </tr>
    <tr>
      <td class="p-2 border">Inahan:</td>
      <td colspan="5" class="p-2 border"><input type="text" v-model="form.mother" :readonly="!editMode" class="w-full border"></td>
    </tr>
    <tr>
      <td class="p-2 border">Pinuy-Anan:</td>
      <td colspan="5" class="p-2 border"><input type="text" v-model="form.address" :readonly="!editMode" class="w-full border"></td>
    </tr>
    <tr>
      <td class="p-2 border">Kadugayon sa Pagpuyo sa Center:</td>
      <td colspan="5" class="p-2 border"><input type="text" v-model="form.center_duration" :readonly="!editMode" class="w-full border"></td>
    </tr>
  </tbody>
</table>


    <!-- Page 2: Trainings -->
    <table class="w-full border-collapse border mt-4">
      <thead>
        <tr>
          <th colspan="4" class="text-center p-2 border bg-gray-300">Skills Training nga human na nga naapilan diri sa sulod CENTER ug sa gawas sa center</th>
        </tr>
        <tr class="bg-gray-200">
          <th class="border p-2 text-center">Title sa Training nga Naapilan</th>
          <th class="border p-2 text-center">Kadugayon sa Training</th>
          <th class="border p-2 text-center">Lugar sa Gi-Trainingan (Sa Gawas)</th>
          <th class="border p-2 text-center">Lugar sa Gi-Trainingan (Sa Center)</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(training, index) in form.trainings" :key="index">
          <td class="p-2 border">
            <input type="text" v-model="training.title" class="w-full border" :readonly="!editMode">
          </td>
          <td class="p-2 border">
            <input type="text" v-model="training.duration" class="w-full border" :readonly="!editMode">
          </td>
          <td class="p-2 border">
            <input type="text" v-model="training.location_outside" class="w-full border" :readonly="!editMode">
          </td>
          <td class="p-2 border">
            <input type="text" v-model="training.location_inside" class="w-full border" :readonly="!editMode">
          </td>
        </tr>
        <!-- Option to add a new training -->
        <tr v-if="editMode">
          <td colspan="4" class="p-2 text-center">
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
  <div class="border-gray-300 ml-6 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        <div class="flex flex-col">
          <p class="ml-24 -mb-2 font-bold">PAGE 1 of 2</p>
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


<div class="max-w-3xl p-8 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
  <!-- Automotive Sector -->
  <tr class="bg-gray-200">
    <th class="border p-2 text-center"></th>
    <th class="border p-2 text-center"></th>
    <th class="border p-2 text-center">1</th>
    <th class="border p-2 text-center">2</th>
    <th class="border p-2 text-center">3</th>
    <th class="border p-2 text-center">4</th>
    <th class="border p-2 text-center">5</th>
    <th class="border p-2 text-center">Ikasugyot/Remarks</th>
  </tr>
  <tr class="bg-gray-100 font-bold">
    <td colspan="8" class="border p-2">A. AUTOMOTIVE SECTOR:</td>
  </tr>
  <tr v-for="(item, index) in automotiveSector" :key="'automotive-' + index">
    <td class="border p-2 text-center">{{ index + 1 }}</td>
    <td class="border p-2">{{ item.name }}</td>
    <td class="border p-2 text-center"><input type="radio" :name="'automotive-' + index" value="1" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'automotive-' + index" value="2" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'automotive-' + index" value="3" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'automotive-' + index" value="4" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'automotive-' + index" value="5" v-model="item.rank"></td>
    <td class="border p-2"><input type="text" v-model="item.remarks" class="w-full border p-1"></td>
  </tr>

  <!-- Agricultural Sector -->
  <tr class="bg-gray-100 font-bold">
    <td colspan="8" class="border p-2">B. AGRICULTURAL SECTOR:</td>
  </tr>
  <tr v-for="(item, index) in agriculturalSector" :key="'agricultural-' + index">
    <td class="border p-2 text-center">{{ index + 1 }}</td>
    <td class="border p-2">{{ item.name }}</td>
    <td class="border p-2 text-center"><input type="radio" :name="'agricultural-' + index" value="1" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'agricultural-' + index" value="2" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'agricultural-' + index" value="3" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'agricultural-' + index" value="4" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'agricultural-' + index" value="5" v-model="item.rank"></td>
    <td class="border p-2"><input type="text" v-model="item.remarks" class="w-full border p-1"></td>
  </tr>

  <!-- Health Sector -->
  <tr class="bg-gray-100 font-bold">
    <td colspan="8" class="border p-2">C. HEALTH, SOCIAL & OTHER COMMUNITY DEVT. SERVICES:</td>
  </tr>
  <tr v-for="(item, index) in healthSector" :key="'health-' + index">
    <td class="border p-2 text-center">{{ index + 1 }}</td>
    <td class="border p-2">{{ item.name }}</td>
    <td class="border p-2 text-center"><input type="radio" :name="'health-' + index" value="1" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'health-' + index" value="2" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'health-' + index" value="3" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'health-' + index" value="4" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'health-' + index" value="5" v-model="item.rank"></td>
    <td class="border p-2"><input type="text" v-model="item.remarks" class="w-full border p-1"></td>
  </tr>

  <!-- ICT Sector -->
  <tr class="bg-gray-100 font-bold">
    <td colspan="8" class="border p-2">D. INFORMATION & COMMUNICATION TECHNOLOGY:</td>
  </tr>
  <tr v-for="(item, index) in ictSector" :key="'ict-' + index">
    <td class="border p-2 text-center">{{ index + 1 }}</td>
    <td class="border p-2">{{ item.name }}</td>
    <td class="border p-2 text-center"><input type="radio" :name="'ict-' + index" value="1" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'ict-' + index" value="2" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'ict-' + index" value="3" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'ict-' + index" value="4" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'ict-' + index" value="5" v-model="item.rank"></td>
    <td class="border p-2"><input type="text" v-model="item.remarks" class="w-full border p-1"></td>
  </tr>

  <!-- Metals Sector -->
  <tr class="bg-gray-100 font-bold">
    <td colspan="8" class="border p-2">E. METALS & ENGINEERING SECTOR:</td>
  </tr>
  <tr v-for="(item, index) in metalsSector" :key="'metals-' + index">
    <td class="border p-2 text-center">{{ index + 1 }}</td>
    <td class="border p-2">{{ item.name }}</td>
    <td class="border p-2 text-center"><input type="radio" :name="'metals-' + index" value="1" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'metals-' + index" value="2" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'metals-' + index" value="3" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'metals-' + index" value="4" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'metals-' + index" value="5" v-model="item.rank"></td>
    <td class="border p-2"><input type="text" v-model="item.remarks" class="w-full border p-1"></td>
  </tr>

  <!-- Tourism Sector -->
  <tr class="bg-gray-100 font-bold">
    <td colspan="8" class="border p-2">F. TOURISM SECTOR:</td>
  </tr>
  <tr v-for="(item, index) in tourismSector" :key="'tourism-' + index">
    <td class="border p-2 text-center">{{ index + 1 }}</td>
    <td class="border p-2">{{ item.name }}</td>
    <td class="border p-2 text-center"><input type="radio" :name="'tourism-' + index" value="1" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'tourism-' + index" value="2" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'tourism-' + index" value="3" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'tourism-' + index" value="4" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'tourism-' + index" value="5" v-model="item.rank"></td>
    <td class="border p-2"><input type="text" v-model="item.remarks" class="w-full border p-1"></td>
  </tr>

  <!-- Construction Sector -->
  <tr class="bg-gray-100 font-bold">
    <td colspan="8" class="border p-2">G. CONSTRUCTION SECTOR:</td>
  </tr>
  <tr v-for="(item, index) in constructionSector" :key="'construction-' + index">
    <td class="border p-2 text-center">{{ index + 1 }}</td>
    <td class="border p-2">{{ item.name }}</td>
    <td class="border p-2 text-center"><input type="radio" :name="'construction-' + index" value="1" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'construction-' + index" value="2" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'construction-' + index" value="3" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'construction-' + index" value="4" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'construction-' + index" value="5" v-model="item.rank"></td>
    <td class="border p-2"><input type="text" v-model="item.remarks" class="w-full border p-1"></td>
  </tr>

  <!-- Basic Trainings -->
  <tr class="bg-gray-100 font-bold">
    <td colspan="8" class="border p-2">H. BASIC TRAININGS:</td>
  </tr>
  <tr v-for="(item, index) in basicTrainings" :key="'basic-' + index">
    <td class="border p-2 text-center">{{ index + 1 }}</td>
    <td class="border p-2">{{ item.name }}</td>
    <td class="border p-2 text-center"><input type="radio" :name="'basic-' + index" value="1" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'basic-' + index" value="2" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'basic-' + index" value="3" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'basic-' + index" value="4" v-model="item.rank"></td>
    <td class="border p-2 text-center"><input type="radio" :name="'basic-' + index" value="5" v-model="item.rank"></td>
    <td class="border p-2"><input type="text" v-model="item.remarks" class="w-full border p-1"></td>
  </tr>
  <br />

  <div class="w-1/2 ml-auto">
<div class="flex items-center">
  <input
    v-model="form.center_head_signature"
    type="text"
    id="centerHeadSignature"
    class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none"
    :readonly="!editMode"
  >
</div>
<p class="text-sm mt-2">Pangalan ug Pirma sa Residente</p>
</div>

<br />

  <div class="border-gray-300 ml-6 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        <div class="flex flex-col">
          <p class="ml-24 -mb-2 font-bold">PAGE 2 of 2</p>
          <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
          <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrcy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
        </div>
        <div class="ml-4">
          <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
        </div>
      </div>
    </div>


</div>

</template>

<script>
import axios from 'axios';

export default {
name: "TrainingNeedsAssessment",
data() {
  return {
    form: {
      client_id: null,
      name: '',
      birthdate: '',
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
      for_the: '',
      date_of_admission: '',
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

              const report = response.data.report;

              const educationDetails = report.education_details;
              const trainingDetails = report.training_details;
              const trainingSectorDetails = report.training_sector_details;

              // Log each of these to verify
              console.log('Education Details:', educationDetails);
              console.log('Training Details:', trainingDetails);
              console.log('Training Sector Details:', trainingSectorDetails);

              // Populate the form with the report data
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
              }

              // Populate the trainings fields
              if (Array.isArray(trainingDetails)) {
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
              if (Array.isArray(trainingSectorDetails)) {
                  trainingSectorDetails.forEach(detail => {
                      let sectorArray;
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
                      const item = sectorArray.find(s => s.name === detail.name);
                      if (item) {
                          item.rank = detail.rank;
                          item.remarks = detail.remarks;
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
 // Validate that education level is provided before saving
 if (!this.form.selectedEducationLevel) {
     this.message = 'Education level is required.';
     this.messageType = 'error';
     return;
 }

 // Update the education array
 this.form.education = [{
     level: this.form.selectedEducationLevel,
     year_or_grade: this.getYearOrGradeForLevel(this.form.selectedEducationLevel)
 }];

 // Ensure all other fields are properly filled
 if (!this.form.client_id) {
     this.message = 'Client ID is missing. Cannot save the form.';
     this.messageType = 'error';
     return; // Prevent saving without a valid client_id
 }

 // Prepare the training_sectors array
 this.form.training_sectors = [
     ...this.automotiveSector.map(s => ({ sector: 'Automotive', ...s })),
     ...this.agriculturalSector.map(s => ({ sector: 'Agricultural', ...s })),
     ...this.healthSector.map(s => ({ sector: 'Health', ...s })),
     ...this.ictSector.map(s => ({ sector: 'ICT', ...s })),
     ...this.metalsSector.map(s => ({ sector: 'Metals', ...s })),
     ...this.tourismSector.map(s => ({ sector: 'Tourism', ...s })),
     ...this.constructionSector.map(s => ({ sector: 'Construction', ...s })),
     ...this.basicTrainings.map(s => ({ sector: 'Basic', ...s })),
 ];

 // Send the data to the backend
 axios.put(`/api/training-needs-assessment/${this.form.client_id}`, this.form)
     .then(response => {
         this.message = 'Data saved successfully.';
         this.messageType = 'success';
         this.editMode = false; // Exit edit mode after saving
     })
     .catch(error => {
         this.message = 'Failed to save data.';
         this.messageType = 'error';
         console.error('Failed to save data:', error.response ? error.response.data : error.message);
     });
}


,
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
</style>