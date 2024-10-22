import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
 
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                
                'resources/js/Pages/Auth/ConfirmPassword.vue',
                'resources/js/Pages/Auth/ForgotPassword.vue',
                'resources/js/Pages/Auth/InputLabel.vue',
                'resources/js/Pages/Auth/Login.vue',
                'resources/js/Pages/Auth/Register.vue',
                'resources/js/Pages/Auth/ResetPassword.vue',
                'resources/js/Pages/Auth/VerifyOtp.vue',

                'resources/js/Pages/Case.vue',
                'resources/js/Pages/AdmissionEdit.vue',
                'resources/js/Pages/CICL.vue',
                'resources/js/Pages/Dashboard.vue',
                'resources/js/Pages/Logs.vue',
                'resources/js/Pages/MainTab.vue',
                'resources/js/Pages/NewClient.vue',
                'resources/js/Pages/User.vue',

                'resources/js/Pages/Tabs/CourtOrderTab.vue',
                'resources/js/Pages/Tabs/EducationalTab.vue',
                'resources/js/Pages/Tabs/HomelifeTab.vue',
                'resources/js/Pages/Tabs/NursingcareTab.vue',
                'resources/js/Pages/Tabs/PSDTab.vue',
                'resources/js/Pages/Tabs/PsychologicalTab.vue',
                'resources/js/Pages/Tabs/SocialServiceTab.vue',

                'resources/js/Pages/Display/Educational/LearnerAcademicForm.vue',
                'resources/js/Pages/Display/Educational/LearnerAssessmentForm.vue',
                'resources/js/Pages/Display/Homelife/ISOAnecdotalForm.vue',
                'resources/js/Pages/Display/Homelife/ISOIncidentForm.vue',
                'resources/js/Pages/Display/Homelife/ISOInventoryForm.vue',
                'resources/js/Pages/Display/Homelife/ISOSessionForm.vue',
                'resources/js/Pages/Display/Homelife/ISOSwappingForm.vue',

                'resources/js/Pages/Display/PSD/IORForm.vue',
                'resources/js/Pages/Display/PSD/TNAQuestionnaire.vue',

                'resources/js/Pages/Display/Psychological/InterventionPlan.vue',
                'resources/js/Pages/Display/Psychological/IPAFORMAT.vue',
                'resources/js/Pages/Display/Psychological/Progressnotes.vue',

                'resources/js/Pages/Display/SocialService/AdmissionContractDisplay.vue',
                'resources/js/Pages/Display/SocialService/AdmissionSlipDisplay.vue',
                'resources/js/Pages/Display/SocialService/ChecklistDisplay.vue',
                'resources/js/Pages/Display/SocialService/DataPrivacyConsentDisplay.vue',
                'resources/js/Pages/Display/SocialService/FirstGeneralIntakeDisplay.vue',
                'resources/js/Pages/Display/SocialService/FirstInterventionPlanDisplay.vue',
                'resources/js/Pages/Display/SocialService/FirstKasabutanDisplay.vue',
                'resources/js/Pages/Display/SocialService/IndicatorsDisplay.vue',
                'resources/js/Pages/Display/SocialService/SecondGeneralIntakeDisplay.vue',
                'resources/js/Pages/Display/SocialService/SecondKasabutanDisplay.vue',
                'resources/js/Pages/Display/SocialService/TalambuhayDisplay.vue',

                'resources/js/Pages/Display/CourtOrder/CourtOrderFiles.vue',

                'resources/js/Pages/Profile/Partials/UpdatePasswordForm.vue',
                'resources/js/Pages/Profile/Partials/UpdateProfileInformationForm.vue',
                'resources/js/Pages/Profile/Show.vue',

                'resources/js/Pages/Display/SocialService/TalambuhayDisplay.vue',
                'resources/js/Pages/Display/SocialService/TalambuhayDisplay.vue',
                'resources/js/Pages/Display/SocialService/TalambuhayDisplay.vue',
                'resources/js/Pages/Display/SocialService/TalambuhayDisplay.vue',

            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});