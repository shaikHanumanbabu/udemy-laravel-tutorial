<style>
    body {
        font-family: 'Courier New', Courier, monospace
    }
</style>

<p>Hi {{ $user->name }}</p>


<p>Some one has commented on your blog post

    <a href="{{ route('posts.show', ['post' => $comment->commentable->id]) }}">
        {{ $comment->commentable->title }}
    </a>
</p>


<hr>


<p>
    <a href="{{ route('users.show', ['user' => $comment->user->id ]) }}">
        {{ $comment->user->name }}
    </a> said: {{ $comment->content }}
</p>