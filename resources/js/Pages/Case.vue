<template>
    <AppLayout>
      <!-- Client Information -->
      <div v-if="client" class="flex flex-col items-start p-6 bg-gray-100 rounded-lg shadow-lg">
        <!-- Main Client Information -->
        <div class="ml-12">
          <h1 class="text-2xl font-bold text-gray-900">{{ client.first_name }} {{ client.last_name }}</h1>
        </div>
      </div>
      
      <!-- Matching Clients Section -->
      <div v-if="matchingClients.length" class="mt-6 w-full flex justify-center">
        <div class="w-full max-w-3xl">
          <ul class="space-y-4">
            <li
              v-for="(client, index) in matchingClients"
              :key="client.id"
              @click="navigateToCase(client.id)"
              class="bg-white p-6 rounded-lg shadow-lg text-center cursor-pointer hover:bg-gray-200 transition-all"
            >
              <!-- Display "Case X" based on the total length, oldest as Case 1 -->
              <p class="text-sm text-blue-600 font-bold mt-2">Case {{ matchingClients.length - index }}</p>
  
              <p class="text-sm text-gray-700">Child Status: {{ client.child_status }}</p>
              <p class="text-sm text-gray-700 mt-2">
                Case Status: {{ client.admissions.length ? client.admissions[0].case_status : 'N/A' }}
              </p>
              <p class="text-sm text-gray-700 mt-2">
                Offense Committed: {{ client.admissions.length ? client.admissions[0].offense_committed : 'N/A' }}
              </p>
              <p class="text-sm text-gray-700 mt-2">
                Date Admitted: {{ client.admissions.length ? client.admissions[0].date_admitted : 'N/A' }}
              </p>
            </li>
          </ul>
        </div>
      </div>
      <div v-else class="p-6 text-red-500 text-center">No matching clients found.</div>
    </AppLayout>
  </template>
  
  <script>
  import axios from 'axios';
  import AppLayout from '@/Layouts/AppLayout.vue';
  
  export default {
    name: 'ClientDetail',
    components: { AppLayout },
    data: () => ({
      client: null,
      matchingClients: [], // Stores clients with the same first name, last name, and DOB
      clientId: null,
    }),
    mounted() {
      this.clientId = this.$route.params.id;
      if (this.clientId) {
        this.fetchClient(this.clientId);
      } else {
        console.error('Client ID is missing from route params.');
      }
    },
    watch: {
      '$route.params.id': {
        immediate: true,
        handler(newId) {
          this.clientId = newId;
          this.fetchClient(this.clientId);
        },
      },
    },
    methods: {
      async fetchClient(clientId) {
        try {
          const { data } = await axios.get(`/api/clients/${clientId}`);
          this.client = data;
  
          // Once client data is fetched, search for matching clients
          this.fetchMatchingClients(data.first_name, data.last_name, data.date_of_birth);
        } catch (error) {
          console.error('Error fetching client data:', error);
        }
      },
      async fetchMatchingClients(firstName, lastName, dob) {
        try {
          const { data } = await axios.get(
            `/api/test?first_name=${firstName}&last_name=${lastName}&date_of_birth=${dob}`
          );
          
          // Filter out the current client based on ID to avoid duplication
          let matchingClients = data.filter(client => client.id !== this.clientId);
          
          // Sort clients by date_admitted, newest first
          matchingClients.sort((a, b) => {
            const dateA = a.admissions.length ? new Date(a.admissions[0].date_admitted) : new Date(0);
            const dateB = b.admissions.length ? new Date(b.admissions[0].date_admitted) : new Date(0);
            return dateB - dateA; // Sort by newest date_admitted
          });
  
          this.matchingClients = matchingClients;
        } catch (error) {
          console.error('Error fetching matching clients:', error);
        }
      },
      
      // Method to handle navigation to the client details
      navigateToCase(clientId) {
        const resolvedRoute = this.$router.resolve({ name: 'maintab', params: { id: clientId } });
        window.location.href = resolvedRoute.href;
      },
    },
  };
  </script>
  