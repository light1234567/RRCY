<template>
  <!-- Buttons for Edit and Save -->
  <div class="flex justify-end gap-4">
      <button type="button" @click="isEditable = !isEditable" class="bg-blue-500 text-white px-4 py-2 rounded">
        {{ isEditable ? 'Cancel' : 'Edit' }}
      </button>
      <button v-if="isEditable" type="submit" @click="submitForm" class="bg-green-500 text-white px-4 py-2 rounded">Save</button>
      <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 text-white rounded-md text-xs">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      <span>Export to PDF</span>
    </button>
    </div>

    <!-- Success/Error Message -->
    <div v-if="message" :class="messageClass" class="p-4 mb-4 rounded">
      {{ message }}
    </div>

  <div class="max-w-3xl p-8 bg-white shadow-xl mx-auto my-8 border border-gray-200">
    
    <!-- Header Section with Logo and Document Details -->
    <div class="relative flex justify-between items-center mb-4">
      <img src="/images/headerlogo2.png" alt="Logo" class="h-24 w-48">
      <div class="text-right flex flex-col justify-center">
        <p class="text-sm font-semibold text-center">PROTECTIVE SERVICES DIVISION</p>
        <p class="text-sm font-semibold text-center">Regional Rehabilitation Center for Youth</p>
        <p class="text-sm font-semibold text-center">Youth/RFO XI</p>
        <p class="text-xs text-center">DSWD-GF-007 | REV 03 / 22 SEP 2023</p>
      </div>
    </div>

    <form @submit.prevent="submitForm">
      <!-- Learner's Information -->
      <h1 class="font-bold text-lg mb-4 ml-56">LEARNER’S ASSESSMENT FORM</h1>
      <div class="ml-56 -mt-4">
      <label for="schoolYear" class="w-full block font-medium">School Year:
      <input type="text" id="schoolYear" class="underline-input w-48 p-1 border bg-transparent border-gray-300 mx-auto text-sm" v-model="form.school_year" :readonly="!isEditable" />
    </label>
  </div>
      <div class="ml-72 mt-1">
    <label for="gradingPeriod" class="block font-medium">
          <input type="text" id="gradingPeriod" class="underline-input mt-4 w-24 p-1 border-none bg-transparent mx-auto text-sm" v-model="form.grading_period" :readonly="!isEditable" />
          Grading Period
        </label>
        </div>
        <br />
        <div class="grid grid-cols-3 gap-4 mb-4 text-sm">
  <!-- Name Input -->
  <div class="flex items-center">
    <label for="name" class="block font-medium mr-2">Name:</label>
    <input type="text" id="name" class="underline-input border-none focus:outline-none w-full p-0" v-model="form.learner_name" readonly />
  </div>

  <!-- Grade Input -->
  <div class="flex items-center ml-20">
    <label for="grade" class="block font-medium mr-2">Grade:</label>
    <input type="text" id="grade" class="underline-input border-none focus:outline-none w-14 p-0" v-model="form.grade" :readonly="!isEditable" />
  </div>

  <!-- Date Input -->
  <div class="flex items-center">
    <label for="date" class="block font-medium mr-2">Date:</label>
    <input type="date" id="date" class="underline-input border-none focus:outline-none w-full p-0" v-model="form.date" :readonly="!isEditable" />
  </div>


      </div>

      <!-- Reading Assessment -->
<h2 class="text-lg mb-4">Reading Assessment</h2>
<table class="w-full border-collapse mb-6">
  <thead>
    <tr class="bg-transparent">
      <th class="border border-black p-2 text-left"></th>
      <th class="border border-black p-2 text-left">1</th>
      <th class="border border-black p-2 text-left">2</th>
      <th class="border border-black p-2 text-left">3</th>
      <th class="border border-black p-2 text-left">4</th>
      <th class="border border-black p-2 text-left"></th>
      <th class="border border-black p-2 text-left">Remarks</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="border border-black p-2">Pronunciation of Words</td>
      <td class="border border-black p-2">The learner struggles to pronounce the words.</td>
      <td class="border border-black p-2">Some words are pronounced correctly</td>
      <td class="border border-black p-2">Most words are pronounced correctly</td>
      <td class="border border-black p-2">All words are pronounced correctly</td>
      <td class="border border-black w-10 p-2">
        <input type="number" class="text" v-model.number="form.assessments.reading.pronunciation" :disabled="!isEditable" style="width: 2ch; padding: 0.2em;" min="0" max="4"/>      </td>
      <td class="border border-black p-2" rowspan="3">
        <textarea class="w-full p-1 border border-black" v-model="form.assessments.reading.pronunciation_remarks" :readonly="!isEditable" rows="6"></textarea>
      </td>
    </tr>
    <tr>
      <td class="border border-black p-2">Fluency of Reading</td>
      <td class="border border-black p-2">Struggles to read.</td>
      <td class="border border-black p-2">Reads word for word</td>
      <td class="border border-black p-2">Words are grouped together logically</td>
      <td class="border border-black p-2">Reading is easy and fluent</td>
      <td class="border border-black w-10 p-2">
        <input type="number" class="text" v-model.number="form.assessments.reading.fluency" :disabled="!isEditable" style="width: 2ch; padding: 0.2em;" min="0" max="4"/>      </td>
    </tr>
    <tr>
      <td class="border border-black p-2">Use of Punctuation</td>
      <td class="border border-black p-2">Punctuation marks are ignored.</td>
      <td class="border border-black p-2">Punctuation marks replaced with a breath</td>
      <td class="border border-black p-2">Punctuation is observed, but tends to stop at the end of a line.</td>
      <td class="border border-black p-2">Punctuation is used correctly and efficiently</td>
      <td class="border border-black w-10 p-2">
        <input type="number" class="text" v-model.number="form.assessments.reading.punctuation" :disabled="!isEditable" style="width: 2ch; padding: 0.2em;" min="0" max="4"/>      </td>
    </tr>
  </tbody>
