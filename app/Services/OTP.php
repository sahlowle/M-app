<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Otp as Model;

class OTP
{
    

    /**
     * @param string $identifier
     * @param int $digits
     * @param int $validity
     * @return mixed
     */
    public static function generate(string $identifier, int $digits = 4, int $validity = 10) 
    {
        Model::where('identifier', $identifier)->where('valid', true)->delete();

        $otp = str_pad(self::generatePin($digits), $digits, '0', STR_PAD_LEFT);

        $otp = 1111;

        Model::create([
            'identifier' => $identifier,
            'token' => $otp,
            'validity' => $validity
        ]);

        return $otp;
    }

    /**
     * @param string $identifier
     * @param string $token
     * @return mixed
     */
    public static function validate(string $identifier, string $token) : object
    {
        $otp = Model::where('identifier', $identifier)
        ->where('token', $token)
        ->where('valid', true)
        ->first();

        if (is_null($otp)) {
            return (object)[
                'success' => false,
                'message' => 'OTP does not exist'
            ];
        }
        
        if ($otp->valid == true) {
            $carbon = new Carbon;
            $now = $carbon->now();
            $validity = $otp->created_at->addMinutes($otp->validity);
            
            if (strtotime($validity) < strtotime($now)) {
                $otp->valid = false;
                $otp->save();
                
                return (object)[
                    'success' => false,
                    'message' => 'OTP Expired'
                ];
            } else {
                $otp->valid = false;
                $otp->save();
                
                return (object)[
                    'success' => true,
                    'message' => 'OTP is valid'
                ];
            }
        }
        else {
            return (object)[
                'success' => false,
                'message' => 'OTP is not valid'
            ];
        }
        
    }

    /**
     * @param int $digits
     * @return string
     */
    private static function generatePin($digits = 4)
    {
        $i = 0;
        $pin = "";

        while ($i < $digits) {
            $pin .= mt_rand(0, 9);
            $i++;
        }

        return $pin;
    }
}
