<template>
  <div>
    <Head :title="title" />

    <Banner />

    <div class="min-h-screen bg-gray-100 flex">
      <!-- Sidebar -->
      <nav
        :class="{
          'w-64': !isSidebarCollapsed,
          'w-20': isSidebarCollapsed
        }"
        class="fixed bg-custom-blue border-r border-gray-100 h-full z-40 transition-all duration-300"
      >
        <div class="flex flex-col h-full">
          <!-- Sidebar Toggle Button (Arrow Icon) -->
          <button
            @click="toggleSidebar"
            class="absolute top-4 right-4 text-white focus:outline-none"
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

          <!-- Logo -->
          <div class="flex justify-center items-center w-full max-w-lg p-8 shadow-lg rounded-lg">
            <a>
              <ApplicationMark class="block h-25 w-auto" />
            </a>
          </div>

          <!-- Navigation Links -->
          <div class="flex flex-col p-4 space-y-4 mt-8">
            <!-- Dashboard Link with Icon -->
            <div
              :class="{
                'px-0 w-12 h-16 pl-2 mt-6 mb-6': isSidebarCollapsed,
                'w-full h-auto': !isSidebarCollapsed
              }"
              class="flex  items-center justify-between max-w-lg p-8 shadow-lg rounded-lg transition-transform duration-200 ease-in-out hover:scale-105"
            >
              <NavLink
                :href="route('dashboard')"
                :active="route().current('dashboard')"
                class="flex items-center space-x-4"
                @click="handleNavClick('dashboard')"
              >
                <!-- Dashboard Icon -->
                <svg
                  :class="{
                    'w-8 h-8': !isSidebarCollapsed,
                    'w-6 h-6': isSidebarCollapsed
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
                  class="transition-opacity duration-300"
                >
                  Dashboard
                </span>
              </NavLink>
            </div>

            <!-- CICL Link with Icon -->
            <div
              :class="{
                'px-2 w-16 h-16 mt-6 mb-6': isSidebarCollapsed,
                'w-full h-auto': !isSidebarCollapsed
              }"
              class="flex items-center justify-between mb-20 max-w-lg p-8 shadow-lg rounded-lg transition-transform duration-200 ease-in-out hover:scale-105"
            >
              <NavLink
                :href="route('cicl')"
                :active="route().current('cicl')"
                class="flex items-center space-x-4"
                @click="handleNavClick('cicl')"
              >
                <!-- List Icon -->
                <svg
                  :class="{
                    'w-8 h-8': !isSidebarCollapsed,
                    'w-6 h-6': isSidebarCollapsed
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
                  class="transition-opacity duration-300"
                >
                  CICL
                </span>
              </NavLink>
            </div>

            <!-- New Client Link with Icon -->
            <div
              :class="{
                'px-2 w-16 h-16 mt-6': isSidebarCollapsed,
                'w-full h-auto mt-1': !isSidebarCollapsed
              }"
              class="flex items-center justify-between max-w-lg p-8 shadow-lg rounded-lg transition-transform duration-200 ease-in-out hover:scale-105"
            >
              <NavLink
                :href="route('new')"
                :active="route().current('new')"
                class="flex items-center space-x-4"
                @click="handleNavClick('new')"
              >
                <!-- Add Icon -->
                <svg
                  :class="{
                    'w-8 h-8': !isSidebarCollapsed,
                    'w-6 h-6': isSidebarCollapsed
                  }"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 4v16m8-8H4"
                  />
                </svg>
                <span
                  :class="{
                    'hidden': isSidebarCollapsed,
                    'block': !isSidebarCollapsed
                  }"
                  class="transition-opacity duration-300"
                >
                  New Client
                </span>
              </NavLink>
            </div>

            <!-- Edit Link with Icon and Tabs -->
            <div
              :class="{
                'px-0 w-12 h-16 pl-2 mt-6 mb-6': isSidebarCollapsed,
                'w-full h-auto': !isSidebarCollapsed
              }"
              class="flex items-center justify-between max-w-lg p-8 shadow-lg rounded-lg transition-transform duration-200 ease-in-out hover:scale-105"
            >
             
            </div>

          </div>
          <!-- Logout Button -->
          <div class="flex items-center justify-center w-full max-w-lg p-8 shadow-lg rounded-lg mt-auto">
            <button
              @click="logout"
              class="flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-blue-900 hover:text-white shadow-md focus:outline-none focus:bg-blue-400 active:bg-blue-400 transition-transform duration-150 ease-in-out hover:scale-105"
            >
              <!-- Updated SVG Logout Icon with Arrow Right -->
              <svg
                class="w-7 h-7 text-white hover:text-white"
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
                class="ml-2 text-gray-400 hover:text-white transition-opacity duration-300"
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
      </nav>

      <!-- Main Content -->
      <div
        :class="{
          'ml-64': !isSidebarCollapsed,
          'ml-16': isSidebarCollapsed
        }"
        class="flex-1 transition-all duration-300"
      >
        <!-- Page Heading -->
        <header v-if="$slots.header">
          <slot name="header" />
          <h2 id="header" class="w-full py-2 bg-white shadow-md flex items-center justify-end px-4 sm:px-8 lg:px-16">
            <img id="header-image-left" src="images/headerlogo2.png" alt="Left Logo" class="h-12 sm:h-16 lg:h-15 w-auto mr-4" />
            <img id="header-image-right" src="images/headerlogo.png" alt="Right Logo" class="h-12 sm:h-16 lg:h-15 w-auto" />
          </h2>
        </header>

        <!-- Page Content -->
        <main class=""> <!-- Adjust padding to match header height -->
          <slot />
        </main>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import NavLink from '@/Components/NavLink.vue';

const props = defineProps({
  title: String,
});

const isSidebarCollapsed = ref(false);

const toggleSidebar = () => {
  isSidebarCollapsed.value = !isSidebarCollapsed.value;
};

const logout = () => {
  router.post(route('logout'));
};

const handleNavClick = (routeName) => {
  changeAllStatus();
  router.visit(route(routeName));
};

const changeAllStatus = () => {
  // Iterate over each client and set the Status to 'inactive'
  const updateRequests = clients.map(client => 
    axios.patch(`/api/clients/${client.id}`, { Status: 'inactive' })
      .then(response => {
        client.Status = 'inactive';
      })
      .catch(error => {
        console.log(error);
      })
  );

  // Wait for all requests to complete
  Promise.all(updateRequests)
    .then(() => {
      // Remove the clients from the list to only show active clients
      clients = clients.filter(client => client.Status === 'active');
    });
};
</script>

<style scoped>
.bg-custom-blue {
  background-color: #1E3A8A; /* Your custom blue color */
}
</style>
