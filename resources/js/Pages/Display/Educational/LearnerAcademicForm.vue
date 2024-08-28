<template>
  <!-- Combined Content and Form -->
  <div class="max-w-3xl p-8 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
    <!-- Header Section with Logo and Document Details -->
    <div class="relative flex justify-between items-center mb-4">
      <img src="/images/headerlogo2.png" alt="Logo" class="h-24 w-48">
      <div class="text-right">
        <p class="item-center mr-6 text-sm font-semibold">PROTECTIVE SERVICES DIVISION</p>
          <p class=" text-sm font-semibold">Regional Rehabilitation Center for Youth</p>
          <p class="mr-20 text-sm font-semibold">Youth/RFO XI</p>
        <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
      </div>
    </div>

    <!-- Learner Academic Behavioral Form -->
    <form @submit.prevent="submitForm">
      <!-- Header Section -->
      <div class="text-center mb-6">
        <h1 class="font-bold text-xl">LEARNER’S ACADEMIC BEHAVIORAL FORM</h1>
        <div class="flex justify-center gap-4 mt-4">
          <div>
            <label for="month" class="block font-medium">For the Month of:</label>
            <input type="text" id="month" class="block w-32 p-1 border border-gray-300 mx-auto text-sm" />
          </div>
          <div>
            <label for="schoolYear" class="block font-medium">School Year:</label>
            <input type="text" id="schoolYear" class="block w-32 p-1 border border-gray-300 mx-auto text-sm" />
          </div>
        </div>
      </div>

      <!-- Learner Information Section -->
      <div class="flex flex-wrap gap-4 mb-6">
        <div class="w-1/2 sm:w-1/3">
          <label for="learnerName" class="block font-medium text-sm">Learner’s Name:</label>
          <input type="text" id="learnerName" class="block w-full p-1 border border-gray-300 text-sm" />
        </div>
        <div class="w-1/2 sm:w-1/3">
          <label for="grade" class="block font-medium text-sm">Grade:</label>
          <input type="text" id="grade" class="block w-full p-1 border border-gray-300 text-sm" />
        </div>
        <div class="w-1/2 sm:w-1/3">
          <label for="lrn" class="block font-medium text-sm">LRN:</label>
          <input type="text" id="lrn" class="block w-full p-1 border border-gray-300 text-sm" />
        </div>
        <div class="w-1/2 sm:w-1/3">
          <label for="status" class="block font-medium text-sm">Status:</label>
          <input type="text" id="status" class="block w-full p-1 border border-gray-300 text-sm" />
        </div>
      </div>

      <!-- Skills Table -->
      <div class="mb-6">
        <table class="w-full border-collapse">
          <thead>
            <tr>
              <th class="border p-2 text-left">Learner Skill</th>
              <th class="border p-2">Outstanding</th>
              <th class="border p-2">Very Satisfactory</th>
              <th class="border p-2">Satisfactory</th>
              <th class="border p-2">Fairly Satisfactory</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, index) in rows" :key="index">
              <td class="border p-2">{{ row.skill }}</td>
              <td class="border p-2"><input type="text" v-model="row.outstanding" class="w-full p-1 border border-gray-300" /></td>
              <td class="border p-2"><input type="text" v-model="row.verySatisfactory" class="w-full p-1 border border-gray-300" /></td>
              <td class="border p-2"><input type="text" v-model="row.satisfactory" class="w-full p-1 border border-gray-300" /></td>
              <td class="border p-2"><input type="text" v-model="row.fairlySatisfactory" class="w-full p-1 border border-gray-300" /></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Observation/Feedback Section -->
      <div class="mb-6">
        <label for="observationFeedback" class="block font-medium">Observation/Feedback:</label>
        <textarea id="observationFeedback" rows="6" class="block w-full p-2 border border-gray-300"></textarea>
      </div>

      <!-- Signature Section -->
      <div class="mb-6 flex gap-4">
        <!-- Learner Signature -->
        <div class="w-1/2">
          <label for="learnerSignature" class="block text-sm font-medium">Learner</label>
          <div class="flex items-center">
            <input
              type="text"
              id="learnerSignature"
              class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm"
            >
          </div>
          <p class="text-sm mt-2">Learner</p>
        </div>

        <!-- Category Adviser Signature -->
        <div class="w-1/2">
          <label for="categoryAdviserSignature" class="block text-sm font-medium">Category Adviser</label>
          <div class="flex items-center">
            <input
              type="text"
              id="categoryAdviserSignature"
              class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm"
            >
          </div>
          <p class="text-sm mt-2">Category Adviser</p>
        </div>
      </div>

      <div class="mb-6 flex gap-4">
        <!-- Educational Section Head Signature -->
        <div class="w-1/2">
          <label for="educationalSectionHeadSignature" class="block text-sm font-medium">Educational Section Head</label>
          <div class="flex items-center">
            <input
              type="text"
              id="educationalSectionHeadSignature"
              class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm bg-gray-200"
              value="Raldie Lloyd D. Adolfo, LPT"
              readonly
            >
          </div>
          <p class="text-sm mt-2">Educational Section Head</p>
        </div>

        <!-- Center Head Signature -->
        <div class="w-1/2">
          <label for="centerHeadSignature" class="block text-sm font-medium">Center Head</label>
          <div class="flex items-center">
            <input
              type="text"
              id="centerHeadSignature"
              class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm bg-gray-200"
              value="Angelic B. Pańa, RSW, MSSW"
              readonly
            >
          </div>
          <p class="text-sm mt-2">Center Head</p>
        </div>
      </div>

      <!-- Footer Section -->
      <div class="border-t border-gray-300 pt-4 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
        <div class="flex justify-between items-center">
          <div class="flex flex-col">
            <p class="font-bold">PAGE 1 of 1</p>
            <p class="border-t border-black pt-2">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
            <p>Email: <span class="text-blue-600 underline">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
          </div>
          <div>
            <img src="/images/footerimg.png" alt="Footer Image" class="h-12 w-24 object-cover rounded-md">
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: 'LearnerBehaviorForm',
  data() {
    return {
      rows: [
        { skill: 'HOMEWORK COMPLETION', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
        { skill: 'STUDY SKILLS', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
        { skill: 'ORGANIZATIONAL SKILLS', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
        { skill: 'COOPERATIVE LEARNING SKILLS', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
        { skill: 'INDEPENDENT SEAT WORK', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
        { skill: 'MOTIVATION', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
        { skill: 'COMPLIANCE', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
      ],
    };
  },
  methods: {
    submitForm() {
      // Handle form submission
      console.log('Form submitted', this.rows);
    },
  },
};
</script>

<style scoped>
/* Adjustments for table and other styles */
table {
  border-collapse: collapse;
}

th, td {
  padding: 8px;
  text-align: left;
}

input[type="text"], textarea {
  border-width: 1px;
}
</style>
