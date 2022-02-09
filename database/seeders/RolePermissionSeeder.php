<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ask for db migration refresh, default is no
        if ($this->command->confirm('Do you wish to fresh migration before seeding, it will clear all old data?')) {
            // Call the php artisan migrate:fresh
            $this->command->call('migrate:fresh');
            $this->command->warn("Data cleared, starting from blank database.");
        }

        Role::create(['name' => 'user']);

        $admin = Role::create(['name' => 'admin']);

        // Create super administrator
        $this->createSuperAdministrator($admin);
    }

    private function createSuperAdministrator($admin)
    {
        $user = User::where('email', 'admin@movie.com')->first();

        if ($user === null) {

            $user = User::create([
                'name' => 'Administrator',
                'email' => 'admin@movie.com',
                'password' => Hash::make('password'),
            ]);

            $user->assignRole($admin);

            $this->command->info('Here is your administrator details to login:');
            $this->command->warn($user->email);
            $this->command->warn('Password is "password"');

        }
    }
}
