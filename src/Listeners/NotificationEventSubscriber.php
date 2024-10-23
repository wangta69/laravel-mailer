<?php
 
namespace App\Listeners;
 
use App\Events\Mailed;

use Illuminate\Support\Facades\Notification;
use Illuminate\Events\Dispatcher;
use App\Notifications\MailNotification;

class NotificationEventSubscriber
{


  public function __construct()
  {
  }
  

    public function handleMail(Mailed $event) {
      \Log::info('handleMail');
      Notification::send($event->user, new MailNotification($event->title, $event->body));
    }
 
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe(Dispatcher $events)
    {

      return [
        Mailed::class => 'handleMail',
      ];
    }
}