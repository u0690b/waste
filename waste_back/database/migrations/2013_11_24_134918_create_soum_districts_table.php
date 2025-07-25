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
        Schema::create('soum_districts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('Код');
            $table->string('name')->comment('Аймаг нэр');
            $table->string('short')->nullable()->comment('товч');
            $table->foreignId('aimag_city_id')->comment('Аймаг/Нийслэл')->constrained('aimag_cities');;
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
        Schema::dropIfExists('soum_districts');
    }
};