</table>

      <!-- Reading Remarks -->
      <table class="w-full border-collapse mb-6">
        <thead>
          <tr class="bg-transparent">
            <th class="border border-black p-2 text-left"></th>
            <th class="border border-black p-2 text-left"></th>
            <th class="border border-black p-2 text-left" rowspan="5">Remarks</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border border-black p-2">Advance</td>
            <td class="border border-black p-2">
              He can identify details from the text. He can give insightful evidence to support his conclusions and to make inferences. He can interpret unfamiliar words based on context.<br />
              He demonstrates a sophisticated understanding of the concepts and competencies relevant to the expected learning.
            </td>
            <td class="border border-black p-2" rowspan="5">
              <textarea class="w-full p-1 border border-black" v-model="form.assessments.reading.advance_remarks" :readonly="!isEditable" rows="6"></textarea>
            </td>
          </tr>
          <tr>
            <td class="border border-black p-2">Proficient</td>
            <td class="border border-black p-2">
              He can identify the main and details about the text. He can give evidence from the text to support conclusions. His ability to make inferences is limited as he can understand familiar words, but he has trouble interpreting new words.<br />
              He demonstrates a complete understanding of the concepts and competencies relevant to the expected learning.
            </td>
          </tr>
          <tr>
            <td class="border border-black p-2">Developing</td>
            <td class="border border-black p-2">
              He can identify the main idea and a few details about the text. He struggles to provide evidence and make inferences. He can understand familiar words when they are used in familiar contexts.<br />
              He demonstrates a partial understanding of the concepts and competencies relevant to the expected learning.
            </td>
          </tr>
          <tr>
            <td class="border border-black p-2">Emerging</td>
            <td class="border border-black p-2">
              His ability to interpret individual words significantly limits his understanding of the text. He can identify the main idea of the text, but he cannot give details or textual evidence to support conclusions about the text.<br />
              He demonstrates an initial understanding of the concepts and competencies relevant to the expected learning.
            </td>
          </tr>
          <tr>
            <td class="border border-black p-2">Beginning</td>
            <td class="border border-black p-2">
              He cannot understand the words in the text well enough to be able to identify the main idea or any details about the text.
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Writing Assessment -->
<h2 class=" text-lg mb-4">Writing Assessment</h2>
<table class="w-full border-collapse mb-6">
  <thead>
    <tr class="bg-transparent">
      <th class="border border-black p-2 text-left"></th>
      <th class="border border-black p-2 text-left">Excellent</th>
      <th class="border border-black p-2 text-left">Good</th>
      <th class="border border-black p-2 text-left">Fair</th>
      <th class="border border-black p-2 text-left">Needs Improvement</th>
      <th class="border border-black p-2 text-left">Remarks</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="border border-black p-2">Punctuation</td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.punctuation[0]" @change="selectOnlyOne('punctuation', 0)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.punctuation[1]" @change="selectOnlyOne('punctuation', 1)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.punctuation[2]" @change="selectOnlyOne('punctuation', 2)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.punctuation[3]" @change="selectOnlyOne('punctuation', 3)" /></td>
      <td class="border border-black p-2" rowspan="5">
        <textarea class="w-full p-1 border border-black" v-model="form.assessments.writing.punctuation_remarks" :readonly="!isEditable" rows="5"></textarea>
      </td>   </tr>
    <tr>
      <td class="border border-black p-2">Capitalization</td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.capitalization[0]" @change="selectOnlyOne('capitalization', 0)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.capitalization[1]" @change="selectOnlyOne('capitalization', 1)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.capitalization[2]" @change="selectOnlyOne('capitalization', 2)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.capitalization[3]" @change="selectOnlyOne('capitalization', 3)" /></td>
      </tr>
    <tr>
      <td class="border border-black p-2">Grammar</td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.grammar[0]" @change="selectOnlyOne('grammar', 0)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.grammar[1]" @change="selectOnlyOne('grammar', 1)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.grammar[2]" @change="selectOnlyOne('grammar', 2)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.grammar[3]" @change="selectOnlyOne('grammar', 3)" /></td>
     </tr>
    <tr>
      <td class="border border-black p-2">Content/Ideas</td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.content_ideas[0]" @change="selectOnlyOne('content_ideas', 0)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.content_ideas[1]" @change="selectOnlyOne('content_ideas', 1)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.content_ideas[2]" @change="selectOnlyOne('content_ideas', 2)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.content_ideas[3]" @change="selectOnlyOne('content_ideas', 3)" /></td>
      </tr>
    <tr>
      <td class="border border-black p-2">Spelling</td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.spelling[0]" @change="selectOnlyOne('spelling', 0)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.spelling[1]" @change="selectOnlyOne('spelling', 1)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.spelling[2]" @change="selectOnlyOne('spelling', 2)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.writing.spelling[3]" @change="selectOnlyOne('spelling', 3)" /></td>
     </tr>
  </tbody>
