<template>
  <AppLayout title="New Client">
    <template #header>
      <div class="flex items-center">
        <div class="ml-5 w-2 h-6 bg-gray-400 mr-3"></div>
        <i class="fa fa-user-plus ml-6 text-xl mr-2"></i>
        <h1 class="ml-4 text-lg font-bold text-red-800">
          Admission Form/New Client
        </h1>
      </div>
    </template>

    <div class="bg-slate-100 mt-0.5" style="background-image: url('/images/da.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center;">
      <h1 class="text-lg p-1 text-customBlue ml-10 font-bold mb-4"></h1>
      <form @submit.prevent="saveForm">
        <!-- Client Information -->

        <fieldset
          class="bg-white border border-gray-300 shadow-md p-6 mb-4 mr-8 ml-16 rounded-xs"
        >
          <legend
            class="text-base bg-gradient-to-r from-blue-900 to-blue-600 text-white pl-2 pr-2 pt-1 pb-1 rounded-md font-bold shadow-md"
          >
            CLIENT INFORMATION
          </legend>

          <div class="grid grid-cols-1">
            <!-- Name, Suffix, and Sex using a Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
              <div class="mb-2">
                <label
                  for="clientFirstName"
                  class="block mb-1 text-sm font-medium"
                >
                  First Name: <span class="text-red-500">*</span>
                </label>
                <input
  type="text"
  id="clientFirstName"
  v-model="form.client.first_name"
  @input="form.client.first_name = $event.target.value.replace(/[^a-zA-Z\s]/g, '')"
  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
  required
  maxlength="20"
/>

              </div>
              <div class="mb-2">
                <label
                  for="clientMiddleName"
                  class="block mb-1 text-sm font-medium"
                  >Middle Name:</label
                >
                <input
  type="text"
  id="clientMiddleName"
  v-model="form.client.middle_name"
  @input="form.client.middle_name = $event.target.value.replace(/[^a-zA-Z\s]/g, '')"
  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
  maxlength="15"
/>

              </div>
              <div class="mb-2">
                <label
                  for="clientLastName"
                  class="block mb-1 text-sm font-medium"
                >
                  Last Name: <span class="text-red-500">*</span>
                </label>
                <input
  type="text"
  id="clientLastName"
  v-model="form.client.last_name"
  @input="form.client.last_name = $event.target.value.replace(/[^a-zA-Z\s]/g, '')"
  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
  maxlength="15"
  required
