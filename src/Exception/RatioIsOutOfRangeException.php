<?php

declare(strict_types=1);

namespace Zablose\Captcha\Exception;

use Exception;
use Zablose\Captcha\Config;

class RatioIsOutOfRangeException extends Exception
{
    protected $message = 'Ratio "Height/(Width/Length)" is out of range!'
    .' Min "be rational" and max "'.(Config::HEIGHT_MIN / Config::WIDTH_MIN).'".';
}
