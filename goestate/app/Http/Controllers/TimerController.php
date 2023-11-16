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
                'timer' => 'required|date_format:Y-m-d\TH:i',
            ]);

            if ($validator->fails()) {
                \Log::error('Validation error in saveActionTimer: ' . $validator->errors());
                return response()->json(['error' => $validator->errors()], 422);
            }

            $userId = Auth::id();

            Timer::updateOrCreate(
                [
                    'action' => $request->input('action'),
                    'timer' => $request->input('timer'),
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

    public function checkActionTimer(Request $request)
    {
        $lahanId = $request->input('lahan_id');
        $userId = $request->input('iduser');

        $recordExists = Timer::where('lahan_id', $lahanId)
            ->where('iduser', $userId)
            ->exists();

        return response()->json(['exists' => $recordExists]);
    }

    public function updateActionTimer(Request $request)
    {
        $lahanId = $request->input('lahan_id');
        $userId = $request->input('iduser');
        $selectedAction = $request->input('action');
        $dateTime = $request->input('timer');

        Timer::where('lahan_id', $lahanId)
            ->where('iduser', $userId)
            ->update([
                'action' => $selectedAction,
                'timer' => $dateTime,
            ]);

        return response()->json(['message' => 'Record updated successfully']);
    }

    public function getTimer($lahanId, $userId)
    {
        $timer = Timer::where('lahan_id', $lahanId)
            ->where('iduser', $userId)
            ->first();

        if (!$timer) {
            return response()->json(['error' => 'Timer not found'], 404);
        }

        return response()->json([
            'action' => $timer->action,
            'timer' => $timer->timer,
        ]);
    }
}
