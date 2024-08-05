<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    active: Boolean,
    href: String,
    as: String,
});

const classes = computed(() => {
    return props.active
        ? 'block w-full  ps-4 pe-4 py-0 border-l-4 border-indigo-400 text-start text-base font-sm text-white-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out'
        : 'block w-full ps-4 pe-4 py-0 border-l-4 border-transparent text-start text-base font-medium text-white hover:text-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-white focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out';
});
</script>

<template>
    <div>
        <button v-if="as == 'button'" :class="classes" class="w-full text-start">
            <slot />
        </button>

        <Link v-else :href="href" :class="classes">
            <slot />
        </Link>
    </div>
</template>
