<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->input('kategori', []);
        $statusDefault = $request->input('status');
        $urutkanDefault = $request->input('urutkan');
        $organisasi = $request->input('organisasi', []);
        $search       = trim($request->input('search', ''));

        $allCampaigns = [
            [
                'id' => 1,
                'title' => 'Bantu Pendidikan Anak Dhuafa',
                'organization' => 'Jejakkebaikan',
                'organization_logo' => 'org-logo.png',
                'verified' => true,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud',
                'link' => 'Lihat Selengkapnya',
                'image' => 'campaign-1.jpg',
                'target_amount' => 1900000,
                'collected_amount' => 950000,
                'target' => 'Rp 1.900.000',
                'collected' => 'Rp 950.000',
                'days_remaining' => 10,
                'days' => '10',
                'days_label' => 'Hari lagi',
                'category' => 'Pendidikan',
                'created_at' => '2025-01-15'
            ],
            [
                'id' => 2,
                'title' => 'Donasi Untuk Korban Bencana',
                'organization' => 'Yayasan Peduli Kasih',
                'organization_logo' => 'org-logo-2.png',
                'verified' => false,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud',
                'link' => 'Lihat Selengkapnya',
                'image' => 'campaign-2.jpg',
                'target_amount' => 2500000,
                'collected_amount' => 2300000,
                'target' => 'Rp 2.500.000',
                'collected' => 'Rp 2.300.000',
                'days_remaining' => 3,
                'days' => '3',
                'days_label' => 'Hari lagi',
                'category' => 'Bencana Alam',
                'created_at' => '2025-01-20'
            ],
            [
                'id' => 3,
                'title' => 'Bantuan Kemanusiaan Gaza',
                'organization' => 'Jejakkebaikan',
                'organization_logo' => 'org-logo.png',
                'verified' => true,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud',
                'link' => 'Lihat Selengkapnya',
                'image' => 'campaign-3.jpg',
                'target_amount' => 5000000,
                'collected_amount' => 1200000,
                'target' => 'Rp 5.000.000',
                'collected' => 'Rp 1.200.000',
                'days_remaining' => 0,
                'days' => '0',
                'days_label' => 'Selesai',
                'category' => 'Kemanusiaan',
                'created_at' => '2024-12-01'
            ],
            [
                'id' => 4,
                'title' => 'Penanaman 1000 Pohon',
                'organization' => 'Yayasan Hijau Indonesia',
                'organization_logo' => 'org-logo-4.png',
                'verified' => false,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud',
                'link' => 'Lihat Selengkapnya',
                'image' => 'campaign-4.jpg',
                'target_amount' => 3000000,
                'collected_amount' => 2800000,
                'target' => 'Rp 3.000.000',
                'collected' => 'Rp 2.800.000',
                'days_remaining' => 15,
                'days' => '15',
                'days_label' => 'Hari lagi',
                'category' => 'Lingkungan',
                'created_at' => '2025-01-10'
            ],
            [
                'id' => 5,
                'title' => 'Renovasi Panti Asuhan',
                'organization' => 'Jejakkebaikan',
                'organization_logo' => 'org-logo.png',
                'verified' => true,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud',
                'link' => 'Lihat Selengkapnya',
                'image' => 'campaign-1.jpg',
                'target_amount' => 10000000,
                'collected_amount' => 9500000,
                'target' => 'Rp 10.000.000',
                'collected' => 'Rp 9.500.000',
                'days_remaining' => 7,
                'days' => '7',
                'days_label' => 'Hari lagi',
                'category' => 'Panti Asuhan',
                'created_at' => '2025-01-05'
            ],
            [
                'id' => 6,
                'title' => 'Beasiswa Anak Berprestasi',
                'organization' => 'Yayasan Cerdas Bangsa',
                'organization_logo' => 'org-logo-6.png',
                'verified' => false,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud',
                'link' => 'Lihat Selengkapnya',
                'image' => 'campaign-2.jpg',
                'target_amount' => 8000000,
                'collected_amount' => 2000000,
                'target' => 'Rp 8.000.000',
                'collected' => 'Rp 2.000.000',
                'days_remaining' => 2,
                'days' => '2',
                'days_label' => 'Hari lagi',
                'category' => 'Pendidikan',
                'created_at' => '2025-01-22'
            ],
        ];

        $campaigns = collect($allCampaigns);

        $campaigns = $campaigns->map(function($campaign) {
            $campaign['progress'] = intval(
                ($campaign['collected_amount'] / $campaign['target_amount']) * 100
            );
            if ($campaign['progress'] > 100) {
                $campaign['progress'] = 100;
            }
            return $campaign;
        });

        if (!empty($kategori)) {
            $campaigns = $campaigns->whereIn('category', $kategori);
        }

        if ($statusDefault === 'Berlangsung') {
            $campaigns = $campaigns->where('days_remaining', '>', 0);
        } elseif ($statusDefault === 'Selesai') {
            $campaigns = $campaigns->where('days_remaining', '<=', 0);
        }

        if (!empty($organisasi)) {
            $campaigns = $campaigns->filter(function($campaign) use ($organisasi) {
                $isJejakkebaikan = $campaign['organization'] === 'Jejakkebaikan';
                $isYayasan = $campaign['organization'] !== 'Jejakkebaikan';

                if (in_array('Oleh Jejakkebaikan', $organisasi) && in_array('Oleh Yayasan', $organisasi)) {
                    return true;
                } elseif (in_array('Oleh Jejakkebaikan', $organisasi)) {
                    return $isJejakkebaikan;
                } elseif (in_array('Oleh Yayasan', $organisasi)) {
                    return $isYayasan;
                }
                return false;
            });
        }

        if (!empty($search)) {
            // split kata (untuk matching kata per kata)
            $keywords = preg_split('/\s+/', $search, -1, PREG_SPLIT_NO_EMPTY);

            $campaigns = $campaigns->filter(function($c) use ($search, $keywords) {
                // 1) cocok frasa penuh?
                if (stripos($c['title'], $search) !== false) {
                    return true;
                }
                // 2) atau cocok salah satu kata dari keyword
                foreach ($keywords as $kw) {
                    if ($kw !== '' && stripos($c['title'], $kw) !== false) {
                        return true;
                    }
                }
                return false;
            });
        }

        if ($urutkanDefault === 'Akan Berakhir') {
            $campaigns = $campaigns->filter(function($campaign) {
                return $campaign['days_remaining'] > 0 && $campaign['days_remaining'] < 5;
            })->sortBy('days_remaining');
        }
        elseif ($urutkanDefault === 'Terbaru') {
            $campaigns = $campaigns->sortByDesc('created_at');
        }
        elseif ($urutkanDefault === 'Progres Tertinggi') {
            $campaigns = $campaigns->map(function($campaign) {
                $campaign['progress_percentage'] = ($campaign['collected_amount'] / $campaign['target_amount']) * 100;
                return $campaign;
            })->sortByDesc('progress_percentage');
        }

        $campaigns = $campaigns->values()->all();

        return view('home', compact('campaigns', 'kategori', 'statusDefault', 'urutkanDefault', 'organisasi'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function faq()
    {
        return view('faq');
    }
    
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }
}
