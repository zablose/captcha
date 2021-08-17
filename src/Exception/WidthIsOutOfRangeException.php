<?php

declare(strict_types=1);

namespace Zablose\Captcha\Exception;

use Exception;
use Zablose\Captcha\Config;

class WidthIsOutOfRangeException extends Exception
{
    protected $message = 'Width is out of range! Min "'.Config::WIDTH_MIN.'" and max "be rational".';
}
