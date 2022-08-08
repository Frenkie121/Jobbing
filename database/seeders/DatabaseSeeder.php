<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\{Category, Customer, Job, Tag};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            StatusSeeder::class,
        ]);

        Category::factory(15)
                ->hasSubCategories(fake()->numberBetween(0, 5))
                ->create();

        Customer::factory(3)
            ->hasJobs(fake()->randomDigit())
            ->create();

        $jobs = Job::all();
        $jobs->each(fn($item) => $item->statuses()->attach(1));

        $tags = Tag::factory(20)->create();
        $jobs->each(fn($item) => $item->tags()->attach([1, 2, 3]));
    }
}
