<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\Reminder;
use App\Models\User;
use App\Notifications\ActivityReminder as ActivityReminderNotification;

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
        $activities = Activity::all();

        foreach ($activities as $activity) {
            $reminders = $activity->reminders;
            foreach ($reminders as $reminder) {
                $reminder_date = $reminder->reminder_date;
                $today = date('Y-m-d');
                if($reminder_date == $today){
                    $activity->notify(new ActivityReminderNotification($activity));
                }
            }
        }
    }
}
