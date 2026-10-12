<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class BenchmarkSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Preparing benchmark data...');

        DB::disableQueryLog();

        $role = Role::updateOrCreate(
            [
                'name' => 'customer',
                'guard_name' => 'web',
            ],
            []
        );

        // Reset existing benchmark data.
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('transaction_items')->truncate();
        DB::table('transactions')->truncate();
        DB::table('products')->truncate();
        DB::table('users')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $checkRole = Role::where('name', 'customer')->first();

        if (!$checkRole) {
            $role = Role::updateOrCreate(
                [
                    'name' => 'customer',
                    'guard_name' => 'web',
                ],
                []
            );
        }


        $this->seedCustomers(100, $role);
        $this->seedProducts(10_000);
        $this->seedTransactions(100_000);
        $this->seedTransactionItems(500_000);

        $this->command->info('Benchmark seeding completed!');
    }

    private function seedCustomers(int $count, Role $role): void
    {
        $this->command->info('Seeding customers...');
        $password = Hash::make('password');

        for ($start = 1; $start <= $count; $start += 1000) {
            $rows = [];

            for ($i = $start; $i < min($start + 1000, $count + 1); $i++) {
                $rows[] = [
                    'name' => 'Customer ' . $i,
                    'email' => "customer{$i}@example.com",
                    'password' => $password,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }


            DB::table('users')->insert($rows);

            // Assign the "customer" role to the newly created users.
            $userIds = DB::table('users')->whereBetween('id', [$start, min($start + 1000 - 1, $count)])->pluck('id');
            $role->users()->attach($userIds);

            $this->command->info(
                'Inserted customers: ' .
                    min($start + 999, $count) .
                    '/' . $count
            );
        }
    }

    private function seedProducts(int $count): void
    {
        $this->command->info('Seeding products...');

        for ($start = 1; $start <= $count; $start += 1000) {
            $rows = [];

            for ($i = $start; $i < min($start + 1000, $count + 1); $i++) {
                $rows[] = [
                    'name' => 'Product ' . $i,
                    'sku' => 'SKU-' . str_pad((string) $i, 6, '0', STR_PAD_LEFT),
                    'category_id' => (($i - 1) % 100) + 1,
                    'price' => random_int(10_000, 1_000_000),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('products')->insert($rows);
            $this->command->info(
                'Inserted products: ' .
                    min($start + 999, $count) .
                    '/' . $count
            );
        }
    }

    private function seedTransactions(int $count): void
    {
        $this->command->info('Seeding transactions...');

        for ($start = 1; $start <= $count; $start += 1000) {
            $rows = [];

            for ($i = $start; $i < min($start + 1000, $count + 1); $i++) {
                $rows[] = [
                    'customer_id' => random_int(1, 100),
                    'invoice_number' => 'INV-' . str_pad((string) $i, 8, '0', STR_PAD_LEFT),
                    'status' => ['pending', 'paid', 'completed', 'cancelled'][random_int(0, 3)],
                    'total' => random_int(50_000, 5_000_000),
                    'transaction_date' => now()
                        ->subDays(random_int(0, 730))
                        ->toDateTimeString(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('transactions')->insert($rows);
            $this->command->info(
                'Inserted transactions: ' .
                    min($start + 999, $count) .
                    '/' . $count
            );
        }
    }

    private function seedTransactionItems(int $count): void
    {
        $this->command->info('Seeding transaction items...');

        for ($start = 1; $start <= $count; $start += 2000) {
            $rows = [];

            for ($i = $start; $i < min($start + 2000, $count + 1); $i++) {
                $rows[] = [
                    'transaction_id' => random_int(1, 100_000),
                    'product_id' => random_int(1, 10_000),
                    'quantity' => random_int(1, 10),
                    'unit_price' => random_int(10_000, 1_000_000),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('transaction_items')->insert($rows);
            $this->command->info(
                'Inserted transaction items: ' .
                    min($start + 1999, $count) .
                    '/' . $count
            );
        }
    }
}
