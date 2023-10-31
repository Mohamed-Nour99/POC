<?php

namespace Src\Domain\Category\Database\Seeds;

use Illuminate\Database\Seeder;
use Src\Domain\Category\Entities\Category;

class CategoryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Category::factory(1000)->times(50);
    }
}
