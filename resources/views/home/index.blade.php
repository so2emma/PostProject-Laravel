@extends('layouts.app')

@section('title', 'Home')


@section('content')
<h1>{{ __('messages.welcome') }}</h1>

<p>{{ __("messages.example_with_value", ['name' => 'John']) }}</p>

<p>{{ trans_choice('messages.plural', 0) }}</p>
<p>{{ trans_choice('messages.plural', 1) }}</p>
<p>{{ trans_choice('messages.plural', 2) }}</p>

<p>Using : JSON{{ __("Welcome to laravel") }}</p>
<p>Using : JSON{{ __("Hello :name", ['name' => 'OSO']) }}</p>
<p>This content is the main page</p>
<h1>Welcome to my Blogging App - HOME PAGE</h1>
@endsection
