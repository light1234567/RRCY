<template>
  <AppLayout title="ClientDetails"> 
    <template #header>
      <!-- Header content here -->
    </template>

    <template #sidebar>
      <div class="bg-gray-800 text-white w-64 h-full fixed top-0 left-0 p-4">
        <ul>
          <li class="py-2">
            <router-link to="/" class="hover:text-gray-400">Dashboard</router-link>
          </li>
          <li class="py-2">
            <router-link to="/cicl" class="hover:text-gray-400">CICL List</router-link>
          </li>
          <li class="py-2">
            <router-link to="/settings" class="hover:text-gray-400">Settings</router-link>
          </li>
          <!-- Add more sidebar items as needed -->
        </ul>
      </div>
    </template>

    <div class="ml-64 p-4">
      <div v-if="client" class="profile-info">
        <img :src="client.profilePicture" alt="Profile Picture" class="profile-picture" />
        <div>
          <p><strong>Client ID:</strong> {{ client.id }}</p>
          <p><strong>Client Name:</strong> {{ client.name }}</p>
          <p><strong>Email:</strong> {{ client.email }}</p>
          <p><strong>Phone Number:</strong> {{ client.phone }}</p>
          <p><strong>Date of Birth:</strong> {{ client.dob }}</p>
        </div>
      </div>
      
      <div class="sector-services" v-if="client.sectors.length > 0">
        <h2>Services Required</h2>
        <ul>
          <li v-for="sector in client.sectors" :key="sector">{{ sector }}</li>
        </ul>
      </div>
      <p v-if="!client">Loading...</p> <!-- Display loading message while fetching data -->
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import AppLayout from '@/Layouts/AppLayout.vue';

const route = useRoute();
const client = ref(null); // Start with null until data is fetched

// Fetch client details based on the ID from the route
onMounted(async () => {
  const clientId = route.params.id;
  try {
    const response = await fetch(`/api/clients/${clientId}`); // Ensure this URL is correct
    if (response.ok) {
      client.value = await response.json();
    } else {
      console.error('Failed to fetch client details:', response.statusText);
    }
  } catch (error) {
    console.error('Failed to fetch client details:', error);
  }
});
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
.sidebar {
  width: 16rem; /* Adjust width as needed */
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  background-color: #2d3748; /* Sidebar background color */
  color: #edf2f7; /* Text color */
  padding: 1rem;
}

.sidebar ul {
  list-style-type: none;
  padding: 0;
}

.sidebar li {
  padding: 0.5rem 0;
}

.sidebar a {
  color: #edf2f7;
  text-decoration: none;
}

.sidebar a:hover {
  color: #e2e8f0;
}
</style>
