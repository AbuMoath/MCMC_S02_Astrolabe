<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\Module1\UserController as Module1UserController;
use App\Http\Controllers\Module1\AdminController as Module1AdminController;
use App\Http\Controllers\Module1\AgencyController as Module1AgencyController;
use App\Http\Controllers\Module3\PublicUser\UserController as Module3UserController;
use App\Http\Controllers\Module3\PublicUser\InquiryController as Module3InquiryController;
use App\Http\Controllers\Module3\Admin\AdminController as Module3AdminController;
use App\Http\Controllers\Module3\Agency\AgencyController as Module3AgencyController;
use App\Http\Controllers\Module3\Agency\AgencyReviewAndNotificationController as Module3AgencyReviewController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Module4\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AgencyReviewAndNotificationController;

// Home page
Route::get('/', function () {
    return view('home.home');
})->name('home');

// Registration
Route::get('register', [Module1UserController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [Module1UserController::class, 'register']);

// Login
Route::get('login', [Module1UserController::class, 'showLoginForm'])->name('login');
Route::post('login', [Module1UserController::class, 'login']);

// Logout
Route::post('logout', [Module1UserController::class, 'logout'])->name('logout');

// Admin 2FA OTP Routes
Route::get('/admin/otp-verify', [Module3AdminController::class, 'showOtpForm'])->name('admin.otp.show');
Route::post('/admin/otp-verify', [Module3AdminController::class, 'verifyOTP'])->name('admin.otp.verify');
Route::post('/admin/otp-resend', [Module3AdminController::class, 'resendOTP'])->name('admin.otp.resend');

// Password recovery routes
Route::get('/password/recovery', [Module1UserController::class, 'showRecoveryForm'])->name('password.recovery');
Route::post('/password/email', [Module1UserController::class, 'sendResetLink'])->name('password.email');
Route::post('/password/reset', [Module1UserController::class, 'resetPassword'])->name('password.reset');
Route::get('/password/recovery/cancel', [Module1UserController::class, 'cancelPasswordReset'])->name('password.recovery.cancel');


// Manage Profile (protected)
Route::get('/manage-profile', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return view('Module3.PublicUser.manageProfilePage');
})->name('manage.profile');

// Public User Home (protected)
Route::get('/public-user-home', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return view('Module3.PublicUser.publicUserHome');
})->name('public.user.home');

Route::put('/profile/update', [Module3UserController::class, 'updateProfile'])->name('profile.update');

Route::post('/profile/password/verify', [Module1UserController::class, 'verifyPassword'])->name('password.verify');
Route::put('/profile/password/update', [Module1UserController::class, 'updatePassword'])->name('password.update');
Route::get('/profile/password/edit', [Module1UserController::class, 'showEditPassword'])->name('password.edit');

Route::get('/password/edit/reset', function () {
    session()->forget('password_verified');
    return redirect()->route('password.edit');
})->name('password.edit.reset');

Route::get('/profile', [Module3UserController::class, 'showProfile'])->name('profile.show');

Route::get('/profile/manage', function () {
    return view('Module3.PublicUser.manageProfilePage');
})->name('profile.manage');
// Submit Inquiry page
Route::get('/submit-inquiry', function () {
    return view('Module3.PublicUser.submitInquiryForm');
})->middleware('auth')->name('submit.inquiry');

Route::post('/inquiries', [Module3InquiryController::class, 'store'])
    ->middleware(['web', 'auth'])
    ->name('inquiries.store');

// Inquiry list and details routes
Route::get('/inquiries', [Module3InquiryController::class, 'index'])
    ->middleware(['web', 'auth'])
    ->name('inquiries.index');

Route::get('/inquiries/{id}', [Module3InquiryController::class, 'show'])
    ->middleware(['web', 'auth'])
    ->name('inquiries.show');

// Notifications route
Route::get('/notifications', [InquiryController::class, 'notifications'])
    ->middleware('web')
    ->name('notifications');

// Test route for login validation
Route::get('/test/login', function () {
    return view('shared publicUser page.test_loginPage');
})->name('test.login');

// Debug route for notifications
Route::get('/test-notifications-debug', function () {
    $debug = [
        'auth_check' => Auth::check(),
        'user_id' => Auth::id(),
        'user_model' => Auth::user() ? get_class(Auth::user()) : null,
        'guard' => Auth::getDefaultDriver(),
        'route_exists' => Route::has('notifications'),
        'notifications_url' => route('notifications'),
        'session_data' => [
            'session_id' => session()->getId(),
            'csrf_token' => csrf_token(),
        ]
    ];

    if (Auth::check()) {
        $debug['user_name'] = Auth::user()->UserName ?? 'Unknown';
        $debug['user_table'] = Auth::user()->getTable() ?? 'Unknown';
    }

    return response()->json($debug, 200, [], JSON_PRETTY_PRINT);
})->name('test.notifications.debug');

