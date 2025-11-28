@extends('dashboard.layout')

@section('title', 'Users')

@section('content')
<div class="flex mb-20">
    <h2>Users</h2>
    <a href="{{ route('invitations.create') }}" class="btn">Invite New User</a>
</div>

<div class="card">
    @if($users->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                @if(auth()->user()->role == "super_admin")
                    <th>Company</th>
                @endif
                <th>Joined</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="badge badge-{{ $user->role === 'admin' ? 'admin' : $user->role }}">
                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                    </span>
                </td>
                @if(auth()->user()->role == "super_admin")
                    <td>{{ $user->company ? $user->company->name : 'N/A' }}</td>
                @endif
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No users found.</p>
    @endif
</div>
@endsection