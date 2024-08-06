<template>
    <div class="mx-auto p-8 bg-gray-100 rounded-lg max-w-full">
      <form @submit.prevent="submitForm" class="space-y-8 w-full">
        <!-- Header -->
        <div class="border border-gray-300 p-6 rounded-md bg-white">
          
          <!-- Identifying Data Section -->
          <div class="space-y-4 mt-6">
            <h2 class="font-bold">INITIAL PSYCHOLOGICAL ASSESSMENT REPORT FORM</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="name" class="block font-medium">Name:</label>
                <input type="text" id="name" placeholder="Enter name" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
              <div class="space-y-2">
                <label for="nickname" class="block font-medium">Nickname:</label>
                <input type="text" id="nickname" placeholder="Enter nickname" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="birthDate" class="block font-medium">Birth Date:</label>
                <input type="date" id="birthDate" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
              <div class="space-y-2">
                <label for="age" class="block font-medium">Age:</label>
                <input type="number" id="age" placeholder="Enter age" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="gender" class="block font-medium">Gender:</label>
                <input type="text" id="gender" placeholder="Enter gender" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
              <div class="space-y-2">
                <label for="address" class="block font-medium">Address:</label>
                <input type="text" id="address" placeholder="Enter address" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="religion" class="block font-medium">Religion:</label>
                <input type="text" id="religion" placeholder="Enter religion" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
              <div class="space-y-2">
                <label for="education" class="block font-medium">Educational Attainment:</label>
                <input type="text" id="education" placeholder="Enter educational attainment" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="offense" class="block font-medium">Offense Committed:</label>
                <input type="text" id="offense" placeholder="Enter offense committed" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
              <div class="space-y-2">
                <label for="admissionDate" class="block font-medium">Date of Admission:</label>
                <input type="date" id="admissionDate" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
              <div class="space-y-2">
                <label for="reportDate" class="block font-medium">Date of Report:</label>
                <input type="date" id="reportDate" required class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
            </div>
          </div>
  
          <!-- Reason for Referral Section -->
          <div class="space-y-4 mt-6">
            <h2 class="font-bold">REASON FOR REFERRAL</h2>
            <textarea id="reasonForReferral" placeholder="Enter reason for referral" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
          </div>
  
          <!-- Brief Background Section -->
          <div class="space-y-4 mt-6">
            <h2 class="font-bold">BRIEF BACKGROUND</h2>
            <div class="space-y-2">
              <label for="familyHistory" class="block font-medium">Family History</label>
              <textarea id="familyHistory" placeholder="Enter family history" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
            </div>
            <div class="space-y-2">
              <label for="sexualDevelopment" class="block font-medium">Sexual Development</label>
              <textarea id="sexualDevelopment" placeholder="Enter sexual development" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
            </div>
            <div class="space-y-2">
              <label for="medicalHistory" class="block font-medium">Medical and Psychological History</label>
              <textarea id="medicalHistory" placeholder="Enter medical and psychological history" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
            </div>
            <div class="space-y-2">
              <label for="schoolHistory" class="block font-medium">School History</label>
              <textarea id="schoolHistory" placeholder="Enter school history" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
            </div>
            <div class="space-y-2">
              <label for="socialHistory" class="block font-medium">Social History (including Spiritual Development and Work Experience)</label>
              <textarea id="socialHistory" placeholder="Enter social history" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
            </div>
            <div class="space-y-2">
              <label for="personalCharacteristics" class="block font-medium">Personal Characteristics</label>
              <textarea id="personalCharacteristics" placeholder="Enter personal characteristics" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
            </div>
          </div>
  
          <!-- Assessment Tools Section -->
          <div class="space-y-4 mt-6">
            <h2 class="font-bold">ASSESSMENT TOOLS</h2>
            <div class="space-y-2">
              <label for="reviewSystems" class="block font-medium">Review the major systems of psychiatric functioning (appearance, cognitive function, insight, etc.).</label>
              <textarea id="reviewSystems" placeholder="Enter review systems" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
            </div>
            <div class="space-y-2">
              <label for="mentalStatus" class="block font-medium">Mental Status Examination</label>
              <textarea id="mentalStatus" placeholder="Enter mental status examination" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
            </div>
            <div class="space-y-2">
              <label for="assessmentInterview" class="block font-medium">Gathering information about the client, assessing his strengths, level of adjustment, the nature and history of the problem, and relevant personal and family history.</label>
              <textarea id="assessmentInterview" placeholder="Enter assessment interview" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
            </div>
          </div>
  
          <!-- Test Result and Discussion Section -->
          <div class="space-y-4 mt-6">
            <h2 class="font-bold">TEST RESULT AND DISCUSSION</h2>
            <div class="space-y-2">
              <label for="testResult" class="block font-medium">Mental Status Examination</label>
              <textarea id="testResult" placeholder="Enter test result and discussion" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
            </div>
          </div>
  
          <!-- Clinical Impression Section -->
          <div class="space-y-4 mt-6">
            <h2 class="font-bold">CLINICAL IMPRESSION</h2>
            <textarea id="clinicalImpression" placeholder="Enter clinical impression" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
          </div>
  
          <!-- Plan of Action Section -->
          <div class="space-y-4 mt-6">
            <h2 class="font-bold">PLAN OF ACTION</h2>
            <textarea id="planOfAction" placeholder="Enter plan of action" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
          </div>
  
          <!-- Signatures Section -->
          <div class="space-y-4 mt-6">
            <div class="space-y-2">
              <label for="preparedBy" class="block font-medium">Prepared by:</label>
              <input type="text" id="preparedBy" value="BRYAN V. GALANG" readonly class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200">
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
    name: 'InitialPsychologicalAssessmentForm',
    methods: {
      submitForm() {
        // Handle form submission
        console.log('Form submitted');
      }
    }
  }
  </script>
  
