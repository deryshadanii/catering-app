<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MenuItem;
use App\Models\MealPackage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@dapurmahasiswa.test'],
            [
                'name' => 'Admin DapurMahasiswa',
                'phone' => '081234567890',
                'address' => 'Sekitar Kampus UINSU Medan',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@dapurmahasiswa.test'],
            [
                'name' => 'Mahasiswa UINSU',
                'phone' => '081111222333',
                'address' => 'Kos sekitar UINSU Medan',
                'role' => 'customer',
                'password' => Hash::make('password'),
            ]
        );

        $menus = [
            [
                'name' => 'Ayam Geprek Original',
                'description' => 'Nasi, ayam geprek, lalapan, dan sambal.',
                'price' => 18000,
                'category' => 'Ayam',
                'available_date' => now()->toDateString(),
                'is_available' => true,
            ],
            [
                'name' => 'Ikan Dori Saus Lemon',
                'description' => 'Nasi, ikan dori, sayur tumis, dan sambal.',
                'price' => 18000,
                'category' => 'Ikan',
                'available_date' => now()->toDateString(),
                'is_available' => true,
            ],
            [
                'name' => 'Tumis Daging Teriyaki',
                'description' => 'Nasi, daging sapi, sayur, dan sambal.',
                'price' => 20000,
                'category' => 'Daging',
                'available_date' => now()->toDateString(),
                'is_available' => true,
            ],
            [
                'name' => 'Tahu Crispy Sambal Matah',
                'description' => 'Nasi, tahu crispy, lalapan, dan sambal matah.',
                'price' => 15000,
                'category' => 'Vegetarian',
                'available_date' => now()->toDateString(),
                'is_available' => true,
            ],
        ];

        foreach ($menus as $menu) {
            MenuItem::updateOrCreate(
                ['name' => $menu['name']],
                $menu
            );
        }

        $packages = [
            [
                'name' => 'Paket A - Seimbang',
                'type' => 'mingguan',
                'description' => 'Paket hemat untuk anak kos yang ingin makan teratur.',
                'price' => 105000,
                'benefits' => "Ikan 3x seminggu\nSayur setiap hari\nNasi + lauk + sayur\nPorsi pas dan mengenyangkan",
                'is_available' => true,
            ],
            [
                'name' => 'Paket B - Protein Boost',
                'type' => 'mingguan',
                'description' => 'Paket tinggi protein untuk mahasiswa aktif.',
                'price' => 115000,
                'benefits' => "Ayam 4 sampai 5x seminggu\nSayur setiap hari\nNasi + lauk + sayur\nCocok untuk aktivitas padat",
                'is_available' => true,
            ],
            [
                'name' => 'Paket C - Bulanan Hemat',
                'type' => 'bulanan',
                'description' => 'Paket bulanan untuk mahasiswa yang ingin hemat dan praktis.',
                'price' => 420000,
                'benefits' => "Makan lebih teratur\nHarga lebih hemat\nMenu berganti setiap minggu\nCocok untuk anak kos",
                'is_available' => true,
            ],
        ];

        foreach ($packages as $package) {
            MealPackage::updateOrCreate(
                ['name' => $package['name']],
                $package
            );
        }
    }
}
