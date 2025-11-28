<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ShortUrlExport;

class ShortUrlController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = ShortUrl::query();

        if ($user->role == 'super_admin') {
            // SuperAdmin sees all URLs from all companies
            $urls = $query->with(['user', 'company'])->latest()->paginate(15);
        } elseif ($user->role == 'admin') {
            // Admin sees all URLs from their company
            $urls = $query->where('company_id', $user->company_id)->with('user')->latest()->paginate(15);
        } else {
            // Member, see only their own URLs
            $urls = $query->where('user_id', $user->id)->latest()->paginate(15);
        }

        return view('dashboard.urls.index', compact('urls'));
    }

    public function create()
    {
        // Check if user can create URLs
        if (!auth()->user()->role == "super_admin") {
            abort(403, 'You are not authorized to create short URLs.');
        }

        return view('dashboard.urls.create');
    }

    public function store(Request $request)
    {
        // Check if user can create URLs
        if (!auth()->user()->role == "super_admin") {
            abort(403, 'You are not authorized to create short URLs.');
        }

        $request->validate([
            'original_url' => 'required|url|max:2048',
        ]);

        $user = auth()->user();

        $shortUrl = ShortUrl::create([
            'original_url' => $request->original_url,
            'short_code' => ShortUrl::generateShortCode(),
            'user_id' => $user->id,
            'company_id' => $user->company_id,
        ]);

        return redirect()->route('urls.index')
            ->with('success', 'Short URL created successfully! Short code: ' . $shortUrl->short_code);
    }

    public function show(ShortUrl $url)
    {
        $user = auth()->user();

        if ($user->role== "super_admin") {
            // Can see all
        } elseif ($user->role == "admin") {
            if ($url->company_id !== $user->company_id) {
                abort(403, 'Unauthorized access.');
            }
        } else {
            if ($url->user_id !== $user->id) {
                abort(403, 'Unauthorized access.');
            }
        }

        return view('dashboard.urls.show', compact('url'));
    }

     public function destroy(ShortUrl $url)
    {
        $user = auth()->user();

        if ($user->role== "super_admin") {
            // Can delete all
        } elseif ($user->role == "admin") {
            if ($url->company_id !== $user->company_id) {
                abort(403, 'Unauthorized access.');
            }
        } else {
            if ($url->user_id !== $user->id) {
                abort(403, 'Unauthorized access.');
            }
        }

        $url->delete();

        return redirect()->route('urls.index')
            ->with('success', 'Short URL deleted successfully!');
    }

    public function redirect($shortCode)
    {
        $url = ShortUrl::where('short_code', $shortCode)->firstOrFail();
        
        $url->incrementClicks();
        
        return redirect($url->original_url);
    }

    /**

    * @return \Illuminate\Support\Collection

    */

    public function export() 
    {
        return Excel::download(new ShortUrlExport, 'users.csv');
    }
}
