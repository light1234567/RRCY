<template>
  <div class="min-h-screen flex flex-col bg-cover bg-center overflow-hidden" style="background-image: url(''); background-size: cover; background-repeat: no-repeat;">
    <div class="background-container min-h-screen flex items-center justify-center">
      <div class="w-full max-w-md p-6 mb-16 shadow-2xl rounded-md border-2 border-gray-300 bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg flex flex-col items-center transform hover:translate-y-0 transition-transform duration-300">
        
        <!-- Back Icon and Centered Heading -->
        <div class="flex items-center justify-center mb-6 w-full relative">
          <button @click="goBack" class="text-white focus:outline-none absolute left-0">
            <!-- Back Icon SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7-7l-7 7 7 7" />
            </svg>
          </button>
          <h2 class="font-bold text-lg md:text-xl text-white">
            OTP Verification
          </h2>
        </div>

        <form @submit.prevent="verifyOtp" class="w-full space-y-4">
          <div class="flex justify-between space-x-2">
            <input 
              v-for="(value, index) in otp" 
              :key="index" 
              v-model="otp[index]" 
              @input="focusNextBox(index)" 
              @keydown.backspace="focusPreviousBox(index)"
              maxlength="1" 
              ref="otpBoxes"
              class="w-12 h-12 text-center bg-white bg-opacity-100 backdrop-filter backdrop-blur-md border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700 text-lg"
              type="text"
            />
          </div>
          <p v-if="errorMessage" class="text-red-700 text-sm mt-2" style="text-shadow: .2px .2px .2px #000;">
              <i class="fas fa-exclamation-circle mr-1"></i>
              {{ errorMessage }}
            </p>
            <p v-if="onlineMessage" class="text-green-300 text-sm mt-2" style="text-shadow: .5px .5px .5px #000;">
              <i class="fas fa-check-circle mr-1"></i>
              {{ onlineMessage }}
            </p>


          <!-- Back and Submit Buttons -->
          <div class="flex justify-center space-x-4">
            <button 
              type="submit" 
              class="py-2 px-4 bg-gray-800 w-1/2 mt-2 text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Submit
            </button>
          </div>
        </form>

        <!-- Span and button in flex container --> 
        <div class="flex text-[12px] items-center -mt-2 justify-center w-full mt-4 space-x-2"> 
          <span class="text-white">Didn't receive OTP?</span> 
          <button 
            @click="resendOtp" 
            :disabled="timer > 0 || !isOnline" 
            class="text-white font-bold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 disabled:opacity-50"
          > 
            RESEND 
          </button> 
          <span v-if="timer > 0" class="text-white">({{ timer }}s)</span>
        </div>
      </div>
    </div>
    
    <!-- Modal -->
    <div v-if="showModal || successModal || resentModal" class="fixed inset-0 flex items-center justify-center z-50">
      <div class="modal-bg absolute inset-0 bg-black opacity-50"></div>
      <div class="modal-content relative p-6 bg-white rounded-lg shadow-lg text-center z-10">
        <!-- Green Circle with Checkmark for Success -->
        <div v-if="successModal || resentModal" class="flex flex-col items-center">
          <div class="rounded-full bg-green-500 h-16 w-16 flex items-center justify-center">
            <!-- Checkmark Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <!-- Success or Resent Message -->
          <p class="mt-4 text-xl font-semibold text-gray-900">
            {{ successModal ? 'Verification Successful!' : 'OTP Resent Successfully!' }}
          </p>
          <p class="text-gray-600">
            {{ successModal ? 'Redirecting to your dashboard...' : 'Your new OTP has been successfully sent to your email. Please check your inbox.' }}
          </p>
        </div>
        <!-- Modal Content for Other Messages -->
        <div v-else class="flex flex-col items-center">
          <p class="text-gray-700">{{ modalMessage }}</p>
          <button 
            v-if="!redirecting" 
            @click="closeModal" 
            class="mt-4 py-2 px-4 bg-indigo-600 text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      otp: ['', '', '', '', '', ''], // Array to store each digit of the OTP
      errorMessage: '', // Property to store the error message
      onlineMessage: '', // Property to store the online success message
      showModal: false,
      successModal: false, // Property for success verification modal
      resentModal: false, // Property for resent OTP modal
      modalMessage: '',
      redirecting: false,  // Track if redirection is happening
      timer: 0, // Timer for OTP resend button
      isLoading: false,  // Loading state for async operations
      isOnline: true,  // Property to track if the user is online or offline
    };
  },
  methods: {
    // Move focus to the next box after entering a digit
    focusNextBox(index) {
      if (this.otp[index].length === 1 && index < 5) {
        this.$refs.otpBoxes[index + 1].focus();
      }
    },
    // Move focus to the previous box and clear if necessary
    focusPreviousBox(index) {
      if (this.otp[index] === '' && index > 0) {
        this.$refs.otpBoxes[index - 1].focus();
        this.otp[index - 1] = ''; // Clear the previous box as well
      }
    },
    // Verify the OTP by combining all input fields
    async verifyOtp() {
      const otpCode = this.otp.join(''); // Combine the OTP array into a single string

      if (otpCode.trim() === '') {
        this.displayErrorMessage('The OTP field is required.');
        return;
      }

      this.errorMessage = ''; // Clear the error message if OTP is not empty
      this.isLoading = true; // Set loading state

      try {
        const response = await axios.post('/verify-otp', { otp: otpCode });
        this.modalMessage = response.data.message;

        if (response.status === 200) {
          this.successModal = true; // Show success modal
          // Wait for 2 seconds before redirecting to the dashboard
          setTimeout(() => {
            this.$inertia.visit('/dashboard', {
              onFinish: () => {
                window.location.reload(); // Refresh the page after redirection
              },
            });
          }, 2000);
        }
      } catch (error) {
        // Handle invalid or expired OTP errors
        if (error.response && (error.response.status === 400 || error.response.status === 422)) {
          this.displayErrorMessage(error.response.data.message);
          this.clearOtp(); // Clear the OTP input fields
        } else {
          this.modalMessage = 'An unexpected error occurred. Please try again.';
          this.showModal = true; // Show modal for other errors
        }
      } finally {
        this.isLoading = false; // Stop loading state
      }
    },
    // Resend OTP request
    async resendOtp() {
      this.errorMessage = ''; // Clear any existing error messages
      this.modalMessage = ''; // Clear any existing modal messages
      this.showModal = false; // Ensure the modal is not shown initially
      this.isLoading = true; // Start loading state

      try {
        const response = await axios.post('/resend-otp');
        this.modalMessage = response.data.message;
        this.resentModal = true; // Show the OTP Resent Successfully modal
        this.setTimer(); // Start the countdown timer

        setTimeout(() => {
          this.resentModal = false; // Automatically close the resent modal after 2 seconds
        }, 2000);
      } catch (error) {
        this.modalMessage = 'Failed to resend OTP. Please try again.'; // Provide a generic error message
        this.showModal = true; // Show the modal with a generic error message
      } finally {
        this.isLoading = false; // Stop loading state
      }
    },
    // Automatically resend OTP when internet is restored
    handleConnectionChange() {
      this.isOnline = navigator.onLine;
      if (this.isOnline) {
        // Automatically resend OTP when connection is back
        this.errorMessage = ''; // Clear the error message when online
        this.onlineMessage = 'You are back online. Check your email, we resent the OTP.'; // Display the online message
        this.resendOtp();
        
        // Clear onlineMessage after 5 seconds
        setTimeout(() => {
          this.onlineMessage = '';
        }, 5000);
      } else {
        this.onlineMessage = ''; // Clear the online message if offline
        this.displayErrorMessage('You are offline. OTP cannot be sent.');
      }
    },

    // Start the OTP resend timer
    setTimer() {
      const endTime = Date.now() + 180000; // Set the timer to 3 minutes from now (180000 ms)
      localStorage.setItem('otpTimerEnd', endTime);
      this.startTimer();
    },
    // Update the timer countdown
    startTimer() {
      const endTime = parseInt(localStorage.getItem('otpTimerEnd'), 10);
      if (!endTime) return;

      const updateTimer = () => {
        const timeLeft = Math.max(0, Math.floor((endTime - Date.now()) / 1000));
        this.timer = timeLeft;

        if (timeLeft > 0) {
          setTimeout(updateTimer, 1000);
        } else {
          localStorage.removeItem('otpTimerEnd'); // Clear the timer end time when the timer expires
        }
      };

      updateTimer();
    },
    // Display error messages for offline status
    displayErrorMessage(message) {
      this.errorMessage = message;
    },
    // Clear all OTP input fields
    clearOtp() {
      this.otp = ['', '', '', '', '', '']; // Clear all OTP input fields
      this.$refs.otpBoxes[0].focus(); // Focus on the first input box
    },
    // Close the error modal
    closeModal() {
      this.showModal = false;
    },
    // Go back to the previous page
    goBack() {
      window.history.back(); // Navigate to the previous page in browser history
    }
  },
  mounted() {
    this.startTimer(); // Start or resume the timer when the component is mounted

    // Add listeners for online and offline events
    window.addEventListener('online', this.handleConnectionChange);
    window.addEventListener('offline', this.handleConnectionChange);

    // Check initial online/offline status
    this.isOnline = navigator.onLine;
    if (!this.isOnline) {
      this.displayErrorMessage('You are offline. OTP cannot be sent.');
    }
  },
  beforeDestroy() {
    // Remove event listeners to avoid memory leaks
    window.removeEventListener('online', this.handleConnectionChange);
    window.removeEventListener('offline', this.handleConnectionChange);
  }
};
</script>

<style>
html, body {
  height: 100%;
  margin: 0;
}

.custom-shadow {
  box-shadow: 10px 10px 5px rgba(0, 0, 0, 0.5); 
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

/* Modal background styling */
.modal-bg {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5); /* Slightly darken the background */
}

/* Modal content styling */
.modal-content {
  background-color: white;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
  z-index: 100;
}
.text-stroke {
  -webkit-text-stroke: 1px white;
  text-stroke: 0.5px white; /* For other browsers */
}
</style>
