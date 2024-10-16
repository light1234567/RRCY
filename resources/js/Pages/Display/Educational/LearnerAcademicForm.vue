<template>

  <!-- Tabs for Actions -->
  <div v-if="editMode" class="flex absolute p-4 space-x-4">
      <button @click="cancelEdit" class=" flex space-x-2 px-3 py-3 bg-blue-900 text-white rounded-md text-xs">
          <!-- FontAwesome for Back -->
          <i class="fas fa-arrow-left w-4 h-4"></i>
          <span>Cancel</span>
      </button>
  </div>
  
  <div class="flex justify-end -mr-9  bg-transparent border border-gray-300 p-4 space-x-4 -mt-9">
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
  
      <button v-if="editMode" @click="submitForm" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
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
  <!-- Modal for Save Confirmation -->
<div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50">
     <div class="fixed inset-0 bg-black opacity-50"></div>
     <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
       <div class="bg-white p-6">
         <div class="flex items-center">
           <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.93 5h13.86c1.1 0 1.96-.9 1.84-1.98l-1.18-12.14a2 2 0 00-1.98-1.88H4.27a2 2 0 00-1.98 1.88L1.11 16.02c-.12 1.08.74 1.98 1.84 1.98z"/>
           </svg>
           <h3 class="text-lg leading-6 font-medium text-gray-900">Save changes?</h3>
         </div>
         <div class="mt-2">
           <p class="text-sm text-gray-500">Are you sure you want to save the changes?</p>
         </div>
       </div>
       <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
         <button @click="confirmSave" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Save</button>
         <button @click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
       </div>
     </div>
   </div>

   <!-- Modal for Save Result -->
   <div v-if="isSaveResultModalOpen" class="fixed inset-0 flex items-center justify-center z-50">
     <div class="fixed inset-0 bg-black opacity-50"></div>
     <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
       <div class="bg-white p-6 text-center">
         <div v-if="saveResultTitle === 'Error'" class="flex justify-center items-center mb-4">
           <div class="flex items-center justify-center w-12 h-12 bg-red-100 rounded-full">
             <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
             </svg>
           </div>
         </div>
         <div v-if="saveResultTitle === 'Success'" class="flex justify-center items-center mb-4">
           <div class="flex items-center justify-center w-12 h-12 bg-blue-500 rounded-full">
             <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
             </svg>
           </div>
         </div>
         <h3 class="text-lg leading-6 font-medium text-gray-900">{{ saveResultTitle }}</h3>
         <div class="mt-2">
           <p class="text-sm text-gray-500">{{ saveResultMessage }}</p>
         </div>
       </div>
       <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
         <button @click="closeSaveResultModal" :class="saveResultTitle === 'Error' ? 'bg-red-600 hover:bg-red-500' : 'bg-blue-600 hover:bg-blue-500'" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
           OK
         </button>
       </div>
     </div>
   </div>

      <form ref="LearnerForm" @submit.prevent="submitForm">
  
  <div class="graph-background pt-0.5 -ml-4 -mr-9 -mb-16">
  
    <div class="max-w-3xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
      <!-- Header Section with Logo and Document Details -->
      <div class="relative flex justify-between items-center mb-4">
        <img src="/images/headerlogo2.png" alt="Logo" class="h-24 w-48">
        <div class="text-right">
          <p class="item-center mr-6 text-sm font-semibold">PROTECTIVE SERVICES DIVISION</p>
          <p class="flex justify-center text-sm font-semibold">Regional Rehabilitation Center for Youth</p>
          <p class="flex justify-center text-sm font-semibold">Youth/RFO XI</p>
          <p class="text-xs flex justify-center">DSWD-GF-007 | REV 03 / 22 SEP 2023</p>
        </div>
      </div>
      
        <div class="text-center mb-6">
          <h1 class="font-bold text-xl">LEARNER’S ACADEMIC BEHAVIORAL FORM</h1>
          <div class="flex justify-center gap-2 mt-4">
            <div class="flex items-center">
  <label for="month" class="block font-medium">For the month of : </label>
  <select 
  v-model="form.month" 
  id="month" 
  class="block w-32 border-b-2 border-black border-t-0 border-l-0 border-r-0 text-left focus:outline-none focus:border-black"
  @input="(e) => { e.target.setCustomValidity('') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please select a valid month') }" 
  :disabled="!editMode" 
  required
