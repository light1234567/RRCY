<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Existing methods...

    // Fetch all users with complete name, role, email, and status except admins
    public function index()
    {
        $users = User::select(
            \DB::raw("CONCAT(fname, ' ', middlename, ' ', lname) as full_name"),
            'id',
            'role',
            'email',
            'status'
        )->where('role', '<>', 'admin') // Exclude users with 'admin' role
        ->get();

        return response()->json($users);
    }

    // Fetch a single user by ID with complete name, role, email, and status
    public function show($id)
    {
        $user = User::select(
            \DB::raw("CONCAT(fname, ' ', middlename, ' ', lname) as full_name"),
            'id',
            'role',
            'email',
            'status'
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

        $user->status = 'verified';
        $user->save();

        return response()->json(['message' => 'User verified successfully'], 200);
    }
}
