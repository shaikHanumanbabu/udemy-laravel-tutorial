@extends('layouts.app')


@section('title', 'Posts')
    

@section('content')

@forelse ($posts as $post)
<h3><a href="{{ route('posts.show', ['post' => $post->id]) }}" >{{ $post->title }}</a></h3>
    <p>Added {{ $post->created_at->diffForHumans() }}</p>
    <p>Added by {{ $post->user->name }}</p>
    @if ($post->comments_count)
        <p>{{ $post->comments_count }} Comments</p>
    @else
        <p>No Comments Found</p>
    @endif
    <div class="mb-3">
        @can('update', $post)
            <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
        @endcan

        @can('delete', $post)
        <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id ]) }}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-primary">Delete!</button>
        </form>
            
        @endcan

        @cannot('delete', $post)
            <p>You can't delete post</p>
        @endcannot
    </div>
@empty
    <h3>No Posts Found</h3>
@endforelse

@endsection