>
  <option value="" disabled selected>Select month</option>
  <option value="January">January</option>
  <option value="February">February</option>
  <option value="March">March</option>
  <option value="April">April</option>
  <option value="May">May</option>
  <option value="June">June</option>
  <option value="July">July</option>
  <option value="August">August</option>
  <option value="September">September</option>
  <option value="October">October</option>
  <option value="November">November</option>
  <option value="December">December</option>
</select>


</div>

  </div>
  
          <div class="flex justify-center gap-4 mt-4">
  
            <div class="flex justify-center">
              <label for="schoolYear" class="block font-medium">School Year:</label>
<input 
  v-model="form.school_year" 
  type="text" 
  id="schoolYear" 
  class="block w-[9ch] border-b-2 border-black border-t-0 border-l-0 border-r-0 text-center focus:outline-none focus:border-black p-0" 
  style="margin-left: 5px; border-color: transparent; border-bottom-color: black;" 
  @input="(e) => { e.target.setCustomValidity(''); e.target.value = e.target.value.replace(/[^a-zA-Z0-9\s-]/g, '') }" 
  @invalid="(e) => { e.target.setCustomValidity('Please provide the school year') }" 
  :readonly="!editMode"
  required
/>

</div>


            </div>
          </div>
          
  
          <div class="flex flex-wrap justify-start gap-4 mb-6">
              <div class="flex">
                <label for="learnerName" class="block font-medium text-sm">Learner’s Name:</label>
                <input 
                  v-model="form.learner_name" 
                  type="text" 
                  id="learnerName" 
                  class="block w-32 border-b-2 border-black border-t-0 border-l-0 border-r-0 text-center focus:outline-none" 
                  style="margin-right:240px;margin-left: 5px; padding: 0; line-height: 1.2; border-color: transparent; border-bottom-color: black;"
                  readonly 
                />
              </div>
              <div class="flex">
  <label for="grade" class="block font-medium text-sm">Grade:</label>
  <input 
    v-model="form.grade" 
    type="text" 
    id="grade" 
    class="block w-32 border-b-2 border-black border-t-0 border-l-0 border-r-0 text-center focus:outline-none" 
    style="margin-left: 5px; padding: 0; line-height: 1.2; border-color: transparent; border-bottom-color: black;" 
    oninput="this.value = Math.min(100, this.value.replace(/[^0-9]/g, '').slice(0, 3))" 
    :readonly="!editMode" 
  />
</div>

              
<div class="flex">
  <label for="lrn" class="block font-medium text-sm">LRN:</label>
  <input 
    v-model="form.lrn" 
    type="text" 
    id="lrn" 
    class="block w-32 border-b-2 border-black border-t-0 border-l-0 border-r-0 text-center focus:outline-none" 
    style="margin-right:310px; margin-left: 5px; padding: 0; line-height: 1.2; border-color: transparent; border-bottom-color: black;" 
    oninput="this.value = this.value.replace(/[^0-9-]/g, '')"
    :readonly="!editMode"
  />
</div>

    
              <div class="flex">
  <label for="status" class="block font-medium text-sm">Status:</label>
  <input 
    v-model="form.status" 
    type="text" 
    id="status" 
    class="block w-32 border-b-2 border-black border-t-0 border-l-0 border-r-0 text-center focus:outline-none" 
    style="margin-left: 5px; padding: 0; line-height: 1.2; border-color: transparent; border-bottom-color: black;" 
    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" 
    :readonly="!editMode"
  />
