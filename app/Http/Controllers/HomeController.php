<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Emails;
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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emails = Auth::user()->email()->orderBy('email','ASC')->get();
        return view('dashboard.home',compact('emails'));
    }
}
