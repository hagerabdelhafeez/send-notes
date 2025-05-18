<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Note;

new #[Layout('layouts.app')] class extends Component {
    public Note $note;
    public $title;
    public $body;
    public $recipient;
    public $send_date;
    public $is_published;

    public function mount(Note $note)
    {
        $this->authorize('update', $note);

        $this->fill($note);
        $this->title = $note->title;
        $this->body = $note->body;
        $this->recipient = $note->recipient;
        $this->send_date = $note->send_date;
        $this->is_published = $note->is_published;
    }

    public function updateNote()
    {
        $validated = $this->validate([
            'title' => 'required|min:5|string',
            'body' => 'required|min:20|string',
            'recipient' => 'required|email',
            'send_date' => 'required|date',
        ]);
        $this->note->update([
            'title' => $this->title,
            'body' => $this->body,
            'recipient' => $this->recipient,
            'send_date' => $this->send_date,
            'is_published' => $this->is_published,
        ]);
        $this->dispatch('savedNote');
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(' Edit a Note') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <form wire:submit="updateNote" class="space-y-4">
                <x-input wire:model='title' label='Note Title' placeholder="It's been a great day." />
                <x-textarea wire:model='body' label='Your Note'
                    placeholder="Share all your thoughts with your friend." />
                <x-input type="email" icon="user" wire:model='recipient' label='Recipient'
                    placeholder="Yourfriend@email.com" />
                <x-input icon="calendar" wire:model='send_date' type="date" label='Send Date' />
                <x-checkbox wire:model='is_published' label='Publish Note'/>
                <div class="pt-4 flex justify-between">
                    <x-button type="submit" secondary  label="Save Note" spinner="updateNote" />
                    <x-button flat negative label="Back To Notes" href="{{ route('notes.index') }}" />
                </div>
                <x-action-message on="savedNote" />
                <x-errors />
            </form>
        </div>
    </div>
</div>
