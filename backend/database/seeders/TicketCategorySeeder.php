<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketCategory;

class TicketCategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Lokal', 'Mancanegara'] as $name) {
            TicketCategory::updateOrCreate(
                ['name' => $name],
                ['name' => $name]
            );
        }
    }
}
