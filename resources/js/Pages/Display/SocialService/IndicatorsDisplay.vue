<template>
  <div class="bg-gray-100 p-10">
    <!-- Page 1 -->
    <div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg mb-10">
      <div class="flex items-center justify-between mb-4">
        <img src="path_to_logo.png" alt="DSWD Logo" class="h-16">
        <div class="text-right">
          <p class="text-xs">DSPTD-QF-01-A | REV 01 | 12 SEP 2023</p>
        </div>
      </div>
      <h1 class="text-2xl font-bold text-center mb-4">INDICATORS OF SOCIAL FUNCTIONING</h1>

      <div class="flex justify-end mb-4">
        <button @click="toggleEdit" class="px-4 py-2 bg-blue-500 text-white rounded-md mt-4">
          {{ editMode ? 'Save' : 'Edit' }}
        </button>
      </div>

      <div v-if="errorMessage" class="p-4 mt-4 text-white rounded-md bg-red-500">
        {{ errorMessage }}
      </div>

      <div v-if="message" :class="`p-4 mt-4 text-white rounded-md ${messageType === 'success' ? 'bg-green-500' : 'bg-red-500'}`">
        {{ message }}
      </div>
      
      <div class="mb-4">
        <label class="block text-gray-700">Client Name:</label>
        <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="clientName" readonly />
      </div>

      <div class="mb-4">
        <label class="block text-gray-700">Date Admission:</label>
        <input type="date" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.dateAdmission" readonly />
      </div>

      <div class="mb-4">
        <label class="block text-gray-700">Date Administered:</label>
        <input type="date" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.date_administered" :readonly="!editMode" />
      </div>

            <!-- The rest of your table goes here -->
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200">
                            AREAS
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Severely-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Moderately-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Normal Functioning
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Raw Score
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Score per Area
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Physical rows here -->

                    <tr>
              <td class="py-2 px-4 border-b border-gray-200" rowspan="2">Physical</td>
              <td class="py-2 px-4 border-b border-gray-200">Has very poor hygiene and grooming</td>
              <td class="py-2 px-4 border-b border-gray-200">Practices adequate self-care habits but still needs monitoring and supervision to maintain such</td>
              <td class="py-2 px-4 border-b border-gray-200">Practices adequate self-care habits even without monitoring and supervision</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.physical_raw_score1" :readonly="!editMode" @input="validateRawScore('physical_raw_score1')">
              </td>
              <td class="py-2 px-4 border-b border-gray-200" rowspan="2">
                <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.physical_score_per_area1" readonly>
              </td>
            </tr> 
            <td class="py-2 px-4 border-b border-gray-200">Is completely dependent to others due to absence of appropriate skills to manage physical disability</td>
              <td class="py-2 px-4 border-b border-gray-200">With very limited skills to manage physical disability which causes him or her to unnecessarily require assistance from others at times</td>
              <td class="py-2 px-4 border-b border-gray-200">Has appropriate skills to function within capacity</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.physical_raw_score2" :readonly="!editMode" @input="validateRawScore('physical_raw_score2')">
              </td>

                    <!-- Emotional rows here -->
                    <tr>
              <td class="py-2 px-4 border-b border-gray-200" rowspan="6">Emotional</td>
              <td class="py-2 px-4 border-b border-gray-200">Is oftentimes sad / lonely which results to his or her lack of interest in anything despite encourage from others.</td>
              <td class="py-2 px-4 border-b border-gray-200">Experiences sadness / loneliness which he or she allows to interfere in the performance of daily tasks and dealings with others.</td>
              <td class="py-2 px-4 border-b border-gray-200">Copes well with sadness or loneliness as he or she does not let such emotion interfere both in daily tasks and social relationship.</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.emotional_raw_score1" :readonly="!editMode" @input="validateRawScore('emotional_raw_score1')">
              </td>
              <td class="py-2 px-4 border-b border-gray-200" rowspan="6">
                <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.emotional_score_per_area1" readonly>
              </td>
            </tr> 
            <td class="py-2 px-4 border-b border-gray-200">Feels hopeless most of the time which is manifested through the following:
