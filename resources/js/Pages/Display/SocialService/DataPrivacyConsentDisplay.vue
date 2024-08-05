<template>
    <div class="bg-gray-100 p-10">
      <!-- Page 1 -->
      <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mb-10">
        <div class="flex items-center justify-between mb-4">
          <img src="path_to_logo.png" alt="DSWD Logo" class="h-16">
          <div class="text-right">
            <p class="text-xs">DSPTD-QF-01-A | REV 01 | 12 SEP 2023</p>
          </div>
        </div>
        <h1 class="text-2xl font-bold text-center mb-4">DATA PRIVACY CONSENT</h1>
  
        <div class="mb-6">
          <p>To Whom It May Concern:</p>
          <p class="mt-4">
            I, <input type="text" class="border-b border-gray-300 outline-none focus:border-blue-500" v-model="form.name" placeholder="Name">, give my consent for the information concerning my file to be furnished by the DSWD-Regional Rehabilitation Center for Youth (RRCY) and/or its authorized personnel to Philippine courts, concerned local government units and legal professionals. I request that any relevant information that may be required for purposes enumerated hereunder be provided in accordance with the provisions of the Data Privacy Act of 2012:
          </p>
          <ol class="list-decimal ml-6 mt-4">
            <li>To assist in responding to Criminal Cases (Court, Lawyer, Prosecutor)</li>
            <li>To report to the PNP any untoward incident by the resident</li>
            <li>To request reports from the concerned LGUs e.g. Parenting Capability Assessment Report (PCAR), Transfer Summary Report and LGU Claims</li>
            <li>To assist in responding to the health needs (medical, psychological), school requirements and training agencies (LTO, TESDA, etc)</li>
            <li>To assist in the provision of financial assistance intended for basic needs, travel expenses and medical needs</li>
            <li>To submit monthly, quarterly, semestral and annual reports to the Field Office and Central Office</li>
          </ol>
          <p class="mt-4">
            I understand and accept that this will include access to personal data and records submitted, which may be considered sensitive personal data as provided for under Republic Act No. 10173, otherwise known as the Data Privacy Act of 2012.
          </p>
          <p class="mt-4">
            Further, any records and related information associated with my case shall be kept from any and all public disclosure and shall be retained only for as long as necessary for the fulfillment of the purposes above-stated.
          </p>
          <p class="mt-4">
            I understand and agree that this consent will remain valid and in force until I revoke it in writing.
          </p>
        </div>
  
        <div class="flex justify-between items-center mt-8">
          <div>
            <label class="block text-gray-700">Name and signature (Client):</label>
            <input type="text" class="w-full mt-2 p-2 border border-gray-300 rounded-md" v-model="form.clientSignature">
          </div>
          <div>
            <label class="block text-gray-700">Date:</label>
            <input type="date" class="w-full mt-2 p-2 border border-gray-300 rounded-md" v-model="form.date">
          </div>
        </div>
  
        <div class="text-center text-xs mt-10">
          <p>PAGE 1 of 2</p>
          <p>DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY), P.Y. Reyes Drive, Bajada, Davao City</p>
          <p>Email: rcydavao@gmail.com | Tel. No: 299-0348 | Website: www.dswd.gov.ph</p>
        </div>
      </div>
  
      <!-- Page 2 -->
      <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <div class="text-right mb-4">
          <p class="text-xs">DSPTD-QF-01-A | REV 01 | 12 SEP 2023</p>
        </div>
  
        <div class="mb-6">
          <label class="block text-gray-700 mb-2">Name and signature (Parent/Guardian):</label>
          <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.guardianSignature">
        </div>
  
        <div class="text-center text-xs mt-10">
          <p>PAGE 2 of 2</p>
          <p>DSWD FIELD OFFICE XI, PROTECTIVE SERVICES DIVISION, REGIONAL REHABILITATION CENTER FOR YOUTH</p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        form: {
          name: '',
          clientSignature: '',
          date: '',
          guardianSignature: ''
        }
      }
    }
  }
  </script>
  
  <style scoped>
  /* Add any custom styles here if needed */
  </style>