<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::withCount(['users', 'shortUrls'])->get();
        return view('dashboard.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('dashboard.companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
        ]);

        Company::create([
            'name' => $request->name,
        ]);

        return redirect()->route('companies.index')
            ->with('success', 'Company created successfully!');
    }
}
