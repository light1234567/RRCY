<template>
  <Head title="Log in">
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=albert-sans:400">
  </Head>
  <div class="background-container">
    <div class="min-h-screen flex flex-col bg-cover bg-center overflow-hidden">
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
            <form class="mt-4 space-y-4" @submit.prevent="submit" novalidate>
              <div class="relative shadow-sm space-y-4">
                <div class="relative">
                  <InputLabel for="email" value="Email" class="" />
                  <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full bg-white bg-opacity-50 backdrop-filter backdrop-blur-md border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required
                    autofocus
                    autocomplete="username"
                    @input="clearError('email')"
                  />
                  <!-- Custom Error Design -->
                  <div v-if="form.errors.email" class="error-message absolute z-10 mt-1">
                    <span class="error-icon">⚠️</span>
                    <span class="error-text">{{ form.errors.email }}</span>
                  </div>
                </div>
                <div class="relative">
                  <InputLabel for="password" value="Password" />
                  <div class="relative">
                    <TextInput
                      id="password"
                      v-model="form.password"
                      :type="showPassword ? 'text' : 'password'"
                      class="mt-1 block w-full bg-white bg-opacity-50 backdrop-filter backdrop-blur-md border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                      required
                      autocomplete="current-password"
                      @input="clearError('password')"
                     
                    />
                  </div>
                  <!-- Custom Error Design -->
                  <div v-if="!form.errors.email && form.errors.password" class="error-message absolute z-10 mt-1">
                    <span class="error-icon">⚠️</span>
                    <span class="error-text">{{ form.errors.password }}</span>
                  </div>
                  <!-- Show a specific error message if the password is incorrect -->
                  <div v-if="!form.errors.email && form.errors.incorrectPassword" class="error-message absolute z-10 mt-1">
                    <span class="error-icon">⚠️</span>
                    <span class="error-text">The password is incorrect. Please try again.</span>
                  </div>
                </div>
              </div>
              <div class="flex items-center justify-between mt-2">
                <div class="flex items-center justify-start mt-2">
                  <Link :href="route('register')" class="underline text-[12px] text-gray-200 hover:text-white focus:outline-none focus:ring-2 mb-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Don't have an account yet?
                  </Link>
                </div>
                <Link v-if="canResetPassword" :href="route('password.request')" class="ml-auto underline text-[12px] text-gray-200 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import axios from 'axios';

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
const emailExists = ref(false);

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};

const submit = async () => {
    if (!validateEmail()) return;

    try {
        const emailResponse = await axios.post('/api/check-email', { email: form.email });
        if (emailResponse.data.exists) {
            emailExists.value = true;
            await validatePasswordAndSubmit(); // Ensure this function is called only once
        } else {
            form.errors.email = "The email is incorrect. Please register and try again.";
        }
    } catch (error) {
        console.error('Error checking email:', error);
        if (error.response && error.response.status === 500) {
            form.errors.email = "Server error. Please try again later.";
        }
    }
};


const validateEmail = () => {
  let isValid = true;

  if (!form.email) {
    form.errors.email = 'Email is required.';
    isValid = false;
  } else if (!form.email.includes('@')) {
    form.errors.email = "Please include an '@' in the email address. '" + form.email + "' is missing an '@'.";
    isValid = false;
  } else if (!isValidEmail(form.email)) {
    form.errors.email = "The email is incorrect. Please register and try again.";
    isValid = false;
  }

  return isValid;
};

const validatePasswordAndSubmit = async () => {
    // Check if the password is empty
    if (!form.password) {
        form.errors.password = 'Password is required.';
        return; // Exit the function early to prevent further processing
    }

    try {
        const passwordResponse = await axios.post('/api/validate-password', {
            email: form.email,
            password: form.password,
        });

        if (passwordResponse.data.valid) {
            // Password is correct, proceed with the login
            form.post(route('login'), {
                onSuccess: () => {
                    console.log('Login successful');
                },
                onError: () => {
                    console.error('Login failed');
                }
            });
        } else {
            form.errors.password = "The password is incorrect. Please try again.";
        }
    } catch (error) {
        console.error('Error validating password:', error);
        form.errors.password = "Server error. Please try again later.";
    }
};


const isValidEmail = (email) => {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
  return re.test(String(email).toLowerCase());
};

const clearError = (field) => {
  form.errors[field] = '';
};

const hideErrorsOnClickOutside = (event) => {
  if (!event.target.closest('.error-message')) {
    form.errors.email = '';
    form.errors.password = '';
  }
};

onMounted(() => {
  document.addEventListener('click', hideErrorsOnClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener('click', hideErrorsOnClickOutside);
});
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

.error-message {
  display: flex;
  align-items: center;
  background-color: #ffffff;
  border: 1px solid #ffa726;
  border-radius: 4px;
  padding: 2px;
  color: #ff6f00;
  width: 130%;
  margin-top: 4px;
  position: absolute;
  left: -15%;
  opacity: 0;
  transform: translateY(-10px);
  animation: fadeInUp 0.3s ease forwards;
}

.error-icon {
  margin-right: 4px;
  margin-top: -4px;
  font-size: 18px;
  padding: 2px;
}

.error-text {
  font-size: 14px;
}

.error-message::before {
  content: "";
  position: absolute;
  top: -16px;
  left: 80px;
  border-width: 10px;
  border-style: solid;
  border-color: transparent transparent #ffffff transparent;
}

@keyframes fadeInUp {
  0% {
    opacity: 0;
    transform: translateY(-10px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeOutDown {
  0% {
    opacity: 1;
    transform: translateY(0);
  }
  100% {
    opacity: 0;
    transform: translateY(-10px);
  }
}

.error-message.fade-out {
  animation: fadeOutDown 0.3s ease forwards;
}
</style>
