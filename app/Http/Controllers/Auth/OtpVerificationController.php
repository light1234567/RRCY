<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\SendLoginOtp;
use App\Models\User;

class OtpVerificationController extends Controller
{
    public function showVerifyForm()
    {
        // Render the OTP verification form using Inertia and Vue component
        return inertia('Auth/VerifyOtp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);
    
        // Retrieve the OTP creation time from the session
        $otpCreatedAt = Session::get('login_otp_created_at');
        $currentTime = now()->setTimezone('Asia/Manila');  // Ensure current time is in the correct timezone
    
        // Ensure the OTP creation time is in the correct timezone and format
        if ($otpCreatedAt) {
            $otpCreatedAt = \DateTime::createFromFormat('Y-m-d H:i:s', $otpCreatedAt, new \DateTimeZone('Asia/Manila'));
        }
    
        // Calculate the difference in seconds between now and the OTP creation time
        $timeDifferenceInSeconds = $currentTime->getTimestamp() - $otpCreatedAt->getTimestamp();
        $timeDifferenceInMinutes = $timeDifferenceInSeconds / 60;
    
        // Debugging output
        \Log::info("OTP created at: " . $otpCreatedAt->format('Y-m-d H:i:s'));
        \Log::info("Current time: " . $currentTime->format('Y-m-d H:i:s'));
        \Log::info("Time difference in minutes: " . $timeDifferenceInMinutes);
    
        // Check if the OTP has expired
        if (!$otpCreatedAt || $timeDifferenceInMinutes > 1) {
            \Log::warning("OTP expired. Time difference: " . $timeDifferenceInMinutes);
            return back()->withErrors(['otp' => 'The OTP has expired. Please request a new one.']);
        }
    
        // Check if the provided OTP matches the one stored in the session
        if ($request->otp == Session::get('login_otp')) {
            Auth::loginUsingId(Session::get('login_user_id'));
    
            // Clear the session data after successful login
            Session::forget('login_otp');
            Session::forget('login_otp_created_at');
            Session::forget('login_user_id');
    
            \Log::info("OTP verified successfully. User logged in.");
            return redirect()->intended('/dashboard');
        }
    
        // If OTP is wrong, return an error
        \Log::warning("Invalid OTP entered.");
        return back()->withErrors(['otp' => 'Invalid OTP.']);
    }
    

    
    public function resendOtp(Request $request)
    {
        $userId = Session::get('login_user_id');
        $user = User::find($userId);

        if ($user) {
            // Generate a new OTP and set new expiration time
            $otp = rand(100000, 999999);
            $otpCreatedAt = now()->setTimezone('Asia/Manila');  // Store the time with the correct timezone

            // Update the OTP and creation time in the session
            Session::put('login_otp', $otp);
            Session::put('login_otp_created_at', $otpCreatedAt);

            // Send the OTP via email
            Mail::to($user->email)->send(new SendLoginOtp($otp));

            return response()->json(['message' => 'OTP resent successfully!']);
        }

        return response()->json(['message' => 'User not found.'], 404);
    }
}
