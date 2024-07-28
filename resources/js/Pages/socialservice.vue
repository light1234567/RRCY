<template>
    <div>
        <h1 class="text-2xl font-bold mb-4">Admission Form</h1>
        <form @submit.prevent="saveForm">
            <!-- Client Information -->
            <fieldset class="border border-gray-300 p-4 mb-4 rounded-lg">
                <legend class="text-lg font-bold mb-4">
                    Client Information
                </legend>
                <div class="mb-4">
                    <label for="clientName" class="block mb-1">Name:</label>
                    <input
                        type="text"
                        id="clientName"
                        v-model="form.client.name"
                        placeholder="Enter client name"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="clientSex" class="block mb-1">Sex:</label>
                    <select
                        id="clientSex"
                        v-model="form.client.sex"
                        class="w-full px-3 py-2 border rounded-md"
                    >
                        <option value="" disabled selected>
                            Select client sex
                        </option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="clientAddress" class="block mb-1"
                        >Address:</label
                    >
                    <input
                        type="text"
                        id="clientAddress"
                        v-model="form.client.address"
                        placeholder="Enter client address"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="clientDob" class="block mb-1"
                        >Date of Birth:</label
                    >
                    <input
                        type="date"
                        id="clientDob"
                        v-model="form.client.date_of_birth"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="clientReligion" class="block mb-1"
                        >Religion:</label
                    >
                    <input
                        type="text"
                        id="clientReligion"
                        v-model="form.client.religion"
                        placeholder="Enter religion"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="clientOccupation" class="block mb-1"
                        >Occupation:</label
                    >
                    <input
                        type="text"
                        id="clientOccupation"
                        v-model="form.client.occupation"
                        placeholder="Enter occupation"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
            </fieldset>

            <!-- Admission Details -->
            <fieldset class="border border-gray-300 p-4 mb-4 rounded-lg">
                <legend class="text-lg font-bold mb-4">
                    Admission Details
                </legend>
                <div class="mb-4">
                    <label for="committingCourt" class="block mb-1"
                        >Committing Court:</label
                    >
                    <input
                        type="text"
                        id="committingCourt"
                        v-model="form.admission.committing_court"
                        placeholder="Enter committing court"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="crimCaseNumber" class="block mb-1"
                        >Criminal Case Number:</label
                    >
                    <input
                        type="text"
                        id="crimCaseNumber"
                        v-model="form.admission.crim_case_number"
                        placeholder="Enter criminal case number"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="offenseCommitted" class="block mb-1"
                        >Offense Committed:</label
                    >
                    <input
                        type="text"
                        id="offenseCommitted"
                        v-model="form.admission.offense_committed"
                        placeholder="Enter offense committed"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="dateAdmitted" class="block mb-1"
                        >Date Admitted:</label
                    >
                    <input
                        type="date"
                        id="dateAdmitted"
                        v-model="form.admission.date_admitted"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="daysInJail" class="block mb-1"
                        >Days in Jail:</label
                    >
                    <input
                        type="number"
                        id="daysInJail"
                        v-model="form.admission.days_in_jail"
                        placeholder="Enter days in jail"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="daysInDetentionCenter" class="block mb-1"
                        >Days in Detention Center:</label
                    >
                    <input
                        type="number"
                        id="daysInDetentionCenter"
                        v-model="form.admission.days_in_detention_center"
                        placeholder="Enter days in detention center"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="actionTaken" class="block mb-1"
                        >Action Taken:</label
                    >
                    <input
                        type="text"
                        id="actionTaken"
                        v-model="form.admission.action_taken"
                        placeholder="Enter action taken"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="highestEducAtt" class="block mb-1"
                        >Highest Education Attainment:</label
                    >
                    <input
                        type="text"
                        id="highestEducAtt"
                        v-model="form.admission.highest_educ_att"
                        placeholder="Enter highest education attainment"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="schoolName" class="block mb-1"
                        >School Name:</label
                    >
                    <input
                        type="text"
                        id="schoolName"
                        v-model="form.admission.school_name"
                        placeholder="Enter school name"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="classAdviser" class="block mb-1"
                        >Class Adviser:</label
                    >
                    <input
                        type="text"
                        id="classAdviser"
                        v-model="form.admission.class_adviser"
                        placeholder="Enter class adviser"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
            </fieldset>

            <!-- Distinguishing Marks -->
            <fieldset class="border border-gray-300 p-4 mb-4 rounded-lg">
                <legend class="text-lg font-bold mb-4">
                    Distinguishing Marks
                </legend>
                <div class="mb-4">
                    <label for="tattooScars" class="block mb-1"
                        >Tattoo/Scars:</label
                    >
                    <input
                        type="text"
                        id="tattooScars"
                        v-model="form.distinguishing_marks.tattoo_scars"
                        placeholder="Enter tattoo/scars"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="height" class="block mb-1">Height:</label>
                    <input
                        type="number"
                        id="height"
                        v-model="form.distinguishing_marks.height"
                        placeholder="Enter height"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="weight" class="block mb-1">Weight:</label>
                    <input
                        type="number"
                        id="weight"
                        v-model="form.distinguishing_marks.weight"
                        placeholder="Enter weight"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="colourOfEye" class="block mb-1"
                        >Colour of Eye:</label
                    >
                    <input
                        type="text"
                        id="colourOfEye"
                        v-model="form.distinguishing_marks.colour_of_eye"
                        placeholder="Enter colour of eye"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="skin" class="block mb-1">Skin:</label>
                    <input
                        type="text"
                        id="skin"
                        v-model="form.distinguishing_marks.skin"
                        placeholder="Enter skin"
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>
            </fieldset>

            <!-- Documents Submitted -->
            <fieldset class="border border-gray-300 p-4 mb-4 rounded-lg">
                <legend class="text-lg font-bold mb-4">
                    Documents Submitted
                </legend>
                <div class="mb-4">
                    <label for="scsr" class="block mb-1">SCSR:</label>
                    <input
                        type="checkbox"
                        id="scsr"
                        v-model="form.documents.scsr"
                    />
                </div>
                <div class="mb-4">
                    <label for="courtOrder" class="block mb-1"
                        >Court Order:</label
                    >
                    <input
                        type="checkbox"
                        id="courtOrder"
                        v-model="form.documents.courtOrder"
                    />
                </div>
                <div class="mb-4">
                    <label for="medicalCertificates" class="block mb-1"
                        >Medical Certificates:</label
                    >
                    <input
                        type="checkbox"
                        id="medicalCertificates"
                        v-model="form.documents.medicalCertificates"
                    />
                </div>
                <div class="mb-4">
                    <label for="commitmentOrder" class="block mb-1"
                        >Commitment Order:</label
                    >
                    <input
                        type="checkbox"
                        id="commitmentOrder"
                        v-model="form.documents.commitmentOrder"
                    />
                </div>
                <div class="mb-4">
                    <label for="courtInformation" class="block mb-1"
                        >Court Information:</label
                    >
                    <input
                        type="checkbox"
                        id="courtInformation"
                        v-model="form.documents.courtInformation"
                    />
                </div>
            </fieldset>

            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-md"
            >
                Save
            </button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                client: {
                    name: "",
                    sex: "",
                    address: "",
                    date_of_birth: "",
                    religion: "",
                    occupation: "",
                },
                admission: {
                    committing_court: "",
                    crim_case_number: "",
                    offense_committed: "",
                    date_admitted: "",
                    days_in_jail: "",
                    days_in_detention_center: "",
                    action_taken: "",
                    highest_educ_att: "",
                    school_name: "",
                    class_adviser: "",
                },
                distinguishing_marks: {
                    tattoo_scars: "",
                    height: "",
                    weight: "",
                    colour_of_eye: "",
                    skin: "",
                },
                documents: {
                    scsr: false,
                    courtOrder: false,
                    medicalCertificates: false,
                    commitmentOrder: false,
                    courtInformation: false,
                },
            },
        };
    },
    methods: {
        saveForm() {
            axios
                .post("/api/admission", this.form)
                .then((response) => {
                    console.log("Form saved successfully:", response.data);
                    alert("Form submitted successfully!");
                    this.resetForm();
                })
                .catch((error) => {
                    console.error("Error saving form:", error);
                    let errorMessage =
                        "There was an error submitting the form. Please try again.";
                    if (error.response) {
                        if (
                            error.response.data &&
                            error.response.data.message
                        ) {
                            errorMessage = error.response.data.message;
                        } else if (error.response.statusText) {
                            errorMessage = `${error.response.status} ${error.response.statusText}`;
                        }
                    }
                    alert(errorMessage);
                });
        },
        resetForm() {
            this.form = {
                client: {
                    name: "",
                    sex: "",
                    address: "",
                    date_of_birth: "",
                    religion: "",
                    occupation: "",
                },
                admission: {
                    committing_court: "",
                    crim_case_number: "",
                    offense_committed: "",
                    date_admitted: "",
                    days_in_jail: "",
                    days_in_detention_center: "",
                    general_impression: "",
                    action_taken: "",
                },
                distinguishing_marks: {
                    tattoo_scars: "",
                    height: "",
                    weight: "",
                    colour_of_eye: "",
                    skin: "",
                },
                documents: {
                    scsr: false,
                    courtOrder: false,
                    medicalCertificates: false,
                    consConsent: false,
                    schoolRecords: false,
                    others: false,
                },
            };
        },
    },
};
</script>

<style>
/* Add your styles here */
</style>
