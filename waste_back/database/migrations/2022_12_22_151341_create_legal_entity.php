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
        Schema::create('legal_entity', function (Blueprint $table) {
            $table->id();
            $table->string('register')->unique()->comment('Хуулийн этгээдийн регистр');
            $table->string('name', 2000)->comment('Хуулийн этгээдийн нэр');
            $table->foreignId('industry_id')->comment('Үйл ажиллагааны чиглэл')->constrained('industries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legal_entity');
    }
};
