<template>
  <Head title="Register">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&display=swap">
  </Head>

  <div class="min-h-screen flex flex-col bg-cover bg-center overflow-hidden" style="background-image: url(''); background-size: cover; background-repeat: no-repeat; font-family: 'Roboto Mono', monospace;">
    <header id="header" class="w-full py-2 bg-white shadow-md flex items-center justify-between px-4 sm:px-8 lg:px-16">
      <img id="header-image-left" src="images/headerlogo2.png" alt="Left Logo" class="h-12 sm:h-16 lg:h-20 w-auto" />
      <img id="header-image-right" src="images/headerlogo.png" alt="Right Logo" class="h-12 sm:h-16 lg:h-20 w-auto" />
    </header>
    <main class="flex-grow flex flex-col md:flex-row items-center justify-center p-2 md:p-4 lg:p-6 overflow-hidden">
      <div class="flex w-full max-w-6xl flex-col md:flex-row h-screen">
        <!-- Left Side: Images -->
        <div class="w-full md:w-1/2 p-2 md:p-4 shadow-md border border-gray-300 flex-grow overflow-hidden relative">
          <div class="absolute inset-0 bg-blue-600 opacity-10 z-10"></div>
          <div class="w-full h-full space-y-4 flex flex-col justify-between relative z-20">
            <div class="w-full h-1/2 flex items-center justify-center">
              <img :src="currentImage1" alt="Image 1" class="w-full h-full object-cover" />
            </div>
            <div class="w-full h-1/2 flex items-center justify-center">
              <img :src="currentImage2" alt="Image 2" class="w-full h-full object-cover" />
            </div>
          </div>
        </div>

        <!-- Right Side: Register Form -->
        <div class="w-full md:w-1/2 p-2 md:p-4 shadow-md border border-gray-300 bg-white flex-grow overflow-auto">
          <div class="w-full space-y-2">
            <div class="text-center">
              <h2 class="mt-0 text-center font-bold text-lg md:text-xl text-gray-900">
                RRCY REGISTER
              </h2>
            </div>
            <form class="mt-2 space-y-2" @submit.prevent="submit">
              <div class="shadow-sm space-y-2">
                <div>
                  <InputLabel for="name" value="Name" />
                  <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
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
                    class="mt-1 block w-full"
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
                    class="mt-1 block w-full"
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
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                  />
                  <InputError class="mt-1" :message="form.errors.password_confirmation" />
                </div>
                <div>
                  <InputLabel for="service_type" value="Service Type" />
                  <select
                    id="service_type"
                    v-model="form.service_type"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
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
                  <InputError class="mt-1" :message="form.errors.service_type" />
                </div>
              </div>
              <div class="flex items-center justify-end mt-1">
                <PrimaryButton class="w-full flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                  Register
                </PrimaryButton>
              </div>
              <div class="flex items-center justify-start mt-1">
                <Link :href="route('login')" class="underline text-xs text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  Already have an account?
                </Link>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>

    <div class="bg-blue-900 py-0">
      <div class="flex flex-wrap justify-between items-center mt-4 px-4 pb-1">
        <!-- Facebook Link -->
        <a href="#" class="flex items-center text-gray-300 hover:text-white space-x-2 mb-2">
          <span class="sr-only">Facebook</span>
          <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
          </svg>
          <span class="text-gray-300 text-xs">Regional Rehabilitation Center for Youth</span>
        </a>
        <!-- Copyright Text -->
        <p class="text-base leading-6 text-gray-300 text-xs mb-2">
          © All rights reserved.
        </p>
        <!-- Website Link -->
        <a href="https://www.dswd.gov.ph/" class="flex items-center text-gray-300 hover:text-gray-600 space-x-2 mb-2">
          <span class="sr-only">Website</span>
          <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.25.139-.099.347.077.447.08zm-1.507 7.176c-1.035.492-2.603.876-4.122.91a12.934 12.934 0 01-4.436-.81 1.67 1.67 0 00-.188-.051c-.229.226-.367.576-.367.957v2.858c0 .767.308 1.415.743 1.918-.511.108-1.034.164-1.569.164a7.515 7.515 0 01-1.818-.226c.418-.518.675-1.168.675-1.88v-2.477c0-.927.604-1.757 1.484-2.037a14.276 14.276 0 004.868.347c1.64-.417 3.134-1.288 4.453-2.224a4.563 4.563 0 01-.106-.895v-.006c.011-1.261-1.007-2.279-2.263-2.279-1.263 0-2.268 1.036-2.268 2.316v.003a.295.295 0 01-.272.27c-.05-.051-.107-.089-.156-.142-.55-.568-1.264-.964-2.039-1.164-.651-.168-1.337-.27-2.019-.272zm.918 4.557c.92.287 1.843.604 2.768.937a2.872 2.872 0 001.29.227c.57.068 1.095-.06 1.56-.285.374-.154.71-.44.941-.762a2.65 2.65 0 00-.063-3.664c-.231-.321-.542-.62-.866-.817a3.173 3.173 0 00-1.344-.44c-.594-.03-1.198.13-1.738.39-.557.261-1.068.59-1.553.953-.572.398-1.115.875-1.628 1.376v1.584c.335.394.677.794 1.055 1.161z" clip-rule="evenodd"></path>
          </svg>
          <span class="text-gray-300 text-xs">dswd.gov.ph</span>
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  service_type: '', // Added field for dropdown
})

const submit = () => {
  form.post(route('register'))
}

const images = [
  'images/your-image1.png',
  'images/your-image2.png',
  'images/your-image3.png'
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
  setInterval(changeImage, 3000); // Change image every 3 seconds
});
</script>
