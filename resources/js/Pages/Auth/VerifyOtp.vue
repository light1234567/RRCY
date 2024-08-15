<template>
  <div class="max-w-md mx-auto p-6 bg-gray-100 rounded-lg shadow-md text-center">
    <h1 class="text-2xl font-semibold mb-4">Verify OTP</h1>

    <form @submit.prevent="submit" class="space-y-4">
      <div class="text-left">
        <label for="otp" class="block text-sm font-medium text-gray-700 mb-1">Enter OTP</label>
        <input 
          id="otp" 
          v-model="form.otp" 
          type="text" 
          required 
          class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
      </div>

      <div>
        <button 
          type="submit" 
          class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          Verify
        </button>
      </div>
    </form>

    <div class="mt-4">
      <button 
        @click="resendOtp" 
        :disabled="isResending" 
        class="bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 disabled:bg-gray-400 disabled:cursor-not-allowed"
      >
        Resend OTP
      </button>
    </div>

    <!-- Modal for Error Messages -->
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-6 rounded-lg shadow-lg text-center relative">
        <span 
          class="absolute top-2 right-2 text-xl cursor-pointer" 
          @click="closeModal"
        >
          &times;
        </span>
        <p>{{ modalMessage }}</p>
      </div>
    </div>

    <!-- Modal for Resend Success -->
    <div v-if="showResendModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-6 rounded-lg shadow-lg text-center relative">
        <span 
          class="absolute top-2 right-2 text-xl cursor-pointer" 
          @click="closeResendModal"
        >
          &times;
        </span>
        <p>OTP has been resent successfully!</p>
      </div>
    </div>
  </div>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

export default {
  setup() {
    const form = useForm({
      otp: ''
    });

    const showModal = ref(false);
    const modalMessage = ref('');
    const showResendModal = ref(false);
    const isResending = ref(false);

    function submit() {
      form.post(route('otp.verify'), {
        onError: (errors) => {
          if (errors.otp) {
            modalMessage.value = errors.otp[0]; // Capture the specific error message
            showModal.value = true; // Show the error modal
          }
        }
      });
    }

    async function resendOtp() {
      try {
        isResending.value = true;
        showResendModal.value = false;

        const response = await axios.post(route('resend.otp'));
        if (response.data.message === 'OTP resent successfully!') {
          showResendModal.value = true;
        } else {
          modalMessage.value = response.data.message || 'Failed to resend OTP. Please try again.';
          showModal.value = true;
        }
      } catch (error) {
        modalMessage.value = 'Failed to resend OTP. Please try again.';
        showModal.value = true;
      } finally {
        isResending.value = false;
      }
    }

    function closeModal() {
      showModal.value = false;
      modalMessage.value = '';
    }

    function closeResendModal() {
      showResendModal.value = false;
    }

    return {
      form,
      showModal,
      modalMessage,
      showResendModal,
      isResending,
      submit,
      resendOtp,
      closeModal,
      closeResendModal
    };
  }
}

</script>

<style>
/* TailwindCSS is used inline, no additional styles needed here */
</style>
