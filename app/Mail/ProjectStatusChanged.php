<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProjectStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Project $project,
        public string $oldStatus
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Project Status Changed: ' . $this->project->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.project-status-changed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
