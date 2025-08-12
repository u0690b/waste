<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Нэр');
            $table->string('username')->comment('Нэвтрэх нэр')->unique();
            $table->string('password')->comment('Нууц үг');
            $table->foreignId('aimag_city_id')->comment('Аймаг нийслэл')->constrained('aimag_cities');
            $table->foreignId('soum_district_id')->comment('Сум дүүрэг')->nullable()->constrained('soum_districts');
            $table->foreignId('bag_horoo_id')->comment(comment: 'Баг хороо')->nullable()->constrained('bag_horoos');
            $table->string('phone')->comment('Утас');
            $table->foreignId('place_id')->comment('Харьялах нэгж')->nullable()->constrained('places');
            $table->string('roles')->comment('Эхийн түвшин')->default('none');
            $table->rememberToken()->comment('Токен')->nullable();
            $table->string('push_token')->nullable();
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
        Schema::dropIfExists('users');
    }
};
