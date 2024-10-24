<?php
namespace Pondol\Mailer;

use Illuminate\Http\Request;

use App\Models\Auth\Role\Role;
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

    $result = $this->_store($request);
    if($result->error == 'validator') {
      return redirect()->back()->withInput()->withErrors($result->validator->errors());
    }
  }


}