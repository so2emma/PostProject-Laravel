<div class="card" style="width: 100%;">
    <div class="card-body">
        <h5 class="card-title">{{ $title }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">
            {{ $subtitle }}
        </h6>
    </div>
    <ul class="list-group list-group-flush">
        @if (is_a($items, 'Illumintae\Support\Collections'))
            @foreach ($items as $item)
                <li class="list-group-item">
                    {{ $item }}
                </li>
            @endforeach
        @else
            {{ $item }}
        @endforeach
        @endif

    </ul>
</div>
