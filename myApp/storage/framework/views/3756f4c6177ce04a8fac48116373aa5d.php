<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<title>Agency Security - AuthenticityHub</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<style>
		body {
			font-family: 'Poppins', sans-serif;
			background: linear-gradient(135deg, #f5f1e8 0%, #ede7d9 50%, #f0ebe1 100%);
			background-attachment: fixed;
			margin: 0;
			padding: 0;
		}

		.top-bar {
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			height: 64px;
			background: linear-gradient(135deg, #4a4237 0%, #6b6860 50%, #5d5449 100%);
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 0 2rem;
			z-index: 100;
			box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
			backdrop-filter: blur(10px);
		}

		.top-bar .logo {
			font-weight: 800;
			font-size: 1.4rem;
			color: #ffffff;
			letter-spacing: 0.5px;
			text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
			background: linear-gradient(135deg, #ffffff, #f0f0f0);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			background-clip: text;
		}

		.user-area {
			display: flex;
			align-items: center;
			gap: 16px;
			color: #FFFFFF;
			background: rgba(255, 255, 255, 0.1);
			padding: 8px 16px;
			border-radius: 50px;
			backdrop-filter: blur(10px);
			transition: all 0.3s ease;
		}

		.user-area:hover {
			background: rgba(255, 255, 255, 0.15);
			transform: translateY(-1px);
		}

		.sidebar {
			position: fixed;
			top: 64px;
			left: 0;
			width: 16rem;
			height: calc(100vh - 64px);
			background: linear-gradient(180deg, #ffffff 0%, #f8f7f4 100%);
			border-top-right-radius: 24px;
			border-bottom-right-radius: 24px;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1), inset -1px 0 0 rgba(255, 255, 255, 0.5);
			display: flex;
			flex-direction: column;
			padding: 2rem 0;
			z-index: 99;
			backdrop-filter: blur(10px);
		}

		.sidebar-nav {
			display: flex;
			flex-direction: column;
			gap: 8px;
			padding: 0 1.5rem;
			flex: 1;
		}

		.sidebar-link {
			display: flex;
			align-items: center;
			gap: 12px;
			padding: 12px 16px;
			color: #4a4237;
			text-decoration: none;
			font-weight: 500;
			font-size: 0.95rem;
			border-radius: 12px;
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			position: relative;
			overflow: hidden;
		}

		.sidebar-link::before {
			content: '';
			position: absolute;
			top: 0;
			left: -100%;
			width: 100%;
			height: 100%;
			background: linear-gradient(90deg, transparent, rgba(255, 89, 90, 0.1), transparent);
			transition: left 0.5s ease;
		}

		.sidebar-link:hover {
			color: #FF595A;
			background: rgba(255, 89, 90, 0.08);
			transform: translateX(8px);
			box-shadow: 0 4px 12px rgba(255, 89, 90, 0.2);
		}

		.sidebar-link:hover::before {
			left: 100%;
		}

		.sidebar-link.active {
			color: #FF595A;
			background: rgba(255, 89, 90, 0.12);
			font-weight: 600;
			box-shadow: 0 4px 16px rgba(255, 89, 90, 0.25);
		}

		.sidebar-link i {
			width: 20px;
			text-align: center;
			font-size: 1.1rem;
		}

		.logout-link {
			margin-top: auto;
			margin-bottom: 1rem;
			color: #e74c3c !important;
			background: rgba(231, 76, 60, 0.08) !important;
			border: 1px solid rgba(231, 76, 60, 0.2);
		}

		.logout-link:hover {
			color: #c0392b !important;
			background: rgba(231, 76, 60, 0.15) !important;
			border-color: rgba(231, 76, 60, 0.3);
			box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
		}

		.content-area {
			margin-left: 16rem;
			margin-top: 64px;
			padding: 30px;
			background: transparent;
			min-height: calc(100vh - 64px);
		}

		.content-container {
			background: #FFFFFF;
			border-radius: 16px;
			box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
			padding: 30px;
			width: 100%;
			max-width: none;
		}

		.page-header {
			background: linear-gradient(135deg, #4a4237 0%, #6b6860 50%, #5d5449 100%);
			color: #fff;
			border-radius: 16px;
			padding: 28px 30px;
			margin-bottom: 24px;
		}

		.page-header h1 {
			margin: 0 0 8px;
			font-size: 2rem;
		}

		.page-header p {
			margin: 0;
			color: rgba(255,255,255,.82);
		}

		.field {
			display: flex;
			flex-direction: column;
			gap: 8px;
			margin-bottom: 18px;
		}

		.field label {
			font-weight: 600;
			color: #4a4237;
		}

		.field input {
			width: 100%;
			padding: 0.9rem 1rem;
			border-radius: 12px;
			border: 1px solid #ddd;
			font: inherit;
			background: #fff;
			outline: none;
		}

		.field input:focus {
			border-color: #FF595A;
			box-shadow: 0 0 0 3px rgba(255, 89, 90, 0.12);
		}

		.actions {
			display: flex;
			gap: 12px;
			flex-wrap: wrap;
			margin-top: 10px;
		}

		.btn {
			border: none;
			border-radius: 10px;
			padding: 0.95rem 1.2rem;
			font-weight: 600;
			cursor: pointer;
			text-decoration: none;
			display: inline-flex;
			align-items: center;
			gap: 0.5rem;
		}

		.btn-primary {
			background: #FF595A;
			color: #fff;
		}

		.btn-ghost {
			background: #EFEFEF;
			color: #4a4237;
		}

		.btn-success {
			background: #4a4237;
			color: #fff;
		}

		.alert {
			padding: 12px 14px;
			border-radius: 10px;
			margin-bottom: 16px;
		}

		.alert-success {
			background: #e8f5e9;
			color: #1b5e20;
		}

		.alert-error {
			background: #ffebee;
			color: #b71c1c;
		}

		.meta {
			color: #6b6860;
			margin-bottom: 16px;
		}

		@media (max-width: 900px) {
			.sidebar {
				position: relative;
				width: auto;
				height: auto;
				margin: 0 12px;
				top: 12px;
			}

			.content-area {
				margin-left: 0;
				padding: 18px;
			}

			.content-container {
				padding: 18px;
			}
		}
	</style>
</head>
<body>
	<header class="top-bar">
		<div class="logo">AuthenticityHub</div>
		<?php echo $__env->make('partials.user_area', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </header>

	<?php echo $__env->make('Module3.Agency.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

	<main class="content-area">
		<section class="content-container">
			<div class="page-header">
				<h1>Change Password</h1>
				<p>Verify the current password before setting a new one.</p>
			</div>

			<?php if(session('status')): ?>
				<div class="alert alert-success"><?php echo e(session('status')); ?></div>
			<?php endif; ?>

			<?php if(session('error')): ?>
				<div class="alert alert-error"><?php echo e(session('error')); ?></div>
			<?php endif; ?>

			<?php if($errors->any()): ?>
				<div class="alert alert-error">
					<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div><?php echo e($error); ?></div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			<?php endif; ?>

			<div class="meta">
				Logged in as <strong><?php echo e($agency->AgencyName); ?></strong> (<?php echo e($agency->AgencyEmail); ?>)
			</div>

			<?php if(!session('agency_password_verified')): ?>
				<form method="POST" action="<?php echo e(route('agency.password.verify')); ?>">
					<?php echo csrf_field(); ?>
					<div class="field">
						<label for="current_password">Current Password</label>
						<input id="current_password" type="password" name="current_password" required placeholder="Enter current password">
					</div>
					<div class="actions">
						<button type="submit" class="btn btn-primary"><i class="fa-solid fa-lock"></i> Verify Password</button>
						<a href="<?php echo e(route('agency.profile')); ?>" class="btn btn-ghost"><i class="fa-solid fa-user"></i> Back to Profile</a>
					</div>
				</form>
			<?php else: ?>
				<form method="POST" action="<?php echo e(route('agency.password.update')); ?>">
					<?php echo csrf_field(); ?>
					<?php echo method_field('PUT'); ?>
					<div class="field">
						<label for="new_password">New Password</label>
						<input id="new_password" type="password" name="new_password" required minlength="8" placeholder="Enter new password">
					</div>
					<div class="field">
						<label for="new_password_confirmation">Confirm New Password</label>
						<input id="new_password_confirmation" type="password" name="new_password_confirmation" required minlength="8" placeholder="Re-enter new password">
					</div>
					<div class="actions">
						<button type="submit" class="btn btn-success"><i class="fa-solid fa-key"></i> Update Password</button>
						<a href="<?php echo e(route('agency.password.edit.reset')); ?>" class="btn btn-ghost"><i class="fa-solid fa-rotate-left"></i> Reset Verification</a>
					</div>
				</form>
			<?php endif; ?>
		</section>
	</main>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\SPM\MCMC_S02_Astrolabe\myApp\resources\views/Module3/Agency/editPasswordPage.blade.php ENDPATH**/ ?>