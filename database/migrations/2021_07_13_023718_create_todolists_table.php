<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodolistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todolists', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('todo')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('bg_color')->nullable();
            $table->integer('status')->default(1);
            $table->string('order')->nullable();
            $table->foreignId('dream_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todolists');
    }
}