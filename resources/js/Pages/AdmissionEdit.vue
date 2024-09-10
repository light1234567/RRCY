<template>
    <div>
        <h1 class="text-2xl p-2 text-red-500 mt-4 font-bold mb-8">
            Admission Form
        </h1>
        <form @submit.prevent="saveForm">
            <!-- Client Information -->
            <fieldset class="border border-gray-300 p-8 mb-4 rounded-lg">
                <legend class="text-lg font-bold">CLIENT INFORMATION</legend>
                <div class="grid grid-cols-1">
                    <!-- Name, Sex, and Date of Birth -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div class="md:col-span-1 mb-4">
                            <label for="clientFirstName" class="block mb-1">First Name: *</label>
                            <input
                                type="text"
                                id="clientFirstName"
                                v-model="client.first_name"
                                class="w-full px-3 py-2 border rounded-md"
                                required
                            />
                        </div>
                        <div class="md:col-span-1 mb-4">
                            <label for="clientMiddleName" class="block mb-1">Middle Name:</label>
                            <input
                                type="text"
                                id="clientMiddleName"
                                v-model="client.middle_name"
                                class="w-full px-3 py-2 border rounded-md"
                            />
                        </div>
                        <div class="md:col-span-1 mb-4">
                            <label for="clientLastName" class="block mb-1">Last Name: *</label>
                            <input
                                type="text"
                                id="clientLastName"
                                v-model="client.last_name"
                                class="w-full px-3 py-2 border rounded-md"
                                required
                            />
                        </div>
                        <div class="md:col-span-1 mb-4">
                            <label for="clientSex" class="block mb-1">Sex: *</label>
                            <select
                                id="clientSex"
                                v-model="client.sex"
                                class="w-full px-3 py-2 border rounded-md"
                                required
                            >
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Date of Birth and Place of Birth -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="md:col-span-1 mb-4">
                            <label for="clientDob" class="block mb-1">Date of Birth: *</label>
                            <input
                                type="date"
                                id="clientDob"
                                v-model="client.date_of_birth"
                                class="w-full px-3 py-2 border rounded-md"
                                required
                            />
                        </div>
                        <div class="md:col-span-1 mb-4">
                            <label for="clientPlaceOfBirth" class="block mb-1">Place of Birth: *</label>
                            <input
                                type="text"
                                id="clientPlaceOfBirth"
                                v-model="client.place_of_birth"
                                class="w-full px-3 py-2 border rounded-md"
                                required
                            />
                        </div>
                    </div>

                    <!-- Address Breakdown -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="mb-4">
                            <label for="clientProvince" class="block mb-1">Province: *</label>
                            <select
                                id="clientProvince"
                                v-model="client.province"
                                class="w-full px-3 py-2 border rounded-md"
                                @change="updateCitiesAndBarangays"
                                required
                            >
                                <option value="" disabled>Select Province</option>
                                <option value="Davao del Norte">Davao del Norte</option>
                                <option value="Davao del Sur">Davao del Sur</option>
                                <option value="Davao Oriental">Davao Oriental</option>
                                <option value="Davao de Oro">Davao de Oro</option>
                                <option value="Davao Occidental">Davao Occidental</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="clientCity" class="block mb-1">City/Municipality: *</label>
                            <select
                                id="clientCity"
                                v-model="client.city"
                                class="w-full px-3 py-2 border rounded-md"
                                @change="updateBarangays"
                                required
                            >
                                <option value="" disabled>Select City/Municipality</option>
                                <option v-for="city in cities" :key="city" :value="city">{{ city }}</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="clientBarangay" class="block mb-1">Barangay: *</label>
                            <select
                                id="clientBarangay"
                                v-model="client.barangay"
                                class="w-full px-3 py-2 border rounded-md"
                                required
                            >
                                <option value="" disabled>Select Barangay</option>
                                <option v-for="barangay in barangays" :key="barangay" :value="barangay">{{ barangay }}</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="clientStreet" class="block mb-1">House/Building Number and Street Name:</label>
                            <input
                                type="text"
                                id="clientStreet"
                                v-model="client.street"
                                class="w-full px-3 py-2 border rounded-md"
                            />
                        </div>
                    </div>

                    <!-- Religion -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="clientReligion" class="block mb-1">Religion: *</label>
                            <select
                                id="clientReligion"
                                v-model="client.religion"
                                class="w-full px-3 py-2 border rounded-md"
                                required
                            >
                                <option value="" disabled>Select Religion</option>
                                <option value="Aglipayan">Aglipayan</option>
                                <option value="Baha'i">Baha'i</option>
                                <option value="Buddhist">Buddhist</option>
                                <option value="Catholic">Catholic</option>
                                <option value="Christian">Christian</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Islam">Islam</option>
                                <option value="Iglesia ni Cristo">Iglesia ni Cristo</option>
                                <option value="Jehovah's Witness">Jehovah's Witness</option>
                                <option value="Judeo-Christian">Judeo-Christian</option>
                                <option value="Kapitiran">Kapitiran</option>
                                <option value="Latter-Day Saints (Mormons)">Latter-Day Saints (Mormons)</option>
                                <option value="Liberal Christian">Liberal Christian</option>
                                <option value="Maranatha">Maranatha</option>
                                <option value="Methodist">Methodist</option>
                                <option value="Nazarene">Nazarene</option>
                                <option value="Orthodox">Orthodox</option>
                                <option value="Pentecostal">Pentecostal</option>
                                <option value="Protestant">Protestant</option>
                                <option value="Quakers">Quakers</option>
                                <option value="Rastafari">Rastafari</option>
                                <option value="Roman Catholic">Roman Catholic</option>
                                <option value="SDA (Seventh-Day Adventist)">SDA (Seventh-Day Adventist)</option>
                                <option value="Shinto">Shinto</option>
                                <option value="Sikh">Sikh</option>
                                <option value="Taoist">Taoist</option>
                                <option value="The Church of God">The Church of God</option>
                                <option value="Unitarian Universalist">Unitarian Universalist</option>
                                <option value="Universal Church">Universal Church</option>
                                <option value="Voodoo">Voodoo</option>
                                <option value="Zoroastrian">Zoroastrian</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>
            <!-- Other form fields here... -->
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
                Save
            </button>
        </form>
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    clientData: Object
});

