@extends('layouts.app')

@section('content')
    
    <div class="row">
        <div class="col-4">
            <img src="{{ $user->image  ? $user->image->url() : ''}}" alt="{{ $user->id }}">
            
        </div>
        <div class="col-8">
            <div class="form-group">
                <label for=""></label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </div>
    </div>
@endsection