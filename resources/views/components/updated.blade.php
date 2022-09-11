<p class="text-muted">
    {{ empty($slot) ? 'Added': $slot }} {{ $date->diffForHumans() }}
    @if (isset($name))
        @if (isset($userId))
            <a href="{{ route('users.show', ['user' => $userId]) }}">{{ $name }}</a>
            
        @else
            by {{ $name }}
        @endif
    @endif
    
</p>
