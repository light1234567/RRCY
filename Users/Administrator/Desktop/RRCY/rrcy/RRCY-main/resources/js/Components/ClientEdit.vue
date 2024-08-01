<template>
    <div>
      <h1>Edit Client</h1>
      <form @submit.prevent="updateClient">
        <div>
          <label for="name">Name:</label>
          <input v-model="client.name" type="text" id="name" />
        </div>
        <div>
          <label for="crimeStatus">Crime Status:</label>
          <input v-model="client.crimeStatus" type="text" id="crimeStatus" />
        </div>
        <button type="submit">Save</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  import axios from 'axios';
  
  const route = useRoute();
  const router = useRouter();
  const client = ref({});
  
  const fetchClient = async () => {
    try {
        const response = await axios.get(`/api/clients/${route.params.id}`);
        client.value = response.data; // Ensure this contains the correct data
    } catch (error) {
        console.error('Error fetching client:', error);
    }
};

onMounted(fetchClient);

  
const updateClient = async () => {
    try {
        await axios.put(`/api/clients/${route.params.id}`, client.value);
        router.push({ name: 'ClientDetails', params: { id: route.params.id } });
    } catch (error) {
        console.error('Error updating client:', error);
        alert('Failed to update client information.');
    }
};

  
  onMounted(fetchClient);
  </script>
  