/>

              </div>
              <div class="mb-2">
                <label for="clientSuffix" class="block mb-1 text-sm font-medium"
                  >Suffix:</label
                >
                <select
                  id="clientSuffix"
                  v-model="form.client.suffix"
                  maxlength="3"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
              <div class="mb-2">
                <label for="clientDob" class="block mb-1 text-sm font-medium"
                  >Date of Birth: <span class="text-red-500">*</span></label
                >
                <input
                  type="date"
                  id="clientDob"
                  v-model="form.client.date_of_birth"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                  :max="form.client.maxDateOfBirth"
                  :min="form.client.minDateOfBirth"
                  required
                />
              </div>
              <div class="mb-2">
                <label
                  for="clientPlaceOfBirth"
                  class="block mb-1 text-sm font-medium"
                  >Place of Birth: <span class="text-red-500">*</span></label
                >
                <input
                  type="text"
                  id="clientPlaceOfBirth"
                  v-model="form.client.place_of_birth"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                  placeholder="City/Province"
                  required
                  maxlength="50"
                />
              </div>
              <div class="mb-2">
                <label for="child_status" class="block mb-1 text-sm font-medium"
                  >Child Status: <span class="text-red-500">*</span></label
                >
                <select
                  id="child_status"
                  v-model="form.client.child_status"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                  required
                  maxlength="35"
                >
                  <option value="">Select Child Status</option>
                  <option value="Still at the Center (SATC)">
                    Still at the Center (SATC)
                  </option>
                  <option value="Discharge">Discharge</option>
                  <option value="Leave without Permission (LWOP)">
                    Leave without Permission (LWOP)
                  </option>
                </select>
              </div>
              <div class="mb-2">
                <label for="clientSex" class="block mb-1 text-sm font-medium"
                  >Sex: <span class="text-red-500">*</span></label
                >
                <select
                  id="clientSex"
                  v-model="form.client.sex"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                  required
                  maxlength="20"
                >
                  <option value="">Select Sex</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Rather not to say">Rather not to say</option>
                </select>
              </div>
            </div>

            <!-- Address Breakdown with Cascading Dropdowns -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div class="mb-2">
                <label
                  for="clientProvince"
                  class="block mb-1 text-sm font-medium"
                  >Province: <span class="text-red-500">*</span></label
                >
                <select
                  id="clientProvince"
                  v-model="form.client.province"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                  @change="onProvinceChange"
                  required
                  maxlength="20"
                >
                  <option value="">Select Province</option>
                  <option
                    v-for="province in provinces"
                    :key="province.psgc"
                    :value="province.col_province"
                  >
                    {{ province.col_province }}
                  </option>
                </select>
              </div>
              <div class="mb-2">
                <label for="clientCity" class="block mb-1 text-sm font-medium"
                  >City/Municipality: <span class="text-red-500">*</span></label
                >
                <select
                  id="clientCity"
                  v-model="form.client.city"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                  @change="onCityChange"
                  :disabled="!form.client.province"
                  required
                  maxlength="30"
                >
                  <option value="">Select City/Municipality</option>
                  <option
                    v-for="citymuni in cityMunis"
                    :key="citymuni.psgc"
                    :value="citymuni.col_citymuni"
                  >
                    {{ citymuni.col_citymuni }}
                  </option>
                </select>
              </div>
              <div class="mb-2">
                <label
                  for="clientBarangay"
                  class="block mb-1 text-sm font-medium"
                  >Barangay: <span class="text-red-500">*</span></label
                >
                <select
                  id="clientBarangay"
                  v-model="form.client.barangay"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                  :disabled="!form.client.city"
                  required
                  maxlength="30"
                >
                  <option value="">Select Barangay</option>
                  <option
                    v-for="brgy in barangays"
                    :key="brgy.psgc"
                    :value="brgy.col_brgy"
                  >
                    {{ brgy.col_brgy }}
                  </option>
                </select>
              </div>
              <div class="mb-2">
                <label for="clientStreet" class="block mb-1 text-sm font-medium"
                  >House/Building Number and Street Name:</label
                >
                <input
                  type="text"
                  id="clientStreet"
                  v-model="form.client.street"
                  maxlength="60"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                />
              </div>
            </div>

            <!-- Religion -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="mb-2">
                <label
                  for="clientReligion"
                  class="block mb-1 text-sm font-medium"
                  >Religion: <span class="text-red-500">*</span></label
                >
                <select
                  id="clientReligion"
                  v-model="form.client.religion"
                  maxlength="20"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
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
              <transition name="fade-in">
                <div
                  class="mb-2 twinkle"
                  v-if="form.client.religion === 'Other'"
                >
                  <label
                    for="customReligion"
                    class="block mb-1 text-sm font-medium"
                  >
                    Please specify: <span class="text-red-500">*</span>
                  </label>
                  <input
  type="text"
  id="customReligion"
  v-model="form.client.customReligion"
  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm twinkle-border"
  placeholder="Enter your religion"
  @input="form.client.customReligion = $event.target.value.replace(/[^a-zA-Z\s]/g, '')"
  required
/>

                </div>
              </transition>
            </div>
          </div>
        </fieldset>

        <!-- Distinguishing Marks -->
        <fieldset
          class="bg-white border border-gray-300 shadow-md p-6 mb-4 mr-8 ml-16 rounded-xs"
        >
          <legend
            class="text-base bg-gradient-to-r from-blue-900 to-blue-600 text-white pl-2 pr-2 pt-1 pb-1 rounded-xs font-bold shadow-sm"
          >
            DISTINGUISHING MARKS
          </legend>

          <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
            <div class="mb-2">
              <label for="tattooScars" class="block mb-1 text-sm font-medium">
                Tattoo/Scars:
              </label>
              <input
  type="text"
  id="tattooScars"
  v-model="form.distinguishing_marks.tattoo_scars"
  maxlength="150"
  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
  @input="form.distinguishing_marks.tattoo_scars = $event.target.value.replace(/[^a-zA-Z\s]/g, '')"
