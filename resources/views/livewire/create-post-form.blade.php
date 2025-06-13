<div class="space-y-4 p-6 bg-white shadow rounded">
    @if (session()->has('message'))
    <div class="text-green-600">{{ session('message') }}</div>
    @endif

    <div>
        <label class="block">Title:</label>
        <input type="text" wire:model="title" class="border rounded p-2 w-full">
        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block">Content:</label>
        <textarea wire:model="content" class="border rounded p-2 w-full"></textarea>
        @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <button wire:click="save" class="px-4 py-2 bg-blue-600 text-white rounded">Save Post</button>
</div>
