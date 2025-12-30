<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TomatoDiseaseController extends Controller
{
    public function index()
    {
        return view('tomato_disease');
    }

    public function diagnose(Request $request)
    {
        // -----------------------------
        // Validate image
        // -----------------------------
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // -----------------------------
        // Save image
        // -----------------------------
        // Save image to public disk, not default local (which goes to private/)
        $imagePath = $request->file('image')
            ->store('uploads', 'public');

        // Build path directly: storage/app/public/uploads/filename
        $fullPath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $imagePath));

        if (!file_exists($fullPath)) {
            return back()->withErrors('Uploaded file not found at: ' . $fullPath);
        }

        // -----------------------------
        // Python config
        // -----------------------------
        $python = "E:\\TomatoRipenessProject\\.venv\\Scripts\\python.exe";

        $diseaseCheckScript = "E:\\TomatoRipenessProject\\tomato_ai\\predict_disease_check.py";
        $diseaseTypeScript  = "E:\\TomatoRipenessProject\\tomato_ai\\predict_disease.py";

        // -----------------------------
        // STEP 1: Healthy vs Diseased
        // -----------------------------
        $cmdCheck = '"' . $python . '" "' . $diseaseCheckScript . '" "' . $fullPath . '" 2>NUL';

        $outputCheck = trim(shell_exec($cmdCheck) ?? '');
        // Extract JSON object from mixed STDERR/STDOUT to be robust
        $jsonCheck = '';
        if (preg_match('/\{.*\}/s', $outputCheck, $m)) {
            $jsonCheck = $m[0];
        }
        $checkResult = $jsonCheck ? json_decode($jsonCheck, true) : null;

        if (!$checkResult || $checkResult['status'] !== 'success') {
            $snippet = $outputCheck ? substr($outputCheck, 0, 400) : 'no output';
            \Log::error('Disease check failed', ['output' => $outputCheck, 'file' => $fullPath]);
            return back()->withErrors('Disease check failed. Error: ' . ($checkResult['message'] ?? $snippet));
        }

        if ($checkResult['label'] === 'HEALTHY') {
            return back()->with('result', [
                'status' => 'Healthy',
                'message' => 'The tomato leaf is healthy 🌱'
            ]);
        }

        // -----------------------------
        // STEP 2: Disease type
        // -----------------------------
        $cmdDisease = '"' . $python . '" "' . $diseaseTypeScript . '" "' . $fullPath . '" 2>NUL';

        $outputDisease = trim(shell_exec($cmdDisease) ?? '');
        $jsonDisease = '';
        if (preg_match('/\{.*\}/s', $outputDisease, $m2)) {
            $jsonDisease = $m2[0];
        }
        $diseaseResult = $jsonDisease ? json_decode($jsonDisease, true) : null;

        if (!$diseaseResult || $diseaseResult['status'] !== 'success') {
            $snippet = $outputDisease ? substr($outputDisease, 0, 400) : 'no output';
            \Log::error('Disease classification failed', ['output' => $outputDisease, 'file' => $fullPath]);
            return back()->withErrors('Disease classification failed. Error: ' . ($diseaseResult['message'] ?? $snippet));
        }

        return back()->with('result', [
            'status' => 'Diseased',
            'disease' => ucfirst(str_replace('_', ' ', $diseaseResult['disease'])),
            'confidence' => round($diseaseResult['confidence'] * 100, 2)
        ]);
    }
}
