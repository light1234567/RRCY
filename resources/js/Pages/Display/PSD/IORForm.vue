<template>
<!-- Tabs for Actions (Back button visible only in edit mode) -->
<div v-if="editMode" class="flex absolute p-4 space-x-4">
  <button @click="cancelEdit" class="flex space-x-2 px-3 py-3 bg-[conic-gradient(at_bottom_right,_var(--tw-gradient-stops))] from-blue-700 via-blue-800 to-gray-900 text-white rounded-md text-xs">
    <!-- FontAwesome for Back -->
    <i class="fas fa-arrow-left w-4 h-4"></i>
    <span>Back</span>
  </button>
</div>

<!-- Main Action Buttons -->
<div class="flex -ml-2 justify-end bg-transparent border -mr-9 border-gray-300 p-4 space-x-4 -mt-9">

  <!-- Pagination Component -->
  <Pagination 
    :totalPages="totalPages" 
    :currentPage="currentPage" 
    @update:currentPage="currentPage = $event" 
  />

  <!-- Edit Button (visible only when not in edit mode) -->
  <button v-if="!editMode" @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
    <!-- FontAwesome for Edit -->
    <i class="fas fa-edit w-4 h-4"></i>
    <span>Edit</span>
  </button>

  <!-- Save Button (visible only in edit mode) -->
  <button v-else @click="submitForm" type="button" class="px-4 py-2 bg-green-500 text-white rounded">Save</button>

  <!-- Export PDF Button (commented out for now, uncomment to use) -->
  <!--
  <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 text-white rounded-md text-xs">
    <i class="fas fa-file-pdf w-4 h-4"></i>
    <span>Export PDF</span>
  </button>
  -->
</div>


    <!-- Success/Error Message -->
    <div v-if="message" :class="`mt-4 p-4 rounded text-white ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">{{ message }}</div>
    <div class="graph-background pt-0.5  -mr-9 -mb-16">



  <div v-if="currentPage === 1" class="max-w-3xl p-12 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-400">
    <!-- Header -->
    <div class="relative flex justify-between items-center mb-4">
      <img src="/images/headerlogo2.png" alt="Logo" class=" h-32 w-64 relative z-10">
      <div class="text-right">
        <p class="item-center mr-6 text-sm font-semibold">PROTECTIVE SERVICES DIVISION</p>
        <p class="text-sm font-semibold">Regional Rehabilitation Center for Youth RFO XI</p>
        <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
      </div>
    </div>
    <div class="text-center mb-4 border-b-2 border-gray-300 pb-2">
      <h1 class="text-lg font-bold">INDIVIDUAL PERFORMANCE OBSERVATION REPORT</h1>
    </div>

    <div class="flex items-center justify-center mb-6">
      <p class="text-md font-semibold mr-4">For the Period:</p>
      <input type="text" v-model="form.period" class="underline-input bg-transparent border-b-2 border-gray-300 text-center text-xs" :readonly="!editMode"/>
    </div>
      
    <!-- General Information -->
    <div class="mb-6 grid grid-cols-2 gap-4">
      <div>
        <label class="block font-bold mb-1">Name of Resident:</label>
        <input type="text" v-model="form.name" class="w-full p-2 border border-gray-300 rounded text-sm" readonly />
      </div>
      <div>
        <label class="block font-bold mb-1">Date of Assessment:</label>
        <input type="date" v-model="form.assessment_date" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode" />
      </div>
      <div class="col-span-2">
        <label class="block font-bold mb-1">Trainings Attended for the Month:</label>
        <input type="text" v-model="form.trainings_attended" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode" />
      </div>
    </div>

<!-- Scale of Measurement Section -->
 
