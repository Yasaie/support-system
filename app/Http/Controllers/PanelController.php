<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanelController extends Controller
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
		if(Auth::user()->owner() || Auth::user()->admin()){
			//admin and owner panel
			return view('adminHome');
		}elseif(Auth::user()->leader() || Auth::user()->staff()){
			//staff and leader panel
			return view('adminHome');
		}
		//simple user panel
		return view('userHome');
    }
}
