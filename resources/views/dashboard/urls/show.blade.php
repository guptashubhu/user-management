@extends('dashboard.layout')

@section('title', 'URL Details')

@section('content')
<h2 style="margin-bottom: 20px;">URL Details</h2>

<div class="card" style="max-width: 800px;">
    <div style="margin-bottom: 15px;">
        <strong>Short Code:</strong>
        <span style="font-size: 18px; color: #007bff;">{{ $url->short_code }}</span>
    </div>
    
    <div style="margin-bottom: 15px;">
        <strong>Short URL:</strong>
        <a href="{{ url('/' . $url->short_code) }}" target="_blank" style="color: #007bff;">
            {{ url('/' . $url->short_code) }}
        </a>
    </div>
    
    <div style="margin-bottom: 15px;">
        <strong>Original URL:</strong>
        <a href="{{ $url->original_url }}" target="_blank" style="color: #007bff; word-break: break-all;">
            {{ $url->original_url }}
        </a>
    </div>
    
    @if(auth()->user()->role == "super_admin")
    <div style="margin-bottom: 15px;">
        <strong>Company:</strong>
        {{ $url->company->name }}
    </div>
    @endif
    
    @if(auth()->user()->role == "super_admin" || auth()->user()->role == "admin")
    <div style="margin-bottom: 15px;">
        <strong>Created By:</strong>
        {{ $url->user->name }} ({{ $url->user->email }})
    </div>
    @endif
    
    <div style="margin-bottom: 15px;">
        <strong>Total Clicks:</strong>
        <span style="font-size: 24px; font-weight: bold; color: #28a745;">{{ $url->clicks }}</span>
    </div>
    
    <div style="margin-bottom: 15px;">
        <strong>Created:</strong>
        {{ $url->created_at->format('F d, Y H:i:s') }}
        ({{ $url->created_at->diffForHumans() }})
    </div>
    
    <div style="display: flex; gap: 10px; margin-top: 20px;">
        <a href="{{ route('urls.index') }}" class="btn btn-secondary">Back to List</a>
        
        <form action="{{ route('urls.destroy', $url) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this URL?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete URL</button>
        </form>
    </div>
</div>
@endsection