</table>


      <!-- Numeracy Assessment -->
      <h2 class=" text-lg mb-4">Numeracy Assessment</h2>
      <table class="w-full border-collapse mb-6">
        <thead>
          <tr class="bg-transparent">
            <th class="border border-black p-2 text-left"></th>
            <th class="border border-black p-2 text-left"></th>
            <th class="border border-black p-2 text-left" rowspan="4">Remarks</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border border-black  p-2">Advance</td>
            <td class="border border-black p-2">
              <ul class="list-disc list-inside">
                <li>He demonstrates advanced ability to view the situation mathematically.</li>
                <li>Approach or representation is effective and is easily followed.</li>
                <li>Reasoning and evidence are clear and well-presented.</li>
                <li>Information is correct and complete.</li>
                <li>Explanation, description, or justification is clear.</li>
                <li>Writing may include details and/or examples.</li>
              </ul>
            </td>
            <td class="border border-black p-2" rowspan="4">
        <textarea class="w-full p-1 border border-black" v-model="form.assessments.numeracy.advance_remarks" :readonly="!isEditable" rows="6"></textarea>
      </td>
          </tr>
          <tr>
            <td class="border border-black p-2">Proficient</td>
            <td class="border border-black p-2">
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
            <td class="border border-black p-2">Developing</td>
            <td class="border border-black p-2">
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
            <td class="border border-black p-2">Emerging</td>
            <td class="border border-black p-2">
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
<h2 class=" text-lg mb-4">Group-work Assessment</h2>
<table class="w-full border-collapse mb-6">
  <thead>
    <tr class="bg-transparent">
      <th class="border border-black p-2 text-left"></th>
      <th class="border border-black p-2 text-left">All The Time</th>
      <th class="border border-black p-2 text-left">Some of the Time</th>
      <th class="border border-black p-2 text-left">Never</th>
      <th class="border border-black p-2 text-left">Remarks</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="border border-black p-2">Participated in group work</td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.participation[0]" @change="selectOnlyOne('participation', 0)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.participation[1]" @change="selectOnlyOne('participation', 1)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.participation[2]" @change="selectOnlyOne('participation', 2)" /></td>
      <td class="border border-black p-2" rowspan="6">
        <textarea class="w-full p-1 border border-black" v-model="form.assessments.group_work.participation_remarks" :readonly="!isEditable" rows="6"></textarea>
      </td>   </tr>
    <tr>
      <td class="border border-black p-2">Maintained focus on the task at hand</td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.focus[0]" @change="selectOnlyOne('focus', 0)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.focus[1]" @change="selectOnlyOne('focus', 1)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.focus[2]" @change="selectOnlyOne('focus', 2)" /></td>
     </tr>
    <tr>
      <td class="border border-black p-2">Offered help to others, or sought help when needed</td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.help[0]" @change="selectOnlyOne('help', 0)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.help[1]" @change="selectOnlyOne('help', 1)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.help[2]" @change="selectOnlyOne('help', 2)" /></td>
      </tr>
    <tr>
      <td class="border border-black p-2">Asked questions that moved the discussion along</td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.questions[0]" @change="selectOnlyOne('questions', 0)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.questions[1]" @change="selectOnlyOne('questions', 1)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.questions[2]" @change="selectOnlyOne('questions', 2)" /></td>
      </tr>
    <tr>
      <td class="border border-black p-2">Contributed ideas, opinions, and feelings</td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.ideas[0]" @change="selectOnlyOne('ideas', 0)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.ideas[1]" @change="selectOnlyOne('ideas', 1)" /></td>
      <td class="border border-black  p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.ideas[2]" @change="selectOnlyOne('ideas', 2)" /></td>
      </tr>
    <tr>
      <td class="border border-black p-2">Provided positive feedback to other group members</td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.feedback[0]" @change="selectOnlyOne('feedback', 0)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.feedback[1]" @change="selectOnlyOne('feedback', 1)" /></td>
      <td class="border border-black p-2"><input type="checkbox" class="form-checkbox" :disabled="!isEditable" v-model="form.assessments.group_work.feedback[2]" @change="selectOnlyOne('feedback', 2)" /></td>
      </tr>
  </tbody>
