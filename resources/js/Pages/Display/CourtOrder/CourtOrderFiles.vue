<template>
    <div class="file-manager p-4">
      <h2 class="text-xl font-bold mb-4">Court Order Files for Client {{ clientId }}</h2>
  
      <!-- Error message -->
      <div v-if="errorMessage" class="alert alert-danger mb-4 bg-red-500 text-white p-3 rounded">
        <i class="fas fa-exclamation-circle"></i> {{ errorMessage }}
      </div>
  
      <!-- Success message -->
      <div v-if="successMessage" class="alert alert-success mb-4 bg-green-500 text-white p-3 rounded">
        <i class="fas fa-check-circle"></i> {{ successMessage }}
      </div>
  
      <!-- Folder Creation Form -->
      <div class="folder-creation flex items-center mb-4">
        <input v-model="newFolderName" placeholder="New folder name" class="border p-2 rounded" />
        <button @click="createFolder" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          <i class="fas fa-folder-plus"></i> Create Folder
        </button>
      </div>
  
      <!-- PDF Upload Section -->
      <div class="pdf-upload flex items-center mb-4">
        <input type="file" @change="onFileChange" class="hidden" ref="mainFileInput" />
        <button @click="triggerFileInput(false)" class="ml-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
          <i class="fas fa-file-upload"></i> Upload File
        </button>
      </div>
  
      <!-- Display if no files or folders are found -->
      <div v-if="!folders.length && !files.length && !errorMessage">
        <p class="text-gray-500">No files available.</p>
      </div>
  
      <!-- Folder Display -->
      <div v-if="folders.length" class="folders mb-4">
        <h3 class="text-lg font-semibold mb-2">Folders:</h3>
        <ul class="grid grid-cols-4 gap-4">
          <li v-for="(folder, index) in folders" :key="index" class="folder-item flex flex-col items-center">
            <button @click="toggleFolder(folder)" class="flex items-center space-x-2">
              <i class="fas fa-folder fa-3x text-yellow-500"></i>
              <span class="mt-2">{{ folder.name }}</span>
            </button>
          </li>
        </ul>
      </div>
  
      <!-- Folder Contents -->
      <div v-if="openFolder !== null" class="folder-content mb-4">
        <h3 class="text-lg font-semibold mb-2">Files in {{ openFolder.name }}:</h3>
        <div class="folder-actions flex justify-between mb-4">
          <input type="file" @change="onFileChange($event, openFolder.id)" class="hidden" ref="fileInput" />
          <button @click="triggerFileInput(true)" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            <i class="fas fa-file-upload"></i> Upload
          </button>
          <button @click="deleteFolder(openFolder.id)" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
            <i class="fas fa-trash"></i> Delete Folder
          </button>
        </div>
        <ul class="space-y-2">
          <li v-for="(file, i) in openFolder.files" :key="i" class="file-item flex justify-between items-center">
            <i class="fas fa-file-alt"></i>
            <a :href="`/storage/${file.filename}`" target="_blank" class="text-blue-600 hover:underline">{{ file.filename }}</a> <!-- View file link -->
            <div class="file-actions flex space-x-2">
              <button @click="deleteFile(openFolder.id, file.filename)" class="text-red-500">
                <i class="fas fa-trash"></i> Delete
              </button>
              <button @click="openMoveDialog(file.filename)" class="text-blue-500"> <!-- Open move dialog -->
                <i class="fas fa-exchange-alt"></i> Move
              </button>
            </div>
          </li>
        </ul>
      </div>
  
      <!-- Unsorted Files -->
      <div v-if="files.length && openFolder === null" class="unsorted-files">
        <h3 class="text-lg font-semibold mb-2">Unsorted Files:</h3>
        <ul class="space-y-2">
          <li v-for="(file, index) in files" :key="index" class="file-item flex justify-between items-center">
            <i class="fas fa-file-alt"></i>
            <a :href="`/storage/${file.filename}`" target="_blank" class="text-blue-600 hover:underline">{{ file.filename }}</a> <!-- View file link -->
            <div class="file-actions flex space-x-2">
              <button @click="deleteFile(null, file.filename)" class="text-red-500">
                <i class="fas fa-trash"></i> Delete
              </button>
              <button @click="openMoveDialog(file.filename)" class="text-blue-500"> <!-- Open move dialog -->
                <i class="fas fa-exchange-alt"></i> Move
              </button>
            </div>
          </li>
        </ul>
      </div>
  
      <!-- File Move Dialog -->
      <div v-if="moveDialogVisible" class="move-dialog">
        <div>
          <h4>Select Destination Folder for {{ fileToMove }}</h4>
          <select v-model="destinationFolder" class="border p-2 rounded">
            <option v-for="folder in folders" :key="folder.id" :value="folder.id">
              {{ folder.name }}
            </option>
          </select>
          <div class="dialog-actions mt-4">
            <button @click="confirmMove" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
              Move
            </button>
            <button @click="cancelMove" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
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
        errorMessage: '',
        successMessage: '',
      };
    },
    mounted() {
      const clientId = this.$route.params.id || localStorage.getItem('clientId');
      if (clientId) {
        this.clientId = clientId;
        localStorage.setItem('clientId', clientId);
        this.fetchFoldersAndFiles();
      } else {
        this.errorMessage = 'Client ID is missing from the URL.';
      }
    },
    methods: {
      async fetchFoldersAndFiles() {
        try {
          const response = await axios.get(`/api/folders-and-files/${this.clientId}`);
          this.folders = response.data.folders;
          this.files = response.data.files;
          this.errorMessage = '';
          this.successMessage = '';
        } catch (error) {
          this.errorMessage = 'Error fetching folders and files: ' + (error.response?.data?.message || error.message);
        }
      },
      triggerFileInput(isFolder = false) {
        if (isFolder && this.openFolder) {
          this.$refs.fileInput.click();
        } else if (!isFolder) {
          this.$refs.mainFileInput.click();
        }
      },
      toggleFolder(folder) {
        this.openFolder = this.openFolder && this.openFolder.id === folder.id ? null : folder;
      },
      async createFolder() {
        if (!this.newFolderName) {
          this.errorMessage = 'Folder name cannot be empty.';
          return;
        }
        try {
          await axios.post('/api/create-folder', {
            name: this.newFolderName,
            client_id: this.clientId,
          });
          this.newFolderName = '';
          this.fetchFoldersAndFiles();
          this.successMessage = 'Folder created successfully!';
          this.errorMessage = '';
          this.resetMessage();
        } catch (error) {
          this.errorMessage = 'Error creating folder: ' + (error.response?.data?.message || error.message);
        }
      },
      async deleteFolder(folderId) {
        try {
          await axios.post('/api/delete-folder', {
            id: folderId,
            client_id: this.clientId,
          });
          this.fetchFoldersAndFiles();
          this.successMessage = 'Folder deleted successfully!';
          this.errorMessage = '';
          this.resetMessage();
        } catch (error) {
          this.errorMessage = 'Error deleting folder: ' + (error.response?.data?.message || error.message);
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
          this.successMessage = 'File deleted successfully!';
          this.errorMessage = '';
          this.resetMessage();
        } catch (error) {
          this.errorMessage = 'Error deleting file: ' + (error.response?.data?.message || error.message);
        }
      },
      onFileChange(e, folderId = null) {
        this.pdfFile = e.target.files[0];
        this.uploadFile(folderId);
      },
      async uploadFile(folderId) {
  if (!this.pdfFile) {
    this.errorMessage = 'Please select a file to upload.';
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
    
    // If folderId is provided, add the file to the folder's file list
    if (folderId) {
      const folder = this.folders.find(folder => folder.id === folderId);
      if (folder) {
        folder.files.push({ filename: response.data.filename });
      }
    } else {
      // Otherwise, add it to the unsorted files
      this.files.push({ filename: response.data.filename });
    }

    this.successMessage = 'File uploaded successfully!';
    this.errorMessage = '';
    this.resetMessage(); // Call to reset messages after timeout
  } catch (error) {
    this.errorMessage = 'Error uploading file: ' + (error.response?.data?.message || error.message);
  }
}
,
      openMoveDialog(fileName) {
        this.fileToMove = fileName;
        this.moveDialogVisible = true;
      },
      async confirmMove() {
  if (!this.destinationFolder) {
    this.errorMessage = 'Please select a destination folder.';
    return;
  }
  try {
    await axios.post('/api/move-file', {
      fileName: this.fileToMove,
      destinationFolder: this.destinationFolder,
      client_id: this.clientId,
    });

    // Find the old folder and remove the file from it
    const oldFolder = this.folders.find(folder => folder.id === this.openFolder.id);
    if (oldFolder) {
      oldFolder.files = oldFolder.files.filter(file => file.filename !== this.fileToMove);
    }

    // Find the destination folder and add the file to it
    const newFolder = this.folders.find(folder => folder.id === this.destinationFolder);
    if (newFolder) {
      newFolder.files.push({ filename: this.fileToMove });
    }

    this.cancelMove(); // Close the move dialog
    this.successMessage = 'File moved successfully!';
    this.errorMessage = '';
    this.resetMessage(); // Call to reset messages after timeout
  } catch (error) {
    this.errorMessage = 'Error moving file: ' + (error.response?.data?.message || error.message);
  }
}
,
      cancelMove() {
        this.moveDialogVisible = false;
        this.fileToMove = '';
        this.destinationFolder = '';
      },
      resetMessage() {
  setTimeout(() => {
    this.successMessage = '';
    this.errorMessage = '';
  },5000); // Resets messages after 3 seconds
}
,
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
  