<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->user()->isAdmin()) {
            return view('admin/dashboard');
        } else {
            return view('home');
        }
    }

    public function welcome()
    {
      return redirect()->action('MemberController@index');
        return view('welcome');
    }
}
