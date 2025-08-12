<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LegalEntity;
use DB;

class LegalEntitySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info('load json');
    $json =  json_decode(file_get_contents(__DIR__ . '/legacy.json'), true);


    $this->command->info('begin transaciton');

    $rec = 0;

    $chunked = array_chunk($json, 5000);
    foreach ($chunked  as $chunk) {
      DB::beginTransaction();
      foreach ($chunk  as $legacy) {
        LegalEntity::insert($legacy);
      }
      $this->command->info(($rec + 5000) + ' records inserted');
      DB::commit();
    }
  }
}
