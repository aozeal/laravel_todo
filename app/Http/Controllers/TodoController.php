<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use App\Models\TodoHistory;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

use Exception;
use Log;


class TodoController extends Controller
{

    const MAX_ROW_PER_PAGE = 5;
    const SORT_TYPE_CREATED_ASC = "created_asc";
    const SORT_TYPE_CREATED_DESC = "created_desc";
    const SORT_TYPE_DEADLINE_ASC = "deadline_asc";
    const SORT_TYPE_DEADLINE_DESC = "deadline_desc";
    const VIEW_DONE_WITHOUT_DONE = "without_done";
    const VIEW_DONE_ONLY_DONE = "only_done";
    const VIEW_DONE_WITH_DONE = "with_done";
    const VIEW_DEADLINE_ALL = "all";
    const VIEW_DEADLINE_BEFORE_DEADLINE = "before_deadline";
    const VIEW_DEADLINE_AFTER_DEADLINE = "after_deadline";
    const VIEW_DEADLINE_CLOSE_DEADLINE = "close_deadline";


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = array(
            'view_done' => $request->input('view_done', null),
            'view_deadline' => $request->input('view_deadline', null),
            'keyword' => $request->input('keyword', null),
            'sort_type' => $request->input('sort_type', null),
            'page' => $request->input('page', 1),
            'total_pages' => $request->input('total_pages', 1)
        );

        $user_id = Auth::id();

        //ページ情報を取得
        $total_row = self::countRowWithCondition($user_id, $data['view_done'], $data['view_deadline'], $data['keyword']);
        $total_pages = ceil($total_row / self::MAX_ROW_PER_PAGE);
        $data['total_pages'] = $total_pages;


        //$todos = Todo::all()->whereNull('done_at')->where('user_id', $user_id);

        $query = Todo::query();
        $query->where('user_id', $user_id);

        if(!is_null($data['keyword'])){
            $query->where('title', 'like', "%{$data['keyword']}%");
        }

        if($data['view_done'] === self::VIEW_DONE_ONLY_DONE){
            $query->whereNotNull('done_at');
        }
        elseif($data['view_done'] === self::VIEW_DONE_WITH_DONE){
            //両方（with_done）query追加なし
        }
        else{
            $query->whereNull('done_at');
        }

        $now = Carbon::now('Asia/Tokyo');
        if ($data['view_deadline'] === self::VIEW_DEADLINE_AFTER_DEADLINE){
            $query->where('deadline_at', '<', $now);
        }
        else if ($data['view_deadline'] === self::VIEW_DEADLINE_BEFORE_DEADLINE){
            $query->where('deadline_at', '>', $now);
        }
        else if ($data['view_deadline'] === self::VIEW_DEADLINE_CLOSE_DEADLINE){
            $next_day = Carbon::now()->addDay();
            $query->where('deadline_at', '>', $now);
            $query->where('deadline_at', '<', $next_day);
        }
        //全て(all)query追加なし
        switch ($data['sort_type']) {
            case self::SORT_TYPE_DEADLINE_DESC:
                $query->orderBy('deadline_at', 'desc');
                break;
            case self::SORT_TYPE_DEADLINE_ASC:
                $query->orderBy('deadline_at', 'asc');
                break;
            
            case self::SORT_TYPE_CREATED_DESC:
                $query->orderBy('created_at', 'desc');
                break;
            case self::SORT_TYPE_CREATED_ASC:
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'asc');
                break;
        }
        $query->limit(self::MAX_ROW_PER_PAGE);
        $query->offset(self::MAX_ROW_PER_PAGE * ($data['page'] -1 ));

        $todos = $query->get();

        return view('todo/index', compact('todos', 'data'));
    }

    private static function countRowWithCondition($user_id, $view_done, $view_deadline, $keyword){
        $query = Todo::query();
        $query->where('user_id', Auth::id());

        if(!is_null($keyword)){
            $query->where('title', 'like', "%{$keyword}%");
        }

        if($view_done === self::VIEW_DONE_ONLY_DONE){
            $query->whereNotNull('done_at');
        }
        elseif($view_done === self::VIEW_DONE_WITH_DONE){
            //両方（with_done）query追加なし
        }
        else{
            $query->whereNull('done_at');
        }

        $now = Carbon::now('Asia/Tokyo');
        if ($view_deadline === self::VIEW_DEADLINE_AFTER_DEADLINE){
            $query->where('deadline_at', '<', $now);
        }
        else if ($view_deadline === self::VIEW_DEADLINE_BEFORE_DEADLINE){
            $query->where('deadline_at', '>', $now);
        }
        else if ($view_deadline === self::VIEW_DEADLINE_CLOSE_DEADLINE){
            $next_day = Carbon::now()->addDay();
            $query->where('deadline_at', '>', $now);
            $query->where('deadline_at', '<', $next_day);
        }

        return $query->count();

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
            $todo = Todo::create($validated);
            $result = TodoHistory::createLog($todo);
            if (!$result){
                throw new Exception("TodoHistory couldn't be saved.", 1);
            }
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
            $todo = Todo::find($id);
            TodoHistory::createLog($todo);
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
            $todo = Todo::onlyTrashed()->find($id);
            TodoHistory::createLog($todo);

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
            TodoHistory::createLog($todo);
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

/*
    //エラー表示テスト用
    public function errorTest(){
        $error_code = "EA-80";
        abort(500, 'internal errror EA-80', ['error_code' => 'EA-80', 'error_code2'=>'xxx']);
    }
*/
}
