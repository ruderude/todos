<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $value = false;

            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment('ユーザーID');
            $table->string('name')->nullable()->comment('タスク');
            $table->string('details')->nullable()->comment('詳細');
            $table->boolean('done')->default($value)->comment('終了フラグ');
            $table->timestamps();
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
