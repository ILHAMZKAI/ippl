<?php

namespace App\Console\Commands;

use App\Models\Timer;
use App\Models\Mark;
use Illuminate\Console\Command;

class UpdateMarksColor extends Command
{
    protected $signature = 'update:marks-color';
    protected $description = 'Update the color in the marks table based on timers';

    public function handle()
    {
        try {
            $currentDateTime = now();

            $this->info('Current DateTime: ' . $currentDateTime);

            $timers = Timer::where('timer', '<=', $currentDateTime)->get();

            $this->info('Number of Timers: ' . $timers->count());

            foreach ($timers as $timer) {
                $action = $timer->action;

                $timerInfo = [
                    'id' => $timer->id,
                    'lahan_id' => $timer->lahan_id,
                    'iduser' => $timer->iduser,
                    'action' => $action,
                ];

                $this->info('Processing Timer: ' . json_encode($timerInfo));

                $color = $this->mapActionToColor($action);

                Mark::where('idlahan', $timer->lahan_id)
                    ->where('id_user', $timer->iduser)
                    ->update(['warna' => $color]);

                $timer->delete();

                $this->info('Mark updated successfully.');

                return redirect('/garden-management');
            }

            $this->info('Marks color updated successfully.');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
    private function mapActionToColor($action)
    {
        switch ($action) {
            case 'pemupukan':
                return 'yellow';
            case 'panen':
                return 'green';
            default:
                return 'default_color';
        }
    }
}
