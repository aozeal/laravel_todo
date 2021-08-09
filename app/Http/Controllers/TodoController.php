<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Todo;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

use Exception;
use Log;


class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //とりあえずサンプル用に全Todoを取得して表示
        $user_id = Auth::id();

        $todos = Todo::all()->whereNull('done_at')->where('user_id', $user_id);

        return view('todo/index', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('todo/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::id();
        
        $rules = [
            'title' => 'required|min:1|max:250',
            'detail' => 'nullable|max:1000',
            'deadline_at' => 'nullable|date'
        ];
        $validated = $request->validate($rules);
        $validated['user_id'] = $user_id;

        DB::beginTransaction();
        try {
            Todo::create($validated);
            DB::commit();
        } catch (\Exception $e){
            DB::rollback();

            $error_msg = $e->getMessage();
            Log::error($error_msg);
            return redirect()->back()->withErrors(['error' => $error_msg])->withInput();
        }

        return redirect(route('todo.index'));
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
        $user_id = Auth::id();

        $todo = Todo::where('user_id', $user_id)->findOrFail($id);

        return view('todo/show', compact('todo'));
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
        $user_id = Auth::id();

        $todo = Todo::where('user_id', $user_id)->findOrFail($id);

        return view('todo/edit', compact('todo'));
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
        $user_id = Auth::id();
        
        $rules = [
            'title' => 'required|min:1|max:250',
            'detail' => 'nullable|max:1000',
            'deadline_at' => 'nullable|date'
        ];
        $validated = $request->validate($rules);
        $validated['user_id'] = $user_id;

        DB::beginTransaction();
        try {
            Todo::where('id', $id)->update($validated);
            DB::commit();
        } catch (\Exception $e){
            DB::rollback();
            $error_msg = $e->getMessage();
            return redirect()->back()->withInput()->withErrors(['error' => $error_msg]);
        }

        return redirect(route('todo.show', ['id' => $id]));        
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
        $user_id = Auth::id();

        DB::beginTransaction();
        try {
            Todo::where('user_id', $user_id)->findOrFail($id)->delete();
            DB::commit();
        } catch (\Exception $e){
            DB::rollback();
            $error_msg = $e->getMessage();

            $response = array(
                'result' => 'error',
                'error_msg' => $error_msg
            );
            return $response;
        }

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

        DB::beginTransaction();
        try {
            $todo->save();
            DB::commit();
        } catch (\Exception $e){
            DB::rollback();

            $error_msg = $e->getMessage();
            $response = array(
                'result' => 'error',
                'error_msg' => $error_msg
            );
            return $response;
        }

        $response = array(
            'result' => 'success'
        );
        return $response;

    }
}
