<ul>
    @foreach ($getRecord()->categories as $category)
        <li>
            <strong>{{ $category->name }}</strong>
            @if ($category->childCategories->isNotEmpty())
               <ul>
                @foreach ($category->childCategories as $child)
                <li>{{ $child->name }}</li>
                @endforeach</ul> 
            @endif
        </li>
    @endforeach
</ul>