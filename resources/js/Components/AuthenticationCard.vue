<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white bg-opacity-40 backdrop-filter backdrop-blur-lg shadow-lg border border-gray-200 rounded-lg overflow-hidden">
            <slot />
        </div>
    </div>
</template>

<style>
/* Additional custom styles, if needed */
</style>
