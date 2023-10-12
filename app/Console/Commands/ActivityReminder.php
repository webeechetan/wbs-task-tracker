<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\Reminder;
use App\Models\User;
use App\Notifications\ActivityReminder as ActivityReminderNotification;
use Carbon\Carbon;

class ActivityReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activity:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder to users for due activities';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $activities = Activity::where('status','=','pending')->get();

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
            $reminders = Reminder::where('activity_id','=',$activity->id)
                        ->whereDate('reminder_date','>=',date('Y-m-d'))
                        ->get();
            foreach ($reminders as $reminder) {
                $reminder_date = Carbon::parse($reminder->reminder_date);
                $reminder_day = $reminder_date->format('d');
                $reminder_month = $reminder_date->format('m');
                if(in_array($reminder_month,$cron_months) && $today == $reminder_day){
                    $activity->notify(new ActivityReminderNotification($activity));
                }
            }
            
        }

        die();

    }

}
