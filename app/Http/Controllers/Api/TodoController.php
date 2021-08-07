<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Log;

class TodoController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Log::error('destroy was called');
        //
        $user_id = Auth::id();

        Log::error($user_id);

//        $todo = Todo::where('user_id', $user_id)->findOrFail($id)->delete();
//        $todo->delete();
        Todo::where('user_id', $user_id)->findOrFail($id)->delete();

        Log::error('redirect to ' . route('todo.create'));
        //return redirect(route('todo.index'));
        //return redirect()->route('todo.create');
        $response = array(
            'result' => 'success'
        );
        return $response;

    }

    public function done($id)
    {
        $user_id = Auth::id();

        $todo = Todo::where('user_id', $user_id)->whereNull('done_at')->findOrFail($id);

        $now = Carbon::now('Asia/Tokyo');
        $todo->done_at = $now;
        $todo->save();

//        Log::error('redirect to ' . route('todo.index'));
//        return redirect()->back();
        $response = array(
            'result' => 'success'
        );
        return $response;

    }
    //
}
