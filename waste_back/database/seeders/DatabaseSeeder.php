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

        ini_set('memory_limit', '-1');


        $this->call([
            AimagSoumDistictSeeder::class,
            BagHorooSeeder::class,
            LegalEntitySeeder::class,
        ]);


        Place::create(['id' => 1, 'name' => "Автотээврийн үндэсний төв, замын цагдаагийн газар"]);
        Place::create(['id' => 2, 'name' => "Аймаг/нийслэлийн байгаль орчны газар"]);
        Place::create(['id' => 3, 'name' => "Аймаг/нийслэлийн эрүүл мэндийн газар"]);
        Place::create(['id' => 4, 'name' => "Байгаль орчны байцаагч"]);
        Place::create(['id' => 5, 'name' => "ЗДТГ-ын хяналт шалгалтын газар"]);
        Place::create(['id' => 6, 'name' => "Нийслэлийн агаар орчны бохирдолтой тэмцэх газар"]);
        Place::create(['id' => 7, 'name' => "Харьяа хамгаалалтын захиргааны байцаагч"]);
        Place::create(['id' => 8, 'name' => "Хүнс хөдөө аж ахуйн газар"]);
        Place::create(['id' => 9, 'name' => "Экологийн цагдаагийн алба"]);




        Reason::create(['code' => '0001', 'name' => 'Ахуйн хог хаягдал', 'sub_group' => 'Энгийн хог хаягдал', 'stype' => 'Э', 'place_id' => 1]);
        Reason::create(['code' => '0002', 'name' => 'Барилгын хог хаягдал', 'sub_group' => 'Энгийн хог хаягдал', 'stype' => 'Э', 'place_id' => 2]);
        Reason::create(['code' => '0003', 'name' => 'Малын гаралтай хог хаягдал', 'sub_group' => 'Энгийн хог хаягдал', 'stype' => 'Э', 'place_id' => 3]);
        Reason::create(['code' => '0004', 'name' => 'Уул уурхайн хог хаягдал', 'sub_group' => 'Аюултай хог хаягдал', 'stype' => 'А', 'place_id' => 1]);
        Reason::create(['code' => '0005', 'name' => 'Эмнэлгийн хог хаягдал', 'sub_group' => 'Аюултай хог хаягдал', 'stype' => 'А', 'place_id' => 4]);
        Reason::create(['code' => '0006', 'name' => 'Авто тээврийн хэрэгслийн хог хаягдал', 'sub_group' => 'Аюултай хог хаягдал', 'stype' => 'А', 'place_id' => 2]);
        Reason::create(['code' => '0007', 'name' => 'Химийн бодисын хог хаягдал', 'sub_group' => 'Аюултай хог хаягдал', 'stype' => 'А', 'place_id' => 1]);
        Reason::create(['code' => '0008', 'name' => 'Зориулалтын бус газарт үүссэн хог хаягдал', 'sub_group' => 'Бусад хог хаягдал', 'stype' => 'Б', 'place_id' => 5]);
        Reason::create(['code' => '0009', 'name' => 'Цахим, цахилгаан хэрэгслийн хог хаягдал', 'sub_group' => 'Бусад хог хаягдал', 'stype' => 'Б', 'place_id' => 5]);
        Reason::create(['code' => '0010', 'name' => 'Суурин эх үүсвэр нийслэлд', 'sub_group' => 'Агаарын бохирдол', 'stype' => 'АБ', 'place_id' => 6]);
        Reason::create(['code' => '0011', 'name' => 'Суурин эх үүсвэр аймагт', 'sub_group' => 'Агаарын бохирдол', 'stype' => 'АБ', 'place_id' => 1]);
        Reason::create(['code' => '0012', 'name' => 'Хөдөлгөөнт эх үүсвэр', 'sub_group' => 'Агаарын бохирдол', 'stype' => 'АБ', 'place_id' => 7]);
        Reason::create(['code' => '0013', 'name' => 'Хөрсний бохирдол', 'sub_group' => 'Хөрсний бохирдол', 'stype' => 'Х', 'place_id' => 1]);
        Reason::create(['code' => '0014', 'name' => 'Сав газар', 'sub_group' => 'Усны бохирдол', 'stype' => 'У', 'place_id' => 8]);
        Reason::create(['code' => '0015', 'name' => 'Тусгай хамгаалалттай газар', 'sub_group' => 'Усны бохирдол', 'stype' => 'У', 'place_id' => 9]);
        Reason::create(['code' => '0016', 'name' => 'NASA', 'sub_group' => 'Аюултай хог хаягдал', 'stype' => 'А', 'place_id' => 1]);


        Industry::create(['name' => 'Үйлдвэрлэл']);
        Industry::create(['name' => 'Барилга']);
        Industry::create(['name' => 'Бөөний болон жижиглэн худалдаа, машин, мотоциклийн засвар үйлчилгээ']);
        Industry::create(['name' => 'Тээвэр, агуулахын үйлчилгээ']);
        Industry::create(['name' => 'Мэргэжлийн, шинжлэх ухаан болон техникийн үйл ажиллагаа']);
        Industry::create(['name' => 'Удирдлагын болон дэмжлэг үзүүлэх үйл ажиллагаа']);


        Status::create(['name' => 'Ноорог /Серверт илгээгээгүй/']);
        Status::create(['name' => 'Илгээсэн']);
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
        ]);

        \App\Models\User::factory()->create([
            'username' => 'da',
            'name' => 'name Aimag duurgiin admin',
            'phone' => '8888-8888',
            'roles' => 'da',
        ]);

        \App\Models\User::factory()->create([
            'username' => 'mha',
            'name' => 'name Байгаль орчны хяналтын улсын ахлах байцаагч',
            'phone' => '8888-8888',
            'roles' => 'mha',
        ]);

        Register::factory(100)->create();
        AttachedFile::factory(150)->create();
    }
}
