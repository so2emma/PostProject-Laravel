@extends('layouts.app')

@section('title', 'Blog Posts')


@section('content')

    @forelse ($posts as $key => $post)
        {{-- @include('posts.partials.post') --}}
        <h3>
            <a href="{{ route('posts.show', ['post' => $post->id]) }}"> {{ $post->title }}</a>
        </h3>
        <p class="text-muted">
            Added {{ $post->created_at->diffForHumans() }}
            by {{ $post->user->name }}
        </p>
        @if ($post->comments_count)
            <p>{{ $post->comments_count }} comments</p>
        @else
            No comments yet!
        @endif
        <div class="mb-3">
            <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
            <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post">
                @csrf
                @method('DELETE')
                <input type="submit" value="Delete!" class="btn btn-primary">
            </form>
        </div>

    @empty
        No posts Found
    @endforelse



@endsection
