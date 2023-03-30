<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AttachedFile;
use App\Models\Place;
use App\Models\Reason;
use App\Models\SoumDistrict;
use App\Models\LegalEntity;
use App\Models\Register;
use App\Models\Resolve;
use App\Models\Status;
use App\Models\Industry;
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

        Reason::create(['name' => 'Аюултай хог хаягдал/Байгаль орчин аялал жуучлалын яам/', 'place_id' => 2]);
        Reason::create(['name' => 'Эмнэлгийн хог хаягдал/Эрүүл мэндийн яам/', 'place_id' => 2]);
        Reason::create(['name' => 'Барилгын хог хаягдал/Барилга, хот байгуулалтын яам/', 'place_id' => 2]);
        Reason::create(['name' => 'Ил задгай шатаах', 'place_id' => 1]);
        Reason::create(['name' => 'Хогийн сав, цэгээс бусад газарт хаях', 'place_id' => 1]);
        Reason::create(['name' => 'Ногоон бүс, үерийн далан, шугам, хоолой руу хаях', 'place_id' => 1]);
        Reason::create(['name' => 'Нийлэг материал зууханд шатаах', 'place_id' => 1]);
        Reason::create(['name' => 'Нийтийн эзэмшлийн газарт зар, шашны зан үйлийн зүйлс тавьж хог үүсгэх', 'place_id' => 1]);
        Reason::create(['name' => 'Хогны төлбөр төлөөгүй', 'place_id' => 1]);
        Reason::create(['name' => 'Нийтийн эзэмшлийн газрын хог, цас, мөсийг цэвэрлээгүй', 'place_id' => 1]);
        Reason::create(['name' => 'Барилгын хог хаягдал, үйлчилгээний хөлс төлөөгүй', 'place_id' => 1]);
        Reason::create(['name' => 'Бохир ус, угаадас асгах', 'place_id' => 1]);

        Industry::create(['name' => 'Үйлдвэрлэл']);
        Industry::create(['name' => 'Барилга']);
        Industry::create(['name' => 'Бөөний болон жижиглэн худалдаа, машин, мотоциклийн засвар үйлчилгээ']);
        Industry::create(['name' => 'Тээвэр, агуулахын үйлчилгээ']);
        Industry::create(['name' => 'Мэргэжлийн, шинжлэх ухаан болон техникийн үйл ажиллагаа']);
        Industry::create(['name' => 'Удирдлагын болон дэмжлэг үзүүлэх үйл ажиллагаа']);


        Status::create(['name' => 'Бүртгэсэн']);
        Status::create(['name' => 'Илгээсэн']);
        Status::create(['name' => 'Хуваарилсан']);
        Status::create(['name' => 'Шийдвэрлэсэн']);

        Resolve::create(['name' => 'Зөрчлийг арилгуулсан']);
        Resolve::create(['name' => 'Торгууль']);
        Resolve::create(['name' => 'Татгалзсан']);
        Resolve::create(['name' => 'Сануулга']);
        Resolve::create(['name' => 'Мэдэгдэх хуудас']);
        Resolve::create(['name' => 'Албан даалгавар']);
        Resolve::create(['name' => 'Бусад']);


        \App\Models\User::factory()->create([
            'username' => 'admin',
            'name' => 'Админ',
            'phone' => '9999-9999',
            'roles' => 'admin',
            'position' => \App\Models\User::$rolesModel['admin'],
        ]);
        \App\Models\User::factory()->create([
            'username' => 'zaa',
            'name' => 'Захирагчийн ажлын алба',
            'phone' => '8888-8888',
            'roles' => 'zaa',
            'position' => \App\Models\User::$rolesModel['zaa'],
        ]);
        \App\Models\User::factory()->create([
            'username' => 'mha',
            'name' => 'МХ байцаагч',
            'phone' => '8888-8888',
            'roles' => 'mha',
            'position' => \App\Models\User::$rolesModel['mha'],
        ]);


        \App\Models\User::factory()->create([
            'username' => 'da',
            'name' => 'Дүүргийн админ',
            'phone' => '8888-8888',
            'roles' => 'da',
            'position' => \App\Models\User::$rolesModel['da'],
        ]);
        \App\Models\User::factory()->create([
            'username' => 'hd',
            'name' => 'Хорооны засаг дарга',
            'phone' => '8888-8888',
            'roles' => 'hd',
            'position' => \App\Models\User::$rolesModel['hd'],
        ]);
        \App\Models\User::factory()->create([
            'username' => 'onb',
            'name' => 'Олон нийтийн байцаагч',
            'phone' => '8888-8888',
            'roles' => 'onb',
            'position' => \App\Models\User::$rolesModel['onb'],
        ]);

        \App\Models\User::factory()->create([
            'username' => 'boajy',
            'name' => 'Sandag',
            'phone' => '8888-8888',
            'roles' => 'boajy',
            'position' => \App\Models\User::$rolesModel['boajy'],
        ]);
        \App\Models\User::factory()->create([
            'username' => 'bhby',
            'name' => 'brigad',
            'phone' => '8888-8888',
            'roles' => 'bhby',
            'position' => \App\Models\User::$rolesModel['bhby'],
        ]);
        \App\Models\User::factory()->create([
            'username' => 'emy',
            'name' => 'Эмч',
            'phone' => '8888-8888',
            'roles' => 'emy',
            'position' => \App\Models\User::$rolesModel['emy']
        ]);


        Register::factory(100)->create();
        AttachedFile::factory(150)->create();
    }
}
