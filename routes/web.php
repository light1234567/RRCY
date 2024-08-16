<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Mail\SendLoginOtp;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Group for authenticated routes
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/cicl', function () {
        return Inertia::render('CICL');
    })->name('cicl');

    Route::get('/new', function () {
        return Inertia::render('NewClient');
    })->name('new')->middleware(\App\Http\Middleware\CheckAdminRole::class);
    
    // Route for the main edit page with an id parameter
    Route::get('/maintab/{id}', function ($id) {
        return Inertia::render('MainTab', ['id' => $id]);
    })->name('maintab');
});

// OTP Verification Routes
Route::get('/verify-otp', [OtpVerificationController::class, 'showVerifyForm'])->name('verify.otp');
Route::post('/verify-otp', [OtpVerificationController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/resend-otp', [OtpVerificationController::class, 'resendOtp'])->name('resend.otp');

// Modified login route to trigger OTP sending and redirection
Route::post('/login', function (Request $request) {
    // Validate the request
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Attempt to authenticate the user
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Check if the user's status is 'unverified'
        if ($user->status === 'unverified') {
            // Log out the user
            Auth::logout();

            // Redirect back with an error message
            return back()->withErrors([
                'email' => 'Your account is not verified. Please wait or contact your head for verification of your account.',
            ])->onlyInput('email');
        }

        // Generate a random OTP
        $otp = rand(100000, 999999);
        $otpCreatedAt = now(); // Get the current time

        // Store OTP, creation time, and user ID in session
        Session::put('login_otp', $otp);
        Session::put('login_otp_created_at', $otpCreatedAt);
        Session::put('login_user_id', $user->id);

        // Send OTP via email
        Mail::to($user->email)->send(new SendLoginOtp($otp));

        // Log out the user temporarily
        Auth::logout();

        // Redirect to OTP verification form
        return redirect()->route('verify.otp');
    }

    // If authentication fails, redirect back with error
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
})->middleware(['guest'])->name('login');

// Registration Routes
use App\Http\Controllers\RegisterController;
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
