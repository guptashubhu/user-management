@extends('dashboard.layout')

@section('title', 'Companies')

@section('content')
<div class="flex mb-20">
    <h2>Companies</h2>
    <a href="{{ route('companies.create') }}" class="btn">Create New Company</a>
</div>

<div class="card">
    @if($companies->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Total Users</th>
                <th>Total URLs</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($companies as $company)
            <tr>
                <td><strong>{{ $company->name }}</strong></td>
                <td>{{ $company->users_count }}</td>
                <td>{{ $company->short_urls_count }}</td>
                <td>{{ $company->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No companies found.</p>
    @endif
</div>
@endsection