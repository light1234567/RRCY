<template>
  <div>
    <Head :title="title" />

    <Banner />

    <div class="min-h-screen bg-gradient-to-tr from-slate-50 via-gray-50 to-zinc-50 to-teal-50 flex ">
      <!-- Sidebar -->
      <nav
        :class="{
          '': !isSidebarCollapsed,
          'w-20': isSidebarCollapsed
        }"
        class="fixed bg-customBlue border-r border-gray-100 h-full z-40 transition-all duration-300"
      >
        <div class="flex flex-col h-full relative">
          <!-- Sidebar Toggle Button (Arrow Icon) -->
          <button
            @click="toggleSidebar"
            class="absolute top-4 right-4 text-white focus:outline-none z-50"
          >
            <svg
              v-if="!isSidebarCollapsed"
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 19l-7-7 7-7"
              />
            </svg>
            <svg
              v-if="isSidebarCollapsed"
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5l7 7-7 7"
              />
            </svg>
          </button>

          <!-- UserProfileImage -->
          <div class="flex flex-col items-center p-4 mt-4">
            <UserProfileImage
              :userImage="userImage"
              :userName="userName"
            />
          </div>

          <!-- Application Mark and User Menu -->
          <div class="flex flex-col items-center p-4">
            <ApplicationMark
              :isSidebarCollapsed="isSidebarCollapsed"
              :userName="userName"
              :userRole="userRole"
              :userImage="userImage"
            />
          </div>

           <!-- Divider Line -->
           <div>
              <hr class="mt-8 ml-2 mr-2 border-gray-700" />
            </div>

          <!-- Navigation Links -->
          <div class="flex flex-col p-4 space-y-0 mt-8">
            <!-- Dashboard Link with Icon -->
            <div
              :class="{
                'px-0 w-12 h-16 pl-2 -mt-4': isSidebarCollapsed,
                'w-full h-auto': !isSidebarCollapsed
              }"
              class="flex items-center justify-between max-w-lg p-2 rounded-lg transition-transform duration-200 ease-in-out hover:scale-105"
              @click="changeAllStatus"
            >
              <NavLink
                :href="route('dashboard')"
                :active="route().current('dashboard')"
                class="flex items-center space-x-4 w-full transition duration-150 ease-in-out"
              >
                <!-- Dashboard Icon -->
                <svg
                  :class="{
                    'w-6 h-6': !isSidebarCollapsed,
                    'w-5 h-5': isSidebarCollapsed
                  }"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 12h3v8H3zm6-8h3v16H9zm6 4h3v12h-3zm6-6h3v18h-3z"
                  />
                </svg>
                <span
                  :class="{
                    'hidden': isSidebarCollapsed,
                    'block': !isSidebarCollapsed
                  }"
                  class="transition-opacity duration-300 text-white"
                >
                  Dashboard
                </span>
              </NavLink>
            </div>

            <!-- CICL Link with Icon -->
            <div
              :class="{
                'px-0 w-12 h-16 pl-2 mt-6 mb-6': isSidebarCollapsed,
                'w-full h-auto': !isSidebarCollapsed
              }"
              class="flex items-center justify-between mb-20 max-w-lg p-2 rounded-lg transition-transform duration-200 ease-in-out hover:scale-105"
              @click="changeAllStatus"
            >
              <NavLink
                :href="route('cicl')"
                :active="route().current('cicl')"
                class="flex items-center space-x-4 w-full transition duration-150 ease-in-out"
              >
                <!-- List Icon -->
                <svg
                  :class="{
                    'w-6 h-6': !isSidebarCollapsed,
                    'w-5 h-5': isSidebarCollapsed
                  }"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 7h18M3 12h18m-7 5h7"
                  />
                </svg>
                <span
                  :class="{
                    'hidden': isSidebarCollapsed,
                    'block': !isSidebarCollapsed
                  }"
                  class="transition-opacity duration-300 text-white"
                >
                  CICL
                </span>
              </NavLink>
            </div>

            <!-- New Client Link with Icon -->
            <div
              :class="{
             'px-0 w-12 h-16 pl-2 mt-6 mb-6': isSidebarCollapsed,
                'w-full h-auto': !isSidebarCollapsed
              }"
              class="flex items-center justify-between max-w-lg p-2 rounded-lg transition-transform duration-200 ease-in-out hover:scale-105"
              @click="changeAllStatus"
            >
              <NavLink
                :href="route('new')"
                :active="route().current('new')"
                class="flex items-center space-x-4 w-full transition duration-150 ease-in-out"
              >
                <!-- Add Icon -->
                <svg xmlns="http://www.w3.org/2000/svg"
                  :class="{
                    'w-6 h-6': !isSidebarCollapsed,
                    'w-5 h-5': isSidebarCollapsed
                  }"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 4c2.21 0 4 1.79 4 4s-1.79 4-4 4-4-1.79-4-4 1.79-4 4-4zM5 20h14c.55 0 1-.45 1-1v-1c0-2.67-5.33-4-8-4s-8 1.33-8 4v1c0 .55.45 1 1 1zM20 12h-3v-3h-2v3h-3v2h3v3h2v-3h3z"
                  />
                </svg>
                <span
                  :class="{
                    'hidden': isSidebarCollapsed,
                    'block': !isSidebarCollapsed
                  }"
                  class="transition-opacity duration-300 text-white"
                >
                  New Client
                </span>
              </NavLink>
            </div>

            <!-- Divider Line -->
            <div>
              <hr class="mt-8 ml-2 mr-2 border-gray-700" />
            </div>

            <!-- Logout Button -->
            <div class="w-full max-w-lg p-8 rounded-lg">
              <button
                @click="showModal = true"
                class="-ml-9 flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium text-white focus:outline-none focus:bg-customglue active:bg-customglue transition-transform duration-150 ease-in-out hover:scale-105"
              >
                <!-- Updated SVG Logout Icon -->
                <svg
                  class="w-6 h-6 text-white"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7M3 12a9 9 0 1118 0 9 9 0 01-18 0z"
                  />
                </svg>
                <span
                  class="ml-4 text-white transition-opacity duration-300"
                  :class="{
                    'hidden': isSidebarCollapsed,
                    'block': !isSidebarCollapsed
                  }"
                >
                  Logout
                </span>
              </button>
            </div>

           </div>
           </div>
        
      </nav>

        

      <!-- Main Content -->
      <div
        :class="{
          'ml-44': !isSidebarCollapsed,
          'ml-20': isSidebarCollapsed
        }"
        class="flex-1 transition-all duration-300"
      >
        <!-- Page Heading -->
     
              <div class="w-full m-0 p-0">
        <header class="w-full py-2 bg-white shadow-md px-24 sm:px-8 lg:px-16">
          <slot name="header" v-if="$slots.header"></slot>
          <h2 id="header" class="flex ">
            <img id="header-image-left" src="/images/headerlogo2.png" alt="Left Logo" class="h-12 -ml-4 sm:h-16 lg:h-15 w-auto mr-4" />
            <img id="header-image-right" src="/images/headerlogo.png" alt="Right Logo" class="h-12 sm:h-16 lg:h-15 w-auto" />
          </h2>
        </header>
      </div>

        <!-- Page Content -->
        <main class="pt-24 mt-20"> <!-- Adjust padding to match header height -->
          <slot />
        </main>
      </div>
    </div>

    <!-- Confirm Logout Modal -->
    <ConfirmLogoutModal :show="showModal" @close="showModal = false" @confirm="logout" />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import NavLink from '@/Components/NavLink.vue';
