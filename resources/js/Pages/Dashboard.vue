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
        <h1 class="text-xl font-bold -ml-4 text-customBlue">Dashboard</h1>
      </template>
        <div class="flex flex-col items-start -mt-40 justify-start min-h-screen p-4 bg-gradient-to-r from-yellow-400 via-red-400 to-pink-500 text-gray-800">
            <!-- Header -->
            <div class="w-full text-center mb-4">
                <h1 class="text-2xl font-bold text-white">Crime Dashboard (Totally Not Under Construction)</h1>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-2 gap-4 w-full">
                <!-- Summary Cards -->
                <div class="col-span-1 p-4 bg-white bg-opacity-70 rounded shadow-md flex items-center justify-center">
                    <div>
                        <h2 class="text-xl font-semibold text-center text-blue-800">Total No. of Children Confused with the Law</h2>
                        <p class="text-4xl text-center mt-2 text-blue-600">🤷‍♂️</p>
                    </div>
                </div>
                <div class="col-span-1 p-4 bg-white bg-opacity-70 rounded shadow-md flex items-center justify-center">
                    <div>
                        <h2 class="text-xl font-semibold text-center text-blue-800">Total No. of Crimes Against Property (Like Stealing Your Meme)</h2>
                        <p class="text-4xl text-center mt-2 text-blue-600">🏠💼</p>
                    </div>
                </div>
                <div class="col-span-1 p-4 bg-white bg-opacity-70 rounded shadow-md flex items-center justify-center">
                    <div>
                        <h2 class="text-xl font-semibold text-center text-blue-800">Total No. of Crimes Against Persons (Ouch)</h2>
                        <p class="text-4xl text-center mt-2 text-blue-600">💥</p>
                    </div>
                </div>

                <!-- Crime Types Table -->
                <div class="col-span-1 p-4 bg-white bg-opacity-70 rounded shadow-md">
                    <h2 class="text-xl font-semibold mb-2 text-blue-800">Types of Crimes (Like Seriously)</h2>
                    <table class="w-full text-left text-gray-800">
                        <thead>
                            <tr>
                                <th class="py-2">Crime Types</th>
                                <th class="py-2">Property Crimes (Like Robbing a Meme)</th>
                                <th class="py-2">Person Crimes (Don't Do It)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t border-gray-300">
                                <td class="py-2">Homicide (Yikes)</td>
                                <td class="py-2">🤷‍♂️</td>
                                <td class="py-2">🚫</td>
                            </tr>
                            <tr class="border-t border-gray-300">
                                <td class="py-2">Murder (Oof)</td>
                                <td class="py-2">🔪</td>
                                <td class="py-2">🚫</td>
                            </tr>
                            <tr class="border-t border-gray-300">
                                <td class="py-2">Physical Injuries (Ouch)</td>
                                <td class="py-2">🩹</td>
                                <td class="py-2">🚫</td>
                            </tr>
                            <tr class="border-t border-gray-300">
                                <td class="py-2">Rape (Never Funny)</td>
                                <td class="py-2">🚫</td>
                                <td class="py-2">🚫</td>
                            </tr>
                            <tr class="border-t border-gray-300">
                                <td class="py-2">Robbery (Not Cool)</td>
                                <td class="py-2">💰</td>
                                <td class="py-2">🔫</td>
                            </tr>
                            <tr class="border-t border-gray-300">
                                <td class="py-2">Theft (No Way)</td>
                                <td class="py-2">👜</td>
                                <td class="py-2">🚫</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="border-t border-gray-300">
                                <td class="py-2">Total (Do Better)</td>
                                <td class="py-2">🤷‍♂️</td>
                                <td class="py-2">🚫</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Bar Chart Placeholder -->
                <div class="col-span-1 p-4 bg-white bg-opacity-70 rounded shadow-md">
                    <h2 class="text-xl font-semibold mb-2 text-blue-800 text-center">No. of Child In Conflict with Law by Crime Committed (Coming Soon)</h2>
                    <div class="flex justify-center">
                        <div class="w-full">
                            <!-- Placeholder for the bar chart -->
                            <div class="bg-gray-300 h-64 flex items-center justify-center rounded">
                                <img src="https://i.imgur.com/4M7IWwP.png" alt="Under Construction Meme" class="h-full">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Line Chart Placeholder -->
                <div class="col-span-1 p-4 bg-white bg-opacity-70 rounded shadow-md">
                    <h2 class="text-xl font-semibold mb-2 text-blue-800 text-center">No. of Crimes by Month (Not Yet Though)</h2>
                    <div class="flex justify-center">
                        <div class="w-full">
                            <!-- Placeholder for the line chart -->
                            <div class="bg-gray-300 h-64 flex items-center justify-center rounded">
                                <img src="https://i.imgur.com/4M7IWwP.png" alt="Under Construction Meme" class="h-full">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
