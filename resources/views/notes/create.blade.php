<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(' Create a Note') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <x-button icon="arrow-left" info label="All Notes" class="mb-8" href="{{ route('notes.index') }}" />
            <livewire:notes.create-note />
        </div>
    </div>
</x-app-layout>
