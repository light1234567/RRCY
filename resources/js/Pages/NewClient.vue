<template>
  <AppLayout title="New Client">
    <template #header>
      <div class="flex items-center">
        <div class="ml-5 w-2 h-6 bg-gray-400 mr-3"></div>
        <i class="fa fa-user-plus ml-6 text-xl mr-2"></i>
        <h1 class="ml-4 text-lg font-bold text-red-800">Admission Form/New Client</h1>
      </div>
    </template>

    <div class="">
      <h1 class="text-lg p-1 text-customBlue ml-10 font-bold mb-4"></h1>
      <form @submit.prevent="saveForm">
        
        <!-- Client Information -->
        <fieldset class="bg-white border shadow-md p-4 mb-2 mr-8 ml-16 rounded-sm">
          <legend class="text-base bg-blue-900 text-gray-300 pl-2 pr-2 pt-1 pb-1 rounded-sm font-bold">CLIENT INFORMATION</legend>
          
          <div class="grid grid-cols-1">
            <!-- Name, Suffix, and Sex using a Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-2 mb-2">
              <div class="mb-2">
                <label for="clientFirstName" class="block mb-1 text-sm">
                  First Name: <span class="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  id="clientFirstName"
                  v-model="form.client.first_name"
                  @input="removeNumbers('first_name')"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  required
                />
              </div>
              <div class="mb-2">
                <label for="clientMiddleName" class="block mb-1 text-sm">Middle Name:</label>
                <input
                  type="text"
                  id="clientMiddleName"
                  v-model="form.client.middle_name"
                  @input="removeNumbers('middle_name')"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                />
              </div>
              <div class="mb-2">
                <label for="clientLastName" class="block mb-1 text-sm">
                  Last Name: <span class="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  id="clientLastName"
                  v-model="form.client.last_name"
                  @input="removeNumbers('last_name')"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  required
                />
              </div>
              <div class="mb-2">
                <label for="clientSuffix" class="block mb-1 text-sm">
                  Suffix:
                </label>
                <select
                  id="clientSuffix"
                  v-model="form.client.suffix"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                >
                  <option value="">Select Suffix</option>
                  <option value="Jr.">Jr.</option>
                  <option value="I">I</option>
                  <option value="II">II</option>
                  <option value="III">III</option>
                  <option value="IV">IV</option>
                  <option value="V">V</option>
                  
                </select>
              </div>
            </div>

            <!-- Date of Birth, Place of Birth, Sex, and Child Status -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-2 mb-2">
              <div class="mb-2">
                <label for="clientDob" class="block mb-1 text-sm">
                  Date of Birth: <span class="text-red-500">*</span>
                </label>
                <input
                  type="date"
                  id="clientDob"
                  v-model="form.client.date_of_birth"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  :max="form.client.maxDateOfBirth"
                  :min="form.client.minDateOfBirth"
                  required
                />
              </div>
              <div class="mb-2">
                <label for="clientPlaceOfBirth" class="block mb-1 text-sm">
                  Place of Birth: <span class="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  id="clientPlaceOfBirth"
                  v-model="form.client.place_of_birth"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  placeholder="City/Province"
                  required
                />
              </div>

              <div class="mb-2">
                <label for="child_status" class="block mb-1 text-sm">
                  Child Status <span class="text-red-500">*</span>
                </label>
                <select
                  id="child_status"
                  v-model="form.client.child_status"
                  :class="statusColorClass"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  required
                >
                  <option value="">Select Child Status</option>
                  <option value="Still at the Center (SATC)">Still at the Center (SATC)</option>
                  <option value="Discharge">Discharge</option>
                  <option value="Leave without Permission (LWOP)">Leave without Permission (LWOP)</option>
                </select>
              </div>
              <div class="mb-2">
                <label for="clientSex" class="block mb-1 text-sm">
                  Sex: <span class="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  id="clientSex"
                  v-model="form.client.sex"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  readonly
                  required
                />
              </div>
            </div>

            <!-- Address Breakdown with Cascading Dropdowns -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
              <div class="mb-2">
                <label for="clientProvince" class="block mb-1 text-sm">
                  Province: <span class="text-red-500">*</span>
                </label>
                <select
                  id="clientProvince"
                  v-model="form.client.province"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  @change="onProvinceChange"
                  required
                >
                  <option value="">Select Province</option>
                  <option v-for="province in provinces" :key="province.psgc" :value="province.col_province">
                    {{ province.col_province }}
                  </option>
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
                  @change="onCityChange"
                  :disabled="!form.client.province"
                  required
                >
                  <option value="">Select City/Municipality</option>
                  <option v-for="citymuni in cityMunis" :key="citymuni.psgc" :value="citymuni.col_citymuni">
                    {{ citymuni.col_citymuni }}
                  </option>
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
                  :disabled="!form.client.city"
                  required
                >
                  <option value="">Select Barangay</option>
                  <option v-for="brgy in barangays" :key="brgy.psgc" :value="brgy.col_brgy">
                    {{ brgy.col_brgy }}
                  </option>
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
      <option value="">Select Religion</option>
      <option value="Christianity">Christianity</option>
      <option value="Islam">Islam</option>
      <option value="Buddhism">Buddhism</option>
      <option value="Hinduism">Hinduism</option>
      <option value="Judaism">Judaism</option>
      <option value="Other">Other</option>
    </select>
  </div>

  <!-- Conditional text input when 'Other' is selected -->
  <div class="mb-2" v-if="form.client.religion === 'Other'">
    <label for="customReligion" class="block mb-1 text-sm">
      Please specify: <span class="text-red-500">*</span>
    </label>
    <input
      type="text"
      id="customReligion"
      v-model="form.client.customReligion"
      class="w-full px-2 py-1 border rounded-md text-sm"
      placeholder="Enter your religion"
      required
    />
  </div>
