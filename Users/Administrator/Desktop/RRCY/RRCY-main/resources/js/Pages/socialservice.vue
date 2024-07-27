<script>
import { ref } from 'vue';

export default {
  data() {
    return {
      currentTab: 0,
      tabs: [
        'Admission Slip',
        'General Intake Sheet'
      ],
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
    },
    setCurrentTab(index) {
      this.currentTab = index;
    }
  }
};
</script>


<template>
  <div class="max-w-4xl mx-auto p-6 bg-gray-100 rounded-lg">
    <!-- Tab Navigation -->
    <div class="flex space-x-4 mb-6">
      <button
        v-for="(tab, index) in tabs"
        :key="index"
        :class="{'bg-blue-500 text-white': currentTab === index, 'bg-gray-200': currentTab !== index }"
        class="py-2 px-4 rounded-md"
        @click="setCurrentTab(index)"
      >
        {{ tab }}
      </button>
    </div>

    <form @submit.prevent="submitForm">
      <!-- Admission Slip Tab -->
      <fieldset v-if="currentTab === 0" class="border border-gray-300 p-4 mb-4 rounded-lg">
        <legend class="text-lg font-bold mb-4">Admission Slip</legend>
        <div class="mb-4">
          <label for="name" class="block mb-1">Name:</label>
          <input type="text" id="name" v-model="form.name" placeholder="Enter name" required class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="sex" class="block mb-1">Sex:</label>
          <select id="sex" v-model="form.sex" required class="w-full px-3 py-2 border rounded-md">
            <option value="" disabled>Select</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
        <div class="mb-4">
          <label for="address" class="block mb-1">Address:</label>
          <input type="text" id="address" v-model="form.address" placeholder="Enter address" required class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="religion" class="block mb-1">Religion:</label>
          <input type="text" id="religion" v-model="form.religion" placeholder="Enter religion" class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="dob" class="block mb-1">Date/Place of Birth:</label>
          <input type="date" id="dob" v-model="form.dob" required class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="committingCourt" class="block mb-1">Committing Court:</label>
          <input type="text" id="committingCourt" v-model="form.committingCourt" placeholder="Enter committing court" class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="criminalCaseNo" class="block mb-1">Crim. Case #:</label>
          <input type="text" id="criminalCaseNo" v-model="form.criminalCaseNo" placeholder="Enter criminal case number" class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="offenseCommitted" class="block mb-1">Offense Committed:</label>
          <input type="text" id="offenseCommitted" v-model="form.offenseCommitted" placeholder="Enter offense committed" class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="dateAdmitted" class="block mb-1">Date admitted to Center:</label>
          <input type="date" id="dateAdmitted" v-model="form.dateAdmitted" required class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="daysInJail" class="block mb-1">No. of Days in Jail:</label>
          <input type="number" id="daysInJail" v-model="form.daysInJail" placeholder="Enter number of days" min="0" required class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="daysInDetention" class="block mb-1">No. of Days in Detention Center:</label>
          <input type="number" id="daysInDetention" v-model="form.daysInDetention" placeholder="Enter number of days" min="0" required class="w-full px-3 py-2 border rounded-md">
        </div>
        <legend class="text-lg font-bold mb-4">Distinguishing Marks</legend>
        <div class="mb-4">
          <label for="tattoo" class="block mb-1">a. Tattoo/Scars:</label>
          <input type="text" id="tattoo" v-model="form.distinguishingMarks.tattoo" placeholder="Enter tattoo details" class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="height" class="block mb-1">b. Height:</label>
          <input type="text" id="height" v-model="form.distinguishingMarks.height" placeholder="Enter height" class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="weight" class="block mb-1">c. Weight:</label>
          <input type="text" id="weight" v-model="form.distinguishingMarks.weight" placeholder="Enter weight" class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="eyeColor" class="block mb-1">d. Colour of Eye:</label>
          <input type="text" id="eyeColor" v-model="form.distinguishingMarks.eyeColor" placeholder="Enter eye color" class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="skinColor" class="block mb-1">e. Skin:</label>
          <input type="text" id="skinColor" v-model="form.distinguishingMarks.skinColor" placeholder="Enter skin color" class="w-full px-3 py-2 border rounded-md">
        </div>
        <legend class="text-lg font-bold mb-4">Documents Submitted</legend>
        <div class="mb-4 space-y-2">
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.documents.scsr" class="form-checkbox h-5 w-5"> <span>1.) SCSR</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.documents.courtOrder" class="form-checkbox h-5 w-5"> <span>2.) Court Order</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.documents.medicalCertificates" class="form-checkbox h-5 w-5"> <span>3.) Medical Certificates</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.documents.consConsent" class="form-checkbox h-5 w-5"> <span>4.) Consent from Parents</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.documents.schoolRecords" class="form-checkbox h-5 w-5"> <span>5.) School Records</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.documents.others" class="form-checkbox h-5 w-5"> <span>6.) Others</span></label>
        </div>
        <legend class="text-lg font-bold mb-4">Additional Information</legend>
        <div class="mb-4">
          <label for="generalImpression" class="block mb-1">General Impression upon admission:</label>
          <textarea id="generalImpression" v-model="form.generalImpression" placeholder="Enter general impression" class="w-full px-3 py-2 border rounded-md"></textarea>
        </div>
        <div class="mb-4">
          <label for="actionTaken" class="block mb-1">Action Taken:</label>
          <textarea id="actionTaken" v-model="form.actionTaken" placeholder="Enter action taken" class="w-full px-3 py-2 border rounded-md"></textarea>
        </div>
      </fieldset>

      <!-- General Intake Sheet Tab -->
      <fieldset v-if="currentTab === 1" class="border border-gray-300 p-4 mb-4 rounded-lg">
        <legend class="text-lg font-bold mb-4">General Intake Sheet</legend>
        <div class="mb-4">
          <label for="name" class="block mb-1">Name of Client:</label>
          <input type="text" id="name" v-model="form.name" placeholder="Enter name" required class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="date" class="block mb-1">Date:</label>
          <input type="date" id="date" v-model="form.date" placeholder="Enter Date" required class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="age" class="block mb-1">Age:</label>
          <input type="number" id="age" v-model="form.age" placeholder="Enter Age" required class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="sex" class="block mb-1">Sex:</label>
          <select id="sex" v-model="form.sex" required class="w-full px-3 py-2 border rounded-md">
            <option value="" disabled>Select</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
        <div class="mb-4">
          <label for="address" class="block mb-1">Address:</label>
          <input type="text" id="address" v-model="form.address" placeholder="Enter address" required class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="religion" class="block mb-1">Religion:</label>
          <input type="text" id="religion" v-model="form.religion" placeholder="Enter religion" class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="occupation" class="block mb-1">Occupation:</label>
          <input type="text" id="occupation" v-model="form.occupation" placeholder="Enter Occupation" class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="dob" class="block mb-1">Date/Place of Birth:</label>
          <input type="date" id="dob" v-model="form.dob" required class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="HEA" class="block mb-1">Highest Educational Attainment:</label>
          <input type="text" id="HEA" v-model="form.HEA" placeholder="Enter Attainment" class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="religion" class="block mb-1">Name of School:</label>
          <input type="text" id="religion" v-model="form.NOS" placeholder="Enter Name of School" class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="mb-4">
          <label for="religion" class="block mb-1">Class Adviser:</label>
          <input type="text" id="religion" v-model="form.classAdviser" placeholder="Enter Class Adviser" class="w-full px-3 py-2 border rounded-md">
        </div>
        <legend class="text-lg font-bold mb-4">Problem Presented</legend>
        <div class="mb-4">
          <textarea v-model="form.problemPresented" class="w-full px-3 py-2 border rounded-md"></textarea>
        </div>
        <legend class="text-lg font-bold mb-4">Brief Physical Description</legend>
        <div class="mb-4">
          <textarea v-model="form.physicalDescription" placeholder="Childs Description" class="w-full px-3 py-2 border rounded-md"></textarea>
        </div>
        <legend class="text-lg font-bold mb-4">Major Life Events</legend>
        <div class="mb-4 space-y-2">
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.majorLifeEvents.deathOfParents" class="form-checkbox h-5 w-5"> <span>Death of Parents</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.majorLifeEvents.separationFromFamily" class="form-checkbox h-5 w-5"> <span>Separation from the family</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.majorLifeEvents.Victimofnaturalmanmadedisaster" class="form-checkbox h-5 w-5"> <span>Victim of natural / manmade disaster</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.majorLifeEvents.Victimofapprehension" class="form-checkbox h-5 w-5"> <span>Victim of apprehension</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.majorLifeEvents.Victimofphysicalabuse" class="form-checkbox h-5 w-5"> <span>Victim of physical abuse</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.majorLifeEvents.withsuicidaltendencies" class="form-checkbox h-5 w-5"> <span>With suicidal tendencies</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.majorLifeEvents.mistakenidentity" class="form-checkbox h-5 w-5"> <span>Mistaken identity</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.majorLifeEvents.abandonment" class="form-checkbox h-5 w-5"> <span>Abandonment</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.majorLifeEvents.seriousAccident" class="form-checkbox h-5 w-5"> <span>Serious Accident</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.majorLifeEvents.Victimofdemolition" class="form-checkbox h-5 w-5"> <span>Victim of demolition</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.majorLifeEvents.Victimofsexualabuse" class="form-checkbox h-5 w-5"> <span>Victim of sexual abuse</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.majorLifeEvents.Victimofverbalabuse" class="form-checkbox h-5 w-5"> <span>Victim of verbal abuse</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.majorLifeEvents.AcquiredDisability" class="form-checkbox h-5 w-5"> <span>Acquired Disability</span></label>
          <textarea v-model="form.majorLifeEvents.Othersplsspecify" placeholder="Others pls specify" class="w-full px-3 py-2 border rounded-md"></textarea>
        </div>
        <legend class="text-lg font-bold mb-4">Enduring Life Strain</legend>
        <div class="mb-4 space-y-2">
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.poverty" class="form-checkbox h-5 w-5"> <span>Poverty</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness" class="form-checkbox h-5 w-5"> <span>Physical illness</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity" class="form-checkbox h-5 w-5"> <span>Lack of educational opportunity</span></label>
        </div>
        <legend class="text-lg font-bold mb-4">Life Transition</legend>
        <div class="mb-4 space-y-2">
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.poverty" class="form-checkbox h-5 w-5"> <span>Poverty</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness" class="form-checkbox h-5 w-5"> <span>Physical illness</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity" class="form-checkbox h-5 w-5"> <span>Lack of educational opportunity</span></label>
        </div>
        <legend class="text-lg font-bold mb-4">Development Changes</legend>
        <div class="mb-4 space-y-2">
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.poverty" class="form-checkbox h-5 w-5"> <span>Poverty</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness" class="form-checkbox h-5 w-5"> <span>Physical illness</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity" class="form-checkbox h-5 w-5"> <span>Lack of educational opportunity</span></label>
        </div>
        <legend class="text-lg font-bold mb-4">Normalization</legend>
        <div class="mb-4 space-y-2">
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.poverty" class="form-checkbox h-5 w-5"> <span>Poverty</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness" class="form-checkbox h-5 w-5"> <span>Physical illness</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity" class="form-checkbox h-5 w-5"> <span>Lack of educational opportunity</span></label>
        </div>
        <legend class="text-lg font-bold mb-4">Feelings/Behaviour towards the incident</legend>
        <div class="mb-4 space-y-2">
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.poverty" class="form-checkbox h-5 w-5"> <span>Poverty</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness" class="form-checkbox h-5 w-5"> <span>Physical illness</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity" class="form-checkbox h-5 w-5"> <span>Lack of educational opportunity</span></label>
        </div>
        <legend class="text-lg font-bold mb-4">Attachments</legend>
        <div class="mb-4 space-y-2">
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.poverty" class="form-checkbox h-5 w-5"> <span>Poverty</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness" class="form-checkbox h-5 w-5"> <span>Physical illness</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity" class="form-checkbox h-5 w-5"> <span>Lack of educational opportunity</span></label>
        </div>
        <legend class="text-lg font-bold mb-4">Skills</legend>
        <div class="mb-4 space-y-2">
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.poverty" class="form-checkbox h-5 w-5"> <span>Poverty</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness" class="form-checkbox h-5 w-5"> <span>Physical illness</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity" class="form-checkbox h-5 w-5"> <span>Lack of educational opportunity</span></label>
        </div>
        <legend class="text-lg font-bold mb-4">Resources</legend>
        <div class="mb-4 space-y-2">
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.poverty" class="form-checkbox h-5 w-5"> <span>Poverty</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness" class="form-checkbox h-5 w-5"> <span>Physical illness</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity" class="form-checkbox h-5 w-5"> <span>Lack of educational opportunity</span></label>
        </div>
        <legend class="text-lg font-bold mb-4">Activities or source of income in the street</legend>
        <div class="mb-4 space-y-2">
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.poverty" class="form-checkbox h-5 w-5"> <span>Poverty</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness" class="form-checkbox h-5 w-5"> <span>Physical illness</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity" class="form-checkbox h-5 w-5"> <span>Lack of educational opportunity</span></label>
        </div>
        <legend class="text-lg font-bold mb-4">Initial Assessment</legend>
        <div class="mb-4 space-y-2">
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.poverty" class="form-checkbox h-5 w-5"> <span>Poverty</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness" class="form-checkbox h-5 w-5"> <span>Physical illness</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity" class="form-checkbox h-5 w-5"> <span>Lack of educational opportunity</span></label>
        </div>
        <legend class="text-lg font-bold mb-4">Recommendations</legend>
        <div class="mb-4 space-y-2">
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.poverty" class="form-checkbox h-5 w-5"> <span>Poverty</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.physicalIllness" class="form-checkbox h-5 w-5"> <span>Physical illness</span></label>
          <label class="flex items-center space-x-2"><input type="checkbox" v-model="form.enduringLifeStrain.lackOfOpportunity" class="form-checkbox h-5 w-5"> <span>Lack of educational opportunity</span></label>
        </div>
      </fieldset>

      <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded-md">Submit</button>
    </form>
  </div>
</template>
