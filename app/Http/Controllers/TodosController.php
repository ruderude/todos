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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $res = $this->service->store($request);
        Log::debug('$resは：' . $res);
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
        //
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
        $res = $this->service->update($request, $id);
        Log::debug('$resは：' . $res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function all()
    {
        $todos = $this->service->all();
        return response()->json(['todos' => $todos]);
    }
}
