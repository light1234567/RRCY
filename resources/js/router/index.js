import { createRouter, createWebHistory } from 'vue-router';
import CICL from '@/components/CICL.vue';
import ClientDetails from '@/components/ClientDetails.vue';

const routes = [
  { path: '/cicl', name: 'CICL', component: CICL },
  { path: '/clients/:id', name: 'ClientDetails', component: ClientDetails, props: true },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;