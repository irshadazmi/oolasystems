<div class="list-group tutorial-sidebar">
    @foreach ($chapters as $chapter)
        <a href="{{ route($routePrefix, ['slug' => $chapter['slug']]) }}"
            class="list-group-item list-group-item-action 
                  {{ request()->is('tutorials/*/' . $chapter['slug']) ? 'active' : '' }}">
            {{ $chapter['title'] }}
        </a>
    @endforeach
</div>
