<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'user_id'
    ];
    
    protected $dates = ['deleted_at'];

    public function getByUserId($id)
    {
        return $this->where('user_id', $id)->get();
    }
}

// 登録機能
// GETの形でregisterにアクセス
// Http\Controllers\Auth\RegisterController@showRegistrationFormにはいる
// constructで>middleware('guest')が実行される
// /Users/mizno/testApp2/vendor/laravel/framework/src/Illuminate/Routing/Controller.php
// $mにquestセットしている
// ControllerMiddlewareOptionsをインスタンス化して返す (onlyとexceptメソッドが入っている)
// /Users/mizno/testApp2/vendor/laravel/framework/src/Illuminate/Routing/ControllerMiddlewareOptions.php
//////////////***       middleware('guest')はここまで          ***////////////////////////////////
// middleware('guest')はControllerMiddlewareOptionsをインスタンスを返している
// kernelファイルの$routeMiddlewareの中から('quest')のkeyに一致する'quest' => \App\Http\Middleware\RedirectIfAuthenticated::class,に飛ぶ（useしている？）
// ＊::classはクラスのパスを短く書いている
// RedirectIfAuthenticated
// 
// middleware('guest')が終わったあと、showRegistrationFormに入る
//トレイトしているIlluminate\Foundation\Auth\RegistersUsersで発見
// showRegistrationFormはview('auth.register')を返している
// 'auth.register'ページで登録情報を打ってもらう
// 送信ボタンでPOSTの形でregister(App\Http\Controllers\Auth\RegisterController@register)に入る（trait）

// constructが終わったあとregisterに入る
// /Users/mizno/testApp2/vendor/laravel/framework/src/Illuminate/Foundation/Auth/RegistersUsers.php

// 最初に$this->validator($request->all())->validate()が動く
    // /Users/mizno/testApp2/app/Http/Controllers/Auth/RegisterController.php@validator()
    // Validator::make
    // ここでバリデーションするためにインスタンス化している
    // validate()でバリデーションの実行をしている
    // registerに戻る((RegistersUsers.php)/Users/mizno/testApp2/vendor/laravel/framework/src/Illuminate/Foundation/Auth/RegistersUsers.php)

// event(new Registered($user = $this->create($request->all())));
    // registered classがインスタンス化される
    // registered class = /Users/mizno/testApp2/vendor/laravel/framework/src/Illuminate/Auth/Events/Registered.php

    // app/Providers/EventServiceProvider.phpのprotected $listenに入る
    // SendEmailVerificationNotification::class,
    // ここから飛んで
    // vendor/laravel/framework/src/Illuminate/Auth/Listeners/SendEmailVerificationNotification.php
    // 起爆後の処理が行われる
    // /Users/mizno/testApp2/vendor/laravel/framework/src/Illuminate/Foundation/Auth/RegistersUsers.php

// guardファサードへ飛ぶ
// $this->guard()->login($user);
// (SessionGuard.php)/Users/mizno/testApp2/vendor/laravel/framework/src/Illuminate/Auth/SessionGuard.php
// ガードが終わった後　loginメソッドの実行
// /Users/mizno/testApp2/vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php
// incrementLoginAttempts(）メソッドの実行
// limiter()実行
// /Users/mizno/testApp2/vendor/laravel/framework/src/Illuminate/Cache/RateLimiter.php
// RateLimiterインスタンス化
// hit(）キャッシュ系の何かを行なっている

// $this->updateSession($user->getAuthIdentifier());
// updateSession
    // getName()がメソッドが実行されlogin_name_ (static::classをハッシュ化したものがreturnされる)
    // returnされたものを第一引数、IDを第二引数としてsessionに
// getAuthIdentifier()ログインに必要なものを集めている
// /Users/mizno/testApp2/vendor/laravel/framework/src/Illuminate/Auth/GenericUser.php
// attributes[$name]セットしているが通ってない
// 何らかの条件でログインするための準備をしている
// /Users/mizno/testApp2/vendor/laravel/framework/src/Illuminate/Foundation/Auth/RegistersUsers.php
// return $this->registered($request, $user)?: redirect($this->redirectPath());
// 

// ログイン機能
// loginへgetでアクセス
// App\Http\Controllers\Auth\LoginController@showLoginFormへ飛ぶ
// constructが動く$this->middleware('guest')->except('logout')
// middlewareに'guest'を入れて実行
// exceptに'logout'をセットしている
// /Users/mizno/testApp2/vendor/laravel/framework/src/Illuminate/Routing/Router.php
// authでname 'logout'の記載あり
// post(）メソッドでaddRouteメソッドを使っている

