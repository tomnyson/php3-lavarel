<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogTaleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            DB::table('blog')->insert([
                'name' => $faker->sentence(3),
                'description' => $faker->paragraph,
                'thumbnail' => $faker->imageUrl(640, 480, 'cats', true, 'Faker'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        //
    }
}
