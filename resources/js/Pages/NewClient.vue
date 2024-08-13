<template>
  <AppLayout title="Dashboard">
    <template #header>
        <h1 class="ml-0 text-lg font-bold  text-red-800">ADMISSION FORM/NEW CLIENT</h1>
      </template>
      <div style="background-image: url(''); background-size: cover; background-position: center;">
      <h1 class="text-lg p-1 text-customBlue ml-10 -mt-44 font-bold mb-4">
      
      </h1>
      <form @submit.prevent="saveForm">
        <!-- Client Information -->
        <fieldset class="border border-blue-900 p-4 mb-2 mr-8 ml-16 rounded-sm">
          <legend class="text-base bg-blue-900 text-gray-300 pl-2 pr-2 pt-1 pb-1 rounded-sm font-bold">CLIENT INFORMATION</legend>
          <div class="grid grid-cols-1">
            <!-- Name, Sex, and Date of Birth -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-2 mb-2">
              <div class="md:col-span-1 mb-2">
                <label for="clientFirstName" class="block mb-1 text-sm">
                  First Name: <span class="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  id="clientFirstName"
                  v-model="form.client.first_name"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  required
                />
              </div>
              <div class="md:col-span-1 mb-2">
                <label for="clientMiddleName" class="block mb-1 text-sm">Middle Name:</label>
                <input
                  type="text"
                  id="clientMiddleName"
                  v-model="form.client.middle_name"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                />
              </div>
              <div class="md:col-span-1 mb-2">
                <label for="clientLastName" class="block mb-1 text-sm">
                  Last Name: <span class="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  id="clientLastName"
                  v-model="form.client.last_name"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  required
                />
              </div>
              <div class="md:col-span-1 mb-2">
                <label for="clientSex" class="block mb-1 text-sm">
                  Sex: <span class="text-red-500">*</span>
                </label>
                <select
                  id="clientSex"
                  v-model="form.client.sex"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  required
                >
                  <option value="male" selected>Male</option>
                  <option value="female">Female</option>
                  <option value="other">Other</option>
                </select>
              </div>
            </div>
  
            <!-- Date of Birth and Place of Birth -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
              <div class="md:col-span-1 mb-2">
                <label for="clientDob" class="block mb-1 text-sm">
                  Date of Birth: <span class="text-red-500">*</span>
                </label>
                <input
                  type="date"
                  id="clientDob"
                  v-model="form.client.date_of_birth"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  required
                />
              </div>
              <div class="md:col-span-1 mb-2">
                <label for="clientPlaceOfBirth" class="block mb-1 text-sm">
                  Place of Birth: <span class="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  id="clientPlaceOfBirth"
                  v-model="form.client.place_of_birth"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  required
                />
              </div>
            </div>
  
            <!-- Address Breakdown -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
              <div class="mb-2">
                <label for="clientProvince" class="block mb-1 text-sm">
                  Province: <span class="text-red-500">*</span>
                </label>
                <select
                  id="clientProvince"
                  v-model="form.client.province"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  @change="updateCitiesAndBarangays"
                  required
                >
                  <option value="" disabled selected>Select Province</option>
                  <option value="Davao del Norte">Davao del Norte</option>
                  <option value="Davao del Sur">Davao del Sur</option>
                  <option value="Davao Oriental">Davao Oriental</option>
                  <option value="Davao de Oro">Davao de Oro</option>
                  <option value="Davao Occidental">Davao Occidental</option>
                </select>
              </div>
              <div class="mb-2">
                <label for="clientCity" class="block mb-1 text-sm">
                  City/Municipality: <span class="text-red-500">*</span>
                </label>
                <select
                  id="clientCity"
                  v-model="form.client.city"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  @change="updateBarangays"
                  required
                >
                  <option value="" disabled selected>Select City/Municipality</option>
                  <option v-for="city in cities" :key="city" :value="city">{{ city }}</option>
                </select>
              </div>
              <div class="mb-2">
                <label for="clientBarangay" class="block mb-1 text-sm">
                  Barangay: <span class="text-red-500">*</span>
                </label>
                <select
                  id="clientBarangay"
                  v-model="form.client.barangay"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  required
                >
                  <option value="" disabled selected>Select Barangay</option>
                  <option v-for="barangay in barangays" :key="barangay" :value="barangay">{{ barangay }}</option>
                </select>
              </div>
              <div class="mb-2">
                <label for="clientStreet" class="block mb-1 text-sm">House/Building Number and Street Name:</label>
                <input
                  type="text"
                  id="clientStreet"
                  v-model="form.client.street"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                />
              </div>
            </div>
  
            <!-- Religion -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
              <div class="mb-2">
                <label for="clientReligion" class="block mb-1 text-sm">
                  Religion: <span class="text-red-500">*</span>
                </label>
                <select
                  id="clientReligion"
                  v-model="form.client.religion"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  required
                >
                  <option value="" disabled selected>Select Religion</option>
                  <option value="Aglipayan">Aglipayan</option>
                  <option value="Baha'i">Baha'i</option>
                  <option value="Buddhist">Buddhist</option>
                  <option value="Catholic">Catholic</option>
                  <option value="Christian">Christian</option>
                  <option value="Hindu">Hindu</option>
                  <option value="Islam">Islam</option>
                  <option value="Iglesia ni Cristo">Iglesia ni Cristo</option>
                  <option value="Jehovah's Witness">Jehovah's Witness</option>
                  <option value="Judeo-Christian">Judeo-Christian</option>
                  <option value="Kapitiran">Kapitiran</option>
                  <option value="Latter-Day Saints (Mormons)">Latter-Day Saints (Mormons)</option>
                  <option value="Liberal Christian">Liberal Christian</option>
                  <option value="Maranatha">Maranatha</option>
                  <option value="Methodist">Methodist</option>
                  <option value="Nazarene">Nazarene</option>
                  <option value="Orthodox">Orthodox</option>
                  <option value="Pentecostal">Pentecostal</option>
                  <option value="Protestant">Protestant</option>
                  <option value="Quakers">Quakers</option>
                  <option value="Rastafari">Rastafari</option>
                  <option value="Roman Catholic">Roman Catholic</option>
                  <option value="SDA (Seventh-Day Adventist)">SDA (Seventh-Day Adventist)</option>
                  <option value="Shinto">Shinto</option>
                  <option value="Sikh">Sikh</option>
                  <option value="Taoist">Taoist</option>
                  <option value="The Church of God">The Church of God</option>
                  <option value="Unitarian Universalist">Unitarian Universalist</option>
                  <option value="Universal Church">Universal Church</option>
                  <option value="Voodoo">Voodoo</option>
                  <option value="Zoroastrian">Zoroastrian</option>
                  <option value="Other">Other</option>
                </select>
              </div>
            </div>
          </div>
        </fieldset>
  
       <!-- Distinguishing Marks -->
        <fieldset class="border border-blue-900  p-4 mb-2 mr-8 ml-16 mt-8  rounded-sm">
          <legend class="text-base  bg-blue-900 text-gray-300 pl-2 pr-2 pt-1 pb-1 rounded-sm font-bold mb-2">
            DISTINGUISHING MARKS
          </legend>
          <div class="grid grid-cols-1 md:grid-cols-5 gap-2 mb-2">
            <div class="mb-2">
              <label for="tattooScars" class="block mb-1 text-sm">Tattoo/Scars:</label>
              <input
                type="text"
                id="tattooScars"
                v-model="form.distinguishing_marks.tattoo_scars"
                class="w-full px-2 py-1 border rounded-md text-sm"
              />
            </div>
            <div class="mb-2">
              <label for="height" class="block mb-1 text-sm">Height (cm):</label>
              <input
                type="number"
                id="height"
                v-model="form.distinguishing_marks.height"
                class="w-full px-2 py-1 border rounded-md text-sm"
              />
            </div>
            <div class="mb-2">
              <label for="weight" class="block mb-1 text-sm">Weight (kg):</label>
              <input
                type="number"
                id="weight"
                v-model="form.distinguishing_marks.weight"
                class="w-full px-2 py-1 border rounded-md text-sm"
              />
            </div>
            <div class="mb-2">
              <label for="colourOfEye" class="block mb-1 text-sm">Colour of Eye:</label>
              <select
                id="colourOfEye"
                v-model="form.distinguishing_marks.colour_of_eye"
                class="w-full px-2 py-1 border rounded-md text-sm"
              >
                <option value="" disabled selected>Select eye color</option>
                <option value="Brown">Brown</option>
                <option value="Black">Black</option>
                <option value="Blue">Blue</option>
                <option value="Green">Green</option>
                <option value="Hazel">Hazel</option>
                <option value="Gray">Gray</option>
                <option value="Amber">Amber</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="mb-2">
              <label for="skinColour" class="block mb-1 text-sm">Skin Colour:</label>
              <select
                id="skinColour"
                v-model="form.distinguishing_marks.skin_colour"
                class="w-full px-2 py-1 border rounded-md text-sm"
              >
                <option value="" disabled selected>Select skin color</option>
                <option value="Light">Light</option>
                <option value="Fair">Fair</option>
                <option value="Medium">Medium</option>
                <option value="Olive">Olive</option>
                <option value="Tan">Tan</option>
                <option value="Brown">Brown</option>
                <option value="Dark">Dark</option>
                <option value="Other">Other</option>
              </select>
            </div>
          </div>
        </fieldset>
  
        <!-- Admission Details -->
        <fieldset class="border border-blue-900  p-4 mb-2 mt-8 mr-8 ml-16 rounded-sm">
          <legend class="text-base  bg-blue-900  text-gray-300 pl-2 pr-2 pt-1 pb-1 rounded-sm font-bold mb-2">ADMISSION DETAILS</legend>
          <div class="grid grid-cols-1 gap-2">
            <div class="mb-2 col-span-1">
              <label for="committingCourt" class="block mb-1 text-sm">
                Committing Court: <span class="text-red-500">*</span>
              </label>
              <input
                type="text"
                id="committingCourt"
                v-model="form.admission.committing_court"
                class="w-full px-2 py-1
                 border rounded-md text-sm"
              required
            />
          </div>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
            <div class="mb-2">
              <label for="crimCaseNumber" class="block mb-1 text-sm">
                Criminal Case Number: <span class="text-red-500">*</span>
              </label>
              <input
                type="text"
                id="crimCaseNumber"
                v-model="form.admission.crim_case_number"
                class="w-full px-2 py-1 border rounded-md text-sm"
                required
              />
            </div>
            <div class="mb-2">
              <label for="offenseCommitted" class="block mb-1 text-sm">
                Offense Committed: <span class="text-red-500">*</span>
              </label>
              <select
                id="offenseCommitted"
                v-model="form.admission.offense_committed"
                class="w-full px-2 py-1 border rounded-md text-sm"
                required
              >
                <option value="" disabled selected>Select offense</option>
                <option value="Animal Cruelty">Animal Cruelty</option>
                <option value="Arson">Arson</option>
                <option value="Assault">Assault</option>
                <option value="Burglary">Burglary</option>
                <option value="Child Abuse">Child Abuse</option>
                <option value="Cybercrime">Cybercrime</option>
                <option value="Destruction of Property">Destruction of Property</option>
                <option value="Driving Without a License">Driving Without a License</option>
                <option value="Drug Possession">Drug Possession</option>
                <option value="Drug Trafficking">Drug Trafficking</option>
                <option value="DUI (Driving Under the Influence)">DUI (Driving Under the Influence)</option>
                <option value="Embezzlement">Embezzlement</option>
                <option value="Extortion">Extortion</option>
                <option value="Forgery">Forgery</option>
                <option value="Fraud">Fraud</option>
                <option value="Gambling">Gambling</option>
                <option value="Graffiti">Graffiti</option>
                <option value="Harassment">Harassment</option>
                <option value="Homicide">Homicide</option>
                <option value="Identity Theft">Identity Theft</option>
                <option value="Illegal Possession of Firearms">Illegal Possession of Firearms</option>
                <option value="Interference with Law Enforcement">Interference with Law Enforcement</option>
                <option value="Kidnapping">Kidnapping</option>
                <option value="Larceny">Larceny</option>
                <option value="Loitering">Loitering</option>
                <option value="Manslaughter">Manslaughter</option>
                <option value="Murder">Murder</option>
                <option value="Negligence">Negligence</option>
                <option value="Nuisance">Nuisance</option>
                <option value="Public Intoxication">Public Intoxication</option>
                <option value="Rape">Rape</option>
                <option value="Robbery">Robbery</option>
                <option value="Sexual Assault">Sexual Assault</option>
                <option value="Sexual Exploitation">Sexual Exploitation</option>
                <option value="Shoplifting">Shoplifting</option>
                <option value="Stalking">Stalking</option>
                <option value="Theft">Theft</option>
                <option value="Threats">Threats</option>
                <option value="Trespassing">Trespassing</option>
                <option value="Unlawful Assembly">Unlawful Assembly</option>
                <option value="Vandalism">Vandalism</option>
                <option value="Vehicular Manslaughter">Vehicular Manslaughter</option>
                <option value="Violation of Probation">Violation of Probation</option>
                <option value="Weapon Possession">Weapon Possession</option>
                <option value="Witness Tampering">Witness Tampering</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="mb-2">
              <label for="dateAdmitted" class="block mb-1 text-sm">
                Date Admitted: <span class="text-red-500">*</span>
              </label>
              <input
                type="date"
                id="dateAdmitted"
                v-model="form.admission.date_admitted"
                class="w-full px-2 py-1 border rounded-md text-sm"
                required
              />
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div class="mb-2">
              <label for="daysInJail" class="block mb-1 text-sm">
                Days in Jail: <span class="text-red-500">*</span>
              </label>
              <input
                type="number"
                id="daysInJail"
                v-model="form.admission.days_in_jail"
                class="w-full px-2 py-1 border rounded-md text-sm"
                required
              />
            </div>
            <div class="mb-2">
              <label for="daysInDetentionCenter" class="block mb-1 text-sm">
                Days in Detention Center: <span class="text-red-500">*</span>
              </label>
              <input
                type="number"
                id="daysInDetentionCenter"
                v-model="form.admission.days_in_detention_center"
                class="w-full px-2 py-1 border rounded-md text-sm"
                required
              />
            </div>
          </div>
        </div>
      </fieldset>

      <!-- Documents Submitted -->
      <fieldset class="border border-blue-900  p-4 mb-2 mt-8  mr-8 ml-16 rounded-sm">
        <legend class="text-base  bg-blue-900 text-gray-300 pl-2 pr-2 pt-1 pb-1 rounded-sm font-bold mb-2">DOCUMENTS SUBMITTED</legend>
        <div class="grid grid-cols-1 gap-2">
          <div class="mb-2">
            <label class="block mb-1 text-sm font-semibold">Documents Submitted:</label>
            <div class="flex flex-col space-y-1">
              <div class="flex items-center">
                <input
                  type="checkbox"
                  value="SCSR"
                  v-model="form.documents_submitted.documents"
                  class="mr-1"
                />
                <span class="text-sm">SCSR</span>
              </div>
              <div class="flex items-center">
                <input
                  type="checkbox"
                  value="Court Order"
                  v-model="form.documents_submitted.documents"
                  class="mr-1"
                />
                <span class="text-sm">Court Order</span>
              </div>
              <div class="flex items-center">
                <input
                  type="checkbox"
                  value="Medical Certificates"
                  v-model="form.documents_submitted.documents"
                  class="mr-1"
                />
                <span class="text-sm">Medical Certificates</span>
              </div>
              <div class="flex items-center">
                <input
                  type="checkbox"
                  value="Commitment Order"
                  v-model="form.documents_submitted.documents"
                  class="mr-1"
                />
                <span class="text-sm">Commitment Order</span>
              </div>
              <div class="flex items-center">
                <input
                  type="checkbox"
                  value="Consent from Parents"
                  v-model="form.documents_submitted.documents"
                  class="mr-1"
                />
                <span class="text-sm">Consent from Parents</span>
              </div>
              <div class="flex items-center">
                <input
                  type="checkbox"
                  value="School Records"
                  v-model="form.documents_submitted.documents"
                  class="mr-1"
                />
                <span class="text-sm">School Records</span>
              </div>
              <div class="flex items-center">
                <input
                  type="checkbox"
                  value="Others"
                  v-model="form.documents_submitted.documents"
                  class="mr-1"
                  @change="toggleOtherDocuments"
                />
                <span class="text-sm">Others</span>
              </div>
            </div>
          </div>
          <div
            v-if="form.documents_submitted.documents.includes('Others')"
            class="mb-2"
          >
            <label for="otherDocuments" class="block mb-1 text-sm font-semibold">Other Documents:</label>
            <input
              type="text"
              id="otherDocuments"
              v-model="form.documents_submitted.others"
              class="w-full px-2 py-1 border rounded-md text-sm"
            />
          </div>
          <div class="mb-2 col-span-1">
            <label for="generalImpression" class="block mb-1 text-sm">
              General Impression: <span class="text-red-500">*</span>
            </label>
            <input
              type="text"
              id="generalImpression"
              v-model="form.admission.general_impression"
              class="w-full px-2 py-1 border rounded-md text-sm"
              required
            />
          </div>
          <div class="mb-2 col-span-1">
            <label for="actionTaken" class="block mb-1 text-sm">
              Action Taken: <span class="text-red-500">*</span>
            </label>
            <input
              type="text"
              id="actionTaken"
              v-model="form.admission.action_taken"
              class="w-full px-2 py-1 border rounded-md text-sm"
              required
            />
          </div>
        </div>
      </fieldset>

      <!-- Submit Button -->
      <button
        type="submit"
        class="bg-blue-900  text-gray-300 mb-2 mt-4 px-8 py-1 mr-8 ml-16 rounded-md text-sm"
      >
        Save
      </button>
    </form>
    <!-- Notification Modal -->
    <NotificationModal
      :isVisible="showModal"
      :modalType="modalType"
      :message="modalMessage"
      @close="showModal = false"
    />
  </div>
