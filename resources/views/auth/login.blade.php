@extends('layouts.app')
@section('content')
    <form method="post" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="">E-mail</label>
            <input type="text" name="email" value="{{ old('email') }}" required
                class="form-control @error('email') is-invalid @enderror">
        </div>

        @error('email')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror

        <div class="form-group">
            <label for="">Password</label>
            <input type="password" name="password" required
                class="form-control @error('password') is-invalid @enderror">
        </div>
        @error('password')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror

        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="remember" value{{ old('remember')? 'checked': '' }} id="">
                <label for="remember" class="form-check label">Remember Me</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block ">Login</button>
    </form>
@endsection

