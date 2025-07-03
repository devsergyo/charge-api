<?php

namespace Database\Seeders;

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
        // Seeder de clientes
        $this->call(CustomerSeeder::class);
        
        // Seeder de faturas (usando os clientes já criados)
        $this->call(InvoiceSeeder::class);
    }
}
