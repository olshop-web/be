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
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'telp' => '+62895331299363',
            'status' => 'active',
            'image' => '/images/self.jpg',
            'image_original' => '/original/self.jpg',
            'password' => Hash::make('asdasdasd')
        ]);
        $categoryFirst = Product_category::create([
            'name' => 'Makanan Berat',
        ]);
        $categorySecond = Product_category::create([
            'name' => 'Makanan Ringan',
        ]);
        $categoryThree = Product_category::create([
            'name' => 'Mebel',
        ]);
        $categoryFour = Product_category::create([
            'name' => 'Fashion',
        ]);
        Product::create([
            'name' => 'Test User',
            'image' => '/images/self.jpg',
            'image_original' => '/original/self.jpg',
            'price' => '300000',
            'discon' => '30',
            'description' => 'bla bla',
            'status' => 'active',
            'product_category_id' => $categoryThree->id,
            'user_id' => $user->id,
            'popular' => 0,
        ]);
        Product::create([
            'name' => 'Test User',
            'image' => '/images/self.jpg',
            'image_original' => '/original/self.jpg',
            'price' => '300000',
            'discon' => '30',
            'description' => 'bla bla',
            'status' => 'active',
            'product_category_id' => $categoryFirst->id,
            'user_id' => $user->id,
            'popular' => 0,
        ]);
    }
}
