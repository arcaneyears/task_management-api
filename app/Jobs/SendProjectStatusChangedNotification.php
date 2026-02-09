<?php

namespace App\Jobs;

use App\Mail\ProjectStatusChangedMail;
use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendProjectStatusChangedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Project $project, public string $oldStatus) {}

    public function handle(): void
    {
        Mail::to($this->project->creator->email)->send(new ProjectStatusChangedMail($this->project, $this->oldStatus));
    }
}
