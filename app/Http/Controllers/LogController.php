<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of all logs.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Fetch all logs from the database
            $logs = Log::all();

            // Return the logs as a JSON response
            return response()->json([
                'status' => 'success',
                'data' => $logs
            ], 200);
        } catch (\Exception $e) {
            // Return an error response if something goes wrong
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a specific log entry.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            // Find the log entry by ID
            $log = Log::findOrFail($id);

            // Return the log as a JSON response
            return response()->json([
                'status' => 'success',
                'data' => $log
            ], 200);
        } catch (\Exception $e) {
            // Return an error response if something goes wrong
            return response()->json([
                'status' => 'error',
                'message' => 'Log not found'
            ], 404);
        }
    }

    /**
     * Store a newly created log entry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'model' => 'required|string',
                'record_id' => 'required|integer',
                'action' => 'required|string',
                'changes' => 'nullable|string',
                'updated_by' => 'required|string',
                'client_full_name' => 'nullable|string',
                'user_role' => 'nullable|string',
            ]);

            // Create a new log entry
            $log = Log::create($validatedData);

            // Return a success response
            return response()->json([
                'status' => 'success',
                'data' => $log
            ], 201);
        } catch (\Exception $e) {
            // Return an error response if something goes wrong
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