* suicidal events
* absence of any interest in the center's activities
* self-isolation
* lack of desire to improve self / does not believe that his or her situation will improve at all
</td>
              <td class="py-2 px-4 border-b border-gray-200">Feels hopeless at times and allows such emotion to negatively affect performance of tasks and social relationship. However, he or she shows no suicidal tendency</td>
              <td class="py-2 px-4 border-b border-gray-200">Is generally optimistic despite difficult situations which enable him or her to perform tasks or roles</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.emotional_raw_score2" :readonly="!editMode" @input="validateRawScore('emotional_raw_score2')">
              </td>
              <tr>
              
              <td class="py-2 px-4 border-b border-gray-200">Oftentimes experiences extreme / severe fear because of traumatic event/s in life which results to social and functional impairment like withdrawal, fighting back, and unnecessary cautiousness</td>
              <td class="py-2 px-4 border-b border-gray-200">Sometimes experiences fear as a result of traumatic event. With constant encouragement; however, he or she tries not to allow such to affect dealings with others and performance of tasks</td>
              <td class="py-2 px-4 border-b border-gray-200">Copes well with traumatic events as evident by his or her social and functional adjustment even with very minimal requirement for support from others</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.emotional_raw_score3" :readonly="!editMode" @input="validateRawScore('emotional_raw_score3')">
              </td>
            </tr> 
            <tr>
              
              <td class="py-2 px-4 border-b border-gray-200">Harbors ill feelings which renders him or her unable to build good relationship with others and to focus on tasks at hand as indicated by any or all of the following:
* dwells most of the time on planning revenge
* not open to reconciliation or forgiveness
* aggressive
* relationship with others is superficial
* displaces anger to others
</td>
              <td class="py-2 px-4 border-b border-gray-200">Is trying to overcome ill feelings (e.g. hatred, resentment and anger) as may be evident by any or all of the following expressions: 
* that revenge may only worsen situation
* that reconciliation may be possible in the future
* that he or she may consider forgiving the individual /s who has / have done wrong to him or her
</td>
              <td class="py-2 px-4 border-b border-gray-200">Has decided to let go of ill-feelings as may be evident in any or all of the following:
* has forgiven others
* is ready to ask forgiveness for those whom he may have done wrong
* believes that there are people who are genuinely interested in his or her welfare
</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.emotional_raw_score4" :readonly="!editMode" @input="validateRawScore('emotional_raw_score4')">
              </td>
            </tr> 

            <tr>
              
              <td class="py-2 px-4 border-b border-gray-200">Is severely guilty for grave offense committed which make him or her feel unworthy and incapable of doing good</td>
              <td class="py-2 px-4 border-b border-gray-200">Feels guilty for grave offense committed which make him or her at times doubt capacity to be a good person</td>
              <td class="py-2 px-4 border-b border-gray-200">Because of feelings of guilt for an offense committed, he or she strives to change negative attitudes that cause damage to others</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.emotional_raw_score5" :readonly="!editMode" @input="validateRawScore('emotional_raw_score5')">
              </td>
            </tr> 

            <tr>
              
              <td class="py-2 px-4 border-b border-gray-200">Is severely guilty because of the incarceration of her abuser which, she is made to believe, resulted to the difficulties being faced by the family. Such emotion cripples her daily interaction with others</td>
              <td class="py-2 px-4 border-b border-gray-200">Sometimes think that she is to blame because of family disintegration due to the case she filed against her perpetrator</td>
              <td class="py-2 px-4 border-b border-gray-200">Believes that revealing the truth about the abuse she experienced and taking legal action are appropriate. Feels good about self for taking the right action against her perpetrator.</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.emotional_raw_score6" :readonly="!editMode" @input="validateRawScore('emotional_raw_score6')">
              </td>
            </tr> 

                </tbody>
            </table>

            <div class="text-center text-xs mt-10">
                <p>PAGE 1 of 4</p>
                <p>
                    DSWD Field Office XI, RRCY Purok 7, Bajao Gisho, Tugatok
                    District, Davao City, Philippines 8000
                </p>
                <p>
                    Website:
                    <a href="https://www.dswd.gov.ph" class="text-blue-500"
                        >www.dswd.gov.ph</a
                    >, Tel No.: (082) 227-1964 Email:
                    <a href="mailto:rcydavao@gmail.com" class="text-blue-500"
                        >rcydavao@gmail.com</a
                    >
                </p>
            </div>
        </div>

        <!-- Page 2 -->
        <div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg mb-10">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200">
                            AREAS
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Severely-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Moderately-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Normal Functioning
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Raw Score
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Score per Area
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Social / Behavioral rows here -->
                    <tr>
              <td class="py-2 px-4 border-b border-gray-200" rowspan="8">Social / Behavioral</td>
              <td class="py-2 px-4 border-b border-gray-200">Has no self-control as maybe evident in any or all of the following:
