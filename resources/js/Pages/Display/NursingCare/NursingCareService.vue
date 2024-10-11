<template>
<!-- Tabs for Actions -->
<div v-if="editMode" class="flex absolute p-4 space-x-4">
    <button @click="cancelEdit" class="flex space-x-2 px-3 py-3 bg-[conic-gradient(at_bottom_right,_var(--tw-gradient-stops))] from-blue-700 via-blue-800 to-gray-900 text-white rounded-md text-xs">
      <!-- FontAwesome for Back -->
      <i class="fas fa-arrow-left w-4 h-4"></i>
      <span>Back</span>
    </button>
</div>

<div class="flex -ml-2 justify-end bg-transparent border -mr-9 border-gray-300 p-4 space-x-4 -mt-[52px]">
    <!-- Pagination Component -->
    <Pagination 
      :totalPages="totalPages" 
      :currentPage="currentPage" 
      @update:currentPage="currentPage = $event" 
    />
    <button @click="toggleEdit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
          <span v-if="!editMode">Edit</span>
          <span v-else>Cancel</span>
        </button>
        <button v-if="editMode" @click="saveData" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
          Save
        </button>

    <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 text-white rounded-md text-xs">
    
      <i class="fas fa-file-pdf w-4 h-4"></i>
      <span>Export PDF</span>
    </button> 
