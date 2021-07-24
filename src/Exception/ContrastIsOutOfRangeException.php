<?php

declare(strict_types=1);

namespace Zablose\Captcha\Exception;

use Exception;
use Zablose\Captcha\Config;

class ContrastIsOutOfRangeException extends Exception
{
    protected $message = 'Contrast level is out of range! '
    .'(Max '.Config::CONTRAST_LEVEL_MAX.' and min '.Config::CONTRAST_LEVEL_MIN.').';
}
