// resources/js/axios.js
import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: 'http://127.0.0.1:8000/api', // Replace with your actual backend URL
});

export default axiosInstance;

axios.post('/logout', {}, {
  headers: {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  }
})
.then(response => {
  showModal.value = false;
  window.location.href = '/login'; // Redirect to login
})
.catch(error => {
  console.log(error);
});
