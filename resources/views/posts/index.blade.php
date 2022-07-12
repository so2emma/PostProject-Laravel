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

                @component('components.tags', ['tags' => $post->tags])
                @endcomponent

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
            <div class="container">
                <div class="row mb-3">
                    <x-card>
                        @slot('title')
                            Most Commented
                        @endslot
                        @slot('subtitle')
                            what people are currently talking about
                        @endslot
                        @slot('items')
                            @foreach ($mostCommented as $post)
                                <li class="list-group-item">
                                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                                </li>
                            @endforeach
                        @endslot
                    </x-card>
                </div>

                <div class="row mb-3">
                    <x-card>
                        @slot('title')
                            Most Active Users
                        @endslot
                        @slot('subtitle')
                            Writers with most post written
                        @endslot
                        @slot('items', collect($mostActive)->pluck('name'))
                    </x-card>
                </div>

                <div class="row mb-3">
                    <x-card>
                        @slot('title')
                            Most Active Last Month
                        @endslot
                        @slot('subtitle')
                            Writers with most post written last month
                        @endslot
                        @slot('items', collect($mostActiveLastMonth)->pluck('name'))
                    </x-card>
                </div>
            </div>
        </div>
    </div>
@endsection
