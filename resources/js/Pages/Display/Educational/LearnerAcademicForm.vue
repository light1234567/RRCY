<template>

<div class="flex justify-end space-x-4 mb-4">
  <button @click="toggleEdit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
    <span v-if="!editMode">Edit</span>
    <span v-else>Cancel</span>
  </button>
  <button v-if="editMode" @click="submitForm" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
  Save
</button>
<div class="flex justify-end space-x-4">
        <button @click="toggleEdit" type="button" class="bg-blue-500 text-white px-4 py-2 rounded">
          {{ editMode ? 'Cancel' : 'Edit' }}
        </button>
        <button v-if="editMode" type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save</button>

        <button @click="exportToPdf" type="button" class="bg-red-500 text-white px-4 py-2 rounded">
        Export to PDF
      </button>
      </div>
</div>

<!-- Success/Error Message -->
<div v-if="message" :class="messageType === 'success' ? 'bg-green-500' : 'bg-red-500'" class="mt-4 p-4 text-white rounded">
  {{ message }}
</div>

  <div class="max-w-3xl p-8 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
    <!-- Header Section with Logo and Document Details -->
    <div class="relative flex justify-between items-center mb-4">
      <img src="/images/headerlogo2.png" alt="Logo" class="h-24 w-48">
      <div class="text-right">
        <p class="item-center mr-6 text-sm font-semibold">PROTECTIVE SERVICES DIVISION</p>
        <p class="text-sm font-semibold">Regional Rehabilitation Center for Youth</p>
        <p class="mr-20 text-sm font-semibold">Youth/RFO XI</p>
        <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
      </div>
    </div>

    <form @submit.prevent="submitForm">


      <div class="text-center mb-6">
        <h1 class="font-bold text-xl">LEARNER’S ACADEMIC BEHAVIORAL FORM</h1>
        <div class="flex justify-center gap-4 mt-4">
          <div>
            <label for="month" class="block font-medium">For the Month of:</label>
            <input v-model="form.month" type="text" id="month" class="block w-32 p-1 border border-gray-300 mx-auto text-sm" />
          </div>
          <div>
            <label for="schoolYear" class="block font-medium">School Year:</label>
            <input v-model="form.school_year" type="text" id="schoolYear" class="block w-32 p-1 border border-gray-300 mx-auto text-sm" />
          </div>
        </div>
      </div>

      <div class="flex flex-wrap gap-4 mb-6">
        <div class="w-1/2 sm:w-1/3">
          <label for="learnerName" class="block font-medium text-sm">Learner’s Name:</label>
          <input v-model="form.learner_name" type="text" id="learnerName" class="block w-full p-1 border border-gray-300 text-sm" readonly />
        </div>
        <div class="w-1/2 sm:w-1/3">
          <label for="grade" class="block font-medium text-sm">Grade:</label>
          <input v-model="form.grade" type="text" id="grade" class="block w-full p-1 border border-gray-300 text-sm" />
        </div>
        <div class="w-1/2 sm:w-1/3">
          <label for="lrn" class="block font-medium text-sm">LRN:</label>
          <input v-model="form.lrn" type="text" id="lrn" class="block w-full p-1 border border-gray-300 text-sm" />
        </div>
        <div class="w-1/2 sm:w-1/3">
          <label for="status" class="block font-medium text-sm">Status:</label>
          <input v-model="form.status" type="text" id="status" class="block w-full p-1 border border-gray-300 text-sm" />
        </div>
      </div>

      <div class="mb-6">
        <table class="w-full border-collapse">
          <thead>
            <tr>
              <th class="border p-2 text-left">Learner Skill</th>
              <th class="border p-2">Outstanding</th>
              <th class="border p-2">Very Satisfactory</th>
              <th class="border p-2">Satisfactory</th>
              <th class="border p-2">Fairly Satisfactory</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, index) in form.skills" :key="index">
              <td class="border p-2">{{ row.skill }}</td>
              <td class="border p-2"><input v-model="row.outstanding" type="text" class="w-full p-1 border border-gray-300" /></td>
              <td class="border p-2"><input v-model="row.verySatisfactory" type="text" class="w-full p-1 border border-gray-300" /></td>
              <td class="border p-2"><input v-model="row.satisfactory" type="text" class="w-full p-1 border border-gray-300" /></td>
              <td class="border p-2"><input v-model="row.fairlySatisfactory" type="text" class="w-full p-1 border border-gray-300" /></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="mb-6">
        <label for="observationFeedback" class="block font-medium">Observation/Feedback:</label>
        <textarea v-model="form.observation_feedback" id="observationFeedback" rows="6" class="block w-full p-2 border border-gray-300"></textarea>
      </div>

      <div class="mb-6 flex gap-4">
        <div class="w-1/2">
          <label for="learnerSignature" class="block text-sm font-medium">Learner</label>
          <div class="flex items-center">
            <input
              v-model="form.learner_name"
              type="text"
              id="learner"
              class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm"
            >
          </div>
          <p class="text-sm mt-2">Learner</p>
        </div>

        <div class="w-1/2">
          <label for="categoryAdviserSignature" class="block text-sm font-medium">Category Adviser</label>
          <div class="flex items-center">
            <input
              v-model="form.category_adviser_signature"
              type="text"
              id="categoryAdviserSignature"
              class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm"
            >
          </div>
          <p class="text-sm mt-2">Category Adviser</p>
        </div>
      </div>

      <div class="mb-6 flex gap-4">
        <div class="w-1/2">
          <label for="educationalSectionHeadSignature" class="block text-sm font-medium">Educational Section Head</label>
          <div class="flex items-center">
            <input
              v-model="form.educational_section_head_signature"
              type="text"
              id="educationalSectionHeadSignature"
              class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm bg-gray-200"
              :readonly="!editMode"
            >
          </div>
          <p class="text-sm mt-2">Educational Section Head</p>
        </div>

        <div class="w-1/2">
          <label for="centerHeadSignature" class="block text-sm font-medium">Center Head</label>
          <div class="flex items-center">
            <input
              v-model="center_head"
              type="text"
              class="mt-1 w-3/4 border-b-2 border-black border-t-0 border-l-0 border-r-0 p-0 rounded-none shadow-sm bg-gray-200"
              :readonly="!editMode"
            >
          </div>
          <p class="text-sm mt-2">Center Head</p>
        </div>
      </div>

      
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import jsPDF from 'jspdf';

