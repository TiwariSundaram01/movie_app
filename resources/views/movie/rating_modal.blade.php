<style>
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
</style>

<!-- Rating Modal -->
<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h5 class="modal-title" id="ratingModalLabel">{{ !empty($ratingData) ? 'Edit Rating' : 'Add Rating' }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <!-- Modal Body -->
            <div class="modal-body text-center">
                <label class="form-label d-block mb-2">
                    @if(!empty($ratingData) && isset($ratingData->is_edited) && $ratingData->is_edited)
                        You’ve already edited your rating. Further changes are not allowed.
                    @else 
                        Your Rating:
                    @endif
                </label>
                <div class="star-rating">
                @for ($i = 10; $i >= 1; $i--)
                    <input type="radio" id="star{{ $i }}" class="rate" name="rating" value="{{ $i }}" {{ !empty($ratingData) && $i == $ratingData->rating ? 'checked' : '' }}>
                    <label for="star{{ $i }}">★</label>
                @endfor
                </div>
                <div id="rating-error" class="text-danger mb-2"></div>
                <input type="hidden" name="movie_id" id="movie_id" value="{{ $movie_id ?? '' }}">
            </div>
        <!-- Modal Footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            @if((!empty($ratingData) && isset($ratingData->is_edited) && !$ratingData->is_edited) || is_null($ratingData) )
                <button type="button" class="btn btn-primary" id="submit-rating">Submit</button>
            @endif
        </div>
    </div>
  </div>
</div>

<script>
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