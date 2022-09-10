<p>
    @foreach ($tags as $tag)
        <a href="{{ route('posts.tags.index' , ['tag' => $tag->id ]) }}" >{{ $tag->name }}</a>
    @endforeach
</p>