<template>
  <Head title="Register">
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=albert-sans:400">
  </Head>

  <div class="background-container">
    <div class="min-h-screen flex flex-col bg-cover bg-center overflow-hidden" style="background-image: url(''); background-size: cover; background-repeat: no-repeat;">
    

      <main class="flex-grow flex items-center justify-center p-4 md:p-6 lg:p-8">
        <div class="w-full max-w-md p-6 shadow-2xl rounded-md border-2 border-gray-300 bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg flex flex-col items-center transform hover:translate-y-0 transition-transform duration-300">
          <!-- Register Form -->
          <div class="w-full space-y-4">
            <div class="text-center">
              <h2 class="mt-0 text-center font-bold text-lg md:text-xl text-white">
                RRCY REGISTER
              </h2>
            </div>
            <form class="mt-4 space-y-4" @submit.prevent="submit">
              <div class="shadow-sm space-y-4">
                <div>
                  <InputLabel for="name" value="Name" />
                  <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full bg-white bg-opacity-50 backdrop-filter backdrop-blur-md border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required
                    autofocus
                    autocomplete="name"
                  />
                  <InputError class="mt-1" :message="form.errors.name" />
                </div>
                <div>
                  <InputLabel for="email" value="Email" />
                  <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full bg-white bg-opacity-50 backdrop-filter backdrop-blur-md border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required
                    autocomplete="username"
                  />
                  <InputError class="mt-1" :message="form.errors.email" />
                </div>
                <div>
                  <InputLabel for="password" value="Password" />
                  <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full bg-white bg-opacity-50 backdrop-filter backdrop-blur-md border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required
                    autocomplete="new-password"
                  />
                  <InputError class="mt-1" :message="form.errors.password" />
                </div>
                <div>
                  <InputLabel for="password_confirmation" value="Confirm Password" />
                  <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full bg-white bg-opacity-50 backdrop-filter backdrop-blur-md border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required
                    autocomplete="new-password"
                  />
                  <InputError class="mt-1" :message="form.errors.password_confirmation" />
                </div>
                <div>
                  <InputLabel for="role" value="Role" />
                  <select
                    id="role"
                    v-model="form.role"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-white bg-opacity-50 backdrop-filter backdrop-blur-md"
                    required
                  >
                    <option value=""></option>
                    <option value="social services">Social Services</option>
                    <option value="psychological">Psychological</option>
                    <option value="court order">Court Order</option>
                    <option value="homelife services">Homelife Services</option>
                    <option value="nursing care">Nursing Care</option>
                    <option value="educational services">Educational Services</option>
                    <option value="psd">PSD</option>
                  </select>
                  <InputError class="mt-1" :message="form.errors.role" />
                </div>
              </div>
              <div class="flex items-center justify-end mt-2">
                <PrimaryButton class="w-full flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium text-white bg-customBlue hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                  Register
                </PrimaryButton>
              </div>
              <div class="flex items-center justify-start mt-2">
                <Link :href="route('login')" class="underline text-xs text-gray-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  Already have an account?
                </Link>
              </div>
            </form>
          </div>
        </div>
      </main>

      <div class="bg-gray-800 py-">
        <div class="flex flex-wrap justify-between items-center mt-4 px-4 pb-1">
          <!-- Facebook Link -->
          <a href="#" class="flex items-center text-gray-300 hover:text-white space-x-2 mb-2">
            <span class="sr-only">Facebook</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-gray-300 hover:text-white text-xs">Regional Rehabilitation Center for Youth</span>
          </a>
          <!-- Copyright Text -->
          <p class="text-base leading-6 text-gray-300 hover:text-white text-xs mb-2">
            © All rights reserved.
          </p>
          <!-- Website Link -->
          <a href="https://www.dswd.gov.ph/" class="flex items-center text-gray-300 hover:text-white space-x-2 mb-2">
            <span class="sr-only">Website</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.25.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-gray-300 hover:text-white text-xs ml-2">dswd.gov.ph</span>
          </a>
          <!-- Location Link -->
          <a href="#" class="flex items-center text-gray-300 hover:text-white space-x-2 mb-2">
            <span class="sr-only">Location</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm0 14.2c-1.58 0-2.88-1.29-2.88-2.88s1.29-2.88 2.88-2.88 2.88 1.29 2.88 2.88-1.29 2.88-2.88 2.88zM12 4.5c-3.92 0-7.1 3.18-7.1 7.1 0 3.35 3.3 7.88 7.1 11.4 3.79-3.52 7.1-8.05 7.1-11.4 0-3.92-3.18-7.1-7.1-7.1z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-gray-300 hover:text-white text-xs">Purok 7, Bago Oshiro, Tugbok District, Davao City</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  role: '', 
});

const submit = () => {
  form.post(route('register'));
}

const images = [
  '/images/4.png',
  '/images/5.png',
  '/images/6.png',
  '/images/8.png',
];

const currentImage1 = ref(images[0]);
const currentImage2 = ref(images[1]);

const changeImage = () => {
  const index1 = (images.indexOf(currentImage1.value) + 1) % images.length;
  const index2 = (images.indexOf(currentImage2.value) + 1) % images.length;

  currentImage1.value = images[index1];
  currentImage2.value = images[index2];
};

onMounted(() => {
  setInterval(changeImage, 5000); // Change image every 5 seconds
});
</script>

<style>
html, body {
  height: 100%;
  margin: 0;
}

.custom-shadow {
  box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.5); /* Adjust the values to get the desired shadow effect */
}

body, html {
  margin: 0;
  padding: 0;
  height: 100%;
  overflow: hidden;
}

.background-container {
  background-image: url('/images/bg.png'); /* Replace with the path to your image */
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  height: calc(100% - 100px); /* Adjust the height by the size of header and footer */
  box-sizing: border-box;
}
</style>
