@extends('layouts.app')


@section('title', $post->title)
    

@section('content')
<h1>{{ $post->title }} 
    @badge(['show' => now()->diffInMinutes($post->created_at) < 65])
        Brand new post
    @endbadge
</h1>
<p>{{ $post->content }}</p>


@updated(['date' => $post->created_at, 'name' => $post->user->name])
        
@endupdated
@updated(['date' => $post->updated_at])
    Updated
@endupdated



@badge(['type' => 'warning'])
    Comments
@endbadge
<hr>
@forelse ($post->comments as $comment)
    <p>
        {{ $comment->content }}
    </p>
    <p class="text-muted">
     @updated(['date' => $comment->created_at])
        
     @endupdated
    </p>
@empty
    <p>No comments</p>
@endforelse

@endsection