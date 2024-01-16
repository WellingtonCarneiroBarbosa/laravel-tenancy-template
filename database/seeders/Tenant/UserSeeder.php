<?php

namespace Database\Seeders\Tenant;

use App\Models\Application\User;
use App\Models\Application\UserNote;
use App\Models\User as ModelsUser;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name'     => 'Tenant User',
            'email'    => 'default@tenant.com',
            'cpf'      => '86009088097',
            'password' => 'password',
        ]);

        $count = 0;

        do {
            $count++;

            UserNote::factory(5, [
                'date' => fake()->date(),
            ])->for(
                $user,
            )->for(
                ModelsUser::firstOrFail(),
                'createdBy',
            )->create();
        } while ($count < 5);
    }
}
