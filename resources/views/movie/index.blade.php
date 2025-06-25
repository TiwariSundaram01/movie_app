@extends('movie.mainLayout')

@section('title')
    Movie List
@endsection

@section('css')
<style>
    .rate-button {
        border: none;
        background: white;
        color: #22c6e1d9;
        font-size: 25px;
        padding: 0px 3px;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 25px;
        border-radius: 5px;
        margin-bottom: 5px;
    }

    .rate-button:hover {
        background-color: #dadada;
    }
    .rating-box {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 10px;
    }
        .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        font-size: 2rem;
        position: relative;
    }
    .star-rating input[type="radio"] {
        display: none;
    }
    .star-rating label {
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s ease;
    }
    .star-rating input[type="radio"]:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #f8ce0b;
    }
    .rating-container {
        max-width: 500px;
        margin: 40px auto;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
    }
    .rating-title {
        text-align: center;
        margin-bottom: 20px;
    }
    .pointer-none {
        pointer-events: none
    }
    .cursor-not-allowed {
        cursor: not-allowed;
    }
</style>
@endsection

@section('content')

@if(isAdmin())
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
                        <div class="card-text text-muted">Published on: {{ isset($movie->published_at) ? \Carbon\Carbon::parse($movie->published_at)->format('d M Y') : '' }}</div>
                        <div class="rating-box">
                            <div>Add Rating :</div>
                            <div type="button" class="rate-button" data-movie_id="{{ $movie->id }}">★</div>
                        </div>
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

@section('js')
<script>
     $(document).on("click" , ".rate-button" , function(){
        var movie_id = $(this).data('movie_id');

         $.ajax({
            type: "GET",
            url: "{{ route('rating.add') }}",
            data: {
                movie_id:  movie_id,
            },
            success: function (response) {
                if(response.success) {
                    $('#ratingModal').remove();
                    $('body').append(response.view);
                    $('#ratingModal').modal('show');
                } else {
                    $.notify(response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                $.notify("Something went wrong !!", 'error' );
            },
        });
    });

    $(document).on('click', '#submit-rating', function (e) {
        e.preventDefault();
        var rating = $('input.rate:checked').val();
        var token = $('meta[name="csrf-token"]').attr('content');

        if(rating == '' || rating == undefined){
            $('#rating-error').text('Add Rating from ( 0 - 10 )')
            return;
        }

        $.ajax({
            type: "POST",
            url: "{{ route('rating.store') }}",
            data: {
                movie_id:  $("#movie_id").val(),
                rating: rating,
                _token: token
            },
            success: function (response) {
                if(response.success) {
                    $.notify(response.message, 'success');
                    setTimeout(() => {
                        location.href = "{{ route('movie.list') }}";
                    }, 1000);
                } else {
                    $.notify(response.message, 'error');
                }

                $('#ratingModal').remove();
            },
            error: function(xhr, status, error) {
                $.notify("Something went wrong !!", 'error' );
            },
        });
    });
</script>
@endsection