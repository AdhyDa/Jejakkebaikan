<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Campaign;
use App\Models\CampaignGoodsNeed;
use App\Models\CampaignVolunteerNeed;
use App\Models\MoneyDonation;
use App\Models\GoodsDonation;
use App\Models\VolunteerDonation;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create test users
        $user1 = User::firstOrCreate([
            'username' => 'AdhyDa',
        ], [
            'name' => 'Adhyaksa Daudi',
            'email' => 'adhyaksa209@gmail.com',
            'phone' => '0895396048445',
            'password' => Hash::make('akuAdmin'),
            'address' => 'Jl. Semarang no. 5',
            'gender' => 'Pria',
            'role' => 'admin',
        ]);

        $user2 = User::firstOrCreate([
            'username' => 'userbiasa',
        ], [
            'name' => 'User Biasa',
            'email' => 'user@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password'),
            'address' => 'Jl. Contoh no. 1',
            'gender' => 'Pria',
            'role' => 'user',
        ]);

        // Create campaigns
        $campaign1 = Campaign::firstOrCreate([
            'title' => 'Pulihkan Senyum Penyintas: Bangun Kembali Desa Sukamaju Pasca Gempa',
            'user_id' => $user1->id,
            'description' => 'Gempa berkekuatan 5.6 SR telah meluluhlantakkan ratusan rumah. Warga kini tidur di tenda pengungsian dengan fasilitas minim. Mari bantu mereka bangkit sebelum musim hujan tiba.',
            'image' => 'campaign-1.jpg',
            'category' => 'Bencana Alam',
            'organization_name' => 'Jejakkebaikan',
            'target_amount' => 50000000,
            'collected_amount' => 50000000,
            'end_date' => now()->addDays(5),
            'need_money' => true,
            'need_goods' => true,
            'need_volunteer' => true,
            'status' => 'active',
        ]);

        // Add goods needs for campaign1
        if ($campaign1->need_goods) {
            CampaignGoodsNeed::firstOrCreate([
                'campaign_id' => $campaign1->id,
                'item_name' => 'Bahan Bangunan',
                'quantity_needed' => 500,
                'quantity_received' => 200,
            ]);
            CampaignGoodsNeed::firstOrCreate([
                'campaign_id' => $campaign1->id,
                'item_name' => 'Makanan Pokok',
                'quantity_needed' => 1000,
                'quantity_received' => 300,
            ]);
        }

        // Add volunteer needs for campaign1
        if ($campaign1->need_volunteer) {
            CampaignVolunteerNeed::firstOrCreate([
                'campaign_id' => $campaign1->id,
                'position' => 'Koordinator Rehabilitasi',
                'slots_needed' => 10,
                'slots_filled' => 5,
                'description' => 'Mengkoordinasi pembangunan kembali rumah warga',
            ]);
            CampaignVolunteerNeed::firstOrCreate([
                'campaign_id' => $campaign1->id,
                'position' => 'Relawan Medis',
                'slots_needed' => 5,
                'slots_filled' => 2,
                'description' => 'Memberikan bantuan medis dasar',
            ]);
        }

        $campaign2 = Campaign::firstOrCreate([
            'title' => 'Sekolah Hampir Roboh: Bantu Renovasi Atap SD Inpres Pelosok Negeri',
        ], [
            'user_id' => $user1->id,
            'description' => 'Sudah 5 tahun siswa SD ini belajar dengan rasa was-was karena atap kelas yang bocor dan kayu yang lapuk. Jangan biarkan semangat belajar mereka runtuh bersama bangunan sekolahnya.',
            'image' => 'campaign-2.jpg',
            'category' => 'Pendidikan',
            'organization_name' => 'Yayasan Peduli Kasih',
            'target_amount' => 25000000,
            'collected_amount' => 3000000,
            'end_date' => now()->addDays(30),
            'need_money' => true,
            'need_goods' => true,
            'need_volunteer' => false,
            'status' => 'active',
            'slug' => 'sekolah-hampir-roboh-bantu-renovasi-atap-sd-inpres-pelosok-negeri',
        ]);

        $campaign3 = Campaign::firstOrCreate([
            'title' => 'Penuhi Gizi 50 Anak Yatim Panti Asuhan Kasih Bunda',
        ], [
            'user_id' => $user1->id,
            'description' => 'Stok beras di gudang panti menipis. Anak-anak membutuhkan asupan gizi yang cukup untuk tumbuh kembang mereka. Mari jadi kakak asuh mereka untuk satu hari.',
            'image' => 'campaign-3.jpg',
            'category' => 'Panti Asuhan',
            'organization_name' => 'Jejakkebaikan',
            'target_amount' => 10000000,
            'collected_amount' => 2170000,
            'end_date' => now()->addDays(0),
            'need_money' => true,
            'need_goods' => false,
            'need_volunteer' => false,
            'status' => 'active',
        ]);

        $campaign4 = Campaign::firstOrCreate([
            'title' => 'Aksi Bersih Pantai: Selamatkan Penyu dari Jeratan Plastik',
        ], [
            'user_id' => $user1->id,
            'description' => 'Pantai indah ini kini tertutup sampah kiriman. Banyak biota laut mati karena memakan plastik. Kita butuh aksi nyata membersihkan rumah mereka sekarang juga.',
            'image' => 'campaign-4.jpg',
            'category' => 'Lingkungan',
            'organization_name' => 'Yayasan Hijau Indonesia',
            'target_amount' => 7000000,
            'collected_amount' => 1570000,
            'end_date' => now()->addDays(30),
            'need_money' => true,
            'need_goods' => false,
            'need_volunteer' => true,
            'status' => 'active',
        ]);

        // Add volunteer needs for campaign4
        if ($campaign4->need_volunteer) {
            CampaignVolunteerNeed::firstOrCreate([
                'campaign_id' => $campaign4->id,
                'position' => 'Koordinator Pembersihan',
                'slots_needed' => 20,
                'slots_filled' => 8,
                'description' => 'Mengkoordinasi kegiatan pembersihan pantai',
            ]);
            CampaignVolunteerNeed::firstOrCreate([
                'campaign_id' => $campaign4->id,
                'position' => 'Relawan Lapangan',
                'slots_needed' => 50,
                'slots_filled' => 15,
                'description' => 'Melakukan pembersihan sampah di pantai',
            ]);
        }

        $campaign5 = Campaign::firstOrCreate([
            'title' => 'Bantu Mbah Karti, Lansia Sebatang Kara Melawan Sakit di Usia Senja',
        ], [
            'user_id' => $user1->id,
            'description' => 'Mbah Karti (80th) tinggal sendiri di gubuk reyot. Penglihatannya mulai kabur dan beliau kesulitan berjalan. Tetangga hanya bisa membantu seadanya.',
            'image' => 'campaign-5.jpg',
            'category' => 'Kemanusiaan',
            'organization_name' => 'Jejakkebaikan',
            'target_amount' => 5000000,
            'collected_amount' => 1200000,
            'end_date' => now()->addDays(17),
            'need_money' => true,
            'need_goods' => true,
            'need_volunteer' => true,
            'status' => 'active',
        ]);

        // Add goods needs for campaign5
        if ($campaign5->need_goods) {
            CampaignGoodsNeed::firstOrCreate([
                'campaign_id' => $campaign5->id,
                'item_name' => 'Obat-obatan',
                'quantity_needed' => 50,
                'quantity_received' => 20,
            ]);
            CampaignGoodsNeed::firstOrCreate([
                'campaign_id' => $campaign5->id,
                'item_name' => 'Makanan Sehat',
                'quantity_needed' => 100,
                'quantity_received' => 30,
            ]);
        }

        // Add volunteer needs for campaign5
        if ($campaign5->need_volunteer) {
            CampaignVolunteerNeed::firstOrCreate([
                'campaign_id' => $campaign5->id,
                'position' => 'Pendamping Lansia',
                'slots_needed' => 3,
                'slots_filled' => 1,
                'description' => 'Membantu kegiatan sehari-hari Mbah Karti',
            ]);
            CampaignVolunteerNeed::firstOrCreate([
                'campaign_id' => $campaign5->id,
                'position' => 'Relawan Kesehatan',
                'slots_needed' => 2,
                'slots_filled' => 0,
                'description' => 'Memantau kondisi kesehatan Mbah Karti',
            ]);
        }

        $campaign6 = Campaign::firstOrCreate([
            'title' => 'Bangun Jendela Dunia: Dirikan Taman Baca Pelita Harapan di Desa Nelayan',
        ], [
            'user_id' => $user1->id,
            'description' => 'Anak-anak di Desa Pesisir ini harus menempuh jarak 20 km hanya untuk meminjam buku cerita. Sebuah gudang tua milik desa telah diizinkan untuk diubah menjadi perpustakaan mini yang nyaman. Mari kita isi rak-rak kosong itu dengan ilmu dan imajinasi.',
            'image' => 'campaign-6.jpg',
            'category' => 'Pendidikan',
            'organization_name' => 'Yayasan Cerdas Bangsa',
            'target_amount' => 20000000,
            'collected_amount' => 7120000,
            'end_date' => now()->addDays(46),
            'need_money' => true,
            'need_goods' => false,
            'need_volunteer' => false,
            'status' => 'active',
        ]);

        echo "Database seeded successfully!\n";
        echo "Test accounts:\n";
        echo "Email: adhyaksa209@gmail.com | Password: akuAdmin";
    }
}
