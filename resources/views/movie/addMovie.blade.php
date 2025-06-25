@extends('movie.mainLayout')

@php
    $movie_id = $movie->id ?? null;
@endphp

@section('title')
    @if(isset($movie_id))
        Edit Movie
    @else
        Add Movie
    @endif
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/parsleyjs/src/parsley.css">
@endsection

@section('content')
<!-- Movie Form -->
<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ isset($movie_id) ? 'Edit Movie' : 'Add New Movie' }}</h4>
                </div>
                <div class="card-body">
                    <form id="movie-form" data-parsley-validate enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="title" class="form-label">Movie Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{@$movie->title}}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Movie Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{@$movie->description}}</textarea>
                        </div>

                        <div class="mb-3 row">
                            <div class="col">
                                <label for="runtime_hours" class="form-label">Runtime Hours</label>
                                <input type="number" class="form-control" id="runtime_hours" name="runtime_hours" min="0" value="{{isset($movie->runtime) ? floor($movie->runtime / 60) : 0}}" required>
                            </div>
                            <div class="col">
                                <label for="runtime_minutes" class="form-label">Runtime Minutes</label>
                                <input type="number" class="form-control" id="runtime_minutes" name="runtime_minutes" min="0" max="59" value="{{isset($movie->runtime) ? $movie->runtime % 60 : 0}}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="published_at" class="form-label">Published Date</label>
                            <input type="date" class="form-control" id="published_at" name="published_at" value="{{@$movie->published_at}}" required>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Movie Poster</label>

                            <div class="img-container text-center mb-3">
                                <img id="uploaded-image" width="100"
                                    src="{{ isset($movie->image) ? asset('storage/'.$movie->image) : '#' }}"
                                    style="{{ isset($movie->image) ? '' : 'display: none;' }}">
                            </div>

                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                        @if(isset($movie_id))
                            <button type="button" id="submit" class="btn btn-success">Update Movie</button>
                        @else
                            <button type="button" id="submit" class="btn btn-success">Add Movie</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/parsleyjs"></script>
<script>
    $(document).on("click" , "#submit" , function(e){
        e.preventDefault()
        var valid = $('#movie-form').parsley().validate();
        var movie_id = "{{ $movie_id }}"
        if(valid){
            var formData = new FormData($('#movie-form')[0]);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('movie_id', movie_id);
            $.ajax({
                type: "POST",
                url: "{{ route('movie.store') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if(response && response.status == 'success'){
                        $.notify( response.message, 'success' );

                        setTimeout(() => {
                            location.href = "{{ route('movie.list') }}";
                        }, 1000);
                    } else {
                        $.notify( response.message, 'error' );
                    }
                },
                error: function(xhr, status, error) {
                    $.notify("Something went wrong !!", 'error' );
                },
            });
        }
    })

    $(document).on('change', '#image', function () {
        const input = this;

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                $('#uploaded-image')
                    .attr('src', e.target.result)
                    .show();
            };

            reader.readAsDataURL(input.files[0]);
        }
    });
</script>
@endsection