const client = ref({
    first_name: '',
    middle_name: '',
    last_name: '',
    sex: 'male',
    date_of_birth: '',
    place_of_birth: '',
    province: '',
    city: '',
    barangay: '',
    street: '',
    religion: ''
});

const cities = ref([]);
const barangays = ref([]);

const updateCitiesAndBarangays = () => {
    const province = client.value.province;
    const provinceCities = {
        "Davao del Norte": ["Tagum City", "Panabo City", "Samal City", "Carmen", "Kapalong", "New Corella", "San Isidro", "Santo Tomas", "Talaingod"],
        "Davao del Sur": ["Davao City", "Digos City", "Bansalan", "Hagonoy", "Kiblawan", "Magsaysay", "Malalag", "Matanao", "Padada", "Santa Cruz", "Sulop"],
        "Davao Oriental": ["Mati City", "Baganga", "Banaybanay", "Boston", "Caraga", "Cateel", "Governor Generoso", "Lupon", "Manay", "San Isidro", "Tarragona"],
        "Davao de Oro": ["Compostela", "Monkayo", "Maco", "Mabini", "Mawab", "Montevista", "Nabunturan", "New Bataan", "Pantukan", "Laak", "Maragusan"],
        "Davao Occidental": ["Malita", "Don Marcelino", "Jose Abad Santos", "Santa Maria", "Sarangani"]
    };
    cities.value = provinceCities[province] || [];
    barangays.value = [];
    client.value.city = '';
    client.value.barangay = '';
};

