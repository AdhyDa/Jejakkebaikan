<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Campaign;
use App\Models\MoneyDonation;
use App\Models\GoodsDonation;
use App\Models\VolunteerDonation;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create test users
        $user1 = User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password'),
            'address' => 'Jl. Contoh No. 123, Jakarta',
            'gender' => 'Pria',
        ]);

        $user2 = User::create([
            'name' => 'Jane Smith',
            'username' => 'janesmith',
            'email' => 'jane@example.com',
            'phone' => '081234567891',
            'password' => Hash::make('password'),
            'address' => 'Jl. Contoh No. 456, Bandung',
            'gender' => 'Wanita',
        ]);

        $user3 = User::create([
            'name' => 'Ahmad Rizki',
            'username' => 'ahmadrizki',
            'email' => 'ahmad@example.com',
            'phone' => '081234567892',
            'password' => Hash::make('password'),
            'address' => 'Jl. Contoh No. 789, Surabaya',
            'gender' => 'Pria',
        ]);

        // Create campaigns
        $campaign1 = Campaign::create([
            'user_id' => $user1->id,
            'title' => 'Bantu Pendidikan Anak Dhuafa',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud',
            'image' => 'campaign-1.jpg',
            'category' => 'Pendidikan',
            'organization_name' => 'Jejakkebaikan',
            'target_amount' => 1900000,
            'collected_amount' => 950000,
            'end_date' => now()->addDays(10),
            'need_money' => true,
            'need_goods' => true,
            'need_volunteer' => true,
            'status' => 'active',
        ]);

        $campaign2 = Campaign::create([
            'user_id' => $user2->id,
            'title' => 'Donasi Untuk Korban Bencana',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud',
            'image' => 'campaign-2.jpg',
            'category' => 'Bencana Alam',
            'organization_name' => 'Yayasan Peduli Kasih',
            'target_amount' => 2500000,
            'collected_amount' => 2300000,
            'end_date' => now()->addDays(3),
            'need_money' => true,
            'need_goods' => true,
            'need_volunteer' => true,
            'status' => 'active',
        ]);

        $campaign3 = Campaign::create([
            'user_id' => $user1->id,
            'title' => 'Bantuan Kemanusiaan Gaza',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud',
            'image' => 'campaign-3.jpg',
            'category' => 'Kemanusiaan',
            'organization_name' => 'Jejakkebaikan',
            'target_amount' => 5000000,
            'collected_amount' => 1200000,
            'end_date' => now()->addDays(0),
            'need_money' => true,
            'need_goods' => true,
            'need_volunteer' => true,
            'status' => 'active',
        ]);

        $campaign4 = Campaign::create([
            'user_id' => $user2->id,
            'title' => 'Penanaman 1000 Pohon',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud',
            'image' => 'campaign-4.jpg',
            'category' => 'Lingkungan',
            'organization_name' => 'Yayasan Hijau Indonesia',
            'target_amount' => 3000000,
            'collected_amount' => 2800000,
            'end_date' => now()->addDays(15),
            'need_money' => true,
            'need_goods' => true,
            'need_volunteer' => true,
            'status' => 'active',
        ]);

        $campaign5 = Campaign::create([
            'user_id' => $user1->id,
            'title' => 'Renovasi Panti Asuhan',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud',
            'image' => 'campaign-5.jpg',
            'category' => 'Panti Asuhan',
            'organization_name' => 'Jejakkebaikan',
            'target_amount' => 10000000,
            'collected_amount' => 9500000,
            'end_date' => now()->addDays(7),
            'need_money' => true,
            'need_goods' => true,
            'need_volunteer' => true,
            'status' => 'active',
        ]);

        $campaign6 = Campaign::create([
            'user_id' => $user3->id,
            'title' => 'Beasiswa Anak Berprestasi',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud',
            'image' => 'campaign-6.jpg',
            'category' => 'Pendidikan',
            'organization_name' => 'Yayasan Cerdas Bangsa',
            'target_amount' => 8000000,
            'collected_amount' => 2000000,
            'end_date' => now()->addDays(2),
            'need_money' => true,
            'need_goods' => true,
            'need_volunteer' => true,
            'status' => 'active',
        ]);

        echo "Database seeded successfully!\n";
        echo "Test accounts:\n";
        echo "Email: john@example.com | Password: password\n";
        echo "Email: jane@example.com | Password: password\n";
        echo "Email: ahmad@example.com | Password: password\n";
    }
}
