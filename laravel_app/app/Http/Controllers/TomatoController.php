<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TomatoController extends Controller
{
    public function analyze(Request $request)
    {
        // Validate uploaded image
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // -----------------------------
        // Save uploaded file
        // -----------------------------
        $file = $request->file('image');
        $uploadsDir = storage_path('app/uploads');

        // Create uploads folder if it doesn't exist
        if (!file_exists($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }

        $filename = time() . '_' . $file->getClientOriginalName();

        // Move file and get absolute path
        $imagePath = $file->move($uploadsDir, $filename)->getRealPath();

        // Check if file exists
        if (!$imagePath || !file_exists($imagePath)) {
            return response()->json([
                'status' => 'error',
                'message' => "Uploaded image file not found at: $imagePath",
                'result' => null
            ]);
        }

        // -----------------------------
        // Python command
        // -----------------------------
        $pythonPath = "E:/TomatoRipenessProject/.venv/Scripts/python.exe";
        $scriptPath = "E:/TomatoRipenessProject/tomato_ai/predict.py";

        $command = escapeshellarg($pythonPath) . ' ' .
                   escapeshellarg($scriptPath) . ' ' .
                   escapeshellarg($imagePath);

        // Execute Python script
        $output = trim(shell_exec($command));

        // Decode JSON response from Python
        $result = json_decode($output, true);

        if (!$result || $result['status'] === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $result['message'] ?? 'Failed to analyze image',
                'result' => $output
            ]);
        }

        // Check prediction label
        $label = $result['result']['label'] ?? 'UNKNOWN';

        if ($label === 'NOT_TOMATO' || $label === 'UNCERTAIN') {
            return response()->json([
                'status' => 'error',
                'message' => 'This image is not a tomato',
                'result' => $result
            ]);
        }

        // Tomato detected
        return response()->json([
            'status' => 'success',
            'message' => 'Tomato detected',
            'result' => $result
        ]);
    }
}