/>

            </div>

            <div class="mb-2">
              <label for="height" class="block mb-1 text-sm font-medium">
                Height (cm):
              </label>
              <input
  type="text"  
  id="height"
  v-model="form.distinguishing_marks.height"
  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
  maxlength="3"
  @input="form.distinguishing_marks.height = $event.target.value.replace(/[^0-9]/g, '')"
  min="0"
  max="999"
/>

            </div>

            <div class="mb-2">
              <label for="weight" class="block mb-1 text-sm font-medium">
                Weight (kg):
              </label>
              <input
                type="number"
                id="weight"
                v-model="form.distinguishing_marks.weight"
                class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                max="999"
              />
            </div>

            <!-- Colour of Eye -->
            <div class="mb-2">
              <label for="colourOfEye" class="block mb-1 text-sm font-medium">
                Colour of Eye:
              </label>
              <select
                id="colourOfEye"
                v-model="form.distinguishing_marks.colour_of_eye"
                class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
              >
                <option value="">Select Colour</option>
                <option value="Brown">Brown</option>
                <option value="Blue">Blue</option>
                <option value="Green">Green</option>
                <option value="Hazel">Hazel</option>
                <option value="Gray">Gray</option>
                <option value="Amber">Amber</option>
                <option value="Other">Other</option>
              </select>
            </div>

            <!-- Custom Eye Color Input (Only when "Other" is selected) -->
            <div v-if="form.distinguishing_marks.colour_of_eye === 'Other'" class="mb-2">
  <label for="customEyeColor" class="block mb-1 text-sm font-medium">
    Custom Eye Color:
  </label>
  <input
    type="text"
    id="customEyeColor"
    v-model="form.distinguishing_marks.custom_eye_color"
    class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
    placeholder="Enter custom eye color"
    maxlength="10"
    @input="form.distinguishing_marks.custom_eye_color = form.distinguishing_marks.custom_eye_color.replace(/\d+/g, '')"
  />
</div>


            <!-- Skin Colour -->
            <div class="mb-2">
              <label for="skinColour" class="block mb-1 text-sm font-medium">
                Skin Colour:
              </label>
              <select
                id="skinColour"
                v-model="form.distinguishing_marks.skin_colour"
                class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
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

            <!-- Custom Skin Colour Input (Only when "Other" is selected) -->
            <div v-if="form.distinguishing_marks.skin_colour === 'Other'" class="mb-2">
  <label for="customSkinColour" class="block mb-1 text-sm font-medium">
    Custom Skin Colour:
  </label>
  <input
    type="text"
    id="customSkinColour"
    v-model="form.distinguishing_marks.custom_skin_colour"
    maxlength="10"
    class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
    placeholder="Enter custom skin colour"
    @input="form.distinguishing_marks.custom_skin_colour = form.distinguishing_marks.custom_skin_colour.replace(/\d+/g, '')"
  />
</div>

          </div>
        </fieldset>

        <!-- Admission Details -->
        <fieldset
          class="bg-white border shadow-md p-6 mb-4 mr-8 ml-16 rounded-xs"
        >
          <legend
            class="text-base bg-gradient-to-r from-blue-900 to-blue-600 text-white pl-2 pr-2 pt-1 pb-1 rounded-md font-bold shadow-md"
          >
            ADMISSION DETAILS
          </legend>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- RTC Province -->
            <div class="mb-2">
              <label for="rtcProvince" class="block mb-1 text-sm font-medium">
                Committing Court Province: <span class="text-red-500">*</span>
              </label>
              <select
                id="rtcProvince"
                v-model="selectedProvince"
                class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                required
              >
                <option value="" disabled>Select a province</option>
                <option
                  v-for="province in rtcProvinces"
                  :key="province.id"
                  :value="province.id"
                >
                  {{ province.province_name }}
                </option>
              </select>
            </div>

            <!-- Committing Court Dropdown -->
            <transition name="fade-in">
              <div class="mb-2" v-if="selectedProvince">
                <label
                  for="committingCourt"
                  class="block mb-1 text-sm font-medium"
                >
                  Committing Court Branch: <span class="text-red-500">*</span>
                </label>
                <select
                  id="committingCourt"
                  v-model="form.admission.committing_court"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm twinkle-border"
                  required
                  maxlength="50"
                >
                  <option value="" disabled>Select a branch</option>
                  <option
                    v-for="branch in filteredBranches"
                    :key="branch.id"
                    :value="branch.branch_name"
                  >
                    {{ branch.branch_name }}
                  </option>
                  <option value="Other">Other</option>
                </select>
              </div>
            </transition>

            <!-- Custom Committing Court Input -->
            <transition name="fade-in">
              <div
                class="mb-2"
                v-if="form.admission.committing_court === 'Other'"
              >
                <label for="customCourt" class="block mb-1 text-sm font-medium">
                  Custom Committing Court: <span class="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  id="customCourt"
                  v-model="customCommittingCourt"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm twinkle-border"
                  placeholder="Enter custom committing court"
                  required
                />
              </div>
            </transition>
            <!-- Criminal Case Number -->
            <div class="mb-2 w-full">
              <label
                for="crimCaseNumber"
                class="block mb-1 text-sm font-medium"
              >
                Criminal Case Number: <span class="text-red-500">*</span>
              </label>
              <input
                type="text"
                id="crimCaseNumber"
                v-model="form.admission.crim_case_number"
                class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                required
                maxlength="25"
              />
            </div>

            <!-- Date Admitted -->
            <div class="mb-2 w-full">
  <label for="dateAdmitted" class="block mb-1 text-sm font-medium">
    Date Admitted: <span class="text-red-500">*</span>
  </label>
  <input
    type="date"
    id="dateAdmitted"
    v-model="form.admission.date_admitted"
    class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
    required
    :max="new Date().toLocaleString('en-CA', { 
      timeZone: 'Asia/Manila', 
      year: 'numeric', 
      month: '2-digit', 
      day: '2-digit' 
    }).split(',')[0]"
  />
