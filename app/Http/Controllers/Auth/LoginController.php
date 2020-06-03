<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login ControllerThrottlesLogin
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;
    // トレイトを使えるようにしている
    // use AuthenticatesUsers;
    // useがリクワイヤーと一緒の機能とするならばここはAuthenticatesUsersの全てを読み込んでいる
    // loggedOutをオーバーライド（上書き）しているので loggedOutはこちら側で用意したものを使っている

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/todo';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // LoginControllerは認証処理
        // dd($this->middleware('guest'));
        // 何も帰ってこない

        $this->middleware('guest')->except('logout');
        
        // メソッド名が'logout'のもの or 
        // ->except('logout');がないとログアウトできない
        // エクセプトは対象外にする（logoutはミドルウェアの対象外）
        // dd($this->middleware('guest'));
                //#options: & array:1 [▼
                // "except" => array:1 [▼
                //   0 => "logout"
                //   ]
                // ]
    }

    protected function loggedOut(Request $request)
    {
        // sessionの情報を削除したのちloggedOutメソッドが実行される
        return redirect('/login');
    }

    public function maxAttempts()
    {
        return property_exists($this, 'maxAttempts') ? $this->maxAttempts : 3;
    }
}
