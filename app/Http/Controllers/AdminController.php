<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Existing methods...

    // Fetch all users with complete name, role, email, and status except admins
    public function index()
    {
        $users = User::select(
            DB::raw("CONCAT(fname, ' ', middlename, ' ', lname) as full_name"),
            'id',
            'role',
            'email',
            'status',
            'login_at', 
            'logout_at'
        )->where('role', '<>', 'admin') // Exclude users with 'admin' role
        ->get();

        return response()->json($users);
    }

    // Fetch a single user by ID with complete name, role, email, and status
    public function show($id)
    {
        $user = User::select(
            DB::raw("CONCAT(fname, ' ', middlename, ' ', lname) as full_name"),
            'id',
            'role',
            'email',
            'status',
             'login_at', 
            'logout_at'
        )->find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    // Delete a user by ID
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    // Verify a user by updating their status to "verified"
    public function verify($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->status = 'v';
        $user->save();

        return response()->json(['message' => 'User verified successfully'], 200);
    }

    // Add this method to AdminController

public function toggleVerify(Request $request, $id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $user->status = $request->input('status');
    $user->save();

    return response()->json(['message' => 'User status updated successfully'], 200);
}

}
