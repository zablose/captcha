<?php

declare(strict_types=1);

namespace Zablose\Captcha\Tests\Laravel\Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Zablose\Captcha\Tests\Laravel\Tests\FeatureTestCase;

class RoutesTest extends FeatureTestCase
{
    #[Test]
    public function index()
    {
        $this->get('/')->assertOk()->assertSee('Welcome');
    }

    #[Test]
    public function home()
    {
        $this->get('/home')->assertRedirect('/login');
    }

    #[Test]
    public function home_with_authorized_user()
    {
        $this->actingAs($this->createUser());

        $this->get('/home')->assertOk()
            ->assertSee('Home')
            ->assertSee('You are logged in!');
    }

    #[Test]
    public function login()
    {
        $this->get('/login')->assertOk()
            ->assertSee('E-Mail Address')
            ->assertSee('Password')
            ->assertSee('Captcha');
    }

    #[Test]
    public function register()
    {
        $this->get('/register')->assertOk()
            ->assertSee('Name')
            ->assertSee('E-Mail Address')
            ->assertSee('Password')
            ->assertSee('Confirm Password');
    }

    #[Test]
    public function logout()
    {
        $this->post('/logout')->assertRedirect('/');
    }

    #[Test]
    public function captcha()
    {
        $types = [
            'default',
            'small',
            'invert',
            'sharpness',
            'blur',
            'contrast',
            'no-angle',
            'bg-color',
        ];

        foreach ($types as $type) {
            $this->assertPng(
                $this->get('/captcha/'.$type)->assertOk()->getContent(),
                config("captcha.$type.width") ?? config('captcha.default.width'),
                config("captcha.$type.height") ?? config('captcha.default.height')
            );
        }
    }
}
