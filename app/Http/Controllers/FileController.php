<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    // Fetch folders and files for a specific client
    public function index($clientId)
    {
        $folders = Folder::with('files')->where('client_id', $clientId)->get();
        $files = File::whereNull('folder_id')->where('client_id', $clientId)->get();

        return response()->json([
            'folders' => $folders,
            'files' => $files,
        ]);
    }

    // Create a new folder for a specific client
    public function createFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id'
        ]);

        Folder::create([
            'name' => $request->name,
            'client_id' => $request->client_id,
        ]);

        return response()->json(['message' => 'Folder created']);
    }

    // Upload a new file for a specific client
    public function uploadFile(Request $request)
{
    $request->validate([
        'pdf' => 'required|mimes:pdf',
        'client_id' => 'required|exists:clients,id'
    ]);

    // Get the original file name
    $originalFilename = $request->file('pdf')->getClientOriginalName();
    
    // Define the file path where the file will be stored, using its original name
    $path = $request->file('pdf')->storeAs('pdfs', $originalFilename, 'public');

    // Save the file details in the database
    File::create([
        'filename' => $path,
        'folder_id' => $request->folder_id, // This is optional
        'client_id' => $request->client_id,
    ]);

    return response()->json(['message' => 'File uploaded', 'filename' => $path]);
}



    // Move a file to another folder for a specific client
    public function moveFile(Request $request)
    {
        $request->validate([
            'fileName' => 'required|string',
            'destinationFolder' => 'required|integer',
            'client_id' => 'required|exists:clients,id'
        ]);

        $file = File::where('filename', $request->fileName)
                    ->where('client_id', $request->client_id)
                    ->first();

        if ($file) {
            $file->update(['folder_id' => $request->destinationFolder]);
            return response()->json(['message' => 'File moved']);
        }

        return response()->json(['error' => 'File not found'], 404);
    }

    // Delete a folder and its files for a specific client
    public function deleteFolder(Request $request)
{
    $request->validate([
        'id' => 'required|integer', // Validation for folder ID
        'client_id' => 'required|exists:clients,id'
    ]);

    $folder = Folder::where('id', $request->id)
                    ->where('client_id', $request->client_id)
                    ->first();

    if ($folder) {
        $folder->delete();
        return response()->json(['message' => 'Folder deleted']);
    }

    return response()->json(['error' => 'Folder not found'], 404);
}

    // Delete a file for a specific client
    public function deleteFile(Request $request)
    {
        $request->validate([
            'fileName' => 'required|string',
            'client_id' => 'required|exists:clients,id'
        ]);

        $file = File::where('filename', $request->fileName)
                    ->where('client_id', $request->client_id)
                    ->first();

        if ($file) {
            Storage::delete($file->filename); // Delete from storage
            $file->delete(); // Delete from DB
            return response()->json(['message' => 'File deleted']);
        }

        return response()->json(['error' => 'File not found'], 404);
    }
}