<?php

namespace Database\Seeders;

use App\InvoiceStatus;
use App\Models\Invoice;
use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all();
        $now = now();

        $invoices = [
            [
                'organization_id' => $organizations->first()?->id,
                'provider_invoice_id' => 'inv_growth_001',
                'status' => InvoiceStatus::PAID->value,
                'amount' => 149900,
                'currency' => 'INR',
                'issued_at' => $now->copy()->subDays(20),
                'due_at' => $now->copy()->subDays(10),
                'paid_at' => $now->copy()->subDays(9),
                'payload' => json_encode(['line_items' => [['plan' => 'Growth', 'qty' => 1]]]),
            ],
            [
                'organization_id' => $organizations->skip(1)->first()?->id,
                'provider_invoice_id' => 'inv_starter_002',
                'status' => InvoiceStatus::PENDING->value,
                'amount' => 0,
                'currency' => 'INR',
                'issued_at' => $now->copy()->subDays(5),
                'due_at' => $now->copy()->addDays(2),
                'paid_at' => null,
                'payload' => json_encode(['line_items' => [['plan' => 'Starter', 'qty' => 1]]]),
            ],
        ];

        Invoice::query()->truncate();
        Invoice::insert(
            collect($invoices)
                ->filter(fn ($invoice) => $invoice['organization_id'])
                ->map(function (array $invoice) {
                    return [
                        ...$invoice,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })->all()
        );
    }
}
