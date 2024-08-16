<template>
  <Head title="Log in">
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=albert-sans:400">
  </Head>
  <div class="background-container">
    <div class="min-h-screen flex flex-col bg-cover bg-center overflow-hidden" style="background-image: url(''); background-size: cover; background-repeat: no-repeat;">
      <div class="flex items-center -mb-12 justify-center">
        <img src="images/logo.png" class="h-44 w-70">
      </div>
      <main class="flex-grow flex items-center justify-center p-4 md:p-6 lg:p-8">
        <div class="w-full max-w-md p-6 mb-16 shadow-2xl rounded-md border-2 border-gray-300 bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg flex flex-col items-center transform hover:translate-y-0 transition-transform duration-300">
          <!-- Login Form -->
          <div class="w-full space-y-4">
            <div class="text-center">
              <h2 class="mt-0 text-center font-bold text-lg md:text-xl text-white">
                RRCY LOGIN
              </h2>
            </div>
            <form class="mt-4 space-y-4" @submit.prevent="submit">
              <div class="shadow-sm space-y-4">
                <div>
                  <InputLabel for="email" value="Email" class="" />
                  <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full bg-white bg-opacity-50 backdrop-filter backdrop-blur-md border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required
                    autofocus
                    autocomplete="username"
                  />
                  <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div>
                  <InputLabel for="password" value="Password" />
                  <div class="relative">
                    <TextInput
                      id="password"
                      v-model="form.password"
                      :type="showPassword ? 'text' : 'password'"
                      class="mt-1 block w-full bg-white bg-opacity-50 backdrop-filter backdrop-blur-md border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                      required
                      autocomplete="current-password"
                    />
                    <button type="button" @click="togglePasswordVisibility" class="absolute inset-y-0 right-0 px-3 flex items-center text-sm leading-5">
                      <svg v-if="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 4.5a7.5 7.5 0 00-7.92 6.49c.53.97 2.17 3.26 7.92 3.26 5.75 0 7.39-2.29 7.92-3.26a7.5 7.5 0 00-7.92-6.49zm0 8.5a3 3 0 110-6 3 3 0 010 6zm0-1.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                      </svg>
                      <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3.5a7.5 7.5 0 00-7.92 6.49.5.5 0 000 .12.5.5 0 000 .13.5.5 0 00.06.1.5.5 0 00.18.23c1.48 1.72 4.37 3.26 7.92 3.26 3.55 0 6.44-1.54 7.92-3.26a5.32 5.32 0 00.18-.23.5.5 0 00.06-.1.5.5 0 00.04-.13.5.5 0 000-.12A7.5 7.5 0 0010 3.5zm0 1a6.5 6.5 0 016.42 5.55c-.53.97-2.17 3.26-7.92 3.26-5.75 0-7.39-2.29-7.92-3.26A6.5 6.5 0 0110 4.5zm0 7a2.5 2.5 0 110-5 2.5 2.5 0 010 5zm-3 2a3 3 0 00-3 3h12a3 3 0 00-3-3h-6z" clip-rule="evenodd"/>
                      </svg>
                    </button>
                  </div>
                  <InputError class="mt-2" :message="form.errors.password" />
                </div>
              </div>
              <div class="flex items-center justify-between mt-2">
                <div class="flex items-center justify-start mt-2">
                  <Link :href="route('register')" class="underline text-[12px] text-gray-200 hover:text-white focus:outline-none focus:ring-2 mb-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Don't have an account yet?
                  </Link>
                </div>
                <Link v-if="canResetPassword" :href="route('password.request')" class="ml-auto underline text-[12px]  text-gray-200 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  Forgot your password?
                </Link>
              </div>
              <div class="flex items-center justify-end mt-2 pt-8">
                <PrimaryButton type="submit" class="w-full flex justify-center -mt-4 py-2 px-4 border border-transparent shadow-sm text-sm font-medium text-white bg-customBlue hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                  Log in
                </PrimaryButton>
              </div>
            </form>
          </div>
        </div>
      </main>

      <!-- Modal for unverified users -->
      <div v-if="showModal" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <h2 class="text-xl font-bold mb-4">Account Verification Required</h2>
          <p>{{ modalMessage }}</p>
          <button @click="showModal = false" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Close</button>
        </div>
      </div>

      <div class="bg-gray-800 py-">
        <div class="flex flex-wrap justify-between items-center mt-4 px-4 pb-1">
          <!-- Footer content here -->
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
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

const showPassword = ref(false);
const showModal = ref(false);
const modalMessage = ref('');

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};

const submit = () => {
  form.post(route('login'), {
    onSuccess: (response) => {
      if (response.data.status === 'unverified') {
        // Show the modal if the user is not verified
        showModal.value = true;
        modalMessage.value = 'You are not a verified user. Please verify your account.';
      } else {
        console.log('Login successful');
        // Redirect or update as necessary
      }
    },
    onError: () => {
      console.error('Login failed');
    }
  });
};
</script>

<style>
html, body {
  height: 100%;
  margin: 0;
}

.background-container {
  background-image: url('/images/bg.png'); /* Replace with the path to your image */
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  height: calc(100% - 100px); /* Adjust the height by the size of header and footer */
  box-sizing: border-box;
}

.fixed.inset-0 {
  background: rgba(0, 0, 0, 0.5);
}

.fixed.z-50 {
  z-index: 50;
}
</style>
