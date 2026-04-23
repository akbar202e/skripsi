<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use App\Services\OtpService;

class OtpServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_generate_otp_creates_and_stores_otp()
    {
        $email = 'test@example.com';
        $otp = OtpService::generateOtp($email);

        $this->assertEquals(6, strlen($otp));
        $this->assertEquals($otp, Cache::get("otp_{$email}"));
    }

    public function test_verify_otp_returns_true_for_correct_otp()
    {
        $email = 'test@example.com';
        $otp = '123456';
        Cache::put("otp_{$email}", $otp, now()->addMinutes(10));

        $result = OtpService::verifyOtp($email, $otp);

        $this->assertTrue($result);
        $this->assertNull(Cache::get("otp_{$email}")); // Should be removed after verification
    }

    public function test_verify_otp_returns_false_for_incorrect_otp()
    {
        $email = 'test@example.com';
        $correctOtp = '123456';
        Cache::put("otp_{$email}", $correctOtp, now()->addMinutes(10));

        $result = OtpService::verifyOtp($email, '654321');

        $this->assertFalse($result);
        $this->assertEquals($correctOtp, Cache::get("otp_{$email}")); // Should not be removed
    }
}
