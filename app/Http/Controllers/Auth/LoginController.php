<?php

namespace App\Http\Controllers\Auth;

use URL;
use Gate;
use Route;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


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
    public function redirectTo()
    {
        if(Gate::allows('isAdmin') || Gate::allows('isModerator')) {
            return '/admin/dashboard';
        } else {
            return '/';
        }
    }

    public $redirectTo = '/';

    //  Added later -------------------------------------------------------------------------------------------


    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {

        $user->last_login = Carbon::now()->toDateTimeString();
        $user->save();

        if ($request->ajax()){

            return response()->json([
                'auth' => auth()->check()
            ]);

        }
    }



    // ------------------------------------------------------------------------------------------------





    public function showLoginForm()
    {

        // if(!session()->has('from')){
        //     session()->put('from', url()->previous());
        // }


        // var_dump(URL::previous());
        // die();
        \JavaScript::put([
            'showLoginFormFromController' => true
        ]);

        return view('home');
    }


    // public function authenticated($request,$user)
    // {

    //     // var_dump($request);
    //     // die();
    //   //  var_dump(session()->pull('from'));
    //     // die();

    //     $redirect = session()->pull('from');
    //     if(Gate::allows('isUser')) {
    //         $redirect = url('/');
    //     }

    //     return redirect();
    // }


    // protected function authenticated($request, $user)
    // {
    //     // if(Route::getRoutes()->match(Request::create(URL::previous()))->getName() == 'home') {
    //     //     return redirect(Request::create(URL::previous())->getRequestUri());
    //     // }

    //     // return redirect()->intended($this->redirectTo);

    //     return $this->authenticated($request, $this->guard()->user())
    //             ?: redirect()->intended($this->redirectTo());

    // }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

   /**
     * Check either username or email.
     * @return string
     */
    public function username()
    {
        $identity  = request()->get('identity');
        $fieldName = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldName => $identity]);
        return $fieldName;
    }

    /**
     * Validate the user login.
     * @param Request $request
     */
    protected function validateLogin(Request $request)
    {
        $this->validate(
            $request,
            [
                'identity' => 'required|string',
                'password' => 'required|string',
            ],
            [
                'identity.required' => 'Username or email is required',
                'password.required' => 'Password is required',
            ]
        );
    }

    /**
     * @param Request $request
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $request->session()->put('login_error', trans('auth.failed'));
        throw ValidationException::withMessages(
            [
                'identity' => [trans('auth.failed')],
            ]
        );
    }

}

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use App\Providers\RouteServiceProvider;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;

// class LoginController extends Controller
// {
//     /*
//     |--------------------------------------------------------------------------
//     | Login Controller
//     |--------------------------------------------------------------------------
//     |
//     | This controller handles authenticating users for the application and
//     | redirecting them to your home screen. The controller uses a trait
//     | to conveniently provide its functionality to your applications.
//     |
//     */

//     use AuthenticatesUsers;

//     /**
//      * Where to redirect users after login.
//      *
//      * @var string
//      */
//     protected $redirectTo = RouteServiceProvider::HOME;

//     /**
//      * Create a new controller instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         $this->middleware('guest')->except('logout');
//     }
// }
