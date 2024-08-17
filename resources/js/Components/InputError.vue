<script setup>
defineProps({
    message: String,
});
</script>

<template>
    <div v-show="message">
      <p class="text-base text-red-600 font-bold">
        {{ message }}
      </p>
    </div>
  </template>
  
  <style scoped>
  .subtle-glow {
    text-shadow: 0 0 5px rgba(255, 0, 0, 0.5);
    color: rgba(255, 0, 0, 0.85);
  }
  </style>