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
        Schema::create('bag_horoos', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('Код');;
            $table->string('name')->comment('Баг,Хороо');
            $table->foreignId('soum_district_id')->comment('Сум,Дүүрэг')->constrained('soum_districts');
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
        Schema::dropIfExists('bag_horoos');
    }
};
