<?php
    $userName = 'Guest';
    $userInitials = 'GU';
    $userPic = null;
    $textColor = '#FFFFFF';
    $pillBg = 'rgba(255, 255, 255, 0.1)';
    $pillBgHover = 'rgba(255, 255, 255, 0.15)';
    
    $isAdminRoute = request()->is('admin*');
    $isAgencyRoute = request()->is('agency*');

    if ($isAdminRoute && session()->has('admin_id')) {
        $userName = session('admin_name', 'Administrator');
        $userPic = null; // Admin doesn't have a profile picture in the schema
        $pillBg = 'rgba(255, 255, 255, 0.15)';
        $pillBgHover = 'rgba(255, 255, 255, 0.25)';
    } elseif ($isAgencyRoute && session()->has('agency_id')) {
        $userName = $agency->AgencyName ?? session('agency_name', 'Agency');
        $userPic = isset($agency) && $agency->AgencyProfilePicture ? asset('storage/' . $agency->AgencyProfilePicture) : null;
        $pillBg = 'rgba(255, 255, 255, 0.1)';
        $pillBgHover = 'rgba(255, 255, 255, 0.15)';
    } elseif ((!$isAdminRoute && !$isAgencyRoute) && (session()->has('user_id') || Auth::check())) {
        $userName = Auth::user()->UserName ?? 'Public User';
        $userPic = Auth::user()->UserProfilePicture ? asset('storage/' . Auth::user()->UserProfilePicture) : null;
        $textColor = '#FFFFFF'; // White text for public user
        $pillBg = '#6a7fd0'; // Solid blue background to match public user page
        $pillBgHover = '#5a6fc0';
    }

    $words = explode(' ', $userName);
    if (count($words) >= 2) {
        $userInitials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
    } else {
        $userInitials = strtoupper(substr($userName, 0, 2));
    }
?>

<div class="user-area" style="display: flex; align-items: center; gap: 12px; color: <?php echo e($textColor); ?>; background: <?php echo e($pillBg); ?>; padding: 4px 16px; border-radius: 50px; backdrop-filter: blur(10px); transition: all 0.3s ease; margin-left: auto; height: 44px; box-sizing: border-box;">
    
    <?php echo $__env->make('partials.notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <div class="welcome" style="text-align: right; line-height: 1.2; font-size: 0.9rem; font-weight: 500;">
        <div style="font-weight: 600; font-size: 0.95rem;"><?php echo e($userName); ?></div>
        <div style="font-size: 0.7rem; opacity: 0.8;">Welcome Back</div>
    </div>
    
    <div class="profile-pic-container" style="width: 36px; height: 36px; border-radius: 50%; overflow: hidden; border: 2px solid rgba(255, 255, 255, 0.8); background: #F9F9F9; position: relative; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); display: flex; align-items: center; justify-content: center; font-weight: bold; color: #555; font-size: 1rem;">
        <?php if($userPic): ?>
            <img src="<?php echo e($userPic); ?>" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
        <?php else: ?>
            <span><?php echo e($userInitials); ?></span>
        <?php endif; ?>
    </div>
</div>

<style>
    .user-area:hover {
        background: <?php echo e($pillBgHover); ?> !important;
        transform: translateY(-1px);
    }
    .profile-pic-container:hover {
        border-color: rgba(255, 255, 255, 1) !important;
        transform: scale(1.05) !important;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3) !important;
    }
</style>
<?php /**PATH C:\xampp\htdocs\SPM\MCMC_S02_Astrolabe\myApp\resources\views/partials/user_area.blade.php ENDPATH**/ ?>