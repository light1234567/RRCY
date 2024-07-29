<template>
  <div class="p-6 max-w-3xl mx-auto">
      <h1 class="text-3xl font-bold mb-6 text-gray-800">Admission Form</h1>
      <form @submit.prevent="saveForm" class="space-y-6">
          <!-- Client Information -->
          <fieldset class="border border-gray-300 p-6 rounded-lg shadow-md bg-white">
              <legend class="text-xl font-semibold text-gray-700 mb-4">
                  Client Information
              </legend>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div class="mb-5">
                      <label for="clientName" class="block text-gray-600 mb-1">Name:</label>
                      <input
                          type="text"
                          id="clientName"
                          v-model="form.client.name"
                          placeholder="Enter client name"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
                  <div class="mb-5">
                      <label for="clientSex" class="block text-gray-600 mb-1">Sex:</label>
                      <select
                          id="clientSex"
                          v-model="form.client.sex"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      >
                          <option value="" disabled>Select client sex</option>
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                          <option value="other">Other</option>
                      </select>
                  </div>
                  <div class="mb-5">
                      <label for="clientAddress" class="block text-gray-600 mb-1">Address:</label>
                      <input
                          type="text"
                          id="clientAddress"
                          v-model="form.client.address"
                          placeholder="Enter client address"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
                  <div class="mb-5">
                      <label for="clientDob" class="block text-gray-600 mb-1">Date of Birth:</label>
                      <input
                          type="date"
                          id="clientDob"
                          v-model="form.client.date_of_birth"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
                  <div class="mb-5">
                      <label for="clientReligion" class="block text-gray-600 mb-1">Religion:</label>
                      <input
                          type="text"
                          id="clientReligion"
                          v-model="form.client.religion"
                          placeholder="Enter religion"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
                  <div class="mb-5">
                      <label for="clientOccupation" class="block text-gray-600 mb-1">Occupation:</label>
                      <input
                          type="text"
                          id="clientOccupation"
                          v-model="form.client.occupation"
                          placeholder="Enter occupation"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
              </div>
          </fieldset>

          <!-- Admission Details -->
          <fieldset class="border border-gray-300 p-6 rounded-lg shadow-md bg-white">
              <legend class="text-xl font-semibold text-gray-700 mb-4">
                  Admission Details
              </legend>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div class="mb-5">
                      <label for="committingCourt" class="block text-gray-600 mb-1">Committing Court:</label>
                      <input
                          type="text"
                          id="committingCourt"
                          v-model="form.admission.committing_court"
                          placeholder="Enter committing court"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
                  <div class="mb-5">
                      <label for="crimCaseNumber" class="block text-gray-600 mb-1">Criminal Case Number:</label>
                      <input
                          type="text"
                          id="crimCaseNumber"
                          v-model="form.admission.crim_case_number"
                          placeholder="Enter criminal case number"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
                  <div class="mb-5">
                      <label for="offenseCommitted" class="block text-gray-600 mb-1">Offense Committed:</label>
                      <input
                          type="text"
                          id="offenseCommitted"
                          v-model="form.admission.offense_committed"
                          placeholder="Enter offense committed"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
                  <div class="mb-5">
                      <label for="dateAdmitted" class="block text-gray-600 mb-1">Date Admitted:</label>
                      <input
                          type="date"
                          id="dateAdmitted"
                          v-model="form.admission.date_admitted"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
                  <div class="mb-5">
                      <label for="daysInJail" class="block text-gray-600 mb-1">Days in Jail:</label>
                      <input
                          type="number"
                          id="daysInJail"
                          v-model="form.admission.days_in_jail"
                          placeholder="Enter days in jail"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
                  <div class="mb-5">
                      <label for="daysInDetentionCenter" class="block text-gray-600 mb-1">Days in Detention Center:</label>
                      <input
                          type="number"
                          id="daysInDetentionCenter"
                          v-model="form.admission.days_in_detention_center"
                          placeholder="Enter days in detention center"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
                  <div class="mb-5">
                      <label for="actionTaken" class="block text-gray-600 mb-1">Action Taken:</label>
                      <input
                          type="text"
                          id="actionTaken"
                          v-model="form.admission.action_taken"
                          placeholder="Enter action taken"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
                  <div class="mb-5">
                      <label for="highestEducAtt" class="block text-gray-600 mb-1">Highest Education Attainment:</label>
                      <input
                          type="text"
                          id="highestEducAtt"
                          v-model="form.admission.highest_educ_att"
                          placeholder="Enter highest education attainment"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
                  <div class="mb-5">
                      <label for="schoolName" class="block text-gray-600 mb-1">School Name:</label>
                      <input
                          type="text"
                          id="schoolName"
                          v-model="form.admission.school_name"
                          placeholder="Enter school name"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
                  <div class="mb-5">
                      <label for="classAdviser" class="block text-gray-600 mb-1">Class Adviser:</label>
                      <input
                          type="text"
                          id="classAdviser"
                          v-model="form.admission.class_adviser"
                          placeholder="Enter class adviser"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
              </div>
          </fieldset>

          <!-- Distinguishing Marks -->
          <fieldset class="border border-gray-300 p-6 rounded-lg shadow-md bg-white">
              <legend class="text-xl font-semibold text-gray-700 mb-4">
                  Distinguishing Marks
              </legend>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div class="mb-5">
                      <label for="tattooScars" class="block text-gray-600 mb-1">Tattoo/Scars:</label>
                      <input
                          type="text"
                          id="tattooScars"
                          v-model="form.distinguishing_marks.tattoo_scars"
                          placeholder="Enter tattoo/scars"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
                  <div class="mb-5">
                      <label for="height" class="block text-gray-600 mb-1">Height:</label>
                      <input
                          type="number"
                          id="height"
                          v-model="form.distinguishing_marks.height"
                          placeholder="Enter height"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
                  <div class="mb-5">
                      <label for="weight" class="block text-gray-600 mb-1">Weight:</label>
                      <input
                          type="number"
                          id="weight"
                          v-model="form.distinguishing_marks.weight"
                          placeholder="Enter weight"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
                  <div class="mb-5">
                      <label for="colourOfEye" class="block text-gray-600 mb-1">Colour of Eye:</label>
                      <input
                          type="text"
                          id="colourOfEye"
                          v-model="form.distinguishing_marks.colour_of_eye"
                          placeholder="Enter colour of eye"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
                  <div class="mb-5">
                      <label for="skin" class="block text-gray-600 mb-1">Skin:</label>
                      <input
                          type="text"
                          id="skin"
                          v-model="form.distinguishing_marks.skin"
                          placeholder="Enter skin"
                          class="w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                  </div>
              </div>
          </fieldset>

          <!-- Documents Submitted -->
          <fieldset class="border border-gray-300 p-6 rounded-lg shadow-md bg-white">
              <legend class="text-xl font-semibold text-gray-700 mb-4">
                  Documents Submitted
              </legend>
              <div class="grid grid-cols-1 gap-4">
                  <div class="flex items-center mb-4">
                      <input
                          type="checkbox"
                          id="scsr"
                          v-model="form.documents.scsr"
                          class="mr-2 h-5 w-5 text-blue-600 border-gray-300 rounded"
                      />
                      <label for="scsr" class="text-gray-600">SCSR</label>
                  </div>
                  <div class="flex items-center mb-4">
                      <input
                          type="checkbox"
                          id="courtOrder"
                          v-model="form.documents.courtOrder"
                          class="mr-2 h-5 w-5 text-blue-600 border-gray-300 rounded"
                      />
                      <label for="courtOrder" class="text-gray-600">Court Order</label>
                  </div>
                  <div class="flex items-center mb-4">
                      <input
                          type="checkbox"
                          id="medicalCertificates"
                          v-model="form.documents.medicalCertificates"
                          class="mr-2 h-5 w-5 text-blue-600 border-gray-300 rounded"
                      />
                      <label for="medicalCertificates" class="text-gray-600">Medical Certificates</label>
                  </div>
                  <div class="flex items-center mb-4">
                      <input
                          type="checkbox"
                          id="commitmentOrder"
                          v-model="form.documents.commitmentOrder"
                          class="mr-2 h-5 w-5 text-blue-600 border-gray-300 rounded"
                      />
                      <label for="commitmentOrder" class="text-gray-600">Commitment Order</label>
                  </div>
                  <div class="flex items-center mb-4">
                      <input
                          type="checkbox"
                          id="courtInformation"
                          v-model="form.documents.courtInformation"
                          class="mr-2 h-5 w-5 text-blue-600 border-gray-300 rounded"
                      />
                      <label for="courtInformation" class="text-gray-600">Court Information</label>
                  </div>
              </div>
          </fieldset>

          <button
              type="submit"
              class="bg-blue-600 text-white px-6 py-3 rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300"
          >
              Save
          </button>
      </form>
  </div>
