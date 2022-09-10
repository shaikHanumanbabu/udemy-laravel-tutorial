@extends('layouts.app')


@section('title', $post->title)
    

@section('content')

<form action="{{ route('posts.update', ['post' => $post->id]) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('posts.partials.form')
    <button type="submit" class="btn btn-primary btn-blocked">Update</button>
</form>

@endsection