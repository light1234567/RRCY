<template>
   <!-- Tabs for Actions -->
      <div class="flex absolute p-4 space-x-4 ">
        <button @click="cancelEdit" class="flex space-x-2 px-3 py-1 bg-customBlue text-white rounded-md text-xs">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          <span>Back</span>
        </button>
      </div>

      <div class="flex justify-end bg-transparent border border-gray-300 p-4 rounded-md space-x-4 mt-4">
        <div class="w-full text-black ml-40 text-center text-md" v-if="!editMode">
          VIEW MODE
        </div>

        <div v-if="editMode" class="w-full text-black ml-40 text-center text-md">
          EDIT MODE
        </div>

        <button @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-blue-500 text-white rounded-md text-xs">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.3 2.7a1 1 0 011.4 0l1.3 1.3a1 1 0 010 1.4l-9.4 9.4a1 1 0 01-.6.3l-2.8.6a1 1 0 01-1.2-1.2l.6-2.8a1 1 0 01.3-.6l9.4-9.4z" />
          </svg>
          <span>Edit</span>
        </button>

        <button @click="downloadAction" class="flex items-center space-x-2 px-3 py-1 bg-customBlue text-white rounded-md text-xs">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7m7 7V3" />
          </svg>
          <span>Download</span>
        </button>

        <button v-if="editMode" @click="toggleEdit" class="flex items-center space-x-2 px-3 py-1 bg-green-500 text-white rounded-md text-xs">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          <span>Save</span>
        </button>
      </div>


      <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50">
      <div class="fixed inset-0 bg-black opacity-50"></div>
      <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
        <div class="bg-white p-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Save changes?</h3>
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



      <div class="p-8 bg-white shadow-xl rounded-lg max-w-4xl mx-auto my-8">
        <div class="bg-white p-8 rounded shadow-md">
          <div class="text-center mb-8">
            <div class="relative flex justify-between items-center mb-2">
          <img src="/images/headerlogo2.png" alt="Logo" class="h-24 w-48 relative z-10">
          <p class="text-xs">DSPDP-GF-010A | REV.00 | 12 SEP 2023</p>
        </div>
        <h1 class="text-xl font-bold">GENERAL INTAKE SHEET</h1>
        <div class="flex justify-end">
          <p>Date: <input type="date" v-model="sheet.date" class="flex-grow border-b-2 border-black border-t-0 mr-4 border-l-0 border-r-0 rounded-none shadow-sm  w-1/8 px-2 py-1" :readonly="!editMode" /></p>
        </div>
      </div>
     


      <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
        {{ message }}
      </div>
      <div class="mb-8">
  <h2 class="text-lg font-semibold">I. Identifying Information:</h2>
  <div class="space-y-2">
    <div class="flex items-center mb-4">
    
  <label class="block text-base font-semibold text-gray-700 mr-4 whitespace-nowrap">Name of client:</label>
  <input type="text" v-model="sheet.name" class="flex-grow border-b-2 border-black border-t-0 mr-4 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
</div>
   
    <div class="grid grid-cols-2 gap-4">
      <div class="flex items-center mb-4">
        <div class="flex-grow flex items-center mr-4">
          <label class="block text-base font-semibold text-gray-700 mr-4">Age:</label>
          <input type="text" v-model="sheet.age" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
        </div>
      </div>
      <div class="flex items-center mb-4">
        <div class="flex-grow flex items-center mr-4">
          <label class="block text-base font-semibold text-gray-700 mr-4">Sex:</label>
          <input type="text" v-model="sheet.sex" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
        </div>
      </div>
    </div>
    <div class="flex items-center mb-4">
      <div class="flex-grow flex items-center mr-4">
        <label class="block text-base font-semibold text-gray-700 mr-4">Address:</label>
        <input type="text" v-model="sheet.address" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
      </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
      <div class="flex items-center mb-4">
        <div class="flex-grow flex items-center mr-4">
          <label class="block text-base font-semibold text-gray-700 mr-4">Date of Birth:</label>
          <input type="date" v-model="sheet.date_of_birth" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
        </div>
      </div>
      <div class="flex items-center mb-4">
        <div class="flex-grow flex items-center mr-4">
          <label class="block text-base font-semibold text-gray-700 mr-4">Place of birth:</label>
          <input type="text" v-model="sheet.place_of_birth" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
        </div>
      </div>
    </div>
    <div class="flex items-center mb-4">
      <div class="flex-grow flex items-center mr-4">
        <label class="block text-base font-semibold text-gray-700 mr-4">Religion:</label>
        <input type="text" v-model="sheet.religion" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" readonly />
      </div>
    </div>
    <div class="flex items-center mb-4">
      <div class="flex-grow flex items-center mr-4">
        <label class="block text-base font-semibold text-gray-700 mr-4">Occupation:</label>
        <input type="text" v-model="sheet.occupation" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
      </div>
    </div>
    <div class="flex items-center mb-4">
  <label class="block text-base font-semibold text-gray-700 mr-4 whitespace-nowrap">Highest Educ'l Att't:</label>
  <input type="text" v-model="sheet.highest_educ_att" class="flex-grow border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
