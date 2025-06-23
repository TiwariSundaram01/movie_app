<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function index(){
        $moviesData = Movie::take(10)->get();
        return view('movie.index' , compact('moviesData'));
    }

    public function addMovie(){
        return view('movie.addMovie');
    }

    public function storeMovie(Request $request)
    {
        try {

            // Calculate total runtime in minutes
            $runTime = ($request->input('runtime_hours') * 60) + $request->input('runtime_minutes');

            $imagePath = null;

            // Handle image upload
            if ($request->hasFile('image')) {
                $imgType = $request->file('image')->extension();
                $imgName = time() . "." . $imgType;
                $imagePath = $request->file('image')->storeAs('movies', $imgName, 'public');
            }

            // Save movie record
            Movie::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description,
                'runtime' => $runTime,
                'imdb_rating' => $request->imdb_rating,
                'published_at' => $request->published_at,
                'image' => $imagePath,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Movie added successfully!'
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
        $formType = 'edit';

        return view('movie.addMovie' , compact('movie','formType'));
    }
}
