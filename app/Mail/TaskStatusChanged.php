<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Task $task,
        public string $oldStatus
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Task Status Changed: ' . $this->task->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.task-status-changed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
