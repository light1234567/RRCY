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
            return response()->json(['message' => 'OTP creation time not found'], 400);
        }
    
        $timeDifferenceInSeconds = $currentTime->getTimestamp() - $otpCreatedAt->getTimestamp();
        $timeDifferenceInMinutes = $timeDifferenceInSeconds / 60;
    
        if ($request->otp != Session::get('login_otp')) {
            Log::warning('Invalid OTP entered', ['user_id' => Session::get('login_user_id'), 'entered_otp' => $request->otp]);
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        if ($timeDifferenceInMinutes > 5) {  // Changed from 1 to 5
            Log::warning('OTP expired', ['user_id' => Session::get('login_user_id'), 'time_difference' => $timeDifferenceInMinutes]);
            return response()->json(['message' => 'OTP expired'], 400);
        }

        Auth::loginUsingId(Session::get('login_user_id'));

        Session::forget('login_otp');
        Session::forget('login_otp_created_at');
        Session::forget('login_user_id');

        return response()->json(['message' => 'OTP verified successfully'], 200);
    }
    
    public function resendOtp(Request $request)
    {
        $userId = Session::get('login_user_id');
        $user = User::find($userId);

        if ($user) {
            $otp = rand(100000, 999999);
            $otpCreatedAt = now()->setTimezone('Asia/Manila');

            Session::put('login_otp', $otp);
            Session::put('login_otp_created_at', $otpCreatedAt);

            Mail::to($user->email)->send(new SendLoginOtp($otp));
            Log::info('OTP resent', ['user_id' => $userId, 'otp' => $otp]);

            return response()->json(['message' => 'OTP resent successfully'], 200);
        }

        return response()->json(['message' => 'User not found'], 400);
    }
}
