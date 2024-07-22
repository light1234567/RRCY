<template>
    <div class="form-container">
      <form @submit.prevent="submitForm">
        <fieldset>
          <legend>Admission Slip</legend>
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" v-model="form.name" placeholder="Enter name" required>
          </div>
          <div class="form-group">
            <label for="sex">Sex:</label>
            <select id="sex" v-model="form.sex" required>
              <option value="" disabled>Select</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" v-model="form.address" placeholder="Enter address" required>
          </div>
          <div class="form-group">
            <label for="religion">Religion:</label>
            <input type="text" id="religion" v-model="form.religion" placeholder="Enter religion">
          </div>
          <div class="form-group">
            <label for="dob">Date/Place of Birth:</label>
            <input type="date" id="dob" v-model="form.dob" required>
          </div>
        </fieldset>
  
        <fieldset>
         
          <div class="form-group">
            <label for="committingCourt">Committing Court:</label>
            <input type="text" id="committingCourt" v-model="form.committingCourt" placeholder="Enter committing court">
          </div>
          <div class="form-group">
            <label for="criminalCaseNo">Crim. Case #:</label>
            <input type="text" id="criminalCaseNo" v-model="form.criminalCaseNo" placeholder="Enter criminal case number">
          </div>
          <div class="form-group">
            <label for="offenseCommitted">Offense Committed:</label>
            <input type="text" id="offenseCommitted" v-model="form.offenseCommitted" placeholder="Enter offense committed">
          </div>
          <div class="form-group">
            <label for="dateAdmitted">Date admitted to Center:</label>
            <input type="date" id="dateAdmitted" v-model="form.dateAdmitted" required>
          </div>
          <div class="form-group">
            <label for="daysInJail">No. of Days in Jail:</label>
            <input type="number" id="daysInJail" v-model="form.daysInJail" placeholder="Enter number of days" min="0" required>
          </div>
          <div class="form-group">
            <label for="daysInDetention">No. of Days in Detention Center:</label>
            <input type="number" id="daysInDetention" v-model="form.daysInDetention" placeholder="Enter number of days" min="0" required>
          </div>
        </fieldset>
  
        <fieldset>
          <legend>Distinguishing Marks</legend>
          <div class="form-group">
            <label for="tattoo">a. Tattoo/Scars:</label>
            <input type="text" id="tattoo" v-model="form.distinguishingMarks.tattoo" placeholder="Enter tattoo details">
          </div>
          <div class="form-group">
            <label for="height">b. Height:</label>
            <input type="text" id="height" v-model="form.distinguishingMarks.height" placeholder="Enter height">
          </div>
          <div class="form-group">
            <label for="weight">c. Weight:</label>
            <input type="text" id="weight" v-model="form.distinguishingMarks.weight" placeholder="Enter weight">
          </div>
          <div class="form-group">
            <label for="eyeColor">d. Colour of Eye:</label>
            <input type="text" id="eyeColor" v-model="form.distinguishingMarks.eyeColor" placeholder="Enter eye color">
          </div>
          <div class="form-group">
            <label for="skinColor">e. Skin:</label>
            <input type="text" id="skinColor" v-model="form.distinguishingMarks.skinColor" placeholder="Enter skin color">
          </div>
        </fieldset>
  
        <fieldset>
          <legend>Documents Submitted</legend>
          <div class="form-group checkbox-group">
            <label><input type="checkbox" v-model="form.documents.scsr"> 1.) SCSR</label>
            <label><input type="checkbox" v-model="form.documents.courtOrder"> 2.) Court Order</label>
            <label><input type="checkbox" v-model="form.documents.medicalCertificates"> 3.) Medical Certificates</label>
            <label><input type="checkbox" v-model="form.documents.consConsent"> 4.) Consent from Parents</label>
            <label><input type="checkbox" v-model="form.documents.schoolRecords"> 5.) School Records</label>
            <label><input type="checkbox" v-model="form.documents.others"> 6.) Others</label>
          </div>
        </fieldset>
  
        <fieldset>
          <legend>Additional Information</legend>
          <div class="form-group">
            <label for="generalImpression">General Impression upon admission:</label>
            <textarea id="generalImpression" v-model="form.generalImpression" placeholder="Enter general impression"></textarea>
          </div>
          <div class="form-group">
            <label for="actionTaken">Action Taken:</label>
            <textarea id="actionTaken" v-model="form.actionTaken" placeholder="Enter action taken"></textarea>
          </div>
        </fieldset>
  
        <button type="submit">Submit</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        form: {
          name: '',
          sex: '',
          address: '',
          religion: '',
          dob: '',
          committingCourt: '',
          criminalCaseNo: '',
          offenseCommitted: '',
          dateAdmitted: '',
          daysInJail: '',
          daysInDetention: '',
          distinguishingMarks: {
            tattoo: '',
            height: '',
            weight: '',
            eyeColor: '',
            skinColor: ''
          },
          documents: {
            scsr: false,
            courtOrder: false,
            medicalCertificates: false,
            consConsent: false,
            schoolRecords: false,
            others: false
          },
          generalImpression: '',
          actionTaken: ''
        }
      };
    },
    methods: {
      submitForm() {
        // Implement form submission logic
        console.log(this.form);
        alert('Form submitted');
      }
    }
  };
  </script>
  
  <style scoped>
  .form-container {
    max-width: 800px;
    margin: auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
  }
  
  form {
    display: flex;
    flex-direction: column;
  }
  
  fieldset {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    margin-bottom: 20px;
  }
  
  legend {
    font-weight: bold;
    font-size: 1.2em;
    margin-bottom: 10px;
  }
  
  .form-group {
    margin-bottom: 15px;
  }
  
  .form-group label {
    display: block;
    margin-bottom: 5px;
  }
  
  .form-group input, .form-group select, .form-group textarea {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
  }
  
  .checkbox-group {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }
  
  button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #0056b3;
  }
  </style>
  