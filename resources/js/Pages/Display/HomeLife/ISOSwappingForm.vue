<template>
  <div class="mx-auto p-8 bg-gray-100 rounded-lg max-w-full">
    <form @submit.prevent="submitForm" class="space-y-8 w-full">
      <!-- Header -->
      <div class="border border-gray-300 p-6 rounded-md bg-white">
        <h1 class="font-bold text-lg mb-4">Request Form</h1>
        <div class="space-y-4">
          <!-- DRN Section -->
          <div class="space-y-2">
            <label for="drn" class="block font-medium">DRN:</label>
            <input type="text" id="drn" required class="block w-full p-2 border border-gray-300 rounded-md">
          </div>


          <!-- Date of Filing and Requesting Party Section -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="space-y-2">
              <label for="dateOfFiling" class="block font-medium">Date of Filing:</label>
              <input type="date" id="dateOfFiling" required class="block w-full p-2 border border-gray-300 rounded-md">
            </div>
          </div>

          <!-- Requesting Party Details -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="space-y-2">
              <label for="requestingPartyName" class="block font-medium">Name of Requesting Party:</label>
              <input type="text" id="requestingPartyName" required class="block w-full p-2 border border-gray-300 rounded-md">
            </div>
            <div class="space-y-2">
              <label for="requestingPartyPosition" class="block font-medium">Position:</label>
              <input type="text" id="requestingPartyPosition" required class="block w-full p-2 border border-gray-300 rounded-md">
            </div>
            <div class="space-y-2">
              <label for="dateOfDuty" class="block font-medium">Date of Duty:</label>
              <input type="date" id="dateOfDuty" required class="block w-full p-2 border border-gray-300 rounded-md">
            </div>
            <div class="space-y-2">
              <label for="timeOfDuty" class="block font-medium">Time of Duty:</label>
              <input type="time" id="timeOfDuty" required class="block w-full p-2 border border-gray-300 rounded-md">
            </div>
          </div>

          <div class="space-y-4">
            <h2 class="font-bold text-lg mb-4">SOD Section</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <div class="space-y-2">
                <label for="sodName" class="block font-medium">Name of SOD accepting the request:</label>
                <input type="text" id="sodName" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
              <div class="space-y-2">
                <label for="sodDateOfDuty" class="block font-medium">Date of Duty:</label>
                <input type="date" id="sodDateOfDuty" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <div class="space-y-2">
                <label for="sodPosition" class="block font-medium">Position:</label>
                <input type="text" id="sodPosition" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
              <div class="space-y-2">
                <label for="sodShiftTime" class="block font-medium">Shift/Time of Duty:</label>
                <input type="text" id="sodShiftTime" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
            </div>
          </div>

          <!-- Purpose Section -->
          <div class="space-y-2">
            <label for="purpose" class="block font-medium">Purpose:</label>
            <textarea id="purpose" rows="4" required class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
          </div>

          <!-- Requested and Accepted By Section -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="space-y-2">
              <label for="requestedBy" class="block font-medium">Requested by:</label>
              <input type="text" id="requestedBy" required class="block w-full p-2 border border-gray-300 rounded-md">
            </div>
            <div class="space-y-2">
              <label for="acceptedBy" class="block font-medium">Accepted by:</label>
              <input type="text" id="acceptedBy" required class="block w-full p-2 border border-gray-300 rounded-md">
            </div>
          </div>

          <!-- Signatures Section -->
          <div class="space-y-4 mt-6">
            <div class="space-y-2">
              <label for="notedBy" class="block font-medium">Noted by:</label>
              <input type="text" id="notedBy" value="VAN M. DE LEON" readonly class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200">
              <p class="text-sm">HP III/ SHP</p>
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
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: 'RequestForm',
  methods: {
    submitForm() {
      // Handle form submission
      console.log('Form submitted');
    }
  }
}
</script>