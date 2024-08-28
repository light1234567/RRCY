<template>
  <AppLayout title="Users">
    <template #header>
      <h1 class="ml-0 text-lg font-bold  text-red-800">User Verification</h1>
    </template>
    <div v-if="loading" class="flex justify-center items-center py-10">Loading...</div>
    <div v-else>
      <div class="overflow-x-auto mr-6 ml-12 px-0">
        <table class="min-w-full  mt-8 bg-gray-50 shadow rounded-lg">
          <thead class="bg-gray-100 text-customBlue">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Full Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Role</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in filteredUsers" :key="user.id" class="border broder-gray-200 hover:bg-gray-300">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 flex items-center">
                <!-- Profile Image or Initials -->
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
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <button
                  @click="openDeleteModal(user)"
                  class="text-red-700 hover:text-red-900 font-semibold"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>

                <button
                  @click="openVerifyModal(user)"
                  v-if="user.status !== 'verified'"
                  class="ml-4 text-green-700 hover:text-green-900 font-semibold"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                  </svg>
                </button>

              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Verify Modal -->
    <div v-if="showVerifyModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
        <div class="flex items-center mb-4">
          <!-- SVG check icon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
          <h3 class="text-lg font-semibold">Confirm Verification</h3>
        </div>
        <p>Are you sure you want to verify <strong>{{ selectedUser.full_name }}</strong>?</p>
        <div class="mt-6 flex justify-end space-x-4">
          <button @click="confirmVerify" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Confirm
          </button>
          <button @click="closeVerifyModal" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            Cancel
          </button>
        </div>
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
          <button @click="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
            Confirm
          </button>
          <button @click="closeDeleteModal" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            Cancel
          </button>
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
const showVerifyModal = ref(false);
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

const openVerifyModal = (user) => {
  selectedUser.value = user;
  showVerifyModal.value = true;
};

const closeVerifyModal = () => {
  showVerifyModal.value = false;
  selectedUser.value = null;
};

const confirmVerify = async () => {
  if (selectedUser.value) {
    try {
      await axios.patch(`/api/users/${selectedUser.value.id}/verify`);
      selectedUser.value.status = 'verified';
      closeVerifyModal();
    } catch (error) {
      console.error('Error verifying user:', error);
    }
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
  justify-content: center;
  align-items: center;
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
