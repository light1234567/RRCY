<script>
 import AppLayout from '@/Layouts/AppLayout.vue';
 import socialservice from './socialservice.vue'

  
  export default {
    name: 'NewClient',
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
  .header-container {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  background-color: white;
  z-index: 10;
  padding: 10px 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.header-title {
  font-size: 1.5rem;
  font-weight: bold;
  text-align: left;
}

.tabs-container {
  position: fixed;
  top: 60px; /* Adjust according to header height */
  left: 0;
  right: 0;
  background-color: white;
  z-index: 10;
  padding: 10px 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

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
  
  .content-container {
  padding-top: 120px; /* Adjust according to header and tabs height */
}

  .tab-content {
    margin-top: 20px;
  }
  
  </style>

  <template>
    <AppLayout>
        
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-start p-3 ">
                New Client
            </h2>
            <div class="tabs ">
              <button v-for="(tab, index) in tabs" :key="index" :class="{ active: currentTab === index }" @click="currentTab = index">
                {{ tab }}
              </button>
           </div>
        </template>
      <div class="">
        <!-- Tabs Navigation -->
        
  
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
  
  