<?php

declare(strict_types=1);

namespace Zablose\Captcha\Exception;

use Exception;
use Zablose\Captcha\Config;

class LinesIsOutOfRangeException extends Exception
{
    protected $message = 'Lines count is out of range! '
    .'No lines "'.Config::LINES_NONE.'" and max "be rational".';
}
