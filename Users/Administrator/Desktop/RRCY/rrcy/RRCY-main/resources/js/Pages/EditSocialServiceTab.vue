

<template>
    <div class="p-4">

    </div>
    <div class="p-4 bg-white shadow-md rounded-lg">
      <h1 class="text-2xl font-bold mb-4">Clients</h1>
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sex</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Birth</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Religion</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Occupation</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="client in clients" :key="client.id">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ client.id }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ client.name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ client.sex }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ client.address }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ client.date_of_birth }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ client.religion }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ client.occupation }}</td>
          </tr>
        </tbody>
      </table>
    </div>

</template>

<script>
import axios from 'axios';

export default {
  name: 'Psychological',
  data() {
    return {
      clients: []
    }
  },
  mounted() {
    this.fetchClients();
  },
  methods: {
    fetchClients() {
      axios.get('/api/clients')
        .then(response => {
          // Filter clients based on Status
          this.clients = response.data.filter(client => client.Status === 'active');
        })
        .catch(error => {
          console.log(error);
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
            console.log(error);
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
}
</script>

   