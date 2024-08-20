<template>
  <AppLayout title="Users">
    <div v-if="loading">Loading...</div>
    <div v-else>
      <table>
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Role</th>
            <th>Email</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in filteredUsers" :key="user.id">
            <td>{{ user.full_name }}</td>
            <td>{{ user.role }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.status }}</td>
            <td>
              <button @click="openDeleteModal(user)">Delete</button>
              <button @click="openVerifyModal(user)" v-if="user.status !== 'verified'">Accept</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Verify Modal -->
    <div v-if="showVerifyModal" class="modal-overlay">
      <div class="modal-content">
        <h3>Confirm Verification</h3>
        <p>Are you sure you want to verify <strong>{{ selectedUser.full_name }}</strong>?</p>
        <div class="modal-actions">
          <button @click="confirmVerify" class="btn btn-success">Yes, Verify</button>
          <button @click="closeVerifyModal" class="btn btn-secondary">Cancel</button>
        </div>
      </div>
    </div>

    <!-- Delete Modal -->
    <div v-if="showDeleteModal" class="modal-overlay">
      <div class="modal-content">
        <h3>Confirm Deletion</h3>
        <p>Are you sure you want to delete <strong>{{ selectedUser.full_name }}</strong>?</p>
        <div class="modal-actions">
          <button @click="confirmDelete" class="btn btn-danger">Yes, Delete</button>
          <button @click="closeDeleteModal" class="btn btn-secondary">Cancel</button>
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

// Fetch all users from the API
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

// Computed property to filter out admin users
const filteredUsers = computed(() => {
  return users.value.filter(user => user.role !== 'admin');
});

// Function to open the verify modal
const openVerifyModal = (user) => {
  selectedUser.value = user;
  showVerifyModal.value = true;
};

// Function to close the verify modal
const closeVerifyModal = () => {
  showVerifyModal.value = false;
  selectedUser.value = null;
};

// Function to verify user (change status to "verified")
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

// Function to open the delete modal
const openDeleteModal = (user) => {
  selectedUser.value = user;
  showDeleteModal.value = true;
};

// Function to close the delete modal
const closeDeleteModal = () => {
  showDeleteModal.value = false;
  selectedUser.value = null;
};

// Function to delete user
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
table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
}

th {
  background-color: #f2f2f2;
  text-align: left;
}

button {
  padding: 5px 10px;
  background-color: #e3342f;
  color: white;
  border: none;
  cursor: pointer;
}

button:hover {
  background-color: #cc1f1a;
}

button + button {
  margin-left: 10px;
  background-color: #38c172;
}

button + button:hover {
  background-color: #1f9d55;
}

/* Modal styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  max-width: 500px;
  width: 100%;
}

.modal-actions {
  margin-top: 20px;
  display: flex;
  justify-content: flex-end;
}

.btn {
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  font-size: 14px;
}

.btn-success {
  background-color: #38c172;
  color: white;
}

.btn-danger {
  background-color: #e3342f;
  color: white;
}

.btn-secondary {
  background-color: #6c757d;
  color: white;
  margin-left: 10px;
}
</style>
