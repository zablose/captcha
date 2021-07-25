<?php

declare(strict_types=1);

namespace Zablose\Captcha\Exception;

use Exception;
use Zablose\Captcha\Config;

class SharpenIsOutOfRangeException extends Exception
{
    protected $message = 'Sharpen is out of range! '
    .'Min (no change) '.Config::SHARPEN_NO_CHANGE.' and max '.Config::SHARPEN_MAX.').';
}
