<template>
  <AppLayout title="Users">
    <template #header>
      <div class="ml-5 w-2 h-6 bg-gray-400 mr-3"></div>
      <h1 class="ml-5 text-lg font-bold text-red-800">User Verification</h1>
    </template>
    <div v-if="loading" class="flex justify-center items-center py-10">Loading...</div>
    <div v-else>
      <div class="overflow-x-auto mr-6 ml-12 px-0">
        <table class="min-w-full mt-8 bg-gray-50 shadow rounded-lg">
          <thead class="bg-gray-100 text-customBlue">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Full Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Role</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Last Login</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Last Logout</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in filteredUsers" :key="user.id" class="border border-gray-200 hover:bg-gray-300">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 flex items-center">
                <div class="flex-shrink-0 h-7 w-7 bg-customBlue rounded-full flex items-center justify-center mr-4 text-white text-[11px]">
                  {{ getInitials(user.full_name) }}
                </div>
                {{ user.full_name }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ user.role }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ user.email }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <span :class="user.status === 'verified' ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold'">
                  {{ user.status }}
                </span>
                <!-- Switch styled button -->
                <div class="mt-2 flex space-x-4">
                  <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" @click="toggleVerification(user)" :checked="user.status === 'verified'" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ user.status === 'verified' ? 'Verified' : 'Unverified' }}</span>
                  </label>
                  <button @click="openDeleteModal(user)" class="text-red-700 hover:text-red-900 font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ user.login_at ? new Date(user.login_at).toLocaleString() : 'Never' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ user.logout_at ? new Date(user.logout_at).toLocaleString() : 'Never' }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Delete Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
        <div class="flex items-center mb-4">
          <!-- SVG trash icon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
          <h3 class="text-lg font-semibold">Confirm Deletion</h3>
        </div>
        <p>Are you sure you want to delete <strong>{{ selectedUser.full_name }}</strong>?</p>
        <div class="mt-6 flex justify-end space-x-4">
          <button @click="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Confirm</button>
          <button @click="closeDeleteModal" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>


<script setup>
import { ref, computed, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';

const users = ref([]);
const loading = ref(true);
const showDeleteModal = ref(false);
const selectedUser = ref(null);

const fetchUsers = async () => {
  try {
    const response = await axios.get('/api/users');
    users.value = response.data;
  } catch (error) {
    console.error('Error fetching users:', error);
  } finally {
    loading.value = false;
  }
};

const filteredUsers = computed(() => {
  return users.value.filter(user => user.role !== 'admin');
});

const getInitials = (name) => {
  return name.split(' ').map(n => n[0]).join('').toUpperCase();
};

// Function to toggle user verification status
const toggleVerification = async (user) => {
  try {
    const newStatus = user.status === 'verified' ? 'unverified' : 'verified';
    await axios.patch(`/api/users/${user.id}/toggle-verify`, { status: newStatus });
    user.status = newStatus;
  } catch (error) {
    console.error('Error toggling verification status:', error);
  }
};

const openDeleteModal = (user) => {
  selectedUser.value = user;
  showDeleteModal.value = true;
};

const closeDeleteModal = () => {
  showDeleteModal.value = false;
  selectedUser.value = null;
};

const confirmDelete = async () => {
  if (selectedUser.value) {
    try {
      await axios.delete(`/api/users/${selectedUser.value.id}`);
      users.value = users.value.filter(user => user.id !== selectedUser.value.id);
      closeDeleteModal();
    } catch (error) {
      console.error('Error deleting user:', error);
    }
  }
};

onMounted(fetchUsers);
</script>

<style scoped>
.modal-overlay {
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  
  z-index: 1000;
}

.modal-content {
  background: white;
  padding: 24px;
  border-radius: 8px;
  max-width: 500px;
  width: 100%;
}

.modal-actions {
  margin-top: 20px;
  display: flex;
  justify-content: flex-end;
}
</style>
