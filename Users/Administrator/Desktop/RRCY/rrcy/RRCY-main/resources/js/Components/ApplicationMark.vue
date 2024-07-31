<template>
  
  <div class="relative mt-4" ref="dropdownContainer">
    <button
      @click="toggleDropdown"
      class="flex flex-col items-center text-sm border-2 border-transparent rounded-full focus:outline-none transition-transform duration-200 ease-in-out hover:scale-105"
    >
      <img
        v-if="userImage"
        :class="isSidebarCollapsed ? 'h-10 w-10' : 'h-16 w-16'"
        class="rounded-full object-cover mb-2"
        :src="userImage"
        :alt="userName"
      />
      <div v-if="userImage && !isSidebarCollapsed" class="text-white text-center truncate">
        <div class="text-l font-medium pt-1">{{ userName }}</div>
        <div class="text-xs text-gray-400 pt-1">{{ userRole }}</div>
      </div>
      <span v-else-if="!userImage && !isSidebarCollapsed" class="inline-flex rounded-md">
        <button
          type="button"
          class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition-transform duration-200 ease-in-out hover:scale-105"
        >
          {{ userName }}
          <span class="ml-2 text-gray-500 text-sm">{{ userRole }}</span>
          <svg
            class="ms-2 -me-0.5 h-4 w-4"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
          </svg>
        </button>
      </span>
    </button>

    <!-- Dropdown Content -->
    <div v-if="isOpen" ref="dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
      <div class="block px-4 py-2 text-xs text-gray-400">Manage Account</div>

      <DropdownLink :href="route('profile.show')">Profile</DropdownLink>

      <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
        API Tokens
      </DropdownLink>

      <div class="border-t border-gray-200"></div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { usePage, router } from '@inertiajs/vue3';

const { props } = usePage();

const userImage = ref(props.auth.user.profile_photo_url || 'images/default.jpg');
const userName = ref(props.auth.user.name || 'Default Name');
const userRole = ref(props.auth.user.role || '(User)');
const isOpen = ref(false);

onMounted(() => {
  // Add event listener to handle clicks outside the dropdown
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  // Remove event listener to avoid memory leaks
  document.removeEventListener('click', handleClickOutside);
});

const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
};

const handleClickOutside = (event) => {
  const dropdownContainer = document.querySelector('[ref="dropdownContainer"]');
  if (dropdownContainer && !dropdownContainer.contains(event.target)) {
    isOpen.value = false;
  }
};

const logout = () => {
  router.post(route('logout'));
};
</script>
