<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB; // ←これを追加
use Illuminate\Support\Str;


class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('todos')->insert([
            "user_id"=> Str::random(10) . "@az.com",
            "title" => Str::random(10),
            "detail" => Str::random(10),
            "created_at"=>date('Y-m-d H:i:s'),
            "updated_at"=>date('Y-m-d H:i:s'),
            "deleted_at"=>null,
            "done_at"=>null,
            "deadline_at"=>null
        ]);
    }
}
