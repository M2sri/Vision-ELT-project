<h2>Students List</h2>

<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th>Name</th>
            <th>Branch</th>
            <th>Score</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>
            <td>{{ $student->name }}</td>
            <td>{{ $student->branch }}</td>
            <td>{{ optional($student->latestTestResult)->score ?? '-' }}</td>
            <td>
                {{ $student->test_attempts_count > 0 ? 'Completed' : 'Not Taken' }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
