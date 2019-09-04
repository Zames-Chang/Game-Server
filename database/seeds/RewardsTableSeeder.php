<?php

use App\Reward;
use Illuminate\Database\Seeder;

class RewardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('zh_TW');
        $en_faker = Faker\Factory::create('en_US');
        $item_count = 0;

        while ($item_count < 2) {
            $data = [
                'name' => $faker->text(20),
                'name_e' => $en_faker->text(20),
                'description' => $faker->realtext(20),
                'description_e' => $en_faker->text,
                'image' => $faker->imageUrl('640', '480', 'technics', true, 'Faker'),
                'redeemable' => $faker->boolean,
            ];

            Reward::create($data);

            $item_count++;
        }
    }
}
