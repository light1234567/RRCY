<script>
 import AppLayout from '@/Layouts/AppLayout.vue';
 import socialservice from './socialservice.vue'

  
  export default {
    name: 'CICL',
    components: {
      AppLayout, socialservice
    },
    data() {
      return {
        currentTab: 0,
        tabs: ['Social Service', 'Psychological Reports', 'Court Order', 'Homelife Services', 'Nursing Care', 'Educational Services', 'PSD Reports']
      };
    }
  };
  </script>
  
  <style scoped>
  .tabs {
    display: flex;
    gap: 10px;
  }
  
  .tabs button {
    padding: 10px;
    cursor: pointer;
  }
  
  .tabs button.active {
    background-color: #007bff;
    color: white;
  }
  
  .tab-content {
    margin-top: 20px;
  }
  </style>

  <template>
    <AppLayout>
        
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-end">
                New Client
            </h2>
        </template>
      <div>
        <!-- Tabs Navigation -->
        <div class="tabs">
          <button v-for="(tab, index) in tabs" :key="index" :class="{ active: currentTab === index }" @click="currentTab = index">
            {{ tab }}
          </button>
        </div>
  
        <!-- Tabs Content -->
        <div >
          <div v-if="currentTab === 0 ">
             <socialservice></socialservice>
          </div>
          <div v-if="currentTab === 1">
            sss
          </div>
          <div v-if="currentTab === 2">
            
          </div>
          <div v-if="currentTab === 3">
            
          </div>
          <div v-if="currentTab === 4">
           
          </div>
          <div v-if="currentTab === 5">
            
          </div>
          <div v-if="currentTab === 6">
            
          </div>
        </div>
      </div>
    </AppLayout>
  </template>
  
  