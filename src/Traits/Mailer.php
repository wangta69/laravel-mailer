<?php
namespace Pondol\Mailer\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Mailer\NotificationMessage;

trait Mailer
{

  public function _index($request) {
    $sk = $request->sk;
    $sv = $request->sv;
    $from_date = $request->from_date;
    $to_date = $request->to_date;

    $items = NotificationMessage::from('notification_messages as msg')->select(
      'msg.*'
    );

    if ($sv) {
      $items = $items->where($sk, 'like', '%' . $sv . '%');
    }

    if ($from_date) {
      if (!$to_date) {
        $to_date = date("Y-m-d");
      }
      $items = $items->where(function ($q) use($from_date, $to_date) {
        $q->whereRaw("msg.created_at >= '".$from_date." 00:00:00' AND msg.created_at <= '".$to_date." 23:59:59'" );
      });
    }


    return $items;
  }
}