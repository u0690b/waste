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
        Schema::create('aimag_cities', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('Код');
            $table->string('name')->unique()->comment('Аймаг нэр');
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
        Schema::dropIfExists('aimag_cities');
    }
};
