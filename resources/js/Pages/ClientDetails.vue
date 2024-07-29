<template>
  <AppLayout title="Client Details">
    <template #header>
      <!-- Optional header content here -->
    </template>

    <div v-if="client" class="ml-64 p-4">
      <h1>Client Details</h1>
      <img :src="client.profilePicture || 'default-profile.png'" alt="Profile Picture" class="profile-picture" />
      <p><strong>Client ID:</strong> {{ client.id }}</p>
      <p><strong>Client Name:</strong> {{ client.name }}</p>
      <p><strong>Email:</strong> {{ client.email }}</p>
      <p><strong>Phone Number:</strong> {{ client.phone }}</p>
      <p><strong>Date of Birth:</strong> {{ client.dob }}</p>
      
      <div class="sector-services" v-if="client.sectors && client.sectors.length > 0">
        <h2 class="text-lg font-semibold">Services Required</h2>
        <ul>
          <li v-for="sector in client.sectors" :key="sector">{{ sector }}</li>
        </ul>
      </div>
      
      <button @click="goBack" class="mt-2 p-2 bg-blue-500 text-white rounded">Back</button>
    </div>
    
    <p v-else>Loading...</p> <!-- Display loading message while fetching data -->
  </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';

const route = useRoute();
const router = useRouter();
const client = ref(null);

onMounted(async () => {
  try {
    const response = await axios.get(`/api/clients/${route.params.id}`);
    client.value = response.data;
  } catch (error) {
    console.error('Error fetching client details:', error);
  }
});

const goBack = () => {
  router.push('/');
};
</script>

<style scoped>
.profile-info {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.profile-picture {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  object-fit: cover;
}

.sector-services {
  margin-top: 2rem;
}

.sector-services ul {
  list-style-type: disc;
  padding-left: 2rem;
}

.sector-services li {
  margin-bottom: 0.5rem;
}

/* Sidebar styling */
.bg-gray-800 {
  background-color: #2d3748; /* Sidebar background color */
}

.text-white {
  color: #edf2f7; /* Text color */
}

.hover\:text-gray-400:hover {
  color: #e2e8f0; /* Hover color */
}
</style>
