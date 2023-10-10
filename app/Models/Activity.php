<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Team;
use Carbon\Carbon;
use Cron\CronExpression;
use App\Models\User;
use App\Models\Reminder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class Activity extends Model
{
    use HasFactory, Notifiable;

    public function routeNotificationForSlack($notification)
    {
        return env('SLACK_NOTIFICATION_WEBHOOK_URL');
    }

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

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }

 
}
