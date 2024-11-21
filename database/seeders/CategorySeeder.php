<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;  // Tambahkan baris ini
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Menambahkan data kategori
        Category::create(['name' => 'Furniture']);
        Category::create(['name' => 'Electronics']);
        Category::create(['name' => 'Clothing']);
    }
}