<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display all contacts (admin) OR user’s own contacts (normal user)
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            $contacts = Contact::latest()->paginate(10);
        } else {
            $contacts = Contact::where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        }

        return view('dashboard.contact.index', compact('contacts'));
    }


    /**
     * Show contact create form
     */
    public function create()
    {
        return view('dashboard.contact.create');
    }


    /**
     * Store new contact
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:contacts,email',
            'phone'   => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        Contact::create([
            'user_id' => auth()->id(),
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('contact.index')
            ->with('success', 'Contact created successfully.');
    }


    /**
     * Show a single contact – admin only
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        return view('dashboard.contact.show', compact('contact'));
    }


    /**
     * Edit form – admin only
     */
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);

        return view('dashboard.contact.edit', compact('contact'));
    }


    /**
     * Update contact – admin only
     */
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:contacts,email,' . $id,
            'phone'   => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        $contact->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('contact.index')
            ->with('success', 'Contact updated successfully.');
    }


    /**
     * Delete contact – admin only
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contact.index')
            ->with('success', 'Contact deleted successfully.');
    }
}
