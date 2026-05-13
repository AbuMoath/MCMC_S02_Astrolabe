<!-- Assignments Report Data -->
<table class="data-table">
    <thead>
        <tr>
            <th>Assignment ID</th>
            <th>Inquiry ID</th>
            <th>Agency</th>
            <th>Assigned Date</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Due Date</th>
            <th>Completion Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reportData as $assignment)
            <tr>
                <td>{{ $assignment->AssignmentID ?? $assignment['AssignmentID'] ?? 'N/A' }}</td>
                <td>{{ $assignment->InquiryID ?? $assignment['InquiryID'] ?? 'N/A' }}</td>
                <td>{{ $assignment->agency_name ?? $assignment['agency_name'] ?? ($assignment->AgencyName ?? $assignment['AgencyName'] ?? 'N/A') }}</td>
                <td>{{ isset($assignment->AssignmentDate) ? date('M j, Y', strtotime($assignment->AssignmentDate)) : (isset($assignment['AssignmentDate']) ? date('M j, Y', strtotime($assignment['AssignmentDate'])) : 'N/A') }}</td>
                <td>{{ $assignment->AssignmentStatus ?? $assignment['AssignmentStatus'] ?? 'N/A' }}</td>
                <td>{{ $assignment->Priority ?? $assignment['Priority'] ?? 'Normal' }}</td>
                <td>{{ isset($assignment->DueDate) ? date('M j, Y', strtotime($assignment->DueDate)) : (isset($assignment['DueDate']) ? date('M j, Y', strtotime($assignment['DueDate'])) : 'N/A') }}</td>
                <td>{{ isset($assignment->CompletionDate) ? date('M j, Y', strtotime($assignment->CompletionDate)) : (isset($assignment['CompletionDate']) ? date('M j, Y', strtotime($assignment['CompletionDate'])) : 'N/A') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@if(count($reportData) == 0)
<div class="no-data">
    <p>No assignments found for the selected criteria.</p>
</div>
@endif
