<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';

const stats = ref([
    { title: "Total Users", value: 1200, icon: "👥" },
    { title: "New Orders", value: 150, icon: "🛒" },
    { title: "Revenue", value: "$34,000", icon: "💰" },
    { title: "Pending Tasks", value: 8, icon: "📋" }
]);
</script>

<style scoped>
html, body {
  height: 100%;
  margin: 0;
}

.main-content {
  padding: 20px;
  background-color: #f3f4f6;
}

.card {
  background: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  margin-bottom: 20px;
  text-align: center;
}

.card-icon {
  font-size: 2rem;
}

.card-title {
  font-size: 1.2rem;
  font-weight: bold;
}

.card-value {
  font-size: 1.5rem;
  color: #4b5563;
}
</style>

<template>
    <AppLayout title="Dashboard">
        <template #header>
        <h1 class="text-xl font-bold ml-12 text-red-800">Dashboard</h1>
      </template>
      
      <!-- Main Content -->
      <div class="main-content">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <div v-for="stat in stats" :key="stat.title" class="card">
            <div class="card-icon">{{ stat.icon }}</div>
            <div class="card-title">{{ stat.title }}</div>
            <div class="card-value">{{ stat.value }}</div>
          </div>
        </div>
        <!-- Additional content can be added here, like charts, tables, etc. -->
      </div>
    </AppLayout>
</template>
