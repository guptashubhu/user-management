@extends('dashboard.layout')

@section('title', 'Contacts')

@section('content')
<div class="flex mb-20">
    <h2>Contacts</h2>
    <a href="{{ route('contact.create') }}" class="btn">Add New Contact</a>
</div>

<div class="card">
    @if($contacts->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>

                {{-- Admin can see which user created the contact --}}
                @if(auth()->user()->role == 'admin')
                    <th>Created By</th>
                @endif

                <th>Created At</th>
                @if(auth()->user()->role == 'admin')
                    <th>Actions</th>
                @endif
            </tr>
        </thead>

        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->phone }}</td>
                <td>{{ $contact->address }}</td>

                {{-- Show created user --}}
                @if(auth()->user()->role == 'admin')
                    <td>{{ $contact->user->name ?? 'N/A' }}</td>
                @endif

                <td>{{ $contact->created_at->format('Y-m-d') }}</td>

                {{-- Only admin can edit/delete --}}
                @if(auth()->user()->role == 'admin')
                <td>
                    <form action="{{ route('contact.destroy', $contact->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    @else
        <p>No contacts found.</p>
    @endif
</div>
@endsection