</AppLayout>
</template>


<script setup>
import { ref } from 'vue';
import axios from 'axios';
import NotificationModal from '@/Components/NotificationModal.vue';
import AppLayout from '@/Layouts/AppLayout.vue';



const form = ref({
  client: {
    first_name: '',
    middle_name: '',
    last_name: '',
    sex: 'male',
    date_of_birth: '',
    place_of_birth: '',
    province: '',
    city: '',
    barangay: '',
    street: '',
    religion: ''
  },
  distinguishing_marks: {
    tattoo_scars: '',
    height: '',
    weight: '',
    colour_of_eye: '',
    skin_colour: ''
  },
  admission: {
    committing_court: '',
    crim_case_number: '',
    offense_committed: '',
    date_admitted: '',
    days_in_jail: '',
    days_in_detention_center: '',
    action_taken: '',
    general_impression: ''
  },
  documents_submitted: {
    documents: [],
    others: ''
  }
});

const cities = ref([]);
const barangays = ref([]);

const showModal = ref(false);
const modalType = ref('success');
const modalMessage = ref('');

const saveForm = async () => {
  try {
    const response = await axios.post('/api/save-admission', form.value);
    modalType.value = 'success';
    modalMessage.value = 'Form saved successfully!';
    showModal.value = true;
    resetForm(); // Reset the form after successful save
  } catch (error) {
    modalType.value = 'error';
    modalMessage.value = 'Failed to save form. Please try again.';
    showModal.value = true;
    console.error(error);
  }
};

