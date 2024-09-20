<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'fname' => ['required', 'string', 'max:20'],
            'lname' => ['required', 'string', 'max:15'],
            'middlename' => ['nullable', 'string', 'max:15'],
            'email' => ['required', 'string', 'email', 'max:30', 'unique:users'],
            'password' => $this->passwordRules(),
            'role' => ['required', 'string', 'in:social services,psychological,court order,homelife services,nursing care,educational services,psd,admin'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'fname' => $input['fname'],
            'lname' => $input['lname'],
            'middlename' => $input['middlename'] ?? null,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => $input['role'], // Save the role to the database
            'status' => 'u', // Set the default status as 'unverified'
        ]);
    }
}
