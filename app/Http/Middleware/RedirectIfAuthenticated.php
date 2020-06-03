<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request,  $next, $guard = null)
    {
        // $dbg = debug_backtrace();
        // dd($dbg);
        // dd('kk');
        // dd($request,$next($request));
        // リクエストインスタンスが帰ってくる
        // Closureインスタンスが帰ってくる
        if (Auth::guard($guard)->check()) {
            // dd($guard);
            // ログイン中にlogin画面へ戻ろうとするとtodoへ飛ばされる
            return redirect('/todo');
        }

        // Illuminate\Http\Response

        // dd($next);
        // Closure($passable)
        return $next($request);
        // 次の処理を実行する
        // Responseのインスタンスが帰ってきている
        // 謎の空のクラスを返している？？？
    }
}
