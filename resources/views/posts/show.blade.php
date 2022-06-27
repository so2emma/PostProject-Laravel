@extends('layouts.app')

@section('title', $post->title)


@section('content')
<h1>{{ $post->title}}</h1>
<p>{{ $post->content }}</p>
@component('components.updated', ['date'=>$post->created_at, 'name'=>$post->user->name])
@endcomponent

@component('components.updated', ['date'=>$post->updated_at])
Updated
@endcomponent
<p>
    Currently read by {{ $counter }} people
</p>

@if(now()->diffInMinutes($post->created_at) < 5)
    <x-badge type="success" >
        New Post
    </x-badge>
@endif

<h4>Comments</h4>
@forelse ($post->comments as $comment)
    <p>
        {{ $comment->content }},
    </p>
    @component('components.updated', ['date'=>$comment->created_at])
    @endcomponent
@empty
    <p>No comments yet!</p>
@endforelse
@endsection
