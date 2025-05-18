<?php

use Livewire\Volt\Component;
use App\Models\Note;

new class extends Component {
    public function delete($id) {
        $note = Note::where('id', $id)->first();
        $this->authorize('delete', $note);
        if ($note) {
            $note->delete();
        }
    }
    public function with(): array
    {
        return [
            'notes' => Auth::user()->notes()->orderBy('send_date', 'asc')->get(),
        ];
    }
}; ?>

<div>
    <div class="space-y-2">
        @if ($notes->isEmpty())
            <div class="text-center">
                <p class="text-xl font-bold">No Notes yet</p>
                <p class="text-sm text-gray-500 mb-2">Let's create your first note to send.</p>
                <x-button right-icon="plus" rounded="md" positive label="Create Note" href="{{ route('notes.create') }}"
                    wire:navigate />
            </div>
        @else
            <x-button class="mb-6" right-icon="plus" rounded="md" positive label="Create Note"
                href="{{ route('notes.create') }}" wire:navigate />
            <div class="grid grid-cols-3 gap-4">
                @foreach ($notes as $note)
                    <x-card wire:key='{{ $note->id }}'>
                        <div class="flex justify-between">
                            <div>
                                <a href="{{ route('notes.edit', $note) }}"  wire:navigate
                                    class="text-md font-bold hover:underline hover:text-blue-500">{{ $note->title }}</a>
                                <p class="mt-2 text-xs">{{ Str::limit($note->body, 50, '...') }}</p>
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($note->send_date)->format('M-d-Y') }}
                            </div>
                        </div>
                        <div class="flex items-end justify-between mt-4 space-x-1">
                            <p class="text-xs">Recipient: <span class="font-semibold">{{ $note->recipient }}</span>
                            </p>
                            <div>
                                <x-mini-button rounded info xs icon="eye"/>
                                <x-mini-button rounded negative xs icon="trash" wire:click="delete('{{ $note->id }}')" />
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </div>
        @endif
    </div>
</div>