const resetForm = () => {
  form.value = {
    client: {
        first_name: '',
        middle_name: '',
        last_name: '',
        sex: 'male',
        date_of_birth: '',
        place_of_birth: '',
        province: '',
        city: '',
        barangay: '',
        street: '',
        religion: ''
    },
    distinguishing_marks: {
        tattoo_scars: '',
        height: '',
        weight: '',
        colour_of_eye: '',
        skin_colour: ''
    },
    admission: {
        committing_court: '',
        crim_case_number: '',
        offense_committed: '',
        date_admitted: '',
        days_in_jail: '',
        days_in_detention_center: '',
        action_taken: '',
        general_impression: ''
    },
    documents_submitted: {
        documents: [],
        others: ''
    }
  };
};

const updateCitiesAndBarangays = () => {
    const province = form.value.client.province;
    const provinceCities = {
    "Davao del Norte": ["Tagum City", "Panabo City", "Samal City", "Carmen", "Kapalong", "New Corella", "San Isidro", "Santo Tomas", "Talaingod"],
    "Davao del Sur": ["Davao City", "Digos City", "Bansalan", "Hagonoy", "Kiblawan", "Magsaysay", "Malalag", "Matanao", "Padada", "Santa Cruz", "Sulop"],
    "Davao Oriental": ["Mati City", "Baganga", "Banaybanay", "Boston", "Caraga", "Cateel", "Governor Generoso", "Lupon", "Manay", "San Isidro", "Tarragona"],
    "Davao de Oro": ["Compostela", "Monkayo", "Maco", "Mabini", "Mawab", "Montevista", "Nabunturan", "New Bataan", "Pantukan", "Laak", "Maragusan"],
    "Davao Occidental": ["Malita", "Don Marcelino", "Jose Abad Santos", "Santa Maria", "Sarangani"]
};
    cities.value = provinceCities[province] || [];
    barangays.value = [];
    form.value.client.city = '';
    form.value.client.barangay = '';
};

