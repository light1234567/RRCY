<template>
  <div class="w-full ml-20 flex justify-center items-center">
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
      :class="{
        'text-blue-600 border-blue-600 font-bold transform active-page': currentPage === page,
        'hover:transform hover:translate-y-[-2px]': true
      }"
      class="px-3 py-1 border rounded hover:bg-blue-100 transition-transform duration-200 mx-1"
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
  transition: transform 0.2s ease-in-out, border-color 0.2s ease-in-out;
}

.active-page {
  transform: translateY(-2px) scale(1.05);
}

.active-page {
  border-color: currentColor;
}

button:hover:not(.active-page) {
  transform: translateY(-2px);
}
</style>
