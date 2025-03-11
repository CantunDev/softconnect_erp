<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $business = Business::create([
            'name' => 'Corazon Contento',
            'business_name' => 'Grupo Restaurantero Corazon Contento',
            'business_address' => 'Ciudad del Carmen',
            'rfc' => 'GRC3432093243',
            'telephone' => '9823938423',
            'business_line' => 'Restaurantero',
            'email' => 'hola@ccontento.com',
            'country' => 'Mexico',
            'state' => 'Campeche',
            'city' => 'Cd del Carmen',
        ]);
        $business = Business::create([
            'name' => 'Grupo Paralelo 18',
            'business_name' => 'Grupo Restaurantero Paralelo 18',
            'business_address' => 'Ciudad del Carmen',
            'rfc' => 'GRPCS1231243',
            'telephone' => '9832432423',
            'business_line' => 'Restaurantero',
            'email' => 'hola@paralelo.com',
            'country' => 'Mexico',
            'state' => 'Campeche',
            'city' => 'Cd del Carmen',
        ]);

    }
}
