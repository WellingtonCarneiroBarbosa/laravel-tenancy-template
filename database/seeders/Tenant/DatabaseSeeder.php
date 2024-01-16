<?php

namespace Database\Seeders\Tenant;

use App\Models\Application\OnBoardingForm;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (app()->environment('local')) {
            $this->call([
                UserSeeder::class,
            ]);

            OnBoardingForm::factory(1, [
                'cicle' => 1,
            ])->create();
        }
    }
}
