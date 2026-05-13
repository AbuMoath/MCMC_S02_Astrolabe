<!-- Inquiries Report Data -->
<table class="data-table">
    <thead>
        <tr>
            <th>Inquiry ID</th>
            <th>User</th>
            <th>Type</th>
            <th>Subject</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Created Date</th>
            <th>Last Updated</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($inquiry->InquiryID ?? $inquiry['InquiryID'] ?? 'N/A'); ?></td>
                <td><?php echo e($inquiry->user_name ?? $inquiry['user_name'] ?? ($inquiry->UserEmail ?? $inquiry['UserEmail'] ?? 'N/A')); ?></td>
                <td><?php echo e($inquiry->InquiryType ?? $inquiry['InquiryType'] ?? 'N/A'); ?></td>
                <td><?php echo e(Str::limit($inquiry->InquirySubject ?? $inquiry['InquirySubject'] ?? 'N/A', 50)); ?></td>
                <td><?php echo e($inquiry->InquiryStatus ?? $inquiry['InquiryStatus'] ?? 'N/A'); ?></td>
                <td><?php echo e($inquiry->Priority ?? $inquiry['Priority'] ?? 'Normal'); ?></td>
                <td><?php echo e(isset($inquiry->created_at) ? date('M j, Y', strtotime($inquiry->created_at)) : (isset($inquiry['created_at']) ? date('M j, Y', strtotime($inquiry['created_at'])) : 'N/A')); ?></td>
                <td><?php echo e(isset($inquiry->updated_at) ? date('M j, Y g:i A', strtotime($inquiry->updated_at)) : (isset($inquiry['updated_at']) ? date('M j, Y g:i A', strtotime($inquiry['updated_at'])) : 'N/A')); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<?php if(count($reportData) == 0): ?>
<div class="no-data">
    <p>No inquiries found for the selected criteria.</p>
</div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\mcmc\myApp\resources\views/admin/reports/partials/inquiries-data.blade.php ENDPATH**/ ?>