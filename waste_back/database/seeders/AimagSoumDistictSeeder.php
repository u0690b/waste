<?php

namespace Database\Seeders;

use App\Models\AimagCity;
use App\Models\BagHoroo;
use App\Models\SoumDistrict;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AimagSoumDistictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('load json');
        $json = json_decode(file_get_contents(__DIR__ . '/AddressList.json'));

        DB::beginTransaction();
        $this->command->info('begin transaciton');
        $i = 0;
        foreach ($json->Data[1] as $aimag) {
            $aimagCity = AimagCity::create([
                'code' => $aimag[0],
                'name' => $aimag[1],
            ]);
            $this->command->info('AimagCity created: ' . $aimagCity->name);

            foreach ($aimag[3] as $soum) {
                $soumDistrict = SoumDistrict::create([
                    'code' => $soum[1],
                    'name' => $soum[2],
                    'aimag_city_id' => $aimagCity->id,
                ]);
                foreach ($soum[4] as $bagHoroo) {
                    // Assuming you want to create BagHoro records here
                    BagHoroo::create([
                        'code' => $bagHoroo[1],
                        'name' => $bagHoroo[2],
                        'soum_district_id' => $soumDistrict->id,
                    ]);

                }
                $this->command->info('SoumDistrict created: ' . $soumDistrict->name);
            }
        }

        DB::commit();
    }
}