</div>
  
  
      <!-- Success/Error Message -->
  <div v-if="message" :class="messageType === 'success' ? 'bg-green-500' : 'bg-red-500'" class="mt-4 p-4 text-white rounded">
    {{ message }}
  </div>
  <div class="graph-background pt-0.5  -mr-9 -mb-16">

    <div class="p-12 mt-8 bg-white max-w-screen-md mx-auto border border-gray-400 rounded-lg shadow-lg">
      <div v-if="message" :class="messageType === 'success' ? 'bg-green-500' : 'bg-red-500'" class="mt-4 p-4 text-white rounded">
    {{ message }}
  </div>
      <!-- Header Section -->
      <div class="text-center border-b pb-2 mb-4">
        <div class="flex justify-between items-center">
    <!-- Stretch the image -->
    <img src="/images/headerlogo3.png" alt="DSWD Logo" class="h-20 w-auto"> 
    <div class="text-right">
      <p class="item-center mr-6 text-sm font-semibold">PROTECTIVE SERVICES DIVISION</p>
      <p class="text-sm font-semibold">Regional Rehabilitation Center for Youth</p>
      <p class="mr-20 text-sm font-semibold">Youth/RFO XI</p>
      <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
    </div>
        </div>
        <h1 class="text-xl font-bold mt-2">NURSING CARE SERVICE</h1>
      </div>
  
      <div class="grid grid-cols-4 gap-2 mb-2">
    <!-- Row 1: Name and B-Day with Date Admitted -->
    <div class="flex w-auto col-span-2">
      <label class="border-none flex items-center block font-bold text-xs">CLIENT'S NAME:</label>
      <input type="text" v-model="form.client_name" class="w-56 border-none p-1 text-xs" readonly>
    </div>
  
    <div class="flex col-span-1 -ml-10">
      <label class="border-none flex items-center block font-bold text-xs">BIRTHDATE:</label>
      <input type="date" v-model="form.birthdate" class="w-full border-none p-1 text-xs" readonly>
    </div>
  
    <div class="flex col-span-1 ml-8">
      <label class="border-none w-40 flex items-center block font-bold -ml-20 text-xs">DATE ADMITTED:</label>
      <input type="date" v-model="form.date_of_admission" class="w-full -ml-8 bg-transparent border-none p-1 text-xs" readonly>
    </div>
  
    <!-- Row 2: Age, Medical Status, Religion -->
    <div class="flex col-span-1 w-20">
      <label class="border-none flex items-center block font-bold text-xs">AGE:</label>
      <input type="number" v-model="form.age" class="w-10 border-none p-1 text-xs" readonly>
    </div>
  
    <div class="flex -ml-28 col-span-2">
      <label class="border-none flex items-center block font-bold text-xs">CURRENT MEDICAL STATUS:</label>
      <input type="text" v-model="form.current_medical_status" class="w-60 border-none p-1 text-xs" :readonly="!editMode">
    </div>
  
    <div class="flex col-span-1">
      <label class="border-none -ml-12 flex items-center block font-bold text-xs">RELIGION:</label>
      <input type="text" v-model="form.religion" class="w-full border-none p-1 text-xs" readonly>
    </div>
  
    <!-- Row 3: Address -->
    <div class="flex col-span-4">
      <label class="border-none flex items-center block font-bold text-xs">ADDRESS:</label>
      <input type="text" v-model="form.address" class="w-full border-none p-1 text-xs" readonly>
    </div>
  </div>
  
  
      <!-- BMI Monitoring Table -->
      <div class="text-center border-b pb-2 mb-4">
        <h2 class="text-lg font-bold">MONTHLY BMI MONITORING 2024</h2>
      </div>
  
      <table class="w-full border-collapse border mb-4">
        <thead>
          <tr class="bg-gray-100 text-base">
            <th class="border p-2">VITAL SIGNS / BMI</th>
            <th class="border p-2">APRIL</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border text-sm p-2">TEMPERATURE</td>
            <td class="border text-sm p-2"><input type="number" v-model="form.temperature" class="w-full border-none p-1" :readonly="!editMode"></td>
          </tr>
          <tr>
            <td class="border text-sm p-2">PULSE RATE</td>
            <td class="border text-sm p-2"><input type="number" v-model="form.pulse_rate" class="w-full border-none p-1" :readonly="!editMode"></td>
          </tr>
          <tr>
            <td class="border text-sm p-2">RESPIRATORY RATE</td>
            <td class="border text-sm p-2"><input type="number" v-model="form.respiratory_rate" class="w-full border-none p-1" :readonly="!editMode"></td>
          </tr>
          <tr>
            <td class="border text-sm p-2">BLOOD PRESSURE</td>
            <td class="border text-sm p-2"><input type="text" v-model="form.blood_pressure" class="w-full border-none p-1" :readonly="!editMode"></td>
          </tr>
          <tr>
            <td class="border text-sm p-2">HEIGHT (cm)</td>
            <td class="border text-sm p-2"><input type="number" v-model="form.height_cm" @input="computeBMI" class="w-full border-none p-1" :readonly="!editMode"></td>
          </tr>
          <tr>
            <td class="border text-sm p-2">WEIGHT (kg)</td>
            <td class="border text-sm p-2"><input type="number" v-model="form.weight_kg" @input="computeBMI" class="w-full border-none p-1" :readonly="!editMode"></td>
          </tr>
          <tr>
            <td class="border text-sm p-2">BODY MASS INDEX (BMI)</td>
            <td class="border text-sm p-2"><input type="number" v-model="form.bmi" class="w-full border-none p-1" readonly></td>
          </tr>
          <tr>
            <td class="border text-sm p-2">BMI REMARKS</td>
            <td class="border text-sm p-2"><input type="text" v-model="form.bmi_remarks" class="w-full border-none p-1" :readonly="!editMode"></td>
          </tr>
        </tbody>
      </table>
  
      <!-- General Appearance -->
      <div class="text-center pb-2 mb-4">
        <h2 class="text-lg font-bold">GENERAL APPEARANCE</h2>
      </div>
  
      <div class="flex mb-4">
  
  
   <!-- Table with health status information -->
  <div class="grid grid-cols-2 gap-4 w-full border">
    <!-- Column 1: Eyes, Ears, Mouth & Teeth -->
    <div class="border border-black-0 w-58 p-2">
      <!-- Eyes Section -->
      <div class="flex items-center mb-2">
        <label class="font-bold text-xs mr-2">EYES:</label>
        <input type="text" v-model="form.eyes_status" class="w-full border-none p-1 text-xs" :readonly="!editMode">
      </div>
  
      <!-- Ears Section -->
      <div class="flex items-center mb-2">
        <label class="font-bold text-xs mr-2">EARS:</label>
        <input type="text" v-model="form.ears_status" class="w-full border-none p-1 text-xs" :readonly="!editMode">
      </div>
  
      <!-- Mouth & Teeth Section -->
      <div class="flex items-center w-full mb-2">
        <label class="flex w-44 font-bold text-xs mr-2">MOUTH & TEETH:     </label>
        <input type="text" v-model="form.mouth_teeth_status" class="-ml-4 w-full border-none p-1 text-xs" :readonly="!editMode">
      </div>
    </div>
  
    <!-- Column 2: Nails, Skin, Hair -->
    <div class="border-none p-2">
      <!-- Nails Section -->
      <div class="flex items-center mb-2">
        <label class="font-bold text-xs mr-2">NAILS:</label>
        <input type="text" v-model="form.nails_status" class="w-full border-none p-1 text-xs" :readonly="!editMode">
      </div>
  
      <!-- Skin Section -->
      <div class="flex items-center mb-2">
        <label class="font-bold text-xs mr-2">SKIN:</label>
        <input type="text" v-model="form.skin_status" class="w-full border-none p-1 text-xs" :readonly="!editMode">
      </div>
  
      <!-- Hair Section -->
      <div class="flex items-center mb-2">
        <label class="font-bold text-xs mr-2">HAIR:</label>
        <input type="text" v-model="form.hair_status" class="w-full border-none p-1 text-xs" :readonly="!editMode">
      </div>
    </div>
  </div>
  
  </div>
  
  
  
      <div class="border">
      <div class="grid grid-cols-3 gap-4 mb-4">
    <!-- Left Column: Services Given and Remarks -->
    <div class="col-span-2">
      <!-- Services Given Section -->
      <div class="mb-4 bg-transparent w-96 ">
        <label class=" font-bold ml-2 text-sm">SERVICES GIVEN:</label>
        <textarea v-model="form.services_given" rows="5" class="w-full ml-2 p-1 border-none text-sm mb-2"></textarea>
      </div>
  
      <!-- Remarks Section -->
      <div class="mb-4 bg-transparent w-96 ">
        <label class=" font-bold ml-2 text-sm">REMARKS:</label>
        <textarea v-model="form.remarks" rows="5" class="w-full p-1 ml-2 border-none text-sm mb-2"></textarea>
      </div>


   




    </div>
  
    <div class="-ml-14 mt-14 col-span-1 flex-absolute justify-center items-center">
  <!-- Upload and Camera Buttons (Visible only in edit mode) -->
