<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Support\Facades\Log;

class NewActivityAssigned extends Notification
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
        $reminders_block = '';
        foreach ($this->activity->reminders as $reminder) {
            $reminders_block .= 'Reminder: ' . $reminder->reminder_date . "\n";
        }



        return (new SlackMessage)
                    ->from('Ghost', ':ghost:')
                    ->to('#tracker')
                    ->success()
                    ->content('A new activity has been assigned to you!')
                    ->attachment(function ($attachment) {
                        $attachment->title($this->activity->name, url('/activity/' . $this->activity->id))
                            ->fields([
                                'Team' => $this->activity->team->name,
                                'Due Date' => $this->activity->first_due_date,
                                'Assigned To' => $this->activity->assignedUsers->pluck('name')->implode(', ')
                            ]);


                    })
                    ->attachment(function ($attachment) use ($reminders_block) {
                        $attachment->title('Reminders')
                            ->content($reminders_block)
                            ->footer('Sheduled On: ' . $this->activity->cron_string);
                    });

    }
}