</template>

<script>
export default {
  data() {
      return {
          form: {
              client: {
                  name: "",
                  sex: "",
                  address: "",
                  date_of_birth: "",
                  religion: "",
                  occupation: "",
              },
              admission: {
                  committing_court: "",
                  crim_case_number: "",
                  offense_committed: "",
                  date_admitted: "",
                  days_in_jail: "",
                  days_in_detention_center: "",
                  action_taken: "",
                  highest_educ_att: "",
                  school_name: "",
                  class_adviser: "",
              },
              distinguishing_marks: {
                  tattoo_scars: "",
                  height: "",
                  weight: "",
                  colour_of_eye: "",
                  skin: "",
              },
              documents: {
                  scsr: false,
                  courtOrder: false,
                  medicalCertificates: false,
                  commitmentOrder: false,
                  courtInformation: false,
              },
          },
      };
  },
  methods: {
      saveForm() {
          axios
              .post("/api/admission", this.form)
              .then((response) => {
                  console.log("Form saved successfully:", response.data);
                  alert("Form submitted successfully!");
                  this.resetForm();
              })
              .catch((error) => {
                  console.error("Error saving form:", error);
                  let errorMessage =
                      "There was an error submitting the form. Please try again.";
                  if (error.response) {
                      if (
                          error.response.data &&
                          error.response.data.message
                      ) {
                          errorMessage = error.response.data.message;
                      } else if (error.response.statusText) {
                          errorMessage = `${error.response.status} ${error.response.statusText}`;
                      }
                  }
                  alert(errorMessage);
              });
      },
      resetForm() {
          this.form = {
              client: {
                  name: "",
                  sex: "",
                  address: "",
                  date_of_birth: "",
                  religion: "",
                  occupation: "",
              },
              admission: {
                  committing_court: "",
                  crim_case_number: "",
                  offense_committed: "",
                  date_admitted: "",
                  days_in_jail: "",
                  days_in_detention_center: "",
                  action_taken: "",
                  highest_educ_att: "",
                  school_name: "",
                  class_adviser: "",
              },
              distinguishing_marks: {
                  tattoo_scars: "",
                  height: "",
                  weight: "",
                  colour_of_eye: "",
                  skin: "",
              },
              documents: {
                  scsr: false,
                  courtOrder: false,
                  medicalCertificates: false,
                  commitmentOrder: false,
                  courtInformation: false,
              },
          };
      },
  },
};
</script>
