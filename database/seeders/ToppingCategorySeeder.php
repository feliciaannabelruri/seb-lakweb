<?php

namespace Database\Seeders;

use App\Models\ToppingCategory;
use Illuminate\Database\Seeder;

class ToppingCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Sayur'],
            ['name' => 'Mie'],
            ['name' => 'Bakso, Gorengan, dan Aci'],
            ['name' => 'Kerupuk']
        ];

        foreach ($categories as $category) {
            ToppingCategory::create($category);
        }
    }
}
