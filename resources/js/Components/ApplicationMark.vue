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
