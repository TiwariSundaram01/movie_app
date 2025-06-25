<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;

class ApiController extends Controller
{
    public function register(Request $request){
        $valid = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'required|numeric|digits:10'
        ]);

        if ($valid->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $valid->errors()
            ], 422);
        }

        // create user.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully!',
            'data' => $user
        ], 200);
    }

    public function login(Request $request){

        $valid = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($valid->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication Fails',
                'errors' => $valid->errors()
            ], 422);
        }

        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user = Auth::user();
                return response()->json([
                    'status' => 'success',
                    'token' => $user->createToken("API Token")->plainTextToken,
                    'message' => 'User Logged-In Successfully!!'
                ], 200);
        } else {
            
            return response()->json([
                'status' => 'error',
                'message' => 'Un-authorized User!',
            ], 401);
        }
    }

    
    public function logout(Request $request)
    {
        if (!$request->user()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated user.'
            ], 401);
        }

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully.'
        ]);
    }

    public function listMovies(Request $request) 
    {
        $movies = Movie::select('id', 'title', 'description', 'runtime', 'imdb_rating', 'published_at', 'image')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return response()->json([
            'status' => 'success',
            'data' => $movies
        ]);
    }

    public function showMovie($id)
    {
        $movie = Movie::select('id', 'title', 'description', 'runtime', 'imdb_rating', 'published_at', 'image')
                    ->find($id);

        if (!$movie) {
            return response()->json([
                'status' => 'error',
                'message' => 'Movie not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $movie
        ]);
    }
}
