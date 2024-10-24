<?php
namespace Pondol\Mailer\Traits;

// use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\Mail; // Mail 퍼사드 호출
use Pondol\Mailer\Models\Notification;
use Pondol\Mailer\Models\NotificationMessage;
use App\Models\Auth\User\User;
use App\Events\Mailed;
use Pondol\Mailer\Mail\NotificationMail;

trait Mailer
{

  private function _index($request) {
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

  private function _store($request) {
    $obj = new \stdClass;
    $validator = Validator::make($request->all(), [
      // 'type' => ['required'],
      'to' => ['required'],
      'title' => ['required'],
      'body' => ['required'],
    ], [
      
    ]);

    $validator->sometimes('recv_users', 'required', function (Fluent $input) {
      return $input->to == 'individual' || $input->to == 'guest';
    });

    $validator->sometimes('role', 'required', function (Fluent $input) {
      return $input->to == 'role';
    });

    $validator->sometimes('csv', 'required', function (Fluent $input) {
      return $input->to == 'csv';
    });


    if ($validator->fails()) {
      $obj->error = 'validator';
      $obj->validator = $validator;
      return $obj;
    }


    // 먼저 내용을 저장
    switch($request->to) {
      case 'all':
        $user = User::get();
        break;
      case 'individual':
        $users = explode(',', $request->recv_users);
        $user = User::whereIn('email', $users)->get();
        break;
      case 'role':
        $user = User::select('users.*')
              ->Join('user_roles', function($join)
              {
                $join->on('user_roles.user_id', '=', 'users.id');
              })
              ->where('user_roles.role_id', $request->role)->get();
        break;
      case 'guest':
        $users = array_map('trim', explode(',', $request->recv_users));
        $user = [];
         foreach($users as $u) {
          $obj = (object)[
            'email' => trim($u),
            'name' => '',
          ];
          array_push($user, $obj);
        }
        break;
      case 'csv':
        $file = $request->file('csv');
        $fileContents = file($file->getPathname());
        $user = [];
        foreach ($fileContents as $line) {
          $data = str_getcsv($line);
          
          $obj = (object)[
            'email' => $data[0],
            'name' => $data[1],
          ];
          array_push($user, $obj);
        }
        break;
    }
    
    // event(new Mailed($user, $request->title, $request->body));
    
    $notification_id = $this->createNotificationMessage($request);

    foreach($user as $u) {
      Mail::to($u)->queue(new NotificationMail($u, $request->title, $request->body));
      $this->createNotifications($notification_id, $u);
    }

    $obj->error = false;
    return $obj;
  }

  private function createNotificationMessage($request) {
    $message = new NotificationMessage;
    $message->title = $request->title;
    $message->body = $request->body;
    $message->type = 'mail';
    $message->save();
    return $message->id;
  }

  private function createNotifications($notification_id, $user) {
    $notify = new Notification;
    $notify->notification_id = $notification_id;
    $notify->user_id = isset($user->id) ? $user->id : null;
    $notify->email = $user->email;
    $notify->name = $user->name;
    $notify->save();
  }
}