<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Movie;
use App\Models\Rating;

class UpdateMovieRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:movie-ratings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update movie IMDB ratings based on last month user reviews';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
             Log::info('Starting movie rating update job.');

            $startDate = Carbon::now()->subMonth()->startOfMonth();
            $endDate = Carbon::now()->subMonth()->endOfMonth();

            $movies = Movie::all();

            foreach ($movies as $movie) {
                $averageRating = Rating::where('movie_id', $movie->id)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->avg('rating');

                if ($averageRating) {
                    $movie->imdb_rating = round($averageRating, 2);
                    $movie->save();

                    Log::info("Updated rating for '{$movie->title}' to {$averageRating}");
                } else {
                    Log::info("No ratings for '{$movie->title}' in last month.");
                }
            }

            Log::info('Movie rating update job completed successfully.');

        } catch (\Exception $e) {
            Log::error('Error occurred while updating movie ratings: ' . $e->getMessage());
        }
       
    }
}
