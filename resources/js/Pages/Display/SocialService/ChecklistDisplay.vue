<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Checklist of Requirements during Admission</h1>
      <table class="min-w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b">No.</th>
            <th class="py-2 px-4 border-b">Documents</th>
            <th class="py-2 px-4 border-b">Yes</th>
            <th class="py-2 px-4 border-b">No</th>
            <th class="py-2 px-4 border-b">Remarks</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in checklist" :key="index" class="hover:bg-gray-100">
            <td class="py-2 px-4 border-b">{{ index + 1 }}</td>
            <td class="py-2 px-4 border-b">{{ item.document }}</td>
            <td class="py-2 px-4 border-b"><input type="checkbox" v-model="item.yes" /></td>
            <td class="py-2 px-4 border-b"><input type="checkbox" v-model="item.no" /></td>
            <td class="py-2 px-4 border-b"><input type="text" v-model="item.remarks" class="w-full border border-gray-300 p-1" /></td>
          </tr>
        </tbody>
      </table>
  
      <h2 class="text-xl font-semibold mt-6 mb-4">RRCY Forms</h2>
      <table class="min-w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b">No.</th>
            <th class="py-2 px-4 border-b">Forms</th>
            <th class="py-2 px-4 border-b">Yes</th>
            <th class="py-2 px-4 border-b">No</th>
            <th class="py-2 px-4 border-b">Remarks</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in rrForms" :key="index" class="hover:bg-gray-100">
            <td class="py-2 px-4 border-b">{{ index + 1 }}</td>
            <td class="py-2 px-4 border-b">{{ item.form }}</td>
            <td class="py-2 px-4 border-b"><input type="checkbox" v-model="item.yes" /></td>
            <td class="py-2 px-4 border-b"><input type="checkbox" v-model="item.no" /></td>
            <td class="py-2 px-4 border-b"><input type="text" v-model="item.remarks" class="w-full border border-gray-300 p-1" /></td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        checklist: [
          { document: 'Commitment/Court Order', yes: false, no: false, remarks: '' },
          { document: 'Referral Letter', yes: false, no: false, remarks: '' },
          { document: 'Social Case Study Report', yes: false, no: false, remarks: '' },
          { document: 'Medical Certificate', yes: false, no: false, remarks: '' },
          { document: 'Negative RT-PCR COVID-19 Test Result', yes: false, no: false, remarks: '' },
          { document: 'Laboratory Examination Result', yes: false, no: false, remarks: '' },
          { document: 'Psychological Assessment and Evaluation', yes: false, no: false, remarks: '' },
          { document: 'Birth Certificate/Baptismal Cert', yes: false, no: false, remarks: '' },
          { document: 'School Documents (Form 137) if applicable', yes: false, no: false, remarks: '' },
          { document: 'List of Belongings', yes: false, no: false, remarks: '' },
        ],
        rrForms: [
          { form: 'Admission Slip', yes: false, no: false, remarks: '' },
          { form: 'General Intake Form', yes: false, no: false, remarks: '' },
          { form: 'Admission Contract', yes: false, no: false, remarks: '' },
          { form: 'Parent\'s Consent', yes: false, no: false, remarks: '' },
          { form: 'Inventory of Client\'s belongings', yes: false, no: false, remarks: '' },
          { form: 'Kasabutan "Good Performance"', yes: false, no: false, remarks: '' },
          { form: 'Kasabutan (Bulitas)', yes: false, no: false, remarks: '' },
          { form: 'Data Privacy Consent Form', yes: false, no: false, remarks: '' },
          { form: 'Talambuhay', yes: false, no: false, remarks: '' },
          { form: 'SFI', yes: false, no: false, remarks: '' },
          { form: 'Daily Journal', yes: false, no: false, remarks: '' },
        ]
      }
    }
  }
  </script>
  
  <style>
  /* Tailwind CSS is included via CDN in the index.html or main.js */
  </style>
  