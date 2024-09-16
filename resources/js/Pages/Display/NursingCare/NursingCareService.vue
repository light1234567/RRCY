<template>
  <div class="p-8 bg-white max-w-screen-md mx-auto border border-gray-300 rounded-lg shadow-lg">
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

  <div class="flex col-span-1 -ml-20">
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

  <!-- Right Column: Profile Picture -->
  <div class="-ml-14 mt-14 col-span-1 flex-absolute justify-center items-center">
    <div class="w-60 h-60 md-8 border flex justify-center items-center">
      <img src="/path/to/profile-picture.png" alt="Profile Picture" class="h-full w-full object-cover">
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
        value="PHILIP ROY D. COTIANGCO, RN"
        class=" w-full text-sm -ml-3 mt-1 border-none shadow-none"
        readonly
      >
    </div>
    <div class="font-semibold text-sm flex items-center">
      <input
        type="text"
        value="CARL BRIAN T. BAUZON, RN"
        class="w-full text-sm w-48 mr-28 mt-1 underline-input shadow-none"
        readonly
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
        value="ANGELIC B. PAÑA, RSW"
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
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      form: {
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
        profile_image: null, // Profile image added to form
        file: null, // File added to handle uploads
        client_id: null, // Ensure client_id is explicitly defined
        id: null, // This will hold the id of NursingCareService if exists
      },
      editMode: false,
      profileImageUrl: '', // To display uploaded image
    };
  },
  mounted() {
    const clientId = this.$route.params.id;
    console.log('Mounted with client ID:', clientId); // Log client ID on component mount
    this.fetchData(clientId);
  },
  watch: {
    '$route.params.id': function (newClientId) {
      console.log('Watched client ID change:', newClientId); // Log client ID on route change
      this.fetchData(newClientId);
    }
  },
  methods: {
    fetchData(clientId) {
    console.log('Fetching data for client ID:', clientId); // Log client ID before API call
    axios.get(`/api/nursing-care-services/${clientId}`)
        .then(response => {
            console.log('API Response:', response.data); // Log full API response
            if (response.data) {
                const { client, assessment } = response.data;

                // Log client details
                console.log('Fetched Client Details:', client);

                // Populate the form with client details
                this.form.client_name = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
                this.form.birthdate = client.date_of_birth;
                this.form.age = this.calculateAge(client.date_of_birth);
                this.form.religion = client.religion;
                this.form.address = `${client.street}, ${client.barangay}, ${client.city}, ${client.province}`;
                this.form.client_id = client.id; // Ensure client_id is set
                this.form.date_of_admission = client.admissions.length ? client.admissions[0].date_admitted : null; // Ensure date_of_admission is set

                if (assessment) {
                    Object.assign(this.form, assessment); // Assigning all assessment fields to form
                    this.form.id = assessment.id; // Store the NursingCareService ID
                    this.profileImageUrl = assessment.profile_image ? `/storage/${assessment.profile_image}` : 'path-to-default-pic.png';
                    console.log('Fetched NursingCareService Details:', assessment); // Log assessment details
                } else {
                    // Initialize form fields if no assessment found
                    this.profileImageUrl = 'path-to-default-pic.png';
                    console.log('No NursingCareService found. Client initialized:', this.form); // Log client initialization
                }
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}
,
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
    toggleEdit() {
      this.editMode = !this.editMode;
    },
    triggerFileInput() {
      this.$refs.fileInput.click();
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.form.file = file; // Store the file for submission
        this.profileImageUrl = URL.createObjectURL(file); // Update image display immediately
        console.log('File selected for upload:', file); // Log file details
      } else {
        // If no file is selected, clear the file from form data
        this.form.file = null;
        console.log('No file selected for upload'); // Log no file selected
      }
    },
    saveData() {
    const formData = new FormData();

    // Ensure required fields are added
    if (this.form.client_id) {
        formData.append('client_id', this.form.client_id);
    } else {
        console.error('Missing client_id'); // Log missing client_id
    }

    if (this.form.date_of_admission) {
        formData.append('date_of_admission', this.form.date_of_admission);
    } else {
        console.error('Missing date_of_admission'); // Log missing date_of_admission
    }

    // Append all other form fields to FormData
    for (const key in this.form) {
        if (this.form[key] !== null && key !== 'file' && key !== 'client_id' && key !== 'date_of_admission') {
            formData.append(key, this.form[key]);
        }
    }

    // Append the file if present
    if (this.form.file) {
        formData.append('profile_image', this.form.file);
    }

    // Determine the appropriate URL and method
    const isUpdate = Boolean(this.form.id);
    const requestUrl = isUpdate
        ? `/api/nursing-care-services/${this.form.id}`
        : `/api/nursing-care-services`;

    const requestMethod = isUpdate ? 'put' : 'post';

    console.log(`Saving data using ${requestMethod.toUpperCase()} for client ID:`, this.form.client_id);

    axios[requestMethod](requestUrl, formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        }
    })
    .then(response => {
        this.toggleEdit();
        alert('Data saved successfully!');

        // Update profileImageUrl if a new image has been uploaded and returned
        if (response.data.profile_image) {
            this.profileImageUrl = `/storage/${response.data.profile_image}`;
        }

        // Fetch updated data to reflect all changes
        this.fetchData(this.form.client_id);
    })
    .catch(error => {
        if (error.response && error.response.data.errors) {
            console.error('Error saving data:', error.response.data.errors);
            alert('Error saving data. Please check the input fields and try again.');
        } else {
            console.error('Unexpected error:', error);
            alert('Unexpected error occurred. Please try again.');
        }
    });
}

  },
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
</style>
