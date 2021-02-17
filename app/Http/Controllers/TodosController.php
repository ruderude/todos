<?php

namespace App\Http\Controllers;

use App\Task;
use App\Http\Services\TodoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

class TodosController extends Controller
{
    private $service = null;

    public function __construct(TodoService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Log::debug('インデックスデバッグメッセージ');
        return view('todo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::debug($request);
        $this->service->store($request);
        return '200 OK';
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
        Log::debug('アップデート：' . $request->done);
        Log::debug('名前は：' . $request->name);
        Log::debug('IDは：' . $id);
        $this->service->update($request, $id);
        return '200 OK';
    }

    public function delete($id)
    {
        $this->service->delete($id);
        return '消去 OK';
    }

    public function all()
    {
        $todos = $this->service->all();
        return response()->json(['todos' => $todos]);
    }

}
