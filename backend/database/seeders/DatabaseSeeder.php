<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
{
    $this->call([
        UserSeeder::class,
        PackageSeeder::class,
        TicketCategorySeeder::class,
        TicketVersionSeeder::class,
        OrderSeeder::class,
    ]);
}

}
