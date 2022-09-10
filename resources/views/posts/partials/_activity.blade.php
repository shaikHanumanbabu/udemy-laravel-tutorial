<div class="container">
    <div class="row">
          @card(['title' => 'Most Commented' ])
            @slot('items')
                @foreach ($most_commented as $post)
                    <li class="list-group-item">
                        <a href="{{ route('posts.show', ['post' => $post->id ]) }}">{{ $post->title }}</a></li>
                @endforeach
            @endslot
          @endcard
    </div>
    <div class="row mt-2">
          @card(['title' => 'Most Active User' ])
            @slot('items', collect($mostActive)->pluck('name'))
          @endcard
    </div>

    <div class="row mt-2">
          @card(['title' => 'Most Active Last Month' ])
            @slot('items', collect($lastMonthActive)->pluck('name'))
          @endcard
    </div>
</div>