</div>
  
    <div class="flex items-center mb-4">
      <div class="flex-grow flex items-center mr-4">
        <label class="block text-base font-semibold text-gray-700 mr-4">Name of School:</label>
        <input type="text" v-model="sheet.school_name" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
      </div>
    </div>
    <div class="flex items-center mb-4">
      <div class="flex-grow flex items-center mr-4">
        <label class="block text-base font-semibold text-gray-700 mr-4">Class Adviser:</label>
        <input type="text" v-model="sheet.class_adviser" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
      </div>
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
          <div class="flex items-center mb-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Earnings/ income:</label>
            <input type="text" v-model="sheet.earnings_income" class="flex-grow mt-1 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
          </div>
          <div class="flex items-center mb-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Hours of stay in the street:</label>
            <input type="text" v-model="sheet.hrs_stay_in_street" class="flex-grow mt-1 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
          </div>
          <div class="flex items-center mb-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Length of stay in the street:</label>
            <input type="text" v-model="sheet.length_stay_in_street" class="flex-grow mt-1 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
          </div>
          <div class="flex items-center mb-4">
            <label class="block text-base font-semibold text-gray-700 mr-4">Common Substance used:</label>
            <input type="text" v-model="sheet.common_substance_used" class="flex-grow mt-1 border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
          </div>
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

      <div class="flex justify-between mb-8">
        <div class="flex flex-col items-start">
          <label class="block text-base font-semibold text-gray-700 mb-1">Prepared by:</label>
          <input type="text" v-model="sheet.prepared_by" class="mt-1 w-full border-b-2 border-black border-t-0 border-l-0 border-r-0 rounded-none shadow-sm text-xs" :readonly="!editMode" />
          <p>SWO __/Case Manager</p>
        </div>
        <div class="flex flex-col items-end">
          <label class="block text-base font-semibold text-gray-700 mb-8">Reviewed by:</label>
          <div class="text-right">
            <p>ANGELIC B. PAÑA, RSW, MSSW</p>
            <p>Center Head/SWO IV</p>
          </div>
        </div>
      </div>
      <div class="border-gray-300 ml-6 mt-24 text-center text-xs" style="font-family: 'Times New Roman', Times, serif;">
      <div class="flex justify-between items-center">
        <div class="flex flex-col">
          <p class="ml-24 -mb-4 font-bold">PAGE 1 of 1</p>
          <p class="border-t mt-4" style="border-top: 2px solid black;">DSWD Field Office XI, Regional Rehabilitation Center for Youth (RRCY) Pk. 7 Bago-Oshiro, Tugbok Dist., Davao City</p>
          <p class="ml-32">Email: <span style="color: blue; text-decoration: underline;">rrxy.fo11@dswd.gov.ph</span> Tel. No.: 293-0306</p>
        </div>
        <div class="ml-4">
          <img src="images/footerimg.png" alt="Image description" class="h-12 w-24 object-cover rounded-md">
        </div>
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
    const isModalOpen = ref(false);
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
        openModal();
      } else {
        editMode.value = !editMode.value;
      }
    };
    const openModal = () => {
      isModalOpen.value = true;
    };

    const closeModal = () => {
      isModalOpen.value = false;
    };
    const confirmSave = () => {
      saveData();
      closeModal();
      editMode.value = false;
    };
    const cancelEdit = () => {
      editMode.value = false;
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
      isModalOpen,
      openModal,
      closeModal,
      confirmSave,
      cancelEdit,
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
