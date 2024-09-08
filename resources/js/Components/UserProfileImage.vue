<template>
  <div class="relative flex items-center">
    <!-- Display user image if available with Tailwind background color -->
    <div v-if="userImage" 
         class="w-20 h-20 border border-customBlue -mt-4 rounded-full cursor-pointerflex items-center justify-center overflow-hidden" 
         @click="toggleDropdown">
      <img :src="userImage" alt="User Image" class="h-full w-full object-cover rounded-full" />
    </div>
    
    <!-- Display initials if no image is provided -->
    <div v-else class="w-10 h-10 flex items-center justify-center bg-blue-900 rounded-full cursor-pointer" @click="toggleDropdown">
      <span class="text-md mb-2 font-semibold text-white">{{ userInitials }}</span>
    </div>

    <!-- Dropdown Content 
    <div v-if="isOpen" ref="dropdown" class="absolute mt-2 w-48 bg-white rounded-md shadow-lg z-10">
      <div class="block py-2 text-xs text-gray-400">Manage Account</div>

      <DropdownLink :href="route('profile.show')">Profile</DropdownLink>

      <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
        API Tokens
      </DropdownLink>

      <div class="border-t border-gray-200"></div>
    </div>-->
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import DropdownLink from '@/Components/DropdownLink.vue';

// Define props
const props = defineProps({
 
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
/* Tailwind classes used directly in the template */
</style>
