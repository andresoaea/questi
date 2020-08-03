<?php

namespace App\Http\Controllers;

use App\User;
use App\Question;
use App\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        \JavaScript::put([
            // 'currentUser'   => Auth:: check() ? Auth::user()->makeHidden(['email', 'created_at', 'updated_at']) : false,
             'isHome'        => true
         ]);

        return view('home');
    }


}
