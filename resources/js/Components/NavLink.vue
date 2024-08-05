<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
    ? 'inline-flex items-center w-full h-6 px-1 pt-0 text-sm font-medium leading-5 text-white bg-customglue focus:outline-none focus:bg-customglue transition duration-150 ease-in-out focus:w-full'
  : 'inline-flex items-center w-full h-6 px-1 pt-0 text-sm font-medium leading-5 text-white hover:text-white focus:outline-none focus:bg-customglue focus:text-white transition duration-150 ease-in-out focus:w-full'
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
