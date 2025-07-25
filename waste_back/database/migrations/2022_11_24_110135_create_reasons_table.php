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
        Schema::create('reasons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('Шалтгаан код');
            $table->string('name', 1000)->comment('Шалтгаан');
            $table->string('sub_group', 1000)->comment('Хог хаягдлын дэд бүлэг');
            $table->string('stype')->comment('Төрөл');
            $table->foreignId('place_id')->comment('Хог хаягдлын бүлэг')->constrained('places');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reasons');
    }
};
