<?php
namespace Pondol\Mailer;

use Illuminate\Http\Request;

use Pondol\Auth\Models\Role\Role;

use Pondol\Mailer\Models\NotificationMessage;

use Pondol\Mailer\Traits\Mailer;
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

  public function dashboard(Request $request) {
    $items = $this->_index($request)->orderBy('id', 'desc')->skip(0)->take(5)->get();
    return view('pondol-mailer::admin.dashboard', ['items'=>$items]);
  }

  public function index(Request $request) {
    $items = $this->_index($request);
    $items = $items->orderBy('id', 'desc')
      ->paginate(20)->appends(request()->query());
      
    return view('pondol-mailer::admin.mailer.index', ['items'=>$items]);
  }

  public function show(NotificationMessage $message, Request $request) {
    $items = $this->_receptionist($message->id);
    $items = $items->orderBy('id', 'desc')
      ->paginate(20)->appends(request()->query());
      
    return view('pondol-mailer::admin.mailer.show', [
      'message'=>$message,
      'items'=>$items
    ]);
  }


  public function create() {
    return view('pondol-mailer::admin.mailer.create', ['roles' => Role::get()]);
  }

  public function store(Request $request) {

    $result = $this->_store($request);
    if($result->error == 'validator') {
      return redirect()->back()->withInput()->withErrors($result->validator->errors());
    }

    return redirect()->route('mailer.admin.index');
  }


}