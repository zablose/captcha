<?php

declare(strict_types=1);

namespace Zablose\Captcha\Exception;

use Exception;
use Zablose\Captcha\Config;

class LengthIsOutOfRangeException extends Exception
{
    protected $message = 'Length is out of range! Min "'.Config::LENGTH_MIN.'" and max "be rational".';
}
