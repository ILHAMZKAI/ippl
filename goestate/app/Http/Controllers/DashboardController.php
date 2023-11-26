<?php

namespace App\Http\Controllers;

use App\Charts\DashboardChart;

use Illuminate\Http\Request;

class DashboardController extends Controller {
    public function index(Request $request, DashboardChart $chart) {
        $sortBy = $request->input('sortBy', 'id');
        $sortOrder = $request->input('sortOrder', 'asc');

        if($sortBy === 'id') {
            $chart = $chart->buildByIdAsc($sortOrder);
        } elseif($sortBy === 'berat') {
            $chart = $chart->buildByBerat($sortOrder);
        }

        return view('pages.dashboard', compact('chart', 'sortBy', 'sortOrder'));
    }

}
