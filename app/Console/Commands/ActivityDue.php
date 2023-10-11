<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\Reminder;
use App\Models\User;
use App\Models\Team;
use App\Notifications\NewActivityAssigned;

class ActivityDue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activity:due';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for due activities and create new activities for the next due date';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $activities = Activity::all();

        foreach ($activities as $activity) {
            $cron_expression = $activity->cron_expression;
            $cron_days = explode(' ',$cron_expression)[2];
            $cron_days = explode(',',$cron_days);
            $today = date('d');
            $cron_months = explode(' ',$cron_expression)[3];
            if($cron_months != '*'){
                $cron_months = explode(',',$cron_months);
            }else{
                $cron_months = range(1,12);
            }

            $current_month = date('m');

            if(in_array($today,$cron_days) && in_array($current_month,$cron_months)){
                $activity->due();
                $activity->notify(new NewActivityAssigned($activity));
            }
        }
        
        die();

    }

}
