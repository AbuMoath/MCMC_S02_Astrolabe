<?php

/*
 * Test file to debug notifications route
 * Run this by visiting: /test-notifications-debug
 */

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InquiryController;

Route::get('/test-notifications-debug', function () {
    $debug = [
        'auth_check' => Auth::check(),
        'user_id' => Auth::id(),
        'user_model' => Auth::user() ? get_class(Auth::user()) : null,
        'guard' => Auth::getDefaultDriver(),
        'route_exists' => Route::has('notifications'),
        'notifications_url' => route('notifications'),
    ];
    
    if (Auth::check()) {
        $debug['user_name'] = Auth::user()->UserName ?? 'Unknown';
    }
    
    return response()->json($debug, 200, [], JSON_PRETTY_PRINT);
})->name('test.notifications.debug');
