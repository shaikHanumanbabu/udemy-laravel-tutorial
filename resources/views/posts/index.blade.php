@extends('layouts.app')


@section('title', 'Posts')
    

@section('content')
<div class="row">
    <div class="col-8">
@forelse ($posts as $post)
<h3><a href="{{ route('posts.show', ['post' => $post->id]) }}" >{{ $post->title }}</a></h3>
    @if ($post->trashed())
        <div class="alert alert-danger">Deleted</div>
    @endif

    @updated(['date' => $post->created_at, 'name' => $post->user->name, 'userId' => $post->user->id])
        
    @endupdated
   
    @tags(['tags' => $post->tags])
    @endtags
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
</div>

<div class="col-4">
    @include('posts.partials._activity')
    
</div>
</div>


@endsection