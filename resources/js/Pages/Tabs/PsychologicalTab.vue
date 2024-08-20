<template>
  <div class="flex flex-col justify-center items-center min-h-screen">
    <div class="flex flex-col justify-center items-center w-full">
      <h1 class="mt-2 text-customBlue mb-1 text-lg italic">Select a Form:</h1>
      <div class="relative w-1/4">
        <select 
          v-model="currentTab" 
          class="block w-full py-2 text-md border rounded-lg shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
        >
          <option 
            v-for="(tab, index) in tabs" 
            :key="index" 
            :value="tab"
          >
            {{ tab }}
          </option>
        </select>
      </div>
    </div>
    <div class="p-4 w-full">
      <div v-if="currentTab === 'Intervention Plan'"><InterventionPlan :id="paramId"/></div>
      <div v-if="currentTab === 'IPA Format'"><IPAFORMAT :id="paramId"/></div>
      <div v-if="currentTab === 'Progress Notes'"><Progressnotes :id="paramId"/></div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import InterventionPlan from '../Display/Psychological/InterventionPlan.vue';
import IPAFORMAT from '../Display/Psychological/IPAFORMAT.vue';
import Progressnotes from '../Display/Psychological/Progressnotes.vue';

export default {
  components: {
    InterventionPlan,
    IPAFORMAT,
    Progressnotes
  },
  data() {
    return {
      tabs: [
        'Intervention Plan',
        'IPA Format',
        'Progress Notes'
      ],
      currentTab: 'Intervention Plan', // Default tab value
      isDropdownOpen: false,
      paramId: null, // Initialize the parameter ID
    };
  },
  methods: {
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    },
    selectTab(tab) {
      this.currentTab = tab;
      this.isDropdownOpen = false;
    }
  },
  mounted() {
    // Fetch the param ID from the route
    this.paramId = this.$route.params.id;

    document.addEventListener('click', (e) => {
      if (!e.target.closest('.relative')) {
        this.isDropdownOpen = false;
      }
    });
  },
  beforeUnmount() {
    document.removeEventListener('click', this.handleClickOutside);
  },
};
</script>

<style scoped>
/* Add any additional styles here */
.text-customBlue {
  color: #1c3d5a; /* Adjust this to your custom blue color */
}
</style>
