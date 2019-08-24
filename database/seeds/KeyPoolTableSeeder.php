<?php

use App\KeyPool;
use Illuminate\Database\Seeder;

class KeyPoolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $item_count = 0;

        while ($item_count < 5) {
            $data = [
                'key' => $faker->word,
                'type' => KeyPool::TYPE_TASK,
            ];

            KeyPool::create($data);

            $item_count++;
        }

        $data = [
            'key' => $faker->word,
            'type' => KeyPool::TYPE_REWARD,
        ];

        KeyPool::create($data);
    }
}