</div>


            <!-- Days in Jail -->
            <div class="mb-2 w-full">
              <label for="daysInJail" class="block mb-1 text-sm font-medium">
                Days in Jail: <span class="text-red-500">*</span>
              </label>
              <input
                type="number"
                id="daysInJail"
                v-model="form.admission.days_in_jail"
                class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                required
                :max="99999"
                @input="
                  (e) =>
                    (form.admission.days_in_jail =
                      e.target.value.length > 5
                        ? e.target.value.slice(0, 5)
                        : e.target.value)
                "
              />
            </div>

            <!-- Days in Detention Center -->
            <div class="mb-2 w-full">
              <label
                for="daysInDetentionCenter"
                class="block mb-1 text-sm font-medium"
              >
                Days in Detention Center: <span class="text-red-500">*</span>
              </label>
              <input
                type="number"
                id="daysInDetentionCenter"
                v-model="form.admission.days_in_detention_center"
                class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                required
                :max="99999"
                @input="
                  (e) =>
                    (form.admission.days_in_detention_center =
                      e.target.value.length > 5
                        ? e.target.value.slice(0, 5)
                        : e.target.value)
                "
              />
            </div>

            <!-- Case Status -->
            <div class="mb-2 w-full">
              <label for="case_status" class="block mb-1 text-sm font-medium">
                Case Status: <span class="text-red-500">*</span>
              </label>
              <select
                id="case_status"
                v-model="form.admission.case_status"
                class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                required
                maxlength="25"
              >
                <option value="">Select Case Status</option>
                <option value="On trial">On trial</option>
                <option value="Acquitted/Dismissed">Acquitted/Dismissed</option>
                <option value="Provisionally Dismissed">
                  Provisionally Dismissed
                </option>
                <option value="Rehabilitation">Rehabilitated</option>
                <option value="Diversion">Diversion</option>
                <option value="Disposition Measure">Disposition Measure</option>
                <option value="Child-at-risk (CAR)">Child-at-risk (CAR)</option>
              </select>
            </div>

            <!-- Crime Category Dropdown -->
            <div class="mb-2">
              <label for="crimeCategory" class="block mb-1 text-sm font-medium">
                Crime Category: <span class="text-red-500">*</span>
              </label>
              <select
                id="crimeCategory"
                v-model="selectedCategory"
                class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                required
              >
                <option value="" disabled>Select a category</option>
                <option
                  v-for="category in crimeCategories"
                  :key="category.id"
                  :value="category.id"
                >
                  {{ category.category_name }}
                </option>
              </select>
            </div>

            <!-- Offense Committed Dropdown -->
            <transition name="fade-in">
              <div class="mb-2" v-if="selectedCategory">
                <label
                  for="offenseCommitted"
                  class="block mb-1 text-sm font-medium"
                >
                  Offense Committed: <span class="text-red-500">*</span>
                </label>
                <select
                  id="offenseCommitted"
                  v-model="form.admission.offense_committed"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm twinkle-border"
                  required
                  maxlength="100"
                >
                  <option value="" disabled>Select an offense</option>
                  <option
                    v-for="crime in filteredCrimes"
                    :key="crime.id"
                    :value="crime.crime_name"
                  >
                    {{ crime.crime_name }}
                  </option>
                  <option value="Other">Other</option>
                </select>
              </div>
            </transition>

            <!-- Custom Offense Input -->
            <transition name="fade-in">
              <div
                class="mb-2"
                v-if="form.admission.offense_committed === 'Other'"
              >
                <label
                  for="customOffense"
                  class="block mb-1 text-sm font-medium"
                >
                  Custom Offense Committed: <span class="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  id="customOffense"
                  v-model="customOffenseCommitted"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm twinkle-border"
                  placeholder="Enter custom offense committed"
                  required
                />
              </div>
            </transition>
          </div>
        </fieldset>

        <!-- Documents Submitted -->
        <fieldset
          class="bg-white border shadow-md p-6 mb-4 mr-8 ml-16 rounded-xs"
        >
          <legend
            class="text-base bg-gradient-to-r from-blue-900 to-blue-600 text-white pl-2 pr-2 pt-1 pb-1 rounded-md font-bold shadow-md"
          >
            DOCUMENTS SUBMITTED
          </legend>

          <div class="grid grid-cols-1 gap-4">
            <div class="mb-2">
              <label class="block mb-1 text-sm font-semibold"
                >Documents Submitted:</label
              >
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
                  <span class="text-sm">Birth Certificates</span>
                </div>
                <div class="flex items-center">
                  <input
                    type="checkbox"
                    value="School Records"
                    v-model="form.documents_submitted.documents"
                    class="mr-1"
                  />
                  <span class="text-sm">Referral Letters</span>
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

            <!-- Other Documents Input -->
            <div
              v-if="form.documents_submitted.documents.includes('Others')"
              class="mb-2"
            >
              <label
                for="otherDocuments"
                class="block mb-1 text-sm font-semibold"
                >Other Documents:</label
              >
              <input
                type="text"
                id="otherDocuments"
                v-model="form.documents_submitted.others"
                maxlength="50"
                class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
              />
            </div>

            <div class="mb-2">
              <label
                for="generalImpression"
                class="block mb-1 text-sm font-medium"
              >
                General Impression: <span class="text-red-500">*</span>
              </label>
              <input
                type="text"
                id="generalImpression"
                v-model="form.admission.general_impression"
                class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                required
              />
            </div>

            <div class="mb-2">
              <label for="actionTaken" class="block mb-1 text-sm font-medium">
                Action Taken: <span class="text-red-500">*</span>
              </label>
              <input
                type="text"
                id="actionTaken"
                v-model="form.admission.action_taken"
                class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                required
              />
            </div>

            <!-- New Fields for Referring Party and Admitting Officer -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="mb-2">
                <label
                  for="referringParty"
                  class="block mb-1 text-sm font-medium"
                >
                  Name of Referring Party:
                </label>
                <input
                  type="text"
                  id="referringParty"
                  v-model="form.admission.referring_party_name"
                  maxlength="50"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                />
              </div>

              <div class="mb-2">
  <label for="admittingOfficer" class="block mb-1 text-sm font-medium">
    Admitting Officer:
  </label>
  <input
    type="text"
    id="admittingOfficer"
    v-model="form.admission.admitting_officer"
    maxlength="50"
    class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
    @input="form.admission.admitting_officer = form.admission.admitting_officer.replace(/\d+/g, '')"
  />
