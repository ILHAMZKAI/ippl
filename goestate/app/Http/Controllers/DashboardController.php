<?php

namespace App\Http\Controllers;

use App\Charts\DashboardChart;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, DashboardChart $chart)
    {
        $sortBy = $request->input('sortBy', 'id');
        $sortOrder = $request->input('sortOrder', 'asc');

        $chart = $chart->build($sortBy, $sortOrder);

        return view('pages.dashboard', compact('chart'));
    }
}
