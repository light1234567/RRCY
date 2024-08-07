<!-- resources/js/components/PDFUploader.vue -->
<template>
  <div>
    <input type="file" @change="onFileChange" />
    <button @click="uploadFile">Upload</button>
    <div v-if="pdfUrl">
      <iframe :src="pdfUrl" width="100%" height="600px"></iframe>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      pdfFile: null,
      pdfUrl: '',
    };
  },
  methods: {
    onFileChange(e) {
      this.pdfFile = e.target.files[0];
    },
    async uploadFile() {
      if (!this.pdfFile) return;
      let formData = new FormData();
      formData.append('pdf', this.pdfFile);
      try {
        const response = await axios.post('/upload', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        this.pdfUrl = `/pdf/${response.data.filename}`;
      } catch (error) {
        console.error('Error uploading file:', error);
      }
    },
  },
};
</script>
