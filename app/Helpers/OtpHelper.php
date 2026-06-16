<?php

namespace App\Helpers;

use App\Models\Otp;
use Carbon\Carbon;

class OtpHelper
{
    /** Generate a numeric OTP of given length */
    public static function generateOtp(int $length = 6): string
    {
        $min = pow(10, $length - 1);
        $max = pow(10, $length) - 1;
        return (string)rand($min, $max);
    }

    /** Create an OTP record for a given phone number */
    public static function createOtpRecord(string $phoneNumber, string $code)
    {
        return Otp::create([
            'phone_number' => $phoneNumber,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);
    }

    /** Convenience method to create OTP for a User model */
    public static function createOtpForUser($user)
    {
        $code = self::generateOtp();
        return self::createOtpRecord($user->phoneNumber, $code);
    }
}
?>
