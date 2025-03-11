<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Business;
use Illuminate\Support\Str;

class BusinessSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $businesses = Business::all();

        foreach ($businesses as $business) {
            // Verificar si el nombre ha cambiado o el slug está vacío
            if ($business->isDirty('name') || empty($business->slug)) {
                // Generar el slug usando la lógica del modelo
                $business->slug = Str::slug($business->name);

                // Guardar el negocio (esto activará el evento "saving" en el modelo)
                $business->save();
            }
        }
    }
}
