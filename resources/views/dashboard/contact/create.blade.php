@extends('dashboard.layout')

@section('title', 'Add New Contact')

@section('content')
    <h2 style="margin-bottom: 20px;">Add New Contact</h2>

    <div class="card" style="max-width: 600px;">

        <form action="{{ route('contact.store') }}" method="POST">
            @csrf

            {{-- Name --}}
            <div class="form-group">
                <label for="name">Full Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe"
                    required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    placeholder="john@example.com" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- Phone --}}
            <div class="form-group">
                <label for="phone">Phone Number *</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="9876543210"
                    required>
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- Address --}}
            <div class="form-group">
                <label for="address">Address *</label>
                <textarea id="address" name="address" placeholder="Enter full address" required>{{ old('address') }}</textarea>
                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- Buttons --}}
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="submit" class="btn btn-success">Save Contact</button>
                <a href="{{ route('contact.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>

    </div>
@endsection
