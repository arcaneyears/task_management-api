<!DOCTYPE html>
<html>
<head>
    <title>Task Status Changed</title>
</head>
<body>
    <h2>Hello {{ $task->assignedUser->first_name }},</h2>
    <p>The status of your task has been updated:</p>
    <h3>{{ $task->title }}</h3>
    <p><strong>Old Status:</strong> {{ ucfirst($oldStatus) }}</p>
    <p><strong>New Status:</strong> {{ ucfirst($task->status) }}</p>
    <p><strong>Project:</strong> {{ $task->project->name }}</p>
    <p>Please check the system for more details.</p>
</body>
</html>
