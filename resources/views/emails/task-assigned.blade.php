<!DOCTYPE html>
<html>
<head>
    <title>New Task Assigned</title>
</head>
<body>
    <h2>Hello {{ $task->assignedUser->first_name }},</h2>
    <p>A new task has been assigned to you:</p>
    <h3>{{ $task->title }}</h3>
    <p><strong>Description:</strong> {{ $task->description }}</p>
    <p><strong>Priority:</strong> {{ ucfirst($task->priority) }}</p>
    <p><strong>Due Date:</strong> {{ $task->due_date ? $task->due_date->format('Y-m-d') : 'Not set' }}</p>
    <p><strong>Project:</strong> {{ $task->project->name }}</p>
    <p>Please check the system for more details.</p>
</body>
</html>
