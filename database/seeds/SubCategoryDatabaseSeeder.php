<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class SubCategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<10;$i++) {
            $parent_id = $this->getRandomParentId();
        factory(Category::class)->create(['parent_id'=>$parent_id]);
        }
    }

    private function getRandomParentId()
    {
         $parent = \App\Models\Category::inRandomOrder()->first();
         return $parent;
    }
}
