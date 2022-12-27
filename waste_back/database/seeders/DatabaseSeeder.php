<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Place;
use App\Models\Reason;
use App\Models\SoumDistrict;
use App\Models\LegalEntity;
use App\Models\Resolve;
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
            LegalEntitySeeder::class,
        ]);

        Place::create(['id' => 1, 'name' => 'Захирагчийн ажлын алба']);
        Place::create(['id' => 2, 'name' => 'Мэргэжлийн хяналтын ерөнхий газар']);

        Reason::create(['name' => 'Аюултай хог хаягдал -> МХЕГ', 'place_id' => 2]);
        Reason::create(['name' => 'Эмнэлгийн хог хаягдал -> МХЕГ', 'place_id' => 2]);
        Reason::create(['name' => 'Барилгын хог хаягдал -> МХЕГ', 'place_id' => 2]);
        Reason::create(['name' => 'Ил задгай шатаах', 'place_id' => 1]);
        Reason::create(['name' => 'Хогийн сав, цэгээс бусад газарт хаях', 'place_id' => 1]);
        Reason::create(['name' => 'Ногоон бүс, үерийн далан, шугам, хоолой руу хаях', 'place_id' => 1]);
        Reason::create(['name' => 'Нийлэг материал зууханд шатаах', 'place_id' => 1]);
        Reason::create(['name' => 'Нийтийн эзэмшлийн газарт зар, шашны зан үйлийн зүйлс тавьж хог үүсгэх', 'place_id' => 1]);
        Reason::create(['name' => 'Хогны төлбөр төлөөгүй', 'place_id' => 1]);
        Reason::create(['name' => 'Нийтийн эзэмшлийн газрын хог, цас, мөсийг цэвэрлээгүй', 'place_id' => 1]);
        Reason::create(['name' => 'Барилгын хог хаягдал, үйлчилгээний хөлс төлөөгүй', 'place_id' => 1]);
        Reason::create(['name' => 'Бохир ус, угаадас асгах', 'place_id' => 1]);




        Status::create(['name' => 'Бүртгэсэн']);
        Status::create(['name' => 'Илгээсэн']);
        Status::create(['name' => 'Хуваарилсан']);
        Status::create(['name' => 'Шийдвэрлэсэн']);

        Resolve::create(['name' => 'Зөрчлийг арилгуулсан']);
        Resolve::create(['name' => 'Торгосон']);
        Resolve::create(['name' => 'Татгалзсан']);
        Resolve::create(['name' => 'Бусад']);


        \App\Models\User::factory()->create([
            'username' => 'admin',
            'name' => 'Админ',
            'phone' => '9999-9999',
            'roles' => 'admin'
        ]);
        \App\Models\User::factory()->create([
            'username' => 'test',
            'name' => 'Зочин',
            'phone' => '8888-8888',
            'roles' => 'pi'
        ]);
    }
}
