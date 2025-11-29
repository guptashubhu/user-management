<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // If user is admin → show all contacts
        if ($user->role == 'admin') {

            $totalContacts = Contact::count();
            $recentContacts = Contact::latest()->take(5)->get();
        } else {
            // If user is normal user → show only his own contacts
            $totalContacts = Contact::where('user_id', $user->id)->count();
            $recentContacts = Contact::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard.dashboard', compact('totalContacts', 'recentContacts'));
    }
}
