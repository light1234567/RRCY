<template>
  <div class="p-6 border border-gray-300 rounded-md bg-white max-w-4xl mx-auto">
    <form @submit.prevent="submitForm">
      <!-- Learner's Information -->
      <div class="border border-gray-300 p-6 rounded-md bg-white mb-6">
        <h1 class="font-bold text-xl mb-4">LEARNER’S ASSESSMENT FORM</h1>
        <div class="grid grid-cols-3 gap-4 mb-4">
          <div>
            <label for="schoolYear" class="block font-medium">School Year:</label>
            <input type="text" id="schoolYear" class="block w-full p-2 border border-gray-300 rounded-md" />
          </div>
          <div>
            <label for="gradingPeriod" class="block font-medium">Grading Period:</label>
            <input type="text" id="gradingPeriod" class="block w-full p-2 border border-gray-300 rounded-md" />
          </div>
          <div>
            <label for="name" class="block font-medium">Name:</label>
            <input type="text" id="name" class="block w-full p-2 border border-gray-300 rounded-md" />
          </div>
          <div>
            <label for="grade" class="block font-medium">Grade:</label>
            <input type="text" id="grade" class="block w-full p-2 border border-gray-300 rounded-md" />
          </div>
          <div>
            <label for="date" class="block font-medium">Date:</label>
            <input type="text" id="date" class="block w-full p-2 border border-gray-300 rounded-md" />
          </div>
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
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 rounded-md" /></td>
            </tr>
            <tr>
              <td class="border p-2">Fluency of Reading</td>
              <td class="border p-2">Struggles to read.</td>
              <td class="border p-2">Read word for word</td>
              <td class="border p-2">Words are grouped together logically</td>
              <td class="border p-2">Reading is easy and fluent</td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 rounded-md" /></td>
            </tr>
            <tr>
              <td class="border p-2">Use of Punctuation</td>
              <td class="border p-2">Punctuation marks are ignored.</td>
              <td class="border p-2">Punctuation marks replaced with a breath</td>
              <td class="border p-2">Punctuation is observed, but tends to stop at the end of a line.</td>
              <td class="border p-2">Punctuation is used correctly and efficiently</td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 rounded-md" /></td>
            </tr>
          </tbody>
        </table>

        
        
       <!-- Reading Remarks -->
       <table class="w-full border-collapse">
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
        <input type="text" class="w-full p-1 border border-gray-300 rounded-md h-full" />
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
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 rounded-md" /></td>
            </tr>
            <tr>
              <td class="border p-2">Capitalization</td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 rounded-md" /></td>
            </tr>
            <tr>
              <td class="border p-2">Grammar</td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 rounded-md" /></td>
            </tr>
            <tr>
              <td class="border p-2">Spelling</td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="checkbox" class="form-checkbox" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 rounded-md" /></td>
            </tr>
          </tbody>
        </table>

      <!-- Numeracy Assessment -->
    
        <h2 class="font-bold text-lg mb-4">Numeracy Assessment</h2>
        <table class="w-full border-collapse mb-6">
          <thead>
            <tr class="bg-gray-200">
              <th class="border p-2 text-left">Aspect</th>
              <th class="border p-2 text-left">Advance</th>
              <th class="border p-2 text-left">Proficient</th>
              <th class="border p-2 text-left">Developing</th>
              <th class="border p-2 text-left">Emerging</th>
              <th class="border p-2 text-left">Remarks</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="border p-2">Numeracy Skills</td>
              <td class="border p-2">
                He demonstrates advanced ability to view the situation mathematically. Approach or representation is effective and is easily followed. Reasoning and evidence is clear and well presented. Information is correct and complete. Explanation, description, or justification is clear. Writing may include details and/or examples.
              </td>
              <td class="border p-2">
                He demonstrates proficient ability to view the situation mathematically. Approach representation is sensible and is generally can be followed. Reasoning and evidence contains minor inconsistencies. Information / explanation is correct. Minor computational errors may be present. Explanation, description, or justification may lack clarity and details.
              </td>
              <td class="border p-2">
                He demonstrates basic ability to view the situation mathematically. Approach or representation is difficult to follow. Reasoning and evidence is lacking to some degree. Information and/or explanation are incomplete. Significant computational errors may occur.
              </td>
              <td class="border p-2">
                He demonstrates limited ability to view the situation mathematically. Approach or representation is ineffective. Reasoning and evidence is absent. Information is incorrect. Explanation, description, or justification is unclear and incorrect.
              </td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 rounded-md" /></td>
            </tr>
          </tbody>
        </table>
    

      <!-- Group-work Assessment -->
      
        <h2 class="font-bold text-lg mb-4">Group-work Assessment</h2>
        <table class="w-full border-collapse mb-6">
          <thead>
            <tr class="bg-gray-200">
              <th class="border p-2 text-left">Aspect</th>
              <th class="border p-2 text-left">All the time</th>
              <th class="border p-2 text-left">Some of the time</th>
              <th class="border p-2 text-left">Never</th>
              <th class="border p-2 text-left">Remarks</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="border p-2">Participated in group work</td>
              <td class="border p-2"><input type="radio" name="groupWork1" class="form-radio" /></td>
              <td class="border p-2"><input type="radio" name="groupWork1" class="form-radio" /></td>
              <td class="border p-2"><input type="radio" name="groupWork1" class="form-radio" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 rounded-md" /></td>
            </tr>
            <tr>
              <td class="border p-2">Maintained focus on the task at hand</td>
              <td class="border p-2"><input type="radio" name="groupWork2" class="form-radio" /></td>
              <td class="border p-2"><input type="radio" name="groupWork2" class="form-radio" /></td>
              <td class="border p-2"><input type="radio" name="groupWork2" class="form-radio" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 rounded-md" /></td>
            </tr>
            <tr>
              <td class="border p-2">Offered help to others, or sought help when needed</td>
              <td class="border p-2"><input type="radio" name="groupWork3" class="form-radio" /></td>
              <td class="border p-2"><input type="radio" name="groupWork3" class="form-radio" /></td>
              <td class="border p-2"><input type="radio" name="groupWork3" class="form-radio" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 rounded-md" /></td>
            </tr>
            <tr>
              <td class="border p-2">Asked questions that moved the discussion along</td>
              <td class="border p-2"><input type="radio" name="groupWork4" class="form-radio" /></td>
              <td class="border p-2"><input type="radio" name="groupWork4" class="form-radio" /></td>
              <td class="border p-2"><input type="radio" name="groupWork4" class="form-radio" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 rounded-md" /></td>
            </tr>
            <tr>
              <td class="border p-2">Contributed ideas, opinions, and feelings</td>
              <td class="border p-2"><input type="radio" name="groupWork5" class="form-radio" /></td>
              <td class="border p-2"><input type="radio" name="groupWork5" class="form-radio" /></td>
              <td class="border p-2"><input type="radio" name="groupWork5" class="form-radio" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 rounded-md" /></td>
            </tr>
            <tr>
              <td class="border p-2">Provided positive feedback to other group members</td>
              <td class="border p-2"><input type="radio" name="groupWork6" class="form-radio" /></td>
              <td class="border p-2"><input type="radio" name="groupWork6" class="form-radio" /></td>
              <td class="border p-2"><input type="radio" name="groupWork6" class="form-radio" /></td>
              <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300 rounded-md" /></td>
            </tr>
          </tbody>
        </table>
      

      <!-- Recommendation -->
    
        <h2 class="font-bold text-lg mb-4">Recommendation/s:</h2>
        <textarea class="w-full p-2 border border-gray-300 rounded-md" rows="4"></textarea>
      

      <!-- Signatures Section -->
      <div class="space-y-4 mt-6">
            <div class="space-y-2">
              <label for="preparedBy" class="block font-medium">Prepared by:</label>
              <input type="text" id="preparedBy" value="BRYAN V. GALANG MPsy, RPsy" readonly class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200">
              <p class="text-sm">EMAR Teacher</p>
            </div>
            <div class="space-y-2">
              <label for="notedBy" class="block font-medium">Noted by:</label>
              <input type="text" id="notedBy" value="RALDIE LLOYD D. ADOLFO, LPT" readonly class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200">
              <p class="text-sm">HP I /Educational Section Head</p>
            </div>
          </div>

      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Submit</button>
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
