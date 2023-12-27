<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 1,
            'store_id' => 6688,
            'phone' => '0394076444',
            'province_id' => '268',
            'province_name' => 'Hưng Yên',
            'district_id' => '2046',
            'district_name' => 'Huyện Văn Lâm',
            'ward_id' => '220901',
            'ward_name' => 'Thị trấn Như Quỳnh',
            'address_detail' => 'Nhà số 68'
        ]);
    }
}
