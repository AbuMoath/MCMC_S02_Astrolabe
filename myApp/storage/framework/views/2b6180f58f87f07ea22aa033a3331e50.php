<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Submit Inquiry - AuthenticityHub</title>
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

        /* User info in top bar - top right */
        .user-info-topbar {
            display: flex;
            flex-direction: row-reverse;
            align-items: center;
            position: absolute;
            right: 2rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .user-info-topbar .user-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #b9c8f6;
            margin-bottom: 0;
            margin-left: 0.7rem;
            background: #f3f4f6;
        }

        .user-info-topbar .user-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info-topbar .user-name {
            font-size: 1rem;
            color: #283d63;
            font-weight: 600;
            text-align: right;
            max-width: 120px;
            word-break: break-all;
        }

        /* Standardized Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 14rem;
            height: calc(100vh - 56px);
            background: #d2dbf6;
            box-shadow: 0 4px 15px rgba(40, 61, 99, 0.1);
            border-top-right-radius: 1.5rem;
            border-bottom-right-radius: 1.5rem;
            padding: 2rem 0;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            z-index: 99;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 0 1.5rem;
            flex: 1;
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
            background: transparent;
        }

        .sidebar-link:hover {
            background: #b9c8f6;
            color: #0057ff;
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background: #b9c8f6;
            color: #0057ff;
            font-weight: 600;
        }

        .sidebar-link.logout-button {
            margin-top: auto;
            color: #e74c3c;
        }

        .sidebar-link.logout-button:hover {
            background: #f8d7da;
            color: #c82333;
        }

        .sidebar-link i {
            width: 1.25rem;
            height: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-content {
            margin-left: 14rem;
            margin-top: 56px;
            padding: 2rem;
            min-height: calc(100vh - 56px);
            background: transparent;
        }

        .form-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 4xl;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: #283d63;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
            font-size: 1.125rem;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            color: #374151;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #0057ff;
            box-shadow: 0 0 0 3px rgba(0, 87, 255, 0.1);
        }

        .btn-primary {
            background: #283d63;
            color: white;
            border-radius: 0.5rem;
            padding: 0.75rem 2rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
            font-weight: 600;
            font-size: 1.125rem;
        }

        .btn-primary:hover {
            background: #1e2f54;
        }

        .btn-primary:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }

        .file-upload-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.2s;
            font-weight: 500;
            color: #283d63;
        }

        .file-upload-label:hover {
            background: #e5e7eb;
        }

        .error-message {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #dc2626;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .required {
            color: #dc2626;
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub</div>

        <?php echo $__env->make('partials.user_area', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="<?php echo e(route('public.user.home')); ?>" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>

            <a href="<?php echo e(route('inquiries.index')); ?>" class="sidebar-link">
                <i class="fas fa-clipboard-list"></i>
                <span>Inquiry List</span>
            </a>

            <a href="<?php echo e(route('submit.inquiry')); ?>" class="sidebar-link active">
                <i class="fas fa-edit"></i>
                <span>Submit Inquiry</span>
            </a>

            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('manage.profile')); ?>" class="sidebar-link">
                    <i class="fas fa-user"></i>
                    <span>Manage Profile</span>
                </a>

                <div style="flex:1"></div>
                <a href="<?php echo e(route('logout')); ?>" class="sidebar-link logout-button"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="hidden">
                    <?php echo csrf_field(); ?>
                </form>
            <?php else: ?>
                <div style="flex:1"></div>
                <a href="<?php echo e(route('login')); ?>" class="sidebar-link">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Sign In</span>
                </a>
            <?php endif; ?>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="form-container">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Submit New Inquiry</h1>

            <!-- Error Messages -->
            <?php if(session('error')): ?>
                <div class="error-message">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="error-message">
                    <ul class="list-disc pl-5">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('inquiries.store')); ?>" enctype="multipart/form-data"
                id="inquiry-form">
                <?php echo csrf_field(); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <div class="form-group">
                            <label class="form-label" for="title">
                                Inquiry Title <span class="required">*</span>
                            </label>
                            <input id="title" name="InquiryTitle" type="text" placeholder="Enter inquiry title"
                                class="form-input" required value="<?php echo e(old('InquiryTitle')); ?>" />
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="source">
                                News Source <span class="required">*</span>
                            </label>
                            <input id="source" name="InquirySource" type="text" placeholder="Enter news source"
                                class="form-input" required value="<?php echo e(old('InquirySource')); ?>" />
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="description">
                                Description <span class="required">*</span>
                            </label>
                            <textarea id="description" name="InquiryDescription" placeholder="Describe your inquiry" rows="5"
                                class="form-textarea" required><?php echo e(old('InquiryDescription')); ?></textarea>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <div class="form-group">
                            <label class="form-label" for="links">
                                Supporting Links
                            </label>
                            <input id="links" name="VerificationDescription" type="text"
                                placeholder="Enter supporting links" class="form-input"
                                value="<?php echo e(old('VerificationDescription')); ?>" />
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Supporting Documents <span class="required">*</span>
                            </label>
                            <label for="documents" class="file-upload-label">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span id="file-label">Choose File</span>
                            </label>
                            <input id="documents" name="InquiryEvidence" type="file" class="hidden" required
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" />
                            <div class="text-sm text-gray-500 mt-2">
                                Accepted formats: PDF, DOC, DOCX, JPG, PNG
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 text-right">
                    <div class="text-sm text-gray-500 mb-4">
                        <span class="required">*</span> Required fields
                    </div>
                    <button type="submit" class="btn-primary" id="submit-btn">
                        Submit Inquiry
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('inquiry-form');
            const submitBtn = document.getElementById('submit-btn');
            const fileInput = document.getElementById('documents');
            const fileLabel = document.getElementById('file-label');

            // File upload handler
            fileInput.addEventListener('change', function(e) {
                if (fileInput.files.length > 0) {
                    fileLabel.textContent = fileInput.files[0].name;
                } else {
                    fileLabel.textContent = 'Choose File';
                }
            });

            // Form submission handler
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                // Reset previous error styling
                requiredFields.forEach(field => {
                    field.style.borderColor = '';
                });

                // Validate required fields
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.style.borderColor = '#dc2626';
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                    return false;
                }

                // Show loading state
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Submitting...
                `;
                submitBtn.disabled = true;
            });
        });
    </script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\SPM\MCMC_S02_Astrolabe\myApp\resources\views/Module3/PublicUser/submitInquiryForm.blade.php ENDPATH**/ ?>