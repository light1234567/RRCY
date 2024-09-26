<template>
<!-- Tabs for Actions -->
<div v-if="editMode" class="flex absolute p-4 space-x-4">
    <button @click="cancelEdit" class="flex space-x-2 px-3 py-3 bg-[conic-gradient(at_bottom_right,_var(--tw-gradient-stops))] from-blue-700 via-blue-800 to-gray-900 text-white rounded-md text-xs">
      <!-- FontAwesome for Back -->
      <i class="fas fa-arrow-left w-4 h-4"></i>
      <span>Back</span>
    </button>
</div>

<div class="flex -ml-2 justify-end bg-transparent border -mr-9 border-gray-300 p-4 space-x-4 -mt-9">
    <!-- Pagination Component -->
    <Pagination 
      :totalPages="totalPages" 
      :currentPage="currentPage" 
      @update:currentPage="currentPage = $event" 
    />
    <button @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
      <!-- FontAwesome for Edit -->
      <i class="fas fa-edit w-4 h-4"></i>
      <span>Edit</span>
    </button>

    <button v-if="editMode" @click="openModal" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
      <!-- FontAwesome for Save -->
      <i class="fas fa-check w-4 h-4"></i>
      <span>Save</span>
    </button>

    <!-- Download PDF Button -->
    <button @click="exportToPdf" class="flex items-center space-x-2 px-3 py-1 bg-red-500 text-white rounded-md text-xs">
      <!-- FontAwesome for PDF Download -->
      <i class="fas fa-file-pdf w-4 h-4"></i>
      <span>Export PDF</span>
    </button>
</div>
<div class="graph-background pt-0.5  -mr-9 -mb-16">

  <!-- Page 1 Content -->
  <div v-if="currentPage === 1" class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
    <div class="relative flex justify-between items-center mb-2">
      <img src="/images/headerlogo2.png" alt="Logo" class="h-32 w-64 relative z-10">
      <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
    </div>

    <div class="text-center mb-8">
      <h1 class="text-2xl font-bold">ADMISSION CONTRACT</h1>
    </div>

    <div class="mb-8 text-justify">
      <p>
        In order to enable a CICL undergo rehabilitation through an intensive management of his behaviour and anti-social attitudes in a residential setting and prepare him for successful adjustment to his family and community after release. This contract is set for CICL, Parents/ Custodian, LGU to abide by the following provisions:
      </p>
    </div>

    <div class="mb-8">
      <h2 class="text-lg font-semibold">For the CICL:</h2>
      <ol class="list-decimal ml-6 space-y-2 text-justify">
        <li>To be physically fit, improve grooming and hygiene. Develop positive values, work habits and acquiring responsibility in a group living task.</li>
        <li>To develop emotional control, stability and maturity. Enable to acquire and equipped coping skills, life skills, solution-focus to address daily encountered problems, gain self-efficacy and self-actualization.</li>
        <li>To learn and develop new adaptive behaviours.</li>
        <li>To learn and live by with the daily structured activities of the center. Follow center policies and procedures at all times, as such offenses committed have corresponding corrective measure.</li>
        <li>To develop and regain self-concept, confidence and able to settle down, mix with others without occurrence of social and interpersonal conflicts.</li>
        <li>To enhance spiritual growth and rediscover the value, meaning and mission of one's life existence.</li>
        <li>To empower oneself knowledge through education and opportunity in taking acceleration exam.</li>
        <li>To equip oneself with skills, active participation in the management on income generating projects.</li>
      </ol>
    </div>

    <div class="mb-8">
      <h2 class="text-lg font-semibold">For the Parents/ Custodian:</h2>
      <ol class="list-decimal ml-6 space-y-2 text-justify">
        <li>To follow the rehabilitation Program/ intervention measures while their son is at the center.</li>
        <li>To observe schedule of visits to their son.</li>
        <li>To create and submit to Case Manager effective re integration plans for their son prior to termination phase of case management.</li>
        <li>To do follow up, constant monitoring of their son's performance while at the center.</li>
        <li>To attend obligatory activities at the center and schedule court hearings of their son.</li>
      </ol>
    </div>

    <div class="border-gray-300 ml-6 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        <div class="flex flex-col">
          <p class="ml-24 -mb-4 font-bold">PAGE 1 of {{ totalPages }}</p>
          <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
          <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrcy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
        </div>
        <div class="ml-4">
          <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
        </div>
      </div>
    </div>
  </div>

  <!-- Page 2 Content -->
  <div v-if="currentPage === 2" class="max-w-3xl p-16 bg-white shadow-xl rounded-lg mx-auto my-8 border border-gray-200">
    <h2 class="text-lg font-semibold">For the LSWDO:</h2>
    <ol class="list-decimal ml-6 space-y-2 text-justify">
      <li>To submit Social Case Study Report (SCSR) upon referral of CICL for Rehabilitation.</li>
      <li>To attend Case Conference and other obligatory responsibilities being Partners as service providers.</li>
      <li>To prepare ahead the Parenting Capability Assessment Report (PCAR).</li>
      <li>To assist for immediate release of LGU Claims.</li>
      <li>To prepare ahead an After-Care Plan.</li>
      <li>To give feedback to the DSWD F O XI-RRCY on the performances of CICL in his after Care Service.</li>
    </ol>

    <div class="mb-8">
      <p>Signed 
        <input type="text" v-model="form.signed_day" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-20 inline-block" :readonly="!editMode" maxlength="2" /> 
        day of 
        <input type="text" v-model="form.signed_month" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-20 inline-block" :readonly="!editMode" />, 
        2024. RRCY Davao City.
      </p>
    </div>

    <div class="text-right mt-12 mb-12">
      <input type="text" v-model="center_head" :class="{'twinkle-border': editMode}" class="w-1/2 inline-block border-none p-1 text-right" readonly>      <p>Center Head/SWO IV</p>
    </div>

    <div class="mt-8">
      <div class="grid grid-cols-2 gap-8">
        <!-- Conforme Section -->
        <div>
          <h2 class="text-lg font-semibold">Conforme:</h2>
          <div class="space-y-8 mt-4">
            <div>
              <input type="text" v-model="clientName" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" readonly />
              <label class="block text-gray-700 mt-1">Signature above-completed Name of CICL</label>
            </div>
            <div>
              <input type="text" v-model="form.parent_custodian_name" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
              <label class="block text-gray-700 mt-1">Signature above-completed Name of Parent/ Custodian</label>
            </div>
            <div>
              <input type="text" v-model="form.lgu_worker_name" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
              <label class="block text-gray-700 mt-1">Signature above-completed Name of LGU Worker</label>
            </div>
          </div>
        </div>

        <!-- Witnesses Section -->
        <div>
          <h2 class="text-lg font-semibold">Witnesses:</h2>
          <div class="space-y-8 mt-4">
            <div>
              <input type="text" v-model="form.rrcy_officer" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
              <label class="block text-gray-700 mt-1">RRCY Administering Officer</label>
            </div>
            <div>
              <input type="text" v-model="form.houseparent_on_duty" class="border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs w-full" :readonly="!editMode" />
              <label class="block text-gray-700 mt-1">Houseparent-On Duty</label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="border-gray-300 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        <div class="flex flex-col">
          <p class="ml-24 -mb-4 font-bold">PAGE 2 of {{ totalPages }}</p>
          <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
          <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrcy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
        </div>
        <div class="ml-4">
          <img src="/images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for Save Confirmation -->
  <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50">
    <div class="fixed inset-0 bg-black opacity-50"></div>
    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
      <div class="bg-white p-6">
        <div class="flex items-center">
          <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.93 5h13.86c1.1 0 1.96-.9 1.84-1.98l-1.18-12.14a2 2 0 00-1.98-1.88H4.27a2 2 0 00-1.98 1.88L1.11 16.02c-.12 1.08.74 1.98 1.84 1.98z"/>
          </svg>
          <h3 class="text-lg leading-6 font-medium text-gray-900">Save changes?</h3>
        </div>
        <div class="mt-2">
          <p class="text-sm text-gray-500">Are you sure you want to save the changes?</p>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button @click="confirmSave" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Save</button>
        <button @click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
      </div>
    </div>
  </div>

  <!-- Modal for Save Result -->
  <div v-if="isSaveResultModalOpen" class="fixed inset-0 flex items-center justify-center z-50">
    <div class="fixed inset-0 bg-black opacity-50"></div>
    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
      <div class="bg-white p-6 text-center">
        <div v-if="saveResultTitle === 'Error'" class="flex justify-center items-center mb-4">
          <div class="flex items-center justify-center w-12 h-12 bg-red-100 rounded-full">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </div>
        </div>
        <div v-if="saveResultTitle === 'Success'" class="flex justify-center items-center mb-4">
          <div class="flex items-center justify-center w-12 h-12 bg-blue-500 rounded-full">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
        </div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ saveResultTitle }}</h3>
        <div class="mt-2">
          <p class="text-sm text-gray-500">{{ saveResultMessage }}</p>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button @click="closeSaveResultModal" :class="saveResultTitle === 'Error' ? 'bg-red-600 hover:bg-red-500' : 'bg-blue-600 hover:bg-blue-500'" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
          OK
        </button>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import axios from 'axios';
