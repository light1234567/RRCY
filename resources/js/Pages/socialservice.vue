<template>
  <div class="mx-auto p-8 bg-gray-100 rounded-lg max-w-full">
    <form @submit.prevent="submitForm" class="space-y-8 w-full">

      <!-- Admission Slip -->
      <div class="border border-gray-300 p-6 rounded-md bg-white">
        <h1 class="font-bold text-lg mb-4">Admission Slip</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-2">
            <label for="name" class="block font-medium">Name:</label>
            <input type="text" id="name" placeholder="Enter name" required class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="space-y-2">
            <label for="sex" class="block font-medium">Sex:</label>
            <select id="sex" required class="block w-full p-2 border border-gray-300 rounded-md">
              <option value="" disabled>Select</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <div class="space-y-2">
            <label for="address" class="block font-medium">Address:</label>
            <input type="text" id="address" placeholder="Enter address" required class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="space-y-2">
            <label for="religion" class="block font-medium">Religion:</label>
            <input type="text" id="religion" placeholder="Enter religion" class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="space-y-2">
            <label for="dob" class="block font-medium">Date/Place of Birth:</label>
            <input type="date" id="dob" required class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
        </div>
      

      <!-- Case Information -->
        <div class="space">
        <h2 class="font-bold text-lg mb-4">Case Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-2">
            <label for="committingCourt" class="block font-medium">Committing Court:</label>
            <input type="text" id="committingCourt" placeholder="Enter committing court" class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="space-y-2">
            <label for="criminalCaseNo" class="block font-medium">Crim. Case #:</label>
            <input type="text" id="criminalCaseNo" placeholder="Enter criminal case number" class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="space-y-2">
            <label for="offenseCommitted" class="block font-medium">Offense Committed:</label>
            <input type="text" id="offenseCommitted" placeholder="Enter offense committed" class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="space-y-2">
            <label for="dateAdmitted" class="block font-medium">Date admitted to Center:</label>
            <input type="date" id="dateAdmitted" required class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="space-y-2">
            <label for="daysInJail" class="block font-medium">No. of Days in Jail:</label>
            <input type="number" id="daysInJail" placeholder="Enter number of days" min="0" required class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="space-y-2">
            <label for="daysInDetention" class="block font-medium">No. of Days in Detention Center:</label>
            <input type="number" id="daysInDetention" placeholder="Enter number of days" min="0" required class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
        </div>
      </div> 

      <!-- Distinguishing Marks -->
 
        <h2 class="font-bold text-lg mb-4">Distinguishing Marks</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-2">
            <label for="tattoo" class="block font-medium">a. Tattoo/Scars:</label>
            <input type="text" id="tattoo" placeholder="Enter tattoo details" class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="space-y-2">
            <label for="height" class="block font-medium">b. Height:</label>
            <input type="text" id="height" placeholder="Enter height" class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="space-y-2">
            <label for="weight" class="block font-medium">c. Weight:</label>
            <input type="text" id="weight" placeholder="Enter weight" class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="space-y-2">
            <label for="eyeColor" class="block font-medium">d. Colour of Eye:</label>
            <input type="text" id="eyeColor" placeholder="Enter eye color" class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="space-y-2">
            <label for="skinColor" class="block font-medium">e. Skin:</label>
            <input type="text" id="skinColor" placeholder="Enter skin color" class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
        </div>
  

      <!-- Documents Submitted -->
        <h2 class="font-bold text-lg mb-4">Documents Submitted</h2>
        <div class="flex flex-wrap gap-4">
          <label class="block">
            <input type="checkbox" class="mr-2"> 1.) SCSR
          </label>
          <label class="block">
            <input type="checkbox" class="mr-2"> 2.) Court Order
          </label>
          <label class="block">
            <input type="checkbox" class="mr-2"> 3.) Medical Certificates
          </label>
          <label class="block">
            <input type="checkbox" class="mr-2"> 4.) Consent from Parents
          </label>
          <label class="block">
            <input type="checkbox" class="mr-2"> 5.) School Records
          </label>
          <label class="block">
            <input type="checkbox" class="mr-2"> 6.) Others
          </label>
        </div>

      <!-- Additional Information -->
        <h2 class="font-bold text-lg mb-4">Additional Information</h2>
        <div class="space-y-4">
          <div class="space-y-2">
            <label for="generalImpression" class="block font-medium">General Impression upon admission:</label>
            <textarea id="generalImpression" placeholder="Enter general impression" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
          </div>
          <div class="space-y-2">
            <label for="actionTaken" class="block font-medium">Action Taken:</label>
            <textarea id="actionTaken" placeholder="Enter action taken" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
          </div>
        </div>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Submit</button>
    </form>
  </div>
</template>
