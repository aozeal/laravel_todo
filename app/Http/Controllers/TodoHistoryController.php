<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TodoHistory;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


use Log;


class TodoHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $request->validate(['target_date' => 'nullable|date']);

        $target_date = $request->input('target_date');
        if (is_null($request->input('target_date'))){
            $target_date = Carbon::now('Asia/Tokyo')->toDateTimeString();
        }
        $user_id = Auth::id();

        //$histories = TodoHistory::all()->where('user_id', $user_id);
        $results = DB::select("select * from todo_histories as h1 where  h1.updated_at = (
            select MAX(updated_at) from todo_histories as h2
            where h1.todo_id = h2.todo_id
            and h2.updated_at < :updated_at
            and user_id = :user_id)", ['updated_at' => $target_date, 'user_id' => $user_id]);
        $histories = TodoHistory::hydrate($results);

        return view('todo_history/index', compact('histories', 'target_date'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        //
        $request->validate(['target_date' => 'nullable|date']);

        $target_date = $request->input('target_date');
        if(is_null($request->input('target_date'))){
            $target_date = Carbon::now('Asia/Tokyo')->toDateTimeString();
        }
        $user_id = Auth::id();

        $todo = TodoHistory::where('user_id', $user_id)->findOrFail($id);

        return view('todo_history/show', compact('todo', 'target_date'));


    }


}
