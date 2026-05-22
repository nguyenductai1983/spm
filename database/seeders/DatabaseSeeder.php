<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'full_name' => 'System Administrator',
            'role' => 'admin',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
        ]);

        // Seed some customers
        \App\Models\KhachHang::create(['code' => 'IFT', 'name' => 'INTERNET FRANCE (THAILAND)']);
        \App\Models\KhachHang::create(['code' => 'IFS', 'name' => 'EMIS FRANCE']);
        \App\Models\KhachHang::create(['code' => 'AIC', 'name' => 'THOMPSON BLDG. MTLS.']);

        // Seed some goods
        \App\Models\HangHoa::create(['code' => 'IFT', 'name' => 'PE MONOFILAMENT RASCHEL MESH']);
        \App\Models\HangHoa::create(['code' => 'AIC', 'name' => 'PE SCAFFOLD DEBRIS MESH WITH BRASS
GROMMETS 185GSM']);
    }
}