// App\Http\Controllers\Auth\LoginControllerにshowLoginFormがない（トレイト）
// view('auth.login')に飛ぶ
// 名前などが打たれた後にroute('login')へPOSTで飛ぶ
// App\Http\Controllers\Auth\LoginController@login
// constructは不明、traitでIlluminate\Foundation\Authの中のloginが実行
// $this->validateLogin($request)が動く（同じtraitにあり）
// ここで入力があり文字列であるかを確認している
// Illuminate\Foundation\Authの中のloginへ戻る
// ログイン試行をなんどもしていないかを確認する
// なんやかんやログインしている
// 多分ここが重要sendLoginResponse
// redirectPathメソッドが動き
// protected $redirectTo = '/todo';が実行されtodoへ飛ぶ
// ログインができなかった場合guardファサードが動く
// 中

// -----------------------------------
// ログアウト機能
// jsの力でgetからpostの形に直している
// /Users/mizno/testApp2/vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php
// AuthenticatesUsers.phpのlogoutメソッドが実行される
    // guard()メソッドはguardファサードが実行される
    // 
    // $this->guard()->logout()
    
// loggedOuttraitしたログアウトをオーバーライドしリダイレクトでlogin画面に飛ぶ

// -----------------------------------

// authは認証済みか判断して次の処理を行う
// 認証済みでなければ弾く


// guestは認証に関するあらゆる処理をする
// guestは誰でも入ることができる
// インスタンス化をした後に
// 
// register
// 












// 不明点一覧
// 全体的、ファサードってどこにありますか？？
// ログアウト機能
// getの形でlogoutをしているがルートリストにはない
// ログイン機能
// Illuminate\Foundation\Authの中のloginぐちゃぐちゃ
// 登録機能
// middlewareメソッド見つからない
// ::classはインスタンス前のclassを使えるようにしている？
//             もしくはインスタンス化している
// event(new Registered($user = $this->create($request->all())));
// 何かの条件の時データベースへ会員登録をする（create）


// 「認証済み（ログイン済み）の状態でログインページにアクセスすると、ログイン後のトップページにリダイレクトする」処理です
// ログインしていたら、リダイレクトする
// グローバルミドルウェア
// 全ての HTTP リクエストに適用したいミドルウェアは $middleware 配列に登録します。
// ルートミドルウェア
// ルート毎に適用したいミドルウエアは $routeMiddleware 配列にキーと共に登録します。
// ミドルウェアグループ
// １つのキーで複数のミドルウェアの適用をしたい時は $middlewareGroups 配列に登録します。


// interface,implementsについて
// 仕様と実装の分離
// プログラムが大きくなるとどこが何をしているのかわからなくなる
// これを使うことによって未定義のメソッドでエラーを出せるようになる
// 見やすくなる


// 大前提
// middleware authはログイン済みかを調べる
// middleware quest は

// createメソッド
// middlewareメソッド
// 呼び出し元がどこなのか

// laravel middleware
// どういった機能を持っているか
// $next　ミドルウェアの次
// エルビス演算子

// middlewareについて
// LaravelのミドルウェアにはBeforeミドルウェアとAfterミドルウェアがある
// エンドユーザの操作にて発生したHTTPリクエストは、ルーティングを通りコントローラに行く前にまずはBeforeミドルウェアによって処理が行われます。
// 今回はコントローラーのコンストラクタで実行している



// ""middleware""
// ルートとコントローラーの間にあるもの
// 複数のコントローラーに対して事前、事後にやっておきたい処理を当てることができる
// ルートリストを変更することなく処理を追加することができる
// ルートにmiddlewareを設定する場合とコントローラーにmiddlewareを設定する使い分けが分からん

// $nextの処理の内容に関して
// after beforeでnextの使い方が変わる

// before after　について
// リクエストがルーターで仕分けられる
// コンストラクタへ進む
// ミドルウェア実行
// ハンドルメソッドが動く
// "ミドルウェアがリクエストの前、後に実行されるかは、そのミドルウェアの組み方により決まります。"

// public function handle($request, Closure $next)　　　// before middleware //
// {
//     // アクションを実行…

//     return $next($request);
// }
// 問題がなければ次の処理へ進む
// コントローラーの中の処理へ進む

// public function handle($request, Closure $next)      // after middleware //
// {
    // $response = $next($request);       // $nextは次の処理をしている

    // アクションを実行…                 //認証をしている
                                          //その結果を返している
//     return $response;
// }

// ページの表示


// middleware('auth');
// dd('sldkfj');

// public function handle($request, Closure $next)     // before middleware //
// {
//     dd('alksdfj');
//     アクションを実行…
// 
//     return $next($request);
// }


// handleの中で処理が終わっているんじゃないか説