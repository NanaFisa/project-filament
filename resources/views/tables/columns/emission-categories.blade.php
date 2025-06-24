<ul>
    @foreach ($getRecord()->categories as $category)
        <li>
            <strong>{{ $category->name }}</strong>
            @if ($category->activities->isNotEmpty())
               <ul>
                @foreach ($category->activities as $child)
                <li>{{ $child->name }}</li>
                @endforeach</ul> 
            @endif
        </li>
    @endforeach
</ul>