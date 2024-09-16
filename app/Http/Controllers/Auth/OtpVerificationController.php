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
    public function showVerifyForm()
    {
        return inertia('Auth/VerifyOtp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);
    
        $otpCreatedAt = Session::get('login_otp_created_at');
        $currentTime = now()->setTimezone('Asia/Manila');  
    
        if ($otpCreatedAt) {
            $otpCreatedAt = \DateTime::createFromFormat('Y-m-d H:i:s', $otpCreatedAt, new \DateTimeZone('Asia/Manila'));
        } else {
            Log::error('OTP creation time not found in session', ['session_data' => Session::all()]);
            return response()->json(['message' => 'OTP creation time not found'], 400);
        }
    
        $timeDifferenceInSeconds = $currentTime->getTimestamp() - $otpCreatedAt->getTimestamp();
        $timeDifferenceInMinutes = $timeDifferenceInSeconds / 60;
    
        if ($request->otp != Session::get('login_otp')) {
            Log::warning('Invalid OTP entered', [
                'user_id' => Session::get('login_user_id'),
                'entered_otp' => $request->otp,
                'session_data' => Session::all()
            ]);
            return response()->json(['message' => 'Invalid OTP'], 400);
        }
    
        if ($timeDifferenceInMinutes > 5) {  // Changed from 1 to 5
            Log::warning('OTP expired', [
                'user_id' => Session::get('login_user_id'),
                'time_difference' => $timeDifferenceInMinutes,
                'session_data' => Session::all()
            ]);
            return response()->json(['message' => 'OTP expired'], 400);
        }
    
        // Retrieve the user and log them in
        $userId = Session::get('login_user_id');
        $user = User::find($userId);
    
        if ($user) {
            Auth::login($user);
    
            // Save user details in the session
            Session::put('user_id', $user->id);
            Session::put('user_fname', $user->fname);
            Session::put('user_lname', $user->lname);
            Session::put('user_middlename', $user->middlename);
            Session::put('user_email', $user->email);
            Session::put('user_role', $user->role);
    
            // Log the saved session data
            Log::info('User logged in successfully and session data saved', [
                'user_id' => $user->id,
                'user_fname' => $user->fname,
                'user_lname' => $user->lname,
                'user_middlename' => $user->middlename,
                'user_email' => $user->email,
                'user_role' => $user->role,
                'session_data' => Session::all()
            ]);
    
            // Clear OTP session data
            Session::forget('login_otp');
            Session::forget('login_otp_created_at');
            Session::forget('login_user_id');
    
            return response()->json(['message' => 'OTP verified successfully'], 200);
        }
    
        Log::error('User not found', ['session_data' => Session::all()]);
        return response()->json(['message' => 'User not found'], 400);
    }
}
