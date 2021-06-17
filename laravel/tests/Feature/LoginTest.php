<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Session;
use Tests\FeatureTestCase;
use Zablose\Captcha\Captcha;

class LoginTest extends FeatureTestCase
{
    /** @test */
    public function login_with_captcha()
    {
        $user = $this->createUser();

        $captcha = new Captcha();

        Session::put(
            'captcha',
            [
                'sensitive' => $captcha->isSensitive(),
                'hash' => $captcha->hash(),
            ]
        );

        $this
            ->post(
                '/login',
                [
                    'email' => $user->email,
                    'password' => 'password',
                    'captcha' => $captcha->getCode(),
                ]
            )
            ->assertRedirect();

        $this->get('/home')->assertOk();
    }

    /** @test */
    public function fail_without_captcha()
    {
        $user = $this->createUser();

        $this
            ->post(
                '/login',
                [
                    'email' => $user->email,
                    'password' => 'password',
                ]
            )
            ->assertRedirect();

        $this
            ->get('/home')
            ->assertRedirect();
    }

    /** @test */
    public function fail_without_captcha_in_session()
    {
        $user = $this->createUser();

        $this
            ->post(
                '/login',
                [
                    'email' => $user->email,
                    'password' => 'password',
                    'captcha' => 'captcha',
                ]
            )
            ->assertRedirect();

        $this
            ->get('/home')
            ->assertRedirect();
    }

    /** @test */
    public function fail_if_captcha_is_wrong()
    {
        $user = $this->createUser();

        $captcha = new Captcha();

        Session::put(
            'captcha',
            [
                'sensitive' => $captcha->isSensitive(),
                'hash' => $captcha->hash(),
            ]
        );

        $this
            ->post(
                '/login',
                [
                    'email' => $user->email,
                    'password' => 'password',
                    'captcha' => $captcha->getCode().'xyz',
                ]
            )
            ->assertRedirect();

        $this
            ->get('/home')
            ->assertRedirect();
    }
}
