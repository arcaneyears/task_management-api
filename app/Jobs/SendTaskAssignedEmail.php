<?php

namespace App\Jobs;

use App\Mail\TaskAssigned;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTaskAssignedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Task $task
    ) {}

    public function handle(): void
    {
        if ($this->task->assignee) {
            Mail::to($this->task->assignee->email)
                ->send(new TaskAssigned($this->task));
        }
    }
}
