<template>
  <div class="relative">
    <!-- User Name and Role Section -->
    <div v-if="!isSidebarCollapsed" class="text-center ml-2 text-bold truncate">
      <div
        :class="{
          'text-[4px]': isSidebarCollapsed,
          'text-[14px]': !isSidebarCollapsed,
          'text-blue-500': isSidebarCollapsed,
          'text-gray-600': !isSidebarCollapsed
        }"
        class="font-bold cursor-pointer -mb-1.5"
        @click="toggleDropdown"
      >
        {{ userName }}
      </div>
      <div
        :class="{
          'text-[4px]': isSidebarCollapsed,
          'text-[12px]': !isSidebarCollapsed,
          'text-blue-400': isSidebarCollapsed,
          'text-gray-400': !isSidebarCollapsed
        }"
        class="pt-1 cursor-pointer"
        @click="toggleDropdown"
      >
        {{ userRole }}
      </div>
    </div>

    <!-- Dropdown Content -->
    <div v-if="isDropdownOpen" ref="dropdown" class="absolute -ml-12 mt-2 w-48 bg-[conic-gradient(at_bottom_right,_var(--tw-gradient-stops))] from-blue-700 via-blue-800 to-gray-900 rounded-md shadow-lg z-10">
      <div class="block px-4 py-2 text-xs text-white">Manage Account</div>

      <DropdownLink :href="route('profile.show')" class="">
        Profile
      </DropdownLink>


      <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
        API Tokens
      </DropdownLink>

      <div class="border-t border-gray-200"></div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import DropdownLink from '@/Components/DropdownLink.vue';

const props = defineProps({
  userImage: String,
  isSidebarCollapsed: Boolean,
  userName: String,
  userRole: String,
});

const isDropdownOpen = ref(false);

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value;
};

const handleClickOutside = (event) => {
  const dropdown = document.querySelector('[ref="dropdown"]');
  if (dropdown && !dropdown.contains(event.target)) {
    isDropdownOpen.value = false;
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