</div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="mb-2">
                <label
                  for="designationContact"
                  class="block mb-1 text-sm font-medium"
                >
                  Designation / ID No. / Contact #:
                </label>
                <input
                  type="text"
                  id="designationContact"
                  v-model="form.admission.designation_id_contact"
                  maxlength="50"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                />
              </div>

              <div class="mb-2">
                <label for="designation" class="block mb-1 text-sm font-medium">
                  Designation:
                </label>
                <input
                  type="text"
                  id="designation"
                  v-model="form.admission.designation"
                  maxlength="50"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                />
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="mb-2">
                <label
                  for="officeAddress"
                  class="block mb-1 text-sm font-medium"
                >
                  Complete Address/Office Address:
                </label>
                <input
                  type="text"
                  id="officeAddress"
                  v-model="form.admission.office_address"
                  maxlength="50"
                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                />
              </div>

              <div class="mb-2">
  <label for="dateTime" class="block mb-1 text-sm font-medium">
    Date/Time:
  </label>
  <input
    type="datetime-local"
    id="dateTime"
    v-model="form.admission.date_time"
    class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
    :max="new Date().toLocaleString('sv-SE', { 
      timeZone: 'Asia/Manila', 
      hour12: false 
    }).replace(' ', 'T').slice(0, 16)"
  />
