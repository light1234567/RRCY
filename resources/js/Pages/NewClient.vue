<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h1 class="ml-12 text-lg font-bold text-red-800">ADMISSION FORM/NEW CLIENT</h1>
    </template>
    <div style="background-image: url(''); background-size: cover; background-position: center;">
      <h1 class="text-lg p-1 text-customBlue ml-10 font-bold mb-4"></h1>
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
                <input
                  type="text"
                  id="clientSex"
                  v-model="form.client.sex"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  required
                  placeholder="Enter Sex"
                />
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
                <input
                  type="text"
                  id="clientReligion"
                  v-model="form.client.religion"
                  class="w-full px-2 py-1 border rounded-md text-sm"
                  required
                  placeholder="Enter Religion"
                />
              </div>
            </div>
          </div>
        </fieldset>

        <!-- Distinguishing Marks -->
        <fieldset class="border border-blue-900 p-4 mb-2 mr-8 ml-16 mt-8 rounded-sm">
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
              <input
                type="text"
                id="colourOfEye"
                v-model="form.distinguishing_marks.colour_of_eye"
                class="w-full px-2 py-1 border rounded-md text-sm"
                placeholder="Enter Eye Colour"
              />
            </div>
            <div class="mb-2">
              <label for="skinColour" class="block mb-1 text-sm">Skin Colour:</label>
              <input
                type="text"
                id="skinColour"
                v-model="form.distinguishing_marks.skin_colour"
                class="w-full px-2 py-1 border rounded-md text-sm"
                placeholder="Enter Skin Colour"
              />
            </div>
          </div>
        </fieldset>

        <!-- Admission Details -->
        <fieldset class="border border-blue-900 p-4 mb-2 mt-8 mr-8 ml-16 rounded-sm">
          <legend class="text-base bg-blue-900 text-gray-300 pl-2 pr-2 pt-1 pb-1 rounded-sm font-bold mb-2">ADMISSION DETAILS</legend>
          <div class="grid grid-cols-1 gap-2">
            <div class="mb-2 col-span-1">
              <label for="committingCourt" class="block mb-1 text-sm">
                Committing Court: <span class="text-red-500">*</span>
              </label>
              <input
                type="text"
                id="committingCourt"
                v-model="form.admission.committing_court"
                class="w-full px-2 py-1 border rounded-md text-sm"
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
                  placeholder="Enter Offense"
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
        <fieldset class="border border-blue-900 p-4 mb-2 mt-8 mr-8 ml-16 rounded-sm">
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

const provinces = ref([]);
const cityMunis = ref([]);
const barangays = ref([]);

const showModal = ref(false);
const modalType = ref('success');
const modalMessage = ref('');

const fetchProvinces = async () => {
  try {
    const response = await axios.get('/provinces');
    provinces.value = response.data;
  } catch (error) {
    console.error('Error fetching provinces:', error);
  }
};

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

const saveForm = async () => {
  // Log the form data to ensure correct values
  console.log('Form Data:', form.value);

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

const toggleOtherDocuments = () => {
  if (!form.value.documents_submitted.documents.includes('Others')) {
    form.value.documents_submitted.others = '';
  }
};

fetchProvinces(); // Load provinces when the component is mounted
</script>

<style scoped>
/* Add your styles here */
</style>
