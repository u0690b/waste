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
            $table->bigIncrements('register_id')->comment('хог хаягдалын ID');
            $table->enum('whois', ['Иргэн', 'Хуулийн этгээд'])->comment('Иргэн/ААН');
            $table->string('name')->comment('Байгууллага, аж ахуйн нэгжийн нэр, иргэний овог нэр');
            $table->string('register')->nullable()->comment('Регистрийн дугаар');
            $table->string('chiglel')->nullable()->comment('Үйл ажиллагааны чиглэл');
            $table->foreignId('aimag_city_id')->comment('Аймаг,Нийслэл')->constrained('aimag_cities');
            $table->foreignId('soum_district_id')->comment('Сум,Дүүрэг')->constrained('soum_districts');
            $table->foreignId('bag_horoo_id')->comment('Баг,Хороо')->constrained('bag_horoos');
            $table->string('address', 500)->nullable()->comment('Хаяг, байршилд');
            $table->string('description', 2000)->comment('Гаргасан зөрчилийн байдал');
            $table->foreignId('reason_id')->comment('Зөрчилийн төрөл')->constrained('reasons');
            $table->string('zuil_zaalt', 1000)->nullable()->comment('Зөрчсөн хууль тогтоомжийн зүйл, заалт');
            $table->double('long')->comment('Уртраг');
            $table->double('lat')->comment('Өргөрөг');

            $table->foreignId('reg_user_id')->comment('Бүртгэсэн хүн')->constrained('users');

            $table->foreignId('resolve_id')->nullable()->comment('Шийдвэрийн төрөл')->constrained('resolves');
            $table->string('resolve_desc', 2000)->nullable()->comment('Шийдвэрлэсэн байдал');
            $table->string('resolve_image', 500)->nullable()->comment('Шийдвэрлэсэн зураг');
            $table->timestamp('resolved_at')->nullable()->comment('Шийдвэрлэсэн огноо');

            $table->foreignId('comf_user_id')->nullable()->comment('Шийдвэрлэсэн хүн')->constrained('users');

            $table->foreignId('status_id')->comment('Төлөв')->constrained('statuses');
            $table->timestamp('reg_at')->nullable()->comment('Үүсгэсэн');
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
