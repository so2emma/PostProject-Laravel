@extends('layouts.app')

@section('title', 'Blog Posts')


@section('content')
    <div class="row">
        <div class="col-8">
            @forelse ($posts as $key => $post)
                {{-- @include('posts.partials.post') --}}
                <h3>
                    @if ($post->trashed())
                        <del>
                    @endif
                    <a class="{{ $post->trashed() ? 'text-muted' : '' }}"
                        href="{{ route('posts.show', ['post' => $post->id]) }}"> {{ $post->title }}</a>
                    @if ($post->trashed())
                        </del>
                    @endif

                </h3>
                @component('components.updated', ['date' => $post->created_at, 'name' => $post->user->name])
                @endcomponent

                {{-- @component('components.tags', ['tags' => $post->tags])
                @endcomponent --}}
                <x-tags :tags="$post->tags" >

                </x-tags>

                @if ($post->comments_count)
                    <p>{{ $post->comments_count }} comments</p>
                @else
                    No comments yet!
                @endif
                <div class="mb-3">
                    @auth
                        @can('update', $post)
                            <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
                        @endcan
                    @endauth

                    @auth
                        @if (!$post->trashed())
                            @can('delete', $post)
                                <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Delete!" class="btn btn-primary">
                                </form>
                            @endcan
                        @endif
                    @endauth
                </div>

            @empty
                No posts Found
            @endforelse

        </div>

        <div class="col-4">
            @include("posts.partials.activity")
        </div>
    </div>
@endsection
