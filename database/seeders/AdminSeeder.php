<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'login' => 'admin',
            'password_hash' => Hash::make('admin123'),
            'email' => '[email protected]',
            'name' => 'Hlavný',
            'last_name' => 'Administrátor',
            'address' => 'Vinárstvo 1, Bratislava',
            'role' => 'admin',
            'is_active' => true,
            'date_of_registration' => now(),
        ]);

        $admin = User::find('admin');
        $admin->assignRole('admin');

        echo "✓ Admin používateľ vytvorený (login: admin, heslo: admin123)\n";
    }
}
