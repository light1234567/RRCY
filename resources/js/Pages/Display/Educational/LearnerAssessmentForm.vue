<template>

<!-- Tabs for Actions -->
<div v-if="isEditable" class="flex absolute p-4 space-x-4">
    <button @click="cancelEdit" class="flex space-x-2 px-3 py-3 bg-[conic-gradient(at_bottom_right,_var(--tw-gradient-stops))] from-blue-700 via-blue-800 to-gray-900 text-white rounded-md text-xs">
        <!-- FontAwesome for Back -->
        <i class="fas fa-arrow-left w-4 h-4"></i>
        <span>Back</span>
    </button>
</div>

<div class="flex justify-end -mr-9 bg-transparent border border-gray-300 p-4 space-x-4 -mt-9">
    <!-- Pagination Component -->
    <Pagination 
      :totalPages="totalPages" 
      :currentPage="currentPage" 
      @update:currentPage="currentPage = $event" 
    />

    <button v-if="!editMode" @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
        <!-- FontAwesome for Edit -->
        <i class="fas fa-edit w-4 h-4"></i>
        <span>Edit</span>
      </button>
    <button v-if="isEditable" type="submit" @click="submitForm" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
        <!-- FontAwesome for Save -->
        <i class="fas fa-check w-4 h-4"></i>
        <span>Save</span>
    </button>

    <!-- Download PDF Button -->
    <button @click="exportToPdf" class="flex items-center mr-8 space-x-2 px-3 py-1 bg-red-500 text-white rounded-md text-xs">
        <!-- FontAwesome for PDF Download -->
        <i class="fas fa-file-pdf w-4 h-4"></i>
        <span>Export PDF</span>
    </button>
</div>

<div class="graph-background pt-0.5 -ml-4 -mr-9 -mb-16">

  <div class="max-w-3xl p-12 bg-white shadow-xl mx-auto my-8 border border-gray-400">
    <!-- Buttons for Edit and Save -->


    <!-- Success/Error Message -->
    <div v-if="message" :class="messageClass" class="p-4 mb-4 rounded">
      {{ message }}
    </div>

    <!-- Header Section with Logo and Document Details -->
    <div class="relative flex justify-between items-center mb-4">
      <img src="/images/headerlogo2.png" alt="Logo" class="h-24 w-48">
      <div class="text-right flex flex-col justify-center">
        <p class="text-sm font-semibold flex justify-center">PROTECTIVE SERVICES DIVISION</p>
        <p class="text-sm font-semibold flex justify-center">Regional Rehabilitation Center for Youth</p>
        <p class="text-sm font-semibold flex justify-center">Youth/RFO XI</p>
        <p class="text-xs flex justify-center">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
      </div>
    </div>

    <form @submit.prevent="submitForm">
      <!-- Learner's Information -->
      <h1 class="font-bold text-xl mb-4 flex justify-center">LEARNER’S ASSESSMENT FORM</h1>
      
      <div class="flex flex-wrap justify-center gap-4 mb-4">
          <label for="schoolYear" class="block font-medium ">School Year:</label>
          <input type="text" id="schoolYear" class="block w-1/4 p-2 border border-gray-300" v-model="form.school_year" :readonly="!isEditable" />
        </div>
        
        <div class="flex flex-wrap justify-center gap-4 mb-4">
          <label for="gradingPeriod" class="block font-medium">Grading Period:</label>
          <input type="text" id="gradingPeriod" class="block w-1/4 p-2 border border-gray-300" v-model="form.grading_period" :readonly="!isEditable" />
        </div>

      <div class="flex gap-4 mb-4">
        
        
        <div>
          <label for="name" class="block font-medium">Name:</label>
          <input type="text" id="name" class="block w-60% p-2 border border-gray-300" v-model="form.learner_name" readonly />
        </div>
        <div>
          <label for="grade" class="block font-medium">Grade:</label>
          <input type="text" id="grade" class="block w-20% p-2 border border-gray-300" v-model="form.grade" :readonly="!isEditable" />
        </div>
        <div>
  <label for="date" class="block font-medium">Date:</label>
  <input type="date" id="date" v-model="form.date" class="block w-20% p-2 border border-gray-300" :readonly="!isEditable" />
