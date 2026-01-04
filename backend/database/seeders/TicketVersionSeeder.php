<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;
use App\Models\TicketCategory;
use App\Models\TicketVersion;

class TicketVersionSeeder extends Seeder
{
    public function run(): void
    {
        $lokal = TicketCategory::where('name', 'Lokal')->first();
        $manca = TicketCategory::where('name', 'Mancanegara')->first();

        $data = [
            'Paket 1' => [
                [$lokal, 'Dewasa', 50000],
                [$lokal, 'Anak', 30000],
                [$manca, 'Dewasa', 150000],
                [$manca, 'Anak', 100000],
            ],
            'Paket 2' => [
                [$lokal, 'Dewasa', 75000],
                [$lokal, 'Anak', 50000],
                [$manca, 'Dewasa', 200000],
                [$manca, 'Anak', 150000],
            ],
            'Paket 3' => [
                [$lokal, 'Dewasa', 120000],
                [$lokal, 'Anak', 90000],
                [$manca, 'Dewasa', 350000],
                [$manca, 'Anak', 250000],
            ],
            'Paket 4' => [
                [$lokal, 'Dewasa', 200000],
                [$lokal, 'Anak', 150000],
                [$manca, 'Dewasa', 450000],
                [$manca, 'Anak', 350000],
            ],
        ];

        foreach ($data as $packageName => $tickets) {
            $package = Package::where('name', $packageName)->first();

            foreach ($tickets as [$category, $name, $price]) {
                TicketVersion::updateOrCreate(
                    [
                        'package_id' => $package->id,
                        'ticket_category_id' => $category->id,
                        'name' => $name,
                    ],
                    [
                        'price' => $price,
                    ]
                );
            }
        }
    }
}
