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
    public function deleteSelectedCells(Request $request)
    {
        $request->validate([
            'idlahan' => 'required',
            'id_user' => 'required',
            'data_col' => 'required',
            'data_row' => 'required',
        ]);

        Mark::where([
            'idlahan' => $request->input('idlahan'),
            'id_user' => $request->input('id_user'),
            'data_col' => $request->input('data_col'),
            'data_row' => $request->input('data_row'),
        ])->delete();

        return response()->json(['message' => 'Selected cells deleted successfully']);
    }

    public function deleteAllCells(Request $request)
    {
        $idlahan = $request->input('idlahan');
        $id_user = Auth::id();

        Mark::where([
            'idlahan' => $idlahan,
            'id_user' => $id_user,
        ])->delete();

        return response()->json(['message' => 'All cells for the user deleted successfully']);
    }

    public function changeColor($lahanId, $color)
    {
        try {
            info("Received lahanId: $lahanId, color: $color");

            $models = Mark::where('idlahan', $lahanId)->get();

            if ($models->isEmpty()) {
                throw new \Exception("No records found for Lahan with ID $lahanId.");
            }

            foreach ($models as $model) {
                $model->warna = $color;
                $model->save();
            }

            return response()->json(['success' => true, 'message' => 'Color changed successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}