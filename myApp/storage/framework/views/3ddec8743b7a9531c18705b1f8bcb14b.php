<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<title>Agency Profile - AuthenticityHub</title>
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

		.profile-summary {
			display: flex;
			align-items: center;
			gap: 16px;
			padding: 18px 0 26px;
		}

		.profile-pic-container {
			width: 84px;
			height: 84px;
			border-radius: 50%;
			overflow: hidden;
			border: 3px solid #fff;
			background: #F9F9F9;
			box-shadow: 0 6px 16px rgba(0,0,0,.08);
		}

		.profile-pic-container img {
			width: 100%;
			height: 100%;
			object-fit: cover;
		}

		.profile-name {
			font-size: 1.5rem;
			font-weight: 700;
			color: #4a4237;
		}

		.profile-meta {
			color: #6b6860;
		}

		.grid {
			display: grid;
			grid-template-columns: repeat(2, minmax(0, 1fr));
			gap: 18px;
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

		.field input,
		.field textarea {
			width: 100%;
			padding: 0.9rem 1rem;
			border-radius: 12px;
			border: 1px solid #ddd;
			font: inherit;
			background: #fff;
			outline: none;
		}

		.field textarea {
			min-height: 120px;
			resize: vertical;
		}

		.field input:focus,
		.field textarea:focus {
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

			.grid {
				grid-template-columns: 1fr;
			}

			.content-container {
				padding: 18px;
			}

			.profile-summary {
				flex-direction: column;
				align-items: flex-start;
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
				<h1>Manage Agency Profile</h1>
				<p>Update the agency details shown across the system.</p>
			</div>

			<?php if(session('status')): ?>
				<div class="alert alert-success"><?php echo e(session('status')); ?></div>
			<?php endif; ?>

			<?php if($errors->any()): ?>
				<div class="alert alert-error">
					<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div><?php echo e($error); ?></div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			<?php endif; ?>

			<div class="profile-summary">
				<div class="profile-pic-container">
					<img src="<?php echo e($agency->profile_picture_url ?? asset('images/default-agency-avatar.png')); ?>" alt="Agency avatar">
				</div>
				<div>
					<div class="profile-name"><?php echo e($agency->AgencyName); ?></div>
					<div class="profile-meta"><?php echo e($agency->AgencyEmail); ?> · <?php echo e($agency->AgencyUserName); ?></div>
				</div>
			</div>

			<form method="POST" action="<?php echo e(route('agency.profile.update')); ?>" enctype="multipart/form-data">
				<?php echo csrf_field(); ?>
				<?php echo method_field('PUT'); ?>

				<div class="grid">
					<div class="field">
						<label for="AgencyName">Agency Name</label>
						<input id="AgencyName" type="text" name="AgencyName" value="<?php echo e(old('AgencyName', $agency->AgencyName)); ?>" required>
					</div>

					<div class="field">
						<label for="AgencyEmail">Agency Email</label>
						<input id="AgencyEmail" type="email" name="AgencyEmail" value="<?php echo e(old('AgencyEmail', $agency->AgencyEmail)); ?>" required>
					</div>

					<div class="field">
						<label for="AgencyPhoneNum">Agency Phone Number</label>
						<input id="AgencyPhoneNum" type="text" name="AgencyPhoneNum" value="<?php echo e(old('AgencyPhoneNum', $agency->AgencyPhoneNum)); ?>" placeholder="Optional">
					</div>

					<div class="field">
						<label for="AgencyProfilePicture">Profile Picture</label>
						<input id="AgencyProfilePicture" type="file" name="AgencyProfilePicture" accept="image/*">
					</div>
				</div>

				<div class="actions">
					<button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
					<a href="<?php echo e(route('agency.security')); ?>" class="btn btn-ghost"><i class="fa-solid fa-shield-halved"></i> Go to Security</a>
				</div>
			</form>
		</section>
	</main>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\SPM\MCMC_S02_Astrolabe\myApp\resources\views/Module3/Agency/manageProfilePage.blade.php ENDPATH**/ ?>