<h4 class="text-center mb-4 border-b-2 border-gray-300 pb-2 font-bold mb-2 ">SCALE OF MEASUREMENT</h4>
      <div class="grid grid-cols-2 gap-4 text-sm">
        <div class="flex justify-between ">
          <span>4 - PIRMI GINABUHAT</span>
          <em>(ALWAYS)</em>
        </div>
        <div class="flex justify-between">
          <span>2 - KUNG GANAHAN LANG GINABUHAT</span>
          <em>(SELDOM)</em>
        </div>
        <div class="flex justify-between">
          <span>3 - USAHAY RA GINABUHAT</span>
          <em>(SOMETIMES)</em>
        </div>
        <div class="flex justify-between">
          <span>1 - WALA JUD GIBUHAT</span>
          <em>(NEVER)</em>
        </div>
      </div>


    <!-- Sections for Indicators and Remarks -->
    <div v-for="(section, index) in form.sections" :key="index" class="mb-6">
      <h4 class="font-bold mb-2">{{ section.title }}</h4>
      <table class="w-full border-collapse border mb-4">
        <thead>
          <tr class="bg-gray-200">
            <th colspan="3" class="text-center p-2 border">Indicators</th>
            <th class="text-center p-2 border">Self-Rating</th>
            <th class="text-center p-2 border">MDO's Rating</th>
            <th class="text-center p-2 border">Total Rating</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(indicator, iIndex) in section.indicators" :key="iIndex">
            <td colspan="3" class="p-2 border">{{ indicator.description }}</td>
            <td class="p-2 border text-center">
              <input type="number" min="1" max="4" v-model="indicator.self_rating" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
            </td>
            <td class="p-2 border text-center">
              <input type="number" min="1" max="4" v-model="indicator.mdo_rating" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
            </td>
            <td class="p-2 border text-center">{{ calculateTotalRating(indicator) }}</td>
          </tr>
        </tbody>
      </table>
      <p class="mb-1"><strong>Sub-Total:</strong> {{ calculateSubTotal(section) }}</p>
      <label class="block font-bold mb-1">Remarks:</label>
      <textarea v-model="section.remarks" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode"></textarea>
    </div>

    

    <div class="border-gray-300 ml-6 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
        <div class="flex justify-between items-center">
          <div class="flex flex-col">
            <p class="ml-24 -mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
            <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
            <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrcy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
          </div>
          <div class="ml-4">
            <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
          </div>
        </div>
      </div>
      
  </div>



  <div v-if="currentPage === 2" class="max-w-3xl p-8 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">

    <!-- General Information -->
    <div class="mb-6 grid grid-cols-2 gap-4">
      <div>
        <label class="block font-bold mb-1">Name of Resident:</label>
        <input type="text" v-model="form.name" class="w-full p-2 border border-gray-300 rounded text-sm" readonly />
      </div>
      <div>
        <label class="block font-bold mb-1">Date of Assessment:</label>
        <input type="date" v-model="form.assessment_date" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode" />
      </div>
    </div>

    <!-- Sections for Indicators and Remarks -->
    <div v-for="(section, index) in form.sectionss" :key="index" class="mb-6">
      <h4 class="font-bold mb-2">{{ section.title }}</h4>
      <table class="w-full border-collapse border mb-4">
        <thead>
          <tr class="bg-gray-200">
            <th colspan="3" class="text-center p-2 border">Indicators</th>
            <th class="text-center p-2 border">Self-Rating</th>
            <th class="text-center p-2 border">MDO's Rating</th>
            <th class="text-center p-2 border">Total Rating</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(indicator, iIndex) in section.indicators" :key="iIndex">
            <td colspan="3" class="p-2 border">{{ indicator.description }}</td>
            <td class="p-2 border text-center">
              <input type="number" min="1" max="4" v-model="indicator.self_rating" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
            </td>
            <td class="p-2 border text-center">
              <input type="number" min="1" max="4" v-model="indicator.mdo_rating" class="w-full p-1 border border-gray-300 text-center text-sm" :readonly="!editMode" />
            </td>
            <td class="p-2 border text-center">{{ calculateTotalRating(indicator) }}</td>
          </tr>
        </tbody>
      </table>
      <p class="mb-1"><strong>Sub-Total:</strong> {{ calculateSubTotal(section) }}</p>
      <label class="block font-bold mb-1">Remarks:</label>
      <textarea v-model="section.remarks" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode"></textarea>
    </div>
    <div class="w-full h-full p-4">
    <table class="w-full h-full border-collapse border border-black table-fixed">
        <tr>
            <td class="border border-black p-4 align-top">4 - Points - Excellent/Full cooperation and proper physical condition</td>
            <td class="border border-black p-4 align-top">2 - 2.99 Points - Needs Improvement/Complies with the request to cooperate</td>
        </tr>
        <tr>
            <td class="border border-black p-4 align-top">3 - 3.99 Points - Very Satisfactory/Appropriate behavior and condition during the training</td>
            <td class="border border-black p-4 align-top">1 - 1.99 Points - Needs Close Monitoring/Problem is Prominent</td>
        </tr>
    </table>
