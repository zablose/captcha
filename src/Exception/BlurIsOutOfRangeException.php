<?php

declare(strict_types=1);

namespace Zablose\Captcha\Exception;

use Exception;
use Zablose\Captcha\Config;

class BlurIsOutOfRangeException extends Exception
{
    protected $message = 'Blur is out of range! No change "'.Config::BLUR_NO_CHANGE.'" and max "'.Config::BLUR_MAX.'".';
}
