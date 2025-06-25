@extends('movie.mainLayout')

@section('title')
    Show Movie
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow rounded-3">
                <div class="row g-0">
                    @if($movie->image)
                        <div class="col-md-4">
                            <img src="{{ asset('storage/' . $movie->image) }}" class="img-fluid rounded-start" alt="{{ $movie->title }}">
                        </div>
                    @endif

                    <div class="{{ $movie->image ? 'col-md-8' : 'col-md-12' }}">
                        <div class="card-body">
                            <h3 class="card-title">{{ $movie->title ?? 'Not Added' }}</h3>

                            @if($movie->description)
                                <p class="card-text text-muted">
                                    <strong>Description:</strong><br>
                                    {{ $movie->description }}
                                </p>
                            @endif

                            @if($movie->runtime)
                                <p class="card-text">
                                    <strong>Runtime:</strong>
                                    {{ isset($movie->runtime) ? floor($movie->runtime / 60) : 0 }}h {{ isset($movie->runtime) ? $movie->runtime % 60 : 0 }}m
                                </p>
                            @endif

                            <p class="card-text">
                                <strong>IMDB Rating:</strong>
                                ⭐ {{ isset($movie->imdb_rating) ? number_format($movie->imdb_rating, 2) : '-' }}/10
                            </p>

                            <p class="card-text">
                                <strong>Published On:</strong>
                                {{ isset($movie->published_at) ? \Carbon\Carbon::parse($movie->published_at)->format('d M Y') : '-' }}
                            </p>

                            @if(isset($movie->author) && isset($movie->author->name))
                                <p class="card-text">
                                    <strong>Posted By:</strong>
                                    {{ $movie->author->name }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between mb-5">
                <a href="{{ route('movie.list') }}" class="btn btn-primary mt-3">Back to Movies</a>
                <div>
                    <a href="{{ route('movie.edit',$movie->id) }}" class="btn btn-warning mt-3">Update</a>
                    <a href="javascipt:void(0)" id="delete-movie" data-movie_id="{{ $movie->id }}" class="btn btn-danger mt-3">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).on('click', '#delete-movie', function() {
        var movie_id = $(this).data('movie_id');
        var isConfirmed = confirm('Are you sure you want to delete this movie?');

        if(isConfirmed) {
            $.ajax({
                url: "{{ route('movie.delete') }}",
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: movie_id
                },
                success: function(response) {
                    if(response.status) {
                        $.notify(response.message, 'success');
                        
                        setTimeout(() => {
                            location.href = "{{ route('movie.list') }}";
                        }, 1000);
                    }else {
                        $.notify(response.message, 'error');
                    }
                },
                error: function(xhr) {
                    $.notify('Something went wrong !!', 'error');
                }
            });
        }
    });
</script>
@endsection
