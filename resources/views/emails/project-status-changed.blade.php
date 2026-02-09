<!DOCTYPE html>
<html>
<head>
    <title>Project Status Changed</title>
</head>
<body>
    <h2>Hello {{ $project->creator->first_name }},</h2>
    <p>The status of your project has been updated:</p>
    <h3>{{ $project->name }}</h3>
    <p><strong>Old Status:</strong> {{ ucfirst($oldStatus) }}</p>
    <p><strong>New Status:</strong> {{ ucfirst($project->status) }}</p>
    <p>Please check the system for more details.</p>
</body>
</html>
