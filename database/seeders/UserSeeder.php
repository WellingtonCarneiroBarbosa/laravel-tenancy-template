<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name'     => 'Default User',
            'email'    => 'default@default.com',
            'password' => 'password',
        ]);

        $team = Team::create([
            'name'          => 'Default Team',
            'user_id'       => 1,
            'personal_team' => true,
        ]);

        $user->switchTeam($team);
    }
}
