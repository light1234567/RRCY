<template>
    <div class="bg-gray-100 p-10">
      <!-- Page 1 -->
      <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mb-10">
        <div class="flex items-center justify-between mb-4">
          <img src="path_to_logo.png" alt="DSWD Logo" class="h-16">
          <div class="text-right">
            <p class="text-xs">DSPTD-QF-01-A | REV 01 | 12 SEP 2023</p>
          </div>
        </div>
        <h1 class="text-2xl font-bold text-center mb-2">CONFIDENTIAL</h1>
        <h2 class="text-xl font-semibold text-center mb-6">TALAMBUHAY</h2>
  
        <div class="mb-6">
          <h3 class="text-lg font-semibold mb-2">Tungkol sa aking Pamilya</h3>
          <p class="text-gray-600 mb-2">(Ilan kaming magkakapatid at tungkol sa kanilang buhay o kaya trabaho; papa/mama at tungkol sa kanilang ikinabubuhay, tungkol sa pamilya at iba pa)</p>
          <textarea class="w-full mt-1 p-2 border border-gray-300 rounded-md" rows="10" v-model="form.family"></textarea>
        </div>
  
        <div class="mb-6">
          <h3 class="text-lg font-semibold mb-2">Tungkol sa aking Sarili</h3>
          <p class="text-gray-600 mb-2">(Karanasan mula pagkabata, mga napagtagumpayan, mga bisyo/pagkakamali, eskwela, interes at mga gustong gawin, sports, ambisyon, pangarap at iba pa)</p>
          <textarea class="w-full mt-1 p-2 border border-gray-300 rounded-md" rows="10" v-model="form.self"></textarea>
        </div>
        
        <div class="text-center text-xs">
          <p>PAGE 1 of 3</p>
          <p>DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY), P.Y. Reyes Drive, Bajada, Davao City</p>
          <p>Email: rcydavao@gmail.com | Tel. No: 299-0348</p>
        </div>
      </div>
  
      <!-- Page 2 -->
      <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mb-10">
        <div class="text-right mb-4">
          <p class="text-xs">DSPTD-QF-01-A | REV 01 | 12 SEP 2023</p>
        </div>
  
        <div class="mb-6">
          <h3 class="text-lg font-semibold mb-2">Tungkol sa aking kaso</h3>
          <p class="text-gray-600 mb-2">(Ano at papaano nangyari, detalye ng pangyayari, ano ang rason at bakit nasangkot "Na-apil" sa kaso, sino-sino ang sangkot at iba pa)</p>
          <textarea class="w-full mt-1 p-2 border border-gray-300 rounded-md" rows="15" v-model="form.case"></textarea>
        </div>
  
        <div class="mb-6">
          <h3 class="text-lg font-semibold mb-2">Received & Assessed:</h3>
          <div class="flex justify-between mt-2">
            <div class="w-1/2 pr-2">
              <label class="block text-gray-700">Case Manager:</label>
              <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.caseManager">
            </div>
            <div class="w-1/2 pl-2">
              <label class="block text-gray-700">Pangalan ng Client at Pirma:</label>
              <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.clientSignature">
            </div>
          </div>
        </div>
  
        <div class="text-center text-xs">
          <p>PAGE 2 of 3</p>
          <p>DSWD FIELD OFFICE XI, PROTECTIVE SERVICES DIVISION, REGIONAL REHABILITATION CENTER FOR YOUTH</p>
        </div>
      </div>
  
      <!-- Page 3 -->
      <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <div class="text-right mb-4">
          <p class="text-xs">DSPTD-QF-01-A | REV 01 | 12 SEP 2023</p>
        </div>
  
        <div class="mb-6">
          <label class="block text-gray-700 mb-2">Petsa:</label>
          <input type="date" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.date">
        </div>
  
        <div class="text-center text-xs">
          <p>PAGE 3 of 3</p>
          <p>DSWD FIELD OFFICE XI, PROTECTIVE SERVICES DIVISION, REGIONAL REHABILITATION CENTER FOR YOUTH</p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        form: {
          family: '',
          self: '',
          case: '',
          caseManager: '',
          clientSignature: '',
          date: ''
        }
      }
    }
  }
  </script>
  
  <style scoped>
  /* Add any custom styles here if needed */
  </style>