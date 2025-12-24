<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TomatoController extends Controller
{
    public function analyze(Request $request)
    {
        // -----------------------------
        // Validate uploaded image
        // -----------------------------
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // -----------------------------
        // Save uploaded file
        // -----------------------------
        $file = $request->file('image');
        $uploadsDir = storage_path('app/uploads');

        if (!file_exists($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }

        $filename = time() . '_' . $file->getClientOriginalName();
        $imagePath = $file->move($uploadsDir, $filename)->getRealPath();

        if (!$imagePath || !file_exists($imagePath)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Uploaded image file not found on server',
            ]);
        }

        // -----------------------------
        // Python paths
        // -----------------------------
        $pythonPath = "E:/TomatoRipenessProject/.venv/Scripts/python.exe";

        $tomatoDetectScript = "E:/TomatoRipenessProject/tomato_ai/predict.py";
        $ripenessScript     = "E:/TomatoRipenessProject/tomato_ai/predict_ripeness.py";

        // -----------------------------
        // STEP 1: Tomato detection
        // -----------------------------
        $cmdDetect = escapeshellarg($pythonPath) . ' ' .
                     escapeshellarg($tomatoDetectScript) . ' ' .
                     escapeshellarg($imagePath);

        $detectOutput = trim(shell_exec($cmdDetect));
        $detectResult = json_decode($detectOutput, true);

        if (!$detectResult || $detectResult['status'] !== 'success') {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to detect tomato',
                'debug' => $detectOutput
            ]);
        }

        $label = $detectResult['result']['label'] ?? 'UNKNOWN';

        if ($label !== 'TOMATO') {
            return response()->json([
                'status' => 'error',
                'message' => 'This image is not a tomato',
                'result' => $detectResult
            ]);
        }

        // -----------------------------
        // STEP 2: Ripeness detection
        // -----------------------------
        $cmdRipeness = escapeshellarg($pythonPath) . ' ' .
                       escapeshellarg($ripenessScript) . ' ' .
                       escapeshellarg($imagePath);

        $ripenessOutput = trim(shell_exec($cmdRipeness));
        $ripenessResult = json_decode($ripenessOutput, true);

        // DEBUG: Log the raw output
        if (!$ripenessResult || $ripenessResult['status'] !== 'success') {
            \Log::error('Ripeness prediction failed', [
                'output' => $ripenessOutput,
                'json_error' => json_last_error_msg()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to detect ripeness',
                'debug' => $ripenessOutput
            ]);
        }

        // -----------------------------
        // Interpret ripeness result
        // -----------------------------
        $stage = strtolower($ripenessResult['stage'] ?? 'unknown');

        switch ($stage) {
            case 'unripe':
                $message = 'Tomato is unripe. Wait about 4 days.';
                $days = 4;
                break;

            case 'old':
                $message = 'Tomato is turning. Use within 1–2 days.';
                $days = 0;
                break;

            case 'ripe':
                $message = 'Tomato is ripe and ready to eat.';
                $days = 1;
                break;

            default:
                $message = 'Unable to determine tomato ripeness.';
                $days = null;
        }

        // -----------------------------
        // FINAL RESPONSE
        // -----------------------------
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'tomato' => [
                'detected' => true,
                'confidence' => $detectResult['result']['confidence'] ?? null
            ],
            'ripeness' => [
                'stage' => strtoupper($stage),
                'days_to_ripe' => $days,
                'confidence' => $ripenessResult['confidence'] ?? null
            ]
        ]);
    }
}