const updateBarangays = () => {
    const city = form.value.client.city;
    const cityBarangays = {
    
    "Tagum City": ["Apokon", "Bincungan", "Canocotan", "Cuambogan", "La Filipina", "Mankilam", "Magugpo East", "Magugpo North", "Magugpo Poblacion", "Magugpo South", "Magugpo West", "Nueva Fuerza", "Pagsabangan", "Pandapan", "San Agustin", "San Isidro", "Visayan Village"],
    "Panabo City": ["A. O. Floirendo", "Cacao", "Cagangohan", "Consolacion", "Datu Abdul Dadia", "Gredu", "J.P. Laurel", "Katipunan", "Kauswagan", "Kiotoy", "Klinan", "Little Panay", "Lower Panaga", "Mabunao", "Maduao", "Manay", "New Malaga", "New Pandan", "New Visayas", "Nanyo", "Quezon", "Salvacion", "San Francisco", "San Nicolas", "San Pedro", "San Roque", "San Vicente", "Santo Niño", "Sindaton", "Southern Davao", "Tagpore", "Tibungol", "Upper Licanan"],
    "Samal City": ["Adecor", "Aumbay", "Balet", "Caliclic", "Camudmud", "Catagman", "Cawag", "Cogon", "Del Monte", "Liberty", "Limao", "Mambago-A", "Mambago-B", "Miranda", "Moncado", "Peñaplata", "Poblacion", "San Agustin", "San Antonio", "San Isidro", "San Jose", "San Miguel", "Santa Cruz", "Santo Niño", "Sion", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagpopongan", "Tambo"],
    "Carmen": ["Adecor", "Alejal", "Anibongan", "Asuncion", "Ising", "La Paz", "Magsaysay", "Pagsabangan", "Pangyan", "Sabangan", "Salvacion", "San Isidro", "Santo Niño", "Taba", "Tuganay", "Tuganay Proper", "Tubod"],
    "Kapalong": ["Banutan", "Capungagan", "Florida", "Gupitan", "Mamacao", "Maniki", "Maug", "New Agutaya", "Nueva Fuerza", "Pag-asa", "Pag-tulagan", "Pandapan", "Patok", "Poblacion", "Sampao", "San Isidro", "Santo Niño", "Simulao", "Tiburcia", "Upper Tagasan", "Waan"],
    "New Corella": ["Carcor", "Del Pilar", "El Salvador", "Limba-an", "Macgum", "Magsaysay", "Mesaoy", "New Bohol", "Patrocenio", "Poblacion", "San Roque", "Santa Fe", "Santo Niño", "Suawon", "Suaon"],
    "San Isidro": ["Bato", "Binigasan", "Dacudao", "Datu Balong", "Datu Salumay", "Igangon", "Kipalili", "Libuton", "Lumiad", "Mabantao", "Mahayag", "Mamacao", "Manat", "Monte Dujali", "Pagsabangan", "Patag", "Sabangan", "Sampao", "San Roque", "Santa Filomena", "Santo Niño", "Sasa", "Suawon", "Upper Tagasan", "Upper Wangan"],
    "Santo Tomas": ["Balagunan", "Balisong", "Bobongan", "Casig-ang", "Esperanza", "Kinabalan", "Kipilas", "Magwawa", "New Visayas", "Pantaron", "Poblacion", "San Jose", "San Miguel", "San Pedro", "Santo Niño", "Talomo", "Tibal-og"],
    "Talaingod": ["Bayabas", "Dagohoy", "Datu Davao", "Kauswagan", "Nangan", "Panganan", "Pantaron", "San Jose", "Santa Cruz", "Santa Maria", "Santo Niño", "Sulangon"],

    "Davao City": ["Agdao", "Baguio", "Buhangin", "Bunawan", "Calinan", "Marilog", "Poblacion", "Talomo", "Toril", "Tugbok"],
    "Digos City": ["Aplaya", "Balabag", "Binaton", "Cogon", "Colorado", "Dawis", "Goma", "Kapatagan", "Kiagot", "Magsaysay", "Mahayahay", "Matti", "Rizal", "San Jose", "San Miguel", "San Roque", "Sinawilan", "Soong", "Tiguman", "Tres de Mayo", "Zone 1", "Zone 2", "Zone 3", "Zone 4"],
    "Bansalan": ["Anonang", "Bitaug", "Bonifacio", "Cagangohan", "Dumoy", "Eman", "Kinuskusan", "Libertad", "Linawan", "Magsaysay", "Marber", "New Clarin", "New Ilocos", "Poblacion", "Rizal", "Salvador", "San Isidro", "San Miguel", "Santa Maria", "Tinongtongan", "Tubo-Tubo"],
    "Hagonoy": ["Balutakay", "Clib", "Guihing", "Guihing Proper", "Kibanban", "Lanuro", "Lapulabao", "Leling", "Libertad", "Mahayahay", "Malabang", "Malinao", "Malian", "Manguring", "New Iloilo", "Paligue", "Pangyan", "Poblacion", "San Guillermo", "San Isidro", "San Miguel", "San Pedro", "Santa Cruz", "Santa Maria", "Tibungol", "Tibungol Proper"],
    "Kiblawan": ["Abnate", "Bagong Silang", "Balasiao", "Bonifacio", "Bugac", "Buno", "Cogon", "Crossing Digos", "Datalbasak", "Davao-Bongabong", "Eastern Kiblawan", "Guia", "Guinaitan", "Kisupaan", "Libertad", "Lumiad", "Malawanit", "New Clarin", "New Ilocos", "Pangi", "Poblacion", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santo Niño", "Suawon", "Upper Tagasan"],
    "Magsaysay": ["Abnate", "Bagong Silang", "Balnate", "Barayong", "Barobo", "Bato", "Bulatok", "Cogon", "Cuambog", "Dalumay", "Darapuay", "Dasay", "Datalmayahai", "Goma", "Guio-ang", "Igpit", "Kanapulo", "Kibalang", "Kibo", "Kibongot", "Kinuskusan", "Labuyan", "La Fortuna", "Lambajon", "Lapuan", "Lasang", "Lavigan", "Linawan", "Lower Igpit", "Lower Sibulan", "Mal", "Malalag", "Malalag Tubig", "Malinao", "Marber", "Matti", "Mulao", "New Bantayan", "New Clarin", "New Ilocos", "New Katipunan", "Pangi", "Poblacion", "Salid", "Salvador", "San Antonio", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santa Cruz", "Santa Fe", "Santa Maria", "Santa Rita", "Santo Niño", "Sinawilan", "Sinuda", "Suawon", "Tibungol", "Tibungol Proper"],
    "Malalag": ["Bagumbayan", "Balao", "Bolton", "Bulacan", "Bungawan", "Calian", "Caputian", "Del Pilar", "Ilangay", "Ilogon", "Lapu-lapu", "Liberty", "Lomonay", "Mabuhay", "Magsaysay", "Mahipon", "Mal", "Malalag", "Malalag Tubig", "Malinao", "Matanao", "New Clarin", "New Danao", "New Iloilo", "New Israel", "New Sibonga", "Old Clarin", "Old Danao", "Palao", "Paligue", "Panabang", "Patag", "Pikit", "Poblacion", "San Antonio", "San Isidro", "San Jose", "San Juan", "San Miguel", "Santa Cruz", "Santa Filomena", "Santa Maria", "Santa Rita", "Santo Niño", "Sinawilan", "Sinsuat", "Suawon", "Talaingod", "Tamara", "Tambacan", "Tibungol", "Tibungol Proper"],
    "Matanao": ["Bagumbayan", "Bangkal", "Basiawan", "Bato", "Bolton", "Bonifacio", "Bugac", "Calian", "Cogon", "Dacudao", "Dalumpinas", "Darapuay", "Del Pilar", "Eman", "Guia", "Karaos", "Katipunan", "Kinuskusan", "La Paz", "Libertad", "Lower Igpit", "Lower Mal", "Lower Sibulan", "Lumalaleng", "Mabini", "Malalag Tubig", "Malinao", "Marber", "Matanao", "Matti", "New Bantayan", "New Clarin", "New Iloilo", "New Katipunan", "Pangi", "Poblacion", "Salvacion", "San Antonio", "San Isidro", "San Jose", "San Juan", "San Miguel", "San Pedro", "Santa Cruz", "Santa Maria", "Santo Niño", "Sinawilan", "Sinuda", "Suawon", "Tibungol", "Tibungol Proper"],
    "Padada": ["Aplaya", "Bagong Silang", "Barangay 1", "Barangay 2", "Barangay 3", "Barangay 4", "Barangay 5", "Barangay 6", "Barangay 7", "Barangay 8", "Barangay 9", "Barangay 10", "Barangay 11", "Barangay 12", "Barangay 13", "Barangay 14", "Barangay 15", "Barangay 16", "Barangay 17", "Barangay 18", "Barangay 19", "Barangay 20", "Barangay 21", "Barangay 22", "Barangay 23", "Barangay 24", "Barangay 25", "Barangay 26", "Barangay 27", "Barangay 28", "Barangay 29", "Barangay 30", "Barangay 31", "Barangay 32", "Barangay 33", "Barangay 34", "Barangay 35", "Barangay 36", "Barangay 37", "Barangay 38", "Barangay 39", "Barangay 40", "Barangay 41", "Barangay 42", "Barangay 43", "Barangay 44", "Barangay 45", "Barangay 46", "Barangay 47", "Barangay 48", "Barangay 49", "Barangay 50", "Barangay 51", "Barangay 52", "Barangay 53", "Barangay 54", "Barangay 55", "Barangay 56", "Barangay 57", "Barangay 58", "Barangay 59", "Barangay 60", "Barangay 61", "Barangay 62", "Barangay 63", "Barangay 64", "Barangay 65", "Barangay 66", "Barangay 67", "Barangay 68", "Barangay 69", "Barangay 70", "Barangay 71", "Barangay 72", "Barangay 73", "Barangay 74", "Barangay 75", "Barangay 76", "Barangay 77", "Barangay 78", "Barangay 79", "Barangay 80", "Barangay 81", "Barangay 82", "Barangay 83", "Barangay 84", "Barangay 85", "Barangay 86", "Barangay 87", "Barangay 88", "Barangay 89", "Barangay 90", "Barangay 91", "Barangay 92", "Barangay 93", "Barangay 94", "Barangay 95", "Barangay 96", "Barangay 97", "Barangay 98", "Barangay 99", "Barangay 100"],
    "Santa Cruz": ["Astorga", "Bato", "Bucana", "Calinan", "Calinan Proper", "Canocotan", "Carmen", "Catigan", "Darong", "Davao-Bukidnon Road", "Digos", "Goma", "Guinobatan", "Inawayan", "Ising", "Junction Digos", "Kibuaya", "Labangal", "Lambajon", "Lavigan", "Linao", "Magbukuan", "Mahayag", "Malabog", "Malalag Tubig", "Malasila", "Malinao", "Mapua", "Matanao", "Matiao", "New Clarin", "New Iloilo", "New Katipunan", "Pangi", "Poblacion", "San Agustin", "San Antonio", "San Isidro", "San Jose", "San Miguel", "Santa Cruz", "Santa Maria", "Santa Rita", "Santo Niño", "Sinawilan", "Sinuda", "Suawon", "Tibungol", "Tibungol Proper"],
    "Sulop": ["Bagong Silang", "Balabag", "Basiawan", "Bato", "Bolton", "Bugac", "Calian", "Cogon", "Dacudao", "Dalumpinas", "Darapuay", "Del Pilar", "Eman", "Guia", "Karaos", "Katipunan", "Kinuskusan", "La Paz", "Libertad", "Lower Igpit", "Lower Mal", "Lower Sibulan", "Lumalaleng", "Mabini", "Malalag Tubig", "Malinao", "Marber", "Matanao", "Matti", "New Bantayan", "New Clarin", "New Iloilo", "New Katipunan", "Pangi", "Poblacion", "Salvacion", "San Antonio", "San Isidro", "San Jose", "San Juan", "San Miguel", "San Pedro", "Santa Cruz", "Santa Maria", "Santo Niño", "Sinawilan", "Sinuda", "Suawon", "Tibungol", "Tibungol Proper"],

    "Mati City": ["Barangay Central", "Barangay Dahican", "Barangay Dawan", "Barangay Macambol", "Barangay Matiao", "Barangay Sainz", "Barangay Sanghay", "Barangay Tagbinonga"],
    "Baganga": ["Barangay Campawan", "Barangay Dapnan", "Barangay Kinablangan", "Barangay Lambajon", "Barangay Mahan-ub", "Barangay San Isidro"],
    "Banaybanay": ["Barangay Cabangcalan", "Barangay Calubihan", "Barangay Causwagan", "Barangay Panikian", "Barangay Pintatagan", "Barangay Poblacion", "Barangay Piso"],
    "Boston": ["Barangay Cabacungan", "Barangay Caatihan", "Barangay Cawayanan", "Barangay Sibahay", "Barangay Simulao"],
    "Caraga": ["Barangay Dapnan", "Barangay Matikad", "Barangay Pichon", "Barangay Poblacion", "Barangay San Luis"],
    "Cateel": ["Barangay Abijod", "Barangay Aliwagwag", "Barangay Aragon", "Barangay Baybay", "Barangay Maglahus", "Barangay Mainit", "Barangay San Alfonso", "Barangay San Antonio", "Barangay San Isidro"],
    "Governor Generoso": ["Barangay Anitap", "Barangay Don Aurelio Chicote", "Barangay Don Mariano Marcos", "Barangay Lavigan", "Barangay Manuel Roxas", "Barangay Pundaguitan", "Barangay Santiago", "Barangay Sigaboy", "Barangay Surop"],
    "Lupon": ["Barangay Bagumbayan", "Barangay Banaybanay", "Barangay Calapagan", "Barangay Cocornon", "Barangay Langka", "Barangay Lapulapu", "Barangay Macangao", "Barangay Mahayag", "Barangay Marayag", "Barangay New Visayas", "Barangay Poblacion", "Barangay San Isidro", "Barangay San Vicente"],
    "Manay": ["Barangay Cabacungan", "Barangay Caatihan", "Barangay Cawayanan", "Barangay Central", "Barangay Cugman", "Barangay Del Pilar", "Barangay Lambajon", "Barangay Matiao", "Barangay Panikian", "Barangay Poblacion", "Barangay San Ignacio", "Barangay San Isidro"],
    "San Isidro": ["Barangay Abijod", "Barangay Aliwagwag", "Barangay Aragon", "Barangay Bagumbayan", "Barangay Cabacungan", "Barangay Caatihan", "Barangay Calapagan", "Barangay Cawayanan", "Barangay Central", "Barangay Cugman", "Barangay Del Pilar", "Barangay Kinablangan", "Barangay Lambajon", "Barangay Lapulapu", "Barangay Macangao", "Barangay Mahayag", "Barangay Marayag", "Barangay Matiao", "Barangay Panikian", "Barangay Pichon", "Barangay Poblacion", "Barangay San Ignacio", "Barangay San Isidro", "Barangay San Luis", "Barangay San Vicente"],
    "Tarragona": ["Barangay Cabangcalan", "Barangay Calubihan", "Barangay Causwagan", "Barangay Central", "Barangay Dapnan", "Barangay Lambajon", "Barangay Langka", "Barangay Lavigan", "Barangay Matikad", "Barangay Pichon", "Barangay Poblacion", "Barangay San Ignacio", "Barangay San Isidro", "Barangay San Luis", "Barangay San Vicente", "Barangay Sainz", "Barangay Sanghay", "Barangay Tagbinonga"],

    "Compostela": ["Barangay Gabi", "Barangay Lagab", "Barangay Mangayon", "Barangay Mapaca", "Barangay Maparat", "Barangay Ngan", "Barangay Osmeña", "Barangay Panansalan", "Barangay San Miguel", "Barangay San Roque", "Barangay Santa Fe", "Barangay Siocon", "Barangay Tamia", "Barangay Tibagon"],
    "Monkayo": ["Barangay Awao", "Barangay Banlag", "Barangay Baylo", "Barangay Casoon", "Barangay Haguimitan", "Barangay Inambatan", "Barangay Katipunan", "Barangay Macopa", "Barangay Olaycon", "Barangay Pasian", "Barangay Poblacion", "Barangay Rizal", "Barangay Salvacion", "Barangay San Isidro", "Barangay San Jose", "Barangay Santa Fe", "Barangay Santo Niño", "Barangay Union"],
    "Maco": ["Barangay Anibongan", "Barangay Apo", "Barangay Balabac", "Barangay Calabcab", "Barangay Del Pilar", "Barangay Gubatan", "Barangay Igangon", "Barangay Linoan", "Barangay Lumbo", "Barangay Magangit", "Barangay Manat", "Barangay Masara", "Barangay New Barili", "Barangay Pangi", "Barangay Pindasan", "Barangay Poblacion", "Barangay San Isidro", "Barangay San Juan", "Barangay Santa Cruz", "Barangay Santo Niño", "Barangay Taglawig", "Barangay Teresa"],
    "Mabini": ["Barangay Cabuyuan", "Barangay Cuambog", "Barangay Del Pilar", "Barangay Elizalde", "Barangay Anitap", "Barangay New Barili", "Barangay Pindasan", "Barangay Poblacion", "Barangay San Antonio", "Barangay San Isidro", "Barangay Santa Cruz", "Barangay Santo Niño", "Barangay Tagbinonga", "Barangay Teresa"],
    "Mawab": ["Barangay Anibongan", "Barangay Apo", "Barangay Balabac", "Barangay Calabcab", "Barangay Del Pilar", "Barangay Gubatan", "Barangay Igangon", "Barangay Linoan", "Barangay Lumbo", "Barangay Magangit", "Barangay Manat", "Barangay Masara", "Barangay New Barili", "Barangay Pangi", "Barangay Pindasan", "Barangay Poblacion", "Barangay San Isidro", "Barangay San Juan", "Barangay Santa Cruz", "Barangay Santo Niño", "Barangay Taglawig", "Barangay Teresa"],
    "Montevista": ["Barangay Anibongan", "Barangay Apo", "Barangay Balabac", "Barangay Calabcab", "Barangay Del Pilar", "Barangay Gubatan", "Barangay Igangon", "Barangay Linoan", "Barangay Lumbo", "Barangay Magangit", "Barangay Manat", "Barangay Masara", "Barangay New Barili", "Barangay Pangi", "Barangay Pindasan", "Barangay Poblacion", "Barangay San Isidro", "Barangay San Juan", "Barangay Santa Cruz", "Barangay Santo Niño", "Barangay Taglawig", "Barangay Teresa"],
    "Nabunturan": ["Barangay Anibongan", "Barangay Apo", "Barangay Balabac", "Barangay Calabcab", "Barangay Del Pilar", "Barangay Gubatan", "Barangay Igangon", "Barangay Linoan", "Barangay Lumbo", "Barangay Magangit", "Barangay Manat", "Barangay Masara", "Barangay New Barili", "Barangay Pangi", "Barangay Pindasan", "Barangay Poblacion", "Barangay San Isidro", "Barangay San Juan", "Barangay Santa Cruz", "Barangay Santo Niño", "Barangay Taglawig", "Barangay Teresa"],
    "New Bataan": ["Barangay Anibongan", "Barangay Apo", "Barangay Balabac", "Barangay Calabcab", "Barangay Del Pilar", "Barangay Gubatan", "Barangay Igangon", "Barangay Linoan", "Barangay Lumbo", "Barangay Magangit", "Barangay Manat", "Barangay Masara", "Barangay New Barili", "Barangay Pangi", "Barangay Pindasan", "Barangay Poblacion", "Barangay San Isidro", "Barangay San Juan", "Barangay Santa Cruz", "Barangay Santo Niño", "Barangay Taglawig", "Barangay Teresa"],
    "Pantukan": ["Barangay Anibongan", "Barangay Apo", "Barangay Balabac", "Barangay Calabcab", "Barangay Del Pilar", "Barangay Gubatan", "Barangay Igangon", "Barangay Linoan", "Barangay Lumbo", "Barangay Magangit", "Barangay Manat", "Barangay Masara", "Barangay New Barili", "Barangay Pangi", "Barangay Pindasan", "Barangay Poblacion", "Barangay San Isidro", "Barangay San Juan", "Barangay Santa Cruz", "Barangay Santo Niño", "Barangay Taglawig", "Barangay Teresa"],
    "Laak": ["Barangay Anibongan", "Barangay Apo", "Barangay Balabac", "Barangay Calabcab", "Barangay Del Pilar", "Barangay Gubatan", "Barangay Igangon", "Barangay Linoan", "Barangay Lumbo", "Barangay Magangit", "Barangay Manat", "Barangay Masara", "Barangay New Barili", "Barangay Pangi", "Barangay Pindasan", "Barangay Poblacion", "Barangay San Isidro", "Barangay San Juan", "Barangay Santa Cruz", "Barangay Santo Niño", "Barangay Taglawig", "Barangay Teresa"],
    "Maragusan": ["Barangay Anibongan", "Barangay Apo", "Barangay Balabac", "Barangay Calabcab", "Barangay Del Pilar", "Barangay Gubatan", "Barangay Igangon", "Barangay Linoan", "Barangay Lumbo", "Barangay Magangit", "Barangay Manat", "Barangay Masara", "Barangay New Barili", "Barangay Pangi", "Barangay Pindasan", "Barangay Poblacion", "Barangay San Isidro", "Barangay San Juan", "Barangay Santa Cruz", "Barangay Santo Niño", "Barangay Taglawig", "Barangay Teresa"],

    "Malita": ["Barangay Bitoon", "Barangay Buhangin", "Barangay Calian", "Barangay Culaman", "Barangay Datu Danwata", "Barangay Demoloc", "Barangay Kidalapong", "Barangay Kilalag", "Barangay Lacaron", "Barangay Lais", "Barangay Lagumit", "Barangay Little Baguio", "Barangay Litos", "Barangay Macol", "Barangay Mana", "Barangay Pangaleon", "Barangay Pinalpalan", "Barangay Poblacion", "Barangay Sangay", "Barangay Talogoy", "Barangay Tubalan"],
    "Don Marcelino": ["Barangay Baluntaya", "Barangay Calian", "Barangay Dalupan", "Barangay Kinanga", "Barangay Kiwanan", "Barangay Lacaron", "Barangay Lapuan", "Barangay Litos", "Barangay Mabuhay", "Barangay Malalan", "Barangay Manuel Peralta", "Barangay Nueva Villa", "Barangay Pinalpalan", "Barangay Poblacion", "Barangay San Isidro", "Barangay San Juan", "Barangay Santo Niño", "Barangay Sugal", "Barangay Talagutong", "Barangay Taytayan"],
    "Jose Abad Santos": ["Barangay Abaran", "Barangay Buguis", "Barangay Caburan", "Barangay Calian", "Barangay Culaman", "Barangay Demoloc", "Barangay La Paz", "Barangay Lacaron", "Barangay Macol", "Barangay Malalan", "Barangay Malibato", "Barangay Malita", "Barangay Marapangi", "Barangay Pinalpalan", "Barangay Poblacion", "Barangay Sangay", "Barangay Sarangani", "Barangay Talogoy", "Barangay Tubalan", "Barangay Upper Tubalan"],
    "Santa Maria": ["Barangay Basiawan", "Barangay Datu Danwata", "Barangay Demoloc", "Barangay Kialeg", "Barangay Kinanga", "Barangay Kiwanan", "Barangay Lacaron", "Barangay Lais", "Barangay Little Baguio", "Barangay Mana", "Barangay Nueva Villa", "Barangay Pinalpalan", "Barangay Poblacion", "Barangay San Antonio", "Barangay San Isidro", "Barangay Santa Cruz", "Barangay Santo Niño", "Barangay Sugal", "Barangay Talogoy", "Barangay Tubalan", "Barangay Upper Tubalan"],
    "Sarangani": ["Barangay Anibongan", "Barangay Apo", "Barangay Balabac", "Barangay Calabcab", "Barangay Del Pilar", "Barangay Gubatan", "Barangay Igangon", "Barangay Linoan", "Barangay Lumbo", "Barangay Magangit", "Barangay Manat", "Barangay Masara", "Barangay New Barili", "Barangay Pangi", "Barangay Pindasan", "Barangay Poblacion", "Barangay San Isidro", "Barangay San Juan", "Barangay Santa Cruz", "Barangay Santo Niño", "Barangay Taglawig", "Barangay Teresa"]
};;
  barangays.value = cityBarangays[city] || [];
  form.value.client.barangay = '';
};

const toggleOtherDocuments = () => {
  if (!form.value.documents_submitted.documents.includes('Others')) {
    form.value.documents_submitted.others = '';
  }
};
</script>

<style scoped>
/* Add your styles here */
</style>