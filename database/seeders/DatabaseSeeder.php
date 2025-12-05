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
            'title' => 'Bantu Bapak Yanto Melawan Kanker',
            'description' => 'Bapak Yanto, seorang ayah dari 3 anak, sedang berjuang melawan kanker stadium 3. Keluarga ini membutuhkan bantuan untuk biaya pengobatan dan operasi. Setiap donasi Anda akan sangat berarti untuk kesembuhan Bapak Yanto dan masa depan anak-anaknya.',
            'image' => 'campaigns/default1.jpg',
            'category' => 'Kemanusiaan',
            'organization_name' => 'Yayasan Peduli Sesama',
            'target_amount' => 100000000,
            'collected_amount' => 1900000,
            'end_date' => now()->addDays(10),
            'need_money' => true,
            'need_goods' => true,
            'need_volunteer' => true,
            'status' => 'active',
        ]);

        $campaign2 = Campaign::create([
            'user_id' => $user2->id,
            'title' => 'Renovasi Panti Asuhan Kasih Ibu',
            'description' => 'Panti Asuhan Kasih Ibu yang menampung 50 anak yatim piatu membutuhkan renovasi mendesak. Atap bocor dan dinding mulai rapuh mengancam keselamatan anak-anak. Mari bersama-sama membantu mereka mendapatkan tempat tinggal yang layak.',
            'image' => 'campaigns/default2.jpg',
            'category' => 'Panti Asuhan',
            'organization_name' => 'Panti Asuhan Kasih Ibu',
            'target_amount' => 50000000,
            'collected_amount' => 15000000,
            'end_date' => now()->addDays(15),
            'need_money' => true,
            'need_goods' => true,
            'need_volunteer' => true,
            'status' => 'active',
        ]);

        $campaign3 = Campaign::create([
            'user_id' => $user1->id,
            'title' => 'Bantuan Korban Banjir Bandung',
            'description' => 'Banjir bandang melanda kawasan Bandung Selatan dan mengakibatkan ratusan keluarga kehilangan tempat tinggal. Mereka membutuhkan bantuan darurat berupa makanan, pakaian, dan tempat berteduh. Setiap bantuan Anda akan disalurkan langsung kepada korban.',
            'image' => 'campaigns/default3.jpg',
            'category' => 'Bencana Alam',
            'organization_name' => 'Relawan Bencana Indonesia',
            'target_amount' => 200000000,
            'collected_amount' => 85000000,
            'end_date' => now()->addDays(5),
            'need_money' => true,
            'need_goods' => true,
            'need_volunteer' => true,
            'status' => 'active',
        ]);

        $campaign4 = Campaign::create([
            'user_id' => $user3->id,
            'title' => 'Program Beasiswa Anak Kurang Mampu',
            'description' => 'Program beasiswa untuk 100 anak kurang mampu agar dapat melanjutkan pendidikan ke jenjang SMA. Pendidikan adalah hak setiap anak, mari bantu mereka meraih mimpi melalui pendidikan yang layak.',
            'image' => 'campaigns/default4.jpg',
            'category' => 'Pendidikan',
            'organization_name' => 'Yayasan Pendidikan Untuk Semua',
            'target_amount' => 150000000,
            'collected_amount' => 45000000,
            'end_date' => now()->addDays(20),
            'need_money' => true,
            'need_goods' => false,
            'need_volunteer' => true,
            'status' => 'active',
        ]);

        $campaign5 = Campaign::create([
            'user_id' => $user2->id,
            'title' => 'Penghijauan Kawasan Gunung Merapi',
            'description' => 'Program penanaman 10.000 pohon di kawasan Gunung Merapi untuk mencegah erosi dan menjaga kelestarian alam. Mari bersama-sama menjaga bumi kita untuk generasi mendatang.',
            'image' => 'campaigns/default5.jpg',
            'category' => 'Lingkungan',
            'organization_name' => 'Jejakkebaikan',
            'target_amount' => 30000000,
            'collected_amount' => 12000000,
            'end_date' => now()->addDays(25),
            'need_money' => true,
            'need_goods' => true,
            'need_volunteer' => true,
            'status' => 'active',
        ]);

        // Create some donations for campaign 1
        MoneyDonation::create([
            'user_id' => $user2->id,
            'campaign_id' => $campaign1->id,
            'amount' => 500000,
            'message' => 'Semoga cepat sembuh Pak Yanto',
            'is_anonymous' => false,
        ]);

        MoneyDonation::create([
            'user_id' => $user3->id,
            'campaign_id' => $campaign1->id,
            'amount' => 200000,
            'message' => null,
            'is_anonymous' => true,
        ]);

        MoneyDonation::create([
            'user_id' => $user2->id,
            'campaign_id' => $campaign1->id,
            'amount' => 1000000,
            'message' => 'Semangat untuk keluarga Pak Yanto',
            'is_anonymous' => false,
        ]);

        GoodsDonation::create([
            'user_id' => $user2->id,
            'campaign_id' => $campaign1->id,
            'item_name' => 'Kursi Roda',
            'quantity' => 1,
            'description' => 'Kursi roda bekas kondisi masih bagus',
            'status' => 'received',
        ]);

        GoodsDonation::create([
            'user_id' => $user3->id,
            'campaign_id' => $campaign1->id,
            'item_name' => 'Selimut',
            'quantity' => 5,
            'description' => 'Selimut tebal untuk pasien',
            'status' => 'pending',
        ]);

        VolunteerDonation::create([
            'user_id' => $user3->id,
            'campaign_id' => $campaign1->id,
            'position' => 'Pengasuh Pasien',
            'message' => 'Saya bersedia membantu merawat Pak Yanto',
            'status' => 'approved',
        ]);

        // Create donations for campaign 2
        MoneyDonation::create([
            'user_id' => $user1->id,
            'campaign_id' => $campaign2->id,
            'amount' => 5000000,
            'message' => 'Untuk anak-anak panti',
            'is_anonymous' => false,
        ]);

        MoneyDonation::create([
            'user_id' => $user3->id,
            'campaign_id' => $campaign2->id,
            'amount' => 2000000,
            'message' => null,
            'is_anonymous' => false,
        ]);

        GoodsDonation::create([
            'user_id' => $user1->id,
            'campaign_id' => $campaign2->id,
            'item_name' => 'Semen',
            'quantity' => 50,
            'description' => '50 sak semen untuk renovasi',
            'status' => 'pending',
        ]);

        VolunteerDonation::create([
            'user_id' => $user1->id,
            'campaign_id' => $campaign2->id,
            'position' => 'Tukang Bangunan',
            'message' => 'Saya berpengalaman 10 tahun sebagai tukang',
            'status' => 'pending',
        ]);

        // Create donations for campaign 3
        MoneyDonation::create([
            'user_id' => $user2->id,
            'campaign_id' => $campaign3->id,
            'amount' => 10000000,
            'message' => 'Untuk korban banjir',
            'is_anonymous' => false,
        ]);

        GoodsDonation::create([
            'user_id' => $user2->id,
            'campaign_id' => $campaign3->id,
            'item_name' => 'Pakaian Layak Pakai',
            'quantity' => 100,
            'description' => '100 set pakaian untuk korban',
            'status' => 'received',
        ]);

        GoodsDonation::create([
            'user_id' => $user3->id,
            'campaign_id' => $campaign3->id,
            'item_name' => 'Makanan Instan',
            'quantity' => 200,
            'description' => '200 paket mie instan',
            'status' => 'pending',
        ]);

        echo "Database seeded successfully!\n";
        echo "Test accounts:\n";
        echo "Email: john@example.com | Password: password\n";
        echo "Email: jane@example.com | Password: password\n";
        echo "Email: ahmad@example.com | Password: password\n";
    }
}
