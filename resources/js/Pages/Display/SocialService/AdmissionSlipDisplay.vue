<template>
  <div>
    <button @click="exportToPdf" class="mt-4 px-4 py-2 bg-blue-600 rounded">
      Export to PDF
    </button>
  
    <div ref="pdfContent" class="p-6 border border-gray-400 shadow-xs rounded-lg max-w-3xl mx-auto my-8 ">
      <div class=" relative flex justify-between items-center mb-2">
        <img src="/images/headerlogo2.png" alt="Logo" class="ml-4 h-32 w-64 relative z-10">
        <p class="text-[10.7px] mb-10 font mr-6" style="font-family: 'Times New Roman', Times, serif; font-style: italic;">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>

      </div>

      <h1 class="text-[21.33px] font-bold mb-2 text-center text-black">ADMISSION SLIP</h1>

      <div v-if="clients.length > 0" v-for="client in clients" :key="client.id" class="mb-12 p-6 rounded-lg text-xs">
        <div class="flex items-center">
          <div class="flex-grow text-[15px] flex items-center mr-2">
            <label class="mb-3  text-black   mr-2 flex items-center h-full">Name:</label>
            <input type="text" class="underline-input  w-full" :value="client.first_name + ' ' + client.middle_name + ' ' + client.last_name" readonly>
          </div>
          <div class="flex text-[15px]  items-center w-1/4">
            <label class="mb-3   text-black mr-2 flex items-center h-full p-0">Sex:</label>
            <input type="text" class="underline-input bg-transparent mt-1 w-full" :value="client.sex" readonly>
          </div>
          <div class="flex text-[15px] items-center w-1/4">
            <label class="mb-3 block ml-2    text-black mr-2">Religion:</label>
            <input type="text" class="underline-input bg-transparent mt-1 w-full mb-6 " :value="client.religion" readonly>
          </div>  
        </div>

        <div class="flex items-center">
          <div class="flex-grow flex text-[15px] items-center mr-2">
            <label class="mb-3 block     text-black mr-2">Address:</label>
            <input type="text" class="underline-input bg-transparent w-full mb-24" :value="client.province + ', ' + client.city + ', ' + client.barangay + ', ' + client.street" readonly>
          </div>
        </div>

        <div class="text-[15px] flex items-center">
          <label class="mb-3 block    text-black mr-2 whitespace-nowrap">Date/Place of Birth:</label>
          <input type="text" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs" :value="client.date_of_birth + ' / ' + client.place_of_birth" readonly>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div class="flex items-center text-[15px] ">
              <label class="mb-3    text-black mr-2 whitespace-nowrap">Committing Court:</label>
              <input type="text" class="underline-input bg-transparent text-xs w-full" :value="client.admissions[0]?.committing_court" readonly>
          </div>
          <div class="text-[15px] flex items-center">
            <label class="mb-3 block    text-black ml-2  mr-2 whitespace-nowrap">Crim. Case #:</label>
            <input type="text" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs" :value="client.admissions[0]?.crim_case_number" readonly>
          </div>
        </div>

        <div class="flex items-center">
        <!-- Offense Committed Section -->
        <div class="text-[15px] flex items-center w-1/2">
          <label class="mb-3    text-black mr-2 whitespace-nowrap">Offense Committed:</label>
          <input type="text" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs" :value="client.admissions[0]?.offense_committed" readonly>
        </div>

        <!-- Date Admitted Section -->
        <div class="text-[15px] flex items-center w-1/2">
          <label class="mb-3    text-black mr-2 whitespace-nowrap ml-4">Date admitted to Center:</label>
          <input type="text" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs" :value="client.admissions[0]?.date_admitted" readonly>
        </div>
      </div>

        <div class="flex items-center">
          <div class="flex items-center text-[15px] w-1/2">
            <label class="mb-3 block    text-black whitespace-nowrap mr-2">No. of Days in Jail:</label>
            <input type="text" class="underline-input bg-transparent mt-1 mb-6 flex-grow text-xs" :value="client.admissions[0]?.days_in_jail" readonly>
          </div>
          <div class="flex items-center text-[15px] w-1/2">
            <label class="mb-3 block    text-black ml-4 whitespace-nowrap mr-2">No. of Days in Detention Center:</label>
            <input type="text" class="underline-input w-1/4 bg-transparent mt-1  mb-6 flex-grow text-xs" :value="client.admissions[0]?.days_in_detention_center" readonly>
          </div>
        </div>
        <div class="mb-2">
          <label class="mt-2 text-[15px] mb-4 block font-bold text-black">DISTINGUISHING MARKS:</label>
          <div class="flex flex-wrap items-center gap-x-8">
            <!-- Tattoo/Scars -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3 block    text-black mr-2">a. Tattoo/Scars:</label>
              <input type="text" class="underline-input1 bg-transparent flex-grow text-xs w-[100px]" :value="client.admissions[0]?.distinguishing_marks[0]?.tattoo_scars" readonly>
            </div>

            <!-- Height -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3 block    text-black mr-2">b. Height:</label>
              <input type="text" class="underline-input1 bg-transparent flex-grow text-xs w-[100px]" :value="client.admissions[0]?.distinguishing_marks[0]?.height" readonly>
            </div>

            <!-- Weight -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3 block    text-black mr-2">c. Weight:</label>
              <input type="text" class="underline-input1 bg-transparent flex-grow text-xs w-[100px]" :value="client.admissions[0]?.distinguishing_marks[0]?.weight" readonly>
            </div>

            <!-- Colour of Eye -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3    text-black mr-2">d. Colour of Eye:</label>
              <input type="text" class="underline-input1 bg-transparent flex-grow text-xs w-[100px]" :value="client.admissions[0]?.distinguishing_marks[0]?.colour_of_eye" readonly>
            </div>

            <!-- Skin -->
            <div class="flex items-center text-[15px]">
              <label class="mb-3    text-black mr-2">e. Skin:</label>
              <input type="text" class="underline-input1 bg-transparent flex-grow text-xs w-[100px]" :value="client.admissions[0]?.distinguishing_marks[0]?.skin_colour" readonly>
            </div>
          </div>
        </div>


        <div class="mb-4">
          <label class="text-[15px] block mb-2  font-semibold  text-black">Put on Documents Submitted:</label>
          <div class="pl-4">
            <div class="text-[15px] flex flex-wrap mb-2 gap-x-20">
              <!-- First Row -->
              <label class="block    text-black">
                <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[0]?.submitted" disabled> SCSR
              </label>
              <label class="ml-20 block    text-black">
                <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[1]?.submitted" disabled> Court Order
              </label>
              <label class="ml-0.5block    text-black">
                <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[2]?.submitted" disabled> Medical Certificates
              </label>
            </div>
            <div class="text-[15px] flex flex-wrap gap-x-14">
              <!-- Second Row -->
              <label class="block    text-black">
                <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[3]?.submitted" disabled> Consent from Parents
              </label>
              <label class="block    text-black">
                <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[4]?.submitted" disabled> School Records
              </label>
              <label class="block    text-black">
                <input type="checkbox" class="mr-2" :checked="client.admissions[0]?.documents[5]?.submitted" disabled> Others
              </label>
            </div>
          </div>
        </div>


        <div class="text-[15px] mb-4">
          <label class="block font-semibold  mb-2 text-black">General impression upon admission:</label>
          <textarea class="mt-1 block w-full border-gray-300 rounded-md shadow-sm leading-relaxed" style="line-height: 1.5;" :value="client.admissions[0]?.general_impression" readonly></textarea>
        </div>

        <div class="text-[15px] mb-4">
          <label class="block    mb-2 text-black">Action Taken:</label>
          <textarea class="text-[15px] mt-1 block w-full border-gray-300 rounded-md shadow-sm text-xs leading-relaxed" style="line-height: 1.5;" :value="client.admissions[0]?.action_taken" readonly></textarea>
        </div>

        <div class="text-[15px] grid grid-cols-2 gap-4 mb-4">
          <div>
            <input type="text" class="underline-input mt-1 w-full text-xs" readonly>
            <label class="block    text-black">Name & Signature of Referring Party</label>
          </div>
          <div>
            <input type="text" class="underline-input mt-1 w-full text-xs" readonly>
            <label class="block    text-black">Admitting Officer</label>
          </div>
        </div>

        <div class="text-[15px] grid grid-cols-2 gap-4 mb-4">
          <div>
            <input type="text" class="underline-input mt-1 w-full text-xs" readonly>
            <label class="block    text-black">Designation / ID No. / Contact #</label>
          </div>
          <div>
            <input type="text" class="underline-input mt-1 w-full text-xs" readonly>
            <label class="block    text-black">Designation</label>
          </div>
        </div>

        <div class="text-[15px] grid grid-cols-2 gap-4 mb-4">
          <div>
            <input type="text" class="underline-input mt-1 w-full text-xs" readonly>
            <label class="block    text-black">Complete Address/Office Address</label>
          </div>
          <div>
            <input type="text" class="underline-input mt-1 w-full text-xs" readonly>
            <label class="block    text-black">Date/Time</label>
          </div>
        </div>

        <!--NOTED BY-->
        <div class="text-[15px] border-gray-300 pt-4 text-center">
          <p class="   mb-4 mt-4 ">Noted By:</p>
          <p class="font-bold ">ANGELIC B. PAÑA, RSW, MSSW</p>
          <p class="">Center Head/SWO IV</p>
        </div>
      </div>
      <div v-else>
        <p>Loading data...</p>
      </div>

      <div class="border-gray-300 ml-6 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
        <div class="flex justify-between items-center">
          <div class="flex flex-col">
            <p class="ml-24 -mb-2 font-bold">PAGE 1 of 1</p>
            <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
            <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrcy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
          </div>
          <div class="ml-4">
            <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { jsPDF } from 'jspdf';
