@extends('layouts.app')


@section('title', 'Posts')
    

@section('content')

<form action="{{ route('posts.store') }}" method="post">
    @csrf
    @include('posts.partials.form')
    <button class="btn btn-primary btn-block mt-3" type="submit">Submit</button>
</form>

@endsection