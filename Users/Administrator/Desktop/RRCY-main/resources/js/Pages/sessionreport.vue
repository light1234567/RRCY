<template>
    <div class="mx-auto p-8 bg-gray-100 rounded-lg max-w-full">
      <form @submit.prevent="submitForm" class="space-y-8 w-full">
        <!-- Header -->
        <div class="border border-gray-300 p-6 rounded-md bg-white">
          <h1 class="font-bold text-lg mb-4">Session Form</h1>
  
          <!-- General Information -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label for="drn" class="block font-medium">DRN:</label>
              <input type="text" id="drn" placeholder="Enter DRN" required class="block w-full p-2 border border-gray-300 rounded-md">
            </div>
            <div class="space-y-2">
              <label for="session" class="block font-medium">Session:</label>
              <input type="text" id="session" placeholder="Enter session" required class="block w-full p-2 border border-gray-300 rounded-md">
            </div>
            <div class="space-y-2">
              <label for="title" class="block font-medium">Title of Session:</label>
              <input type="text" id="title" placeholder="Enter session title" required class="block w-full p-2 border border-gray-300 rounded-md">
            </div>
            <div class="space-y-2">
              <label for="dateConducted" class="block font-medium">Date Conducted:</label>
              <input type="date" id="dateConducted" required class="block w-full p-2 border border-gray-300 rounded-md">
            </div>
          </div>
  
          <!-- Session Sections -->
          <div class="space-y-4 mt-6">
            <div class="space-y-2">
              <label for="objective" class="block font-medium">Section I: Objective</label>
              <textarea id="objective" placeholder="Enter objective details" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
            </div>
            <div class="space-y-2">
              <label for="methodology" class="block font-medium">Section II: Methodology</label>
              <textarea id="methodology" placeholder="Enter methodology details" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
            </div>
            <div class="space-y-2">
              <label for="highlight" class="block font-medium">Section III: Highlight of the Session and Activity</label>
              <textarea id="highlight" placeholder="Enter session highlight details" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
            </div>
            <div class="space-y-2">
              <label for="outcome" class="block font-medium">Section IV: Outcome</label>
              <textarea id="outcome" placeholder="Enter outcome details" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
            </div>
          </div>
  
          <!-- Signatures -->
          <div class="space-y-4 mt-6">
            <div class="space-y-2">
              <label for="notedBy" class="block font-medium">Noted by:</label>
              <input type="text" id="notedBy" placeholder="Enter name of person noting" class="block w-full p-2 border border-gray-300 rounded-md">
            </div>
            <div class="space-y-2">
              <label for="approvedBy" class="block font-medium">Approved by:</label>
              <input type="text" id="approvedBy" placeholder="Enter name of person approving" class="block w-full p-2 border border-gray-300 rounded-md">
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
    name: 'SessionForm',
    methods: {
      submitForm() {
        // Handle form submission
        console.log('Form submitted');
      }
    }
  }
  </script>
  

  