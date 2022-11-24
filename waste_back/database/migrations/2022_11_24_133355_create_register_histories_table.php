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
        Schema::create('register_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('register_id')->constrained('registers')->comment('Бүртгэл');;;
            $table->double('long')->comment('Уртраг');
            $table->double('lat')->comment('Өргөрөг');
            $table->string('description')->comment('Тайлбар');;
            $table->string('resolve_desc')->comment('Тэмдэглэл');;
            $table->foreignId('reason_id')->comment('Шалтгаан')->constrained('reasons');
            $table->foreignId('status_id')->comment('Төлөв')->constrained('statuses');
            $table->foreignId('aimag_city_id')->comment('Аймаг,Нийслэл')->constrained('aimag_cities');
            $table->foreignId('soum_district_id')->comment('Сум,Дүүрэг')->constrained('soum_districts');
            $table->foreignId('bag_horoo_id')->comment('Баг,Хороо')->constrained('bag_horoos');
            $table->string('address')->nullable()->comment('Хаяг');;
            $table->foreignId('user_id')->comment('Бүртгэсэн хүн')->constrained('users');;
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
        Schema::dropIfExists('register_histories');
    }
};
