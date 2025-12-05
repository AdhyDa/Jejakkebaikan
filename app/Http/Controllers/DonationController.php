<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\MoneyDonation;
use App\Models\GoodsDonation;
use App\Models\VolunteerDonation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function donateMoney(Request $request, $campaignId)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'message' => 'nullable|string',
            'is_anonymous' => 'boolean',
        ]);

        $campaign = Campaign::findOrFail($campaignId);

        $donation = MoneyDonation::create([
            'user_id' => auth()->id(),
            'campaign_id' => $campaignId,
            'amount' => $validated['amount'],
            'message' => $validated['message'] ?? null,
            'is_anonymous' => $request->has('is_anonymous'),
        ]);

        // Update campaign collected amount
        $campaign->increment('collected_amount', $validated['amount']);

        return redirect()->route('campaigns.show', $campaignId)
            ->with('success', 'Terima kasih atas donasi Anda!');
    }

    public function donateGoods(Request $request, $campaignId)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        GoodsDonation::create([
            'user_id' => auth()->id(),
            'campaign_id' => $campaignId,
            'item_name' => $validated['item_name'],
            'quantity' => $validated['quantity'],
            'description' => $validated['description'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('campaigns.show', $campaignId)
            ->with('success', 'Janji donasi barang berhasil dibuat!');
    }

    public function registerVolunteer(Request $request, $campaignId)
    {
        $validated = $request->validate([
            'position' => 'required|string|max:255',
            'message' => 'nullable|string',
        ]);

        VolunteerDonation::create([
            'user_id' => auth()->id(),
            'campaign_id' => $campaignId,
            'position' => $validated['position'],
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('campaigns.show', $campaignId)
            ->with('success', 'Pendaftaran relawan berhasil!');
    }

    public function markGoodsReceived($donationId)
    {
        $donation = GoodsDonation::findOrFail($donationId);

        // Check if user owns the campaign
        if ($donation->campaign->user_id !== auth()->id()) {
            abort(403);
        }

        $donation->update(['status' => 'received']);

        return back()->with('success', 'Donasi barang ditandai sudah diterima!');
    }

    public function approveVolunteer($donationId)
    {
        $donation = VolunteerDonation::findOrFail($donationId);

        // Check if user owns the campaign
        if ($donation->campaign->user_id !== auth()->id()) {
            abort(403);
        }

        $donation->update(['status' => 'approved']);

        return back()->with('success', 'Relawan berhasil disetujui!');
    }

    public function rejectVolunteer($donationId)
    {
        $donation = VolunteerDonation::findOrFail($donationId);

        // Check if user owns the campaign
        if ($donation->campaign->user_id !== auth()->id()) {
            abort(403);
        }

        $donation->update(['status' => 'rejected']);

        return back()->with('success', 'Relawan ditolak!');
    }
}
