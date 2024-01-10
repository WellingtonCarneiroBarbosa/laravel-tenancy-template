<?php

namespace Database\Seeders\Tenant;

use App\Models\Application\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Tenant User',
            'email'    => 'default@tenant.com',
            'password' => 'password',
        ]);
    }
}
