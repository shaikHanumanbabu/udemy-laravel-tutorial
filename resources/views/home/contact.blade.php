@extends('layouts.app')

@section('content')
    <h2>contact layout</h2>

    @can('home.secrete')
        <p>Special hiddent content</p>
    @endcan
@endsection