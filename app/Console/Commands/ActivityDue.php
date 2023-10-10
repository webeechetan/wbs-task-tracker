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
        
        // pickup last month activities

        $activities = Activity::where('first_due_date',now()->subMonth()->format('Y-m-d'))->get();

        foreach ($activities as $activity) {
            $activity->due();
        }
    }
}
