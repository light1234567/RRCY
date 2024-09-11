<template>
  <AppLayout>
    <!-- Client Information -->
    <div v-if="client" class="flex flex-col items-start p-6 bg-gray-100 rounded-lg shadow-lg">
      <!-- Main Client Information -->
      <div class="ml-12 flex">
        <img
          :src="client.profile_image ? `/storage/${client.profile_image}` : defaultImage"
          alt="Client Profile Image"
          class="w-32 h-32 rounded-full border mr-6"
        />
        <div>
          <h1 class="text-2xl font-bold text-gray-900">{{ client.first_name }} {{ client.last_name }}</h1>
          <p class="text-lg text-gray-700">Age: {{ calculateAge(client.date_of_birth) }} years old</p>
          <p class="text-lg text-gray-700">Address: {{ formattedAddress }}</p>
        </div>
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

    <!-- No matching clients found -->
    <div v-else class="p-6 text-red-500 text-center">No matching clients found.</div>
  </AppLayout>
</template>

<script>
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';

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

    // Format address for matching clients
    formatAddress(client) {
      const { street, barangay, city, province } = client;
      return `${street || ''} ${barangay || ''} ${city || ''} ${province || ''}`.trim();
    },

    // Navigate to another client case
    navigateToCase(clientId) {
      const resolvedRoute = this.$router.resolve({ name: 'maintab', params: { id: clientId } });
      window.location.href = resolvedRoute.href;
    },
  },
};
</script>

<style scoped>
.flex {
  display: flex;
}
.border-b {
  border-bottom: 1px solid #ddd;
}
.py-2 {
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
}
.px-8 {
  padding-left: 2rem;
  padding-right: 2rem;
  text-align: center;
}
.focus\:outline-none {
  outline: none;
}
.border-blue-500 {
  border-color: #3b82f6;
}
.text-blue-500 {
  color: #3b82f6;
}
.text-gray-500 {
  color: #6b7280;
}
.p-4 {
  padding: 1rem;
}
.tab-content {
  padding: 20px;
  border: 1px solid #ddd;
  border-top: none;
}
</style>
