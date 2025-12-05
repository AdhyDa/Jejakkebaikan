<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->input('kategori', []);
        $statusDefault = $request->input('status');
        $urutkanDefault = $request->input('urutkan');
        $organisasi = $request->input('organisasi', []);
        $search       = trim($request->input('search', ''));

        $campaignsFromDB = Campaign::where('status', 'active')->get();

        $allCampaigns = $campaignsFromDB->map(function($campaign) {
            $days_remaining = now()->diffInDays($campaign->end_date, false);
            $organization_logos = [
                'Jejakkebaikan' => 'org-logo.png',
                'Yayasan Peduli Kasih' => 'org-logo-2.png',
                'Yayasan Hijau Indonesia' => 'org-logo-4.png',
                'Yayasan Cerdas Bangsa' => 'org-logo-6.png',
            ];
            $organization_logo = $organization_logos[$campaign->organization_name] ?? 'org-logo.png';

            return [
                'id' => $campaign->id,
                'title' => $campaign->title,
                'organization' => $campaign->organization_name,
                'organization_logo' => $organization_logo,
                'verified' => $campaign->organization_name === 'Jejakkebaikan',
                'description' => $campaign->description,
                'link' => 'Lihat Selengkapnya',
                'image' => $campaign->image,
                'target_amount' => $campaign->target_amount,
                'collected_amount' => $campaign->collected_amount,
                'target' => 'Rp ' . number_format((float)$campaign->target_amount),
                'collected' => 'Rp ' . number_format((float)$campaign->collected_amount),
                'days_remaining' => $days_remaining,
                'days' => abs($days_remaining),
                'days_label' => $days_remaining > 0 ? 'Hari lagi' : 'Selesai',
                'category' => $campaign->category,
                'created_at' => $campaign->created_at->format('Y-m-d'),
            ];
        })->toArray();

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
