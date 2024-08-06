<template>
    <div class="mx-auto p-8 bg-gray-100 rounded-lg max-w-full">
      <form @submit.prevent="submitForm" class="space-y-8 w-full">
        <!-- Header -->
        <div class="border border-gray-300 p-6 rounded-md bg-white">
          <h1 class="font-bold text-lg mb-4">Intervention Plan</h1>
  
          <!-- Psychological Service Section -->
          <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="asOfDate" class="block font-medium">As of:</label>
                <input type="date" id="asOfDate" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
            </div>
  
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="name" class="block font-medium">Name:</label>
                <input type="text" id="name" placeholder="Enter name" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
              <div class="space-y-2">
                <label for="age" class="block font-medium">Age:</label>
                <input type="number" id="age" placeholder="Enter age" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
              <div class="space-y-2">
                <label for="dateAdmitted" class="block font-medium">Date Admitted:</label>
                <input type="date" id="dateAdmitted" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
            </div>
          </div>
  
          <!-- Dynamic Table Section -->
          <div class="space-y-4 mt-6">
            <label class="block font-medium">Intervention Plan Details:</label>
        
          </div>
  
          <!-- Progress Notes Section -->
          <div class="space-y-4 mt-6">
            <label for="progressNotes" class="block font-medium">Progress notes:</label>
            <textarea id="progressNotes" placeholder="Enter progress notes" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
          </div>
  
          <!-- Signatures Section -->
          <div class="space-y-4 mt-6">
            <div class="space-y-2">
              <label for="preparedBy" class="block font-medium">Prepared by:</label>
              <input type="text" id="preparedBy" value="BRYAN V. GALANG, MPsy, RPsy" readonly class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200">
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
  
  

  </script>
  