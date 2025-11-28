<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class InvitationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role == 'super_admin') {
            $users = User::with('company')->where('role', '!=', 'super_admin')->get();
        } else {
            $users = User::where('company_id', $user->company_id)->where('id', '!=', $user->id)->get();
        }

        return view('dashboard.invitations.index', compact('users'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('dashboard.invitations.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ];

        if ($user->role == 'super_admin') {
            $rules['role'] = 'required|in:admin,member,';
            $rules['company_id'] = 'required_if:role,admin,member,|exists:companies,id';
        } else {
            $rules['role'] = 'required|in:member,';
        }

        $validated = $request->validate($rules);

        $companyId = $user->role == 'super_admin' ? $request->company_id : $user->company_id;

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'company_id' => $companyId,
        ]);

        return redirect()->route('invitations.index')->with('success', 'User invited successfully!');
    }
}
