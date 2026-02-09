<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Project $project, public string $oldStatus) {}

    public function build()
    {
        return $this->subject('Project Status Updated')
            ->view('emails.project-status-changed');
    }
}
