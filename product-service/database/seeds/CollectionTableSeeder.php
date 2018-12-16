<?php

use Illuminate\Database\Seeder;

class CollectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\Collection::class, 3)->create()->each(function ($collection) {
            $collection->products()->saveMany(factory(App\Model\Product::class, 10)->make());
        });
    }
}