import { jsPDF } from 'jspdf';
import Pagination from '@/Components/Pagination.vue';
import '../../../fonts/arial-normal.js'; 
import '../../../fonts/times-normal.js'; 
import '../../../fonts/arialbd-bold.js'; 


export default {
  name: 'AdmissionContract',
  components: {
    Pagination,
  },
  data() {
    return {
      editMode: false,
      message: '',
      messageType: '',
      center_head: '',
      form: {
        client_id: null,
        signed_day: '',
        signed_month: '',
        parent_custodian_name: '',
        lgu_worker_name: '',
        rrcy_officer: '',
        houseparent_on_duty: '',
        id: null,
      },
      clientName: '',
      errorMessage: '',
      currentPage: 1,
      totalPages: 2,
      isModalOpen: false,
      isSaveResultModalOpen: false,
      saveResultTitle: '',
      saveResultMessage: '',
    };
  },
  mounted() {
    this.fetchData();
    this.fetchCenterHead();
  },
  watch: {
    '$route.params.id': function(newId) {
      this.fetchData();
    }
  },
  methods: {
    fetchData() {
      const id = this.$route.params.id;
      if (id) {
        axios.get(`/api/clients/${id}`)
          .then((response) => {
            const client = response.data;
            this.clientName = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
            this.form.client_id = client.id;
            console.log('Client ID fetched:', client.id);

            return axios.get(`/api/admission-contracts/${id}`);
          })
          .then((response) => {
            const admissionContract = response.data;
            this.form.signed_day = admissionContract.signed_day || '';
            this.form.signed_month = admissionContract.signed_month || '';
            this.form.parent_custodian_name = admissionContract.parent_custodian_name || '';
            this.form.lgu_worker_name = admissionContract.lgu_worker_name || '';
            this.form.rrcy_officer = admissionContract.rrcy_officer || '';
            this.form.houseparent_on_duty = admissionContract.houseparent_on_duty || '';
            this.form.id = admissionContract.id;
          })
          .catch((error) => {
            this.errorMessage = 'Error fetching data: ' + (error.response?.data?.message || error.message);
            console.error('Error fetching data:', error);
          });
      }
    },
    fetchCenterHead() {
    axios.get('/api/center-head')  // Replace with the correct API route
      .then(response => {
        this.center_head = response.data.name;  // Bind the fetched name to v-model
      })
      .catch(error => {
        console.error('Error fetching center head:', error);
      });
  },
    toggleEdit() {
      if (this.editMode) {
        this.openModal();
      } else {
        this.editMode = !this.editMode;
      }
    },
    openModal() {
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
    },
    confirmSave() {
      this.saveData();
      this.closeModal();
      this.editMode = false;
    },
    closeSaveResultModal() {
      this.isSaveResultModalOpen = false;
    },
    saveData() {
      if (!this.form.client_id) {
        this.message = 'Client ID is missing.';
        this.messageType = 'error';
        return;
      }

      const method = this.form.id ? 'put' : 'post';
      const url = `/api/admission-contracts${this.form.id ? '/' + this.form.id : ''}`;

      axios[method](url, this.form)
        .then((response) => {
          this.saveResultTitle = 'Success';
          this.saveResultMessage = 'Data saved successfully!';
          this.errorMessage = '';

          if (!this.form.id) {
            this.form.id = response.data.id;
          }

          setTimeout(() => {
            this.message = '';
          }, 3000);
        })
        .catch((error) => {
          this.saveResultTitle = 'Error';
          this.saveResultMessage = 'Error saving data: ' + (error.response?.data?.message || error.message);
          console.error('Error saving data:', error);
        })
        .finally(() => {
          this.isSaveResultModalOpen = true;
        });
    },
    updatePage(page) {
      this.currentPage = page;
    },
    exportToPdf() {
  const pdf = new jsPDF('p', 'mm', 'a4'); // Standard A4 size document

  // Function to justify text
function justifyText(text, maxWidth, initialX, yPos, pdf) {
    const lines = pdf.splitTextToSize(text, maxWidth);
    lines.forEach((line, lineIndex) => {
        const words = line.split(' ');
        if (words.length > 1 && lineIndex < lines.length - 1) {
            const totalWordsWidth = words.reduce((total, word) => total + pdf.getTextWidth(word), 0);
            const totalSpaceWidth = maxWidth - totalWordsWidth;
            const spaceWidth = totalSpaceWidth / (words.length - 1);

            let x = initialX;
            words.forEach((word, index) => {
                pdf.text(word, x, yPos);
                x += pdf.getTextWidth(word) + spaceWidth;  // Add space between words
            });
        } else {
            // For the last line or single-word lines, print as is (no extra spaces)
            pdf.text(line, initialX, yPos);
        }
        yPos += 7; // Move to the next line
    });
}

  // Convert your image to Base64 or ensure it's a valid URL
  const imgData = '/images/headerlogo2.png'; // Ensure this is correct or use Base64 image
  pdf.addImage(imgData, 'PNG', 15, 10, 50, 30); // DSWD logo

  // Header
  pdf.setFontSize(9);
pdf.setFont('TimesNewRoman', 'italic'); // Set font style to italic
pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 135, 20);

  pdf.setFont('arialbd', 'bold');
  pdf.setFontSize(20);
  pdf.setTextColor(0, 0, 0); // Black text for title
  pdf.text('Admission Contract', 105, 48, null, null, 'center'); // Centered title

  // Main Content: Adjust positioning and apply bold/underline styles
  let contentYPos = 55; // Start below the title

  let initialX = 20;  // Adjust this value to shift the text further right as needed
  const maxWidth = 170;

  contentYPos += 5;
  pdf.setFont('arial', 'normal');
  pdf.setFontSize(12);
  const text1 = 'In order to enable a CICL undergo rehabilitation through an intensive management of his behaviour and anti-social attitudes in a residential setting and prepare him for successful adjustment to his family and community after release. This contract is set for CICL, Parents/ Custodian, LGU to abide by the following provisions:';
  justifyText(text1, maxWidth, initialX, contentYPos, pdf);


  contentYPos += 35;
  pdf.setFontSize(13);
  pdf.setFont('arialbd', 'bold');
  pdf.text('For the CICL:', initialX, contentYPos);

  pdf.setFontSize(12);
  pdf.setFont('arial', 'normal');

  contentYPos += 7; 
  pdf.text('1. To be physically fit, improve grooming and hygiene. Develop positive values, work', initialX+5, contentYPos);
  contentYPos += 7; 
  pdf.text('habits and acquiring responsibility in a group living task.', initialX+10, contentYPos);
  contentYPos += 7; 
  pdf.text('2. To develop emotional control, stability and maturity. Enable to acquire and equipped', initialX+5, contentYPos);
  contentYPos += 7; 
  pdf.text('coping skills, life skills, solution-focus to address daily encountered problems, gain', initialX+10, contentYPos);
  contentYPos += 7; 
  pdf.text('self-efficacy and self-actualization.', initialX+10, contentYPos);
  contentYPos += 7; 
  pdf.text('3. To learn and develop new adaptive behaviours.', initialX+5, contentYPos);
  contentYPos += 7; 
  pdf.text('4. To learn and live by with the daily structured activities of the center. Follow center', initialX+5, contentYPos);
  contentYPos += 7; 
  pdf.text('policies and procedures at all times, as such offenses committed have corresponding', initialX+10, contentYPos);
  contentYPos += 7; 
  pdf.text('corrective measure.', initialX+10, contentYPos);
  contentYPos += 7; 
  pdf.text('5. To develop and regain self-concept, confidence and able to settle down, mix with', initialX+5, contentYPos);
  contentYPos += 7; 
  pdf.text('others without occurrence of social and interpersonal conflicts.', initialX+10, contentYPos);
  contentYPos += 7; 
  pdf.text('6. To enhance spiritual growth and rediscover the value, meaning and mission of ones', initialX+5, contentYPos);
  contentYPos += 7; 
  pdf.text('life existence.', initialX+10, contentYPos);
  contentYPos += 7; 
  pdf.text('7. To empower oneself knowledge through education and opportunity in taking', initialX+5, contentYPos);
  contentYPos += 7; 
  pdf.text('acceleration exam.', initialX+10, contentYPos);
  contentYPos += 7; 
  pdf.text('8. To equip oneself with skills, active participation in the management on income', initialX+5, contentYPos);
  contentYPos += 7; 
  pdf.text('generating projects.', initialX+10, contentYPos);

  contentYPos += 11;
  pdf.setFontSize(13);
  pdf.setFont('arialbd', 'bold');
  pdf.text('For the Parents/ Custodian:', initialX, contentYPos);

  pdf.setFontSize(12);
  pdf.setFont('arial', 'normal');
  contentYPos += 7; 
  pdf.text('1. To follow the rehabilitation Program/ intervention measures while their son is at the', initialX+5, contentYPos);
  contentYPos += 7; 
  pdf.text('center.', initialX+10, contentYPos);
  contentYPos += 7; 
  pdf.text('2. To observe schedule of visits to their son.', initialX+5, contentYPos);
  contentYPos += 7; 
  pdf.text('3. To create and submit to Case Manager effective re integration plans for their son', initialX+5, contentYPos);
  contentYPos += 7; 
  pdf.text('prior to termination phase of case management.', initialX+10, contentYPos);

// Footer Section - Adjusted Y positions to move higher
pdf.setFontSize(9);
pdf.setFont('TimesNewRoman', 'bold');
pdf.text('PAGE 1 of 2', 105, 280, null, null, 'center'); // Moved higher (was 290)
pdf.setLineWidth(0.5); // Set line width to make it bolder (default is 0.200)
pdf.line(17, 282, 173, 282); // Footer line moved higher (was 292)
pdf.setFont('times', 'normal');
const footerText = pdf.splitTextToSize('DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Prk. 7 Bago-Oshiro, Tugbok Dist., Davao City', 160); // Adjust width limit (160mm)
  pdf.text(footerText, 95, 287, null, null, 'center');
pdf.text('Email: rrcy.fo11@dswd.gov.ph    Tel. No.: 293-0306', 105, 292, null, null, 'center');

const footerImgData = '/images/footerimg.png';
pdf.addImage(footerImgData, 'PNG', 175, 275, 25, 12); // Adjust the position and size

  // Add a new page for Page 2 content
  pdf.addPage();

  pdf.setFont('TimesNewRoman', 'italic'); // Set font style to italic
pdf.text('DSPDP-GF-010A | REV.00 | 12 SEP 2023', 135, 20);
  
  contentYPos = 30; // Reset Y position for the new page
  pdf.setLineWidth(0); // Set line width to make it bolder (default is 0.200)
  pdf.setFontSize(12);
  pdf.setFont('arial', 'normal');
  contentYPos += 7; // Reset Y position for the new page
  pdf.text('4. To do follow up, constant monitoring of their sons performance while at the center.', initialX+5, contentYPos);
  contentYPos += 7; // Reset Y position for the new page
  pdf.text('5. To attend obligatory activities at the center and schedule court hearings of their son.', initialX+5, contentYPos);
  
  

  contentYPos += 11;
  pdf.setFontSize(13);
  pdf.setFont('arialbd', 'bold');
  pdf.text('For the LSWDO:', initialX, contentYPos);

  pdf.setFontSize(12);
  pdf.setFont('arial', 'normal');
  contentYPos += 7; // Reset Y position for the new page
  pdf.text('1. To submit Social Case Study Report (SCSR) upon referral of CICL for Rehabilitation.', initialX+5, contentYPos);
  contentYPos += 7; // Reset Y position for the new page
  pdf.text('2. To attend Case Conference and other obligatory responsibilities being Partners as', initialX+5, contentYPos);
  contentYPos += 7; 
  pdf.text('service providers.', initialX+10, contentYPos);
  contentYPos += 7; // Reset Y position for the new page
  pdf.text('3. To prepare ahead the Parenting Capability Assessment Report (PCAR).', initialX+5, contentYPos);
  contentYPos += 7; // Reset Y position for the new page
  pdf.text('4. To assist for immediate release of LGU Claims.', initialX+5, contentYPos);
  contentYPos += 7; // Reset Y position for the new page
  pdf.text('5. To prepare ahead an After-Care Plan.', initialX+5, contentYPos);
  contentYPos += 7; // Reset Y position for the new page
  pdf.text('6. To give feedback to the DSWD F O XI-RRCY on the performances of CICL in his', initialX+5, contentYPos);
  contentYPos += 7; 
  pdf.text('after Care Service.', initialX+10, contentYPos);


  contentYPos += 10; 
pdf.setFont('arial', 'normal');
pdf.setFontSize(13);
pdf.text('Signed', initialX, contentYPos);
pdf.setFontSize(11);
pdf.text(`${this.form.signed_day || ''}`, initialX+19, contentYPos+-1);
pdf.setFontSize(13);
pdf.line(37, contentYPos, 55, contentYPos); 
pdf.text('day of', initialX+40, contentYPos); 
pdf.setFontSize(11);
pdf.text(`${this.form.signed_month || ''}`, initialX+58, contentYPos+-1);
pdf.setFontSize(13);
pdf.line(75, contentYPos, 95, contentYPos); 
pdf.text(', 2024. RRCY Davao City.', initialX+76, contentYPos); 

// Signature Section
contentYPos += 25;
  pdf.setFont('arialbd', 'bold');
  pdf.text('ANGELIC B. PAÑA, RSW, MSSW', 120, contentYPos);
  pdf.setFont('arial', 'normal');
  pdf.text('Center Head/SWO IV', 120, contentYPos + 6);
  contentYPos += 1;
  pdf.line(192, contentYPos, 120, contentYPos); // Underline first (left aligned)
  
  contentYPos += 20;
  pdf.setFontSize(13);
  pdf.setFont('arialbd', 'bold');
  pdf.text('Conforme:', initialX, contentYPos);
  pdf.text('Witnesses:', initialX+95, contentYPos);

  // Client/Resident underline and label
  contentYPos += 20;

  pdf.text(`${this.clientName || ''}`, initialX, contentYPos+-2);
pdf.line(20, contentYPos, 100, contentYPos); // Underline first (left aligned)
contentYPos += 5; // Move Y position down for the text
pdf.setFont('arial', 'normal');
pdf.setFontSize(12);
pdf.text('Signature above-completed Name of CICL', 20, contentYPos); // Label below the underline

// Adjust X-coordinates to align the second signature section to the right
contentYPos += -5;
initialX = 110; // Set initialX for the second signature section on the right side
pdf.text(`${this.form.rrcy_officer || ''}`, initialX, contentYPos+-2);
pdf.line(initialX, contentYPos, initialX + 80, contentYPos); // Underline on the right side (adjusted X-coordinates)
contentYPos += 5; // Move Y position down for the text
pdf.setFont('arial', 'normal');
pdf.setFontSize(12);
pdf.text('RRCY Administering Officer', initialX, contentYPos); // Label below the underline on the right side


  // Client/Resident underline and label
  contentYPos += 20;
  pdf.text(`${this.form.parent_custodian_name || ''}`, initialX+-90, contentYPos+-2);
pdf.line(20, contentYPos, 100, contentYPos); // Underline first (left aligned)
contentYPos += 5; // Move Y position down for the text
pdf.setFont('arial', 'normal');
pdf.setFontSize(12);
pdf.text('Signature above-completed Name of', 20, contentYPos); // Label below the underline
pdf.text('Parent/ Custodian', 20, contentYPos+5); // Label below the underline

// Adjust X-coordinates to align the second signature section to the right
contentYPos += -5;
initialX = 110; // Set initialX for the second signature section on the right side
pdf.text(`${this.form.houseparent_on_duty || ''}`, initialX, contentYPos+-2);
pdf.line(initialX, contentYPos, initialX + 80, contentYPos); // Underline on the right side (adjusted X-coordinates)
contentYPos += 5; // Move Y position down for the text
pdf.setFont('arial', 'normal');
pdf.setFontSize(12);
pdf.text('Houseparent-On Duty', initialX, contentYPos); // Label below the underline on the right side

contentYPos += 20;
pdf.text(`${this.form.lgu_worker_name || ''}`, initialX+-90, contentYPos+-2);
pdf.line(20, contentYPos, 100, contentYPos); // Underline first (left aligned)
contentYPos += 5; // Move Y position down for the text
pdf.setFont('arial', 'normal');
pdf.setFontSize(12);
pdf.text('Signature above-completed Name of LGU', 20, contentYPos); // Label below the underline
pdf.text('Worker', 20, contentYPos+5); // Label below the underline




// Footer Section - Adjusted Y positions to move higher
pdf.setFontSize(8.5); // Reduced font size to fit the text in one line
pdf.setFont('TimesNewRoman', 'bold');

// Footer page number
pdf.text('PAGE 2 of 2', 105, 280, null, null, 'center');

// Footer line
pdf.setLineWidth(0.5); // Set line width to make it bolder (default is 0.200)
pdf.line(17, 282, 193, 282); // Adjusted line width to extend across the footer

// Single-line footer text without splitting
pdf.text('DSWD | FIELD OFFICE XI | PROTECTIVE SERVICES DIVISION | REGIONAL REHABILITATION CENTER FOR YOUTH', 105, 285, null, null, 'center'); // Moved Y from 287 to 285 for better alignment

  // Save the PDF
  pdf.save('admission_contract.pdf');
}
  }
};
</script>

<style scoped>
.graph-background {
    background-image: linear-gradient(to right, #cccccc 1px, transparent 1px), 
                      linear-gradient(to bottom, #cccccc 1px, transparent 1px);
    background-size: 15px 15px; /* Adjust size as per your need */
  }
button {
  transition: background-color 0.3s;
}
button:hover {
  background-color: #2563eb;
}
</style>
