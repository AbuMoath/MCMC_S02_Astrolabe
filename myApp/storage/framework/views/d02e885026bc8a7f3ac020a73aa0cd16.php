<?php
	$currentRoute = Route::currentRouteName();
	$homeActive = $currentRoute === 'agency.home';
	$profileActive = $currentRoute === 'agency.profile';
	$securityActive = $currentRoute === 'agency.security';
	$displayActive = $currentRoute === 'agency.view.display.inquiry' || str_starts_with((string) $currentRoute, 'agency.inquiry.');
?>

<aside class="sidebar">
	<nav class="sidebar-nav">
		<a href="<?php echo e(route('agency.home')); ?>" class="sidebar-link <?php echo e($homeActive ? 'active' : ''); ?>"><i class="fa-solid fa-house"></i> Home</a>
		<a href="<?php echo e(route('agency.profile')); ?>" class="sidebar-link <?php echo e($profileActive ? 'active' : ''); ?>"><i class="fa-solid fa-user"></i> Profile</a>
		<a href="<?php echo e(route('agency.security')); ?>" class="sidebar-link <?php echo e($securityActive ? 'active' : ''); ?>"><i class="fa-solid fa-shield-halved"></i> Security</a>
		<a href="<?php echo e(route('agency.view.display.inquiry')); ?>" class="sidebar-link <?php echo e($displayActive ? 'active' : ''); ?>"><i class="fa-regular fa-clipboard"></i> Display and Approve</a>
		<a href="<?php echo e(route('login')); ?>" class="sidebar-link logout-link"><i class="fa-solid fa-right-from-bracket"></i> Back to login</a>
	</nav>
</aside><?php /**PATH C:\xampp\htdocs\SPM\MCMC_S02_Astrolabe\myApp\resources\views/Module3/Agency/partials/sidebar.blade.php ENDPATH**/ ?>