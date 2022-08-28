<p class="text-muted">
    {{ empty($slot) ? 'Added': $slot }} {{ $date->diffForHumans() }}
    @if (isset($name))
        by {{ $name }}
    @endif
    
</p>
