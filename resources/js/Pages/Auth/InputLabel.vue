<template>
    <div class="relative group">
      <label :for="for" class="block text-sm font-medium text-gray-700">
        <span class="absolute top-0 left-0 transform -translate-y-1/2 transition-transform duration-300 group-hover:translate-y-0">
          {{ value }}
        </span>
        <span class="block mt-1">{{ value }}</span>
      </label>
    </div>
  </template>
  
  <script setup>
  const props = defineProps({
    for: String,
    value: String
  });
  </script>
  
  <style scoped>
  .group {
    position: relative;
  }
  
  .group label {
    position: relative;
    display: block;
  }
  
  .group label span:first-child {
    position: absolute;
    top: -0.75rem; /* Adjust this based on your design */
    left: 0;
    font-size: 0.75rem;
    color: gray;
    transition: transform 0.3s;
  }
  </style>