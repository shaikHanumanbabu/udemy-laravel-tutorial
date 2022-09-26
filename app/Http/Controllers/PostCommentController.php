<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Mail\CommentPosted;
use Illuminate\Http\Request;
use App\Http\Requests\StoreComment;
use App\Http\Resources\Comment;
use Illuminate\Support\Facades\Mail;
use App\Jobs\NotifyUsersPostWasCommented;

class PostCommentController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth')->only('store');
    }

    public function index(BlogPost $post)
    {
        return  Comment::collection($post->comments()->with('user')->get());
        // return $post->comments()->with('user')->get();

    }

    public function store(BlogPost $post, Request $request)
    {
        # code...
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);
        // dd($comment);

        // Mail::to($post->user)->send(new CommentPosted($comment));
        // dd('hello');
        // $when = now()->addSeconds(10);
        // Mail::to($post->user)->queue(new CommentPosted($comment));
        // Mail::to($post->user)->later($when, new CommentPosted($comment));
        NotifyUsersPostWasCommented::dispatch($comment);
        $request->session()->flash('status', 'Comment was created');
        return redirect()->back();
        
    }
}
