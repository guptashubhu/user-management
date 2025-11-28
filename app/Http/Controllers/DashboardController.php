<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Stats based on role
        if ($user->role == 'super_admin') {
            $totalUrls = ShortUrl::count();
            $totalClicks = ShortUrl::sum('clicks');
            $recentUrls = ShortUrl::with(['user', 'company'])
                ->latest()
                ->take(5)
                ->get();
        } elseif ($user->role == 'admin') {
            $totalUrls = ShortUrl::where('company_id', $user->company_id)->count();
            $totalClicks = ShortUrl::where('company_id', $user->company_id)->sum('clicks');
            $recentUrls = ShortUrl::where('company_id', $user->company_id)
                ->with('user')
                ->latest()
                ->take(5)
                ->get();
        } else {
            $totalUrls = ShortUrl::where('user_id', $user->id)->count();
            $totalClicks = ShortUrl::where('user_id', $user->id)->sum('clicks');
            $recentUrls = ShortUrl::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard.dashboard', compact('totalUrls', 'totalClicks', 'recentUrls'));
    }
}
