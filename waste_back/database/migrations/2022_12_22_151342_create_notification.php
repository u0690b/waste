<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from')->nullable()->comment('Хэнээс')->constrained('users');
            $table->foreignId('to')->comment('хэнд')->constrained('users');
            $table->string('title', 2000)->comment('Гарчиг');
            $table->text('body', 2000)->nullable()->comment('дэд гарчиг');
            $table->text('payload')->nullable()->comment('Агуулга');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification');
    }
};
