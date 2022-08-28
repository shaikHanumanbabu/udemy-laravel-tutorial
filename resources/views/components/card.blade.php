<div class="card" style="width: 18rem;">
    <div class="card-header">
      {{ $title }}
    </div>
    <ul class="list-group list-group-flush">
      @if (is_a($items, 'Illuminate\Support\Collection'))
        @foreach ($items as $item)
            <li class="list-group-item">
                {{-- <a href="{{ route('posts.show', ['post' => $post->id ]) }}">{{ $post->title }}</a></li> --}}
                {{ $item }}
            </li>
        @endforeach
      @else
        {{ $items }}
      @endif

    </ul>
</div>