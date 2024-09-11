<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Ensure you are importing Auth

class UserController extends Controller
{
    /**
     * Check if the email exists in the database.
     */
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Find the user by email
        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    /**
     * Validate the password for the given email.
     * On successful validation, update login_at timestamp.
     */
    public function validatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if ($user && Hash::check($request->input('password'), $user->password)) {
            // On successful login, update login_at timestamp
            $user->update(['login_at' => now()]);

            // Optional: Log the user in
            Auth::login($user);

            return response()->json(['valid' => true]);
        } else {
            return response()->json(['valid' => false]);
        }
    }

    /**
     * Log out the user and update the logout_at timestamp.
     */
    /**
 * Log out the user and update the logout_at timestamp.
 */
public function logout(Request $request)
{
    $user = Auth::user();  // Get the currently authenticated user

    if ($user) {
        // Update the logout_at timestamp
        $user->logout_at = now();
        $user->save();  // Save the changes to the database

        // Perform the logout
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'User logged out successfully.',
            'logout_at' => $user->logout_at,  // Optionally return the updated logout_at timestamp
        ]);
    }

    return response()->json(['message' => 'No authenticated user found.'], 401);
}




    
}
