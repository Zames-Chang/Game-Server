<?php

use App\Task;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
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

        while ($item_count < 20) {
            $data = [
                'vkey_id' => rand(1, 3),
                'name' => $faker->text(20),
                'name_e' => $en_faker->text(20),
                'description' => $faker->realtext(20),
                'description_e' => $en_faker->text,
                'image' => $faker->imageUrl('640', '480', 'technics', true, 'Faker'),
            ];

            Task::create($data);

            $item_count++;
        }
    }
}
