<?php

namespace Pondol\Mailer\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public $params;
  /**
   * @params Object $params = {user, title, body, notify_id}
   */
  public function __construct($params)
  {
    $this->params = $params;
    \Log::info('NotificationMail __construct');
    \Log::info(json_encode($this->params));
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this
      ->subject($this->params->title)
      ->view('mailer.templates.default.notice');
  }

  public function failed($e){
    \Log::info('failed.......................................................');
  }
}
