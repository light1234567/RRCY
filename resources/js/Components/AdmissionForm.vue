<template>
    <div class="p-6 max-w-3xl mx-auto">
      <h1 class="text-3xl font-bold mb-6 text-gray-800">Admission Form</h1>
      <form @submit.prevent="submitForm" class="space-y-6">
        <!-- Form fields here (as per your original code) -->
        <button
          type="submit"
          class="bg-blue-600 text-white px-6 py-3 rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300"
        >
          Save
        </button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        form: {
          client: {
            name: "",
            sex: "",
            address: "",
            date_of_birth: "",
            religion: "",
            occupation: ""
          },
          admission: {
            committing_court: "",
            crim_case_number: "",
            offense_committed: "",
            date_admitted: "",
            days_in_jail: "",
            days_in_detention_center: "",
            action_taken: "",
            highest_educ_att: "",
            school_name: "",
            class_adviser: ""
          },
          distinguishing_marks: {
            tattoo_scars: "",
            height: "",
            weight: "",
            colour_of_eye: "",
            skin: ""
          },
          documents: {
            scsr: false,
            courtOrder: false,
            medicalCertificates: false,
            commitmentOrder: false,
            courtInformation: false
          }
        }
      };
    },
    methods: {
      submitForm() {
        this.$router.push({ 
          name: 'DisplayData',
          query: { form: JSON.stringify(this.form) }
        });
      }
    }
  };
  </script>
  