* frequent involvement in fights (physical and verbal)
* inappropriate sexual behavior (e.g. frequent masturbation even in the presence of others)
* saying offensive words without caution
* vices
</td>
              <td class="py-2 px-4 border-b border-gray-200">Exercises self-control when he or she believes that it will bring him or her some reward or will make him or her appear good to others</td>
              <td class="py-2 px-4 border-b border-gray-200">Exercises self-control in all cases as evident in the following:
* cautious in giving comments so that he or she may not hurt or offend others
* avoids involvement in fights
* avoids stealing
* avoids display of inappropriate sexual behavior
</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.social_raw_score1" :readonly="!editMode" @input="validateRawScore('social_raw_score1')">
              </td>
              <td class="py-2 px-4 border-b border-gray-200" rowspan="6">
                <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.social_score_per_area1" readonly>
              </td>
            </tr> 
            <td class="py-2 px-4 border-b border-gray-200">Lacks sense of responsibility as evident in refusing to perform tasks / roles and constantly complaining even if tasks given are:
* appropriate to age, intellectual ability, physical strength
* not against his or her principles and religious belief 
</td>
              <td class="py-2 px-4 border-b border-gray-200">Carries out responsibilities but requires supervision and close monitoring</td>
              <td class="py-2 px-4 border-b border-gray-200">Performs responsibilities to the best of his or her ability even without prodding. He or she may at times express complaints but does so only when task given is not within his or her own capacity and not against religious beliefs and principles</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.social_raw_score2" :readonly="!editMode" @input="validateRawScore('social_raw_score2')">
              </td>
              <tr>
              
              <td class="py-2 px-4 border-b border-gray-200">Has no self-confidence which cause him or her to do most or all of the following:
* always refuses to participate in sports, socio-cultural, and skills training even if constantly encouraged
* constantly makes negative self-talk (e.g. I cannot do it, I am good for nothing, etc.)
* always dwells on what she or he cannot do rather than on what she or he can perform
* isolates self, most of the time
</td>
              <td class="py-2 px-4 border-b border-gray-200">Tries to participate in center's activities although with some degree of hesitation because of doubt that she or he will be able to perform as expected. Needs constant encouragement.</td>
              <td class="py-2 px-4 border-b border-gray-200">Aware of limitations but still maintain healthy self-confidence as shown in his or her ability to do the following:
* assert
* avoid saying self-demeaning words
* active participation in center's activities
</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.social_raw_score3" :readonly="!editMode" @input="validateRawScore('social_raw_score3')">
              </td>
            </tr> 
            <tr>
              
              <td class="py-2 px-4 border-b border-gray-200">Disrespectful as evident in the following:
* defies center's rules and regulations
* does not want to perform tasks
* always answers back
</td>
              <td class="py-2 px-4 border-b border-gray-200">Is selective in showing respect</td>
              <td class="py-2 px-4 border-b border-gray-200">Respects others at all times</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.social_raw_score4" :readonly="!editMode" @input="validateRawScore('social_raw_score4')">
              </td>
            </tr> 

            <tr>
              
              <td class="py-2 px-4 border-b border-gray-200">Can't decide for himself or herself either because of absence of appropriate decision-making skills</td>
              <td class="py-2 px-4 border-b border-gray-200">Makes decisions but always needs the confirmation of others</td>
              <td class="py-2 px-4 border-b border-gray-200">Decides for himself or herself but refers to others for assistance when appropriate</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.social_raw_score5" :readonly="!editMode" @input="validateRawScore('social_raw_score5')">
              </td>
            </tr> 

            <tr>
              
              <td class="py-2 px-4 border-b border-gray-200">Domineering and manipulative as can be gleaned from any or all of the following:
