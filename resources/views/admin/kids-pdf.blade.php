<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kids Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .header { text-align: center; margin-bottom: 20px; }
        .date { text-align: right; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Kids Report</h1>
        <p>Generated on: {{ now()->format('d M Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Age</th>
                <th>Zone</th>
                <th>Phone</th>
                <th>City</th>
                <th>Country</th>
                <th>Score</th>
                <th>Level</th>
                <th>Status</th>
                <th>Registration Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kids as $index => $kid)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $kid->kid_name }}</td>
                <td>{{ $kid->age }}</td>
                <td>{{ strtoupper($kid->zone) }}</td>
                <td>{{ $kid->phone }}</td>
                <td>{{ $kid->city }}</td>
                <td>{{ $kid->country }}</td>
                <td>{{ $kid->latestCompletedAttempt?->score ?? '-' }}</td>
                <td>{{ $kid->latestCompletedAttempt?->level ?? '-' }}</td>
                <td>{{ $kid->completed_test_attempts_count > 0 ? 'Completed' : 'Not Taken' }}</td>
                <td>{{ $kid->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>