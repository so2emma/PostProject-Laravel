@extends('layouts.app')

@section('title', $post->title)

@section('content')

    <div class="row">
        <div class="col-8">
            @if ($post->image)
            <div style="background-image: url('{{ $post->image->url() }}'); min-height: 500px; color:white; text-align:center; background-attachement:fixed;">
            {{-- <img src="{{ $post->image->url() }}"   alt=""> --}}
                <h1 style="padding-top: 100px; text-shadow:1px 2px #000">Blog Post</h1>
            </div>
            @endif


            <h1>{{ $post->title }}</h1>
            <p>{{ $post->content }}</p>

            @if (now()->diffInMinutes($post->created_at) < 5)
                <x-badge type="success">
                    New Post
                </x-badge>
            @endif

            @component('components.updated', ['date' => $post->created_at, 'name' => $post->user->name])
            @endcomponent

            @component('components.updated', ['date' => $post->updated_at])
                Updated
            @endcomponent

            @component('components.tags', ['tags' => $post->tags])
            @endcomponent

            {{-- <p>
                Currently read by {{ $counter }} people
            </p> --}}

            <p>{{ trans_choice("messages.people.reading", $counter ) }}</p>


            <h4>Comments</h4>

            @component("components.comment-form", ["route" =>route("posts.comments.store", ["post" => $post->id]) ])

            @endcomponent
            <x-errors></x-errors>

            @component("components.comment-list", ["comments" => $post->comments])
            @endcomponent
        </div>

        <div class="col-4">
            @include("posts.partials.activity")
        </div>
    </div>


@endsection
