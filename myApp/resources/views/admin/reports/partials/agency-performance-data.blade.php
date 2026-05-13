<!-- Agency Performance Report Data -->
<table class="data-table">
    <thead>
        <tr>
            <th>Agency</th>
            <th>Total Assignments</th>
            <th>Completed</th>
            <th>In Progress</th>
            <th>Overdue</th>
            <th>Completion Rate</th>
            <th>Avg Response Time</th>
            <th>Performance Score</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reportData as $agency)
            <tr>
                <td>{{ $agency->agency_name ?? $agency['agency_name'] ?? ($agency->AgencyName ?? $agency['AgencyName'] ?? 'N/A') }}</td>
                <td>{{ $agency->total_assignments ?? $agency['total_assignments'] ?? '0' }}</td>
                <td>{{ $agency->completed_assignments ?? $agency['completed_assignments'] ?? '0' }}</td>
                <td>{{ $agency->in_progress_assignments ?? $agency['in_progress_assignments'] ?? '0' }}</td>
                <td>{{ $agency->overdue_assignments ?? $agency['overdue_assignments'] ?? '0' }}</td>
                <td>
                    @php
                        $total = $agency->total_assignments ?? $agency['total_assignments'] ?? 0;
                        $completed = $agency->completed_assignments ?? $agency['completed_assignments'] ?? 0;
                        $rate = $total > 0 ? round(($completed / $total) * 100, 1) : 0;
                    @endphp
                    {{ $rate }}%
                </td>
                <td>{{ $agency->avg_response_time ?? $agency['avg_response_time'] ?? 'N/A' }}</td>
                <td>
                    @php
                        $score = $agency->performance_score ?? $agency['performance_score'] ?? null;
                        if ($score === null) {
                            // Calculate a basic performance score based on completion rate and response time
                            $score = $rate; // Use completion rate as base score
                        }
                    @endphp
                    {{ is_numeric($score) ? round($score, 1) : 'N/A' }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@if(count($reportData) == 0)
<div class="no-data">
    <p>No agency performance data found for the selected criteria.</p>
</div>
@endif

@if(isset($summaryStats) && count($summaryStats) > 0)
<div class="section mt-4">
    <h3>Performance Summary</h3>
    <div class="summary-stats">
        @foreach($summaryStats as $stat)
        <div class="stat-card">
            <div class="stat-number">{{ $stat['value'] ?? 0 }}</div>
            <div class="stat-label">{{ $stat['label'] ?? 'Statistic' }}</div>
        </div>
        @endforeach
    </div>
</div>
@endif
