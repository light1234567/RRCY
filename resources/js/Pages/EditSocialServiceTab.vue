<template>
  <div class="p-8 bg-white shadow-xl rounded-lg max-w-4xl mx-auto my-8 border border-gray-200">
    <div class="flex justify-between items-center mb-6">
      <img src="path-to-your-logo.png" alt="Logo" class="h-16">
      <div class="text-center">
        <h2 class="text-xl font-bold">DSWD</h2>
        <p class="text-sm">Field Office XI - Davao Region</p>
      </div>
      <div class="text-right">
        <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
      </div>
    </div>
    <h1 class="text-3xl font-extrabold mb-6 text-center text-blue-600">ADMISSION SLIP</h1>

    <div v-for="client in clients" :key="client.id" class="mb-12 p-6 bg-gray-50 rounded-lg shadow-lg">
      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-lg font-semibold text-gray-700">Name:</label>
          <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.first_name + ' ' + client.middle_name + ' ' + client.last_name" readonly>
        </div>
        <div>
          <label class="block text-lg font-semibold text-gray-700">Sex:</label>
          <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.sex" readonly>
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-lg font-semibold text-gray-700">Address:</label>
        <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.province + ', ' + client.city + ', ' + client.barangay + ', ' + client.street" readonly>
      </div>

      <div class="mb-4">
        <label class="block text-lg font-semibold text-gray-700">Religion:</label>
        <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.religion" readonly>
      </div>

      <div class="mb-4">
        <label class="block text-lg font-semibold text-gray-700">Date/Place of Birth:</label>
        <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.date_of_birth + ' / ' + client.place_of_birth" readonly>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-lg font-semibold text-gray-700">Committing Court:</label>
          <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.admissions[0]?.committing_court" readonly>
        </div>
        <div>
          <label class="block text-lg font-semibold text-gray-700">Crim. Case #:</label>
          <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.admissions[0]?.crim_case_number" readonly>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-lg font-semibold text-gray-700">Offense Committed:</label>
          <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.admissions[0]?.offense_committed" readonly>
        </div>
        <div>
          <label class="block text-lg font-semibold text-gray-700">Date admitted to Center:</label>
          <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.admissions[0]?.date_admitted" readonly>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-lg font-semibold text-gray-700">No. of Days in Jail:</label>
          <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.admissions[0]?.days_in_jail" readonly>
        </div>
        <div>
          <label class="block text-lg font-semibold text-gray-700">No. of Days in Detention Center:</label>
          <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.admissions[0]?.days_in_detention_center" readonly>
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-lg font-semibold text-gray-700">Distinguishing Marks:</label>
        <div class="grid grid-cols-2 gap-4 pl-4">
          <div>
            <label class="block text-lg font-semibold text-gray-700">a. Tattoo/Scars:</label>
            <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.admissions[0]?.distinguishing_marks[0]?.tattoo_scars" readonly>
          </div>
          <div>
            <label class="block text-lg font-semibold text-gray-700">b. Height:</label>
            <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.admissions[0]?.distinguishing_marks[0]?.height" readonly>
          </div>
          <div>
            <label class="block text-lg font-semibold text-gray-700">c. Weight:</label>
            <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.admissions[0]?.distinguishing_marks[0]?.weight" readonly>
          </div>
          <div>
            <label class="block text-lg font-semibold text-gray-700">d. Colour of Eye:</label>
            <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.admissions[0]?.distinguishing_marks[0]?.colour_of_eye" readonly>
          </div>
          <div>
            <label class="block text-lg font-semibold text-gray-700">e. Skin:</label>
            <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.admissions[0]?.distinguishing_marks[0]?.skin_colour" readonly>
          </div>
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-lg font-semibold text-gray-700">Put on Documents Submitted:</label>
        <div class="pl-4">
          <label class="block text-lg font-semibold text-gray-700">
            <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[0]?.submitted" disabled> SCSR
          </label>
          <label class="block text-lg font-semibold text-gray-700">
            <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[1]?.submitted" disabled> Court Order
          </label>
          <label class="block text-lg font-semibold text-gray-700">
            <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[2]?.submitted" disabled> Medical Certificates
          </label>
          <label class="block text-lg font-semibold text-gray-700">
            <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[3]?.submitted" disabled> Consent from Parents
          </label>
          <label class="block text-lg font-semibold text-gray-700">
            <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[4]?.submitted" disabled> School Records
          </label>
          <label class="block text-lg font-semibold text-gray-700">
            <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[5]?.submitted" disabled> Others
          </label>
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-lg font-semibold text-gray-700">General impression upon admission:</label>
        <textarea class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.admissions[0]?.general_impression" readonly></textarea>
      </div>

      <div class="mb-4">
        <label class="block text-lg font-semibold text-gray-700">Action Taken:</label>
        <textarea class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="client.admissions[0]?.action_taken" readonly></textarea>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-lg font-semibold text-gray-700">Name & Signature of Referring Party:</label>
          <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly>
        </div>
        <div>
          <label class="block text-lg font-semibold text-gray-700">Admitting Officer:</label>
          <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-lg font-semibold text-gray-700">Designation / ID No. / Contact #:</label>
          <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly>
        </div>
        <div>
          <label class="block text-lg font-semibold text-gray-700">Designation:</label>
          <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly>
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-lg font-semibold text-gray-700">Complete Address/Office Address:</label>
        <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-lg font-semibold text-gray-700">Noted By:</label>
          <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly>
        </div>
        <div>
          <label class="block text-lg font-semibold text-gray-700">Date/Time:</label>
          <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly>
        </div>
      </div>
    </div>

    <div class="border-t border-gray-300 pt-4 mt-8 text-center text-sm">
      <p class="font-semibold">Noted By:</p>
      <p class="font-bold text-lg">ANGELIC B. PAÑA, RSW, MSSW</p>
      <p class="text-sm">Center Head/SWO IV</p>
      <p class="mt-4">PAGE 1 of 1</p>
      <p>DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
      <p>Email: rrxy.fo11@dswd.gov.ph Tel. No.: 293-0306</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ClientList',
  data() {
    return {
      clients: []
    };
  },
  mounted() {
    this.fetchClientsData();
  },
  methods: {
    fetchClientsData() {
      axios.get('/api/clients-data')
        .then(response => {
          this.clients = response.data.filter(client => client.Status === 'active');
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
