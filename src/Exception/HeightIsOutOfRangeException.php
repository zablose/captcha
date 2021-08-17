<?php

declare(strict_types=1);

namespace Zablose\Captcha\Exception;

use Exception;
use Zablose\Captcha\Config;

class HeightIsOutOfRangeException extends Exception
{
    protected $message = 'Height is out of range! Min "'.Config::HEIGHT_MIN.'" and max "be rational".';
}
