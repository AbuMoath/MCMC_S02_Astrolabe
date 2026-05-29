<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OTP Verification - AuthenticityHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a7fd0, #6bc5f3);
            margin: 0;
            padding: 0;
        }

        /* Smooth transitions for all elements */
        * {
            transition: all 0.4s ease-in-out;
        }

        /* Top Bar Styling */
        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            background: #d2dbf6;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 2rem;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.07);
        }

        .top-bar .logo {
            font-weight: 700;
            font-size: 1.3rem;
            color: #283d63;
            letter-spacing: 0.02em;
            margin-right: 2rem;
            margin-left: 0;
            position: absolute;
            left: 2rem;
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 14rem;
            height: calc(100vh - 56px);
            background: #d2dbf6;
            border-top-right-radius: 1.5rem;
            border-bottom-right-radius: 1.5rem;
            box-shadow: 0 4px 15px rgba(40, 61, 99, 0.1);
            padding: 1.5rem 0;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            z-index: 99;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding: 0 1rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #283d63;
            text-decoration: none;
            font-weight: 500;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .sidebar-link i {
            font-size: 1.1rem;
            width: 1.25rem;
            text-align: center;
        }

        .sidebar-link:hover {
            background: #b9c8f6;
            color: #0057ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 87, 255, 0.2);
        }

        /* Main Content Area */
        .main-content {
            margin-left: 14rem;
            margin-top: 56px;
            padding: 2rem;
            min-height: calc(100vh - 56px);
            background: transparent;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: #eef2ff;
            padding: 2.5rem 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            max-width: 480px;
            width: 100%;
            box-sizing: border-box;
            backdrop-filter: blur(10px);
        }

        .card:hover {
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
        }

        /* Shield Icon */
        .shield-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #4f8cff, #0057ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 8px 24px rgba(0, 87, 255, 0.3);
        }

        .shield-icon i {
            color: #fff;
            font-size: 2rem;
        }

        /* OTP Input Styling */
        .otp-input-wrapper {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 1.5rem 0;
        }

        .otp-digit {
            width: 52px;
            height: 60px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: #283d63;
            background: linear-gradient(145deg, #e6ebfc, #c5cee9);
            box-shadow: inset 4px 4px 6px rgba(59, 130, 246, 0.2), inset -4px -4px 6px rgba(255, 255, 255, 0.7);
            border: 2px solid transparent;
            border-radius: 12px;
            outline: none;
            transition: all 0.3s ease;
        }

        .otp-digit:focus {
            border-color: #0057ff;
            box-shadow: inset 4px 4px 6px rgba(59, 130, 246, 0.4), inset -4px -4px 6px rgba(255, 255, 255, 0.8),
                0 0 12px rgba(0, 87, 255, 0.4);
            background: linear-gradient(145deg, #c5cee9, #e6ebfc);
            transform: scale(1.08);
        }

        .otp-digit.is-invalid {
            border: 2px solid #dc3545 !important;
            box-shadow: 0 0 12px 3px rgba(220, 53, 69, 0.25) !important;
        }

        /* Hidden real input for form submission */
        .otp-hidden-input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 0.5rem;
            margin-bottom: 1rem;
            display: block;
            text-align: center;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-info {
            background: #e0f2fe;
            color: #0c4a6e;
        }

        .btn-smooth {
            background: linear-gradient(145deg, #4f8cff, #0057ff);
            color: #ffffff;
            font-weight: 600;
            border-radius: 0.75rem;
            border: none;
            padding: 0.85rem 1.5rem;
            font-size: 1.125rem;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(79, 140, 255, 0.3);
            margin-top: 0.5rem;
        }

        .btn-smooth:hover {
            background: linear-gradient(145deg, #0057ff, #003bbd);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 140, 255, 0.4);
        }

        .btn-smooth:active {
            transform: translateY(0px);
        }

        .btn-secondary {
            background: transparent;
            color: #506a9f;
            font-weight: 600;
            border-radius: 0.75rem;
            border: 2px solid #b9c8f6;
            padding: 0.7rem 1.5rem;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 0.75rem;
        }

        .btn-secondary:hover {
            background: #b9c8f6;
            color: #283d63;
            transform: translateY(-2px);
        }

        .timer-text {
            text-align: center;
            color: #506a9f;
            font-size: 0.9rem;
            margin-top: 1rem;
        }

        .timer-text span {
            font-weight: 700;
            color: #0057ff;
        }

        .email-hint {
            text-align: center;
            color: #506a9f;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            word-break: break-all;
        }

        .email-hint strong {
            color: #283d63;
        }

        /* Animation Keyframes */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        body {
            opacity: 0;
            animation: fadeIn 0.8s ease-in-out forwards;
        }

        .card {
            opacity: 0;
            animation: slideInUp 0.8s ease-out forwards 0.3s;
        }

        .error-message {
            animation: shake 0.5s ease-in-out;
        }

        .shield-icon {
            animation: pulse 2s ease-in-out infinite;
        }

        /* Responsive Design */
        @media (max-width: 900px) {
            .sidebar { width: 60px; }
            .sidebar a span { display: none; }
            .main-content { margin-left: 60px; }
        }

        @media (max-width: 768px) {
            .main-content { padding: 1rem; margin-left: 60px; }
            .card { margin: 1rem; padding: 2rem 1.5rem; }
            .otp-digit { width: 44px; height: 52px; font-size: 1.3rem; }
        }

        @media (max-width: 480px) {
            .main-content { margin-left: 0; padding: 0.5rem; }
            .sidebar { display: none; }
            .card { margin: 0.5rem; padding: 1.5rem 1rem; max-width: 100%; }
            .otp-digit { width: 38px; height: 46px; font-size: 1.1rem; gap: 6px; }
            .otp-input-wrapper { gap: 6px; }
        }
    </style>
</head>

<body>
    
    <header class="top-bar">
        <div class="logo">AuthenticityHub</div>
    </header>

    
    <aside class="sidebar">
        <div class="sidebar-nav">
            <a href="<?php echo e(route('home')); ?>" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="<?php echo e(route('login')); ?>" class="sidebar-link">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Login</span>
            </a>
        </div>
    </aside>

    
    <div class="main-content">
        <div class="card">
            
            <div class="shield-icon">
                <i class="fas fa-shield-alt"></i>
            </div>

            <h2 style="font-size: 1.6rem; text-align: center; color: #283d63; margin-bottom: 0.5rem;">
                <b>2-Factor Verification</b>
            </h2>
            <p style="text-align: center; color: #506a9f; font-size: 0.95rem; margin-bottom: 0.3rem;">
                Enter the 6-digit OTP code sent to your registered email
            </p>

            
            <?php if(session('admin_email')): ?>
                <p class="email-hint">
                    Sent to: <strong><?php echo e(session('admin_email')); ?></strong>
                </p>
            <?php endif; ?>

            
            <?php if(session('error')): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i><?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('info')): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i><?php echo e(session('info')); ?>

                </div>
            <?php endif; ?>

            
            <form method="POST" action="<?php echo e(route('admin.otp.verify')); ?>" id="otpForm" novalidate>
                <?php echo csrf_field(); ?>

                
                <input type="hidden" name="otp_code" id="otpHiddenInput" value="" />

                
                <div class="otp-input-wrapper">
                    <input type="text" maxlength="1" class="otp-digit <?php $__errorArgs = ['otp_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           data-index="0" inputmode="numeric" pattern="[0-9]" autocomplete="one-time-code" autofocus />
                    <input type="text" maxlength="1" class="otp-digit <?php $__errorArgs = ['otp_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           data-index="1" inputmode="numeric" pattern="[0-9]" />
                    <input type="text" maxlength="1" class="otp-digit <?php $__errorArgs = ['otp_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           data-index="2" inputmode="numeric" pattern="[0-9]" />
                    <input type="text" maxlength="1" class="otp-digit <?php $__errorArgs = ['otp_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           data-index="3" inputmode="numeric" pattern="[0-9]" />
                    <input type="text" maxlength="1" class="otp-digit <?php $__errorArgs = ['otp_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           data-index="4" inputmode="numeric" pattern="[0-9]" />
                    <input type="text" maxlength="1" class="otp-digit <?php $__errorArgs = ['otp_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           data-index="5" inputmode="numeric" pattern="[0-9]" />
                </div>

                <?php $__errorArgs = ['otp_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error-message"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                
                <button type="submit" class="btn-smooth" id="verifyBtn">
                    <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>Verify OTP
                </button>
            </form>

            
            <form method="POST" action="<?php echo e(route('admin.otp.resend')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-secondary" id="resendBtn">
                    <i class="fas fa-redo" style="margin-right: 0.5rem;"></i>Resend OTP Code
                </button>
            </form>

            
            <div class="timer-text">
                Code expires in: <span id="countdown">5:00</span>
            </div>

            
            <div style="text-align:center; margin-top:1.2rem;">
                <a href="<?php echo e(route('login')); ?>" style="color:#506a9f; font-weight:500; text-decoration:none; font-size:0.9rem;">
                    <i class="fas fa-arrow-left" style="margin-right: 0.3rem;"></i>Back to Login
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const digits = document.querySelectorAll('.otp-digit');
            const hiddenInput = document.getElementById('otpHiddenInput');
            const form = document.getElementById('otpForm');
            const verifyBtn = document.getElementById('verifyBtn');

            // Sync all digit inputs into hidden field
            function syncHiddenInput() {
                let otp = '';
                digits.forEach(d => otp += d.value);
                hiddenInput.value = otp;
            }

            // Handle input for each digit
            digits.forEach((digit, idx) => {
                digit.addEventListener('input', function (e) {
                    // Allow only numeric
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value && idx < digits.length - 1) {
                        digits[idx + 1].focus();
                    }
                    syncHiddenInput();
                });

                // Handle backspace navigation
                digit.addEventListener('keydown', function (e) {
                    if (e.key === 'Backspace' && !this.value && idx > 0) {
                        digits[idx - 1].focus();
                        digits[idx - 1].value = '';
                        syncHiddenInput();
                    }
                    // Handle Enter to submit
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        syncHiddenInput();
                        if (hiddenInput.value.length === 6) {
                            form.submit();
                        }
                    }
                });

                // Handle paste (e.g., paste full OTP from clipboard)
                digit.addEventListener('paste', function (e) {
                    e.preventDefault();
                    const pasteData = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
                    if (pasteData.length >= 6) {
                        for (let i = 0; i < 6; i++) {
                            digits[i].value = pasteData[i] || '';
                        }
                        digits[5].focus();
                        syncHiddenInput();
                    }
                });
            });

            // Form submit handler
            form.addEventListener('submit', function (e) {
                syncHiddenInput();
                if (hiddenInput.value.length !== 6) {
                    e.preventDefault();
                    digits.forEach(d => d.classList.add('is-invalid'));
                    return;
                }
                verifyBtn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:0.5rem;"></i>Verifying...';
                verifyBtn.style.pointerEvents = 'none';
            });

            // Countdown timer (5 minutes)
            let timeLeft = 300; // 5 minutes in seconds
            const countdownEl = document.getElementById('countdown');

            const timer = setInterval(function () {
                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                countdownEl.textContent = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

                if (timeLeft <= 60) {
                    countdownEl.style.color = '#dc3545';
                    countdownEl.style.fontWeight = '700';
                }

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    countdownEl.textContent = 'Expired';
                    countdownEl.style.color = '#dc3545';
                    verifyBtn.disabled = true;
                    verifyBtn.style.opacity = '0.5';
                    verifyBtn.style.pointerEvents = 'none';
                    verifyBtn.innerHTML = '<i class="fas fa-times-circle" style="margin-right:0.5rem;"></i>OTP Expired';
                }
            }, 1000);
        });
    </script>
</body>

</html>
<?php /**PATH C:\Users\khale\Desktop\MCMC_S02_Astrolabe\myApp\resources\views/home/adminOTPVerifyPage.blade.php ENDPATH**/ ?>