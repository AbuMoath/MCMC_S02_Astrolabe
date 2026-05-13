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
        <?php $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($user->UserID ?? $user['UserID'] ?? 'N/A'); ?></td>
                <td><?php echo e(($user->UserFirstName ?? $user['UserFirstName'] ?? '') . ' ' . ($user->UserLastName ?? $user['UserLastName'] ?? '')); ?></td>
                <td><?php echo e($user->UserEmail ?? $user['UserEmail'] ?? 'N/A'); ?></td>
                <td><?php echo e($user->UserPhoneNum ?? $user['UserPhoneNum'] ?? 'N/A'); ?></td>
                <td><?php echo e(isset($user->created_at) ? date('M j, Y', strtotime($user->created_at)) : (isset($user['created_at']) ? date('M j, Y', strtotime($user['created_at'])) : 'N/A')); ?></td>
                <td><?php echo e($user->UserStatus ?? $user['UserStatus'] ?? 'Active'); ?></td>
                <td><?php echo e(isset($user->last_login) ? date('M j, Y g:i A', strtotime($user->last_login)) : (isset($user['last_login']) ? date('M j, Y g:i A', strtotime($user['last_login'])) : 'N/A')); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<?php if(count($reportData) == 0): ?>
<div class="no-data">
    <p>No users found for the selected criteria.</p>
</div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\mcmc\myApp\resources\views/admin/reports/partials/users-data.blade.php ENDPATH**/ ?>