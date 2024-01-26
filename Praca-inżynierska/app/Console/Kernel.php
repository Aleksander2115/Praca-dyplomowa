<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;
use App\Models\User;
use Auth;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        'App\Console\Commands\LeaveQueue'
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $users = User::all();

        foreach ($users as $u) {
            $end_time = Carbon::parse($u->end_time);

            if ($end_time->isCurrentMinute() && $end_time != null){
                $schedule->command('leave:queue')->when($end_time->isCurrentMinute())->withoutOverlapping();
            }
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