// Admin routes - protected by admin.auth middleware
Route::middleware('admin.auth')->prefix('admin')->group(function () {
    // Admin: home dashboard
    Route::get('/home', [Module1AdminController::class, 'showHome'])->name('admin.home');

    // Admin: show all public users and agencies with search functionality
    Route::get('/users', [Module1AdminController::class, 'showUsers'])->name('admin.users');
    Route::get('/users/{id}', [Module1AdminController::class, 'viewUser'])->name('admin.user.view');
    Route::get('/users/{id}/edit', [Module1AdminController::class, 'editUser'])->name('admin.user.edit');
    Route::put('/users/{id}', [Module1AdminController::class, 'updateUser'])->name('admin.user.update');

    // Admin: agency management
    Route::get('/agencies/{id}', [Module1AdminController::class, 'viewAgency'])->name('admin.agency.view');
    Route::get('/agencies/{id}/edit', [Module1AdminController::class, 'editAgency'])->name('admin.agency.edit');
    Route::put('/agencies/{id}', [Module1AdminController::class, 'updateAgency'])->name('admin.agency.update');
    Route::get('/agency/register', [Module1AdminController::class, 'showAgencyRegistrationForm'])->name('admin.agency.register');
    Route::post('/agency/store', [Module1AdminController::class, 'storeAgency'])->name('admin.agency.store');

    // Admin: inquiry management
    Route::get('/inquiries', [Module3AdminController::class, 'showInquiries'])->name('admin.inquiries');
    Route::get('/inquiries/{id}', [Module3AdminController::class, 'showInquiryDetails'])->name('admin.inquiry.details');
    Route::put('/inquiries/{id}/status', [Module3AdminController::class, 'updateInquiryStatus'])->name('admin.inquiry.update.status');

    // Admin: reassignment requests
    Route::get('/inquiry/{id}/reassignment-request', [Module1AdminController::class, 'getReassignmentRequest'])->name('admin.inquiry.reassignment.request');
    Route::get('/agencies/list', [Module1AdminController::class, 'getAgenciesList'])->name('admin.agencies.list');
    Route::post('/reassignment-request/{id}/process', [Module1AdminController::class, 'processReassignmentRequest'])->name('admin.reassignment.process');

    // Admin: assign inquiry management
    Route::get('/assign-inquiry', [Module3AdminController::class, 'showAssignInquiry'])->name('admin.assign.inquiry');
    Route::post('/assign-inquiry', [Module3AdminController::class, 'assignInquiries'])->name('admin.assign.inquiries');
    Route::post('/assign-inquiry-with-notes', [Module3AdminController::class, 'assignInquiriesWithNotes'])->name('admin.assign.inquiries.with.notes');

    // Admin: generate reports (existing)
    Route::get('/reports', [Module1AdminController::class, 'showReports'])->name('admin.reports');
    Route::post('/reports', [Module1AdminController::class, 'generateReports'])->name('admin.reports.generate');
});

// Agency routes
Route::get('/agency/home', [Module3AgencyController::class, 'showHome'])->name('agency.home');
Route::get('/agency/profile', [Module3AgencyController::class, 'showProfile'])->name('agency.profile');

// Agency profile updates
Route::put('/agency/profile', [Module3AgencyController::class, 'updateProfile'])->name('agency.profile.update');

// Agency security and password routes
Route::get('/agency/security', [Module3AgencyController::class, 'showSecurity'])->name('agency.security');

Route::post('/agency/password/verify', [Module3AgencyController::class, 'verifyPassword'])->name('agency.password.verify');

Route::put('/agency/password/update', [Module3AgencyController::class, 'updatePassword'])->name('agency.password.update');

Route::get('/agency/password/edit/reset', [Module3AgencyController::class, 'resetPasswordVerification'])->name('agency.password.edit.reset');

// Agency phone verification route
Route::post('/agency/phone/update', [Module3UserController::class, 'updateAgencyPhoneAndPassword'])->name('agency.phone.update');

// Agency assigned inquiries route
Route::get('/agency/assigned-inquiries', [Module3AgencyController::class, 'showAssignedInquiries'])->name('agency.assigned.inquiries');

