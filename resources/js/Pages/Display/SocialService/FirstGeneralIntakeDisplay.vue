<template>
    <div class="p-10 bg-gray-100">
      <div class="bg-white p-8 rounded shadow-md">
        <div class="text-center mb-8">
          <img src="path/to/dswd-logo.png" alt="DSWD Logo" class="mx-auto mb-4" />
          <h1 class="text-xl font-bold">GENERAL INTAKE SHEET</h1>
          <p>Date: ______________</p>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">I. Identifying Information:</h2>
          <div class="space-y-2">
            <div>
              <label>Name of client</label>
              <input type="text" class="border w-full px-2 py-1" />
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label>Age</label>
                <input type="text" class="border w-full px-2 py-1" />
              </div>
              <div>
                <label>Sex</label>
                <input type="text" class="border w-full px-2 py-1" />
              </div>
            </div>
            <div>
              <label>Address</label>
              <input type="text" class="border w-full px-2 py-1" />
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label>Date of Birth</label>
                <input type="text" class="border w-full px-2 py-1" />
              </div>
              <div>
                <label>Place of birth</label>
                <input type="text" class="border w-full px-2 py-1" />
              </div>
            </div>
            <div>
              <label>Religion</label>
              <input type="text" class="border w-full px-2 py-1" />
            </div>
            <div>
              <label>Occupation</label>
              <input type="text" class="border w-full px-2 py-1" />
            </div>
            <div>
              <label>Highest Educ'l Att't</label>
              <input type="text" class="border w-full px-2 py-1" />
            </div>
            <div>
              <label>Name of School</label>
              <input type="text" class="border w-full px-2 py-1" />
            </div>
            <div>
              <label>Class Adviser</label>
              <input type="text" class="border w-full px-2 py-1" />
            </div>
          </div>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">II. Problem Presented:</h2>
          <textarea class="border w-full px-2 py-1" rows="4"></textarea>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">III. Brief Physical description of the minor:</h2>
          <textarea class="border w-full px-2 py-1" rows="4"></textarea>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">A. Major life Events:</h2>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label><input type="checkbox" /> Death of Parents</label><br />
              <label><input type="checkbox" /> Separation from the family</label><br />
              <label><input type="checkbox" /> Victim of natural / manmade disaster</label><br />
              <label><input type="checkbox" /> Victim of apprehension</label><br />
              <label><input type="checkbox" /> Victim of physical abuse</label><br />
              <label><input type="checkbox" /> with suicidal tendencies</label><br />
              <label><input type="checkbox" /> mistaken identity</label><br />
            </div>
            <div>
              <label><input type="checkbox" /> Abandonment</label><br />
              <label><input type="checkbox" /> Serious Accident</label><br />
              <label><input type="checkbox" /> Victim of demolition</label><br />
              <label><input type="checkbox" /> Victim of sexual abuse</label><br />
              <label><input type="checkbox" /> Victim of verbal abuse</label><br />
              <label><input type="checkbox" /> acquired disability</label><br />
              <label><input type="checkbox" /> others: (pls. Specify)</label><br />
            </div>
          </div>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">B. Enduring Life Strain:</h2>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label><input type="checkbox" /> Poverty</label><br />
              <label><input type="checkbox" /> Physical illness</label><br />
              <label><input type="checkbox" /> Lack of recreational facilities</label><br />
              <label><input type="checkbox" /> Exclusion from peers</label><br />
              <label><input type="checkbox" /> other (pls. specify)</label><br />
            </div>
            <div>
              <label><input type="checkbox" /> constant need to earn for the family</label><br />
              <label><input type="checkbox" /> lack of educational/ opportunity</label><br />
              <label><input type="checkbox" /> exclusion from school</label><br />
              <label><input type="checkbox" /> with disability</label><br />
            </div>
          </div>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">C. Life Transition:</h2>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label><input type="checkbox" /> moving from one neighbour to another</label><br />
              <label><input type="checkbox" /> Changing peer group</label><br />
              <label><input type="checkbox" /> moving of another place of residence due to demolition</label><br />
              <label><input type="checkbox" /> moving of another place of residence due to disaster</label><br />
              <label><input type="checkbox" /> moving from biological family to a kinship/ foster placement</label><br />
              <label><input type="checkbox" /> beginning romantic relationship</label><br />
              <label><input type="checkbox" /> beginning romantic relationship of parents</label><br />
              <label><input type="checkbox" /> others (pls. specify)</label><br />
            </div>
          </div>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">D. Development Changes:</h2>
          <div class="space-y-2">
            <label><input type="checkbox" /> Early childhood 1-6 yrs. Old</label><br />
            <label><input type="checkbox" /> School age 7-12 yrs. Old</label><br />
            <label><input type="checkbox" /> Adolescence 13-18 yrs. old</label><br />
          </div>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">E. Normalization:</h2>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label><input type="checkbox" /> legality/law enforcement (weak)</label><br />
              <label><input type="checkbox" /> Availability of:</label><br />
              <div class="ml-4">
                <label><input type="checkbox" /> Commercial sex</label><br />
                <label><input type="checkbox" /> substance/illegal drugs</label><br />
                <label><input type="checkbox" /> Pornography materials to include video tapes</label><br />
                <label><input type="checkbox" /> Red houses</label><br />
              </div>
              <label><input type="checkbox" /> Price- least expensive</label><br />
              <label><input type="checkbox" /> Advertisement/ sponsorship/ media presentation</label><br />
              <div class="ml-4">
                <label><input type="checkbox" /> Advertisement promoting liquors/cigarettes/clubs/red houses</label><br />
                <label><input type="checkbox" /> Television shows</label><br />
                <label><input type="checkbox" /> Movies</label><br />
                <label><input type="checkbox" /> printed materials</label><br />
              </div>
            </div>
            <div>
              <label><input type="checkbox" /> Community acceptance</label><br />
              <div class="ml-4">
                <label><input type="checkbox" /> Source of income</label><br />
                <label><input type="checkbox" /> involve in actual trade/ production</label><br />
              </div>
              <label><input type="checkbox" /> Role of culture (culturally accepted)</label><br />
              <div class="ml-4">
                <label><input type="checkbox" /> Smoking</label><br />
                <label><input type="checkbox" /> Abuse</label><br />
                <label><input type="checkbox" /> Illicit relationship</label><br />
                <label><input type="checkbox" /> Incest relationship</label><br />
                <label><input type="checkbox" /> Begging</label><br />
                <label><input type="checkbox" /> Rugby sniffing</label><br />
              </div>
            </div>
          </div>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">F. Feelings / Behaviour towards the incident:</h2>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label><input type="checkbox" /> stow away</label><br />
              <label><input type="checkbox" /> irritable</label><br />
              <label><input type="checkbox" /> Delinquent behaviour</label><br />
              <label><input type="checkbox" /> stealing</label><br />
              <label><input type="checkbox" /> begging</label><br />
              <label><input type="checkbox" /> others (pls. specify)</label><br />
            </div>
            <div>
              <label><input type="checkbox" /> withdrawal</label><br />
              <label><input type="checkbox" /> unresponsive/ passive</label><br />
              <label><input type="checkbox" /> indulge in illegal substance</label><br />
              <label><input type="checkbox" /> snatching</label><br />
              <label><input type="checkbox" /> staying in the street</label><br />
            </div>
          </div>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">G. Attachments:</h2>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label><input type="checkbox" /> Mother</label><br />
              <label><input type="checkbox" /> Grandmother</label><br />
              <label><input type="checkbox" /> Aunt</label><br />
              <label><input type="checkbox" /> Neighbour</label><br />
              <label><input type="checkbox" /> Cousin</label><br />
            </div>
            <div>
              <label><input type="checkbox" /> father</label><br />
              <label><input type="checkbox" /> grand father</label><br />
              <label><input type="checkbox" /> uncle</label><br />
              <label><input type="checkbox" /> peer</label><br />
              <label><input type="checkbox" /> schoolmate</label><br />
              <label><input type="checkbox" /> classmate</label><br />
            </div>
          </div>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">H. Skills:</h2>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label><input type="checkbox" /> Problem solving</label><br />
              <label><input type="checkbox" /> Interpersonal relationship</label><br />
              <label><input type="checkbox" /> Communication skills</label><br />
              <label><input type="checkbox" /> Vocational skills</label><br />
              <label><input type="checkbox" /> Critical thinking</label><br />
              <label><input type="checkbox" /> Others</label><br />
            </div>
            <div>
              <label><input type="checkbox" /> coping skills</label><br />
              <label><input type="checkbox" /> survival skills</label><br />
              <label><input type="checkbox" /> decision making skills</label><br />
              <label><input type="checkbox" /> comprehension</label><br />
              <label><input type="checkbox" /> self-awareness</label><br />
            </div>
          </div>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">Resources:</h2>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label><input type="checkbox" /> Internal resources</label><br />
              <div class="ml-4">
                <label><input type="checkbox" /> Intelligence</label><br />
                <label><input type="checkbox" /> Spirituality</label><br />
                <label><input type="checkbox" /> Resourceful</label><br />
                <label><input type="checkbox" /> Obedient</label><br />
                <label><input type="checkbox" /> others</label><br />
              </div>
            </div>
            <div>
              <label><input type="checkbox" /> External Resources</label><br />
              <div class="ml-4">
                <label><input type="checkbox" /> Family</label><br />
                <label><input type="checkbox" /> Peers</label><br />
                <label><input type="checkbox" /> Health services</label><br />
                <label><input type="checkbox" /> Recreational services</label><br />
                <label><input type="checkbox" /> NGOs existing in the community</label><br />
                <label><input type="checkbox" /> Civic Organization</label><br />
                <label><input type="checkbox" /> others (pls. specify)</label><br />
              </div>
            </div>
          </div>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">IV. Activities or source of income in the street:</h2>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label><input type="checkbox" /> vending</label><br />
              <label><input type="checkbox" /> Car wash boy</label><br />
              <label><input type="checkbox" /> Rugby user</label><br />
            </div>
            <div>
              <label><input type="checkbox" /> porter</label><br />
              <label><input type="checkbox" /> barker</label><br />
            </div>
          </div>
          <div class="space-y-2">
            <label>Earnings/ income</label>
            <input type="text" class="border w-full px-2 py-1" />
            <label>Hours of stay in the street</label>
            <input type="text" class="border w-full px-2 py-1" />
            <label>Length of stay in the street</label>
            <input type="text" class="border w-full px-2 py-1" />
            <label>Common Substance used</label>
            <input type="text" class="border w-full px-2 py-1" />
          </div>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">V. INITIAL ASSESSMENT:</h2>
          <textarea class="border w-full px-2 py-1" rows="4"></textarea>
        </div>
  
        <div class="mb-8">
          <h2 class="text-lg font-semibold">VI. RECOMMENDATIONS:</h2>
          <textarea class="border w-full px-2 py-1" rows="4"></textarea>
        </div>
  
        <div class="text-right">
          <p>Prepared by: _____________________</p>
          <p>Reviewed by: _____________________</p>
          <p>ANGELIC B. PAÑA, RSW, MSSW</p>
          <p>Center Head/SWO IV</p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'GeneralIntakeSheet',
  };
  </script>
  
  <style scoped>
  /* Add any additional styling here */
  </style>
  