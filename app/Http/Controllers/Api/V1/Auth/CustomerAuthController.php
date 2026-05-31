<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendOtpRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Models\Customer;
use App\Models\Otp;

class CustomerAuthController extends Controller
{
    public function sendOtp(SendOtpRequest $request)
    {
        $otp = random_int(100000, 999999);

        Otp::create([
            'mobile' => $request->mobile,
            'otp_code' => $otp,
            'purpose' => $request->purpose,
            'otp_expires_at' => now()->addMinutes(5),
            'is_verified' => false,
        ]);

        return response()->json([
            'message' => 'OTP sent successfully',
            'otp' => $otp,
        ]);
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $otpRecord = Otp::where('mobile', $request->mobile)
            ->where('otp_code', $request->otp)
            ->where('is_verified', false)
            ->latest()
            ->first();

        if (! $otpRecord) {
            return response()->json(['message' => 'Invalid OTP'], 422);
        }

        if ($otpRecord->otp_expires_at < now()) {
            return response()->json(['message' => 'OTP expired'], 422);
        }

        if ($otpRecord->is_verified == true) {
            return response()->json(['message' => 'Invalid OTP'], 422);
        }

        $otpRecord->is_verified = true;
        $otpRecord->save();

        $customer = Customer::firstOrCreate(
            [
                'mobile' => $request->mobile,
            ],
            [
                'first_name' => '',
                'last_name' => '',
            ]
        );

        $token = $customer
            ->createToken(
                'customer-token',
                ['customer']
            )
            ->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'customer' => $customer,
        ]);
    }
}
