@extends('layouts.app')


@section('title', 'Posts')
    

@section('content')

@forelse ($posts as $post)
<h3><a href="{{ route('posts.show', ['post' => $post->id]) }}" >{{ $post->title }}</a></h3>
    <div class="mb-3">
        <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
        <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id ]) }}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-primary">Delete!</button>
        </form>
    </div>
@empty
    <h3>No Posts Found</h3>
@endforelse

@endsection