</div>

          </div>
        </fieldset>

        <!-- Distinguishing Marks -->
        <fieldset class="border shadow-md bg-white p-4 mb-2 mr-8 ml-16 mt-8 rounded-sm">
          <legend class="text-base bg-blue-900 text-gray-300 pl-2 pr-2 pt-1 pb-1 rounded-sm font-bold mb-2">
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
                  max="999"  
                  min="0"    
                />
              </div>
              <div class="mb-2">
                <label for="weight" class="block mb-1 text-sm">Weight (kg):</label>
                <input
                  type="number"
                  id="weight"
                  v-model="form.distinguishing_marks.weight"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  max="999" 
                />
              </div>
              <div class="mb-2">
              <label for="colourOfEye" class="block mb-1 text-sm">Colour of Eye:</label>
              <select
                id="colourOfEye"
                v-model="form.distinguishing_marks.colour_of_eye"
                class="w-full px-2 py-1 border rounded-md text-sm"
              >
                <option value="">Select Colour</option>
                <option value="Brown">Brown</option>
                <option value="Blue">Blue</option>
                <option value="Green">Green</option>
                <option value="Hazel">Black</option>
                <option value="Gray">Gray</option>
                <option value="Amber">Amber</option>
                
              </select>
            </div>
            <div class="mb-2">
              <label for="skinColour" class="block mb-1 text-sm">Skin Colour:</label>
              <select
                id="skinColour"
                v-model="form.distinguishing_marks.skin_colour"
                class="w-full px-2 py-1 border rounded-md text-sm"
              >
                <option value="">Select Skin Colour</option>
                <option value="Light">Light</option>
                <option value="Fair">Fair</option>
                <option value="Medium">Medium</option>
                <option value="Olive">Olive</option>
                <option value="Brown">Brown</option>
                <option value="Dark">Dark</option>
                <option value="Other">Other</option>
              </select>
            </div>
          </div>
        </fieldset>

         <!-- Admission Details -->
         <fieldset class="border shadow-md bg-white p-4 mb-2 mt-8 mr-8 ml-16 rounded-sm">
          <legend class="text-base bg-blue-900 text-gray-300 pl-2 pr-2 pt-1 pb-1 rounded-sm font-bold mb-2">ADMISSION DETAILS</legend>
         
          <div class="grid grid-cols-1 gap-2">
            <div class="mb-2 col-span-1">
          <label for="committingCourt" class="block mb-1 text-sm">
            Committing Court: <span class="text-red-500">*</span>
          </label>
          <select
            id="committingCourt"
            v-model="form.admission.committing_court"
            class="w-full px-2 py-1 border rounded-md text-sm"
            required
          >
            <option value="">Select Committing Court</option>
            <option value="Supreme Court of the Philippines">Supreme Court of the Philippines</option>
            <option value="Court of Appeals">Court of Appeals</option>
            <option value="Sandiganbayan">Sandiganbayan</option>
            <option value="Court of Tax Appeals">Court of Tax Appeals</option>
            <option value="Regional Trial Court">Regional Trial Court</option>
            <option value="Metropolitan Trial Court">Metropolitan Trial Court</option>
            <option value="Municipal Trial Court">Municipal Trial Court</option>
            <option value="Municipal Circuit Trial Court">Municipal Circuit Trial Court</option>
            <option value="Shari'a District Court">Shari'a District Court</option>
            <option value="Shari'a Circuit Court">Shari'a Circuit Court</option>
            <option value="Other">Other</option>
          </select>
        </div>

        <!-- Optional custom input for 'Other' court -->
        <div class="mb-2 col-span-1" v-if="form.admission.committing_court === 'Other'">
          <label for="customCommittingCourt" class="block mb-1 text-sm">
            Specify Committing Court: <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            id="customCommittingCourt"
            v-model="form.admission.custom_committing_court"
            class="w-full px-2 py-1 border rounded-md text-sm"
            placeholder="Enter court name"
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
                <input
                  type="text"
                  id="offenseCommitted"
                  v-model="form.admission.offense_committed"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  required
                />
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
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
              <div class="mb-2">
                <label for="case_status" class="block mb-1 text-sm">
                  Case Status <span class="text-red-500">*</span>
                </label>
                <select
                  id="case_status"
                  v-model="form.admission.case_status"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  required
                >
                  <option value="">Select Case Status</option>
                  <option value="On trial">On trial</option>
                  <option value="Suspended sentence">Suspended sentence</option>
                  <option value="Acquitted">Acquitted</option>
                  <option value="Dismissed">Dismissed</option>
                  <option value="Provisionally Dismissed">Provisionally Dismissed</option>
                  <option value="Rehabilitation">Rehabilitation</option>
                  <option value="Diversion">Diversion</option>
                  <option value="Disposition Measure">Disposition Measure</option>
                  <option value="Child-at-risk (CAR)">Child-at-risk (CAR)</option>
                </select>
              </div>

            </div>
          </div>
        </fieldset>

        <!-- Documents Submitted -->
        <fieldset class="border bg-white shadow-md p-4 mb-2 mt-8 mr-8 ml-16 rounded-sm">
          <legend class="text-base bg-blue-900 text-gray-300 pl-2 pr-2 pt-1 pb-1 rounded-sm font-bold mb-2">DOCUMENTS SUBMITTED</legend>
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

           <!-- New Fields for Referring Party and Admitting Officer -->
           <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
      <div class="mb-2">
        <label for="referringParty" class="block mb-1 text-sm">Name & Signature of Referring Party:</label>
        <input
          type="text"
          id="referringParty"
          v-model="form.admission.referring_party_name"
          class="w-full px-2 py-1 border rounded-md text-sm"
        />
      </div>

      <div class="mb-2">
        <label for="admittingOfficer" class="block mb-1 text-sm">Admitting Officer:</label>
        <input
          type="text"
          id="admittingOfficer"
          v-model="form.admission.admitting_officer"
          class="w-full px-2 py-1 border rounded-md text-sm"
        />
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
      <div class="mb-2">
        <label for="designationContact" class="block mb-1 text-sm">Designation / ID No. / Contact #:</label>
        <input
          type="text"
          id="designationContact"
          v-model="form.admission.designation_id_contact"
          class="w-full px-2 py-1 border rounded-md text-sm"
        />
      </div>

      <div class="mb-2">
        <label for="designation" class="block mb-1 text-sm">Designation:</label>
        <input
          type="text"
          id="designation"
          v-model="form.admission.designation"
          class="w-full px-2 py-1 border rounded-md text-sm"
        />
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
      <div class="mb-2">
        <label for="officeAddress" class="block mb-1 text-sm">Complete Address/Office Address:</label>
        <input
          type="text"
          id="officeAddress"
          v-model="form.admission.office_address"
          class="w-full px-2 py-1 border rounded-md text-sm"
        />
      </div>

      <div class="mb-2">
        <label for="dateTime" class="block mb-1 text-sm">Date/Time:</label>
        <input
          type="datetime-local"
          id="dateTime"
          v-model="form.admission.date_time"
          class="w-full px-2 py-1 border rounded-md text-sm"
        />
      </div>
    </div>

    <div class="mb-2">
        <label for="notedBy" class="block mb-1 text-sm">Noted by:</label>
        <input
          type="text"
          id="notedBy"
          v-model="form.admission.center_head"
          class="w-full px-2 py-1 border rounded-md text-sm"
        />
      </div>
    

        </fieldset>

       


        <!-- Submit Button -->
        <button
          type="submit"
          class="bg-blue-900 text-gray-300 mb-2 mt-4 px-8 py-1 mr-8 ml-16 rounded-md text-sm"
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
import { ref, watch, onMounted, computed } from 'vue';
import axios from 'axios';
import NotificationModal from '@/Components/NotificationModal.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const form = ref({
  client: {
    first_name: '',
    middle_name: '',
    last_name: '',
    suffix: ' ',
    sex: 'Male',
    date_of_birth: '',
    place_of_birth: '',
    province: '',
    city: '',
    barangay: '',
    street: '',
    religion: '',
    child_status: '',
    maxDateOfBirth: '',
    minDateOfBirth: '', 
  },
  distinguishing_marks: {
    tattoo_scars: '',
    height: '',
    weight: '',
    colour_of_eye: '',
    skin_colour: ''
  },
  admission: {
    case_status: '',
    committing_court: '',
    crim_case_number: '',
    offense_committed: '',
    date_admitted: '',
    days_in_jail: '',
    days_in_detention_center: '',
    action_taken: '',
    general_impression: '',
    referring_party_name: '',
    admitting_officer: '',
    designation_id_contact: '',
    designation: '',
    office_address: '',
    date_time: '',
    center_head: '',
  },
  documents_submitted: {
    documents: [],
    others: ''
  }
});