</table>


      <!-- Recommendation -->
      <div class="mb-6">
        <label for="Recommendation" class="block font-medium">Recommendation/s:</label>
        <textarea id="Recommendation" rows="6" class="block w-full p-2 border border-gray-300" v-model="form.recommendations" :readonly="!isEditable"></textarea>
      </div>

      <!-- Signatures Section -->
      <div class="mb-6 flex gap-4">
        <!-- Prepared by Signature -->
        <div class="w-1/2">
          <label for="preparedBy" class="block text-sm font-medium">Prepared by:</label>
          <div class="flex items-center">
            <input type="text" id="preparedBy" class="mt-1 w-3/4 underline-input" v-model="form.prepared_by" :readonly="!isEditable">
          </div>
          <p class="text-sm mt-2">EMAR Teacher</p>
        </div>

        <!-- Noted by Signature -->
        <div class="w-1/2">
          <label for="notedBy" class="block text-sm font-medium">Noted by:</label>
          <div class="flex items-center">
            <input type="text" id="preparedBy" value="RALDIE LLOYD D. ADOLFO, LPT" class="text-sm font-bold mt-1 w-3/4 underline-input" v-model="form.noted_by" :readonly="!isEditable">
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
            <p>Email: <span class="text-blue-600 underline">rrcy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
          </div>
          <div>
            <img src="/images/footerimg.png" alt="Footer Image" class="h-12 w-24 object-cover">
          </div>
        </div>
      </div>
    </form>
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
            pronunciation: null,
            pronunciation_remarks: '',
            fluency: null,
            punctuation: null,
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
  watch: {
    '$route.params.id': function (newId) {
      this.form.client_id = newId;
      this.fetchData();
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
                console.warn('No form data found:', response.data);
            }
        })
        .catch(error => {
            console.error('Error fetching form data:', error.response ? error.response.data : error.message);
        });
},
exportToPdf() {
  const pdf = new jsPDF('p', 'mm', [216, 356]); // Legal size: 216mm x 356mm
  const pageHeight = 356; // A4 page height in mm
  const marginBottom = 10; // Space for footer
  const marginTop = 20;
  const footerHeight = 10; // Space for footer
  const lineHeight = 7; // Height for each line
  let contentYPos = 0; // Start Y position for content
  let currentPage = 1; // Track current page
 const maxContentHeight = pageHeight - marginBottom; // Max height for content before adding a new page
 const maxWidth = 165; // Maximum width for text
 let initialX = 20; // X position for content


  const addHeader = () => {
    pdf.setFontSize(10);
    pdf.setFont('Arial', 'bold');
    pdf.text('PROTECTIVE SERVICES DIVISION', 160, 20, { align: 'center' });
    pdf.text('REGIONAL REHABILITATION CENTER FOR YOUTH', 160, 25, { align: 'center' });
    pdf.text('Youth/RFO XI', 160, 30, { align: 'center' });
    pdf.setFontSize(8);
    pdf.setFont('Times', 'italic');
    pdf.text('DSWD-GF-007 | REV 03 / 22 SEP 2023', 135, 35);
  };

 // Helper function to add a new page if content exceeds the page height
 const addNewPageIfNeeded = () => {
   if (contentYPos >= maxContentHeight) {
     addFooter(); // Add the footer for the current page
     pdf.addPage(); // Add new page // Add the header on the new page
     pdf.setLineWidth(0);
     currentPage++; // Increment page number
     contentYPos = 40; // Reset Y position for the new page
     pdf.setFont('arial', 'normal'); // Reset font to 'arial' and style to 'normal'
     pdf.setFontSize(10); // Set font size back to what it was
   }
 };

  const addFooter = () => {
      if (currentPage === 1) {
        // Footer for Page 1
        pdf.setFontSize(9);
        pdf.setFont('TimesNewRoman', 'bold');
        pdf.setLineWidth(0.5);
        pdf.line(17, 340, 173, 340); // Footer line
  
        pdf.setFont('times', 'normal');
        const footerText = pdf.splitTextToSize('DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Prk. 7 Bago-Oshiro, Tugbok Dist., Davao City', 160);
        pdf.text(footerText, 95, 345, { align: 'center' });
        pdf.text('Email: rrcy.fo11@dswd.gov.ph    Tel. No.: 293-0306', 105, 349, { align: 'center' });
  
        const footerImgData = '/images/footerimg.png';
        pdf.addImage(footerImgData, 'PNG', 175, 334, 25, 12); // Footer image
      } else {
        // Footer for Page 2 and beyond
        pdf.setFontSize(8.5);
        pdf.setFont('TimesNewRoman', 'bold');
  
        pdf.setLineWidth(0.5);
        pdf.line(17, 340, 193, 340); // Footer line extending further
  
        pdf.setFont('times', 'bold');
        pdf.text('DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH', 105, 345, { align: 'center' });
      }
    };

  const addPage = () => {
    if (contentYPos+80 >= (pageHeight - marginBottom - footerHeight)) {
      addFooter(); // Add footer before new page
      pdf.addPage(); // Create new page
      contentYPos = 40; // Reset Y position for new page
      currentPage++;
    }
  };

  // Add header to the first page
  addHeader();

  // DSWD logo
  const imgData = '/images/headerlogo2.png';
  pdf.addImage(imgData, 'PNG', 10, 5, 70, 40); // Adjust the width and height

  // Add main title

  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(14);
  pdf.text('LEARNER’S ASSESSMENT FORM', 105, 45, { align: 'center' });
  pdf.setFont('Arial', 'normal');

  // Learner's Information
  pdf.setFontSize(13);
  pdf.text(`School Year: ${this.form.school_year}`, 105, 55, "center"); 
  pdf.text(`${this.form.grading_period} Grading Period`, 105, 63, "center"); 
  pdf.setFontSize(11);
  pdf.text(`Name: ${this.form.learner_name}`, 20, 70); 
  pdf.text(`Grade: ${this.form.grade}`, 100, 70); 
  pdf.text(`Date: ${this.form.date}`, 150, 70); ;

  contentYPos += 20;
  pdf.setFontSize(13);
  pdf.setFont('arial', 'normal');
  pdf.text('Reading Assessment', 20, 75); ;
  pdf.setFont('Arial', 'normal');
  contentYPos= 80;

  addPage();
  // Reading Assessment Table
  pdf.autoTable({
    body: [
      [
        '', '1', '2', '3', '4','', 'REMARKS'
      ],
      [
        { content: 'Pronunciation of Words', styles: { fontStyle: 'bold' } },
        'The learner struggles to pronounce the words.',
        'Some words are pronounced correctly',
        'Most words are pronounced correctly',
        'All words are pronounced correctly',
        '',
        { content: this.form.assessments.reading.pronunciation_remarks || '', rowSpan: 3 } // Merge Remarks cell across 3 rows
      ],
      [
        { content: 'Fluency of Reading', styles: { fontStyle: 'bold' } },
        'Struggles to read.',
        'Reads word for word',
        'Words are grouped together logically',
        'Reading is easy and fluent',
        '',
        '' // Leave empty since it's merged
      ],
      [
        { content: 'Use of Punctuation', styles: { fontStyle: 'bold' } },
        'Punctuation marks are ignored.',
        'Punctuation marks replaced with a breath',
        'Punctuation is observed, but tends to stop at the end of a line.',
        'Punctuation is used correctly and efficiently',
        '',
        '' // Leave empty since it's merged
      ]
    ],
    startY: contentYPos,
    theme: 'grid',
    styles: { 
        fontSize: 10, 
        fillColor: [255, 255, 255], // White background
        textColor: 0, // Black text
        lineColor: [0, 0, 0], // Black border lines
        tableLineWidth: 0.75 // Slightly thicker border lines
    },
    margin: { top: 5, left: 5, right: 5 },
    columnStyles: { 
        0: { cellWidth: 50, lineColor: [0, 0, 0] },  // Apply black border for the first column
        1: { lineColor: [0, 0, 0] },                 // Apply black border for column '1'
        2: { lineColor: [0, 0, 0] },                 // Apply black border for column '2'
        3: { lineColor: [0, 0, 0] },                 // Apply black border for column '3'
        4: { lineColor: [0, 0, 0] },                 // Apply black border for column '4'
        5: { cellWidth: 10,lineColor: [0, 0, 0] } ,  // Apply black border for 'Remarks' column
        6: { cellWidth: 50, lineColor: [0, 0, 0] }   // Apply black border for 'Remarks' column
    }
});





contentYPos += 70;
// Setup autoTable for the new table
pdf.autoTable({
    head: [], // Header for the new table
    body: [
        ['','', 'Remarks'],
        ['Advance', 'He can identify details from the text. He can give insightful evidence to support his conclusions and to make inferences. He can interpret unfamiliar words based on context. He demonstrates a sophisticated understanding of the concepts and competencies relevant to the expected learning.', { content: this.form.assessments.reading.advance_remarks || '', rowSpan: 5 }],
        ['Proficient', 'He can identify the main and details about the text. He can give evidence from the text to support conclusions. His ability to make inferences is limited as he can understand familiar words, but he has trouble interpreting new words. He demonstrates a complete understanding of the concepts and competencies relevant to the expected learning.'],
        ['Developing', 'He can identify the main idea and a few details about the text. He struggles to provide evidence and make inferences. He can understand familiar words when they are used in familiar contexts. He demonstrates a partial understanding of the concepts and competencies relevant to the expected learning.'],
        ['Emerging', 'His ability to interpret individual words significantly limits his understanding of the text. He can identify the main idea of the text, but he cannot give details or textual evidence to support conclusions about the text. He demonstrates an initial understanding of the concepts and competencies relevant to the expected learning.'],
        ['Beginning', 'He cannot understand the words in the text well enough to be able to identify the main idea or any details about the text.'], 
    ],
    startY: contentYPos+4, // Use the updated currentY for vertical positioning
    theme: 'grid', // Maintain the grid theme
    styles: { 
        fontSize: 10, 
        fillColor: [255, 255, 255], // White background
        textColor: 0, // Black text
        lineColor: [0, 0, 0], // Black border lines
        tableLineWidth: 0.75 // Slightly thicker border lines
    }, 
    margin: { top: 5, left: 5, right: 5 },
    columnStyles: { 
        0: { lineColor: [0, 0, 0] },  // Apply black border for the first column
        1: { lineColor: [0, 0, 0] },                 // Apply black border for column '1'
        2: { cellWidth :50, lineColor: [0, 0, 0] },                 // Apply black border for column '2'

    }
});
contentYPos= 20;
contentYPos += pdf.autoTable.previous.finalY ;
  addPage();

  // Writing Assessment Table
  pdf.setFontSize(13);
  pdf.setFont('Arial', 'normal');
  pdf.text('Writing Assessment', 20, contentYPos); contentYPos += lineHeight;
  pdf.setFont('Arial', 'normal');

  pdf.autoTable({
  head: [], // No headers
  body: [
    ['', 'Excellent', 'Good', 'Fair', 'Needs Improvement', 'Remarks'],
    [
      'Punctuation\nHe uses accurate punctuation',
      this.form.assessments.writing.punctuation[0] ? '/' : '',
      this.form.assessments.writing.punctuation[1] ? '/' : '',
      this.form.assessments.writing.punctuation[2] ? '/' : '',
      this.form.assessments.writing.punctuation[3] ? '/' : '',
      { content: this.form.assessments.writing.punctuation_remarks || '', rowSpan: 5 }
    ],
    [
      'Capitalization\nHe uses capital letters to begin sentences and for names',
      this.form.assessments.writing.capitalization[0] ? '/' : '',
      this.form.assessments.writing.capitalization[1] ? '/' : '',
      this.form.assessments.writing.capitalization[2] ? '/' : '',
      this.form.assessments.writing.capitalization[3] ? '/' : '',
      ''
    ],
    [
      'Grammar\nHe uses subject/verb agreement and writes complete sentences that make sense.',
      this.form.assessments.writing.grammar[0] ? '/' : '',
      this.form.assessments.writing.grammar[1] ? '/' : '',
      this.form.assessments.writing.grammar[2] ? '/' : '',
      this.form.assessments.writing.grammar[3] ? '/' : '',
      ''
    ],
    [
      'Content/Ideas\nHe writes on topic and adds details',
      this.form.assessments.writing.content_ideas[0] ? '/' : '',
      this.form.assessments.writing.content_ideas[1] ? '/' : '',
      this.form.assessments.writing.content_ideas[2] ? '/' : '',
      this.form.assessments.writing.content_ideas[3] ? '/' : '',
      ''
    ],
    [
      'Spelling\nHe writes most sight words correctly and applies spelling rules',
      this.form.assessments.writing.spelling[0] ? '/' : '',
      this.form.assessments.writing.spelling[1] ? '/' : '',
      this.form.assessments.writing.spelling[2] ? '/' : '',
      this.form.assessments.writing.spelling[3] ? '/' : '',
      ''
    ],
  ],
  startY: contentYPos, // Start position for Y coordinate
  theme: 'grid', // Maintain grid theme
  styles: { 
    fontSize: 10, 
    fillColor: [255, 255, 255], // White background
    textColor: 0, // Black text
    lineColor: [0, 0, 0], // Black border lines
    tableLineWidth: 0.75 // Slightly thicker border lines
  },
  headStyles: { 
    fillColor: [192, 192, 192], // Light gray header background
    textColor: 0 // Black text for the header
  },
  margin: { top: 10, left: 5, right: 5 }, // Margins
  columnStyles: { 
    0: { cellWidth: 65, lineColor: [0, 0, 0] }, // Black border for first column
    1: { cellWidth: 20, lineColor: [0, 0, 0] }, // Black border for second column
    2: { cellWidth: 20, lineColor: [0, 0, 0] }, // Black border for third column
    3: { cellWidth: 20, lineColor: [0, 0, 0] }, // Black border for fourth column
    4: { cellWidth: 40, lineColor: [0, 0, 0] }, // Black border for fifth column
    5: { cellWidth: 40, lineColor: [0, 0, 0] } // Black border for "Remarks" column
  }
});



  // Update currentY after the table
  contentYPos=20;
  contentYPos += pdf.autoTable.previous.finalY;
  addPage();

  // Numeracy Assessment Table
  pdf.setFontSize(13);
  pdf.setFont('Arial', 'normal');
  pdf.text('Numeracy Assessment', 20, contentYPos); contentYPos += lineHeight;
  pdf.setFont('Arial', 'normal');

  pdf.autoTable({
    head: [], // Empty head because we define the first row in the body
    body: [
        ['', '', 'Remarks'], // Header row with an empty cell and "Remarks" column

        // Advance row
        ['Advance', 
        '• He demonstrates advanced ability to view the situation mathematically\n• Approach or representation is effective and is easily followed\n• Reasoning and evidence is clear and well presented.\n• Information is correct and complete\n• Explanation, description, or justification is clear.\n• Writing may include details and/or examples', 
        { content: this.form.assessments.numeracy.advance_remarks || '', rowSpan: 4 }],

        // Proficient row
        ['Proficient', 
        '• He demonstrates proficient ability to view the situation mathematically\n• Approach representation is sensible and is generally can be followed\n• Reasoning and evidence contains minor inconsistencies.\n• Information  / explanation is correct\n• Minor computational errors may be present\n• Explanation, description, or justification may lack clarity and details.'],

        // Developing row
        ['Developing', 
        '• He demonstrates basic ability to view the situation mathematically\n• Approach or representation is difficult to follow\n• Reasoning and evidence is lacking to some degree.\n• Information  and/or explanation are incomplete.\n• Significant computational errors may occur.'],

        // Emerging row
        ['Emerging', 
        '• He demonstrates limited ability to view the situation mathematically\n• Approach or representation is ineffective\n• Reasoning and evidence is absent.\n• Information is incorrect.\n• Explanation, description, or justification is unclear and incorrect.\n• No attempt was made'],
    ],
    startY: contentYPos + 4, // Adjust this based on your layout
    theme: 'grid', // Maintain the grid theme
    styles: { 
        fontSize: 10, 
        fillColor: [255, 255, 255], // White background
        textColor: 0, // Black text
        lineColor: [0, 0, 0], // Black border lines
        tableLineWidth: 0.75 // Slightly thicker border lines
    },
    margin: { top: 5, left: 5, right: 5 },
    columnStyles: { 
        0: { cellWidth: 25, lineColor: [0, 0, 0] }, // Adjust first column width
        1: { lineColor: [0, 0, 0] }, // Second column border and dynamic width
        2: { cellWidth: 55, lineColor: [0, 0, 0] }, // Adjust Remarks column width
    }
});


  // Update currentY after the table
  contentYPos= 20;
  contentYPos += pdf.autoTable.previous.finalY;
  addPage();

  pdf.setFontSize(13);
  pdf.setFont('Arial', 'normal');
  pdf.text('Group-work Assessment', 20, contentYPos); contentYPos += lineHeight;
  pdf.setFont('Arial', 'normal');

  pdf.autoTable({
    head: [],
    body: [
      ['', 'All The Time', 'Some of the Time', 'Never', 'Remarks'],
      ['Participated in group work', 
      this.form.assessments.group_work.participation[0] ? '/' : '',
      this.form.assessments.group_work.participation[1] ? '/' : '',
      this.form.assessments.group_work.participation[2] ? '/' : '',
      { content: this.form.assessments.group_work.participation_remarks || '', rowSpan: 6 }],


      ['Maintained focus on the task at hand', 
      this.form.assessments.group_work.focus[0] ? '/' : '',
      this.form.assessments.group_work.focus[1] ? '/' : '',
      this.form.assessments.group_work.focus[2] ? '/' : '',
      ''],
      ['Offered help to others, or sought help when needed', 
      this.form.assessments.group_work.help[0] ? '/' : '',
      this.form.assessments.group_work.help[1] ? '/' : '',
      this.form.assessments.group_work.help[2] ? '/' : '',
      ''],
      ['Asked questions that moved the discussion along', 
      this.form.assessments.group_work.questions[0] ? '/' : '',
      this.form.assessments.group_work.questions[1] ? '/' : '',
      this.form.assessments.group_work.questions[2] ? '/' : '',
      ''],
      ['Contributed ideas, opinions, and feelings', 
      this.form.assessments.group_work.ideas[0] ? '/' : '',
      this.form.assessments.group_work.ideas[1] ? '/' : '',
      this.form.assessments.group_work.ideas[2] ? '/' : '',
      ''],
      ['Provided positive feedback to other group members', 
      this.form.assessments.group_work.feedback[0] ? '/' : '',
      this.form.assessments.group_work.feedback[1] ? '/' : '',
      this.form.assessments.group_work.feedback[2] ? '/' : '',
      ''],
    ],
    startY: contentYPos + 4, // Adjust this based on your layout
    theme: 'grid', // Maintain the grid theme
    styles: { 
        fontSize: 10, 
        fillColor: [255, 255, 255], // White background
        textColor: 0, // Black text
        lineColor: [0, 0, 0], // Black border lines
        tableLineWidth: 0.75 // Slightly thicker border lines
    },
    margin: { top: 5, left: 5, right: 5 },
    columnStyles: { 
        0: { cellWidth: 90, lineColor: [0, 0, 0] }, // Adjust first column width
        1: { cellWidth: 20, lineColor: [0, 0, 0] }, // Second column border and dynamic width
        2: { cellWidth: 20, lineColor: [0, 0, 0] }, // Second column border and dynamic width
        3: { cellWidth: 20, lineColor: [0, 0, 0] }, // Second column border and dynamic width
        4: { cellWidth: 55, lineColor: [0, 0, 0] }, // Second column border and dynamic width
}
});

  // Update currentY after the table
  contentYPos= 5;
  contentYPos += pdf.autoTable.previous.finalY + 10;
  addPage();

  contentYPos +=5;
  pdf.setFontSize(10);
  pdf.text('Recommendation/s', 20, contentYPos);

  // Dynamic text with underline
  contentYPos += 5;
  addNewPageIfNeeded();
  pdf.setLineWidth(0);
  pdf.setFontSize(10);
 const text1 = `${this.form.recommendations || ''}`;
 const wrappedText1 = pdf.splitTextToSize(text1, maxWidth);
 wrappedText1.forEach(line => {
   addNewPageIfNeeded(); // Add a new page if necessary
   pdf.text(line, initialX, contentYPos);
   const textWidth = pdf.getTextWidth(line);
   pdf.line(initialX, contentYPos + 1, initialX + textWidth, contentYPos + 1); // Underline
   contentYPos += lineHeight;
 });


  addPage();

  // Signatures Section
  contentYPos +=10;
  pdf.setFontSize(11);
  pdf.setFont('Arial', 'bold');
  pdf.text('Prepared by:', 20, contentYPos); 
  addNewPageIfNeeded();
  pdf.setLineWidth(0);
  pdf.setFontSize(10);
  pdf.setFont('Arial', 'bold');
  pdf.setFont('Arial', 'normal');
 const text2 = `${this.form.prepared_by || ''}`;
 const wrappedText2 = pdf.splitTextToSize(text2, maxWidth);
 wrappedText2.forEach(line => {
   addNewPageIfNeeded(); // Add a new page if necessary
   pdf.text(line, initialX+23, contentYPos);
   const textWidth = pdf.getTextWidth(line);
   pdf.line(initialX+23, contentYPos + 1, initialX+23 + textWidth, contentYPos + 1); // Underline
   contentYPos += lineHeight;
 });
  pdf.text('EMAR Teacher', 52, contentYPos+-1); 
  
  contentYPos +=20;
  pdf.setFontSize(10);
  pdf.setFont('Arial', 'normal');
  pdf.text('Noted by:',102, contentYPos); 
  pdf.setFontSize(9);
  pdf.setFont('arialbd', 'bold');
  pdf.text('RALDIE LLOYD D. ADOLFO, LPT', initialX+98, contentYPos); 
  pdf.line(118, contentYPos+1, 168, contentYPos+1);
  pdf.text('HP I / Educational Section Head', 118, contentYPos+5);

  addFooter(); 
  
  const totalPages = pdf.internal.getNumberOfPages();
    for (let i = 1; i <= totalPages; i++) {
      pdf.setPage(i);
      pdf.setFontSize(8);
      pdf.setFont('TimesNewRoman', 'bold');
      pdf.text(`PAGE ${i} of ${totalPages}`, 105, 338, { align: 'center' }); // Update the footer with the correct total pages
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
.underline-input {
  border: none;
  border-bottom:  1px solid black;
  padding: 0;
  margin: 0;
  line-height: 1  ;
  vertical-align: bottom; /* Ensures the text aligns with the bottom of the input */
  font-size: inherit; /* Ensure consistent font size */
}
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type="number"] {
  -moz-appearance: textfield; /* Hide the spinner in Firefox */
}
</style>