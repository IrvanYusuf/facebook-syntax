<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = fake();

        foreach (range(1, 20) as $i) {
            Branch::create([
                'name' => $faker->unique()->company(),
                'address' => $faker->address(),
                'phone' => $faker->phoneNumber(),
            ]);
        }
    }
}
