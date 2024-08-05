<template>
    <div class="p-10 bg-gray-100">
      <div class="bg-white p-8 rounded shadow-md">
        <div class="text-center mb-8">
          <h1 class="text-xl font-bold">GENERAL INTAKE SHEET</h1>
          <p>Date: ______________</p>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">I. Identifying Information:</h2>
          <div class="space-y-2">
            <div>
              <label>Name of client</label>
              <input type="text" class="border w-full px-2 py-1" />
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label>Age</label>
                <input type="text" class="border w-full px-2 py-1" />
              </div>
              <div>
                <label>Sex</label>
                <input type="text" class="border w-full px-2 py-1" />
              </div>
            </div>
            <div>
              <label>Address</label>
              <input type="text" class="border w-full px-2 py-1" />
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label>Date of Birth</label>
                <input type="text" class="border w-full px-2 py-1" />
              </div>
              <div>
                <label>Place of birth</label>
                <input type="text" class="border w-full px-2 py-1" />
              </div>
            </div>
            <div>
              <label>Religion</label>
              <input type="text" class="border w-full px-2 py-1" />
            </div>
            <div>
              <label>Occupation</label>
              <input type="text" class="border w-full px-2 py-1" />
            </div>
            <div>
              <label>Highest Educ'l Att't</label>
              <input type="text" class="border w-full px-2 py-1" />
            </div>
            <div>
              <label>Name of School</label>
              <input type="text" class="border w-full px-2 py-1" />
            </div>
            <div>
              <label>Class Adviser</label>
              <input type="text" class="border w-full px-2 py-1" />
            </div>
          </div>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">Vices/Start:</h2>
          <div class="space-y-2">
            <label><input type="checkbox" /> Gambling</label><br />
            <label><input type="checkbox" /> Drugs (_______)</label><br />
            <label><input type="checkbox" /> Cigarette</label><br />
            <label><input type="checkbox" /> Liquor</label><br />
            <label><input type="checkbox" /> Computer Games (_______ hrs)</label><br />
          </div>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">Schools Activities Achievement:</h2>
          <div class="space-y-2">
            <textarea class="border w-full px-2 py-1" rows="4"></textarea>
          </div>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">Family:</h2>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label>Mother's Occupation</label>
              <input type="text" class="border w-full px-2 py-1" />
            </div>
            <div>
              <label>Father's Occupation</label>
              <input type="text" class="border w-full px-2 py-1" />
            </div>
          </div>
          <div class="space-y-2">
            <label>Siblings:</label>
            <input type="text" class="border w-full px-2 py-1" />
            <input type="text" class="border w-full px-2 py-1" />
            <input type="text" class="border w-full px-2 py-1" />
          </div>
          <div class="space-y-2">
            <label>Responsible for Households Chores (_______________________)</label>
          </div>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">Community:</h2>
          <div class="space-y-2">
            <label>No. of Days Detention/Jail/CSWD/MSWDO</label>
            <input type="text" class="border w-full px-2 py-1" />
            <label>Water Source</label><br />
            <label><input type="checkbox" /> Water Source</label><br />
            <label><input type="checkbox" /> Light</label><br />
            <label><input type="checkbox" /> Barangay Facility</label><br />
            <label><input type="checkbox" /> Health Center</label><br />
            <label><input type="checkbox" /> Internet</label><br />
          </div>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">House made of:</h2>
          <div class="space-y-2">
            <input type="text" class="border w-full px-2 py-1" />
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'GeneralIntakeSheetPart2',
  };
  </script>
  
  <style scoped>
  /* Add any additional styling here */
  </style>
  