</div>

      </div>
  
          <div class="mb-6">
          <table class="w-full border-collapse">
            <thead>
              <tr>
                <th class="border p-2 text-left align-top" style="width: 25%;">Learner Skill</th>
                <th class="border p-2 text-left align-top">
                  <div>Outstanding</div>
                  <div class="text-xs font-light whitespace-normal">
                    *Well performed. Tasks are fully completed, all relevant information provided accurately and adequately where necessary. Relevant tasks well performed; no tasks left incomplete.
                  </div>
                </th>
                <th class="border p-2 text-left align-top">
                  <div>Very Satisfactory</div>
                  <div class="text-xs font-light whitespace-normal">
                    *Generally satisfactory with only minor omissions and inadequacies. Part of it is well attempted but overall, just satisfactory because of some major omissions and the limited coverage of the information.
                  </div>
                </th>
                <th class="border p-2 text-left align-top">
                  <div>Satisfactory</div>
                  <div class="text-xs font-light whitespace-normal">
                    *Revealing significant omission and inadequacies. Very limited coverage performed.
                  </div>
                </th>
                <th class="border p-2 text-left align-top">
                  <div>Fairly Satisfactory</div>
                  <div class="text-xs font-light whitespace-normal">
                    *Very unsatisfactory, important task(s) are poorly done or not attempted to do so.
                  </div>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(skill, index) in form.skills" :key="index">
                <td class="border p-2">{{ skill.skill }}</td>
                <td class="border p-2 text-center">
                  <div class="flex justify-center items-center h-full">
                    <input 
                      type="checkbox" 
                      :disabled="!editMode" 
                      v-model="skill.outstanding" 
                      @change="handleCheckboxChange(index, 'outstanding')"
                      class="form-checkbox"
                    />
                  </div>
                </td>
                <td class="border p-2 text-center">
                  <div class="flex justify-center items-center h-full">
                    <input 
                      type="checkbox" 
                      :disabled="!editMode" 
                      v-model="skill.verySatisfactory" 
                      @change="handleCheckboxChange(index, 'verySatisfactory')"
                      class="form-checkbox"
                    />
                  </div>
                </td>
                <td class="border p-2 text-center">
                  <div class="flex justify-center items-center h-full">
                    <input 
                      type="checkbox" 
                      :disabled="!editMode" 
                      v-model="skill.satisfactory" 
                      @change="handleCheckboxChange(index, 'satisfactory')"
                      class="form-checkbox"
                    />
                  </div>
                </td>
                <td class="border p-2 text-center">
                  <div class="flex justify-center items-center h-full">
                    <input 
                      type="checkbox" 
                      :disabled="!editMode" 
                      v-model="skill.fairlySatisfactory" 
                      @change="handleCheckboxChange(index, 'fairlySatisfactory')"
                      class="form-checkbox"
                    />
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
  
        <div class="mb-6">
          <label for="observationFeedback" class="block font-medium">Observation/Feedback:</label>
          <textarea 
            v-model="form.observation_feedback" 
            id="observationFeedback" 
            rows="6" 
            class="block w-full p-2 border border-gray-300" 
            @input="(e) => { e.target.setCustomValidity('') }" 
            @invalid="(e) => { e.target.setCustomValidity('Please provide your observation feedback') }" 
            :readonly="!editMode"
            required
          ></textarea>

        </div>
  
        <div class="mb-6 flex gap-3 ">
          <div class="w-1/2 mt-5">
            <label for="learnerSignature" class="block text-sm font-medium"></label>
            <div class="flex items-center">
              <input
                v-model="form.learner_name"
                type="text"
                id="learner"
                class="block w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 text-center focus:outline-none" 
                style=" font-size:65%; padding: 0; line-height: 1.2; border-color: transparent; border-bottom-color: black;"
                readonly
              >
            </div>
            <p class="flex justify-center text-xs mt-2 font-bold">Learner</p>
          </div>
  
          <div class="w-1/2 mt-5">
  
            
            <label for="categoryAdviserSignature" class="block text-sm font-medium"></label>
            <div class="flex items-center">
              <input
                v-model="form.category_adviser_signature"
                type="text"
                id="categoryAdviserSignature"
                class="block w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 text-center focus:outline-none" 
                style=" font-size:65%;padding: 0; line-height: 1.2; border-color: transparent; border-bottom-color: black;"
                :readonly="!editMode"
              >
            </div>
            <p class="flex justify-center text-xs mt-2 font-bold">Category Adviser</p>
          </div>
          
          <div class="w-1/2 mt-5">
            <label for="educationalSectionHeadSignature" class="block text-sm font-medium"></label>
            <div class="flex items-center">
              <input
                v-model="form.educational_section_head_signature"
                type="text"
                id="educationalSectionHeadSignature"
                class="block w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 text-center focus:outline-none" 
                style=" font-size:65%; padding: 0; line-height: 1.2; border-color: transparent; border-bottom-color: black;"
                :readonly="!editMode"
              >
            </div>
            <p class="flex justify-center text-xs mt-2 font-bold">Educational Section Head</p>
          </div>
  
          <div class="w-1/2 mt-5">
            <label for="centerHeadSignature" class="block text-sm font-medium"></label>
            <div class="flex items-center">
              <input
                v-model="center_head"
                type="text"
                class="block w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 text-center focus:outline-none" 
                style=" font-size:65%; padding: 0; line-height: 1.2; border-color: transparent; border-bottom-color: black;"
                readonly
              >
            </div>
            <p class="flex justify-center text-xs mt-2 font-bold">Center Head</p>
          </div>
  
  
        </div>
  
        <div class="border-gray-300 ml-6 mt-8 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
          <div class="flex justify-between items-center">
            
            <!-- Left Section: Page number -->
            <div class="flex flex-col flex-grow">
              <!-- Page number centered -->
              <p class="text-center -mb-1 font-bold">PAGE 1 of {{ totalPages }}</p>
  
            <!-- Continuous horizontal line, moved to the left with space on the right -->
            <div style="border-top: 2px solid black; width: 103%; margin-bottom: 4px;margin-top: 4px; margin-left: -24px;"></div>
  
  
              <!-- Text under the line -->
              <p style="text-align: center; font-weight: bold; margin-top: -1px;">LEARNER’S ACADEMIC BEHAVIORAL FORM</p>
              <p class="-ml-6 text-[9px]"style="text-align: center; margin-top: -1px;">DSWD  | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH, DAVAO CITY PHILIPPINES 8000
              </p>
            </div>
        </div>
  </div>
    </div>
    </div>
  </form>
  </template>
  
  <script>
  import axios from 'axios';
  import jsPDF from 'jspdf';
  import Pagination from '@/Components/Pagination.vue';
  export default {
    components: {
      Pagination
    },
    name: 'LearnerBehaviorForm',
    data() {
      return {
        totalPages: 1,
        currentPage: 1,
        form: {
          client_id: null,
          month: '',
          school_year: '',
          learner_name: '',
          grade: '',
          lrn: '',
          status: '',
          skills: [
            { skill: 'HOMEWORK COMPLETION', outstanding: false, verySatisfactory: false, satisfactory: false, fairlySatisfactory: false },
            { skill: 'STUDY SKILLS', outstanding: false, verySatisfactory: false, satisfactory: false, fairlySatisfactory: false },
            { skill: 'ORGANIZATIONAL SKILLS', outstanding: false, verySatisfactory: false, satisfactory: false, fairlySatisfactory: false },
            { skill: 'COOPERATIVE LEARNING SKILLS', outstanding: false, verySatisfactory: false, satisfactory: false, fairlySatisfactory: false },
            { skill: 'INDEPENDENT SEAT WORK', outstanding: false, verySatisfactory: false, satisfactory: false, fairlySatisfactory: false },
            { skill: 'MOTIVATION', outstanding: false, verySatisfactory: false, satisfactory: false, fairlySatisfactory: false },
            { skill: 'COMPLIANCE', outstanding: false, verySatisfactory: false, satisfactory: false, fairlySatisfactory: false },
          ],
          observation_feedback: '',
          learner_signature: '',
          category_adviser_signature: '',
          educational_section_head_signature: '',
          center_head_signature: '',
        },
        originalForm: null,
        editMode: false,
        center_head: '',
        isModalOpen: false,
        isSaveResultModalOpen: false,
        saveResultTitle: '',
        saveResultMessage: '',
      };
    },
    mounted() {
      this.form.client_id = this.$route.params.id;
      if (!this.form.client_id) {
        console.error('client_id is missing in mounted. Cannot fetch the form data.');
      } else {
        this.fetchData();
        this.fetchCenterHead();
      }
    },
    watch: {
      '$route.params.id': function (newId) {
        this.form.client_id = newId;
        this.fetchData();
      }
    },
    methods: {
      fetchData() {
        this.fetchCenterHead(this.form.client_id);
        if (!this.form.client_id) {
          console.error('client_id is missing. Cannot fetch the form data.');
          return;
        }
  
        axios.get(`/api/learner-academic-behavioral-forms/${this.form.client_id}`)
          .then(response => {
            if (response.data.form) {
              Object.assign(this.form, response.data.form);
              this.originalForm = JSON.parse(JSON.stringify(this.form));
              console.log('Form data loaded:', this.form);
            } else if (response.data.client) {
              this.form.learner_name = `${response.data.client.first_name} ${response.data.client.last_name}`;
              console.log('Client name loaded:', this.form.learner_name);
            }
          })
          .catch(error => {
          });
      },
      fetchCenterHead() {
      axios.get('/api/center-head')  // Replace with the correct API route
        .then(response => {
          this.center_head = response.data.name;  // Bind the fetched name to v-model
        })
        .catch(error => {
          console.error('Error fetching center head:', error);
        });
    },
    
    handleCheckboxChange(index, type) {
        const skill = this.form.skills[index];
        skill.outstanding = type === 'outstanding';
        skill.verySatisfactory = type === 'verySatisfactory';
        skill.satisfactory = type === 'satisfactory';
        skill.fairlySatisfactory = type === 'fairlySatisfactory';
      },
      submitForm() {
  const form = this.$refs.LearnerForm; // Ensure the form reference is correct
  let isFormValid = true;

  // Validate the form fields and check for invalid fields
  if (!form.checkValidity()) {
    isFormValid = false;
    form.reportValidity(); // This will display the browser's validation and scroll to the first invalid field
  }

  // If the form is valid, show the confirmation modal
  if (isFormValid) {
    this.isModalOpen = true;  // Open the confirmation modal to ask the user if they want to proceed
  } else {
    console.warn('Form contains invalid fields. Please correct them.');
  }
},

confirmSave() {
  const url = `/api/learner-academic-behavioral-forms`;

  axios.post(url, this.form)
    .then(response => {
      this.editMode = false;
      this.saveResultTitle = 'Success';
      this.saveResultMessage = 'Form has been saved successfully.';
      this.isSaveResultModalOpen = true;  // Show the success modal
      this.fetchData(); // Reload the form data after submission
    })
    .catch(error => {
      this.saveResultTitle = 'Error';
      this.saveResultMessage = error.response?.data?.message || 'Error saving data.';
      this.isSaveResultModalOpen = true; // Show the error modal
      console.error('Error saving data:', error.response?.data || error);
    })
    .finally(() => {
      this.isModalOpen = false;  // Close the confirmation modal
    });
},

      clearMessageAfterDelay() {
      setTimeout(() => {
      }, 3000); // Clear the message after 3 seconds
    },
      toggleEdit() {
        this.editMode = !this.editMode;
      },
    closeModal() {
      this.isModalOpen = false;
    },
    cancelEdit() {
      this.editMode = false;
    },
    closeSaveResultModal() {
       this.isSaveResultModalOpen = false;
       this.saveResultTitle = '';
       this.saveResultMessage = '';
     },
      exportToPdf() {
      const pdf = new jsPDF('p', 'mm', [216, 356]); // 216mm x 356mm is legal size
  
      const marginTop = 20;
      const marginBottom = 20;
      
      const pageHeight = pdf.internal.pageSize.getHeight(); // Height of one page
      let currentY = marginTop;
      let totalPages = 1; // Track total pages
     
      // Function to add a new page if the content exceeds page height
      const addNewPageIfNeeded = (spaceNeeded) => {
        if (currentY + spaceNeeded >= pageHeight - marginBottom) {
          pdf.addPage();
          currentY = marginTop; // Reset currentY for new page
          totalPages += 1; // Increment total page count
        }
      };
  
      // Add header logo
      const logoImg = "/images/headerlogo2.png"; // Ensure correct path to the logo
      pdf.addImage(logoImg, "PNG", 15, currentY, 75, 35);
      currentY += 30;
  
      // Add title and header
      pdf.setFontSize(10);
      pdf.setFont('arialbd', 'bold');
      pdf.text('PROTECTIVE SERVICES DIVISION', 165, 30, null, null, "center");
      currentY += 5;
      pdf.setFontSize(10);
      pdf.setFont('TimesNewRoman', 'bold');
      pdf.text('REGIONAL REHABILITATION CENTER FOR YOUTH', 165, 35, null, null, "center");
      currentY += 5;
      pdf.text('Youth/RFO XI', 165, 40, null, null, "center");
      currentY += 3;
  
      // Add subtitle
      pdf.setFontSize(8);
      pdf.setFont('TimesNewRoman', 'italic');
      pdf.text('DSWD-GF-007 | REV 03 / 22 SEP 2023', 165, 45, null, null, "center");
      currentY += 3;
  
      // Add form title
      pdf.setFontSize(16);
      pdf.setFont('TimesNewRoman', 'Bold');
      pdf.line(10, 50,210,50)
  
      pdf.setFontSize(11);
      pdf.setFont('arialbd', 'bold');
      pdf.text("LEARNER’S ACADEMIC BEHAVIORAL FORM", 105, currentY, null, null, "center");
  
      currentY += 25;
  
      pdf.setFontSize(11);
      pdf.setFont('arial', 'normal');
  
      // For the Month of
      pdf.text("For the Month of:", 85, 75, null, null, "left");  // Y-coordinate changed from 70 to 75
      let labelWidthMonth = pdf.getTextWidth("For the Month of:");
      pdf.text(`${this.form.month|| ''}`, 86 + labelWidthMonth, 75, null, null, "left");  // Y-coordinate changed from 70 to 75
      let monthWidth = pdf.getTextWidth(`${this.form.month}`);
      pdf.line(86 + labelWidthMonth, 76, 86 + labelWidthMonth + monthWidth, 76);  // Y-coordinate changed from 71 to 76
  
      // School Year
      pdf.text("School Year:", 85, 82, null, null, "left");  // Y-coordinate changed from 75 to 80
      let labelWidthYear = pdf.getTextWidth("School Year:");
      pdf.text(`${this.form.school_year|| ''}`, 87 + labelWidthYear, 82, null, null, "left");  // Y-coordinate changed from 75 to 80
      let yearWidth = pdf.getTextWidth(`${this.form.school_year}`);
      pdf.line(87 + labelWidthYear, 83, 87 + labelWidthYear + yearWidth, 83);  // Y-coordinate changed from 76 to 81
  
      // Learner's Name
      pdf.text(`Learner's Name: ${this.form.learner_name||''}`, 20, currentY);
      let learnerNameWidth = pdf.getTextWidth(`${this.form.learner_name}`);
      pdf.line(20 + pdf.getTextWidth("Learner's Name: "), currentY + 1, 20 + pdf.getTextWidth("Learner's Name: ") + learnerNameWidth, currentY + 1); // Underline
  
      // Grade
      pdf.text(`Grade: ${this.form.grade|| ''}`, 150, currentY);
      let gradeWidth = pdf.getTextWidth(`${this.form.grade}`);
      pdf.line(150 + pdf.getTextWidth("Grade: "), currentY + 1, 150 + pdf.getTextWidth("Grade: ") + gradeWidth, currentY + 1); // Underline
  
      currentY += 10;
  
      // LRN
      pdf.text(`LRN: ${this.form.lrn||''}`, 20, currentY);
      let lrnWidth = pdf.getTextWidth(`${this.form.lrn}`);
      pdf.line(20 + pdf.getTextWidth("LRN: "), currentY + 1, 20 + pdf.getTextWidth("LRN: ") + lrnWidth, currentY + 1); // Underline
  
      // Status
      pdf.text(`Status: ${this.form.status|| ''}`, 150, currentY);
      let statusWidth = pdf.getTextWidth(`${this.form.status}`);
      pdf.line(150 + pdf.getTextWidth("Status: "), currentY + 1, 150 + pdf.getTextWidth("Status: ") + statusWidth, currentY + 1); // Underline
  
      currentY += 15;
  
      // Define data for the autoTable
      // Assume this.form.skills is an array of skill objects with relevant properties
      const skillsData = this.form.skills.map(skill => [
        skill.skill, // The name of the skill
        skill.outstanding ? '/' : '', // Outstanding remarks, default to '-' if undefined
        skill.verySatisfactory ? '/' : '', // Very Satisfactory remarks
        skill.satisfactory ? '/' : '', // Satisfactory remarks
        skill.fairlySatisfactory ? '/' : '' // Fairly Satisfactory remarks
      ]);
      
      // Setup autoTable
      pdf.autoTable({
      head: [['Learner Skills', 'Outstanding *Well performed. Tasks are fully completed, all relevant information provided accurately and adequately where necessary.*Relevant tasks well performed; no tasks left incomplete', 'Very Satisfactory *General satisfactory with only minor omissions and inadequacies. Part of it is well attempted but overall, just satisfactory because of some major omissions and the limited coverage of the information.', 'Satisfactory *Revealing significant omission and inadequacies. Very limited coverage performed.', 'Fairly Satisfactory *Very unsatisfactory, important task(s) are poorly done or not attempted to do so.']],
      body: skillsData,
      startY: currentY,
      margin: { left: 20 }, // Set left margin to 20
      theme: 'grid',
      styles: {
          fontSize: 9,
          fillColor: [255, 255, 255],
          textColor: 0,
          lineWidth:0.1,
          lineColor: [0, 0, 0]
      },
      headStyles: {
          fillColor: [255, 255, 255],
          textColor: 0,
          fontStyle: 'normal', // Make the header text bold
           // Set the border color to black (RGB)
      },
      columnStyles: {
          0: { cellWidth: 45, halign: 'center' }, // Center-align specific columns if needed
          1: { cellWidth: 30, halign: 'center' },
          2: { cellWidth: 30, halign: 'center' },
          3: { cellWidth: 30, halign: 'center' },
          4: { cellWidth: 30, halign: 'center' }
      }
  });
      
  
      currentY = pdf.autoTable.previous.finalY + 10; // Update currentY after the table
      
  
      // Add observation/feedback
      addNewPageIfNeeded(15);
      pdf.setFontSize(10);
      pdf.setFont("arialbd", "italic","bold");
      pdf.text("Observation/Feedback:", 20, currentY);
  
      pdf.setFont("Arial", "normal");
      currentY += 5;
  
      const maxLineWidth = 175;
      const wrappedText = pdf.splitTextToSize(this.form.observation_feedback || "", maxLineWidth);
  
      // Add the wrapped text and handle pagination
      wrappedText.forEach(line => {
        addNewPageIfNeeded(7); // Check for space for each new line
        pdf.text(line, 20, currentY);
        currentY += 5;
      });
  
      // Add signature section
      addNewPageIfNeeded(25);
      currentY += 20;
      pdf.setFont("arialbd", "bold");
  
      // Helper function to draw a line based on text width
      function drawLine(pdf, text, x, y, width, position = "center") {
          pdf.text(text, x, y, position);
          let textWidth = pdf.getTextWidth(text); 
          let lineWidth = Math.max(width, textWidth); // Ensure the line is at least the specified width
          let lineXStart = x - lineWidth / 2; // Center the line on the text
          pdf.line(lineXStart, y + 2, lineXStart + lineWidth, y + 2); // Draw the line
      }
  
      // Signature lines and labels, adjusted for spacing and alignment
      pdf.setFont('Arial','normal');
      drawLine(pdf, this.form.learner_name || "", 35, currentY, 40); // Draw Learner name
      pdf.text("Learner", 35, currentY + 7, 'center'); // Draw Learner label
  
      pdf.setFont('Arial','normal');
      drawLine(pdf, this.form.category_adviser_signature || "", 80, currentY, 40); // Draw Category Adviser signature
      pdf.text("Category Adviser", 80, currentY + 7, 'center'); // Draw Category Adviser label
  
      pdf.setFont('Arial','normal');
      drawLine(pdf, this.form.educational_section_head_signature || "", 125, currentY, 40); // Draw Educational Section Head signature
      pdf.text("Educational Section Head", 125, currentY + 7, 'center'); // Draw Educational Section Head label
  
      pdf.setFont('Arial','normal');
      drawLine(pdf, this.center_head || "", 175, currentY, 40); // Draw Center Head signature
      pdf.text("Center Head", 175, currentY + 7, 'center'); // Draw Center Head label
  
      currentY += 20; // Adjust currentY for the next section if needed
  
      // Add footer on every page
      const addFooter = (pageNum, totalPages) => {
          const footerY = pageHeight - 10; // Position footer 10mm from the bottom
          pdf.setFontSize(9);
          pdf.setFont("Arial", "normal");
          
          // Page numbering
          pdf.setFontSize(8);
          pdf.setFont("arialbd", "bold");
          pdf.text(`PAGE ${pageNum} of ${totalPages}`, 105, footerY - 5, null, null, 'center');
          pdf.setFontSize(16);
          
          pdf.line(10, footerY-4, 210, footerY-4);
  
          // Form name
          pdf.setFontSize(8);
          pdf.text("LEARNER’S ACADEMIC BEHAVIORAL FORM", 105, footerY, null, null, 'center');
          
          // Footer text (DSWD info)
          pdf.setFontSize(8);
          pdf.setFont("Times New Roman", "normal");
          pdf.text("DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION REGIONAL REHABILITATION CENTER FOR YOUTH, DAVAO CITY PHILIPPINES 8000", 110, footerY + 3, null, null, 'center');
      };
  
      // Track how many pages were created after adding all content
      const totalPagesPlaceholder = pdf.internal.getNumberOfPages();
  
      // Add footer to each page
      for (let i = 1; i <= totalPagesPlaceholder; i++) {
          pdf.setPage(i);
          addFooter(i, totalPagesPlaceholder); // Add footer with correct page number
      }
  
      // Save the PDF
      pdf.save(`learner-behavior-form-${this.form.client_id}.pdf`);
  }
  
    },
  };
  </script>
  
  <style scoped>
  table {
    border-collapse: collapse;
  }
  
  th, td {
    padding: 8px;
    text-align: left;
  }
  .form-checkbox {
    appearance: none;
    background-color: #fff;
    border: 1px solid #d1d5db;
    border-radius: 0.25rem;
    display: inline-block;
    height: 1.5rem; /* Increased size */
    width: 1.5rem;  /* Increased size */
    vertical-align: middle;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
  }
  
  .form-checkbox:checked {
    background-color: #4f46e5;
    border-color: #4f46e5;
  }
  input[type="text"], textarea {
    border-width: 1px;
  }
  .graph-background {
      background-image: linear-gradient(to right, #cccccc 1px, transparent 1px), 
                        linear-gradient(to bottom, #cccccc 1px, transparent 1px);
      background-size: 15px 15px; /* Adjust size as per your need */
    }
  </style>
        