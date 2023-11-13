<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Timer;
use Illuminate\Support\Facades\Validator;

class TimerController extends Controller
{
    public function saveActionTimer(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'lahan_id' => 'required|numeric',
                'action' => 'required|string',
                'date_time' => 'required|date_format:Y-m-d\TH:i',
            ]);

            if ($validator->fails()) {
                \Log::error('Validation error in saveActionTimer: ' . $validator->errors());
                return response()->json(['error' => $validator->errors()], 422);
            }

            $userId = Auth::id();

            Timer::updateOrCreate(
                [
                    'action' => $request->input('action'),
                    'timer' => $request->input('date_time'),
                    'lahan_id' => $request->input('lahan_id'),
                    'iduser' => $userId,
                ]
            );

            \Log::info('Action and Timer saved successfully.');
            return response()->json(['message' => 'Action and Timer saved successfully']);
        } catch (\Exception $e) {
            \Log::error('Error in saveActionTimer: ' . $e->getMessage());

            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

}
