<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Category;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete();
        DB::table('products')->delete();
        factory(Product::class, 10)->create()->each(function ($product) {
            $product->categories()->save(factory(Category::class)->make());
        });
    }
}
