<template>
    <div class="relative flex items-center">
      <!-- Display user image if available -->
      <img v-if="userImage" :src="userImage" alt="User Image" class="w-20 h-20 mt-12 rounded-full cursor-pointer" @click="toggleDropdown" />
      <!-- Display initials if no image is provided -->
      <div v-else class="w-12 h-12 flex items-center justify-center bg-gray-300 rounded-full cursor-pointer" @click="toggleDropdown">
        <span class="text-xl font-semibold text-white">{{ userInitials }}</span>
      </div>
  
      <!-- Dropdown Content -->
      <div v-if="isOpen" ref="dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
        <div class="block py-2 text-xs text-gray-400">Manage Account</div>
  
        <DropdownLink :href="route('profile.show')">Profile</DropdownLink>
  
        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
          API Tokens
        </DropdownLink>
  
        <div class="border-t border-gray-200"></div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, onMounted, onUnmounted } from 'vue';
  import DropdownLink from '@/Components/DropdownLink.vue';

  
  // Define props
  const props = defineProps({
    userImage: String,
    userName: String
  });
  
  // Define local state for dropdown
  const isOpen = ref(false);
  
  // Compute user initials
  const userInitials = computed(() => {
    if (props.userName) {
      const names = props.userName.split(' ');
      return names.map(name => name.charAt(0)).join('');
    }
    return '';
  });
  
  // Toggle dropdown visibility
  const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
  };
  
  // Handle clicks outside the dropdown
  const handleClickOutside = (event) => {
    const dropdownContainer = document.querySelector('[ref="dropdown"]');
    if (dropdownContainer && !dropdownContainer.contains(event.target)) {
      isOpen.value = false;
    }
  };
  
  onMounted(() => {
    document.addEventListener('click', handleClickOutside);
  });
  
  onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
  });
  </script>
  
  <style scoped>
  /* Add any additional styling here */
  </style>
  