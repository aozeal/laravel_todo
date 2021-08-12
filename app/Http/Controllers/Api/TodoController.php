<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyFromApi($id, Request $request)
    {
        //
        $user_id = $request->user()->id;

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

    public function doneFromApi($id, Request $request)
    {
        $user_id = $request->user()->id;

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
}
