<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

use Log;

class Todo extends Model
{
    use HasFactory;

    use SoftDeletes;

    //登録時にエラーになるので追加
    protected $fillable = ['user_id', 'title', 'detail', 'deadline_at'];

    function checkDeadline(){
        $now = Carbon::now('Asia/Tokyo');
        $deadline = $this->deadline_at;
        if (is_null($deadline)){
            return null;
        }

        if (!$now->lt($deadline)){
            return -1; //期限切れ
        }

        $diff = $now->diffInHours($deadline);
        if ($diff > 24){
            return 1; //期限は先
        }
        return 0; //期限間近
    }
}
