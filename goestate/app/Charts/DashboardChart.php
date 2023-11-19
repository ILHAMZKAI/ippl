<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Lahan;
use App\Models\Mark;

class DashboardChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($sortBy = 'id', $sortOrder = 'asc'): \ArielMejiaDev\LarapexCharts\AreaChart
    {
        $userId = auth()->id();

        $lahanData = Lahan::where('user_id', $userId)->orderBy($sortBy, $sortOrder)->get();

        $beratData = [];
        $xAxisData = [];

        foreach ($lahanData as $lahan) {
            $markData = Mark::select('berat')->where('idlahan', $lahan->id)->get();
            $beratData[] = $markData->sum('berat');
            $xAxisData[] = "Lahan: $lahan->nama";
        }

        return $this->chart->AreaChart()
            ->setTitle('Total Panen')
            ->addData('Berat', $beratData)
            ->setXAxis($xAxisData);
    }
}