<template>
    <div class="mx-auto p-8 bg-gray-100 rounded-lg max-w-full">
      <form @submit.prevent="submitForm" class="space-y-8 w-full">
        <!-- Header -->
        <div class="border border-gray-300 p-6 rounded-md bg-white">
  
          <!-- Progress Report Section -->
          <div class="space-y-4 mt-6">
            <h2 class="font-bold text-lg">PROGRESS REPORT</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="name" class="block font-medium">Name:</label>
                <input type="text" id="name" placeholder="Enter name" class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
              <div class="space-y-2">
                <label for="age" class="block font-medium">Age:</label>
                <input type="text" id="age" placeholder="Enter age" class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="dateAdmitted" class="block font-medium">Date Admitted:</label>
                <input type="date" id="dateAdmitted" class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
              <div class="space-y-2">
                <label for="interventionPeriod" class="block font-medium">Period of Intervention Plan:</label>
                <input type="text" id="interventionPeriod" placeholder="Enter intervention period" class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
            </div>
          </div>
  
          <!-- Problem Behavior Log Section -->
          <div class="space-y-4 mt-6">
            <h2 class="font-bold">PROBLEM BEHAVIOR LOG</h2>
            <textarea id="problemBehaviorLog" placeholder="Enter problem behavior log" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
          </div>
  
          <!-- Interventions Conducted Section -->
          <div class="space-y-4 mt-6">
            <h2 class="font-bold">INTERVENTIONS CONDUCTED</h2>
            <textarea id="interventionsConducted" placeholder="Enter interventions conducted" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
          </div>
  
          <!-- Progress Notes Section -->
          <div class="space-y-4 mt-6">
            <h2 class="font-bold">PROGRESS NOTES</h2>
            <textarea id="progressNotes" placeholder="Enter progress notes" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
          </div>
  
          <!-- Signatures Section -->
          <div class="space-y-4 mt-6">
            <div class="space-y-2">
              <label for="preparedBy" class="block font-medium">Prepared by:</label>
              <input type="text" id="preparedBy" value="BRYAN V. GALANG MPsy, RPsy" readonly class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200">
              <p class="text-sm">Psychologist I</p>
            </div>
            <div class="space-y-2">
              <label for="notedBy" class="block font-medium">Noted by:</label>
              <input type="text" id="notedBy" value="ANGELIC B. PAÑA, RSW, MSSW" readonly class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200">
              <p class="text-sm">SWO IV / Center Head</p>
            </div>
          </div>
        </div>
  
        <!-- Submit Button -->
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Submit</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    name: 'ProgressReportForm',
    methods: {
      submitForm() {
        // Handle form submission
        console.log('Form submitted');
      }
    }
  }
  </script>
  