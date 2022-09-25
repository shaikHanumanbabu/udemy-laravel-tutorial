<?php

namespace App\Mail;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentPostedOnPostWatched extends Mailable
{
    use Queueable, SerializesModels;
    public $comment;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment , User $user)
    {
        $this->comment = $comment;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.posts.comments-posted-on-post-watched');
    }
}
