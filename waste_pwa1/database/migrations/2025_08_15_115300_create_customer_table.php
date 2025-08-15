<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('regnum')->unique();
            $table->string('firstname')->nullable();
            $table->string('gender')->nullable();
            $table->text('image')->nullable();
            $table->string('lastname')->nullable();
            $table->string('nationality')->nullable();
            $table->string('passportAddress')->nullable();
            $table->string('passportExpireDate')->nullable();
            $table->string('passportIssueDate')->nullable();
            $table->string('soumDistrictCode')->nullable();
            $table->string('soumDistrictName')->nullable();
            $table->string('surname')->nullable();
            $table->string('token')->nullable();
            $table->rememberToken();
            $table->string('push_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('customers');
    }
};
