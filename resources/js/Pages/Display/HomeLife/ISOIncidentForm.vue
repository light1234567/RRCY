<template>
    <div class="mx-auto p-8 bg-gray-100 rounded-lg max-w-full">
     <form @submit.prevent="submitForm" class="space-y-8 w-full">
        <!-- Header -->
        <div class="border border-gray-300 p-6 rounded-md bg-white">
          <h1 class="font-bold text-lg mb-4">Incident Report Form</h1>
  
          <!-- General Information -->
          <div class="space-y-2">
            <label for="drn" class="block font-medium">DRN:</label>
            <input type="text" id="drn" placeholder="Enter DRN" required class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
  
          <!-- Incident Details -->
          <div class="space-y-4 mt-6">
            <div class="space-y-2">
              <label for="incident" class="block font-medium">What was the incident:</label>
              <textarea id="incident" placeholder="Enter incident details" class="block w-full p-2 border border-gray-300 rounded-md" rows="4"></textarea>
            </div>
            
            <div class="text-center font-medium mt-4">
              WHEN IT HAPPENED
            </div>
  
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
              <div class="space-y-2">
                <label for="dateOfIncident" class="block font-medium">Date of Incident:</label>
                <input type="date" id="dateOfIncident" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
              <div class="space-y-2">
                <label for="timeOfIncident" class="block font-medium">Time:</label>
                <input type="time" id="timeOfIncident" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
            </div>
  
            <div class="space-y-2 mt-4">
              <label for="involved" class="block font-medium">Who are involved:</label>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <input type="text" id="involved1" placeholder="Enter name" class="block w-full p-2 border border-gray-300 rounded-md">
                <input type="text" id="involved2" placeholder="Enter name" class="block w-full p-2 border border-gray-300 rounded-md">
                <input type="text" id="involved3" placeholder="Enter name" class="block w-full p-2 border border-gray-300 rounded-md">
                <input type="text" id="involved4" placeholder="Enter name" class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
            </div>
  
            <div class="space-y-2 mt-4">
              <label for="location" class="block font-medium">Where it happened:</label>
              <textarea id="location" placeholder="Enter location" class="block w-full p-2 border border-gray-300 rounded-md" rows="4"></textarea>
            </div>
  
            <div class="space-y-2 mt-4">
              <label for="actionTaken" class="block font-medium">Action Taken:</label>
              <textarea id="actionTaken" placeholder="Enter actions taken" class="block w-full p-2 border border-gray-300 rounded-md" rows="4"></textarea>
            </div>
  
            <div class="space-y-2 mt-4">
              <label for="agreements" class="block font-medium">Agreements Reached/Advice Given to Residents Involved:</label>
              <textarea id="agreements" placeholder="Enter agreements or advice" class="block w-full p-2 border border-gray-300 rounded-md" rows="4"></textarea>
            </div>
  
            <div class="space-y-2 mt-4">
              <label for="correctiveMeasure" class="block font-medium">Corrective Measure:</label>
              <textarea id="correctiveMeasure" placeholder="Enter corrective measures" class="block w-full p-2 border border-gray-300 rounded-md" rows="4"></textarea>
            </div>
          </div>
  
          <!-- Signatures -->
          <div class="space-y-4 mt-6">
            <div class="space-y-2">
              <label for="preparedBy" class="block font-medium">Prepared by:</label>
              <input type="text" id="preparedBy" placeholder="Enter name of person preparing" class="block w-full p-2 border border-gray-300 rounded-md">
            </div>
            <div class="space-y-2">
              <label for="reviewedBy" class="block font-medium">Reviewed by:</label>
              <input type="text" id="reviewedBy" value="VAN M. DE LEON" readonly class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200">
              <p class="text-sm">HPIII/SHP</p>
            </div>
            <div class="space-y-2">
              <label for="approvedBy" class="block font-medium">Approved by:</label>
              <input type="text" id="approvedBy" value="ANGELIC B. PAÑA" readonly class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200">
              <p class="text-sm">SWO IV / Center Head</p>
            </div>
          </div>
        </div>
  
        <!-- Submit Button -->
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Submit</button>
      </form>
    </div>
  </template>
  