</div>

      </div>

      <!-- Reading Assessment -->
      <h2 class="font-bold text-lg mb-4">Reading Assessment</h2>
      <table class="w-full border-collapse mb-6">
        <thead>
          <tr class="bg-gray-200">
            <th class="border p-2 text-left"></th>
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
            <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" v-model="form.assessments.reading.pronunciation_remarks" :readonly="!isEditable" /></td>
          </tr>
          <tr>
            <td class="border p-2">Fluency of Reading</td>
            <td class="border p-2">Struggles to read.</td>
            <td class="border p-2">Reads word for word</td>
            <td class="border p-2">Words are grouped together logically</td>
            <td class="border p-2">Reading is easy and fluent</td>
            <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" v-model="form.assessments.reading.fluency_remarks" :readonly="!isEditable" /></td>
          </tr>
          <tr>
            <td class="border p-2">Use of Punctuation</td>
            <td class="border p-2">Punctuation marks are ignored.</td>
            <td class="border p-2">Punctuation marks replaced with a breath</td>
            <td class="border p-2">Punctuation is observed, but tends to stop at the end of a line.</td>
            <td class="border p-2">Punctuation is used correctly and efficiently</td>
            <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" v-model="form.assessments.reading.punctuation_remarks" :readonly="!isEditable" /></td>
          </tr>
        </tbody>
      </table>

      <!-- Reading Remarks -->
      <h2 class="font-bold text-lg mb-4"></h2>
      <table class="w-full border-collapse mb-6">
        <thead>
          <tr class="bg-gray-200">
            <th class="border p-2 text-left"></th>
            <th class="border p-2 text-left"></th>
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
              <input type="text" class="w-full p-1 border border-gray-300 h-full" v-model="form.assessments.reading.advance_remarks" :readonly="!isEditable" />
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
      <th class="border p-2 text-left"></th>
      <th class="border p-2 text-left">Excellent</th>
      <th class="border p-2 text-left">Good</th>
      <th class="border p-2 text-left">Fair</th>
      <th class="border p-2 text-left">Needs Improvement</th>
      <th class="border p-2 text-left">Remarks</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="border p-2">Punctuation:He uses accurate punctuation</td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.punctuation[0]" @change="selectOnlyOne('punctuation', 0)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.punctuation[1]" @change="selectOnlyOne('punctuation', 1)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.punctuation[2]" @change="selectOnlyOne('punctuation', 2)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.punctuation[3]" @change="selectOnlyOne('punctuation', 3)" /></td>
      <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" v-model="form.assessments.writing.punctuation_remarks" :readonly="!isEditable" /></td>
    </tr>
    <tr>
      <td class="border p-2">Capitalization: He uses capital letters to begin sentences and for names</td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.capitalization[0]" @change="selectOnlyOne('capitalization', 0)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.capitalization[1]" @change="selectOnlyOne('capitalization', 1)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.capitalization[2]" @change="selectOnlyOne('capitalization', 2)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.capitalization[3]" @change="selectOnlyOne('capitalization', 3)" /></td>
      <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" v-model="form.assessments.writing.capitalization_remarks" :readonly="!isEditable" /></td>
    </tr>
    <tr>
      <td class="border p-2">Grammar: He uses subject/verb agreement and writes complete sentences that make sense.</td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.grammar[0]" @change="selectOnlyOne('grammar', 0)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.grammar[1]" @change="selectOnlyOne('grammar', 1)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.grammar[2]" @change="selectOnlyOne('grammar', 2)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.grammar[3]" @change="selectOnlyOne('grammar', 3)" /></td>
      <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" v-model="form.assessments.writing.grammar_remarks" :readonly="!isEditable" /></td>
    </tr>
    <tr>
      <td class="border p-2">Content/Ideas: He writes on topic and adds details</td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.content_ideas[0]" @change="selectOnlyOne('content_ideas', 0)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.content_ideas[1]" @change="selectOnlyOne('content_ideas', 1)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.content_ideas[2]" @change="selectOnlyOne('content_ideas', 2)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.content_ideas[3]" @change="selectOnlyOne('content_ideas', 3)" /></td>
      <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" v-model="form.assessments.writing.content_ideas_remarks" :readonly="!isEditable" /></td>
    </tr>
    <tr>
      <td class="border p-2">Spelling: He writes most sight words correctly and applies spelling rules</td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.spelling[0]" @change="selectOnlyOne('spelling', 0)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.spelling[1]" @change="selectOnlyOne('spelling', 1)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.spelling[2]" @change="selectOnlyOne('spelling', 2)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.spelling[3]" @change="selectOnlyOne('spelling', 3)" /></td>
      <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" v-model="form.assessments.writing.spelling_remarks" :readonly="!isEditable" /></td>
    </tr>
  </tbody>
