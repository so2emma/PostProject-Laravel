<div class="container">
    <div class="row mb-3">
        <x-card>
            @slot('title')
                Most Commented
            @endslot
            @slot('subtitle')
                what people are currently talking about
            @endslot
            @slot('items')
                @foreach ($mostCommented as $post)
                    <li class="list-group-item">
                        <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                    </li>
                @endforeach
            @endslot
        </x-card>
    </div>

    <div class="row mb-3">
        <x-card>
            @slot('title')
                Most Active Users
            @endslot
            @slot('subtitle')
                Writers with most post written
            @endslot
            @slot('items', collect($mostActive)->pluck('name'))
        </x-card>
    </div>

    <div class="row mb-3">
        <x-card>
            @slot('title')
                Most Active Last Month
            @endslot
            @slot('subtitle')
                Writers with most post written last month
            @endslot
            @slot('items', collect($mostActiveLastMonth)->pluck('name'))
        </x-card>
    </div>
</div>
