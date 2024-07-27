import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createRouter, createWebHistory } from 'vue-router';

// Import components for routes
import ClientDetails from '@/Pages/ClientDetails.vue';
import CICL from '@/Pages/CICL.vue'; // Assuming you have a CICL component

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const routes = [
    {
        path: '/cicl',
        name: 'CICL',
        component: CICL
    },
    {
        path: '/clients/:id',
        name: 'ClientDetails',
        component: ClientDetails,
        props: true // Allows passing route params as props
    },
    // Add other routes as needed
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(router) // Ensure the router is used here
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
