{{-- <div class="fi-ta-header flex flex-col gap-4 px-4 sm:px-6">
    <div class="flex flex-col gap-4">
        <div class="flex flex-col gap-2">
            <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                @foreach($scopes as $scope => $label)
                    <a 
                        href="{{ $resourceUrl }}?scope={{ $scope }}"
                        @class([
                            'flex items-center gap-x-1 font-medium',
                            'text-primary-600 dark:text-primary-400' => $scope === $currentScope,
                            'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' => $scope !== $currentScope,
                        ])
                    >
                        <span>{{ $label }}</span>
                        <span class="text-xs text-gray-400 dark:text-gray-500">
                            ({{ $counts[$scope] ?? 0 }})
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div> --}}

<div class="flex space-x-4">
    @foreach ($scopes as $key => $label)
        <a 
            href="{{ $resourceUrl }}?scope={{ $key }}"
            @class([
                'px-4 py-2 rounded-md text-sm font-medium',
                'bg-primary-600 text-white' => $currentScope === $key,
                'bg-gray-200 text-gray-800' => $currentScope !== $key,
            ])
        >
            {{ $label }} ({{ $counts[$key] ?? 0 }})
        </a>
    @endforeach
</div>
