<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Category extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * apple, samsung, xaomi, oppo
         */
        DB::table('category')->insert([
            [
                'name' => 'apple',
                'description' => 'apple'
            ],
            [
                'name' => 'samsung',
                'description' => 'apsamsungle'
            ],
            [
                'name' => 'xaomi',
                'description' => 'xaomi'
            ],
            [
                'name' => 'oppo',
                'description' => 'oppo'
            ]

        ]);
    }
}
