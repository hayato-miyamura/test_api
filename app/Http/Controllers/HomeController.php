<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request) {

        $user = Auth::user();

        $cookie = Cookie::get('name');
        // Cookieの有効期間(1分)
        $minutes = config('const.cookie_limit');

        if (!isset($cookie)) {
            return response()->view('home', compact('user'))->cookie('name', "$user->name", $minutes);
        } else {
            return view('home', compact('user'));
        }

    }
}
