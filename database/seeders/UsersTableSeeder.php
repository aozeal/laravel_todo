<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB; // ←これを追加
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            [
                "name"=>"test user1",
                "detail"=>Str::random(20),
                "email"=>Str::random(10) . "@az.com",
                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s"),
                "deleted_at"=>null
            ],
            [
                "name"=>"test user2",
                "detail"=>Str::random(20),
                "email"=>Str::random(10) . "@az.com",
                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s"),
                "deleted_at"=>null
            ]
        ]);
    }
}
