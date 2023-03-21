<div class="form-group">
    <label for="title">Title</label>
    <input id="title" type="text" name="title" class="form-control"
        value="{{ old('title', optional($post ?? null)->title) }}">
</div>

<div class="form-group">
    <label for="content">Content</label>
    <textarea name="content" id="" value="" class="form-control">{{ old('content', optional($post ?? null)->content) }}</textarea>
</div>

<div class="form-group">
    <label class="form-label" for="thumbnail">Thumbnail</label>
    <input type="file" name="thumbnail" id="thumbnail" class="form-control">
</div>

<x-errors></x-errors>

