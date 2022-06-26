<p class="text-muted">
    {{ empty(trim($slot)) ? 'Added ' : $slot}}
     {{ $date->diffForHumans() }}
    @if (isset($name))
        {{ $name }}
    @endif
</p>
