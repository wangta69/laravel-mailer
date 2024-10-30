<?php
 
namespace Pondol\Mailer\Listeners;
 
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;

use Pondol\Mailer\Models\Notification;
class MailerEventSubscriber
{

  public function __construct()
  {
  }


    public function hanldeMessageSending(MessageSending $event) {
      // \Log::info('MessageSending 11111111111111  =====================================');
      // // \Log::info(json_encode($event));
      // // \Log::info(json_encode($event->data));
      // \Log::info(json_encode($event->data['params']));
      // \Log::info(json_encode($event->data['params']->notify_id));
      Notification::where('id', $event->data['params']->notify_id)->update(['status'=>1]);
    }

    public function hanldeMessageSent(MessageSent $event) {
      \Log::info('MessageSent =====================================');
      // \Log::info(json_encode($event));
    }
 
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
      return [
        MessageSending::class => 'hanldeMessageSending', // queue로 부터 메시지가 보내지기 바로 직전에 이벤트 발생
        MessageSent::class => 'hanldeMessageSent', // queue로 부터 메시지가 발송된 이후의 결과
      ];
    }
}