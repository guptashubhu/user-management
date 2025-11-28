@extends('dashboard.layout')

@section('title', 'Invite User')

@section('content')
<h2 style="margin-bottom: 20px;">Invite New Admin</h2>

<div class="card" style="max-width: 600px;">
    <p style="margin-bottom: 20px; color: #666;">
        Create a new admin account and assign them to 
        @if(auth()->user()->role == "super_admin")
            any company.
        @else
            your company ({{ auth()->user()->company->name }}).
        @endif
    </p>

    <form action="{{ route('invitations.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Full Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="john@example.com" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password *</label>
            <input type="password" id="password" name="password" placeholder="Minimum 8 characters" required >
            <small style="color: #666; font-size: 12px;">User will use this password to login</small>
        </div>
        
        <div class="form-group">
            <label for="role">Role *</label>
            <select id="role" name="role" required>
                <option value="">Select Role</option>
                @if(auth()->user()->role == "super_admin")
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin - Can manage company users and URLs</option>
                @endif
                @if (auth()->user()->role == "admin" || auth()->user()->role == "member")
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin - Can manage company users and URLs</option>
                    <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member - Can create and view own URLs</option>
                @endif
            </select>
        </div>
        
        @if(auth()->user()->role == "super_admin")
        <div class="form-group">
            <label for="company_id">Company *</label>
            <select id="company_id" name="company_id" required>
                <option value="">Select Company</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif
        
        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn btn-success">Create User Account</button>
            <a href="{{ route('invitations.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

@if(auth()->user()->role == "super_admin")
<div class="card" style="max-width: 600px; margin-top: 20px; background: #f8f9fa;">
    <h4 style="margin-bottom: 10px;">💡 Quick Tip</h4>
    <p style="color: #666; font-size: 14px; margin: 0;">
        As SuperAdmin, you can invite Admins to manage different companies. 
        Admins can then invite Members, to their own company.
    </p>
</div>
@endif
@endsection