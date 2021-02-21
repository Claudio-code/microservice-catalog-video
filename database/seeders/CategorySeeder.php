<?php

namespace Database\Seeders;

use App\Models\Category;
use Database\Factories\models\CategoryFactory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->count(30)->create();
    }
}