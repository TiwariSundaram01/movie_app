<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use App\Models\Rating;
use Illuminate\Support\Facades\Gate;

class MovieController extends Controller
{
    public function index(){
        $movies = Movie::paginate(9);
        return view('movie.index' , compact('movies'));
    }

    public function addMovie(){
        return view('movie.addMovie');
    }

    public function storeMovie(Request $request)
    {
        try {
            $id = null;
            $imagePath = null;

            if(isset($request->movie_id)){
                $id = $request->movie_id;
                $movie = Movie::find($id);

                if (Gate::denies('update', $movie)) {
                    return redirect()->back()->with('error', 'You are not authorized to edit this movie.');
                }

                if(!empty($movie)) {
                    $imagePath = $movie['image'];
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Movie not found!'
                    ], 200);
                }
                
            }
            
            // Handle image upload
            if ($request->hasFile('image')) {

                // Delete old image if it exists
                if (isset($imagePath)) {
                    $oldImagePath = public_path('storage/' . $imagePath);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $imgType = $request->file('image')->extension();
                $imgName = time() . "." . $imgType;
                $imagePath = $request->file('image')->storeAs('movies', $imgName, 'public');
            }

            // Calculate total runtime in minutes
            $runTime = ($request->input('runtime_hours') * 60) + $request->input('runtime_minutes');

            if(isset($id)){
                // update movie record
                Movie::where('id', $id)->update([
                    'user_id' => Auth::id(),
                    'title' => $request->title,
                    'description' => $request->description,
                    'runtime' => $runTime,
                    'published_at' => $request->published_at,
                    'image' => $imagePath,
                ]);

                $message = 'Movie updated successfully!';

            }else{
                // Save movie record
                Movie::create([
                    'user_id' => Auth::id(),
                    'title' => $request->title,
                    'description' => $request->description,
                    'runtime' => $runTime,
                    'published_at' => $request->published_at,
                    'image' => $imagePath,
                ]);

                $message = 'Movie added successfully!';

            }
        
            return response()->json([
                'status' => 'success',
                'message' => $message
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Movie Store Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function showMovie(Request $request) {
        $id = $request->id;
        $movie = Movie::getMovieById($id);
        
        return view('movie.showMovie',compact('movie'));
    }

    public function editMovie(Request $request) {
        $id = $request->id;
        $movie = Movie::getMovieById($id);

        if (Gate::denies('update', $movie)) {
            return redirect()->back()->with('error', 'You are not authorized to update this movie.');
        }

        return view('movie.addMovie' , compact('movie'));
    }

    public function deleteMovie(Request $request)
    {
        $movie_id = $request->id;

        // Find the movie
        $movie = Movie::find($movie_id);

        if (Gate::denies('delete', $movie)) {
            return redirect()->back()->with('error', 'You are not authorized to delete this movie.');
        }
            
        if (!$movie) {
            return response()->json([
                'status' => false,
                'message' => 'Movie not found.'
            ]);
        }

        try {
            // Delete associated ratings
            Rating::where('movie_id', $movie_id)->delete();

            // Delete movie
            $movie->delete();

            return response()->json([
                'status' => true,
                'message' => 'Movie deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete movie.',
                'error' => $e->getMessage()
            ]);
        }
    }


    public function addRating(Request $request)
    {
        $movie_id = $request->movie_id;
        $user_id = Auth::id();

        // Fetch existing rating if it exists
        $ratingData = Rating::where('movie_id', $movie_id)
                            ->where('user_id', $user_id)
                            ->first();

        // Render the rating modal view
        $view = view('movie.rating_modal', compact('ratingData', 'movie_id'))->render();

        return response()->json([
            'success' => true,
            'view' => $view,
        ]);
    }

    public function storeRating(Request $request) {
        try {
            $user_id = Auth::id();
            $movie_id = $request->movie_id;
            $rating = $request->rating;

            // Optional: Prevent duplicate rating (one rating per user per movie)
            $existingRating = Rating::where('movie_id', $movie_id)
                                    ->where('user_id', $user_id)
                                    ->first();

            if ($existingRating) {
                // Update existing rating instead of creating new
                $existingRating->update(['rating' => $rating, 'is_edited' => true]);

                return response()->json([
                    'success' => true,
                    'message' => 'Rating updated successfully',
                    'data' => $existingRating,
                ]);
            }

            // Store new rating
            $newRating = Rating::create([
                'movie_id' => $movie_id,
                'user_id' => $user_id,
                'rating' => $rating,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Rating submitted successfully',
                'data' => $newRating,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
