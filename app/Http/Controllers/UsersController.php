<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $data = [
            'name'    => $user->name,
            'email' => $user->email,
        ];
        return view('user', $data);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $me = User::find($user->id);
        $me->name = $request->name;
        $me->save();
        return response()->json(['name' => $me->name]);
    }

}
