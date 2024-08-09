<template>
    <div class="flex justify-center space-x-2 mt-4">
      <button 
        @click="prevPage" 
        :disabled="currentPage === 1" 
        class="px-3 py-1 border rounded hover:bg-blue-100 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        «
      </button>
      <button 
        v-for="page in totalPages" 
        :key="page" 
        @click="goToPage(page)" 
        :class="{'text-blue-600 font-bold': currentPage === page}" 
        class="px-3 py-1 border rounded hover:bg-blue-100"
      >
        {{ page }}
      </button>
      <button 
        @click="nextPage" 
        :disabled="currentPage === totalPages" 
        class="px-3 py-1 border rounded hover:bg-blue-100 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        »
      </button>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      totalPages: {
        type: Number,
        required: true
      },
      currentPage: {
        type: Number,
        required: true
      }
    },
    methods: {
      prevPage() {
        if (this.currentPage > 1) {
          this.$emit('update:currentPage', this.currentPage - 1);
          console.log('Prev page', this.currentPage - 1); // Debug log
        }
      },
      nextPage() {
        if (this.currentPage < this.totalPages) {
          this.$emit('update:currentPage', this.currentPage + 1);
          console.log('Next page', this.currentPage + 1); // Debug log
        }
      },
      goToPage(page) {
        this.$emit('update:currentPage', page);
        console.log('Go to page', page); // Debug log
      }
    }
  };
  </script>
  
  <style scoped>
  button {
    min-width: 40px;
  }
  </style>
  