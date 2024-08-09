<script>
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import socialservice from './socialservice.vue';

import { usePage } from '@inertiajs/vue3';

export default {
  name: 'NewClient',
  components: {
    AppLayout,
    socialservice,
  },
  data() {
    return {
      tabs: [
        'Social Service',
        'Psychological Reports',
        'Court Order',
        'Homelife Services',
        'Nursing Care',
        'Educational Services',
        'PSD Reports',
      ],
      user: {
        role: '', // Role will be set dynamically
      },
    };
  },
  computed: {
    availableTabs() {
      switch (this.user.role) {
        case 'social services':
          return ['Social Service'];
        case 'psychological':
          return ['Psychological Reports'];
        case 'court order':
          return ['Court Order'];
        case 'homelife services':
          return ['Homelife Services'];
        case 'nursing care':
          return ['Nursing Care'];
        case 'educational services':
          return ['Educational Services'];
        case 'psd':
          return ['PSD Reports'];
        default:
          return this.tabs;
      }
    },
  },
  mounted() {
    const { props } = usePage();
    this.user.role = props.auth.user.role || '(User)'; // Set user role from Inertia props
  },
};
</script>

<style scoped>
.header-container {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  background-color: white;
  z-index: 10;
  padding: 10px 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.header-title {
  font-size: 1.5rem;
  font-weight: bold;
  text-align: left;
}

.tabs-container {
  position: fixed;
  top: 60px;
  /* Adjust according to header height */
  left: 0;
  right: 0;
  background-color: white;
  z-index: 10;
  padding: 10px 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.tabs {
  display: flex;
  gap: 10px;
}

.tabs button {
  padding: 10px;
  cursor: pointer;
}

.tabs button.active {
  background-color: #007bff;
  color: white;
}

.content-container {
  padding-top: 120px;
  /* Adjust according to header and tabs height */
}

.tab-content {
  margin-top: 20px;
}

.centered-big-text {
  font-size: 3rem;
  font-weight: bold;
  text-align: center;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh; /* Full viewport height */
}
</style>

<template>
  <AppLayout>
    <template #header>
      <!-- Header content -->
    </template>
    <div>
      <!-- Tabs Content -->
      <div>
        <div v-if="user.role === 'social services'">
          <socialservice></socialservice>
        </div>
        <div v-if="user.role === 'psychological'" class="centered-big-text">
          Ulol hahahaha
        </div>
        <div v-if="user.role === 'court order'" class="centered-big-text">
          Ulol hahahaha
        </div>
        <div v-if="user.role === 'homelife services'" class="centered-big-text">
          Ulol hahahaha
        </div>
        <div v-if="user.role === 'nursing care'" class="centered-big-text">
          Ulol hahahaha
        </div>
        <div v-if="user.role === 'educational services'" class="centered-big-text">
          Ulol hahahaha
        </div>
        <div v-if="user.role === 'psd'" class="centered-big-text">
          Ulol hahahaha
        </div>
      </div>
    </div>
  </AppLayout>
</template>
