@extends('layouts.app')


@section('title', $post->title)
    

@section('content')
<h1>{{ $post->title }}</h1>
<p>{{ $post->content }}</p>

<p>Added {{ $post->created_at->diffForHumans() }}</p>

@if (now()->diffInMinutes($post->created_at) < 65)
    <div class="alert alert-success">New</div>
@endif

<h4>Comments</h4>

@forelse ($post->comments as $comment)
    <p>
        {{ $comment->content }}
    </p>
    <p class="text-muted">
     added {{ $comment->created_at->diffForHumans() }}
    </p>
@empty
    <p>No comments</p>
@endforelse

@endsection