<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CommentPosted extends Mailable 
{
    use Queueable, SerializesModels;
    public $comment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $post = new BlogPost();
        $subject = "Comment was posted on your {$this->comment->commentable->title}";
        return $this
                // ->attach(storage_path('app/public/'). '/'. $this->comment->user->image->path)
                ->subject($subject)
                ->from('admin@laravel.test', 'Admin')
                ->view('emails.posts.commented');
    }
}
