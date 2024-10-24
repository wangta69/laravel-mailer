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
  public $user;
  public $title;
  public $body;
  public function __construct($user, $title, $body)
  {

    \Log::info('__construct NotificationMail');

    
    $this->user = $user;
    $this->title = $title;
    $this->body = $body;

    \Log::info($this->user->email);
    \Log::info($this->title);
    \Log::info($this->body);
    //
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {

    \Log::info('build========================================');
    return $this
      ->subject($this->title)
      ->view('mailer.templates.default.notice');
  }
}
