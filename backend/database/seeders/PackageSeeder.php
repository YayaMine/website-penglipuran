<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Paket 1',
                'description' => "• Tiket Masuk",
                'is_active' => true,
            ],
            [
                'name' => 'Paket 2',
                'description' => "• Tiket Masuk\n• Baju Adat",
                'is_active' => true,
            ],
            [
                'name' => 'Paket 3',
                'description' => "• Tiket Masuk\n• Baju Adat\n• Dokumentasi",
                'is_active' => true,
            ],
            [
                'name' => 'Paket 4',
                'description' => "• Tiket Masuk\n• Baju Adat\n• Dokumentasi\n• Tourguide",
                'is_active' => true,
            ],
        ];

        foreach ($packages as $package) {
            Package::updateOrCreate(
                ['name' => $package['name']],
                $package
            );
        }
    }
}
