<template>
  <div>
    <Head :title="title" />

    <Banner />

    <div >
      <!-- Sidebar -->
      <nav
        :class="{
          'w-64': !isSidebarCollapsed,
          'w-20': isSidebarCollapsed
        }"
        class="fixed bg-[conic-gradient(at_bottom_right,_var(--tw-gradient-stops))] from-blue-700 via-blue-800 to-gray-900 border-r border-gray-100 h-full z-40 transition-all duration-300"
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
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

          <!-- LOGO DSWD -->
          <img
            :class="['p-6 mt-4 mb-4 relative z-10 transition-all duration-300', isSidebarCollapsed ? 'mt-8 h-20 w-28' : 'h-32 w-68']"
            :src="isSidebarCollapsed ? '/images/rrcy.png' : '/images/transparent.png'"
            alt="Logo"
          />

          <!-- Divider Line -->
          <div>
            <hr class="-mt-1 ml-2 mr-2 border-gray-700" />
          </div>

          <!-- Navigation Links -->
          <div class="flex flex-col p-4 space-y-0 mt-2">
            <!-- Dashboard Link with Icon -->
            <div
              :class="{
                'px-0 w-12 h-16 pl-2 -mt-4': isSidebarCollapsed,
                'w-full h-auto': !isSidebarCollapsed
              }"
              class="flex items-center justify-between max-w-lg p-2 rounded-lg transition-transform duration-200 ease-in-out hover:scale-105"
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

            <!-- New Client Link with Icon (conditionally rendered) -->
            <div
              v-if="isSocialServices"
              :class="{
                'px-0 w-12 h-16 pl-2 mt-6 mb-6': isSidebarCollapsed,
                'w-full h-auto': !isSidebarCollapsed
              }"
              class="flex items-center justify-between max-w-lg p-2 rounded-lg transition-transform duration-200 ease-in-out hover:scale-105"
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

            <!-- User Link with Icon -->
            <div
              v-if="isAdmin"
              :class="{
                'px-0 w-12 h-16 pl-2 mt-6 mb-6': isSidebarCollapsed,
                'w-full h-auto': !isSidebarCollapsed
              }"
              class="flex items-center justify-between mb-20 max-w-lg p-2 rounded-lg transition-transform duration-200 ease-in-out hover:scale-105"
            >
              <NavLink
                :href="route('user')"
                :active="route().current('user')"
                class="flex items-center space-x-4 w-full transition duration-150 ease-in-out"
              >
                <!-- User Icon -->
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
                    d="M12 4.5a4.5 4.5 0 100 9 4.5 4.5 0 100-9zm0 12a9 9 0 00-9 9h18a9 9 0 00-9-9z"
                  />
                </svg>
                <span
                  :class="{
                    'hidden': isSidebarCollapsed,
                    'block': !isSidebarCollapsed
                  }"
                  class="transition-opacity duration-300 text-white"
                >
                  User
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
          'ml-0': isSidebarCollapsed
        }"
        class="flex-1 transition-all duration-300"
      >
       <!-- Page Heading -->
        <div class="ml-5 w-full m-0 p-0">
          <header class="w-full py-2 bg-white border shadow-md px-24 sm:px-8 lg:px-16 flex items-center">
            <slot name="header" v-if="$slots.header"></slot>

            <div class="ml-auto -mr-2 h-8 w-8">
              <div class="h-full w-full bg-white rounded-full overflow-hidden">
                <UserProfileImage 
                  :userImage="userImage"
                  :userName="userfName + userSName + usermidName + userSName + userlName"
                />
              </div>
            </div>

            <!-- Add the vertical bar here -->
            <div class="mx-4 ml-8 h-8 border-l border-gray-300"></div> <!-- This is the vertical bar -->

            <div class="flex flex-col items-center -mr-2 mt-1/2 ml-2">
              <ApplicationMark
                :isSidebarCollapsed="isSidebarCollapsed"
                :userName="userfName + userSName + usermidName + userSName + userlName"
                :userImage="userImage"
              />
            </div>

            <!-- Add the small dropdown icon to the right using SVG -->
            <div class="ml-4 -mr-8 mt-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </div>
          </header>
        </div>

        <!-- Page Content -->
        <main class="ml-12"> <!-- Adjust padding to match header height -->
          <slot />
        </main>
      </div>
    </div>

    <!-- Confirm Logout Modal -->
    <ConfirmLogoutModal :show="showModal" @close="showModal = false" @confirm="logout" />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import NavLink from '@/Components/NavLink.vue';
import UserProfileImage from '@/Components/UserProfileImage.vue';
import ConfirmLogoutModal from '@/Components/ConfirmLogoutModal.vue';
import axios from 'axios';

const props = usePage().props;

const userImage = ref(props.auth.user.profile_photo_url || 'images/default.jpg');
const userfName = ref(props.auth.user.fname || 'Default Name');
const userSName = ref( ' ');
const userlName = ref(props.auth.user.lname || 'Default Name');
const usermidName = ref(props.auth.user.middlename || 'Default Name');
const userRole = ref(props.auth.user.role || '(User)');

// Load sidebar state from localStorage
const isSidebarCollapsed = ref(localStorage.getItem('isSidebarCollapsed') === 'true');
const showModal = ref(false);

const toggleSidebar = () => {
  isSidebarCollapsed.value = !isSidebarCollapsed.value;
  // Store the sidebar state in localStorage
  localStorage.setItem('isSidebarCollapsed', isSidebarCollapsed.value);
};

const logout = () => {
  axios.post('/logout')
    .then(response => {
      showModal.value = false;
      console.log(response.data); // Optionally log the response or handle it
      window.location.href = '/login'; // Redirect to the login page after logout
    })
    .catch(error => {
      console.error('Logout failed:', error); // Log the error
    });
};


const isSocialServices = computed(() => userRole.value === 'social services');
const isAdmin = computed(() => userRole.value === 'admin');

// Ensure the sidebar remains collapsed or expanded on page load
onMounted(() => {
  isSidebarCollapsed.value = localStorage.getItem('isSidebarCollapsed') === 'true';
});
</script>
