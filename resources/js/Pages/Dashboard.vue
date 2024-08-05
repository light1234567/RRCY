<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<style>
html, body {
  height: 100%;
  margin: 0;
}
</style>

<template>
    <AppLayout title="Dashboard">
        <template #header>
        </template>
        <div class="flex flex-col items-start -mt-40 justify-start min-h-screen p-4 bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 text-gray-800">
            <!-- Header -->
            <div class="w-full text-center mb-4">
                <h1 class="text-2xl font-bold text-white">Crime Dashboard</h1>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-2 gap-4 w-full">
                <!-- Summary Cards -->
                <div class="col-span-1 p-4 bg-white bg-opacity-70 rounded shadow-md flex items-center justify-center">
                    <div>
                        <h2 class="text-xl font-semibold text-center text-blue-800">Total No. of Child In Conflict with Law</h2>
                        <p class="text-4xl text-center mt-2 text-blue-600">50</p>
                    </div>
                </div>
                <div class="col-span-1 p-4 bg-white bg-opacity-70 rounded shadow-md flex items-center justify-center">
                    <div>
                        <h2 class="text-xl font-semibold text-center text-blue-800">Total No. of Crime Against Property</h2>
                        <p class="text-4xl text-center mt-2 text-blue-600">11</p>
                    </div>
                </div>
                <div class="col-span-1 p-4 bg-white bg-opacity-70 rounded shadow-md flex items-center justify-center">
                    <div>
                        <h2 class="text-xl font-semibold text-center text-blue-800">Total No. of Crime Against Person</h2>
                        <p class="text-4xl text-center mt-2 text-blue-600">39</p>
                    </div>
                </div>

                <!-- Crime Types Table -->
                <div class="col-span-1 p-4 bg-white bg-opacity-70 rounded shadow-md">
                    <h2 class="text-xl font-semibold mb-2 text-blue-800">Types of Crime</h2>
                    <table class="w-full text-left text-gray-800">
                        <thead>
                            <tr>
                                <th class="py-2">Types of Crime</th>
                                <th class="py-2">Total No. of Crime Against Property</th>
                                <th class="py-2">Total No. of Crime Against Person</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t border-gray-300">
                                <td class="py-2">Homicide</td>
                                <td class="py-2">8</td>
                                <td class="py-2">0</td>
                            </tr>
                            <tr class="border-t border-gray-300">
                                <td class="py-2">Murder</td>
                                <td class="py-2">10</td>
                                <td class="py-2">0</td>
                            </tr>
                            <tr class="border-t border-gray-300">
                                <td class="py-2">Physical Injuries</td>
                                <td class="py-2">4</td>
                                <td class="py-2">0</td>
                            </tr>
                            <tr class="border-t border-gray-300">
                                <td class="py-2">Rape</td>
                                <td class="py-2">18</td>
                                <td class="py-2">0</td>
                            </tr>
                            <tr class="border-t border-gray-300">
                                <td class="py-2">Robbery</td>
                                <td class="py-2">7</td>
                                <td class="py-2">2</td>
                            </tr>
                            <tr class="border-t border-gray-300">
                                <td class="py-2">Theft</td>
                                <td class="py-2">0</td>
                                <td class="py-2">9</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="border-t border-gray-300">
                                <td class="py-2">Total</td>
                                <td class="py-2">39</td>
                                <td class="py-2">11</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Bar Chart Placeholder -->
                <div class="col-span-1 p-4 bg-white bg-opacity-70 rounded shadow-md">
                    <h2 class="text-xl font-semibold mb-2 text-blue-800 text-center">No. of Child In Conflict with Law by Crime Committed</h2>
                    <div class="flex justify-center">
                        <div class="w-full">
                            <!-- Placeholder for the bar chart -->
                            <div class="bg-gray-300 h-64 flex items-center justify-center rounded">
                                <span>Bar Chart Placeholder</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Line Chart Placeholder -->
                <div class="col-span-1 p-4 bg-white bg-opacity-70 rounded shadow-md">
                    <h2 class="text-xl font-semibold mb-2 text-blue-800 text-center">No. of Crimes by Month</h2>
                    <div class="flex justify-center">
                        <div class="w-full">
                            <!-- Placeholder for the line chart -->
                            <div class="bg-gray-300 h-64 flex items-center justify-center rounded">
                                <span>Line Chart Placeholder</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
