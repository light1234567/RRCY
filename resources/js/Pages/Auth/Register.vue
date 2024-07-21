<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
    role: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />

    <div class="flex min-h-screen">
        <!-- Left side content -->
        <div class="w-1/2 p-4">
            <div class="grid grid-cols-1 gap-4">
                <img src="/path-to-your-image1.png" alt="Image 1" class="w-full h-auto object-cover">
                <div class="bg-white p-4 shadow rounded">
                    <p class="text-xl font-semibold">A characteristic of the normal child is he doesn't act that way very often.</p>
                    <p class="mt-2">- Anonymous</p>
                </div>
                <img src="/path-to-your-image2.png" alt="Image 2" class="w-full h-auto object-cover">
                <img src="/path-to-your-image3.png" alt="Image 3" class="w-full h-auto object-cover">
            </div>
        </div>

        <!-- Right side form -->
        <div class="w-1/2 bg-gray-100 flex items-center justify-center p-8">
            <div class="w-full max-w-lg bg-white p-8 shadow-lg rounded-lg">
                <AuthenticationCard>
                    <template #logo>
                        <AuthenticationCardLogo />
                    </template>

                    <form @submit.prevent="submit">
                        <h2 class="text-center text-2xl font-bold mb-6">Create an Account</h2>

                        <div>
                            <InputLabel for="name" value="Name" />
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                                autocomplete="name"
                            />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="email" value="Email" />
                            <TextInput
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="mt-1 block w-full"
                                required
                                autocomplete="username"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="password" value="Password" />
                            <TextInput
                                id="password"
                                v-model="form.password"
                                type="password"
                                class="mt-1 block w-full"
                                required
                                autocomplete="new-password"
                            />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="password_confirmation" value="Confirm Password" />
                            <TextInput
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                                required
                                autocomplete="new-password"
                            />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="role" value="Role" />
                            
                            <select
                                id="role"
                                v-model="form.role"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring focus:ring-opacity-50"
                                required
                                
                            >
                                <option value="" disabled>Select Role</option>
                                <option value="admin">Social Service</option>
                                <option value="user">Psychology</option>
                                <option value="user">Court</option>
                                <option value="user">Homelife</option>
                                <option value="user">Nursing Care</option>
                                <option value="user">Educational Service</option>
                                <option value="user">PSD</option>
                                
                            </select>
                            <InputError class="mt-2" :message="form.errors.role" />
                        </div>

                        <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                            <InputLabel for="terms">
                                <div class="flex items-center">
                                    <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />
                                    <div class="ml-2">
                                        I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                                    </div>
                                </div>
                                <InputError class="mt-2" :message="form.errors.terms" />
                            </InputLabel>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                                Already registered?
                            </Link>
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Sign up
                            </PrimaryButton>
                        </div>
                    </form>
                </AuthenticationCard>
            </div>
        </div>
    </div>
</template>
