<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class MoveTaskToTomorrow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move-task:tomorrow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move task from today to tomorrow';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tasks = Task::where('status', 'pending')->get();
        foreach ($tasks as $task) {
            $task->update([
                'created_at' => now()->addDay(),
            ]);
            $str = '';
            $str.= $task->id .' Moved to ' . now()->addDay(). ' From ' . $task->created_at; 
            Log::info($str);
        }
    }
}
