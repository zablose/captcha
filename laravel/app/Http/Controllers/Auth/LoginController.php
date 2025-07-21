<?php

declare(strict_types=1);

namespace Zablose\Captcha\Tests\Laravel\App\Http\Controllers\Auth;

use Zablose\Captcha\Tests\Laravel\App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected string $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate(
            [
                $this->username() => 'required|string',
                'password' => 'required|string',
                'captcha' => 'required|string|captcha',
            ]
        );
    }
}
