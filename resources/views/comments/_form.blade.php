@auth
<div class="mb-4 mt-2">
    <form action="{{ route('posts.comments.store', ['post' => $post->id]) }}" method="post">
        @csrf
        <div class="form-group">
            <label for="">content</label>
            <textarea type="text" name="content" class="form-control" value=""></textarea>
        </div>
        <button class="btn btn-primary btn-block mt-3" type="submit">Comment</button>
    </form>

</div>
@else
    <p>sign into post comments <a href="/login">login</a></p>
    
@endauth

@errors
@enderrors

<hr>