<!-- Upload and Camera Buttons (Visible only in edit mode) -->
<div v-if="editMode" class="flex flex-col space-y-4">
  <!-- File Input for Uploading Profile Image -->
  <input 
    type="file" 
    ref="fileInput" 
    accept="image/*" 
    @change="onFileChange" 
    class="hidden" 
  />
  <button @click="triggerFileInput" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 w-full">
    Upload Image
  </button>

  <!-- Button to Open Camera -->
  <button @click="openCamera" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 w-full">
    Open Camera
  </button>

  <!-- Modal Structure -->
  <div v-if="showCamera" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-4 w-11/12 sm:w-96">
      <video ref="video" autoplay class="w-full h-64 object-cover rounded-md"></video>
      <button @click="capturePhoto" class="mt-4 w-full px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
        Capture
      </button>
      <button @click="closeCamera" class="mt-2 w-full px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
        Close
      </button>
    </div>
  </div>
</div>


  <!-- Preview Profile Image -->
  <div class="w-60 h-60 border flex justify-center items-center cursor-pointer" @click="triggerFileInput">
    <img 
      v-if="form.profile_image || previewImage" 
      :src="previewImage || `/profile_images/${form.profile_image}`" 
      alt="Profile Image" 
      class="h-full w-full object-cover" 
    />

    <img 
    v-else 
    src="/images/default-profile.jpg" 
    alt="Default Profile Image" 
    class="h-full w-full object-cover"
  />
  </div>
