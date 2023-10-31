<?php

namespace Src\Domain\Product\Database\Seeds;

use Illuminate\Database\Seeder;
use Src\Domain\Product\Entities\Product;

class ProductTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Product::factory(1000)->times(50);
    }
}
