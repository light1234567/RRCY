<template>
  <Head title="Log in">
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=albert-sans:400">
  </Head>

  <div class="min-h-screen flex flex-col bg-cover bg-center overflow-hidden" style="background-image: url(''); background-size: cover; background-repeat: no-repeat;">
    <header id="header" class="w-full py-2 bg-white shadow-md flex items-center justify-between px-4 sm:px-8 lg:px-16">
      <img id="header-image-left" src="images/headerlogo2.png" alt="Left Logo" class="h-12 sm:h-16 lg:h-20 w-auto" />
      <img id="header-image-right" src="images/headerlogo.png" alt="Right Logo" class="h-12 sm:h-16 lg:h-20 w-auto" />
    </header>
    <main class="flex-grow flex flex-col md:flex-row items-center justify-center p-4 md:p-6 lg:p-8 overflow-hidden">
      <div class="flex w-full max-w-5xl flex-col md:flex-row">
        <!-- Login Form -->
        <div class="w-full md:w-1/2 p-4 md:p-6 shadow-lg border-2 border-gray-300 bg-white flex-grow relative">
          <div class="w-full space-y-4">
            <div class="text-center">
              <h2 class="mt-0 text-center font-bold text-xl md:text-2xl text-gray-900">
                RRCY LOGIN
              </h2>
            </div>
            <form class="mt-4 space-y-4" @submit.prevent="submit">
              <div class="shadow-sm space-y-4">
                <div>
                  <InputLabel for="email" value="Email" />
                  <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="username"
                  />
                  <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div>
                  <InputLabel for="password" value="Password" />
                  <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="current-password"
                  />
                  <InputError class="mt-2" :message="form.errors.password" />
                </div>
              </div>
              <div class="flex items-center justify-between mt-2">
                <label class="flex items-center">
                  <Checkbox v-model:checked="form.remember" name="remember" />
                  <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
                <Link v-if="canResetPassword" :href="route('password.request')" class="ml-auto underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  Forgot your password?
                </Link>
              </div>
              <div class="flex items-center justify-end mt-2 pt-8">
                <PrimaryButton type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium text-white bg-customBlue hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                  Log in
                </PrimaryButton>
              </div>
              <div class="flex items-center justify-start mt-2">
                <Link :href="route('register')" class="underline text-xs text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  Don't have an account yet?
                </Link>
              </div>
            </form>
          </div>
        </div>

        <!-- Image Box -->
        <div class="w-full md:w-1/2 p-4 md:p-6 flex-grow relative">
        <!-- Blue Overlay -->
        <div class="absolute inset- z-10"></div>

        <!-- Image Container -->
        <div class="w-full h-full space-y-4 flex flex-col justify-between relative z-20">
          <div class="w-full h-1/2 flex items-center justify-center custom-shadow border border-black">
            <img :src="currentImage1" alt="Image 1" class="w-full h-full object-cover" />
          </div>
          <div class="w-full h-1/2 flex items-center justify-center custom-shadow border border-black">
            <img :src="currentImage2" alt="Image 2" class="w-full h-full object-cover" />
          </div>
        </div>
      </div>
    </div>
    </main>
    <div class="bg-customBlue py-">
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
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onSuccess: () => {
      // Handle successful login
      console.log('Login successful');
      // Redirect or update as necessary
    },
    onError: () => {
      // Handle login error
      console.error('Login failed');
    }
  });
}

const images1 = ['images/4.png', 'images/5.png', 'images/6.png', 'images/8.png' ]; // Add your images
const images2 = ['images/5.png', 'images/6.png', 'images/8.png', 'images/4.png']; // Add your images

const currentImage1 = ref(images1[0]);
const currentImage2 = ref(images2[0]);

let index1 = 0;
let index2 = 0;

const changeImage1 = () => {
  index1 = (index1 + 1) % images1.length;
  currentImage1.value = images1[index1];
};

const changeImage2 = () => {
  index2 = (index2 + 1) % images2.length;
  currentImage2.value = images2[index2];
};

onMounted(() => {
  // Change image1 every 3 seconds
  const interval1 = setInterval(changeImage1, 5000);

  // Change image2 every 4 seconds
  const interval2 = setInterval(changeImage2, 5000);

  // Cleanup intervals on component unmount
  onUnmounted(() => {
    clearInterval(interval1);
    clearInterval(interval2);
  });
});

</script>

<style>
html, body {
  height: 100%;
  margin: 0;
}
.custom-shadow {
  box-shadow: 10px 10px 5px rgba(0, 0, 0, 0.5); /* Adjust the values to get the desired shadow effect */
}
</style>
