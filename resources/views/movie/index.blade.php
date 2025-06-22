@extends('movie.mainLayout')

@section('title')
    Movie List
@endsection

@section('content')

@if (isAdmin())
    <!-- Add Movie -->
    <div class="ms-auto">
        <a href="{{ route('movie.add') }}" class="btn btn-primary">Add Movie</a>
    </div>
@endif

<!-- Movie Cards -->
<div class="container mt-4">
    <div class="row">
        @forelse ( $moviesData ?? [] as $movie )
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ isset($movie->image) ? asset('storage/' . $movie->image) : '' }}" class="card-img-top" alt="Movie {{ $loop->iteration }}" style="height: 250px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $movie->title ?? '' }}</h5>
                        <p class="card-text text-muted">Published on: {{ isset($movie->published_at) ? \Carbon\Carbon::parse($movie->published_at)->format('d M Y') : '' }}</p>
                        <a href="{{ route('movie.show',$movie->id) }}" class="btn btn-outline-primary mt-auto">View More</a>
                    </div>
                </div>
            </div>
        @empty
            No Movies Added.
        @endforelse
    </div>
</div>
@endsection