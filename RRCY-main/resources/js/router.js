import { createRouter, createWebHistory } from 'vue-router';
import ClientDetail from '@/views/ClientDetail.vue'; 
import CICL from '@/components/CICL.vue'; // Make sure this path is correct

const routes = [
  // Other routes
  {
    path: '/client/:id',
    name: 'ClientDetails', // Updated to match the name used in the client list
    component: ClientDetail,
    props: true, // Pass route params as props
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
