<?php

namespace App\Jobs;

use App\Models\Note;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Note $note)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $noteUrl = config('app.url') . '/notes/' . $this->note->id;
        $emailContent = "Hello, you've received a new note. Check it out at {$noteUrl}";
        Mail::raw($emailContent, function ($message) {
            $message->from('sendnotes@zimfy.co', 'Sendnotes')
                ->to($this->note->recipient)
                ->subject('you have a new note from ' . $this->note->user->name);
        });
    }
}
