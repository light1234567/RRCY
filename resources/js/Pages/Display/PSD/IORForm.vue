<template>
  <div class="p-8">
    <!-- Header -->
    <div class="text-center mb-8">
      <img src="path-to-your-logo.png" alt="DSWD Logo" class="mx-auto mb-4" />
      <h1 class="text-lg font-bold">PROTECTIVE SERVICES DIVISION</h1>
      <h2 class="text-md">REGIONAL REHABILITATION CENTER FOR YOUTH FO XI</h2>
      <h3 class="text-sm">DSWD-GF-010 | REV 02 / 22 SEPT 2023</h3>
    </div>

    <!-- Buttons -->
    <div class="flex justify-end space-x-4">
      <button v-if="!editMode" @click="toggleEdit" type="button" class="px-4 py-2 bg-blue-500 text-white rounded">Edit</button>
      <button v-else @click="submitForm" type="button" class="px-4 py-2 bg-green-500 text-white rounded">Save</button>
    </div>

    <!-- Success/Error Message -->
    <div v-if="message" :class="`mt-4 p-4 rounded text-white ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">{{ message }}</div>

    <!-- General Information -->
    <div class="mb-8 grid grid-cols-2 gap-4">
      <div>
        <label class="block font-bold mb-1">Name of Resident:</label>
        <input type="text" v-model="form.name" class="w-full p-2 border rounded" readonly />
      </div>
      <div>
        <label class="block font-bold mb-1">Date of Assessment:</label>
        <input type="date" v-model="form.assessment_date" class="w-full p-2 border rounded" :readonly="!editMode" />
      </div>
      <div class="col-span-2">
        <label class="block font-bold mb-1">Trainings Attended for the Month:</label>
        <input type="text" v-model="form.trainings_attended" class="w-full p-2 border rounded" :readonly="!editMode" />
      </div>
    </div>

    <!-- Sections for Indicators and Remarks -->
    <div v-for="(section, index) in form.sections" :key="index" class="mb-8">
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
              <input type="number" min="1" max="4" v-model="indicator.self_rating" class="w-full text-center" :readonly="!editMode" />
            </td>
            <td class="p-2 border text-center">
              <input type="number" min="1" max="4" v-model="indicator.mdo_rating" class="w-full text-center" :readonly="!editMode" />
            </td>
            <td class="p-2 border text-center">{{ calculateTotalRating(indicator) }}</td>
          </tr>
        </tbody>
      </table>
      <p class="mb-1"><strong>Sub-Total:</strong> {{ calculateSubTotal(section) }}</p>      <label class="block font-bold mb-1">Remarks:</label>
      <textarea v-model="section.remarks" class="w-full p-2 border rounded" :readonly="!editMode"></textarea>
    </div>

    <!-- General Remarks/Recommendations -->
    <div class="mb-8">
      <label class="block font-bold mb-1">General Remarks/Recommendation:</label>
      <textarea v-model="form.general_remarks" class="w-full p-2 border rounded" :readonly="!editMode"></textarea>
    </div>

    <!-- Trainings Previously Attended -->
<div class="mb-8">
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
          <input type="text" v-model="training.title" class="w-full p-2 border rounded" :readonly="!editMode" />
        </td>
        <td class="p-2 border">
          <input type="date" v-model="training.date_of_attendance" class="w-full p-2 border rounded" :readonly="!editMode" />
        </td>
        <td class="p-2 border">
          <input type="text" v-model="training.status" class="w-full p-2 border rounded" :readonly="!editMode" />
        </td>
        <td class="p-2 border text-center">
          <button @click="removeTraining(index)" type="button" class="px-2 py-1 bg-red-500 text-white rounded" :disabled="!editMode">Remove</button>
        </td>
      </tr>
    </tbody>
  </table>
  <button @click="addTraining" type="button" class="px-4 py-2 bg-blue-500 text-white rounded" :disabled="!editMode">Add Training</button>