</div>


            </div>

            <div class="mb-2">
              <label for="notedBy" class="block mb-1 text-sm font-medium">
                Noted by:
              </label>
              <input
                type="text"
                id="notedBy"
                v-model="form.center_head"
                class="w-full px-3 py-2 border rounded-md shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 text-sm"
                readonly
              />
            </div>
          </div>
        </fieldset>

        <!-- Submit Button -->
        <button
          type="submit"
          class="bg-gradient-to-r from-blue-900 to-blue-600 text-white mb-2 mt-4 px-8 py-1 mr-8 ml-16 rounded-md text-sm"
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
import { ref, watch, onMounted, computed } from "vue";
import axios from "axios";
import NotificationModal from "@/Components/NotificationModal.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

const form = ref({
  center_head: "",
  client: {
    first_name: "",
    middle_name: "",
    last_name: "",
    suffix: " ",
    sex: "",
    date_of_birth: "",
    place_of_birth: "",
    province: "",
    city: "",
    barangay: "",
    street: "",
    religion: "",
    child_status: "",
    maxDateOfBirth: "",
    minDateOfBirth: "",
  },
  distinguishing_marks: {
    tattoo_scars: "",
    height: "",
    weight: "",
    colour_of_eye: "",
    skin_colour: "",
  },
  admission: {
    case_status: "",
    committing_court: "",
    crim_case_number: "",
    offense_committed: "",
    date_admitted: "",
    days_in_jail: "",
    days_in_detention_center: "",
    action_taken: "",
    general_impression: "",
    referring_party_name: "",
    admitting_officer: "",
    designation_id_contact: "",
    designation: "",
    office_address: "",
    date_time: "",
  },
  documents_submitted: {
    documents: [],
    others: "",
  },
});
// Variables for categories and crimes
const crimeCategories = ref([]); // Stores all crime categories
const selectedCategory = ref(""); // Stores the selected category ID
const filteredCrimes = ref([]); // Stores crimes based on selected category
const customOffenseCommitted = ref(""); // Custom value for "Other" offense committed
const rtcProvinces = ref([]); // Stores all RTC provinces
const selectedProvince = ref(""); // Stores the selected province ID
const filteredBranches = ref([]); // Stores branches based on selected province
const customCommittingCourt = ref(""); // Custom value for "Other" committing court
const provinces = ref([]);
const cityMunis = ref([]);
const barangays = ref([]);

const showModal = ref(false);
const modalType = ref("success");
const modalMessage = ref("");

// Fetch RTC provinces and branches
const fetchRtcProvincesAndBranches = async () => {
  try {
    const response = await axios.get("/api/rtcBranches"); // Fetch provinces and branches from API
    rtcProvinces.value = response.data;
  } catch (error) {
    console.error("Error fetching RTC provinces:", error);
  }
};

// Watch for changes in selected province and filter branches
watch(selectedProvince, (newProvinceId) => {
  if (newProvinceId) {
    const province = rtcProvinces.value.find(
      (p) => p.id === parseInt(newProvinceId)
    );
    filteredBranches.value = province ? province.branches : [];
  } else {
    filteredBranches.value = [];
  }
});

// Load RTC provinces and branches when component is mounted
onMounted(fetchRtcProvincesAndBranches);

// Fetch crime categories and crimes
const fetchCrimeCategoriesAndCrimes = async () => {
  try {
    const response = await axios.get("/api/crimes"); // Fetch categories and crimes from API
    crimeCategories.value = response.data;
  } catch (error) {
    console.error("Error fetching crime categories:", error);
  }
};