</div>



  </div>
  
  </div>
  
  
  <!-- Signatures Section -->
  <div class="flex gap-4 mb-6 border p-4">
    <!-- Prepared by Signature -->
    <div class="w-1/2 border-r pr-4">
      <label class="block text-sm font-bold">PREPARED BY:</label>
      <div class="font-semibold flex items-center">
        <input
          type="text"
          v-model="form.prepared_by"
          class=" w-full text-sm -ml-3 mt-1 border-none shadow-none"
          :readonly="!editMode"
        >
      </div>
      <div class="font-semibold text-sm flex items-center">
        <input
          type="text"
          value="CARL BRIAN T. BAUZON, RN"
          class="w-full text-sm w-48 mr-28 mt-1 underline-input shadow-none"
          :readonly="!editMode"
        >
      </div>
      <p class="text-sm mt-2 ">RESIDENT NURSES RRCY</p>
    </div>
  
    <!-- Noted by Signature -->
    <div class="w-1/2 pl-4">
      <label class="block text-sm font-bold">NOTED BY:</label>
      <div class="flex items-center">
        <input
          type="text"
          v-model="center_head"
          class="text-sm font-semibold w-44 mt-1 underline-input shadow-none"
          readonly
        >
      </div>
      <p class="text-sm mt-2">SWO IV/Center Head</p>
    </div>
  </div>
  
        <!-- Footer Section -->
        <div class=" pt-4 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
          <div class="flex justify-between items-center">
            <div class="flex flex-col">
              <p class="font-bold">PAGE 1 of 1</p>
              <p class="border-t border-black pt-2">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
              <p>Email: <span class="text-blue-600 underline">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
            </div>
            <div>
              <img src="/images/footerimg.png" alt="Footer Image" class="h-12 w-24 object-cover">
            </div>
          </div>
        </div>
        </div>
    </div>
  </template>
  <script>
  import axios from 'axios';
  import { jsPDF } from 'jspdf';
