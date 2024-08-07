<template>
  <div class="p-10 bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md">
      <div class="text-center mb-8">
        <img src="path/to/dswd-logo.png" alt="DSWD Logo" class="mx-auto mb-4" />
        <h1 class="text-xl font-bold">GENERAL INTAKE SHEET</h1>
        <p>Date: <input type="date" v-model="sheet.date" class="border w-1/8 px-2 py-1" :readonly="!editMode" /></p>
      </div>
      <div class="flex justify-end">
  <button @click="toggleEdit" class="px-4 py-2 bg-blue-500 text-white rounded-md mt-4">
    {{ editMode ? 'Save' : 'Edit' }}
  </button>
</div>

      <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
        {{ message }}
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">I. Identifying Information:</h2>
        <div class="space-y-2">
          <div>
            <label>Name of client</label>
            <input type="text" v-model="sheet.name" class="border w-full px-2 py-1" readonly />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label>Age</label>
              <input type="text" v-model="sheet.age" class="border w-full px-2 py-1" readonly />
            </div>
            <div>
              <label>Sex</label>
              <input type="text" v-model="sheet.sex" class="border w-full px-2 py-1" readonly />
            </div>
          </div>
          <div>
            <label>Address</label>
            <input type="text" v-model="sheet.address" class="border w-full px-2 py-1" readonly />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label>Date of Birth</label>
              <input type="date" v-model="sheet.date_of_birth" class="border w-full px-2 py-1" readonly />
            </div>
            <div>
              <label>Place of birth</label>
              <input type="text" v-model="sheet.place_of_birth" class="border w-full px-2 py-1" readonly />
            </div>
          </div>
          <div>
            <label>Religion</label>
            <input type="text" v-model="sheet.religion" class="border w-full px-2 py-1" readonly />
          </div>
          <div>
            <label>Occupation</label>
            <input type="text" v-model="sheet.occupation" class="border w-full px-2 py-1" :readonly="!editMode" />
          </div>
          <div>
            <label>Highest Educ'l Att't</label>
            <input type="text" v-model="sheet.highest_educ_att" class="border w-full px-2 py-1" :readonly="!editMode" />
          </div>
          <div>
            <label>Name of School</label>
            <input type="text" v-model="sheet.school_name" class="border w-full px-2 py-1" :readonly="!editMode" />
          </div>
          <div>
            <label>Class Adviser</label>
            <input type="text" v-model="sheet.class_adviser" class="border w-full px-2 py-1" :readonly="!editMode" />
          </div>
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">II. Problem Presented:</h2>
        <textarea v-model="sheet.problem_presented" class="border w-full px-2 py-1" rows="4" :readonly="!editMode"></textarea>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">III. Brief Physical description of the minor:</h2>
        <textarea v-model="sheet.brief_physical_description" class="border w-full px-2 py-1" rows="4" :readonly="!editMode"></textarea>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">A. Major life Events:</h2>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label><input type="checkbox" v-model="sheet.major_life_event.death_of_parents" :disabled="!editMode" /> Death of Parents</label><br />
            <label><input type="checkbox" v-model="sheet.major_life_event.separation_from_family" :disabled="!editMode" /> Separation from the family</label><br />
            <label><input type="checkbox" v-model="sheet.major_life_event.natural_disaster" :disabled="!editMode" /> Victim of natural / manmade disaster</label><br />
            <label><input type="checkbox" v-model="sheet.major_life_event.apprehension" :disabled="!editMode" /> Victim of apprehension</label><br />
            <label><input type="checkbox" v-model="sheet.major_life_event.physical_abuse" :disabled="!editMode" /> Victim of physical abuse</label><br />
            <label><input type="checkbox" v-model="sheet.major_life_event.suicidal_tendencies" :disabled="!editMode" /> with suicidal tendencies</label><br />
            <label><input type="checkbox" v-model="sheet.major_life_event.mistaken_identity" :disabled="!editMode" /> mistaken identity</label><br />
          </div>
          <div>
            <label><input type="checkbox" v-model="sheet.major_life_event.abandonment" :disabled="!editMode" /> Abandonment</label><br />
            <label><input type="checkbox" v-model="sheet.major_life_event.serious_accident" :disabled="!editMode" /> Serious Accident</label><br />
            <label><input type="checkbox" v-model="sheet.major_life_event.demolition" :disabled="!editMode" /> Victim of demolition</label><br />
            <label><input type="checkbox" v-model="sheet.major_life_event.sexual_abuse" :disabled="!editMode" /> Victim of sexual abuse</label><br />
            <label><input type="checkbox" v-model="sheet.major_life_event.verbal_abuse" :disabled="!editMode" /> Victim of verbal abuse</label><br />
            <label><input type="checkbox" v-model="sheet.major_life_event.disability" :disabled="!editMode" /> acquired disability</label><br />
            <label><input type="checkbox" v-model="sheet.major_life_event.others" :disabled="!editMode" /> others: (pls. Specify)</label><br />
          </div>
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">B. Enduring Life Strain:</h2>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label><input type="checkbox" v-model="sheet.enduring_life_strain.poverty" :disabled="!editMode" /> Poverty</label><br />
            <label><input type="checkbox" v-model="sheet.enduring_life_strain.physical_illness" :disabled="!editMode" /> Physical illness</label><br />
            <label><input type="checkbox" v-model="sheet.enduring_life_strain.lack_recreational_facilities" :disabled="!editMode" /> Lack of recreational facilities</label><br />
            <label><input type="checkbox" v-model="sheet.enduring_life_strain.exclusion_from_peers" :disabled="!editMode" /> Exclusion from peers</label><br />
            <label><input type="checkbox" v-model="sheet.enduring_life_strain.other" :disabled="!editMode" /> other (pls. specify)</label><br />
          </div>
          <div>
            <label><input type="checkbox" v-model="sheet.enduring_life_strain.constant_need_to_earn" :disabled="!editMode" /> constant need to earn for the family</label><br />
            <label><input type="checkbox" v-model="sheet.enduring_life_strain.lack_education_opportunity" :disabled="!editMode" /> lack of educational/ opportunity</label><br />
            <label><input type="checkbox" v-model="sheet.enduring_life_strain.exclusion_from_school" :disabled="!editMode" /> exclusion from school</label><br />
            <label><input type="checkbox" v-model="sheet.enduring_life_strain.disability" :disabled="!editMode" /> with disability</label><br />
          </div>
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">C. Life Transition:</h2>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label><input type="checkbox" v-model="sheet.life_transition.moving_neighbour" :disabled="!editMode" /> moving from one neighbour to another</label><br />
            <label><input type="checkbox" v-model="sheet.life_transition.changing_peer_group" :disabled="!editMode" /> Changing peer group</label><br />
            <label><input type="checkbox" v-model="sheet.life_transition.moving_due_to_demolition" :disabled="!editMode" /> moving of another place of residence due to demolition</label><br />
            <label><input type="checkbox" v-model="sheet.life_transition.moving_due_to_disaster" :disabled="!editMode" /> moving of another place of residence due to disaster</label><br />
            <label><input type="checkbox" v-model="sheet.life_transition.kinship_foster_placement" :disabled="!editMode" /> moving from biological family to a kinship/ foster placement</label><br />
            <label><input type="checkbox" v-model="sheet.life_transition.beginning_romantic_relationship" :disabled="!editMode" /> beginning romantic relationship</label><br />
            <label><input type="checkbox" v-model="sheet.life_transition.beginning_parents_romantic_relationship" :disabled="!editMode" /> beginning romantic relationship of parents</label><br />
            <label><input type="checkbox" v-model="sheet.life_transition.others" :disabled="!editMode" /> others (pls. specify)</label><br />
          </div>
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">D. Development Changes:</h2>
        <div class="space-y-2">
          <label><input type="checkbox" v-model="sheet.development_changes.early_childhood" :disabled="!editMode" /> Early childhood 1-6 yrs. Old</label><br />
          <label><input type="checkbox" v-model="sheet.development_changes.school_age" :disabled="!editMode" /> School age 7-12 yrs. Old</label><br />
          <label><input type="checkbox" v-model="sheet.development_changes.adolescence" :disabled="!editMode" /> Adolescence 13-18 yrs. old</label><br />
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">E. Normalization:</h2>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label><input type="checkbox" v-model="sheet.normalization.legality_law_enforcement" :disabled="!editMode" /> legality/law enforcement (weak)</label><br />
            <label><input type="checkbox" v-model="sheet.normalization.commercial_sex" :disabled="!editMode" /> Availability of:</label><br />
            <div class="ml-4">
              <label><input type="checkbox" v-model="sheet.normalization.commercial_sex" :disabled="!editMode" /> Commercial sex</label><br />
              <label><input type="checkbox" v-model="sheet.normalization.substance_illegal_drugs" :disabled="!editMode" /> substance/illegal drugs</label><br />
              <label><input type="checkbox" v-model="sheet.normalization.pornography_materials" :disabled="!editMode" /> Pornography materials to include video tapes</label><br />
              <label><input type="checkbox" v-model="sheet.normalization.red_houses" :disabled="!editMode" /> Red houses</label><br />
            </div>
            <label><input type="checkbox" v-model="sheet.normalization.price_least_expensive" :disabled="!editMode" /> Price- least expensive</label><br />
            <label><input type="checkbox" v-model="sheet.normalization.advertisement_media" :disabled="!editMode" /> Advertisement/ sponsorship/ media presentation</label><br />
            <div class="ml-4">
              <label><input type="checkbox" v-model="sheet.normalization.advertisement_promoting_liquors" :disabled="!editMode" /> Advertisement promoting liquors/cigarettes/clubs/red houses</label><br />
              <label><input type="checkbox" v-model="sheet.normalization.television_shows" :disabled="!editMode" /> Television shows</label><br />
              <label><input type="checkbox" v-model="sheet.normalization.movies" :disabled="!editMode" /> Movies</label><br />
              <label><input type="checkbox" v-model="sheet.normalization.printed_materials" :disabled="!editMode" /> printed materials</label><br />
            </div>
          </div>
          <div>
            <label><input type="checkbox" v-model="sheet.normalization.community_acceptance" :disabled="!editMode" /> Community acceptance</label><br />
            <div class="ml-4">
              <label><input type="checkbox" v-model="sheet.normalization.source_of_income" :disabled="!editMode" /> Source of income</label><br />
              <label><input type="checkbox" v-model="sheet.normalization.involve_in_trade" :disabled="!editMode" /> involve in actual trade/ production</label><br />
            </div>
            <label><input type="checkbox" v-model="sheet.normalization.role_of_culture" :disabled="!editMode" /> Role of culture (culturally accepted)</label><br />
            <div class="ml-4">
              <label><input type="checkbox" v-model="sheet.normalization.smoking" :disabled="!editMode" /> Smoking</label><br />
              <label><input type="checkbox" v-model="sheet.normalization.abuse" :disabled="!editMode" /> Abuse</label><br />
              <label><input type="checkbox" v-model="sheet.normalization.illicit_relationship" :disabled="!editMode" /> Illicit relationship</label><br />
              <label><input type="checkbox" v-model="sheet.normalization.incest_relationship" :disabled="!editMode" /> Incest relationship</label><br />
              <label><input type="checkbox" v-model="sheet.normalization.begging" :disabled="!editMode" /> Begging</label><br />
              <label><input type="checkbox" v-model="sheet.normalization.rugby_sniffing" :disabled="!editMode" /> Rugby sniffing</label><br />
            </div>
          </div>
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">F. Feelings / Behaviour towards the incident:</h2>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.stow_away" :disabled="!editMode" /> stow away</label><br />
            <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.irritable" :disabled="!editMode" /> irritable</label><br />
            <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.delinquent_behaviour" :disabled="!editMode" /> Delinquent behaviour</label><br />
            <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.stealing" :disabled="!editMode" /> stealing</label><br />
            <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.begging" :disabled="!editMode" /> begging</label><br />
            <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.others" :disabled="!editMode" /> others (pls. specify)</label><br />
          </div>
          <div>
            <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.withdrawal" :disabled="!editMode" /> withdrawal</label><br />
            <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.unresponsive_passive" :disabled="!editMode" /> unresponsive/ passive</label><br />
            <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.indulge_in_illegal_substance" :disabled="!editMode" /> indulge in illegal substance</label><br />
            <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.snatching" :disabled="!editMode" /> snatching</label><br />
            <label><input type="checkbox" v-model="sheet.behaviour_towards_incident.staying_in_street" :disabled="!editMode" /> staying in the street</label><br />
          </div>
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">G. Attachments:</h2>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label><input type="checkbox" v-model="sheet.attachments.mother" :disabled="!editMode" /> Mother</label><br />
            <label><input type="checkbox" v-model="sheet.attachments.grandmother" :disabled="!editMode" /> Grandmother</label><br />
            <label><input type="checkbox" v-model="sheet.attachments.aunt" :disabled="!editMode" /> Aunt</label><br />
            <label><input type="checkbox" v-model="sheet.attachments.neighbour" :disabled="!editMode" /> Neighbour</label><br />
            <label><input type="checkbox" v-model="sheet.attachments.cousin" :disabled="!editMode" /> Cousin</label><br />
          </div>
          <div>
            <label><input type="checkbox" v-model="sheet.attachments.father" :disabled="!editMode" /> father</label><br />
            <label><input type="checkbox" v-model="sheet.attachments.grandfather" :disabled="!editMode" /> grand father</label><br />
            <label><input type="checkbox" v-model="sheet.attachments.uncle" :disabled="!editMode" /> uncle</label><br />
            <label><input type="checkbox" v-model="sheet.attachments.peer" :disabled="!editMode" /> peer</label><br />
            <label><input type="checkbox" v-model="sheet.attachments.schoolmate" :disabled="!editMode" /> schoolmate</label><br />
            <label><input type="checkbox" v-model="sheet.attachments.classmate" :disabled="!editMode" /> classmate</label><br />
          </div>
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">H. Skills:</h2>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label><input type="checkbox" v-model="sheet.skills.problem_solving" :disabled="!editMode" /> Problem solving</label><br />
            <label><input type="checkbox" v-model="sheet.skills.interpersonal_relationship" :disabled="!editMode" /> Interpersonal relationship</label><br />
            <label><input type="checkbox" v-model="sheet.skills.communication_skills" :disabled="!editMode" /> Communication skills</label><br />
            <label><input type="checkbox" v-model="sheet.skills.vocational_skills" :disabled="!editMode" /> Vocational skills</label><br />
            <label><input type="checkbox" v-model="sheet.skills.critical_thinking" :disabled="!editMode" /> Critical thinking</label><br />
            <label><input type="checkbox" v-model="sheet.skills.others" :disabled="!editMode" /> Others</label><br />
          </div>
          <div>
            <label><input type="checkbox" v-model="sheet.skills.coping_skills" :disabled="!editMode" /> coping skills</label><br />
            <label><input type="checkbox" v-model="sheet.skills.survival_skills" :disabled="!editMode" /> survival skills</label><br />
            <label><input type="checkbox" v-model="sheet.skills.decision_making_skills" :disabled="!editMode" /> decision making skills</label><br />
            <label><input type="checkbox" v-model="sheet.skills.comprehension" :disabled="!editMode" /> comprehension</label><br />
            <label><input type="checkbox" v-model="sheet.skills.self_awareness" :disabled="!editMode" /> self-awareness</label><br />
          </div>
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">Resources:</h2>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label><input type="checkbox" v-model="sheet.resources.internal" :disabled="!editMode" /> Internal resources</label><br />
            <div class="ml-4">
              <label><input type="checkbox" v-model="sheet.resources.intelligence" :disabled="!editMode" /> Intelligence</label><br />
              <label><input type="checkbox" v-model="sheet.resources.spirituality" :disabled="!editMode" /> Spirituality</label><br />
              <label><input type="checkbox" v-model="sheet.resources.resourceful" :disabled="!editMode" /> Resourceful</label><br />
              <label><input type="checkbox" v-model="sheet.resources.obedient" :disabled="!editMode" /> Obedient</label><br />
              <label><input type="checkbox" v-model="sheet.resources.others" :disabled="!editMode" /> others</label><br />
            </div>
          </div>
          <div>
            <label><input type="checkbox" v-model="sheet.resources.external" :disabled="!editMode" /> External Resources</label><br />
            <div class="ml-4">
              <label><input type="checkbox" v-model="sheet.resources.family" :disabled="!editMode" /> Family</label><br />
              <label><input type="checkbox" v-model="sheet.resources.peers" :disabled="!editMode" /> Peers</label><br />
              <label><input type="checkbox" v-model="sheet.resources.health_services" :disabled="!editMode" /> Health services</label><br />
              <label><input type="checkbox" v-model="sheet.resources.recreational_services" :disabled="!editMode" /> Recreational services</label><br />
              <label><input type="checkbox" v-model="sheet.resources.ngos" :disabled="!editMode" /> NGOs existing in the community</label><br />
              <label><input type="checkbox" v-model="sheet.resources.civic_organization" :disabled="!editMode" /> Civic Organization</label><br />
              <label><input type="checkbox" v-model="sheet.resources.others" :disabled="!editMode" /> others (pls. specify)</label><br />
            </div>
          </div>
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">IV. Activities or source of income in the street:</h2>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label><input type="checkbox" v-model="sheet.source_of_income_in_street.vending" :disabled="!editMode" /> vending</label><br />
            <label><input type="checkbox" v-model="sheet.source_of_income_in_street.car_wash_boy" :disabled="!editMode" /> Car wash boy</label><br />
            <label><input type="checkbox" v-model="sheet.source_of_income_in_street.rugby_user" :disabled="!editMode" /> Rugby user</label><br />
          </div>
          <div>
            <label><input type="checkbox" v-model="sheet.source_of_income_in_street.porter" :disabled="!editMode" /> porter</label><br />
            <label><input type="checkbox" v-model="sheet.source_of_income_in_street.barker" :disabled="!editMode" /> barker</label><br />
          </div>
        </div>
        <div class="space-y-2">
          <label>Earnings/ income</label>
          <input type="text" v-model="sheet.earnings_income" class="border w-full px-2 py-1" :readonly="!editMode" />
          <label>Hours of stay in the street</label>
          <input type="text" v-model="sheet.hrs_stay_in_street" class="border w-full px-2 py-1" :readonly="!editMode" />
          <label>Length of stay in the street</label>
          <input type="text" v-model="sheet.length_stay_in_street" class="border w-full px-2 py-1" :readonly="!editMode" />
          <label>Common Substance used</label>
          <input type="text" v-model="sheet.common_substance_used" class="border w-full px-2 py-1" :readonly="!editMode" />
        </div>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">V. INITIAL ASSESSMENT:</h2>
        <textarea v-model="sheet.initial_assessment" class="border w-full px-2 py-1" rows="4" :readonly="!editMode"></textarea>
      </div>

      <div class="mb-8">
        <h2 class="text-lg font-semibold">VI. RECOMMENDATIONS:</h2>
        <textarea v-model="sheet.recommendations" class="border w-full px-2 py-1" rows="4" :readonly="!editMode"></textarea>
      </div>

      <div class="text-right mb-8">
        <div>
          <label>Prepared by:</label>
          <input type="text" v-model="sheet.prepared_by" class="border w-1/4 px-2 py-1" :readonly="!editMode" />
        </div>
        <div>
          <label>Reviewed by:</label>
          <input type="text" v-model="sheet.reviewed_by" class="border w-1/4 px-2 py-1" :readonly="!editMode" />
        </div>
        <div>
          <p>ANGELIC B. PAÑA, RSW, MSSW</p>
          <p>Center Head/SWO IV</p>
        </div>
      </div>


    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { ref, reactive, onMounted } from 'vue';
