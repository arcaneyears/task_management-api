<?php

namespace App\Jobs;

use App\Mail\TaskStatusChangedMail;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTaskStatusChangedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Task $task, public string $oldStatus) {}

    public function handle(): void
    {
        if ($this->task->assignedUser) {
            Mail::to($this->task->assignedUser->email)->send(new TaskStatusChangedMail($this->task, $this->oldStatus));
        }
    }
}
