<?php

namespace Database\Factories;

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


        $baghoroo = $this->faker->randomElement([['308', '148'], ['313', '149'], ['314', '150'], ['315', '150'], ['316', '150'], ['317', '150'], ['318', '150'], ['319', '150'], ['320', '150'], ['321', '150'], ['322', '150'], ['323', '150'], ['324', '150'], ['325', '150'], ['326', '150'], ['327', '150'], ['328', '150'], ['329', '150'], ['330', '150'], ['331', '150'], ['332', '150'], ['333', '150'], ['334', '151'], ['358', '152'], ['370', '153'], ['389', '154'], ['409', '155'], ['422', '156'], ['1703', '150'], ['1704', '150'], ['1705', '150'], ['1706', '151'], ['2156', '150'], ['2157', '150'], ['2158', '155'], ['2169', '150'], ['2170', '150'], ['2171', '150'], ['2172', '150'], ['2173', '150'], ['2174', '150'], ['2175', '150'], ['2176', '150'], ['2177', '150'], ['2178', '155'], ['2201', '151']]);
        $conf_user = $this->faker->randomElement([fn() => User::where('roles', '<>', 'onb')->inRandomOrder()->first(), fn() => null])();
        $status = $this->faker->randomElement([2, 3]);
        return [
            'whois' => $this->faker->randomElement(['Иргэн', 'Хуулийн этгээд']),
            'name' => $this->faker->randomElement(['Б.Мэндсайхан', 'Д.Батчимэг', 'Т.Нэргүй', 'Б.Саранчимэг', 'Б.Саранцэцэг', 'Г.Чүлтэмжамц', 'Д.Оюунчимэг', 'Д.Ариунсайхан', 'Д.Сайнбаяр', 'С.Отгон-Өлзий', 'Э.Цасанчимэг', 'Ш.Энхцэцэг', 'З.Баяндугар', 'Э.Зол-Эрдэнэ', 'Б.Ганзориг', 'Д.Чинтулга', 'Б.Галбадрах', 'Л.Батмөнх', 'О.Ганболор', 'Ч.Ууганбаяр', 'Ж.Ганболд', 'Б.Цогзолмаа', 'Б.Баяраа', 'С.Анхтуяа', 'Ө.Сонинбаяр', 'Б.Бат-Эрдэнэ', 'А.Мөнхцэцэг', 'Л.Энхцэцэг', 'О.Ганбаатар', 'Э.Цэлмэг', 'Д.Оюунбаяр', 'Ж.Чиймаа', 'Д.Наранбилэг']),
            'register' => $this->faker->randomElement(['пй00010001', 'пй00010002', 'пй00010003', 'пй00010004', 'пй00010005', 'пй00010006', 'пй00010007', 'пй00010008', 'пй00010009', 'пй00010010', 'пй00010011', 'пй00010012', 'пй00010013', 'пй00010014', 'пй00010015', 'пй00010016', 'пй00010017', 'пй00010018', 'пй00010019', 'пй00010020', 'пй00010021', 'пй00010022', 'пй00010023', 'пй00010024', 'пй00010025', 'пй00010026', 'пй00010027', 'пй00010028', 'пй00010029', 'пй00010030', 'пй00010031', 'пй00010032', 'пй00010033']),
            'chiglel' => $this->faker->word,
            'aimag_city_id' => 7,
            'soum_district_id' => $baghoroo[1],
            'bag_horoo_id' => $baghoroo[0],
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
