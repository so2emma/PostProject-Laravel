@extends('layouts.app')
@section('content')
    <form method="post" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="form-control @error('name') is-invalid @enderror ">
        </div>

        @error('name')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror

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
            <label for="">Retyped Password</label>
            <input type="password" name="password_confirmation" required class="form-control">
        </div>

        <button type="submit" class="btn btn-primary btn-block ">Register!</button>
    </form>
@endsection

