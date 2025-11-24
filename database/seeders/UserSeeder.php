<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'login' => 'vinar1',
                'password_hash' => Hash::make('heslo123'),
                'email' => 'vinic@mail.com',
                'name' => 'Andrej',
                'last_name' => 'Vinič',
                'address' => 'Vinohradnícka 5, Modra',
                'role' => 'winemaker',
                'is_active' => true,
                'date_of_registration' => now()->subDays(180),
            ],
            [
                'login' => 'pracovnik1',
                'password_hash' => Hash::make('heslo123'),
                'email' => 'robotnik@mail.com',
                'name' => 'Jozef',
                'last_name' => 'Robotník',
                'address' => 'Hlavná 12, Pezinok',
                'role' => 'worker',
                'is_active' => true,
                'date_of_registration' => now()->subDays(90),
            ],
            [
                'login' => 'zakaznik1',
                'password_hash' => Hash::make('heslo123'),
                'email' => 'kupil@mail.com',
                'name' => 'Peter',
                'last_name' => 'Kúpil',
                'address' => 'Nová 8, Bratislava',
                'role' => 'customer',
                'is_active' => true,
                'date_of_registration' => now()->subDays(30),
            ],
            [
                'login' => 'zakaznik2',
                'password_hash' => Hash::make('heslo123'),
                'email' => 'novakova@mail.com',
                'name' => 'Mária',
                'last_name' => 'Nováková',
                'address' => 'Slnečná 15, Trnava',
                'role' => 'visitor',
                'is_active' => true,
                'date_of_registration' => now()->subDays(10),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        $winemaker = User::find('vinar1');
        $winemaker->assignRole('winemaker');

        $worker = User::find('pracovnik1');
        $worker->assignRole('worker');
        $customer = User::find('zakaznik1');
        $customer->assignRole('customer');
        $visitor = User::find('zakaznik2');
        $visitor->assignRole('visitor');

        echo "✓ Vytvorených " . count($users) . " testovacích používateľov\n";
    }
}
