<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('guest')->except('logout');
    }


    public function redirectToGoogle() {

        return Socialite::driver('google')->redirect();
    }


    public function googleCallback() {

        // ユーザー情報をグーグルから取得
        $googleUserInfo = Socialite::driver('google')->stateless()->user();

        // emailで登録をしているか調べる
        $user = User::where('email', $googleUserInfo->email)->first();

        if (is_null($user)) {
            $user = $this->createUserFromGoogle($googleUserInfo);
        }

        \Auth::login($user, true);

        return redirect('/home');
    }


    public function createUserFromGoogle($googleUserInfo) {

        $user = User::create([
            'name'     => $googleUserInfo->name,
            'email'    => $googleUserInfo->email,
            'password' => \Hash::make(uniqid()),
        ]);

        return $user;
    }


    // ログアウト時にログイン画面にリダイレクト。
    protected function loggedOut(Request $request) {

        return redirect('/login');
    }
}
