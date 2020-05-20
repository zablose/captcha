<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Tests\FeatureTestCase;
use Zablose\Captcha\Captcha;

class LoginTest extends FeatureTestCase
{
    public function user_can_login()
    {
        $captcha = new Captcha();

        Session::put('captcha', [
            'sensitive' => $captcha->isSensitive(),
            'hash'      => $captcha->hash(),
        ]);

        $this
            ->post('/login', [
                'email'    => 'zablose@gmail.com',
                'password' => 'qwerty',
                'captcha'  => $captcha->getCode(),
            ])
            ->assertStatus(Response::HTTP_FOUND);
    }
}
