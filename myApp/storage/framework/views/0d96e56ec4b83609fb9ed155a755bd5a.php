<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Password Recovery — AuthenticityHub | MCMC</title>
    <meta name="description" content="Recover your AuthenticityHub password securely.">
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
        .nav-brand-name { font-weight: 800; font-size: 1rem; color: #fff; letter-spacing: -0.01em; }
        .nav-brand-sub { display:block; font-size: 0.58rem; font-weight:500; color:var(--cyan); letter-spacing:0.05em; text-transform:uppercase; }
        
        .nav-links { display: flex; align-items: center; gap: 1rem; }
        .nav-link { font-size: 0.88rem; font-weight: 500; color: var(--text-secondary); text-decoration: none; transition: color 0.2s ease; cursor: pointer; }
        .nav-link:hover, .nav-link.active { color: #fff; }

        /* MAIN */
        .page-wrapper {
            position: relative; z-index: 1;
            flex: 1; display: flex; align-items: center; justify-content: center;
            padding: 3rem 1.5rem;
        }

        .auth-card {
            width: 100%; max-width: 480px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--glass-border);
            border-radius: 24px; padding: 2.75rem 2.5rem;
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 30px 80px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.08);
            animation: cardIn 0.6s ease both;
            position: relative;
        }

        @keyframes cardIn {
            from { opacity:0; transform:translateY(28px) scale(0.97); }
            to   { opacity:1; transform:translateY(0) scale(1); }
        }

        .card-header { text-align: center; margin-bottom: 2rem; }
        .card-icon {
            width: 60px; height: 60px; border-radius: 18px;
            background: linear-gradient(135deg, rgba(29,95,219,0.2), rgba(6,182,212,0.15));
            border: 1px solid rgba(29,95,219,0.3);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem; font-size: 1.5rem; color: var(--blue-light);
        }
        .card-title { font-size: 1.6rem; font-weight: 800; letter-spacing: -0.02em; color: #fff; margin-bottom: 0.4rem; }
        .card-subtitle { font-size: 0.88rem; color: var(--text-secondary); line-height: 1.5; }

        /* FORM */
        .form-group { margin-bottom: 1.25rem; }
        .form-label {
            display: block; font-size: 0.82rem; font-weight: 600; color: var(--text-secondary);
            margin-bottom: 0.5rem; letter-spacing: 0.03em; text-transform: uppercase;
        }
        .input-wrap { position: relative; }
        .input-icon-left {
            position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);
            color: var(--text-secondary); font-size: 0.9rem; pointer-events: none; z-index: 1; transition: color 0.2s ease;
        }
        .form-input {
            width: 100%; padding: 0.85rem 1rem 0.85rem 2.75rem;
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px; color: #fff; font-size: 0.95rem; font-family: 'Inter', sans-serif; font-weight: 500;
            outline: none; transition: all 0.25s ease; -webkit-appearance: none;
        }
        .form-input::placeholder { color: rgba(148,163,184,0.5); }
        .form-input:hover { border-color: rgba(29,95,219,0.4); background: rgba(255,255,255,0.08); }
        .form-input:focus { border-color: var(--blue-light); background: rgba(29,95,219,0.08); box-shadow: 0 0 0 3px rgba(29,95,219,0.15); }
        .form-input:focus ~ .input-icon-left, .input-wrap:focus-within .input-icon-left { color: var(--blue-light); }
        .form-input.is-invalid { border-color: var(--danger) !important; background: rgba(239,68,68,0.06) !important; box-shadow: 0 0 0 3px rgba(239,68,68,0.12) !important; }
        
        .field-error { display: flex; align-items: center; gap: 0.4rem; margin-top: 0.45rem; font-size: 0.8rem; color: #fca5a5; font-weight: 500; }
        .field-error i { font-size: 0.75rem; }

        .btn-submit {
            width: 100%; padding: 0.9rem; font-size: 1rem; font-weight: 700; color: #fff;
            background: linear-gradient(135deg, var(--blue), #1a4fc4); border: none; border-radius: 12px; cursor: pointer;
            transition: all 0.3s ease; box-shadow: 0 6px 24px rgba(29,95,219,0.35);
            display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-top: 1.5rem;
        }
        .btn-submit:hover { background: linear-gradient(135deg, #2670f5, var(--blue)); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(29,95,219,0.5); }
        
        .btn-secondary {
            width: 100%; padding: 0.9rem; font-size: 0.95rem; font-weight: 600; color: var(--text-primary);
            background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); border-radius: 12px; cursor: pointer;
            transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-top: 0.75rem;
        }
        .btn-secondary:hover { background: rgba(255,255,255,0.1); color: #fff; }

        /* Alerts */
        .alert { display: flex; align-items: flex-start; gap: 0.75rem; padding: 0.9rem 1.1rem; border-radius: 12px; font-size: 0.875rem; font-weight: 500; margin-bottom: 1.5rem; line-height: 1.5; }
        .alert-success { background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.3); color: #6ee7b7; }
        .alert-error { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; }
        .alert-warning { background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3); color: #fcd34d; }

        /* LOADING SPINNER OVERLAY */
        .loading-overlay {
            position: absolute; inset: 0; background: rgba(11,31,58,0.85); backdrop-filter: blur(5px);
            border-radius: 24px; display: none; flex-direction: column; align-items: center; justify-content: center; z-index: 10;
        }
        .loading-spinner {
            width: 50px; height: 50px; border: 4px solid rgba(29,95,219,0.2); border-top: 4px solid var(--blue-light);
            border-radius: 50%; animation: spin 1s linear infinite; margin-bottom: 1rem;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .loading-text { color: #fff; font-weight: 600; font-size: 1.1rem; margin-bottom: 0.5rem; }
        .countdown { color: var(--cyan); font-weight: 800; font-size: 2.5rem; }

        .success-message {
            background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.3); color: #6ee7b7;
            padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; font-weight: 500; display: none; text-align: center;
        }
        .success-message.show { display: block; animation: fadeIn 0.5s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        
        /* HELP CONTENT SECTION */
        .help-content { display: none; animation: cardIn 0.4s ease; text-align: left; }
        .help-section { margin-bottom: 1.5rem; }
        .help-section h3 { color: #fff; font-size: 1.1rem; font-weight: 700; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem; }
        .help-section h3 i { color: var(--cyan); font-size: 1rem; }
        .help-section p { color: var(--text-secondary); font-size: 0.9rem; line-height: 1.6; margin-bottom: 0.75rem; }
        .help-list { list-style: none; color: var(--text-secondary); font-size: 0.9rem; line-height: 1.6; }
        .help-list li { display: flex; align-items: flex-start; gap: 0.5rem; margin-bottom: 0.5rem; }
        .help-list li i { color: var(--blue-light); font-size: 0.8rem; margin-top: 0.2rem; }
        .help-contact { background: rgba(29,95,219,0.1); border-radius: 12px; padding: 1.25rem; margin-top: 1.5rem; }
        .help-contact p { color: #fff; font-size: 0.9rem; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem; }
        .help-contact i { color: var(--cyan); width: 1.2rem; text-align: center; }

        /* FOOTER */
        footer {
            position: relative; z-index: 1; padding: 1.5rem 2rem; background: rgba(5,15,30,0.8); border-top: 1px solid var(--glass-border);
        }
        .footer-inner {
            max-width: 900px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem;
        }
        .footer-inner p { font-size: 0.78rem; color: rgba(148,163,184,0.55); }
        .footer-inner p a { color: var(--blue-light); text-decoration: none; }
        .footer-links { display: flex; gap: 1.25rem; }
        .footer-links a { font-size: 0.78rem; color: rgba(148,163,184,0.55); text-decoration: none; transition: color 0.2s ease; }
        .footer-links a:hover { color: var(--text-secondary); }

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
        <div class="nav-links">
            <a href="#" id="nav-recovery-link" class="nav-link active"><i class="fas fa-key"></i> Recovery</a>
            <a href="#" id="nav-help-link" class="nav-link"><i class="fas fa-circle-question"></i> Help</a>
            <a href="<?php echo e(route('login')); ?>" class="nav-link" style="color:var(--blue-light);"><i class="fas fa-arrow-right-to-bracket"></i> Login</a>
        </div>
    </nav>

    <!-- MAIN -->
    <div class="page-wrapper">
        <div class="auth-card" id="main-card">
            
            <!-- Loading Overlay -->
            <div class="loading-overlay" id="loading-overlay">
                <div class="loading-spinner"></div>
                <div class="loading-text">Verifying Email...</div>
                <div class="countdown" id="countdown">5</div>
            </div>

            <!-- REGULAR RECOVERY VIEWS -->
            <div id="recovery-views">
                <div class="card-header">
                    <div class="card-icon" id="card-icon-el"><i class="fas fa-unlock-keyhole"></i></div>
                    <h1 class="card-title" id="card-title-el">Password Recovery</h1>
                    <p class="card-subtitle" id="card-subtitle-el">Enter your email to reset your password</p>
                </div>

                <!-- Success Message -->
                <div class="success-message" id="success-message">
                    <i class="fas fa-circle-check" style="margin-right:0.4rem;"></i>
                    Your email has been verified!
                </div>

                <?php if(session('status')): ?>
                    <div class="alert alert-success"><i class="fas fa-circle-check"></i> <span><?php echo e(session('status')); ?></span></div>
                <?php endif; ?>
                <?php if(session('phone_required')): ?>
                    <div class="alert alert-warning"><i class="fas fa-triangle-exclamation"></i> <span><?php echo e(session('phone_required')); ?></span></div>
                <?php endif; ?>

                <!-- AGENCY SETUP MODE -->
                <?php if(session('phone_verification_agency_id')): ?>
                    <div id="agency-setup-container">
                        <form method="POST" action="<?php echo e(route('agency.phone.update')); ?>" novalidate>
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <label class="form-label" for="phone">Phone Number</label>
                                <div class="input-wrap">
                                    <i class="fas fa-phone input-icon-left"></i>
                                    <input type="tel" name="phone" id="phone" value="<?php echo e(old('phone')); ?>" placeholder="Enter phone number" class="form-input <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required />
                                </div>
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="field-error"><i class="fas fa-triangle-exclamation"></i><span><?php echo e($errors->first('phone')); ?></span></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password">New Password</label>
                                <div class="input-wrap">
                                    <i class="fas fa-lock input-icon-left"></i>
                                    <input type="password" name="password" id="password" placeholder="New Password" class="form-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required />
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="field-error"><i class="fas fa-triangle-exclamation"></i><span><?php echo e($errors->first('password')); ?></span></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                <div class="input-wrap">
                                    <i class="fas fa-lock input-icon-left"></i>
                                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm New Password" class="form-input" required />
                                </div>
                            </div>

                            <button type="submit" class="btn-submit">Complete Setup</button>
                            <a href="<?php echo e(route('login')); ?>" class="btn-secondary" style="text-decoration:none;">Back to Login</a>
                        </form>
                    </div>
                <?php else: ?>
                    <!-- NORMAL EMAIL/PASSWORD FORMS -->
                    <!-- 1. Email verification form -->
                    <div id="email-form-container" style="display: <?php echo e($errors->has('password') ? 'none' : 'block'); ?>;">
                        <form method="POST" action="<?php echo e(route('password.email')); ?>" novalidate id="email-form">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <label class="form-label" for="email">Email Address</label>
                                <div class="input-wrap">
                                    <i class="fas fa-envelope input-icon-left"></i>
                                    <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" placeholder="you@example.com" class="form-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required />
                                </div>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="field-error"><i class="fas fa-triangle-exclamation"></i><span><?php echo e($errors->first('email')); ?></span></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Send Recovery Link</button>
                            <a href="<?php echo e(route('login')); ?>" class="btn-secondary" style="text-decoration:none;"><i class="fas fa-arrow-left"></i> Back to Login</a>
                        </form>
                    </div>

                    <!-- 2. Password reset form -->
                    <div id="password-form-container" style="display: <?php echo e($errors->has('password') ? 'block' : 'none'); ?>;">
                        <form method="POST" action="<?php echo e(route('password.reset')); ?>" novalidate>
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="email" id="verified-email" value="<?php echo e(old('email')); ?>">
                            <div class="form-group">
                                <label class="form-label" for="new-password">New Password</label>
                                <div class="input-wrap">
                                    <i class="fas fa-lock input-icon-left"></i>
                                    <input type="password" name="password" id="new-password" placeholder="Create new password" class="form-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required />
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="field-error"><i class="fas fa-triangle-exclamation"></i><span><?php echo e($errors->first('password')); ?></span></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="confirm-password">Confirm Password</label>
                                <div class="input-wrap">
                                    <i class="fas fa-lock input-icon-left"></i>
                                    <input type="password" name="password_confirmation" id="confirm-password" placeholder="Confirm new password" class="form-input" required />
                                </div>
                            </div>
                            <button type="submit" class="btn-submit"><i class="fas fa-key"></i> Reset Password</button>
                            <button type="button" id="back-to-email" class="btn-secondary"><i class="fas fa-arrow-left"></i> Back</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <!-- HELP CONTENT VIEW -->
            <div id="help-content" class="help-content">
                <div class="card-header" style="margin-bottom:1.5rem;">
                    <div class="card-icon"><i class="fas fa-circle-question"></i></div>
                    <h1 class="card-title">Help & Support</h1>
                    <p class="card-subtitle">Information on recovering your account</p>
                </div>
                
                <div class="help-section">
                    <h3><i class="fas fa-shield-halved"></i> Recovery Process</h3>
                    <ul class="help-list">
                        <li><i class="fas fa-circle-dot"></i> Enter the email address associated with your account.</li>
                        <li><i class="fas fa-circle-dot"></i> Our system will securely verify your identity.</li>
                        <li><i class="fas fa-circle-dot"></i> Create a strong new password to regain access immediately.</li>
                    </ul>
                </div>
                <div class="help-section">
                    <h3><i class="fas fa-clipboard-question"></i> FAQ</h3>
                    <p><strong>Not receiving emails?</strong><br>Our secure instant-verification process allows you to reset it here immediately if your email is valid on our system.</p>
                </div>
                <div class="help-contact">
                    <h4 style="color:#fff;font-size:0.9rem;font-weight:600;margin-bottom:0.75rem;">Contact Support</h4>
                    <p><i class="fas fa-envelope"></i> support@authenticityhub.com</p>
                    <p><i class="fas fa-phone"></i> 1-800-AUTH-HUB</p>
                </div>
                
                <button type="button" id="back-to-recovery-btn" class="btn-submit" style="margin-top:1.5rem;">
                    <i class="fas fa-arrow-left"></i> Return to Recovery
                </button>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Views
            const recoveryViews = document.getElementById('recovery-views');
            const helpContent = document.getElementById('help-content');
            
            // Nav Links
            const navRecoveryLink = document.getElementById('nav-recovery-link');
            const navHelpLink = document.getElementById('nav-help-link');
            const backToRecoveryBtn = document.getElementById('back-to-recovery-btn');

            // Form Elements
            const emailForm = document.getElementById('email-form');
            const emailFormContainer = document.getElementById('email-form-container');
            const passwordFormContainer = document.getElementById('password-form-container');
            const loadingOverlay = document.getElementById('loading-overlay');
            const successMessage = document.getElementById('success-message');
            const countdownElement = document.getElementById('countdown');
            const backToEmailBtn = document.getElementById('back-to-email');
            const verifiedEmailInput = document.getElementById('verified-email');

            // Dynamic header
            const cardTitleEl = document.getElementById('card-title-el');
            const cardSubtitleEl = document.getElementById('card-subtitle-el');
            const cardIconEl = document.getElementById('card-icon-el');

            // Check if we're in agency setup mode
            const agencySetupContainer = document.getElementById('agency-setup-container');
            if (agencySetupContainer) {
                if (cardTitleEl) cardTitleEl.textContent = 'Account Setup';
                if (cardSubtitleEl) cardSubtitleEl.textContent = 'Complete your profile setup';
                if (cardIconEl) cardIconEl.innerHTML = '<i class="fas fa-user-cog"></i>';
            }

            // Check if we have password validation errors on page load
            <?php if($errors->has('password') && old('email')): ?>
                if (verifiedEmailInput) verifiedEmailInput.value = '<?php echo e(old('email')); ?>';
                const newPasswordField = document.getElementById('new-password');
                if (newPasswordField) newPasswordField.focus();
                
                if (cardTitleEl) cardTitleEl.textContent = 'Create New Password';
                if (cardSubtitleEl) cardSubtitleEl.textContent = 'Secure your account with a strong password';
            <?php endif; ?>

            // Toggle Help & Recovery Views
            function showHelp() {
                recoveryViews.style.display = 'none';
                helpContent.style.display = 'block';
                navRecoveryLink.classList.remove('active');
                navHelpLink.classList.add('active');
            }

            function showRecovery() {
                helpContent.style.display = 'none';
                recoveryViews.style.display = 'block';
                navHelpLink.classList.remove('active');
                navRecoveryLink.classList.add('active');
            }

            navHelpLink.addEventListener('click', (e) => { e.preventDefault(); showHelp(); });
            navRecoveryLink.addEventListener('click', (e) => { e.preventDefault(); showRecovery(); });
            backToRecoveryBtn.addEventListener('click', showRecovery);

            // AJAX Form Submission for Email
            if (emailForm) {
                emailForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const emailInput = document.getElementById('email');
                    const email = emailInput.value.trim();
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    
                    // Cleanup existing errors
                    emailInput.classList.remove('is-invalid');
                    let existingError = emailInput.parentNode.parentNode.querySelector('.field-error');
                    if (existingError) existingError.remove();

                    if (!emailRegex.test(email)) {
                        emailInput.classList.add('is-invalid');
                        let errorMsg = document.createElement('div');
                        errorMsg.className = 'field-error';
                        errorMsg.innerHTML = '<i class="fas fa-triangle-exclamation"></i><span>Valid email address required</span>';
                        emailInput.parentNode.parentNode.appendChild(errorMsg);
                        return;
                    }

                    loadingOverlay.style.display = 'flex';

                    fetch('<?php echo e(route('password.email')); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ email: email })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            verifiedEmailInput.value = email;
                            let countdown = 5;
                            countdownElement.textContent = countdown;
                            
                            const countdownInterval = setInterval(() => {
                                countdown--;
                                countdownElement.textContent = countdown;
                                if (countdown <= 0) {
                                    clearInterval(countdownInterval);
                                    loadingOverlay.style.display = 'none';
                                    successMessage.classList.add('show');
                                    
                                    setTimeout(() => {
                                        emailFormContainer.style.display = 'none';
                                        passwordFormContainer.style.display = 'block';
                                        if (cardTitleEl) cardTitleEl.textContent = 'Create New Password';
                                        if (cardSubtitleEl) cardSubtitleEl.textContent = 'Secure your account with a strong password';
                                        document.getElementById('new-password').focus();
                                    }, 800);
                                }
                            }, 1000);
                        } else {
                            loadingOverlay.style.display = 'none';
                            emailInput.classList.add('is-invalid');
                            let errorMsg = document.createElement('div');
                            errorMsg.className = 'field-error';
                            errorMsg.innerHTML = '<i class="fas fa-triangle-exclamation"></i><span>' + (data.message || 'Verification failed') + '</span>';
                            emailInput.parentNode.parentNode.appendChild(errorMsg);
                        }
                    })
                    .catch(error => {
                        loadingOverlay.style.display = 'none';
                        console.error('Error:', error);
                        emailInput.classList.add('is-invalid');
                        let errorMsg = document.createElement('div');
                        errorMsg.className = 'field-error';
                        errorMsg.innerHTML = '<i class="fas fa-triangle-exclamation"></i><span>An error occurred</span>';
                        emailInput.parentNode.parentNode.appendChild(errorMsg);
                    });
                });
            }

            // Back to email form
            if (backToEmailBtn) {
                backToEmailBtn.addEventListener('click', function() {
                    passwordFormContainer.style.display = 'none';
                    emailFormContainer.style.display = 'block';
                    successMessage.classList.remove('show');
                    if (cardTitleEl) cardTitleEl.textContent = 'Password Recovery';
                    if (cardSubtitleEl) cardSubtitleEl.textContent = 'Enter your email to reset your password';
                });
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\khale\Desktop\MCMC_S02_Astrolabe\myApp\resources\views/home/recovaryPasswordPage.blade.php ENDPATH**/ ?>