</table>


      <!-- Numeracy Assessment -->
      <h2 class="font-bold text-lg mb-4">Numeracy Assessment</h2>
      <table class="w-full border-collapse mb-6">
        <thead>
          <tr class="bg-gray-200">
            <th class="border p-2 text-left"></th>
            <th class="border p-2 text-left"></th>
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
              <input type="text" class="w-full p-1 border border-gray-300 h-full" v-model="form.assessments.numeracy.advance_remarks" :readonly="!isEditable" />
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

      <!-- Group-work Assessment -->
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
      <td class="border p-2">Participated in group work</td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.participation[0]" @change="selectOnlyOne('participation', 0)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.participation[1]" @change="selectOnlyOne('participation', 1)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.participation[2]" @change="selectOnlyOne('participation', 2)" /></td>
      <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" v-model="form.assessments.group_work.participation_remarks" :readonly="!isEditable" /></td>
    </tr>
    <tr>
      <td class="border p-2">Maintained focus on the task at hand</td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.focus[0]" @change="selectOnlyOne('focus', 0)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.focus[1]" @change="selectOnlyOne('focus', 1)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.focus[2]" @change="selectOnlyOne('focus', 2)" /></td>
      <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" v-model="form.assessments.group_work.focus_remarks" :readonly="!isEditable" /></td>
    </tr>
    <tr>
      <td class="border p-2">Offered help to others, or sought help when needed</td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.help[0]" @change="selectOnlyOne('help', 0)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.help[1]" @change="selectOnlyOne('help', 1)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.help[2]" @change="selectOnlyOne('help', 2)" /></td>
      <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" v-model="form.assessments.group_work.help_remarks" :readonly="!isEditable" /></td>
    </tr>
    <tr>
      <td class="border p-2">Asked questions that moved the discussion along</td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.questions[0]" @change="selectOnlyOne('questions', 0)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.questions[1]" @change="selectOnlyOne('questions', 1)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.questions[2]" @change="selectOnlyOne('questions', 2)" /></td>
      <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" v-model="form.assessments.group_work.questions_remarks" :readonly="!isEditable" /></td>
    </tr>
    <tr>
      <td class="border p-2">Contributed ideas, opinions, and feelings</td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.ideas[0]" @change="selectOnlyOne('ideas', 0)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.ideas[1]" @change="selectOnlyOne('ideas', 1)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.ideas[2]" @change="selectOnlyOne('ideas', 2)" /></td>
      <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" v-model="form.assessments.group_work.ideas_remarks" :readonly="!isEditable" /></td>
    </tr>
    <tr>
      <td class="border p-2">Provided positive feedback to other group members</td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.feedback[0]" @change="selectOnlyOne('feedback', 0)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.feedback[1]" @change="selectOnlyOne('feedback', 1)" /></td>
      <td class="border p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.feedback[2]" @change="selectOnlyOne('feedback', 2)" /></td>
      <td class="border p-2"><input type="text" class="w-full p-1 border border-gray-300" v-model="form.assessments.group_work.feedback_remarks" :readonly="!isEditable" /></td>
    </tr>
  </tbody>
