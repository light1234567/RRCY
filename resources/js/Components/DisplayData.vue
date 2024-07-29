<template>
    <div class="p-6 max-w-3xl mx-auto">
      <h1 class="text-3xl font-bold mb-6 text-gray-800">Form Data</h1>
      <pre>{{ formData }}</pre>
    </div>
  </template>
  
  <script>
  export default {
    props: ['form'],
    data() {
      return {
        formData: JSON.parse(this.form || '{}') // Parse the form data
      };
    }
  };
  </script>
  