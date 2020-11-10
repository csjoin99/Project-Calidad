<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /* $this->middleware('guest')->except('logout'); */
/*         $this->middleware('guest:admin')->except('logout');
 */    }

    public function showLoginForm()
    {
        session()->put('previous',url()->previous());
        if (Auth::user()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    public function showAdminLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect('admin');
        }
        return view('admin.login');
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            /* dd($request->email); */
            return redirect()->route('admin');
        }                
        return back()->withInput($request->only('email', 'remember'));
    }
}
