@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
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
            <div class="form-check">
                <input type="checkbox" name="remember" value="{{ old('remember') ? 'checked' : '' }}"  class="form-check-input">
                <label class="form-check-label" for="remember">Remember Me</label>

            </div>
           
        </div>
        
        <button class="btn btn-primary">Submit</button>
    </form>
@endsection