* attempts to lead others to violate center's rules and regulations
* imposes harsh decisions, distorted values, false beliefs, inappropriate practices, etc.
* intimates or threatens others to get things done
</td>
              <td class="py-2 px-4 border-b border-gray-200">Sometimes tends to dominate and manipulate others, but tries to control such tendency especially when attention is called</td>
              <td class="py-2 px-4 border-b border-gray-200">Refrains from domineering or manipulating others as evident in the following:
* adheres to group decision
* refrains from imposing beliefs, values or practices to others
* refrains from threatening others to achieve or get what he or she wants
</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.social_raw_score6" :readonly="!editMode" @input="validateRawScore('social_raw_score6')">
              </td>
            </tr> 

            <tr>
              
              <td class="py-2 px-4 border-b border-gray-200">Is always involved in stealing and shows no remorse</td>
              <td class="py-2 px-4 border-b border-gray-200">Has the tendency to steal but shows remorse by returning stolen items and expressing the need to be restrained from committing such act</td>
              <td class="py-2 px-4 border-b border-gray-200">Does not steal</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.social_raw_score7" :readonly="!editMode" @input="validateRawScore('social_raw_score7')">
              </td>
            </tr> 

            <tr>
              
              <td class="py-2 px-4 border-b border-gray-200">Always tells lies to damage or hurt others and to make self-appear superior over other people</td>
              <td class="py-2 px-4 border-b border-gray-200">Has the tendency to lie in some occasions but avoids that may harm or damage others</td>
              <td class="py-2 px-4 border-b border-gray-200">Strives to be honest at all times</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.social_raw_score8" :readonly="!editMode" @input="validateRawScore('social_raw_score8')">
              </td>
            </tr> 
          </tbody>
        </table>
  
        <div class="text-center text-xs mt-10">
          <p>PAGE 2 of 4</p>
          <p>DSWD Field Office XI, RRCY Purok 7, Bajao Gisho, Tugatok District, Davao City, Philippines 8000</p>
          <p>Website: <a href="https://www.dswd.gov.ph" class="text-blue-500">www.dswd.gov.ph</a>, Tel No.: (082) 227-1964 Email: <a href="mailto:rcydavao@gmail.com" class="text-blue-500">rcydavao@gmail.com</a></p>
        </div>
      </div>

        <!-- Page 3 -->
        <div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg mb-10">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200">
                            AREAS
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Severely-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Moderately-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Normal Functioning
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Raw Score
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Score per Area
                        </th>
                    </tr>
                </thead>
                <tbody>
                  <tr>
              <td class="py-2 px-4 border-b border-gray-200" rowspan="6">Spiritual</td>
              <td class="py-2 px-4 border-b border-gray-200">Has low self-confidence which causes him or her to find meaning only in negative thoughts; always makes self-deprecating comments and statements which devalue his/her own worth</td>
              <td class="py-2 px-4 border-b border-gray-200">Sometimes tends to be overly critical of self but manages to overcome feelings of inadequacy and finds meaning in life through other positive activities</td>
              <td class="py-2 px-4 border-b border-gray-200">Recognizes and accepts his/her limitations but strives to improve self and find meaning in life through positive self-affirmation and involvement in community/ religious activities</td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.spiritual_raw_score1" :readonly="!editMode" @input="validateRawScore('spiritual_raw_score1')">
              </td>
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.spiritual_score_per_area1" readonly>
              </td>
            </tr>

                    <!-- Add additional rows as necessary -->
                </tbody>
            </table>

            <div class="text-center text-xs mt-10">
                <p>PAGE 3 of 4</p>
                <p>
                    DSWD Field Office XI, RRCY Purok 7, Bajao Gisho, Tugatok
                    District, Davao City, Philippines 8000
                </p>
                <p>
                    Website:
                    <a href="https://www.dswd.gov.ph" class="text-blue-500"
                        >www.dswd.gov.ph</a
                    >, Tel No.: (082) 227-1964 Email:
                    <a href="mailto:rcydavao@gmail.com" class="text-blue-500"
                        >rcydavao@gmail.com</a
                    >
                </p>
            </div>
        </div>

        <!-- Page 4 -->
        <div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200">
                            AREAS
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Severely-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Moderately-Impaired Functioning
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Normal Functioning
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Raw Score
                        </th>
                        <th class="py-2 px-4 border-b border-gray-200">
                            Score per Area
                        </th>
                    </tr>
                </thead>
                <tbody>
                  <tr>
    <td class="py-2 px-4 border-b border-gray-200">
        Educational / Literacy
    </td>
    <td class="py-2 px-4 border-b border-gray-200">
        Not able to read, write and count
    </td>
    <td class="py-2 px-4 border-b border-gray-200">
        Undertakes non-formal education or willingly
        receives tutorial services to learn basic skills
    </td>
    <td class="py-2 px-4 border-b border-gray-200">
        Able to read, write and count with skills
        appropriate to age and educational attainment
    </td>
    <td class="py-2 px-4 border-b border-gray-200">
        <input
            type="number"
            min="0"
            max="100"
            class="w-full mt-1 p-2 border border-gray-300 rounded-md"
            v-model="form.educational_raw_score"
            :readonly="!editMode"
            @input="validateRawScore('educational_raw_score')"
        />
    </td>
    <td class="py-2 px-4 border-b border-gray-200">
        <input
            type="text"
            class="w-full mt-1 p-2 border border-gray-300 rounded-md"
            v-model="form.educational_score_per_area"
            readonly
        />
    </td>
