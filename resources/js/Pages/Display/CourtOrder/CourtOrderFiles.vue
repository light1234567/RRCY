<template>
  <div class="ml-10 pt-0.5 mr-4 mb-8">
    <!-- Display Folder Creation and Upload Section only when no folder is open -->
    <div v-if="openFolder === null" class="flex space-x-4 mb-6">
      <!-- Folder Creation Section -->
      <div class="folder-creation p-4 bg-white shadow-xs rounded-lg border border-gray-300 w-1/5">
        <h3 class="text-lg font-semibold mb-3 text-gray-800">Create New Folder</h3>
        <button 
          @click="openCreateFolderModal"
          class="text-gray-800 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-200 transition duration-200 text-sm">
          <i class="fas fa-folder-plus mr-2 fa-sm"></i> Create Folder
        </button>
      </div>

      <!-- PDF Upload Section -->
      <div class="pdf-upload p-4 bg-white shadow-xs rounded-lg border border-gray-300 w-1/5">
        <h3 class="text-lg font-semibold mb-3 text-gray-800">Upload PDF File</h3>
        <div class="flex items-center">
          <input type="file" @change="onFileChange" class="hidden" ref="mainFileInput" />
          <button @click="triggerFileInput(false)" class="text-gray-800 px-4 py-2 rounded-lg border hover:bg-gray-200 border-gray-300 transition duration-200 text-sm">
            <i class="fas fa-file-upload mr-2 fa-sm"></i> Choose File
          </button>
        </div>
      </div>
    </div>

    <!-- Modal for Creating Folder -->
    <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white rounded-lg p-6 shadow-lg w-1/3">
        <h4 class="text-lg font-semibold mb-4">Create New Folder</h4>
        <input 
          v-model="newFolderName" 
          placeholder="Enter folder name" 
          class="border border-gray-400 p-1.5 rounded-lg shadow-sm flex-grow text-sm" 
          style="font-size: 0.875rem;" />
        <div class="flex justify-end mt-4">
          <button @click="createFolder" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
            Create
          </button>
          <button @click="isModalOpen = false" class="ml-2 bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-200">
            Cancel
          </button>
        </div>
      </div>
    </div>

    <!-- Display if no files or folders are found -->
    <div v-if="!folders.length && !files.length && !errorMessage" class="text-gray-500 text-sm">
      <p>No files available.</p>
    </div>

    <!-- Folder Display -->
    <div v-if="folders.length" class="folders mb-6">
      <h3 class="text-xl font-semibold mb-4 text-gray-800">Folders:</h3>
      <ul class="grid grid-cols-4 gap-6">
        <li v-for="(folder, index) in folders" :key="index" class="folder-item flex flex-col items-center">
          <div 
            @click="toggleFolder(folder)" 
            :class="['border rounded-lg p-4 transition duration-200 cursor-pointer w-full', openFolder && openFolder.id === folder.id ? 'bg-blue-100 shadow-lg' : 'border-gray-300']"
          >
            <div class="flex items-center space-x-2">
              <i class="fas fa-folder fa-lg text-yellow-600"></i>
              <span class="text-center text-gray-800 font-medium text-sm">{{ folder.name }}</span>
            </div>
          </div>
        </li>
      </ul>
    </div>

    <!-- Folder Contents -->
    <div v-if="openFolder !== null" class="border border-gray-400 p-8 rounded-md folder-content mb-6">
      <button @click="openFolder = null" class="-ml-4 text-gray-700 px-4 py-2 hover:bg-gray-50 rounded-lg mb-4">
        <i class="fas fa-arrow-left"></i> Back
      </button>
      <h3 class="text-xl font-semibold mb-4 text-gray-800">Files in {{ openFolder.name }}:</h3>
   
      <div class="folder-actions flex justify-between mb-4">
        <input type="file" @change="onFileChange($event, openFolder.id)" class="hidden" ref="fileInput" />
        <button @click="triggerFileInput(true)" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-200 text-sm">
          <i class="fas fa-file-upload fa-sm"></i> Upload
        </button>
        <button @click="confirmDeleteFolder(openFolder.id)" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-200 text-sm">
          <i class="fas fa-trash fa-sm"></i> Delete
        </button>
      </div>

      <ul class="space-y-4">
        <template v-if="openFolder.files.length === 0">
          <li class="text-gray-500 text-sm">No files uploaded.</li>
        </template>
        <template v-else>
          <li v-for="(file, i) in openFolder.files" :key="i" class="file-item flex justify-between items-center bg-white p-3 rounded-lg shadow-sm border border-gray-300">
            <i class="fas fa-file-alt text-gray-600 fa-sm"></i>
            <a :href="`/storage/${file.filename}`" target="_blank" class="text-blue-600 hover:underline text-sm">{{ file.filename }}</a>
            <div class="file-actions flex space-x-4">
              <button @click="confirmDeleteFile(openFolder.id, file.filename)" class="text-red-600 text-sm">
                <i class="fas fa-trash fa-sm"></i> Delete
              </button>
              <button @click="openMoveDialog(file.filename)" class="text-blue-600 text-sm">
                <i class="fas fa-exchange-alt fa-sm"></i> Move
              </button>
            </div>
          </li>
        </template>
      </ul>
    </div>

    <!-- Unsorted Files -->
    <div v-if="files.length && openFolder === null" class="unsorted-files">
      <h3 class="text-xl font-semibold mb-6 text-gray-800">Unsorted Files:</h3>
      <ul class="grid grid-cols-3 gap-6">
        <li v-for="(file, index) in files" :key="index" class="file-item bg-white rounded-lg shadow-lg border border-gray-300 p-4 flex flex-col items-center">
          <div class="file-preview mb-4 w-full h-32 flex items-center justify-center overflow-hidden">
            <i class="fas fa-file-pdf fa-3x text-red-600"></i>
          </div>
          <a :href="`/storage/${file.filename}`" target="_blank" class="text-blue-600 hover:underline text-center text-md">{{ file.filename }}</a>
          <div class="file-actions flex space-x-4 mt-3">
            <button @click="confirmDeleteFile(null, file.filename)" class="text-red-600 text-md">
              <i class="fas fa-trash"></i> Delete
            </button>
            <button @click="openMoveDialog(file.filename)" class="text-blue-600 text-md">
              <i class="fas fa-exchange-alt"></i> Move
            </button>
          </div>
        </li>
      </ul>
    </div>

    <!-- Success/Error Modal -->
    <div v-if="modalVisible" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white rounded-lg p-6 shadow-lg w-1/3">
        <h4 class="text-lg font-semibold mb-4">
          <i class="fas" :class="modalTitle === 'Error' ? 'fa-exclamation-circle text-red-600' : 'fa-check-circle text-green-600'"></i>
          {{ modalTitle }}
        </h4>
        <p>{{ modalMessage }}</p>
        <div class="flex justify-end mt-4">
          <button @click="modalVisible = false" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Close</button>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="deleteModalVisible" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white rounded-lg p-6 shadow-lg w-1/3">
        <h4 class="text-lg font-semibold mb-4">
          <i class="fas fa-trash text-red-600"></i> Confirm Deletion
        </h4>
        <p>Are you sure you want to delete this {{ isFolder ? 'folder' : 'file' }}?</p>
        <div class="flex justify-end mt-4">
          <button @click="deleteConfirmed" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Delete</button>
          <button @click="deleteModalVisible = false" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 ml-2">Cancel</button>
        </div>
      </div>
    </div>

    <!-- File Move Dialog -->
    <div v-if="moveDialogVisible" class="move-dialog bg-white rounded-lg shadow-lg p-4">
      <div>
        <h4 class="text-lg font-semibold">Select Destination Folder for {{ fileToMove }}</h4>
        <select v-model="destinationFolder" class="border border-gray-400 p-2 rounded-lg w-full mt-2">
          <option v-for="folder in folders" :key="folder.id" :value="folder.id">
            {{ folder.name }}
          </option>
        </select>
        <div class="dialog-actions mt-4">
          <button @click="confirmMove" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
            Move
          </button>
          <button @click="cancelMove" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-200">
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      clientId: null,
      folders: [],
      files: [],
      newFolderName: '',
      openFolder: null,
      moveDialogVisible: false,
      fileToMove: '',
      destinationFolder: '',
      pdfFile: null,
      modalVisible: false,
      modalTitle: '',
      modalMessage: '',
      deleteModalVisible: false,
      deleteItemId: null,
      isFolder: false,
      isModalOpen: false, // New data property for modal visibility
    };
  },
  mounted() {
    this.clientId = this.$route.params.id;
    if (this.clientId) {
      this.fetchFoldersAndFiles();
    }
  },
  watch: {
    '$route.params.id': function(newId) {
      this.clientId = newId;
      if (this.clientId) {
        this.fetchFoldersAndFiles();
      }
    }
  },
  methods: {
    async fetchFoldersAndFiles() {
      try {
        const response = await axios.get(`/api/folders-and-files/${this.clientId}`);
        this.folders = response.data.folders;
        this.files = response.data.files;
      } catch (error) {
        this.modalTitle = 'Error';
        this.modalMessage = 'Error fetching folders and files: ' + (error.response?.data?.message || error.message);
        this.modalVisible = true;
      }
    },
    triggerFileInput(isFolder = false) {
      if (isFolder && this.openFolder) {
        this.$refs.fileInput.click();
      } else {
        this.$refs.mainFileInput.click();
      }
    },
    toggleFolder(folder) {
      this.openFolder = this.openFolder && this.openFolder.id === folder.id ? null : folder;
    },
    openCreateFolderModal() {
      this.isModalOpen = true; // Open the modal when the button is clicked
    },
    async createFolder() {
      if (!this.newFolderName) {
        this.modalTitle = 'Error';
        this.modalMessage = 'Folder name cannot be empty.';
        this.modalVisible = true;
        return;
      }
      try {
        await axios.post('/api/create-folder', {
          name: this.newFolderName,
          client_id: this.clientId,
        });
        this.newFolderName = '';
        this.fetchFoldersAndFiles();
        this.modalTitle = 'Success';
        this.modalMessage = 'Folder created successfully!';
        this.modalVisible = true;
        this.isModalOpen = false; // Close the modal after creating the folder
      } catch (error) {
        this.modalTitle = 'Error';
        this.modalMessage = 'Error creating folder: ' + (error.response?.data?.message || error.message);
        this.modalVisible = true;
      }
    },
    confirmDeleteFolder(folderId) {
      this.deleteItemId = folderId;
      this.isFolder = true;
      this.deleteModalVisible = true;
    },
    confirmDeleteFile(folderId, fileName) {
      this.deleteItemId = fileName;
      this.isFolder = false;
      this.deleteModalVisible = true;
    },
    async deleteConfirmed() {
      if (this.isFolder) {
        await this.deleteFolder(this.deleteItemId);
        this.openFolder = null; // Automatically go back to the main view
      } else {
        await this.deleteFile(null, this.deleteItemId);
      }
      this.deleteModalVisible = false;
    },
    async deleteFolder(folderId) {
      try {
        await axios.post('/api/delete-folder', {
          id: folderId,
          client_id: this.clientId,
        });
        this.fetchFoldersAndFiles();
        this.modalTitle = 'Success';
        this.modalMessage = 'Folder deleted successfully!';
        this.modalVisible = true;
      } catch (error) {
        this.modalTitle = 'Error';
        this.modalMessage = 'Error deleting folder: ' + (error.response?.data?.message || error.message);
        this.modalVisible = true;
      }
    },
    async deleteFile(folderId, fileName) {
      try {
        await axios.post('/api/delete-file', {
          folderId,
          fileName,
          client_id: this.clientId,
        });
        this.fetchFoldersAndFiles();
        this.modalTitle = 'Success';
        this.modalMessage = 'File deleted successfully!';
        this.modalVisible = true;
      } catch (error) {
        this.modalTitle = 'Error';
        this.modalMessage = 'Error deleting file: ' + (error.response?.data?.message || error.message);
        this.modalVisible = true;
      }
    },
    onFileChange(e, folderId = null) {
      this.pdfFile = e.target.files[0];
      this.uploadFile(folderId);
    },
    async uploadFile(folderId) {
      if (!this.pdfFile) {
        this.modalTitle = 'Error';
        this.modalMessage = 'Please select a file to upload.';
        this.modalVisible = true;
        return;
      }
      let formData = new FormData();
      formData.append('pdf', this.pdfFile);
      formData.append('client_id', this.clientId);
      if (folderId) {
        formData.append('folder_id', folderId);
      }
      try {
        const response = await axios.post('/api/upload', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });

        if (folderId) {
          const folder = this.folders.find(folder => folder.id === folderId);
          if (folder) {
            folder.files.push({ filename: response.data.filename });
          }
        } else {
          this.files.push({ filename: response.data.filename });
        }

        this.modalTitle = 'Success';
        this.modalMessage = 'File uploaded successfully!';
        this.modalVisible = true;
      } catch (error) {
        this.modalTitle = 'Error';
        this.modalMessage = 'Error uploading file: ' + (error.response?.data?.message || error.message);
        this.modalVisible = true;
      }
    },
    openMoveDialog(fileName) {
      this.fileToMove = fileName;
      this.moveDialogVisible = true;
    },
    async confirmMove() {
      if (!this.destinationFolder) {
        this.modalTitle = 'Error';
        this.modalMessage = 'Please select a destination folder.';
        this.modalVisible = true;
        return;
      }

      try {
        await axios.post('/api/move-file', {
          fileName: this.fileToMove,
          destinationFolder: this.destinationFolder,
          client_id: this.clientId,
        });

        if (this.openFolder === null) {
          this.files = this.files.filter(file => file.filename !== this.fileToMove);
        } else {
          const oldFolder = this.folders.find(folder => folder.id === this.openFolder.id);
          if (oldFolder) {
            oldFolder.files = oldFolder.files.filter(file => file.filename !== this.fileToMove);
          }
        }

        const newFolder = this.folders.find(folder => folder.id === this.destinationFolder);
        if (newFolder) {
          newFolder.files.push({ filename: this.fileToMove });
        }

        this.cancelMove();
        this.modalTitle = 'Success';
        this.modalMessage = 'File moved successfully!';
        this.modalVisible = true;
      } catch (error) {
        this.modalTitle = 'Error';
        this.modalMessage = 'Error moving file: ' + (error.response?.data?.message || error.message);
        this.modalVisible = true;
      }
    },
    cancelMove() {
      this.moveDialogVisible = false;
      this.fileToMove = '';
      this.destinationFolder = '';
    },
  },
};
</script>

<style scoped>
.file-manager {
  max-width: 1200px;
  margin: 0 auto;
}

.folder-item {
  text-align: center;
  cursor: pointer;
}

.folder-item:hover {
  background-color: #f3f4f6;
  border-radius: 8px;
}

.folder-actions,
.file-actions {
  display: flex;
  gap: 0.5rem;
}

.file-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

button {
  transition: background-color 0.3s ease;
}
</style>
