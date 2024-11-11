<template>
  <div v-if="show" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50" @click.self="closeModal">
    <!-- Modal Container with Arial font -->
    <div class="bg-white p-6 rounded shadow-lg max-w-lg w-full z-60 brightness-125 relative" style="font-family: Arial, sans-serif;">
      <div class="text-left">
        <h2 class="text-xl font-semibold">Details</h2>
      </div>

      <!-- Close 'X' Button -->
      <button class="absolute top-2 right-2 text-red-500 hover:text-red-900 focus:outline-none text-3xl font-bold" @click="closeModal">
        <span aria-hidden="true">&times;</span>
      </button>

      <!-- Modal Content: Display Log Details -->
      <div class="modal-content max-h-[80vh] overflow-y-auto p-2">
        <ul>
          <li v-for="(value, key) in parseChanges(log.changes)" :key="key" class="inline-details">
            <strong>{{ key }}:</strong> {{ value }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>


  
  
  
  
  <script setup>
  import { ref } from 'vue';
  
  const props = defineProps({
    show: {
      type: Boolean,
      required: true,
    },
    log: {
      type: Object,
      required: true,
    },
  });
  
  const emit = defineEmits(['close']);
  const isResizing = ref(false);
  const startX = ref(0), startY = ref(0), initialWidth = ref(0), initialHeight = ref(0);
  
  // Parse changes string into an object
  const parseChanges = (changes) => {
    try {
      return JSON.parse(changes);
    } catch (error) {
      return {}; 
    }
  };
  
  // Close modal by emitting close event
  const closeModal = () => {
    emit('close');
  };
  
  // Start resizing function
  const startResizing = (event) => {
    isResizing.value = true;
    startX.value = event.clientX;
    startY.value = event.clientY;
    initialWidth.value = props.log.width || 300;
    initialHeight.value = props.log.height || 32;
  
    document.addEventListener('mousemove', resizeBox);
    document.addEventListener('mouseup', stopResizing);
  };
  
  // Resize the details box
  const resizeBox = (event) => {
    if (!isResizing.value) return;
    props.log.width = initialWidth.value + (event.clientX - startX.value);
    props.log.height = initialHeight.value + (event.clientY - startY.value);
  };
  
  // Stop resizing
  const stopResizing = () => {
    isResizing.value = false;
    document.removeEventListener('mousemove', resizeBox);
    document.removeEventListener('mouseup', stopResizing);
  };
  </script>

<style scoped>
/* Ensures that the modal content is flexible, allowing the content to expand vertically */
.modal-content {
  position: relative;
  width: 100%;
  height: auto; /* Allow height to expand based on content */
  overflow-y: auto; /* Enable scrolling if content overflows */
  max-height: 80vh; /* Limit the height to 80% of the viewport height */
  padding: 1rem;
}

/* 'X' Close Button Styling */
button[aria-hidden="true"] {
  font-size: 1.5rem;
  line-height: 1;
}

/* Make sure inline details are properly styled */
.inline-details {
  display: block; /* Changed from inline-block to block to make sure content wraps correctly */
  margin-bottom: 0.5rem; /* Prevent text from sticking together */
  word-wrap: break-word; /* Ensure text wraps within the container */
}

/* Apply Arial font to the entire modal */
.modal-content, .modal-container {
  font-family: Arial, sans-serif;
}
</style>

