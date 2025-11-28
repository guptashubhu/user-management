@extends('dashboard.layout')

@section('title', 'Short URLs')

@section('content')
<div class="flex mb-20">
    <h2>Short URLs</h2>
    @if(!auth()->user()->role == "super_admin")
        <a href="{{ route('urls.create') }}" class="btn">Create New URLsdfsdfsdf</a>
    @endif
    <a href="{{ route('export.url') }}" class="btn">Export-URL</a>
</div>

<div class="card">
    @if($urls->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Short Code</th>
                <th>Original URL</th>
                <th>Short URL</th>
                @if(auth()->user()->role == "super_admin")
                    <th>Company</th>
                @endif
                @if(auth()->user()->role == "super_admin" || auth()->user()->role == "admin")
                    <th>Created By</th>
                @endif
                <th>Clicks</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($urls as $url)
            <tr>
                <td><strong>{{ $url->short_code }}</strong></td>
                <td>{{ Str::limit($url->original_url, 40) }}</td>
                <td>
                    <a href="{{ url('/' . $url->short_code) }}" target="_blank">
                        {{ url('/' . $url->short_code) }}
                    </a>
                </td>
                @if(auth()->user()->role == "super_admin")
                    <td>{{ $url->company->name }}</td>
                @endif
                @if(auth()->user()->role == "super_admin" || auth()->user()->role == "admin")
                    <td>{{ $url->user->name }}</td>
                @endif
                <td>{{ $url->clicks }}</td>
                <td>{{ $url->created_at->format('Y-m-d H:i') }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('urls.show', $url) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 14px;">View</a>
                        <form action="{{ route('urls.destroy', $url) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 14px;">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 20px;">
        {{ $urls->links() }}
    </div>
    @else
    <p>No short URLs found.</p>
    @if(auth()->user()->role == "admin" || auth()->user()->role == "member")
        <a href="{{ route('urls.create') }}" class="btn" style="margin-top: 15px;">Create Your First URL</a>
    @endif
    @endif
</div>
@endsection