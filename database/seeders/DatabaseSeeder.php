<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product_category;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'telp' => '+62895331299363',
            'password' => Hash::make('asdasdasd')
        ]);
        Product_category::create([
            'name' => 'Makanan Berat',
        ]);
        Product_category::create([
            'name' => 'Makanan Ringan',
        ]);
        Product_category::create([
            'name' => 'Mebel',
        ]);
        Product_category::create([
            'name' => 'Fashion',
        ]);
        Product::create([
            'name' => 'Test User',
            'image' => '/images/self.jpg',
            'price' => '300000',
            'discon' => '30',
            'description' => 'bla bla',
        ]);
    }
}