export default {
  name: 'LearnerBehaviorForm',
  data() {
    return {
      form: {
        client_id: null,
        month: '',
        school_year: '',
        learner_name: '',
        grade: '',
        lrn: '',
        status: '',
        skills: [
          { skill: 'HOMEWORK COMPLETION', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
          { skill: 'STUDY SKILLS', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
          { skill: 'ORGANIZATIONAL SKILLS', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
          { skill: 'COOPERATIVE LEARNING SKILLS', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
          { skill: 'INDEPENDENT SEAT WORK', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
          { skill: 'MOTIVATION', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
          { skill: 'COMPLIANCE', outstanding: '', verySatisfactory: '', satisfactory: '', fairlySatisfactory: '' },
        ],
        observation_feedback: '',
        learner_signature: '',
        category_adviser_signature: '',
        educational_section_head_signature: '',
        center_head_signature: '',
      },
      originalForm: null,
      editMode: false,
      center_head: '',
      message: '', 
      messageType: '', 
    };
  },
  mounted() {
    this.form.client_id = this.$route.params.id;
    if (!this.form.client_id) {
      console.error('client_id is missing in mounted. Cannot fetch the form data.');
    } else {
      this.fetchData();
    }
  },
  watch: {
    '$route.params.id': function (newId) {
      this.form.client_id = newId;
      this.fetchData();
    }
  },
  methods: {
    fetchData() {
      this.fetchCenterHead(this.form.client_id);
      if (!this.form.client_id) {
        console.error('client_id is missing. Cannot fetch the form data.');
        return;
      }

      axios.get(`/api/learner-academic-behavioral-forms/${this.form.client_id}`)
        .then(response => {
          if (response.data.form) {
            Object.assign(this.form, response.data.form);
            this.originalForm = JSON.parse(JSON.stringify(this.form));
            console.log('Form data loaded:', this.form);
          } else if (response.data.client) {
            this.form.learner_name = `${response.data.client.first_name} ${response.data.client.last_name}`;
            console.log('Client name loaded:', this.form.learner_name);
          }
        })
        .catch(error => {
          this.message = 'Error fetching data: ' + (error.response?.data || error.message);
          this.messageType = 'error';
          console.error('Error fetching data:', error.response?.data || error);
        });
    },
    fetchCenterHead(clientId) {
    if (!clientId) {
      console.error("Client ID is missing.");
      return;
    }
    // Make an API request using the client ID
    axios.get(`/api/center-head/${clientId}`)
      .then(response => {
        this.center_head = response.data.center_head;
        console.log("Fetched center head:", this.center_head); // Log the center head
      })
      .catch(error => {
        console.error("Error fetching center head:", error);
      });
  },
  // Save center head
  saveCenterHead() {
    const clientId = this.$route.params.id;
    if (!this.center_head || !clientId) {
      return;
    }
    axios
      .put(`/api/update-center-head`, {
        center_head: this.center_head,
        client_id: clientId, // Use the correct client ID
      })
      .then(response => {
        this.editMode = false;
        this.fetchClientData(clientId); // Refetch the data to update the UI
      })
      .catch(error => {
        console.error("Error updating center head:", error);
      });
  },
  

  submitForm() {
      this.saveCenterHead();
      if (!this.form.client_id) {
        this.message = 'Client ID is missing. Cannot submit the form.';
        this.messageType = 'error';
        console.error('client_id is missing. Cannot submit the form.');
        return;
      }

      const url = `/api/learner-academic-behavioral-forms`;
      
      axios.post(url, this.form)
        .then(response => {
          this.editMode = false;
          this.message = 'Form submitted successfully!';
          this.messageType = 'success'; // Set success message
          this.clearMessageAfterDelay();
          this.fetchData(); // Reload the form data
          console.log('Form submitted successfully:', response.data);

        })
        .catch(error => {
          this.message = 'Error saving data: ' + (error.response?.data || error.message);
          this.messageType = 'error'; // Set error message
          this.clearMessageAfterDelay();
          console.error('Error saving data:', error.response?.data || error);
        });
    },
    clearMessageAfterDelay() {
    setTimeout(() => {
      this.message = '';
    }, 3000); // Clear the message after 3 seconds
  },
    toggleEdit() {
      this.message = ''; // Clear any existing messages when toggling edit mode
      this.messageType = ''; // Clear message type as well
      this.editMode = !this.editMode;
    },
    exportToPdf() {
        const pdf = new jsPDF('p', 'mm', [216, 356]); // 216mm x 356mm is legal size

        const marginTop = 20;
        const marginBottom = 20;
        
        const pageHeight = pdf.internal.pageSize.getHeight(); // Height of one page
        let currentY = marginTop;
        let totalPages = 1; // Track total pages
       

        // Function to add a new page if the content exceeds page height
        const addNewPageIfNeeded = (spaceNeeded) => {
          if (currentY + spaceNeeded >= pageHeight - marginBottom) {
            pdf.addPage();
            currentY = marginTop; // Reset currentY for new page
            totalPages += 1; // Increment total page count
          }
        };

        // Add header logo
        const logoImg = "/images/headerlogo2.png"; // Ensure correct path to the logo
        pdf.addImage(logoImg, "PNG", 15, currentY, 75, 35);
        currentY += 30;

        // Add title and header
        pdf.setFontSize(10);
        pdf.setFont('arialbd', 'bold');
        pdf.text('PROTECTIVE SERVICES DIVISION', 165, 30, null, null, "center");
        currentY += 5;
        pdf.setFontSize(10);
        pdf.setFont('TimesNewRoman', 'bold');
        pdf.text('REGIONAL REHABILITATION CENTER FOR YOUTH', 165, 35, null, null, "center");
        currentY += 5;
        pdf.text('Youth/RFO XI', 165, 40, null, null, "center");
        currentY += 3;

        // Add subtitle
        pdf.setFontSize(8);
        pdf.setFont('TimesNewRoman', 'italic');
        pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 165, 45, null, null, "center");
        currentY += 3;

        // Add form title
        pdf.setFontSize(16);
        pdf.setFont('TimesNewRoman', 'Bold');
        pdf.text("_______________________________________________________________", 105, currentY-8, null, null, "center");

        pdf.setFontSize(11);
        pdf.setFont('arialbd', 'bold');
        pdf.text("LEARNER’S ACADEMIC BEHAVIORAL FORM", 105, currentY, null, null, "center");

        currentY += 25;



        pdf.setFontSize(11);
pdf.setFont('arial', 'normal');

// For the Month of
pdf.text("For the Month of:", 85, 75, null, null, "left");  // Y-coordinate changed from 70 to 75
let labelWidthMonth = pdf.getTextWidth("For the Month of:");
pdf.text(`${this.form.month}`, 86 + labelWidthMonth, 75, null, null, "left");  // Y-coordinate changed from 70 to 75
let monthWidth = pdf.getTextWidth(`${this.form.month}`);
pdf.line(86 + labelWidthMonth, 76, 86 + labelWidthMonth + monthWidth, 76);  // Y-coordinate changed from 71 to 76

// School Year
pdf.text("School Year:", 85, 82, null, null, "left");  // Y-coordinate changed from 75 to 80
let labelWidthYear = pdf.getTextWidth("School Year:");
pdf.text(`${this.form.school_year}`, 87 + labelWidthYear, 82, null, null, "left");  // Y-coordinate changed from 75 to 80
let yearWidth = pdf.getTextWidth(`${this.form.school_year}`);
pdf.line(87 + labelWidthYear, 83, 87 + labelWidthYear + yearWidth, 83);  // Y-coordinate changed from 76 to 81


        // Learner's Name
pdf.text(`Learner's Name: ${this.form.learner_name}`, 20, currentY);
let learnerNameWidth = pdf.getTextWidth(`${this.form.learner_name}`);
pdf.line(20 + pdf.getTextWidth("Learner's Name: "), currentY + 1, 20 + pdf.getTextWidth("Learner's Name: ") + learnerNameWidth, currentY + 1); // Underline

// Grade
pdf.text(`Grade: ${this.form.grade}`, 150, currentY);
let gradeWidth = pdf.getTextWidth(`${this.form.grade}`);
pdf.line(150 + pdf.getTextWidth("Grade: "), currentY + 1, 150 + pdf.getTextWidth("Grade: ") + gradeWidth, currentY + 1); // Underline

currentY += 10;

// LRN
pdf.text(`LRN: ${this.form.lrn}`, 20, currentY);
let lrnWidth = pdf.getTextWidth(`${this.form.lrn}`);
pdf.line(20 + pdf.getTextWidth("LRN: "), currentY + 1, 20 + pdf.getTextWidth("LRN: ") + lrnWidth, currentY + 1); // Underline

// Status
pdf.text(`Status: ${this.form.status}`, 150, currentY);
let statusWidth = pdf.getTextWidth(`${this.form.status}`);
pdf.line(150 + pdf.getTextWidth("Status: "), currentY + 1, 150 + pdf.getTextWidth("Status: ") + statusWidth, currentY + 1); // Underline

currentY += 15;

 // Set up column headers
pdf.setFontSize(9);
pdf.setFont("arialbd", "bold");

// Header text for "Learner Skills"
pdf.text("LEARNER SKILLS", 21, currentY+6);

// Header text for "Outstanding" (wrapped)
let wrappedOutstanding = pdf.splitTextToSize("OUTSTANDING Well performed. Tasks are fully completed, all relevant information provided accurately and adequately where necessary. *Relevant tasks well performed; no tasks left incomplete", 25);
wrappedOutstanding.forEach((line, index) => {
    pdf.text(line, 76, currentY+6 + (index * 5)); // Increment Y for each line of wrapped text
});

// Header text for "Very Satisfactory"
let wrappedVerySatisfactory = pdf.splitTextToSize("VERY SATSFACTORY  General satisfactory with only minor omissions and inadequacies.Part of it is well attempted but overall, just satisfactory because of some major omissions and the limited coverage of the information", 35);
wrappedVerySatisfactory.forEach((line, index) => {
    pdf.text(line, 102, currentY +6 + (index * 5));
});

// Header text for "Satisfactory"
let wrappedSatisfactory = pdf.splitTextToSize("SATISFACTORY *Revealing significant omission and inadequacies. Very limited coverage performed.", 25);
wrappedSatisfactory.forEach((line, index) => {
    pdf.text(line, 141, currentY +6 + (index * 5));
});

// Header text for "Fairly Satisfactory"
let wrappedFairlySatisfactory = pdf.splitTextToSize("FAIRLY SATISFACTORY Very unsatisfactory, important task(s) are poorly done or not attempted to do so.", 28);
wrappedFairlySatisfactory.forEach((line, index) => {
    pdf.text(line, 172, currentY +6 + (index * 5));
});

// Calculate the maximum height of the wrapped text for all headers
let maxHeaderLines = Math.max(wrappedOutstanding.length, wrappedVerySatisfactory.length, wrappedSatisfactory.length, wrappedFairlySatisfactory.length);
currentY += maxHeaderLines * 5; // Adjust Y based on the tallest wrapped text

// Draw header lines
currentY += 3;
pdf.line(20, currentY - 70, 200, currentY - 70);
pdf.line(20, currentY, 200, currentY); // Bottom horizontal line of the header (no top line)

// Draw vertical lines for the entire table (headers and rows)
let topOfTable = currentY - (maxHeaderLines * 5); // Top Y position of the table
pdf.line(20, topOfTable, 20, currentY + 9);  // Left vertical line (Learner Skills)
pdf.line(75, topOfTable, 75, currentY + 7);  // Line between Learner Skills and Outstanding
pdf.line(100, topOfTable, 100, currentY + 5); // Line between Outstanding and Very Satisfactory
pdf.line(140, topOfTable, 140, currentY + 5); // Line between Very Satisfactory and Satisfactory
pdf.line(170, topOfTable, 170, currentY + 5); // Line between Satisfactory and Fairly Satisfactory
pdf.line(200, topOfTable, 200, currentY + 5); // Right vertical line (Fairly Satisfactory)

// Move currentY down after the header to start the rows
currentY += 5;

// Define the height of each row dynamically
let rowHeight = 10;

// Draw the table content (rows)
this.form.skills.forEach(skill => {
    addNewPageIfNeeded(rowHeight); // Check if there's enough space for the next row

    // Skill column
    pdf.text(skill.skill, 21, currentY);

    // Outstanding column
    pdf.text(skill.outstanding || "-", 81, currentY);

    // Very Satisfactory column
    pdf.text(skill.verySatisfactory || "-", 111, currentY);

    // Satisfactory column
    pdf.text(skill.satisfactory || "-", 151, currentY);

    // Fairly Satisfactory column
    pdf.text(skill.fairlySatisfactory || "-", 181, currentY);

    // Draw horizontal lines to separate each row
    pdf.line(20, currentY + 5, 200, currentY + 5); // Bottom horizontal line of the current row

    // Move to the next row
    currentY += rowHeight;
});

// Extend the vertical lines for each row dynamically, connected to the header
pdf.line(20, topOfTable, 20, currentY-5);  // Left vertical line (Learner Skills)
pdf.line(75, topOfTable, 75, currentY-5);  // Line between Learner Skills and Outstanding
pdf.line(100, topOfTable, 100, currentY-5); // Line between Outstanding and Very Satisfactory
pdf.line(140, topOfTable, 140, currentY-5); // Line between Very Satisfactory and Satisfactory
pdf.line(170, topOfTable, 170, currentY-5); // Line between Satisfactory and Fairly Satisfactory
pdf.line(200, topOfTable, 200, currentY-5); // Right vertical line (Fairly Satisfactory)

// Draw the final bottom line of the table




        // Add observation/feedback
        addNewPageIfNeeded(15);
        pdf.setFontSize(10);
        pdf.setFont("arialbd", "italic","bold");
        pdf.text("Observation/Feedback:", 20, currentY);

        pdf.setFont("Arial", "normal");
        currentY += 5;

        const maxLineWidth = 175;
        const wrappedText = pdf.splitTextToSize(this.form.observation_feedback || "None", maxLineWidth);

        // Add the wrapped text and handle pagination
        wrappedText.forEach(line => {
          addNewPageIfNeeded(7); // Check for space for each new line
          pdf.text(line, 20, currentY);
          currentY += 5;
        });

        
// Add signature section
addNewPageIfNeeded(25);
currentY += 20;
pdf.setFont("arialbd", "bold");

// Helper function to draw a line based on text width
function drawLine(pdf, text, x, y, width, position = "center") {
    // Draw the signature text or default underscores for the line
    pdf.text(text, x, y, position);
    let textWidth = pdf.getTextWidth(text); 
    let lineWidth = Math.max(width, textWidth); // Ensure the line is at least the specified width
    let lineXStart = x - lineWidth / 2; // Center the line on the text
    pdf.line(lineXStart, y + 2, lineXStart + lineWidth, y + 2); // Draw the line
}

// Signature lines and labels, adjusted for spacing and alignment

// Left side (Learner)
pdf.setFont('Arial','normal')
drawLine(pdf, this.form.learner_name || "", 40, currentY, 40); // Draw Learner name
pdf.text("Learner", 40, currentY + 7, 'center'); // Draw Learner label

// Middle left (Category Adviser)
pdf.setFont('Arial','normal')
drawLine(pdf, this.form.category_adviser_signature || "", 87, currentY, 40); // Draw Category Adviser signature
pdf.text("Category Adviser", 87, currentY + 7, 'center'); // Draw Category Adviser label

// Middle right (Educational Section Head)
pdf.setFont('Arial','normal')
drawLine(pdf, this.form.educational_section_head_signature || "Raldie Lloyd D. Adolfo, LPT", 132, currentY, 40); // Draw Educational Section Head signature
pdf.text("Educational Section Head", 132, currentY + 7, 'center'); // Draw Educational Section Head label

// Right side (Center Head)
pdf.setFont('Arial','normal')
drawLine(pdf, this.form.center_head_signature || "Angelic B. Pańa, RSW, MSSW", 180, currentY, 40); // Draw Center Head signature
pdf.text("Center Head", 180, currentY + 7, 'center'); // Draw Center Head label

currentY += 20; // Adjust currentY for the next section if needed





        // Add footer on every page
  const addFooter = (pageNum, totalPages) => {
    const footerY = pageHeight - 10; // Position footer 10mm from the bottom
    pdf.setFontSize(9);
    pdf.setFont("Arial", "normal")
    
    
    // Page numbering
    pdf.setFontSize(8);
    pdf.setFont("arialbd", "bold")
    pdf.text(`PAGE ${pageNum} of ${totalPages}`, 105, footerY - 5, null, null, 'center');
    pdf.setFontSize(16);
    pdf.text("_________________________________________________________________", 110, footerY+-5, null, null, 'center');

    // Form name
    pdf.setFontSize(8);
    pdf.text("LEARNER’S ACADEMIC BEHAVIORAL FORM", 105, footerY, null, null, 'center');
    

    // Footer text (DSWD info)
    pdf.setFontSize(6);
    pdf.setFont("Arial", "normal")
    pdf.text("DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION REGIONAL REHABILITATION CENTER FOR YOUTH, DAVAO CITY PHILIPPINES 8000", 105, footerY + 3, null, null, 'center');
    
  };

  // Track how many pages were created after adding all content
  const totalPagesPlaceholder = pdf.internal.getNumberOfPages();

  // Add footer to each page
  for (let i = 1; i <= totalPagesPlaceholder; i++) {
    pdf.setPage(i);
    addFooter(i, totalPagesPlaceholder); // Add footer with correct page number
  }

  // Save the PDF
  pdf.save(`learner-behavior-form-${this.form.client_id}.pdf`);
      }
  },
};
</script>

<style scoped>
table {
  border-collapse: collapse;
}

th, td {
  padding: 8px;
  text-align: left;
}

input[type="text"], textarea {
  border-width: 1px;
}
</style>
      