<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class ActivityReminder extends Notification
{
    use Queueable;

    public $activity;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($activity)
    {
        $this->activity = $activity;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toSlack($notifiable)
    {
        $activity = $this->activity;
        $mention_users = $activity->assignedUsers->pluck('slack_id')->toArray();
        foreach ($mention_users as $key => $value) {
            $mention_users[$key] = '<@' . $value . '>';
        }
        $mention_users = implode(' ', $mention_users);

        $reminders = $activity->reminders;
        $reminders_block = '';
        foreach ($reminders as $reminder) {
            if($reminder->reminder_date == date('Y-m-d')){
                $reminders_block .= 'Today : ~' . $reminder->reminder_date . "~ \n";
            }else{
                $reminders_block .= 'Upcoming : ' .$reminder->reminder_date . " \n";
            }

        }

        return (new SlackMessage)
            ->from('Activity Reminder', ':robot_face:')
            ->to('#tracker')
            ->content(' :robot_face: Hey! '. $mention_users .' You have to complete the following activity before `' . $activity->first_due_date . '` :')
            ->attachment(function ($attachment) use ($activity, $mention_users, $reminders_block) {
                $attachment->title($activity->name, url('/activities/' . $activity->id))
                    ->fields([
                        'Activity Name' => $activity->name,
                        'Activity Due Date' => '`'. $activity->first_due_date . '`',
                        'Team' => $activity->team->name,
                        'Assigned Users' => $mention_users,
                        'Reminders' => $reminders_block
                    ]);
            });
    }
}
