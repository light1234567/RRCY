import { createRouter, createWebHistory } from 'vue-router';
import AdmissionForm from './components/AdmissionForm.vue'; // Adjust path if necessary
import DisplayData from './components/DisplayData.vue'; // Adjust path if necessary

const routes = [
  {
    path: '/admission',
    name: 'AdmissionForm',
    component: AdmissionForm
  },
  {
    path: '/display-data',
    name: 'DisplayData',
    component: DisplayData,
    props: route => ({ form: route.query.form }) // Pass form data as props
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
