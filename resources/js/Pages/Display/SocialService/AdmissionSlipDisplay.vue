<template>
  <div class="p-8 bg-white shadow-xl rounded-lg max-w-3xl mx-auto my-8 border border-gray-200">
    <div class="relative flex justify-between items-center mb-2">
      <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
      <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p> <!-- Applied text-xs class -->
    </div>

    <h1 class="text-2xl font-bold mb-6 text-center text-black">ADMISSION SLIP</h1> <!-- Reduced font size -->

    <div v-for="client in clients" :key="client.id" class="mb-12 p-6 bg-gray-50 rounded-lg text-xs"> <!-- Applied text-xs class -->
      <div class="flex items-center mb-4">
        <div class="flex-grow flex items-center mr-4">
          <label class="block text-base font-semibold text-gray-700 mr-4 flex items-center h-full">Name:</label> <!-- Reduced font size -->
          <input type="text" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :value="client.first_name + ' ' + client.middle_name + ' ' + client.last_name" readonly> <!-- Applied text-xs class -->
        </div>
        <div class="flex items-center w-1/4">
          <label class="block text-base font-semibold text-gray-700 mr-4 flex items-center h-full">Sex:</label> <!-- Reduced font size -->
          <input type="text" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :value="client.sex" readonly> <!-- Applied text-xs class -->
        </div>
      </div>

      <div class="flex items-center mb-4">
        <div class="flex-grow flex items-center mr-4">
          <label class="block text-base font-semibold text-gray-700 mr-4">Address:</label> <!-- Reduced font size -->
          <input type="text" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :value="client.province + ', ' + client.city + ', ' + client.barangay + ', ' + client.street" readonly> <!-- Applied text-xs class -->
        </div>
        <div class="flex items-center w-1/3">
          <label class="block text-base font-semibold text-gray-700 mr-4">Religion:</label> <!-- Reduced font size -->
          <input type="text" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :value="client.religion" readonly> <!-- Applied text-xs class -->
        </div>
      </div>

      <div class="flex items-center mb-4">
        <label class="block text-base font-semibold text-gray-700 mr-4">Date/Place of Birth:</label> <!-- Reduced font size -->
        <input type="text" class="mt-1 flex-grow border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :value="client.date_of_birth + ' / ' + client.place_of_birth" readonly> <!-- Applied text-xs class -->
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="flex items-center">
          <label class="block text-base font-semibold text-gray-700 mr-4">Committing Court:</label> <!-- Reduced font size -->
          <input type="text" class="mt-1 flex-grow border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :value="client.admissions[0]?.committing_court" readonly> <!-- Applied text-xs class -->
        </div>
        <div class="flex items-center">
          <label class="block text-base font-semibold text-gray-700 mr-4">Crim. Case #:</label> <!-- Reduced font size -->
          <input type="text" class="mt-1 flex-grow border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :value="client.admissions[0]?.crim_case_number" readonly> <!-- Applied text-xs class -->
        </div>
      </div>

      <div class="flex items-center mb-4">
        <div class="flex items-center w-1/2">
          <label class="block text-base font-semibold text-gray-700 mr-4">Offense Committed:</label> <!-- Reduced font size -->
          <input type="text" class="mt-1 flex-grow border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :value="client.admissions[0]?.offense_committed" readonly> <!-- Applied text-xs class -->
        </div>
        <div class="flex items-center w-1/2">
          <label class="block text-base font-semibold text-gray-700 ml-4 mr-4">Date admitted to Center:</label> <!-- Reduced font size -->
          <input type="text" class="mt-1 flex-grow border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :value="client.admissions[0]?.date_admitted" readonly> <!-- Applied text-xs class -->
        </div>
      </div>

      <div class="flex items-center mb-4">
        <div class="flex items-center w-1/2">
          <label class="block text-base font-semibold text-gray-700 mr-4">No. of Days in Jail:</label> <!-- Reduced font size -->
          <input type="text" class="mt-1 flex-grow border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :value="client.admissions[0]?.days_in_jail" readonly> <!-- Applied text-xs class -->
        </div>
        <div class="flex items-center w-1/2">
          <label class="block text-base font-semibold text-gray-700 mr-4 ml-4">No. of Days in Detention Center:</label> <!-- Reduced font size -->
          <input type="text" class="mt-1 flex-grow border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :value="client.admissions[0]?.days_in_detention_center" readonly> <!-- Applied text-xs class -->
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-base font-semibold text-gray-700">Distinguishing Marks:</label> <!-- Reduced font size -->
        <div class="grid grid-cols-2 gap-4 pl-4">
          <div class="flex items-center">
            <label class="block text-base font-semibold text-gray-700 mr-4">a. Tattoo/Scars:</label> <!-- Reduced font size -->
            <input type="text" class="mt-1 flex-grow border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :value="client.admissions[0]?.distinguishing_marks[0]?.tattoo_scars" readonly> <!-- Applied text-xs class -->
          </div>
          <div class="flex items-center">
            <label class="block text-base font-semibold text-gray-700 mr-4">b. Height:</label> <!-- Reduced font size -->
            <input type="text" class="mt-1 flex-grow border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :value="client.admissions[0]?.distinguishing_marks[0]?.height" readonly> <!-- Applied text-xs class -->
          </div>
          <div class="flex items-center">
            <label class="block text-base font-semibold text-gray-700 mr-4">c. Weight:</label> <!-- Reduced font size -->
            <input type="text" class="mt-1 flex-grow border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :value="client.admissions[0]?.distinguishing_marks[0]?.weight" readonly> <!-- Applied text-xs class -->
          </div>
          <div class="flex items-center">
            <label class="block text-base font-semibold text-gray-700 mr-4">d. Colour of Eye:</label> <!-- Reduced font size -->
            <input type="text" class="mt-1 flex-grow border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :value="client.admissions[0]?.distinguishing_marks[0]?.colour_of_eye" readonly> <!-- Applied text-xs class -->
          </div>
          <div class="flex items-center">
            <label class="block text-base font-semibold text-gray-700 mr-4">e. Skin:</label> <!-- Reduced font size -->
            <input type="text" class="mt-1 flex-grow border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :value="client.admissions[0]?.distinguishing_marks[0]?.skin_colour" readonly> <!-- Applied text-xs class -->
          </div>
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-base font-semibold text-gray-700">Put on Documents Submitted:</label> <!-- Reduced font size -->
        <div class="pl-4">
          <div class="flex flex-wrap mb-2">
            <label class="block text-base font-semibold text-gray-700 mr-48">
              <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[0]?.submitted" disabled> SCSR
            </label>
            <label class="block text-base font-semibold text-gray-700 mr-40">
              <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[1]?.submitted" disabled> Court Order
            </label>
            <label class="block text-base font-semibold text-gray-700">
              <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[2]?.submitted" disabled> Medical Certificates
            </label>
          </div>
          <div class="flex flex-wrap">
            <label class="block text-base font-semibold text-gray-700 mr-16">
              <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[3]?.submitted" disabled> Consent from Parents
            </label>
            <label class="block text-base font-semibold text-gray-700 mr-32">
              <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[4]?.submitted" disabled> School Records
            </label>
            <label class="block text-base font-semibold text-gray-700">
              <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[5]?.submitted" disabled> Others
            </label>
          </div>
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-base font-semibold text-gray-700">General impression upon admission:</label> <!-- Reduced font size -->
        <textarea class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-xs" :value="client.admissions[0]?.general_impression" readonly></textarea> <!-- Applied text-xs class -->
      </div>

      <div class="mb-4">
        <label class="block text-base font-semibold text-gray-700">Action Taken:</label> <!-- Reduced font size -->
        <textarea class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-xs" :value="client.admissions[0]?.action_taken" readonly></textarea> <!-- Applied text-xs class -->
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <input type="text" class="mt-1 w-full border-0 border-b border-black focus:ring-0 focus:border-black text-xs" readonly> <!-- Applied text-xs class -->
          <label class="block text-base font-semibold text-gray-700">Name & Signature of Referring Party</label> <!-- Reduced font size -->
        </div>
        <div>
          <input type="text" class="mt-1 w-full border-0 border-b border-black focus:ring-0 focus:border-black text-xs" readonly> <!-- Applied text-xs class -->
          <label class="block text-base font-semibold text-gray-700">Admitting Officer</label> <!-- Reduced font size -->
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <input type="text" class="mt-1 w-full border-0 border-b border-black focus:ring-0 focus:border-black text-xs" readonly> <!-- Applied text-xs class -->
          <label class="block text-base font-semibold text-gray-700">Designation / ID No. / Contact #</label> <!-- Reduced font size -->
        </div>
        <div>
          <input type="text" class="mt-1 w-full border-0 border-b border-black focus:ring-0 focus:border-black text-xs" readonly> <!-- Applied text-xs class -->
          <label class="block text-base font-semibold text-gray-700">Designation</label> <!-- Reduced font size -->
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <input type="text" class="mt-1 w-full border-0 border-b border-black focus:ring-0 focus:border-black text-xs" readonly> <!-- Applied text-xs class -->
          <label class="block text-base font-semibold text-gray-700">Complete Address/Office Address</label> <!-- Reduced font size -->
        </div>
        <div>
          <input type="text" class="mt-1 w-full border-0 border-b border-black focus:ring-0 focus:border-black text-xs" readonly> <!-- Applied text-xs class -->
          <label class="block text-base font-semibold text-gray-700">Date/Time</label> <!-- Reduced font size -->
        </div>
      </div>

      <!--NOTED BY-->
      <div class="border-gray-300 pt-4 text-center text-xs">
        <p class="font-semibold mb-8 text-base">Noted By:</p> <!-- Reduced font size -->
        <p class="font-bold text-lg">ANGELIC B. PAÑA, RSW, MSSW</p> <!-- Reduced font size -->
        <p class="text-xs">Center Head/SWO IV</p> <!-- Reduced font size -->
      </div>
    </div>

    <div class="border-gray-300 ml-6 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        <div class="flex flex-col">
          <p class="ml-24 -mb-4 font-bold">PAGE 1 of 1</p>
          <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
          <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
        </div>
        <div class="ml-4">
          <img src="images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ClientList',
  data() {
    return {
      clients: [],
      id: null
    };
  },
  mounted() {
    this.id = this.$route.params.id;
    this.fetchClientsData();
  },
  watch: {
    '$route.params.id': function(newId) {
      this.id = newId;
      this.fetchClientsData();
    }
  },
  methods: {
    fetchClientsData() {
      axios.get(`/api/clients-data/${this.id}`)
        .then(response => {
          this.clients = response.data.filter(client => client.id === parseInt(this.id));
        })
        .catch(error => {
          console.error('Error fetching client data:', error);
        });
    }
  }
};
</script>

<style scoped>
/* Ensure the form fits within A4 dimensions for printing */
@media print {
  .max-w-7xl {
    max-width: 210mm;
  }
  .p-8 {
    padding: 20mm;
  }
  .mb-12, .mb-8, .mb-6, .mb-4, .mb-2 {
    margin-bottom: 5mm;
  }
  .border-t {
    border-top: 1px solid #d2d2d2;
  }
}
</style>