// Watch for changes in selected category and filter crimes
watch(selectedCategory, (newCategoryId) => {
  if (newCategoryId) {
    const category = crimeCategories.value.find(
      (c) => c.id === parseInt(newCategoryId)
    );
    filteredCrimes.value = category ? category.crimes : [];
  } else {
    filteredCrimes.value = [];
  }
});

// Load crime categories and crimes when component is mounted
onMounted(fetchCrimeCategoriesAndCrimes);
// Function to fetch provinces
const fetchProvinces = async () => {
  try {
    const response = await axios.get("/provinces");
    provinces.value = response.data;
  } catch (error) {
    console.error("Error fetching provinces:", error);
  }
};

// Handle province selection change
const onProvinceChange = async () => {
  const selectedProvince = provinces.value.find(
    (p) => p.col_province === form.value.client.province
  );
  if (selectedProvince) {
    try {
      const response = await axios.get(`/citymunis/${selectedProvince.psgc}`);
      cityMunis.value = response.data;
      form.value.client.city = ""; // Reset city selection
      form.value.client.barangay = ""; // Reset barangay selection
      barangays.value = []; // Clear barangays
    } catch (error) {
      console.error("Error fetching city/municipalities:", error);
    }
  }
};

// Method to remove numbers from input
const removeNumbers = (field) => {
  form.value.client[field] = form.value.client[field].replace(/[0-9]/g, "");
};

// Handle city selection change
const onCityChange = async () => {
  const selectedCity = cityMunis.value.find(
    (c) => c.col_citymuni === form.value.client.city
  );
  if (selectedCity) {
    try {
      const response = await axios.get(`/barangays/${selectedCity.psgc}`);
      barangays.value = response.data;
      form.value.client.barangay = ""; // Reset barangay selection
    } catch (error) {
      console.error("Error fetching barangays:", error);
    }
  }
};

// Save form data
// Function to save the form data
const saveForm = async () => {
  try {
    const formData = new FormData();

    // Check if "Other" is selected for Colour of Eye and Skin Colour, and set custom values
    if (form.value.distinguishing_marks.colour_of_eye === "Other") {
      form.value.distinguishing_marks.colour_of_eye =
        form.value.distinguishing_marks.custom_eye_color;
    }
    if (form.value.distinguishing_marks.skin_colour === "Other") {
      form.value.distinguishing_marks.skin_colour =
        form.value.distinguishing_marks.custom_skin_colour;
    }

    // Check if "Other" is selected for Committing Court and set custom value
    if (form.value.admission.committing_court === "Other") {
      form.value.admission.committing_court = customCommittingCourt.value; // Use the custom committing court entered by the user
    }

    // Check if the religion is "Other" and set it to the custom religion input value
    if (form.value.client.religion === "Other") {
      form.value.client.religion = form.value.client.customReligion; // Replace 'Other' with custom religion
    }
    if (form.value.admission.offense_committed === "Other") {
      form.value.admission.offense_committed = customOffenseCommitted.value; // Use the custom offense entered by the user
    }
    if (!form.value.client.suffix) {
      form.value.client.suffix = ""; // Default to empty string if no suffix is selected
    }

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
      formData.append(
        `distinguishing_marks[${key}]`,
        form.value.distinguishing_marks[key]
      );
    });

    // Prepare documents array without the "Others" literal value
    const documentsWithoutOthers =
      form.value.documents_submitted.documents.filter(
        (doc) => doc !== "Others"
      );

    // Append documents submitted data (excluding "Others")
    documentsWithoutOthers.forEach((doc, index) => {
      formData.append(`documents_submitted[documents][${index}]`, doc);
    });

    // Append the "Others" document field if it exists
    if (form.value.documents_submitted.others) {
      formData.append(
        `documents_submitted[others]`,
        form.value.documents_submitted.others
      );
    }

    // Send the form data as FormData
    const response = await axios.post("/api/save-admission", formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });

    // Show success message
    modalType.value = "success";
    modalMessage.value = "Form saved successfully!";
    showModal.value = true;

    // Optionally reset form after successful save
    resetForm();
  } catch (error) {
    // Handle errors, specifically checking for the "Client already exists" error
    if (error.response && error.response.status === 400) {
      if (
        error.response.data.error ===
        "Client with the same first name, last name, date of birth, and date admitted already exists."
      ) {
        modalType.value = "error";
        modalMessage.value = "Client already exists!";
      } else if (
        error.response.data.error ===
        "The client has a pending case at the center."
      ) {
        modalType.value = "error";
        modalMessage.value = "The client has a pending case at the center!";
      } else {
        modalType.value = "error";
        modalMessage.value =
          "An error occurred while saving the form. Please try again.";
      }
    } else {
      modalType.value = "error";
      modalMessage.value = "An unexpected error occurred. Please try again.";
    }
    showModal.value = true;
  }
};

