<?php

namespace App\Services;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class CaptchaService
{

    public function createCapcha()
    {
        $captcha_pattern = new PhraseBuilder(5, '0123456789');
        $captcha = new CaptchaBuilder(null, $captcha_pattern);
        $captcha->setBackgroundColor('0', '0', '0');
        $captcha->setTextColor('255', '255', '0');
        $captcha->build();
        return $captcha;
    }
    public function checkCaptcha(int $captcha)
    {
        $sessionCaptcha = Session::get('captcha');

        if (!$sessionCaptcha || now()->greaterThan($sessionCaptcha['time'])) {
            return back()->withErrors(['captcha' => trans('captcha_has_expired.')])->withInput();
        }
        if (!Hash::check($captcha, $sessionCaptcha['value'])) {
            return back()->withErrors(['captcha' => trans('the_captcha_is_wrong.')])->withInput();
        }
        Session::forget('captcha');
        return true;
    }
}