const provinces = ref([]);
const cityMunis = ref([]);
const barangays = ref([]);

const showModal = ref(false);
const modalType = ref('success');
const modalMessage = ref('');

// Function to fetch provinces
const fetchProvinces = async () => {
  try {
    const response = await axios.get('/provinces');
    provinces.value = response.data;
  } catch (error) {
    console.error('Error fetching provinces:', error);
  }
};

// Handle province selection change
const onProvinceChange = async () => {
  const selectedProvince = provinces.value.find(p => p.col_province === form.value.client.province);
  if (selectedProvince) {
    try {
      const response = await axios.get(`/citymunis/${selectedProvince.psgc}`);
      cityMunis.value = response.data;
      form.value.client.city = ''; // Reset city selection
      form.value.client.barangay = ''; // Reset barangay selection
      barangays.value = []; // Clear barangays
    } catch (error) {
      console.error('Error fetching city/municipalities:', error);
    }
  }
};

// Method to remove numbers from input
const removeNumbers = (field) => {
  form.value.client[field] = form.value.client[field].replace(/[0-9]/g, '');
};

// Handle city selection change
const onCityChange = async () => {
  const selectedCity = cityMunis.value.find(c => c.col_citymuni === form.value.client.city);
  if (selectedCity) {
    try {
      const response = await axios.get(`/barangays/${selectedCity.psgc}`);
      barangays.value = response.data;
      form.value.client.barangay = ''; // Reset barangay selection
    } catch (error) {
      console.error('Error fetching barangays:', error);
    }
  }
};

