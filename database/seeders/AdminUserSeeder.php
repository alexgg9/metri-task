<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Role::firstOrCreate(['name' => 'admin']);

        $user = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'email_verified_at' => now(),
                'password' => Hash::make('securepassword123'),
                'phone' => '123456789',
                'address' => 'Admin Street',
                'birthdate' => '1990-01-01',
                'avatar' => null,
            ]
        );

        $user->assignRole('admin');
    }
}
