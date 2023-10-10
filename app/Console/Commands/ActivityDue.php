<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Activity;

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

        // $activities = Activity::All();

        $activities = Activity::whereDate('first_due_date', '=', now()->toDateString())
        ->groupB('id', 'desc')
        ->limit(1)
        ->first();
    
        $cron_date = ($activities->cron_expression);

        $cron_date_array = explode(' ', $cron_date);

        $cron_day = $cron_date_array[2];
        $cron_month = $cron_date_array[3];

        dd($cron_date_array);
         

        // pickup last month activities and create new activities for this month
        $activities = Activity::where('first_due_date', '<=', now()->subMonth())
                        ->groupBy('name')
                        ->orderBy('id', 'desc')
                        ->get();

       


        foreach ($activities as $activity) {
            $activity->due();
        }
    }

    

        public function scheduleAction(Request $request) 
        {

            $activity = new Activity();
            $activity->team_id = $team;
            $activity->name = $request->activity;
            $activity->first_due_date = $request->first_due_date;
            $activity->created_by = auth()->user()->id;
            

        }
}