</tr>
<tr>
    <td class="py-2 px-4 border-b border-gray-200">
        Economic Productivity
    </td>
    <td class="py-2 px-4 border-b border-gray-200">
        No employable skills and has no interest in learning
        any skills that would help him/her support his/her
        needs
    </td>
    <td class="py-2 px-4 border-b border-gray-200">
        Needs to brush up skills to make them usable for
        employment
    </td>
    <td class="py-2 px-4 border-b border-gray-200">
        Has employable skills
    </td>
    <td class="py-2 px-4 border-b border-gray-200">
        <input
            type="number"
            min="0"
            max="100"
            class="w-full mt-1 p-2 border border-gray-300 rounded-md"
            v-model="form.economic_raw_score"
            :readonly="!editMode"
            @input="validateRawScore('economic_raw_score')"
        />
    </td>
    <td class="py-2 px-4 border-b border-gray-200">
        <input
            type="text"
            class="w-full mt-1 p-2 border border-gray-300 rounded-md"
            v-model="form.economic_score_per_area"
            readonly
        />
    </td>
</tr>

                </tbody>
            </table>

            <div class="mt-6">
          <label class="block text-gray-700">General Score:</label>
          <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.general_score" readonly>
        </div>
        <div class="mt-6">
          <label class="block text-gray-700">Interpretation:</label>
          <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.interpretation" :readonly="!editMode">
        </div>
  
        <div class="flex justify-between mt-10">
          <div>
            <label class="block text-gray-700">Prepared by:</label>
            <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.prepared_by" :readonly="!editMode">
          </div>
          <div>
            <label class="block text-gray-700">Discussed with:</label>
            <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md" v-model="form.discussed_with" :readonly="!editMode">
          </div>
        </div>
  
        <div class="text-center text-xs mt-10">
          <p>PAGE 4 of 4</p>
          <p>DSWD PROTECTIVE SERVICES DIVISION, FIELD OFFICE XI, REGIONAL REHABILITATION CENTER FOR YOUTH</p>
        </div>
      </div>

  </div>
</template>



<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import {  watch } from 'vue';

