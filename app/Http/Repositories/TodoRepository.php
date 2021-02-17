<?php

namespace App\Http\Repositories;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Task;
use Log;

class TodoRepository {

    public function store($request)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $task = new Task;
            $task->user_id = $user->id;
            $task->name = $request->task;
            $task->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function update($request, $id)
    {
        try {
            DB::beginTransaction();

            $task = Task::find($id);
            $task->name = $request->name;
            $task->done = $request->done;
            $task->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
        return true;
    }

    public function all()
    {
        $user = Auth::user();
        return Task::where('user_id', $user->id)->get();
    }


    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $task = Task::find($id);
            $task->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }


}