import { useRoute } from 'vue-router';

export default {
  name: 'GeneralIntakeSheet',
  setup() {
    const route = useRoute();
    const editMode = ref(false);
    const message = ref('');
    const messageType = ref('');
    const clientId = ref(null);
    const sheet = reactive({
      id: null,
      name: '',
      age: '',
      sex: '',
      address: '',
      date_of_birth: '',
      place_of_birth: '',
      religion: '',
      occupation: '',
      highest_educ_att: '',
      school_name: '',
      class_adviser: '',
      date: '',  // New date field
      problem_presented: '',
      brief_physical_description: '',
      major_life_event: {
        death_of_parents: false,
        separation_from_family: false,
        natural_disaster: false,
        apprehension: false,
        physical_abuse: false,
        suicidal_tendencies: false,
        mistaken_identity: false,
        abandonment: false,
        serious_accident: false,
        demolition: false,
        sexual_abuse: false,
        verbal_abuse: false,
        disability: false,
        others: false,
      },
      enduring_life_strain: {
        poverty: false,
        physical_illness: false,
        lack_recreational_facilities: false,
        exclusion_from_peers: false,
        other: false,
        constant_need_to_earn: false,
        lack_education_opportunity: false,
        exclusion_from_school: false,
        disability: false,
      },
      life_transition: {
        moving_neighbour: false,
        changing_peer_group: false,
        moving_due_to_demolition: false,
        moving_due_to_disaster: false,
        kinship_foster_placement: false,
        beginning_romantic_relationship: false,
        beginning_parents_romantic_relationship: false,
        others: false,
      },
      development_changes: {
        early_childhood: false,
        school_age: false,
        adolescence: false,
      },
      normalization: {
        legality_law_enforcement: false,
        commercial_sex: false,
        substance_illegal_drugs: false,
        pornography_materials: false,
        red_houses: false,
        price_least_expensive: false,
        advertisement_media: false,
        advertisement_promoting_liquors: false,
        television_shows: false,
        movies: false,
        printed_materials: false,
        community_acceptance: false,
        source_of_income: false,
        involve_in_trade: false,
        role_of_culture: false,
        smoking: false,
        abuse: false,
        illicit_relationship: false,
        incest_relationship: false,
        begging: false,
        rugby_sniffing: false,
      },
      behaviour_towards_incident: {
        stow_away: false,
        irritable: false,
        delinquent_behaviour: false,
        stealing: false,
        begging: false,
        others: false,
        withdrawal: false,
        unresponsive_passive: false,
        indulge_in_illegal_substance: false,
        snatching: false,
        staying_in_street: false,
      },
      attachments: {
        mother: false,
        grandmother: false,
        aunt: false,
        neighbour: false,
        cousin: false,
        father: false,
        grandfather: false,
        uncle: false,
        peer: false,
        schoolmate: false,
        classmate: false,
      },
      skills: {
        problem_solving: false,
        interpersonal_relationship: false,
        communication_skills: false,
        vocational_skills: false,
        critical_thinking: false,
        others: false,
        coping_skills: false,
        survival_skills: false,
        decision_making_skills: false,
        comprehension: false,
        self_awareness: false,
      },
      resources: {
        internal: false,
        intelligence: false,
        spirituality: false,
        resourceful: false,
        obedient: false,
        others: false,
        external: false,
        family: false,
        peers: false,
        health_services: false,
        recreational_services: false,
        ngos: false,
        civic_organization: false,
        others: false,
      },
      source_of_income_in_street: {
        vending: false,
        car_wash_boy: false,
        rugby_user: false,
        porter: false,
        barker: false,
      },
      earnings_income: '',
      hrs_stay_in_street: '',
      length_stay_in_street: '',
      common_substance_used: '',
      initial_assessment: '',
      recommendations: '',
      vices: '',
      school_activities_achievement: '',
      occupation_of_mother: '',
      occupation_of_father: '',
      siblings: '',
      responsible_for_households_chores: '',
      water_source: '',
      house_made_of: '',
      prepared_by: '',  // New field
      reviewed_by: '',  // New field
    });

    const fetchClientData = async (id) => {
      try {
        const response = await axios.get(`/api/clients/${id}`);
        const client = response.data;

        sheet.name = `${client.first_name} ${client.last_name}`;
        sheet.age = calculateAge(client.date_of_birth);
        sheet.sex = client.sex;
        sheet.address = `${client.province}, ${client.city}, ${client.barangay}, ${client.street}`;
        sheet.date_of_birth = client.date_of_birth;
        sheet.place_of_birth = client.place_of_birth;
        sheet.religion = client.religion;

        const sheetResponse = await axios.get(`/api/general-intake-sheets/${id}`);
        const clientSheet = sheetResponse.data;

        Object.assign(sheet, clientSheet);
      } catch (error) {
        console.error('Error fetching client data:', error);
      }
    };

    const calculateAge = (birthDate) => {
      const today = new Date();
      const birthDateObj = new Date(birthDate);
      let age = today.getFullYear() - birthDateObj.getFullYear();
      const monthDiff = today.getMonth() - birthDateObj.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDateObj.getDate())) {
        age--;
      }
      return age;
    };

    onMounted(() => {
      clientId.value = route.params.id;
      fetchClientData(clientId.value);
    });

    const toggleEdit = () => {
      if (editMode.value) {
        saveData();
      }
      editMode.value = !editMode.value;
    };

    const saveData = () => {
  if (!clientId.value) {
    message.value = 'No client selected.';
    messageType.value = 'error';
    clearNotification();
    return;
  }

  const payload = {
    client_id: clientId.value,
    ...sheet,
  };

  const method = sheet.id ? 'put' : 'post';
  const url = `/api/general-intake-sheets${sheet.id ? '/' + sheet.id : ''}`;

  axios[method](url, payload)
    .then(response => {
      message.value = 'Data saved successfully.';
      messageType.value = 'success';
      clearNotification();
      if (!sheet.id) sheet.id = response.data.id;
    })
    .catch(error => {
      message.value = error.response.data.message || 'Error saving data.';
      messageType.value = 'error';
      console.error('Error saving data:', error);
      clearNotification();
    });
};

const clearNotification = () => {
  setTimeout(() => {
    message.value = '';
    messageType.value = '';
  }, 3000);
};


    return {
      editMode,
      message,
      messageType,
      sheet,
      toggleEdit,
      saveData,
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
.bg-green-500:hover {
  background-color: #38a169;
}
</style>
