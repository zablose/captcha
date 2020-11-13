<?php declare(strict_types=1);

namespace Tests\Feature;

use Tests\FeatureTestCase;

class RoutesTest extends FeatureTestCase
{
    /** @test */
    public function index()
    {
        $this->get('/')->assertOk()->assertSee('Welcome');
    }

    /** @test */
    public function home()
    {
        $this->get('/home')->assertRedirect('/login');
    }

    /** @test */
    public function home_with_authorized_user()
    {
        $this->actingAs($this->createUser());

        $this->get('/home')->assertOk()
            ->assertSee('Home')
            ->assertSee('You are logged in!');
    }

    /** @test */
    public function login()
    {
        $this->get('/login')->assertOk()
            ->assertSee('E-Mail Address')
            ->assertSee('Password')
            ->assertSee('Captcha');
    }

    /** @test */
    public function register()
    {
        $this->get('/register')->assertOk()
            ->assertSee('Name')
            ->assertSee('E-Mail Address')
            ->assertSee('Password')
            ->assertSee('Confirm Password');
    }

    /** @test */
    public function logout()
    {
        $this->post('/logout')->assertRedirect('/');
    }
}
