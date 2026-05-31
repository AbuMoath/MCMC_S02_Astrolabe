<?php

namespace App\Http\Controllers\Module3\PublicUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use App\Models\Module3\PublicUsers as PublicUser;
use App\Models\Module3\Agency;
use App\Models\Module3\Administrator as Admin;
use App\Http\Controllers\Module3\Admin\AdminController;
use App\Http\Controllers\Module3\Agency\AgencyController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    /**
     * Show registration form
     */
    public function showRegistrationForm(): View
    {
        return view('Module3.PublicUser.registerPage');
    }

    /**
     * Show login form
     */
    public function showLoginForm(): View
    {
        return view('home.loginPage');
    }

    /**
     * Register a new user (general)
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'UserName' => 'required|string|max:50',
            'UserEmail' => 'required|email|unique:public_users,UserEmail',
            'UserPassword' => 'required|min:8|confirmed',
        ]);

        PublicUser::create([
            'UserName' => $request->UserName,
            'UserEmail' => $request->UserEmail,
            'UserPassword' => Hash::make($request->UserPassword),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    /**
     * Handle login
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'login' => 'required|string',
                'password' => 'required',
            ],
            [
                'login.required' => 'Email or Username field is required.',
            ]
        );

        $loginInput = $request->input('login');
        $password = $request->input('password');

        // Try admin login first
        $adminController = new AdminController();
        $adminResult = $adminController->attemptLogin($loginInput, $password);
        if ($adminResult !== false) {
            return $adminResult;
        }

        // Try agency login with proper password handling
        $isEmail = filter_var($loginInput, FILTER_VALIDATE_EMAIL);
        $agency = null;

        if ($isEmail) {
            $agency = Agency::where('AgencyEmail', $loginInput)->first();
        } else {
            $agency = Agency::where('AgencyUserName', $loginInput)->first();
        }

        if ($agency) {
            // Check if password matches using the agency's checkPassword method
            $passwordMatch = $agency->checkPassword($password);

            if ($passwordMatch) {
                // Check if agency has phone number
                if (empty($agency->AgencyPhoneNum) || is_null($agency->AgencyPhoneNum)) {
                    // Store agency ID in session for phone verification
                    session(['phone_verification_agency_id' => $agency->AgencyID]);

                    return redirect()->route('password.recovery')
                        ->with('phone_required', 'Please add your phone number and reset your password to complete account setup.');
                }

                // Store agency data in session
                session(['agency_id' => $agency->AgencyID, 'agency_name' => $agency->AgencyName]);
                // Mark login as successful to clear form on return
                session()->flash('login_successful', true);
                return redirect()->route('agency.home');
            }
        }

        // Finally, try public user login
        $column = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'UserEmail' : 'UserName';
        $user = PublicUser::where($column, $loginInput)->first();

        if (!$user) {
            return Redirect::back()
                ->withErrors(['login' => 'No account found with this email or username.']);
        }

        if (!Hash::check($request->input('password'), $user->UserPassword)) {
            return Redirect::back()
                ->withErrors(['password' => 'The password is incorrect.']);
        }

        Auth::login($user);

        // Store the current page in session for potential back button functionality
        Session::put('previous_url', URL::previous());
        // Mark login as successful to clear form on return
        session()->flash('login_successful', true);

        return redirect()->route('public.user.home');
    }

    /**
     * Logout user
     */
    public function logout(Request $request): RedirectResponse
    {
        // Clear all session data
        session()->flush();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Show public user home
     */
    public function showHome(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('Module3.PublicUser.publicUserHome');
    }    /**
     * Show user profile
     */
    public function showProfile(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        return view('Module3.PublicUser.manageProfilePage', compact('user'));
    }

    /**
     * Show manage profile page
     */
    public function showManageProfile(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('Module3.PublicUser.manageProfilePage');
    }

    /**
     * Show edit password page
     */
    public function showEditPassword(): View|RedirectResponse
    {
        return view('Module3.PublicUser.editPasswordPage');
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $validated = $request->validate([
            'UserName' => 'required|string|max:50',
            'UserEmail' => 'required|email|max:50|unique:public_users,UserEmail,' . $user->UserID . ',UserID',
            'UserPhoneNum' => 'nullable|string|max:15',
        ]);

        // Handle profile picture upload
        if ($request->hasFile('UserProfilePicture')) {
            // Delete old profile picture if it exists
            if ($user->UserProfilePicture) {
                Storage::delete('public/' . $user->UserProfilePicture);
            }

            $path = $request->file('UserProfilePicture')->store('profile_pictures', 'public');
            $validated['UserProfilePicture'] = $path;
        }

        $user->update($validated);

        return redirect()->route('manage.profile')
            ->with('status', 'Profile updated successfully!');
    }

    /**
     * Verify current password for password change
     */
    public function verifyPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->UserPassword)) {
            return Redirect::back()
                ->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Store verification in session
        session(['password_verified' => true]);

        return redirect()->route('password.edit')
            ->with('status', 'Password verified. You can now set a new password.');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        if (!session('password_verified')) {
            return redirect()->route('manage.profile')
                ->with('error', 'Please verify your current password first.');
        }

        $request->validate([
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $user->UserPassword = Hash::make($request->new_password);
        $user->save();

        // Clear password verification session
        session()->forget('password_verified');

        return redirect()->route('manage.profile')
            ->with('status', 'Password updated successfully!');
    }

    /**
     * Cancel password reset
     */
    public function cancelPasswordReset(): RedirectResponse
    {
        session()->forget('password_verified');
        return redirect()->route('manage.profile');
    }

    /**
     * Show recovery form
     */
    public function showRecoveryForm(): View
    {
        return view('home.recovaryPasswordPage');
    }

    /**
     * Send reset link
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        // Add your password reset logic here
        return redirect()->back()->with('status', 'Password reset link sent!');
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        // Add your password reset logic here
        return redirect()->route('login')->with('status', 'Password reset successfully!');
    }

    /**
     * Update agency phone and password (for phone verification flow)
     */
    public function updateAgencyPhoneAndPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'AgencyPhoneNum' => 'required|string|max:15',
            'AgencyPassword' => 'required|string|min:6|confirmed',
        ]);

        $agencyId = session('phone_verification_agency_id');
        if (!$agencyId) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        $agency = Agency::find($agencyId);
        if (!$agency) {
            return redirect()->route('login')->with('error', 'Agency not found.');
        }

        // Update phone number and password
        $agency->AgencyPhoneNum = $request->AgencyPhoneNum;
        $agency->AgencyPassword = Hash::make($request->AgencyPassword);
        $agency->save();

        // Clear the verification session
        session()->forget('phone_verification_agency_id');

        // Log the agency in
        session(['agency_id' => $agency->AgencyID, 'agency_name' => $agency->AgencyName]);

        return redirect()->route('agency.home')->with('success', 'Account setup completed successfully!');
    }
}
