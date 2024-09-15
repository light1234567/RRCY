<template>
  <AppLayout>
    <template #header>
      <div class="flex items-center">
        <div class="w-2 h-6 bg-gray-400 mr-3"></div>
        <i class="fa fa-users  text-black text-2xl ml-6"></i> 
        <h1 class="text-lg ml-4 font-bold text-red-800">CICL Cases</h1>
      </div>
    </template>
    <!-- Container for Main Client Information -->
    <div class="w-full max-w-6xl mx-auto mt-6 space-y-6">
      <!-- Main Client Information -->
      <div
        v-if="client"
        class="flex items-center justify-between p-6 bg-white border border-gray-200 rounded-lg shadow-lg"
      >
        <!-- Left: Client Image and Details -->
        <div class="flex items-center space-x-6">
          <img
            :src="client.profile_image ? `/storage/${client.profile_image}` : defaultImage"
            alt="Client Profile Image"
            class="w-24 h-24 rounded-full object-cover border-4 border-blue-500"
          />
          <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ client.first_name }} {{ client.last_name }}</h1>
            <div class="mt-2 text-gray-700 space-y-1">
              <p class="text-sm"><span class="font-semibold">Age:</span> {{ calculateAge(client.date_of_birth) }} years old</p>
              <p class="text-sm"><span class="font-semibold">Address:</span> {{ formattedAddress }}</p>
              <p class="text-sm"><span class="font-semibold">Status:</span> {{ client.child_status }}</p>
            </div>
          </div>
        </div>
        <!-- Right: Recent Case Label -->
        <div class="text-right">
          <p class="text-lg font-semibold text-blue-600 uppercase">Recent Case</p>
        </div>
      </div>

      <!-- Clients Table -->
      <div v-if="matchingClients.length" class="w-full">
        <!-- Table for matching clients -->
        <div class="overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-lg">
          <table class="min-w-full bg-white">
            <thead>
              <tr class="bg-blue-100">
                <th class="p-4 text-left text-sm font-bold text-blue-900">Case #</th>
                <th class="p-4 text-left text-sm font-bold text-blue-900">Child Status</th>
                <th class="p-4 text-left text-sm font-bold text-blue-900">Case Status</th>
                <th class="p-4 text-left text-sm font-bold text-blue-900">Date Admitted</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(client, index) in matchingClients"
                :key="client.id"
                @click="navigateToCase(client.id)"
                class="border-t border-gray-200 hover:bg-blue-50 transition-all duration-300 cursor-pointer"
              >
                <td class="p-4 text-sm text-blue-600 font-bold">Case {{ matchingClients.length - index }}</td>
                <td class="p-4 text-sm text-gray-700">{{ client.child_status }}</td>
                <td class="p-4 text-sm text-gray-700">{{ client.admissions.length ? client.admissions[0].case_status : 'N/A' }}</td>
                <td class="p-4 text-sm text-gray-700">{{ client.admissions.length ? client.admissions[0].date_admitted : 'N/A' }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- No matching clients found -->
      <div v-else class="p-6 text-red-500 text-center text-lg font-semibold">No matching clients found.</div>
    </div>
  </AppLayout>
</template>

<script>
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import '@fortawesome/fontawesome-free/css/all.css';


export default {
  name: 'ClientDetail',
  components: { AppLayout },
  data() {
    return {
      client: null, // Main client data
      matchingClients: [], // Stores clients with matching first name, last name, and DOB
      clientId: null, // The client ID from route params
      defaultImage: 'https://via.placeholder.com/150', // Placeholder image if no profile image is available
    };
  },
  computed: {
    // Combine address components into a full address string
    formattedAddress() {
      if (!this.client) return '';
      const { street, barangay, city, province } = this.client;
      return `${street || ''} ${barangay || ''} ${city || ''} ${province || ''}`.trim();
    }
  },
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
    // Fetch individual client data
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

    // Fetch clients with matching first name, last name, and DOB
    async fetchMatchingClients(firstName, lastName, dob) {
      try {
        const { data } = await axios.get(
          `/api/test?first_name=${firstName}&last_name=${lastName}&date_of_birth=${dob}`
        );

        // Filter out the current client from the matching clients
        const matchingClients = data.filter(client => client.id !== this.clientId);

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

    // Method to calculate age from date of birth
    calculateAge(dob) {
      const birthDate = new Date(dob);
      const today = new Date();
      let age = today.getFullYear() - birthDate.getFullYear();
      const monthDiff = today.getMonth() - birthDate.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      return age;
    },

    // Navigate to another client case
    navigateToCase(clientId) {
      const resolvedRoute = this.$router.resolve({ name: 'maintab', params: { id: clientId } });
      window.location.href = resolvedRoute.href;
    },
  },
};
</script>