import UserProfileImage from '@/Components/UserProfileImage.vue';
import ConfirmLogoutModal from '@/Components/ConfirmLogoutModal.vue';
import axios from 'axios';

const props = usePage().props;

const userImage = ref(props.auth.user.profile_photo_url || 'images/default.jpg');
const userName = ref(props.auth.user.name || 'Default Name');
const userRole = ref(props.auth.user.role || '(User)');
const isSidebarCollapsed = ref(false);
const showModal = ref(false);

const toggleSidebar = () => {
  isSidebarCollapsed.value = !isSidebarCollapsed.value;
};

const clients = ref([]);

const fetchClients = () => {
  axios.get('/api/clients')
    .then(response => {
      clients.value = response.data.filter(client => client.Status === 'active');
    })
    .catch(error => {
      console.log(error);
    });
};

const changeAllStatus = () => {
  console.log('changeAllStatus triggered');
  const updateRequests = clients.value.map(client =>
    axios.patch(`/api/clients/${client.id}`, { Status: 'inactive' })
      .then(() => {
        client.Status = 'inactive';
      })
      .catch(error => {
        console.log(error);
      })
  );

  Promise.all(updateRequests)
    .then(() => {
      clients.value = clients.value.filter(client => client.Status === 'active');
    });
};

const logout = () => {
  axios.post('/logout')
    .then(() => {
      showModal.value = false;
      window.location.href = '/login'; // Redirect to the login page or any other page after logout
    })
    .catch(error => {
      console.log(error);
    });
};

onMounted(() => {
  fetchClients();
});
</script>

<style scoped>
/* Ensure the sidebar toggle button is always clickable */
.sidebar-button {
  z-index: 50; /* Higher z-index to ensure it's above other elements */
  position: absolute;
  top: 1rem;
  right: 1rem;
  background-color: transparent;
  border: none;
  cursor: pointer;
}
</style>
