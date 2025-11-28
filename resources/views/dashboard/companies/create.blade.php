@extends('dashboard.layout')

@section('title', 'Create Company')

@section('content')
<h2 style="margin-bottom: 20px;">Create New Company</h2>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('companies.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Company Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter company name" required >
        </div>
        
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn">Create Company</button>
            <a href="{{ route('companies.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection