@extends('layouts.app')

@section('title', 'contact page')


@section('content')
<h1>Contact</h1>
<p>Hello this is Contact!</p>

@can('home.secret')
<h1>Welcome to my Blogging App - CONTACT PAGE</h1>
<p>
    <a href="{{ route('home.secret') }}">Special Contact Details</a>
</p>
@endcan
@endsection