// Save form data
// Function to save the form data
const saveForm = async () => {
  try {
    const formData = new FormData();

    // Append client data
    Object.keys(form.value.client).forEach((key) => {
      formData.append(`client[${key}]`, form.value.client[key]);
    });

    // Append admission data
    Object.keys(form.value.admission).forEach((key) => {
        formData.append(`admission[${key}]`, form.value.admission[key]);
      
    });

    // Append distinguishing marks data
    Object.keys(form.value.distinguishing_marks).forEach((key) => {
      formData.append(`distinguishing_marks[${key}]`, form.value.distinguishing_marks[key]);
    });

    // Prepare documents array without the "Others" literal value
    const documentsWithoutOthers = form.value.documents_submitted.documents.filter(doc => doc !== 'Others');

    // Append documents submitted data (excluding "Others")
    documentsWithoutOthers.forEach((doc, index) => {
      formData.append(`documents_submitted[documents][${index}]`, doc);
    });

    // Append the "Others" document field if it exists
    if (form.value.documents_submitted.others) {
      formData.append(`documents_submitted[others]`, form.value.documents_submitted.others);
    }

    // Send the form data as FormData
    const response = await axios.post('/api/save-admission', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });

    // Show success message
    modalType.value = 'success';
    modalMessage.value = 'Form saved successfully!';
    showModal.value = true;

    // Optionally reset form after successful save
    resetForm();

  } catch (error) {
    // Handle errors
    if (error.response && error.response.status === 400) {
      if (error.response.data.error === 'Client with the same first name, last name, and date admitted already exists.') {
        modalType.value = 'error';
        modalMessage.value = 'CICL is already existed!';
      } else {
        modalType.value = 'error';
        modalMessage.value = 'An error occurred while saving the form. Please try again.';
      }
    } else {
      modalType.value = 'error';
      modalMessage.value = 'An unexpected error occurred. Please try again.';
    }
    showModal.value = true;
  }
};