// Agency reassignment request routes
Route::post('/agency/inquiry/request-reassignment', [Module1AgencyController::class, 'submitReassignmentRequest'])->name('agency.inquiry.request.reassignment');
Route::get('/agency/inquiry/{id}/reassignment-status', [Module1AgencyController::class, 'checkReassignmentRequest'])->name('agency.inquiry.reassignment.status');

// Agency view and display inquiry main page
Route::get('/agency/view-display-inquiry', [Module3AgencyReviewController::class, 'showViewAndDisplayInquiry'])->name('agency.view.display.inquiry');

// Agency inquiry details route
Route::get('/agency/inquiry/{id}', [Module3AgencyReviewController::class, 'showInquiryDetails'])->name('agency.inquiry.details');

// Agency inquiry reject route
Route::post('/agency/inquiry/{id}/reject', [AgencyReviewAndNotificationController::class, 'rejectInquiry'])->name('agency.inquiry.reject');

// Agency inquiry status update route
Route::post('/agency/inquiry/{id}/update-status', [AgencyReviewAndNotificationController::class, 'updateInquiryStatus'])->name('agency.inquiry.update.status');

// Agency add notes route
Route::post('/agency/inquiry/{id}/add-notes', [AgencyReviewAndNotificationController::class, 'addInquiryNotes'])->name('agency.inquiry.add.notes');

// Module 4: Notification System Routes

// Public User Notification Routes
Route::middleware(['auth'])->group(function () {
    // Public user notifications (receive only)
    Route::get('/public/notifications', [NotificationController::class, 'publicNotifications'])->name('public.notifications');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread.count');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark.read');

    // Status history for inquiries
    Route::get('/inquiry/{inquiryId}/status-history', [NotificationController::class, 'getStatusHistory'])->name('inquiry.status.history');
});

// Admin Notification Routes
Route::prefix('admin')->middleware('admin.auth')->group(function () {
    // Admin notifications dashboard
    Route::get('/notifications', [NotificationController::class, 'adminNotifications'])->name('admin.notifications');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('admin.notifications.unread.count');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.mark.read');
});

// Agency Communication Routes (API-style for AJAX calls)
Route::prefix('agency')->middleware(['auth'])->group(function () {
    // Agency updates inquiry status and notifies public user
    Route::post('/inquiry/update-status', [NotificationController::class, 'sendStatusUpdateToPublic'])->name('agency.inquiry.notify.status');

    // Agency notifies admin of inquiry completion
    Route::post('/inquiry/notify-completed', [NotificationController::class, 'notifyInquiryCompleted'])->name('agency.inquiry.notify.completed');

    // Agency requests reassignment
    Route::post('/inquiry/request-reassignment', [NotificationController::class, 'requestReassignment'])->name('agency.inquiry.notify.reassignment');

    // Agency requests clarification from admin
    Route::post('/inquiry/request-clarification', [NotificationController::class, 'requestClarification'])->name('agency.inquiry.request.clarification');
});

// Additional API Routes for real-time features
Route::prefix('api')->middleware(['auth'])->group(function () {
    // Get status history for an inquiry
    Route::get('/inquiry/{inquiryId}/status-history', [NotificationController::class, 'getStatusHistory'])->name('api.inquiry.status.history');

    // Get unread notification count for current user
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('api.notifications.unread.count');
});

// Investigation Notes Routes
Route::middleware(['auth'])->group(function () {
    // Admin routes for viewing investigation notes
    Route::prefix('admin')->group(function () {
        Route::get('/inquiry/{inquiryId}/investigation-notes', [App\Http\Controllers\InvestigationNoteController::class, 'show'])->name('admin.investigation.notes.show');
    });

    // Agency routes for managing investigation notes
    Route::prefix('agency')->group(function () {
        Route::get('/inquiry/{inquiryId}/investigation-notes', [App\Http\Controllers\InvestigationNoteController::class, 'agencyView'])->name('agency.investigation.notes.index');
        Route::get('/inquiry/{inquiryId}/investigation-notes/create', [App\Http\Controllers\InvestigationNoteController::class, 'create'])->name('agency.investigation.notes.create');
        Route::post('/inquiry/{inquiryId}/investigation-notes', [App\Http\Controllers\InvestigationNoteController::class, 'store'])->name('agency.investigation.notes.store');
    });

    // Common routes for file downloads
    Route::get('/investigation-attachment/{attachmentId}/download', [App\Http\Controllers\InvestigationNoteController::class, 'downloadAttachment'])->name('investigation.attachment.download');
});
