<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Sandwich cookies (£3.50)
        $sandwiches = [
            [
                'name' => 'Love Sandwich',
                'description' => 'Red Velvet cookie sandwich with vanilla and strawberry brigadeiro in the middle.',
                'price' => 3.50,
                'category' => 'sandwich',
                'image_path' => 'assets/img/sandu-love.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Ninho Sandwich',
                'description' => 'Milk powder brigadeiro with Nutella in the middle. Optionally topped with milk powder outside.',
                'price' => 3.50,
                'category' => 'sandwich',
                'image_path' => 'assets/img/sandu-ninho.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Chocolate Sandwich',
                'description' => 'Chocolate brigadeiro sandwich filled with chocolate chips on the outside.',
                'price' => 3.50,
                'category' => 'sandwich',
                'image_path' => 'assets/img/sandu-choco.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Duo Sandwich',
                'description' => 'Half chocolate brigadeiro and half Ninho brigadeiro for a perfect duo.',
                'price' => 3.50,
                'category' => 'sandwich',
                'image_path' => 'assets/img/sandu-duo.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Pistachio Sandwich',
                'description' => 'Pistachio cookie sandwich filled with creamy pistachio brigadeiro.',
                'price' => 3.50,
                'category' => 'sandwich',
                'image_path' => 'assets/img/sandu-pista.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Cookies (padrão £2.70) + especiais
        $cookies = [
            [
                'name' => 'The golden bites',
                'description' => 'Special trio box with Kinder, Nutella & Lotus. You can request all 3 same flavour in Observations.',
                'price' => 12.50,
                'category' => 'cookie',
                'image_path' => 'assets/img/new-product-2.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Pot Classic Cookies with Nutella',
                'description' => 'A creamy Nutella pot with classic cookie pieces. Perfect as an add-on or a quick treat.',
                'price' => 4.00,
                'category' => 'cookie',
                'image_path' => 'assets/img/new-product-1.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Alpino Black',
                'description' => 'Cookie with chunks of smooth white chocolate and rich semi-sweet chocolate.',
                'price' => 2.70,
                'category' => 'cookie',
                'image_path' => 'assets/img/alpino_black.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Lotus Cookie',
                'description' => 'A delightful cookie filled with Lotus cream, perfect for fans of unique flavours.',
                'price' => 2.70,
                'category' => 'cookie',
                'image_path' => 'assets/img/cookie-lutus.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Lindt Cookie',
                'description' => 'An irresistible cookie filled with the rich Lindor chocolate by Lindt.',
                'price' => 2.70,
                'category' => 'cookie',
                'image_path' => 'assets/img/cookie-lindt.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Oreo Cookie',
                'description' => 'A crunchy cookie with an irresistible blend of Oreo biscuit and chocolate.',
                'price' => 2.70,
                'category' => 'cookie',
                'image_path' => 'assets/img/cookie-oreo.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => '100% Cocoa Cookie',
                'description' => 'An intensely flavoured cookie with a blend of 100% pure cocoa.',
                'price' => 2.70,
                'category' => 'cookie',
                'image_path' => 'assets/img/cookie-cacau.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'KitKat Cookie',
                'description' => 'A crunchy cookie filled with the unmistakable crunch of KitKat.',
                'price' => 2.70,
                'category' => 'cookie',
                'image_path' => 'assets/img/cookie-kitkat.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Churro Cookie',
                'description' => 'A perfect combination of churro biscuit and dulce de leche.',
                'price' => 2.70,
                'category' => 'cookie',
                'image_path' => 'assets/img/cookie-churro.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Traditional Cookie',
                'description' => 'The classic cookie with a timeless taste.',
                'price' => 2.70,
                'category' => 'cookie',
                'image_path' => 'assets/img/cookie-tradicional.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Kinder Bueno Cookie',
                'description' => 'A cookie filled with hazelnut cream inspired by the famous Kinder Bueno.',
                'price' => 2.70,
                'category' => 'cookie',
                'image_path' => 'assets/img/cookie-avela.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Red Velvet Cookie',
                'description' => 'An elegant Red Velvet cookie with a rich chocolate ganache filling.',
                'price' => 2.70,
                'category' => 'cookie',
                'image_path' => 'assets/img/cookie-ganache.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Nutella Cookie',
                'description' => 'A cookie filled with the classic Nutella hazelnut cream for an unmistakable treat.',
                'price' => 2.70,
                'category' => 'cookie',
                'image_path' => 'assets/img/cookie-nutella.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Dubai Cookie',
                'description' => 'A refined cookie filled with pistachio cream, inspired by the exotic flavours of Dubai.',
                'price' => 2.70,
                'category' => 'cookie',
                'image_path' => 'assets/img/cookie-pistache.jpg',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Drinks
        $drinks = [
            [
                'name' => 'Coke',
                'description' => null,
                'price' => 1.10,
                'category' => 'drink',
                'image_path' => 'assets/img/coke.png',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Fanta',
                'description' => null,
                'price' => 1.10,
                'category' => 'drink',
                'image_path' => 'assets/img/fanta-laranja.png',
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $all = [...$sandwiches, ...$cookies, ...$drinks];

        // upsert evita duplicar se já existir seed anterior (usa 'name' como chave)
        DB::table('products')->upsert(
            $all,
            ['name'],
            ['description', 'price', 'category', 'image_path', 'active', 'updated_at']
        );
    }
}
