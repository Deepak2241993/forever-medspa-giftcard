<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function uploadMultipleImages(Request $request)
    {
        $request->validate([
            'images.*' => 'required|mimes:jpg,jpeg,png|max:1024', // Validate each image
        ]);
    
        $uploadedFiles = [];
    
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Generate a unique filename
                $fileName = $file->getClientOriginalName();
                // Store the image in the 'images' directory in the 'public' disk
                $filePath = $file->storeAs('images', $fileName, 'public');
    
                // Store the file paths to return as a response
                $uploadedFiles[] = Storage::url($filePath);
            }
    
            return response()->json([
                'message' => 'Images uploaded successfully!',
                'files' => $uploadedFiles
            ]);
        }
    
        return response()->json(['message' => 'No images uploaded'], 400);
    }
}
