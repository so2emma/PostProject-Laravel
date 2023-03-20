<p>
    {{-- <a href="#" class="badge badge-success badge-lg">{{ $tags }}</a> --}}

    @foreach ($tags as $tag)
        <a href="{{ route("posts.tags.index", $tag->id) }}" class="badge badge-success badge-lg">{{ $tag->name }}</a>
    @endforeach
</p>
