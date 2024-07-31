<template>
  <div class="mx-auto p-8 bg-gray-100 rounded-lg max-w-full">
    <form @submit.prevent="submitForm" class="space-y-8 w-full">
      <!-- Header -->
      <div class="border border-gray-300 p-6 rounded-md bg-white">
        <h1 class="font-bold text-lg mb-4">Anecdotal Report Form</h1>

        <!-- General Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-2">
            <label for="name" class="block font-medium">Pangalan:</label>
            <input type="text" id="name" placeholder="Enter name" required class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="space-y-2">
            <label for="date" class="block font-medium">Date:</label>
            <input type="date" id="date" required class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="space-y-2">
            <label for="drn" class="block font-medium">DRN:</label>
            <input type="text" id="drn" placeholder="Enter DRN" class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
          <div class="space-y-2">
            <label for="color" class="block font-medium">Color:</label>
            <input type="text" id="color" placeholder="Enter color" class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
        </div>

        <!-- Report Sections -->
        <div class="space-y-4 mt-6">
          <div class="space-y-2">
            <label for="physical" class="block font-medium">I. Physical:</label>
            <textarea id="physical" placeholder="Enter physical details" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
          </div>
          <div class="space-y-2">
            <label for="emotional" class="block font-medium">II. Emotional:</label>
            <textarea id="emotional" placeholder="Enter emotional details" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
          </div>
          <div class="space-y-2">
            <label for="behavioral" class="block font-medium">III. Social/Behavioral:</label>
            <textarea id="behavioral" placeholder="Enter social/behavioral details" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
          </div>
          <div class="space-y-2">
            <label for="spiritual" class="block font-medium">IV. Spiritual:</label>
            <textarea id="spiritual" placeholder="Enter spiritual details" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
          </div>
          <div class="space-y-2">
            <label for="recommendation" class="block font-medium">V. Recommendation:</label>
            <textarea id="recommendation" placeholder="Enter recommendations" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
          </div>
        </div>

        <!-- Signatures -->
        <div class="space-y-4 mt-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label for="notedBy" class="block font-medium">Noted by:</label>
              <input type="text" id="notedBy" placeholder="Enter name of person noting" class="block w-full p-2 border border-gray-300 rounded-md">
            </div>
            <div class="space-y-2">
              <label for="approvedBy" class="block font-medium">Approved by:</label>
              <input type="text" id="approvedBy" placeholder="Enter name of person approving" class="block w-full p-2 border border-gray-300 rounded-md">
            </div>
          </div>
          <div class="space-y-2">
            <label for="preparedBy" class="block font-medium">Prepared by:</label>
            <input type="text" id="preparedBy" placeholder="Enter name of person preparing" class="block w-full p-2 border border-gray-300 rounded-md">
          </div>
        </div>

        <!-- Signature Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
          <div class="space-y-2">
            <button type="button" class="w-full p-2 border border-gray-300 rounded-md">INSERT SIGNATURE</button>
            <input type="text" id="houseParents" placeholder="Enter House Parents' name" class="block w-full p-2 border border-gray-300 rounded-md mt-2">
            <p class="text-center">House Parents</p>
          </div>
          <div class="space-y-2">
            <button type="button" class="w-full p-2 border border-gray-300 rounded-md">INSERT SIGNATURE</button>
            <input type="text" id="residents" placeholder="Enter Residents' name" class="block w-full p-2 border border-gray-300 rounded-md mt-2">
            <p class="text-center">Residents</p>
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
  methods: {
    submitForm() {
      // Add form submission logic here
      alert('Form submitted!');
    }
  }
}
</script>

<style scoped>
/* Add any additional styling if needed */
</style>
