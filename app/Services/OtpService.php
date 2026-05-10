<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpVerification;

class OtpService
{
    public static function generateOtp(string $email): string
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        Cache::put("otp_{$email}", $otp, now()->addMinutes(10)); // Expire in 10 minutes
        return $otp;
    }

    public static function sendOtp(string $email, string $otp): void
    {
        Mail::to($email)->send(new OtpVerification($otp));
    }

    public static function verifyOtp(string $email, string $otp): bool
    {
        $cachedOtp = Cache::get("otp_{$email}");
        if ($cachedOtp && $cachedOtp === $otp) {
            Cache::forget("otp_{$email}"); // Remove after successful verification
            return true;
        }
        return false;
    }
}