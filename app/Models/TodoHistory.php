<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Log;
use Exception;

class TodoHistory extends Model
{
    use HasFactory;

    protected $fillable = ['todo_id', 'user_id', 'title', 'detail', 'deadline_at', 
                            'created_at', 'updated_at', 'done_at', 'deleted_at'];

    static function createLog($todo){
        $data = array();
        $attributes = $todo->getAttributes();
        foreach ($attributes as $key => $value){
            if ($key == "id"){
                $data["todo_id"] = $value;
            }
            else{
                $data[$key] = $value;                
            }
        }
        //外部でtry-catchを実施しているのでここでは行わない
        self::create($data);

        return true;
    }

    function checkDeadline($target_date){
        if (is_null($target_date)){
            $target = new Carbon('now' ,'Asia/Tokyo');
        }
        else{
            $target = new Carbon($target_date);
        }
        $deadline = $this->deadline_at;
        if (is_null($deadline)){
            return null;
        }

        if (!$target->lt($deadline)){
            return -1; //期限切れ
        }

        $diff = $target->diffInHours($deadline);
        if ($diff > 24){
            return 1; //期限は先
        }
        return 0; //期限間近
    }

}
