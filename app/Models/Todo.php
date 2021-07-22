<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    //登録時にエラーになるので追加
    protected $fillable = ['user_id', 'title', 'detail', 'deadline_at'];
}
