@extends('layouts.app')

@section('content')
    <form action="{{ route('users.update', ['user' => $user->id ]) }}" method="POST"
          enctype="multipart/form-data"    
    >
    @csrf
    @method('put')
    <div class="row">
        <div class="col-4">
            <img src="" alt="">
            <div class="card">
                <div class="card-body">
                    <h6>Upload a different file</h6>
                    <img src="{{ $user->image ? $user->image->url() : '' }}" alt="{{ $user->id }}">
                    <input class="form-control-file" type="file" name="avatar" id="">

                </div>
            </div>
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
    </form>
@endsection