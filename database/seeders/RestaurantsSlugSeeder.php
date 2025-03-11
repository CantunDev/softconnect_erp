<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use Illuminate\Support\Str;

class RestaurantsSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurants = Restaurant::all();

        foreach ($restaurants as $restaurant) {
            if ($restaurant->isDirty('name') || empty($restaurant->slug)) {
                $restaurant->slug = Str::slug($restaurant->name);
                $restaurant->save();
            }
        }
    }
}
