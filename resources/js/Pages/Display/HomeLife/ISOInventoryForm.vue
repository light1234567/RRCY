<template>
    <div class="mx-auto p-8 bg-gray-100 rounded-lg max-w-full">
      <form @submit.prevent="submitForm" class="space-y-8 w-full">
       <!-- Header -->
      <div class="border border-gray-300 p-6 rounded-md bg-white">
        <h1 class="font-bold text-lg mb-4">Monthly Inventory of Belongings</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div class="space-y-2">
            <label for="month" class="block font-medium">For the Month of:</label>
            <input type="text" id="month" required class="block w-full p-2 border border-gray-300 rounded-md" placeholder="Enter month">
          </div>
          <div class="space-y-2">
            <label for="drn" class="block font-medium">DRN:</label>
            <input type="text" id="drn" class="block w-full p-2 border border-gray-300 rounded-md" placeholder="Enter DRN">
          </div>
        </div>
  
          <!-- Inventory Table -->
          <div class="space-y-4">
            <table class="w-full border-collapse">
              <thead>
                <tr class="bg-gray-200">
                  <th class="border p-2 text-left">Item</th>
                  <th class="border p-2 text-left">Description</th>
                  <th class="border p-2 text-left">Qty</th>
                  <th class="border p-2 text-left">Brand</th>
                  <th class="border p-2 text-left">Size</th>
                  <th class="border p-2 text-left">Color</th>
                  <th class="border p-2 text-left">Old</th>
                  <th class="border p-2 text-left">New</th>
                  <th class="border p-2 text-left">Remarks</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in inventoryItems" :key="index">
                  <td class="border p-2">{{ item.name }}</td>
                  <td class="border p-2">
                    <input type="text" v-model="item.description" class="w-full p-1 border border-gray-300 rounded-md">
                  </td>
                  <td class="border p-2">
                    <input type="text" v-model="item.qty" class="w-full p-1 border border-gray-300 rounded-md">
                  </td>
                  <td class="border p-2">
                    <input type="text" v-model="item.brand" class="w-full p-1 border border-gray-300 rounded-md">
                  </td>
                  <td class="border p-2">
                    <input type="text" v-model="item.size" class="w-full p-1 border border-gray-300 rounded-md">
                  </td>
                  <td class="border p-2">
                    <input type="text" v-model="item.color" class="w-full p-1 border border-gray-300 rounded-md">
                  </td>
                  <td class="border p-2">
                    <input type="text" v-model="item.old" class="w-full p-1 border border-gray-300 rounded-md">
                  </td>
                  <td class="border p-2">
                    <input type="text" v-model="item.new" class="w-full p-1 border border-gray-300 rounded-md">
                  </td>
                  <td class="border p-2">
                    <input type="text" v-model="item.remarks" class="w-full p-1 border border-gray-300 rounded-md">
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
  
          <!-- Signatures Section -->
          <div class="space-y-4 mt-6">
            <div class="flex justify-between">
              <div class="space-y-2">
                <label for="residentName" class="block font-medium">Name & Signature of Resident:</label>
                <input type="text" id="residentName" class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
              <div class="space-y-2">
                <label for="houseparentName" class="block font-medium">Name & Signature of Houseparent:</label>
                <input type="text" id="houseparentName" class="block w-full p-2 border border-gray-300 rounded-md">
              </div>
            </div>
            <p class="text-sm">Noted: VAN M. DE LEON</p>
          </div>
        </div>
  
        <!-- Submit Button -->
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Submit</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    name: 'MonthlyInventoryForm',
    data() {
      return {
        inventoryItems: [
          { name: 'T shirt', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'T shirt Uranay', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Polo Shirt', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Polo Uniform', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Polo', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Short Pants', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Long Pants', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Long Pants Uniform', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Long Sleeve ', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Sando Jersey ', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'School Shoes ', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Basketball Shoes ', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Walking Shoes ', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Bed Sheet ', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Slipper ', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Blanket ', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Pillows ', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Pillow Case ', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Towel ', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Face Towel ', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Socks ', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Brief/ Boxer ', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Jogging Pants', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Jacket/sweatshirt ', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'CAP ', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' },
          { name: 'Pack Bag ', description: '', qty: '', brand: '', size: '', color: '', old: '', new: '', remarks: '' }
        ]
      };
    },
    methods: {
      submitForm() {
        // Handle form submission
        console.log('Form submitted');
      }
    }
  }
  </script>
  