<?php

declare(strict_types=1);

namespace Zablose\Captcha\Exception;

use Exception;
use Zablose\Captcha\Config;

class SharpnessIsOutOfRangeException extends Exception
{
    protected $message = 'Sharpness is out of range! '
    .'No change "'.Config::SHARPNESS_NO_CHANGE.'" and max "'.Config::SHARPNESS_MAX.'".';
}
