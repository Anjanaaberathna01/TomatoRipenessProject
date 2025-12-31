<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TomatoDiseaseController extends Controller
{
    public function index()
    {
        return view('tomato_disease');
    }

    public function diagnose(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $imagePath = $request->file('image')->store('uploads', 'public');

        $fullPath = storage_path(
            'app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $imagePath)
        );

        if (!file_exists($fullPath)) {
            Log::error('Uploaded file not found', ['path' => $fullPath]);
            return response()->json([
                'status' => 'error',
                'message' => 'Uploaded file not found. Please retry.',
            ], 500);
        }

        $python = "E:\\TomatoRipenessProject\\.venv\\Scripts\\python.exe";

        $leafCheckScript    = "E:\\TomatoRipenessProject\\tomato_ai\\predict_leaf_check.py";
        $diseaseCheckScript = "E:\\TomatoRipenessProject\\tomato_ai\\predict_disease_check.py";
        $diseaseTypeScript  = "E:\\TomatoRipenessProject\\tomato_ai\\predict_disease.py";

        $runScript = static function (string $scriptPath, string $step) use ($python, $fullPath) {
            $cmd = '"' . $python . '" "' . $scriptPath . '" "' . $fullPath . '" 2>NUL';
            $raw = trim(shell_exec($cmd) ?? '');

            $json = '';
            if (preg_match('/\{.*\}/s', $raw, $matches)) {
                $json = $matches[0];
            }

            $parsed = $json ? json_decode($json, true) : null;
            if (!$parsed || ($parsed['status'] ?? '') !== 'success') {
                $snippet = $raw ? substr($raw, 0, 400) : 'no output';
                Log::error($step . ' failed', ['output' => $raw, 'file' => $fullPath]);
                return [null, $step . ' failed. ' . ($parsed['message'] ?? $snippet)];
            }

            return [$parsed, null];
        };

        // Step 0: verify the photo is a tomato leaf
        [$leafResult, $leafError] = $runScript($leafCheckScript, 'Tomato leaf check');
        if ($leafError) {
            return response()->json([
                'status' => 'error',
                'message' => $leafError,
            ], 500);
        }

        if (($leafResult['label'] ?? '') !== 'TOMATO_LEAF') {
            return response()->json([
                'status' => 'error',
                'message' => 'Please upload a tomato leaf photo.',
                'details' => $leafResult,
            ], 422);
        }

        // Step 1: Healthy vs Diseased
        [$checkResult, $checkError] = $runScript($diseaseCheckScript, 'Disease health check');
        if ($checkError) {
            return response()->json([
                'status' => 'error',
                'message' => $checkError,
            ], 500);
        }

        if (strtoupper($checkResult['label'] ?? '') === 'HEALTHY') {
            return response()->json([
                'status' => 'success',
                'result' => [
                    'status' => 'Healthy',
                    'message' => 'The tomato leaf is healthy.',
                ],
            ]);
        }

        // Step 2: Disease type
        [$diseaseResult, $diseaseError] = $runScript($diseaseTypeScript, 'Disease classification');
        if ($diseaseError) {
            return response()->json([
                'status' => 'error',
                'message' => $diseaseError,
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'result' => [
                'status' => 'Diseased',
                'disease' => isset($diseaseResult['disease'])
                    ? ucfirst(str_replace('_', ' ', $diseaseResult['disease']))
                    : 'Unknown',
                'confidence' => $diseaseResult['confidence'] ?? null,
            ],
        ]);
    }
}
