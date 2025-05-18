<?php

use Livewire\Volt\Component;

new class extends Component {
    public $title;
    public $body;
    public $recipient;
    public $send_date;

    public function submit() {
        $validated = $this->validate([
            'title' => 'required|min:5|string',
            'body' => 'required|min:20|string',
            'recipient' => 'required|email',
            'send_date' => 'required|date',
        ]);
        Auth::user()->notes()->create([
            'title' => $this->title,
            'body' => $this->body,
            'recipient' => $this->recipient,
            'send_date' => $this->send_date,
           'is_published' => true,
        ]);
        redirect(route('notes.index'));
    }

}; ?>

<div>
    <form wire:submit="submit" class="space-y-4">
        <x-input wire:model='title' label='Note Title' placeholder="It's been a great day." />
        <x-textarea wire:model='body' label='Your Note' placeholder="Share all your thoughts with your friend." />
        <x-input type="email" icon="user" wire:model='recipient' label='Recipient' placeholder="Yourfriend@email.com"/>
        <x-input icon="calendar" wire:model='send_date' type="date" label='Send Date' />
        <div class="pt-4">
        <x-button type="submit" icon="clipboard" type="submit" info label="Schedule Note" spinner />
    </div>
    <x-errors />
    </form>
</div>
