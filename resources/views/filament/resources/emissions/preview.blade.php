<div class="space-y-4">
    <div>
        <h2 class="text-lg font-semibold">Scope:</h2>
        <p>{{ $record->scope }}</p>
    </div>

    <div>
        <h2 class="text-lg font-semibold">Categories:</h2>
        <ul class="list-disc list-inside">
            @foreach ($record->categories as $category)
                <li>
                    {{ $category->name }}
                    @if ($category->childCategories->count())
                        <ul class="ml-4 list-circle text-sm text-gray-700">
                            @foreach ($category->childCategories as $child)
                                <li>{{ $child->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    <div>
        <h2 class="text-lg font-semibold">Created:</h2>
        <p>{{ $record->created_at->format('d M Y, H:i') }}</p>
    </div>
</div>
