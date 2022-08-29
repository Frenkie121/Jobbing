<?php

namespace Database\Seeders;

use App\Models\Freelance;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'email' => 'admin@job.com',
            'role_id' => 1,
            'is_active' => 1
        ]);
    
        for ($i=1; $i < 4; $i++) { 
            User::factory()->create([
                'userable_id' => $i,
                'userable_type' => 'App\Models\Customer',
                'email' => 'customer' . $i . '@job.com',
                'role_id' => 2
            ]);
        
            Freelance::create();
            User::factory()->create([
                'userable_id' => $i,
                'userable_type' => 'App\Models\Freelance',
                'email' => 'freelance' . $i . '@job.com',
                'role_id' => 3
            ]);   
        }
    }
}
