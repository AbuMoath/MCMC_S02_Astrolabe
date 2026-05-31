<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — AuthenticityHub | MCMC</title>
    <meta name="description" content="Register for a free AuthenticityHub account to submit inquiries to the Malaysian Communications and Multimedia Commission.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --navy: #0b1f3a;
            --blue: #1d5fdb;
            --blue-light: #3b82f6;
            --cyan: #06b6d4;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
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
            display: flex; flex-direction: column;
            overflow-x: hidden;
        }

        .bg-mesh {
            position: fixed; inset: 0; z-index: 0;
            background:
                radial-gradient(ellipse 70% 60% at 90% 10%, rgba(6,182,212,0.18) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 10% 80%, rgba(29,95,219,0.2) 0%, transparent 55%),
                linear-gradient(160deg, #0b1f3a 0%, #071529 60%, #050f1e 100%);
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
            display: flex; align-items: center; gap: 0.75rem; text-decoration: none;
        }
        .nav-logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--blue), var(--cyan));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(29,95,219,0.4);
        }
        .nav-logo-icon i { color:#fff; font-size:0.95rem; }
        .nav-brand-name { font-weight:800; font-size:1rem; color:#fff; }
        .nav-brand-sub {
            display:block; font-size:0.58rem; font-weight:500;
            color:var(--cyan); letter-spacing:0.05em; text-transform:uppercase;
        }
        .nav-link {
            font-size:0.88rem; font-weight:500;
            color:var(--text-secondary); text-decoration:none; transition:color 0.2s ease;
        }
        .nav-link:hover { color:#fff; }

        /* MAIN */
        .page-wrapper {
            position: relative; z-index: 1;
            flex: 1;
            display: flex; align-items: center; justify-content: center;
            padding: 3rem 1.5rem;
        }

        .auth-card {
            width: 100%; max-width: 520px;
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

        .card-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .card-icon {
            width: 60px; height: 60px;
            border-radius: 18px;
            background: linear-gradient(135deg, rgba(6,182,212,0.18), rgba(29,95,219,0.15));
            border: 1px solid rgba(6,182,212,0.25);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem;
            font-size: 1.5rem; color: var(--cyan);
        }
        .card-title {
            font-size: 1.7rem; font-weight: 800;
            letter-spacing: -0.02em; color: #fff; margin-bottom: 0.4rem;
        }
        .card-subtitle {
            font-size: 0.88rem; color: var(--text-secondary); line-height: 1.5;
        }

        /* FORM */
        .form-row {
            display: grid; gap: 1rem;
            margin-bottom: 1rem;
        }
        .form-row.two-col { grid-template-columns: 1fr 1fr; }

        .form-group { margin-bottom: 0; }

        .form-label {
            display: block;
            font-size: 0.8rem; font-weight: 600;
            color: var(--text-secondary); margin-bottom: 0.45rem;
            letter-spacing: 0.03em; text-transform: uppercase;
        }

        .input-wrap { position: relative; }

        .input-icon-left {
            position: absolute; left: 0.9rem; top: 50%; transform: translateY(-50%);
            color: var(--text-secondary); font-size: 0.88rem;
            pointer-events: none; z-index: 1; transition: color 0.2s ease;
        }

        .form-input {
            width: 100%;
            padding: 0.8rem 0.9rem 0.8rem 2.6rem;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 11px;
            color: #fff; font-size: 0.92rem;
            font-family: 'Inter', sans-serif; font-weight: 500;
            outline: none; transition: all 0.25s ease;
        }
        .form-input::placeholder { color: rgba(148,163,184,0.45); }
        .form-input:hover {
            border-color: rgba(29,95,219,0.35);
            background: rgba(255,255,255,0.08);
        }
        .form-input:focus {
            border-color: var(--blue-light);
            background: rgba(29,95,219,0.08);
            box-shadow: 0 0 0 3px rgba(29,95,219,0.15);
        }
        .input-wrap:focus-within .input-icon-left { color: var(--blue-light); }

        /* Validation states */
        .form-input.is-invalid {
            border-color: var(--danger) !important;
            background: rgba(239,68,68,0.06) !important;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.12) !important;
        }
        .form-input.is-valid {
            border-color: var(--success) !important;
            background: rgba(16,185,129,0.05) !important;
        }
        .input-wrap:focus-within .form-input.is-invalid { box-shadow: 0 0 0 3px rgba(239,68,68,0.2) !important; }

        .input-status-icon {
            position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%);
            font-size: 0.85rem; pointer-events: none;
        }
        .input-status-icon.valid { color: var(--success); }
        .input-status-icon.invalid { color: var(--danger); }

        .input-btn-right {
            position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: var(--text-secondary); font-size: 0.88rem;
            padding: 0.2rem; border-radius: 4px; transition: color 0.2s ease;
        }
        .input-btn-right:hover { color: #fff; }

        .field-error {
            display: flex; align-items: center; gap: 0.35rem;
            margin-top: 0.4rem; font-size: 0.78rem;
            color: #fca5a5; font-weight: 500;
        }
        .field-error i { font-size: 0.72rem; }

        .field-hint {
            margin-top: 0.4rem; font-size: 0.75rem;
            color: rgba(148,163,184,0.6); line-height: 1.5;
        }

        /* Password strength */
        .strength-bar {
            margin-top: 0.6rem;
            display: flex; gap: 4px;
        }
        .strength-segment {
            flex: 1; height: 3px; border-radius: 2px;
            background: rgba(255,255,255,0.1);
            transition: background 0.3s ease;
        }
        .strength-label {
            font-size: 0.73rem; margin-top: 0.3rem;
            font-weight: 600; transition: color 0.3s ease;
            color: var(--text-secondary);
        }

        /* Password rules */
        .pw-rules {
            margin-top: 0.6rem;
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 0.35rem;
        }
        .pw-rule {
            display: flex; align-items: center; gap: 0.35rem;
            font-size: 0.73rem; color: var(--text-secondary);
            transition: color 0.2s ease;
        }
        .pw-rule i { font-size: 0.65rem; color: rgba(148,163,184,0.4); transition: color 0.2s ease; }
        .pw-rule.passed { color: var(--success); }
        .pw-rule.passed i { color: var(--success); }

        /* Submit button */
        .btn-submit {
            width: 100%; padding: 0.9rem;
            font-size: 1rem; font-weight: 700; color: #fff;
            background: linear-gradient(135deg, var(--blue), #1a4fc4);
            border: none; border-radius: 12px; cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 24px rgba(29,95,219,0.35);
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            font-family: 'Inter', sans-serif;
            margin-top: 1.5rem;
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, #2670f5, var(--blue));
            transform: translateY(-2px); box-shadow: 0 10px 30px rgba(29,95,219,0.5);
        }
        .btn-submit:active { transform:translateY(0); }
        .btn-submit:disabled { opacity:0.65; cursor:not-allowed; transform:none; }

        .card-divider {
            display: flex; align-items: center; gap: 1rem; margin: 1.5rem 0;
        }
        .card-divider::before, .card-divider::after {
            content:''; flex:1; height:1px; background:var(--glass-border);
        }
        .card-divider span { font-size:0.78rem; color:var(--text-secondary); font-weight:500; }

        .login-prompt {
            text-align: center; font-size: 0.9rem; color: var(--text-secondary);
        }
        .login-prompt a {
            color: var(--blue-light); font-weight: 600;
            text-decoration: none; transition: color 0.2s ease;
        }
        .login-prompt a:hover { color: var(--cyan); }

        .security-note {
            display: flex; align-items: center; justify-content: center;
            gap: 0.5rem; margin-top: 1.5rem;
            font-size: 0.75rem; color: rgba(148,163,184,0.55);
        }
        .security-note i { color: var(--success); font-size: 0.8rem; }

        /* GDPR/terms */
        .terms-note {
            font-size: 0.78rem; color: var(--text-secondary);
            text-align: center; margin-top: 1rem; line-height: 1.55;
        }
        .terms-note a { color:var(--blue-light); text-decoration:none; }
        .terms-note a:hover { text-decoration:underline; }

        /* Alerts */
        .alert {
            display: flex; align-items: flex-start; gap: 0.75rem;
            padding: 0.9rem 1.1rem; border-radius: 12px;
            font-size: 0.875rem; font-weight: 500;
            margin-bottom: 1.5rem; line-height: 1.5;
        }
        .alert-success {
            background: rgba(16,185,129,0.12);
            border: 1px solid rgba(16,185,129,0.3); color: #6ee7b7;
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
        .footer-inner p { font-size:0.78rem; color:rgba(148,163,184,0.55); }
        .footer-inner p a { color:var(--blue-light); text-decoration:none; }
        .footer-inner p a:hover { text-decoration:underline; }
        .footer-links { display:flex; gap:1.25rem; }
        .footer-links a {
            font-size:0.78rem; color:rgba(148,163,184,0.55);
            text-decoration:none; transition:color 0.2s ease;
        }
        .footer-links a:hover { color:var(--text-secondary); }

        @media (max-width: 540px) {
            .auth-card { padding: 2rem 1.5rem; }
            .form-row.two-col { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
    <div class="bg-mesh"></div>
    <div class="bg-grid"></div>

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="<?php echo e(route('home')); ?>" class="nav-brand">
            <div class="nav-logo-icon"><i class="fas fa-shield-halved"></i></div>
            <div>
                <span class="nav-brand-name">AuthenticityHub</span>
                <span class="nav-brand-sub">MCMC Official Platform</span>
            </div>
        </a>
        <a href="<?php echo e(route('login')); ?>" class="nav-link">
            Already have an account? <strong style="color:var(--blue-light);">Sign In</strong>
        </a>
    </nav>

    <!-- MAIN -->
    <div class="page-wrapper">
        <div class="auth-card">

            <div class="card-header">
                <div class="card-icon"><i class="fas fa-user-plus"></i></div>
                <h1 class="card-title">Create Your Account</h1>
                <p class="card-subtitle">Join AuthenticityHub to submit and track public inquiries with MCMC</p>
            </div>

            
            <?php if(session('message')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-circle-check"></i>
                    <span><?php echo e(session('message')); ?></span>
                </div>
            <?php endif; ?>

            
            <form method="POST" action="<?php echo e(route('register')); ?>" novalidate id="registerForm">
                <?php echo csrf_field(); ?>

                <!-- Username -->
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="UserName">Username</label>
                        <div class="input-wrap">
                            <i class="fas fa-user input-icon-left"></i>
                            <input
                                type="text"
                                id="UserName"
                                name="UserName"
                                value="<?php echo e(old('UserName')); ?>"
                                placeholder="Choose a username"
                                autocomplete="username"
                                class="form-input <?php $__errorArgs = ['UserName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required
                            />
                            <?php $__errorArgs = ['UserName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="input-status-icon invalid"><i class="fas fa-circle-xmark"></i></span>
                            <?php else: ?>
                                <?php if(old('UserName')): ?>
                                    <span class="input-status-icon valid" id="usernameValidIcon"><i class="fas fa-circle-check"></i></span>
                                <?php endif; ?>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <?php $__errorArgs = ['UserName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="field-error"><i class="fas fa-triangle-exclamation"></i><span><?php echo e($message); ?></span></div>
                        <?php else: ?>
                            <p class="field-hint">4–20 characters: letters, numbers, underscores only.</p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-row" style="margin-bottom:1rem;">
                    <div class="form-group">
                        <label class="form-label" for="UserEmail">Email Address</label>
                        <div class="input-wrap">
                            <i class="fas fa-envelope input-icon-left"></i>
                            <input
                                type="email"
                                id="UserEmail"
                                name="UserEmail"
                                value="<?php echo e(old('UserEmail')); ?>"
                                placeholder="you@example.com"
                                autocomplete="email"
                                class="form-input <?php $__errorArgs = ['UserEmail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required
                            />
                            <?php $__errorArgs = ['UserEmail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="input-status-icon invalid"><i class="fas fa-circle-xmark"></i></span>
                            <?php else: ?>
                                <?php if(old('UserEmail')): ?>
                                    <span class="input-status-icon valid"><i class="fas fa-circle-check"></i></span>
                                <?php endif; ?>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <?php $__errorArgs = ['UserEmail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="field-error"><i class="fas fa-triangle-exclamation"></i><span><?php echo e($message); ?></span></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Password -->
                <div class="form-row" style="margin-bottom:1rem;">
                    <div class="form-group">
                        <label class="form-label" for="UserPassword">Password</label>
                        <div class="input-wrap">
                            <i class="fas fa-lock input-icon-left"></i>
                            <input
                                type="password"
                                id="UserPassword"
                                name="UserPassword"
                                placeholder="Create a strong password"
                                autocomplete="new-password"
                                class="form-input <?php $__errorArgs = ['UserPassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required
                            />
                            <button type="button" class="input-btn-right" id="togglePw1" aria-label="Toggle password">
                                <i class="fas fa-eye" id="pw1Icon"></i>
                            </button>
                        </div>
                        <?php $__errorArgs = ['UserPassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="field-error"><i class="fas fa-triangle-exclamation"></i><span><?php echo e($message); ?></span></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <!-- Strength meter -->
                        <div class="strength-bar" id="strengthBar">
                            <div class="strength-segment" id="seg1"></div>
                            <div class="strength-segment" id="seg2"></div>
                            <div class="strength-segment" id="seg3"></div>
                            <div class="strength-segment" id="seg4"></div>
                        </div>
                        <div class="strength-label" id="strengthLabel">Enter a password</div>

                        <!-- Password rules -->
                        <div class="pw-rules" id="pwRules">
                            <div class="pw-rule" id="rule-length"><i class="fas fa-circle"></i> 8+ characters</div>
                            <div class="pw-rule" id="rule-upper"><i class="fas fa-circle"></i> Uppercase letter</div>
                            <div class="pw-rule" id="rule-lower"><i class="fas fa-circle"></i> Lowercase letter</div>
                            <div class="pw-rule" id="rule-num"><i class="fas fa-circle"></i> Number</div>
                            <div class="pw-rule" id="rule-special"><i class="fas fa-circle"></i> Special character</div>
                        </div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="form-row" style="margin-bottom:1rem;">
                    <div class="form-group">
                        <label class="form-label" for="UserPassword_confirmation">Confirm Password</label>
                        <div class="input-wrap">
                            <i class="fas fa-lock input-icon-left"></i>
                            <input
                                type="password"
                                id="UserPassword_confirmation"
                                name="UserPassword_confirmation"
                                placeholder="Re-enter your password"
                                autocomplete="new-password"
                                class="form-input"
                                required
                            />
                            <button type="button" class="input-btn-right" id="togglePw2" aria-label="Toggle confirm password">
                                <i class="fas fa-eye" id="pw2Icon"></i>
                            </button>
                        </div>
                        <div class="field-error" id="confirmError" style="display:none;">
                            <i class="fas fa-triangle-exclamation"></i><span>Passwords do not match</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:0.35rem;margin-top:0.4rem;display:none;" id="confirmSuccess">
                            <i class="fas fa-circle-check" style="font-size:0.72rem;color:var(--success);"></i>
                            <span style="font-size:0.73rem;color:var(--success);font-weight:500;">Passwords match</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit" id="registerSubmitBtn">
                    <i class="fas fa-user-plus"></i>
                    Create Account
                </button>

                <p class="terms-note">
                    By registering, you agree to our <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>.<br>
                    Your data is protected under Malaysia's <a href="#">Personal Data Protection Act (PDPA)</a>.
                </p>
            </form>

            <div class="card-divider"><span>Already registered?</span></div>

            <div class="login-prompt">
                Have an account? <a href="<?php echo e(route('login')); ?>" id="goLoginLink">Sign in here &rarr;</a>
            </div>

            <div class="security-note">
                <i class="fas fa-lock"></i>
                256-bit TLS encryption · PDPA compliant · ISO 27001
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
        // ============================================================
        // Password toggle: Password field
        // ============================================================
        const togglePw1 = document.getElementById('togglePw1');
        const pw1 = document.getElementById('UserPassword');
        const pw1Icon = document.getElementById('pw1Icon');
        togglePw1.addEventListener('click', () => {
            const show = pw1.type === 'password';
            pw1.type = show ? 'text' : 'password';
            pw1Icon.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
        });

        // ============================================================
        // Password toggle: Confirm field
        // ============================================================
        const togglePw2 = document.getElementById('togglePw2');
        const pw2 = document.getElementById('UserPassword_confirmation');
        const pw2Icon = document.getElementById('pw2Icon');
        togglePw2.addEventListener('click', () => {
            const show = pw2.type === 'password';
            pw2.type = show ? 'text' : 'password';
            pw2Icon.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
        });

        // ============================================================
        // Password strength meter
        // ============================================================
        const strengthColors = {
            0: 'rgba(255,255,255,0.1)',
            1: '#ef4444',
            2: '#f59e0b',
            3: '#3b82f6',
            4: '#10b981'
        };
        const strengthLabels = {
            0: { text: 'Enter a password', color: 'var(--text-secondary)' },
            1: { text: 'Weak', color: '#ef4444' },
            2: { text: 'Fair', color: '#f59e0b' },
            3: { text: 'Good', color: '#3b82f6' },
            4: { text: 'Strong', color: '#10b981' }
        };

        const rules = {
            'rule-length':  v => v.length >= 8,
            'rule-upper':   v => /[A-Z]/.test(v),
            'rule-lower':   v => /[a-z]/.test(v),
            'rule-num':     v => /[0-9]/.test(v),
            'rule-special': v => /[^A-Za-z0-9]/.test(v),
        };

        const segs = [
            document.getElementById('seg1'),
            document.getElementById('seg2'),
            document.getElementById('seg3'),
            document.getElementById('seg4'),
        ];
        const strengthLabel = document.getElementById('strengthLabel');

        pw1.addEventListener('input', function() {
            const val = this.value;
            let score = 0;

            // Check rules
            Object.entries(rules).forEach(([id, test]) => {
                const el = document.getElementById(id);
                if (test(val)) {
                    el.classList.add('passed');
                    el.querySelector('i').className = 'fas fa-circle-check';
                    score++;
                } else {
                    el.classList.remove('passed');
                    el.querySelector('i').className = 'fas fa-circle';
                }
            });

            // Update strength bar
            const level = val.length === 0 ? 0 : Math.min(4, score);
            segs.forEach((seg, i) => {
                seg.style.background = i < level ? strengthColors[level] : strengthColors[0];
            });
            strengthLabel.textContent = strengthLabels[level].text;
            strengthLabel.style.color = strengthLabels[level].color;

            // Re-check confirm match
            checkConfirm();
        });

        // ============================================================
        // Confirm password match check
        // ============================================================
        const confirmError   = document.getElementById('confirmError');
        const confirmSuccess = document.getElementById('confirmSuccess');

        function checkConfirm() {
            if (!pw2.value) {
                confirmError.style.display   = 'none';
                confirmSuccess.style.display = 'none';
                pw2.classList.remove('is-invalid', 'is-valid');
                return;
            }
            const match = pw1.value === pw2.value;
            confirmError.style.display   = match ? 'none'  : 'flex';
            confirmSuccess.style.display = match ? 'flex'  : 'none';
            pw2.classList.toggle('is-invalid', !match);
            pw2.classList.toggle('is-valid',    match);
        }

        pw2.addEventListener('input', checkConfirm);

        // ============================================================
        // Username live validation (basic)
        // ============================================================
        const usernameInput = document.getElementById('UserName');
        usernameInput.addEventListener('input', function() {
            const valid = /^[a-zA-Z0-9_]{4,20}$/.test(this.value);
            this.classList.toggle('is-valid',   this.value.length > 0 &&  valid);
            this.classList.toggle('is-invalid', this.value.length > 0 && !valid);
        });

        // ============================================================
        // Email live validation
        // ============================================================
        const emailInput = document.getElementById('UserEmail');
        emailInput.addEventListener('blur', function() {
            const valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value);
            this.classList.toggle('is-valid',   this.value.length > 0 &&  valid);
            this.classList.toggle('is-invalid', this.value.length > 0 && !valid);
        });

        // ============================================================
        // Form submission state
        // ============================================================
        const form = document.getElementById('registerForm');
        const submitBtn = document.getElementById('registerSubmitBtn');
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account…';
        });

        window.addEventListener('pageshow', function(e) {
            if (e.persisted) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-user-plus"></i> Create Account';
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\khale\Desktop\MCMC_S02_Astrolabe\myApp\resources\views/Module3/PublicUser/registerPage.blade.php ENDPATH**/ ?>