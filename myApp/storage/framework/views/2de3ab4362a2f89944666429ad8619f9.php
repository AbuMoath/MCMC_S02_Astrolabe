<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — AuthenticityHub | MCMC</title>
    <meta name="description" content="Securely sign in to your AuthenticityHub account to track your inquiries or access the MCMC government portal.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --navy: #0b1f3a;
            --navy-mid: #112d52;
            --blue: #1d5fdb;
            --blue-light: #3b82f6;
            --cyan: #06b6d4;
            --gold: #f59e0b;
            --danger: #ef4444;
            --success: #10b981;
            --text-primary: #e2e8f0;
            --text-secondary: #94a3b8;
            --glass-bg: rgba(255,255,255,0.06);
            --glass-border: rgba(255,255,255,0.12);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--navy);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* BACKGROUND */
        .bg-mesh {
            position: fixed; inset: 0; z-index: 0;
            background:
                radial-gradient(ellipse 70% 60% at 10% 10%, rgba(29,95,219,0.22) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 90% 80%, rgba(6,182,212,0.12) 0%, transparent 55%),
                linear-gradient(160deg, #0b1f3a 0%, #07152a 60%, #050f1e 100%);
        }
        .bg-grid {
            position: fixed; inset: 0; z-index: 0;
            background-image:
                linear-gradient(rgba(29,95,219,0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(29,95,219,0.05) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* NAVBAR */
        .navbar {
            position: relative; z-index: 100;
            padding: 0 2rem; height: 70px;
            display: flex; align-items: center; justify-content: space-between;
            background: rgba(11,31,58,0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
        }

        .nav-brand {
            display: flex; align-items: center; gap: 0.75rem;
            text-decoration: none;
        }
        .nav-logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--blue), var(--cyan));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(29,95,219,0.4);
        }
        .nav-logo-icon i { color:#fff; font-size:0.95rem; }
        .nav-brand-name {
            font-weight: 800; font-size: 1rem; color: #fff; letter-spacing: -0.01em;
        }
        .nav-brand-sub {
            display:block; font-size: 0.58rem; font-weight:500; color:var(--cyan);
            letter-spacing:0.05em; text-transform:uppercase;
        }

        .nav-link {
            font-size: 0.88rem; font-weight: 500;
            color: var(--text-secondary); text-decoration: none;
            transition: color 0.2s ease;
        }
        .nav-link:hover { color: #fff; }

        /* MAIN LAYOUT */
        .page-wrapper {
            position: relative; z-index: 1;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
        }

        /* CARD */
        .auth-card {
            width: 100%; max-width: 460px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 2.75rem 2.5rem;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 30px 80px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.08);
            animation: cardIn 0.6s ease both;
        }

        @keyframes cardIn {
            from { opacity:0; transform:translateY(28px) scale(0.97); }
            to   { opacity:1; transform:translateY(0) scale(1); }
        }

        /* Card Header */
        .card-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .card-icon {
            width: 60px; height: 60px;
            border-radius: 18px;
            background: linear-gradient(135deg, rgba(29,95,219,0.2), rgba(6,182,212,0.15));
            border: 1px solid rgba(29,95,219,0.3);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem;
            font-size: 1.5rem;
            color: var(--blue-light);
        }

        .card-title {
            font-size: 1.7rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #fff;
            margin-bottom: 0.4rem;
        }

        .card-subtitle {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* Alerts */
        .alert {
            display: flex; align-items: flex-start; gap: 0.75rem;
            padding: 0.9rem 1.1rem;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }
        .alert i { margin-top: 0.05rem; flex-shrink:0; }
        .alert-success {
            background: rgba(16,185,129,0.12);
            border: 1px solid rgba(16,185,129,0.3);
            color: #6ee7b7;
        }
        .alert-error {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            color: #fca5a5;
        }

        /* Form */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon-left {
            position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 0.9rem;
            pointer-events: none;
            z-index: 1;
            transition: color 0.2s ease;
        }

        .form-input {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.75rem;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            color: #fff;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            outline: none;
            transition: all 0.25s ease;
            -webkit-appearance: none;
        }

        .form-input::placeholder { color: rgba(148,163,184,0.5); }

        .form-input:hover {
            border-color: rgba(29,95,219,0.4);
            background: rgba(255,255,255,0.08);
        }

        .form-input:focus {
            border-color: var(--blue-light);
            background: rgba(29,95,219,0.08);
            box-shadow: 0 0 0 3px rgba(29,95,219,0.15);
        }

        .form-input:focus ~ .input-icon-left,
        .input-wrap:focus-within .input-icon-left {
            color: var(--blue-light);
        }

        .form-input.is-invalid {
            border-color: var(--danger) !important;
            background: rgba(239,68,68,0.06) !important;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.12) !important;
        }

        .input-btn-right {
            position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: var(--text-secondary); font-size: 0.9rem;
            padding: 0.25rem; border-radius: 4px;
            transition: color 0.2s ease;
        }
        .input-btn-right:hover { color: #fff; }

        .field-error {
            display: flex; align-items: center; gap: 0.4rem;
            margin-top: 0.45rem;
            font-size: 0.8rem;
            color: #fca5a5;
            font-weight: 500;
        }
        .field-error i { font-size: 0.75rem; }

        /* Options row */
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
            margin-top: 0.25rem;
        }

        .remember-label {
            display: flex; align-items: center; gap: 0.5rem;
            font-size: 0.85rem; color: var(--text-secondary);
            cursor: pointer;
            user-select: none;
        }
        .remember-label input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: var(--blue-light);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 0.85rem;
            color: var(--blue-light);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        .forgot-link:hover { color: var(--cyan); text-decoration: underline; }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 0.9rem;
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--blue), #1a4fc4);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 24px rgba(29,95,219,0.35);
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            font-family: 'Inter', sans-serif;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #2670f5, var(--blue));
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(29,95,219,0.5);
        }

        .btn-submit:active { transform: translateY(0); }

        .btn-submit:disabled {
            opacity: 0.7; cursor: not-allowed; transform: none;
        }

        /* Divider */
        .card-divider {
            display: flex; align-items: center; gap: 1rem;
            margin: 1.5rem 0;
        }
        .card-divider::before, .card-divider::after {
            content:''; flex:1; height:1px; background:var(--glass-border);
        }
        .card-divider span {
            font-size: 0.78rem; color: var(--text-secondary); font-weight: 500;
        }

        /* Register link */
        .register-prompt {
            text-align: center;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }
        .register-prompt a {
            color: var(--blue-light);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .register-prompt a:hover { color: var(--cyan); }

        /* Security note */
        .security-note {
            display: flex; align-items: center; justify-content: center;
            gap: 0.5rem; margin-top: 1.5rem;
            font-size: 0.75rem; color: rgba(148,163,184,0.6);
        }
        .security-note i { color: var(--success); font-size: 0.8rem; }

        /* OTP STATE PANEL (hidden by default, shown after password via JS/backend) */
        #otp-state {
            display: none; /* Laravel backend controls this flow via redirect */
        }

        .otp-preview-label {
            font-size: 0.82rem;
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        .otp-preview-label strong { color: var(--cyan); }

        .otp-boxes {
            display: flex; gap: 0.6rem; justify-content: center;
            margin-bottom: 1.5rem;
        }
        .otp-box {
            width: 52px; height: 58px;
            text-align: center; font-size: 1.4rem; font-weight: 700;
            color: #fff;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 12px;
            outline: none;
            transition: all 0.2s ease;
            -webkit-appearance: none;
        }
        .otp-box:focus {
            border-color: var(--blue-light);
            background: rgba(29,95,219,0.1);
            box-shadow: 0 0 0 3px rgba(29,95,219,0.2);
        }

        /* FOOTER */
        footer {
            position: relative; z-index: 1;
            padding: 1.5rem 2rem;
            background: rgba(5,15,30,0.8);
            border-top: 1px solid var(--glass-border);
        }
        .footer-inner {
            max-width: 900px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 0.75rem;
        }
        .footer-inner p {
            font-size: 0.78rem; color: rgba(148,163,184,0.55);
        }
        .footer-inner p a { color: var(--blue-light); text-decoration:none; }
        .footer-inner p a:hover { text-decoration:underline; }
        .footer-links { display:flex; gap:1.25rem; }
        .footer-links a {
            font-size:0.78rem; color:rgba(148,163,184,0.55);
            text-decoration:none; transition:color 0.2s ease;
        }
        .footer-links a:hover { color:var(--text-secondary); }
    </style>
</head>

<body>
    <div class="bg-mesh"></div>
    <div class="bg-grid"></div>

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="<?php echo e(route('home')); ?>" class="nav-brand">
            <div class="nav-logo-icon">
                <i class="fas fa-shield-halved"></i>
            </div>
            <div>
                <span class="nav-brand-name">AuthenticityHub</span>
                <span class="nav-brand-sub">MCMC Official Platform</span>
            </div>
        </a>
        <a href="<?php echo e(route('home')); ?>" class="nav-link">
            <i class="fas fa-arrow-left" style="margin-right:0.35rem;font-size:0.8rem;"></i> Back to Home
        </a>
    </nav>

    <!-- MAIN -->
    <div class="page-wrapper">
        <div class="auth-card">

            <!-- Card Header -->
            <div class="card-header">
                <div class="card-icon">
                    <i class="fas fa-shield-halved"></i>
                </div>
                <h1 class="card-title">Welcome Back</h1>
                <p class="card-subtitle">Sign in to your AuthenticityHub account to continue</p>
            </div>

            
            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-circle-check"></i>
                    <span><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>

            
            <form method="POST" action="<?php echo e(route('login')); ?>" novalidate id="loginForm">
                <?php echo csrf_field(); ?>

                <!-- Email / Username -->
                <div class="form-group">
                    <label class="form-label" for="login">Email or Username</label>
                    <div class="input-wrap">
                        <i class="fas fa-user input-icon-left"></i>
                        <input
                            type="text"
                            id="login"
                            name="login"
                            value="<?php echo e(old('login')); ?>"
                            placeholder="Enter your email or username"
                            autocomplete="username"
                            class="form-input <?php $__errorArgs = ['login'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            required
                        />
                    </div>
                    <?php $__errorArgs = ['login'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="field-error">
                            <i class="fas fa-triangle-exclamation"></i>
                            <span><?php echo e($message); ?></span>
                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon-left"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            class="form-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            required
                        />
                        <button type="button" class="input-btn-right" id="togglePassword" aria-label="Toggle password visibility">
                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="field-error">
                            <i class="fas fa-triangle-exclamation"></i>
                            <span><?php echo e($message); ?></span>
                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Options row -->
                <div class="form-options">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" id="remember" value="1">
                        Remember me
                    </label>
                    
                    <a href="<?php echo e(route('password.recovery')); ?>" class="forgot-link">Forgot password?</a>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit" id="loginSubmitBtn">
                    <i class="fas fa-arrow-right-to-bracket"></i>
                    Sign In
                </button>
            </form>

            
            <div style="
                margin-top:1.25rem;
                padding:0.85rem 1rem;
                background:rgba(6,182,212,0.08);
                border:1px solid rgba(6,182,212,0.2);
                border-radius:10px;
                display:flex; align-items:flex-start; gap:0.7rem;
            ">
                <i class="fas fa-shield-halved" style="color:var(--cyan);margin-top:0.1rem;flex-shrink:0;"></i>
                <p style="font-size:0.8rem;color:rgba(148,163,184,0.85);line-height:1.55;">
                    <strong style="color:var(--cyan);">Administrator accounts</strong> are protected with Two-Factor Authentication. You will be prompted for a One-Time Password after sign-in.
                </p>
            </div>

            <div class="card-divider"><span>New to AuthenticityHub?</span></div>

            <div class="register-prompt">
                Don't have an account?
                <a href="<?php echo e(route('register')); ?>" id="goRegisterLink">Create one for free &rarr;</a>
            </div>

            <div class="security-note">
                <i class="fas fa-lock"></i>
                Secured with 256-bit TLS encryption &amp; PDPA compliant
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="footer-inner">
            <p>&copy; <?php echo e(date('Y')); ?> AuthenticityHub — <a href="https://www.mcmc.gov.my" target="_blank">MCMC Malaysia</a>. All rights reserved.</p>
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Use</a>
                <a href="<?php echo e(route('home')); ?>">Home</a>
            </div>
        </div>
    </footer>

    <script>
        // Password visibility toggle
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                toggleIcon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
            });
        }

        // Login form submission — loading state
        const loginForm = document.getElementById('loginForm');
        const loginSubmitBtn = document.getElementById('loginSubmitBtn');

        if (loginForm) {
            // Restore form state on page show (back button)
            window.addEventListener('pageshow', function(e) {
                if (e.persisted) {
                    loginSubmitBtn.disabled = false;
                    loginSubmitBtn.innerHTML = '<i class="fas fa-arrow-right-to-bracket"></i> Sign In';
                }
            });

            loginForm.addEventListener('submit', function() {
                loginSubmitBtn.disabled = true;
                loginSubmitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing In…';
            });
        }
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\MCMC_S02_Astrolabe\myApp\resources\views/home/loginPage.blade.php ENDPATH**/ ?>