<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use Auth;

class TodoController extends Controller
{
    private $todo;

    public function __construct(Todo $instanceClass)
    {
        $this->middleware('auth');
        // 中にはif文が入っている。ログインしていればページ表示
        // （kernelの中）
        $this->todo = $instanceClass;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = $this->todo->getByUserId(Auth::id());
        // $todos = $this->todo->all();
        $user = \Auth::user();
        return view('todo.index',compact('todos','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // storeの流れ
        // Request classをインスタンス化して$requestに入る（サーバーの情報など全て）
        // リクエストの情報からallすると、なぜかtitleとtokenを取り出せる
        // このclassのtodoに該当する部分に(titleであればtitleに)データを保存する
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $this->todo->fill($input)->save();
        // やってきたページへリダイレクトする
        return redirect()->route('todo.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 編集
        // これもsave()は使うはず
        // 引数&idの中の番号のtitleを編集する
        $todo = $this->todo->find($id);
        // dd($todo,compact('todo'));
        // 配列の形にしている。取り出しやすくなる？
        return view('todo.edit',compact('todo'));
        // 連想配列の形で渡している。なぜ！？
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // アップデート
        // 受け取った値とIDを使いDBへデータを保存する
        $input = $request->all();
        $this->todo->find($id)->fill($input)->save();
        return redirect()->route('todo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $this->todo->find($id)->delete();
        $this->todo->find($id)->delete();
        return redirect()->route('todo.index');
    }
}
