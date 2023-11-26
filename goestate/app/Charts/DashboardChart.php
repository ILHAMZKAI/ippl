<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Lahan;
use App\Models\Mark;

class DashboardChart {
    protected $chart;

    public function __construct(LarapexChart $chart) {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\AreaChart {
        $userId = auth()->id();

        $lahanData = Lahan::select('datalahan.*')
            ->join('marks', 'datalahan.id', '=', 'marks.idlahan')
            ->where('datalahan.user_id', $userId)
            ->orderBy('datalahan.id', 'asc')
            ->distinct()
            ->get();

        $beratData = [];
        $xAxisData = [];

        foreach($lahanData as $lahan) {
            $totalWeight = Mark::where('idlahan', $lahan->id)->sum('berat');

            $beratData[] = $totalWeight;
            $xAxisData[] = "Lahan: $lahan->nama";
        }

        return $this->chart->AreaChart()
            ->setTitle('Total Panen')
            ->addData('Berat', $beratData)
            ->setXAxis($xAxisData);
    }
    public function buildByIdAsc($sortOrder = 'asc'): \ArielMejiaDev\LarapexCharts\AreaChart {
        $userId = auth()->id();

        $lahanData = Lahan::select('datalahan.*')
            ->join('marks', 'datalahan.id', '=', 'marks.idlahan')
            ->where('datalahan.user_id', $userId)
            ->distinct();

        if($sortOrder === 'asc') {
            $lahanData->orderBy('datalahan.id', 'asc');
        } else {
            $lahanData->orderBy('datalahan.id', 'desc');
        }

        $lahanData = $lahanData->get();

        $beratData = [];
        $xAxisData = [];

        foreach($lahanData as $lahan) {
            $totalWeight = Mark::where('idlahan', $lahan->id)->sum('berat');

            $beratData[] = $totalWeight;
            $xAxisData[] = "Lahan: $lahan->nama";
        }

        return $this->chart->AreaChart()
            ->setTitle('Total Panen')
            ->addData('Berat', $beratData)
            ->setXAxis($xAxisData);
    }
    public function buildByBerat($sortOrder = 'asc'): \ArielMejiaDev\LarapexCharts\AreaChart {
        $userId = auth()->id();

        $sortOrder = ($sortOrder === 'asc') ? 'asc' : 'desc';

        $lahanData = Lahan::select('datalahan.*')
            ->join('marks', 'datalahan.id', '=', 'marks.idlahan')
            ->where('datalahan.user_id', $userId)
            ->distinct()
            ->get();

        $beratData = [];
        $xAxisData = [];

        foreach($lahanData as $lahan) {
            $totalWeight = Mark::where('idlahan', $lahan->id)->sum('berat');

            $beratData[] = $totalWeight;
            $xAxisData[] = "Lahan: $lahan->nama";
        }

        if($sortOrder === 'asc') {
            asort($beratData);
        } else {
            arsort($beratData);
        }

        $sortedBeratData = array_values($beratData);

        return $this->chart->AreaChart()
            ->setTitle('Total Panen')
            ->addData('Berat', $sortedBeratData)
            ->setXAxis($xAxisData);
    }
}