</table>


      <!-- Recommendation -->
      <div class="mb-6">
        <label for="Recommendation" class="block font-medium">Recommendation/s:</label>
        <textarea id="Recommendation" rows="6" class="block w-full p-2 border border-gray-300" v-model="form.recommendations" :readonly="!isEditable"></textarea>
      </div>

      <!-- Signatures Section -->
      
        <!-- Prepared by Signature -->
        <div class="flex-wrap justify-start w-1/2 gap-4 mt-4">
          <label for="preparedBy" class="block text-sm font-medium">Prepared by:</label>
          <div class="flex items-center">
            <input type="text" id="preparedBy" class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm" v-model="form.prepared_by" :readonly="!isEditable">
          </div>
          <p class="text-sm mt-2">EMAR Teacher</p>
        </div>

        <!-- Noted by Signature -->
        <div class="flex-wrap justify-end w-1/2 gap-4 mt-4">
          <label for="notedBy" class=" block text-sm font-medium">Noted by:</label>
          <div class="flex items-center">
            <input type="text" id="preparedBy" class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm" v-model="form.noted_by" :readonly="!isEditable">
          </div>
          <p class="text-sm mt-2 justify-center">HP I / Educational Section Head</p>
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
            <img src="/images/footerimg.png" alt="Footer Image" class="h-12 w-24 object-cover">
          </div>
        </div>
      </div>
    </form>
  </div>
  </div>
</template>

<script>
import axios from 'axios';
import { jsPDF } from 'jspdf';
import 'jspdf-autotable';
import '../../../fonts/arial-normal.js'; 
import '../../../fonts/times-normal.js'; 
import '../../../fonts/arialbd-bold.js'; 
import Pagination from '@/Components/Pagination.vue';

