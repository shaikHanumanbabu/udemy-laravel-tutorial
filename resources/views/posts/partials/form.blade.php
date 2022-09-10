<div class="form-group">
    <label for="title">title</label>
    <input id="title" type="text" name="title" class="form-control" value="{{ old('title', optional($post ?? null)->title) }}">
</div>
<div class="form-group">
    <label for="">content</label>
    <input type="text" name="content" class="form-control" value="{{ old('content', optional($post ?? null)->content) }}">
</div>

<div class="form-group">
    <label for="">Thumbnail</label>
    <input type="file" name="thumbnail" class="form-control">
</div>

@errors
@enderrors


