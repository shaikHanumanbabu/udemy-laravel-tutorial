@extends('layouts.app')


@section('title', $post->title)
    

@section('content')
<div class="row">
    <div class="col-8">
<h1>{{ $post->title }} 
    @badge(['show' => now()->diffInMinutes($post->created_at) < 65])
        Brand new post
    @endbadge
</h1>
<p>{{ $post->content }}</p>

@if ($post->image)
    <img src="{{ $post->image->url() }}" alt="" height="500">
@else
    <h2>No Image Found!!</h2>
@endif
{{-- <img src="{{ url('storage/'.$post->image->path) }}" alt=""> --}}


@updated(['date' => $post->created_at, 'name' => $post->user->name])
        
@endupdated
@updated(['date' => $post->updated_at])
    Updated
@endupdated

@tags(['tags' => $post->tags])
@endtags

<p>Currently Reading {{ $counter }}</p>



@badge(['type' => 'warning'])
    Comments
@endbadge

@include('comments._form')
<hr>
@forelse ($post->comments as $comment)
    <p>
        {{ $comment->content }}
    </p>
    <p class="text-muted">
     @updated(['date' => $comment->created_at, 'name' => $comment->user->name])
        
     @endupdated
    </p>
@empty
    <p>No comments</p>
@endforelse

</div>

<div class="col-4">
    @include('posts.partials._activity')
    
</div>
</div>

@endsection