export default {
  name: 'AssessmentForm',
  components:{
    Pagination
  },
  data() {
    return {
      totalPages: 1,
      currentPage: 1,
      isEditable: false, // State to toggle edit mode
      message: '', // State to hold the success/error message
      messageClass: '', // Class to style the message (success/error)
      form: {
        client_id: null,  // Store the client ID
        school_year: '',
        grading_period: '',
        learner_name: '', // Field to store the client name
        grade: '',
        date: '',
        recommendations: '',
        prepared_by: '',
        noted_by: '',
        assessments: {
          reading: {
            pronunciation_remarks: '',
            fluency_remarks: '',
            punctuation_remarks: '',
            advance_remarks: '',
          },
          writing: {
            punctuation: [false, false, false, false], // [Excellent, Good, Fair, Needs Improvement]
            punctuation_remarks: '',
            capitalization: [false, false, false, false],
            capitalization_remarks: '',
            grammar: [false, false, false, false],
            grammar_remarks: '',
            content_ideas: [false, false, false, false],
            content_ideas_remarks: '',
            spelling: [false, false, false, false],
            spelling_remarks: '',
          },
          numeracy: {
            advance_remarks: '',
          },
          group_work: {
            participation: [false, false, false], // [All The Time, Some of the Time, Never]
            participation_remarks: '',
            focus: [false, false, false],
            focus_remarks: '',
            help: [false, false, false],
            help_remarks: '',
            questions: [false, false, false],
            questions_remarks: '',
            ideas: [false, false, false],
            ideas_remarks: '',
            feedback: [false, false, false],
            feedback_remarks: '',
          },
        }
      }
    };
  },
  mounted() {
    this.form.client_id = this.$route.params.id;  // Get client ID from route params
    if (this.form.client_id) {
      console.log('Client ID:', this.form.client_id);  // Log to check client_id
      this.fetchData();  // Fetch client data if client ID is available
    }
  },
  methods: {
    toggleEdit() {
      this.isEditable = !this.isEditable;
      if (!this.isEditable) {
        this.message = '';
      }
    },
    selectOnlyOne(aspect, index) {
        // Reset all checkboxes for the given aspect
        this.form.assessments.writing[aspect] = [false, false, false, false];
        // Set the selected checkbox to true
        this.form.assessments.writing[aspect][index] = true;
        // Reset all checkboxes for the given aspect
        this.form.assessments.group_work[aspect] = [false, false, false];
        // Set the selected checkbox to true
        this.form.assessments.group_work[aspect][index] = true;
    },
    submitForm() {
    axios.post('/api/learner-assessment-forms', this.form)
        .then(response => {
            this.message = response.data.message;
            this.messageClass = 'bg-green-100 text-green-800';
            console.log('Form saved successfully:', response.data);
            this.isEditable = false;
        })
        .catch(error => {
            this.message = 'An error occurred while saving the form.';
            this.messageClass = 'bg-red-100 text-red-800';
            console.error('Error saving form:', error.response ? error.response.data : error.message);
        });
}
,
fetchData() {
    // Fetch client information first
    console.log('Attempting to fetch client data for client_id:', this.form.client_id);
    
    axios.get(`/api/clients/${this.form.client_id}`)
        .then(response => {
            console.log('Client data fetched successfully:', response.data);
            const client = response.data;

            // Check if client data is received correctly
            if (client && client.first_name && client.last_name) {
                // Set the learner's name using client data
                this.form.learner_name = `${client.first_name} ${client.last_name}`;
                console.log('Learner name loaded:', this.form.learner_name);
            } else {
                console.warn('Client data is incomplete or not formatted as expected:', client);
                this.message = 'Client data is incomplete.';
                this.messageClass = 'bg-yellow-100 text-yellow-800';
            }

            // After successfully fetching client information, fetch the form data
            this.fetchFormData();
        })
        .catch(error => {
            this.message = 'An error occurred while fetching client data.';
            this.messageClass = 'bg-red-100 text-red-800';
            console.error('Error fetching client data:', error.response ? error.response.data : error.message);
        });
},

fetchFormData() {
    console.log('Attempting to fetch form data for client_id:', this.form.client_id);

    // Fetch the form data based on the client ID
    axios.get(`/api/learner-assessment-forms/${this.form.client_id}`)
        .then(response => {
            console.log('Form data fetched successfully:', response.data);

            // Check if formData exists and update form
            const formData = response.data;
            if (formData && Object.keys(formData).length > 0) {
                this.form = {
                    ...this.form,
                    ...formData, // Merge top-level form fields
                    assessments: {
                        ...this.form.assessments,
                        reading: {
                            ...this.form.assessments.reading,
                            ...(formData.reading_assessments || {}) // Use empty object as fallback
                        },
                        writing: {
                            ...this.form.assessments.writing,
                            ...(formData.writing_assessments || {})
                        },
                        numeracy: {
                            ...this.form.assessments.numeracy,
                            ...(formData.numeracy_assessments || {})
                        },
                        group_work: {
                            ...this.form.assessments.group_work,
                            ...(formData.group_work_assessments || {})
                        }
                    }
                };
                console.log('Form updated with fetched data:', this.form);
                this.message = ''; // Clear any previous messages
                this.messageClass = ''; // Clear any previous message classes
            } else {
                // Set the message if formData is not found or empty
                this.message = 'Form not found or data is empty.';
                this.messageClass = 'bg-yellow-100 text-yellow-800';
                console.warn('No form data found:', response.data);
            }
        })
        .catch(error => {
            // Error handling for network or server issues
            this.message = 'An error occurred while fetching the form data.';
            this.messageClass = 'bg-red-100 text-red-800';
            console.error('Error fetching form data:', error.response ? error.response.data : error.message);
        });
},
exportToPdf() {
  const pdf = new jsPDF('p', 'mm', 'a4'); // Create a new PDF document
  const pageHeight = 297; // A4 page height in mm
  const marginBottom = 30; // Space for footer
  const marginTop = 20;
  const footerHeight = 20; // Space for footer
  const lineHeight = 10; // Height for each line
  let currentY = 40; // Start Y position for content
  let currentPage = 1; // Track current page

  const addHeader = () => {
    pdf.setFontSize(10);
    pdf.setFont('Arial', 'bold');
    pdf.text('PROTECTIVE SERVICES DIVISION', 160, 20, { align: 'center' });
    pdf.text('REGIONAL REHABILITATION CENTER FOR YOUTH', 160, 25, { align: 'center' });
    pdf.text('Youth/RFO XI', 160, 30, { align: 'center' });
    pdf.setFontSize(8);
    pdf.setFont('Times', 'italic');
    pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 135, 35);
  };

  const addFooter = () => {
    pdf.setFontSize(8);
    pdf.setFont('Times', 'normal');
    pdf.text('DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Prk. 7 Bago-Oshiro, Tugbok Dist., Davao City', 105, pageHeight - marginBottom + 10, { align: 'center' });
    pdf.text('Email: rrcy.fo11@dswd.gov.ph    Tel. No.: 293-0306', 105, pageHeight - marginBottom + 15, { align: 'center' });
  };

  const addPage = () => {
    if (currentY+80 >= (pageHeight - marginBottom - footerHeight)) {
      addFooter(); // Add footer before new page
      pdf.addPage(); // Create new page
      currentY = 40; // Reset Y position for new page
      currentPage++;
    }
  };

  // Add header to the first page
  addHeader();

  // DSWD logo
  const imgData = '/images/headerlogo2.png';
  pdf.addImage(imgData, 'PNG', 10, 5, 70, 40); // Adjust the width and height

  // Add main title
  pdf.setFont('Arial', 'bold');
  pdf.setFontSize(14);
  pdf.text('LEARNER’S ASSESSMENT FORM', 105, 50, { align: 'center' });
  pdf.setFont('Arial', 'normal');

  // Learner's Information
  pdf.setFontSize(11);
  pdf.text(`School Year: ${this.form.school_year}`, 105, 55, "center"); 
  pdf.text(`Grading Period: ${this.form.grading_period}`, 105, 60, "center"); 
  pdf.text(`Learner's Name: ${this.form.learner_name}`, 20, 70); 
  pdf.text(`Grade: ${this.form.grade}`, 100, 70); 
  pdf.text(`Date: ${this.form.date}`, 150, 70); ;

  // Reading Assessment Table
  pdf.setFont('Arial', 'bold');
  pdf.text('Reading Assessment', 20, 75); ;
  pdf.setFont('Arial', 'normal');
  currentY= 80;

  addPage();
  // Reading Assessment Table
  pdf.autoTable({
    head: [['', '1', '2', '3', '4', 'Remarks']],
    body: [
      [
        'Pronunciation of Words',
        'The learner struggles to pronounce the words.',
        'Some words are pronounced correctly',
        'Most words are pronounced correctly',
        'All words are pronounced correctly',
        this.form.assessments.reading.pronunciation_remarks || ''
      ],
      [
        'Fluency of Reading',
        'Struggles to read.',
        'Reads word for word',
        'Words are grouped together logically',
        'Reading is easy and fluent',
        this.form.assessments.reading.fluency_remarks || ''
      ],
      [
        'Use of Punctuation',
        'Punctuation marks are ignored.',
        'Punctuation marks replaced with a breath',
        'Punctuation is observed, but tends to stop at the end of a line.',
        'Punctuation is used correctly and efficiently',
        this.form.assessments.reading.punctuation_remarks || ''
      ]
    ],
    startY: currentY,
    theme: 'grid',
    styles: { fontSize: 10, fillColor: [255, 255, 255], textColor: 0 }, // Set background color to white and text color to black
    headStyles: { fillColor: [192, 192, 192], textColor: 0 }, // Set header background to light gray and text color to black
    columnStyles: { 0: { cellWidth: 50 } } // Adjust as needed
  });

  // Update currentY after the table
  currentY = 20;
  currentY += pdf.autoTable.previous.finalY ;
  addPage();


  // After the Reading Assessment Table


// Setup autoTable for the new table
pdf.autoTable({
    head: [['','', 'Remarks']], // Header for the new table
    body: [
        ['Advance', 'He can identify details from the text. He can give insightful evidence to support his conclusions and to make inferences. He can interpret unfamiliar words based on context. He demonstrates a sophisticated understanding of the concepts and competencies relevant to the expected learning.', this.form.assessments.reading.advance_remarks],
        ['Proficient', 'He can identify the main and details about the text. He can give evidence from the text to support conclusions. His ability to make inferences is limited as he can understand familiar words, but he has trouble interpreting new words. He demonstrates a complete understanding of the concepts and competencies relevant to the expected learning.', this.form.assessments.reading.advance_remarks],
        ['Developing', 'He can identify the main idea and a few details about the text. He struggles to provide evidence and make inferences. He can understand familiar words when they are used in familiar contexts. He demonstrates a partial understanding of the concepts and competencies relevant to the expected learning.', this.form.assessments.reading.advance_remarks],
        ['Emerging', 'His ability to interpret individual words significantly limits his understanding of the text. He can identify the main idea of the text, but he cannot give details or textual evidence to support conclusions about the text. He demonstrates an initial understanding of the concepts and competencies relevant to the expected learning.', this.form.assessments.reading.advance_remarks],
        ['Beginning', 'He cannot understand the words in the text well enough to be able to identify the main idea or any details about the text.', this.form.assessments.reading.advance_remarks], 
    ],
    startY: currentY, // Use the updated currentY for vertical positioning
    theme: 'grid', // Maintain the grid theme
    styles: { fontSize: 10, fillColor: [255, 255, 255], textColor: 0 }, // White background, black text
    headStyles: { fillColor: [192, 192, 192], textColor: 0 }, // Light gray header background
});
  currentY= 20;
  currentY += pdf.autoTable.previous.finalY ;
  addPage();

  // Writing Assessment Table
  pdf.setFont('Arial', 'bold');
  pdf.text('Writing Assessment', 20, currentY); currentY += lineHeight;
  pdf.setFont('Arial', 'normal');

  pdf.autoTable({
    head: [['', 'Excellent', 'Good', 'Fair', 'Needs Improvement', 'Remarks']],
    body: [
      ['Punctuation: He uses accurate punctuation', '', '', '', '', this.form.assessments.writing.punctuation_remarks || ''],
      ['Capitalization: He uses capital letters to begin sentences and for names', '', '', '', '', this.form.assessments.writing.capitalization_remarks || ''],
      ['Grammar: He uses subject/verb agreement and writes complete sentences that make sense.', '', '', '', '', this.form.assessments.writing.grammar_remarks || ''],
      ['Content/Ideas: He writes on topic and adds details', '', '', '', '', this.form.assessments.writing.content_ideas_remarks || ''],
      ['Spelling: He writes most sight words correctly and applies spelling rules', '', '', '', '', this.form.assessments.writing.spelling_remarks || ''],
    ],
    startY: currentY,
    theme: 'grid',
    styles: { fontSize: 10, fillColor: [255, 255, 255], textColor: 0 }, // Set background color to white and text color to black
    headStyles: { fillColor: [192, 192, 192], textColor: 0 }, // Set header background to light gray and text color to black
  });

  // Update currentY after the table
  currentY=20;
  currentY += pdf.autoTable.previous.finalY;
  addPage();

  // Numeracy Assessment Table
  pdf.setFont('Arial', 'bold');
  pdf.text('Numeracy Assessment', 20, currentY); currentY += lineHeight;
  pdf.setFont('Arial', 'normal');

  pdf.autoTable({
    head: [['', 'Remarks']],
    body: [
      ['Advance', this.form.assessments.numeracy.advance_remarks || ''],
      ['Proficient', ''],
      ['Developing', ''],
      ['Emerging', '']
    ],
    startY: currentY,
    theme: 'grid',
    styles: { fontSize: 10, fillColor: [255, 255, 255], textColor: 0 }, // Set background color to white and text color to black
    headStyles: { fillColor: [192, 192, 192], textColor: 0 }, // Set header background to light gray and text color to black
  });

  // Update currentY after the table
  currentY= 20;
  currentY += pdf.autoTable.previous.finalY;
  addPage();

  // Group-work Assessment Table
  pdf.setFont('Arial', 'bold');
  pdf.text('Group-work Assessment', 20, currentY); currentY += lineHeight;
  pdf.setFont('Arial', 'normal');

  pdf.autoTable({
    head: [['', 'All The Time', 'Some of the Time', 'Never', 'Remarks']],
    body: [
      ['Participated in group work', '', '', '', this.form.assessments.group_work.participation_remarks || ''],
      ['Maintained focus on the task at hand', '', '', '', this.form.assessments.group_work.focus_remarks || ''],
      ['Offered help to others, or sought help when needed', '', '', '', this.form.assessments.group_work.help_remarks || ''],
      ['Asked questions that moved the discussion along', '', '', '', this.form.assessments.group_work.questions_remarks || ''],
      ['Contributed ideas, opinions, and feelings', '', '', '', this.form.assessments.group_work.ideas_remarks || ''],
      ['Provided positive feedback to other group members', '', '', '', this.form.assessments.group_work.feedback_remarks || ''],
    ],
    startY: currentY,
    theme: 'grid',
    styles: { fontSize: 10, fillColor: [255, 255, 255], textColor: 0 }, // Set background color to white and text color to black
    headStyles: { fillColor: [192, 192, 192], textColor: 0 }, // Set header background to light gray and text color to black
  });

  // Update currentY after the table
  currentY= 5;
  currentY += pdf.autoTable.previous.finalY + 10;
  addPage();

  // Recommendation Section
  pdf.setFont('Arial', 'bold');
  pdf.text('Recommendation/s:', 20, currentY); currentY += lineHeight;
  pdf.setFont('Arial', 'normal');
  pdf.text(this.form.recommendations || '', 20, currentY, { maxWidth: 170 }); // Add recommendation text
  currentY += lineHeight * 3; // Add some space for the recommendation section
  addPage();

  // Signatures Section
  pdf.setFont('Arial', 'bold');
  pdf.text('Prepared by:', 20, currentY); currentY += lineHeight;
  pdf.line(20, currentY+1, 45, currentY+1);
  pdf.setFont('Arial', 'normal');
  
  pdf.text(this.form.prepared_by || '', 20, currentY); currentY += lineHeight;
  pdf.text('EMAR Teacher:', 20, currentY-5); currentY += lineHeight;
  
  pdf.text('Noted by:', 140, currentY); currentY += lineHeight;
  pdf.line(140, currentY+1, 185, currentY+1);
  
  pdf.text(this.form.noted_by || '', 140, currentY);
  pdf.text('HP I / Educational Section Head', 140, currentY+5); currentY += lineHeight;

  // Add footer to the last page
  

  // Page number handling
  const totalPages = pdf.internal.getNumberOfPages();
  for (let i = 1; i <= totalPages; i++) {
    pdf.setPage(i);
    pdf.setFontSize(9);
    pdf.setFont('Times', 'bold');
    pdf.text(`PAGE ${i} of ${totalPages}`, 105, pageHeight - marginBottom + 5, { align: 'center' });
    addFooter();
    marginBottom;
  }

  // Save the PDF with a dynamic file name
  const fileName = `Learner_AssessmentForm_${this.form.learner_name || 'Unknown'}.pdf`;
  pdf.save(fileName);
}





  }
}
</script>


<style scoped>
.graph-background {
    background-image: linear-gradient(to right, #cccccc 1px, transparent 1px), 
                      linear-gradient(to bottom, #cccccc 1px, transparent 1px);
    background-size: 15px 15px; /* Adjust size as per your need */
  }
  </style>