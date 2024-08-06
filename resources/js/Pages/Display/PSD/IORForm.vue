<template>
    <div class="p-4">
      <!-- Page 1 -->
      <table class="w-full border-collapse border">
        <thead>
          <tr>
            <th colspan="5" class="text-center p-2 border">
              <img src="path-to-your-logo.png" alt="DSWD Logo" class="mx-auto mb-2">
              <h1 class="text-lg font-bold">PROTECTIVE SERVICES DIVISION</h1>
              <h2 class="text-md">REGIONAL REHABILITATION CENTER FOR YOUTH FO XI</h2>
              <h3 class="text-sm">DSWD-GF-010 | REV 02 / 22 SEPT 2023</h3>
            </th>
          </tr>
          <tr>
            <th colspan="5" class="text-center p-2 border bg-gray-200">
              <h2 class="text-lg font-bold">INDIVIDUAL PERFORMANCE OBSERVATION REPORT</h2>
              <p>For the Period: ____________________</p>
              <p>NAME OF RESIDENT: ________________________</p>
              <p>DATE OF ASSESSMENT: ____________________</p>
              <p>TRAININGS ATTENDED FOR THE MONTH: __________________________________</p>
            </th>
          </tr>
          <tr class="bg-gray-300">
            <th colspan="5" class="text-center p-2 border">SCALE OF MEASUREMENT</th>
          </tr>
          <tr class="bg-gray-100">
            <th class="border p-2">4 - PIRMI GINABUHAT (ALWAYS)</th>
            <th class="border p-2">3 - USAHAY RA GINABUHAT (SOMETIMES)</th>
            <th class="border p-2">2 - KUNG GANAHAN LANG GINABUHAT (SELDOM)</th>
            <th class="border p-2">1 - WALA JUD GIBUHAT (NEVER)</th>
          </tr>
          <tr class="bg-gray-300">
            <th colspan="3" class="text-center p-2 border">INDICATORS</th>
            <th class="text-center p-2 border">Self-Rating</th>
            <th class="text-center p-2 border">MDO's Rating</th>
          </tr>
        </thead>
        <tbody>
          <tr class="bg-gray-200">
            <td colspan="5" class="text-center p-2 border font-bold">A. PERSONALITY/BEHAVIOR:</td>
          </tr>
          <tr>
            <td colspan="3" class="p-2 border">1. Maayo ug batasan ug displinado. (Well mannered and disciplined)</td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
          </tr>
          <tr>
            <td colspan="3" class="p-2 border">2. Makahimo ug maayo aksyon ug desisyon sa mga dili maayo nga sitwasyon. (He acts appropriately in any given situation)</td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
          </tr>
          <!-- Add more rows for section A -->
          <tr class="bg-gray-200">
            <td colspan="5" class="text-center p-2 border font-bold">B. PERSONAL RELATIONSHIP:</td>
          </tr>
          <tr>
            <td colspan="3" class="p-2 border">1. Makighalobilo ug maayo sa ubang residente, staff ug mga trainer. (Can relate appropriately with co-residents, staff and trainers)</td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
          </tr>
          <!-- Add more rows for section B -->
          <tr class="bg-gray-200">
            <td colspan="5" class="text-center p-2 border font-bold">C. KNOWLEDGE:</td>
          </tr>
          <tr>
            <td colspan="3" class="p-2 border">1. Naay pamaagi nga madugangan ang talento. (Has the initiative to improve his given skills and talents)</td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
          </tr>
          <!-- Add more rows for section C -->
          <tr class="bg-gray-200">
            <td colspan="5" class="text-center p-2 border font-bold">D. SKILLS:</td>
          </tr>
          <tr>
            <td colspan="3" class="p-2 border">1. Naay kapasidad nga mohimo sa mga butang nga magpakita sa mga talento. (Has inherent capacity to be creative)</td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
          </tr>
          <!-- Add more rows for section D -->
        </tbody>
      </table>
  
      <!-- Page 2 -->
      <table class="w-full border-collapse border mt-8">
        <thead>
          <tr>
            <th colspan="5" class="text-center p-2 border">E. ATTITUDE:</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="3" class="p-2 border">1. Wala mosupak sa mga polisiya sa training sa tanang higayon. (He abides with policies of the training at all times)</td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
          </tr>
          <!-- Add more rows for section E -->
          <tr class="bg-gray-200">
            <td colspan="5" class="text-center p-2 border font-bold">F. RESPONSES TO SITUATIONS:</td>
          </tr>
          <tr>
            <td colspan="3" class="p-2 border">1. Dili moreklamo sa mga wala giplano nga kabag-uhan. (Never complains on unexpected changes/result of a group tasks)</td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
          </tr>
          <!-- Add more rows for section F -->
          <tr class="bg-gray-200">
            <td colspan="5" class="text-center p-2 border font-bold">G. LIFE'S ASPIRATIONS:</td>
          </tr>
          <tr>
            <td colspan="3" class="p-2 border">1. Andam makat-on sa mga kabag-ohan. (Willingness to learn new things)</td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
          </tr>
          <!-- Add more rows for section G -->
          <tr class="bg-gray-200">
            <td colspan="5" class="text-center p-2 border font-bold">OVER-ALL RATING</td>
          </tr>
          <tr>
            <td colspan="3" class="p-2 border">Adjectival Rating</td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
            <td class="p-2 border text-center"><input type="number" min="1" max="4" class="w-full text-center"></td>
          </tr>
        </tbody>
      </table>
  
      <!-- Page 3 -->
      <table class="w-full border-collapse border mt-8">
        <thead>
          <tr class="bg-red-300">
            <th colspan="5" class="text-center p-2 border">GENERAL REMARKS/RECOMMENDATION:</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="5" class="p-4 border h-48">
              <textarea class="w-full h-full border-none resize-none p-2" placeholder="Enter general remarks or recommendations here..."></textarea>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Page 4 -->
      <table class="w-full border-collapse border mt-8">
        <thead>
          <tr class="bg-red-300">
            <th colspan="4" class="text-center p-2 border">TRAININGS PREVIOUSLY ATTENDED:</th>
          </tr>
          <tr class="bg-gray-100">
            <th class="border p-2">No.</th>
            <th class="border p-2">TITLE OF THE TRAINING</th>
            <th class="border p-2">DATE OF ATTENDANCE</th>
            <th class="border p-2">STATUS</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="p-2 border text-center">1</td>
            <td class="p-2 border"></td>
            <td class="p-2 border"></td>
            <td class="p-2 border"></td>
          </tr>
          <tr>
            <td class="p-2 border text-center">2</td>
            <td class="p-2 border"></td>
            <td class="p-2 border"></td>
            <td class="p-2 border"></td>
          </tr>
          <tr>
            <td class="p-2 border text-center">3</td>
            <td class="p-2 border"></td>
            <td class="p-2 border"></td>
            <td class="p-2 border"></td>
          </tr>
          <tr>
            <td class="p-2 border text-center">4</td>
            <td class="p-2 border"></td>
            <td class="p-2 border"></td>
            <td class="p-2 border"></td>
          </tr>
          <tr>
            <td class="p-2 border text-center">5</td>
            <td class="p-2 border"></td>
            <td class="p-2 border"></td>
            <td class="p-2 border"></td>
          </tr>
        </tbody>
      </table>
  
      <div class="mt-4">
        <p class="text-xs">
          <strong>Prepared by:</strong><br>
          JENNY C. CADOYAS<br>
          MDO I<br>
          <strong>Noted by:</strong><br>
          SHERWIN B. GABUTAN<br>
          MDO II<br>
          <strong>Center Head:</strong><br>
          ANGELIC B. PAÑA<br>
        </p>
      </div>
  
      <div class="mt-4 text-center">
        <p class="text-xs">
          DSWD FIELD OFFICE XI PROTECTIVE SERVICES DIVISION REGIONAL REHABILITATION CENTER FOR YOUTH<br>
          PAGE 2 of 2
        </p>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "PerformanceObservationForm"
  };
  </script>
  
  <style scoped>
  /* Add any additional styling here */
  </style>
  