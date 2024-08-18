<template>
    <AppLayout title="Users">
      <div class="p-6 ml-4">
        <!-- Header -->
        <div class="flex items-center justify-between -mt-44 mb-6">
          <h2 class="text-xl font-bold text-purple-700">User Verification</h2>
          <button class="bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-700">List of Users</button>
        </div>
  
        <!-- Sections -->
        <div v-for="(sector, index) in sectors" :key="index" class="mb-6">
          <!-- Sector Header -->
          <div class="bg-blue-200 text-blue-800 font-semibold py-2 px-4 rounded-t">
            {{ sector.name }}
          </div>
  
          <!-- Table -->
          <div class="bg-white shadow-md rounded-b">
            <table class="min-w-full">
              <thead>
                <tr class="bg-gray-100 border-b">
                  <th class="py-2 px-4 text-left">Name</th>
                  <th class="py-2 px-4 text-left">Email</th>
                  <th class="py-2 px-4 text-left">Date & Time</th>
                  <th class="py-2 px-4 text-left">Current Status</th>
                  <th class="py-2 px-4 text-left">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, idx) in sector.users" :key="idx" class="border-b">
                  <td class="py-2 px-4">{{ user.name }}</td>
                  <td class="py-2 px-4 text-blue-600 underline">{{ user.email }}</td>
                  <td class="py-2 px-4">{{ user.dateTime }}</td>
                  <td class="py-2 px-4">{{ user.status }}</td>
                  <td class="py-2 px-4 flex space-x-2">
                    <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-700">Accept</button>
                    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700">Reject</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </AppLayout>
  </template>
  
  <script setup>
  import { reactive } from 'vue';
  import AppLayout from '@/Layouts/AppLayout.vue';
  
  const sectors = reactive([
    {
      name: 'Social Service Sector',
      users: [
        { name: 'Amor Jones', email: 'amorjones@gmail.com', dateTime: 'July 04, 2024 / 8:04 am', status: 'Pending' },
        { name: 'Rizalyn Viloria', email: 'rizalynviloria@gmail.com', dateTime: 'July 04, 2024 / 10:23 am', status: 'Pending' },
      ],
    },
    {
      name: 'Psychological team sector',
      users: [
        { name: 'Amor Jones', email: 'amorjones@gmail.com', dateTime: 'July 04, 2024 / 8:04 am', status: 'Pending' },
        { name: 'Rizalyn Viloria', email: 'rizalynviloria@gmail.com', dateTime: 'July 04, 2024 / 10:23 am', status: 'Pending' },
      ],
    },
    {
      name: 'Court order sector',
      users: [
        { name: 'Amor Jones', email: 'amorjones@gmail.com', dateTime: 'July 04, 2024 / 8:04 am', status: 'Pending' },
        { name: 'Rizalyn Viloria', email: 'rizalynviloria@gmail.com', dateTime: 'July 04, 2024 / 10:23 am', status: 'Pending' },
      ],
    },
    {
      name: 'Homelife Services',
      users: [
        { name: 'Amor Jones', email: 'amorjones@gmail.com', dateTime: 'July 04, 2024 / 8:04 am', status: 'Pending' },
        { name: 'Rizalyn Viloria', email: 'rizalynviloria@gmail.com', dateTime: 'July 04, 2024 / 10:23 am', status: 'Pending' },
      ],
    },
    {
      name: 'Nursing Care',
      users: [
        { name: 'Amor Jones', email: 'amorjones@gmail.com', dateTime: 'July 04, 2024 / 8:04 am', status: 'Pending' },
        { name: 'Rizalyn Viloria', email: 'rizalynviloria@gmail.com', dateTime: 'July 04, 2024 / 10:23 am', status: 'Pending' },
      ],
    },
  ]);
  </script>
  
  <style scoped>
  /* Add any additional styling here */
  </style>
  