export default {
  setup() {
    const route = useRoute();
    const editMode = ref(false);
    const message = ref('');
    const messageType = ref('');
    const form = ref({
      client_id: null,
      admission_id: null,
      date_administered: '',
      physical_raw_score1: '',
      physical_score_per_area1: '',
      physical_raw_score2: '',
      emotional_raw_score1: '',
      emotional_score_per_area1: '',
      emotional_raw_score2: '',
      emotional_raw_score3: '',
      emotional_raw_score4: '',
      emotional_raw_score5: '',
      emotional_raw_score6: '',
      social_raw_score1: '',
      social_score_per_area1: '',
      social_raw_score2: '',
      social_raw_score3: '',
      social_raw_score4: '',
      social_raw_score5: '',
      social_raw_score6: '',
      social_raw_score7: '',
      social_raw_score8: '',
      spiritual_raw_score1: '',
      spiritual_score_per_area1: '',
      educational_raw_score: '',
      educational_score_per_area: '',
      economic_raw_score: '',
      economic_score_per_area: '',
      general_score: '',
      interpretation: '',
      prepared_by: '',
      discussed_with: ''
    });

    const clientName = ref('');
    const errorMessage = ref('');

    const fetchData = async (client_id) => {
  try {
    const clientResponse = await axios.get(`/api/clients/${client_id}`);
    const clientData = clientResponse.data;

    const admissionResponse = await axios.get(`/api/admissions/client/${clientData.id}`);
    const admissionData = admissionResponse.data;

    const indicatorResponse = await axios.get(`/api/indicators-of-social-functioning/check/${clientData.id}/${admissionData.id}`);
    const indicatorData = indicatorResponse.data;

    if (!indicatorData) {
      // No indicator found for this client and admission, handle accordingly
      message.value = 'No indicator data found for this client.';
      messageType.value = 'error';
      return;
    }

    clientName.value = `${clientData.first_name} ${clientData.middle_name ? clientData.middle_name + ' ' : ''}${clientData.last_name}`;
    form.value.client_id = clientData.id;
    form.value.admission_id = admissionData.id;
    form.value.dateAdmission = admissionData.date_admitted;
    form.value.date_administered = indicatorData.date_administered || admissionData.date_administered;

    form.value.physical_raw_score1 = indicatorData.physical_raw_score1 || '';
    form.value.physical_score_per_area1 = indicatorData.physical_score_per_area1 || '';
    form.value.physical_raw_score2 = indicatorData.physical_raw_score2 || '';

    form.value.emotional_raw_score1 = indicatorData.emotional_raw_score1 || '';
    form.value.emotional_score_per_area1 = indicatorData.emotional_score_per_area1 || '';
    form.value.emotional_raw_score2 = indicatorData.emotional_raw_score2 || '';
    form.value.emotional_raw_score3 = indicatorData.emotional_raw_score3 || '';
    form.value.emotional_raw_score4 = indicatorData.emotional_raw_score4 || '';
    form.value.emotional_raw_score5 = indicatorData.emotional_raw_score5 || '';
    form.value.emotional_raw_score6 = indicatorData.emotional_raw_score6 || '';

    form.value.social_raw_score1 = indicatorData.social_raw_score1 || '';
    form.value.social_score_per_area1 = indicatorData.social_score_per_area1 || '';
    form.value.social_raw_score2 = indicatorData.social_raw_score2 || '';
    form.value.social_raw_score3 = indicatorData.social_raw_score3 || '';
    form.value.social_raw_score4 = indicatorData.social_raw_score4 || '';
    form.value.social_raw_score5 = indicatorData.social_raw_score5 || '';
    form.value.social_raw_score6 = indicatorData.social_raw_score6 || '';
    form.value.social_raw_score7 = indicatorData.social_raw_score7 || '';
    form.value.social_raw_score8 = indicatorData.social_raw_score8 || '';

    form.value.spiritual_raw_score1 = indicatorData.spiritual_raw_score1 || '';
    form.value.spiritual_score_per_area1 = indicatorData.spiritual_score_per_area1 || '';

    form.value.educational_raw_score = indicatorData.educational_raw_score || '';
    form.value.educational_score_per_area = indicatorData.educational_score_per_area || '';

    form.value.economic_raw_score = indicatorData.economic_raw_score || '';
    form.value.economic_score_per_area = indicatorData.economic_score_per_area || '';

    form.value.general_score = indicatorData.general_score || '';
    form.value.interpretation = indicatorData.interpretation || '';

    form.value.prepared_by = indicatorData.prepared_by || '';
    form.value.discussed_with = indicatorData.discussed_with || '';

    errorMessage.value = '';

  } catch (error) {
    handleAxiosError(error);
  }
};



    const toggleEdit = () => {
      if (editMode.value) {
        saveData();
      }
      editMode.value = !editMode.value;
    };

    const validateRawScore = (field) => {
    if (form.value[field] < 0) {
        form.value[field] = 0;
    } else if (form.value[field] > 100) {
        form.value[field] = 100;
    }
    // Convert to integer explicitly
    form.value[field] = parseInt(form.value[field], 10) || 0;
    calculateScores();
};

const calculateScores = () => {
      // Calculate physical score per area
      form.value.physical_score_per_area1 = 
        form.value.physical_raw_score1 && form.value.physical_raw_score2 
        ? (parseFloat(form.value.physical_raw_score1) + parseFloat(form.value.physical_raw_score2)) / 2 
        : '';

      // Calculate emotional score per area
      form.value.emotional_score_per_area1 = [
        form.value.emotional_raw_score1,
        form.value.emotional_raw_score2,
        form.value.emotional_raw_score3,
        form.value.emotional_raw_score4,
        form.value.emotional_raw_score5,
        form.value.emotional_raw_score6,
      ].reduce((sum, score) => sum + (parseFloat(score) || 0), 0) / 6 || '';

      // Calculate social score per area
      form.value.social_score_per_area1 = [
        form.value.social_raw_score1,
        form.value.social_raw_score2,
        form.value.social_raw_score3,
        form.value.social_raw_score4,
        form.value.social_raw_score5,
        form.value.social_raw_score6,
        form.value.social_raw_score7,
        form.value.social_raw_score8,
      ].reduce((sum, score) => sum + (parseFloat(score) || 0), 0) / 8 || '';

      // Calculate spiritual score per area
      form.value.spiritual_score_per_area1 = form.value.spiritual_raw_score1 
        ? parseFloat(form.value.spiritual_raw_score1) 
        : '';

      // Calculate educational score per area
      form.value.educational_score_per_area = form.value.educational_raw_score 
        ? parseFloat(form.value.educational_raw_score) 
        : '';

      // Calculate economic score per area
      form.value.economic_score_per_area = form.value.economic_raw_score 
        ? parseFloat(form.value.economic_raw_score) 
        : '';

      // Calculate the general score
      const scores = [
        form.value.physical_score_per_area1,
        form.value.emotional_score_per_area1,
        form.value.social_score_per_area1,
        form.value.spiritual_score_per_area1,
        form.value.educational_score_per_area,
        form.value.economic_score_per_area,
      ].filter(score => score !== '');
      
      form.value.general_score = scores.length > 0 
        ? (scores.reduce((sum, score) => sum + parseFloat(score), 0) / scores.length).toFixed(2) 
        : '';
    };

    // Watch for changes in any of the raw scores to trigger recalculation
    watch(
      () => [
        form.value.physical_raw_score1,
        form.value.physical_raw_score2,
        form.value.emotional_raw_score1,
        form.value.emotional_raw_score2,
        form.value.emotional_raw_score3,
        form.value.emotional_raw_score4,
        form.value.emotional_raw_score5,
        form.value.emotional_raw_score6,
        form.value.social_raw_score1,
        form.value.social_raw_score2,
        form.value.social_raw_score3,
        form.value.social_raw_score4,
        form.value.social_raw_score5,
        form.value.social_raw_score6,
        form.value.social_raw_score7,
        form.value.social_raw_score8,
        form.value.spiritual_raw_score1,
        form.value.educational_raw_score,
        form.value.economic_raw_score,
      ],
      calculateScores
    );





const saveData = async () => {
    if (!form.value.client_id || !form.value.admission_id) {
        message.value = 'Client or Admission ID is missing.';
        messageType.value = 'error';
        return;
    }

    try {
        let method, url;

        if (form.value.id) {
            // Update existing record
            method = 'put';
            url = `/api/indicators-of-social-functioning/${form.value.id}`;
        } else {
            // Create new record
            method = 'post';
            url = `/api/indicators-of-social-functioning`;
        }

        const response = await axios[method](url, form.value);
        message.value = 'Data saved successfully!';
        messageType.value = 'success';
        errorMessage.value = '';

        if (!form.value.id) {
            form.value.id = response.data.id;
        }

        // Update the form with the calculated scores from the response
        form.value = response.data;

        setTimeout(() => {
            message.value = '';
        }, 3000);
    } catch (error) {
        handleAxiosError(error);
    }
};




    const handleAxiosError = (error) => {
      if (error.response) {
        console.error('Server Error:', error.response.data);
        message.value = `Error saving data: ${error.response.status} ${error.response.statusText}. ${error.response.data.message || ''}`;
      } else if (error.request) {
        console.error('No Response:', error.request);
        message.value = 'Error saving data: No response received from the server. Please check your network connection or try again later.';
      } else {
        console.error('Unexpected Error:', error.message);
        message.value = `Error saving data: ${error.message}`;
      }

      messageType.value = 'error';
    };

    onMounted(() => {
  const id = route.params.id; // Assuming id is the indicators_id
  if (id) {
    fetchData(id);
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
      validateRawScore,
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