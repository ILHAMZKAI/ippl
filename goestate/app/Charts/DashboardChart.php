<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Mark;
use App\Models\Timer;

class DashboardChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\AreaChart
    {
        $userId = auth()->id();

        $marksData = Mark::where('id_user', $userId)->orderBy('idlahan')->get();
        $timerData = Timer::where('iduser', $userId)->orderBy('lahan_id')->pluck('timer')->toArray();

        $beratData = [];
        $xAxisData = [];

        $groupedMarks = $marksData->groupBy('idlahan');
        $totalBerat = $groupedMarks->map(function ($group) {
            return $group->sum('berat');
        });

        foreach ($totalBerat as $idlahan => $total) {
            $beratData[] = $total;
            $xAxisData[] = "ID Lahan: $idlahan";
        }

        return $this->chart->AreaChart()
            ->setTitle('Total panen lahan')
            ->addData('Total panen', $beratData)
            ->setXAxis($xAxisData);
    }
}