</div>
      <br />



    <!-- General Remarks/Recommendations -->
    <div class="mb-6">
      <label class="block font-bold mb-1">General Remarks/Recommendation:</label>
      <textarea v-model="form.general_remarks" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode"></textarea>
    </div>

    <!-- Trainings Previously Attended -->
    <div class="mb-6">
      <h4 class="font-bold mb-2">Trainings Previously Attended</h4>
      <table class="w-full border-collapse border mb-4">
        <thead>
          <tr class="bg-gray-200">
            <th class="text-center p-2 border">No.</th>
            <th class="text-center p-2 border">Title of the Training</th>
            <th class="text-center p-2 border">Date of Attendance</th>
            <th class="text-center p-2 border">Status</th>
            <th class="text-center p-2 border">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(training, index) in form.trainings" :key="index">
            <td class="p-2 border text-center">{{ index + 1 }}</td>
            <td class="p-2 border">
              <input type="text" v-model="training.title" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode" />
            </td>
            <td class="p-2 border">
              <input type="date" v-model="training.date_of_attendance" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode" />
            </td>
            <td class="p-2 border">
              <input type="text" v-model="training.status" class="w-full p-2 border border-gray-300 rounded text-sm" :readonly="!editMode" />
            </td>
            <td class="p-2 border text-center">
              <button @click="removeTraining(index)" type="button" class="px-2 py-1 bg-red-500 text-white rounded" :disabled="!editMode">Remove</button>
            </td>
          </tr>
        </tbody>
      </table>
      <button @click="addTraining" type="button" class="px-4 py-2 bg-blue-500 text-white rounded" :disabled="!editMode">Add Training</button>
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
          value="JENNY C. CADOYAS"
          class="mt-1 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm "
        >
      </div>
      <p class="text-sm mt-2">MDO I</p>

      
      <div class="flex items-center">
        <input
          type="text"
          id="preparedBy"
          value="SHERWIN B. GABUTAN"
          class="mt-1 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm "
        >
      </div>
      <p class="text-sm mt-2">MDO II</p>
      
      
    </div>
  
    <!-- Noted by Signature -->
    <div class="w-1/2">
      <label for="notedBy" class="block text-sm font-medium">Noted by:</label>
      <div class="flex items-center">
        <input
          type="text"
          id="notedBy"
          v-model="center_head"
          readonly
          class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm "
        >
      </div>
      <p class="text-sm mt-2">Center Head</p>
    </div>
  </div>

    <div class="border-gray-300 ml-6 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
        <div class="flex justify-between items-center">
          <div class="flex flex-col">
            <p class="ml-24 -mb-4 font-bold">PAGE 2 of {{ totalPages }}</p>
            <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
            <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrcy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
          </div>
          <div class="ml-4">
            <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
          </div>
        </div>
      </div>
      
      </div>
  </div>
</template>


<script>
import axios from 'axios';
import Pagination from '@/Components/Pagination.vue';

