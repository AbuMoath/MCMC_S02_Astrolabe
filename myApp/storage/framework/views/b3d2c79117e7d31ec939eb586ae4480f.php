<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Verification — AuthenticityHub | MCMC</title>
    <meta name="description" content="Enter your One-Time Password to complete the two-factor authentication for your MCMC administrator account.">
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

        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--navy);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex; flex-direction: column;
            overflow-x: hidden;
        }

        .bg-mesh {
            position: fixed; inset:0; z-index:0;
            background:
                radial-gradient(ellipse 60% 50% at 50% 0%, rgba(29,95,219,0.2) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 20% 90%, rgba(6,182,212,0.12) 0%, transparent 55%),
                linear-gradient(160deg, #0b1f3a 0%, #07152a 60%, #050f1e 100%);
        }
        .bg-grid {
            position: fixed; inset:0; z-index:0;
            background-image:
                linear-gradient(rgba(29,95,219,0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(29,95,219,0.05) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* Animated ring behind shield */
        .bg-ring {
            position: fixed;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 500px; height: 500px;
            border-radius: 50%;
            border: 1px solid rgba(29,95,219,0.1);
            z-index: 0;
            animation: ringPulse 3s ease-in-out infinite;
        }
        .bg-ring:nth-child(2) {
            width: 700px; height: 700px;
            animation-delay: 0.8s;
            border-color: rgba(6,182,212,0.06);
        }
        .bg-ring:nth-child(3) {
            width: 900px; height: 900px;
            animation-delay: 1.6s;
            border-color: rgba(29,95,219,0.04);
        }
        @keyframes ringPulse {
            0%, 100% { transform: translate(-50%,-50%) scale(1); opacity:1; }
            50% { transform: translate(-50%,-50%) scale(1.04); opacity:0.6; }
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
        .nav-brand { display:flex; align-items:center; gap:0.75rem; text-decoration:none; }
        .nav-logo-icon {
            width:36px; height:36px;
            background: linear-gradient(135deg, var(--blue), var(--cyan));
            border-radius:10px;
            display:flex; align-items:center; justify-content:center;
            box-shadow:0 4px 12px rgba(29,95,219,0.4);
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
            flex:1;
            display: flex; align-items: center; justify-content: center;
            padding: 3rem 1.5rem;
        }

        /* CARD */
        .auth-card {
            width:100%; max-width:440px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 2.75rem 2.5rem;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 30px 80px rgba(0,0,0,0.45), inset 0 1px 0 rgba(255,255,255,0.08);
            animation: cardIn 0.6s ease both;
            text-align: center;
        }

        @keyframes cardIn {
            from { opacity:0; transform:translateY(24px) scale(0.97); }
            to   { opacity:1; transform:translateY(0) scale(1); }
        }

        /* Shield icon */
        .shield-wrap {
            width: 80px; height: 80px;
            border-radius: 22px;
            background: linear-gradient(135deg, rgba(29,95,219,0.2), rgba(6,182,212,0.15));
            border: 1px solid rgba(29,95,219,0.3);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem; color: var(--blue-light);
            position: relative;
            animation: shieldGlow 3s ease-in-out infinite;
        }

        @keyframes shieldGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(29,95,219,0.2), 0 0 40px rgba(29,95,219,0.05); }
            50%       { box-shadow: 0 0 30px rgba(29,95,219,0.35), 0 0 60px rgba(6,182,212,0.1); }
        }

        /* Step indicator */
        .step-indicator {
            display: flex; align-items: center; justify-content: center;
            gap: 0.5rem; margin-bottom: 1.5rem;
        }
        .step-dot {
            width: 8px; height: 8px; border-radius:50%;
            background: var(--glass-border);
        }
        .step-dot.active { background: var(--blue-light); box-shadow:0 0 8px rgba(59,130,246,0.6); }
        .step-dot.done { background: var(--success); }

        .card-title {
            font-size: 1.55rem; font-weight: 800;
            letter-spacing: -0.02em; color: #fff;
            margin-bottom: 0.5rem;
        }
        .card-subtitle {
            font-size: 0.88rem; color: var(--text-secondary); line-height: 1.6;
        }

        .email-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            margin: 1rem auto;
            padding: 0.45rem 1rem;
            background: rgba(6,182,212,0.1);
            border: 1px solid rgba(6,182,212,0.25);
            border-radius: 100px;
            font-size: 0.82rem; font-weight: 600; color: var(--cyan);
        }
        .email-badge i { font-size:0.78rem; }

        /* Alerts */
        .alert {
            display: flex; align-items: flex-start; gap: 0.75rem;
            padding: 0.85rem 1rem; border-radius: 12px;
            font-size: 0.85rem; font-weight: 500;
            margin-bottom: 1.25rem; line-height: 1.5;
            text-align: left;
        }
        .alert i { margin-top:0.05rem; flex-shrink:0; }
        .alert-error {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3); color: #fca5a5;
        }
        .alert-info {
            background: rgba(6,182,212,0.08);
            border: 1px solid rgba(6,182,212,0.25); color: #67e8f9;
        }

        /* OTP BOXES */
        .otp-input-wrapper {
            display: flex; justify-content: center; gap: 0.65rem;
            margin: 1.75rem 0 0.5rem;
        }

        .otp-digit {
            width: 54px; height: 62px;
            text-align: center; font-size: 1.5rem; font-weight: 800;
            color: #fff;
            background: rgba(255,255,255,0.07);
            border: 1.5px solid rgba(255,255,255,0.12);
            border-radius: 14px; outline: none;
            transition: all 0.2s ease;
            caret-color: var(--blue-light);
            -webkit-appearance: none;
        }

        .otp-digit::placeholder { color: rgba(148,163,184,0.25); }

        .otp-digit:focus {
            border-color: var(--blue-light);
            background: rgba(29,95,219,0.12);
            box-shadow: 0 0 0 3px rgba(29,95,219,0.2), 0 0 20px rgba(29,95,219,0.15);
            transform: translateY(-2px) scale(1.05);
        }

        .otp-digit.filled {
            border-color: rgba(29,95,219,0.5);
            background: rgba(29,95,219,0.1);
        }

        .otp-digit.is-invalid {
            border-color: var(--danger) !important;
            background: rgba(239,68,68,0.08) !important;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.15) !important;
            animation: shake 0.4s ease;
        }

        .otp-digit.is-success {
            border-color: var(--success) !important;
            background: rgba(16,185,129,0.08) !important;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-5px); }
            40% { transform: translateX(5px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
        }

        .field-error {
            display: flex; align-items: center; justify-content: center; gap: 0.4rem;
            margin-top: 0.6rem; font-size: 0.82rem;
            color: #fca5a5; font-weight: 500;
        }
        .field-error i { font-size: 0.75rem; }

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
        .btn-submit:disabled { opacity:0.5; cursor:not-allowed; transform:none; }

        /* Resend button */
        .btn-resend {
            width: 100%; padding: 0.75rem;
            font-size: 0.9rem; font-weight: 600;
            color: var(--text-secondary);
            background: transparent;
            border: 1px solid var(--glass-border);
            border-radius: 12px; cursor: pointer;
            transition: all 0.2s ease;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            font-family: 'Inter', sans-serif;
            margin-top: 0.75rem;
        }
        .btn-resend:hover:not(:disabled) {
            background: var(--glass-bg);
            border-color: rgba(255,255,255,0.22);
            color: #fff;
        }
        .btn-resend:disabled {
            opacity: 0.4; cursor: not-allowed;
        }

        /* Timer */
        .timer-display {
            margin-top: 1.25rem;
            font-size: 0.82rem; color: var(--text-secondary);
        }
        .timer-value {
            font-weight: 700; color: var(--blue-light);
            font-size: 0.95rem; font-variant-numeric: tabular-nums;
        }
        .timer-value.urgent { color: var(--danger); }

        /* Progress arc */
        .timer-arc-wrap {
            display: flex; align-items: center; justify-content: center;
            gap: 0.6rem; margin-bottom: 0.25rem;
        }
        .timer-arc-label { font-size:0.78rem; color:var(--text-secondary); }

        /* Back link */
        .back-link {
            display: inline-flex; align-items: center; gap: 0.4rem;
            margin-top: 1.5rem;
            font-size: 0.84rem; font-weight: 500;
            color: var(--text-secondary); text-decoration: none;
            transition: color 0.2s ease;
        }
        .back-link:hover { color: var(--blue-light); }

        /* Security hints */
        .security-hints {
            margin-top: 1.75rem;
            padding: 1rem;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 12px;
            text-align: left;
        }
        .security-hints h5 {
            font-size:0.75rem; font-weight:700;
            text-transform:uppercase; letter-spacing:0.06em;
            color:var(--text-secondary); margin-bottom:0.75rem;
        }
        .security-hint-item {
            display:flex; align-items:flex-start; gap:0.55rem;
            margin-bottom:0.5rem; font-size:0.78rem;
            color:rgba(148,163,184,0.65); line-height:1.5;
        }
        .security-hint-item i { color:var(--cyan); font-size:0.7rem; margin-top:0.18rem; flex-shrink:0; }
        .security-hint-item:last-child { margin-bottom:0; }

        /* Footer */
        footer {
            position:relative; z-index:1;
            padding:1.5rem 2rem;
            background: rgba(5,15,30,0.8);
            border-top: 1px solid var(--glass-border);
        }
        .footer-inner {
            max-width:900px; margin:0 auto;
            display:flex; align-items:center; justify-content:space-between;
            flex-wrap:wrap; gap:0.75rem;
        }
        .footer-inner p { font-size:0.78rem; color:rgba(148,163,184,0.5); }
        .footer-inner p a { color:var(--blue-light); text-decoration:none; }

        @media (max-width: 480px) {
            .auth-card { padding: 2rem 1.25rem; }
            .otp-digit { width: 44px; height: 52px; font-size: 1.25rem; }
            .otp-input-wrapper { gap: 0.45rem; }
        }
    </style>
</head>

<body>
    <div class="bg-mesh"></div>
    <div class="bg-grid"></div>
    <div class="bg-ring"></div>
    <div class="bg-ring"></div>
    <div class="bg-ring"></div>

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
            <i class="fas fa-arrow-left" style="margin-right:0.35rem;font-size:0.8rem;"></i>Back to Login
        </a>
    </nav>

    <!-- MAIN -->
    <div class="page-wrapper">
        <div class="auth-card">

            <!-- Step indicator: Login → 2FA → Dashboard -->
            <div class="step-indicator">
                <div class="step-dot done"></div>
                <div style="width:24px;height:1.5px;background:var(--success);"></div>
                <div class="step-dot active"></div>
                <div style="width:24px;height:1.5px;background:var(--glass-border);"></div>
                <div class="step-dot"></div>
            </div>

            <!-- Shield icon -->
            <div class="shield-wrap">
                <i class="fas fa-shield-halved"></i>
            </div>

            <h1 class="card-title">Two-Factor Verification</h1>
            <p class="card-subtitle">
                We've sent a 6-digit One-Time Password to your registered email address. Enter it below to complete sign-in.
            </p>

            
            <?php if(session('admin_email')): ?>
                <div class="email-badge">
                    <i class="fas fa-envelope"></i>
                    <?php echo e(session('admin_email')); ?>

                </div>
            <?php endif; ?>

            
            <?php if(session('error')): ?>
                <div class="alert alert-error">
                    <i class="fas fa-triangle-exclamation"></i>
                    <span><?php echo e(session('error')); ?></span>
                </div>
            <?php endif; ?>

            <?php if(session('info')): ?>
                <div class="alert alert-info">
                    <i class="fas fa-circle-info"></i>
                    <span><?php echo e(session('info')); ?></span>
                </div>
            <?php endif; ?>

            
            <form method="POST" action="<?php echo e(route('admin.otp.verify')); ?>" id="otpForm" novalidate>
                <?php echo csrf_field(); ?>

                
                <input type="hidden" name="otp_code" id="otpHiddenInput" value="">

                <!-- 6 Individual OTP digit inputs -->
                <div class="otp-input-wrapper" id="otpWrapper">
                    <input type="text" maxlength="1"
                        class="otp-digit <?php $__errorArgs = ['otp_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        data-index="0" inputmode="numeric" pattern="[0-9]"
                        autocomplete="one-time-code" autofocus
                        placeholder="·" />
                    <input type="text" maxlength="1"
                        class="otp-digit <?php $__errorArgs = ['otp_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        data-index="1" inputmode="numeric" pattern="[0-9]"
                        placeholder="·" />
                    <input type="text" maxlength="1"
                        class="otp-digit <?php $__errorArgs = ['otp_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        data-index="2" inputmode="numeric" pattern="[0-9]"
                        placeholder="·" />
                    <input type="text" maxlength="1"
                        class="otp-digit <?php $__errorArgs = ['otp_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        data-index="3" inputmode="numeric" pattern="[0-9]"
                        placeholder="·" />
                    <input type="text" maxlength="1"
                        class="otp-digit <?php $__errorArgs = ['otp_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        data-index="4" inputmode="numeric" pattern="[0-9]"
                        placeholder="·" />
                    <input type="text" maxlength="1"
                        class="otp-digit <?php $__errorArgs = ['otp_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        data-index="5" inputmode="numeric" pattern="[0-9]"
                        placeholder="·" />
                </div>

                <?php $__errorArgs = ['otp_code'];
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

                <button type="submit" class="btn-submit" id="verifyBtn">
                    <i class="fas fa-circle-check"></i>
                    Verify &amp; Continue
                </button>
            </form>

            
            <form method="POST" action="<?php echo e(route('admin.otp.resend')); ?>" id="resendForm">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-resend" id="resendBtn" disabled>
                    <i class="fas fa-rotate-right"></i>
                    <span id="resendText">Resend OTP (available in <span id="resendCountdown">60</span>s)</span>
                </button>
            </form>

            <!-- Countdown timer -->
            <div class="timer-display">
                <div class="timer-arc-wrap">
                    <i class="fas fa-clock" style="font-size:0.78rem;"></i>
                    <span class="timer-arc-label">Code expires in:</span>
                    <span class="timer-value" id="mainCountdown">5:00</span>
                </div>
            </div>

            <a href="<?php echo e(route('login')); ?>" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Back to Login
            </a>

            <!-- Security hints -->
            <div class="security-hints">
                <h5><i class="fas fa-shield-halved" style="margin-right:0.35rem;color:var(--cyan);"></i>Security Notice</h5>
                <div class="security-hint-item">
                    <i class="fas fa-circle-dot"></i>
                    MCMC will never ask for your OTP over phone or email. Never share it with anyone.
                </div>
                <div class="security-hint-item">
                    <i class="fas fa-circle-dot"></i>
                    This code is valid for 5 minutes only. Request a new one if it expires.
                </div>
                <div class="security-hint-item">
                    <i class="fas fa-circle-dot"></i>
                    Multiple failed attempts will temporarily lock your account.
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="footer-inner">
            <p>&copy; <?php echo e(date('Y')); ?> AuthenticityHub — <a href="https://www.mcmc.gov.my" target="_blank">MCMC Malaysia</a>. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const digits      = document.querySelectorAll('.otp-digit');
            const hiddenInput = document.getElementById('otpHiddenInput');
            const form        = document.getElementById('otpForm');
            const verifyBtn   = document.getElementById('verifyBtn');

            // =========================================================
            // Sync all digit inputs into the hidden field
            // =========================================================
            function syncHiddenInput() {
                let otp = '';
                digits.forEach(d => otp += (d.value || ''));
                hiddenInput.value = otp;
                return otp;
            }

            // =========================================================
            // Update "filled" visual state on each box
            // =========================================================
            function updateFilled() {
                digits.forEach(d => {
                    d.classList.toggle('filled', d.value.length === 1);
                });
            }

            // =========================================================
            // OTP input handling
            // =========================================================
            digits.forEach((digit, idx) => {
                // Only accept digits
                digit.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1);
                    updateFilled();
                    syncHiddenInput();
                    // Auto-advance
                    if (this.value && idx < digits.length - 1) {
                        digits[idx + 1].focus();
                    }
                    // Remove invalid styling on interaction
                    digits.forEach(d => d.classList.remove('is-invalid'));
                });

                // Backspace navigation
                digit.addEventListener('keydown', function (e) {
                    if (e.key === 'Backspace') {
                        if (!this.value && idx > 0) {
                            digits[idx - 1].focus();
                            digits[idx - 1].value = '';
                        }
                        this.value = '';
                        updateFilled();
                        syncHiddenInput();
                    }
                    // Arrow key navigation
                    if (e.key === 'ArrowLeft' && idx > 0) { e.preventDefault(); digits[idx-1].focus(); }
                    if (e.key === 'ArrowRight' && idx < digits.length-1) { e.preventDefault(); digits[idx+1].focus(); }
                    // Enter to submit
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const otp = syncHiddenInput();
                        if (otp.length === 6) form.submit();
                    }
                });

                // Paste: fill all boxes from clipboard
                digit.addEventListener('paste', function (e) {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData)
                        .getData('text')
                        .replace(/[^0-9]/g, '');
                    if (paste.length >= 6) {
                        for (let i = 0; i < 6; i++) {
                            digits[i].value = paste[i] || '';
                        }
                        digits[Math.min(5, paste.length - 1)].focus();
                        updateFilled();
                        syncHiddenInput();
                    }
                });

                // Click: select content
                digit.addEventListener('click', function () {
                    this.select();
                });
            });

            // =========================================================
            // Form submission
            // =========================================================
            form.addEventListener('submit', function (e) {
                const otp = syncHiddenInput();
                if (otp.length !== 6) {
                    e.preventDefault();
                    digits.forEach(d => d.classList.add('is-invalid'));
                    return;
                }
                // Success animation
                digits.forEach(d => { d.classList.remove('is-invalid'); d.classList.add('is-success'); });
                verifyBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying…';
                verifyBtn.disabled = true;
            });

            // =========================================================
            // Main countdown timer (5 minutes)
            // =========================================================
            let totalSeconds = 300;
            const mainCountdownEl = document.getElementById('mainCountdown');

            const mainTimer = setInterval(() => {
                totalSeconds--;
                const m = Math.floor(totalSeconds / 60);
                const s = totalSeconds % 60;
                mainCountdownEl.textContent = `${m}:${s < 10 ? '0' : ''}${s}`;

                if (totalSeconds <= 60) {
                    mainCountdownEl.classList.add('urgent');
                }

                if (totalSeconds <= 0) {
                    clearInterval(mainTimer);
                    mainCountdownEl.textContent = 'Expired';
                    verifyBtn.disabled = true;
                    verifyBtn.innerHTML = '<i class="fas fa-circle-xmark"></i> OTP Expired';
                    verifyBtn.style.opacity = '0.45';
                }
            }, 1000);

            // =========================================================
            // Resend cooldown (60 seconds)
            // =========================================================
            const resendBtn  = document.getElementById('resendBtn');
            const resendCountdownEl = document.getElementById('resendCountdown');
            const resendText = document.getElementById('resendText');
            let resendSeconds = 60;

            const resendTimer = setInterval(() => {
                resendSeconds--;
                resendCountdownEl.textContent = resendSeconds;

                if (resendSeconds <= 0) {
                    clearInterval(resendTimer);
                    resendBtn.disabled = false;
                    resendText.innerHTML = '<i class="fas fa-rotate-right" style="margin-right:0.4rem;"></i> Resend OTP Code';
                }
            }, 1000);

            // =========================================================
            // Resend form submission state
            // =========================================================
            document.getElementById('resendForm').addEventListener('submit', function () {
                resendBtn.disabled = true;
                resendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending…';
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\khale\Desktop\MCMC_S02_Astrolabe\myApp\resources\views/home/adminOTPVerifyPage.blade.php ENDPATH**/ ?>