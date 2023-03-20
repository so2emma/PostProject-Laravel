@extends('layouts.app')

@section('title', $post->title)

@section('content')

    <div class="row">
        <div class="col-8">
            <h1>{{ $post->title }}</h1>
            <p>{{ $post->content }}</p>
            @component('components.updated', ['date' => $post->created_at, 'name' => $post->user->name])
            @endcomponent

            @component('components.updated', ['date' => $post->updated_at])
                Updated
            @endcomponent

            @component('components.tags', ['tags' => $post->tags])
            @endcomponent

            <p>
                Currently read by {{ $counter }} people
            </p>

            @if (now()->diffInMinutes($post->created_at) < 5)
                <x-badge type="success">
                    New Post
                </x-badge>
            @endif

            <h4>Comments</h4>

            @include("comments.partials.form")
            <x-errors></x-errors>

            @forelse ($post->comments as $comment)
                <p>
                    {{ $comment->content }},
                </p>
                @component('components.updated', ['date' => $comment->created_at, "name" => $comment->user->name])
                @endcomponent
            @empty
                <p>No comments yet!</p>
            @endforelse
        </div>

        <div class="col-4">
            @include("posts.partials.activity")
        </div>
    </div>


@endsection
