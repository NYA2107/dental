<?php

use Illuminate\Database\Seeder;
use App\Antrian;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AntrianTableSeeder::class);
        $this->command->info('Antrian seeded!');
    }
}

class AntrianTableSeeder extends Seeder {

    public function run()
    {
        Antrian::create(['antrian' => json_encode([])]);
    }

}
