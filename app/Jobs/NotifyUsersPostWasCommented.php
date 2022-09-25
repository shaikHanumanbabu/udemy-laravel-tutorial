<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use App\Mail\CommentPostedOnPostWatched;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Storage;

class NotifyUsersPostWasCommented implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $comment;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Storage::disk('public')->append('log.txt', "before sending a request");
        
        $users = User::thatHasCommentedOnPost($this->comment->commentable)
            ->get();
            // ->filter(function(User $user) {
            //     return $user->id !== $this->comment->user_id;
            // })
        Storage::disk('public')->append('log.txt', $users);
        
        $users->map(function(User $user) {
            // Storage::put('log.txt', $user);
            // echo now()->format('Y-m-d H:i:s');
            Mail::to("jayanth@gmail.com")->send(
                new CommentPostedOnPostWatched($this->comment, $user)
            );
        })
            
            ;

        
    }
}
