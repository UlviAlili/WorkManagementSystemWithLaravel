<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create.blade.php();

        \App\Models\User::factory()->create([
//            'name' => 'Ulvi Alili',
//            'email' => 'ulvi96alili@gmail.com',
//            'status' => 'admin',
//            'password' => bcrypt('Alili1907'),
        ]);
    }
}