import '../../../fonts/arial-normal.js'; 
import '../../../fonts/times-normal.js'; 

export default {  
  name: 'ClientList',
  data() {
    return {
      clients: [],
      id: null,
    };
  },
  mounted() {
    this.id = this.$route.params.id;
    this.fetchClientsData();
  },
  watch: {
    '$route.params.id': function(newId) {
      this.id = newId;
      this.fetchClientsData();
    },
  },
  methods: {
    async fetchClientsData() {
      try {
        const response = await axios.get(`/api/clients-data/${this.id}`);
        this.clients = response.data.filter(
          (client) => client.id === parseInt(this.id)
        );
        console.log(this.clients); // Check if data is being fetched correctly
      } catch (error) {
        console.error('Error fetching client data:', error);
      }
    },
  async exportToPdf() {
  const pdf = new jsPDF('p', 'mm', [216, 356]); // Legal size: 216mm x 356mm

  // Add and set Times New Roman font
  pdf.addFont('times-normal.ttf', 'TimesNewRoman', 'italic'); // Loads the Times New Roman italic font
  pdf.setFont('TimesNewRoman', 'italic'); // Sets Times New Roman as the italic font

  // Set default font properties
  pdf.setFontSize(11);
  pdf.setLineHeightFactor(1.5);

  const imgData = '/images/headerlogo2.png'; // Ensure this is accessible or use base64
  pdf.addImage(imgData, 'PNG', 15, 10, 75, 35); // Adjust the size as needed

  // Add the header below the image
  pdf.setFontSize(8); 
  pdf.setFont('italic'); // Set font to italic
  pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 152, 24);

  // Load and set Arial font
  pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
  pdf.setFont('Arial', 'normal'); // Set Arial as the default font  
  pdf.setFontSize(18);

  
  pdf.setTextColor(0, 0, 0); // RGB values for black

  // Mimic bold by drawing the text multiple times with slight offsets
  pdf.text('ADMISSION SLIP', 108, 60, null, null, 'center'); // First pass
  pdf.text('ADMISSION SLIP', 108.2, 60, null, null, 'center'); // Slight offset
  pdf.text('ADMISSION SLIP', 107.8, 60, null, null, 'center'); // Slight offset



  pdf.addFont('arial-normal.ttf', 'Arial', 'normal');
  pdf.setFont('Arial', 'normal'); // Set Arial as the default font
  pdf.setFontSize(11); // Reset font size to 12 for content

  // Loop through clients and add their data
  this.clients.forEach((client, index) => {
    const offset = index * 160 + 80; // Adjust offset for each client's data

    // Add client details with margins and underline
    pdf.text(`Name:`, 20, offset);
    pdf.text(`${client.first_name} ${client.middle_name} ${client.last_name}`, 35, offset);
    pdf.line(35, offset + 1, 95, offset + 1); // Draw underline from start to end of data

    pdf.text(`Sex:`, 100, offset);
    pdf.text(`${client.sex}`, 110, offset);
    pdf.line(110, offset + 1, 140, offset + 1); // Draw underline for sex

    pdf.text(`Religion:`, 145, offset  );
    pdf.text(`${client.religion}`, 162, offset );
    pdf.line(162, offset + 1, 200, offset + 1); // Draw underline for religion

    pdf.text(`Address:`, 20, offset + 10);
    pdf.text(`${client.province}, ${client.city}, ${client.barangay}, ${client.street}`, 40, offset + 10);
    pdf.line(40, offset + 11, 200, offset + 11); // Draw underline for address

    pdf.text(`Date/Place of Birth:`, 20, offset + 20);
    pdf.text(`${client.date_of_birth} / ${client.place_of_birth}`, 58, offset + 20);
    pdf.line(58, offset + 21, 200, offset + 21); // Draw underline for birth details

   
    pdf.text(`Committing Court:`, 20, offset + 30);
    pdf.text(`${client.admissions[0]?.committing_court}`, 56, offset + 30);
    pdf.line(56, offset + 31, 110, offset + 31); // Draw underline for committing court

    pdf.text(`Crim. Case #:`, 115, offset + 30);
    pdf.text(`${client.admissions[0]?.crim_case_number}`, 143, offset + 30);
    pdf.line(143, offset + 31, 200, offset + 31); // Draw underline for criminal case number

    pdf.text(`Offense Committed:`, 20, offset + 40);
    pdf.text(`${client.admissions[0]?.offense_committed}`, 58, offset + 40);
    pdf.line(58, offset + 41, 110, offset + 41); // Draw underline for offense

    pdf.text(`Date admitted to Center:`, 115, offset + 40);
    pdf.text(`${client.admissions[0]?.date_admitted}`, 160, offset + 40);
    pdf.line(160, offset + 41, 200, offset + 41); // Draw underline for date admitted

    pdf.text(`No. of Days in Jail:`, 20, offset + 50);
    pdf.text(`${client.admissions[0]?.days_in_jail}`, 57, offset + 50);
    pdf.line(57, offset + 51, 110, offset + 51); // Draw underline for days in jail

    pdf.text(`No. of Days in Detention Center:`, 115, offset + 50);
    pdf.text(`${client.admissions[0]?.days_in_detention_center}`, 175, offset + 50);
    pdf.line(175, offset + 51, 200, offset + 51); // Draw underline for days in detention center

    pdf.setFont('helvetica', 'bold'); // Set font to Arial and make it bold
    pdf.text(`Distinguishing Marks:`, 20, offset + 60);
    pdf.setFont('helvetica', 'normal'); // Reset font to normal for the following text


    pdf.text(`a. Tattoo/Scars:`, 20, offset + 70);
    pdf.text(`${client.admissions[0]?.distinguishing_marks[0]?.tattoo_scars}`, 51, offset + 70);
    pdf.line(51, offset + 71, 110, offset + 71); // Draw underline for tattoo/scars

    pdf.text(`b. Height:`, 115, offset + 70);
    pdf.text(`${client.admissions[0]?.distinguishing_marks[0]?.height}`, 138, offset + 70);
    pdf.line(138, offset + 71, 200, offset + 71); // Draw underline for height

    pdf.text(`c. Weight:`, 20, offset + 80);
    pdf.text(`${client.admissions[0]?.distinguishing_marks[0]?.weight}`, 40, offset + 80);
    pdf.line(40, offset + 81, 110, offset + 81); // Draw underline for weight

    pdf.text(`d. Colour of Eye:`, 115, offset + 80);
    pdf.text(`${client.admissions[0]?.distinguishing_marks[0]?.colour_of_eye}`, 150, offset + 80);
    pdf.line(150, offset + 81, 200, offset + 81); // Draw underline for eye color

    pdf.text(`e. Skin:`, 20, offset + 90);
    pdf.text(`${client.admissions[0]?.distinguishing_marks[0]?.skin_colour}`, 36, offset + 90);
    pdf.line(36, offset + 91, 110, offset + 91); // Draw underline for skin color

    // Add the "Put on Documents Submitted" section with checkboxes
    pdf.setFont('helvetica', 'bold'); // Set font to Arial and make it bold
    pdf.text(`Put on Documents Submitted:`, 20, offset + 100);
    pdf.setFont('helvetica', 'normal'); // Reset font to normal for the following text

    // Function to draw a custom checkmark inside the checkbox
      function drawCheckmark(pdf, x, y) {
          pdf.setLineWidth(0.1);
          pdf.line(x, y + 1, x + 1, y + 2.5); // Adjust the first line of the checkmark
          pdf.line(x + 1, y + 2.5, x + 3, y - 0.5); // Adjust the second line of the checkmark
      }

      // Function to fill the checkbox and draw the checkmark
      function fillCheckboxWithCheck(pdf, x, y) {
          pdf.setFillColor(169, 169, 169); // Set a light gray color
          pdf.rect(x, y, 4, 4, 'F'); // Draw and fill the rectangle
          drawCheckmark(pdf, x, y + 2); // Draw the checkmark on top
      }

      // Example usage in your PDF generation code:

      // SCSR
      pdf.rect(20, offset + 106, 4, 4); // Draw a square for the checkbox
      pdf.text(`SCSR`, 28, offset + 110); // Position the label text next to the checkbox
      if (client.admissions[0]?.documents[0]?.submitted) {
          fillCheckboxWithCheck(pdf, 20, offset + 106); // Fill the checkbox and draw the checkmark
      }

      // Court Order
      pdf.rect(90, offset + 106, 4, 4); // Draw a square for the checkbox
      pdf.text(`Court Order`, 98, offset + 110); // Position the label text next to the checkbox
      if (client.admissions[0]?.documents[1]?.submitted) {
          fillCheckboxWithCheck(pdf, 90, offset + 106); // Fill the checkbox and draw the checkmark
      }

      // Medical Certificates
      pdf.rect(157, offset + 106, 4, 4); // Draw a square for the checkbox
      pdf.text(`Medical Certificates`, 165, offset + 110); // Position the label text next to the checkbox
      if (client.admissions[0]?.documents[2]?.submitted) {
          fillCheckboxWithCheck(pdf, 157, offset + 106); // Fill the checkbox and draw the checkmark
      }

      // Consent from Parents
      pdf.rect(20, offset + 116, 4, 4); // Draw a square for the checkbox
      pdf.text(`Consent from Parents`, 28, offset + 120); // Position the label text next to the checkbox
      if (client.admissions[0]?.documents[3]?.submitted) {
          fillCheckboxWithCheck(pdf, 20, offset + 116); // Fill the checkbox and draw the checkmark
      }

      // School Records
      pdf.rect(90, offset + 116, 4, 4); // Draw a square for the checkbox
      pdf.text(`School Records`, 98, offset + 120); // Position the label text next to the checkbox
      if (client.admissions[0]?.documents[4]?.submitted) {
          fillCheckboxWithCheck(pdf, 90, offset + 116); // Fill the checkbox and draw the checkmark
      }

      // Others
      pdf.rect(157, offset + 116, 4, 4); // Draw a square for the checkbox
      pdf.text(`Others`, 165, offset + 120); // Position the label text next to the checkbox
      if (client.admissions[0]?.documents[5]?.submitted) {
          fillCheckboxWithCheck(pdf, 180, offset + 116); // Fill the checkbox and draw the checkmark
      }

    pdf.setFont('helvetica', 'bold'); // Set font to Arial and make it bold
    pdf.text(`General impression upon admission:`, 20, offset + 130);
    pdf.setFont('helvetica', 'normal'); // Reset font to normal for the following text

    pdf.text(client.admissions[0]?.general_impression || '', 20, offset + 140, { maxWidth: 170 });
    pdf.line(20, offset + 141, 200, offset + 141); // Draw underline for general impression

    pdf.setFont('helvetica', 'bold'); // Set font to Arial and make it bold
    pdf.text(`Action Taken:`, 20, offset + 150);
    pdf.setFont('helvetica', 'normal'); // Reset font to normal for the following text

    pdf.text(client.admissions[0]?.action_taken || '', 20, offset + 160, { maxWidth: 170 });
    pdf.line(20, offset + 161, 200, offset + 161); // Draw underline for action taken

    if (index < this.clients.length - 1) {
      pdf.addPage(); // Add a new page for the next client if more clients exist
    }
  });
    // Add the new section content
    let offset = 253; // Assuming we are continuing from a previous offset

    // Grid: Name & Signature of Referring Party / Admitting Officer
   
        // Name & Signature of Referring Party / Admitting Officer
    pdf.line(20, offset, 85, offset); // Underline for Referring Party
    pdf.text('Name & Signature of Referring Party', 20, offset + 4); // Text below the line
    pdf.line(130, offset, 200, offset); // Underline for Admitting Officer
    pdf.text('Admitting Officer', 130, offset + 4); // Text below the line

    offset += 10; // Move down

    // Grid: Designation / ID No. / Contact # / Designation
    pdf.line(20, offset, 85, offset); // Underline for Designation / ID No. / Contact #
    pdf.text('Designation / ID No. / Contact #', 20, offset + 4); // Text below the line
    pdf.line(130, offset, 200, offset); // Underline for Designation
    pdf.text('Designation', 130, offset + 4); // Text below the line

    offset += 10; // Move down

    // Grid: Complete Address/Office Address / Date/Time
    pdf.line(20, offset, 85, offset); // Underline for Complete Address/Office Address
    pdf.text('Complete Address/Office Address', 20, offset + 4); // Text below the line
    pdf.line(130, offset, 200, offset); // Underline for Date/Time
    pdf.text('Date/Time', 130, offset + 4); // Text below the line

    offset += 20; // Move down for "Noted By" section

    // Noted By section
    pdf.setFontSize(11);
    pdf.text('Noted By:', 108, offset - 5, null, null, 'center');

    pdf.setFontSize(11);
    pdf.setFont('helvetica', 'bold');
    // Centered text with the underline above
    pdf.text('ANGELIC B. PAÑA, RSW, MSSW', 108, offset + 6, null, null, 'center'); // Text below the line
    pdf.setFont('helvetica', 'normal');
      // Draw the underline above the text
      

    pdf.line(78, offset + 7, 140, offset + 7); // Adjust the line length and position for centering

    // Centered text with the underline above
    pdf.text('Center Head/SWO IV', 108, offset + 12, null, null, 'center'); // Text below the line

    offset += 30; // Move down for footer

    // Add and set Times New Roman font
    pdf.setFont('TimesNewRoman', 'bold'); // Use the normal font but increase size for bold effect
pdf.setFontSize(12); // Increase the font size to simulate bold
pdf.text('PAGE 1 of 1', 108, offset + 3, null, null, 'center');
    pdf.setLineWidth(0.5);
    pdf.addFont('times-normal.ttf', 'TimesNewRoman', 'italic'); // Loads the Times New Roman italic font
    pdf.setFont('TimesNewRoman', 'italic'); // Sets Times New Roman as the italic font
    pdf.line(20, offset + 5, 210 - 30, offset + 5); // Draw a line
    pdf.setFontSize(9);
    pdf.text('DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City', 100, offset + 10, null, null, 'center');
    pdf.text('Email: rrcy.fo11@dswd.gov.ph    Tel. No.: 293-0306', 108, offset + 15, null, null, 'center');

     // Add the footer image
     const footerImgData = '/images/footerimg.png'; // Path to your footer image
    pdf.addImage(footerImgData, 'PNG', 182, offset, 20, 10); // Adjust the position and size as needed

    // Save the PDF
    pdf.save(`admission-slip-${this.id}.pdf`);
    }

  },
};
</script>

<style scoped>
/* Adjust spacing and underline input */
.underline-input {
  border: none;
  border-bottom:  1px solid black;
  padding: 0;
  width: 100%;
  margin-bottom: 14px;
  line-height: 0;
  box-sizing: border-box;
  vertical-align: bottom; /* Ensures the text aligns with the bottom of the input */
  font-size: inherit; /* Ensure consistent font size */
}
.underline-input1 {
  border: none;
  border-bottom:  1px solid black;
  padding: 0;
  margin-bottom: 14px;
  line-height: 0;
  box-sizing: border-box;
  vertical-align: bottom; /* Ensures the text aligns with the bottom of the input */
  font-size: inherit; /* Ensure consistent font size */
}



/* Ensure the form fits within Legal size dimensions for printing */
@media print {
  .max-w-7xl {
    max-width: 216mm;
  }
  .p-8 {
    padding: 100mm;
  }
  .mr-4, .mb-12, .mb-8, .mb-6, .mb-4, .mb-2 {
    margin-bottom: 20mm;
  }
  .border-t {
    border-top: 1px solid #d2d2d2;
  }
}
</style>
