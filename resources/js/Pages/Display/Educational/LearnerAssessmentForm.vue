<template>
  <div class="max-w-3xl p-8 bg-white shadow-xl mx-auto my-8 border border-gray-200">
      <!-- Header Section with Logo and Document Details -->
      <div class="relative flex justify-between items-center mb-4">
        <img src="/images/headerlogo2.png" alt="Logo" class="h-24 w-48">
        <div class="text-right flex flex-col justify-center">
          <p class="text-sm font-semibold">PROTECTIVE SERVICES DIVISION</p>
          <p class="text-sm font-semibold">Regional Rehabilitation Center for Youth</p>
          <p class="text-sm font-semibold">Youth/RFO XI</p>
          <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
        </div>
      </div>
  
      <form @submit.prevent="submitForm">
        <!-- Learner's Information -->
        <h1 class="font-bold text-xl mb-4">LEARNER’S ASSESSMENT FORM</h1>
        <div class="grid grid-cols-3 gap-4 mb-4">
          <div>
            <label for="schoolYear" class="block font-medium">School Year:</label>
            <input type="text" id="schoolYear" class="block w-full p-2 border border-gray-300" />
          </div>
          <div>
            <label for="gradingPeriod" class="block font-medium">Grading Period:</label>
            <input type="text" id="gradingPeriod" class="block w-full p-2 border border-gray-300" />
          </div>
          <div>
            <label for="name" class="block font-medium">Name:</label>
            <input type="text" id="name" class="block w-full p-2 border border-gray-300 " />
          </div>
          <div>
            <label for="grade" class="block font-medium">Grade:</label>
            <input type="text" id="grade" class="block w-full p-2 border border-gray-300 " />
          </div>
          <div>
            <label for="date" class="block font-medium">Date:</label>
            <input type="text" id="date" class="block w-full p-2 border border-gray-300" />
          </div>
        </div>
  
        <!-- Reading Assessment -->
        <h2 class="font-bold text-lg mb-4">Reading Assessment</h2>
        <table class="w-full border-collapse mb-6">
          <thead>
            <tr class="bg-gray-200">
              <th class="border p-2 text-left">Aspect</th>
              <th class="border p-2 text-left">1</th>
              <th class="border p-2 text-left">2</th>
              <th class="border p-2 text-left">3</th>
              <th class="border p-2 text-left">4</th>
              <th class="border p-2 text-left">Remarks</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="border p-2">Pronunciation of Words</td>
              <td class="border p-2">The learner struggles to pronounce the words.</td>
              <td class="border p-2">Some words are pronounced correctly</td>
              <td class="border p-2">Most words are pronounced correctly</td>
              <td class="border p-2">All words are pronounced correctly</td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" /></td>
            </tr>
            <tr>
              <td class="border p-2">Fluency of Reading</td>
              <td class="border p-2">Struggles to read.</td>
              <td class="border p-2">Read word for word</td>
              <td class="border p-2">Words are grouped together logically</td>
              <td class="border p-2">Reading is easy and fluent</td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" /></td>
            </tr>
            <tr>
              <td class="border p-2">Use of Punctuation</td>
              <td class="border p-2">Punctuation marks are ignored.</td>
              <td class="border p-2">Punctuation marks replaced with a breath</td>
              <td class="border p-2">Punctuation is observed, but tends to stop at the end of a line.</td>
              <td class="border p-2">Punctuation is used correctly and efficiently</td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" /></td>
            </tr>
          </tbody>
        </table>
  
        <!-- Reading Remarks -->
        <h2 class="font-bold text-lg mb-4">Reading Remarks</h2>
        <table class="w-full border-collapse mb-6">
          <thead>
            <tr class="bg-gray-200">
              <th class="border p-2 text-left">Level</th>
              <th class="border p-2 text-left">Description</th>
              <th class="border p-2 text-left" rowspan="5">Remarks</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="border p-2">Advance</td>
              <td class="border p-2">
                He can identify details from the text. He can give insightful evidence to support his conclusions and to make inferences. He can interpret unfamiliar words based on context.<br />
                He demonstrates a sophisticated understanding of the concepts and competencies relevant to the expected learning.
              </td>
              <td class="border p-2" rowspan="5">
                <input type="text" class="w-full p-1 border border-gray-300 h-full" />
              </td>
            </tr>
            <tr>
              <td class="border p-2">Proficient</td>
              <td class="border p-2">
                He can identify the main and details about the text. He can give evidence from the text to support conclusions. His ability to make inferences is limited as he can understand familiar words, but he has trouble interpreting new words.<br />
                He demonstrates a complete understanding of the concepts and competencies relevant to the expected learning.
              </td>
            </tr>
            <tr>
              <td class="border p-2">Developing</td>
              <td class="border p-2">
                He can identify the main idea and a few details about the text. He struggles to provide evidence and make inferences. He can understand familiar words when they are used in familiar contexts.<br />
                He demonstrates a partial understanding of the concepts and competencies relevant to the expected learning.
              </td>
            </tr>
            <tr>
              <td class="border p-2">Emerging</td>
              <td class="border p-2">
                His ability to interpret individual words significantly limits his understanding of the text. He can identify the main idea of the text, but he cannot give details or textual evidence to support conclusions about the text.<br />
                He demonstrates an initial understanding of the concepts and competencies relevant to the expected learning.
              </td>
            </tr>
            <tr>
              <td class="border p-2">Beginning</td>
              <td class="border p-2">
                He cannot understand the words in the text well enough to be able to identify the main idea or any details about the text.
              </td>
            </tr>
          </tbody>
        </table>
  
        <!-- Writing Assessment -->
        <h2 class="font-bold text-lg mb-4">Writing Assessment</h2>
        <table class="w-full border-collapse mb-6">
          <thead>
            <tr class="bg-gray-200">
              <th class="border p-2 text-left">Aspect</th>
              <th class="border p-2 text-left">Excellent</th>
              <th class="border p-2 text-left">Good</th>
              <th class="border p-2 text-left">Fair</th>
              <th class="border p-2 text-left">Needs Improvement</th>
              <th class="border p-2 text-left">Remarks</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="border p-2">Punctuation</td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" /></td>
            </tr>
            <tr>
              <td class="border p-2">Capitalization</td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 " /></td>
            </tr>
            <tr>
              <td class="border p-2">Grammar</td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 " /></td>
            </tr>
            <tr>
              <td class="border p-2">Content/Ideas</td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 " /></td>
            </tr>
            <tr>
              <td class="border p-2">Spelling</td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 " /></td>
            </tr>
          </tbody>
        </table>
  
        <!-- Numeracy Assessment -->
  <h2 class="font-bold text-lg mb-4">Numeracy Assessment</h2>
  <table class="w-full border-collapse mb-6">
    <thead>
      <tr class="bg-gray-200">
        <th class="border p-2 text-left">Level</th>
        <th class="border p-2 text-left">Description</th>
        <th class="border p-2 text-left" rowspan="4">Remarks</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="border p-2">Advance</td>
        <td class="border p-2">
          <ul class="list-disc list-inside">
            <li>He demonstrates advanced ability to view the situation mathematically.</li>
            <li>Approach or representation is effective and is easily followed.</li>
            <li>Reasoning and evidence are clear and well-presented.</li>
            <li>Information is correct and complete.</li>
            <li>Explanation, description, or justification is clear.</li>
            <li>Writing may include details and/or examples.</li>
          </ul>
        </td>
        <td class="border p-2" rowspan="4">
          <input type="text" class="w-full p-1 border border-gray-300 h-full" />
        </td>
      </tr>
      <tr>
        <td class="border p-2">Proficient</td>
        <td class="border p-2">
          <ul class="list-disc list-inside">
            <li>He demonstrates proficient ability to view the situation mathematically.</li>
            <li>Approach or representation is sensible and generally can be followed.</li>
            <li>Reasoning and evidence contain minor inconsistencies.</li>
            <li>Information/explanation is correct.</li>
            <li>Minor computational errors may be present.</li>
            <li>Explanation, description, or justification may lack clarity and details.</li>
          </ul>
        </td>
      </tr>
      <tr>
        <td class="border p-2">Developing</td>
        <td class="border p-2">
          <ul class="list-disc list-inside">
            <li>He demonstrates basic ability to view the situation mathematically.</li>
            <li>Approach or representation is difficult to follow.</li>
            <li>Reasoning and evidence are lacking to some degree.</li>
            <li>Information and/or explanation are incomplete.</li>
            <li>Significant computational errors may occur.</li>
          </ul>
        </td>
      </tr>
      <tr>
        <td class="border p-2">Emerging</td>
        <td class="border p-2">
          <ul class="list-disc list-inside">
            <li>He demonstrates limited ability to view the situation mathematically.</li>
            <li>Approach or representation is ineffective.</li>
            <li>Reasoning and evidence are absent.</li>
            <li>Information is incorrect.</li>
            <li>Explanation, description, or justification is unclear and incorrect.</li>
            <li>No attempt was made.</li>
          </ul>
        </td>
      </tr>
    </tbody>
  </table>
  
  
        <!-- Writing Assessment -->
        <h2 class="font-bold text-lg mb-4">Group-work Assessment</h2>
        <table class="w-full border-collapse mb-6">
          <thead>
            <tr class="bg-gray-200">
              <th class="border p-2 text-left"></th>
              <th class="border p-2 text-left">All The Time</th>
              <th class="border p-2 text-left">Some of the Time</th>
              <th class="border p-2 text-left">Never</th>
              <th class="border p-2 text-left">Remarks</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="border p-2">Participated in group work
              </td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 " /></td>
            </tr>
            <tr>
              <td class="border p-2">Maintained focus on the task at hand</td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 " /></td>
            </tr>
            <tr>
              <td class="border p-2">Offered help to others, or sought help when needed</td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 " /></td>
            </tr>
            <tr>
              <td class="border p-2">Asked questions that moved the discussion along</td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 " /></td>
            </tr>
            <tr>
              <td class="border p-2">Contributed ideas, opinions, and feelings</td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 " /></td>
            </tr>
            <tr>
              <td class="border p-2">Provided positive feedback to other group members</td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 " /></td>
            </tr>
          </tbody>
        </table>
  
        <!-- Recommendation -->
        <div class="mb-6">
          <label for="Recommendation" class="block font-medium">Recommendation/s:</label>
          <textarea id="Recommendation" rows="6" class="block w-full p-2 border border-gray-300"></textarea>
        </div>
  
  <!-- Signatures Section -->
  <div class="mb-6 flex gap-4">
    <!-- Prepared by Signature -->
    <div class="w-1/2">
      <label for="preparedBy" class="block text-sm font-medium">Prepared by:</label>
      <div class="flex items-center">
        <input
          type="text"
          id="preparedBy"
          class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm "
        >
      </div>
      <p class="text-sm mt-2">EMAR Teacher</p>
    </div>
  
    <!-- Noted by Signature -->
    <div class="w-1/2">
      <label for="notedBy" class="block text-sm font-medium">Noted by:</label>
      <div class="flex items-center">
        <input
          type="text"
          id="notedBy"
          value="RALDIE LLOYD D. ADOLFO, LPT"
          readonly
          class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm "
        >
      </div>
      <p class="text-sm mt-2">HP I / Educational Section Head</p>
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
              <img src="/images/footerimg.png" alt="Footer Image" class="h-12 w-24 object-cover ">
            </div>
          </div>
          </div>
      </form>
      
    </div>
  </template>
  
  <script>
  export default {
    name: 'AssessmentForm',
    methods: {
      submitForm() {
        // Handle form submission
      }
    }
  }
  </script>
  
  <style scoped>
  /* Add any custom styling here */
  </style>
  