<?php

namespace Database\Seeders;

use App\Models\Topping;
use Illuminate\Database\Seeder;

class ToppingSeeder extends Seeder
{
    public function run()
    {
        $toppings = [
            // Sayur Category (id: 1)
            ['name' => 'Toge', 'price' => 3000, 'stock' => 100, 'image' => 'toge.jpg', 'is_available' => true, 'category_id' => 1],
            ['name' => 'Sawi', 'price' => 3000, 'stock' => 100, 'image' => 'sawi.jpg', 'is_available' => true, 'category_id' => 1],
            ['name' => 'Enoki', 'price' => 6000, 'stock' => 100, 'image' => 'enoki.jpg', 'is_available' => true, 'category_id' => 1],

            // Mie Category (id: 2)
            ['name' => 'Kwetiau', 'price' => 4000, 'stock' => 100, 'image' => 'kwetiau.jpg', 'is_available' => true, 'category_id' => 2],
            ['name' => 'Mie Jelly Kuning', 'price' => 4000, 'stock' => 100, 'image' => 'miejelly.jpg', 'is_available' => true, 'category_id' => 2],
            ['name' => 'Mie Kuning', 'price' => 4000, 'stock' => 100, 'image' => 'mie-kuning.jpg', 'is_available' => true, 'category_id' => 2],

            // Bakso, Aci, dan Gorengan Category (id: 3)
            ['name' => 'Siomay', 'price' => 6000, 'stock' => 100, 'image' => 'siomay.jpg', 'is_available' => true, 'category_id' => 3],
            ['name' => 'Batagor', 'price' => 6000, 'stock' => 100, 'image' => 'batagor.jpg', 'is_available' => true, 'category_id' => 3],
            ['name' => 'Baso Ikan', 'price' => 7000, 'stock' => 100, 'image' => 'basoikan.jpg', 'is_available' => true, 'category_id' => 3],
            ['name' => 'Cilok', 'price' => 5000, 'stock' => 100, 'image' => 'cilok.jpg', 'is_available' => true, 'category_id' => 3],
            ['name' => 'Basreng', 'price' => 5000, 'stock' => 100, 'image' => 'basreng.jpg', 'is_available' => true, 'category_id' => 3],
            ['name' => 'Bakso Keju', 'price' => 4000, 'stock' => 100, 'image' => 'bakso-keju.jpg', 'is_available' => true, 'category_id' => 3],
            ['name' => 'Bakso Ayam', 'price' => 6000, 'stock' => 100, 'image' => 'bakso-ayam.jpg', 'is_available' => true, 'category_id' => 3],
            ['name' => 'Cikur', 'price' => 3000, 'stock' => 100, 'image' => 'cikur.jpg', 'is_available' => true, 'category_id' => 3],

            // Kerupuk Category (id: 4)
            ['name' => 'Kerupuk Warna Warni Panjang', 'price' => 4000, 'stock' => 100, 'image' => 'kerupukpanjang.jpg', 'is_available' => true, 'category_id' => 4],
            ['name' => 'Kerupuk Bulat Warna Warni', 'price' => 4000, 'stock' => 100, 'image' => 'kerupukbulat.jpg', 'is_available' => true, 'category_id' => 4],
            ['name' => 'Kerupuk Seblak', 'price' => 4000, 'stock' => 100, 'image' => 'kerupuk-seblak.jpg', 'is_available' => true, 'category_id' => 4],
            ['name' => 'Kerupuk Lidah', 'price' => 4000, 'stock' => 100, 'image' => 'kerupuk-lidah.jpg', 'is_available' => true, 'category_id' => 4],
        ];

        foreach ($toppings as $topping) {
            Topping::create($topping);
        }
    }
}