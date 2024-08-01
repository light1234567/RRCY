<?php



namespace App\Http\Controllers; // Correct namespace based on your file location

use App\Http\Controllers\Controller; // Import the base controller class
use Illuminate\Http\Request; // Import the Request class for handling HTTP requests
use Illuminate\Support\Facades\Auth; // Import the Auth facade for authentication

class UserController extends Controller
{
    /**
     * Get the role of the authenticated user.
     */
    public function getUserRole(Request $request)
    {
        $user = Auth::user(); // Retrieve the currently authenticated user

        if ($user) {
            return response()->json(['role' => $user->role]); // Return the user's role
        } else {
            return response()->json(['error' => 'Unauthorized'], 401); // Return an error if not authenticated
        }
    }
}