export default {
  name: 'IORForm',
  components: {
    Pagination,
  },
  data() {
    return {
      form: {
        client_id: null,
        name: '',
        period: '',
        assessment_date: '',
        trainings_attended: '',
        sections: [
          {
            title: 'A. PERSONALITY/BEHAVIOR',
            sub_total: 0,
            remarks: '',
            indicators: [
              { description: 'Well mannered and disciplined.', self_rating: '', mdo_rating: '' },
              { description: 'He acts appropriately in any given situation.', self_rating: '', mdo_rating: '' },
              { description: 'He can inspire and motivate co-residents to be happy.', self_rating: '', mdo_rating: '' },
              { description: 'Carry himself well in any given situation.', self_rating: '', mdo_rating: '' },
              { description: 'Has confidence in expressing himself.', self_rating: '', mdo_rating: '' },
            ],
          },
          {
            title: 'B. PERSONAL RELATIONSHIP',
            sub_total: 0,
            remarks: '',
            indicators: [
              { description: 'Can relate appropriately with co-residents, staff and trainers.', self_rating: '', mdo_rating: '' },
              { description: 'Can lead and motivate co-residents to do assigned tasks.', self_rating: '', mdo_rating: '' },
              { description: 'Dependable in any given situation.', self_rating: '', mdo_rating: '' },
              { description: 'Has the willingness to learn by listening, asking questions/clarify concerns with trainer.', self_rating: '', mdo_rating: '' },
              { description: 'Non-involvement in any untoward incident that may occur during the training.', self_rating: '', mdo_rating: '' },
            ],
          },
          {
            title: 'C. KNOWLEDGE',
            sub_total: 0,
            remarks: '',
            indicators: [
              { description: 'Has the initiative to improve his given skills and talents.', self_rating: '', mdo_rating: '' },
              { description: 'Punctual in attending the training.', self_rating: '', mdo_rating: '' },
              { description: 'Demonstrates knowledge in the area of expertise.', self_rating: '', mdo_rating: '' },
              { description: 'Shows interest in learning by actively participating in discussions.', self_rating: '', mdo_rating: '' },
              { description: 'Observes cleanliness and orderliness of the training venue.', self_rating: '', mdo_rating: '' },
            ],
          },
          {
            title: 'D. SKILLS',
            sub_total: 0,
            remarks: '',
            indicators: [
              { description: 'Has inherent capacity to be creative.', self_rating: '', mdo_rating: '' },
              { description: 'Utilizes his skills appropriately on beneficial activities.', self_rating: '', mdo_rating: '' },
              { description: 'Tries his best to be progressive on acquired skills in the different activities.', self_rating: '', mdo_rating: '' },
              { description: 'Participates in activities that will assist the trainer in maximizing resident time at the center.', self_rating: '', mdo_rating: '' },
              { description: 'Learns easily on productive endeavors taught to him.', self_rating: '', mdo_rating: '' },
            ],
          },
        ],
        sectionss: [
          {
            title: 'E. ATTITUDE',
            sub_total: 0,
            remarks: '',
            indicators: [
              { description: 'He abides with policies of the training at all times..', self_rating: '', mdo_rating: '' },
              { description: 'He follows instructions on given tasks.', self_rating: '', mdo_rating: '' },
              { description: 'Treats his co-residents fairly.', self_rating: '', mdo_rating: '' },
              { description: 'He is a peacemaker at all times.', self_rating: '', mdo_rating: '' },
              { description: 'Can cope up with challenges and difficulties.', self_rating: '', mdo_rating: '' },
            ],
          },
          {
            title: 'F. RESPONSES TO SITUATIONS',
            sub_total: 0,
            remarks: '',
            indicators: [
              { description: 'Never complains on unexpected changes/result of a group tasks.', self_rating: '', mdo_rating: '' },
              { description: 'Gentle in his actions/decisions.', self_rating: '', mdo_rating: '' },
              { description: 'Can handle challenging tasks.', self_rating: '', mdo_rating: '' },
              { description: 'Can think appropriately in any given situation.', self_rating: '', mdo_rating: '' },
              { description: 'Never argues with co-residents and trainor to create conflict.', self_rating: '', mdo_rating: '' },
            ],
          },
          {
            title: 'G. LIFE ASPIRATIONS ',
            sub_total: 0,
            remarks: '',
            indicators: [
              { description: 'Willingness to learn new things.', self_rating: '', mdo_rating: '' },
              { description: 'Values the importance of education.', self_rating: '', mdo_rating: '' },
              { description: 'Believes having discipline can change his life.', self_rating: '', mdo_rating: '' },
              { description: 'Believes in the power of the caring God.', self_rating: '', mdo_rating: '' },
              { description: 'Believes that good character qualities will help him develop his potentials.', self_rating: '', mdo_rating: '' },
            ],
          },
        ],
        general_remarks: '',
        trainings: [ { title: '', date_of_attendance: '', status: '' },],
        prepared_by: '',
      },
      center_head: '',
      editMode: false,
      originalForm: null,
      message: '',
      totalPages: 2,
      currentPage: 1,
      messageType: '',
    };
  },
  mounted() {
    this.fetchReportData();
    this.fetchCenterHead();
  },
  watch: {
    '$route.params.id': 'fetchReportData',
}
,
  methods: {
    addTraining() {
    this.form.trainings.push({ title: '', date_of_attendance: '', status: '' });
  },
  removeTraining(index) {
    this.form.trainings.splice(index, 1);
  },
  fetchReportData() {
        const clientId = this.$route.params.id;
        // Fetch client data first, if clientId is undefined
        if (!clientId) {
            console.warn("Client ID is undefined, fetching client data.");
            this.fetchClientData(); // Fetch the client data directly
            return;
        }

        axios.get(`/api/performance-observation-reports/${clientId}`)
            .then(response => {
                console.log('API Response:', response.data);  // Log API response

                if (response.data) {
                    // Ensure the response structure is correct
                    if (response.data.sections && Array.isArray(response.data.sections)) {
                        this.form.sections = response.data.sections.map(section => ({
                            title: section.title,
                            sub_total: section.sub_total,
                            remarks: section.remarks,
                            indicators: section.indicators.map(indicator => ({
                                description: indicator.description,
                                self_rating: indicator.self_rating,
                                mdo_rating: indicator.mdo_rating,
                            }))
                        }));
                    }
                    
                    if (response.data.trainings && Array.isArray(response.data.trainings)) {
                        this.form.trainings = response.data.trainings.map(training => ({
                            title: training.title,
                            date_of_attendance: training.date_of_attendance,
                            status: training.status,
                        }));
                    }

                    // Assign fetched client and report data to form
                    this.form.client_id = response.data.client_id;
                    this.form.name = `${response.data.client.first_name} ${response.data.client.last_name}`;
                    this.form.assessment_date = response.data.assessment_date;
                    this.form.period = response.data.period;
                    this.form.trainings_attended = response.data.trainings_attended;
                    this.form.general_remarks = response.data.general_remarks;
                    this.form.prepared_by = response.data.prepared_by;

                    // Fetch center head after fetching the client_id
                    this.fetchCenterHead(this.form.client_id);

                    console.log('Form after API fetch:', this.form);  // Log the form data after fetch
                    this.messageType = 'success';
                } else {
                    // No report data, fetch client data directly
                    this.fetchClientData(clientId);
                }
            })
            .catch(error => {
                console.error('Error fetching report data:', error);
                // Fallback to fetching client data
                this.fetchClientData(clientId);
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
  
    fetchClientData(clientId) {
        axios.get(`/api/clients/${clientId}`)
            .then(response => {
                const client = response.data;

                this.form.client_id = client.id; // Set the client_id
                this.form.name = `${client.first_name} ${client.last_name}`;
                this.fetchCenterHead(clientId);
                
               
            })
            .catch(error => {
                console.error('Error fetching client data:', error);
                
                
            });
    },
    submitForm() {
        console.log("Submitting form with data:", this.form);
        if (!this.form.client_id) {
            this.message = 'Failed to save data: Missing client ID';
            this.messageType = 'error';
            return;
        }
        if (!this.form.assessment_date) {
            this.message = 'Assessment date is required.';
            this.messageType = 'error';
            return;
        }

        axios.post(`/api/performance-observation-reports/${this.form.client_id}`, this.form)
            .then(response => {
                const updatedSections = response.data.sections || this.form.sections;
                const updatedTrainings = response.data.trainings || this.form.trainings;

                this.form = {
                    ...this.form,
                    ...response.data, 
                    sections: this.form.sections.map((section, index) => ({
                        ...section,
                        ...updatedSections[index] || {} // Ensure section exists before merging
                    })),
                    trainings: this.form.trainings.map((training, index) => ({
                        ...training,
                        ...updatedTrainings[index] || {} // Ensure training exists before merging
                    })),
                };

                this.editMode = false;
                this.message = 'Data saved or updated successfully!';
                this.messageType = 'success';
                this.clearMessageAfterDelay();
            })
            .catch(error => {
                const errorMessage = this.constructDetailedErrorMessage(error);
                console.error('Failed to save or update data:', errorMessage);
                this.message = errorMessage;
                this.messageType = 'error';
                this.clearMessageAfterDelay();
            });
    },
    clearMessageAfterDelay() {
    setTimeout(() => {
      this.message = '';
    }, 3000); // Clear the message after 3 seconds
  },
    constructDetailedErrorMessage(error) {
        let message = 'Failed to save or update data: ';
    
        if (error.response) {
            message += `HTTP ${error.response.status} (${error.response.statusText}) - `;
    
            if (error.response.data && error.response.data.message) {
                message += `${error.response.data.message}. `;
            }
    
            if (error.response.data && error.response.data.errors) {
                const errorDetails = Object.entries(error.response.data.errors)
                    .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
                    .join('; ');
                message += `Details: ${errorDetails}`;
            }
        } else if (error.request) {
            message += 'No response received from the server. ';
        } else {
            message += `Request setup error: ${error.message}. `;
        }
    
        return message;
    },
    toggleEdit() {
        this.editMode = !this.editMode;
    },
    calculateTotalRating(indicator) {
      return (parseFloat(indicator.self_rating) || 0) + (parseFloat(indicator.mdo_rating) || 0);
    },
    cancelEdit() {
      this.editMode = false;
      console.log('Edit mode canceled');
    },
    calculateSubTotal(section) {
      return section.indicators.reduce((sum, indicator) => sum + (parseFloat(indicator.self_rating) || 0), 0);
    },
    addTraining() {
      this.form.trainings.push({
        title: '',
        date_of_attendance: '',
        status: ''
      });
    },
    removeTraining(index) {
      this.form.trainings.splice(index, 1);
    },
  },
};
</script>

<style scoped>
.graph-background {
    background-image: linear-gradient(to right, #cccccc 1px, transparent 1px), 
                      linear-gradient(to bottom, #cccccc 1px, transparent 1px);
    background-size: 15px 15px; /* Adjust size as per your need */
  } 
</style>
