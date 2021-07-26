<?php

declare(strict_types=1);

namespace Zablose\Captcha\Exception;

use Exception;
use Zablose\Captcha\Config;

class AngleIsOutOfRangeException extends Exception
{
    protected $message = 'Angle is out of range! '
    .'No rotation '.Config::ANGLE_NO_ROTATION.' and max '.Config::ANGLE_MAX.').';
}
