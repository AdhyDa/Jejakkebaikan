<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\MoneyDonation;
use App\Models\GoodsDonation;
use App\Models\VolunteerDonation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::orderBy('id', 'asc')->get();

        return view('admin.index', compact('campaigns'));
    }

    public function manageCampaign($id)
    {
        $query = Campaign::with([
            'moneyDonations.user',
            'goodsDonations.user',
            'volunteerDonations.user'
        ]);

        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $campaign = $query->findOrFail($id);

        return view('admin.manage', compact('campaign'));
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:Pria,Wanita',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('profiles', 'public');
        }

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function changePassword()
    {
        return view('admin.change-password');
    }

    public function userChangePassword()
    {
        return view('user.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah!']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    public function donationHistory()
    {
        $moneyDonations = MoneyDonation::where('user_id', auth()->id())
            ->with('campaign')
            ->orderBy('created_at', 'desc')
            ->get();

        $goodsDonations = GoodsDonation::where('user_id', auth()->id())
            ->with('campaign')
            ->orderBy('created_at', 'desc')
            ->get();

        $volunteerDonations = VolunteerDonation::where('user_id', auth()->id())
            ->with('campaign')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.history', compact(
            'moneyDonations',
            'goodsDonations',
            'volunteerDonations'
        ));
    }

    public function updateCampaignStatus(Request $request, $id)
    {
        $campaign = Campaign::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:draft,active',
        ]);

        $campaign->update(['status' => $validated['status']]);

        $message = $validated['status'] === 'active' ? 'Campaign berhasil dipublikasikan!' : 'Campaign disimpan sebagai draft!';

        return back()->with('success', $message);
    }



    public function addCampaignUpdate(Request $request, $id)
    {
        $campaign = Campaign::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $campaign->updates()->create($validated);

        return back()->with('success', 'Update campaign berhasil ditambahkan!');
    }

    public function showDeleteAccount()
    {
        return view('user.delete-account');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'confirmation' => 'required|string|in:HAPUS AKUN SAYA',
        ], [
            'confirmation.in' => 'Konfirmasi harus tepat sama dengan "HAPUS AKUN SAYA".',
        ]);

        $user = auth()->user();

        // Delete user's photo
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }
        // Logout and delete
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Akun berhasil dihapus!');
    }
}
