<template>
 <div class="p-6 border border-gray-300 rounded-md bg-white max-w-4xl mx-auto">
    <form @submit.prevent="submitForm">
      <!-- Header Section -->
      <div class="text-center mb-6">
        <div>
        <h1 class="font-bold text-xl">LEARNER’S ACADEMIC BEHAVIORAL FORM</h1>
        <label for="Forthemonth" class="block font-medium flex">For the Month of:</label>
        <input type="text" id="status" class="block w-1/2 p-2 border border-gray-300 rounded-md " />
      </div>
      <div></div>
      <label for="Forthemonth" class="block font-medium flex">School Year:</label>
      <input type="text" id="status" class="block w-1/2 p-2 border border-gray-300 rounded-md" />
      <div></div>
      </div>

      <!-- Learner Information Section -->
      <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
          <label for="learnerName" class="block font-medium">Learner’s Name:</label>
          <input type="text" id="learnerName" class="block w-full p-2 border border-gray-300 rounded-md" />
        </div>
        <div>
          <label for="grade" class="block font-medium">Grade:</label>
          <input type="text" id="grade" class="block w-full p-2 border border-gray-300 rounded-md" />
        </div>
        <div>
          <label for="lrn" class="block font-medium">LRN:</label>
          <input type="text" id="lrn" class="block w-full p-2 border border-gray-300 rounded-md" />
        </div>
        <div>
          <label for="status" class="block font-medium">Status:</label>
          <input type="text" id="status" class="block w-full p-2 border border-gray-300 rounded-md" />
        </div>
      </div>

      <!-- Learner Skills Section -->
      <div class="border border-gray-300 p-6 rounded-md bg-white mb-6">
        <div class="grid grid-cols-4 gap-4 mb-4 text-center">
          <div class="font-bold">OUTSTANDING</div>
          <div class="font-bold">VERY SATISFACTORY</div>
          <div class="font-bold">SATISFACTORY</div>
          <div class="font-bold">FAIRLY SATISFACTORY</div>
        </div>
        <div class="grid grid-cols-4 gap-4 mb-4 text-center">
          <div>*Well performed. Tasks are fully completed, all relevant information provided accurately and adequately where necessary. *Relevant tasks well performed; no tasks left incomplete</div>
          <div>*General satisfactory with only minor omissions and inadequacies. Part of it is well attempted but overall, just satisfactory because of some major omissions and the limited coverage of the information.</div>
          <div>*Revealing significant omission and inadequacies. Very limited coverage performed.</div>
          <div>*Very unsatisfactory, important task(s) are poorly done or not attempted to do so.</div>
        </div>

        <table class="w-full border-collapse">
          <thead>
            <tr>
              <th class="border p-2">Learner Skill</th>
              <th class="border p-2">Outstanding</th>
              <th class="border p-2">Very Satisfactory</th>
              <th class="border p-2">Satisfactory</th>
              <th class="border p-2">Fairly Satisfactory</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, index) in rows" :key="index">
              <td class="border p-2">{{ row.skill }}</td>
              <td class="border p-2"><input type="text" v-model="row.outstanding" class="w-full p-1 border border-gray-300 rounded-md" /></td>
              <td class="border p-2"><input type="text" v-model="row.verySatisfactory" class="w-full p-1 border border-gray-300 rounded-md" /></td>
              <td class="border p-2"><input type="text" v-model="row.satisfactory" class="w-full p-1 border border-gray-300 rounded-md" /></td>
              <td class="border p-2"><input type="text" v-model="row.fairlySatisfactory" class="w-full p-1 border border-gray-300 rounded-md" /></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Observation/Feedback Section -->
      <div class="border border-gray-300 p-6 rounded-md bg-white mb-6">
        <label for="observationFeedback" class="block font-medium">Observation/Feedback:</label>
        <textarea id="observationFeedback" rows="6" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
      </div>

      <!-- Signature Section -->
      <div class="grid grid-cols-3 gap-4 mb-4">
        <div class="text-center">
          <label for="learnerSignature" class="block font-medium">Learner</label>
          <input type="text" id="learnerSignature" class="block w-full p-2 border border-gray-300 rounded-md" />
        </div>
        <div class="text-center">
          <label for="categoryAdviserSignature" class="block font-medium">Category Adviser</label>
          <input type="text" id="categoryAdviserSignature" class="block w-full p-2 border border-gray-300 rounded-md" />
        </div>
        <div class="text-center">
          <label for="educationalSectionHeadSignature" class="block font-medium">Educational Section Head</label>
          <input type="text" id="educationalSectionHeadSignature" class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200" value="Raldie Lloyd D. Adolfo, LPT" readonly />
          <p class="text-sm">Educational Section Head</p>
        </div>
        <div class="text-center">
          <label for="centerHeadSignature" class="block font-medium">Center Head</label>
          <input type="text" id="centerHeadSignature" class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200" value="Angelic B. Pańa, RSW, MSSW" readonly />
          <p class="text-sm">Center Head</p>
        </div>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Submit</button>
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
#status {
  border-width: 1px; /* Adjust the width as needed */
}
</style>
