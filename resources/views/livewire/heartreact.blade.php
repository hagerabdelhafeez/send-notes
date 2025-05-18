<?php

use Livewire\Volt\Component;
use App\Models\Note;

new class extends Component {
    public Note $note;
    public $heartCount;

    public function mount(Note $note)
    {
        $this->note = $note;
        $this->heartCount = $note->heart_count;
    }

    public function increase()
    {
        $this->note->heart_count++;
        $this->note->save();
        $this->heartCount = $this->note->heart_count;
    }
}; ?>

<div>
    <x-button xs rounded wire:click='increase' rose icon="heart" wire:navigate spinner>{{ $heartCount }}</x-button>
</div>
