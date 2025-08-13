<?php

namespace Database\Seeders;

use App\Models\AimagCity;
use App\Models\SoumDistrict;
use App\Models\User;
use App\Models\UsersModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Register;
use App\Models\AttachedFile;
class RegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          Register::factory(100)->create();
        AttachedFile::factory(150)->create();
    }
}
