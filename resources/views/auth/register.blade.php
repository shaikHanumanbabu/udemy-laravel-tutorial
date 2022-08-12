@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="form-control {{ $errors->has('name') ? 'is-invalid': '' }}">
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control {{ $errors->has('name') ? 'is-invalid': '' }}">

            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="">Password</label>
            <input type="password" name="password" value="{{ old('password') }}" required class="form-control">
            @if ($errors->has('password'))
                <span class="is-invalid">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="">Re-Enter Password</label>
            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" required class="form-control">
        </div>
        <button class="btn btn-primary">Submit</button>
    </form>
@endsection