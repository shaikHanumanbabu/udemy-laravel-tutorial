@forelse ($comments as $comment)
    <p>
        {{ $comment->content }}
    </p>

    @tags(['tags' => $comment->tags])
    @endtags

    <p class="text-muted">
     @updated(['date' => $comment->created_at, 'name' => $comment->user->name, 'userId' => $comment->user->id ])
        
     @endupdated
    </p>
@empty
    <p>No comments</p>
@endforelse