// Set the min and max dates for the date of birth
onMounted(() => {
  const today = new Date();

  // Calculate the year when someone would be 10 years old today
  const maxYear = today.getFullYear() - 10;
  const maxDate = new Date(maxYear, 11, 31); // Set to December 31 of that year
  form.value.client.maxDateOfBirth = maxDate.toISOString().split('T')[0];

  // Calculate the year when someone would be 25 years old today
  const minYear = today.getFullYear() - 25;
  const minDate = new Date(minYear, 0, 1); // Set to January 1 of that year
  form.value.client.minDateOfBirth = minDate.toISOString().split('T')[0];
});

// Watcher to limit height input to three digits
watch(
  () => form.value.distinguishing_marks.height,
  (newValue) => {
    if (newValue && newValue > 999) {
      form.value.distinguishing_marks.height = 999; // Set maximum to 999
    } else if (newValue && newValue.toString().length > 3) {
      form.value.distinguishing_marks.height = parseInt(newValue.toString().slice(0, 3), 10);
    }
  }
);

// Watcher to limit weight input to three digits
watch(
  () => form.value.distinguishing_marks.weight,
  (newValue) => {
    if (newValue && newValue > 999) {
      form.value.distinguishing_marks.weight = 999; // Set maximum to 999
    } else if (newValue && newValue.toString().length > 3) {
      form.value.distinguishing_marks.weight = parseInt(newValue.toString().slice(0, 3), 10);
    }
  }
);

// Computed property to return the appropriate color class based on the child status
const statusColorClass = computed(() => {
  switch (form.value.client.child_status) {
    case 'Still at the Center (SATC)':
      return 'bg-green-100 text-green-800'; // Green background for SATC
    case 'Discharge':
      return 'bg-blue-100 text-blue-800'; // Blue background for Discharge
    case 'Leave without Permission (LWOP)':
      return 'bg-red-100 text-red-800'; // Red background for LWOP
    default:
      return 'bg-white text-black'; // Default color for no selection
  }
});

// Reset the form to initial state while keeping date of birth constraints
const resetForm = () => {
  form.value = {
    client: {
      first_name: '',
      middle_name: '',
      last_name: '',
      suffix: '',
      sex: 'Male',
      date_of_birth: '',
      place_of_birth: '',
      province: '',
      city: '',
      barangay: '',
      street: '',
      religion: '',
      child_status: '',
      maxDateOfBirth: form.value.client.maxDateOfBirth, // Keep the max date of birth
      minDateOfBirth: form.value.client.minDateOfBirth, // Keep the min date of birth
    },
    distinguishing_marks: {
      tattoo_scars: '',
      height: '',
      weight: '',
      colour_of_eye: '',
      skin_colour: ''
    },
    admission: {
      case_status: '',
      committing_court: '',
      crim_case_number: '',
      offense_committed: '',
      date_admitted: '',
      days_in_jail: '',
      days_in_detention_center: '',
      action_taken: '',
      general_impression: '',
      referring_party_name: '',
      admitting_officer: '',
      designation_id_contact: '',
      designation: '',
      office_address: '',
      date_time: '',
      center_head: '',
  
    },
    documents_submitted: {
      documents: [],
      others: ''
    }
  };

};


// Function to handle "Other" document selection
const toggleOtherDocuments = () => {
  if (!form.value.documents_submitted.documents.includes('Others')) {
    form.value.documents_submitted.others = '';
  }
};

// Load provinces when the component is mounted
onMounted(fetchProvinces);
</script>