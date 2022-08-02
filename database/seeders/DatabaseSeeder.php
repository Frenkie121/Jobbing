<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
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
        
        $this->call([
            RoleSeeder::class,
        ]);
        
        User::factory()->create([
            'email' => 'admin@job.com',
            'role_id' => 1
        ]);
        
        User::factory(10)->create();
    }
}
