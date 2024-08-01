<template>
  <div class="p-4">
    <div class="p-4 bg-white shadow-md rounded-lg">
      <h1 class="text-2xl font-bold mb-4">Clients</h1>
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sex</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Birth</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Place of Birth</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Religion</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="client in clients" :key="client.id">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ client.id }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ client.first_name + ' ' + client.middle_name + ' ' + client.last_name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ client.sex }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ client.date_of_birth }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ client.place_of_birth }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ client.province + ', ' + client.city + ', ' + client.barangay + ', ' + client.street }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ client.religion }}</td>
          </tr>
        </tbody>
      </table>

      <div v-for="client in clients" :key="client.id" class="mt-8">
        <h2 class="text-xl font-bold mb-4">Admissions for {{ client.first_name + ' ' + client.middle_name + ' ' + client.last_name }}</h2>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Court</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Offense</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Admitted</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">General Impression</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="admission in client.admissions ?? []" :key="admission.id">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ admission.committing_court }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ admission.offense_committed }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ admission.date_admitted }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ admission.general_impression }}</td>
            </tr>
          </tbody>
        </table>

        <h3 class="text-lg font-bold mt-4 mb-2">Distinguishing Marks</h3>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tattoo Scars</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Height</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Weight</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Colour of Eye</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skin Colour</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <template v-if="client.admissions">
              <template v-for="admission in client.admissions" :key="admission.id">
                <tr v-if="admission.distinguishing_marks.length" v-for="mark in admission.distinguishing_marks" :key="mark.id">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ mark.tattoo_scars }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ mark.height }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ mark.weight }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ mark.colour_of_eye }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ mark.skin_colour }}</td>
                </tr>
                <tr v-else>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" colspan="5">No distinguishing marks found</td>
                </tr>
              </template>
            </template>
            <tr v-else>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" colspan="5">No admissions found</td>
            </tr>
          </tbody>
        </table>

        <h3 class="text-lg font-bold mt-4 mb-2">Documents</h3>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <template v-if="client.admissions">
              <template v-for="admission in client.admissions" :key="admission.id">
                <tr v-if="admission.documents.length" v-for="document in admission.documents" :key="document.id">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ document.document_name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ document.submitted ? 'Submitted' : 'Not Submitted' }}</td>
                </tr>
                <tr v-else>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" colspan="2">No documents found</td>
                </tr>
              </template>
            </template>
            <tr v-else>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" colspan="2">No admissions found</td>
            </tr>
          </tbody>
        </table>
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
          console.log(response.data); // Add this line to inspect the fetched data
          this.clients = response.data.filter(client => client.Status === 'active');
        })
        .catch(error => {
          console.error('Error fetching client data:', error);
        });
    },
    changeAllStatus() {
      // Iterate over each client and set the Status to 'inactive'
      const updateRequests = this.clients.map(client =>
        axios.patch(`/api/clients/${client.id}`, { Status: 'inactive' })
          .then(response => {
            client.Status = 'inactive';
          })
          .catch(error => {
            console.error(error);
          })
      );

      // Wait for all requests to complete
      Promise.all(updateRequests)
        .then(() => {
          // Remove the clients from the list to only show active clients
          this.clients = this.clients.filter(client => client.Status === 'active');
        });
    }
  }
};
</script>
