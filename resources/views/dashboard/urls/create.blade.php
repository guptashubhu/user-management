@extends('dashboard.layout')

@section('title', 'Create Short URL')

@section('content')
<h2 style="margin-bottom: 20px;">Create Short URL</h2>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('urls.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="original_url">Original URL *</label>
            <input type="url" id="original_url" name="original_url" value="{{ old('original_url') }}" placeholder="https://example.com/very/long/url" required >
        </div>
        
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn">Create Short URL</button>
            <a href="{{ route('urls.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection