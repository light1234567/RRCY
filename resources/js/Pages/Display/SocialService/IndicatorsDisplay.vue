<template>
    <div class="bg-gray-100 p-10">
      <!-- Page 1 -->
      <div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg mb-10">
        <div class="flex items-center justify-between mb-4">
          <img src="path_to_logo.png" alt="DSWD Logo" class="h-16">
          <div class="text-right">
            <p class="text-xs">DSPTD-QF-01-A | REV 01 | 12 SEP 2023</p>
          </div>
        </div>
        <h1 class="text-2xl font-bold text-center mb-4">INDICATORS OF SOCIAL FUNCTIONING</h1>
        
        <div class="mb-4">
          <label class="block text-gray-700">Name:</label>
          <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.name">
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">Date Admission:</label>
          <input type="date" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.dateAdmission">
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">Date Administered:</label>
          <input type="date" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.dateAdministered">
        </div>
        
        <table class="min-w-full bg-white">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b border-gray-200">AREAS</th>
              <th class="py-2 px-4 border-b border-gray-200">Severely-Impaired Functioning</th>
              <th class="py-2 px-4 border-b border-gray-200">Moderately-Impaired Functioning</th>
              <th class="py-2 px-4 border-b border-gray-200">Normal Functioning</th>
              <th class="py-2 px-4 border-b border-gray-200">Raw Score</th>
              <th class="py-2 px-4 border-b border-gray-200">Score per Area</th>
            </tr>
          </thead>
          <tbody>
            <!-- Physical rows here -->
            <!-- Emotional rows here -->
            <!-- Social / Behavioral rows here -->
            <!-- Spiritual rows here -->
          </tbody>
        </table>
  
        <div class="text-center text-xs mt-10">
          <p>PAGE 1 of 4</p>
          <p>DSWD Field Office XI, RRCY Purok 7, Bajao Gisho, Tugatok District, Davao City, Philippines 8000</p>
          <p>Website: <a href="https://www.dswd.gov.ph" class="text-blue-500">www.dswd.gov.ph</a>, Tel No.: (082) 227-1964 Email: <a href="mailto:rcydavao@gmail.com" class="text-blue-500">rcydavao@gmail.com</a></p>
        </div>
      </div>
  
      <!-- Page 2 -->
      <div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg mb-10">
        <table class="min-w-full bg-white">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b border-gray-200">AREAS</th>
              <th class="py-2 px-4 border-b border-gray-200">Severely-Impaired Functioning</th>
              <th class="py-2 px-4 border-b border-gray-200">Moderately-Impaired Functioning</th>
              <th class="py-2 px-4 border-b border-gray-200">Normal Functioning</th>
              <th class="py-2 px-4 border-b border-gray-200">Raw Score</th>
              <th class="py-2 px-4 border-b border-gray-200">Score per Area</th>
            </tr>
          </thead>
          <tbody>
            <!-- Social / Behavioral rows here -->
          </tbody>
        </table>
  
        <div class="text-center text-xs mt-10">
          <p>PAGE 2 of 4</p>
          <p>DSWD Field Office XI, RRCY Purok 7, Bajao Gisho, Tugatok District, Davao City, Philippines 8000</p>
          <p>Website: <a href="https://www.dswd.gov.ph" class="text-blue-500">www.dswd.gov.ph</a>, Tel No.: (082) 227-1964 Email: <a href="mailto:rcydavao@gmail.com" class="text-blue-500">rcydavao@gmail.com</a></p>
        </div>
      </div>
      
      <!-- Page 3 -->
      <div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg mb-10">
        <table class="min-w-full bg-white">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b border-gray-200">AREAS</th>
              <th class="py-2 px-4 border-b border-gray-200">Severely-Impaired Functioning</th>
              <th class="py-2 px-4 border-b border-gray-200">Moderately-Impaired Functioning</th>
              <th class="py-2 px-4 border-b border-gray-200">Normal Functioning</th>
              <th class="py-2 px-4 border-b border-gray-200">Raw Score</th>
              <th class="py-2 px-4 border-b border-gray-200">Score per Area</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="py-2 px-4 border-b border-gray-200" rowspan="6">Spiritual</td>
              <td class="py-2 px-4 border-b border-gray-200">Has low self-confidence which causes him or her to find meaning only in negative thoughts; always makes self-deprecating comments and statements which devalue his/her own worth</td>
              <td class="py-2 px-4 border-b border-gray-200">Sometimes tends to be overly critical of self but manages to overcome feelings of inadequacy and finds meaning in life through other positive activities</td>
              <td class="py-2 px-4 border-b border-gray-200">Recognizes and accepts his/her limitations but strives to improve self and find meaning in life through positive self-affirmation and involvement in community/ religious activities</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.spiritual.rawScore1">
              </td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.spiritual.scorePerArea1">
              </td>
            </tr>
            <tr>
              <td class="py-2 px-4 border-b border-gray-200">Has the tendency to engage in risky behaviors (e.g., drugs, alcohol, unsafe sex) because of a lack of moral grounding and/or due to peer pressure</td>
              <td class="py-2 px-4 border-b border-gray-200">Is aware of the risks involved in risky behaviors but sometimes gives in to peer pressure or has difficulty managing impulses</td>
              <td class="py-2 px-4 border-b border-gray-200">Does not engage in risky behaviors and maintains a strong moral grounding and manages impulses well</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.spiritual.rawScore2">
              </td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.spiritual.scorePerArea2">
              </td>
            </tr>
            <tr>
              <td class="py-2 px-4 border-b border-gray-200">Has difficulty finding and maintaining a personal relationship with a higher power which results in a lack of a sense of purpose</td>
              <td class="py-2 px-4 border-b border-gray-200">Sometimes has difficulty finding and maintaining a personal relationship with a higher power but continues to strive for spiritual growth</td>
              <td class="py-2 px-4 border-b border-gray-200">Has a strong and consistent personal relationship with a higher power and finds a sense of purpose in life</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.spiritual.rawScore3">
              </td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.spiritual.scorePerArea3">
              </td>
            </tr>
            <!-- Add additional rows as necessary -->
          </tbody>
        </table>
  
        <div class="text-center text-xs mt-10">
          <p>PAGE 3 of 4</p>
          <p>DSWD Field Office XI, RRCY Purok 7, Bajao Gisho, Tugatok District, Davao City, Philippines 8000</p>
          <p>Website: <a href="https://www.dswd.gov.ph" class="text-blue-500">www.dswd.gov.ph</a>, Tel No.: (082) 227-1964 Email: <a href="mailto:rcydavao@gmail.com" class="text-blue-500">rcydavao@gmail.com</a></p>
        </div>
      </div>
  
      <!-- Page 4 -->
      <div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <table class="min-w-full bg-white">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b border-gray-200">AREAS</th>
              <th class="py-2 px-4 border-b border-gray-200">Severely-Impaired Functioning</th>
              <th class="py-2 px-4 border-b border-gray-200">Moderately-Impaired Functioning</th>
              <th class="py-2 px-4 border-b border-gray-200">Normal Functioning</th>
              <th class="py-2 px-4 border-b border-gray-200">Raw Score</th>
              <th class="py-2 px-4 border-b border-gray-200">Score per Area</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="py-2 px-4 border-b border-gray-200">Educational / Literacy</td>
              <td class="py-2 px-4 border-b border-gray-200">Not able to read, write and count</td>
              <td class="py-2 px-4 border-b border-gray-200">Undertakes non-formal education or willingly receives tutorial services to learn basic skills</td>
              <td class="py-2 px-4 border-b border-gray-200">Able to read, write and count with skills appropriate to age and educational attainment</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.educational.rawScore">
              </td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.educational.scorePerArea">
              </td>
            </tr>
            <tr>
              <td class="py-2 px-4 border-b border-gray-200">Economic Productivity</td>
              <td class="py-2 px-4 border-b border-gray-200">No employable skills and has no interest in learning any skills that would help him/her support his/her needs</td>
              <td class="py-2 px-4 border-b border-gray-200">Needs to brush up skills to make them usable for employment</td>
              <td class="py-2 px-4 border-b border-gray-200">Has employable skills</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.economic.rawScore">
              </td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.economic.scorePerArea">
              </td>
            </tr>
          </tbody>
        </table>
  
        <div class="mt-6">
          <label class="block text-gray-700">General Score:</label>
          <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.generalScore">
        </div>
        <div class="mt-6">
          <label class="block text-gray-700">Interpretation:</label>
          <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.interpretation">
        </div>
  
        <div class="flex justify-between mt-10">
          <div>
            <label class="block text-gray-700">Prepared by:</label>
            <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.preparedBy">
          </div>
          <div>
            <label class="block text-gray-700">Discussed with:</label>
            <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.discussedWith">
          </div>
        </div>
  
        <div class="text-center text-xs mt-10">
          <p>PAGE 4 of 4</p>
          <p>DSWD PROTECTIVE SERVICES DIVISION, FIELD OFFICE XI, REGIONAL REHABILITATION CENTER FOR YOUTH</p>
        </div>
      </div>
  
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        form: {
          name: '',
          dateAdmission: '',
          dateAdministered: '',
          physical: {
            rawScore1: '',
            scorePerArea1: '',
            rawScore2: '',
            scorePerArea2: '',
            rawScore3: '',
            scorePerArea3: '',
            rawScore4: '',
            scorePerArea4: '',
            rawScore5: '',
            scorePerArea5: '',
          },
          emotional: {
            rawScore1: '',
            scorePerArea1: '',
            rawScore2: '',
            scorePerArea2: '',
            rawScore3: '',
            scorePerArea3: '',
            rawScore4: '',
            scorePerArea4: '',
            rawScore5: '',
            scorePerArea5: '',
          },
          social: {
            rawScore1: '',
            scorePerArea1: '',
            rawScore2: '',
            scorePerArea2: '',
            rawScore3: '',
            scorePerArea3: '',
            rawScore4: '',
            scorePerArea4: '',
            rawScore5: '',
            scorePerArea5: '',
          },
          spiritual: {
            rawScore1: '',
            scorePerArea1: '',
            rawScore2: '',
            scorePerArea2: '',
            rawScore3: '',
            scorePerArea3: '',
            rawScore4: '',
            scorePerArea4: '',
            rawScore5: '',
            scorePerArea5: '',
          },
          educational: {
            rawScore: '',
            scorePerArea: '',
          },
          economic: {
            rawScore: '',
            scorePerArea: '',
          },
          generalScore: '',
          interpretation: '',
          preparedBy: '',
          discussedWith: ''
        }
      }
    }
  }
  </script>
  
  <style scoped>
  /* Add any custom styles here if needed */
  </style>