import '../../../fonts/arial-normal.js'; 
import '../../../fonts/times-normal.js'; 
import '../../../fonts/arialbd-bold.js'; 
import Pagination from '@/Components/Pagination.vue';

  export default {
    components:{
      Pagination,
    },
    data() {
      return {
        totalPages: 1,
        currentPage: 1,
        center_head: '',
        showCamera: false,
    videoStream: null,
    previewImage: null,
    form: {
      profile_image: null, // Holds the captured or uploaded image
          client_name: '',
          birthdate: '',
          age: '',
          current_medical_status: '',
          religion: '',
          address: '',
          date_of_admission: '',
          temperature: '',
          pulse_rate: '',
          respiratory_rate: '',
          blood_pressure: '',
          height_cm: '',
          weight_kg: '',
          bmi: '',
          bmi_remarks: '',
          eyes_status: '',
          nails_status: '',
          ears_status: '',
          skin_status: '',
          mouth_teeth_status: '',
          hair_status: '',
          services_given: '',
          remarks: '',
          prepared_by: '',
          noted_by: '',
          client_id: null, // Ensure client_id is explicitly defined
          id: null, // This will hold the id of NursingCareService if exists
        },
        editMode: false,
        message: '',
        messageType: '',
      };
    },
    mounted() {
      const clientId = this.$route.params.id;
      console.log('client ID:', clientId); // Log client ID on component mount
      this.fetchData(clientId);
      this.fetchCenterHead();
    },
    watch: {
      '$route.params.id': function (newClientId) {
        console.log('Watched client ID change:', newClientId); // Log client ID on route change
        this.fetchData(newClientId);
        this.fetchCenterHead(newClientId);
      }
    },
    methods: {


      fetchData(clientId) {
        if (!clientId) {
          console.error('Client ID is missing.');
          return;
        }
  
        axios.get(`/api/nursing-care-services/${clientId}`)
          .then(response => {
            const { data } = response;
            if (!data || !data.client) {
              console.warn('No client data found in the response.');
              return;
            }
  
            const { client, assessment } = data;
            this.form.client_id = client.id;  // Ensure client_id is set
            this.form.client_name = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
            this.form.birthdate = client.date_of_birth;
            this.form.age = this.calculateAge(client.date_of_birth);
            this.form.religion = client.religion;
            this.form.address = `${client.street}, ${client.barangay}, ${client.city}, ${client.province}`;
  
            if (client.admissions && client.admissions.length > 0) {
              this.form.date_of_admission = client.admissions[0].date_admitted;
            } else {
              this.form.date_of_admission = '';
            }
  
            if (assessment) {
              Object.assign(this.form, assessment);
              this.form.id = assessment.id;
            }
          })
          .catch(error => {
            console.error('Error fetching data:', error.response ? error.response.data : error.message);
            this.message = 'Error fetching data: ' + (error.response?.data || error.message);
            this.messageType = 'error';
            this.clearMessageAfterDelay();
          });
      },
      fetchCenterHead() {
    axios.get('/api/center-head')  // Replace with the correct API route
      .then(response => {
        this.center_head = response.data.name;  // Bind the fetched name to v-model
      })
      .catch(error => {
        console.error('Error fetching center head:', error);
      });
  },
  
      calculateAge(birthDate) {
        const today = new Date();
        const birthDateObj = new Date(birthDate);
        let age = today.getFullYear() - birthDateObj.getFullYear();
        const monthDiff = today.getMonth() - birthDateObj.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDateObj.getDate())) {
          age--;
        }
        return age;
      },
      toggleEdit() {
        this.editMode = !this.editMode;
      },

    computeBMI() {
      const heightInMeters = this.form.height_cm / 100;
      const weight = this.form.weight_kg;

      if (heightInMeters > 0 && weight > 0) {
        const bmi = weight / (heightInMeters * heightInMeters);
        this.form.bmi = bmi.toFixed(2);
      } else {
        this.form.bmi = '';
      }
    },
  // Trigger file input for uploading image
  triggerFileInput() {
    // Ensure we correctly reference the hidden file input element
    this.$refs.fileInput.click();
  },

  // Handle file upload
  onFileChange(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        this.previewImage = e.target.result; // Set the preview image
      };
      reader.readAsDataURL(file);
      this.form.profile_image = file; // Store the file in form data
    }
  },

  // Open the camera to capture an image
  openCamera() {
    this.showCamera = true;
    navigator.mediaDevices
      .getUserMedia({ video: true })
      .then((stream) => {
        this.videoStream = stream;
        this.$refs.video.srcObject = stream;
      })
      .catch((err) => {
        console.error("Error accessing the camera: ", err);
        this.message = 'Error accessing the camera.';
        this.messageType = 'error';
      });
  },

  // Capture the photo from the camera
  capturePhoto() {
  const video = this.$refs.video;
  const canvas = document.createElement('canvas');
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  const context = canvas.getContext('2d');
  context.drawImage(video, 0, 0, canvas.width, canvas.height);

  // Generate timestamp
  const timestamp = new Date().toISOString().replace(/[-:.]/g, ''); // Removes special characters for filename compatibility
  
  // Set the captured image as preview
  this.previewImage = canvas.toDataURL('image/png');

  // Convert data URL to file object for saving and add timestamp to the filename
  canvas.toBlob((blob) => {
    this.form.profile_image = new File([blob], `captured_image_${timestamp}.png`, { type: 'image/png' });
  });

  // Stop the video stream and close the camera view
  this.closeCamera();
},


  // Close the camera and modal
  closeCamera() {
    if (this.videoStream) {
      this.videoStream.getTracks().forEach(track => track.stop());
    }
    this.showCamera = false;
  },

  saveData() {
    const formData = new FormData();

    // Loop through the form and append fields to FormData if they are not null
    Object.keys(this.form).forEach(key => {
      if (this.form[key] !== null && this.form[key] !== undefined && key !== 'client_id' && key !== 'profile_image') {
        formData.append(key, this.form[key]);
      }
    });

    // If a new profile image is selected or captured, append it to form data
    if (this.form.profile_image instanceof File) {
      formData.append('profile_image', this.form.profile_image);
    }

    // Ensure client_id is present before proceeding
    if (!this.form.client_id) {
      console.error('Missing client_id');
      this.message = 'Client ID is missing. Cannot submit the form.';
      this.messageType = 'error';
      this.clearMessageAfterDelay();
      return;
    }

    // Append the client ID to formData
    formData.append('client_id', this.form.client_id);

    // Send a request to either update or create the record
    const url = this.form.id
      ? `/api/nursing-care-services/${this.form.id}?_method=PUT`
      : '/api/nursing-care-services';
    
    axios({
      method: 'post', // Use POST for both creation and updates
      url: url,
      data: formData,
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    .then(response => {
      console.log('Data saved successfully', response.data);
      this.message = 'Data saved successfully!';
      this.messageType = 'success';
      this.clearMessageAfterDelay();
      this.editMode = false; // Exit edit mode after saving
    })
    .catch(error => {
      console.error('Error saving data:', error.response ? error.response.data : error.message);
      this.message = 'Error saving data: ' + (error.response?.data?.message || error.message);
      this.messageType = 'error';
      this.clearMessageAfterDelay();
    });
  },

  clearMessageAfterDelay() {
    setTimeout(() => {
      this.message = '';
    }, 3000); // Clear the message after 3 seconds
  },
  exportToPdf() { 
  const pdf = new jsPDF('p', 'mm', 'a4'); // Standard A4 size document
  const pageHeight = 297; // Total page height in mm
  const marginBottom = 30; // Bottom margin in mm
  const rowHeight = 8; // Height of each row
  const lineHeight = 5; // Space between lines
  const footerHeight = 5; // Adjust to fit the height of your footer
  const maxContentHeight = pageHeight - marginBottom - footerHeight; // Reduce height to account for footer
  const maxWidth = 90; // Maximum width for text
  let contentYPos = 0; // Start Y position for content (initialize contentYPos)
  let initialX = 20; // X position for content


  

  // Add header logo
  const logoImg = "/images/headerlogo3.png"; 
  pdf.addImage(logoImg, "PNG", 15, 15, 90, 20); 
  contentYPos += 40; 

  // Add title and header text
  pdf.setFontSize(10);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text('REGIONAL REHABILITATION CENTER FOR YOUTH', 150, 22, { align: 'center' });
  contentYPos += 10;

  pdf.text('RRCY/FIELD OFFICE XI', 150, 27, { align: 'center' });
  contentYPos += 10;

  pdf.setFontSize(8);
  pdf.setFont('times', 'italic','bold');
  pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 150, 32, { align: 'center' });
  contentYPos += 10;


  pdf.setFontSize(18);
  pdf.setTextColor(50, 50, 255);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text('NURSING CARE SERVICE', 105, 48, { align: 'center' });


  pdf.setTextColor(0, 0, 0);
  contentYPos += -14;
  pdf.setFontSize(10);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text(`CLIENT'S NAME: ${this.form.client_name || ''}`, initialX+-9, contentYPos);
  pdf.text(`BIRTHDATE: ${this.form.birthdate || ''}`, initialX+120, contentYPos);

  contentYPos += 6;
  pdf.text(`AGE: ${this.form.age || ''}`, initialX+-9, contentYPos);
  pdf.text(`CURRENT MEDICAL STATUS: ${this.form.current_medical_status || ''}`, initialX+30, contentYPos);
  pdf.text(`RELIGION: ${this.form.religion || ''}`, initialX+120, contentYPos);

  contentYPos += 6;
  pdf.text(`ADDRESS:`, initialX+-9, contentYPos);
  pdf.setFontSize(9);
  pdf.text(`${this.form.address || ''}`, initialX+10, contentYPos);
  pdf.setFontSize(10);
  pdf.text(`DATE OF ADMISSION: ${this.form.date_of_admission || ''}`, initialX+120, contentYPos);

  pdf.setFontSize(16);
  pdf.setTextColor(50, 50, 255);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text('MONTHLY BMI MONITORING 2024', 105, 77, { align: 'center' });


contentYPos += 16;
pdf.setFontSize(10);
pdf.setTextColor(0, 0, 0);
pdf.setFont('arialbd', 'bold'); 
pdf.text(`VITAL SIGNS / BMI`, initialX+15, contentYPos);
pdf.text(`APRIL`, initialX+125, contentYPos);

contentYPos += 5;
pdf.setFont('arial', 'normal'); 
pdf.text(`TEMPERATURE`, initialX+-9, contentYPos);
const temperature = this.form.temperature || ''; // Get the temperature value
pdf.text(`${temperature}`, 136, 89); 
const tempTextWidth = pdf.getTextWidth(`${temperature}`);
pdf.text('degree celsius', 136 + tempTextWidth + 2, 89);

contentYPos += 5;
pdf.setFont('arial', 'normal'); 
pdf.text(`PULSE RATE`, initialX+-9, contentYPos);
const pulsrate = this.form.pulse_rate || ''; // Get the temperature value
pdf.text(`${pulsrate}`, 145, contentYPos); 
const pulsrateTextWidth = pdf.getTextWidth(`${pulsrate}`);
pdf.text('bpm', 145 + pulsrateTextWidth + 2, contentYPos);

contentYPos += 5;
pdf.setFont('arial', 'normal'); 
pdf.text(`RESPIRATORY RATE`, initialX+-9, contentYPos);
const respiratory_rate = this.form.respiratory_rate || ''; // Get the temperature value
pdf.text(`${respiratory_rate}`, 145, contentYPos); 
const respiratory_rateTextWidth = pdf.getTextWidth(`${respiratory_rate}`);
pdf.text('bpm', 145 + respiratory_rateTextWidth + 2, contentYPos);

contentYPos += 5;
pdf.setFont('arial', 'normal'); 
pdf.text(`BLOOD PRESSURE`, initialX+-9, contentYPos);
const blood_pressure = this.form.blood_pressure || ''; // Get the temperature value
pdf.text(`${blood_pressure}`, 147, contentYPos); 
const blood_pressureTextWidth = pdf.getTextWidth(`${blood_pressure}`);
pdf.text('mmHg', 147 + blood_pressureTextWidth + 2, contentYPos);

contentYPos += 5;
pdf.setFont('arial', 'normal'); 
pdf.text(`HEIGHT (cm)`, initialX+-9, contentYPos);
pdf.text(`${this.form.height_cm || ''}`, 150, contentYPos, { align: 'center' });

contentYPos += 5;
pdf.setFont('arial', 'normal'); 
pdf.text(`WEIGHT (kg)`, initialX+-9, contentYPos);
pdf.text(`${this.form.weight_kg || ''}`, 150, contentYPos, { align: 'center' });


contentYPos += 5;
pdf.setFont('arial', 'normal'); 
pdf.text(`BODY MASS INDEX (BMI)`, initialX+-9, contentYPos);
pdf.text(`${this.form.bmi || ''}`, 150, contentYPos, { align: 'center' });

contentYPos += 5;
pdf.setFont('arial', 'normal'); 
pdf.text(`BMI REMARKS`, initialX+-9, contentYPos);
pdf.setFont('arialbd', 'bold'); 
pdf.text(`${this.form.bmi_remarks || ''}`, 150, contentYPos, { align: 'center' });


pdf.setFontSize(14);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text('GENERAL APPEARANCE', 105, 132, { align: 'center' });

  contentYPos += 15;
  pdf.setFontSize(10);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text(`EYES:`, initialX+-9, contentYPos);
  pdf.setFontSize(9);
  pdf.setFont('arial', 'normal'); 
  pdf.text(`${this.form.eyes_status || ''}`, initialX+3, contentYPos);
  pdf.setFont('arialbd', 'bold'); 
  pdf.setFontSize(10);
  pdf.text(`NAILS:`, initialX+91, contentYPos);
  pdf.setFontSize(9);
  pdf.setFont('arial', 'normal'); 
  pdf.text(`${this.form.nails_status || ''}`, initialX+104, contentYPos);

  contentYPos += 5;
  pdf.setFontSize(10);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text(`EARS:`, initialX+-9, contentYPos);
  pdf.setFontSize(9);
  pdf.setFont('arial', 'normal'); 
  pdf.text(`${this.form.ears_status || ''}`, initialX+3, contentYPos);
  pdf.setFont('arialbd', 'bold'); 
  pdf.setFontSize(10);
  pdf.text(`SKIN:`, initialX+91, contentYPos);
  pdf.setFontSize(9);
  pdf.setFont('arial', 'normal'); 
  pdf.text(`${this.form.skin_status || ''}`, initialX+102, contentYPos);

  contentYPos += 5;
  pdf.setFontSize(10);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text(`MOUTH & TEETH:`, initialX+-9, contentYPos);
  pdf.setFontSize(9);
  pdf.setFont('arial', 'normal'); 
  pdf.text(`${this.form.mouth_teeth_status || ''}`, initialX+22, contentYPos);
  pdf.setFont('arialbd', 'bold'); 
  pdf.setFontSize(10);
  pdf.text(`HAIR:`, initialX+91, contentYPos);
  pdf.setFontSize(9);
  pdf.setFont('arial', 'normal'); 
  pdf.text(`${this.form.hair_status || ''}`, initialX+103, contentYPos);




contentYPos +=60;
  const profileImage = this.form.profile_image 
  ? `/profile_images/${this.form.profile_image}` 
  : this.previewImage || '/images/default-profile.jpg'; // Fallback to default image if none

  const img = new Image();
  img.src = profileImage; // Set the image source
  img.onload = () => {
      // Add the profile image to the PDF
      pdf.addImage(img, 'PNG', initialX + 90, contentYPos+-54, 90, 81); // Adjust size as necessary



  contentYPos += 10;
  pdf.setFontSize(10);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text(`SERVICES GIVEN:`, initialX+-9, contentYPos);

  contentYPos = 164;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(10);
  const services_givenLog = `${this.form.services_given || ''}`;
  const services_givenLines = pdf.splitTextToSize(services_givenLog, maxWidth);

  services_givenLines.forEach(line => {
    pdf.text(line, initialX+-9, contentYPos);
    contentYPos += lineHeight;
  });

  contentYPos = 199;
  pdf.setFontSize(10);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text(`REMARKS:`, initialX+-9, contentYPos);

  contentYPos = 204;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(10);
  const remarksLog = `${this.form.remarks || ''}`;
  const remarksLines = pdf.splitTextToSize(remarksLog, maxWidth);

  remarksLines.forEach(line => {
    pdf.text(line, initialX+-9, contentYPos);
    contentYPos += lineHeight;
  });



  contentYPos = 240;
  pdf.setFontSize(10);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text(`PREPARED BY:`, initialX+-9, contentYPos);

  pdf.setFontSize(10);
  pdf.setFont('arialbd', 'bold'); 
  pdf.text(`NOTED BY:`, initialX+81, contentYPos);






contentYPos += 10;


pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(11);
  pdf.text('PHILIP ROY D. CONTANGCO, RN', initialX+5, contentYPos+10);
  pdf.text('CARLBRIAN T. BAUZON, RN', initialX+8, contentYPos+15);
  contentYPos += 5; 
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(10);
  pdf.line(27, contentYPos+11, 82, contentYPos+11);
  pdf.text('RESIDENT NURSES RRCY', initialX+12, contentYPos+15);



  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(11);
  pdf.text('ANGELIC B. PAÑA,RSW', initialX+105, contentYPos+5);
  contentYPos += 5; 
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(10);
  pdf.line(125, contentYPos+1, 170, contentYPos+1);
  pdf.text('SWO IV / Center Head', initialX+110, contentYPos+5);



  pdf.setLineWidth(0.5);
  pdf.rect(10, 10, 190, 277); 

  pdf.line(10, 40, 200, 40); 
  pdf.line(10, 52, 200, 52); 
  pdf.line(10, 58, 200, 58); 
  pdf.line(10, 64, 200, 64); 
  pdf.line(10, 69, 200, 69); 
  pdf.line(10, 80, 200, 80); 
  pdf.line(10, 85, 200, 85); 
  pdf.line(10, 90, 200, 90); 
  pdf.line(10, 95, 200, 95); 
  pdf.line(10, 100, 200, 100); 
  pdf.line(10, 105, 200,105); 
  pdf.line(10, 110, 200, 110); 
  pdf.line(10, 115, 200, 115); 
  pdf.line(10, 120, 200, 120); 
  pdf.line(10, 125, 200, 125); 
  pdf.line(10, 135, 200, 135); 
  pdf.line(10, 155, 200, 155); 
  pdf.line(10, 195, 110, 195); 
  pdf.line(10, 236, 200, 236); 

  pdf.line(100, 236, 100, 287); 
  pdf.line(110, 135, 110, 155); 
  pdf.line(90, 80 , 90, 125); 

  pdf.setLineWidth(0);

  pdf.line(139, 52 , 139, 64); 
  pdf.line(49, 58 , 49, 64); 



// Save the PDF with a dynamic filename
pdf.save(`Nursing_Care_${this.form.client_name || ''}.pdf`);

};
img.onerror = (err) => {
   console.error('Image loading error:', err);
   // Continue generating the PDF even if the image fails to load
   pdf.save(`Nursing_Care_${this.form.client_name || ''}.pdf`);
  };

  img.src = profileImage; // Set the image source
},


}
  };
  </script>
  
  
  <style scoped>
  .underline-input {
    border: none;
    border-bottom:  1px solid black;
    padding: 0;
    margin: 0;
    vertical-align: bottom; /* Ensures the text aligns with the bottom of the input */
  }
  .graph-background {
      background-image: linear-gradient(to right, #cccccc 1px, transparent 1px), 
                        linear-gradient(to bottom, #cccccc 1px, transparent 1px);
      background-size: 15px 15px; /* Adjust size as per your need */
    } 
  </style>
  