<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\SendLoginOtp;
use App\Models\User;

class OtpVerificationController extends Controller
{
    // Show the OTP verification form
    public function showVerifyForm()
    {
        return inertia('Auth/VerifyOtp');
    }

    // Verify the OTP
    public function verifyOtp(Request $request)
    {
        // Validate the OTP field
        $request->validate(['otp' => 'required']);

        // Get OTP creation time from session
        $otpCreatedAt = Session::get('login_otp_created_at');
        $currentTime = now()->setTimezone('Asia/Manila');

        // If OTP creation time is missing (session expired or not set), log out and show an error
        if (!$otpCreatedAt) {
            Log::error('OTP creation time not found', ['session_data' => Session::all()]);
            Auth::logout(); // Log the user out
            return response()->json(['message' => 'OTP creation time not found'], 400);
        }

        // Parse OTP creation time to DateTime object
        $otpCreatedAt = \DateTime::createFromFormat('Y-m-d H:i:s', $otpCreatedAt, new \DateTimeZone('Asia/Manila'));
        $timeDifferenceInMinutes = ($currentTime->getTimestamp() - $otpCreatedAt->getTimestamp()) / 60;

        // Check if entered OTP matches the one in session
        if ($request->otp != Session::get('login_otp')) {
            Log::warning('Invalid OTP entered', [
                'user_id' => Session::get('login_user_id'),
                'entered_otp' => $request->otp,
                'session_data' => Session::all(),
            ]);
            Auth::logout(); // Log the user out
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        // Check if OTP has expired (greater than 5 minutes)
        if ($timeDifferenceInMinutes > 5) {
            Log::warning('OTP expired', [
                'user_id' => Session::get('login_user_id'),
                'time_difference' => $timeDifferenceInMinutes,
                'session_data' => Session::all(),
            ]);
            Auth::logout(); // Log the user out
            return response()->json(['message' => 'OTP expired'], 400);
        }

        // Find the user by ID from session
        $user = User::find(Session::get('login_user_id'));
        if ($user) {
            // Log in the user
            Auth::login($user);

            // Save user data to session
            Session::put([
                'user_id' => $user->id,
                'user_fname' => $user->fname,
                'user_lname' => $user->lname,
                'user_middlename' => $user->middlename,
                'user_email' => $user->email,
                'user_role' => $user->role,
            ]);

            // Clear OTP session data
            Session::forget(['login_otp', 'login_otp_created_at', 'login_user_id']);

            return response()->json(['message' => 'OTP verified successfully'], 200);
        }

        // If the user was not found, log out and return an error
        Log::error('User not found during OTP verification', ['session_data' => Session::all()]);
        Auth::logout(); // Log the user out
        return response()->json(['message' => 'User not found'], 400);
    }

    // Login and send OTP
    public function loginWithOtp(Request $request)
    {
        // Validate email and password fields
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Get email and password from request
        $credentials = $request->only('email', 'password');

        // Attempt to log in with the provided credentials
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if the user is unverified
            if ($user->status === 'u') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is not verified. Please contact your head for verification.',
                ])->onlyInput('email');
            }

            // Generate and send OTP
            $this->createAndSendOtp($user);

            // Log out temporarily and redirect to OTP verification form
            Auth::logout();
            return redirect()->route('verify.otp');
        }

        // If login attempt failed, show an error
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }

    // Function to generate and send OTP
    private function createAndSendOtp($user)
    {
        $otp = rand(100000, 999999);

        // Store OTP and user details in session
        Session::put([
            'login_otp' => $otp,
            'login_otp_created_at' => now(),
            'login_user_id' => $user->id,
        ]);

        try {
            // Attempt to send OTP via email
            Mail::to($user->email)->send(new SendLoginOtp($otp));
            Log::info('OTP sent to user', ['user_id' => $user->id, 'email' => $user->email, 'otp' => $otp]);
        } catch (\Exception $e) {
            // Handle the failure of the OTP email sending
            Log::error('Failed to send OTP', [
                'user_id' => $user->id,
                'email' => $user->email,
                'otp' => $otp,
                'error_message' => $e->getMessage()
            ]);

            // If email sending fails, return an error
            return back()->withErrors([
                'email' => 'Unable to send OTP due to network issues. Please try again later.',
            ]);
        }
    }

    // Function to resend OTP
    public function resendOtp()
    {
        // Get the user ID from session
        $userId = Session::get('login_user_id');
        $user = User::find($userId);

        // If user exists, resend the OTP
        if ($user) {
            $this->createAndSendOtp($user);
            return response()->json(['message' => 'OTP resent successfully'], 200);
        }

        // If the user was not found, return an error
        return response()->json(['message' => 'User not found'], 400);
    }
}
