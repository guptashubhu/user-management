@extends('dashboard.layout')

@section('title', 'Dashboard')

@section('content')
    <h2 style="margin-bottom: 20px;">Dashboard</h2>

    <div class="stats">
        <div class="stat-card">
            <h3>Total URLs</h3>
            <div class="number">{{ $totalUrls }}</div>
        </div>

        <div class="stat-card">
            <h3>Total Clicks</h3>
            <div class="number">{{ $totalClicks }}</div>
        </div>

        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'member')
            <div class="stat-card">
                <h3>Quick Action</h3>
                <a href="{{ route('urls.create') }}" class="btn">Create Short URL</a>
            </div>
        @endif
    </div>

    <div class="card">
        <h3 style="margin-bottom: 15px;">Recent URLs</h3>

        @if ($recentUrls->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Short Code</th>
                        <th>Original URL</th>
                        @if (auth()->user()->role == 'super_admin')
                            <th>Company</th>
                        @endif
                        @if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
                            <th>Created By</th>
                        @endif
                        <th>Clicks</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentUrls as $url)
                        <tr>
                            <td><strong>{{ $url->short_code }}</strong></td>
                            <td>{{ Str::limit($url->original_url, 50) }}</td>
                            @if (auth()->user()->role == 'super_admin')
                                <td>{{ $url->company->name }}</td>
                            @endif
                            @if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
                                <td>{{ $url->user->name }}</td>
                            @endif
                            <td>{{ $url->clicks }}</td>
                            <td>{{ $url->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No URLs created yet.</p>
        @endif

        <div style="margin-top: 15px;">
            <a href="{{ route('urls.index') }}" class="btn btn-secondary">View All URLs</a>
        </div>
    </div>
@endsection
