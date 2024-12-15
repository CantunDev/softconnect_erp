<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $business = Restaurant::create([
            'name' => 'Sagrado Comal',
            'description' => 'Servidor Sagrado Comal Ciudad del Carmen',
            'ip' => '192.168.193.226',
            'database' => 'softrestaurant10'
        ]);
        $business = Restaurant::create([
            'name' => 'Perro Cafe',
            'description' => 'Servidor Perro Cafe Ciudad del Carmen',
            'ip' => '192.168.193.216',
            'database' => 'softrestaurant11'
        ]);
        $business = Restaurant::create([
            'name' => 'Paralelo 18',
            'description' => 'Servidor Paralelo 18 Ciudad del Carmen',
            'ip' => '192.168.193.73',
            'database' => 'softrestaurant11'
        ]);
        $business = Restaurant::create([
            'name' => 'Brazilia',
            'description' => 'Servidor Brazilia Merida Yucatan',
            'ip' => '192.168.193.29',
            'database' => 'softrestaurant10'
        ]);

    }
}
