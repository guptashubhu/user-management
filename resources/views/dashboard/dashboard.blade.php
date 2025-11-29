@extends('dashboard.layout')

@section('title', 'Dashboard')

@section('content')
    <h2 style="margin-bottom: 20px;">Dashboard</h2>

    <div class="card">
        <h3 style="margin-bottom: 15px;">Recent Contacts</h3>

        @if ($recentContacts->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>

                        @if (auth()->user()->role == 'admin')
                            <th>Created By</th>
                        @endif

                        <th>Created</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($recentContacts as $contact)
                        <tr>
                            <td><strong>{{ $contact->name }}</strong></td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->phone }}</td>
                            <td>{{ Str::limit($contact->address, 40) }}</td>

                            @if (auth()->user()->role == 'admin')
                                <td>{{ $contact->user->name ?? 'N/A' }}</td>
                            @endif

                            <td>{{ $contact->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No contact created yet.</p>
        @endif

        <div style="margin-top: 15px;">
            <a href="{{ route('contact.index') }}" class="btn btn-secondary">View All Contacts</a>
        </div>
    </div>
@endsection
