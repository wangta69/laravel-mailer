<?php
namespace Pondol\Mailer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Fluent;

use Pondol\Mailer\Traits\Mailer;
use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use App\Events\Mailed;

use App\Http\Controllers\Controller;
class MailerController extends Controller
{

  use Mailer;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    // $this->middleware('auth');
  }

  public function dashboard() {
    return view('mailer::admin.dashboard');
  }

  public function index(Request $request) {
    $items = $this->_index($request);
    $items = $items->orderBy('id', 'desc')
      ->paginate(20)->appends(request()->query());
      
    return view('mailer::admin.mailer.index', ['items'=>$items]);
  }

  public function create() {
    return view('mailer::admin.mailer.create', ['roles' => Role::get()]);
  }

  public function store(Request $request) {
    $validator = Validator::make($request->all(), [
      'type' => ['required'],
      'to' => ['required'],
      'title' => ['required'],
      'body' => ['required'],
    ], [
      
    ]);


    $validator->sometimes('recv_users', 'required', function (Fluent $input) {
      return $input->to == 'individual';
    });

    $validator->sometimes('role', 'required', function (Fluent $input) {
      \Log::info('input->to2:'.$input->to);
      return $input->to == 'role';
    });

    if ($validator->fails()) {
      // return response()->json(['error'=>$validator->errors()->first()]);
      return redirect()->back()->withInput()->withErrors($validator->errors());
    }

    print_r($request->all());
    // 먼저 내용을 저장
    switch($request->to) {
      case 'all':
        break;
      case 'individual':
        $users = explode(',', $request->recv_users);
        $user = User::whereIn('email', $users)->get();
        break;
      case 'role':
        break;
    }
    
    event(new Mailed($user, $request->title, $request->body));
  }


}