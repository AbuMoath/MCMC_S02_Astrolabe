<!-- Users Report Data -->
<table class="data-table">
    <thead>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Registration Date</th>
            <th>Status</th>
            <th>Last Login</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reportData as $user)
            <tr>
                <td>{{ $user->UserID ?? $user['UserID'] ?? 'N/A' }}</td>
                <td>{{ ($user->UserFirstName ?? $user['UserFirstName'] ?? '') . ' ' . ($user->UserLastName ?? $user['UserLastName'] ?? '') }}</td>
                <td>{{ $user->UserEmail ?? $user['UserEmail'] ?? 'N/A' }}</td>
                <td>{{ $user->UserPhoneNum ?? $user['UserPhoneNum'] ?? 'N/A' }}</td>
                <td>{{ isset($user->created_at) ? date('M j, Y', strtotime($user->created_at)) : (isset($user['created_at']) ? date('M j, Y', strtotime($user['created_at'])) : 'N/A') }}</td>
                <td>{{ $user->UserStatus ?? $user['UserStatus'] ?? 'Active' }}</td>
                <td>{{ isset($user->last_login) ? date('M j, Y g:i A', strtotime($user->last_login)) : (isset($user['last_login']) ? date('M j, Y g:i A', strtotime($user['last_login'])) : 'N/A') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@if(count($reportData) == 0)
<div class="no-data">
    <p>No users found for the selected criteria.</p>
</div>
@endif
