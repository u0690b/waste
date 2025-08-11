<?php

namespace Database\Factories;

use App\Models\AimagCity;
use App\Models\BagHoroo;
use App\Models\Reason;
use App\Models\Register;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegisterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Register::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        /** @var \App\Models\BagHoroo|null $bh */
        $bh = BagHoroo::inRandomOrder()->first();
        $sd = $bh->soum_district;
        $conf_user = $this->faker->randomElement([fn() => User::where('roles', '<>', 'onb')->inRandomOrder()->first(), fn() => null])();
        $status = $this->faker->randomElement([2, 3]);
        return [
            'whois' => $this->faker->randomElement(['Иргэн', 'Хуулийн этгээд']),
            'name' => $this->faker->randomElement(['Б.Мэндсайхан', 'Д.Батчимэг', 'Т.Нэргүй', 'Б.Саранчимэг', 'Б.Саранцэцэг', 'Г.Чүлтэмжамц', 'Д.Оюунчимэг', 'Д.Ариунсайхан', 'Д.Сайнбаяр', 'С.Отгон-Өлзий', 'Э.Цасанчимэг', 'Ш.Энхцэцэг', 'З.Баяндугар', 'Э.Зол-Эрдэнэ', 'Б.Ганзориг', 'Д.Чинтулга', 'Б.Галбадрах', 'Л.Батмөнх', 'О.Ганболор', 'Ч.Ууганбаяр', 'Ж.Ганболд', 'Б.Цогзолмаа', 'Б.Баяраа', 'С.Анхтуяа', 'Ө.Сонинбаяр', 'Б.Бат-Эрдэнэ', 'А.Мөнхцэцэг', 'Л.Энхцэцэг', 'О.Ганбаатар', 'Э.Цэлмэг', 'Д.Оюунбаяр', 'Ж.Чиймаа', 'Д.Наранбилэг']),
            'register' => $this->faker->randomElement(['пй00010001', 'пй00010002', 'пй00010003', 'пй00010004', 'пй00010005', 'пй00010006', 'пй00010007', 'пй00010008', 'пй00010009', 'пй00010010', 'пй00010011', 'пй00010012', 'пй00010013', 'пй00010014', 'пй00010015', 'пй00010016', 'пй00010017', 'пй00010018', 'пй00010019', 'пй00010020', 'пй00010021', 'пй00010022', 'пй00010023', 'пй00010024', 'пй00010025', 'пй00010026', 'пй00010027', 'пй00010028', 'пй00010029', 'пй00010030', 'пй00010031', 'пй00010032', 'пй00010033']),
            'chiglel' => $this->faker->word,
            'aimag_city_id' => $sd->aimag_city_id,
            'soum_district_id' => $sd->id,
            'bag_horoo_id' => $bh->id,
            'address' => $this->faker->word,
            'description' => $this->faker->word,
            'reason_id' => Reason::inRandomOrder()->first(),
            'zuil_zaalt' => $this->faker->word,
            'resolve_desc' => $this->faker->word,
            'long' => $this->faker->randomFloat(6,  106.752358, 107.107354),
            'lat' => $this->faker->randomFloat(6, 47.860657, 48.033442),
            'reg_user_id' =>  User::inRandomOrder()->first(),
            'comf_user_id' => $status > 2 ? $conf_user : null,
            'status_id' => $status,
            'resolve_image' => $this->faker->imageUrl(),
            'resolved_at' => $status > 2 ? $this->faker->dateTimeThisMonth() : null,
            'reg_at' => $this->faker->dateTimeThisMonth(),
            'created_at' => $this->faker->dateTimeThisMonth(),
            'updated_at' => $this->faker->dateTimeThisMonth()
        ];
    }
}
