<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { ref } from 'vue';


// Sample data for clients
const clients = ref([
    { id: '001', name: 'John Doe', crimeStatus: 'Pending' },
    { id: '002', name: 'Jane Smith', crimeStatus: 'Convicted' },
    // Add more clients as needed
]);


// Function to handle row click
const handleRowClick = (client) => {
    // Replace with your logic for navigation or action
    router.push({ name: 'client-detail', params: { id: client.id } });
};

// Function to handle left box click
const handleLeftClick = (event, client) => {
    event.stopPropagation(); // Prevents the row click event from being triggered
    console.log(`Left box clicked for client: ${client.name}`);
};

// Function to handle right box click
const handleRightClick = (event, client) => {
    event.stopPropagation(); // Prevents the row click event from being triggered
    console.log(`Right box clicked for client: ${client.name}`);
};
</script>

<template>
    <AppLayout title="CICL">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                CICL
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                  

                    <!-- Clients List -->
                    <div class="mt-6 p-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unique ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Crime Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="client in clients"
                                    :key="client.id"
                                    @click="handleRowClick(client)"
                                    class="cursor-pointer hover:bg-gray-100"
                                >
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ client.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ client.id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ client.crimeStatus }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-4">
                                            <!-- Left Box -->
                                            <button 
                                                @click.stop="handleLeftClick($event, client)"
                                                class="bg-green-500 text-white p-2 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                                            >
                                                Left Box
                                            </button>

                                            <!-- Right Box -->
                                            <button 
                                                @click.stop="handleRightClick($event, client)"
                                                class="bg-red-500 text-white p-2 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500"
                                            >
                                                Right Box
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
