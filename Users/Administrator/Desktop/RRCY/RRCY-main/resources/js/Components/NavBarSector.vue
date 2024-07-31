<template>
    <nav class="flex items-center justify-between bg-gray-800 p-4 shadow-md">
      <div class="flex items-center space-x-4">
        <NavLink
          :href="route('edit.tab1')"
          :active="route().current('edit.tab1')"
          class="text-white hover:bg-gray-700 px-4 py-2 rounded transition-colors duration-300"
        >
          <span>Psychological</span>
        </NavLink>
        <NavLink
          :href="route('edit.tab2')"
          :active="route().current('edit.tab2')"
          class="text-white hover:bg-gray-700 px-4 py-2 rounded transition-colors duration-300"
        >
          <span>PSD</span>
        </NavLink>
        <NavLink
          :href="route('edit.tab3')"
          :active="route().current('edit.tab3')"
          class="text-white hover:bg-gray-700 px-4 py-2 rounded transition-colors duration-300"
        >
          <span>Nursing Care</span>
        </NavLink>
      </div>
    </nav>
  </template>
  
  <script setup>
  import { Head, router } from '@inertiajs/vue3';
  import NavLink from '@/Components/NavLink.vue';
  </script>
  