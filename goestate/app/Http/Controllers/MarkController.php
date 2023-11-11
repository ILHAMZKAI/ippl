<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mark;
use Illuminate\Support\Facades\Auth;

class MarkController extends Controller
{
    public function saveSelectedCells(Request $request)
    {
        try {
            $selectedCells = $request->input('selectedCells');

            if (!empty($selectedCells)) {
                $user = Auth::user();

                foreach ($selectedCells as $cellData) {
                    Mark::create([
                        'idlahan' => $cellData['idlahan'],
                        'id_user' => $user->id,
                        'data_col' => $cellData['data_col'],
                        'data_row' => $cellData['data_row'],
                        'warna' => $cellData['warna'],
                    ]);
                }

                return response()->json(['message' => 'Data saved successfully']);
            } else {
                return response()->json(['error' => 'Selected cells data is empty'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage()], 500);
        }
    }
    public function getMarksData($idLahan)
    {
        $marksData = Mark::where('idlahan', $idLahan)->get();

        if ($marksData->isNotEmpty()) {

            return response()->json($marksData);
        } else {
            return response()->json([
                'error' => 'Data not found',
            ], 404);
        }
    }
}
