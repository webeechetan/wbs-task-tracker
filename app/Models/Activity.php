<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Team;
use Carbon\Carbon;
use Cron\CronExpression;

class Activity extends Model
{
    use HasFactory;

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function due()
    {
        $new_activity = $this->replicate();
        $first_due_date = Carbon::parse($this->first_due_date)->addMonth();
        $second_due_date = Carbon::parse($this->second_due_date)->addMonth();
        $new_activity->first_due_date = $first_due_date;
        $new_activity->second_due_date = $second_due_date;
        $new_activity->save();
    }

    public function isDue()
    {
        $cron = CronExpression::factory($this->cron_expression);
        return $cron->isDue();
    }
}
