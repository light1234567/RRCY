<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Helping/Intervention Plan</h1>
      <div class="mb-4">
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="font-semibold">Name:</label>
            <input type="text" v-model="plan.name" class="w-full border border-gray-300 p-2">
          </div>
          <div>
            <label class="font-semibold">Age:</label>
            <input type="text" v-model="plan.age" class="w-full border border-gray-300 p-2">
          </div>
          <div>
            <label class="font-semibold">Period:</label>
            <input type="text" v-model="plan.period" class="w-full border border-gray-300 p-2">
          </div>
          <div>
            <label class="font-semibold">Date Prepared:</label>
            <input type="date" v-model="plan.datePrepared" class="w-full border border-gray-300 p-2">
          </div>
        </div>
      </div>
      <table class="min-w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b">Objectives</th>
            <th class="py-2 px-4 border-b">Activities</th>
            <th class="py-2 px-4 border-b">Time Frame</th>
            <th class="py-2 px-4 border-b">Responsible Person</th>
            <th class="py-2 px-4 border-b">Expected Outcome</th>
            <th class="py-2 px-4 border-b">Remarks</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in plan.items" :key="index" class="hover:bg-gray-100">
            <td class="py-2 px-4 border-b"><input type="text" v-model="item.objectives" class="w-full border border-gray-300 p-1"></td>
            <td class="py-2 px-4 border-b"><input type="text" v-model="item.activities" class="w-full border border-gray-300 p-1"></td>
            <td class="py-2 px-4 border-b"><input type="text" v-model="item.timeFrame" class="w-full border border-gray-300 p-1"></td>
            <td class="py-2 px-4 border-b"><input type="text" v-model="item.responsiblePerson" class="w-full border border-gray-300 p-1"></td>
            <td class="py-2 px-4 border-b"><input type="text" v-model="item.expectedOutcome" class="w-full border border-gray-300 p-1"></td>
            <td class="py-2 px-4 border-b"><input type="text" v-model="item.remarks" class="w-full border border-gray-300 p-1"></td>
          </tr>
        </tbody>
      </table>
      <div class="mt-6 grid grid-cols-3 gap-4">
        <div>
          <label class="font-semibold">Prepared by:</label>
          <div class="mt-2">__________________________</div>
          <div class="text-sm mt-1">Social Welfare Officer I</div>
        </div>
        <div>
          <label class="font-semibold">Conformed by:</label>
          <div class="mt-2">__________________________</div>
          <div class="text-sm mt-1">Resident</div>
        </div>
        <div>
          <label class="font-semibold">Noted by:</label>
          <div class="mt-2">__________________________</div>
          <div class="text-sm mt-1">Center Head/ SWO IV</div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        plan: {
          name: '',
          age: '',
          period: '',
          datePrepared: '',
          items: [
            { objectives: '', activities: '', timeFrame: '', responsiblePerson: '', expectedOutcome: '', remarks: '' },
            { objectives: '', activities: '', timeFrame: '', responsiblePerson: '', expectedOutcome: '', remarks: '' },
            { objectives: '', activities: '', timeFrame: '', responsiblePerson: '', expectedOutcome: '', remarks: '' },
            { objectives: '', activities: '', timeFrame: '', responsiblePerson: '', expectedOutcome: '', remarks: '' },
            { objectives: '', activities: '', timeFrame: '', responsiblePerson: '', expectedOutcome: '', remarks: '' },
            { objectives: '', activities: '', timeFrame: '', responsiblePerson: '', expectedOutcome: '', remarks: '' },
          ]
        }
      }
    }
  }
  </script>
  
  <style>
  /* Tailwind CSS is included via CDN in the index.html or main.js */
  </style>
  