<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesPermissionSeeder::class);
        $this->call(BusinessSeeder::class);
        $this->call(RestaurantsSeeder::class);
        $this->call(ProvidersSFRTSeeder::class);
        $this->call(InvoiceSFRTSeeder::class);
        $this->call(PaymenMethodsFRTSeeder::class);
        $this->call(ExpensesSFRTSeeder::class);
    }
}
