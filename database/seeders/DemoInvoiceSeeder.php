<?php

namespace Database\Seeders;

use App\Services\InvoiceWriter;
use Illuminate\Database\Seeder;

class DemoInvoiceSeeder extends Seeder
{
    public function run(InvoiceWriter $writer): void
    {
        foreach ([
            ['Studio Aksara', 'paid', 'Identitas visual & pedoman merek', 6500000, -8],
            ['PT Ruang Karya', 'unpaid', 'Pengembangan situs perusahaan', 12500000, -3],
            ['Kopi Senja', 'draft', 'Desain kemasan produk', 2750000, 14],
            ['Nusa Creative', 'unpaid', 'Desain antarmuka aplikasi', 4800000, 7],
            ['CV Bentang Arsitek', 'paid', 'Pemeliharaan situs bulanan', 1500000, 3],
        ] as [$customer, $status, $item, $price, $days]) {
            $writer->save([
                'sender_name' => 'Studio Invoicely (Contoh)',
                'sender_address' => "Jl. Merdeka No. 21\nBandung, Jawa Barat 40115",
                'customer_name' => $customer.' (Contoh)',
                'customer_address' => "Jl. Asia Afrika No. 8\nBandung, Jawa Barat",
                'invoice_date' => today()->subDays(14)->format('Y-m-d'),
                'due_date' => today()->addDays($days)->format('Y-m-d'),
                'tax_percentage' => '11', 'status' => $status,
                'notes' => 'Data demonstrasi fiktif. Terima kasih atas kepercayaan Anda.',
                'items' => [['item_name' => $item, 'quantity' => 1, 'unit_price' => $price]],
            ]);
        }
    }
}
