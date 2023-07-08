<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class DeletePosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'daily force deletes all softly deleted posts for more than 30 days.
    ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $posts=Post::onlyTrashed()->get();
        //where('delete_at','<',now()->subMonth())->get();
        foreach($posts as $post){
            $post->forceDelete();
        }
    }
}
