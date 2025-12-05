<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $query = Campaign::where('status', 'active');

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->has('filter_status')) {
            if ($request->filter_status == 'berlangsung') {
                $query->where('end_date', '>=', now());
            } elseif ($request->filter_status == 'selesai') {
                $query->where('end_date', '<', now());
            }
        }

        // Sort
        if ($request->has('sort')) {
            if ($request->sort == 'terbaru') {
                $query->orderBy('created_at', 'desc');
            } elseif ($request->sort == 'terlama') {
                $query->orderBy('created_at', 'asc');
            } elseif ($request->sort == 'akan_berakhir') {
                $query->orderBy('end_date', 'asc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $campaigns = $query->paginate(12);

        return view('campaigns.index', compact('campaigns'));
    }

    public function show($slug)
    {
        $campaign = Campaign::with([
            'user',
            'moneyDonations.user',
            'goodsDonations',
            'volunteerDonations',
            'updates'
        ])->where('slug', $slug)->firstOrFail();

        return view('campaigns.show', compact('campaign'));
    }

    public function create()
    {
        return view('campaigns.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required|string',
            'organization_name' => 'required|string|max:255',
            'end_date' => 'required|date|after:today',
            'need_money' => 'boolean',
            'need_goods' => 'boolean',
            'need_volunteer' => 'boolean',
            'target_amount' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('campaigns', 'public');
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = $request->has('publish') ? 'active' : 'draft';
        $validated['slug'] = Str::slug($validated['title']);

        $campaign = Campaign::create($validated);

        return redirect()->route('dashboard.campaigns.manage', $campaign->id)
            ->with('success', 'Campaign berhasil dibuat!');
    }

    public function edit($id)
    {
        $campaign = Campaign::where('user_id', auth()->id())->findOrFail($id);
        return view('campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, $id)
    {
        $campaign = Campaign::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required|string',
            'organization_name' => 'required|string|max:255',
            'end_date' => 'required|date',
            'target_amount' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($campaign->image) {
                Storage::disk('public')->delete($campaign->image);
            }
            $validated['image'] = $request->file('image')->store('campaigns', 'public');
        }

        $campaign->update($validated);

        return back()->with('success', 'Campaign berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $campaign = Campaign::where('user_id', auth()->id())->findOrFail($id);

        if ($campaign->image) {
            Storage::disk('public')->delete($campaign->image);
        }

        $campaign->delete();

        return redirect()->route('dashboard.index')
            ->with('success', 'Campaign berhasil dihapus!');
    }
}
