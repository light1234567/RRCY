<template>
  <div class="p-10 bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md">
      <div class="text-center mb-8">
        <img src="path/to/dswd-logo.png" alt="DSWD Logo" class="mx-auto mb-4" />
        <h1 class="text-xl font-bold">ADMISSION CONTRACT</h1>
      </div>

      <div class="flex justify-end mb-4">
        <button @click="toggleEdit" class="px-4 py-2 bg-blue-500 text-white rounded-md mt-4">
          {{ editMode ? 'Save' : 'Edit' }}
        </button>
      </div>

      <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
        {{ message }}
      </div>

      <div class="mb-8">
        <p>
          In order to enable a CICL undergo rehabilitation through an intensive management of his behaviour and anti-social attitudes in a residential setting and prepare him for successful adjustment to his family and community after release. This contract is set for CICL, Parents/ Custodian, LGU to abide the following provisions:
        </p>
      </div>
  
      <div class="mb-8">
        <h2 class="text-lg font-semibold">For the CICL:</h2>
        <ol class="list-decimal ml-6 space-y-2">
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
        <ol class="list-decimal ml-6 space-y-2">
          <li>To follow the rehabilitation Program/ intervention measures while their son is at the center.</li>
          <li>To observe schedule of visits to their son.</li>
          <li>To create and submit to Case Manager effective re integration plans for their son prior to termination phase of case management.</li>
          <li>To do follow up, constant monitoring of their son's performance while at the center.</li>
          <li>To attend obligatory activities at the center and schedule court hearings of their son.</li>
        </ol>
      </div>
  
      <div class="mb-8">
        <h2 class="text-lg font-semibold">For the LSWDO:</h2>
        <ol class="list-decimal ml-6 space-y-2">
          <li>To submit Social Case Study Report (SCSR) upon referral of CICL for Rehabilitation.</li>
          <li>To attend Case Conference and other obligatory responsibilities being Partners as service providers.</li>
          <li>To prepare ahead the Parenting Capability Assessment Report (PCAR).</li>
          <li>To assist for immediate release of LGU Claims.</li>
          <li>To prepare ahead an After-Care Plan.</li>
          <li>To give feedback to the DSWD F O XI-RRCY on the performances of CICL in his after Care Service.</li>
        </ol>
      </div>
  
      <div class="mb-8">
        <p>Signed 
          <input type="text" v-model="form.signed_day" class="border w-20 px-2 py-1 inline-block" :readonly="!editMode" maxlength="2" /> 
          day of 
          <input type="text" v-model="form.signed_month" class="border w-20 px-2 py-1 inline-block" :readonly="!editMode" />, 
          2024. RRCY Davao City.
        </p>
      </div>

      <div class="text-center mt-8">
        <p>ANGELIC B. PAÑA, RSW, MSSW</p>
        <p>Center Head/SWO IV</p>
      </div>

      <div class="mt-8">
        <h2 class="text-lg font-semibold">Conforme:</h2>
        <div class="space-y-2">
          <div>
  <label>Signature above-completed Name of CICL</label>
  <input type="text" v-model="clientName" class="border w-full px-2 py-1" readonly />
</div>

          <div>
            <label>Signature above-completed Name of Parent/ Custodian</label>
            <input type="text" v-model="form.parent_custodian_name" class="border w-full px-2 py-1" :readonly="!editMode" />
          </div>
          <div>
            <label>Signature above-completed Name of LGU Worker</label>
            <input type="text" v-model="form.lgu_worker_name" class="border w-full px-2 py-1" :readonly="!editMode" />
          </div>
        </div>

        <h2 class="text-lg font-semibold mt-8">Witnesses:</h2>
        <div class="space-y-2">
          <div>
            <label>RRCY Administering Officer</label>
            <input type="text" v-model="form.rrcy_officer" class="border w-full px-2 py-1" :readonly="!editMode" />
          </div>
          <div>
            <label>Houseparent-On Duty</label>
            <input type="text" v-model="form.houseparent_on_duty" class="border w-full px-2 py-1" :readonly="!editMode" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';

export default {
  setup() {
    const route = useRoute();
    const editMode = ref(false);
    const message = ref('');
    const messageType = ref('');
    const form = ref({
      client_id: null,
      signed_day: '',
      signed_month: '',
      parent_custodian_name: '',
      lgu_worker_name: '',
      rrcy_officer: '',
      houseparent_on_duty: '',
      id: null // Add id to track existing record
    });
    const clientName = ref('');
    const errorMessage = ref('');

    const fetchClientData = async (clientId) => {
      try {
        const clientResponse = await axios.get(`/api/clients/${clientId}`);
        const client = clientResponse.data;
        clientName.value = `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
        form.value.client_id = client.id;

        const admissionContractResponse = await axios.get(`/api/admission-contracts/${clientId}`);
        const admissionContract = admissionContractResponse.data;
        form.value.signed_day = admissionContract.signed_day || '';
        form.value.signed_month = admissionContract.signed_month || '';
        form.value.parent_custodian_name = admissionContract.parent_custodian_name || '';
        form.value.lgu_worker_name = admissionContract.lgu_worker_name || '';
        form.value.rrcy_officer = admissionContract.rrcy_officer || '';
        form.value.houseparent_on_duty = admissionContract.houseparent_on_duty || '';
        form.value.id = admissionContract.id;
      } catch (error) {
        errorMessage.value = 'Error fetching client data: ' + (error.response?.data?.message || error.message);
        console.error('Error fetching client data:', error);
      }
    };

    const toggleEdit = () => {
      if (editMode.value) {
        saveData();
      }
      editMode.value = !editMode.value;
    };

    const saveData = async () => {
      if (!form.value.client_id) {
        message.value = 'Client ID is missing.';
        messageType.value = 'error';
        return;
      }

      try {
        const response = await axios[form.value.id ? 'put' : 'post'](`/api/admission-contracts${form.value.id ? '/' + form.value.id : ''}`, form.value);
        message.value = 'Data saved successfully!';
        messageType.value = 'success';
        errorMessage.value = '';

        if (!form.value.id) {
          form.value.id = response.data.id;
        }

        setTimeout(() => {
          message.value = '';
        }, 3000);
      } catch (error) {
        message.value = 'Error saving data: ' + (error.response?.data?.message || error.message);
        messageType.value = 'error';
        console.error('Error saving data:', error);
      }
    };

    onMounted(() => {
      const id = route.params.id;
      if (id) {
        fetchClientData(id);
      }
    });

    return {
      editMode,
      form,
      clientName,
      errorMessage,
      message,
      messageType,
      toggleEdit,
    };
  }
};
</script>

<style scoped>
button {
  transition: background-color 0.3s;
}
button:hover {
  background-color: #2563eb;
}
</style>
