<script>
export default {
  data() {
    return {
      form: {
        name: '',
        sex: '',
        dphpate:'',
        age: '',
        address: '',
        religion: '',
        occupation:'',
        HEA:'',
        NOS:'',
        classAdviser:'',
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
        actionTaken: '',
        problemPresented: '',
        physicalDescription: '',

        majorLifeEvents: {
          deathOfParents: false,
          abandonment: false,
          separationFromFamily: false,
          seriousAccident: false,
          Victimofnaturalmanmadedisaster: false,
          Victimofapprehension : false,
          Victimofphysicalabuse : false,
          withsuicidaltendencies : false,
          mistakenidentity : false,
          Victimofdemolition : false,
          Victimofsexualabuse : false,
          Victimofverbalabuse : false,
          AcquiredDisability : false,
          Othersplsspecify : '',

          // Add more fields as needed
        },
        enduringLifeStrain: {
          poverty: false,
          physicalIllness: false,
          lackOfOpportunity: false,
          // Add more fields as needed
        }
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
  margin-right: 50%;
}

.form-group input, .form-group select, .form-group textarea {
  width: 100%;
  padding: 8px;
  box-sizing: border-box;
}

.checkbox-group {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  
}

.checkbox-group input[type="checkbox"]
{
  height: 20px; /* Adjust size */
  width: 20px;
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

      <!-- New sections from intake sheet images -->

      <fieldset>
        <legend>General Intake Sheet</legend>
        <div class="form-group">
          <label for="name">Name of Client:</label>
          <input type="text" id="name" v-model="form.name" placeholder="Enter name" required>
        </div>

        <div class="form-group">
          <label for="date">Date:</label>
          <input type="date" id="date" v-model="form.date" placeholder="Enter Date" required>
        </div>

        <div class="form-group">
          <label for="age">Age:</label>
          <input type="number" id="age" v-model="form.age" placeholder="Enter Age" required>
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
          <label for="occupation">Occupation:</label>
          <input type="text" id="occupation" v-model="form.occupation" placeholder="Enter Occupation">
        </div>



        <div class="form-group">
          <label for="dob">Date/Place of Birth:</label>
          <input type="date" id="dob" v-model="form.dob" required>
        </div>

        <div class="form-group">
          <label for="HEA">Highest Educational Attainment:</label>
          <input type="text" id="HEA" v-model="form.HEA" placeholder="Enter Attainment">
        </div>

        <div class="form-group">
          <label for="religion">Name of School:</label>
          <input type="text" id="religion" v-model="form.NOS" placeholder="Enter Name of School">
        </div>

        <div class="form-group">
          <label for="religion">Class Adviser:</label>
          <input type="text" id="religion" v-model="form.classAdviser" placeholder="Enter Class Adviser">
        </div>

      </fieldset>

      <fieldset>
        <legend>Problem Presented</legend>
        <div class="form-group">
          <textarea v-model="form.problemPresented"></textarea>
        </div>
      </fieldset>

      <fieldset>
        <legend>Brief Physical Description</legend>
        <div class="form-group">
          <textarea v-model="form.physicalDescription" placeholder="Childs Description"></textarea>
        </div>
      </fieldset>

      <fieldset>
        <legend>Major Life Events</legend>
        <div class="form-group checkbox-group">
          <label><input type="checkbox" v-model="form.majorLifeEvents.deathOfParents"> Death of Parents</label>
          <label><input type="checkbox" v-model="form.majorLifeEvents.separationFromFamily"> Separation from the family</label>

          <label><input type="checkbox" v-model="form.majorLifeEvents.Victimofnaturalmanmadedisaster"> Victim of natural / manmade disaster</label>
          <label><input type="checkbox" v-model="form.majorLifeEvents.Victimofapprehension"> Victim of apprehension</label>
          <label><input type="checkbox" v-model="form.majorLifeEvents.Victimofphysicalabuse"> Victim of physical abuse</label>
          <label><input type="checkbox" v-model="form.majorLifeEvents.withsuicidaltendencies"> With suicidal tendencies</label>
          <label><input type="checkbox" v-model="form.majorLifeEvents.mistakenidentity"> Mistaken identity</label>

          <label><input type="checkbox" v-model="form.majorLifeEvents.abandonment"> Abandonment</label>
          <label><input type="checkbox" v-model="form.majorLifeEvents.seriousAccident"> Serious Accident</label>
          
          <label><input type="checkbox" v-model="form.majorLifeEvents.Victimofdemolition"> Victim of demolition</label>
          <label><input type="checkbox" v-model="form.majorLifeEvents.Victimofsexualabuse"> Victim of sexual abuse</label>
          <label><input type="checkbox" v-model="form.majorLifeEvents.Victimofverbalabuse"> Victim of verbal abuse</label>
          <label><input type="checkbox" v-model="form.majorLifeEvents.AcquiredDisability"> Acquired Disability</label>
          
          <textarea v-model="form.majorLifeEvents.Othersplsspecify" placeholder="Others pls specify"> Others pls specify</textarea>


          <!-- Add more checkboxes as needed -->
        </div>
      </fieldset>

      <fieldset>
        <legend>Enduring Life Strain</legend>
        <div class="form-group checkbox-group">
          <label><input type="checkbox" v-model="form.enduringLifeStrain.poverty"> Poverty</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness"> Physical illness</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity"> Lack of educational opportunity</label>
          <!-- Add more checkboxes as needed -->
        </div>
      </fieldset>

      <fieldset>
        <legend>Life Transition</legend>
        <div class="form-group checkbox-group">
          <label><input type="checkbox" v-model="form.enduringLifeStrain.poverty"> Poverty</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness"> Physical illness</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity"> Lack of educational opportunity</label>
          <!-- Add more checkboxes as needed -->
        </div>
      </fieldset>

      <fieldset>
        <legend>Development Changes</legend>
        <div class="form-group checkbox-group">
          <label><input type="checkbox" v-model="form.enduringLifeStrain.poverty"> Poverty</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness"> Physical illness</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity"> Lack of educational opportunity</label>
          <!-- Add more checkboxes as needed -->
        </div>
      </fieldset>

      <fieldset>
        <legend>Normalization</legend>
        <div class="form-group checkbox-group">
          <label><input type="checkbox" v-model="form.enduringLifeStrain.poverty"> Poverty</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness"> Physical illness</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity"> Lack of educational opportunity</label>
          <!-- Add more checkboxes as needed -->
        </div>
      </fieldset>

      <fieldset>
        <legend>Feelings/Behaviour towards the incident</legend>
        <div class="form-group checkbox-group">
          <label><input type="checkbox" v-model="form.enduringLifeStrain.poverty"> Poverty</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness"> Physical illness</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity"> Lack of educational opportunity</label>
          <!-- Add more checkboxes as needed -->
        </div>
      </fieldset>

      <fieldset>
              <legend>Attachments</legend>
              <div class="form-group checkbox-group">
                <label><input type="checkbox" v-model="form.enduringLifeStrain.poverty"> Poverty</label>
                <label><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness"> Physical illness</label>
                <label><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity"> Lack of educational opportunity</label>
                <!-- Add more checkboxes as needed -->
              </div>
        </fieldset>

        <fieldset>
        <legend>Skills</legend>
        <div class="form-group checkbox-group">
          <label><input type="checkbox" v-model="form.enduringLifeStrain.poverty"> Poverty</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness"> Physical illness</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity"> Lack of educational opportunity</label>
          <!-- Add more checkboxes as needed -->
        </div>
      </fieldset>

      <fieldset>
        <legend>Resources</legend>
        <div class="form-group checkbox-group">
          <label><input type="checkbox" v-model="form.enduringLifeStrain.poverty"> Poverty</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness"> Physical illness</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity"> Lack of educational opportunity</label>
          <!-- Add more checkboxes as needed -->
        </div>
      </fieldset>

      <fieldset>
        <legend>Activities or source of income in the street</legend>
        <div class="form-group checkbox-group">
          <label><input type="checkbox" v-model="form.enduringLifeStrain.poverty"> Poverty</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness"> Physical illness</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity"> Lack of educational opportunity</label>
          <!-- Add more checkboxes as needed -->
        </div>
      </fieldset>

      <fieldset>
        <legend>Initial Assessment</legend>
        <div class="form-group checkbox-group">
          <label><input type="checkbox" v-model="form.enduringLifeStrain.poverty"> Poverty</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness"> Physical illness</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity"> Lack of educational opportunity</label>
          <!-- Add more checkboxes as needed -->
        </div>
      </fieldset>

      <fieldset>
        <legend>Reccomendations</legend>
        <div class="form-group checkbox-group">
          <label><input type="checkbox" v-model="form.enduringLifeStrain.poverty"> Poverty</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness"> Physical illness</label>
          <label><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity"> Lack of educational opportunity</label>
          <!-- Add more checkboxes as needed -->
        </div>
      </fieldset>


      <button type="submit">Submit</button>
    </form>
  </div>
</template>

