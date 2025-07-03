<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();

        if ($customers->isEmpty()) {
            return;
        }

        $customers->each(function (Customer $customer) {
            $invoiceCount = rand(2, 5);
            
            Invoice::factory()
                ->count($invoiceCount)
                ->forCustomer($customer->id)
                ->create();

            if (rand(1, 100) <= 30) {
                Invoice::factory()
                    ->forCustomer($customer->id)
                    ->overdue()
                    ->create();
            }
        });
    }
}
