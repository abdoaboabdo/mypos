<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products=['product one','product two','product three'];
        foreach ($products as $index=>$product) {
            \App\Product::create([
                'category_id'=>$index+1,
                'purchase_price'=>100,
                'sale_price'=>122.5,
                'stock'=>1000,
                'ar'=>['name'=>$product,'description'=>$product.' description'],
                'en'=>['name'=>$product,'description'=>$product.' description'],
            ]);
        }
    }
}
