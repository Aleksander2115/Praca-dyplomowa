<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\User;

class LeaveQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Leave queue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $u) {
            $end_time = Carbon::parse($u->end_time);

            if ($end_time->isCurrentMinute() && $end_time != null){
                $u->update([
                    'sign_up_time' => null,
                    'start_time' => null,
                    'end_time' => null
                ]);

                $u->charging_point()->dissociate();
                $u->save();
            }
        }
    }
}
