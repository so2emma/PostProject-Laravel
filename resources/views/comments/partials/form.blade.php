<div class="my-2">
    @auth
    <form action="{{ route("posts.comments.store", $post->id) }}" method="post">
        @csrf
        <div class="form-group">
            <textarea name="content" id="" value="" class="form-control"></textarea>
        </div>
        <div><input type="submit" value="Add Comment!" class="btn btn-primary btn-block"></div>
    </form>
    @else
    <a href="{{ route("login") }}">Sign-in </a>to comment.
    @endauth
</div>
<hr>
