<?php

namespace App\Http\Controllers;

use App\Task;
use App\Http\Services\TodoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Log;

class TodosController extends Controller
{
    private $service = null;

    public function __construct(TodoService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        // Log::debug('インデックスデバッグメッセージ');
        return view('todo');
    }

    public function store(Request $request)
    {
        Log::debug($request);
        $this->service->store($request);
        return '200 OK';
    }

    public function update(Request $request, int $id)
    {
        Log::debug('アップデート：' . $request->done);
        Log::debug('名前は：' . $request->name);
        Log::debug('IDは：' . $id);
        $item = $this->service->update($request, $id);

        if($item) {
            $status = 'success';
        }else{
            $status = 'error';
        }
        return response()->json(['status' => $status]);
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
