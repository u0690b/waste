<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Place;
use App\Models\Reason;
use App\Models\SoumDistrict;
use App\Models\Status;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        // \App\Models\User::create();




        $this->call([
            AimagSoumDistictSeeder::class,
            BagHorooSeeder::class,
        ]);

        Place::create(['id' => 1, 'name' => 'Захирагчийн ажлын алба']);
        Place::create(['id' => 2, 'name' => 'Мэргэжлийн хяналтын ерөнхий газар']);

        Reason::create(['name' => 'Хог хаягдал', 'place_id' => 1]);
        Reason::create(['name' => 'Хор хөнөөлт хог хаягдал', 'place_id' => 2]);

        Status::create(['name' => 'Бүртгэсэн']);
        Status::create(['name' => 'Илгээсэн']);
        Status::create(['name' => 'Шийдвэрлэсэн']);




        \App\Models\User::factory()->create([
            'username' => 'admin',
            'name' => 'Админ',
            'roles' => 'admin'
        ]);
        \App\Models\User::factory()->create([
            'username' => 'test',
            'name' => 'Зочин',
            'roles' => 'admin'
        ]);
    }
}
