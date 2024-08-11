<template>
  <div class="mx-auto p-8 bg-gray-100 rounded-lg max-w-full">
    <form @submit.prevent="submitForm" class="space-y-8 w-full">
      <!-- Header -->
      <div class="border border-gray-300 p-6 rounded-md bg-white">
        <!-- Identifying Data Section -->
        <div class="space-y-4 mt-6">
          <h2 class="font-bold">INITIAL PSYCHOLOGICAL ASSESSMENT REPORT FORM</h2>

          <div class="flex justify-end mb-4">
            <button
              v-if="!editMode"
              @click="toggleEdit"
              type="button"
              class="px-4 py-2 bg-blue-500 text-white rounded-md mt-4"
            >
              Edit
            </button>
            <button
              v-else
              @click="submitForm"
              type="button"
              class="px-4 py-2 bg-green-500 text-white rounded-md mt-4"
            >
              Save
            </button>
          </div>

          <div
            v-if="message"
            :class="`p-4 mt-4 text-white rounded-md ${
              messageType === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`"
          >
            {{ message }}
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label for="name" class="block font-medium">Name:</label>
              <input type="text" id="name" v-model="form.name" required class="block w-full p-2 border border-gray-300 rounded-md" readonly>
            </div>
            <div class="space-y-2">
              <label for="nickname" class="block font-medium">Nickname:</label>
              <input type="text" id="nickname" v-model="form.nickname" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label for="birthDate" class="block font-medium">Birth Date:</label>
              <input type="date" id="birthDate" v-model="form.birth_date" required class="block w-full p-2 border border-gray-300 rounded-md" readonly>
            </div>
            <div class="space-y-2">
              <label for="age" class="block font-medium">Age:</label>
              <input type="number" id="age" v-model="form.age" required class="block w-full p-2 border border-gray-300 rounded-md" readonly>
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label for="gender" class="block font-medium">Gender:</label>
              <input type="text" id="gender" v-model="form.gender" required class="block w-full p-2 border border-gray-300 rounded-md" readonly>
            </div>
            <div class="space-y-2">
              <label for="address" class="block font-medium">Address:</label>
              <input type="text" id="address" v-model="form.address" required class="block w-full p-2 border border-gray-300 rounded-md" readonly>
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label for="religion" class="block font-medium">Religion:</label>
              <input type="text" id="religion" v-model="form.religion" required class="block w-full p-2 border border-gray-300 rounded-md" readonly>
            </div>
            <div class="space-y-2">
              <label for="education" class="block font-medium">Educational Attainment:</label>
              <input type="text" id="education" v-model="form.educational_attainment" class="block w-full p-2 border border-gray-300 rounded-md" readonly>
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label for="offense" class="block font-medium">Offense Committed:</label>
              <input type="text" id="offense" v-model="form.offense_committed" required class="block w-full p-2 border border-gray-300 rounded-md" readonly>
            </div>
            <div class="space-y-2">
              <label for="admissionDate" class="block font-medium">Date of Admission:</label>
              <input type="date" id="admissionDate" v-model="form.admission_date" required class="block w-full p-2 border border-gray-300 rounded-md" readonly>
            </div>
            <div class="space-y-2">
              <label for="reportDate" class="block font-medium">Date of Report:</label>
              <input type="date" id="reportDate" v-model="form.report_date" required class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode">
            </div>
          </div>
        </div>

        <!-- Reason for Referral Section -->
        <div class="space-y-4 mt-6">
          <h2 class="font-bold">REASON FOR REFERRAL</h2>
          <textarea id="reasonForReferral" v-model="form.reason_for_referral" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
        </div>

        <!-- Brief Background Section -->
        <div class="space-y-4 mt-6">
          <h2 class="font-bold">BRIEF BACKGROUND</h2>
          <div class="space-y-2">
            <label for="familyHistory" class="block font-medium">Family History</label>
            <textarea id="familyHistory" v-model="form.family_history" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="sexualDevelopment" class="block font-medium">Sexual Development</label>
            <textarea id="sexualDevelopment" v-model="form.sexual_development" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="medicalHistory" class="block font-medium">Medical and Psychological History</label>
            <textarea id="medicalHistory" v-model="form.medical_history" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="schoolHistory" class="block font-medium">School History</label>
            <textarea id="schoolHistory" v-model="form.school_history" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="socialHistory" class="block font-medium">Social History (including Spiritual Development and Work Experience)</label>
            <textarea id="socialHistory" v-model="form.social_history" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="personalCharacteristics" class="block font-medium">Personal Characteristics</label>
            <textarea id="personalCharacteristics" v-model="form.personal_characteristics" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
        </div>

        <!-- Assessment Tools Section -->
        <div class="space-y-4 mt-6">
          <h2 class="font-bold">ASSESSMENT TOOLS</h2>
          <div class="space-y-2">
            <label for="reviewSystems" class="block font-medium">Review the major systems of psychiatric functioning (appearance, cognitive function, insight, etc.).</label>
            <textarea id="reviewSystems" v-model="form.review_systems" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="mentalStatus" class="block font-medium">Mental Status Examination</label>
            <textarea id="mentalStatus" v-model="form.mental_status" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
          <div class="space-y-2">
            <label for="assessmentInterview" class="block font-medium">Gathering information about the client, assessing his strengths, level of adjustment, the nature and history of the problem, and relevant personal and family history.</label>
            <textarea id="assessmentInterview" v-model="form.assessment_interview" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
        </div>

        <!-- Test Result and Discussion Section -->
        <div class="space-y-4 mt-6">
          <h2 class="font-bold">TEST RESULT AND DISCUSSION</h2>
          <div class="space-y-2">
            <label for="testResult" class="block font-medium">Test Result and Discussion</label>
            <textarea id="testResult" v-model="form.test_result" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
          </div>
        </div>

        <!-- Clinical Impression Section -->
        <div class="space-y-4 mt-6">
          <h2 class="font-bold">CLINICAL IMPRESSION</h2>
          <textarea id="clinicalImpression" v-model="form.clinical_impression" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
        </div>

        <!-- Plan of Action Section -->
        <div class="space-y-4 mt-6">
          <h2 class="font-bold">PLAN OF ACTION</h2>
          <textarea id="planOfAction" v-model="form.plan_of_action" class="block w-full p-2 border border-gray-300 rounded-md" :readonly="!editMode"></textarea>
        </div>

        <!-- Signatures Section -->
        <div class="space-y-4 mt-6">
          <div class="space-y-2">
            <label for="preparedBy" class="block font-medium">Prepared by:</label>
            <input type="text" id="preparedBy" v-model="form.prepared_by" class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200" :readonly="!editMode">
          </div>
          <div class="space-y-2">
            <label for="notedBy" class="block font-medium">Noted by:</label>
            <input type="text" id="notedBy" v-model="form.noted_by" class="block w-full p-2 border border-gray-300 rounded-md bg-gray-200" :readonly="!editMode">
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';

export default {
  name: 'InitialPsychologicalAssessmentForm',
  setup() {
    const form = ref({
      id: null,
      client_id: null,
      nickname: '',
      name: '',
      birth_date: '',
      age: '',
      gender: '',
      address: '',
      religion: '',
      educational_attainment: '',
      offense_committed: '',
      admission_date: '',
      report_date: '',
      reason_for_referral: '',
      family_history: '',
      sexual_development: '',
      medical_history: '',
      school_history: '',
      social_history: '',
      personal_characteristics: '',
      review_systems: '',
      mental_status: '',
      assessment_interview: '',
      test_result: '',
      clinical_impression: '',
      plan_of_action: '',
      prepared_by: '',
      noted_by: '',
    });

    const editMode = ref(false);
    const message = ref('');
    const messageType = ref(''); // 'success' or 'error'
    const route = useRoute();

    const fetchData = () => {
      const clientId = route.params.id;
      if (clientId) {
        axios.get(`/api/initial-psychological-assessments/${clientId}`).then(response => {
          if (response.data.assessment) {
            Object.assign(form.value, response.data.assessment);
            form.value.client_id = clientId;
            form.value.admission_id = response.data.admission.id;
            // Assign additional fields from client and admission, making them non-editable
            const client = response.data.client;
            const admission = response.data.admission;
            form.value.name = `${client.first_name} ${client.last_name}`;
            form.value.birth_date = client.date_of_birth;
            form.value.age = calculateAge(client.date_of_birth);
            form.value.gender = client.sex;
            form.value.address = `${client.street}, ${client.barangay}, ${client.city}, ${client.province}`;
            form.value.religion = client.religion;
            form.value.offense_committed = admission.offense_committed;
            form.value.admission_date = admission.date_admitted;
          } else {
            const { client, admission, highest_educ_att } = response.data;
            form.value.client_id = client.id;
            form.value.admission_id = admission.id;
            form.value.name = `${client.first_name} ${client.last_name}`;
            form.value.birth_date = client.date_of_birth;
            form.value.age = calculateAge(client.date_of_birth);
            form.value.gender = client.sex;
            form.value.address = `${client.street}, ${client.barangay}, ${client.city}, ${client.province}`;
            form.value.religion = client.religion;
            form.value.offense_committed = admission.offense_committed;
            form.value.educational_attainment = highest_educ_att;
            form.value.admission_date = admission.date_admitted;
            form.value.report_date = new Date().toISOString().split('T')[0];
          }
        }).catch(error => {
          console.error('Error fetching data:', error);
        });
      }
    };

    onMounted(fetchData);

    const toggleEdit = () => {
      editMode.value = true;
    };

    const submitForm = () => {
  if (!form.value.client_id || !form.value.admission_id) {
    message.value = 'Client ID and Admission ID are required.';
    messageType.value = 'error';
    return;
  }

  const url = `/api/initial-psychological-assessments/${form.value.client_id}`;

  axios.put(url, form.value)
    .then(response => {
      editMode.value = false;
      message.value = 'Data updated successfully!';
      messageType.value = 'success';
      fetchData(); // Re-fetch data to update the form with the latest saved data
    })
    .catch(error => {
      if (error.response && error.response.status === 422) {
        const errors = error.response.data.errors;
        message.value = 'Validation error: ' + Object.values(errors).flat().join(', ');
      } else {
        message.value = 'Failed to update data';
      }
      messageType.value = 'error';
    });
};


    const calculateAge = (birthDate) => {
      const today = new Date();
      const birthDateObj = new Date(birthDate);
      let age = today.getFullYear() - birthDateObj.getFullYear();
      const monthDiff = today.getMonth() - birthDateObj.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDateObj.getDate())) {
        age--;
      }
      return age;
    };

    return {
      form,
      editMode,
      message,
      messageType,
      toggleEdit,
      submitForm,
      calculateAge,
    };
  },
};
</script>


<style scoped>
/* Add your custom styles here */
</style>