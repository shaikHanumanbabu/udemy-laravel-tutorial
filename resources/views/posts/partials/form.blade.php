<div class="form-group">
    <label for="title">title</label>
    <input id="title" type="text" name="title" class="form-control" value="{{ old('title', optional($post ?? null)->title) }}">
</div>
<div class="form-group">
    <label for="">content</label>
    <input type="text" name="content" class="form-control" value="{{ old('content', optional($post ?? null)->content) }}">
</div>
@if ($errors->any())
    <div class="mb-3">
        <ul class="list-group">
            @foreach ($errors->all() as $error)
                <li class="list-group-item list-group-item-danger">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif