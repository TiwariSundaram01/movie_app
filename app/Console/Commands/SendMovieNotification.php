<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Movie;
use App\Notifications\NewMovieNotification;

class SendMovieNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:movie-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send push notification with Movie Title & Description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {

            Log::info('Movie notification send process starting...');

            $latestMovie = Movie::latest()->first();

            if ($latestMovie) {
                $users = User::all();

                foreach ($users as $user) {

                    $user->notify(new NewMovieNotification($latestMovie));
                    Log::info("Notification sent successfully to user id: '{$user->id}' !!");

                }

                Log::info("All notification sent successfully to users!");
            } else {
                Log::info("No movies found!");
            }

        } catch(\Exception $e) {
            Log::info("Error Occured while sending notification ( Exception : '{$e->getMessage()}' )");
        }
       
    }
}