</div>


    <!-- Prepared By and Noted By -->
    <div class="grid grid-cols-2 gap-4 mb-8">
      <div>
        <label class="block font-bold mb-1">Prepared by:</label>
        <input type="text" v-model="form.prepared_by" class="w-full p-2 border rounded" :readonly="!editMode" />
      </div>
      <div>
        <label class="block font-bold mb-1">Noted by:</label>
        <input type="text" v-model="form.noted_by" class="w-full p-2 border rounded" :readonly="!editMode" />
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'IORForm',
  data() {
    return {
      form: {
        client_id: null,
        name: '',
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
              { description: 'Has shown his best in any given tasks.', self_rating: '', mdo_rating: '' },
              { description: 'Shares his talent for best results on a given activity.', self_rating: '', mdo_rating: '' },
              { description: 'Has the capacity to teach his co-residents on things that will improve and show their best in a given situation.', self_rating: '', mdo_rating: '' },
              { description: 'Continues to try new things that will increase and improve his learnings.', self_rating: '', mdo_rating: '' },
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
          {
            title: 'E. ATTITUDE',
            sub_total: 0,
            remarks: '',
            indicators: [
              { description: 'He abides with policies of the training at all times.', self_rating: '', mdo_rating: '' },
              { description: 'He follows instructions on given tasks.', self_rating: '', mdo_rating: '' },
              { description: 'Treats his co-residents fairly.', self_rating: '', mdo_rating: '' },
              { description: 'He is a peacemaker at all times.', self_rating: '', mdo_rating: '' },
              { description: 'Can cope with challenges and difficulties.', self_rating: '', mdo_rating: '' },
            ],
          },
          {
            title: 'F. RESPONSES TO SITUATIONS',
            sub_total: 0,
            remarks: '',
            indicators: [
              { description: 'Never complains on unexpected changes/result of a group task.', self_rating: '', mdo_rating: '' },
              { description: 'Gentle in his actions/decisions.', self_rating: '', mdo_rating: '' },
              { description: 'Can handle challenging tasks.', self_rating: '', mdo_rating: '' },
              { description: 'Can think appropriately in any given situation.', self_rating: '', mdo_rating: '' },
              { description: 'Never argues with co-residents and trainer to create conflict.', self_rating: '', mdo_rating: '' },
            ],
          },
          {
            title: 'G. LIFE\'S ASPIRATIONS',
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
        trainings: [
          { title: '', date_of_attendance: '', status: '' },
          // Add more trainings as needed...
        ],
        prepared_by: '',
        noted_by: '',
      },
      originalForm: null,
      editMode: false,
      message: '',
      messageType: '', // 'success' or 'error'
    };
  },
  mounted() {
    this.fetchReportData();
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
        if (!clientId) {
            console.warn("Client ID is undefined, data fetch aborted.");
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

                    this.form.client_id = response.data.client_id;
                    this.form.name = `${response.data.client.first_name} ${response.data.client.last_name}`;
                    this.form.assessment_date = response.data.assessment_date;
                    this.form.trainings_attended = response.data.trainings_attended;
                    this.form.general_remarks = response.data.general_remarks;
                    this.form.prepared_by = response.data.prepared_by;
                    this.form.noted_by = response.data.noted_by;

                    console.log('Form after API fetch:', this.form);  // Log the form data after fetch
                    this.message = 'Data loaded successfully!';
                    this.messageType = 'success';
                } else {
                    this.fetchClientData(clientId);
                }
            })
            .catch(error => {
                console.error('Error fetching report data:', error);
               
                
                this.fetchClientData(clientId);
            });
    },
    fetchClientData(clientId) {
        axios.get(`/api/clients/${clientId}`)
            .then(response => {
                const client = response.data;
                this.form.client_id = client.id; // Set the client_id
                this.form.name = `${client.first_name} ${client.last_name}`;
                
               
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
            })
            .catch(error => {
                const errorMessage = this.constructDetailedErrorMessage(error);
                console.error('Failed to save or update data:', errorMessage);
                this.message = errorMessage;
                this.messageType = 'error';
            });
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
        return (Number(indicator.self_rating) + Number(indicator.mdo_rating)) / 2 || 0;
    },
    calculateSubTotal(section) {
      const totalRatings = section.indicators.reduce((sum, indicator) => sum + this.calculateTotalRating(indicator), 0);
      return (totalRatings / 5).toFixed(2); // Divide by 5 as per your requirement and round to 2 decimal places
    },
},
};
</script>


<style scoped>
/* Add any additional styling here */
</style>
