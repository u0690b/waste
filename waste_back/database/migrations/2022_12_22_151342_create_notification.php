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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('Хэнд');
            $table->string('type', 100)->comment('Төрөл');
            $table->string('title', 500)->comment('Гарчиг');
            $table->text('content')->nullable()->comment('Агуулга');
            $table->unsignedBigInteger('rid')->nullable()->comment('Холоотой айди');
            $table->timestamp('read_at')->nullable()->comment('Уншсан');
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
        Schema::dropIfExists('notifications');
    }
};
