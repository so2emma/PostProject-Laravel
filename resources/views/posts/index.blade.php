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
                    <a class="{{ $post->trashed() ? 'text-muted' : ''}}"
                     href="{{ route('posts.show', ['post' => $post->id]) }}"> {{ $post->title }}</a>
                    @if ($post->trashed())
                        </del>
                    @endif

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
                    @can('update', $post)
                        <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
                    @endcan
                    @if (!$post->trashed())
                    @can('delete', $post)
                        <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Delete!" class="btn btn-primary">
                        </form>
                    @endcan
                    @endif
                </div>

            @empty
                No posts Found
            @endforelse

        </div>

        <div class="col-4">
            <div class="container">
                <div class="row mb-3">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Most Commented</h5>
                            <h6 class="card-subtitle mb-2 text-muted">what people are currently talking about</h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($mostCommented as $post)
                                <li class="list-group-item">
                                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Most Active Users</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Users with most post written</h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($mostActive as $user)
                                <li class="list-group-item">
                                    {{ $user->name }}
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Most Active Last Month</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Users with most post written in the last Month</h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($mostActiveLastMonth as $user)
                                <li class="list-group-item">
                                    {{ $user->name }}
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
