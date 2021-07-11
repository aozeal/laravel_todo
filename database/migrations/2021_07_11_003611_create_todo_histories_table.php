<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('todo_id');
            $table->string('user_id');
            $table->string('title');
            $table->text('detail')->nullable();
            $table->timestamps();
            $table->timestamp('done_at')->nullable();
            $table->timestamp('deadline_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todo_histories');
    }
}
