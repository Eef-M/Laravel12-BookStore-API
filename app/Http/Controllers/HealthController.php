<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HealthController extends Controller
{
    public function __invoke()
    {
        try {
            DB::connection()->getPdo();

            return response()->json([
                'status' => 'ok',
                'message' => 'Service is healthy',
                'database' => 'connected',
                'timestamp' => now()->toIso8601String(),
            ], 200);

        } catch (\Exception $e) {
            Log::error('Health Check Failed: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Service unavailable',
                'database' => 'disconnected',
            ], 503);
        }
    }
}
