<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Business;

class BusinessSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los negocios
        // $businesses = Business::all();

        // foreach ($businesses as $business) {
        //     // Generar el slug basado en el nombre
        //     $slug = Business::generateSlug($business->name);
        //     static::creating(function ($business) {
        //         $business->slug = Str::slug($business->name);
        //     });
        //     // Actualizar el campo slug
        //     $business->update(['slug' => $slug]);
        //     static::creating(function ($business) {
        //         $business->slug = Str::slug($business->name);
        //     });
        // }
    }
}