const updateBarangays = () => {
    const city = client.value.city;
    const cityBarangays = {
        "Tagum City": ["Apokon", "Bincungan", "Canocotan", "Cuambogan", "La Filipina", "Mankilam", "Magugpo East", "Magugpo North", "Magugpo Poblacion", "Magugpo South", "Magugpo West", "Nueva Fuerza", "Pagsabangan", "Pandapan", "San Agustin", "San Isidro", "Visayan Village"],
        "Panabo City": ["A. O. Floirendo", "Cacao", "Cagangohan", "Consolacion", "Datu Abdul Dadia", "Gredu", "J.P. Laurel", "Katipunan", "Kauswagan", "Kiotoy", "Klinan", "Little Panay", "Lower Panaga", "Mabunao", "Maduao", "Manay", "New Malaga", "New Pandan", "New Visayas", "Nanyo", "Quezon", "Salvacion", "San Francisco", "San Nicolas", "San Pedro", "San Roque", "San Vicente", "Santo Niño", "Sindaton", "Southern Davao", "Tagpore", "Tibungol", "Upper Licanan"],
        "Samal City": ["Adecor", "Aumbay", "Balet", "Caliclic", "Camudmud", "Catagman", "Cawag", "Cogon", "Del Monte", "Liberty", "Limao", "Mambago-A", "Mambago-B", "Miranda", "Moncado", "Peñaplata", "Poblacion", "San Agustin", "San Antonio", "San Isidro", "San Jose", "San Miguel", "Santa Cruz", "Santo Niño", "Sion", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagpopongan", "Tambo"],
        "Carmen": ["Adecor", "Alejal", "Anibongan", "Asuncion", "Ising", "La Paz", "Magsaysay", "Pagsabangan", "Pangyan", "Sabangan", "Salvacion", "San Isidro", "Santo Niño", "Taba", "Tuganay", "Tuganay Proper", "Tubod"],
        "Kapalong": ["Banutan", "Capungagan", "Florida", "Gupitan", "Mamacao", "Maniki", "Maug", "New Agutaya", "Nueva Fuerza", "Pag-asa", "Pag-tulagan", "Pandapan", "Patok", "Poblacion", "Sampao", "San Isidro", "Santo Niño", "Simulao", "Tiburcia", "Upper Tagasan", "Waan"],
        "New Corella": ["Carcor", "Del Pilar", "El Salvador", "Limba-an", "Macgum", "Magsaysay", "Mesaoy", "New Bohol", "Patrocenio", "Poblacion", "San Roque", "Santa Fe", "Santo Niño", "Suawon", "Suaon"],
        "San Isidro": ["Bato", "Binigasan", "Dacudao", "Datu Balong", "Datu Salumay", "Igangon", "Kipalili", "Libuton", "Lumiad", "Mabantao", "Mahayag", "Mamacao", "Manat", "Monte Dujali", "Pagsabangan", "Patag", "Sabangan", "Sampao", "San Roque", "Santa Filomena", "Santo Niño", "Sasa", "Suawon", "Upper Tagasan", "Upper Wangan"],
        "Santo Tomas": ["Balagunan", "Balisong", "Bobongan", "Casig-ang", "Esperanza", "Kinabalan", "Kipilas", "Magwawa", "New Visayas", "Pantaron", "Poblacion", "San Jose", "San Miguel", "San Pedro", "Santo Niño", "Talomo", "Tibal-og"],
        "Talaingod": ["Bayabas", "Dagohoy", "Datu Davao", "Kauswagan", "Nangan", "Panganan", "Pantaron", "San Jose", "Santa Cruz", "Santa Maria", "Santo Niño", "Sulangon"],

        "Davao City": ["Agdao", "Baguio", "Buhangin", "Bunawan", "Calinan", "Marilog", "Poblacion", "Talomo", "Toril", "Tugbok"],
        "Digos City": ["Aplaya", "Balabag", "Binaton", "Cogon", "Colorado", "Dawis", "Goma", "Kapatagan", "Kiagot", "Magsaysay", "Mahayahay", "Matti", "Rizal", "San Jose", "San Miguel", "San Roque", "Sinawilan", "Soong", "Tiguman", "Tres de Mayo", "Zone 1", "Zone 2", "Zone 3", "Zone 4"],
        "Bansalan": ["Anonang", "Bitaug", "Bonifacio", "Cagangohan", "Dumoy", "Eman", "Kinuskusan", "Libertad", "Linawan", "Magsaysay", "Marber", "New Clarin", "New Ilocos", "Poblacion", "Rizal", "Salvador", "San Isidro", "San Miguel", "Santa Maria", "Tinongtongan", "Tubo-Tubo"],
        "Hagonoy": ["Balutakay", "Clib", "Guihing", "Guihing Proper", "Kibanban", "Lanuro", "Lapulabao", "Leling", "Libertad", "Mahayahay", "Malabang", "Malinao", "Malian", "Manguring", "New Iloilo", "Paligue", "Pangyan", "Poblacion", "San Guillermo", "San Isidro", "San Miguel", "San Pedro", "Santa Cruz", "Santa Maria", "Tibungol", "Tibungol Proper"],
        "Kiblawan": ["Abnate", "Bagong Silang", "Balasiao", "Bonifacio", "Bugac", "Buno", "Cogon", "Crossing Digos", "Datalbasak", "Davao-Bongabong", "Eastern Kiblawan", "Guia", "Guinaitan", "Kisupaan", "Libertad", "Lumiad", "Malawanit", "New Clarin", "New Ilocos", "Pangi", "Poblacion", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santo Niño", "Suawon", "Upper Tagasan"],
        "Magsaysay": ["Abnate", "Bagong Silang", "Balnate", "Barayong", "Barobo", "Bato", "Bulatok", "Cogon", "Cuambog", "Dalumay", "Darapuay", "Dasay", "Datalmayahai", "Goma", "Guio-ang", "Igpit", "Kanapulo", "Kibalang", "Kibo", "Kibongot", "Kinuskusan", "Labuyan", "La Fortuna", "Lambajon", "Lapuan", "Lasang", "Lavigan", "Linawan", "Lower Igpit", "Lower Sibulan", "Mal", "Malalag", "Malalag Tubig", "Malinao", "Marber", "Mulao", "New Bantayan", "New Clarin", "New Ilocos", "New Sibulan", "Padada", "Pagasa", "Pangil", "Pangyan", "Poblacion", "Rizal", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santa Cruz", "Santo Niño", "Sibulan", "Sinawilan", "Sinayawan", "Soong", "Suawon", "Tagabuli", "Talomo", "Tampakan", "Tigbao", "Tinongtongan", "Tupi", "Upper Tagasan"],
        "Malalag": ["Bagong Bayan", "Banaybanay", "Bayabas", "Bulacan", "Colongulo", "Dalumay", "Darapuay", "Dasay", "Datalbasak", "Datalgoni", "Guihing", "Kalubohan", "Kanapulo", "Kinuskusan", "Libertad", "Lumiad", "Malinao", "Managa", "Marber", "Matinao", "Matinan", "Matti", "New Sibulan", "Paligo", "Palilun", "Pangyan", "Patulang", "Poblacion", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santo Niño", "Sinawilan", "Sinayawan", "Soong", "Suawon", "Tagabuli", "Tagakpan", "Talomo", "Tibungol", "Tinongtongan"],
        "Matanao": ["Abnate", "Bagong Bayan", "Bagong Silang", "Balnate", "Balos", "Banate", "Barayong", "Basiawan", "Bato", "Bayabas", "Bayuyan", "Bulacan", "Colongulo", "Cuambog", "Datalgoni", "Darapuay", "Datalbasak", "Dasay", "Datalmayahai", "Dawis", "Del Pilar", "Doy", "Guihing", "Kabalantian", "Kaimakop", "Kalubohan", "Kanapulo", "Kinuskusan", "Lumiad", "Mahayahay", "Malinao", "Managa", "Marber", "Matinao", "Matinan", "Matti", "Napan", "Padada", "Paligo", "Pangyan", "Patulang", "Poblacion", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santo Niño", "Sinayawan", "Soong", "Suawon", "Tagabuli", "Tagakpan", "Talomo", "Talubangan", "Tibungol", "Tinongtongan"],
        "Padada": ["Abnate", "Bagong Bayan", "Bagong Silang", "Balnate", "Balos", "Banaybanay", "Barayong", "Basiawan", "Bato", "Bayabas", "Bayuyan", "Bulacan", "Colongulo", "Datalgoni", "Darapuay", "Dasay", "Datalbasak", "Datalmayahai", "Dawis", "Guihing", "Kabalantian", "Kaimakop", "Kalubohan", "Kinuskusan", "Lumiad", "Mahayahay", "Malinao", "Marber", "Matinao", "Matinan", "Matti", "Napan", "Padada", "Paligo", "Pangyan", "Patulang", "Poblacion", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santo Niño", "Sinayawan", "Soong", "Suawon", "Tagabuli", "Tagakpan", "Talomo", "Talubangan", "Tibungol", "Tinongtongan"],
        "Santa Cruz": ["Adecor", "Alejal", "Anibongan", "Apokon", "Asuncion", "Balusong", "Balusong West", "Banaybanay", "Banaybanay West", "Banaybanay East", "Bincungan", "Bungiao", "Buntay", "Cuambog", "Dacudao", "Darapuay", "Dasay", "Datal", "Davao", "Guio-ang", "Igpit", "J.P. Laurel", "Kinuskusan", "Kibongot", "Libertad", "Lumiad", "Mahayahay", "Magugpo East", "Magugpo North", "Magugpo Poblacion", "Magugpo South", "Magugpo West", "Matinao", "Matinan", "Maton", "Nangan", "Nangan East", "New Sibulan", "New Visayas", "Pangyan", "Patulang", "Poblacion", "Rizal", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santo Niño", "Sinayawan", "Sual", "Suawon", "Talomo", "Tagbay", "Tibungol", "Tibungol Proper"],
        "Sulop": ["Abnate", "Alejal", "Anibongan", "Apokon", "Asuncion", "Balusong", "Balusong West", "Banaybanay", "Banaybanay West", "Banaybanay East", "Bincungan", "Bungiao", "Buntay", "Cuambog", "Dacudao", "Darapuay", "Dasay", "Datal", "Davao", "Guio-ang", "Igpit", "J.P. Laurel", "Kinuskusan", "Kibongot", "Libertad", "Lumiad", "Mahayahay", "Magugpo East", "Magugpo North", "Magugpo Poblacion", "Magugpo South", "Magugpo West", "Matinao", "Matinan", "Maton", "Nangan", "Nangan East", "New Sibulan", "New Visayas", "Pangyan", "Patulang", "Poblacion", "Rizal", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santo Niño", "Sinayawan", "Sual", "Suawon", "Talomo", "Tagbay", "Tibungol", "Tibungol Proper"],

        "Mati City": ["Badas", "Bangkaw-Bangkaw", "Barangay Central", "Bobon", "Bolo", "Buso", "Calao", "Dahican", "Don Enrique Lopez", "Don Mariano Marcos", "Dumoy", "Gaudan", "Iba", "Ilangay", "Jamela", "Kanding", "Kinawitnon", "La Union", "Laguna", "Lancaon", "Lawigan", "Libudon", "Limot", "Lucod", "Mahayahay", "Matiao", "Mauswagon", "Mayo", "Minalaba", "Poblacion", "San Ignacio", "San Isidro", "San Roque", "Santa Cruz", "Sasa", "Sito", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Baganga": ["Bacao", "Baculin", "Ban-ao", "Basa", "Batiano", "Binondo", "Binoongan", "Cabangahan", "Cabidan", "Camantangan", "Cambaleon", "Campawan", "Caningag", "Concepcion", "Dahican", "Datu Balong", "Guihing", "J.P. Laurel", "Lavigan", "Limot", "Lucod", "Malalangas", "Malbogon", "Mambago-A", "Mambago-B", "Mampising", "Manay", "Mapantad", "Matiao", "Mauswagon", "Mayo", "New Bataan", "New Visayas", "Pagsabangan", "Pangyan", "Poblacion", "San Ignacio", "San Isidro", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Banaybanay": ["Andap", "Bacungan", "Baganga", "Balinawan", "Balite", "Bato", "Batolinao", "Bawani", "Binantian", "Bobon", "Buena Vida", "Busaon", "Camansi", "Camantangan", "Campawan", "Caningag", "Concepcion", "Datu Balong", "Guihing", "J.P. Laurel", "Kanding", "Limot", "Lucod", "Malalangas", "Malbogon", "Manay", "Mapantad", "Matiao", "Mauswagon", "Mayo", "New Bataan", "New Visayas", "Pagsabangan", "Pangyan", "Poblacion", "San Ignacio", "San Isidro", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Boston": ["Andap", "Bacungan", "Baganga", "Balinawan", "Balite", "Bato", "Batolinao", "Bawani", "Binantian", "Bobon", "Buena Vida", "Busaon", "Camansi", "Camantangan", "Campawan", "Caningag", "Concepcion", "Datu Balong", "Guihing", "J.P. Laurel", "Kanding", "Limot", "Lucod", "Malalangas", "Malbogon", "Manay", "Mapantad", "Matiao", "Mauswagon", "Mayo", "New Bataan", "New Visayas", "Pagsabangan", "Pangyan", "Poblacion", "San Ignacio", "San Isidro", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Caraga": ["Andap", "Bacungan", "Baganga", "Balinawan", "Balite", "Bato", "Batolinao", "Bawani", "Binantian", "Bobon", "Buena Vida", "Busaon", "Camansi", "Camantangan", "Campawan", "Caningag", "Concepcion", "Datu Balong", "Guihing", "J.P. Laurel", "Kanding", "Limot", "Lucod", "Malalangas", "Malbogon", "Manay", "Mapantad", "Matiao", "Mauswagon", "Mayo", "New Bataan", "New Visayas", "Pagsabangan", "Pangyan", "Poblacion", "San Ignacio", "San Isidro", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Cateel": ["Andap", "Bacungan", "Baganga", "Balinawan", "Balite", "Bato", "Batolinao", "Bawani", "Binantian", "Bobon", "Buena Vida", "Busaon", "Camansi", "Camantangan", "Campawan", "Caningag", "Concepcion", "Datu Balong", "Guihing", "J.P. Laurel", "Kanding", "Limot", "Lucod", "Malalangas", "Malbogon", "Manay", "Mapantad", "Matiao", "Mauswagon", "Mayo", "New Bataan", "New Visayas", "Pagsabangan", "Pangyan", "Poblacion", "San Ignacio", "San Isidro", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Governor Generoso": ["Andap", "Bacungan", "Baganga", "Balinawan", "Balite", "Bato", "Batolinao", "Bawani", "Binantian", "Bobon", "Buena Vida", "Busaon", "Camansi", "Camantangan", "Campawan", "Caningag", "Concepcion", "Datu Balong", "Guihing", "J.P. Laurel", "Kanding", "Limot", "Lucod", "Malalangas", "Malbogon", "Manay", "Mapantad", "Matiao", "Mauswagon", "Mayo", "New Bataan", "New Visayas", "Pagsabangan", "Pangyan", "Poblacion", "San Ignacio", "San Isidro", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Lupon": ["Andap", "Bacungan", "Baganga", "Balinawan", "Balite", "Bato", "Batolinao", "Bawani", "Binantian", "Bobon", "Buena Vida", "Busaon", "Camansi", "Camantangan", "Campawan", "Caningag", "Concepcion", "Datu Balong", "Guihing", "J.P. Laurel", "Kanding", "Limot", "Lucod", "Malalangas", "Malbogon", "Manay", "Mapantad", "Matiao", "Mauswagon", "Mayo", "New Bataan", "New Visayas", "Pagsabangan", "Pangyan", "Poblacion", "San Ignacio", "San Isidro", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Manay": ["Andap", "Bacungan", "Baganga", "Balinawan", "Balite", "Bato", "Batolinao", "Bawani", "Binantian", "Bobon", "Buena Vida", "Busaon", "Camansi", "Camantangan", "Campawan", "Caningag", "Concepcion", "Datu Balong", "Guihing", "J.P. Laurel", "Kanding", "Limot", "Lucod", "Malalangas", "Malbogon", "Manay", "Mapantad", "Matiao", "Mauswagon", "Mayo", "New Bataan", "New Visayas", "Pagsabangan", "Pangyan", "Poblacion", "San Ignacio", "San Isidro", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "San Isidro": ["Andap", "Bacungan", "Baganga", "Balinawan", "Balite", "Bato", "Batolinao", "Bawani", "Binantian", "Bobon", "Buena Vida", "Busaon", "Camansi", "Camantangan", "Campawan", "Caningag", "Concepcion", "Datu Balong", "Guihing", "J.P. Laurel", "Kanding", "Limot", "Lucod", "Malalangas", "Malbogon", "Manay", "Mapantad", "Matiao", "Mauswagon", "Mayo", "New Bataan", "New Visayas", "Pagsabangan", "Pangyan", "Poblacion", "San Ignacio", "San Isidro", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Tarragona": ["Andap", "Bacungan", "Baganga", "Balinawan", "Balite", "Bato", "Batolinao", "Bawani", "Binantian", "Bobon", "Buena Vida", "Busaon", "Camansi", "Camantangan", "Campawan", "Caningag", "Concepcion", "Datu Balong", "Guihing", "J.P. Laurel", "Kanding", "Limot", "Lucod", "Malalangas", "Malbogon", "Manay", "Mapantad", "Matiao", "Mauswagon", "Mayo", "New Bataan", "New Visayas", "Pagsabangan", "Pangyan", "Poblacion", "San Ignacio", "San Isidro", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],

        "Compostela": ["Alejal", "Amakan", "Apo Macote", "Bagong Bayan", "Balnate", "Basiawan", "Binondo", "Bobongon", "Bolisong", "Buaya", "Buenavista", "Cabasagan", "Cabinuangan", "Calatrava", "Candinuyan", "Canling", "Capungagan", "Carcor", "Cawayan", "Caybunga", "Dulangan", "Guadalupe", "Guio-ang", "Ilangay", "Inayangan", "Kabaruyan", "Kabalantian", "Kaimakop", "Kanapulo", "Lavigan", "Libertad", "Limbo", "Lubi", "Lumiad", "Magsaysay", "Malinao", "Malu-ao", "Manaoag", "Mantasalam", "Maparat", "Marber", "Mayo", "Matiao", "Matin-ao", "Matiyan", "Mawab", "New Bataan", "New Visayas", "Pangyan", "Patag", "Poblacion", "San Ignacio", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Monkayo": ["Alejal", "Amakan", "Apo Macote", "Bagong Bayan", "Balnate", "Basiawan", "Binondo", "Bobongon", "Bolisong", "Buaya", "Buenavista", "Cabasagan", "Cabinuangan", "Calatrava", "Candinuyan", "Canling", "Capungagan", "Carcor", "Cawayan", "Caybunga", "Dulangan", "Guadalupe", "Guio-ang", "Ilangay", "Inayangan", "Kabaruyan", "Kabalantian", "Kaimakop", "Kanapulo", "Lavigan", "Libertad", "Limbo", "Lubi", "Lumiad", "Magsaysay", "Malinao", "Malu-ao", "Manaoag", "Mantasalam", "Maparat", "Marber", "Mayo", "Matiao", "Matin-ao", "Matiyan", "Mawab", "New Bataan", "New Visayas", "Pangyan", "Patag", "Poblacion", "San Ignacio", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Maco": ["Alejal", "Amakan", "Apo Macote", "Bagong Bayan", "Balnate", "Basiawan", "Binondo", "Bobongon", "Bolisong", "Buaya", "Buenavista", "Cabasagan", "Cabinuangan", "Calatrava", "Candinuyan", "Canling", "Capungagan", "Carcor", "Cawayan", "Caybunga", "Dulangan", "Guadalupe", "Guio-ang", "Ilangay", "Inayangan", "Kabaruyan", "Kabalantian", "Kaimakop", "Kanapulo", "Lavigan", "Libertad", "Limbo", "Lubi", "Lumiad", "Magsaysay", "Malinao", "Malu-ao", "Manaoag", "Mantasalam", "Maparat", "Marber", "Mayo", "Matiao", "Matin-ao", "Matiyan", "Mawab", "New Bataan", "New Visayas", "Pangyan", "Patag", "Poblacion", "San Ignacio", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Mabini": ["Alejal", "Amakan", "Apo Macote", "Bagong Bayan", "Balnate", "Basiawan", "Binondo", "Bobongon", "Bolisong", "Buaya", "Buenavista", "Cabasagan", "Cabinuangan", "Calatrava", "Candinuyan", "Canling", "Capungagan", "Carcor", "Cawayan", "Caybunga", "Dulangan", "Guadalupe", "Guio-ang", "Ilangay", "Inayangan", "Kabaruyan", "Kabalantian", "Kaimakop", "Kanapulo", "Lavigan", "Libertad", "Limbo", "Lubi", "Lumiad", "Magsaysay", "Malinao", "Malu-ao", "Manaoag", "Mantasalam", "Maparat", "Marber", "Mayo", "Matiao", "Matin-ao", "Matiyan", "Mawab", "New Bataan", "New Visayas", "Pangyan", "Patag", "Poblacion", "San Ignacio", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Mawab": ["Alejal", "Amakan", "Apo Macote", "Bagong Bayan", "Balnate", "Basiawan", "Binondo", "Bobongon", "Bolisong", "Buaya", "Buenavista", "Cabasagan", "Cabinuangan", "Calatrava", "Candinuyan", "Canling", "Capungagan", "Carcor", "Cawayan", "Caybunga", "Dulangan", "Guadalupe", "Guio-ang", "Ilangay", "Inayangan", "Kabaruyan", "Kabalantian", "Kaimakop", "Kanapulo", "Lavigan", "Libertad", "Limbo", "Lubi", "Lumiad", "Magsaysay", "Malinao", "Malu-ao", "Manaoag", "Mantasalam", "Maparat", "Marber", "Mayo", "Matiao", "Matin-ao", "Matiyan", "Mawab", "New Bataan", "New Visayas", "Pangyan", "Patag", "Poblacion", "San Ignacio", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Montevista": ["Alejal", "Amakan", "Apo Macote", "Bagong Bayan", "Balnate", "Basiawan", "Binondo", "Bobongon", "Bolisong", "Buaya", "Buenavista", "Cabasagan", "Cabinuangan", "Calatrava", "Candinuyan", "Canling", "Capungagan", "Carcor", "Cawayan", "Caybunga", "Dulangan", "Guadalupe", "Guio-ang", "Ilangay", "Inayangan", "Kabaruyan", "Kabalantian", "Kaimakop", "Kanapulo", "Lavigan", "Libertad", "Limbo", "Lubi", "Lumiad", "Magsaysay", "Malinao", "Malu-ao", "Manaoag", "Mantasalam", "Maparat", "Marber", "Mayo", "Matiao", "Matin-ao", "Matiyan", "Mawab", "New Bataan", "New Visayas", "Pangyan", "Patag", "Poblacion", "San Ignacio", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Nabunturan": ["Alejal", "Amakan", "Apo Macote", "Bagong Bayan", "Balnate", "Basiawan", "Binondo", "Bobongon", "Bolisong", "Buaya", "Buenavista", "Cabasagan", "Cabinuangan", "Calatrava", "Candinuyan", "Canling", "Capungagan", "Carcor", "Cawayan", "Caybunga", "Dulangan", "Guadalupe", "Guio-ang", "Ilangay", "Inayangan", "Kabaruyan", "Kabalantian", "Kaimakop", "Kanapulo", "Lavigan", "Libertad", "Limbo", "Lubi", "Lumiad", "Magsaysay", "Malinao", "Malu-ao", "Manaoag", "Mantasalam", "Maparat", "Marber", "Mayo", "Matiao", "Matin-ao", "Matiyan", "Mawab", "New Bataan", "New Visayas", "Pangyan", "Patag", "Poblacion", "San Ignacio", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "New Bataan": ["Alejal", "Amakan", "Apo Macote", "Bagong Bayan", "Balnate", "Basiawan", "Binondo", "Bobongon", "Bolisong", "Buaya", "Buenavista", "Cabasagan", "Cabinuangan", "Calatrava", "Candinuyan", "Canling", "Capungagan", "Carcor", "Cawayan", "Caybunga", "Dulangan", "Guadalupe", "Guio-ang", "Ilangay", "Inayangan", "Kabaruyan", "Kabalantian", "Kaimakop", "Kanapulo", "Lavigan", "Libertad", "Limbo", "Lubi", "Lumiad", "Magsaysay", "Malinao", "Malu-ao", "Manaoag", "Mantasalam", "Maparat", "Marber", "Mayo", "Matiao", "Matin-ao", "Matiyan", "Mawab", "New Bataan", "New Visayas", "Pangyan", "Patag", "Poblacion", "San Ignacio", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Pantukan": ["Alejal", "Amakan", "Apo Macote", "Bagong Bayan", "Balnate", "Basiawan", "Binondo", "Bobongon", "Bolisong", "Buaya", "Buenavista", "Cabasagan", "Cabinuangan", "Calatrava", "Candinuyan", "Canling", "Capungagan", "Carcor", "Cawayan", "Caybunga", "Dulangan", "Guadalupe", "Guio-ang", "Ilangay", "Inayangan", "Kabaruyan", "Kabalantian", "Kaimakop", "Kanapulo", "Lavigan", "Libertad", "Limbo", "Lubi", "Lumiad", "Magsaysay", "Malinao", "Malu-ao", "Manaoag", "Mantasalam", "Maparat", "Marber", "Mayo", "Matiao", "Matin-ao", "Matiyan", "Mawab", "New Bataan", "New Visayas", "Pangyan", "Patag", "Poblacion", "San Ignacio", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],

        "Malita": ["Alejal", "Amakan", "Apo Macote", "Bagong Bayan", "Balnate", "Basiawan", "Binondo", "Bobongon", "Bolisong", "Buaya", "Buenavista", "Cabasagan", "Cabinuangan", "Calatrava", "Candinuyan", "Canling", "Capungagan", "Carcor", "Cawayan", "Caybunga", "Dulangan", "Guadalupe", "Guio-ang", "Ilangay", "Inayangan", "Kabaruyan", "Kabalantian", "Kaimakop", "Kanapulo", "Lavigan", "Libertad", "Limbo", "Lubi", "Lumiad", "Magsaysay", "Malinao", "Malu-ao", "Manaoag", "Mantasalam", "Maparat", "Marber", "Mayo", "Matiao", "Matin-ao", "Matiyan", "Mawab", "New Bataan", "New Visayas", "Pangyan", "Patag", "Poblacion", "San Ignacio", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Don Marcelino": ["Alejal", "Amakan", "Apo Macote", "Bagong Bayan", "Balnate", "Basiawan", "Binondo", "Bobongon", "Bolisong", "Buaya", "Buenavista", "Cabasagan", "Cabinuangan", "Calatrava", "Candinuyan", "Canling", "Capungagan", "Carcor", "Cawayan", "Caybunga", "Dulangan", "Guadalupe", "Guio-ang", "Ilangay", "Inayangan", "Kabaruyan", "Kabalantian", "Kaimakop", "Kanapulo", "Lavigan", "Libertad", "Limbo", "Lubi", "Lumiad", "Magsaysay", "Malinao", "Malu-ao", "Manaoag", "Mantasalam", "Maparat", "Marber", "Mayo", "Matiao", "Matin-ao", "Matiyan", "Mawab", "New Bataan", "New Visayas", "Pangyan", "Patag", "Poblacion", "San Ignacio", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Jose Abad Santos": ["Alejal", "Amakan", "Apo Macote", "Bagong Bayan", "Balnate", "Basiawan", "Binondo", "Bobongon", "Bolisong", "Buaya", "Buenavista", "Cabasagan", "Cabinuangan", "Calatrava", "Candinuyan", "Canling", "Capungagan", "Carcor", "Cawayan", "Caybunga", "Dulangan", "Guadalupe", "Guio-ang", "Ilangay", "Inayangan", "Kabaruyan", "Kabalantian", "Kaimakop", "Kanapulo", "Lavigan", "Libertad", "Limbo", "Lubi", "Lumiad", "Magsaysay", "Malinao", "Malu-ao", "Manaoag", "Mantasalam", "Maparat", "Marber", "Mayo", "Matiao", "Matin-ao", "Matiyan", "Mawab", "New Bataan", "New Visayas", "Pangyan", "Patag", "Poblacion", "San Ignacio", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Santa Maria": ["Alejal", "Amakan", "Apo Macote", "Bagong Bayan", "Balnate", "Basiawan", "Binondo", "Bobongon", "Bolisong", "Buaya", "Buenavista", "Cabasagan", "Cabinuangan", "Calatrava", "Candinuyan", "Canling", "Capungagan", "Carcor", "Cawayan", "Caybunga", "Dulangan", "Guadalupe", "Guio-ang", "Ilangay", "Inayangan", "Kabaruyan", "Kabalantian", "Kaimakop", "Kanapulo", "Lavigan", "Libertad", "Limbo", "Lubi", "Lumiad", "Magsaysay", "Malinao", "Malu-ao", "Manaoag", "Mantasalam", "Maparat", "Marber", "Mayo", "Matiao", "Matin-ao", "Matiyan", "Mawab", "New Bataan", "New Visayas", "Pangyan", "Patag", "Poblacion", "San Ignacio", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"],
        "Sarangani": ["Alejal", "Amakan", "Apo Macote", "Bagong Bayan", "Balnate", "Basiawan", "Binondo", "Bobongon", "Bolisong", "Buaya", "Buenavista", "Cabasagan", "Cabinuangan", "Calatrava", "Candinuyan", "Canling", "Capungagan", "Carcor", "Cawayan", "Caybunga", "Dulangan", "Guadalupe", "Guio-ang", "Ilangay", "Inayangan", "Kabaruyan", "Kabalantian", "Kaimakop", "Kanapulo", "Lavigan", "Libertad", "Limbo", "Lubi", "Lumiad", "Magsaysay", "Malinao", "Malu-ao", "Manaoag", "Mantasalam", "Maparat", "Marber", "Mayo", "Matiao", "Matin-ao", "Matiyan", "Mawab", "New Bataan", "New Visayas", "Pangyan", "Patag", "Poblacion", "San Ignacio", "San Isidro", "San Jose", "San Miguel", "San Pedro", "Santa Cruz", "Santa Filomena", "Sasa", "Sual", "Tagbaobo", "Tagbay", "Tagbitan-ag", "Tagburos", "Tagdaliao", "Tagmamarkay", "Tagum"]
    };
    barangays.value = cityBarangays[city] || [];
    client.value.barangay = '';
};

watch(() => client.value.province, updateCitiesAndBarangays);
watch(() => client.value.city, updateBarangays);

onMounted(() => {
    if (props.clientData) {
        Object.assign(client.value, props.clientData);
        updateCitiesAndBarangays();
        updateBarangays();
    }
});

const saveForm = () => {
    axios.post('/api/save-admission', client.value)
        .then(response => {
            alert('Form saved successfully!');
        })
        .catch(error => {
            alert('Failed to save form. Please try again.');
            console.error(error);
        });
};


</script>
