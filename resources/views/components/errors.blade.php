@if ($errors->any())
    <div class="mb-3">
        <ul class="list-group">
            @foreach ($errors->all() as $error)
                <li class="list-group-item list-group-item-danger my-2">{{ $error }}</li>
            @endforeach
        </ul>
    </div>

@endif
