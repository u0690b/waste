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
        Schema::create('registers', function (Blueprint $table) {
            $table->id();
            $table->double('long');
            $table->double('lat');
            $table->string('description');
            $table->string('resolve_desc');
            $table->foreignId('reason_id')->constrained('reasons');
            $table->foreignId('status_id')->constrained('statuses');
            $table->foreignId('aimag_city_id')->constrained('aimag_cities');
            $table->foreignId('soum_district_id')->constrained('soum_districts');
            $table->foreignId('bag_horoo_id')->constrained('bag_horoos');
            $table->string('address')->nullable();
            $table->foreignId('user_id')->constrained('users');
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
        Schema::dropIfExists('registers');
    }
};
