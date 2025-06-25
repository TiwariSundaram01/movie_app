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
                <div class="star-rating {{ (!empty($ratingData) && isset($ratingData->is_edited) && $ratingData->is_edited) ? 'pointer-none' : '' }}">
                @for ($i = 10; $i >= 1; $i--)
                    <input type="radio" id="star{{ $i }}" class="rate" name="rating" value="{{ $i }}" {{ !empty($ratingData) && $i == $ratingData->rating ? 'checked' : '' }} >
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