// Set the min and max dates for the date of birth
onMounted(() => {
  const today = new Date();

  // Calculate the exact date when someone would be 10 years old today
  const maxDate = new Date(
    today.getFullYear() - 10,
    today.getMonth(),
    today.getDate()
  );
  form.value.client.maxDateOfBirth = maxDate.toISOString().split("T")[0]; // Restrict to clients who are at least 10 years old

  // Calculate the exact date when someone would be 25 years old today
  const minDate = new Date(
    today.getFullYear() - 25,
    today.getMonth(),
    today.getDate()
  );
  form.value.client.minDateOfBirth = minDate.toISOString().split("T")[0]; // Restrict to clients who are at most 25 years old
});

// Watcher to limit height input to three digits
watch(
  () => form.value.distinguishing_marks.height,
  (newValue) => {
    if (newValue && newValue > 999) {
      form.value.distinguishing_marks.height = 999; // Set maximum to 999
    } else if (newValue && newValue.toString().length > 3) {
      form.value.distinguishing_marks.height = parseInt(
        newValue.toString().slice(0, 3),
        10
      );
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
      form.value.distinguishing_marks.weight = parseInt(
        newValue.toString().slice(0, 3),
        10
      );
    }
  }
);

// Reset the form to initial state while keeping date of birth constraints
const resetForm = () => {
  form.value = {
    center_head: "",
    client: {
      first_name: "",
      middle_name: "",
      last_name: "",
      suffix: "",
      sex: "",
      date_of_birth: "",
      place_of_birth: "",
      province: "",
      city: "",
      barangay: "",
      street: "",
      religion: "",
      child_status: "",
      maxDateOfBirth: form.value.client.maxDateOfBirth, // Keep the max date of birth
      minDateOfBirth: form.value.client.minDateOfBirth, // Keep the min date of birth
    },
    distinguishing_marks: {
      tattoo_scars: "",
      height: "",
      weight: "",
      colour_of_eye: "",
      skin_colour: "",
    },
    admission: {
      case_status: "",
      committing_court: "",
      crim_case_number: "",
      offense_committed: "",
      date_admitted: "",
      days_in_jail: "",
      days_in_detention_center: "",
      action_taken: "",
      general_impression: "",
      referring_party_name: "",
      admitting_officer: "",
      designation_id_contact: "",
      designation: "",
      office_address: "",
      date_time: "",
    },
    documents_submitted: {
      documents: [],
      others: "",
    },
  };
};

// Function to handle "Other" document selection
const toggleOtherDocuments = () => {
  if (!form.value.documents_submitted.documents.includes("Others")) {
    form.value.documents_submitted.others = "";
  }
};

const fetchCenterHead = async () => {
  try {
    const response = await axios.get("/api/center-head"); // Adjust the API route if necessary
    console.log("Center Head Response:", response.data); // Log the response to the console
    form.value.center_head = response.data.name; // Set the correct value for center_head from response
  } catch (error) {
    console.error("Error fetching center head:", error);
  }
};
// Load provinces when the component is mounted
onMounted(() => {
  fetchCenterHead(); // Fetch the center head on component mount
  fetchProvinces();
});
</script>
<style scoped>
/* Transition for element fade-in */
.fade-in-enter-active,
.fade-in-leave-active {
  transition: opacity 0.5s ease;
}
.fade-in-enter, .fade-in-leave-to /* .fade-in-leave-active in <2.1.8 */ {
  opacity: 0;
}

/* Keyframes for twinkling border */
@keyframes twinkle {
  0%,
  100% {
    border-color: #60a5fa; /* blue-400 */
  }
  50% {
    border-color: transparent;
  }
}

/* Twinkling border animation */
.twinkle-border {
  animation: twinkle 1s ease-in-out 2;
}
</style>