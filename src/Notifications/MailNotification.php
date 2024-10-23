<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MailNotification extends Notification  implements ShouldQueue
{
  use Queueable;


  protected $title;
  protected $body;
  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($title, $body)
  {
    $this->title = $title;
    $this->body = $body;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {

    \Log::info($this->title);
    \Log::info($this->body);
    \Log::info(json_encode($notifiable));
    return (new MailMessage)->subject('['.config('app.name').'] '.$this->title)->view(
      'mailer.templates.default.notice',
      [
        'notifiable' => $notifiable,
        'body' => $this->body
      ]);

  }


}
